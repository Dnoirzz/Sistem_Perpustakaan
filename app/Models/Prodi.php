<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'prodi_id';

    protected $fillable = [
        'nama_prodi',
        'jurusan_id',
    ];

    /**
     * Relasi: Prodi milik suatu Jurusan
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'jurusan_id');
    }

    /**
     * Relasi: Prodi memiliki banyak Mahasiswa
     */
    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'prodi_id', 'prodi_id');
    }

    /**
     * Relasi: Prodi memiliki banyak Dosen
     */
    public function dosens()
    {
        return $this->hasMany(Dosen::class, 'prodi_id', 'prodi_id');
    }
}
