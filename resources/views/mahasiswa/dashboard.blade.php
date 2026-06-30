<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard Mahasiswa - SIPUS PSDKU POLNEP</title>
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
    @include('mahasiswa.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Dashboard Mahasiswa</h1>
                <p class="text-sm text-outline">Selamat datang kembali di portal perpustakaan Anda.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">NIM: {{ Auth::user()->mahasiswa->nim ?? '-' }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00609a&bold=true"/>
                </div>
            </div>
        </header>

        <!-- Hero Banner Section -->
        <section class="mb-10 relative overflow-hidden rounded-3xl hero-pattern p-10 text-on-primary shadow-xl shadow-primary/20">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[10px] font-bold uppercase tracking-widest border border-white/20">Mahasiswa Aktif</span>
                    </div>
                    <h2 class="font-display-lg text-headline-lg mb-2">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                    <p class="font-body-md opacity-90 mb-8 max-w-lg">Program Studi: {{ Auth::user()->mahasiswa->prodi->nama_prodi ?? 'Program Studi' }} | Semester: {{ Auth::user()->mahasiswa->semester ?? '-' }}</p>
                    
                    <!-- Quick Search Navigation Button -->
                    <a href="{{ route('mahasiswa.books.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-white text-primary font-bold shadow-lg hover:bg-slate-50 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
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
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-200">
                        <span class="material-symbols-outlined">auto_stories</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Aktif</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Pinjaman Aktif</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-on-surface">{{ $stats['active_loans'] }}</span>
                </div>
            </div>
            
            <!-- Booking Saya -->
            <a href="{{ route('mahasiswa.bookings.my') }}" class="block bg-white p-6 rounded-3xl border border-outline-variant/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined">event_available</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Booking</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Booking Saya</h3>
                <span class="text-4xl font-bold text-on-surface">{{ $stats['total_bookings'] }}</span>
            </a>

            <!-- Buku Terlambat -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center text-white shadow-lg shadow-red-200">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                    @if($stats['late_loans'] > 0)
                        <div class="px-2 py-1 bg-red-50 rounded-lg text-red-600 text-[10px] font-bold">Terlambat</div>
                    @else
                        <div class="px-2 py-1 bg-green-50 rounded-lg text-green-600 text-[10px] font-bold">Aman</div>
                    @endif
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Buku Terlambat</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold {{ $stats['late_loans'] > 0 ? 'text-rose-600' : 'text-on-surface' }}">{{ $stats['late_loans'] }}</span>
                    <span class="text-xs text-outline font-semibold">buku</span>
                </div>
            </div>

            <!-- Denda Tertunggak -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-purple-200">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    @if($stats['unpaid_fines'] > 0)
                        <div class="px-2 py-1 bg-red-50 rounded-lg text-red-600 text-[10px] font-bold">Harus Dibayar</div>
                    @else
                        <div class="px-2 py-1 bg-green-50 rounded-lg text-green-600 text-[10px] font-bold">Lunas</div>
                    @endif
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Denda yang Harus Dibayar</h3>
                <span class="text-2xl font-bold {{ $stats['unpaid_fines'] > 0 ? 'text-rose-600' : 'text-on-surface' }}">Rp{{ number_format($stats['unpaid_fines'], 0, ',', '.') }}</span>
            </div>
        </section>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Active Loans & Recommendations -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Active Loans Table -->
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
                    <div class="p-8 border-b border-outline-variant/10 flex items-center justify-between">
                        <div>
                            <h2 class="font-headline-md text-on-surface">Peminjaman Aktif</h2>
                            <p class="text-sm text-outline">Pantau pengembalian koleksi Anda tepat waktu.</p>
                        </div>
                        <a href="{{ route('mahasiswa.books.index') }}" class="text-primary font-label-md text-sm hover:underline">Cari Buku</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-surface-container-low/50">
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Judul Buku</th>
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Tgl Pinjam</th>
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Tgl Kembali</th>
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse($currentLoans as $loan)
                                    <tr class="hover:bg-surface-container-low/30 transition-colors">
                                        <td class="px-8 py-5">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-on-surface text-sm">
                                                    {{ $loan->collection?->display_title ?? 'Dokumen' }}
                                                </span>
                                                <span class="text-[10px] text-outline font-bold uppercase tracking-tighter">
                                                    {{ $loan->collection?->display_type_label ?? 'Koleksi' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-sm text-on-surface-variant">
                                            {{ \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d-m-Y') }}
                                        </td>
                                        <td class="px-8 py-5 text-sm font-medium {{ $loan->status === 'terlambat' ? 'text-error' : 'text-on-surface-variant' }}">
                                            {{ \Carbon\Carbon::parse($loan->bts_waktu)->translatedFormat('d-m-Y') }}
                                        </td>
                                        <td class="px-8 py-5">
                                            @if($loan->status === 'terlambat')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wide">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 animate-pulse"></span>
                                                    Terlambat
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wide">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></span>
                                                    Dipinjam
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-8 text-center text-outline font-medium">Anda tidak memiliki pinjaman aktif saat ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Book Recommendations Section -->
                <section>
                    <div class="flex items-center justify-between mb-6 px-2">
                        <h2 class="font-headline-md text-on-surface">Rekomendasi Untuk Anda</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Book Card 1 -->
                        <div class="bg-white rounded-3xl overflow-hidden border border-outline-variant/10 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">
                            <div class="h-48 bg-gradient-to-br from-primary to-surface-container-high relative flex items-center justify-center text-white/20">
                                <span class="material-symbols-outlined text-[80px]">image</span>
                                <div class="absolute bottom-4 left-4 right-4 bg-white/10 backdrop-blur-md rounded-xl p-2 flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-white uppercase tracking-wider">Informatika</span>
                                    <div class="flex gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-yellow-400">star</span>
                                        <span class="text-[10px] font-bold text-white">4.8</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-semibold text-on-surface mb-1 group-hover:text-primary transition-colors">Struktur Data dan Algoritma</h3>
                                <p class="text-xs text-outline mb-4">Dr. Suhardi, M.T.</p>
                                <a href="{{ route('mahasiswa.books.index') }}" class="block w-full py-3 rounded-2xl bg-surface-container text-primary font-label-md text-center text-sm hover:bg-primary hover:text-white transition-all">Lihat Detail</a>
                            </div>
                        </div>
                        
                        <!-- Book Card 2 -->
                        <div class="bg-white rounded-3xl overflow-hidden border border-outline-variant/10 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">
                            <div class="h-48 bg-gradient-to-br from-secondary to-secondary-container relative flex items-center justify-center text-white/20">
                                <span class="material-symbols-outlined text-[80px]">image</span>
                                <div class="absolute bottom-4 left-4 right-4 bg-white/10 backdrop-blur-md rounded-xl p-2 flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-white uppercase tracking-wider">Sistem Informasi</span>
                                    <div class="flex gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-yellow-400">star</span>
                                        <span class="text-[10px] font-bold text-white">4.9</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-semibold text-on-surface mb-1 group-hover:text-primary transition-colors">Laporan PKL SIA POLNEP</h3>
                                <p class="text-xs text-outline mb-4">Alumni Mahasiswa</p>
                                <a href="{{ route('mahasiswa.books.index') }}" class="block w-full py-3 rounded-2xl bg-surface-container text-primary font-label-md text-center text-sm hover:bg-primary hover:text-white transition-all">Lihat Detail</a>
                            </div>
                        </div>

                        <!-- Book Card 3 -->
                        <div class="bg-white rounded-3xl overflow-hidden border border-outline-variant/10 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">
                            <div class="h-48 bg-gradient-to-br from-tertiary-container to-tertiary relative flex items-center justify-center text-white/20">
                                <span class="material-symbols-outlined text-[80px]">image</span>
                                <div class="absolute bottom-4 left-4 right-4 bg-white/10 backdrop-blur-md rounded-xl p-2 flex items-center justify-between">
                                    <span class="text-[10px] font-bold text-white uppercase tracking-wider">Teknologi</span>
                                    <div class="flex gap-1">
                                        <span class="material-symbols-outlined text-[14px] text-yellow-400">star</span>
                                        <span class="text-[10px] font-bold text-white">4.5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-semibold text-on-surface mb-1 group-hover:text-primary transition-colors">Perpustakaan Digital</h3>
                                <p class="text-xs text-outline mb-4">Team Dev POLNEP</p>
                                <a href="{{ route('mahasiswa.books.index') }}" class="block w-full py-3 rounded-2xl bg-surface-container text-primary font-label-md text-center text-sm hover:bg-primary hover:text-white transition-all">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Column: Sidebar Widgets -->
            <div class="space-y-8">
                <!-- Status Validasi Arsip Digital -->
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-headline-md text-on-surface text-lg">Status Arsip Digital</h2>
                        <span class="material-symbols-outlined text-primary">cloud_upload</span>
                    </div>
                    <div class="p-4 bg-surface-container-low rounded-2xl border border-outline-variant/10 flex gap-4">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex-shrink-0 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[20px]">assignment</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-on-surface leading-tight">Dokumen Terupload</p>
                            <p class="text-sm font-semibold text-primary mt-1">{{ $stats['submitted_archives'] }} Dokumen</p>
                            <span class="inline-block mt-2 text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded font-bold uppercase tracking-wider">Siap Diverifikasi</span>
                        </div>
                    </div>
                </section>

                <!-- Library Announcements -->
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-headline-md text-on-surface text-lg">Pengumuman</h2>
                        <span class="material-symbols-outlined text-primary">campaign</span>
                    </div>
                    <div class="space-y-6">
                        <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 flex gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex-shrink-0 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined text-[20px]">info</span>
                            </div>
                            <div>
                                <p class="text-xs text-blue-800 font-medium">Segera lakukan pengembalian koleksi sebelum jatuh tempo untuk menghindari sanksi denda.</p>
                                <p class="text-[10px] text-blue-400 mt-2">Aktif</p>
                            </div>
                        </div>
                        <div class="p-4 rounded-2xl border border-outline-variant/10 flex gap-4">
                            <div class="w-10 h-10 rounded-xl bg-surface-container flex-shrink-0 flex items-center justify-center text-outline">
                                <span class="material-symbols-outlined text-[20px]">update</span>
                            </div>
                            <div>
                                <p class="text-xs text-on-surface-variant font-medium">Layanan mandiri upload laporan PKL dan TA dibuka selama 24 jam penuh di web.</p>
                                <p class="text-[10px] text-outline mt-2">Info Portal</p>
                            </div>
                        </div>
                    </div>
                </section>


            </div>
        </div>
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
