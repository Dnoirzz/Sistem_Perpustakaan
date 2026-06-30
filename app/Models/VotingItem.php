<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'voting_item_id';

    protected $fillable = [
        'voting_id',
        'rekomendasi_id',
    ];

    /**
     * Relasi: VotingItem milik satu Voting
     */
    public function voting()
    {
        return $this->belongsTo(Voting::class, 'voting_id', 'voting_id');
    }

    /**
     * Relasi: VotingItem milik satu Recommendation
     */
    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class, 'rekomendasi_id', 'rekomendasi_id');
    }

    /**
     * Relasi: VotingItem memiliki banyak Vote
     */
    public function votes()
    {
        return $this->hasMany(Vote::class, 'voting_item_id', 'voting_item_id');
    }

    /**
     * Hitung total vote
     */
    public function getTotalVotesAttribute(): int
    {
        return $this->votes()->count();
    }
}
