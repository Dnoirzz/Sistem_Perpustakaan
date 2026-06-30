<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Seed data roles: admin, petugas, dosen, mahasiswa
     */
    public function run(): void
    {
        $roles = ['admin', 'petugas', 'dosen', 'mahasiswa'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['role_name' => $role]);
        }
    }
}
