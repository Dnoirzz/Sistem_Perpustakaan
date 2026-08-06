<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola User - SIPUS PSDKU POLNEP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-background": "#131b2e",
                        "surface": "#faf8ff",
                        "outline": "#777587",
                        "on-tertiary-fixed": "#40000d",
                        "secondary-fixed": "#6ffbbe",
                        "secondary-fixed-dim": "#4edea3",
                        "on-tertiary": "#ffffff",
                        "outline-variant": "#c7c4d8",
                        "surface-container-highest": "#dae2fd",
                        "surface-container-high": "#e2e7ff",
                        "on-error": "#ffffff",
                        "background": "#faf8ff",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-secondary-fixed": "#002113",
                        "tertiary-fixed-dim": "#ffb2b7",
                        "surface-variant": "#dae2fd",
                        "surface-container": "#eaedff",
                        "secondary-container": "#6cf8bb",
                        "secondary": "#006c49",
                        "tertiary": "#95002b",
                        "tertiary-fixed": "#ffdadb",
                        "primary": "#00a5c0", /* POLNEP Brand Turquoise */
                        "on-primary-container": "#dad7ff",
                        "surface-dim": "#d2d9f4",
                        "tertiary-container": "#bf0f3c",
                        "on-tertiary-fixed-variant": "#92002a",
                        "error-container": "#ffdad6",
                        "inverse-on-surface": "#eef0ff",
                        "on-secondary-fixed-variant": "#005236",
                        "surface-bright": "#faf8ff",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#131b2e",
                        "surface-tint": "#00a5c0",
                        "on-primary-fixed-variant": "#007b91",
                        "inverse-surface": "#283044",
                        "surface-container-low": "#f2f3ff",
                        "error": "#ba1a1a",
                        "on-surface-variant": "#464555",
                        "primary-fixed": "#e2dfff",
                        "on-secondary-container": "#00714d",
                        "primary-container": "#00a5c0",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-primary-fixed": "#0f0069",
                        "on-tertiary-container": "#ffd0d2",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#c3c0ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-max": "1280px",
                        "base": "8px",
                        "margin-mobile": "16px",
                        "gutter": "24px",
                        "margin-desktop": "40px"
                    },
                    "fontFamily": {
                        "headline-md": ["Outfit"],
                        "label-md": ["Inter"],
                        "display-lg": ["Outfit"],
                        "caption": ["Inter"],
                        "headline-lg": ["Outfit"],
                        "headline-lg-mobile": ["Outfit"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"]
                    },
                    "fontSize": {
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "caption": ["12px", {"lineHeight": "16px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 231, 255, 0.5);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f8faff;
            color: #131b2e;
        }
        .sidebar-active {
            background-color: #00a5c0; /* POLNEP Turquoise */
            color: white;
            box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2);
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #c7c4d8;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #b1afc2;
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen flex">
    @include('admin.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Kelola User',
            'subtitle' => 'Kelola data seluruh akun pengguna sirkulasi perpustakaan (Mahasiswa, Dosen, Petugas, Admin).'
        ])

        <!-- Success Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-3xl flex items-center gap-3 shadow-sm shadow-emerald-50">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Search & Filters -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm">
                <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <!-- Search Input -->
                    <div class="md:col-span-5">
                        <label for="search" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pencarian</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                            </span>
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ $search }}" 
                                   class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="Cari nama, email, NIM, NIP..." />
                        </div>
                    </div>

                    <!-- Role Filter -->
                    <div class="md:col-span-4">
                        <label for="role_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Filter Role</label>
                        <select id="role_id" 
                                name="role_id" 
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm">
                            <option value="">Semua Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->role_id }}" {{ $roleId == $role->role_id ? 'selected' : '' }}>
                                    {{ strtoupper($role->role_name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit / Reset Buttons -->
                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit" 
                                class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-2xl text-sm transition duration-200 flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                            Terapkan
                        </button>
                        @if($search || $roleId)
                            <a href="{{ route('admin.users.index') }}" 
                               class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-sm transition duration-200 flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Action Bar -->
            <div class="flex justify-between items-center bg-white px-8 py-4 rounded-3xl border border-outline-variant/100 shadow-sm">
                <div class="text-sm font-semibold text-outline">
                    Menampilkan total <span class="text-primary font-bold">{{ $users->total() }}</span> user
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.users.import.form') }}" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-emerald-600/20 transition duration-200 flex items-center gap-2 transform hover:-translate-y-0.5 active:translate-y-0">
                        <span class="material-symbols-outlined text-[20px]">upload_file</span>
                        Import Excel
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="px-5 py-3 bg-primary hover:bg-primary/95 text-white text-sm font-bold rounded-2xl shadow-lg shadow-primary/20 transition duration-200 flex items-center gap-2 transform hover:-translate-y-0.5 active:translate-y-0">
                        <span class="material-symbols-outlined text-[20px]">person_add</span>
                        Tambah User Baru
                    </a>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-3xl border border-outline-variant/100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50 border-b border-outline-variant/100 text-outline-variant text-xs font-bold uppercase tracking-wider">
                                <th class="py-4.5 px-8">Nama / Email</th>
                                <th class="py-4.5 px-6">Nomor HP</th>
                                <th class="py-4.5 px-6">Role</th>
                                <th class="py-4.5 px-6">Detail Data</th>
                                <th class="py-4.5 px-8 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10 text-sm text-slate-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-5 px-8">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase shadow-sm">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-on-surface text-base">{{ $user->name }}</span>
                                                <span class="text-outline text-xs mt-0.5">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 px-6">
                                        @if(empty($user->no_hp))
                                            <span class="text-outline-variant italic text-xs">Belum diisi</span>
                                        @else
                                            <div class="font-medium text-slate-800 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-emerald-500 text-[18px]">phone</span>
                                                {{ $user->no_hp }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-5 px-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm
                                            @if($user->role->role_name === 'admin') bg-indigo-50 text-indigo-700
                                            @elseif($user->role->role_name === 'petugas') bg-rose-50 text-rose-700
                                            @elseif($user->role->role_name === 'dosen') bg-amber-50 text-amber-700
                                            @else bg-emerald-50 text-emerald-700 @endif">
                                            {{ $user->role->role_name }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-6">
                                        @if($user->role->role_name === 'mahasiswa' && $user->mahasiswa)
                                            <div class="space-y-0.5 text-xs">
                                                <div><span class="text-outline">NIM:</span> <span class="font-semibold text-on-surface">{{ $user->mahasiswa->nim }}</span></div>
                                                <div><span class="text-outline">Prodi:</span> <span class="text-on-surface-variant font-medium">{{ $user->mahasiswa->prodi->nama_prodi ?? '-' }}</span></div>
                                                <div><span class="text-outline">Semester:</span> <span class="text-on-surface-variant font-medium">Semester {{ $user->mahasiswa->semester }}</span></div>
                                            </div>
                                        @elseif($user->role->role_name === 'dosen' && $user->dosen)
                                            <div class="space-y-0.5 text-xs">
                                                <div><span class="text-outline">NIP:</span> <span class="font-semibold text-on-surface">{{ $user->dosen->nip }}</span></div>
                                                <div><span class="text-outline">Prodi:</span> <span class="text-on-surface-variant font-medium">{{ $user->dosen->prodi->nama_prodi ?? '-' }}</span></div>
                                            </div>
                                        @elseif($user->role->role_name === 'petugas' && $user->petugas)
                                            <div class="space-y-0.5 text-xs">
                                                <div><span class="text-outline">NIP:</span> <span class="font-semibold text-on-surface">{{ $user->petugas->nip }}</span></div>
                                                <div><span class="text-outline">Jabatan:</span> <span class="text-on-surface-variant font-medium">{{ $user->petugas->jabatan ?? '-' }}</span></div>
                                            </div>
                                        @else
                                            <span class="text-outline-variant italic text-xs">Tidak ada data tambahan</span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-8">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Edit -->
                                            <a href="{{ route('admin.users.edit', $user->user_id) }}" 
                                               class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-primary/10 text-slate-600 hover:text-primary flex items-center justify-center transition duration-200"
                                               title="Edit User">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </a>
                                            <!-- Delete -->
                                            @if(Auth::user()->user_id !== $user->user_id)
                                                <form action="{{ route('admin.users.destroy', $user->user_id) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Semua data terkait (profil, peminjaman, denda) akan terhapus.');"
                                                      class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-650 hover:text-rose-600 flex items-center justify-center transition duration-200"
                                                            title="Hapus User">
                                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-outline font-medium">User tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="px-8 py-4 border-t border-outline-variant/100 bg-slate-50/50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
