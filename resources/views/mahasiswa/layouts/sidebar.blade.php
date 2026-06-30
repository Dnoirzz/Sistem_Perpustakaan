<!-- Sidebar Navigation -->
<aside class="fixed left-0 top-0 h-full w-64 bg-white border-r border-outline-variant/30 flex flex-col z-50">
    <div class="p-8 border-b border-outline-variant/10">
        <div class="flex flex-col gap-1">
            <span class="font-headline-md text-primary font-bold leading-tight">SIPUS POLNEP</span>
            <span class="text-[10px] text-outline font-bold tracking-widest uppercase">Digital Library</span>
        </div>
    </div>
    <nav class="flex-1 p-4 space-y-2 mt-4 text-sm font-semibold">
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('mahasiswa.dashboard') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('mahasiswa.dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-label-md">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('mahasiswa.books.index') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('mahasiswa.books.index') }}">
            <span class="material-symbols-outlined">auto_stories</span>
            <span class="font-label-md">Koleksi Buku</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('mahasiswa.bookings.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('mahasiswa.bookings.my') }}">
            <span class="material-symbols-outlined">event_available</span>
            <span class="font-label-md">Booking Saya</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('mahasiswa.antrian.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('mahasiswa.antrian.my') }}">
            <span class="material-symbols-outlined">format_list_numbered</span>
            <span class="font-label-md">Antrian Saya</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('mahasiswa.recommendations.index') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('mahasiswa.recommendations.index') }}">
            <span class="material-symbols-outlined">rate_review</span>
            <span class="font-label-md">Usulan Buku</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('mahasiswa.voting.index') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('mahasiswa.voting.index') }}">
            <span class="material-symbols-outlined">how_to_vote</span>
            <span class="font-label-md">Voting Buku</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('mahasiswa.arsip.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('mahasiswa.arsip.index') }}">
            <span class="material-symbols-outlined">upload_file</span>
            <span class="font-label-md">Upload Arsip Digital</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('mahasiswa.katalog-arsip.*') ? 'sidebar-active' : 'text-on-surface-variant hover:bg-surface-container' }} transition-all group" href="{{ route('mahasiswa.katalog-arsip.index') }}">
            <span class="material-symbols-outlined">library_books</span>
            <span class="font-label-md">Katalog Arsip</span>
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
