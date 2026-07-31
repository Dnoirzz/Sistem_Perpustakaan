@php
    $user = Auth::user();
    $roleName = strtolower($user?->role?->role_name ?? '');

    if ($roleName === 'petugas') {
        $roleLabel = $user?->petugas?->jabatan ?? 'Petugas Perpustakaan';
    } elseif ($roleName === 'mahasiswa') {
        $roleLabel = 'Mahasiswa' . ($user?->mahasiswa?->nim ? ' • NIM ' . $user->mahasiswa->nim : '');
    } elseif ($roleName === 'dosen') {
        $roleLabel = 'Dosen' . ($user?->dosen?->nip ? ' • NIP ' . $user->dosen->nip : '');
    } elseif ($roleName === 'admin') {
        $roleLabel = 'Administrator';
    } else {
        $roleLabel = ucfirst($roleName ?: 'Pengguna');
    }
    $targetBackUrl = $back_url ?? $backUrl ?? null;
@endphp

<!-- Ensure Alpine.js is loaded for dropdown interaction -->
<script>
    if (typeof window.Alpine === 'undefined' && !document.getElementById('alpine-js-script')) {
        const script = document.createElement('script');
        script.id = 'alpine-js-script';
        script.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
        script.defer = true;
        document.head.appendChild(script);
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>

<header class="sticky top-0 flex justify-between items-center mb-8 -mx-6 sm:-mx-10 -mt-6 sm:-mt-10 px-6 sm:px-10 h-[88px] bg-white border-b border-outline-variant/20 shadow-sm z-40">
    <div class="flex items-center gap-3.5 min-w-0 flex-1 mr-4">
        @if(isset($targetBackUrl) && $targetBackUrl)
            <a href="{{ $targetBackUrl }}" class="w-10 h-10 rounded-2xl bg-white hover:bg-slate-100/90 text-on-surface flex items-center justify-center border border-outline-variant/20 transition-all shadow-sm group shrink-0" title="Kembali">
                <span class="material-symbols-outlined text-[20px] text-outline group-hover:text-primary transition-colors">arrow_back</span>
            </a>
        @else
            <div class="w-1.5 h-9 bg-primary rounded-full hidden sm:block shadow-sm shrink-0"></div>
        @endif
        <div class="min-w-0 flex-1">
            <h1 class="font-headline-md text-on-surface text-lg sm:text-xl font-bold tracking-tight truncate" title="{{ $title }}">{{ $title ?? 'Dashboard' }}</h1>
            @if(isset($subtitle) && $subtitle)
                <p class="text-xs sm:text-sm text-outline mt-0.5 font-medium truncate" title="{{ $subtitle }}">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    <!-- Profile & Dropdown Menu Container -->
    <div class="relative" x-data="{ userMenuOpen: false }" @click.outside="userMenuOpen = false">
        <button 
            @click="userMenuOpen = !userMenuOpen" 
            type="button" 
            class="flex items-center gap-3 p-1.5 pl-3 rounded-2xl hover:bg-slate-100/80 border border-transparent hover:border-outline-variant/20 transition-all focus:outline-none cursor-pointer group"
            aria-expanded="false"
            :aria-expanded="userMenuOpen"
        >
            <div class="text-right hidden sm:block">
                <p class="font-label-md text-on-surface text-sm font-semibold group-hover:text-primary transition-colors">{{ $user?->name }}</p>
                <p class="text-[11px] text-outline font-medium uppercase tracking-wider">{{ $roleLabel }}</p>
            </div>
            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm group-hover:shadow-md transition-all">
                <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user?->name ?? 'User') }}&background=e2e7ff&color=00a5c0&bold=true"/>
            </div>
            <span class="material-symbols-outlined text-outline text-[20px] transition-transform duration-200" :class="{ 'rotate-180': userMenuOpen }">expand_more</span>
        </button>

        <!-- Dropdown Menu Kecil -->
        <div 
            x-show="userMenuOpen" 
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
            class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl border border-outline-variant/20 py-2 z-50 overflow-hidden"
        >
            <!-- User Info Header -->
            <div class="px-4 py-3 border-b border-outline-variant/10 bg-slate-50/60">
                <p class="text-xs font-bold text-on-surface truncate">{{ $user?->name }}</p>
                <p class="text-[11px] text-outline truncate mt-0.5">{{ $user?->email }}</p>
                <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider">
                    {{ $roleLabel }}
                </span>
            </div>

            <!-- Menu Links -->
            <div class="py-1.5 px-1.5">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-slate-100 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[18px]">person</span>
                    Profil Saya
                </a>
            </div>

            <div class="border-t border-outline-variant/10 my-1"></div>

            <!-- Logout Form & Button -->
            <div class="px-1.5 pb-0.5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-error hover:bg-rose-50 transition-all text-left">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
