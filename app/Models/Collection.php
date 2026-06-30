<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use HasFactory;

    protected $primaryKey = 'koleksi_id';

    protected $fillable = [
        'item_type',
        'item_id',
        'stock',
    ];

    /**
     * Mendapatkan item terkait (polimorfik manual)
     * item_type: 'book', 'laporan_pkl', 'proposal_ta', 'laporan_ta'
     */
    public function item()
    {
        if ($this->item_type === 'book') {
            return $this->belongsTo(Book::class, 'item_id', 'buku_id');
        } elseif ($this->item_type === 'laporan_pkl') {
            return $this->belongsTo(LaporanPkl::class, 'item_id', 'id');
        } elseif ($this->item_type === 'proposal_ta') {
            return $this->belongsTo(ProposalTa::class, 'item_id', 'id');
        } elseif ($this->item_type === 'laporan_ta') {
            return $this->belongsTo(LaporanTugasAkhir::class, 'item_id', 'id');
        }
        return null;
    }

    /**
     * Relasi eksplisit ke buku untuk kebutuhan eager-loading transaksi buku.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'item_id', 'buku_id');
    }

    public function laporanPkl(): BelongsTo
    {
        return $this->belongsTo(LaporanPkl::class, 'item_id', 'id');
    }

    public function proposalTa(): BelongsTo
    {
        return $this->belongsTo(ProposalTa::class, 'item_id', 'id');
    }

    public function laporanTa(): BelongsTo
    {
        return $this->belongsTo(LaporanTugasAkhir::class, 'item_id', 'id');
    }

    /**
     * Relasi: Collection memiliki banyak Loan
     */
    public function loans()
    {
        return $this->hasMany(Loan::class, 'koleksi_id', 'koleksi_id');
    }

    /**
     * Relasi: Collection memiliki banyak Booking
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'koleksi_id', 'koleksi_id');
    }

    /**
     * Relasi: Collection memiliki banyak Antrian
     */
    public function antrian()
    {
        return $this->hasMany(Antrian::class, 'koleksi_id', 'koleksi_id');
    }

    /**
     * Ambil judul item koleksi untuk ditampilkan pada UI.
     */
    public function getDisplayTitleAttribute(): string
    {
        if ($this->item_type === 'book') {
            return $this->book?->judul ?? 'Buku tidak ditemukan';
        }

        if ($this->item_type === 'laporan_pkl') {
            return LaporanPkl::query()->whereKey($this->item_id)->value('judul_pkl') ?? 'Laporan PKL';
        }

        if ($this->item_type === 'proposal_ta') {
            return ProposalTa::query()->whereKey($this->item_id)->value('judul_proposal') ?? 'Proposal Tugas Akhir';
        }

        if ($this->item_type === 'laporan_ta') {
            return LaporanTugasAkhir::query()->whereKey($this->item_id)->value('judul_tgs_akhir') ?? 'Laporan Tugas Akhir';
        }

        return 'Item koleksi';
    }

    /**
     * Label jenis item koleksi untuk badge atau keterangan singkat.
     */
    public function getDisplayTypeLabelAttribute(): string
    {
        return match ($this->item_type) {
            'book' => 'Buku Teks',
            'laporan_pkl' => 'Laporan PKL',
            'proposal_ta' => 'Proposal TA',
            'laporan_ta' => 'Laporan TA',
            default => 'Koleksi',
        };
    }

    public function syncBackingStock(int $delta): void
    {
        if ($delta === 0) {
            return;
        }

        $this->increment('stock', $delta);

        if ($this->item_type === 'book' && $this->book) {
            if ($delta > 0) {
                $this->book->increment('stock', $delta);
            } else {
                $this->book->decrement('stock', abs($delta));
            }
        }
    }
}
