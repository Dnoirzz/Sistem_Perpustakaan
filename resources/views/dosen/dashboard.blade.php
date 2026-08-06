<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard Dosen - SIPUS PSDKU POLNEP</title>
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
        .hero-pattern {
            background-color: #00a5c0; /* POLNEP Turquoise */
            background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 24px 24px;
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
    @include('dosen.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Dashboard',
            'subtitle' => 'Selamat datang kembali di portal layanan akademik perpustakaan.'
        ])

        <!-- Hero Banner Section -->
        <section class="mb-10 relative overflow-hidden rounded-3xl hero-pattern p-10 text-on-primary shadow-xl shadow-primary/20">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[10px] font-bold uppercase tracking-widest border border-white/20">Tenaga Pendidik</span>
                    </div>
                    <h2 class="font-display-lg text-headline-lg mb-2">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                    <p class="font-body-md opacity-90 mb-8 max-w-lg">Program Studi: {{ Auth::user()->dosen->prodi->nama_prodi ?? 'Program Studi' }}</p>
                    
                    <!-- Quick Search Navigation Button -->
                    <a href="{{ route('dosen.books.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-white text-primary font-bold shadow-lg hover:bg-slate-50 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                        <span class="material-symbols-outlined">search</span>
                        Cari Buku Sekarang
                    </a>
                </div>
                <div class="hidden lg:block">
                    <div class="w-64 h-64 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/10 animate-pulse">
                        <span class="material-symbols-outlined text-[120px] opacity-40">menu_book</span>
                    </div>
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl"></div>
        </section>

        <!-- Stats Section -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Pinjaman Aktif -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <span class="material-symbols-outlined">auto_stories</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Pinjaman Aktif</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-on-surface">{{ $stats['active_loans'] }}</span>
                </div>
            </div>
            
            <!-- Booking Saya -->
            <a href="{{ route('dosen.bookings.my') }}" class="block bg-white p-6 rounded-3xl border border-outline-variant/100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined">event_available</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Booking Saya</h3>
                <span class="text-4xl font-bold text-on-surface">{{ $stats['total_bookings'] }}</span>
            </a>

            <!-- Buku Terlambat -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center text-white shadow-lg shadow-red-200">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Buku Terlambat</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold {{ $stats['late_loans'] > 0 ? 'text-rose-600' : 'text-on-surface' }}">{{ $stats['late_loans'] }}</span>
                    <span class="text-xs text-outline font-semibold">buku</span>
                </div>
            </div>

            <!-- Denda Tertunggak -->
            <a href="{{ route('dosen.loans.penalties') }}" class="block bg-white p-6 rounded-3xl border border-outline-variant/100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-purple-200">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <span class="material-symbols-outlined text-outline text-[18px]">chevron_right</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Denda yang Harus Dibayar</h3>
                <span class="text-2xl font-bold {{ $stats['unpaid_fines'] > 0 ? 'text-rose-600' : 'text-on-surface' }}">Rp{{ number_format($stats['unpaid_fines'], 0, ',', '.') }}</span>
            </a>
        </section>

        <!-- Two Column Layout: Active Loans & Usulan Buku Baru -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Left Column: Active Loans Table -->
            <div class="lg:col-span-2">
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/100 p-6 sm:p-8 h-full flex flex-col justify-between">
                    <div>
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <h2 class="font-headline-md text-on-surface text-lg font-bold">Peminjaman Aktif</h2>
                                <p class="text-xs text-slate-500 font-medium">Daftar buku pengajaran perpustakaan yang sedang Anda pinjam.</p>
                            </div>
                            <a href="{{ route('dosen.loans.active') }}" class="text-primary font-bold text-xs hover:underline flex items-center gap-1">
                                Lihat Semua Pinjaman &rarr;
                            </a>
                        </div>
                        
                        {{-- Menggunakan Komponen Standar Tabel Aplikasi --}}
                        <x-table>
                            <x-slot name="headers">
                                <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700 w-12 text-center">No</th>
                                <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700">Judul Koleksi</th>
                                <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700">Tgl Pinjam</th>
                                <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700">Jatuh Tempo</th>
                                <th class="px-5 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700 text-center">Status</th>
                            </x-slot>

                            @forelse($currentLoans as $index => $loan)
                                <tr class="even:bg-slate-50/50 hover:bg-slate-100/60 transition-colors group">
                                    <td class="px-5 py-4 text-center text-xs font-bold text-slate-500">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-1 group-hover:text-primary transition-colors">
                                                {{ $loan->collection?->display_title ?? 'Dokumen / Buku' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-xs font-semibold text-slate-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($loan->status === 'terlambat')
                                            <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-200 inline-block">
                                                {{ \Carbon\Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-xs font-bold text-slate-800">
                                                {{ \Carbon\Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        @if($loan->status === 'terlambat')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-[11px] font-extrabold uppercase tracking-wider shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-rose-600 animate-pulse"></span>
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-[11px] font-extrabold uppercase tracking-wider shadow-2xs">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-12 text-center bg-slate-50/40">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <span class="material-symbols-outlined text-slate-300 text-4xl">auto_stories</span>
                                            <p class="text-xs font-semibold text-slate-500">Anda tidak memiliki pinjaman aktif saat ini.</p>
                                            <a href="{{ route('dosen.books.index') }}" class="inline-block mt-2 text-xs font-bold text-primary hover:underline">Jelajahi Katalog Buku &rarr;</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </x-table>
                    </div>
                </section>
            </div>

            <!-- Right Column: Status Usulan Buku -->
            <div class="lg:col-span-1">
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/100 p-8 h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="font-headline-md text-on-surface text-lg font-bold">Usulan Buku Baru</h2>
                            <span class="material-symbols-outlined text-primary">rate_review</span>
                        </div>
                        <div class="p-4 bg-surface-container-low rounded-2xl border border-outline-variant/100 flex gap-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex-shrink-0 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-on-surface leading-tight">Total Usulan Buku Anda</p>
                                <p class="text-sm font-semibold text-primary mt-1">{{ $stats['total_recommendations'] }} Judul</p>
                                <span class="inline-block mt-2 text-[10px] bg-blue-50 text-blue-700 px-2 py-0.5 rounded font-bold uppercase tracking-wider">Menunggu Pengadaan</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400">Usulan Referensi</span>
                        <a href="{{ route('dosen.recommendations.index') }}" class="font-bold text-primary hover:underline">Usulkan Buku &rarr;</a>
                    </div>
                </section>
            </div>
        </div>

        <!-- Full Width Dynamic Book Recommendations Section (5 Koleksi Penuh) -->
        <section class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-outline-variant/100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]">auto_awesome</span>
                    </span>
                    <div>
                        <h2 class="font-headline-md text-on-surface text-lg font-bold">Rekomendasi Untuk Anda</h2>
                        <p class="text-xs text-slate-500 font-medium">Koleksi terpopuler dan rilis terbaru di perpustakaan.</p>
                    </div>
                </div>
                <a href="{{ route('dosen.books.index') }}" class="text-xs font-bold text-primary hover:underline">Lihat Semua Katalog &rarr;</a>
            </div>

            <!-- Grid Container (5 Columns Full Width) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                @forelse($recommendedCollections as $item)
                    @php
                        $title = $item->display_title;
                        $author = $item->author_name;
                        $coverUrl = $item->cover_url;
                        $typeLabel = $item->display_type_label;
                        $detailUrl = $item->item_type === 'book'
                            ? route('dosen.books.index', ['search' => $title])
                            : route('dosen.katalog-arsip.show', ['type' => $item->item_type, 'id' => $item->item_id]);
                    @endphp
                    <div class="bg-slate-50/70 rounded-3xl overflow-hidden border border-slate-200/80 hover:border-primary/40 shadow-xs hover:shadow-md hover:-translate-y-1 transition-all duration-300 group flex flex-col justify-between">
                        <div class="h-44 bg-slate-200/60 relative flex items-center justify-center overflow-hidden">
                            <img src="{{ $coverUrl }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $title }}" onerror="this.onerror=null; this.src='{{ asset('img/logo_polnep.webp') }}';">
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                            <div>
                                <span class="inline-block text-[10px] font-bold text-primary uppercase tracking-wider bg-primary/10 px-2 py-0.5 rounded-md mb-2">
                                    {{ $typeLabel }}
                                </span>
                                <h3 class="font-bold text-slate-900 text-xs sm:text-sm line-clamp-2 leading-snug group-hover:text-primary transition-colors mb-1" title="{{ $title }}">{{ $title }}</h3>
                                <p class="text-[11px] text-slate-500 line-clamp-1 font-medium">{{ $author }}</p>
                            </div>
                            <a href="{{ $detailUrl }}" class="block w-full py-2 rounded-xl bg-white text-primary font-bold text-center text-xs border border-primary/20 hover:bg-primary hover:text-white transition-all shadow-xs">Lihat Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center bg-slate-50 rounded-3xl border border-slate-200 text-slate-400 text-xs font-semibold">
                        Belum ada data rekomendasi koleksi.
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <script>
        // Smooth hover interactions for stat cards
        document.querySelectorAll('.bg-white.p-6.rounded-3xl').forEach(card => {
            card.addEventListener('mouseenter', () => {
                const icon = card.querySelector('.material-symbols-outlined');
                if(icon) icon.classList.add('animate-bounce');
            });
            card.addEventListener('mouseleave', () => {
                const icon = card.querySelector('.material-symbols-outlined');
                if(icon) icon.classList.remove('animate-bounce');
            });
        });
    </script>
</body>
</html>
