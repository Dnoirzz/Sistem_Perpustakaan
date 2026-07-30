<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Katalog Arsip - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }],
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "caption": ["12px", { "lineHeight": "16px", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "600" }],
                        "headline-lg-mobile": ["28px", { "lineHeight": "36px", "fontWeight": "600" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
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
    @if(Auth::check())
        @include($rolePrefix . '.layouts.sidebar')
    @endif
    
    <main class="{{ Auth::check() ? 'ml-64' : 'max-w-7xl mx-auto' }} p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('welcome') }}" class="w-10 h-10 rounded-xl bg-white text-slate-650 hover:bg-slate-100 transition duration-200 flex items-center justify-center border border-outline-variant/15 shadow-sm" title="Kembali ke Beranda">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </a>
                @endguest
                <div>
                    <h1 class="font-headline-md text-on-surface">Katalog Arsip Digital Publik</h1>
                    <p class="text-sm text-outline">Jelajahi arsip karya tulis mahasiswa yang sudah diverifikasi perpustakaan.</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <div class="text-right hidden sm:block">
                        <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-outline font-medium uppercase tracking-wide">Role: {{ ucfirst($rolePrefix) }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                        <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-5 py-2.5 bg-primary text-white font-bold rounded-2xl text-xs shadow-md shadow-primary/20 hover:bg-primary/95 transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">login</span>
                            <span>Masuk</span>
                        </a>
                        <a href="{{ route('welcome') }}" class="px-4 py-2.5 border border-outline-variant/40 text-on-surface-variant font-bold rounded-2xl text-xs hover:bg-white transition-all">
                            Beranda
                        </a>
                    </div>
                @endauth
            </div>
        </header>

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-700 flex items-center gap-2">
                <span class="material-symbols-outlined text-rose-600">error</span>
                {{ session('error') }}
            </div>
        @endif

        <section class="mb-8 rounded-3xl border border-outline-variant/10 bg-white p-6 shadow-sm">
            <form action="{{ Auth::check() ? route($rolePrefix . '.katalog-arsip.index') : route('katalog-arsip.index') }}" method="GET" class="grid gap-4 md:grid-cols-5">
                <div>
                    <select name="search_by" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                        <option value="all" @selected(request('search_by') === 'all' || !request('search_by'))>Cari Berdasarkan</option>
                        <option value="judul" @selected(request('search_by') === 'judul')>Judul Karya Ilmiah</option>
                        <option value="penulis" @selected(request('search_by') === 'penulis')>Nama Mahasiswa / NIM</option>
                        <option value="pembimbing" @selected(request('search_by') === 'pembimbing')>Dosen Pembimbing</option>
                        <option value="penguji" @selected(request('search_by') === 'penguji')>Dosen Penguji</option>
                        <option value="tempat_pkl" @selected(request('search_by') === 'tempat_pkl')>Tempat PKL</option>
                    </select>
                </div>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-outline text-[20px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kata kunci pencarian" class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold placeholder:truncate transition-all">
                </div>
                <div>
                    <select name="type" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                        <option value="">Semua Jenis</option>
                        @foreach($typeOptions as $typeOption)
                            <option value="{{ $typeOption['value'] }}" @selected(request('type') === $typeOption['value'])>{{ $typeOption['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="prodi_id" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                        <option value="">Semua Prodi</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->prodi_id }}" @selected((string) request('prodi_id') === (string) $prodi->prodi_id)>{{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <input type="number" name="year" value="{{ request('year') }}" placeholder="Tahun" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold transition-all">
                    <button class="flex items-center justify-center gap-1.5 rounded-2xl bg-primary hover:bg-primary/95 text-white font-bold px-6 py-3 text-xs shadow-lg shadow-primary/20 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                        Cari
                    </button>
                </div>
            </form>
        </section>

        <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @forelse($archives as $item)
                <article class="flex flex-col justify-between rounded-3xl border border-outline-variant/10 bg-white p-6 shadow-sm hover:shadow-md transition duration-200">
                    <div>
                        <div class="mb-4 flex items-center justify-between gap-4">
                            <span class="rounded-full bg-primary/10 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-primary">{{ $item['type_label'] }}</span>
                            <span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wide border
                                {{ $item['status'] === 'aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-500/15 text-amber-700 border-amber-500/20' }}">
                                {{ $item['status'] === 'aktif' ? 'Diserahkan' : 'Belum Diserahkan' }}
                            </span>
                        </div>
                        <h2 class="line-clamp-2 text-[17px] font-bold text-on-surface mb-4 leading-snug" style="font-family: Outfit, sans-serif;">{{ $item['title'] }}</h2>
                        
                        <div class="space-y-2 border-t border-outline-variant/10 pt-4 text-xs text-outline font-semibold">
                            <p class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-primary">school</span> 
                                Mahasiswa: <strong class="text-on-surface">{{ $item['mahasiswa_name'] ?? '-' }}</strong>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-primary">domain</span> 
                                Prodi: <span class="text-on-surface">{{ $item['prodi'] ?? '-' }}</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-primary">calendar_month</span> 
                                Tahun Terbit: <span class="text-on-surface">{{ $item['year'] ?? '-' }}</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-primary">person</span> 
                                Pembimbing: <span class="text-on-surface">{{ $item['pembimbing'] ?? '-' }}</span>
                            </p>
                            @if(!empty($item['penguji_1']))
                                <p class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-primary">gavel</span> 
                                    Penguji 1: <span class="text-on-surface">{{ $item['penguji_1'] }}</span>
                                </p>
                            @endif
                            @if(!empty($item['penguji_2']))
                                <p class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-primary">gavel</span> 
                                    Penguji 2: <span class="text-on-surface">{{ $item['penguji_2'] }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-6 border-t border-outline-variant/10 pt-4">
                        <a href="{{ Auth::check() ? route($rolePrefix . '.katalog-arsip.show', [$item['type'], $item['id']]) : route('katalog-arsip.show', [$item['type'], $item['id']]) }}" class="w-full inline-flex items-center justify-center gap-1.5 rounded-2xl bg-primary hover:bg-primary/95 text-white font-bold px-5 py-3.5 text-sm shadow-lg shadow-primary/15 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                            Lihat Detail
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-3xl border border-outline-variant/10 bg-white p-12 text-center text-outline shadow-sm font-semibold">
                    <div class="flex flex-col items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-4xl text-outline-variant">folder_open</span>
                        <span>Arsip tidak ditemukan untuk filter yang dipilih.</span>
                    </div>
                </div>
            @endforelse
        </section>

        @if($archives->hasPages())
            <section class="mt-8 rounded-3xl border border-outline-variant/10 bg-white p-6 shadow-sm">
                {{ $archives->links() }}
            </section>
        @endif
    </main>
</body>
</html>
