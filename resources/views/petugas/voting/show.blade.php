<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Detail Rekap Voting Buku - SIPUS PSDKU POLNEP</title>
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
                        "secondary": "#006c49",
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
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')
    
    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.voting.index') }}" class="p-2 rounded-2xl bg-white border border-outline-variant/30 text-outline hover:text-on-surface hover:shadow-sm transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-headline-md text-on-surface">Detail Rekap Suara</h1>
                    <p class="text-sm text-outline font-medium">Pantau perolehan suara buku kandidat secara real-time.</p>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
            </div>
        </header>

        <!-- Two Column Content Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Sesi Info & Perolehan Grafis (Bar) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Info Sesi Card -->
                <section class="bg-white rounded-3xl border border-outline-variant/10 shadow-sm p-8">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                        <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider">
                            Sesi Voting Pengadaan
                        </span>
                        
                        @php
                            $today = now()->toDateString();
                            $tglMulai = $voting->tgl_mulai->toDateString();
                            $tglSelesai = $voting->tgl_selesai->toDateString();
                        @endphp
                        @if($today < $tglMulai)
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wider">
                                Belum Mulai
                            </span>
                        @elseif($today <= $tglSelesai)
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">
                                Aktif Berlangsung
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-outline text-[10px] font-bold uppercase tracking-wider">
                                Selesai
                            </span>
                        @endif
                    </div>
                    
                    <h2 class="font-headline-md text-on-surface text-2xl mb-2">{{ $voting->title }}</h2>
                    <p class="text-sm text-outline mb-6">{{ $voting->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-6 border-t border-outline-variant/10">
                        <div>
                            <span class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-1">Tanggal Mulai</span>
                            <span class="font-semibold text-on-surface text-sm">{{ $voting->tgl_mulai->translatedFormat('d F Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-1">Tanggal Selesai</span>
                            <span class="font-semibold text-on-surface text-sm">{{ $voting->tgl_selesai->translatedFormat('d F Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-outline uppercase tracking-wider mb-1">Total Suara Masuk</span>
                            <span class="font-bold text-primary text-sm">{{ $totalSessionVotes }} suara</span>
                        </div>
                    </div>
                </section>

                <!-- Peringkat Kandidat (Bar Chart) -->
                <section class="bg-white rounded-3xl border border-outline-variant/10 shadow-sm p-8">
                    <h3 class="font-headline-md text-on-surface text-lg mb-6">Hasil Perolehan Suara Kandidat</h3>
                    
                    <div class="space-y-8">
                        @forelse($voting->votingItems as $item)
                            @php
                                $itemVotes = $item->votes->count();
                                $pct = $totalSessionVotes > 0 ? round(($itemVotes / $totalSessionVotes) * 100) : 0;
                            @endphp
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-on-surface text-sm">{{ $item->recommendation?->title }}</h4>
                                        <p class="text-xs text-outline">Karya: {{ $item->recommendation?->author ?: '-' }} | Diusulkan oleh: {{ $item->recommendation?->user?->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-bold text-primary">{{ $itemVotes }} suara</span>
                                        <span class="block text-[10px] text-outline font-semibold">{{ $pct }}%</span>
                                    </div>
                                </div>
                                
                                <!-- Progress Bar -->
                                <div class="w-full bg-surface-container rounded-full h-3.5 overflow-hidden">
                                    <div class="bg-primary h-full rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-outline font-medium text-sm">Tidak ada kandidat buku yang dimasukkan ke sesi voting ini.</div>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Right Column: Voters Logs -->
            <div>
                <section class="bg-white rounded-3xl border border-outline-variant/10 shadow-sm p-8 max-h-[600px] overflow-y-auto">
                    <h3 class="font-headline-md text-on-surface text-lg mb-4">Pemilih Terakhir</h3>
                    <p class="text-xs text-outline mb-6">Daftar pengguna yang menyalurkan hak suaranya pada sesi ini.</p>
                    
                    <div class="space-y-4">
                        @php $hasVotes = false; @endphp
                        @foreach($voting->votingItems as $item)
                            @foreach($item->votes as $vote)
                                @php $hasVotes = true; @endphp
                                <div class="flex items-center gap-3 p-3 rounded-2xl bg-surface-container-low border border-outline-variant/10">
                                    <div class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase flex-shrink-0">
                                        {{ substr($vote->user?->name, 0, 2) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-on-surface truncate leading-tight">{{ $vote->user?->name }}</p>
                                        <p class="text-[10px] text-outline font-semibold">Memilih: <strong class="text-primary">{{ $item->recommendation?->title }}</strong></p>
                                    </div>
                                    <div class="text-right text-[10px] text-outline font-semibold flex-shrink-0">
                                        {{ $vote->created_at->format('d/m H:i') }}
                                    </div>
                                </div>
                            @endforeach
                        @endforeach

                        @if(!$hasVotes)
                            <div class="text-center py-6 text-outline font-medium text-xs">Belum ada suara masuk.</div>
                        @endif
                    </div>
                </section>
            </div>
            
        </div>
    </main>
</body>
</html>
