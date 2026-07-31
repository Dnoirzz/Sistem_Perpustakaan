<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Buat Peminjaman - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
                        "primary": "#00a5c0",
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
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600" }],
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "caption": ["12px", { "lineHeight": "16px", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "600" }],
                        "headline-lg-mobile": ["28px", { "lineHeight": "36px", "fontWeight": "600" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
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
            background-color: #00a5c0;
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

        /* Custom styling overlay for Tom Select to match SIPUS POLNEP Design System and date inputs */
        .ts-wrapper.single .ts-control {
            background-color: #ffffff !important;
            border: 1px solid #c7c4d8 !important; /* outline-variant */
            border-radius: 1rem !important; /* rounded-2xl */
            padding: 0 1rem !important; /* px-4 equivalent */
            font-size: 0.875rem !important; /* text-sm */
            font-weight: 600 !important; /* font-semibold */
            color: #464555 !important; /* on-surface-variant */
            height: 46px !important; /* Match date input height exactly */
            display: flex !important;
            align-items: center !important;
            box-shadow: none !important;
            transition: all 0.2s ease;
        }
        
        .ts-wrapper.single.focus .ts-control {
            border-color: #00a5c0 !important; /* primary */
            box-shadow: 0 0 0 2px rgba(0, 165, 192, 0.2) !important; /* focus:ring-2 focus:ring-primary/20 */
        }
        
        .ts-wrapper.single .ts-control::after {
            border-color: #777587 transparent transparent transparent !important; /* outline color */
            border-width: 5px 4px 0 4px !important;
            right: 1.25rem !important;
        }
        
        .ts-wrapper.single.open .ts-control::after {
            border-color: transparent transparent #777587 transparent !important;
            border-width: 0 4px 5px 4px !important;
        }

        .ts-dropdown.single {
            border-radius: 1rem !important; /* rounded-2xl */
            border: 1px solid rgba(199, 196, 216, 0.5) !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
            margin-top: 4px !important;
            z-index: 1000 !important;
            background: #ffffff !important;
            padding: 0.5rem !important;
        }
        
        .ts-dropdown .option {
            padding: 0.75rem 1rem !important;
            border-radius: 0.75rem !important; /* rounded-xl */
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            color: #464555 !important;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        
        .ts-dropdown .option.active, .ts-dropdown .option:hover {
            background-color: #e2e7ff !important; /* surface-container-high / light indigo */
            color: #00a5c0 !important; /* primary */
        }

        .ts-dropdown .ts-dropdown-content {
            max-height: 250px !important;
        }
        
        /* Complete reset of Tailwind Forms on Tom Select input to prevent nested containers */
        .ts-wrapper.single .ts-control input,
        .ts-wrapper.single.input-active .ts-control input,
        .ts-wrapper.single.focus .ts-control input,
        .ts-wrapper.single .ts-control input:focus,
        .ts-wrapper.single .ts-control > .item {
            border: 0 !important;
            border-width: 0 !important;
            outline: 0 !important;
            outline-offset: 0 !important;
            box-shadow: none !important;
            background-color: transparent !important;
            background-image: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            height: auto !important;
            min-height: 0 !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            color: #131b2e !important; /* on-surface */
            --tw-ring-color: transparent !important;
            --tw-ring-shadow: none !important;
            --tw-ring-offset-width: 0px !important;
            --tw-ring-offset-shadow: none !important;
        }

        /* Style placeholder text color when visible */
        .ts-wrapper.single .ts-control input::placeholder,
        .ts-wrapper.single .ts-control input::-webkit-input-placeholder,
        .ts-wrapper.single .ts-control input::-moz-placeholder {
            color: #777587 !important;
            opacity: 1 !important;
        }

        /* Keep control input visible when select has placeholder class */
        .ts-wrapper.single.placeholder .ts-control input {
            opacity: 1 !important;
        }

        /* Custom styling overlay for Flatpickr */
        .flatpickr-calendar {
            border-radius: 1.25rem !important;
            border: 1px solid rgba(199, 196, 216, 0.4) !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08) !important;
            font-family: 'Inter', sans-serif !important;
            padding: 0.5rem !important;
        }
        .flatpickr-day.selected, .flatpickr-day.selected:hover {
            background: #00a5c0 !important;
            border-color: #00a5c0 !important;
        }
        .flatpickr-input[readonly] {
            background-color: #ffffff !important;
            cursor: pointer;
        }
    </style>
</head>

<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')

    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Buat Transaksi Peminjaman',
            'subtitle' => 'Pilih anggota dan buku yang tersedia, lalu tetapkan periode peminjaman.',
            'back_url' => route('petugas.loans.index')
        ])

        @if($errors->any())
            <div
                class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-start gap-3 text-rose-800 text-sm shadow-sm">
                <span class="material-symbols-outlined text-rose-600 mt-0.5">error</span>
                <div>
                    <div class="font-semibold mb-1">Form peminjaman belum bisa disimpan.</div>
                    <p class="text-xs text-rose-700">Periksa kembali data anggota, buku, dan periode pinjam yang Anda isi.
                    </p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <section class="xl:col-span-2 bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                <form action="{{ route('petugas.loans.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 md:col-span-2">
                            <label for="user_id"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Anggota
                                Peminjam</label>
                            <select name="user_id" id="user_id" class="w-full" required>
                                @foreach($members as $member)
                                    <option value="{{ $member->user_id }}" {{ old('user_id') == $member->user_id ? 'selected' : '' }}>
                                        {{ $member->name }} - {{ strtoupper($member->role->role_name) }}
                                        @if($member->role->role_name === 'mahasiswa')
                                            (NIM: {{ $member->mahasiswa->nim ?? '-' }})
                                        @else
                                            (NIP: {{ $member->dosen->nip ?? '-' }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-xs text-error font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 md:col-span-2">
                            <label for="collection_type"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Jenis
                                Koleksi</label>
                            <select name="collection_type" id="collection_type"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all">
                                <option value="">Semua jenis koleksi</option>
                                @foreach($collectionTypes as $typeValue => $typeLabel)
                                    <option value="{{ $typeValue }}" {{ old('collection_type') === $typeValue ? 'selected' : '' }}>
                                        {{ $typeLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cari & Tambah Koleksi -->
                        <div class="space-y-2 md:col-span-2">
                            <label for="koleksi_picker"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Cari & Tambah Koleksi yang Dipinjam</label>
                            <select id="koleksi_picker" class="w-full"></select>
                            <div id="koleksi_search_feedback"
                                class="hidden rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm shadow-rose-50">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-rose-600 text-[20px] leading-none mt-0.5">error</span>
                                    <div>
                                        <p class="font-semibold">Koleksi tidak dapat ditambahkan.</p>
                                        <p id="koleksi_search_feedback_text" class="mt-1 text-xs text-rose-700"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Koleksi Terpilih (Batch List) -->
                        <div class="space-y-3 md:col-span-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-outline uppercase tracking-wider">Daftar Koleksi Dipinjam</label>
                                <span id="selected_count_badge" class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold">0 Item Dipilih</span>
                            </div>

                            <div id="selected_books_list" class="space-y-2 min-h-[100px]">
                                <!-- Dynamic items rendered by JS -->
                            </div>
                            <div id="hidden_koleksi_inputs"></div>

                            @error('koleksi_ids')
                                <p class="text-xs text-error font-medium">{{ $message }}</p>
                            @enderror
                            @error('koleksi_ids.*')
                                <p class="text-xs text-error font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="tgl_pinjam"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Tanggal
                                Pinjam</label>
                            <input type="date" name="tgl_pinjam" id="tgl_pinjam"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                value="{{ old('tgl_pinjam', now()->toDateString()) }}" required />
                            @error('tgl_pinjam')
                                <p class="text-xs text-error font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="bts_waktu"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Batas Waktu
                                Pengembalian</label>
                            <input type="date" name="bts_waktu" id="bts_waktu"
                                class="w-full px-4 py-3 rounded-2xl border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold transition-all"
                                value="{{ old('bts_waktu', now()->addDays(7)->toDateString()) }}" required />
                            @error('bts_waktu')
                                <p class="text-xs text-error font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 border-t border-outline-variant/10 pt-6">
                        <a href="{{ route('petugas.loans.index') }}"
                            class="px-8 py-4 rounded-2xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm hover:bg-slate-50 transition-all text-center">
                            Kembali
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 px-8 py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-sm">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Simpan Peminjaman
                        </button>
                    </div>
                </form>
            </section>

            <div class="space-y-8">
                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="font-headline-md text-on-surface text-lg">Panduan Petugas</h2>
                        <span class="material-symbols-outlined text-primary">tips_and_updates</span>
                    </div>
                    <div class="space-y-4 text-sm text-on-surface-variant">
                        <div class="p-4 rounded-2xl bg-surface-container-low border border-outline-variant/10">
                            Anda dapat menambahkan <strong>beberapa koleksi sekaligus</strong> untuk satu anggota dalam 1 kali transaksi.
                        </div>
                        <div class="p-4 rounded-2xl bg-surface-container-low border border-outline-variant/10">
                            Sistem akan otomatis mengurangi stok masing-masing koleksi setelah transaksi berhasil disimpan.
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="font-headline-md text-on-surface text-lg">Stok Tersedia</h2>
                        <span class="material-symbols-outlined text-primary">inventory_2</span>
                    </div>
                    <div class="space-y-3">
                        <!-- Buku Umum -->
                        <div class="p-4 rounded-2xl border border-outline-variant/10 bg-slate-50/70 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">auto_stories</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-on-surface">Buku Umum</p>
                                    <p class="text-[11px] text-outline">Katalog buku teks & referensi</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                                {{ $stockSummary['book'] ?? 0 }} item
                            </span>
                        </div>

                        <!-- Laporan PKL -->
                        <div class="p-4 rounded-2xl border border-outline-variant/10 bg-slate-50/70 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">assignment</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-on-surface">Laporan PKL</p>
                                    <p class="text-[11px] text-outline">Arsip Praktek Kerja Lapangan</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                                {{ $stockSummary['laporan_pkl'] ?? 0 }} item
                            </span>
                        </div>

                        <!-- Proposal TA -->
                        <div class="p-4 rounded-2xl border border-outline-variant/10 bg-slate-50/70 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">description</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-on-surface">Proposal TA</p>
                                    <p class="text-[11px] text-outline">Arsip Proposal Tugas Akhir</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                                {{ $stockSummary['proposal_ta'] ?? 0 }} item
                            </span>
                        </div>

                        <!-- Laporan TA -->
                        <div class="p-4 rounded-2xl border border-outline-variant/10 bg-slate-50/70 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">article</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-on-surface">Laporan TA</p>
                                    <p class="text-[11px] text-outline">Arsip Laporan Tugas Akhir</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                                {{ $stockSummary['laporan_ta'] ?? 0 }} item
                            </span>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Batch books state management
            var selectedBooks = [
                @foreach($collections as $col)
                {
                    koleksi_id: "{{ $col->koleksi_id }}",
                    judul: {!! json_encode($col->display_title) !!},
                    author: {!! json_encode($col->book?->author ?? '') !!},
                    type_label: {!! json_encode($col->display_type_label) !!},
                    stock: {{ $col->stock }},
                    is_available: {{ $col->stock > 0 ? 'true' : 'false' }}
                },
                @endforeach
            ];

            function escapeHtml(text) {
                if (!text) return '';
                return String(text)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function renderSelectedBooks() {
                var listContainer = document.getElementById('selected_books_list');
                var inputsContainer = document.getElementById('hidden_koleksi_inputs');
                var badge = document.getElementById('selected_count_badge');

                if (!listContainer || !inputsContainer) return;

                listContainer.innerHTML = '';
                inputsContainer.innerHTML = '';

                badge.textContent = selectedBooks.length + ' Item Dipilih';

                if (selectedBooks.length === 0) {
                    listContainer.innerHTML = '<div class="p-6 rounded-2xl border-2 border-dashed border-outline-variant/30 text-center text-outline">'
                        + '<span class="material-symbols-outlined text-3xl mb-1 text-outline/60">library_add</span>'
                        + '<p class="text-xs font-medium">Belum ada koleksi yang dipilih.</p>'
                        + '<p class="text-[11px] text-outline/80 mt-0.5">Cari judul atau penulis buku untuk menambahkannya ke daftar peminjaman.</p>'
                        + '</div>';
                    return;
                }

                selectedBooks.forEach(function(item, idx) {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'koleksi_ids[]';
                    hiddenInput.value = item.koleksi_id;
                    inputsContainer.appendChild(hiddenInput);

                    var card = document.createElement('div');
                    card.className = 'p-4 rounded-2xl border border-outline-variant/20 bg-slate-50 flex items-center justify-between gap-4 transition-all hover:bg-white hover:shadow-sm';
                    card.innerHTML = '<div class="flex items-center gap-3 min-w-0">'
                        + '<div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">' + (idx + 1) + '</div>'
                        + '<div class="min-w-0">'
                        + '<p class="text-sm font-bold text-on-surface truncate">' + escapeHtml(item.judul) + '</p>'
                        + '<p class="text-xs text-outline mt-0.5">' + escapeHtml(item.type_label) + (item.author ? ' • ' + escapeHtml(item.author) : '') + '</p>'
                        + '</div>'
                        + '</div>'
                        + '<div class="flex items-center gap-3 shrink-0">'
                        + '<span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">Stok: ' + item.stock + '</span>'
                        + '<button type="button" data-index="' + idx + '" class="remove-book-btn w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition-colors">'
                        + '<span class="material-symbols-outlined text-[18px]">delete</span>'
                        + '</button>'
                        + '</div>';

                    listContainer.appendChild(card);
                });

                document.querySelectorAll('.remove-book-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var indexToRemove = parseInt(this.getAttribute('data-index'));
                        selectedBooks.splice(indexToRemove, 1);
                        renderSelectedBooks();
                    });
                });
            }

            renderSelectedBooks();

            // Initialize Tom Select for Member Selection
            var tsMember = new TomSelect('#user_id', {
                valueField: 'user_id',
                labelField: 'name_display',
                searchField: ['name'],
                load: function(query, callback) {
                    if (!query.length) return callback();
                    var url = '/petugas/loans/search-members?q=' + encodeURIComponent(query);
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            callback(json);
                        }).catch(()=>{
                            callback();
                        });
                },
                render: {
                    option: function(item, escape) {
                        if (!item || !item.name_display) return '';
                        return '<div class="py-1">' + escape(item.name_display) + '</div>';
                    },
                    item: function(item, escape) {
                        return '<div>' + escape((item && item.name_display) ? item.name_display : (item ? (item.text || '') : '')) + '</div>';
                    }
                },
                placeholder: "Cari berdasarkan Nama, NIP atau NIM",
                allowEmptyOption: true,
                create: false
            });

            tsMember.on('focus', function () {
                tsMember.control_input.placeholder = "";
            });
            tsMember.on('blur', function () {
                if (!tsMember.getValue()) {
                    tsMember.control_input.placeholder = "Cari nama atau NIM/NIP anggota...";
                }
            });

            // Initialize Tom Select for Book Picker (Batch Loan)
            var collectionTypeSelect = document.getElementById('collection_type');
            var collectionFeedback = document.getElementById('koleksi_search_feedback');
            var collectionFeedbackText = document.getElementById('koleksi_search_feedback_text');

            function showCollectionFeedback(message) {
                if (!collectionFeedback || !collectionFeedbackText) return;
                collectionFeedbackText.textContent = message;
                collectionFeedback.classList.remove('hidden');
            }

            function hideCollectionFeedback() {
                if (!collectionFeedback || !collectionFeedbackText) return;
                collectionFeedbackText.textContent = '';
                collectionFeedback.classList.add('hidden');
            }

            var tsBook = new TomSelect('#koleksi_picker', {
                valueField: 'koleksi_id',
                labelField: 'judul',
                searchField: ['judul', 'author', 'type_label', 'judul_display'],
                load: function(query, callback) {
                    if (!query.length) return callback();
                    var params = new URLSearchParams({ q: query });
                    if (collectionTypeSelect && collectionTypeSelect.value) {
                        params.append('type', collectionTypeSelect.value);
                    }

                    var url = '/petugas/loans/search-books?' + params.toString();
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            callback(json);
                        }).catch(()=>{
                            callback();
                        });
                },
                render: {
                    option: function(item, escape) {
                        if (!item || !item.judul) {
                            return '';
                        }
                        var stockClass = item.is_available
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'bg-rose-50 text-rose-700';
                        var stockLabel = item.is_available
                            ? 'Stok tersedia: ' + escape(String(item.stock))
                            : 'Stok habis';

                        return '<div class="py-2">'
                            + '<div class="font-semibold text-sm text-on-surface">' + escape(item.judul) + '</div>'
                            + '<div class="mt-1 text-xs text-outline">' + escape(item.type_label || '')
                            + (item.author ? ' • ' + escape(item.author) : '')
                            + '</div>'
                            + '<div class="mt-2 inline-flex items-center rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider ' + stockClass + '">' + stockLabel + '</div>'
                            + '</div>';
                    },
                    item: function(item, escape) {
                        return '<div>' + escape((item && item.judul) ? item.judul : (item ? (item.text || '') : '')) + '</div>';
                    }
                },
                placeholder: "Cari berdasarkan judul atau penulis",
                allowEmptyOption: true,
                create: false,
                onChange: function(value) {
                    if (!value) {
                        hideCollectionFeedback();
                        return;
                    }

                    var selectedItem = this.options[value];
                    if (!selectedItem) return;

                    if (!selectedItem.is_available) {
                        this.close();
                        this.clear(true);
                        showCollectionFeedback('Stok koleksi tidak tersedia. Koleksi ini tidak dapat ditambahkan.');
                        return;
                    }

                    var exists = selectedBooks.some(function(b) {
                        return String(b.koleksi_id) === String(selectedItem.koleksi_id);
                    });

                    if (exists) {
                        this.close();
                        this.clear(true);
                        showCollectionFeedback('Koleksi "' + selectedItem.judul + '" sudah ada di dalam daftar peminjaman.');
                        return;
                    }

                    selectedBooks.push({
                        koleksi_id: selectedItem.koleksi_id,
                        judul: selectedItem.judul,
                        author: selectedItem.author || '',
                        type_label: selectedItem.type_label || 'Koleksi',
                        stock: selectedItem.stock,
                        is_available: true
                    });

                    this.close();
                    this.clear(true);
                    hideCollectionFeedback();
                    renderSelectedBooks();
                }
            });

            tsBook.on('focus', function () {
                tsBook.control_input.placeholder = "";
            });
            tsBook.on('blur', function () {
                if (!tsBook.getValue()) {
                    tsBook.control_input.placeholder = "Cari judul koleksi atau penulis untuk menambahkan";
                }
            });
            tsBook.on('type', function () {
                hideCollectionFeedback();
            });
            tsBook.on('clear', function () {
                hideCollectionFeedback();
            });

            if (collectionTypeSelect) {
                collectionTypeSelect.addEventListener('change', function () {
                    tsBook.clear(true);
                    tsBook.clearOptions();
                    hideCollectionFeedback();
                    tsBook.control_input.value = '';
                    tsBook.refreshOptions(false);
                });
            }

            document.querySelector('form').addEventListener('submit', function(e) {
                if (selectedBooks.length === 0) {
                    e.preventDefault();
                    showCollectionFeedback('Silakan pilih minimal 1 koleksi untuk ditambahkan ke daftar peminjaman.');
                }
            });
        });
    </script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var dateConfig = {
                altInput: true,
                altFormat: "d/m/Y",
                dateFormat: "Y-m-d",
                locale: "id",
                disableMobile: "true"
            };

            var fpBts = flatpickr("#bts_waktu", Object.assign({}, dateConfig));

            var fpPinjam = flatpickr("#tgl_pinjam", Object.assign({}, dateConfig, {
                onChange: function(selectedDates) {
                    if (selectedDates[0]) {
                        var btsDate = new Date(selectedDates[0]);
                        btsDate.setDate(btsDate.getDate() + 7);
                        fpBts.setDate(btsDate, true);
                    }
                }
            }));
        });
    </script>
</body>

</html>
