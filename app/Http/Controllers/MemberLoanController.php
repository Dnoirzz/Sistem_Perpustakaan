<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberLoanController extends Controller
{
    /**
     * Tampilkan daftar pinjaman aktif milik anggota (Dosen/Mahasiswa).
     */
    public function activeLoans()
    {
        Loan::syncOverdueStatuses();

        $user = Auth::user();

        $loans = Loan::with(['collection.book'])
            ->where('user_id', $user->user_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderBy('tgl_pinjam', 'desc')
            ->paginate(10);

        if ($user->isDosen()) {
            return view('dosen.loans.active', compact('loans'));
        }

        return view('mahasiswa.loans.active', compact('loans'));
    }

    /**
     * Tampilkan daftar riwayat peminjaman milik anggota (Dosen/Mahasiswa).
     */
    public function loanHistory()
    {
        Loan::syncOverdueStatuses();

        $user = Auth::user();

        // 1. Get physical returned loans
        $loans = Loan::with(['collection.book'])
            ->where('user_id', $user->user_id)
            ->where('status', 'kembali')
            ->get()
            ->map(function ($loan) {
                // Calculate lateness
                $isLate = $loan->tgl_kembali && $loan->bts_waktu && $loan->tgl_kembali->greaterThan($loan->bts_waktu);
                $daysLate = 0;
                if ($isLate) {
                    $daysLate = $loan->tgl_kembali->diffInDays($loan->bts_waktu);
                }

                // Check condition
                $isDamaged = $loan->return_condition_status === 'bermasalah';
                $notes = $loan->return_condition_notes;

                // Build description (keterangan)
                $keteranganParts = [];
                if ($isLate) {
                    $keteranganParts[] = "Terlambat dikembalikan ({$daysLate} hari)";
                }
                if ($isDamaged) {
                    $detailKerusakan = $notes ? ": {$notes}" : "";
                    $keteranganParts[] = "Buku rusak{$detailKerusakan}";
                }

                $keterangan = count($keteranganParts) > 0 
                    ? implode(' & ', $keteranganParts) 
                    : '-';

                return [
                    'tipe_riwayat' => 'fisik',
                    'judul' => $loan->collection?->display_title ?? 'Koleksi tidak ditemukan',
                    'penulis' => $loan->collection?->book?->author ?? 'Penulis',
                    'tgl_pinjam' => $loan->tgl_pinjam,
                    'tgl_kembali' => $loan->tgl_kembali,
                    'tanggal_aksi' => $loan->tgl_kembali, // Carbon instance
                    'keterangan' => $keterangan,
                    'status_kondisi' => $loan->return_condition_status,
                    'catatan' => $loan->return_condition_notes,
                ];
            });

        // 2. Get digital read logs
        $readLogs = \App\Models\ArchiveReadLog::with(['archive'])
            ->where('user_id', $user->user_id)
            ->get()
            ->map(function ($log) {
                $archive = $log->archive;
                $title = $archive ? \App\Support\ArsipDigital::title($archive) : 'Arsip tidak ditemukan';
                $author = $archive?->mahasiswa?->user?->name ?? 'Mahasiswa';
                return [
                    'tipe_riwayat' => 'digital',
                    'judul' => $title,
                    'penulis' => 'Oleh: ' . $author,
                    'tgl_pinjam' => $log->created_at,
                    'tgl_kembali' => $log->finished_at,
                    'tanggal_aksi' => $log->created_at, // Carbon instance
                    'keterangan' => '-',
                    'status_kondisi' => null,
                    'catatan' => null,
                ];
            });

        // 3. Combine and sort by date descending
        $history = $loans->concat($readLogs)->sortByDesc(function ($item) {
            return $item['tanggal_aksi'] instanceof \Carbon\Carbon 
                ? $item['tanggal_aksi']->timestamp 
                : (is_string($item['tanggal_aksi']) ? strtotime($item['tanggal_aksi']) : 0);
        })->values();

        // 4. Paginate the collection manually
        $page = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $paginatedHistory = new \Illuminate\Pagination\LengthAwarePaginator(
            $history->forPage($page, $perPage)->values(),
            $history->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        if ($user->isDosen()) {
            return view('dosen.loans.history', ['history' => $paginatedHistory]);
        }

        return view('mahasiswa.loans.history', ['history' => $paginatedHistory]);
    }
}
