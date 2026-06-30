<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $primaryKey = 'rekomendasi_id';

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'reason',
        'status',
    ];

    /**
     * Relasi: Recommendation milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: Recommendation bisa masuk ke banyak VotingItem
     */
    public function votingItems()
    {
        return $this->hasMany(VotingItem::class, 'rekomendasi_id', 'rekomendasi_id');
    }
}
