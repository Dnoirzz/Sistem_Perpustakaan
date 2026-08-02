<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

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
            'book' => 'Buku Umum',
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

        $sync = function () use ($delta): void {
            // The collection row is the inventory source used by booking/loan
            // decisions. Always lock it before calculating the new value.
            $collection = static::query()
                ->whereKey($this->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $newStock = (int) $collection->stock + $delta;
            if ($newStock < 0) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'stock' => 'Stok koleksi tidak mencukupi.',
                ]);
            }

            $book = null;
            if ($collection->item_type === 'book') {
                // Lock the backing book after the collection, matching the
                // lock order used by all circulation transactions.
                $book = Book::query()
                    ->whereKey($collection->item_id)
                    ->lockForUpdate()
                    ->first();
            }

            $collection->update(['stock' => $newStock]);

            // Use a query update so Book's stock observer cannot perform a
            // second, non-atomic collection update while this transaction is
            // synchronizing the two inventory columns.
            if ($book) {
                Book::query()
                    ->whereKey($book->getKey())
                    ->update(['stock' => $newStock]);
            }

            $this->setAttribute('stock', $newStock);
            if ($this->relationLoaded('book') && $this->book) {
                $this->book->setAttribute('stock', $newStock);
            }
        };

        if (DB::transactionLevel() > 0) {
            $sync();
        } else {
            DB::transaction($sync);
        }
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->item_type === 'book' && $this->book) {
            return $this->book->cover_url;
        }
        return asset('img/logo_polnep.webp');
    }

    public function getAuthorNameAttribute(): string
    {
        if ($this->item_type === 'book') {
            return $this->book?->author ?? 'Penulis tidak diketahui';
        }
        if ($this->item_type === 'laporan_pkl') {
            return $this->laporanPkl?->mahasiswa?->nama_lengkap ?? 'Alumni Mahasiswa';
        }
        if ($this->item_type === 'proposal_ta') {
            return $this->proposalTa?->mahasiswa?->nama_lengkap ?? 'Mahasiswa TA';
        }
        if ($this->item_type === 'laporan_ta') {
            return $this->laporanTa?->mahasiswa?->nama_lengkap ?? 'Alumni Mahasiswa';
        }
        return 'Penulis tidak diketahui';
    }
}
