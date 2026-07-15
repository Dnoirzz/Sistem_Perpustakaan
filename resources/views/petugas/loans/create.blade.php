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
    </style>
</head>

<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')

    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Buat Transaksi Peminjaman</h1>
                <p class="text-sm text-outline">Pilih anggota dan buku yang tersedia, lalu tetapkan periode peminjaman.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">{{ Auth::user()->petugas?->jabatan ?? 'Petugas Perpustakaan' }}</p>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                    <img alt="User Avatar" class="w-full h-full object-cover"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true" />
                </div>
            </div>
        </header>

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

                        <div class="space-y-2 md:col-span-2">
                            <label for="koleksi_id"
                                class="block text-xs font-bold text-outline uppercase tracking-wider">Koleksi yang
                                Dipinjam</label>
                            <select name="koleksi_id" id="koleksi_id" class="w-full" required>
                                @foreach($collections as $collection)
                                    <option value="{{ $collection->koleksi_id }}" {{ old('koleksi_id') == $collection->koleksi_id ? 'selected' : '' }}>
                                        {{ $collection->display_title }} - {{ $collection->display_type_label }} (Stok: {{ $collection->stock }})
                                    </option>
                                @endforeach
                            </select>
                            <div id="koleksi_search_feedback"
                                class="hidden rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm shadow-rose-50">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-outlined text-rose-600 text-[20px] leading-none mt-0.5">error</span>
                                    <div>
                                        <p class="font-semibold">Koleksi tidak dapat dipilih.</p>
                                        <p id="koleksi_search_feedback_text" class="mt-1 text-xs text-rose-700"></p>
                                    </div>
                                </div>
                            </div>
                            @error('koleksi_id')
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
                            Pilih hanya anggota berstatus mahasiswa atau dosen yang benar-benar hadir dan sudah
                            diverifikasi.
                        </div>
                        <div class="p-4 rounded-2xl bg-surface-container-low border border-outline-variant/10">
                            Sistem akan otomatis mengurangi stok koleksi yang tersedia setelah transaksi berhasil disimpan.
                        </div>
                        <div class="p-4 rounded-2xl bg-surface-container-low border border-outline-variant/10">
                            Anggota tidak bisa meminjam koleksi yang sama jika masih memiliki pinjaman aktif
                            sebelumnya.
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="font-headline-md text-on-surface text-lg">Ketersediaan Saat Ini</h2>
                        <span class="material-symbols-outlined text-primary">library_books</span>
                    </div>
                    <div class="space-y-3 max-h-[420px] overflow-y-auto pr-1">
                        @forelse($collections->take(8) as $book)
                            <div class="p-4 rounded-2xl border border-outline-variant/10 bg-slate-50/70">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-bold text-on-surface leading-snug">{{ $book->display_title }}</p>
                                        <p class="text-[11px] text-outline mt-1">{{ $book->display_type_label }}
                                            @if($book->book?->author)
                                                • {{ $book->book->author }}
                                            @endif
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">
                                        {{ $book->stock }} tersedia
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div
                                class="p-4 rounded-2xl border border-outline-variant/10 bg-slate-50/70 text-sm text-outline">
                                Belum ada buku dengan stok tersedia untuk dipinjam.
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize Tom Select for Member Selection (AJAX dynamic search)
            var tsMember = new TomSelect('#user_id', {
                valueField: 'user_id',
                labelField: 'name_display',
                searchField: ['name'],
                // fetch remote data
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
                        return '<div class="py-1">' + escape(item.name_display) + '</div>';
                    },
                    item: function(item, escape) {
                        return '<div>' + escape(item.name_display) + '</div>';
                    }
                },
                placeholder: "Cari Berdasarkan Nama, NIP atau NIM",
                allowEmptyOption: true,
                create: false
            });

            // Dynamically clear placeholder on focus, restore on blur if empty
            tsMember.on('focus', function () {
                tsMember.control_input.placeholder = "";
            });
            tsMember.on('blur', function () {
                if (!tsMember.getValue()) {
                    tsMember.control_input.placeholder = "Cari nama atau NIM/NIP anggota...";
                }
            });

            // Initialize Tom Select for Book Selection (AJAX dynamic search)
            var collectionTypeSelect = document.getElementById('collection_type');
            var collectionFeedback = document.getElementById('koleksi_search_feedback');
            var collectionFeedbackText = document.getElementById('koleksi_search_feedback_text');
            function showCollectionFeedback(message) {
                if (!collectionFeedback || !collectionFeedbackText) {
                    return;
                }

                collectionFeedbackText.textContent = message;
                collectionFeedback.classList.remove('hidden');
            }

            function hideCollectionFeedback() {
                if (!collectionFeedback || !collectionFeedbackText) {
                    return;
                }

                collectionFeedbackText.textContent = '';
                collectionFeedback.classList.add('hidden');
            }

            var tsBook = new TomSelect('#koleksi_id', {
                valueField: 'koleksi_id',
                labelField: 'judul',
                searchField: ['judul', 'author', 'type_label', 'judul_display'],
                // fetch remote data
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
                        var stockClass = item.is_available
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'bg-rose-50 text-rose-700';
                        var stockLabel = item.is_available
                            ? 'Stok tersedia: ' + escape(String(item.stock))
                            : 'Stok habis';

                        return '<div class="py-2">'
                            + '<div class="font-semibold text-sm text-on-surface">' + escape(item.judul) + '</div>'
                            + '<div class="mt-1 text-xs text-outline">' + escape(item.type_label)
                            + (item.author ? ' • ' + escape(item.author) : '')
                            + '</div>'
                            + '<div class="mt-2 inline-flex items-center rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider ' + stockClass + '">' + stockLabel + '</div>'
                            + '</div>';
                    },
                    item: function(item, escape) {
                        return '<div>' + escape(item.judul) + '</div>';
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
                    if (!selectedItem || selectedItem.is_available) {
                        hideCollectionFeedback();
                        return;
                    }

                    this.close();
                    this.clear(true);
                    showCollectionFeedback('Stok buku tidak tersedia. Koleksi ini tidak dapat dipilih untuk transaksi peminjaman.');
                }
            });

            // Dynamically clear placeholder on focus, restore on blur if empty
            tsBook.on('focus', function () {
                tsBook.control_input.placeholder = "";
            });
            tsBook.on('blur', function () {
                if (!tsBook.getValue()) {
                    tsBook.control_input.placeholder = "Cari judul koleksi, penulis, atau jenis arsip...";
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
        });
    </script>
</body>

</html>
