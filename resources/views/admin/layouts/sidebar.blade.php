<!-- Sidebar Navigation -->
<aside class="fixed left-0 top-0 h-full w-64 bg-white border-r border-outline-variant/30 flex flex-col z-50">
    <div class="p-6 border-b border-outline-variant/10">
        <div class="flex items-center gap-3">
            <img src="{{ asset('img/logo_polnep.webp') }}" class="w-10 h-10 object-contain" alt="Logo POLNEP">
            <div class="flex flex-col">
                <span class="font-headline-md text-primary font-bold leading-none">SIPUS POLNEP</span>
                <span class="text-[10px] text-outline font-bold tracking-widest uppercase mt-1.5">Digital Library</span>
            </div>
        </div>
    </div>

    @php
        $settingsMenuOpen = request()->routeIs('admin.settings.*');
    @endphp

    <nav class="flex-1 p-4 space-y-2 mt-4">
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('admin.dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-label-md">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.users.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('admin.users.index') }}">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined">group</span>
                <span class="font-label-md">Kelola User</span>
            </div>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.prodis.*') || request()->routeIs('admin.jurusans.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('admin.prodis.index') }}">
            <span class="material-symbols-outlined">school</span>
            <span class="font-label-md">Kelola Prodi & Jurusan</span>
        </a>
        <details class="group" {{ $settingsMenuOpen ? 'open' : '' }}>
            <summary class="list-none flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer {{ $settingsMenuOpen ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all">
                <span class="flex items-center gap-3 min-w-0">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="font-label-md">Pengaturan</span>
                </span>
                <span class="material-symbols-outlined text-[18px] transition-transform group-open:rotate-180">expand_more</span>
            </summary>

            <div class="mt-2 ml-4 pl-3 border-l border-outline-variant/20 space-y-1">
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('admin.settings.wa') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('admin.settings.wa') }}">
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                    <span class="text-sm">Notifikasi WA</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('admin.settings.telegram') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('admin.settings.telegram') }}">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    <span class="text-sm">Notifikasi Telegram</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('admin.settings.email') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('admin.settings.email') }}">
                    <span class="material-symbols-outlined text-[18px]">mail</span>
                    <span class="text-sm">Notifikasi Email</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('admin.settings.receipt') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('admin.settings.receipt') }}">
                    <span class="material-symbols-outlined text-[18px]">description</span>
                    <span class="text-sm">Template Tanda Terima</span>
                </a>
            </div>
        </details>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.activity-logs.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('admin.activity-logs.index') }}">
            <span class="material-symbols-outlined">receipt_long</span>
            <span class="font-label-md">Log Aktivitas</span>
        </a>
    </nav>
</aside>

<style>
    /* Page Load Transition */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    main {
        opacity: 0;
        animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Cross-Document View Transitions */
    @view-transition {
        navigation: auto;
    }

    /* CSS overrides for dashboard responsiveness */
    @media (max-width: 1023px) {
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw !important;
        }
        aside {
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        aside.mobile-open {
            transform: translateX(0) !important;
        }
        main {
            margin-left: 0 !important;
            padding: 1.5rem 1rem !important;
            padding-top: 5.5rem !important;
            max-width: 100vw !important;
            overflow-x: hidden !important;
            /* Override page load animation style since media queries can affect parsing, keeping animation active */
            animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        /* Clean Page Header on Mobile (No duplicate white bar, no horizontal clipping) */
        main > header {
            position: static !important;
            height: auto !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            margin-top: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-bottom: 1.25rem !important;
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        main > header > div:first-child {
            width: 100% !important;
            margin-right: 0 !important;
        }
        main > header > div:last-child {
            display: none !important;
        }
        main > header h1, main > header p {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: clip !important;
            word-break: break-word !important;
        }
        
        #mobileTopBar {
            display: flex;
            max-width: 100vw !important;
        }
    }
</style>

<!-- Overlay Backdrop -->
<div class="sidebar-overlay fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-[45] hidden opacity-0 transition-all duration-300" style="z-index: 45;" id="sidebarOverlay"></div>

<!-- Mobile top bar -->
<div class="mobile-top-bar fixed top-0 left-0 right-0 h-16 bg-white border-b border-outline-variant/30 hidden items-center justify-between px-6 z-40 shadow-sm" id="mobileTopBar">
    <div class="flex items-center gap-3">
        <button id="mobileMenuBtn" class="w-10 h-10 rounded-xl hover:bg-slate-100 flex items-center justify-center text-on-surface-variant active:scale-95 transition-all">
            <span class="material-symbols-outlined text-[26px]">menu</span>
        </button>
        <span class="font-bold text-on-surface tracking-wide text-sm">SIPUS POLNEP</span>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative" x-data="{ mobileMenuOpen: false }" @click.outside="mobileMenuOpen = false">
        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="w-9 h-9 rounded-full bg-primary-container flex items-center justify-center overflow-hidden border border-slate-200 shadow-sm active:scale-95 transition-all focus:outline-none">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true" class="w-full h-full object-cover" alt="Avatar">
        </button>

        <div x-show="mobileMenuOpen" x-cloak style="display: none;" x-transition class="absolute right-0 top-11 w-56 bg-white rounded-2xl shadow-xl border border-outline-variant/20 py-2 z-50 overflow-hidden">
            <div class="px-4 py-2 border-b border-outline-variant/10 bg-slate-50/60">
                <p class="text-xs font-bold text-on-surface truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-outline truncate mt-0.5">{{ Auth::user()->email }}</p>
            </div>
            <div class="py-1 px-1.5 space-y-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined text-[18px]">person</span>
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-all text-left">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        Keluar Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('aside');
        const overlay = document.getElementById('sidebarOverlay');
        const menuBtn = document.getElementById('mobileMenuBtn');
        const closeBtn = document.getElementById('mobileCloseSidebarBtn');

        function closeSidebar() {
            if (sidebar) sidebar.classList.remove('mobile-open');
            if (overlay) {
                overlay.classList.remove('opacity-100');
                setTimeout(() => {
                    if (!overlay.classList.contains('opacity-100')) {
                        overlay.classList.add('hidden');
                    }
                }, 300);
            }
        }
        
        if (sidebar && overlay && menuBtn) {
            menuBtn.addEventListener('click', function() {
                sidebar.classList.add('mobile-open');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.add('opacity-100');
                }, 10);
            });
            
            overlay.addEventListener('click', closeSidebar);

            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }
            
            // Close sidebar when link inside sidebar is clicked
            sidebar.querySelectorAll('nav a').forEach(link => {
                link.addEventListener('click', closeSidebar);
            });
        }
    });
</script>

@include('layouts.custom-confirm')
