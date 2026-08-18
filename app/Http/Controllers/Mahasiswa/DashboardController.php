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
        $user->load(['mahasiswa.prodi.jurusan']);
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

        // 5 Rekomendasi Koleksi Cerdas Berbasis Prodi Mahasiswa
        $recommendedCollections = $this->getRecommendedCollectionsForUser($user, 5);

        return view('mahasiswa.dashboard', compact('stats', 'currentLoans', 'recommendedCollections'));
    }

    /**
     * Helper untuk mengambil koleksi rekomendasi cerdas berbasis Prodi Pengguna.
     */
    protected function getRecommendedCollectionsForUser($user, $limit = 5)
    {
        $prodiId = $user->mahasiswa?->prodi_id ?? $user->dosen?->prodi_id;
        $prodiName = strtolower($user->mahasiswa?->prodi?->nama_prodi ?? $user->dosen?->prodi?->nama_prodi ?? '');
        $jurusanId = $user->mahasiswa?->prodi?->jurusan_id ?? $user->dosen?->prodi?->jurusan_id;

        // Tentukan kata kunci kategori / judul berdasarkan Prodi
        $keywords = [];
        if (str_contains($prodiName, 'informatika') || str_contains($prodiName, 'teknologi informasi') || str_contains($prodiName, 'komputer')) {
            $keywords = ['informatika', 'komputer', 'teknologi', 'sistem', 'jaringan', 'web', 'data', 'software', 'program', 'algoritma', 'pemrograman', 'database', 'coding', 'ti'];
        } elseif (str_contains($prodiName, 'akuntansi') || str_contains($prodiName, 'keuangan')) {
            $keywords = ['akuntansi', 'keuangan', 'pajak', 'audit', 'ekonomi', 'bisnis', 'manajemen', 'laporan', 'kas', 'bank', 'investasi'];
        } elseif (str_contains($prodiName, 'sipil') || str_contains($prodiName, 'konstruksi')) {
            $keywords = ['sipil', 'konstruksi', 'bangunan', 'struktur', 'beton', 'baja', 'tanah', 'arsitektur', 'jalan', 'jembatan', 'proyek'];
        }

        $recommended = collect();
        $collectedIds = [];

        // 1. Prioritas Utama: Koleksi yang berelasi langsung dengan Prodi pengguna (Arsip prodi, Riwayat pinjam prodi, Kata kunci judul/kategori)
        if ($prodiId || !empty($keywords)) {
            $prodiCollections = Collection::with(['book.category', 'laporanPkl.mahasiswa.prodi', 'proposalTa.mahasiswa.prodi', 'laporanTa.mahasiswa.prodi'])
                ->withCount('loans')
                ->where(function ($query) use ($prodiId, $keywords) {
                    if ($prodiId) {
                        $query->whereHas('laporanPkl.mahasiswa', fn($q) => $q->where('prodi_id', $prodiId))
                              ->orWhereHas('proposalTa.mahasiswa', fn($q) => $q->where('prodi_id', $prodiId))
                              ->orWhereHas('laporanTa.mahasiswa', fn($q) => $q->where('prodi_id', $prodiId));
                    }

                    if ($prodiId) {
                        $query->orWhereHas('loans.user.mahasiswa', fn($q) => $q->where('prodi_id', $prodiId))
                              ->orWhereHas('loans.user.dosen', fn($q) => $q->where('prodi_id', $prodiId));
                    }

                    if (!empty($keywords)) {
                        $query->orWhereHas('book', function ($bq) use ($keywords) {
                            $bq->where(function ($kQ) use ($keywords) {
                                foreach ($keywords as $kw) {
                                    $kQ->orWhere('judul', 'LIKE', "%{$kw}%");
                                }
                            })->orWhereHas('category', function ($cQ) use ($keywords) {
                                $cQ->where(function ($kQ) use ($keywords) {
                                    foreach ($keywords as $kw) {
                                        $kQ->orWhere('kategori_name', 'LIKE', "%{$kw}%");
                                    }
                                });
                            });
                        });
                    }
                })
                ->orderBy('loans_count', 'desc')
                ->orderBy('koleksi_id', 'desc')
                ->take($limit)
                ->get();

            $recommended = $recommended->concat($prodiCollections);
            $collectedIds = $recommended->pluck('koleksi_id')->toArray();
        }

        // 2. Prioritas Kedua: Jurusan yang Sama
        if ($recommended->count() < $limit && $jurusanId) {
            $jurusanCollections = Collection::with(['book.category', 'laporanPkl.mahasiswa.prodi', 'proposalTa.mahasiswa.prodi', 'laporanTa.mahasiswa.prodi'])
                ->withCount('loans')
                ->whereNotIn('koleksi_id', $collectedIds)
                ->where(function ($query) use ($jurusanId) {
                    $query->whereHas('laporanPkl.mahasiswa.prodi', fn($q) => $q->where('jurusan_id', $jurusanId))
                          ->orWhereHas('proposalTa.mahasiswa.prodi', fn($q) => $q->where('jurusan_id', $jurusanId))
                          ->orWhereHas('laporanTa.mahasiswa.prodi', fn($q) => $q->where('jurusan_id', $jurusanId))
                          ->orWhereHas('loans.user.mahasiswa.prodi', fn($q) => $q->where('jurusan_id', $jurusanId));
                })
                ->orderBy('loans_count', 'desc')
                ->orderBy('koleksi_id', 'desc')
                ->take($limit - $recommended->count())
                ->get();

            $recommended = $recommended->concat($jurusanCollections);
            $collectedIds = $recommended->pluck('koleksi_id')->toArray();
        }

        // 3. Fallback Umum: Koleksi Terbaru / Populer Global
        if ($recommended->count() < $limit) {
            $globalCollections = Collection::with(['book.category', 'laporanPkl.mahasiswa.prodi', 'proposalTa.mahasiswa.prodi', 'laporanTa.mahasiswa.prodi'])
                ->withCount('loans')
                ->whereNotIn('koleksi_id', $collectedIds)
                ->orderBy('loans_count', 'desc')
                ->orderBy('koleksi_id', 'desc')
                ->take($limit - $recommended->count())
                ->get();

            $recommended = $recommended->concat($globalCollections);
        }

        return $recommended;
    }
}
