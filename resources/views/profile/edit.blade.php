@php
    $user = Auth::user();
    $roleName = $user->role->role_name ?? '';
@endphp
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Profil Saya - SIPUS PSDKU POLNEP</title>
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
<body class="font-body-md text-body-md antialiased min-h-screen flex">

    <!-- 1. SIDEBAR NAV DINAMIS BERDASARKAN ROLE -->
    @if($roleName === 'admin')
        @include('admin.layouts.sidebar')
    @elseif($roleName === 'petugas')
        @include('petugas.layouts.sidebar')
    @elseif($roleName === 'dosen')
        @include('dosen.layouts.sidebar')
    @elseif($roleName === 'mahasiswa')
        @include('mahasiswa.layouts.sidebar')
    @endif

    <!-- 2. MAIN CONTENT DINAMIS DENGAN OFFSET SIDEBAR -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        
        @include('layouts.header', [
            'title' => 'Profil Saya',
            'subtitle' => 'Kelola kredensial login, data personal, dan kata sandi keamanan Anda.'
        ])

        <!-- FORM KONTEN PROFIL -->
        <div class="max-w-4xl space-y-8">
            
            <!-- Card 1: Informasi Profil -->
            <div class="bg-white rounded-3xl border border-outline-variant/100 p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-outline-variant/100">
                    <span class="material-symbols-outlined text-primary text-3xl">badge</span>
                    <div>
                        <h2 class="font-headline-md text-lg text-on-surface">Informasi Profil</h2>
                        <p class="text-xs text-outline">Perbarui informasi dasar profil dan alamat email akun Anda.</p>
                    </div>
                </div>
                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Card 2: Update Password -->
            <div class="bg-white rounded-3xl border border-outline-variant/100 p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-outline-variant/100">
                    <span class="material-symbols-outlined text-primary text-3xl">lock</span>
                    <div>
                        <h2 class="font-headline-md text-lg text-on-surface">Perbarui Kata Sandi</h2>
                        <p class="text-xs text-outline">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak demi keamanan.</p>
                    </div>
                </div>
                <div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Card 3: Delete Account (Hanya Tampil Jika Diizinkan) -->
            <div class="bg-white rounded-3xl border border-outline-variant/100 p-8 shadow-sm">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-outline-variant/100">
                    <span class="material-symbols-outlined text-error text-3xl">no_accounts</span>
                    <div>
                        <h2 class="font-headline-md text-lg text-error">Hapus Akun</h2>
                        <p class="text-xs text-outline">Setelah akun Anda dihapus, semua data terkait akan dihapus secara permanen.</p>
                    </div>
                </div>
                <div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </main>

    @php 
        $rawBot = \App\Models\AppSetting::get('telegram_bot_username', 'SipusPolnep_bot');
        $cleanBot = ltrim(trim($rawBot), '@') ?: 'SipusPolnep_bot';
    @endphp

    <!-- MODAL PANDUAN CARI CHAT ID -->
    <div id="modal-help-chatid" class="fixed inset-0 z-[99999] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl space-y-6 my-auto relative animate-in fade-in zoom-in duration-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3 text-sky-600">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-2xl">help</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-base text-slate-800">Cara Cek Chat ID Telegram</h3>
                        <p class="text-xs text-slate-400">Ikuti 3 langkah mudah berikut ini</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="document.getElementById('modal-help-chatid').classList.add('hidden')" 
                        class="text-slate-400 hover:text-slate-600 rounded-full p-1.5 hover:bg-slate-100 transition-colors">
                    <span class="material-symbols-outlined text-xl block">close</span>
                </button>
            </div>

            <div class="space-y-4 text-xs text-slate-600 leading-relaxed">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-150 space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-sky-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">1</span>
                        <div class="space-y-1">
                            <p class="font-bold text-slate-800">Cek Chat ID Anda di Telegram</p>
                            <p class="text-slate-500">Klik tombol di bawah untuk membuka bot resmi penginfo ID Telegram:</p>
                            <div class="pt-1">
                                <a href="https://t.me/userinfobot" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-3.5 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-bold text-xs transition-colors shadow-sm shadow-sky-200">
                                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    <span>Buka @userinfobot</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-sky-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">2</span>
                        <div class="space-y-1">
                            <p class="font-bold text-slate-800">Salin Deretan Angka 'Id'</p>
                            <p class="text-slate-500">Bot akan membalas info akun Anda. Salin deretan angka pada baris <strong>Id</strong> (misal: <code>123456789</code>).</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-sky-600 text-white font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">3</span>
                        <div class="space-y-1">
                            <p class="font-bold text-slate-800">Tempel & Simpan</p>
                            <p class="text-slate-500">Kembali ke halaman profil ini, tempel angka tersebut di kolom <strong>Telegram Chat ID</strong>, lalu klik <strong>Save</strong>.</p>
                        </div>
                    </div>
                </div>

                <div class="p-3.5 bg-amber-50 border border-amber-200 text-amber-900 rounded-2xl flex items-start gap-2.5 text-xs">
                    <span class="material-symbols-outlined text-amber-600 text-lg shrink-0 mt-0.5">warning</span>
                    <span><strong>Penting:</strong> Setelah menyimpan Chat ID, pastikan Anda mengeklik tombol <strong>"Buka Bot"</strong> dan menekan <strong>START</strong> pada bot Telegram perpustakaan agar notifikasi dapat terkirim.</span>
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" 
                        onclick="document.getElementById('modal-help-chatid').classList.add('hidden')" 
                        class="w-full sm:w-auto px-6 py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs rounded-2xl transition-all shadow-md">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</body>
</html>
