<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Booking;
use App\Models\Penalty;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        Loan::syncOverdueStatuses();

        $user = Auth::user();

        $stats = [
            'active_loans' => Loan::where('user_id', $user->user_id)->whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'total_bookings' => Booking::where('user_id', $user->user_id)->count(),
            'unpaid_fines' => Penalty::where('user_id', $user->user_id)->where('status', 'belum_dibayar')->sum('amount'),
            'late_loans' => Loan::where('user_id', $user->user_id)->where('status', 'terlambat')->count(),
            'total_recommendations' => Recommendation::where('user_id', $user->user_id)->count(),
        ];

        $currentLoans = Loan::with(['collection.book'])
            ->where('user_id', $user->user_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderBy('tgl_pinjam', 'desc')
            ->get();

        return view('dosen.dashboard', compact('stats', 'currentLoans'));
    }
}
