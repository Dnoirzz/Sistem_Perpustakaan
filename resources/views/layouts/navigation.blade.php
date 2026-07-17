<nav x-data="{ open: false }" class="bg-white border-b border-slate-100 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2.5">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 flex items-center justify-center">
                            <img src="{{ asset('img/logo_polnep.webp') }}" class="w-8 h-8 object-contain" alt="Logo POLNEP">
                        </div>
                        <span class="font-bold text-slate-800 tracking-wide text-sm hidden sm:inline-block">SIPUS PSDKU</span>
                    </a>
                </div>

                <!-- Navigation Links (Role Specific) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                            {{ __('Manajemen Anggota') }}
                        </x-nav-link>
                    @elseif(Auth::user()->isPetugas())
                        <x-nav-link :href="route('petugas.dashboard')" :active="request()->routeIs('petugas.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('petugas.books.index')" :active="request()->routeIs('petugas.books.index')">
                            {{ __('Kelola Buku') }}
                        </x-nav-link>
                        <x-nav-link :href="route('petugas.members.index')" :active="request()->routeIs('petugas.members.index')">
                            {{ __('Kelola Anggota') }}
                        </x-nav-link>
                        <x-nav-link :href="route('petugas.loans.index')" :active="request()->routeIs('petugas.loans.index')">
                            {{ __('Peminjaman') }}
                        </x-nav-link>
                        <x-nav-link :href="route('petugas.returns.index')" :active="request()->routeIs('petugas.returns.index')">
                            {{ __('Pengembalian') }}
                        </x-nav-link>
                    @elseif(Auth::user()->isDosen())
                        <x-nav-link :href="route('dosen.dashboard')" :active="request()->routeIs('dosen.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dosen.books.index')" :active="request()->routeIs('dosen.books.index')">
                            {{ __('Cari Buku') }}
                        </x-nav-link>
                        <x-nav-link :href="route('dosen.recommendations.index')" :active="request()->routeIs('dosen.recommendations.index')">
                            {{ __('Usulan Buku') }}
                        </x-nav-link>
                    @elseif(Auth::user()->isMahasiswa())
                        <x-nav-link :href="route('mahasiswa.dashboard')" :active="request()->routeIs('mahasiswa.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('mahasiswa.books.index')" :active="request()->routeIs('mahasiswa.books.index')">
                            {{ __('Cari Buku') }}
                        </x-nav-link>
                        <x-nav-link :href="route('mahasiswa.recommendations.index')" :active="request()->routeIs('mahasiswa.recommendations.index')">
                            {{ __('Usulan Buku') }}
                        </x-nav-link>
                        <x-nav-link :href="route('mahasiswa.arsip.index')" :active="request()->routeIs('mahasiswa.arsip.*')">
                            {{ __('Upload Tugas Akhir / PKL') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3.5 py-2 border border-slate-200 text-sm leading-4 font-semibold rounded-xl text-slate-700 bg-slate-50 hover:bg-slate-100 hover:text-slate-900 focus:outline-none transition ease-in-out duration-150">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <div>{{ Auth::user()->name }}</div>
                            </span>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Role Anda</p>
                            <p class="text-sm font-bold text-indigo-600 capitalize">{{ Auth::user()->role->role_name ?? '' }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-50 border-t border-slate-100">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                    {{ __('Manajemen Anggota') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->isPetugas())
                <x-responsive-nav-link :href="route('petugas.dashboard')" :active="request()->routeIs('petugas.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('petugas.books.index')" :active="request()->routeIs('petugas.books.index')">
                    {{ __('Kelola Buku') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('petugas.members.index')" :active="request()->routeIs('petugas.members.index')">
                    {{ __('Kelola Anggota') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('petugas.loans.index')" :active="request()->routeIs('petugas.loans.index')">
                    {{ __('Peminjaman') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('petugas.returns.index')" :active="request()->routeIs('petugas.returns.index')">
                    {{ __('Pengembalian') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->isDosen())
                <x-responsive-nav-link :href="route('dosen.dashboard')" :active="request()->routeIs('dosen.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dosen.books.index')" :active="request()->routeIs('dosen.books.index')">
                    {{ __('Cari Buku') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dosen.recommendations.index')" :active="request()->routeIs('dosen.recommendations.index')">
                    {{ __('Usulan Buku') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->isMahasiswa())
                <x-responsive-nav-link :href="route('mahasiswa.dashboard')" :active="request()->routeIs('mahasiswa.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('mahasiswa.books.index')" :active="request()->routeIs('mahasiswa.books.index')">
                    {{ __('Cari Buku') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('mahasiswa.recommendations.index')" :active="request()->routeIs('mahasiswa.recommendations.index')">
                    {{ __('Usulan Buku') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('mahasiswa.arsip.index')" :active="request()->routeIs('mahasiswa.arsip.*')">
                    {{ __('Upload Tugas Akhir / PKL') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                <div class="text-xs font-semibold text-indigo-600 mt-1 uppercase tracking-wider capitalize">{{ Auth::user()->role->role_name ?? '' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil Saya') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
