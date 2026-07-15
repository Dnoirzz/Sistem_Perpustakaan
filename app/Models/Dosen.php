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

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'prodi_id');
    }

    /**
     * Relasi: Dosen milik satu Jurusan (melalui Prodi)
     */
    public function jurusan()
    {
        return $this->hasOneThrough(
            Jurusan::class,
            Prodi::class,
            'prodi_id',     // FK di prodi
            'jurusan_id',   // FK di jurusans
            'prodi_id',     // Local key di dosens
            'jurusan_id'    // Local key di prodi
        );
    }
}
