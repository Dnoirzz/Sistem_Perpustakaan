<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyRule extends Model
{
    use HasFactory;

    protected $table = 'penalty_rules';

    protected $primaryKey = 'penalty_rule_id';

    protected $fillable = [
        'code',
        'rule_name',
        'calculation_type',
        'default_settlement_method',
        'default_amount',
        'description',
        'is_active',
    ];

    protected $casts = [
        'default_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getCalculationTypeLabelAttribute(): string
    {
        return match ($this->calculation_type) {
            'per_hari' => 'Per hari',
            'flat' => 'Nominal tetap',
            'manual' => 'Manual oleh petugas',
            default => 'Tidak diketahui',
        };
    }

    public function getDefaultSettlementMethodLabelAttribute(): string
    {
        return match ($this->default_settlement_method) {
            'uang_tunai' => 'Uang tunai',
            'ganti_buku' => 'Ganti buku',
            'kombinasi' => 'Kombinasi',
            default => 'Tidak diketahui',
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
