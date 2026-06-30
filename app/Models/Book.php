<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'buku_id';

    protected $fillable = [
        'kategori_id',
        'judul',
        'author',
        'publisher',
        'release',
        'stock',
        'cover_image',
    ];

    /**
     * Boot model events for synchronizing collections.
     */
    protected static function booted()
    {
        static::created(function ($book) {
            Collection::create([
                'item_type' => 'book',
                'item_id' => $book->buku_id,
                'stock' => $book->stock,
            ]);
        });

        static::updated(function ($book) {
            if ($book->isDirty('stock')) {
                $book->collection()->update(['stock' => $book->stock]);
            }
        });

        static::deleted(function ($book) {
            $book->collection()->delete();
        });
    }

    /**
     * Relasi: Book milik satu Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id', 'kategori_id');
    }

    /**
     * Relasi: Book memiliki satu Collection (polimorfik)
     */
    public function collection()
    {
        return $this->hasOne(Collection::class, 'item_id', 'buku_id')
                    ->where('item_type', 'book');
    }

    /**
     * Hitung jumlah eksemplar yang sedang dipinjam (status 'dipinjam')
     */
    public function getActiveLoansCountAttribute(): int
    {
        $collection = $this->collection;
        if (!$collection) {
            return 0;
        }
        return Loan::where('koleksi_id', $collection->koleksi_id)
                    ->where('status', 'dipinjam')
                    ->count();
    }
}
