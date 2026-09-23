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
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @if(Auth::check())
        @include($rolePrefix . '.layouts.sidebar')
    @endif
    
    <main class="{{ Auth::check() ? 'ml-64' : 'max-w-7xl mx-auto' }} p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Katalog Arsip Digital Publik',
            'subtitle' => 'Jelajahi arsip karya tulis mahasiswa yang sudah diverifikasi perpustakaan.'
        ])

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

        @php
            $catalogRouteName = Auth::check() ? $rolePrefix . '.katalog-arsip.index' : 'katalog-arsip.index';
            $searchByOptions = [
                'judul' => 'Judul Karya Ilmiah',
                'penulis' => 'Nama Mahasiswa / NIM',
                'pembimbing' => 'Dosen Pembimbing',
                'penguji' => 'Dosen Penguji',
                'tempat_pkl' => 'Tempat PKL',
            ];
            $searchPlaceholders = [
                'all' => 'Masukkan judul, nama mahasiswa, dosen, atau prodi',
                'judul' => 'Masukkan judul karya ilmiah',
                'penulis' => 'Masukkan nama mahasiswa atau NIM',
                'pembimbing' => 'Masukkan nama dosen pembimbing',
                'penguji' => 'Masukkan nama dosen penguji',
                'tempat_pkl' => 'Masukkan nama instansi atau tempat PKL',
            ];
            $selectedSearchBy = (string) request('search_by', '');
            $selectedTypeLabel = collect($typeOptions)->firstWhere('value', request('type'))['label'] ?? null;
            $selectedProdi = $prodis->first(fn ($prodi) => (string) $prodi->prodi_id === (string) request('prodi_id'));
            $hasActiveFilters = request()->filled('search')
                || request()->filled('type')
                || request()->filled('prodi_id')
                || request()->filled('year');
        @endphp

        <section class="mb-8 rounded-3xl border border-outline-variant/100 bg-white p-6 shadow-sm">
            <form
                action="{{ route($catalogRouteName) }}"
                method="GET"
                x-data="{ searchBy: @js($selectedSearchBy), placeholders: @js($searchPlaceholders) }"
            >
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div>
                        <label for="search_by" class="sr-only">Cari berdasarkan</label>
                        <select
                            id="search_by"
                            name="search_by"
                            x-model="searchBy"
                            @change="searchBy ? $nextTick(() => $refs.searchInput.focus()) : ($refs.searchInput.value = '', $el.form.submit())"
                            class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all"
                        >
                            <option value="" @selected($selectedSearchBy === '')>Cari berdasarkan</option>
                            @foreach($searchByOptions as $value => $label)
                                <option value="{{ $value }}" @selected($selectedSearchBy === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="archive_type" class="sr-only">Jenis arsip</label>
                        <select id="archive_type" name="type" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                            <option value="">Jenis Arsip</option>
                            @foreach($typeOptions as $typeOption)
                                <option value="{{ $typeOption['value'] }}" @selected(request('type') === $typeOption['value'])>{{ $typeOption['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="archive_prodi" class="sr-only">Program studi</label>
                        <select id="archive_prodi" name="prodi_id" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                            <option value="">Program Studi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->prodi_id }}" @selected((string) request('prodi_id') === (string) $prodi->prodi_id)>{{ $prodi->nama_prodi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="archive_year" class="sr-only">Tahun arsip</label>
                        <select id="archive_year" name="year" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                            <option value="">Tahun Terbit</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" @selected((string) request('year') === (string) $year)>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div
                    x-cloak
                    x-show="searchBy"
                    x-transition.opacity.duration.200ms
                    class="mt-4 border-t border-outline-variant/60 pt-4"
                >
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="relative flex min-w-0 flex-1 items-center">
                            <span class="material-symbols-outlined absolute left-4 text-outline text-[20px]">search</span>
                            <input
                                x-ref="searchInput"
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                :placeholder="placeholders[searchBy] || 'Kata kunci pencarian'"
                                class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold placeholder:truncate transition-all"
                            >
                        </div>
                        <button type="submit" class="flex shrink-0 items-center justify-center gap-1.5 rounded-2xl bg-primary px-7 py-3 text-xs font-bold text-white shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5 hover:bg-primary/95 active:translate-y-0">
                            <span class="material-symbols-outlined text-[18px]">search</span>
                            Cari
                        </button>
                    </div>
                </div>

                @if($hasActiveFilters)
                    <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-outline-variant/60 pt-4">
                        <span class="mr-1 text-[11px] font-bold uppercase tracking-wider text-outline">Filter aktif:</span>

                        @if(request()->filled('search'))
                            <a href="{{ route($catalogRouteName, request()->except(['search', 'search_by', 'page'])) }}" class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-3 py-1.5 text-[11px] font-bold text-primary transition-colors hover:bg-primary/20" title="Hapus pencarian kata kunci">
                                {{ $searchByOptions[$selectedSearchBy] ?? 'Pencarian' }}: {{ request('search') }}
                                <span aria-hidden="true">&times;</span>
                            </a>
                        @endif

                        @if($selectedTypeLabel)
                            <a href="{{ route($catalogRouteName, request()->except(['type', 'page'])) }}" class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-3 py-1.5 text-[11px] font-bold text-primary transition-colors hover:bg-primary/20" title="Hapus filter jenis">
                                {{ $selectedTypeLabel }}
                                <span aria-hidden="true">&times;</span>
                            </a>
                        @endif

                        @if($selectedProdi)
                            <a href="{{ route($catalogRouteName, request()->except(['prodi_id', 'page'])) }}" class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-3 py-1.5 text-[11px] font-bold text-primary transition-colors hover:bg-primary/20" title="Hapus filter program studi">
                                {{ $selectedProdi->nama_prodi }}
                                <span aria-hidden="true">&times;</span>
                            </a>
                        @endif

                        @if(request()->filled('year'))
                            <a href="{{ route($catalogRouteName, request()->except(['year', 'page'])) }}" class="inline-flex items-center gap-1 rounded-full border border-primary/20 bg-primary/10 px-3 py-1.5 text-[11px] font-bold text-primary transition-colors hover:bg-primary/20" title="Hapus filter tahun">
                                Tahun {{ request('year') }}
                                <span aria-hidden="true">&times;</span>
                            </a>
                        @endif

                        <a href="{{ route($catalogRouteName) }}" class="ml-auto inline-flex items-center gap-1 text-[11px] font-bold text-rose-600 transition-colors hover:text-rose-700 hover:underline">
                            <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                            Reset Semua
                        </a>
                    </div>
                @endif
            </form>
        </section>

        <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @forelse($archives as $item)
                <article class="flex flex-col justify-between rounded-3xl border border-outline-variant/100 bg-white p-6 shadow-sm hover:shadow-md transition duration-200">
                    <div>
                        <div class="mb-4 flex items-center justify-between gap-4">
                            <span class="rounded-full bg-primary/10 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-primary whitespace-nowrap">{{ $item['type_label'] }}</span>
                            <span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wide border whitespace-nowrap
                                {{ match($item['availability_status']) {
                                    'tersedia' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'dipinjam' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    'dipesan' => 'bg-sky-50 text-sky-700 border-sky-200',
                                    'belum_diserahkan' => 'bg-amber-500/15 text-amber-700 border-amber-500/20',
                                    default => 'bg-slate-100 text-slate-600 border-slate-200',
                                } }}">
                                {{ $item['availability_label'] }}
                            </span>
                        </div>
                        <h2 class="line-clamp-2 text-[17px] font-bold text-on-surface mb-4 leading-snug" style="font-family: Outfit, sans-serif;">{{ $item['title'] }}</h2>
                        
                        <div class="space-y-2 border-t border-outline-variant/100 pt-4 text-xs text-outline font-semibold">
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
                    <div class="mt-6 border-t border-outline-variant/100 pt-4">
                        <a href="{{ Auth::check() ? route($rolePrefix . '.katalog-arsip.show', [$item['type'], $item['id']]) : route('katalog-arsip.show', [$item['type'], $item['id']]) }}" class="w-full inline-flex items-center justify-center gap-1.5 rounded-2xl bg-primary hover:bg-primary/95 text-white font-bold px-5 py-3.5 text-sm shadow-lg shadow-primary/15 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                            Lihat Detail
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-3xl border border-outline-variant/100 bg-white p-12 text-center text-outline shadow-sm font-semibold">
                    <div class="flex flex-col items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-4xl text-outline-variant">folder_open</span>
                        <span>Arsip tidak ditemukan untuk filter yang dipilih.</span>
                    </div>
                </div>
            @endforelse
        </section>

        @if($archives->hasPages())
            <section class="mt-8 rounded-3xl border border-outline-variant/100 bg-white p-6 shadow-sm">
                {{ $archives->links() }}
            </section>
        @endif
    </main>
</body>
</html>
