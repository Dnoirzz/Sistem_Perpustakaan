<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    /**
     * Seed data program studi PSDKU POLNEP Sukamara
     */
    public function run(): void
    {
        $prodis = [
            'D3 Teknik Informatika',
            'D3 Teknik Sipil',
            'D3 Akuntansi',
        ];

        foreach ($prodis as $prodi) {
            Prodi::firstOrCreate(['nama_prodi' => $prodi]);
        }
    }
}
