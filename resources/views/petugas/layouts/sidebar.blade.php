<!-- Sidebar Navigation -->
<aside class="fixed left-0 top-0 h-full w-64 bg-white border-r border-outline-variant/30 flex flex-col z-50">
    <div class="p-6 border-b border-outline-variant/10">
        <div class="flex items-center gap-3">
            <img src="{{ asset('img/logo_polnep.webp') }}" class="w-10 h-10 object-contain" alt="Logo POLNEP">
            <div class="flex flex-col">
                <span class="font-headline-md text-primary font-bold leading-none">SIPUS POLNEP</span>
                <span class="text-[10px] text-outline font-bold tracking-widest uppercase mt-1.5">PSDKU SUKAMARA</span>
            </div>
        </div>
    </div>

    @php
        $libraryMenuOpen = request()->routeIs('petugas.books.*')
            || request()->routeIs('petugas.categories.*')
            || request()->routeIs('petugas.arsip.*');
        $loanManagementMenuOpen = request()->routeIs('petugas.loans.*')
            || request()->routeIs('petugas.returns.*')
            || request()->routeIs('petugas.bookings.*')
            || request()->routeIs('petugas.antrian.*')
            || request()->routeIs('petugas.penalties.*');
        $settingsMenuOpen = request()->routeIs('petugas.return-settings.*') || request()->routeIs('profile.edit');
    @endphp

    <nav class="flex-1 p-4 space-y-2 mt-4 overflow-y-auto">
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('petugas.dashboard') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('petugas.dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-label-md">Dashboard</span>
        </a>

        <details class="group" {{ $libraryMenuOpen ? 'open' : '' }}>
            <summary class="list-none flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer {{ $libraryMenuOpen ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all">
                <span class="flex items-center gap-3 min-w-0">
                    <span class="material-symbols-outlined">auto_stories</span>
                    <span class="font-label-md">Koleksi Perpustakaan</span>
                </span>
                <div class="flex items-center gap-2">
                    @if(($petugasBadges['koleksi_total'] ?? 0) > 0)
                        <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-rose-600 text-white shadow-xs" title="{{ $petugasBadges['koleksi_total'] }} tugas arsip pending verifikasi">
                            {{ $petugasBadges['koleksi_total'] }}
                        </span>
                    @endif
                    <span class="material-symbols-outlined text-[18px] transition-transform group-open:rotate-180">expand_more</span>
                </div>
            </summary>

            <div class="mt-2 ml-4 pl-3 border-l border-outline-variant/20 space-y-1">
                <a class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('petugas.books.*') || request()->routeIs('petugas.categories.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('petugas.books.index') }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[18px]">menu_book</span>
                        <span class="text-sm">Kelola Buku</span>
                    </div>
                </a>
                <a class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('petugas.arsip.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('petugas.arsip.index') }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[18px]">folder_managed</span>
                        <span class="text-sm">Kelola Arsip Digital</span>
                    </div>
                    @if(($petugasBadges['arsip'] ?? 0) > 0)
                        <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-rose-600 text-white shadow-xs" title="{{ $petugasBadges['arsip'] }} arsip pending verifikasi">
                            {{ $petugasBadges['arsip'] }}
                        </span>
                    @endif
                </a>
            </div>
        </details>

        <a class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('petugas.members.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('petugas.members.index') }}">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined">group</span>
                <span class="font-label-md">Kelola Anggota</span>
            </div>
        </a>

        <a class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('petugas.recommendations.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('petugas.recommendations.index') }}">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined">rate_review</span>
                <span class="font-label-md">Kelola Usulan Buku</span>
            </div>
            @if(($petugasBadges['recommendations'] ?? 0) > 0)
                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-rose-600 text-white shadow-xs" title="{{ $petugasBadges['recommendations'] }} usulan pending">
                    {{ $petugasBadges['recommendations'] }}
                </span>
            @endif
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('petugas.voting.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('petugas.voting.index') }}">
            <span class="material-symbols-outlined">how_to_vote</span>
            <span class="font-label-md">Kelola Voting Buku</span>
        </a>

        <details class="group" {{ $loanManagementMenuOpen ? 'open' : '' }}>
            <summary class="list-none flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer {{ $loanManagementMenuOpen ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all">
                <span class="flex items-center gap-3 min-w-0">
                    <span class="material-symbols-outlined">library_books</span>
                    <span class="font-label-md">Manajemen Peminjaman</span>
                </span>
                <div class="flex items-center gap-2">
                    @if(($petugasBadges['peminjaman_total'] ?? 0) > 0)
                        <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-rose-600 text-white shadow-xs" title="{{ $petugasBadges['peminjaman_total'] }} transaksi butuh tindakan petugas">
                            {{ $petugasBadges['peminjaman_total'] }}
                        </span>
                    @endif
                    <span class="material-symbols-outlined text-[18px] transition-transform group-open:rotate-180">expand_more</span>
                </div>
            </summary>

            <div class="mt-2 ml-4 pl-3 border-l border-outline-variant/20 space-y-1">
                <a class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('petugas.loans.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('petugas.loans.index') }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[18px]">assignment_returned</span>
                        <span class="text-sm">Peminjaman</span>
                    </div>
                </a>
                <a class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('petugas.returns.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('petugas.returns.index') }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[18px]">assignment_return</span>
                        <span class="text-sm">Pengembalian</span>
                    </div>
                </a>
                <a class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('petugas.bookings.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('petugas.bookings.index') }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[18px]">event_available</span>
                        <span class="text-sm">Booking</span>
                    </div>
                    @if(($petugasBadges['bookings'] ?? 0) > 0)
                        <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-rose-600 text-white shadow-xs" title="{{ $petugasBadges['bookings'] }} booking pending disetujui">
                            {{ $petugasBadges['bookings'] }}
                        </span>
                    @endif
                </a>
                <a class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('petugas.antrian.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('petugas.antrian.index') }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[18px]">format_list_numbered</span>
                        <span class="text-sm">Antrian</span>
                    </div>
                </a>
                <a class="flex items-center justify-between gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('petugas.penalties.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('petugas.penalties.index') }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[18px]">gavel</span>
                        <span class="text-sm">Denda & Sanksi</span>
                    </div>
                </a>
            </div>
        </details>

        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('petugas.reports.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('petugas.reports.index') }}">
            <span class="material-symbols-outlined">analytics</span>
            <span class="font-label-md">Laporan & Rekap</span>
        </a>

        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('petugas.return-settings.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('petugas.return-settings.index') }}">
            <span class="material-symbols-outlined">tune</span>
            <span class="font-label-md">Rules Pengembalian</span>
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
            /* Override page load animation style since media queries can affect parsing, keeping animation active */
            animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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
<div class="sidebar-overlay fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-[45] hidden opacity-0 transition-all duration-300" style="z-index: 45;" id="sidebarOverlay"></div>

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
