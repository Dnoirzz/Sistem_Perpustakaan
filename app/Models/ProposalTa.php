<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalTa extends Model
{
    use HasFactory;

    protected $table = 'proposal_ta';

    protected $fillable = [
        'mahasiswa_id',
        'judul_proposal',
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
        static::deleted(function (self $proposalTa) {
            $proposalTa->collection()->delete();
        });
    }

    /**
     * Relasi: ProposalTa milik satu Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'mhs_id');
    }

    /**
     * Relasi: ProposalTa memiliki satu Collection
     */
    public function collection()
    {
        return $this->hasOne(Collection::class, 'item_id', 'id')
                    ->where('item_type', 'proposal_ta');
    }

    public function getDisplayTitleAttribute(): string
    {
        return (string) $this->judul_proposal;
    }
}
