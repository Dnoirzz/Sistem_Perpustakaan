<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Upload Arsip Digital - SIPUS PSDKU POLNEP</title>
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
        @include('layouts.header', [
            'title' => 'Upload Arsip Digital',
            'subtitle' => 'Unggah arsip PKL, Proposal TA, atau Laporan TA beserta riwayat verifikasinya.'
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
        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-800">
                <p class="mb-2 font-bold flex items-center gap-1.5"><span class="material-symbols-outlined text-[18px]">warning</span> Form pengajuan arsip belum lengkap:</p>
                <ul class="list-disc pl-5 font-semibold space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-8 xl:grid-cols-[1fr_0.8fr]">
            <section class="rounded-3xl border border-outline-variant/100 bg-white p-8 shadow-sm">
                <h2 class="mb-6 text-xl font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[24px]">cloud_upload</span>
                    Form Upload Arsip
                </h2>
                
                <form action="{{ route('mahasiswa.arsip.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5" x-data="{ type: '{{ old('type', $typeOptions[0]['value'] ?? 'laporan-pkl') }}' }" onsubmit="return validatePengujiForm(this)">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Jenis Arsip <span class="text-error">*</span></label>
                        <select name="type" x-model="type" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required oninvalid="this.setCustomValidity('Jenis arsip wajib dipilih')" oninput="this.setCustomValidity('')">
                            @foreach($typeOptions as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Nama Tempat PKL (Hanya muncul jika Laporan PKL) -->
                    <div x-show="type === 'laporan-pkl'" x-transition class="space-y-2">
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Nama Tempat PKL <span class="text-error">*</span></label>
                        <input type="text" name="nama_tempat_pkl" :required="type === 'laporan-pkl'" value="{{ old('nama_tempat_pkl') }}" placeholder="Masukkan Nama Instansi/Perusahaan Tempat PKL" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" oninvalid="this.setCustomValidity('Nama tempat PKL wajib diisi')" oninput="this.setCustomValidity('')">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Judul Arsip <span class="text-error">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Masukkan Judul Laporan" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required oninvalid="this.setCustomValidity('Judul arsip wajib diisi')" oninput="this.setCustomValidity('')">
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Dosen Pembimbing <span class="text-error">*</span></label>
                            <input type="text" name="pembimbing" value="{{ old('pembimbing') }}" placeholder="Nama Pembimbing" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required oninvalid="this.setCustomValidity('Nama dosen pembimbing wajib diisi')" oninput="this.setCustomValidity('')">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Tahun Terbit <span class="text-error">*</span></label>
                            <input type="number" name="tahun" value="{{ old('tahun') }}" placeholder="Tahun" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required oninvalid="this.setCustomValidity('Tahun terbit wajib diisi')" oninput="this.setCustomValidity('')">
                        </div>
                    </div>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Dosen Penguji 1</label>
                            <input type="text" name="penguji_1" value="{{ old('penguji_1') }}" placeholder="Nama Penguji 1" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Dosen Penguji 2</label>
                            <input type="text" name="penguji_2" value="{{ old('penguji_2') }}" placeholder="Nama Penguji 2" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">File PDF <span class="text-error">*</span></label>
                        <input type="file" name="file_pdf" accept="application/pdf" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-outline bg-slate-50 transition-all" required oninvalid="this.setCustomValidity('File PDF utama wajib diunggah')" oninput="this.setCustomValidity('')">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">File Word <span class="text-error">*</span></label>
                        <input type="file" name="file_word" accept=".doc,.docx" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-outline bg-slate-50 transition-all" required oninvalid="this.setCustomValidity('File Word wajib diunggah')" oninput="this.setCustomValidity('')">
                    </div>
                    <button class="w-full flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm">
                        <span class="material-symbols-outlined text-[18px]">send</span>
                        Kirim Arsip Ke Perpustakaan
                    </button>
                </form>

                <script>
                    function validatePengujiForm(form) {
                        const p1 = form.querySelector('input[name="penguji_1"]');
                        const p2 = form.querySelector('input[name="penguji_2"]');
                        if (!p1 || !p2) return true;
                        
                        if (!p1.value.trim() && !p2.value.trim()) {
                            p1.setCustomValidity('Isikan minimal satu penguji');
                            p1.reportValidity();
                            return false;
                        } else {
                            p1.setCustomValidity('');
                            p2.setCustomValidity('');
                            return true;
                        }
                    }
                    document.addEventListener('DOMContentLoaded', () => {
                        ['penguji_1', 'penguji_2'].forEach(name => {
                            const el = document.querySelector(`input[name="${name}"]`);
                            if (el) {
                                el.addEventListener('input', () => {
                                    const p1 = document.querySelector('input[name="penguji_1"]');
                                    const p2 = document.querySelector('input[name="penguji_2"]');
                                    if (p1) p1.setCustomValidity('');
                                    if (p2) p2.setCustomValidity('');
                                });
                            }
                        });
                    });
                </script>
            </section>

            <section class="rounded-3xl border border-outline-variant/100 bg-white p-8 shadow-sm">
                <h2 class="mb-6 text-xl font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[24px]">history</span>
                    Riwayat Arsip Saya
                </h2>
                
                <div class="space-y-4 max-h-[720px] overflow-y-auto pr-2">
                    @forelse($archives as $item)
                        <article class="rounded-2xl border border-outline-variant/100 p-5 hover:shadow-md transition duration-200 bg-white">
                            <div class="flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <span class="mb-2 inline-block text-xs font-bold uppercase tracking-wide text-primary bg-primary/10 px-2.5 py-0.5 rounded-full whitespace-nowrap">{{ $item['type_label'] }}</span>
                                    <h3 class="text-[16px] font-bold text-on-surface line-clamp-2 mt-1">{{ $item['title'] }}</h3>
                                    <p class="mt-2 text-xs text-outline font-semibold flex flex-wrap items-center gap-2">
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">calendar_month</span> Tahun {{ $item['year'] ?? '-' }}</span>
                                        <span class="text-outline-variant">•</span> 
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">person</span> Pembimbing: {{ $item['pembimbing'] ?? '-' }}</span>
                                        @if($item['type'] === 'laporan-pkl' && !empty($item['nama_tempat_pkl']))
                                            <span class="text-outline-variant">•</span> 
                                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">corporate_fare</span> Tempat PKL: {{ $item['nama_tempat_pkl'] }}</span>
                                        @endif
                                    </p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wide border whitespace-nowrap
                                    {{ $item['status'] === 'ditolak' ? 'bg-error/15 text-error border-error/20' : 
                                       ($item['status'] === 'aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                                       ($item['status'] === 'diverifikasi' ? 'bg-primary/15 text-primary border-primary/20' : 'bg-amber-500/15 text-amber-700 border-amber-500/20')) }}">
                                    {{ $item['status'] }}
                                </span>
                            </div>
                            
                            @if($item['model']->catatan_petugas)
                                <div class="mt-4 rounded-2xl border border-error/20 bg-error/5 p-4 text-xs text-error flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[18px] mt-0.5">info</span>
                                    <div>
                                        <span class="font-bold block uppercase tracking-wide mb-1 text-[10px]">Catatan Koreksi Petugas:</span>
                                        <p class="leading-relaxed font-semibold">{{ $item['model']->catatan_petugas }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mt-4 flex flex-wrap gap-2 border-t border-outline-variant/10 pt-4">
                                @if(in_array($item['status'], ['pending', 'ditolak'], true))
                                    <a href="{{ route('mahasiswa.arsip.edit', [$item['type'], $item['id']]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-primary hover:bg-primary/10 border border-primary/20 rounded-2xl transition duration-200">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                        Koreksi Data
                                    </a>
                                    <form action="{{ route('mahasiswa.arsip.destroy', [$item['type'], $item['id']]) }}" method="POST" onsubmit="return confirm('Hapus arsip ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-error hover:bg-error/10 border border-error/20 rounded-2xl transition duration-200">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <p class="text-[11px] text-outline font-semibold flex items-center gap-1 mt-1">
                                        <span class="material-symbols-outlined text-[14px]">lock</span>
                                        Arsip telah diverifikasi/aktif. Kontak petugas jika butuh perubahan berkas.
                                    </p>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-outline-variant/10 bg-slate-50/50 p-8 text-center text-outline font-semibold">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-4xl text-outline-variant">folder_open</span>
                                <span>Belum ada arsip yang Anda unggah.</span>
                            </div>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </main>
</body>
</html>
