<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Detail Arsip - SIPUS PSDKU POLNEP</title>
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
    @include('petugas.layouts.sidebar')
    
    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Detail ' . $typeDefinition['full_label'],
            'back_url' => route('petugas.arsip.index')
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
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.SIPUSModal.alert('Berkas Tidak Ditemukan', "{!! addslashes(session('error')) !!}", 'danger', { confirmText: 'Paham & Tutup' });
                });
            </script>
        @endif

        <div class="grid gap-8 xl:grid-cols-[1.2fr_.8fr]">
            <div class="space-y-6">
                <section class="rounded-3xl border border-outline-variant/10 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between border-b border-outline-variant/10 pb-4 mb-6">
                        <h2 class="text-xl font-bold text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[24px]">info</span>
                            Informasi Arsip
                        </h2>
                        <a href="{{ route('petugas.arsip.edit', [$archiveType, $archive->getKey()]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-primary/10 hover:bg-primary/20 text-primary font-bold text-xs transition duration-200">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                            Koreksi Data
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-outline uppercase tracking-wider">Status Arsip</span>
                            <div class="inline-block">
                                <span class="rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wide border
                                    {{ $archive->status === 'ditolak' ? 'bg-error/15 text-error border-error/20' : 
                                       ($archive->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 
                                       ($archive->status === 'diverifikasi' ? 'bg-primary/15 text-primary border-primary/20' : 'bg-amber-500/15 text-amber-700 border-amber-500/20')) }}">
                                    {{ $archive->status }}
                                </span>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-outline uppercase tracking-wider">Mahasiswa / NIM</span>
                            <p class="text-sm font-semibold text-on-surface">{{ $archive->mahasiswa?->user?->name ?? '-' }} ({{ $archive->mahasiswa?->nim ?? '-' }})</p>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-outline uppercase tracking-wider">Program Studi</span>
                            <p class="text-sm font-semibold text-on-surface">{{ $archive->mahasiswa?->prodi?->nama_prodi ?? $archive->mahasiswa?->prodi?->prodi_name ?? '-' }}</p>
                        </div>
                        @if ($archiveType === 'laporan-pkl')
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-outline uppercase tracking-wider">Nama Tempat PKL</span>
                            <p class="text-sm font-semibold text-on-surface">{{ $archive->nama_tempat_pkl ?? '-' }}</p>
                        </div>
                        @endif
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-outline uppercase tracking-wider">Tahun Terbit</span>
                            <p class="text-sm font-semibold text-on-surface">{{ $archive->tahun ?? '-' }}</p>
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <span class="block text-xs font-bold text-outline uppercase tracking-wider">Dosen Pembimbing</span>
                            <p class="text-sm font-semibold text-on-surface">{{ $archive->pembimbing ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-outline uppercase tracking-wider">Dosen Penguji 1</span>
                            <p class="text-sm font-semibold text-on-surface">{{ $archive->penguji_1 ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="block text-xs font-bold text-outline uppercase tracking-wider">Dosen Penguji 2</span>
                            <p class="text-sm font-semibold text-on-surface">{{ $archive->penguji_2 ?? '-' }}</p>
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <span class="block text-xs font-bold text-outline uppercase tracking-wider">Nomor Surat Tanda Terima</span>
                            <p class="text-sm font-semibold text-on-surface font-mono">{{ $archive->nomor_surat ?? '-' }}</p>
                        </div>
                    </div>

                    @if($archive->catatan_petugas)
                        <div class="mt-6 rounded-2xl border border-error/20 bg-error/5 p-4 text-sm text-error flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-[20px] mt-0.5">info</span>
                            <div>
                                <span class="font-bold block text-xs uppercase tracking-wide mb-1">Catatan Koreksi / Penolakan Petugas:</span>
                                <p class="text-sm leading-relaxed">{{ $archive->catatan_petugas }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3 border-t border-outline-variant/10 pt-6">
                        @if($archive->file_pdf)
                            <a href="{{ route('petugas.arsip.download', [$archiveType, $archive->getKey()]) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-on-background text-white font-bold text-sm hover:bg-opacity-90 transition duration-200 shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">download</span>
                                Unduh PDF Asli
                            </a>
                        @else
                            <button type="button" onclick="window.SIPUSModal.alert('Berkas PDF Belum Diunggah', 'Mahasiswa belum mengunggah berkas naskah PDF utama untuk arsip karya ilmiah ini.', 'warning', { confirmText: 'Paham & Tutup' })" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold text-sm border border-slate-200 transition duration-200 shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">download</span>
                                Unduh PDF Asli
                            </button>
                        @endif

                        @if($archive->file_word)
                            <a href="{{ route('petugas.arsip.download', [$archiveType, $archive->getKey(), 'kind' => 'word']) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm bg-white hover:bg-slate-50 transition duration-200 shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">description</span>
                                Unduh Word
                            </a>
                        @else
                            <button type="button" onclick="window.SIPUSModal.alert('Berkas Word Belum Diunggah', 'Mahasiswa belum mengunggah berkas dokumen Word (.doc / .docx) untuk arsip karya ilmiah ini.', 'warning', { confirmText: 'Paham & Tutup' })" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl border border-dashed border-outline-variant/40 text-slate-400 hover:text-slate-600 font-bold text-sm bg-slate-50/50 hover:bg-slate-100 transition duration-200">
                                <span class="material-symbols-outlined text-[20px]">description</span>
                                Unduh Word
                            </button>
                        @endif

                        @if($archive->surat_tanda_terima_pdf)
                            <a href="{{ route('petugas.arsip.surat', [$archiveType, $archive->getKey()]) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm bg-white hover:bg-slate-50 transition duration-200 shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">feed</span>
                                Unduh Surat Tanda Terima
                            </a>
                        @else
                            <button type="button" onclick="window.SIPUSModal.alert('Surat Belum Diterbitkan', 'Surat Tanda Terima belum diterbitkan karena arsip ini belum diverifikasi oleh petugas.', 'warning', { confirmText: 'Paham & Tutup' })" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl border border-dashed border-outline-variant/40 text-slate-400 hover:text-slate-600 font-bold text-sm bg-slate-50/50 hover:bg-slate-100 transition duration-200">
                                <span class="material-symbols-outlined text-[20px]">feed</span>
                                Unduh Surat Tanda Terima
                            </button>
                        @endif
                    </div>
                </section>
            </div>

            <div class="space-y-6">
                @if($archive->preview_pdf)
                    <section class="rounded-3xl border border-outline-variant/10 bg-white p-6 shadow-sm">
                        <h2 class="mb-2 text-lg font-bold text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[22px]">find_in_page</span>
                            Berkas Preview
                        </h2>
                        <p class="text-sm text-outline font-medium leading-relaxed">Preview berisi 10 halaman pertama telah berhasil dipotong dan siap ditayangkan pada katalog mahasiswa & dosen.</p>
                    </section>
                @endif

                <section class="rounded-3xl border border-outline-variant/10 bg-white p-6 shadow-sm">
                    <h2 class="mb-4 text-lg font-bold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">check_box</span>
                        Aksi Petugas
                    </h2>
                    <div class="space-y-4">
                        @if($archive->status === 'pending')
                            <form action="{{ route('petugas.arsip.verify', [$archiveType, $archive->getKey()]) }}" method="POST">
                                @csrf
                                <button class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-primary hover:bg-primary/95 text-white font-bold px-5 py-3.5 text-sm shadow-lg shadow-primary/20 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                                    <span class="material-symbols-outlined text-[20px]">verified</span>
                                    Verifikasi & Kirim Email Surat
                                </button>
                            </form>
                        @endif

                        @if(in_array($archive->status, ['pending', 'diverifikasi'], true))
                            <form action="{{ route('petugas.arsip.reject', [$archiveType, $archive->getKey()]) }}" method="POST" class="space-y-3 {{ $archive->status === 'pending' ? 'border-t border-outline-variant/10 pt-4' : '' }}">
                                @csrf
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold text-outline uppercase tracking-wider">Alasan Penolakan / Koreksi</label>
                                    <textarea name="catatan_petugas" rows="3" placeholder="Tuliskan catatan detail mengapa berkas ditolak atau bagian mana yang perlu diperbaiki oleh mahasiswa..." class="w-full rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all px-4 py-3" required></textarea>
                                </div>
                                <button class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-error hover:bg-error/95 text-white font-bold px-5 py-3.5 text-sm shadow-lg shadow-error/20 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                                    <span class="material-symbols-outlined text-[20px]">cancel</span>
                                    Tolak & Minta Koreksi
                                </button>
                            </form>
                        @endif

                        @if($archive->status === 'diverifikasi')
                            <form action="{{ route('petugas.arsip.confirm', [$archiveType, $archive->getKey()]) }}" method="POST" class="border-t border-outline-variant/10 pt-4">
                                @csrf
                                <button class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-3.5 text-sm shadow-lg shadow-emerald-600/20 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                                    <span class="material-symbols-outlined text-[20px]">task_alt</span>
                                    Konfirmasi Terima Fisik
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('petugas.arsip.destroy', [$archiveType, $archive->getKey()]) }}" method="POST" onsubmit="return confirm('Hapus arsip ini secara permanen? Tindakan ini tidak dapat dibatalkan.')" class="border-t border-outline-variant/10 pt-4">
                            @csrf
                            @method('DELETE')
                            <button class="w-full inline-flex items-center justify-center gap-2 rounded-2xl border border-error/30 bg-white hover:bg-error/5 text-error font-bold px-5 py-3 text-sm transition duration-200">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                Hapus Arsip Permanen
                            </button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>
