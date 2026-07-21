<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Import Arsip Digital - SIPUS PSDKU POLNEP</title>
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
    @include('petugas.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('petugas.arsip.index') }}" class="w-10 h-10 rounded-xl bg-white text-slate-650 hover:bg-slate-100 transition duration-200 flex items-center justify-center border border-outline-variant/15 shadow-sm animate-fade-in">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-headline-md text-on-surface">Import Arsip via Excel</h1>
                    <p class="text-sm text-outline">Tambahkan data arsip digital mahasiswa secara massal menggunakan berkas template Excel.</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">{{ Auth::user()->petugas?->jabatan ?? 'Petugas Perpustakaan' }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
                </div>
            </div>
        </header>

        <!-- Success Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-3xl flex items-center gap-3 shadow-sm shadow-emerald-50 animate-fade-in">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left: Upload Form Card -->
            <div class="lg:col-span-7 bg-white rounded-3xl border border-outline-variant/15 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-outline-variant/10 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-lg">Unggah Berkas Template</h3>
                    <p class="text-xs text-outline mt-0.5">Berkas yang didukung adalah .xlsx, .xls, atau .csv (Maksimal 10MB)</p>
                </div>

                <form action="{{ route('petugas.arsip.import') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    <!-- Jenis Arsip Dropdown -->
                    <div>
                        <label for="archive-type-select" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jenis Arsip</label>
                        <select id="archive-type-select" 
                                name="type" 
                                class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 font-semibold focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm">
                            @foreach($typeOptions as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2 text-rose-500 text-xs font-semibold" />
                    </div>

                    <!-- Dropzone -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Berkas Excel / CSV</label>
                        <div id="drop-zone" class="border-2 border-dashed border-slate-200 hover:border-primary/50 rounded-3xl p-8 text-center cursor-pointer transition bg-slate-50/50 hover:bg-slate-50 flex flex-col items-center justify-center gap-3">
                            <span class="material-symbols-outlined text-[48px] text-slate-400">cloud_upload</span>
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-slate-700">Tarik dan jatuhkan berkas di sini</p>
                                <p class="text-xs text-outline">atau klik untuk memilih berkas secara manual</p>
                            </div>
                            <input type="file" id="file-input" name="file" class="hidden" accept=".xlsx,.xls,.csv" required>
                        </div>
                        <!-- File indicator -->
                        <div id="file-indicator" class="hidden mt-4 p-4 bg-primary-container/20 border border-primary/20 rounded-2xl items-center justify-between text-sm text-primary font-semibold animate-fade-in">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined">description</span>
                                <span id="file-name">template_import.xlsx</span>
                            </div>
                            <button type="button" id="remove-file-btn" class="text-rose-500 hover:text-rose-600 transition flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">cancel</span>
                            </button>
                        </div>
                        
                        <x-input-error :messages="$errors->get('file')" class="mt-2 text-rose-500 text-xs font-semibold" />
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-outline-variant/10">
                        <a href="{{ route('petugas.arsip.index') }}" 
                           class="py-3 px-6 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-xs transition duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                                class="py-3 px-6 bg-primary hover:bg-primary/95 text-white font-bold rounded-2xl text-xs shadow-lg shadow-primary/20 transition duration-200 flex items-center gap-1.5 transform hover:-translate-y-0.5 active:translate-y-0">
                            <span class="material-symbols-outlined text-[18px]">publish</span>
                            Mulai Import Data
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Guideline Card -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Template Download Card -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/15 shadow-sm space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-sm border border-emerald-100">
                            <span class="material-symbols-outlined text-[24px]">download_for_offline</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-base">Unduh Template Excel</h4>
                            <p class="text-xs text-outline mt-0.5">Sesuaikan dengan jenis berkas terpilih.</p>
                        </div>
                    </div>
                    <a id="download-template-btn" href="{{ route('petugas.arsip.import.template') }}?type=laporan-pkl" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl text-xs transition duration-200 flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/10">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Download Template <span id="template-type-label">Laporan PKL (.xlsx)</span>
                    </a>
                </div>

                <!-- Guidelines Card -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/15 shadow-sm space-y-4 animate-fade-in">
                    <h4 class="font-bold text-slate-800 text-base border-b border-slate-100 pb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500 text-[20px]">info</span>
                        Panduan Pengisian Data
                    </h4>
                    <ul class="space-y-3 text-xs text-slate-600 font-medium">
                        <li class="flex gap-2.5 items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            <span><strong>NIM & Nama Mahasiswa:</strong> Wajib diisi dengan benar. Sistem mencocokkan data profil berdasarkan NIM.</span>
                        </li>
                        <li class="flex gap-2.5 items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            <span><strong>Program Studi:</strong> Harus sama persis dengan Program Studi yang terdaftar di sistem (Contoh: <em>D3 Teknik Informatika</em>). Jika tidak cocok, proses dibatalkan.</span>
                        </li>
                        <li class="flex gap-2.5 items-start" id="guideline-pkl-only">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            <span><strong>Tempat PKL:</strong> Wajib diisi khusus untuk pengisian template Laporan PKL.</span>
                        </li>
                        <li class="flex gap-2.5 items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            <span><strong>Akun Alumni Baru:</strong> Jika NIM belum terdaftar di sistem, sistem akan otomatis membuatkan akun alumni dummy (semester = 'Alumni') dengan password default: <code class="bg-slate-100 p-0.5 rounded px-1 text-slate-800 font-mono">sipus[NIM]</code>.</span>
                        </li>
                        <li class="flex gap-2.5 items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            <span><strong>Duplikasi Data:</strong> Duplikat diperiksa berdasarkan NIM & Tipe Arsip. Jika mahasiswa tersebut sudah memiliki arsip dengan tipe terpilih, data baris tersebut akan dilewati secara otomatis.</span>
                        </li>
                        <li class="flex gap-2.5 items-start">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mt-1.5 shrink-0"></span>
                            <span><strong>Koleksi Fisik:</strong> Arsip yang di-import diset aktif dan otomatis didaftarkan di tabel koleksi buku fisik (`Collections`) dengan `stock = 1`.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Validation Errors Panel (Tampil jika ada error baris) -->
        @if(session('import_errors'))
            <div class="mt-8 bg-rose-50 border border-rose-200 rounded-3xl p-6 sm:p-8 shadow-sm shadow-rose-50/50 animate-fade-in">
                <div class="flex items-center gap-3 mb-4 text-rose-800">
                    <span class="material-symbols-outlined text-rose-600 text-[28px]">warning_amber</span>
                    <div>
                        <h4 class="font-bold text-base">Gagal Mengimpor Berkas Excel</h4>
                        <p class="text-xs text-rose-700/80 font-medium">Sistem membatalkan seluruh operasi import karena terdapat beberapa kesalahan validasi berikut:</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-rose-100 divide-y divide-rose-50 max-h-60 overflow-y-auto shadow-inner">
                    @foreach(session('import_errors') as $error)
                        <div class="p-3.5 px-5 text-xs font-semibold text-rose-700 flex items-center gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-input');
        const fileIndicator = document.getElementById('file-indicator');
        const fileName = document.getElementById('file-name');
        const removeFileBtn = document.getElementById('remove-file-btn');
        const typeSelect = document.getElementById('archive-type-select');
        const downloadBtn = document.getElementById('download-template-btn');
        const templateTypeLabel = document.getElementById('template-type-label');
        const guidelinePkl = document.getElementById('guideline-pkl-only');

        // Trigger file input click when clicking drop zone
        dropZone.addEventListener('click', () => fileInput.click());

        // Highlight drop zone on dragover
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-primary', 'bg-slate-150');
        });

        // Remove highlight on dragleave
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-primary', 'bg-slate-150');
        });

        // Handle file drop
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-primary', 'bg-slate-150');
            
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                updateFileIndicator();
            }
        });

        // Handle file input change
        fileInput.addEventListener('change', () => {
            updateFileIndicator();
        });

        // Remove selected file
        removeFileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.value = '';
            fileIndicator.classList.add('hidden');
            fileIndicator.classList.remove('flex');
            dropZone.classList.remove('hidden');
        });

        function updateFileIndicator() {
            if (fileInput.files.length > 0) {
                fileName.textContent = fileInput.files[0].name;
                fileIndicator.classList.remove('hidden');
                fileIndicator.classList.add('flex');
                dropZone.classList.add('hidden');
            }
        }

        // Handle type select change for dynamic download link and guidelines
        typeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            downloadBtn.href = `{{ route('petugas.arsip.import.template') }}?type=${selectedType}`;
            
            if (selectedType === 'laporan-pkl') {
                templateTypeLabel.textContent = 'Laporan PKL (.xlsx)';
                guidelinePkl.classList.remove('hidden');
            } else {
                const label = selectedType === 'proposal-ta' ? 'Proposal TA' : 'Laporan TA';
                templateTypeLabel.textContent = `${label} (.xlsx)`;
                guidelinePkl.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
