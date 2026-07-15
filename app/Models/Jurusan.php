<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusans';
    protected $primaryKey = 'jurusan_id';

    protected $fillable = [
        'nama_jurusan',
    ];

    /**
     * Relasi: Jurusan memiliki banyak Prodi
     */
    public function prodis()
    {
        return $this->hasMany(Prodi::class, 'jurusan_id', 'jurusan_id');
    }
}
