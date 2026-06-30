<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'kategori_name',
    ];

    /**
     * Relasi: Category memiliki banyak Book
     */
    public function books()
    {
        return $this->hasMany(Book::class, 'kategori_id', 'kategori_id');
    }
}
