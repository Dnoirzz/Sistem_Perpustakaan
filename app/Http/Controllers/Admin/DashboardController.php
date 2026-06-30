<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Petugas;
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

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}
