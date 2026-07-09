<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Detail Anggota - SIPUS PSDKU POLNEP</title>
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
    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen space-y-8">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('petugas.members.index') }}" class="w-10 h-10 rounded-2xl bg-white border border-outline-variant/30 flex items-center justify-center hover:bg-slate-50 transition-all shadow-sm" title="Kembali ke Daftar Anggota">
                    <span class="material-symbols-outlined text-[20px] text-on-surface">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-headline-md text-on-surface">Profil & Riwayat Anggota</h1>
                    <p class="text-sm text-outline">Informasi akademis, peminjaman aktif, dan histori baca digital.</p>
                </div>
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

        <!-- Member Profile Overview Card -->
        <section class="bg-white rounded-3xl border border-outline-variant/10 shadow-sm p-8 flex flex-col md:flex-row items-center md:items-start gap-8">
            <div class="w-24 h-24 rounded-3xl bg-slate-100 flex-shrink-0 flex items-center justify-center border-2 border-primary/20 shadow-md">
                <span class="text-3xl font-black text-primary uppercase">{{ substr($member->name, 0, 2) }}</span>
            </div>
            <div class="flex-1 text-center md:text-left space-y-4">
                <div>
                    <h2 class="text-2xl font-bold text-on-surface flex flex-col md:flex-row md:items-center gap-3 justify-center md:justify-start">
                        {{ $member->name }}
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider w-max mx-auto md:mx-0 shadow-sm
                            @if($member->role->role_name === 'mahasiswa') bg-emerald-50 text-emerald-700 @else bg-amber-50 text-amber-700 @endif">
                            {{ $member->role->role_name }}
                        </span>
                    </h2>
                    <p class="text-sm text-outline font-semibold mt-1">ID Pengguna: #{{ $member->user_id }}</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 pt-4 border-t border-outline-variant/10">
                    <div>
                        <span class="block text-[10px] font-bold text-outline uppercase tracking-wider">
                            @if($member->role->role_name === 'mahasiswa') Nomor Induk Mahasiswa (NIM) @else Nomor Induk Pegawai (NIP) @endif
                        </span>
                        <span class="font-bold text-sm text-on-surface-variant">
                            @if($member->role->role_name === 'mahasiswa') {{ $member->mahasiswa->nim ?? '-' }} @else {{ $member->dosen->nip ?? '-' }} @endif
                        </span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-outline uppercase tracking-wider">Program Studi</span>
                        <span class="font-bold text-sm text-on-surface-variant">
                            @if($member->role->role_name === 'mahasiswa') {{ $member->mahasiswa->prodi->nama_prodi ?? '-' }} @else {{ $member->dosen->prodi->nama_prodi ?? '-' }} @endif
                        </span>
                    </div>
                    @if($member->role->role_name === 'mahasiswa')
                        <div>
                            <span class="block text-[10px] font-bold text-outline uppercase tracking-wider">Semester Aktif</span>
                            <span class="font-bold text-sm text-on-surface-variant">Semester {{ $member->mahasiswa->semester ?? '-' }}</span>
                        </div>
                    @else
                        <div>
                            <span class="block text-[10px] font-bold text-outline uppercase tracking-wider">Jabatan Akademis</span>
                            <span class="font-bold text-sm text-on-surface-variant">Tenaga Pengajar / Dosen</span>
                        </div>
                    @endif
                    <div>
                        <span class="block text-[10px] font-bold text-outline uppercase tracking-wider">Email</span>
                        <span class="font-semibold text-xs text-on-surface-variant flex items-center gap-1 justify-center md:justify-start">
                            <span class="material-symbols-outlined text-[16px] text-outline">mail</span>
                            {{ $member->email }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-[10px] font-bold text-outline uppercase tracking-wider">Nomor HP</span>
                        <span class="font-semibold text-xs text-on-surface-variant flex items-center gap-1 justify-center md:justify-start">
                            <span class="material-symbols-outlined text-[16px] text-emerald-500">phone</span>
                            {{ $member->no_hp ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Two Section Stack -->
        <div class="grid grid-cols-1 gap-8">
            
            <!-- Section 1: Active Borrowings -->
            <section class="bg-white rounded-3xl border border-outline-variant/10 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-outline-variant/10 flex justify-between items-center">
                    <div>
                        <h3 class="font-headline-md text-on-surface text-lg">Peminjaman Buku Aktif</h3>
                        <p class="text-xs text-outline mt-1">Daftar buku fisik yang saat ini sedang dipinjam</p>
                    </div>
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-sm font-bold text-primary">{{ $activeLoans->count() }}</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50 border-b border-outline-variant/10 text-outline-variant text-xs font-bold uppercase tracking-wider">
                                <th class="py-4 px-8">Judul Buku</th>
                                <th class="py-4 px-6">Tanggal Pinjam</th>
                                <th class="py-4 px-6">Batas Waktu</th>
                                <th class="py-4 px-6 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10 text-sm text-slate-700">
                            @forelse($activeLoans as $loan)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-5 px-8">
                                        <div class="font-bold text-on-surface text-sm">
                                            {{ $loan->collection?->display_title ?? 'Buku tidak ditemukan' }}
                                        </div>
                                        <div class="text-[10px] text-outline mt-0.5">Penulis: {{ $loan->collection?->book?->author ?? '-' }}</div>
                                    </td>
                                    <td class="py-5 px-6 font-semibold text-slate-700">
                                        {{ $loan->tgl_pinjam->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-5 px-6 font-semibold text-slate-700">
                                        {{ $loan->bts_waktu->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm
                                            @if($loan->status === 'terlambat') bg-rose-50 text-rose-700 @else bg-cyan-50 text-cyan-700 @endif">
                                            {{ $loan->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-outline font-medium">Tidak ada peminjaman buku</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Section 2: Combined History -->
            <section class="bg-white rounded-3xl border border-outline-variant/10 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-outline-variant/10 flex justify-between items-center">
                    <div>
                        <h3 class="font-headline-md text-on-surface text-lg">Riwayat Pengguna</h3>
                        <p class="text-xs text-outline mt-1">Histori peminjaman buku fisik dan log pembacaan arsip digital.</p>
                    </div>
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-sm font-bold text-primary">{{ $history->count() }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/50 border-b border-outline-variant/10 text-outline-variant text-xs font-bold uppercase tracking-wider">
                                <th class="py-4 px-8">Jenis Riwayat</th>
                                <th class="py-4 px-8">Judul Koleksi / Arsip</th>
                                <th class="py-4 px-6">Mulai Pinjam / Baca</th>
                                <th class="py-4 px-6">Selesai / Kembali</th>
                                <th class="py-4 px-8">Keterangan / Kondisi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10 text-sm text-slate-700">
                            @forelse($history as $item)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <!-- History Type Badge -->
                                    <td class="py-5 px-8">
                                        @if($item['tipe_riwayat'] === 'fisik')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-bold uppercase tracking-wider">
                                                <span class="material-symbols-outlined text-[14px]">menu_book</span>
                                                Buku Fisik
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-teal-50 text-teal-700 text-[10px] font-bold uppercase tracking-wider">
                                                <span class="material-symbols-outlined text-[14px]">picture_as_pdf</span>
                                                Arsip Digital
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <!-- Title & Author -->
                                    <td class="py-5 px-8">
                                        <div class="font-bold text-on-surface text-sm max-w-sm truncate" title="{{ $item['judul'] }}">
                                            {{ $item['judul'] }}
                                        </div>
                                        <div class="text-[10px] text-outline mt-0.5">{{ $item['penulis'] }}</div>
                                    </td>

                                    <!-- Date Start -->
                                    <td class="py-5 px-6 font-semibold text-slate-700">
                                        {{ $item['tgl_pinjam'] ? $item['tgl_pinjam']->translatedFormat('d M Y, H:i') : '-' }}
                                    </td>

                                    <!-- Date End -->
                                    <td class="py-5 px-6 font-semibold text-slate-700">
                                        {{ $item['tgl_kembali'] ? $item['tgl_kembali']->translatedFormat('d M Y, H:i') : '-' }}
                                    </td>

                                    <!-- Condition / Lateness / Keterangan -->
                                    <td class="py-5 px-8">
                                        @if($item['tipe_riwayat'] === 'fisik')
                                            <div class="flex flex-col gap-0.5">
                                                <span class="font-bold text-xs @if($item['status_kondisi'] === 'bermasalah') text-rose-600 @else text-emerald-600 @endif">
                                                    {{ $item['keterangan'] }}
                                                </span>
                                                @if($item['catatan'])
                                                    <span class="text-[10px] text-outline italic">Catatan: "{{ $item['catatan'] }}"</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="font-bold text-xs text-teal-600">
                                                {{ $item['keterangan'] }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-outline font-medium">Belum ada riwayat aktivitas peminjaman atau pembacaan online.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>
</body>
</html>
