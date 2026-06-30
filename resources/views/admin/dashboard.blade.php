<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard Admin - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
    @include('admin.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Dashboard Admin</h1>
                <p class="text-sm text-outline">Selamat datang kembali di pusat kontrol sistem perpustakaan.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">Role: Administrator</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
                </div>
            </div>
        </header>

        <!-- Hero Banner Section -->
        <section class="mb-10 relative overflow-hidden rounded-3xl hero-pattern p-10 text-on-primary shadow-xl shadow-primary/20">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="max-w-xl">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[10px] font-bold uppercase tracking-widest border border-white/20">Administrator</span>
                    </div>
                    <h2 class="font-display-lg text-headline-lg mb-2">Halo, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                    <p class="font-body-md opacity-90 mb-8 max-w-lg">Selamat datang di panel kontrol administrator SIPUS PSDKU POLNEP Sukamara. Di sini Anda dapat memantau aktivitas sistem, mengelola anggota dan petugas perpustakaan.</p>
                    
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-white text-primary font-bold shadow-lg hover:bg-slate-50 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                        <span class="material-symbols-outlined">manage_accounts</span>
                        Kelola Pengguna Sekarang
                    </a>
                </div>
                <div class="hidden lg:block">
                    <div class="w-64 h-64 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/10 animate-pulse">
                        <span class="material-symbols-outlined text-[120px] opacity-40">admin_panel_settings</span>
                    </div>
                </div>
            </div>
            <!-- Decorative circle -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl"></div>
        </section>

        <!-- Stats Section -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Total Pengguna -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Pengguna</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Total Pengguna</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-on-surface">{{ $stats['total_users'] }}</span>
                    <span class="text-xs text-outline font-semibold">orang</span>
                </div>
            </div>
            
            <!-- Mahasiswa -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined">school</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Mahasiswa</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Mahasiswa Terdaftar</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-on-surface">{{ $stats['total_mahasiswa'] }}</span>
                    <span class="text-xs text-outline font-semibold">orang</span>
                </div>
            </div>

            <!-- Dosen -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                        <span class="material-symbols-outlined">co_present</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Dosen</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Dosen Terdaftar</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-on-surface">{{ $stats['total_dosen'] }}</span>
                    <span class="text-xs text-outline font-semibold">orang</span>
                </div>
            </div>

            <!-- Petugas -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <span class="material-symbols-outlined">badge</span>
                    </div>
                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Petugas</span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Petugas Perpustakaan</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-on-surface">{{ $stats['total_petugas'] }}</span>
                    <span class="text-xs text-outline font-semibold">orang</span>
                </div>
            </div>
        </section>

        <!-- Charts Section -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Line Chart: Tren Peminjaman -->
            <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm">
                <h3 class="text-sm font-bold text-on-surface mb-4">Tren Peminjaman Bulanan ({{ date('Y') }})</h3>
                <div class="h-64 relative">
                    <canvas id="chartTrenPeminjaman"></canvas>
                </div>
            </div>

            <!-- Pie Chart: Distribusi Kategori -->
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm flex flex-col justify-between">
                <h3 class="text-sm font-bold text-on-surface mb-4">Distribusi Kategori Populer</h3>
                <div class="h-64 relative flex items-center justify-center">
                    @if(count($categoryLabels) > 0)
                        <canvas id="chartKategoriPopuler"></canvas>
                    @else
                        <div class="text-xs text-outline font-medium">Belum ada data sirkulasi kategori buku.</div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Recent Users Table -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Recent Users Section -->
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
                    <div class="p-8 border-b border-outline-variant/10 flex items-center justify-between">
                        <div>
                            <h2 class="font-headline-md text-on-surface">Pendaftar Terbaru</h2>
                            <p class="text-sm text-outline">Pengguna terdaftar baru-baru ini dalam sistem.</p>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="text-primary font-label-md text-sm hover:underline">Kelola Anggota</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-surface-container-low/50">
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Nama</th>
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Email / HP</th>
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Role</th>
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Tgl Daftar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse($recentUsers as $user)
                                    <tr class="hover:bg-surface-container-low/30 transition-colors">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase">
                                                    {{ substr($user->name, 0, 2) }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="font-semibold text-on-surface text-sm">{{ $user->name }}</span>
                                                    <span class="text-[10px] text-outline">ID: #{{ $user->id }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-sm text-on-surface-variant">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-medium">{{ $user->email }}</span>
                                                <span class="text-xs text-outline">{{ $user->no_hp ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            @if($user->role->role_name === 'admin')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-[10px] font-bold uppercase tracking-wide">
                                                    Admin
                                                </span>
                                            @elseif($user->role->role_name === 'petugas')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold uppercase tracking-wide">
                                                    Petugas
                                                </span>
                                            @elseif($user->role->role_name === 'dosen')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wide">
                                                    Dosen
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wide">
                                                    Mahasiswa
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-5 text-xs text-outline font-semibold">
                                            {{ $user->created_at->translatedFormat('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-8 text-center text-outline font-medium">Belum ada pengguna terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <!-- Right Column: Sidebar Widgets -->
            <div class="space-y-8">
                <!-- Status Sistem Widget -->
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-headline-md text-on-surface text-lg">Status Sistem</h2>
                        <span class="material-symbols-outlined text-primary">dns</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-outline-variant/10 text-xs">
                            <span class="text-outline font-medium">Database</span>
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Connected
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-outline-variant/10 text-xs">
                            <span class="text-outline font-medium">Waktu Server</span>
                            <span class="font-semibold text-on-surface-variant">{{ now()->translatedFormat('H:i') }} WIB</span>
                        </div>
                        <div class="flex justify-between items-center py-2 text-xs">
                            <span class="text-outline font-medium">Platform</span>
                            <span class="font-semibold text-on-surface-variant">Laravel 11 / PHP 8.2</span>
                        </div>
                    </div>
                </section>

                <!-- Audit Log / Info Widget -->
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="font-headline-md text-on-surface text-lg">Keamanan & Audit</h2>
                        <span class="material-symbols-outlined text-primary">security</span>
                    </div>
                    <div class="space-y-6">
                        <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 flex gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 flex-shrink-0 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined text-[20px]">verified_user</span>
                            </div>
                            <div>
                                <p class="text-xs text-blue-800 font-semibold mb-1">Log Audit Aktif</p>
                                <p class="text-[11px] text-blue-700 opacity-95">Setiap perubahan akun, role, dan data master terekam secara otomatis oleh log aktivitas sistem.</p>
                            </div>
                        </div>
                        <div class="p-4 bg-purple-50/50 rounded-2xl border border-purple-100 flex gap-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 flex-shrink-0 flex items-center justify-center text-purple-600">
                                <span class="material-symbols-outlined text-[20px]">backup</span>
                            </div>
                            <div>
                                <p class="text-xs text-purple-800 font-semibold mb-1">Backup Otomatis</p>
                                <p class="text-[11px] text-purple-700 opacity-95">Pencadangan basis data MySQL dijadwalkan secara berkala untuk mencegah kehilangan data.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Quick Control Widget -->
                <section class="bg-gradient-to-br from-primary to-primary-container rounded-3xl shadow-lg p-8 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-headline-md text-lg mb-2">Kontrol Cepat</h3>
                        <p class="text-xs opacity-70 mb-6">Kelola dan pantau seluruh operasi dari satu genggaman.</p>
                        
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.create') }}" class="flex items-center justify-between p-3 rounded-2xl bg-white/10 hover:bg-white/20 transition-all text-xs font-bold border border-white/15">
                                <span>Tambah Pengguna Baru</span>
                                <span class="material-symbols-outlined text-[16px]">person_add</span>
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between p-3 rounded-2xl bg-white/10 hover:bg-white/20 transition-all text-xs font-bold border border-white/15">
                                <span>Kelola Semua Akun</span>
                                <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
                            </a>
                        </div>
                    </div>
                    <!-- Decorative element -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
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

        // Initialize Tren Peminjaman Chart
        const ctxLine = document.getElementById('chartTrenPeminjaman').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Peminjaman',
                    data: {!! json_encode($monthlyLoans) !!},
                    borderColor: '#00a5c0',
                    backgroundColor: 'rgba(0, 165, 192, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1 } 
                    }
                }
            }
        });

        // Initialize Kategori Populer Chart
        const hasCategories = {{ count($categoryLabels) > 0 ? 'true' : 'false' }};
        if (hasCategories) {
            const ctxPie = document.getElementById('chartKategoriPopuler').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($categoryLabels) !!},
                    datasets: [{
                        data: {!! json_encode($categoryCounts) !!},
                        backgroundColor: ['#00a5c0', '#4edea3', '#ffb2b7', '#bf0f3c', '#006c49']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { boxWidth: 12, font: { size: 10 } } 
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
