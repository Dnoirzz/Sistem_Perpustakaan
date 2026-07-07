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

        $loans = Loan::with(['collection.book'])
            ->where('user_id', $user->user_id)
            ->where('status', 'kembali')
            ->orderBy('tgl_kembali', 'desc')
            ->paginate(10);

        if ($user->isDosen()) {
            return view('dosen.loans.history', compact('loans'));
        }

        return view('mahasiswa.loans.history', compact('loans'));
    }
}
