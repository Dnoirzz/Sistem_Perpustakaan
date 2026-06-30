<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Loan;
use App\Support\ArsipDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Tampilkan daftar semua booking.
     */
    public function index(Request $request)
    {
        Booking::checkExpiredBookings();

        $search = $request->input('search');
        $status = $request->input('status');

        $query = Booking::with([
            'user.role',
            'user.mahasiswa',
            'user.dosen',
            'collection.book',
        ]);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                            $mq->where('nim', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dosen', function ($dq) use ($search) {
                            $dq->where('nip', 'like', "%{$search}%");
                        });
                });

                $matchingCollectionIds = ArsipDigital::matchingCollectionIds($search);
                if ($matchingCollectionIds !== []) {
                    $q->orWhereIn('koleksi_id', $matchingCollectionIds);
                }
            });
        }

        $bookings = $query
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 WHEN status = 'disetujui' THEN 1 ELSE 2 END")
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'pending' => Booking::where('status', 'pending')->count(),
            'approved' => Booking::where('status', 'disetujui')->count(),
            'total' => Booking::count(),
        ];

        return view('petugas.bookings.index', compact('bookings', 'stats', 'search', 'status'));
    }

    /**
     * Setujui booking.
     */
    public function approve(Request $request, $booking_id)
    {
        $booking = Booking::with(['user', 'collection.book'])->findOrFail($booking_id);

        if ($booking->status !== 'pending') {
            return redirect()
                ->route('petugas.bookings.index')
                ->with('error', 'Booking ini sudah diproses sebelumnya.');
        }

        if (! $booking->collection || $booking->collection->stock < 1) {
            return redirect()
                ->route('petugas.bookings.index')
                ->with('error', 'Stok koleksi tidak mencukupi untuk disetujui saat ini.');
        }

        $hour = $request->input('pickup_hour') ?? '13';
        $minute = $request->input('pickup_minute') ?? '00';
        $timeInput = $hour . ':' . $minute;
        $batasWaktu = now()->toDateString() . ' ' . $timeInput . ':00';

        DB::transaction(function () use ($booking, $batasWaktu, $request, $timeInput) {
            $booking->update([
                'status' => 'disetujui',
                'note' => $request->input('note') ?? "Koleksi dapat diambil sebelum pukul {$timeInput} WIB",
                'batas_waktu_ambil' => $batasWaktu,
            ]);

            $booking->collection->syncBackingStock(-1);
        });

        return redirect()
            ->route('petugas.bookings.index')
            ->with('success', "Booking oleh {$booking->user->name} untuk \"{$booking->collection?->display_title}\" telah disetujui.");
    }

    /**
     * Tolak booking.
     */
    public function reject(Request $request, $booking_id)
    {
        $booking = Booking::with(['user', 'collection.book'])->findOrFail($booking_id);

        if (!in_array($booking->status, ['pending', 'disetujui'], true)) {
            return redirect()
                ->route('petugas.bookings.index')
                ->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        $oldStatus = $booking->status;

        DB::transaction(function () use ($booking, $oldStatus, $request) {
            $booking->update([
                'status' => 'dibatalkan',
                'note' => $request->input('note') ?? 'Booking dibatalkan.',
            ]);

            // Jika sebelumnya sudah disetujui, kembalikan stok buku
            if ($oldStatus === 'disetujui' && $booking->collection) {
                $booking->collection->syncBackingStock(1);
            }
        });

        return redirect()
            ->route('petugas.bookings.index')
            ->with('success', "Booking oleh {$booking->user->name} berhasil dibatalkan.");
    }

    /**
     * Realisasikan booking menjadi peminjaman aktif.
     */
    public function realize(Request $request, $booking_id)
    {
        $booking = Booking::with(['user', 'collection.book'])->findOrFail($booking_id);

        if ($booking->status !== 'disetujui') {
            return redirect()
                ->route('petugas.bookings.index')
                ->with('error', 'Hanya booking yang telah disetujui yang dapat direalisasikan menjadi peminjaman.');
        }

        // Cek apakah user sudah punya peminjaman aktif untuk koleksi ini
        $hasActiveLoan = Loan::where('user_id', $booking->user_id)
            ->where('koleksi_id', $booking->koleksi_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($hasActiveLoan) {
            return redirect()
                ->route('petugas.bookings.index')
                ->with('error', 'Anggota ini masih memiliki peminjaman aktif untuk judul buku yang sama.');
        }

        DB::transaction(function () use ($booking) {
            // Buat peminjaman aktif (default bts_waktu 7 hari)
            Loan::create([
                'user_id' => $booking->user_id,
                'koleksi_id' => $booking->koleksi_id,
                'tgl_pinjam' => today()->toDateString(),
                'bts_waktu' => today()->addDays(7)->toDateString(),
                'status' => 'dipinjam',
            ]);

            // Update status booking menjadi selesai
            $booking->update([
                'status' => 'selesai',
                'note' => 'Koleksi telah diambil. Transaksi peminjaman aktif telah dibuat.',
            ]);
        });

        return redirect()
            ->route('petugas.loans.index')
            ->with('success', "Booking oleh {$booking->user->name} berhasil diproses menjadi peminjaman aktif.");
    }
}
