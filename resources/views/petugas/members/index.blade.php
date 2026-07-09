<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Anggota - SIPUS PSDKU POLNEP</title>
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
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Kelola Anggota Perpustakaan</h1>
                <p class="text-sm text-outline">Daftarkan dan perbarui profil keanggotaan mahasiswa dan dosen.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">{{ Auth::user()->petugas?->jabatan ?? 'Petugas Perpustakaan' }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
                </div>
            </div>
        </header>

        <!-- Alert Section -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-250 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div class="font-semibold">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-250 rounded-2xl flex items-center gap-3 text-rose-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <div class="font-semibold">{{ session('error') }}</div>
            </div>
        @endif

        <!-- Action Bar: Add button -->
        <div class="flex justify-end gap-4 mb-8">
            <a href="{{ route('petugas.members.create') }}" class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-primary text-white font-bold text-sm shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                Tambah Anggota Baru
            </a>
        </div>

        <!-- Filter & Search Section -->
        <section class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm mb-8">
            <form action="{{ route('petugas.members.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search query -->
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input type="text" name="search" placeholder="Cari nama, NIM, atau NIP..." class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold" value="{{ request('search') }}"/>
                </div>

                <!-- Role Filter -->
                <div>
                    <select name="role_id" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                        <option value="">Semua Anggota</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->role_id }}" {{ request('role_id') == $r->role_id ? 'selected' : '' }}>
                                {{ ucfirst($r->role_name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Prodi Filter -->
                <div>
                    <select name="prodi_id" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                        <option value="">Semua Program Studi</option>
                        @foreach($prodis as $p)
                            <option value="{{ $p->prodi_id }}" {{ request('prodi_id') == $p->prodi_id ? 'selected' : '' }}>
                                {{ $p->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Button -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-95 transition-all">
                        Terapkan
                    </button>
                    @if(request()->filled('search') || request()->filled('role_id') || request()->filled('prodi_id'))
                        <a href="{{ route('petugas.members.index') }}" class="py-3 px-6 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-xs transition-all text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>

        <!-- Members Table -->
        <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden font-body-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Nama & ID Anggota</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Akun / Kontak</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Peran</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Detail Akademis</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs text-center uppercase tracking-widest w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($members as $m)
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <!-- Name Column -->
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase border border-outline-variant/10 shadow-sm">
                                            {{ substr($m->name, 0, 2) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-on-surface text-sm">{{ $m->name }}</span>
                                            <span class="text-[10px] text-outline font-bold tracking-wider">
                                                @if($m->role->role_name === 'mahasiswa')
                                                    NIM: {{ $m->mahasiswa->nim ?? '-' }}
                                                @else
                                                    NIP: {{ $m->dosen->nip ?? '-' }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact Column -->
                                <td class="px-8 py-5 text-sm text-on-surface-variant">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-xs">{{ $m->email }}</span>
                                        <span class="text-[10px] text-outline mt-0.5 font-medium">{{ $m->no_hp ?? '-' }}</span>
                                    </div>
                                </td>

                                <!-- Role Column -->
                                <td class="px-8 py-5">
                                    @if($m->role->role_name === 'mahasiswa')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">
                                            Mahasiswa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wider">
                                            Dosen
                                        </span>
                                    @endif
                                </td>

                                <!-- Academic Details -->
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        @if($m->role->role_name === 'mahasiswa')
                                            <span class="font-bold text-xs text-on-surface-variant">{{ $m->mahasiswa->prodi->nama_prodi ?? 'Prodi' }}</span>
                                            <span class="text-[10px] text-outline mt-0.5 font-bold uppercase">Semester {{ $m->mahasiswa->semester ?? '-' }}</span>
                                        @else
                                            <span class="font-bold text-xs text-on-surface-variant">{{ $m->dosen->prodi->nama_prodi ?? 'Prodi' }}</span>
                                            <span class="text-[10px] text-outline mt-0.5 font-bold uppercase">Pengajar / Dosen</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-8 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- History button -->
                                        <a href="{{ route('petugas.members.show', $m->user_id) }}" class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 hover:bg-indigo-100 flex items-center justify-center transition-all" title="Lihat Detail">
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        </a>

                                        <!-- Edit button -->
                                        <a href="{{ route('petugas.members.edit', $m->user_id) }}" class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center transition-all" title="Edit Anggota">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>
                                        
                                        <!-- Delete form -->
                                        <form action="{{ route('petugas.members.destroy', $m->user_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini? Seluruh data sirkulasi dan log terkait anggota ini akan hilang.')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-all" title="Hapus Anggota">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-10 text-center text-outline font-medium">Data anggota perpustakaan tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($members->hasPages())
                <div class="p-6 border-t border-outline-variant/10 bg-slate-50/50">
                    {{ $members->links() }}
                </div>
            @endif
        </section>
    </main>
</body>
</html>
