<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Voting Pengadaan Buku - SIPUS PSDKU POLNEP</title>
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
                        "on-tertiary-fixed": "#40000d",
                        "secondary-fixed": "#6ffbbe",
                        "secondary-fixed-dim": "#4edea3",
                        "on-tertiary": "#ffffff",
                        "outline-variant": "#c7c4d8",
                        "surface-container-highest": "#dae2fd",
                        "surface-container-high": "#e2e7ff",
                        "on-error": "#ffffff",
                        "background": "#faf8ff",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-secondary-fixed": "#002113",
                        "tertiary-fixed-dim": "#ffb2b7",
                        "surface-variant": "#dae2fd",
                        "surface-container": "#eaedff",
                        "secondary-container": "#6cf8bb",
                        "secondary": "#f39200",
                        "tertiary": "#95002b",
                        "tertiary-fixed": "#ffdadb",
                        "primary": "#00a5c0", /* POLNEP Brand Turquoise */
                        "on-primary-container": "#dad7ff",
                        "surface-dim": "#d2d9f4",
                        "tertiary-container": "#bf0f3c",
                        "on-tertiary-fixed-variant": "#92002a",
                        "error-container": "#ffdad6",
                        "inverse-on-surface": "#eef0ff",
                        "on-secondary-fixed-variant": "#005236",
                        "surface-bright": "#faf8ff",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#131b2e",
                        "surface-tint": "#00a5c0",
                        "on-primary-fixed-variant": "#007b91",
                        "inverse-surface": "#283044",
                        "surface-container-low": "#f2f3ff",
                        "error": "#ba1a1a",
                        "on-surface-variant": "#464555",
                        "primary-fixed": "#e2dfff",
                        "on-secondary-container": "#00714d",
                        "primary-container": "#00a5c0",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-primary-fixed": "#0f0069",
                        "on-tertiary-container": "#ffd0d2",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#c3c0ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-max": "1280px",
                        "base": "8px",
                        "margin-mobile": "16px",
                        "gutter": "24px",
                        "margin-desktop": "40px"
                    },
                    "fontFamily": {
                        "headline-md": ["Outfit"],
                        "label-md": ["Inter"],
                        "display-lg": ["Outfit"],
                        "caption": ["Inter"],
                        "headline-lg": ["Outfit"],
                        "headline-lg-mobile": ["Outfit"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"]
                    },
                    "fontSize": {
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "caption": ["12px", {"lineHeight": "16px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 231, 255, 0.5);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f8faff;
            color: #131b2e;
        }
        .sidebar-active {
            background-color: #00a5c0; /* POLNEP Turquoise */
            color: white;
            box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2);
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #c7c4d8;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #b1afc2;
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen flex">
    @include('mahasiswa.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Voting Pengadaan Buku',
            'subtitle' => 'Berikan suara Anda untuk menentukan prioritas pengadaan buku perpustakaan berikutnya.'
        ])

        <!-- Status Alerts -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-650">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm flex items-center gap-3">
                <span class="material-symbols-outlined text-rose-600">warning</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Active Votings Section -->
        <div class="space-y-10">
            @forelse($votings as $voting)
                @php
                    $totalSessionVotes = $voting->votingItems->sum(function($item) {
                        return $item->votes->count();
                    });
                @endphp
                <div class="bg-white rounded-3xl border border-outline-variant/100 shadow-sm overflow-hidden p-8">
                    <!-- Session Header Info -->
                    <div class="border-b border-outline-variant/10 pb-6 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider">Sesi Aktif</span>
                                <span class="text-xs text-outline">Total Suara Masuk: <strong class="text-on-surface">{{ $totalSessionVotes }}</strong></span>
                            </div>
                            <h2 class="font-headline-md text-on-surface text-xl mb-1">{{ $voting->title }}</h2>
                            <p class="text-sm text-outline">{{ $voting->deskripsi }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-4 py-2 bg-[#f8faff] text-outline border border-outline-variant/20 rounded-2xl">
                                <span class="material-symbols-outlined text-[16px] text-primary">calendar_today</span>
                                Periode: {{ $voting->tgl_mulai->translatedFormat('d M') }} - {{ $voting->tgl_selesai->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Candidates List Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($voting->votingItems as $item)
                            @php
                                $hasVoted = in_array($item->voting_item_id, $userVotes);
                                $itemVotesCount = $item->votes->count();
                                $percentage = $totalSessionVotes > 0 ? round(($itemVotesCount / $totalSessionVotes) * 100) : 0;
                            @endphp
                            <div class="bg-[#f8faff] rounded-3xl border border-outline-variant/10 overflow-hidden flex flex-col hover:shadow-md transition duration-300 group {{ $hasVoted ? 'border-primary/30 ring-2 ring-primary/10' : '' }}">
                                <!-- Visual Cover Header -->
                                <div class="h-32 bg-gradient-to-br from-primary to-primary-container relative flex items-center justify-center text-white/20">
                                    <span class="material-symbols-outlined text-[60px]">image</span>
                                    
                                    @if($loop->iteration === 1 && $itemVotesCount > 0)
                                        <div class="absolute top-4 left-4 bg-amber-500 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-sm border border-amber-600">🏆 Top 1</div>
                                    @elseif($loop->iteration === 2 && $itemVotesCount > 0)
                                        <div class="absolute top-4 left-4 bg-slate-400 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-sm border border-slate-500">🥈 Top 2</div>
                                    @elseif($loop->iteration === 3 && $itemVotesCount > 0)
                                        <div class="absolute top-4 left-4 bg-amber-750 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-sm border border-amber-800" style="background-color: #a05a2c;">🥉 Top 3</div>
                                    @endif

                                    <div class="absolute bottom-4 left-4 right-4 bg-white/10 backdrop-blur-md rounded-xl p-2 flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-white uppercase tracking-wider">Calon Pengadaan</span>
                                        <div class="flex items-center gap-1 text-white bg-primary px-2.5 py-0.5 rounded-lg text-[10px] font-bold shadow-sm">
                                            <span class="material-symbols-outlined text-[12px] text-yellow-400">thumb_up</span>
                                            <span>{{ $itemVotesCount }} Vote</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Body details -->
                                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                    <div>
                                        <h3 class="font-semibold text-on-surface mb-1 group-hover:text-primary transition-colors text-sm line-clamp-1">
                                            {{ $item->recommendation->title }}
                                        </h3>
                                        <p class="text-xs text-outline mb-2">Penulis: {{ $item->recommendation->author ?? 'Tidak diketahui' }}</p>
                                        <p class="text-xs text-on-surface-variant bg-white p-3 border border-outline-variant/10 rounded-2xl min-h-[64px] line-clamp-3">
                                            <strong class="text-outline">Alasan:</strong> "{{ $item->recommendation->reason ?? 'Mendukung bahan ajar dan referensi materi kuliah.' }}"
                                        </p>
                                    </div>

                                    <!-- Reading Share / Progress -->
                                    <div>
                                        <div class="flex items-center justify-between text-[10px] text-outline font-semibold mb-1">
                                            <span>Proporsi Suara</span>
                                            <span>{{ $percentage }}%</span>
                                        </div>
                                        <div class="w-full h-1.5 bg-outline-variant/20 rounded-full overflow-hidden">
                                            <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Recommended by Badge -->
                                    <div class="flex items-center justify-between border-t border-outline-variant/10 pt-4">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] text-outline uppercase tracking-wider font-bold">Diusulkan Oleh</span>
                                            <span class="text-[11px] font-semibold text-on-surface truncate max-w-[120px]">{{ $item->recommendation->user->name ?? 'User' }}</span>
                                        </div>
                                        
                                        <!-- Vote Action Button -->
                                        <form action="{{ route('mahasiswa.voting.vote', $item->voting_item_id) }}" method="POST">
                                            @csrf
                                            @if($hasVoted)
                                                <button type="submit" class="px-4 py-2 bg-white border border-primary text-primary font-bold text-xs rounded-xl hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition-colors shadow-sm">
                                                    Batal Vote
                                                </button>
                                            @else
                                                <button type="submit" class="px-4 py-2 bg-primary text-white font-bold text-xs rounded-xl hover:bg-primary-container transition-colors shadow-sm">
                                                    Vote Buku
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-outline-variant/10 p-12 text-center max-w-xl mx-auto shadow-sm">
                    <div class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-[40px]">ballot</span>
                    </div>
                    <h2 class="font-headline-md text-on-surface text-lg mb-2">Tidak Ada Voting Aktif</h2>
                    <p class="text-sm text-outline leading-relaxed">Saat ini tidak ada sesi voting pengadaan buku yang sedang berlangsung. Informasi voting baru akan muncul di sini jika ditambahkan oleh petugas perpustakaan.</p>
                </div>
            @endforelse
        </div>
    </main>

    <script>
        // Micro interactions
        document.querySelectorAll('.group').forEach(card => {
            card.addEventListener('mouseenter', () => {
                const icon = card.querySelector('.material-symbols-outlined');
                if(icon) icon.classList.add('scale-110');
            });
            card.addEventListener('mouseleave', () => {
                const icon = card.querySelector('.material-symbols-outlined');
                if(icon) icon.classList.remove('scale-110');
            });
        });
    </script>
</body>
</html>
