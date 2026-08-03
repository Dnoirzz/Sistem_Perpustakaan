<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\ActivityLog;
use App\Mail\MemberApprovedMail;
use App\Mail\MemberRejectedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
        $tab = $request->input('tab', 'verified'); // 'verified' atau 'pending'

        $query = User::whereHas('role', function ($q) {
            $q->whereIn('role_name', ['mahasiswa', 'dosen']);
        })->with(['role', 'mahasiswa.prodi', 'dosen.prodi']);

        // Filter tab status verifikasi
        if ($tab === 'pending') {
            $query->where('status_verifikasi', 'pending');
        } else {
            $query->where('status_verifikasi', 'verified');
        }

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

        $pendingCount = User::where('status_verifikasi', 'pending')->count();
        $roles = Role::whereIn('role_name', ['mahasiswa', 'dosen'])->get();
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();

        return view('petugas.members.index', compact('members', 'roles', 'prodis', 'search', 'roleId', 'prodiId', 'tab', 'pendingCount'));
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
     * Display the specified resource.
     */
    public function show(User $member)
    {
        // Proteksi: Petugas hanya boleh melihat Mahasiswa atau Dosen
        $member->load(['role', 'mahasiswa.prodi', 'dosen.prodi']);
        if (!in_array($member->role->role_name, ['mahasiswa', 'dosen'])) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengelola akun ini.');
        }

        // 1. Get active physical borrowings (status dipinjam, terlambat)
        $activeLoans = \App\Models\Loan::with(['collection.book'])
            ->where('user_id', $member->user_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderBy('tgl_pinjam', 'desc')
            ->get();

        // 2. Get completed physical loans (returned)
        $completedLoans = \App\Models\Loan::with(['collection.book'])
            ->where('user_id', $member->user_id)
            ->whereIn('status', ['dikembalikan', 'hilang'])
            ->get()
            ->map(function ($loan) {
                $isLost = $loan->status === 'hilang';

                // Calculate lateness
                $isLate = $loan->tgl_kembali && $loan->bts_waktu && $loan->tgl_kembali->greaterThan($loan->bts_waktu);
                $daysLate = 0;
                if ($isLate) {
                    $daysLate = $loan->tgl_kembali->diffInDays($loan->bts_waktu);
                }

                // Check condition
                $isDamaged = ! $isLost && $loan->return_condition_status === 'bermasalah';
                $notes = $loan->return_condition_notes;

                // Build description (keterangan)
                $keteranganParts = [];
                if ($isLate && ! $isLost) {
                    $keteranganParts[] = "Terlambat ({$daysLate} hari)";
                }
                if ($isLost) {
                    $keteranganParts[] = 'Buku Hilang' . ($notes ? ": {$notes}" : '');
                } elseif ($isDamaged) {
                    $detailKerusakan = $notes ? ": {$notes}" : "";
                    $keteranganParts[] = "Buku rusak{$detailKerusakan}";
                }

                $keterangan = count($keteranganParts) > 0
                    ? implode(' & ', $keteranganParts)
                    : 'Kondisi baik';

                return [
                    'tipe_riwayat' => 'fisik',
                    'judul' => $loan->collection?->display_title ?? 'Koleksi tidak ditemukan',
                    'penulis' => $loan->collection?->book?->author ?? 'Penulis',
                    'tgl_pinjam' => $loan->tgl_pinjam,
                    'tgl_kembali' => $loan->tgl_kembali,
                    'tanggal_aksi' => $loan->tgl_kembali, // Carbon instance
                    'keterangan' => $keterangan,
                    'status_kondisi' => $loan->return_condition_status,
                    'catatan' => $loan->return_condition_notes,
                    'status_peminjaman' => $loan->status,
                ];
            });

        // 3. Get digital read logs
        $readLogs = \App\Models\ArchiveReadLog::with(['archive'])
            ->where('user_id', $member->user_id)
            ->get()
            ->map(function ($log) {
                $archive = $log->archive;
                $title = $archive ? \App\Support\ArsipDigital::title($archive) : 'Arsip tidak ditemukan';
                $author = $archive?->mahasiswa?->user?->name ?? 'Mahasiswa';
                return [
                    'tipe_riwayat' => 'digital',
                    'judul' => $title,
                    'penulis' => 'Oleh: ' . $author,
                    'tgl_pinjam' => $log->created_at,
                    'tgl_kembali' => $log->finished_at,
                    'tanggal_aksi' => $log->created_at, // Carbon instance
                    'keterangan' => 'Baca Online',
                    'status_kondisi' => null,
                    'catatan' => null,
                ];
            });

        // 4. Combine and sort by date descending
        $history = $completedLoans->concat($readLogs)->sortByDesc(function ($item) {
            return $item['tanggal_aksi'] instanceof \Carbon\Carbon
                ? $item['tanggal_aksi']->timestamp
                : (is_string($item['tanggal_aksi']) ? strtotime($item['tanggal_aksi']) : 0);
        })->values();

        return view('petugas.members.show', compact('member', 'activeLoans', 'history'));
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

    /**
     * Disetujui (Approve) pendaftaran anggota.
     */
    public function approve(User $member)
    {
        if ($member->status_verifikasi === 'verified') {
            return redirect()->back()->with('warning', 'Akun ini sudah terverifikasi sebelumnya.');
        }

        $member->update([
            'status_verifikasi' => 'verified',
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Menyetujui (Approve) pendaftaran anggota baru: ' . $member->name . ' (' . $member->email . ')',
        ]);

        // Kirim Email Notifikasi Kelulusan
        try {
            Mail::to($member->email)->send(new MemberApprovedMail($member));
            Log::info("Email kelulusan verifikasi terkirim ke {$member->email}");
        } catch (\Exception $e) {
            Log::warning("Gagal mengirim email kelulusan verifikasi ke {$member->email}: " . $e->getMessage());
        }

        // Kirim Notifikasi Lonceng (Bell) ke User
        try {
            \App\Models\NotificationCustom::send(
                $member->user_id,
                'Akun Terverifikasi 🎉',
                'Selamat! Akun anggota perpustakaan Anda telah berhasil diverifikasi dan disetujui oleh Petugas.',
                '/dashboard',
                'success'
            );
        } catch (\Exception $e) {
            Log::warning("Gagal mengirim notifikasi lonceng ke user: " . $e->getMessage());
        }

        return redirect()->route('petugas.members.index', ['tab' => 'pending'])
            ->with('success', 'Akun anggota "' . $member->name . '" berhasil diverifikasi dan disetujui. Email konfirmasi telah dikirim.');
    }

    /**
     * Ditolak (Reject) pendaftaran anggota & Hapus data (Clean Delete).
     */
    public function reject(Request $request, User $member)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ], [
            'reason.required' => 'Alasan penolakan wajib diisi agar pendaftar mengetahui penyebabnya.',
        ]);

        $userName = $member->name;
        $userEmail = $member->email;
        $reason = $request->reason;

        // Kirim Email Notifikasi Penolakan SEBELUM data dihapus
        try {
            Mail::to($userEmail)->send(new MemberRejectedMail($userName, $reason));
            Log::info("Email penolakan verifikasi terkirim ke {$userEmail}");
        } catch (\Exception $e) {
            Log::warning("Gagal mengirim email penolakan verifikasi ke {$userEmail}: " . $e->getMessage());
        }

        // Hapus file foto KTM dari storage jika ada
        if (!empty($member->foto_ktm) && Storage::disk('public')->exists($member->foto_ktm)) {
            Storage::disk('public')->delete($member->foto_ktm);
        }

        // Hapus data pengguna dari database (Clean Delete)
        $member->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Menolak & menghapus pendaftaran anggota: ' . $userName . ' (' . $userEmail . '). Alasan: ' . $reason,
        ]);

        return redirect()->route('petugas.members.index', ['tab' => 'pending'])
            ->with('success', 'Pendaftaran anggota "' . $userName . '" berhasil ditolak. Email pemberitahuan telah dikirim dan data telah dibersihkan.');
    }

    /**
     * Stream file foto KTM untuk modal preview.
     */
    public function viewKtm(User $member)
    {
        if (empty($member->foto_ktm) || !Storage::disk('public')->exists($member->foto_ktm)) {
            abort(404, 'File foto KTM tidak ditemukan.');
        }

        return Storage::disk('public')->response($member->foto_ktm);
    }
}
