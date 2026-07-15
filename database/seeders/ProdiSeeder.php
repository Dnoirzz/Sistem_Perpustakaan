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
            [
                'nama_prodi' => 'D3 Teknik Informatika',
                'nama_jurusan' => 'Teknologi Informasi',
            ],
            [
                'nama_prodi' => 'D3 Teknik Sipil',
                'nama_jurusan' => 'Teknik Sipil',
            ],
            [
                'nama_prodi' => 'D3 Akuntansi',
                'nama_jurusan' => 'Akuntansi',
            ],
        ];

        foreach ($prodis as $item) {
            $jurusan = \App\Models\Jurusan::where('nama_jurusan', $item['nama_jurusan'])->first();
            if ($jurusan) {
                Prodi::firstOrCreate(
                    ['nama_prodi' => $item['nama_prodi']],
                    ['jurusan_id' => $jurusan->jurusan_id]
                );
            }
        }
    }
}
