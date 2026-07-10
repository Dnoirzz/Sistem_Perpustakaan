<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Edit Arsip - SIPUS PSDKU POLNEP</title>
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
    @include('mahasiswa.layouts.sidebar')
    
    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('mahasiswa.arsip.index') }}" class="w-10 h-10 rounded-xl bg-white text-slate-650 hover:bg-slate-100 transition duration-200 flex items-center justify-center border border-outline-variant/15 shadow-sm">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-primary">{{ $typeLabel }}</span>
                    <h1 class="font-headline-md text-on-surface">Edit Arsip</h1>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">Mahasiswa</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
                </div>
            </div>
        </header>

        <section class="max-w-4xl rounded-3xl border border-outline-variant/10 bg-white p-8 shadow-sm">
            <form action="{{ route('mahasiswa.arsip.update', [$archiveType, $archive->getKey()]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="{{ $archiveType }}">
                
                <div>
                    <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Judul Arsip <span class="text-error">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $archiveTitle) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required>
                </div>
                
                @if ($archiveType === 'laporan-pkl')
                    <div>
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Nama Tempat PKL <span class="text-error">*</span></label>
                        <input type="text" name="nama_tempat_pkl" value="{{ old('nama_tempat_pkl', $archive->nama_tempat_pkl) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required>
                    </div>
                @endif
                
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Pembimbing <span class="text-error">*</span></label>
                        <input type="text" name="pembimbing" value="{{ old('pembimbing', $archive->pembimbing) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Tahun Terbit <span class="text-error">*</span></label>
                        <input type="number" name="tahun" value="{{ old('tahun', $archive->tahun) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required>
                    </div>
                </div>
                
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Penguji 1 <span class="text-error">*</span></label>
                        <input type="text" name="penguji_1" value="{{ old('penguji_1', $archive->penguji_1) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Penguji 2 <span class="text-error">*</span></label>
                        <input type="text" name="penguji_2" value="{{ old('penguji_2', $archive->penguji_2) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required>
                    </div>
                </div>
                
                <div class="border-t border-outline-variant/10 pt-6">
                    <h3 class="text-sm font-bold text-on-surface-variant mb-4 uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">cloud_upload</span>
                        Ganti File Berkas (Opsional)
                    </h3>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Ganti PDF Utama</label>
                            <input type="file" name="file_pdf" accept="application/pdf" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-outline bg-slate-50 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Ganti File Word</label>
                            <input type="file" name="file_word" accept=".doc,.docx" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-outline bg-slate-50 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex justify-end gap-4 border-t border-outline-variant/10 pt-6 mt-8">
                    <a href="{{ route('mahasiswa.arsip.index') }}"
                        class="px-8 py-4 rounded-2xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm hover:bg-slate-50 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex items-center gap-2 px-8 py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
