<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Booking;
use App\Models\Antrian;
use App\Models\Penalty;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        Loan::syncOverdueStatuses();

        $stats = [
            'total_books' => Book::count(),
            'active_loans' => Loan::where('status', 'dipinjam')->count(),
            'overdue_loans' => Loan::where('status', 'terlambat')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'active_penalties' => Penalty::where('status', 'belum_dibayar')->count(),
        ];

        $recentLoans = Loan::with(['user', 'collection.book'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact('stats', 'recentLoans'));
    }
}
