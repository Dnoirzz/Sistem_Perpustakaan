<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Booking;
use App\Models\Penalty;
use App\Models\Recommendation;
use App\Models\LaporanPkl;
use App\Models\ProposalTa;
use App\Models\LaporanTugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        Loan::syncOverdueStatuses();

        $user = Auth::user();
        $mhs = $user->mahasiswa;

        $stats = [
            'active_loans' => Loan::where('user_id', $user->user_id)->whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'total_bookings' => Booking::where('user_id', $user->user_id)->count(),
            'unpaid_fines' => Penalty::where('user_id', $user->user_id)->where('status', 'belum_dibayar')->sum('amount'),
            'late_loans' => Loan::where('user_id', $user->user_id)->where('status', 'terlambat')->count(),
            'submitted_archives' => 0,
        ];

        if ($mhs) {
            $stats['submitted_archives'] = LaporanPkl::where('mahasiswa_id', $mhs->mhs_id)->count() +
                                         ProposalTa::where('mahasiswa_id', $mhs->mhs_id)->count() +
                                         LaporanTugasAkhir::where('mahasiswa_id', $mhs->mhs_id)->count();
        }

        $currentLoans = Loan::with(['collection.book'])
            ->where('user_id', $user->user_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderBy('tgl_pinjam', 'desc')
            ->take(5)
            ->get();

        // 5 Rekomendasi Koleksi (Buku Umum & Arsip Digital: Populer & Terbaru)
        $popularCollections = Collection::with(['book.category', 'laporanPkl.mahasiswa', 'proposalTa.mahasiswa', 'laporanTa.mahasiswa'])
            ->withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->take(3)
            ->get();

        $popularIds = $popularCollections->pluck('koleksi_id')->toArray();

        $latestCollections = Collection::with(['book.category', 'laporanPkl.mahasiswa', 'proposalTa.mahasiswa', 'laporanTa.mahasiswa'])
            ->whereNotIn('koleksi_id', $popularIds)
            ->orderBy('koleksi_id', 'desc')
            ->take(5 - count($popularIds))
            ->get();

        $recommendedCollections = $popularCollections->concat($latestCollections);

        if ($recommendedCollections->count() < 5) {
            $existingIds = $recommendedCollections->pluck('koleksi_id')->toArray();
            $additional = Collection::with(['book.category', 'laporanPkl.mahasiswa', 'proposalTa.mahasiswa', 'laporanTa.mahasiswa'])
                ->whereNotIn('koleksi_id', $existingIds)
                ->orderBy('koleksi_id', 'asc')
                ->take(5 - count($existingIds))
                ->get();
            $recommendedCollections = $recommendedCollections->concat($additional);
        }

        return view('mahasiswa.dashboard', compact('stats', 'currentLoans', 'recommendedCollections'));
    }
}
