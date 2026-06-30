<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Beranda - SIPUS PSDKU POLNEP</title>
    
    <!-- Tailwind CSS with CDN for dynamic theme compilation (Matching exact reference) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    
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
<body class="flex flex-col min-h-screen text-on-surface">
    <!-- TopNavBar -->
    <nav class="w-full top-0 sticky z-50 bg-surface border-b border-subtle">
        <div class="flex justify-between items-center max-w-container-max mx-auto px-margin-desktop h-16">
            <div class="flex items-center gap-2">
                <span class="text-headline-md font-headline-md font-bold text-primary">POLNEP Digital Library</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a class="text-primary border-b-2 border-primary font-bold pb-1 font-body-md text-body-md" href="#">Koleksi</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors duration-200 font-body-md text-body-md" href="#">Peminjaman</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors duration-200 font-body-md text-body-md" href="#">Panduan</a>
            </div>
            
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-opacity">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-opacity">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2 border border-primary text-primary rounded-lg font-label-md text-label-md hover:bg-slate-50 transition-opacity">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="py-20 bg-surface-container-low">
            <div class="max-w-container-max mx-auto px-margin-desktop text-center">
                <h1 class="font-display-lg text-display-lg mb-6 text-primary">Perpustakaan Digital PSDKU POLNEP</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto mb-10">
                    Akses literasi dan sumber daya akademik terpadu untuk civitas akademika Politeknik Negeri Pontianak.
                </p>
                <div class="max-w-3xl mx-auto relative group">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-outline">search</span>
                    </div>
                    <input class="w-full pl-12 pr-32 py-4 bg-white border border-subtle rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all text-body-md" placeholder="Cari judul buku, pengarang, atau nomor ISBN..." type="text">
                    <button class="absolute right-2 top-2 bottom-2 px-6 bg-secondary-container text-on-secondary-container font-label-md text-label-md rounded-lg hover:bg-secondary-fixed transition-colors">
                        Cari Koleksi
                    </button>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-12 border-b border-subtle bg-white">
            <div class="max-w-container-max mx-auto px-margin-desktop">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter text-center">
                    <div class="flex flex-col items-center">
                        <span class="font-display-lg text-display-lg text-primary">12.450+</span>
                        <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Koleksi Buku</span>
                    </div>
                    <div class="flex flex-col items-center border-x-0 md:border-x border-subtle">
                        <span class="font-display-lg text-display-lg text-primary">3.200+</span>
                        <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Anggota Aktif</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="font-display-lg text-display-lg text-primary">8.900+</span>
                        <span class="font-label-md text-label-md text-outline uppercase tracking-wider">Unduhan Digital</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Collection -->
        <section class="py-16">
            <div class="max-w-container-max mx-auto px-margin-desktop">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface">Koleksi Unggulan</h2>
                        <p class="font-body-md text-body-md text-on-surface-variant">Buku-buku terbaru dan paling sering dipinjam bulan ini.</p>
                    </div>
                    <a class="text-primary font-label-md text-label-md flex items-center gap-1 hover:underline" href="#">
                        Lihat Semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    <!-- Book Card 1 -->
                    <div class="group bg-white border border-subtle rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="aspect-[3/4] overflow-hidden bg-surface-container-highest">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Algoritma & Pemrograman C++" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAbgeGr5KDK4gakRIl2MI1XtSJW22Q2rhHKlGN4dUG_H8j12CwxyoGfFXNSA-cf_NpI1LQ_HGmv8ItrJQ0LAdVvlG3RGkfhSBJ1sXthMoDTqIqXVXRuKvPeNBVmkLz8Pb2WDZoCGG5EXrRJxlNcXVSU52Kvz7OlTwCQQJlbeJXupJCI_Pl06Zngj02Frtk9ZFGFGMcCVY2nSnm096JyW5RGdGAm-0MOq4PPvC5wNZt9JxpupTk9BUWgNqkbomg9cQYNA7hqY3rK3MY">
                        </div>
                        <div class="p-4">
                            <span class="text-[10px] font-bold text-primary uppercase mb-1 block">Teknologi</span>
                            <h3 class="font-label-md text-label-md text-on-surface line-clamp-2 mb-1">Algoritma &amp; Pemrograman C++</h3>
                            <p class="text-[12px] text-outline">Dr. Eng. Hermawan</p>
                        </div>
                    </div>
                    <!-- Book Card 2 -->
                    <div class="group bg-white border border-subtle rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="aspect-[3/4] overflow-hidden bg-surface-container-highest">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Manajemen Strategis Bisnis" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBOz1Jr3I9jChJLsMH__roOE4K2XpjiuAOC2TDR2SaIVapMXBhVZKMUVntxMeW4deU2-PbzCk8qZ1Y3PzMh6NDhFoaKa7nGU2sF8y36ofWxGxZfviz5Caesh95-AMWxIMqgo-LfPo0TOTfeJo1RJOqx-ldCRA6fJ-Ls35g2WpfTz2pbW_YAwIEBov4hkaPLp2ikrwbtczVIEWR69Wk6we0P83ZHMHsB_wEJLgxN872z3XcaQG6ig821XCl5UgmruAT92UxgWZjjci4">
                        </div>
                        <div class="p-4">
                            <span class="text-[10px] font-bold text-primary uppercase mb-1 block">Manajemen</span>
                            <h3 class="font-label-md text-label-md text-on-surface line-clamp-2 mb-1">Manajemen Strategis Bisnis</h3>
                            <p class="text-[12px] text-outline">Prof. Susi Susanti</p>
                        </div>
                    </div>
                    <!-- Book Card 3 -->
                    <div class="group bg-white border border-subtle rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="aspect-[3/4] overflow-hidden bg-surface-container-highest">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Metodologi Penelitian Sains" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC4hjwHCKaH5mlIIeUdP2JOehrDryZXcG0fuI8aPKfCVrX2Kbeq-exbOUr4x5NGretuIzIDWCi-ITqQ_jVnQaYma90idSk629d5bGVCp-HnMV26mwzEawea6xPt0Yo3sKqOzRWYC6CsHxTFib9mnp-AWLjTMJYJplUk6MLKkpF4ym1Is4Mk5GDwgJ3FIX2AaSVIT7u8AIBm5fNJ4q6wD8PSZLuZiJwCio-kDT0w_gect-r8Zx0V6SdAocNXN7iope24SDtoAzumlrI">
                        </div>
                        <div class="p-4">
                            <span class="text-[10px] font-bold text-primary uppercase mb-1 block">Sains</span>
                            <h3 class="font-label-md text-label-md text-on-surface line-clamp-2 mb-1">Metodologi Penelitian Sains</h3>
                            <p class="text-[12px] text-outline">Budi Santoso, Ph.D</p>
                        </div>
                    </div>
                    <!-- Book Card 4 -->
                    <div class="group bg-white border border-subtle rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="aspect-[3/4] overflow-hidden bg-surface-container-highest">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Desain Struktur Bangunan Modern" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTJfrBI8mMtDUgMCJtJ2797HNhxgfwdNIwePsiNLMZvzHcnk4gZunhUTi3i-0XlFcc6-4mpgOBGtcEUQZbARc7q3eRGY-BU1SH_NOFL5TKGpBlQUjFKh12sJxNFWnE3ZMFVmfuinB-k91AwL0Ww2pJPwDvwCc05kS_b3yQC-gpWW5xy3v01VsGgVSUdQ4RNDRg11YlV8piqZZr7PoB508q07LZ2RrBsEdeubMLZj6mwIzuwbIYAQsvBKSoMExuy1u_8QyT46NM1_g">
                        </div>
                        <div class="p-4">
                            <span class="text-[10px] font-bold text-primary uppercase mb-1 block">Arsitektur</span>
                            <h3 class="font-label-md text-label-md text-on-surface line-clamp-2 mb-1">Desain Struktur Bangunan Modern</h3>
                            <p class="text-[12px] text-outline">Ir. Ahmad Dahlan</p>
                        </div>
                    </div>
                    <!-- Book Card 5 -->
                    <div class="group bg-white border border-subtle rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="aspect-[3/4] overflow-hidden bg-surface-container-highest">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Etika Profesi & Hukum Digital" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAVCQTyUTUsPS7deoAFXmfh9HKilzHjtDBFiSXp3R8u5bMY8Fvy8gJaSQwTaPK6dH2PpCU7VXQaV3JzoAC4UMZNLzKtHNQI2acdgfB9NeXOZwWR4cRp09xZWTDk7izXyRmr7AK4EpgbJvRu_GhG4eRA_F9UALl1d7uWcO0YTYXtyxoqw0xhSjkRAkYyI7Y_mnXiUim2385Csrr0F3AbSg_-cJH2aR3YrJ_0qT_Sv3CWHVCzuAsc23pUT91Cwt2xRZCI_xiUWyJ1LUc">
                        </div>
                        <div class="p-4">
                            <span class="text-[10px] font-bold text-primary uppercase mb-1 block">Hukum</span>
                            <h3 class="font-label-md text-label-md text-on-surface line-clamp-2 mb-1">Etika Profesi &amp; Hukum Digital</h3>
                            <p class="text-[12px] text-outline">Siti Aminah, M.H.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Services -->
        <section class="py-16 bg-surface-container">
            <div class="max-w-container-max mx-auto px-margin-desktop">
                <div class="text-center mb-12">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">Layanan Perpustakaan</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">Fasilitas pendukung akademik untuk seluruh Civitas Akademika.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    <!-- Service 1 -->
                    <div class="p-8 bg-white border border-subtle rounded-xl flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-primary-container/10 text-primary rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-[32px]">auto_stories</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-3">E-Book &amp; Jurnal</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Akses ribuan judul buku elektronik dan jurnal internasional terakreditasi secara gratis.</p>
                    </div>
                    <!-- Service 2 -->
                    <div class="p-8 bg-white border border-subtle rounded-xl flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-secondary-container/10 text-secondary rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-[32px]">laptop_mac</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-3">Ruang Multimedia</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Fasilitas komputer dan internet berkecepatan tinggi untuk menunjang riset mahasiswa.</p>
                    </div>
                    <!-- Service 3 -->
                    <div class="p-8 bg-white border border-subtle rounded-xl flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-tertiary-container/10 text-tertiary rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-[32px]">history_edu</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-3">Pengecekan Plagiasi</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Layanan verifikasi orisinalitas karya ilmiah menggunakan software standar industri.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="w-full mt-auto bg-surface-container-low border-t border-subtle">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter max-w-container-max mx-auto px-margin-desktop py-12">
            <div>
                <span class="font-headline-md text-headline-md font-bold text-on-surface mb-4 block">POLNEP Library</span>
                <p class="font-label-md text-label-md text-on-surface-variant max-w-md mb-6">
                    Mencerdaskan kehidupan bangsa melalui penyediaan sumber informasi berkualitas dan aksesibilitas literasi yang inklusif.
                </p>
                <div class="flex gap-4">
                    <a class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white" href="#"><span class="material-symbols-outlined text-sm">public</span></a>
                    <a class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white" href="#"><span class="material-symbols-outlined text-sm">mail</span></a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h4 class="font-label-md text-label-md font-bold text-on-surface mb-4 uppercase">Informasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a class="text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" href="#">Kontak</a></li>
                        <li><a class="text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" href="#">Peta Situs</a></li>
                        <li><a class="text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-label-md text-label-md font-bold text-on-surface mb-4 uppercase">Akademik</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a class="text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" href="#">Aksesibilitas</a></li>
                        <li><a class="text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" href="#">Repositori</a></li>
                        <li><a class="text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" href="#">E-Journal</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-subtle">
            <div class="max-w-container-max mx-auto px-margin-desktop py-6 text-center">
                <p class="font-label-md text-label-md text-on-surface-variant">© 2026 Politeknik Negeri Pontianak. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
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
