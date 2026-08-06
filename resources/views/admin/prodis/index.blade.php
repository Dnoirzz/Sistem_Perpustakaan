<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Prodi - SIPUS PSDKU POLNEP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @include('admin.layouts.sidebar')

    <!-- Main Content Area -->
    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Kelola Program Studi & Jurusan',
            'subtitle' => 'Kelola data program studi dan jurusan untuk pengelompokan mahasiswa dan dosen.'
        ])

        <!-- Success Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-3xl flex items-center gap-3 shadow-sm shadow-emerald-50">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error/Validation Notification -->
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-3xl flex items-center gap-3 shadow-sm shadow-rose-50">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-3xl shadow-sm shadow-rose-50">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-rose-600">error</span>
                    <span class="font-bold">Mohon perbaiki kesalahan berikut:</span>
                </div>
                <ul class="list-disc pl-8 space-y-1 font-semibold text-xs">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Navigation Tabs -->
        <div class="flex border-b border-outline-variant/100 mb-8 gap-2">
            <a href="{{ route('admin.prodis.index', ['tab' => 'prodi']) }}" 
               class="px-6 py-3.5 font-headline-md font-bold text-sm transition-all border-b-2 flex items-center gap-2 {{ $activeTab === 'prodi' ? 'border-primary text-primary' : 'border-transparent text-outline hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]">school</span>
                Kelola Program Studi
            </a>
            <a href="{{ route('admin.prodis.index', ['tab' => 'jurusan']) }}" 
               class="px-6 py-3.5 font-headline-md font-bold text-sm transition-all border-b-2 flex items-center gap-2 {{ $activeTab === 'jurusan' ? 'border-primary text-primary' : 'border-transparent text-outline hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]">domain</span>
                Kelola Jurusan
            </a>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: List -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Search Box -->
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm">
                    <form action="{{ route('admin.prodis.index') }}" method="GET" class="flex gap-3">
                        <input type="hidden" name="tab" value="{{ $activeTab }}">
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                            </span>
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search }}" 
                                   class="block w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/45 focus:border-primary transition duration-200 text-sm" 
                                   placeholder="{{ $activeTab === 'prodi' ? 'Cari nama program studi...' : 'Cari nama jurusan...' }}" />
                        </div>
                        <button type="submit" 
                                class="py-2.5 px-6 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-2xl text-sm transition duration-200 flex items-center justify-center gap-1.5 shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">search</span>
                            Cari
                        </button>
                        @if($search)
                            <a href="{{ route('admin.prodis.index', ['tab' => $activeTab]) }}" 
                               class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-2xl text-sm transition duration-200 flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Table Card -->
                <div class="bg-white rounded-3xl border border-outline-variant/100 shadow-sm overflow-hidden">
                    @if($activeTab === 'prodi')
                        <!-- TAB PRODI -->
                        <div class="p-8 border-b border-outline-variant/100 flex justify-between items-center">
                            <div>
                                <h2 class="font-headline-md text-on-surface text-lg">Daftar Program Studi</h2>
                                <p class="text-xs text-outline mt-1">Menampilkan data program studi terdaftar.</p>
                            </div>
                            <div class="text-xs font-bold text-outline">
                                Total: <span class="text-primary">{{ $prodis->total() }}</span> Prodi
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-surface-container-low/50 border-b border-outline-variant/100 text-outline-variant text-xs font-bold uppercase tracking-wider">
                                        <th class="py-4.5 px-8">Nama Program Studi</th>
                                        <th class="py-4.5 px-6">Jurusan</th>
                                        <th class="py-4.5 px-6 text-center">Mahasiswa</th>
                                        <th class="py-4.5 px-6 text-center">Dosen</th>
                                        <th class="py-4.5 px-8 text-center w-40">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/10 text-sm text-slate-700">
                                    @forelse($prodis as $p)
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="py-5 px-8">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase shadow-sm">
                                                        {{ substr($p->nama_prodi, 0, 2) }}
                                                    </div>
                                                    <div class="font-bold text-on-surface text-base">
                                                        {{ $p->nama_prodi }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-5 px-6 font-semibold text-slate-800">
                                                {{ $p->jurusan?->nama_jurusan ?? '-' }}
                                            </td>
                                            <td class="py-5 px-6 text-center font-semibold text-slate-800">
                                                {{ $p->mahasiswas_count }}
                                            </td>
                                            <td class="py-5 px-6 text-center font-semibold text-slate-800">
                                                {{ $p->dosens_count }}
                                            </td>
                                            <td class="py-5 px-8">
                                                <div class="flex items-center justify-center gap-2">
                                                    <!-- Edit button -->
                                                    <a href="{{ route('admin.prodis.edit', $p->prodi_id) }}" 
                                                       class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-amber-100 text-slate-600 hover:text-amber-700 flex items-center justify-center transition duration-200"
                                                       title="Edit Prodi">
                                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                                    </a>
                                                    
                                                    <!-- Delete button -->
                                                    <form action="{{ route('admin.prodis.destroy', $p->prodi_id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus Program Studi ini?')" 
                                                          class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-650 hover:text-rose-600 flex items-center justify-center transition duration-200"
                                                                title="Hapus Prodi">
                                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-12 text-center text-outline font-medium">Program studi tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($prodis->hasPages())
                            <div class="px-8 py-4 border-t border-outline-variant/100 bg-slate-50/50">
                                {{ $prodis->links() }}
                            </div>
                        @endif
                    @else
                        <!-- TAB JURUSAN -->
                        <div class="p-8 border-b border-outline-variant/100 flex justify-between items-center">
                            <div>
                                <h2 class="font-headline-md text-on-surface text-lg">Daftar Jurusan</h2>
                                <p class="text-xs text-outline mt-1">Menampilkan data jurusan terdaftar.</p>
                            </div>
                            <div class="text-xs font-bold text-outline">
                                Total: <span class="text-primary">{{ $jurusansPage->total() }}</span> Jurusan
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-surface-container-low/50 border-b border-outline-variant/100 text-outline-variant text-xs font-bold uppercase tracking-wider">
                                        <th class="py-4.5 px-8">Nama Jurusan</th>
                                        <th class="py-4.5 px-6 text-center">Jumlah Prodi</th>
                                        <th class="py-4.5 px-8 text-center w-40">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/10 text-sm text-slate-700">
                                    @forelse($jurusansPage as $j)
                                        <tr class="hover:bg-slate-50/50 transition">
                                            <td class="py-5 px-8">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase shadow-sm">
                                                        {{ substr($j->nama_jurusan, 0, 2) }}
                                                    </div>
                                                    <div class="font-bold text-on-surface text-base">
                                                        {{ $j->nama_jurusan }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-5 px-6 text-center font-semibold text-slate-800">
                                                {{ $j->prodis_count }}
                                            </td>
                                            <td class="py-5 px-8">
                                                <div class="flex items-center justify-center gap-2">
                                                    <!-- Edit button -->
                                                    <a href="{{ route('admin.jurusans.edit', $j->jurusan_id) }}" 
                                                       class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-amber-100 text-slate-600 hover:text-amber-700 flex items-center justify-center transition duration-200"
                                                       title="Edit Jurusan">
                                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                                    </a>
                                                    
                                                    <!-- Delete button -->
                                                    <form action="{{ route('admin.jurusans.destroy', $j->jurusan_id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus Jurusan ini?')" 
                                                          class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-650 hover:text-rose-600 flex items-center justify-center transition duration-200"
                                                                title="Hapus Jurusan">
                                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-12 text-center text-outline font-medium">Jurusan tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($jurusansPage->hasPages())
                            <div class="px-8 py-4 border-t border-outline-variant/100 bg-slate-50/50">
                                {{ $jurusansPage->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Right Column: Add Form -->
            <div class="space-y-6">
                @if($activeTab === 'prodi')
                    <!-- ADD PRODI FORM -->
                    <div class="bg-white rounded-3xl border border-outline-variant/100 p-8 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-headline-md text-on-surface text-lg">Tambah Prodi</h3>
                            <span class="material-symbols-outlined text-primary">school</span>
                        </div>
                        
                        <form action="{{ route('admin.prodis.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label for="nama_prodi" class="block text-xs font-bold text-outline uppercase tracking-wider">Nama Program Studi</label>
                                <input type="text" 
                                       name="nama_prodi" 
                                       id="nama_prodi" 
                                       placeholder="Contoh: D3 Teknologi Informasi" 
                                       class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all" 
                                       value="{{ old('nama_prodi') }}" 
                                       required/>
                            </div>

                            <div class="space-y-2">
                                <label for="jurusan_id" class="block text-xs font-bold text-outline uppercase tracking-wider">Jurusan</label>
                                <select name="jurusan_id" 
                                        id="jurusan_id" 
                                        class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all" 
                                        required>
                                    <option value="" disabled selected>-- Pilih Jurusan --</option>
                                    @foreach($jurusans as $j)
                                        <option value="{{ $j->jurusan_id }}" {{ old('jurusan_id') == $j->jurusan_id ? 'selected' : '' }}>
                                            {{ $j->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" 
                                    class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                Simpan Program Studi
                            </button>
                        </form>
                    </div>
                @else
                    <!-- ADD JURUSAN FORM -->
                    <div class="bg-white rounded-3xl border border-outline-variant/100 p-8 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-headline-md text-on-surface text-lg">Tambah Jurusan</h3>
                            <span class="material-symbols-outlined text-primary">domain</span>
                        </div>
                        
                        <form action="{{ route('admin.jurusans.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="space-y-2">
                                <label for="nama_jurusan" class="block text-xs font-bold text-outline uppercase tracking-wider">Nama Jurusan</label>
                                <input type="text" 
                                       name="nama_jurusan" 
                                       id="nama_jurusan" 
                                       placeholder="Contoh: Teknik Elektro" 
                                       class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all" 
                                       value="{{ old('nama_jurusan') }}" 
                                       required/>
                            </div>

                            <button type="submit" 
                                    class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                Simpan Jurusan
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    </main>
</body>
</html>
