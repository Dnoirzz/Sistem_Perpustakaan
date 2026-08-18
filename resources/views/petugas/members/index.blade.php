<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Anggota - SIPUS PSDKU POLNEP</title>
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
    <main class="ml-64 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('petugas.layouts.header', [
            'title' => 'Kelola Anggota Perpustakaan',
            'subtitle' => 'Daftarkan, perbarui profil, dan verifikasi pendaftaran anggota mahasiswa & dosen.'
        ])

        <!-- Alert Section -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-250 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div class="font-semibold">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 p-4 bg-amber-50 border border-amber-250 rounded-2xl flex items-center gap-3 text-amber-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-amber-600">warning</span>
                <div class="font-semibold">{{ session('warning') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-250 rounded-2xl flex items-center gap-3 text-rose-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <div class="font-semibold">{{ session('error') }}</div>
            </div>
        @endif

        <!-- TAB NAVIGATION & ACTION BAR -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div class="flex gap-4">
                <a href="{{ route('petugas.members.index', ['tab' => 'verified']) }}" 
                   class="px-6 py-3 rounded-2xl font-bold text-sm transition-all flex items-center gap-2 {{ $tab !== 'pending' ? 'bg-primary text-white shadow-sm' : 'bg-white border border-outline-variant/100 text-on-surface-variant hover:bg-slate-50 hover:text-primary' }}">
                    <span class="material-symbols-outlined text-[18px]">verified_user</span>
                    Anggota Terverifikasi
                </a>

                <a href="{{ route('petugas.members.index', ['tab' => 'pending']) }}" 
                   class="px-6 py-3 rounded-2xl font-bold text-sm transition-all flex items-center gap-2 {{ $tab === 'pending' ? 'bg-primary text-white shadow-sm' : 'bg-white border border-outline-variant/100 text-on-surface-variant hover:bg-slate-50 hover:text-primary' }}">
                    <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
                    Verifikasi Pendaftaran
                    @if($pendingCount > 0)
                        <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full {{ $tab === 'pending' ? 'bg-amber-400 text-slate-900' : 'bg-amber-500 text-white' }} shadow-xs">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Tambah Anggota Button -->
            <a href="{{ route('petugas.members.create') }}" class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-primary text-white font-bold text-sm shadow-sm hover:bg-opacity-80 transition-all">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
                Tambah Anggota Baru
            </a>
        </div>

        <!-- Filter & Search Section -->
        <section class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm mb-8">
            <form action="{{ route('petugas.members.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="hidden" name="tab" value="{{ $tab }}">
                
                <!-- Search query -->
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input type="text" name="search" placeholder="Cari nama, NIM, NIP, atau email..." class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold" value="{{ request('search') }}"/>
                </div>

                <!-- Role Filter -->
                <div>
                    <select name="role_id" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
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
                    <select name="prodi_id" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
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
                    <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-80 transition-all shadow-sm">
                        Terapkan
                    </button>
                    @if(request()->filled('search') || request()->filled('role_id') || request()->filled('prodi_id'))
                        <a href="{{ route('petugas.members.index', ['tab' => $tab]) }}" class="py-3 px-6 rounded-2xl border border-outline-variant/100 text-on-surface-variant hover:bg-slate-50 font-bold text-xs transition-all text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>

        @if($tab === 'pending')
            <!-- TAB 2: UNVERIFIED / PENDING MEMBERS TABLE -->
            <div class="mb-4 p-4 rounded-2xl bg-amber-50 border border-amber-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-amber-600 text-2xl">pending_actions</span>
                    <div>
                        <h2 class="font-bold text-sm text-slate-800">Antrian Verifikasi Anggota Mandiri</h2>
                        <p class="text-xs text-slate-600">Periksa foto Kartu Tanda Mahasiswa (KTM) / Kartu Identitas dan setujui atau tolak akun pendaftar.</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-amber-100 text-amber-900 border border-amber-300 text-xs font-extrabold rounded-full whitespace-nowrap">
                    {{ $members->total() }} Menunggu Akses
                </span>
            </div>

            <x-table :pagination="$members->hasPages() ? $members->links() : null">
                <x-slot name="headers">
                    <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700">Calon Anggota</th>
                    <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700">Program Studi</th>
                    <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700">Bukti Identitas</th>
                    <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-center text-slate-700 w-36">Aksi Verifikasi</th>
                </x-slot>

                @forelse($members as $m)
                    <tr class="even:bg-slate-50/40 hover:bg-amber-50/30 transition-colors duration-150 group border-b border-slate-100">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-2xl bg-amber-100 text-amber-800 font-bold flex items-center justify-center text-xs uppercase border border-amber-200 shrink-0">
                                    {{ substr($m->name, 0, 2) }}
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-amber-800 transition-colors truncate">{{ $m->name }}</span>
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-extrabold uppercase {{ $m->isMahasiswa() ? 'bg-sky-100 text-sky-800 border border-sky-200' : 'bg-purple-100 text-purple-800 border border-purple-200' }}">
                                            {{ $m->role->role_name ?? '-' }}
                                        </span>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-medium truncate">
                                        @if($m->isMahasiswa())
                                            NIM: {{ $m->mahasiswa->nim ?? '-' }}
                                        @elseif($m->isDosen())
                                            NIP: {{ $m->dosen->nip ?? '-' }}
                                        @endif
                                        • {{ $m->email }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-xs text-slate-800 font-bold truncate block">
                                @if($m->isMahasiswa())
                                    {{ $m->mahasiswa->prodi->nama_prodi ?? '-' }}
                                @elseif($m->isDosen())
                                    {{ $m->dosen->prodi->nama_prodi ?? '-' }}
                                @else
                                    -
                                @endif
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            @if(!empty($m->foto_ktm))
                                <button type="button" 
                                        onclick="previewKtm('{{ route('petugas.members.ktm', $m->user_id) }}', '{{ e($m->name) }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all border border-slate-200">
                                    <span class="material-symbols-outlined text-[16px]">badge</span>
                                    Lihat Identitas
                                </button>
                            @else
                                <span class="text-xs text-slate-400 italic">Tanpa Berkas</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <form action="{{ route('petugas.members.approve', $m->user_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui akun {{ e($m->name) }}?')">
                                    @csrf
                                    <button type="submit" title="Setujui Pendaftaran" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1 active:scale-95">
                                        <span class="material-symbols-outlined text-[16px]">check</span>
                                    </button>
                                </form>

                                <button type="button" 
                                        title="Tolak Pendaftaran"
                                        onclick="openRejectModal('{{ $m->user_id }}', '{{ e($m->name) }}')"
                                        class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold rounded-xl transition-all flex items-center gap-1 active:scale-95">
                                    <span class="material-symbols-outlined text-[16px]">close</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center">
                            <span class="material-symbols-outlined text-slate-300 text-5xl mb-2">verified</span>
                            <p class="font-bold text-slate-700 text-sm">Tidak Ada Antrian Verifikasi</p>
                            <p class="text-xs text-slate-400">Seluruh pendaftaran anggota baru telah terverifikasi.</p>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        @else
            <!-- TAB 1: VERIFIED ACTIVE MEMBERS TABLE -->
            <x-table :pagination="$members->hasPages() ? $members->links() : null">
                <x-slot name="headers">
                    <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700">Anggota</th>
                    <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700">Kontak</th>
                    <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700">Program Studi</th>
                    <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-center text-slate-700 w-32">Aksi</th>
                </x-slot>

                @forelse($members as $m)
                    <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group border-b border-slate-100">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-teal-700 text-xs uppercase border border-outline-variant/100 shrink-0">
                                    {{ substr($m->name, 0, 2) }}
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-teal-700 transition-colors truncate">{{ $m->name }}</span>
                                        @if($m->role->role_name === 'mahasiswa')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-[9px] font-extrabold tracking-wide">
                                                Mahasiswa
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200 text-[9px] font-extrabold tracking-wide">
                                                Dosen
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-slate-500 font-bold tracking-wider">
                                        @if($m->role->role_name === 'mahasiswa')
                                            NIM: {{ $m->mahasiswa->nim ?? '-' }}
                                        @else
                                            NIP: {{ $m->dosen->nip ?? '-' }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="px-5 py-3.5 text-xs text-slate-700">
                            <div class="flex flex-col min-w-0">
                                <span class="font-bold text-xs text-slate-900 truncate">{{ $m->email }}</span>
                                <span class="text-[10px] text-slate-500 font-medium truncate">{{ $m->no_hp ?? '-' }}</span>
                            </div>
                        </td>

                        <td class="px-5 py-3.5">
                            <span class="font-bold text-xs text-slate-800 truncate block">
                                @if($m->role->role_name === 'mahasiswa')
                                    {{ $m->mahasiswa->prodi->nama_prodi ?? 'Prodi' }}
                                @else
                                    {{ $m->dosen->prodi->nama_prodi ?? 'Prodi' }}
                                @endif
                            </span>
                        </td>

                        <td class="px-5 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('petugas.members.show', $m->user_id) }}" class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 flex items-center justify-center transition-all active:scale-95" title="Lihat Detail">
                                    <span class="material-symbols-outlined text-[17px]">visibility</span>
                                </a>

                                <a href="{{ route('petugas.members.edit', $m->user_id) }}" class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-600 hover:text-white hover:border-amber-600 flex items-center justify-center transition-all active:scale-95" title="Edit Anggota">
                                    <span class="material-symbols-outlined text-[17px]">edit</span>
                                </a>
                                
                                <form action="{{ route('petugas.members.destroy', $m->user_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini? Seluruh data sirkulasi dan log terkait anggota ini akan hilang.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-600 hover:text-white hover:border-rose-600 flex items-center justify-center transition-all active:scale-95" title="Hapus Anggota">
                                        <span class="material-symbols-outlined text-[17px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center text-slate-500 font-medium">Data anggota perpustakaan tidak ditemukan.</td>
                    </tr>
                @endforelse
            </x-table>
        @endif
    </main>

    <!-- MODAL PREVIEW KTM -->
    <div id="modal-ktm" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 shadow-2xl space-y-4 my-auto relative">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-2xl">badge</span>
                    <h3 class="font-bold text-base text-slate-800" id="ktm-modal-title">Pratinjau Foto KTM</h3>
                </div>
                <button type="button" onclick="closeKtmModal()" class="text-slate-400 hover:text-slate-600 rounded-full p-1 transition-colors">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="bg-slate-100 rounded-2xl overflow-hidden min-h-[250px] flex items-center justify-center border border-slate-200">
                <img id="ktm-img" src="" alt="Foto KTM" class="max-h-[70vh] w-auto object-contain rounded-xl shadow-sm" />
            </div>
            <div class="flex justify-end pt-2">
                <button type="button" onclick="closeKtmModal()" class="px-5 py-2.5 bg-slate-800 text-white font-bold text-xs rounded-xl hover:bg-slate-900 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL ALASAN PENOLAKAN -->
    <div id="modal-reject" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-5 my-auto relative">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2 text-rose-600">
                    <span class="material-symbols-outlined text-2xl">cancel</span>
                    <h3 class="font-bold text-base text-slate-800">Tolak Pendaftaran</h3>
                </div>
                <button type="button" onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600 rounded-full p-1 transition-colors">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <form id="reject-form" method="POST" action="" class="space-y-4">
                @csrf
                <p class="text-xs text-slate-600 leading-relaxed">
                    Menolak pendaftaran calon anggota <strong id="reject-user-name" class="text-slate-800"></strong>. 
                    Pesan alasan penolakan ini akan dikirimkan ke email pendaftar, dan data pendaftaran akan dibersihkan agar calon anggota dapat mendaftar ulang.
                </p>

                <div class="space-y-1.5">
                    <label for="reject-reason" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Alasan Penolakan <span class="text-rose-500">*</span></label>
                    <textarea id="reject-reason" 
                              name="reason" 
                              rows="3" 
                              required 
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500 resize-none" 
                              placeholder="Misal: Foto KTM yang diunggah kurang jelas/buram. Silakan daftar kembali dengan foto KTM yang valid."></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                        Tolak & Kirim Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewKtm(url, name) {
            document.getElementById('ktm-modal-title').textContent = 'Foto KTM: ' + name;
            document.getElementById('ktm-img').src = url;
            document.getElementById('modal-ktm').classList.remove('hidden');
        }

        function closeKtmModal() {
            document.getElementById('modal-ktm').classList.add('hidden');
            document.getElementById('ktm-img').src = '';
        }

        function openRejectModal(userId, name) {
            const form = document.getElementById('reject-form');
            form.action = "{{ url('petugas/members') }}/" + userId + "/reject";
            document.getElementById('reject-user-name').textContent = name;
            document.getElementById('reject-reason').value = '';
            document.getElementById('modal-reject').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('modal-reject').classList.add('hidden');
        }
    </script>
</body>
</html>
