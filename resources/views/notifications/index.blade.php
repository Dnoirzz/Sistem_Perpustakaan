<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pemberitahuan - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-background": "#131b2e",
                        "surface": "#faf8ff",
                        "outline": "#777587",
                        "primary": "#00a5c0",
                        "on-surface": "#131b2e",
                        "on-surface-variant": "#464555",
                        "surface-container-low": "#f2f3ff"
                    },
                    "fontFamily": {
                        "headline-md": ["Outfit"],
                        "body-md": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f4f6fb;
            color: #131b2e;
            font-family: 'Inter', sans-serif;
        }
        .sidebar-active {
            background-color: #00a5c0;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2);
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @php
        $userRole = strtolower(auth()->user()?->role?->role_name ?? '');
    @endphp

    @if($userRole === 'admin')
        @include('admin.layouts.sidebar')
    @elseif($userRole === 'petugas')
        @include('petugas.layouts.sidebar')
    @elseif($userRole === 'dosen')
        @include('dosen.layouts.sidebar')
    @elseif($userRole === 'mahasiswa')
        @include('mahasiswa.layouts.sidebar')
    @endif

    <!-- Main Content Area -->
    <main class="ml-64 p-6 sm:p-10 bg-[#f4f6fb] min-h-screen">
        @include('layouts.header', [
            'title' => 'Pemberitahuan',
            'subtitle' => 'Daftar seluruh notifikasi dan riwayat aktivitas Anda.'
        ])

        <!-- Alert Notifications -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm text-sm font-semibold">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <!-- TOP BAR: Title & Mark All Read Button -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight font-headline-md">Pemberitahuan</h1>
                <p class="text-xs text-slate-500 mt-1">Kelola dan pantau seluruh notifikasi masuk akun Anda.</p>
            </div>

            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">done_all</span>
                    Tandai semua sebagai sudah dibaca
                </button>
            </form>
        </div>

        <!-- NOTIFICATIONS CARDS CONTAINER -->
        <div class="space-y-3.5">
            @forelse($notifications as $notif)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-center justify-between gap-4 group {{ !$notif->is_read ? 'border-l-4 border-l-primary bg-sky-50/20' : '' }} {{ $notif->url ? 'cursor-pointer hover:border-primary/40' : '' }}"
                    @if($notif->url)
                        onclick="window.location='{{ route('notifications.open', $notif->id) }}'"
                    @endif
                >
                    <!-- Clickable area (left part) -->
                    <div class="flex items-start gap-4 min-w-0 flex-1 p-5">
                        <!-- Icon Circle -->
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 mt-0.5 {{ $notif->type === 'warning' ? 'bg-amber-100 text-amber-700' : ($notif->type === 'success' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600') }}">
                            <span class="material-symbols-outlined text-[20px]">
                                @if($notif->type === 'warning')
                                    error
                                @elseif($notif->type === 'success')
                                    check_circle
                                @else
                                    info
                                @endif
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="min-w-0 flex-1">
                            <span class="font-bold text-sm text-slate-900 {{ $notif->url ? 'group-hover:text-primary' : '' }} block truncate transition-colors">
                                {{ $notif->title }}
                            </span>

                            <p class="text-xs text-slate-500 mt-1 leading-relaxed line-clamp-2">
                                {{ $notif->message }}
                            </p>
                        </div>
                    </div>

                    <!-- Right: Time Ago & Delete Action -->
                    <div class="flex items-center gap-4 shrink-0 pr-5" onclick="event.stopPropagation()">
                        <span class="text-xs text-slate-400 font-medium whitespace-nowrap">
                            {{ $notif->created_at ? $notif->created_at->diffForHumans() : '' }}
                        </span>

                        <!-- Delete Button -->
                        <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 flex items-center justify-center transition-all" title="Hapus Pemberitahuan">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-xs">
                    <span class="material-symbols-outlined text-slate-300 text-6xl mb-3">notifications_off</span>
                    <h3 class="font-bold text-slate-700 text-base mb-1">Belum Ada Pemberitahuan</h3>
                    <p class="text-xs text-slate-400">Seluruh riwayat pemberitahuan Anda akan muncul di halaman ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @endif
    </main>
</body>
</html>
