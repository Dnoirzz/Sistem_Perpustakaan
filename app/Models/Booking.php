<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $expiredBookings = self::with('collection.book')
            ->where('status', 'disetujui')
            ->whereNotNull('batas_waktu_ambil')
            ->where('batas_waktu_ambil', '<', now())
            ->get();

        if ($expiredBookings->isNotEmpty()) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($expiredBookings) {
                foreach ($expiredBookings as $booking) {
                    $booking->update([
                        'status' => 'dibatalkan',
                        'note' => 'Booking dibatalkan otomatis karena melewati batas waktu pengambilan.'
                    ]);

                    if ($booking->collection) {
                        $booking->collection->syncBackingStock(1);
                    }
                }
            });
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
