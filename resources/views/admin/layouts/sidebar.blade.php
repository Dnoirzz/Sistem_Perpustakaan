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
            <span class="material-symbols-outlined">group</span>
            <span class="font-label-md">Kelola User</span>
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
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('profile.edit') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined">person</span>
            <span class="font-label-md">Profil</span>
        </a>
    </nav>
    <div class="p-4 border-t border-outline-variant/10">
        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
            @csrf
        </form>
        <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-error hover:bg-error/5 transition-all">
            <span class="material-symbols-outlined">logout</span>
            <span class="font-label-md">Keluar</span>
        </button>
    </div>
</aside>

<style>
    /* CSS overrides for dashboard responsiveness */
    @media (max-width: 1023px) {
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
        }
        /* Page header layout adjust on mobile */
        main > header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem !important;
        }
        main > header > div:last-child {
            display: none !important;
        }
        
        #mobileTopBar {
            display: flex;
        }
    }
</style>

<!-- Overlay Backdrop -->
<div class="sidebar-overlay fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-45 hidden opacity-0 transition-all duration-300" id="sidebarOverlay"></div>

<!-- Mobile top bar -->
<div class="mobile-top-bar fixed top-0 left-0 right-0 h-16 bg-white border-b border-outline-variant/30 hidden items-center justify-between px-6 z-40 shadow-sm" id="mobileTopBar">
    <div class="flex items-center gap-3">
        <button id="mobileMenuBtn" class="w-10 h-10 rounded-xl hover:bg-slate-100 flex items-center justify-center text-on-surface-variant active:scale-95 transition-all">
            <span class="material-symbols-outlined text-[26px]">menu</span>
        </button>
        <span class="font-bold text-on-surface tracking-wide text-sm">SIPUS POLNEP</span>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('profile.edit') }}" class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center overflow-hidden border border-slate-200 shadow-sm active:scale-95 transition-all">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true" class="w-full h-full object-cover" alt="Avatar">
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('aside');
        const overlay = document.getElementById('sidebarOverlay');
        const menuBtn = document.getElementById('mobileMenuBtn');
        
        if (sidebar && overlay && menuBtn) {
            menuBtn.addEventListener('click', function() {
                sidebar.classList.add('mobile-open');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.add('opacity-100');
                }, 10);
            });
            
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('opacity-100');
                setTimeout(() => {
                    if (!overlay.classList.contains('opacity-100')) {
                        overlay.classList.add('hidden');
                    }
                }, 300);
            });
            
            // Close sidebar when active link is clicked
            sidebar.querySelectorAll('nav a').forEach(link => {
                link.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('opacity-100');
                    overlay.classList.add('hidden');
                });
            });
        }
    });
</script>

