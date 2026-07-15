<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jurusans = [
            'Teknologi Informasi',
            'Teknik Sipil',
            'Teknik Mesin',
            'Teknik Elektro',
            'Akuntansi',
            'Administrasi Bisnis',
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::firstOrCreate(['nama_jurusan' => $jurusan]);
        }
    }
}
