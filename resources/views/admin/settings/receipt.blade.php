<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pengaturan Tanda Terima - SIPUS PSDKU POLNEP</title>
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
    @include('admin.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Template Surat Tanda Terima',
            'subtitle' => 'Kelola kop surat, kode penomoran surat, dan identitas penandatangan bukti tanda terima arsip digital.'
        ])

        <!-- Alert Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-3xl flex items-center gap-3 shadow-sm shadow-emerald-50">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-3xl">
                <ul class="list-disc pl-5 font-semibold text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="receipt-settings-form" action="{{ route('admin.settings.receipt.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            
            <!-- Left & Middle Column: Configuration Fields -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Kop Surat Section -->
                <section class="bg-white rounded-3xl border border-outline-variant/100 p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-outline-variant/100">
                        <span class="material-symbols-outlined text-primary text-3xl">domain</span>
                        <div>
                            <h2 class="font-headline-md text-lg text-on-surface">Struktur Kop Surat Resmi</h2>
                            <p class="text-xs text-outline">Atur susunan Kop surat</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label for="receipt_kop_line_1" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kop Baris 1 (Kementerian / Lembaga)</label>
                            <textarea name="receipt_kop_line_1" 
                                      id="receipt_kop_line_1" 
                                      rows="2" 
                                      class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-semibold resize-none" 
                                      required>{{ $settings['receipt_kop_line_1'] }}</textarea>
                            <p class="text-[10px] text-outline">Tekan Enter untuk membuat baris baru jika teks terlalu panjang.</p>
                        </div>

                        <div class="space-y-2">
                            <label for="receipt_kop_line_2" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kop Baris 2 (Nama Instansi)</label>
                            <input type="text" 
                                   name="receipt_kop_line_2" 
                                   id="receipt_kop_line_2" 
                                   value="{{ $settings['receipt_kop_line_2'] }}" 
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-semibold" 
                                   required />
                        </div>

                        <div class="space-y-2">
                            <label for="receipt_kop_line_3" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kop Baris 3 (Nama UPT / Perpustakaan)</label>
                            <input type="text" 
                                   name="receipt_kop_line_3" 
                                   id="receipt_kop_line_3" 
                                   value="{{ $settings['receipt_kop_line_3'] }}" 
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-semibold" 
                                   required />
                        </div>

                        <div class="space-y-2">
                            <label for="receipt_kop_alamat" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat & Kontak Instansi</label>
                            <textarea name="receipt_kop_alamat" 
                                      id="receipt_kop_alamat" 
                                      rows="3" 
                                      class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm resize-none" 
                                      required>{{ $settings['receipt_kop_alamat'] }}</textarea>
                            <p class="text-[10px] text-outline">Alamat jalan, nomor telepon, faksimile, alamat surel, dan kode pos.</p>
                        </div>

                        <div class="flex flex-col md:flex-row items-center gap-4 border-t border-outline-variant/100 pt-6 mt-4">
                            <div class="w-20 h-20 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-center p-2 shrink-0 shadow-sm relative group overflow-hidden">
                                <img src="{{ route('receipt.logo') }}?t={{ time() }}" class="w-full h-full object-contain transition duration-300 group-hover:scale-105" alt="Logo Instansi">
                            </div>
                            <div class="space-y-1.5 flex-1 w-full">
                                <label for="receipt_logo" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Logo Kop Surat</label>
                                <input type="file" 
                                       name="receipt_logo" 
                                       id="receipt_logo" 
                                       accept="image/png, image/jpeg, image/jpg"
                                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all cursor-pointer" />
                                <p class="text-[10px] text-outline">Format: PNG, JPG, JPEG (Disarankan logo dengan rasio 1:1 persegi, maks 2MB).</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Penandatangan & Format Surat Section -->
                <section class="bg-white rounded-3xl border border-outline-variant/100 p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-outline-variant/100">
                        <span class="material-symbols-outlined text-primary text-3xl">badge</span>
                        <div>
                            <h2 class="font-headline-md text-lg text-on-surface">Format Penomoran & Penandatangan</h2>
                            <p class="text-xs text-outline">Atur kode tengah surat dan identitas petugas yang menandatangani berkas fisik.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label for="receipt_kode_surat" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kode Penomoran Surat</label>
                            <input type="text" 
                                   name="receipt_kode_surat" 
                                   id="receipt_kode_surat" 
                                   value="{{ $settings['receipt_kode_surat'] }}" 
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-semibold font-mono" 
                                   placeholder="/PL.16.A3/KM/" 
                                   required />
                            <p class="text-[10px] text-outline">Format nomor surat yang dihasilkan: <code class="font-bold">[No_Urut]/PL.16.A3/KM/[Tahun]</code></p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="receipt_penerima_nama" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Petugas Penandatangan</label>
                                <input type="text" 
                                       name="receipt_penerima_nama" 
                                       id="receipt_penerima_nama" 
                                       value="{{ $settings['receipt_penerima_nama'] }}" 
                                       class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-semibold" 
                                       required />
                            </div>

                            <div class="space-y-2">
                                <label for="receipt_penerima_nip" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">NIP / NUP / Identitas Pegawai</label>
                                <input type="text" 
                                       name="receipt_penerima_nip" 
                                       id="receipt_penerima_nip" 
                                       value="{{ $settings['receipt_penerima_nip'] }}" 
                                       class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-semibold" 
                                       required />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="receipt_penerima_jabatan" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Jabatan Penandatangan</label>
                            <input type="text" 
                                   name="receipt_penerima_jabatan" 
                                   id="receipt_penerima_jabatan" 
                                   value="{{ $settings['receipt_penerima_jabatan'] }}" 
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-semibold" 
                                   required />
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Column: Info & Action Buttons -->
            <div class="space-y-8">
                <!-- Action Card -->
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/100 p-8">
                    <h3 class="font-headline-md text-lg text-on-surface mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[22px]">settings_suggest</span>
                        Simpan Konfigurasi
                    </h3>
                    <p class="text-xs text-outline mb-6 leading-relaxed">Pastikan semua data kop surat dan petugas penandatangan sudah benar. Data ini akan langsung dimuat ketika petugas memverifikasi arsip mahasiswa dan mencetak surat bukti serah terima.</p>

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm mb-3">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        Simpan Semua Pengaturan
                    </button>

                    <button type="button" onclick="previewReceipt()" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl border border-outline-variant text-on-surface-variant font-bold hover:bg-slate-50 transition-all text-sm">
                        <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                        Pratinjau Surat (PDF)
                    </button>
                </section>
            </div>
        </form>
    </main>

    <script>
        function previewReceipt() {
            const form = document.getElementById('receipt-settings-form');
            const originalAction = form.action;
            const originalTarget = form.target;
            
            form.action = "{{ route('admin.settings.receipt.preview') }}";
            form.target = "_blank";
            form.submit();
            
            // Restore original action and target
            form.action = originalAction;
            form.target = originalTarget || "";
        }
    </script>
</body>
</html>
