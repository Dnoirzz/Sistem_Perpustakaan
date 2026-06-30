<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';
    protected $primaryKey = 'mhs_id';

    protected $fillable = [
        'user_id',
        'prodi_id',
        'nim',
        'semester',
    ];

    /**
     * Relasi: Mahasiswa milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: Mahasiswa milik satu Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'prodi_id');
    }

    /**
     * Relasi: Mahasiswa memiliki banyak Laporan PKL
     */
    public function laporanPkl()
    {
        return $this->hasMany(LaporanPkl::class, 'mahasiswa_id', 'mhs_id');
    }

    /**
     * Relasi: Mahasiswa memiliki banyak Proposal TA
     */
    public function proposalTa()
    {
        return $this->hasMany(ProposalTa::class, 'mahasiswa_id', 'mhs_id');
    }

    /**
     * Relasi: Mahasiswa memiliki banyak Laporan TA
     */
    public function laporanTa()
    {
        return $this->hasMany(LaporanTugasAkhir::class, 'mahasiswa_id', 'mhs_id');
    }
}
