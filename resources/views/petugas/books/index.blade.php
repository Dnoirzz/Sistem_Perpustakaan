<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Buku - SIPUS PSDKU POLNEP</title>
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
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Kelola Buku Perpustakaan</h1>
                <p class="text-sm text-outline">Tambahkan, ubah, dan kelola informasi serta stok buku perpustakaan.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">{{ Auth::user()->petugas?->jabatan ?? 'Petugas Perpustakaan' }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
                </div>
            </div>
        </header>

        <!-- Alert Section -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-250 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div class="font-semibold">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-250 rounded-2xl flex items-center gap-3 text-rose-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <div class="font-semibold">{{ session('error') }}</div>
            </div>
        @endif

        <!-- Tab Navigation for Pustaka -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div class="flex gap-4">
                <a href="{{ route('petugas.books.index') }}" class="px-6 py-3 rounded-2xl font-bold text-sm bg-primary text-white shadow-lg shadow-primary/20 transition-all">
                    Daftar Buku
                </a>
                <a href="{{ route('petugas.categories.index') }}" class="px-6 py-3 rounded-2xl font-bold text-sm bg-white border border-outline-variant/20 text-on-surface-variant hover:bg-slate-50 hover:text-primary transition-all">
                    Kategori Buku
                </a>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.books.import.form') }}" class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-600/20 transition-all">
                    <span class="material-symbols-outlined text-[18px]">upload_file</span>
                    Import Excel
                </a>
                <a href="{{ route('petugas.books.create') }}" class="flex items-center gap-2 px-6 py-3 rounded-2xl bg-primary text-white font-bold text-sm shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Buku Baru
                </a>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <section class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm mb-8">
            <form action="{{ route('petugas.books.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search input -->
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input type="text" name="search" placeholder="Cari judul buku atau penulis..." class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold" value="{{ request('search') }}"/>
                </div>

                <!-- Category selector -->
                <div>
                    <select name="category" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->kategori_id }}" {{ request('category') == $cat->kategori_id ? 'selected' : '' }}>
                                {{ $cat->kategori_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-95 transition-all">
                        Terapkan Filter
                    </button>
                    @if(request()->filled('search') || request()->filled('category'))
                        <a href="{{ route('petugas.books.index') }}" class="py-3 px-6 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-xs transition-all text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>

        <!-- Books Table Card -->
        <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest w-24">Cover</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Informasi Buku</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Kategori</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest w-28">Stok</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest w-28">Dipinjam</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs text-center uppercase tracking-widest w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($books as $book)
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <!-- Cover Column -->
                                <td class="px-8 py-4">
                                    <div class="w-12 h-16 bg-slate-100 rounded-lg overflow-hidden border border-outline-variant/20 flex items-center justify-center text-outline">
                                        @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover Buku" class="w-full h-full object-cover"/>
                                        @else
                                            <span class="material-symbols-outlined text-[24px]">book</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <!-- Info Column -->
                                <td class="px-8 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface text-sm leading-snug">{{ $book->judul }}</span>
                                        <span class="text-xs text-outline mt-0.5">Penulis: {{ $book->author }}</span>
                                        <span class="text-[10px] text-outline font-semibold">Penerbit: {{ $book->publisher ?? '-' }} ({{ $book->release ?? '-' }})</span>
                                    </div>
                                </td>
                                
                                <!-- Category Column -->
                                <td class="px-8 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold uppercase tracking-wider">
                                        {{ $book->category->kategori_name ?? 'Umum' }}
                                    </span>
                                </td>
                                
                                <!-- Stock Column -->
                                <td class="px-8 py-4">
                                    @if($book->stock > 0)
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-on-surface">{{ $book->stock }}</span>
                                            <span class="text-[10px] text-emerald-600 font-bold uppercase">Tersedia</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-rose-600">{{ $book->stock }}</span>
                                            <span class="text-[10px] text-rose-500 font-bold uppercase">Habis</span>
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Dipinjam Column -->
                                <td class="px-8 py-4">
                                    @if($book->active_loans_count > 0)
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-amber-600">{{ $book->active_loans_count }}</span>
                                            <span class="text-[10px] text-amber-500 font-bold uppercase">Dipinjam</span>
                                        </div>
                                    @else
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-outline-variant">0</span>
                                            <span class="text-[10px] text-outline-variant font-bold uppercase">—</span>
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Actions Column -->
                                <td class="px-8 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit button -->
                                        <a href="{{ route('petugas.books.edit', $book->buku_id) }}" class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center transition-all" title="Edit Buku">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>
                                        
                                        <!-- Delete form -->
                                        <form action="{{ route('petugas.books.destroy', $book->buku_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini? Semua data sirkulasi terkait buku ini juga dapat terpengaruh.')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-all" title="Hapus Buku">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-10 text-center text-outline font-medium">Data buku tidak ditemukan atau belum ditambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($books->hasPages())
                <div class="p-6 border-t border-outline-variant/10 bg-slate-50/50">
                    {{ $books->links() }}
                </div>
            @endif
        </section>
    </main>
</body>
</html>
