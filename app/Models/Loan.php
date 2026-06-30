<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $primaryKey = 'loan_id';

    protected $fillable = [
        'user_id',
        'koleksi_id',
        'tgl_pinjam',
        'bts_waktu',
        'tgl_kembali',
        'status',
        'return_condition_status',
        'return_condition_checks',
        'return_condition_notes',
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'bts_waktu' => 'date',
        'tgl_kembali' => 'date',
        'return_condition_checks' => 'array',
    ];

    /**
     * Relasi: Loan milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: Loan milik satu Collection
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class, 'koleksi_id', 'koleksi_id');
    }

    /**
     * Relasi: Loan memiliki banyak Penalty
     */
    public function penalties()
    {
        return $this->hasMany(Penalty::class, 'loan_id', 'loan_id');
    }

    /**
     * Sinkronkan status pinjaman yang sudah melewati batas waktu.
     */
    public static function syncOverdueStatuses(): void
    {
        static::query()
            ->where('status', 'dipinjam')
            ->whereDate('bts_waktu', '<', today())
            ->update(['status' => 'terlambat']);
    }

    /**
     * Cek apakah peminjaman terlambat
     */
    public function isOverdue(): bool
    {
        return in_array($this->status, ['dipinjam', 'terlambat'], true)
            && now()->greaterThan($this->bts_waktu);
    }
}
