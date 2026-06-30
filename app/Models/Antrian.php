<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';
    protected $primaryKey = 'antrian_id';

    protected $fillable = [
        'user_id',
        'koleksi_id',
        'no_antrian',
        'status',
    ];

    /**
     * Relasi: Antrian milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: Antrian milik satu Collection
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class, 'koleksi_id', 'koleksi_id');
    }
}
