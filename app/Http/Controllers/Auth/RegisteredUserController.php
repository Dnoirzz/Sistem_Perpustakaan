<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $prodis = Prodi::orderBy('nama_prodi')->get();
        return view('auth.register', compact('prodis'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['required', 'string', 'max:20'],
            'role_name' => ['required', 'string', 'in:mahasiswa,dosen'],
            'prodi_id' => ['required', 'exists:prodi,prodi_id'],
        ];

        if ($request->role_name === 'mahasiswa') {
            $rules['nim'] = ['required', 'string', 'max:50', 'unique:mahasiswas,nim'];
            $rules['semester'] = ['required', 'string', 'max:10'];
        } else {
            $rules['nip'] = ['required', 'string', 'max:50', 'unique:dosens,nip'];
        }

        $request->validate($rules);

        // Get corresponding role_id
        $roleName = $request->role_name;
        $role = Role::where('role_name', $roleName)->first();

        if (!$role) {
            throw ValidationException::withMessages([
                'role_name' => 'Role tidak valid atau belum terdaftar di sistem.',
            ]);
        }

        // Create User
        $user = User::create([
            'role_id' => $role->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
        ]);

        // Create related Mahasiswa or Dosen profile
        if ($roleName === 'mahasiswa') {
            Mahasiswa::create([
                'user_id' => $user->user_id,
                'prodi_id' => $request->prodi_id,
                'nim' => $request->nim,
                'semester' => $request->semester,
            ]);
        } else {
            Dosen::create([
                'user_id' => $user->user_id,
                'prodi_id' => $request->prodi_id,
                'nip' => $request->nip,
            ]);
        }

        event(new Registered($user));

        // Auth::login($user);

        return redirect()->route('register')->with('registration_success', true);
    }
}
