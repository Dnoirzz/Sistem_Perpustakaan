<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        foreach (['admin', 'petugas', 'dosen', 'mahasiswa'] as $roleName) {
            \App\Models\Role::firstOrCreate(['role_name' => $roleName]);
        }

        $prodi = \App\Models\Prodi::create(['nama_prodi' => 'D3 Teknologi Informasi']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'SecuredPass123',
            'password_confirmation' => 'SecuredPass123',
            'no_hp' => '081234567890',
            'role_name' => 'mahasiswa',
            'prodi_id' => $prodi->prodi_id,
            'nim' => '12345678',
            'semester' => '1',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('register'));
        $response->assertSessionHas('registration_success', true);
    }

    public function test_registration_fails_if_password_does_not_meet_rules(): void
    {
        foreach (['admin', 'petugas', 'dosen', 'mahasiswa'] as $roleName) {
            \App\Models\Role::firstOrCreate(['role_name' => $roleName]);
        }

        $prodi = \App\Models\Prodi::create(['nama_prodi' => 'D3 Teknologi Informasi']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12345678', // No uppercase, no letters
            'password_confirmation' => '12345678',
            'no_hp' => '081234567890',
            'role_name' => 'mahasiswa',
            'prodi_id' => $prodi->prodi_id,
            'nim' => '12345678',
            'semester' => '1',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'password' => 'password harus mengandung setidaknya satu huruf.'
        ]);
    }

    public function test_petugas_can_create_member_with_simple_password(): void
    {
        foreach (['admin', 'petugas', 'dosen', 'mahasiswa'] as $roleName) {
            $roles[$roleName] = \App\Models\Role::firstOrCreate(['role_name' => $roleName]);
        }

        $prodi = \App\Models\Prodi::create(['nama_prodi' => 'D3 Teknologi Informasi']);

        $petugasUser = \App\Models\User::create([
            'name' => 'Petugas Test',
            'email' => 'petugas@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('SecuredPass123'),
            'no_hp' => '081234567891',
            'role_id' => $roles['petugas']->role_id,
        ]);

        \App\Models\Petugas::create([
            'user_id' => $petugasUser->user_id,
            'nip' => '198603012020121002',
            'jabatan' => 'Pustakawan',
        ]);

        $response = $this->actingAs($petugasUser)
            ->post(route('petugas.members.store'), [
                'name' => 'Member Test',
                'email' => 'member@example.com',
                'password' => '12345678', // Simple password
                'password_confirmation' => '12345678',
                'no_hp' => '081234567892',
                'role_id' => $roles['mahasiswa']->role_id,
                'nim' => '1234567890',
                'prodi_id' => $prodi->prodi_id,
                'semester' => '1',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('petugas.members.index'));
        
        $this->assertDatabaseHas('users', [
            'email' => 'member@example.com',
        ]);
    }
}
