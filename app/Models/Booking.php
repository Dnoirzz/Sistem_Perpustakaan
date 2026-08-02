<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'user_id',
        'koleksi_id',
        'tgl_booking',
        'status',
        'note',
        'batas_waktu_ambil',
    ];

    protected $casts = [
        'tgl_booking' => 'date',
        'batas_waktu_ambil' => 'datetime',
    ];

    /**
     * Otomatis membatalkan booking yang telah melewati batas waktu.
     */
    public static function checkExpiredBookings()
    {
        $expiredBookingIds = self::query()
            ->where('status', 'disetujui')
            ->whereNotNull('batas_waktu_ambil')
            ->where('batas_waktu_ambil', '<', now())
            ->pluck('booking_id');

        foreach ($expiredBookingIds as $bookingId) {
            $releasedCollectionId = DB::transaction(function () use ($bookingId) {
                // Re-check status after taking the booking lock. An approval,
                // cancellation, or realization may have won the race.
                $booking = self::query()
                    ->whereKey($bookingId)
                    ->lockForUpdate()
                    ->first();

                if (! $booking
                    || $booking->status !== 'disetujui'
                    || ! $booking->batas_waktu_ambil
                    || $booking->batas_waktu_ambil->isFuture()) {
                    return null;
                }

                $collection = Collection::query()
                    ->whereKey($booking->koleksi_id)
                    ->lockForUpdate()
                    ->first();

                $booking->update([
                    'status' => 'dibatalkan',
                    'note' => 'Booking dibatalkan otomatis karena melewati batas waktu pengambilan.',
                    'batas_waktu_ambil' => null,
                ]);

                if ($collection) {
                    $collection->syncBackingStock(1);
                }

                return $collection?->koleksi_id;
            });

            if ($releasedCollectionId) {
                Antrian::checkAndNotifyAvailableQueue($releasedCollectionId);
            }
        }
    }

    /**
     * Relasi: Booking milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: Booking milik satu Collection
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class, 'koleksi_id', 'koleksi_id');
    }
}
