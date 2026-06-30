<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tambah Anggota Baru - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
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
            background-color: #00a5c0;
            /* POLNEP Turquoise */
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
    <!-- Sidebar Navigation -->
    @include('petugas.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen" x-data="{ 
            roleId: '{{ old('role_id', $roles->first()->role_id ?? '') }}',
            rolesMap: {
                @foreach($roles as $r)
                    '{{ $r->role_id }}': '{{ $r->role_name }}',
                @endforeach
            },
            get roleName() {
                return this.rolesMap[this.roleId] || 'mahasiswa';
            }
        }">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Tambah Anggota Perpustakaan</h1>
                <p class="text-sm text-outline">Daftarkan akun dan profil akademik mahasiswa atau dosen baru.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">Petugas Perpustakaan</p>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true" />
                </div>
            </div>
        </header>

        <!-- Form Card Container -->
        <section class="max-w-6xl bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
            <form action="{{ route('petugas.members.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Basic User Info Section -->
                <div class="border-b border-outline-variant/10 pb-6">
                    <h3
                        class="text-sm font-bold text-on-surface-variant mb-4 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">account_box</span>
                        Informasi Akun Dasar
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="space-y-2">
                            <label for="name" class="block text-xs font-bold text-outline uppercase tracking-wider">Nama
                                Lengkap</label>
                            <input type="text" name="name" id="name" placeholder="Nama Lengkap"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                value="{{ old('name') }}" required />
                            @error('name')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Email -->
                        <div class="space-y-2">
                            <label for="email"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Alamat
                                Email</label>
                            <input type="email" name="email" id="email" placeholder="example@gmail.com"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                value="{{ old('email') }}" required />
                            @error('email')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div class="space-y-2">
                            <label for="no_hp"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Nomor Handphone
                                (WhatsApp)</label>
                            <input type="text" name="no_hp" id="no_hp" placeholder="0812345xxxx"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                value="{{ old('no_hp') }}" required />
                            @error('no_hp')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Peran / Role -->
                        <div class="space-y-2">
                            <label for="role_id"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Jenis
                                Keanggotaan</label>
                            <select name="role_id" id="role_id" x-model="roleId"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all"
                                required>
                                @foreach($roles as $r)
                                    <option value="{{ $r->role_id }}">{{ ucfirst($r->role_name) }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Academic Info Section (Dynamic based on selected role) -->
                <div class="border-b border-outline-variant/10 pb-6">
                    <h3
                        class="text-sm font-bold text-on-surface-variant mb-4 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">school</span>
                        Informasi Akademik
                    </h3>

                    <!-- Mahasiswa fields -->
                    <div x-show="roleName === 'mahasiswa'" class="grid grid-cols-1 md:grid-cols-3 gap-6" x-transition>
                        <!-- NIM -->
                        <div class="space-y-2">
                            <label for="nim" class="block text-xs font-bold text-outline uppercase tracking-wider">Nomor
                                Induk Mahasiswa (NIM)</label>
                            <input type="text" name="nim" id="nim" placeholder="Masukkan NIM"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                value="{{ old('nim') }}" :required="roleName === 'mahasiswa'" />
                            @error('nim')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prodi -->
                        <div class="space-y-2">
                            <label for="prodi_id_mhs"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Program
                                Studi</label>
                            <select name="prodi_id" id="prodi_id_mhs"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all"
                                :required="roleName === 'mahasiswa'">
                                <option value="" disabled selected>Pilih Program Studi</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->prodi_id }}" {{ old('prodi_id') == $p->prodi_id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                            @error('prodi_id')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Semester -->
                        <div class="space-y-2">
                            <label for="semester"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Semester</label>
                            <input type="number" name="semester" id="semester" placeholder="Semester (1-14)" min="1"
                                max="14"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                value="{{ old('semester', 1) }}" :required="roleName === 'mahasiswa'" />
                            @error('semester')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Dosen fields -->
                    <div x-show="roleName === 'dosen'" class="grid grid-cols-1 md:grid-cols-2 gap-6" x-transition>
                        <!-- NIP -->
                        <div class="space-y-2">
                            <label for="nip" class="block text-xs font-bold text-outline uppercase tracking-wider">Nomor
                                Induk Pegawai (NIP)</label>
                            <input type="text" name="nip" id="nip" placeholder="Masukkan NIP Dosen"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                value="{{ old('nip') }}" :required="roleName === 'dosen'" />
                            @error('nip')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prodi -->
                        <div class="space-y-2">
                            <label for="prodi_id_dsn"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Program
                                Studi</label>
                            <select name="prodi_id" id="prodi_id_dsn"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all"
                                :required="roleName === 'dosen'">
                                <option value="" disabled selected>Pilih Program Studi</option>
                                @foreach($prodis as $p)
                                    <option value="{{ $p->prodi_id }}" {{ old('prodi_id') == $p->prodi_id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                            @error('prodi_id')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Info -->
                <div class="pb-4">
                    <h3
                        class="text-sm font-bold text-on-surface-variant mb-4 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">lock</span>
                        Keamanan & Sandi
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Password
                                Akun</label>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                required />
                            @error('password')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Konfirmasi
                                Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                required />
                        </div>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex justify-end gap-4 border-t border-outline-variant/10 pt-6">
                    <a href="{{ route('petugas.members.index') }}"
                        class="px-8 py-4 rounded-2xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm hover:bg-slate-50 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center gap-2 px-8 py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Anggota Baru
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>