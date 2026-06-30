<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Seed testing accounts for all roles (Admin, Petugas, Dosen, Mahasiswa).
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('role_name', 'admin')->first();
        $petugasRole = Role::where('role_name', 'petugas')->first();
        $dosenRole = Role::where('role_name', 'dosen')->first();
        $mahasiswaRole = Role::where('role_name', 'mahasiswa')->first();

        // Get default prodi
        $prodi = Prodi::first();
        $prodiId = $prodi ? $prodi->prodi_id : null;

        DB::transaction(function () use ($adminRole, $petugasRole, $dosenRole, $mahasiswaRole, $prodiId) {
            // 1. Admin
            if ($adminRole) {
                User::firstOrCreate(
                    ['email' => 'admin@perpustakaan.com'],
                    [
                        'role_id' => $adminRole->role_id,
                        'name' => 'Administrator',
                        'password' => Hash::make('admin123'),
                        'no_hp' => '081234567890',
                    ]
                );
            }

            // 2. Petugas
            if ($petugasRole) {
                $userPetugas = User::firstOrCreate(
                    ['email' => 'petugas@perpustakaan.com'],
                    [
                        'role_id' => $petugasRole->role_id,
                        'name' => 'Budi Petugas',
                        'password' => Hash::make('password'),
                        'no_hp' => '081234567891',
                    ]
                );
                Petugas::firstOrCreate(
                    ['user_id' => $userPetugas->user_id],
                    [
                        'nip' => '199001012015011001',
                        'jabatan' => 'Pustakawan',
                    ]
                );
            }

            // 3. Dosen
            if ($dosenRole) {
                $userDosen = User::firstOrCreate(
                    ['email' => 'dosen@perpustakaan.com'],
                    [
                        'role_id' => $dosenRole->role_id,
                        'name' => 'Dr. H. Ahmad, M.T.',
                        'password' => Hash::make('password'),
                        'no_hp' => '081234567892',
                    ]
                );
                Dosen::firstOrCreate(
                    ['user_id' => $userDosen->user_id],
                    [
                        'nip' => '198603012020121001',
                        'prodi_id' => $prodiId,
                    ]
                );
            }

            // 4. Mahasiswa
            if ($mahasiswaRole) {
                $userMhs = User::firstOrCreate(
                    ['email' => 'mahasiswa@perpustakaan.com'],
                    [
                        'role_id' => $mahasiswaRole->role_id,
                        'name' => 'Aditya Pratama',
                        'password' => Hash::make('password'),
                        'no_hp' => '081234567893',
                    ]
                );
                Mahasiswa::firstOrCreate(
                    ['user_id' => $userMhs->user_id],
                    [
                        'prodi_id' => $prodiId,
                        'nim' => '3202210001',
                        'semester' => 6,
                    ]
                );
            }

            // 5. Seed a sample Voting session & Candidates
            if ($petugasRole && isset($userPetugas) && isset($userMhs) && isset($userDosen)) {
                $voting = \App\Models\Voting::firstOrCreate(
                    ['title' => 'Pengadaan Buku Referensi Teknik Semester Ganjil 2026/2027'],
                    [
                        'deskripsi' => 'Pilih buku-buku rekomendasi Anda untuk diprioritaskan dalam pengadaan buku perpustakaan semester depan.',
                        'tgl_mulai' => now()->subDays(2)->toDateString(),
                        'tgl_selesai' => now()->addDays(12)->toDateString(),
                        'created_by' => $userPetugas->user_id,
                    ]
                );

                $recs = [
                    [
                        'user_id' => $userMhs->user_id,
                        'title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                        'author' => 'Robert C. Martin',
                        'reason' => 'Sangat penting untuk mempelajari best practice penulisan kode pemrograman yang rapi dan terstruktur.',
                        'status' => 'disetujui',
                    ],
                    [
                        'user_id' => $userDosen->user_id,
                        'title' => 'Introduction to Algorithms',
                        'author' => 'Thomas H. Cormen',
                        'reason' => 'Buku pegangan wajib untuk mata kuliah Struktur Data dan Desain Algoritma.',
                        'status' => 'disetujui',
                    ],
                    [
                        'user_id' => $userMhs->user_id,
                        'title' => 'Laravel in Action',
                        'author' => 'Brandon Cannaday',
                        'reason' => 'Membantu mahasiswa tingkat akhir dalam menyelesaikan tugas akhir berbasis framework Laravel.',
                        'status' => 'disetujui',
                    ]
                ];

                foreach ($recs as $recData) {
                    $rec = \App\Models\Recommendation::firstOrCreate(
                        ['title' => $recData['title']],
                        $recData
                    );

                    $votingItem = \App\Models\VotingItem::firstOrCreate(
                        [
                            'voting_id' => $voting->voting_id,
                            'rekomendasi_id' => $rec->rekomendasi_id,
                        ]
                    );

                    // Add dummy vote from petugas for demonstration
                    \App\Models\Vote::firstOrCreate(
                        [
                            'voting_item_id' => $votingItem->voting_item_id,
                            'user_id' => $userPetugas->user_id,
                        ]
                    );
                }
            }
        });
    }
}
