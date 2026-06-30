<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $roleId = $request->input('role_id');
        $prodiId = $request->input('prodi_id');

        // Batasi hanya menampilkan Mahasiswa dan Dosen
        $query = User::whereHas('role', function ($q) {
            $q->whereIn('role_name', ['mahasiswa', 'dosen']);
        })->with(['role', 'mahasiswa.prodi', 'dosen.prodi']);

        // Filter pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', function ($m) use ($search) {
                      $m->where('nim', 'like', "%{$search}%");
                  })
                  ->orWhereHas('dosen', function ($d) use ($search) {
                      $d->where('nip', 'like', "%{$search}%");
                  });
            });
        }

        // Filter role
        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        // Filter prodi
        if ($prodiId) {
            $query->where(function ($q) use ($prodiId) {
                $q->whereHas('mahasiswa', function ($m) use ($prodiId) {
                    $m->where('prodi_id', $prodiId);
                })->orWhereHas('dosen', function ($d) use ($prodiId) {
                    $d->where('prodi_id', $prodiId);
                });
            });
        }

        $members = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        $roles = Role::whereIn('role_name', ['mahasiswa', 'dosen'])->get();
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();

        return view('petugas.members.index', compact('members', 'roles', 'prodis', 'search', 'roleId', 'prodiId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::whereIn('role_name', ['mahasiswa', 'dosen'])->get();
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();
        return view('petugas.members.create', compact('roles', 'prodis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Pastikan role_id yang dipilih hanya Mahasiswa atau Dosen
        $allowedRoles = Role::whereIn('role_name', ['mahasiswa', 'dosen'])->pluck('role_id')->toArray();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'no_hp' => ['required', 'string', 'max:20'],
            'role_id' => ['required', Rule::in($allowedRoles)],
        ];

        $role = Role::find($request->role_id);

        if ($role) {
            if ($role->role_name === 'mahasiswa') {
                $rules['nim'] = ['required', 'string', 'max:50', 'unique:mahasiswas,nim'];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
                $rules['semester'] = ['required', 'integer', 'min:1', 'max:14'];
            } elseif ($role->role_name === 'dosen') {
                $rules['nip'] = ['required', 'string', 'max:50', 'unique:dosens,nip'];
                $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
            }
        }

        $request->validate($rules, [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'role_id.required' => 'Role wajib dipilih.',
            'nim.required' => 'NIM wajib diisi bagi mahasiswa.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nip.required' => 'NIP wajib diisi bagi dosen.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'prodi_id.required' => 'Program Studi wajib dipilih.',
            'semester.required' => 'Semester wajib diisi.',
        ]);

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
            }
        });

        return redirect()->route('petugas.members.index')
            ->with('success', 'Anggota perpustakaan baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $member)
    {
        // Proteksi: Petugas hanya boleh mengedit Mahasiswa atau Dosen
        $member->load(['role', 'mahasiswa', 'dosen']);
        if (!in_array($member->role->role_name, ['mahasiswa', 'dosen'])) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengelola akun ini.');
        }

        $roles = Role::whereIn('role_name', ['mahasiswa', 'dosen'])->get();
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();

        return view('petugas.members.edit', compact('member', 'roles', 'prodis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $member)
    {
        // Proteksi: Petugas hanya boleh mengupdate Mahasiswa atau Dosen
        if (!in_array($member->role->role_name, ['mahasiswa', 'dosen'])) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengelola akun ini.');
        }

        // Role tidak boleh diubah oleh petugas
        $currentRole = $member->role;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($member->user_id, 'user_id')],
            'no_hp' => ['required', 'string', 'max:20'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        if ($currentRole->role_name === 'mahasiswa') {
            $mhsId = $member->mahasiswa->mhs_id ?? 0;
            $rules['nim'] = ['required', 'string', 'max:50', Rule::unique('mahasiswas', 'nim')->ignore($mhsId, 'mhs_id')];
            $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
            $rules['semester'] = ['required', 'integer', 'min:1', 'max:14'];
        } elseif ($currentRole->role_name === 'dosen') {
            $dosenId = $member->dosen->dosen_id ?? 0;
            $rules['nip'] = ['required', 'string', 'max:50', Rule::unique('dosens', 'nip')->ignore($dosenId, 'dosen_id')];
            $rules['prodi_id'] = ['required', 'exists:prodi,prodi_id'];
        }

        $request->validate($rules, [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'nim.required' => 'NIM wajib diisi bagi mahasiswa.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nip.required' => 'NIP wajib diisi bagi dosen.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'prodi_id.required' => 'Program Studi wajib dipilih.',
            'semester.required' => 'Semester wajib diisi.',
        ]);

        DB::transaction(function () use ($request, $member, $currentRole) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                // role_id tetap tidak berubah
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $member->update($userData);

            // Perbarui profil akademik sesuai role yang ada
            if ($currentRole->role_name === 'mahasiswa') {
                Mahasiswa::updateOrCreate(
                    ['user_id' => $member->user_id],
                    [
                        'prodi_id' => $request->prodi_id,
                        'nim' => $request->nim,
                        'semester' => $request->semester,
                    ]
                );
            } elseif ($currentRole->role_name === 'dosen') {
                Dosen::updateOrCreate(
                    ['user_id' => $member->user_id],
                    [
                        'nip' => $request->nip,
                        'prodi_id' => $request->prodi_id,
                    ]
                );
            }
        });

        return redirect()->route('petugas.members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $member)
    {
        // Proteksi: Petugas hanya boleh menghapus Mahasiswa atau Dosen
        if (!in_array($member->role->role_name, ['mahasiswa', 'dosen'])) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengelola akun ini.');
        }

        $member->delete();

        return redirect()->route('petugas.members.index')
            ->with('success', 'Anggota perpustakaan berhasil dihapus.');
    }
}
