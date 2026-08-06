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

<header class="sticky top-0 flex justify-between items-center mb-8 -mx-4 sm:-mx-10 -mt-6 sm:-mt-10 px-4 sm:px-10 h-[88px] bg-white border-b border-outline-variant/20 shadow-sm z-40">
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

    <!-- Header Right Section: Notification Bell & Profile Dropdown -->
    <div class="flex items-center gap-3">
        @if($roleName !== 'admin')
        <!-- Lonceng Notifikasi Bell -->
        <div class="relative" 
             x-data="{ 
                 notifOpen: false, 
                 unreadCount: 0, 
                 notifications: [], 
                 fetchFeed() {
                     fetch('{{ route('notifications.feed') }}')
                         .then(res => res.json())
                         .then(data => {
                             this.unreadCount = data.unread_count || 0;
                             this.notifications = data.notifications || [];
                         })
                         .catch(err => console.error('Error fetching notifications:', err));
                 },
                 markAllRead() {
                     fetch('{{ route('notifications.read-all') }}', {
                         method: 'POST',
                         headers: {
                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                             'Accept': 'application/json'
                         }
                     })
                     .then(res => res.json())
                     .then(data => {
                         if(data.success) {
                             this.unreadCount = 0;
                             this.notifications.forEach(n => n.is_read = true);
                         }
                     });
                 }
             }" 
             x-init="fetchFeed(); setInterval(() => fetchFeed(), 30000)"
             @click.outside="notifOpen = false">
             
            <!-- Button Bell Icon -->
            <button 
                @click="notifOpen = !notifOpen; if(notifOpen) fetchFeed();" 
                type="button" 
                class="relative w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-slate-100/90 hover:bg-slate-200/80 border border-outline-variant/20 flex items-center justify-center text-on-surface transition-all focus:outline-none cursor-pointer group active:scale-95 shadow-xs"
                aria-label="Notifikasi"
            >
                <span class="material-symbols-outlined text-[22px] text-slate-700 group-hover:text-teal-700 transition-colors">notifications</span>
                
                <!-- Badge Merah Unread Count -->
                <template x-if="unreadCount > 0">
                    <span 
                        class="absolute -top-1 -right-1 px-1.5 py-0.5 text-[10px] font-extrabold rounded-full bg-rose-600 text-white border-2 border-white shadow-xs animate-bounce min-w-[20px] text-center"
                        x-text="unreadCount > 99 ? '99+' : unreadCount"
                    ></span>
                </template>
            </button>

            <!-- Dropdown Popover Notifikasi -->
            <div 
                x-show="notifOpen" 
                x-cloak
                style="display: none;"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-outline-variant/20 py-3 z-50 overflow-hidden"
            >
                <!-- Popover Header -->
                <div class="px-5 py-2.5 flex items-center justify-between border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-teal-600 text-[20px]">notifications_active</span>
                        <h3 class="font-bold text-slate-800 text-sm">Notifikasi Saya</h3>
                    </div>
                    <template x-if="unreadCount > 0">
                        <button 
                            @click="markAllRead()" 
                            type="button" 
                            class="text-[11px] font-bold text-teal-600 hover:text-teal-700 hover:underline cursor-pointer"
                        >
                            Tandai semua dibaca
                        </button>
                    </template>
                </div>

                <!-- Notification Feed List -->
                <div class="max-h-[360px] overflow-y-auto divide-y divide-slate-100">
                    <template x-if="notifications.length === 0">
                        <div class="py-10 text-center space-y-2">
                            <span class="material-symbols-outlined text-[36px] text-slate-300">notifications_off</span>
                            <p class="text-xs text-slate-400 font-medium">Belum ada notifikasi baru untuk Anda</p>
                        </div>
                    </template>

                    <template x-for="item in notifications" :key="item.id">
                        <a :href="'{{ url('/notifications') }}/' + item.id + '/open'"
                           class="block w-full text-left p-4 hover:bg-slate-50 transition-colors flex items-start gap-3 cursor-pointer group"
                           :class="!item.is_read ? 'bg-teal-50/40' : ''"
                        >
                            <!-- Icon Tipe Notifikasi -->
                            <div class="w-9 h-9 rounded-2xl flex items-center justify-center shrink-0 mt-0.5"
                                 :class="{
                                     'bg-teal-100 text-teal-700': item.type === 'arsip',
                                     'bg-amber-100 text-amber-700': item.type === 'warning' || item.type === 'booking',
                                     'bg-sky-100 text-sky-700': item.type === 'sirkulasi',
                                     'bg-emerald-100 text-emerald-700': item.type === 'success',
                                     'bg-rose-100 text-rose-700': item.type === 'denda',
                                     'bg-slate-100 text-slate-700': !['arsip','warning','booking','sirkulasi','denda','success'].includes(item.type)
                                 }"
                            >
                                <span class="material-symbols-outlined text-[18px]"
                                      x-text="item.type === 'arsip' ? 'folder_managed' : (item.type === 'booking' ? 'event_available' : (item.type === 'sirkulasi' ? 'assignment_returned' : (item.type === 'denda' ? 'gavel' : (item.type === 'success' ? 'check_circle' : (item.type === 'warning' ? 'error' : 'info')))))"
                                ></span>
                            </div>

                            <!-- Text Body -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1 mb-1">
                                    <h4 class="text-xs font-bold text-slate-900 group-hover:text-teal-700 transition-colors truncate" x-text="item.title"></h4>
                                    <span class="text-[10px] text-slate-400 shrink-0 font-medium" x-text="item.time_ago"></span>
                                </div>
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed" x-text="item.message"></p>
                            </div>

                            <!-- Unread Dot Indicator -->
                            <template x-if="!item.is_read">
                                <div class="w-2 h-2 rounded-full bg-rose-600 shrink-0 mt-2"></div>
                            </template>
                        </a>
                    </template>
                </div>

                <!-- Dropdown Footer: Link to /notifications page -->
                <div class="p-3 bg-slate-50 border-t border-slate-100 text-center">
                    <a href="{{ route('notifications.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-teal-700 hover:text-teal-900 transition-colors">
                        Lihat Semua Pemberitahuan
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
        @endif

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
                    <p class="font-label-md text-on-surface text-sm font-semibold group-hover:text-teal-700 transition-colors">{{ $user?->name }}</p>
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
                style="display: none;"
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
                    <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-700 border border-teal-200 text-[10px] font-bold uppercase tracking-wider">
                        {{ $roleLabel }}
                    </span>
                </div>

                <!-- Menu Links -->
                <div class="py-1.5 px-1.5">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-slate-100 hover:text-teal-700 transition-all">
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
    </div>
</header>
