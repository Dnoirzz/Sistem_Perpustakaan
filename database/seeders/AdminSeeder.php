<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Seed default admin user
     */
    public function run(): void
    {
        $adminRole = Role::where('role_name', 'admin')->first();

        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@perpustakaan.com'],
                [
                    'role_id' => $adminRole->role_id,
                    'name' => 'Administrator',
                    'password' => bcrypt('admin123'),
                    'no_hp' => '081234567890',
                ]
            );
        }
    }
}
