<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $primaryKey = 'vote_id';

    protected $fillable = [
        'voting_item_id',
        'user_id',
    ];

    /**
     * Relasi: Vote milik satu VotingItem
     */
    public function votingItem()
    {
        return $this->belongsTo(VotingItem::class, 'voting_item_id', 'voting_item_id');
    }

    /**
     * Relasi: Vote milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
