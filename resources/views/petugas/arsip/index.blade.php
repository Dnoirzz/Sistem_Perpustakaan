<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Arsip Digital - SIPUS PSDKU POLNEP</title>
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
    @include('petugas.layouts.sidebar')
    
    <main class="ml-64 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('petugas.layouts.header', [
            'title' => 'Kelola Arsip Digital',
            'subtitle' => 'Verifikasi, tolak, aktifkan, dan koreksi data repositori mahasiswa.'
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

        <!-- Top Action Button -->
        <div class="flex justify-end items-center mb-6">
            <a href="{{ route('petugas.arsip.import.form') }}" class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-sm transition-all">
                <span class="material-symbols-outlined text-[18px]">upload_file</span>
                Import Excel
            </a>
        </div>

        <!-- Filter Section -->
        <section class="mb-6 rounded-3xl border border-outline-variant/100 bg-white p-6 shadow-sm">
            <form action="{{ route('petugas.arsip.index') }}" method="GET" class="grid gap-4 md:grid-cols-4">
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-outline text-[20px]">search</span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, NIM atau judul" class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold placeholder:truncate transition-all">
                </div>
                <div>
                    <select name="type" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                        <option value="">Semua Jenis</option>
                        @foreach($typeOptions as $option)
                            <option value="{{ $option['value'] }}" @selected($selectedType === $option['value'])>{{ $option['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant transition-all">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected($selectedStatus === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-primary/90 transition-all text-center shadow-sm">
                        Terapkan Filter
                    </button>
                    @if($search !== '' || $selectedType !== '' || $selectedStatus !== '')
                        <a href="{{ route('petugas.arsip.index') }}" class="rounded-2xl border border-outline-variant/100 px-6 py-3 text-center text-xs font-bold text-on-surface-variant transition-all hover:bg-slate-50 flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>

        <x-table :pagination="$archives->hasPages() ? $archives->links() : null">
            <x-slot name="headers">
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Jenis</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Judul</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Mahasiswa</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Status</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-center text-slate-700 whitespace-nowrap w-28">Aksi</th>
            </x-slot>

            @forelse($archives as $item)
                <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="inline-flex items-center px-3.5 py-1 rounded-full bg-teal-100 text-teal-800 border border-teal-200 text-xs font-extrabold tracking-wide whitespace-nowrap">
                            {{ $item['type_label'] }}
                        </span>
                    </td>
                    <td class="px-8 py-5 max-w-md">
                        <div class="font-bold text-slate-900 text-sm line-clamp-2 group-hover:text-teal-700 transition-colors">{{ $item['title'] }}</div>
                        <div class="text-xs text-slate-500 mt-1.5 flex items-center gap-2 font-medium">
                            <span class="material-symbols-outlined text-[14px]">calendar_month</span> Tahun {{ $item['year'] ?? '-' }}
                            <span class="text-slate-300">•</span>
                            <span class="material-symbols-outlined text-[14px]">person</span> Pembimbing: {{ $item['pembimbing'] ?? '-' }}
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-teal-700 text-xs uppercase border border-outline-variant/100 shadow-xs shrink-0">
                                {{ substr($item['mahasiswa_name'] ?? 'M', 0, 2) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 text-sm whitespace-nowrap group-hover:text-teal-700 transition-colors">{{ $item['mahasiswa_name'] ?? '-' }}</span>
                                <span class="text-[10px] text-slate-500 font-bold tracking-wider mt-0.5 whitespace-nowrap">NIM: {{ $item['nim'] ?? '-' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-extrabold tracking-wide border whitespace-nowrap shadow-2xs
                            {{ $item['status'] === 'ditolak' ? 'bg-rose-100 text-rose-700 border-rose-200' : 
                               ($item['status'] === 'aktif' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 
                               ($item['status'] === 'diverifikasi' ? 'bg-sky-100 text-sky-800 border-sky-200' : 'bg-amber-100 text-amber-800 border-amber-200')) }}">
                            {{ $item['status'] }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center whitespace-nowrap">
                        <a href="{{ route('petugas.arsip.show', [$item['type'], $item['id']]) }}" class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 flex items-center justify-center transition-all inline-flex active:scale-95" title="Detail Arsip">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-8 py-14 text-center text-slate-500 font-medium">Belum ada data arsip digital.</td>
                </tr>
            @endforelse
        </x-table>
    </main>
</body>
</html>
