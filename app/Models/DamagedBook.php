<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DamagedBook extends Model
{
    use HasFactory;

    protected $primaryKey = 'damaged_book_id';

    protected $fillable = [
        'loan_id',
        'koleksi_id',
        'user_id',
        'reported_by',
        'reported_at',
        'condition_notes',
        'status',
        'replacement_koleksi_id',
        'replacement_notes',
        'resolved_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'loan_id');
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class, 'koleksi_id', 'koleksi_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by', 'user_id');
    }

    public function replacementCollection(): BelongsTo
    {
        return $this->belongsTo(Collection::class, 'replacement_koleksi_id', 'koleksi_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_penggantian' => 'Menunggu Penggantian',
            'selesai_diganti_sama' => 'Selesai (Buku Sama)',
            'selesai_diganti_koleksi_baru' => 'Selesai (Koleksi Baru)',
            'diafkir_perbaikan' => 'Di-afkir / Perbaikan',
            default => $this->status,
        };
    }
}
