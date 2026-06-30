<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Petugas;
use App\Models\Loan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_mahasiswa' => Mahasiswa::count(),
            'total_dosen' => Dosen::count(),
            'total_petugas' => Petugas::count(),
        ];

        $recentUsers = User::with('role')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 1. Tren Peminjaman Bulanan (Tahun Berjalan)
        $monthlyLoansData = Loan::selectRaw('MONTH(tgl_pinjam) as month, COUNT(*) as count')
            ->whereYear('tgl_pinjam', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyLoans = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        foreach (range(1, 12) as $m) {
            $monthlyLoans[] = $monthlyLoansData[$m] ?? 0;
        }

        // 2. Distribusi Kategori Buku Terpopuler
        $categoryData = Loan::join('collections', 'loans.koleksi_id', '=', 'collections.koleksi_id')
            ->join('books', 'collections.item_id', '=', 'books.buku_id')
            ->join('categories', 'books.kategori_id', '=', 'categories.kategori_id')
            ->where('collections.item_type', 'book')
            ->selectRaw('categories.kategori_name as name, COUNT(*) as count')
            ->groupBy('name')
            ->orderByDesc('count')
            ->take(5)
            ->pluck('count', 'name')
            ->toArray();

        $categoryLabels = array_keys($categoryData);
        $categoryCounts = array_values($categoryData);

        return view('admin.dashboard', compact(
            'stats', 
            'recentUsers', 
            'months', 
            'monthlyLoans', 
            'categoryLabels', 
            'categoryCounts'
        ));
    }
}
