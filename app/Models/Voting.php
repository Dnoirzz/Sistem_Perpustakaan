<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;

    protected $primaryKey = 'voting_id';

    protected $fillable = [
        'title',
        'deskripsi',
        'tgl_mulai',
        'tgl_selesai',
        'created_by',
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
    ];

    /**
     * Relasi: Voting dibuat oleh satu User
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    /**
     * Relasi: Voting memiliki banyak VotingItem
     */
    public function votingItems()
    {
        return $this->hasMany(VotingItem::class, 'voting_id', 'voting_id');
    }

    /**
     * Cek apakah voting masih aktif
     */
    public function isActive(): bool
    {
        return now()->between($this->tgl_mulai, $this->tgl_selesai);
    }
}
