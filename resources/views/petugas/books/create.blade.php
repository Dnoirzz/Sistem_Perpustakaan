<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tambah Buku - SIPUS PSDKU POLNEP</title>
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
        @include('layouts.header', [
            'title' => 'Tambah Buku Baru',
            'subtitle' => 'Masukkan informasi lengkap buku teks baru ke dalam database katalog.',
            'back_url' => route('petugas.books.index')
        ])

        <!-- Form Container -->
        <section class="max-w-6xl bg-white rounded-3xl shadow-sm border border-outline-variant/100 p-8">
            <form action="{{ route('petugas.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Left Column: Image Upload & Preview -->
                    <div class="space-y-4">
                        <span class="block text-xs font-bold text-outline uppercase tracking-wider">Cover Gambar Buku</span>
                        
                        <!-- Upload Box / Preview Area -->
                        <div class="relative w-full h-72 rounded-2xl border-2 border-dashed border-outline-variant/60 flex flex-col items-center justify-center bg-slate-50 overflow-hidden group">
                            <!-- Image Display -->
                            <img id="cover-preview" class="w-full h-full object-cover hidden" alt="Cover Preview"/>
                            
                            <!-- Static placeholder -->
                            <div id="preview-placeholder" class="flex flex-col items-center justify-center text-center p-4">
                                <span class="material-symbols-outlined text-[48px] text-outline opacity-60 mb-2">image</span>
                                <span class="text-xs text-outline font-semibold">Pilih file gambar cover</span>
                                <span class="text-[10px] text-outline-variant mt-1">Format: JPG, PNG, WEBP (Max: 2MB)</span>
                            </div>
                            
                            <!-- Hidden File Input Overlay -->
                            <input type="file" name="cover_image" id="cover_image" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(event)"/>
                        </div>
                        @error('cover_image')
                            <p class="text-xs text-error font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Right Column: Fields (Span 2) -->
                    <div class="md:col-span-2 space-y-6">
                        <!-- Judul Buku -->
                        <div class="space-y-2">
                            <label for="judul" class="block text-xs font-bold text-outline uppercase tracking-wider">Judul Buku</label>
                            <input type="text" name="judul" id="judul" placeholder="Masukkan Judul Buku" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all" value="{{ old('judul') }}" required oninvalid="this.setCustomValidity('Judul buku wajib diisi.')" oninput="this.setCustomValidity('')"/>
                            @error('judul')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penulis & Kategori Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Penulis -->
                            <div class="space-y-2">
                                <label for="author" class="block text-xs font-bold text-outline uppercase tracking-wider">Penulis / Author</label>
                                <input type="text" name="author" id="author" placeholder="Masukkan Nama Penulis" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all" value="{{ old('author') }}" required oninvalid="this.setCustomValidity('Nama penulis wajib diisi.')" oninput="this.setCustomValidity('')"/>
                                @error('author')
                                    <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div class="space-y-2">
                                <label for="kategori_id" class="block text-xs font-bold text-outline uppercase tracking-wider">Kategori Buku</label>
                                <select name="kategori_id" id="kategori_id" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold text-on-surface-variant transition-all" required oninvalid="this.setCustomValidity('Silakan pilih kategori buku terlebih dahulu.')" oninput="this.setCustomValidity('')">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->kategori_id }}" {{ old('kategori_id') == $cat->kategori_id ? 'selected' : '' }}>
                                            {{ $cat->kategori_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Penerbit, Tahun, Stok Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
                            <!-- Penerbit -->
                            <div class="sm:col-span-2 space-y-2">
                                <label for="publisher" class="block text-xs font-bold text-outline uppercase tracking-wider">Penerbit</label>
                                <input type="text" name="publisher" id="publisher" placeholder="Masukkan Nama Penerbit" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all" value="{{ old('publisher') }}"/>
                                @error('publisher')
                                    <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tahun Terbit -->
                            <div class="space-y-2">
                                <label for="release" class="block text-xs font-bold text-outline uppercase tracking-wider">Tahun Terbit <span class="text-error">*</span></label>
                                <input type="number" name="release" id="release" placeholder="2024" min="1900" max="{{ date('Y') }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all" value="{{ old('release') }}" required oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Tahun terbit wajib diisi.' : (this.validity.rangeOverflow ? 'Tahun terbit tidak boleh lebih dari {{ date('Y') }}.' : (this.validity.rangeUnderflow ? 'Tahun terbit minimal tahun 1900.' : 'Tahun terbit tidak valid.')))" oninput="this.setCustomValidity('')"/>
                                @error('release')
                                    <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div class="space-y-2">
                                <label for="stock" class="block text-xs font-bold text-outline uppercase tracking-wider">Stok Buku <span class="text-error">*</span></label>
                                <input type="number" name="stock" id="stock" placeholder="5" min="0" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all" value="{{ old('stock') }}" required oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Stok buku wajib diisi.' : (this.validity.rangeUnderflow ? 'Stok buku tidak boleh kurang dari 0.' : 'Stok buku tidak valid.'))" oninput="this.setCustomValidity('')"/>
                                @error('stock')
                                    <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="flex justify-end gap-4 border-t border-outline-variant/100 pt-6">
                    <a href="{{ route('petugas.books.index') }}" class="px-8 py-4 rounded-2xl border border-outline-variant/100 text-on-surface-variant font-bold text-sm hover:bg-slate-50 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex items-center gap-2 px-8 py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Buku Baru
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script>
        // Image preview logic
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('cover-preview');
            const placeholder = document.getElementById('preview-placeholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
