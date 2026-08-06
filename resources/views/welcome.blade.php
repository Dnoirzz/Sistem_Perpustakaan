<!DOCTYPE html>
<html class="light scroll-smooth" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Beranda - SIPUS PSDKU POLNEP</title>
    
    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS with CDN for dynamic theme compilation -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-secondary-fixed-variant": "#5c4300",
                    "outline": "#707882",
                    "surface-container-lowest": "#ffffff",
                    "surface-container-high": "#e1e8fd",
                    "surface-container": "#e9edff",
                    "on-surface": "#141b2b",
                    "surface-bright": "#f9f9ff",
                    "on-tertiary-fixed-variant": "#633f00",
                    "surface-container-low": "#f1f3ff",
                    "tertiary-fixed": "#ffddb3",
                    "tertiary-container": "#a06900",
                    "on-primary-fixed": "#001d34",
                    "secondary-container": "#f39200",
                    "secondary-fixed": "#ffdf9f",
                    "on-secondary": "#ffffff",
                    "surface-variant": "#dce2f7",
                    "on-primary": "#ffffff",
                    "border-subtle": "#E5E7EB",
                    "surface-light": "#F9FAFB",
                    "on-background": "#141b2b",
                    "error-container": "#ffdad6",
                    "on-error": "#ffffff",
                    "on-secondary-container": "#6f5100",
                    "tertiary-fixed-dim": "#ffb951",
                    "surface-dim": "#d3daef",
                    "on-error-container": "#93000a",
                    "on-tertiary-fixed": "#291800",
                    "on-secondary-fixed": "#261a00",
                    "background": "#f9f9ff",
                    "text-muted": "#4B5563",
                    "inverse-primary": "#9acbff",
                    "on-surface-variant": "#404751",
                    "secondary-fixed-dim": "#f9bd22",
                    "primary-fixed-dim": "#9acbff",
                    "on-tertiary": "#ffffff",
                    "surface-tint": "#00a5c0",
                    "on-primary-fixed-variant": "#007b91",
                    "surface": "#f9f9ff",
                    "tertiary": "#7f5300",
                    "inverse-on-surface": "#edf0ff",
                    "on-primary-container": "#fdfcff",
                    "on-tertiary-container": "#fffbff",
                    "primary-container": "#00a5c0",
                    "secondary": "#f39200",
                    "primary": "#00a5c0",
                    "inverse-surface": "#293040",
                    "error": "#ba1a1a",
                    "surface-container-highest": "#dce2f7",
                    "outline-variant": "#c0c7d2",
                    "primary-fixed": "#cfe5ff"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "margin-desktop": "40px",
                    "margin-mobile": "16px",
                    "unit": "4px",
                    "gutter": "24px",
                    "container-max": "1280px"
            },
            "fontFamily": {
                    "sans": ["Outfit", "sans-serif"],
                    "display-lg-mobile": ["Outfit"],
                    "label-sm": ["Outfit"],
                    "headline-lg": ["Outfit"],
                    "label-md": ["Outfit"],
                    "body-md": ["Outfit"],
                    "display-lg": ["Outfit"],
                    "headline-md": ["Outfit"],
                    "body-lg": ["Outfit"]
            },
            "fontSize": {
                    "display-lg-mobile": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                    "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f9f9ff;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen text-on-surface bg-surface">
    <!-- TopNavBar (Responsive Mobile & Desktop) -->
    <nav class="w-full top-0 sticky z-50 bg-surface/95 backdrop-blur-md border-b border-border-subtle">
        <div class="flex justify-between items-center max-w-container-max mx-auto px-4 md:px-margin-desktop h-16">
            <div class="flex items-center gap-2 sm:gap-3">
                <img src="{{ asset('img/logo_polnep.webp') }}" class="w-8 h-8 sm:w-9 sm:h-9 object-contain" alt="Logo POLNEP">
                <span class="text-sm sm:text-headline-md font-headline-md font-bold text-primary truncate max-w-[170px] sm:max-w-none">
                    Perpustakaan
                <br>
                    PSDKU POLNEP SUKAMARA
                </span>
            </div>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center gap-8 font-body-md text-body-md">
                <a class="text-on-surface-variant hover:text-primary transition-colors duration-200" href="#katalog">Koleksi Buku</a>
                <a class="text-on-surface-variant hover:text-teal-700 transition-colors duration-200" href="#repositori">Karya Ilmiah</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors duration-200" href="#layanan">Layanan</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors duration-200" href="#panduan">Panduan</a>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-3">
                @if (Route::has('login'))
                    @auth
                        @php
                            $user = Auth::user();
                            $dashboardRoute = route('dashboard');
                            if ($user->isAdmin()) $dashboardRoute = route('admin.dashboard');
                            elseif ($user->isPetugas()) $dashboardRoute = route('petugas.dashboard');
                            elseif ($user->isDosen()) $dashboardRoute = route('dosen.dashboard');
                            elseif ($user->isMahasiswa()) $dashboardRoute = route('mahasiswa.dashboard');
                        @endphp
                        <a href="{{ $dashboardRoute }}" class="px-3 sm:px-6 py-1.5 sm:py-2 bg-primary text-on-primary rounded-lg font-label-md text-xs sm:text-label-md hover:opacity-90 transition-opacity flex items-center gap-1.5 sm:gap-2">
                            <span class="material-symbols-outlined text-[18px]">dashboard</span>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-3.5 sm:px-6 py-1.5 sm:py-2 bg-primary text-on-primary rounded-lg font-label-md text-xs sm:text-label-md hover:opacity-90 transition-opacity">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-3.5 sm:px-6 py-1.5 sm:py-2 border border-primary text-primary rounded-lg font-label-md text-xs sm:text-label-md hover:bg-slate-50 transition-opacity">
                                Daftar
                            </a>
                        @endif
                    @endauth
                @endif

                <!-- Mobile Hamburger Button -->
                <button id="mobile-menu-btn" type="button" class="md:hidden p-1.5 text-on-surface-variant hover:text-primary rounded-lg focus:outline-none" aria-label="Toggle Navigation">
                    <span class="material-symbols-outlined text-2xl" id="menu-icon">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-border-subtle bg-surface px-4 py-3 space-y-2 shadow-lg">
            <a class="block font-medium text-on-surface-variant hover:text-primary py-1.5 px-2 rounded-lg hover:bg-surface-container-low" href="#katalog" onclick="toggleMobileMenu()">Koleksi Buku</a>
            <a class="block font-medium text-on-surface-variant hover:text-teal-700 py-1.5 px-2 rounded-lg hover:bg-surface-container-low" href="#repositori" onclick="toggleMobileMenu()">Karya Ilmiah</a>
            <a class="block font-medium text-on-surface-variant hover:text-primary py-1.5 px-2 rounded-lg hover:bg-surface-container-low" href="#layanan" onclick="toggleMobileMenu()">Layanan</a>
            <a class="block font-medium text-on-surface-variant hover:text-primary py-1.5 px-2 rounded-lg hover:bg-surface-container-low" href="#panduan" onclick="toggleMobileMenu()">Panduan</a>
        </div>
    </nav>

    <main class="flex-grow">
        <!-- Hero Section 2 Kolom (Headline + Ilustrasi Vektor Modern) -->
        <section class="py-12 md:py-20 bg-surface-container-low overflow-hidden">
            <div class="max-w-container-max mx-auto px-4 md:px-margin-desktop">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left Column: Content & Badges -->
                    <div class="lg:col-span-7 space-y-5 sm:space-y-6 text-left">
                        
                        <!-- Badge Jam Operasional & Status -->
                        <div class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 rounded-full bg-white border border-border-subtle shadow-sm max-w-full">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shrink-0"></span>
                            <span class="text-[11px] sm:text-xs font-bold text-on-surface-variant leading-tight">Jam Operasional Perpustakaan: Senin – Jumat (08:00 – 14:00 WIB)</span>
                        </div>

                        <!-- Headline & Subtitle -->
                        <h1 class="font-display-lg text-2xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-primary leading-tight">
                            Perpustakaan 
                            <br>
                            PSDKU POLNEP SUKAMARA
                        </h1>
                        <p class="font-body-lg text-sm sm:text-body-lg text-on-surface-variant max-w-xl leading-relaxed">
                            Pusat akses literasi terpadu, koleksi buku teks perkuliahan, dan repositori karya ilmiah digital untuk civitas akademika PSDKU Politeknik Negeri Pontianak Sukamara
                        </p>

                        <!-- Feature Highlights (3 Key Badges - Opsi A) -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 pt-2 sm:pt-4">
                            <div class="p-3.5 sm:p-4 bg-white/80 border border-border-subtle rounded-xl flex items-center gap-3 shadow-sm">
                                <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">bolt</span>
                                </div>
                                <div class="text-left">
                                    <h4 class="font-bold text-xs text-on-surface">Fitur Reservasi Buku</h4>
                                    <p class="text-[11px] text-outline">Booking &amp; Antrian Peminjaman Buku</p>
                                </div>
                            </div>

                            <div class="p-3.5 sm:p-4 bg-white/80 border border-border-subtle rounded-xl flex items-center gap-3 shadow-sm">
                                <div class="w-10 h-10 rounded-lg bg-secondary-container/20 text-secondary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">chat</span>
                                </div>
                                <div class="text-left">
                                    <h4 class="font-bold text-xs text-on-surface">Notifikasi WhatsApp</h4>
                                    <p class="text-[11px] text-outline">Update Otomatis Informasi via WA</p>
                                </div>
                            </div>

                            <div class="p-3.5 sm:p-4 bg-white/80 border border-border-subtle rounded-xl flex items-center gap-3 shadow-sm">
                                <div class="w-10 h-10 rounded-lg bg-tertiary-container/20 text-tertiary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">school</span>
                                </div>
                                <div class="text-left">
                                    <h4 class="font-bold text-xs text-on-surface">Karya Ilmiah</h4>
                                    <p class="text-[11px] text-outline">Arsip Karya Ilmiah Mahasiswa</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Hero Illustration Graphic -->
                    <div class="lg:col-span-5 flex items-center justify-center mt-4 lg:mt-0">
                        <div class="relative w-full max-w-md">
                            <!-- Background Decorative Glow -->
                            <div class="absolute -inset-4 rounded-3xl bg-gradient-to-r from-primary/20 via-secondary/15 to-primary-container/20 blur-2xl opacity-70"></div>
                            
                            <!-- Main Illustration Card -->
                            <div class="relative bg-white border border-border-subtle rounded-3xl p-3 sm:p-4 shadow-xl overflow-hidden">
                                <img src="{{ asset('img/foto_perpus.png') }}" 
                                     alt="Foto Perpustakaan POLNEP" 
                                     class="w-full h-auto object-cover rounded-2xl">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Statistics Section (Background putih & Border asli) -->
        <section class="py-10 sm:py-12 border-b border-border-subtle bg-white">
            <div class="max-w-container-max mx-auto px-4 md:px-margin-desktop">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-gutter text-center">
                    <div class="flex flex-col items-center">
                        <span class="font-display-lg text-3xl sm:text-display-lg text-primary">{{ number_format($totalBooks) }}</span>
                        <span class="font-label-md text-xs sm:text-label-md text-outline uppercase tracking-wider mt-1">Koleksi Buku</span>
                    </div>
                    <div class="flex flex-col items-center border-y md:border-y-0 md:border-x border-border-subtle py-4 md:py-0">
                        <span class="font-display-lg text-3xl sm:text-display-lg text-primary">{{ number_format($totalMembers) }}</span>
                        <span class="font-label-md text-xs sm:text-label-md text-outline uppercase tracking-wider mt-1">Anggota Aktif</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="font-display-lg text-3xl sm:text-display-lg text-primary">{{ number_format($totalArchives) }}</span>
                        <span class="font-label-md text-xs sm:text-label-md text-outline uppercase tracking-wider mt-1">Arsip Digital</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 1: Koleksi Buku Terbaru (5 Buku Umum) -->
        <section id="katalog" class="py-10 sm:py-14">
            <div class="max-w-container-max mx-auto px-4 md:px-margin-desktop">
                <div class="flex justify-between items-end mb-6 sm:mb-8">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-primary text-[20px]">menu_book</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-primary">Koleksi Cetak & Teks</span>
                        </div>
                        <h2 class="font-headline-lg text-2xl sm:text-headline-lg text-on-surface font-bold">Koleksi Buku</h2>
                        <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Koleksi buku yang tersedia di perpustakaan.</p>
                    </div>
                    @auth
                        @php
                            $searchRoute = route('mahasiswa.books.index');
                            if (Auth::user()->isDosen()) $searchRoute = route('dosen.books.index');
                            elseif (Auth::user()->isPetugas()) $searchRoute = route('petugas.books.index');
                        @endphp
                        <a class="text-primary font-label-md text-xs sm:text-label-md flex items-center gap-1 hover:underline font-bold shrink-0" href="{{ $searchRoute }}">
                            Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    @else
                        <a class="text-primary font-label-md text-xs sm:text-label-md flex items-center gap-1 hover:underline font-bold shrink-0" href="{{ route('login') }}">
                            Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    @endauth
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-6">
                    @forelse($featuredBooks as $book)
                        <div class="group bg-white border border-border-subtle rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                            <div class="aspect-[3/4] overflow-hidden bg-white flex items-center justify-center relative border-b border-border-subtle">
                                <img class="w-full h-full {{ $book->cover_image ? 'object-cover' : 'object-contain p-6 bg-white' }} group-hover:scale-105 transition-transform duration-500" alt="{{ $book->judul }}" src="{{ $book->cover_url }}">
                            </div>
                            <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <span class="text-[9px] sm:text-[10px] font-bold text-primary uppercase mb-1 block truncate">{{ $book->category?->kategori_name ?? 'Umum' }}</span>
                                    <h3 class="font-label-md text-xs sm:text-label-md text-on-surface line-clamp-2 mb-1 font-bold" title="{{ $book->judul }}">{{ $book->judul }}</h3>
                                    <p class="text-[11px] sm:text-[12px] text-outline truncate">{{ $book->author ?? 'Penulis tidak diketahui' }}</p>
                                </div>
                                <div class="mt-3 sm:mt-4 pt-2 border-t border-border-subtle flex items-center justify-between">
                                    <a href="{{ route('login') }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                                        <span>Pinjam</span>
                                        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-outline font-medium">
                            Belum ada koleksi buku yang ditampilkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Section 2: Repositori Karya Ilmiah Digital (5 Laporan TA / Proposal / PKL Terbaru) -->
        <section id="repositori" class="py-10 sm:py-14 bg-slate-50/70 border-t border-b border-outline-variant/100">
            <div class="max-w-container-max mx-auto px-4 md:px-margin-desktop">
                <div class="flex justify-between items-end mb-6 sm:mb-8">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-teal-600 text-[20px]">school</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-teal-700">Repositori Digital Kampus</span>
                        </div>
                        <h2 class="font-headline-lg text-2xl sm:text-headline-lg text-on-surface font-bold">Karya Ilmiah Mahasiswa</h2>
                        <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Laporan Tugas Akhir, Proposal dan Laporan PKL Mahasiswa</p>
                    </div>
                    @auth
                        @php
                            $archiveRoute = route('mahasiswa.katalog-arsip.index');
                            if (Auth::user()->isDosen()) $archiveRoute = route('dosen.katalog-arsip.index');
                            elseif (Auth::user()->isPetugas()) $archiveRoute = route('petugas.arsip.index');
                        @endphp
                        <a class="text-teal-700 font-label-md text-xs sm:text-label-md flex items-center gap-1 hover:underline font-bold shrink-0" href="{{ $archiveRoute }}">
                            Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    @else
                        <a class="text-teal-700 font-label-md text-xs sm:text-label-md flex items-center gap-1 hover:underline font-bold shrink-0" href="{{ route('login') }}">
                            Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    @endauth
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-6">
                    @forelse($featuredArchives as $archive)
                        <div class="group bg-white border border-border-subtle rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                            <!-- Cover area using default logo_polnep.webp -->
                            <div class="aspect-[3/4] overflow-hidden bg-white flex items-center justify-center relative border-b border-border-subtle">
                                <img class="w-full h-full object-contain p-6 bg-white group-hover:scale-105 transition-transform duration-500" alt="{{ $archive->title_display }}" src="{{ asset('img/logo_polnep.webp') }}">
                                
                                <!-- Badge Type Label -->
                                <span class="absolute top-2 left-2 bg-teal-700 text-white text-[9px] sm:text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-xs">
                                    {{ $archive->type_label }}
                                </span>
                            </div>

                            <!-- Content Footer -->
                            <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <span class="text-[9px] sm:text-[10px] font-bold text-teal-700 uppercase mb-1 block truncate">{{ $archive->prodi_display }}</span>
                                    <h3 class="font-label-md text-xs sm:text-label-md text-on-surface line-clamp-2 mb-1 font-bold" title="{{ $archive->title_display }}">
                                        {{ $archive->title_display }}
                                    </h3>
                                    <p class="text-[11px] sm:text-[12px] text-outline truncate">Oleh: {{ $archive->author_display }}</p>
                                </div>
                                <div class="mt-3 sm:mt-4 pt-2 border-t border-border-subtle flex items-center justify-between">
                                    @auth
                                        @php
                                            $streamRoute = route('mahasiswa.katalog-arsip.show', ['type' => $archive->archive_type, 'id' => $archive->getKey()]);
                                            if (Auth::user()->isDosen()) $streamRoute = route('dosen.katalog-arsip.show', ['type' => $archive->archive_type, 'id' => $archive->getKey()]);
                                            elseif (Auth::user()->isPetugas()) $streamRoute = route('petugas.arsip.show', ['type' => $archive->archive_type, 'id' => $archive->getKey()]);
                                        @endphp
                                        <a href="{{ $streamRoute }}" class="text-xs font-bold text-teal-700 hover:underline flex items-center gap-1">
                                            <span>Selengkapnya</span>
                                            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="text-xs font-bold text-teal-700 hover:underline flex items-center gap-1">
                                            <span>Selengkapnya</span>
                                            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-outline font-medium">
                            Belum ada karya ilmiah publikasi digital yang ditampilkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Core Services (Background surface-container asli) -->
        <section id="layanan" class="py-12 sm:py-16 bg-surface-container">
            <div class="max-w-container-max mx-auto px-4 md:px-margin-desktop">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="font-headline-lg text-2xl sm:text-headline-lg text-on-surface">Layanan Perpustakaan</h2>
                    <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Fasilitas pendukung akademik untuk seluruh Civitas Akademika.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-gutter">
                    <!-- Service 1 -->
                    <div class="p-6 sm:p-8 bg-white border border-border-subtle rounded-xl flex flex-col items-center text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-primary-container/10 text-primary rounded-full flex items-center justify-center mb-4 sm:mb-6">
                            <span class="material-symbols-outlined text-[28px] sm:text-[32px]">auto_stories</span>
                        </div>
                        <h3 class="font-headline-md text-lg sm:text-headline-md text-on-surface mb-2 sm:mb-3">E-Book &amp; Jurnal</h3>
                        <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Akses ribuan judul buku elektronik dan jurnal internasional terakreditasi secara gratis</p>
                    </div>
                    <!-- Service 2 -->
                    <div class="p-6 sm:p-8 bg-white border border-border-subtle rounded-xl flex flex-col items-center text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-secondary-container/10 text-secondary rounded-full flex items-center justify-center mb-4 sm:mb-6">
                            <span class="material-symbols-outlined text-[28px] sm:text-[32px]">local_library</span>
                        </div>
                        <h3 class="font-headline-md text-lg sm:text-headline-md text-on-surface mb-2 sm:mb-3">Ruang Baca Nyaman</h3>
                        <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Fasilitas area baca yang tenang, bersih, dan kondusif untuk menunjang kegiatan membaca serta belajar</p>
                    </div>
                    <!-- Service 3 -->
                    <div class="p-6 sm:p-8 bg-white border border-border-subtle rounded-xl flex flex-col items-center text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-tertiary-container/10 text-tertiary rounded-full flex items-center justify-center mb-4 sm:mb-6">
                            <span class="material-symbols-outlined text-[28px] sm:text-[32px]">history_edu</span>
                        </div>
                        <h3 class="font-headline-md text-lg sm:text-headline-md text-on-surface mb-2 sm:mb-3">Repositori &amp; Karya Ilmiah</h3>
                        <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Akses penuh Laporan PKL, Skripsi/TA, dan verifikasi orisinalitas karya ilmiah mahasiswa</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Panduan Peminjaman (Background surface-container-low) -->
        <section id="panduan" class="py-12 sm:py-16 bg-surface-container-low border-t border-border-subtle">
            <div class="max-w-container-max mx-auto px-4 md:px-margin-desktop">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="font-headline-lg text-2xl sm:text-headline-lg text-on-surface">3 Langkah Mudah Meminjam Buku</h2>
                    <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Alur peminjaman buku di Perpustakaan Digital POLNEP.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-gutter text-center">
                    <div class="p-5 sm:p-6 bg-white border border-border-subtle rounded-xl">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-white font-bold text-base sm:text-lg flex items-center justify-center mx-auto mb-3 sm:mb-4">1</div>
                        <h3 class="font-headline-md text-base sm:text-headline-md text-on-surface mb-2">Cari Buku</h3>
                        <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Gunakan kolom pencarian untuk menemukan koleksi buku yang dibutuhkan</p>
                    </div>
                    <div class="p-5 sm:p-6 bg-white border border-border-subtle rounded-xl">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-white font-bold text-base sm:text-lg flex items-center justify-center mx-auto mb-3 sm:mb-4">2</div>
                        <h3 class="font-headline-md text-base sm:text-headline-md text-on-surface mb-2">Booking / Antri</h3>
                        <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Lakukan booking jika stok tersedia, atau masuk ke antrian jika stok tidak tersedia</p>
                    </div>
                    <div class="p-5 sm:p-6 bg-white border border-border-subtle rounded-xl">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary text-white font-bold text-base sm:text-lg flex items-center justify-center mx-auto mb-3 sm:mb-4">3</div>
                        <h3 class="font-headline-md text-base sm:text-headline-md text-on-surface mb-2">Ambil Buku</h3>
                        <p class="font-body-md text-xs sm:text-body-md text-on-surface-variant">Tunjukkan kode booking ke petugas perpustakaan untuk mengambil fisik buku</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Biru (Sesuai Pilihan Warna User) -->
    <footer class="w-full bg-[#2d80c5] text-white/90 border-t border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                
                <!-- Col 1: Brand Info -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('img/logo_polnep.webp') }}" class="w-10 h-10 object-contain drop-shadow-md" alt="Logo POLNEP">
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-white tracking-tight leading-none">SIPUS POLNEP</span>
                            <span class="text-[10px] text-white/80 uppercase tracking-widest mt-1">Digital Library System</span>
                        </div>
                    </div>
                    <p class="text-xs text-white/85 max-w-md leading-relaxed">
                        Perpustakaan Digital Politeknik Negeri Pontianak berkomitmen mencerdaskan civitas akademika melalui penyediaan literasi inklusif, buku teks berkualitas, dan repositori ilmiah terpadu.
                    </p>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-xs text-white/85">
                        <li><a href="#katalog" class="hover:text-white hover:underline transition-all">Koleksi Buku</a></li>
                        <li><a href="#repositori" class="hover:text-white hover:underline transition-all">Karya Ilmiah</a></li>
                        <li><a href="#layanan" class="hover:text-white hover:underline transition-all">Layanan &amp; Fitur</a></li>
                        <li><a href="#panduan" class="hover:text-white hover:underline transition-all">Panduan Peminjaman</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white hover:underline transition-all">Masuk Anggota</a></li>
                    </ul>
                </div>

                <!-- Col 3: Contact Info -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Kontak &amp; Lokasi</h4>
                    <ul class="space-y-3 text-xs text-white/85">
                        <li class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-[18px] text-white shrink-0 mt-0.5">location_on</span>
                            <span>Jl. Tjilik Riwut, Natai Sedawak, Kec. Sukamara, Kabupaten Sukamara, Kalimantan Tengah 74171</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[18px] text-white shrink-0">call</span>
                            <span>0561 736180</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[18px] text-white shrink-0">mail</span>
                            <span>kampus@polnep.ac.id</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="mt-12 pt-8 border-t border-white/20 text-center text-xs text-white/75">
                <p>&copy; 2026 Politeknik Negeri Pontianak. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        function toggleMobileMenu() {
            if (mobileMenu) {
                mobileMenu.classList.toggle('hidden');
                if (menuIcon) {
                    menuIcon.textContent = mobileMenu.classList.contains('hidden') ? 'menu' : 'close';
                }
            }
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', toggleMobileMenu);
        }

        // Simple search interaction
        const searchInput = document.querySelector('input[type="text"]');
        if (searchInput) {
            searchInput.addEventListener('focus', () => {
                searchInput.parentElement.classList.add('ring-2', 'ring-primary/20');
            });
            searchInput.parentElement.addEventListener('blur', () => {
                searchInput.parentElement.classList.remove('ring-2', 'ring-primary/20');
            });
        }
    </script>
</body>
</html>
