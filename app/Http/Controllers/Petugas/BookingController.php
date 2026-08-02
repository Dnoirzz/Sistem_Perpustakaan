<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Booking;
use App\Models\Collection;
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
        $hour = $request->input('pickup_hour') ?? '13';
        $minute = $request->input('pickup_minute') ?? '00';
        $timeInput = $hour . ':' . $minute;
        $batasWaktu = now()->toDateString() . ' ' . $timeInput . ':00';

        $result = DB::transaction(function () use ($booking_id, $batasWaktu, $request, $timeInput) {
            $booking = Booking::query()
                ->whereKey($booking_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== 'pending') {
                return ['error' => 'Booking ini sudah diproses sebelumnya.'];
            }

            $collection = Collection::query()
                ->whereKey($booking->koleksi_id)
                ->lockForUpdate()
                ->first();

            if (! $collection || $collection->stock < 1) {
                return ['error' => 'Stok koleksi tidak mencukupi untuk disetujui saat ini.'];
            }

            $booking->update([
                'status' => 'disetujui',
                'note' => $request->input('note') ?? "Koleksi dapat diambil sebelum pukul {$timeInput} WIB",
                'batas_waktu_ambil' => $batasWaktu,
            ]);

            // Reservation consumes one available copy atomically with the
            // status transition. The collection row is already locked.
            $collection->syncBackingStock(-1);

            return [
                'booking' => $booking->load(['user', 'collection.book']),
            ];
        });

        if (isset($result['error'])) {
            return redirect()
                ->route('petugas.bookings.index')
                ->with('error', $result['error']);
        }

        $booking = $result['booking'];

        // Send Notification to Member
        $bookTitle = $booking->collection?->display_title ?? 'buku';
        \App\Models\NotificationCustom::send(
            $booking->user_id,
            'Booking Disetujui (Siap Diambil)',
            "Buku '{$bookTitle}' telah disetujui dan siap diambil di perpustakaan sebelum pukul {$timeInput} WIB.",
            route('mahasiswa.bookings.my'),
            'booking'
        );

        return redirect()
            ->route('petugas.bookings.index')
            ->with('success', "Booking oleh {$booking->user->name} untuk \"{$booking->collection?->display_title}\" telah disetujui.");
    }

    /**
     * Tolak booking.
     */
    public function reject(Request $request, $booking_id)
    {
        $result = DB::transaction(function () use ($booking_id, $request) {
            $booking = Booking::query()
                ->whereKey($booking_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($booking->status, ['pending', 'disetujui'], true)) {
                return ['error' => 'Booking ini tidak dapat dibatalkan.'];
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
                'note' => $request->input('note') ?? 'Booking dibatalkan.',
            ]);

            // Jika sebelumnya sudah disetujui, kembalikan stok buku
            if ($oldStatus === 'disetujui' && $collection) {
                $collection->syncBackingStock(1);
            }

            return [
                'booking' => $booking->load(['user', 'collection.book']),
                'released_collection_id' => $collection?->koleksi_id,
            ];
        });

        if (isset($result['error'])) {
            return redirect()
                ->route('petugas.bookings.index')
                ->with('error', $result['error']);
        }

        $booking = $result['booking'];

        if ($result['released_collection_id']) {
            Antrian::checkAndNotifyAvailableQueue($result['released_collection_id']);
        }

        return redirect()
            ->route('petugas.bookings.index')
            ->with('success', "Booking oleh {$booking->user->name} berhasil dibatalkan.");
    }

    /**
     * Realisasikan booking menjadi peminjaman aktif.
     */
    public function realize(Request $request, $booking_id)
    {
        $result = DB::transaction(function () use ($booking_id) {
            $booking = Booking::query()
                ->whereKey($booking_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($booking->status !== 'disetujui') {
                return ['error' => 'Hanya booking yang telah disetujui yang dapat direalisasikan menjadi peminjaman.'];
            }

            // Keep the collection in the same lock order as approval,
            // cancellation, expiry, and return operations.
            Collection::query()
                ->whereKey($booking->koleksi_id)
                ->lockForUpdate()
                ->firstOrFail();

            // Re-check inside the transaction so two realization requests
            // cannot create two active loans for the same member/title.
            $hasActiveLoan = Loan::where('user_id', $booking->user_id)
                ->where('koleksi_id', $booking->koleksi_id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->exists();

            if ($hasActiveLoan) {
                return ['error' => 'Anggota ini masih memiliki peminjaman aktif untuk judul buku yang sama.'];
            }

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

            return [
                'booking' => $booking->load(['user', 'collection.book']),
            ];
        });

        if (isset($result['error'])) {
            return redirect()
                ->route('petugas.bookings.index')
                ->with('error', $result['error']);
        }

        $booking = $result['booking'];

        return redirect()
            ->route('petugas.loans.index')
            ->with('success', "Booking oleh {$booking->user->name} berhasil diproses menjadi peminjaman aktif.");
    }
}
