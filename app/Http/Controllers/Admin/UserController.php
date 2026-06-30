<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleId = $request->input('role_id');

        $users = User::with(['role', 'mahasiswa.prodi', 'dosen.prodi', 'petugas'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('mahasiswa', function ($m) use ($search) {
                          $m->where('nim', 'like', "%{$search}%");
                      })
                      ->orWhereHas('dosen', function ($d) use ($search) {
                          $d->where('nip', 'like', "%{$search}%");
                      })
                      ->orWhereHas('petugas', function ($p) use ($search) {
                          $p->where('nip', 'like', "%{$search}%");
                      });
                });
            })
            ->when($roleId, function ($query, $roleId) {
                return $query->where('role_id', $roleId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles', 'search', 'roleId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        return view('admin.users.create', compact('roles', 'prodis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'no_hp' => ['required', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,role_id'],
        ];

        $role = Role::find($request->role_id);

        if ($role) {
            if ($role->role_name === 'mahasiswa') {
                $rules['nim'] = ['required', 'string', 'max:50', 'unique:mahasiswas,nim'];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
                $rules['semester'] = ['required', 'string', 'max:10'];
            } elseif ($role->role_name === 'dosen') {
                $rules['nip'] = ['required', 'string', 'max:50', 'unique:dosens,nip'];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
            } elseif ($role->role_name === 'petugas') {
                $rules['nip'] = ['required', 'string', 'max:50', 'unique:petugas,nip'];
                $rules['jabatan'] = ['nullable', 'string', 'max:100'];
            }
        }

        $request->validate($rules);

        DB::transaction(function () use ($request, $role) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'role_id' => $request->role_id,
            ]);

            if ($role->role_name === 'mahasiswa') {
                Mahasiswa::create([
                    'user_id' => $user->user_id,
                    'prodi_id' => $request->prodi_id,
                    'nim' => $request->nim,
                    'semester' => $request->semester,
                ]);
            } elseif ($role->role_name === 'dosen') {
                Dosen::create([
                    'user_id' => $user->user_id,
                    'nip' => $request->nip,
                    'prodi_id' => $request->prodi_id,
                ]);
            } elseif ($role->role_name === 'petugas') {
                Petugas::create([
                    'user_id' => $user->user_id,
                    'nip' => $request->nip,
                    'jabatan' => $request->jabatan,
                ]);
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load(['role', 'mahasiswa', 'dosen', 'petugas']);
        $roles = Role::all();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        return view('admin.users.edit', compact('user', 'roles', 'prodis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->user_id, 'user_id')],
            'no_hp' => ['required', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,role_id'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $newRole = Role::find($request->role_id);
        $oldRole = $user->role;

        if ($newRole) {
            if ($newRole->role_name === 'mahasiswa') {
                $mhsId = $user->mahasiswa->mhs_id ?? 0;
                $rules['nim'] = ['required', 'string', 'max:50', Rule::unique('mahasiswas', 'nim')->ignore($mhsId, 'mhs_id')];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
                $rules['semester'] = ['required', 'string', 'max:10'];
            } elseif ($newRole->role_name === 'dosen') {
                $dosenId = $user->dosen->dosen_id ?? 0;
                $rules['nip'] = ['required', 'string', 'max:50', Rule::unique('dosens', 'nip')->ignore($dosenId, 'dosen_id')];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
            } elseif ($newRole->role_name === 'petugas') {
                $staffId = $user->petugas->staff_id ?? 0;
                $rules['nip'] = ['required', 'string', 'max:50', Rule::unique('petugas', 'nip')->ignore($staffId, 'staff_id')];
                $rules['jabatan'] = ['nullable', 'string', 'max:100'];
            }
        }

        $request->validate($rules);

        DB::transaction(function () use ($request, $user, $newRole, $oldRole) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'role_id' => $request->role_id,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // If role has changed, delete old profile
            if ($oldRole->role_id != $newRole->role_id) {
                if ($oldRole->role_name === 'mahasiswa') {
                    Mahasiswa::where('user_id', $user->user_id)->delete();
                } elseif ($oldRole->role_name === 'dosen') {
                    Dosen::where('user_id', $user->user_id)->delete();
                } elseif ($oldRole->role_name === 'petugas') {
                    Petugas::where('user_id', $user->user_id)->delete();
                }
            }

            // Create/Update the current role profile
            if ($newRole->role_name === 'mahasiswa') {
                Mahasiswa::updateOrCreate(
                    ['user_id' => $user->user_id],
                    [
                        'prodi_id' => $request->prodi_id,
                        'nim' => $request->nim,
                        'semester' => $request->semester,
                    ]
                );
            } elseif ($newRole->role_name === 'dosen') {
                Dosen::updateOrCreate(
                    ['user_id' => $user->user_id],
                    [
                        'nip' => $request->nip,
                        'prodi_id' => $request->prodi_id,
                    ]
                );
            } elseif ($newRole->role_name === 'petugas') {
                Petugas::updateOrCreate(
                    ['user_id' => $user->user_id],
                    [
                        'nip' => $request->nip,
                        'jabatan' => $request->jabatan,
                    ]
                );
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
