<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pengaturan Email SMTP - SIPUS PSDKU POLNEP</title>
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
                <h1 class="font-headline-md text-on-surface">Pengaturan SMTP Email</h1>
                <p class="text-sm text-outline">Kelola konfigurasi server SMTP untuk pengiriman surat tanda terima arsip digital secara otomatis.</p>
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
                            <span class="material-symbols-outlined text-primary text-3xl">mail</span>
                            <div>
                                <h2 class="font-headline-md text-lg text-on-surface">Server SMTP Dinamis</h2>
                                <p class="text-xs text-outline">Kredensial disimpan dengan aman di database sirkulasi.</p>
                            </div>
                        </div>
                        
                        <!-- Badge status koneksi -->
                        @if($settings['mail_mailer'] === 'log')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold uppercase tracking-wider">
                                Driver Log Lokal
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider">
                                SMTP Aktif
                            </span>
                        @endif
                    </div>

                    <form action="{{ route('admin.settings.email.update') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Toggle ON/OFF Driver -->
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-outline-variant/15">
                            <div class="flex flex-col gap-0.5">
                                <label class="font-label-md text-sm text-on-surface">Driver Pengiriman Email</label>
                                <p class="text-xs text-outline">Pilih 'SMTP' untuk pengiriman email asli, atau 'Log' untuk keperluan debug lokal.</p>
                            </div>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <select name="mail_mailer" id="mail_mailer" onchange="toggleMailerFields()" class="bg-white border border-outline-variant rounded-xl px-3 py-1.5 text-sm font-semibold focus:ring-primary focus:border-primary">
                                    <option value="smtp" {{ $settings['mail_mailer'] === 'smtp' ? 'selected' : '' }}>SMTP Server</option>
                                    <option value="log" {{ $settings['mail_mailer'] === 'log' ? 'selected' : '' }}>Laravel Log (Lokal)</option>
                                </select>
                            </div>
                        </div>

                        <div id="smtp_fields" class="space-y-6">
                            <!-- SMTP Host & Port -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <div class="sm:col-span-2 space-y-2">
                                    <label for="mail_host" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">SMTP Host</label>
                                    <input type="text" 
                                           name="mail_host" 
                                           id="mail_host" 
                                           value="{{ $settings['mail_host'] }}" 
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-mono" 
                                           placeholder="smtp.gmail.com atau sandbox.smtp.mailtrap.io" />
                                </div>
                                <div class="space-y-2">
                                    <label for="mail_port" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">SMTP Port</label>
                                    <input type="number" 
                                           name="mail_port" 
                                           id="mail_port" 
                                           value="{{ $settings['mail_port'] }}" 
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-mono" 
                                           placeholder="587, 465, 2525" />
                                </div>
                            </div>

                            <!-- Encryption -->
                            <div class="space-y-2">
                                <label for="mail_encryption" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Protokol Keamanan (Encryption)</label>
                                <select name="mail_encryption" id="mail_encryption" class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm">
                                    <option value="none" {{ $settings['mail_encryption'] === 'none' || empty($settings['mail_encryption']) ? 'selected' : '' }}>None (Tanpa Enkripsi / Port 25/8025/2525)</option>
                                    <option value="tls" {{ $settings['mail_encryption'] === 'tls' ? 'selected' : '' }}>TLS (Direkomendasikan untuk Port 587)</option>
                                    <option value="ssl" {{ $settings['mail_encryption'] === 'ssl' ? 'selected' : '' }}>SSL (Direkomendasikan untuk Port 465)</option>
                                </select>
                            </div>

                            <!-- Username & Password -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="mail_username" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">SMTP Username</label>
                                    <input type="text" 
                                           name="mail_username" 
                                           id="mail_username" 
                                           value="{{ $settings['mail_username'] }}" 
                                           class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                           placeholder="Masukkan username atau email login SMTP" />
                                </div>
                                <div class="space-y-2">
                                    <label for="mail_password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">SMTP Password</label>
                                    <div class="relative rounded-xl shadow-sm">
                                        <input type="password" 
                                               name="mail_password" 
                                               id="mail_password" 
                                               value="{{ $settings['mail_password'] }}" 
                                               class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm font-mono" 
                                               placeholder="Masukkan password atau App Password" />
                                        <button type="button" 
                                                onclick="togglePasswordVisibility()" 
                                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-outline hover:text-primary transition-colors">
                                            <span class="material-symbols-outlined text-[20px]" id="password-visibility-icon">visibility</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- From Address & From Name -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                            <div class="space-y-2">
                                <label for="mail_from_address" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Email Pengirim (Sender Email)</label>
                                <input type="email" 
                                       name="mail_from_address" 
                                       id="mail_from_address" 
                                       value="{{ $settings['mail_from_address'] }}" 
                                       class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                       placeholder="noreply@perpustakaan-polnep.ac.id" required />
                            </div>
                            <div class="space-y-2">
                                <label for="mail_from_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pengirim (Sender Name)</label>
                                <input type="text" 
                                       name="mail_from_name" 
                                       id="mail_from_name" 
                                       value="{{ $settings['mail_from_name'] }}" 
                                       class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                       placeholder="SIPUS PSDKU POLNEP" required />
                            </div>
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
                        <span class="material-symbols-outlined text-primary text-3xl">send_and_archive</span>
                        <div>
                            <h2 class="font-headline-md text-lg text-on-surface">Uji Koneksi SMTP</h2>
                            <p class="text-xs text-outline">Kirim email uji coba secara real-time.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Target Email -->
                        <div class="space-y-1.5">
                            <label for="test_email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Email Penerima</label>
                            <input type="email" 
                                   id="test_email" 
                                   class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="Masukkan email tujuan Anda" />
                        </div>

                        <!-- Subject -->
                        <div class="space-y-1.5">
                            <label for="test_subject" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Subjek Email</label>
                            <input type="text" 
                                   id="test_subject" 
                                   class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   value="Tes Koneksi SMTP - SIPUS PSDKU POLNEP" />
                        </div>

                        <!-- Message Body -->
                        <div class="space-y-1.5">
                            <label for="test_body" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Isi Email Uji Coba</label>
                            <textarea id="test_body" 
                                      rows="4"
                                      class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm resize-none">Halo!

Ini adalah email uji coba dari modul Pengaturan SMTP Administrator SIPUS PSDKU POLNEP.

Jika Anda menerima email ini, berarti koneksi server SMTP dan kredensial yang dimasukkan sudah berfungsi dengan baik dan sistem siap mengirimkan surat tanda terima arsip digital otomatis.

Terima kasih!</textarea>
                        </div>

                        <!-- AJAX Response Alerts -->
                        <div id="test-email-result" class="hidden text-xs p-4 rounded-xl border"></div>

                        <!-- Button Uji Coba -->
                        <button type="button" 
                                id="btn-test-email"
                                onclick="sendTestEmail()" 
                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-800 text-white font-bold hover:bg-slate-900 transition-all">
                            <span class="material-symbols-outlined text-[18px]" id="test-email-btn-icon">bolt</span>
                            <span id="test-email-btn-text">Kirim Uji Coba</span>
                        </button>
                    </div>
                </section>

                <!-- Panduan SMTP Widget -->
                <section class="bg-gradient-to-br from-primary to-primary-container rounded-3xl shadow-lg p-8 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-headline-md text-lg mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">help_outline</span>
                            Bantuan SMTP
                        </h3>
                        <p class="text-xs opacity-75 mb-6 leading-relaxed">SMTP (Simple Mail Transfer Protocol) digunakan untuk mengirim email. Jika menggunakan Gmail, Anda wajib membuat **App Password** di setelan akun Google Anda.</p>
                        
                        <div class="space-y-3 text-xs">
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">check</span>
                                <span>Gmail: host=smtp.gmail.com, port=587, encryption=tls</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">check</span>
                                <span>Mailtrap (Test): port=2525 atau 587, encryption=tls</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">check</span>
                                <span>Gunakan tombol "Uji coba" sebelum menyimpan data</span>
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
        function togglePasswordVisibility() {
            const input = document.getElementById('mail_password');
            const icon = document.getElementById('password-visibility-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }

        function toggleMailerFields() {
            const mailerSelect = document.getElementById('mail_mailer');
            const smtpFields = document.getElementById('smtp_fields');
            
            if (mailerSelect.value === 'log') {
                // Sembunyikan field SMTP atau disable input
                smtpFields.style.opacity = '0.4';
                smtpFields.style.pointerEvents = 'none';
            } else {
                smtpFields.style.opacity = '1';
                smtpFields.style.pointerEvents = 'auto';
            }
        }

        // Jalankan pada load pertama
        document.addEventListener('DOMContentLoaded', function() {
            toggleMailerFields();
        });

        async function sendTestEmail() {
            const testEmailInput = document.getElementById('test_email');
            const subjectInput = document.getElementById('test_subject');
            const bodyInput = document.getElementById('test_body');
            
            const mailerSelect = document.getElementById('mail_mailer');
            const hostInput = document.getElementById('mail_host');
            const portInput = document.getElementById('mail_port');
            const encryptionSelect = document.getElementById('mail_encryption');
            const usernameInput = document.getElementById('mail_username');
            const passwordInput = document.getElementById('mail_password');
            const fromAddressInput = document.getElementById('mail_from_address');
            const fromNameInput = document.getElementById('mail_from_name');
            
            const resultDiv = document.getElementById('test-email-result');
            const btn = document.getElementById('btn-test-email');
            const btnText = document.getElementById('test-email-btn-text');
            const btnIcon = document.getElementById('test-email-btn-icon');

            const testEmail = testEmailInput.value.trim();
            const subject = subjectInput.value.trim();
            const body = bodyInput.value.trim();

            if (!testEmail) {
                alert('Silakan masukkan email penerima.');
                testEmailInput.focus();
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
                const response = await fetch("{{ route('admin.settings.email.test') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        test_email: testEmail,
                        test_subject: subject,
                        test_body: body,
                        mail_mailer: mailerSelect.value,
                        mail_host: hostInput.value.trim(),
                        mail_port: portInput.value.trim(),
                        mail_encryption: encryptionSelect.value,
                        mail_username: usernameInput.value.trim(),
                        mail_password: passwordInput.value.trim(),
                        mail_from_address: fromAddressInput.value.trim(),
                        mail_from_name: fromNameInput.value.trim()
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
                                <p>${data.message || 'Terjadi kesalahan SMTP.'}</p>
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
                            <p>Gagal menghubungi server. Periksa koneksi internet Anda atau logs server.</p>
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
