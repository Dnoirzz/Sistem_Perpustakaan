<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Simpan booking baru oleh anggota.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'koleksi_id' => ['required', 'exists:collections,koleksi_id'],
        ], [
            'koleksi_id.required' => 'Koleksi wajib dipilih.',
            'koleksi_id.exists' => 'Koleksi tidak ditemukan.',
        ]);

        $user = Auth::user();
        $koleksiId = $validated['koleksi_id'];

        // Cek apakah pengguna sedang meminjam koleksi ini
        $sedangDipinjam = Loan::where('user_id', $user->user_id)
            ->where('koleksi_id', $koleksiId)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($sedangDipinjam) {
            return back()->with('error', 'Anda sedang meminjam koleksi ini. Silakan kembalikan terlebih dahulu.');
        }

        // Cek apakah sudah punya booking aktif untuk koleksi ini
        $existingBooking = Booking::where('user_id', $user->user_id)
            ->where('koleksi_id', $koleksiId)
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();

        if ($existingBooking) {
            return back()->with('error', 'Anda sudah memiliki booking aktif untuk koleksi ini.');
        }

        Booking::create([
            'user_id' => $user->user_id,
            'koleksi_id' => $koleksiId,
            'tgl_booking' => today(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Booking berhasil dibuat. Tunggu persetujuan petugas.');
    }

    /**
     * Tampilkan daftar booking milik anggota yang login.
     */
    public function myBookings()
    {
        Booking::checkExpiredBookings();

        $user = Auth::user();

        $bookings = Booking::with(['collection.book'])
            ->where('user_id', $user->user_id)
            ->orderByDesc('created_at')
            ->paginate(10);

        if ($user->isDosen()) {
            return view('dosen.bookings.index', compact('bookings'));
        }

        return view('mahasiswa.bookings.index', compact('bookings'));
    }

    /**
     * Batalkan booking milik anggota yang sedang login.
     */
    public function cancel(Request $request, $booking_id)
    {
        $validated = $request->validate([
            'cancel_reason' => ['required', 'string', 'max:1000'],
        ], [
            'cancel_reason.required' => 'Alasan pembatalan booking wajib diisi.',
            'cancel_reason.max' => 'Alasan pembatalan maksimal 1000 karakter.',
        ]);

        Booking::checkExpiredBookings();

        $user = Auth::user();

        $booking = Booking::with(['collection.book'])
            ->where('booking_id', $booking_id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        if (! in_array($booking->status, ['pending', 'disetujui'], true)) {
            return back()->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        $oldStatus = $booking->status;
        $cancelReason = trim($validated['cancel_reason']);

        DB::transaction(function () use ($booking, $oldStatus, $cancelReason) {
            $booking->update([
                'status' => 'dibatalkan',
                'note' => 'Dibatalkan oleh anggota. Alasan: ' . $cancelReason,
                'batas_waktu_ambil' => null,
            ]);

            if ($oldStatus === 'disetujui' && $booking->collection) {
                $booking->collection->syncBackingStock(1);
            }
        });

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
