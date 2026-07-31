<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Koleksi Buku - SIPUS PSDKU POLNEP</title>
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
            'title' => 'Koleksi Buku & Referensi',
            'subtitle' => 'Temukan referensi buku teks perkuliahan dan literatur lainnya.'
        ])

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div class="font-semibold">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center gap-3 text-rose-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <div class="font-semibold">{{ session('error') }}</div>
            </div>
        @endif

        <!-- Search & Filter Form -->
        <section class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm mb-8">
            <form action="{{ route('mahasiswa.books.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search query -->
                <div class="relative col-span-1 md:col-span-2">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input type="text" name="search" placeholder="Cari judul buku, penulis, atau penerbit..." class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold" value="{{ request('search') }}"/>
                </div>

                <!-- Category filter and Submit -->
                <div class="flex gap-2">
                    <select name="category" class="flex-1 px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->kategori_id }}" {{ request('category') == $cat->kategori_id ? 'selected' : '' }}>
                                {{ $cat->kategori_name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-95 transition-all">
                        Cari
                    </button>
                    
                    @if(request()->filled('search') || request()->filled('category'))
                        <a href="{{ route('mahasiswa.books.index') }}" class="py-3 px-4 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-xs flex items-center justify-center transition-all">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>

        <!-- Books Grid Catalog -->
        <section class="mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($books as $book)
                    <div class="bg-white rounded-3xl overflow-hidden border border-outline-variant/10 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group flex flex-col justify-between">
                        <div>
                            <!-- Cover area -->
                            <div class="h-56 bg-slate-50 relative flex items-center justify-center overflow-hidden border-b border-outline-variant/15">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                                @else
                                    <span class="material-symbols-outlined text-[80px] text-outline opacity-40">menu_book</span>
                                @endif
                                
                                <div class="absolute bottom-3 left-3 bg-white/80 backdrop-blur-md rounded-xl px-2.5 py-1 flex items-center">
                                    <span class="text-[9px] font-bold text-primary uppercase tracking-wider">
                                        {{ $book->category->kategori_name ?? 'Umum' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="p-6">
                                <h3 class="font-bold text-on-surface leading-tight text-sm line-clamp-2 group-hover:text-primary transition-colors duration-200" title="{{ $book->judul }}">
                                    {{ $book->judul }}
                                </h3>
                                <p class="text-xs text-outline mt-1 font-medium">Penulis: {{ $book->author }}</p>
                                <p class="text-[10px] text-outline-variant mt-0.5">Penerbit: {{ $book->publisher ?? '-' }} ({{ $book->release ?? '-' }})</p>
                            </div>
                        </div>

                        <!-- Card footer / actions -->
                        <div class="p-6 pt-0">
                            <div class="flex items-center justify-between gap-2 border-t border-outline-variant/10 pt-4 mt-2">
                                <!-- Status badge -->
                                @if($book->stock > 0)
                                    <div class="flex flex-col">
                                        <span class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider">Tersedia</span>
                                        <span class="text-xs font-bold text-on-surface">{{ $book->stock }} eks</span>
                                    </div>
                                    @if($book->collection)
                                        <form action="{{ route('mahasiswa.bookings.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="koleksi_id" value="{{ $book->collection->koleksi_id }}">
                                            <button type="submit" class="px-4 py-2 bg-primary/10 text-primary text-xs font-bold rounded-xl hover:bg-primary hover:text-white transition-all">
                                                Booking
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <div class="flex flex-col">
                                        <span class="text-[9px] text-rose-500 font-bold uppercase tracking-wider">Habis</span>
                                        <span class="text-xs font-bold text-rose-600">0 eks</span>
                                    </div>
                                    @if($book->collection)
                                        <form action="{{ route('mahasiswa.antrian.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="koleksi_id" value="{{ $book->collection->koleksi_id }}">
                                            <button type="submit" class="px-4 py-2 bg-rose-50 text-rose-600 text-xs font-bold rounded-xl hover:bg-rose-500 hover:text-white transition-all">
                                                Antri
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-12 text-center rounded-3xl border border-outline-variant/10 shadow-sm text-outline">
                        <span class="material-symbols-outlined text-[64px] text-outline opacity-40 mb-3">sentiment_dissatisfied</span>
                        <p class="font-bold text-lg">Buku tidak ditemukan</p>
                        <p class="text-xs text-outline-variant mt-1">Gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Pagination Section -->
        @if($books->hasPages())
            <section class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm">
                {{ $books->links() }}
            </section>
        @endif
    </main>
</body>
</html>
