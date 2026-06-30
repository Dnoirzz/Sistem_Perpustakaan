<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Seed data kategori buku perpustakaan
     */
    public function run(): void
    {
        $categories = [
            'Teknik Informatika',
            'Teknik Sipil',
            'Akuntansi',
            'Pemrograman',
            'Jaringan Komputer',
            'Basis Data',
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Umum',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['kategori_name' => $category]);
        }
    }
}
