<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';
    protected $primaryKey = 'dosen_id';

    protected $fillable = [
        'user_id',
        'nip',
        'prodi_id',
    ];

    /**
     * Relasi: Dosen milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: Dosen milik satu Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'prodi_id');
    }
}
