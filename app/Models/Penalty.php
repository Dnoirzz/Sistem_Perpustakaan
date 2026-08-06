<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $table = 'penalties';
    protected $primaryKey = 'penalti_id';

    protected $fillable = [
        'loan_id',
        'user_id',
        'type',
        'penalti_type',
        'amount',
        'description',
        'status',
        'payment_received_at',
        'replacement_received_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_received_at' => 'datetime',
        'replacement_received_at' => 'datetime',
    ];

    /**
     * Relasi: Penalty milik satu Loan
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'loan_id');
    }

    /**
     * Relasi: Penalty milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function getSettlementMethodLabelAttribute(): string
    {
        return match ($this->penalti_type) {
            'uang_tunai', 'denda' => 'Uang tunai',
            'ganti_buku' => 'Ganti buku',
            'kombinasi' => 'Kombinasi',
            default => 'Belum ditentukan',
        };
    }
}
