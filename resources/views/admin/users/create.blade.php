<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tambah User - SIPUS PSDKU POLNEP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @include('admin.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Tambah User Baru',
            'subtitle' => 'Daftarkan pengguna baru ke dalam sistem perpustakaan.',
            'back_url' => route('admin.users.index')
        ])

        <div class="max-w-3xl" x-data="{ roleName: '{{ old('role_id') ? ($roles->firstWhere('role_id', old('role_id'))->role_name ?? "") : "" }}' }">
            <div class="bg-white rounded-3xl border border-outline-variant/15 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-outline-variant/10 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-lg">Form Registrasi User</h3>
                    <p class="text-xs text-outline mt-0.5">Isi data di bawah ini dengan lengkap untuk mendaftarkan akun baru.</p>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                               placeholder="Nama Lengkap" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-500 text-xs" />
                    </div>

                    <!-- Email & HP -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="nama@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                        <div>
                            <label for="no_hp" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor WhatsApp/HP</label>
                            <input id="no_hp" 
                                   type="text" 
                                   name="no_hp" 
                                   value="{{ old('no_hp') }}" 
                                   required 
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="08XXXXXXXXXX" />
                            <x-input-error :messages="$errors->get('no_hp')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                    </div>

                    <!-- Role & Prodi Selection -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="role_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Role / Peran</label>
                            <select id="role_id" 
                                    name="role_id" 
                                    required 
                                    @change="roleName = $el.options[$el.selectedIndex].getAttribute('data-name')"
                                    class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm">
                                <option value="" disabled data-name="" {{ old('role_id') ? '' : 'selected' }}>Pilih Role / Peran</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->role_id }}" data-name="{{ $role->role_name }}" {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                                        {{ strtoupper($role->role_name) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role_id')" class="mt-2 text-rose-500 text-xs" />
                        </div>

                        <!-- Prodi (Mahasiswa/Dosen only) -->
                        <div x-show="roleName === 'mahasiswa' || roleName === 'dosen'">
                            <label for="prodi_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Program Studi</label>
                            <select id="prodi_id" 
                                    name="prodi_id" 
                                    ::required="roleName === 'mahasiswa' || roleName === 'dosen'"
                                    class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm">
                                <option value="" disabled {{ old('prodi_id') ? '' : 'selected' }}>Pilih Program Studi</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->prodi_id }}" {{ old('prodi_id') == $prodi->prodi_id ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('prodi_id')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                    </div>

                    <!-- DYNAMIC FIELDS -->
                    
                    <!-- MAHASISWA fields -->
                    <div x-show="roleName === 'mahasiswa'" class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-50 p-5 rounded-2xl border border-slate-100 animate-fade-in">
                        <div>
                            <label for="nim" class="block text-sm font-semibold text-slate-700 mb-1.5">NIM</label>
                            <input id="nim" 
                                   type="text" 
                                   name="nim" 
                                   ::required="roleName === 'mahasiswa'"
                                   value="{{ old('nim') }}" 
                                   class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="320231XXXX" />
                            <x-input-error :messages="$errors->get('nim')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                        <div>
                            <label for="semester" class="block text-sm font-semibold text-slate-700 mb-1.5">Semester</label>
                            <select id="semester" 
                                    name="semester" 
                                    ::required="roleName === 'mahasiswa'"
                                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm">
                                <option value="" disabled {{ old('semester') ? '' : 'selected' }}>Pilih Semester</option>
                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('semester')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                    </div>

                    <!-- DOSEN fields -->
                    <div x-show="roleName === 'dosen'" class="bg-slate-50 p-5 rounded-2xl border border-slate-100 animate-fade-in">
                        <div>
                            <label for="nip_dosen" class="block text-sm font-semibold text-slate-700 mb-1.5">NIP</label>
                            <input id="nip_dosen" 
                                   type="text" 
                                   name="nip" 
                                   ::required="roleName === 'dosen'"
                                   value="{{ old('nip') }}" 
                                   class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="1990XXXXXXXXXXXXXXXX" />
                            <x-input-error :messages="$errors->get('nip')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                    </div>

                    <!-- PETUGAS fields -->
                    <div x-show="roleName === 'petugas'" class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-50 p-5 rounded-2xl border border-slate-100 animate-fade-in">
                        <div>
                            <label for="nip_staff" class="block text-sm font-semibold text-slate-700 mb-1.5">NIP</label>
                            <input id="nip_staff" 
                                   type="text" 
                                   name="nip" 
                                   ::required="roleName === 'petugas'"
                                   value="{{ old('nip') }}" 
                                   class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="1985XXXXXXXXXXXXXXXX" />
                            <x-input-error :messages="$errors->get('nip')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                        <div>
                            <label for="jabatan" class="block text-sm font-semibold text-slate-700 mb-1.5">Jabatan / Staff</label>
                            <input id="jabatan" 
                                   type="text" 
                                   name="jabatan" 
                                   value="{{ old('jabatan') }}" 
                                   class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="Kepala Perpus / Staff Administrasi" />
                            <x-input-error :messages="$errors->get('jabatan')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                    </div>

                    <!-- Password Fields -->
                    <div x-show="roleName !== ''" x-transition class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-outline-variant/10">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   ::required="roleName !== ''" 
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="Min. 8 karakter" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password</label>
                            <input id="password_confirmation" 
                                   type="password" 
                                   name="password_confirmation" 
                                   ::required="roleName !== ''" 
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="Ulangi password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-500 text-xs" />
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-outline-variant/10">
                        <a href="{{ route('admin.users.index') }}" 
                           class="py-3 px-6 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-sm transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                                class="py-3 px-6 bg-primary hover:bg-primary/95 text-white font-bold rounded-2xl text-sm shadow-lg shadow-primary/20 transition duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                            Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
