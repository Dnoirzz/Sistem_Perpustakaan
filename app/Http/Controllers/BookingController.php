<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Antrian;
use App\Models\Collection;
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

        $errorMessage = null;
        $booking = DB::transaction(function () use ($user, $koleksiId, &$errorMessage) {
            // Serialize all booking/loan checks for this collection. The
            // checks must happen after the lock to prevent duplicate bookings.
            Collection::query()
                ->whereKey($koleksiId)
                ->lockForUpdate()
                ->firstOrFail();

            $sedangDipinjam = Loan::where('user_id', $user->user_id)
                ->where('koleksi_id', $koleksiId)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->exists();

            if ($sedangDipinjam) {
                $errorMessage = 'Anda sedang meminjam koleksi ini. Silakan kembalikan terlebih dahulu.';
                return null;
            }

            $existingBooking = Booking::where('user_id', $user->user_id)
                ->where('koleksi_id', $koleksiId)
                ->whereIn('status', ['pending', 'disetujui'])
                ->exists();

            if ($existingBooking) {
                $errorMessage = 'Anda sudah memiliki booking aktif untuk koleksi ini.';
                return null;
            }

            return Booking::create([
                'user_id' => $user->user_id,
                'koleksi_id' => $koleksiId,
                'tgl_booking' => today(),
                'status' => 'pending',
            ])->load('collection.book');
        });

        if (! $booking) {
            return back()->with('error', $errorMessage ?? 'Booking tidak dapat dibuat saat ini.');
        }

        $bookTitle = $booking->collection?->display_title ?? 'buku';
        
        // Notif ke anggota
        \App\Models\NotificationCustom::send(
            $user->user_id,
            'Pengajuan Booking Berhasil',
            "Pengajuan booking untuk koleksi '{$bookTitle}' berhasil dicatat.",
            route('mahasiswa.bookings.my'),
            'booking'
        );

        // Notif ke petugas & admin
        \App\Models\NotificationCustom::sendToRoles(
            ['petugas', 'admin'],
            'Pengajuan Booking Baru',
            "Anggota {$user->name} mengajukan booking untuk koleksi '{$bookTitle}'.",
            route('petugas.bookings.index'),
            'booking'
        );

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

        $cancelReason = trim($validated['cancel_reason']);

        $releasedCollectionId = null;
        $cancelled = DB::transaction(function () use ($booking_id, $user, $cancelReason, &$releasedCollectionId) {
            $booking = Booking::query()
                ->where('booking_id', $booking_id)
                ->where('user_id', $user->user_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($booking->status, ['pending', 'disetujui'], true)) {
                return false;
            }

            $oldStatus = $booking->status;
            $collection = null;
            if ($oldStatus === 'disetujui') {
                $collection = Collection::query()
                    ->whereKey($booking->koleksi_id)
                    ->lockForUpdate()
                    ->first();
            }

            $booking->update([
                'status' => 'dibatalkan',
                'note' => 'Dibatalkan oleh anggota. Alasan: ' . $cancelReason,
                'batas_waktu_ambil' => null,
            ]);

            if ($oldStatus === 'disetujui' && $collection) {
                $collection->syncBackingStock(1);
                $releasedCollectionId = $collection->koleksi_id;
            }

            return true;
        });

        if (! $cancelled) {
            return back()->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        if ($releasedCollectionId) {
            Antrian::checkAndNotifyAvailableQueue($releasedCollectionId);
        }

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
