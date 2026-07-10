<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPkl extends Model
{
    use HasFactory;

    protected $table = 'laporan_pkl';

    protected $fillable = [
        'mahasiswa_id',
        'judul_pkl',
        'nama_tempat_pkl',
        'pembimbing',
        'penguji_1',
        'penguji_2',
        'tahun',
        'file_pdf',
        'file_word',
        'status',
        'catatan_petugas',
        'preview_pdf',
        'surat_tanda_terima_pdf',
        'nomor_surat',
        'verified_at',
        'received_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::deleted(function (self $laporanPkl) {
            $laporanPkl->collection()->delete();
        });
    }

    /**
     * Relasi: LaporanPkl milik satu Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'mhs_id');
    }

    /**
     * Relasi: LaporanPkl memiliki satu Collection
     */
    public function collection()
    {
        return $this->hasOne(Collection::class, 'item_id', 'id')
                    ->where('item_type', 'laporan_pkl');
    }

    public function getDisplayTitleAttribute(): string
    {
        return (string) $this->judul_pkl;
    }
}
