<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pengaturan WA - SIPUS PSDKU POLNEP</title>
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
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Pengaturan Notifikasi WA</h1>
                <p class="text-sm text-outline">Kelola kredensial Fonnte dan konfigurasi sistem notifikasi WhatsApp otomatis.</p>
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

        <!-- Alert Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-3xl flex items-center gap-3 shadow-sm shadow-emerald-50">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left & Middle Column: Configuration Form -->
            <div class="lg:col-span-2 space-y-8">
                <section class="bg-white rounded-3xl border border-outline-variant/20 p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-outline-variant/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-3xl">api</span>
                            <div>
                                <h2 class="font-headline-md text-lg text-on-surface">Kredensial Fonnte API</h2>
                                <p class="text-xs text-outline">Token disimpan dengan aman di database sirkulasi.</p>
                            </div>
                        </div>
                        
                        <!-- Badge status koneksi -->
                        @if(empty($settings['fonnte_token']))
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-bold uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                Belum Diatur
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Konfigurasi Ada
                            </span>
                        @endif
                    </div>

                    <form action="{{ route('admin.settings.wa.update') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Toggle ON/OFF -->
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-outline-variant/15">
                            <div class="flex flex-col gap-0.5">
                                <label class="font-label-md text-sm text-on-surface">Aktifkan Notifikasi WhatsApp</label>
                                <p class="text-xs text-outline">Kirim WA otomatis saat pinjaman dibuat, jatuh tempo, dsb.</p>
                            </div>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <select name="wa_notification_enabled" class="bg-white border border-outline-variant rounded-xl px-3 py-1.5 text-sm font-semibold focus:ring-primary focus:border-primary">
                                    <option value="true" {{ $settings['wa_notification_enabled'] === 'true' ? 'selected' : '' }}>Aktif</option>
                                    <option value="false" {{ $settings['wa_notification_enabled'] === 'false' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Fonnte Token -->
                        <div class="space-y-2">
                            <label for="fonnte_token" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Fonnte API Token</label>
                            <div class="relative rounded-xl shadow-sm">
                                <input type="password" 
                                       name="fonnte_token" 
                                       id="fonnte_token" 
                                       value="{{ $settings['fonnte_token'] }}" 
                                       class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-mono" 
                                       placeholder="Masukkan API Token Fonnte Anda" />
                                <button type="button" 
                                        onclick="toggleTokenVisibility()" 
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-outline hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]" id="visibility-icon">visibility</span>
                                </button>
                            </div>
                            <p class="text-xs text-outline">Anda dapat mendapatkan API token ini dari dasbor akun Fonnte Anda.</p>
                        </div>

                        <!-- Sender Name -->
                        <div class="space-y-2">
                            <label for="wa_sender_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pengirim (Footer Message)</label>
                            <input type="text" 
                                   name="wa_sender_name" 
                                   id="wa_sender_name" 
                                   value="{{ $settings['wa_sender_name'] }}" 
                                   class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="Perpustakaan PSDKU POLNEP" />
                            <p class="text-xs text-outline">Nama ini akan dicantumkan di bagian bawah pesan notifikasi otomatis.</p>
                        </div>

                        <!-- Button Simpan -->
                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                                <span class="material-symbols-outlined">save</span>
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </section>
            </div>

            <!-- Right Column: Test Connection Tool -->
            <div class="space-y-8">
                <!-- Status Sistem Widget -->
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/15 p-8">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-outline-variant/10">
                        <span class="material-symbols-outlined text-primary text-3xl">send</span>
                        <div>
                            <h2 class="font-headline-md text-lg text-on-surface">Uji Koneksi WA</h2>
                            <p class="text-xs text-outline">Kirim pesan uji coba ke nomor tujuan.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Target Phone -->
                        <div class="space-y-1.5">
                            <label for="test_phone" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Nomor HP Tujuan</label>
                            <input type="text" 
                                   id="test_phone" 
                                   class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="08123456xxxx" />
                        </div>

                        <!-- Message Body -->
                        <div class="space-y-1.5">
                            <label for="test_message" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Isi Pesan Uji Coba</label>
                            <textarea id="test_message" 
                                      rows="3"
                                      class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm resize-none">Halo! Ini adalah pesan uji coba sistem notifikasi WhatsApp dari panel Admin SIPUS PSDKU POLNEP Sukamara. Koneksi API Fonnte berfungsi dengan baik! 👍</textarea>
                        </div>

                        <!-- AJAX Response Alerts -->
                        <div id="test-wa-result" class="hidden text-xs p-4 rounded-xl border"></div>

                        <!-- Button Uji Coba -->
                        <button type="button" 
                                id="btn-test-wa"
                                onclick="sendTestWa()" 
                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-800 text-white font-bold hover:bg-slate-900 transition-all">
                            <span class="material-symbols-outlined text-[18px]" id="test-wa-btn-icon">bolt</span>
                            <span id="test-wa-btn-text">Kirim Uji Coba</span>
                        </button>
                    </div>
                </section>

                <!-- Panduan / Bantuan Widget -->
                <section class="bg-gradient-to-br from-primary to-primary-container rounded-3xl shadow-lg p-8 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-headline-md text-lg mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">help_outline</span>
                            Panduan Fonnte
                        </h3>
                        <p class="text-xs opacity-75 mb-6 leading-relaxed">Fonnte adalah gateway notifikasi WA. Pastikan status device Anda di dasbor Fonnte adalah **"Connect"** (Aktif) agar pesan dapat terkirim.</p>
                        
                        <div class="space-y-3 text-xs">
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">check</span>
                                <span>Gunakan nomor berformat *08...* atau *62...*</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">check</span>
                                <span>Pastikan masa aktif paket device Fonnte aktif</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">check</span>
                                <span>Cek menu *Logs* di Fonnte jika WA tidak masuk</span>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative element -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                </section>
            </div>
        </div>
    </main>

    <script>
        function toggleTokenVisibility() {
            const input = document.getElementById('fonnte_token');
            const icon = document.getElementById('visibility-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        async function sendTestWa() {
            const phoneInput = document.getElementById('test_phone');
            const messageInput = document.getElementById('test_message');
            const resultDiv = document.getElementById('test-wa-result');
            const btn = document.getElementById('btn-test-wa');
            const btnText = document.getElementById('test-wa-btn-text');
            const btnIcon = document.getElementById('test-wa-btn-icon');

            const phone = phoneInput.value.trim();
            const message = messageInput.value.trim();

            if (!phone) {
                alert('Silakan masukkan nomor HP tujuan.');
                phoneInput.focus();
                return;
            }
            if (!message) {
                alert('Silakan masukkan isi pesan.');
                messageInput.focus();
                return;
            }

            // Set loading state
            btn.disabled = true;
            btn.classList.add('opacity-60', 'cursor-not-allowed');
            btnText.textContent = 'Mengirim...';
            btnIcon.textContent = 'progress_activity';
            btnIcon.classList.add('animate-spin');

            resultDiv.classList.add('hidden');
            resultDiv.className = 'text-xs p-4 rounded-xl border';

            try {
                const response = await fetch("{{ route('admin.settings.wa.test') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        test_phone: phone,
                        test_message: message
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    resultDiv.classList.remove('hidden');
                    resultDiv.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-800');
                    resultDiv.innerHTML = `
                        <div class="flex gap-2">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0">check_circle</span>
                            <div>
                                <p class="font-bold">Sukses!</p>
                                <p>${data.message}</p>
                            </div>
                        </div>
                    `;
                } else {
                    resultDiv.classList.remove('hidden');
                    resultDiv.classList.add('bg-rose-50', 'border-rose-200', 'text-rose-800');
                    resultDiv.innerHTML = `
                        <div class="flex gap-2">
                            <span class="material-symbols-outlined text-rose-600 text-[18px] shrink-0">error</span>
                            <div>
                                <p class="font-bold">Gagal Kirim!</p>
                                <p>${data.message || 'Terjadi kesalahan sistem.'}</p>
                            </div>
                        </div>
                    `;
                }
            } catch (error) {
                resultDiv.classList.remove('hidden');
                resultDiv.classList.add('bg-rose-50', 'border-rose-200', 'text-rose-800');
                resultDiv.innerHTML = `
                    <div class="flex gap-2">
                        <span class="material-symbols-outlined text-rose-600 text-[18px] shrink-0">error</span>
                        <div>
                            <p class="font-bold">Error Terkoneksi!</p>
                            <p>Gagal menghubungi server. Periksa koneksi internet Anda.</p>
                        </div>
                    </div>
                `;
            } finally {
                // Reset button state
                btn.disabled = false;
                btn.classList.remove('opacity-60', 'cursor-not-allowed');
                btnText.textContent = 'Kirim Uji Coba';
                btnIcon.textContent = 'bolt';
                btnIcon.classList.remove('animate-spin');
            }
        }
    </script>
</body>
</html>
