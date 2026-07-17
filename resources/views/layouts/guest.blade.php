<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Perpustakaan PSDKU POLNEP') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
            .glassmorphism {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.25);
            }
            .glassmorphism-dark {
                background: rgba(15, 23, 42, 0.75);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
        </style>
    </head>
    <body class="h-full text-slate-900 antialiased bg-gradient-to-tr from-slate-950 via-indigo-950 to-slate-900 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
        <div class="w-full max-w-4xl grid grid-cols-1 md:grid-cols-12 gap-0 overflow-hidden rounded-3xl shadow-2xl border border-white/10 glassmorphism-dark min-h-[600px]">
            
            <!-- Left Info Panel (Stunning visual design) -->
            <div class="hidden md:flex md:col-span-5 flex-col justify-between p-8 relative overflow-hidden bg-gradient-to-br from-indigo-600/90 to-emerald-600/90 text-white border-r border-white/10">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.15),transparent)] pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                
                <!-- Brand / Logo -->
                <div class="flex items-center gap-3 z-10">
                    <div class="w-10 h-10 rounded-xl bg-white backdrop-blur-md flex items-center justify-center border border-white/20 shadow-inner">
                        <img src="{{ asset('img/logo_polnep.webp') }}" class="w-7 h-7 object-contain" alt="Logo POLNEP">
                    </div>
                    <div>
                        <h2 class="font-bold text-lg tracking-wide leading-none">SIPUS</h2>
                        <span class="text-xs text-white/70">PSDKU POLNEP</span>
                    </div>
                </div>

                <!-- Main Slogan -->
                <div class="my-auto z-10 py-12">
                    <h1 class="text-3xl font-extrabold tracking-tight leading-tight mb-4 text-white">
                        Gerbang Digital Menuju Pengetahuan.
                     </h1>
                    <p class="text-sm text-white/80 leading-relaxed">
                        Aplikasi Perpustakaan PSDKU POLNEP Sukamara memudahkan akses pencarian buku, booking online, dan pengelolaan arsip akademik Anda secara modern.
                    </p>
                </div>

                <!-- Footer Text -->
                <div class="text-xs text-white/50 z-10">
                    &copy; 2026 PSDKU POLNEP Sukamara. All rights reserved.
                </div>
            </div>

            <!-- Right Content Panel -->
            <div class="md:col-span-7 flex flex-col justify-center p-8 sm:p-10 bg-slate-900/90 relative">
                <!-- Mobile brand logo (visible only on small screens) -->
                <div class="flex md:hidden items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-lg shadow-white/10">
                        <img src="{{ asset('img/logo_polnep.webp') }}" class="w-7 h-7 object-contain" alt="Logo POLNEP">
                    </div>
                    <div>
                        <h2 class="font-bold text-white text-lg tracking-wide leading-none">SIPUS</h2>
                        <span class="text-xs text-slate-400">PSDKU POLNEP Sukamara</span>
                    </div>
                </div>

                <div class="w-full">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
    <script>
        // Translate native validation error tooltips to Indonesian
        const formInputs = document.querySelectorAll('form input, form select');
        formInputs.forEach(input => {
            input.addEventListener('invalid', function (e) {
                if (this.validity.customError) return;
                
                this.setCustomValidity('');

                if (this.id === 'email') {
                    if (this.validity.valueMissing) {
                        this.setCustomValidity('Email wajib diisi');
                    } else if (this.validity.typeMismatch) {
                        this.setCustomValidity('Format email tidak valid');
                    }
                } else if (this.id === 'password') {
                    if (this.validity.valueMissing) {
                        this.setCustomValidity('Password wajib diisi');
                    }
                } else {
                    if (this.validity.valueMissing) {
                        let fieldName = document.querySelector(`label[for="${this.id}"]`)?.textContent || 'kolom ini';
                        fieldName = fieldName.replace('*', '').trim();
                        this.setCustomValidity(`${fieldName} wajib diisi`);
                    }
                }
            });

            input.addEventListener('input', function () {
                this.setCustomValidity('');
            });
        });
    </script>
</html>
