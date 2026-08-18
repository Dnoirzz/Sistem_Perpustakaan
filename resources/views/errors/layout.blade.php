<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .header-font {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="h-full bg-slate-50 text-slate-800 flex items-center justify-center p-4 sm:p-6 overflow-x-hidden selection:bg-teal-600 selection:text-white relative">

    <!-- Soft Decorative Ambient Elements -->
    <div class="fixed -top-24 -left-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-24 -right-24 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-md w-full bg-white border border-slate-200/80 rounded-3xl p-6 sm:p-8 shadow-xl relative z-10 text-center flex flex-col items-center">
        <!-- Error Code Icon Badge -->
        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl @yield('icon-bg', 'bg-teal-50 border-teal-200 text-teal-700') border flex items-center justify-center mb-5 shadow-xs transition-transform hover:scale-105">
            <span class="material-symbols-outlined text-3xl sm:text-4xl">@yield('icon', 'warning')</span>
        </div>

        <!-- Error Code Pill -->
        <span class="px-3 py-1 rounded-full @yield('pill-bg', 'bg-teal-50 text-teal-800 border-teal-200') border text-[11px] font-black uppercase tracking-wider mb-3">
            Error @yield('code', '403')
        </span>

        <!-- Title & Description -->
        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 header-font mb-2 tracking-tight">
            @yield('headline', 'Akses Ditolak')
        </h1>
        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6 max-w-xs sm:max-w-sm font-medium">
            @yield('message')
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5 w-full pt-2 border-t border-slate-100">
            <button onclick="window.history.back()" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all border border-slate-200/80 flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali
            </button>
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-6 py-2.5 rounded-2xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-md shadow-teal-600/20 transition-all flex items-center justify-center gap-2 active:scale-95">
                <span class="material-symbols-outlined text-[18px]">home</span>
                Halaman Utama
            </a>
        </div>
    </div>

</body>
</html>
