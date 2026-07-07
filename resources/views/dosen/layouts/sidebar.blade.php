<!-- Sidebar Navigation -->
<aside class="fixed left-0 top-0 h-full w-64 bg-white border-r border-outline-variant/30 flex flex-col z-50">
    <div class="p-8 border-b border-outline-variant/10">
        <div class="flex flex-col gap-1">
            <span class="font-headline-md text-primary font-bold leading-tight">SIPUS POLNEP</span>
            <span class="text-[10px] text-outline font-bold tracking-widest uppercase">Digital Library</span>
        </div>
    </div>
    @php
        $libraryMenuOpen = request()->routeIs('dosen.books.*')
            || request()->routeIs('dosen.katalog-arsip.*');
        $rakPinjamOpen = request()->routeIs('dosen.loans.active')
            || request()->routeIs('dosen.loans.history')
            || request()->routeIs('dosen.bookings.*')
            || request()->routeIs('dosen.antrian.*');
    @endphp

    <nav class="flex-1 p-4 space-y-2 mt-4 font-semibold text-sm">
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dosen.dashboard') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('dosen.dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-label-md">Dashboard</span>
        </a>
        <details class="group" {{ $libraryMenuOpen ? 'open' : '' }}>
            <summary class="list-none flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer {{ $libraryMenuOpen ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all">
                <span class="flex items-center gap-3 min-w-0">
                    <span class="material-symbols-outlined">auto_stories</span>
                    <span class="font-label-md">Koleksi Perpustakaan</span>
                </span>
                <span class="material-symbols-outlined text-[18px] transition-transform group-open:rotate-180">expand_more</span>
            </summary>

            <div class="mt-2 ml-4 pl-3 border-l border-outline-variant/20 space-y-1">
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('dosen.books.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('dosen.books.index') }}">
                    <span class="material-symbols-outlined text-[18px]">menu_book</span>
                    <span class="text-sm">Buku</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('dosen.katalog-arsip.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('dosen.katalog-arsip.index') }}">
                    <span class="material-symbols-outlined text-[18px]">library_books</span>
                    <span class="text-sm">Arsip Mahasiswa</span>
                </a>
            </div>
        </details>
        
        <details class="group" {{ $rakPinjamOpen ? 'open' : '' }}>
            <summary class="list-none flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer {{ $rakPinjamOpen ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all">
                <span class="flex items-center gap-3 min-w-0">
                    <span class="material-symbols-outlined">shelves</span>
                    <span class="font-label-md">Rak Pinjam</span>
                </span>
                <span class="material-symbols-outlined text-[18px] transition-transform group-open:rotate-180">expand_more</span>
            </summary>

            <div class="mt-2 ml-4 pl-3 border-l border-outline-variant/20 space-y-1">
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('dosen.loans.active') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('dosen.loans.active') }}">
                    <span class="material-symbols-outlined text-[18px]">chrome_reader_mode</span>
                    <span class="text-sm">Pinjaman</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('dosen.bookings.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('dosen.bookings.my') }}">
                    <span class="material-symbols-outlined text-[18px]">event_available</span>
                    <span class="text-sm">Booking</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('dosen.antrian.*') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('dosen.antrian.my') }}">
                    <span class="material-symbols-outlined text-[18px]">format_list_numbered</span>
                    <span class="text-sm">Antrian</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-2.5 rounded-2xl {{ request()->routeIs('dosen.loans.history') ? 'bg-surface-container text-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container-low' }} transition-all" href="{{ route('dosen.loans.history') }}">
                    <span class="material-symbols-outlined text-[18px]">history</span>
                    <span class="text-sm">Riwayat</span>
                </a>
            </div>
        </details>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dosen.recommendations.index') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('dosen.recommendations.index') }}">
            <span class="material-symbols-outlined">rate_review</span>
            <span class="font-label-md">Usulan Buku Baru</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dosen.voting.index') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('dosen.voting.index') }}">
            <span class="material-symbols-outlined">how_to_vote</span>
            <span class="font-label-md">Voting Buku</span>
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
