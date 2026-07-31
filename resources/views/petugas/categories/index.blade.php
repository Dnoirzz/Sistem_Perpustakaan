<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Kategori - SIPUS PSDKU POLNEP</title>
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
        @include('petugas.layouts.header', [
            'title' => 'Kelola Kategori Buku',
            'subtitle' => 'Atur pengelompokan klasifikasi kategori koleksi pustaka perpustakaan.'
        ])

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

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-250 rounded-2xl text-rose-800 text-sm shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-rose-600">error</span>
                    <span class="font-bold">Mohon perbaiki kesalahan berikut:</span>
                </div>
                <ul class="list-disc pl-8 space-y-1 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tab Navigation for Pustaka -->
        <div class="flex gap-4 mb-8">
            <a href="{{ route('petugas.books.index') }}" class="px-6 py-3 rounded-2xl font-bold text-sm bg-white border border-outline-variant/20 text-on-surface-variant hover:bg-slate-50 hover:text-primary transition-all">
                Daftar Buku
            </a>
            <a href="{{ route('petugas.categories.index') }}" class="px-6 py-3 rounded-2xl font-bold text-sm bg-primary text-white shadow-lg shadow-primary/20 transition-all">
                Kategori Buku
            </a>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Categories List -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
                    <div class="p-8 border-b border-outline-variant/10">
                        <h2 class="font-headline-md text-on-surface text-lg">Daftar Kategori</h2>
                        <p class="text-xs text-outline mt-1">Total kategori yang terdaftar dalam sistem perpustakaan.</p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-surface-container-low/50">
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Nama Kategori</th>
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Jumlah Buku</th>
                                    <th class="px-8 py-4 font-label-md text-outline-variant text-xs text-center uppercase tracking-widest w-40">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                @forelse($categories as $cat)
                                    <tr class="hover:bg-surface-container-low/30 transition-colors">
                                        <td class="px-8 py-5">
                                            <div class="font-semibold text-on-surface text-sm">
                                                {{ $cat->kategori_name }}
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-sm font-semibold text-on-surface-variant">
                                            {{ $cat->books_count }} buku
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- Edit button -->
                                                <a href="{{ route('petugas.categories.edit', $cat->kategori_id) }}" class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center transition-all" title="Edit Kategori">
                                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                                </a>
                                                
                                                <!-- Delete form -->
                                                <form action="{{ route('petugas.categories.destroy', $cat->kategori_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-all" title="Hapus Kategori">
                                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-8 text-center text-outline font-medium">Belum ada kategori buku terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($categories->hasPages())
                        <div class="p-6 border-t border-outline-variant/10 bg-slate-50/50">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Add Category Form -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-headline-md text-on-surface text-lg">Tambah Kategori</h3>
                        <span class="material-symbols-outlined text-primary">library_add</span>
                    </div>
                    
                    <form action="{{ route('petugas.categories.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label for="kategori_name" class="block text-xs font-bold text-outline uppercase tracking-wider">Nama Kategori</label>
                            <input type="text" name="kategori_name" id="kategori_name" placeholder="Contoh: Pemrograman Web" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all" value="{{ old('kategori_name') }}" required/>
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Simpan Kategori
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>
</body>
</html>
