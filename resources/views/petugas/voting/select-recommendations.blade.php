<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pilih Usulan Buku - SIPUS PSDKU POLNEP</title>
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
            background-color: #00a5c0;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2);
        }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')

    <main class="ml-64 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Pilih Usulan Buku',
            'subtitle' => 'Pilih usulan buku civitas akademika untuk dimasukkan ke sesi voting.',
            'back_url' => route('petugas.voting.show', $voting->voting_id)
        ])

        <!-- Search and Filter Form -->
        <section class="mb-8">
            <div class="bg-white rounded-3xl border border-outline-variant/10 shadow-sm p-6">
                <form action="{{ route('petugas.voting.select-recommendations', $voting->voting_id) }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
                    <div class="flex-1 w-full relative">
                        <span class="material-symbols-outlined text-outline absolute left-4 top-1/2 -translate-y-1/2 text-[20px]">search</span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul buku atau nama penulis..." class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/45 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold transition-all">
                    </div>
                    <div class="w-full md:w-48">
                        <select name="sort_by" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/45 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold transition-all">
                            <option value="latest" {{ $sortBy === 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="title_asc" {{ $sortBy === 'title_asc' ? 'selected' : '' }}>Judul: A - Z</option>
                            <option value="title_desc" {{ $sortBy === 'title_desc' ? 'selected' : '' }}>Judul: Z - A</option>
                        </select>
                    </div>
                    <div class="w-full md:w-auto flex gap-2">
                        <button type="submit" class="flex-1 md:flex-initial px-6 py-3 rounded-2xl bg-primary hover:bg-primary/90 text-white text-xs font-bold transition-all shadow-sm flex items-center justify-center gap-2">
                            Cari
                        </button>
                        @if($search)
                            <a href="{{ route('petugas.voting.select-recommendations', $voting->voting_id) }}" class="px-6 py-3 rounded-2xl border border-outline-variant/30 text-xs font-bold text-outline hover:bg-slate-50 transition-all flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </section>

        <!-- Main Form Checklist -->
        <section class="bg-white rounded-3xl border border-outline-variant/10 shadow-sm overflow-hidden p-8">
            <form action="{{ route('petugas.voting.add-recommendations-batch', $voting->voting_id) }}" method="POST" id="batch-form" class="space-y-6">
                @csrf

                <!-- Action Bar (Floating indicator style) -->
                <div class="flex justify-between items-center pb-4 border-b border-outline-variant/10">
                    <span class="text-xs text-slate-600 font-semibold">Terpilih: <strong id="selected-count" class="text-primary text-sm font-extrabold">0</strong> usulan</span>
                    <button type="submit" id="submit-btn" disabled class="px-8 py-3 rounded-2xl bg-primary hover:bg-primary/90 disabled:bg-slate-100 disabled:text-slate-400 text-white text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">add_circle</span>
                        Tambahkan Buku Terpilih
                    </button>
                </div>

                <!-- Table -->
                <x-table :pagination="$recommendations->appends(['search' => $search, 'sort_by' => $sortBy])->links()">
                    <x-slot name="headers">
                        <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap w-12 text-center">
                            <input type="checkbox" id="select-all" class="rounded text-teal-600 focus:ring-teal-500/20 border-slate-300 cursor-pointer">
                        </th>
                        <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap w-12 text-center">No</th>
                        <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Judul Buku & Riwayat Sesi</th>
                        <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Penulis</th>
                        <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Pengusul</th>
                        <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-center text-slate-700 whitespace-nowrap">Tanggal Usulan</th>
                    </x-slot>

                    @forelse($recommendations as $index => $rec)
                        <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group">
                            <td class="px-8 py-5 text-center whitespace-nowrap">
                                <input type="checkbox" name="rekomendasi_ids[]" value="{{ $rec->rekomendasi_id }}" class="rec-checkbox rounded text-teal-600 focus:ring-teal-500/20 border-slate-300 cursor-pointer">
                            </td>
                            <td class="px-8 py-5 text-center text-slate-500 font-bold whitespace-nowrap">
                                {{ $recommendations->firstItem() + $index }}
                            </td>
                            <td class="px-8 py-5">
                                <div>
                                    <span class="font-bold text-slate-900 text-sm block leading-snug group-hover:text-teal-700 transition-colors">{{ $rec->title }}</span>
                                    
                                    <!-- Riwayat Voting Sebelumnya -->
                                    @foreach($rec->votingItems as $vi)
                                        @if($vi->voting)
                                            <span class="inline-flex items-center px-2.5 py-0.5 mt-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-extrabold border border-amber-200">
                                                Pernah di-voting pada: {{ $vi->voting->title }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-8 py-5 text-slate-700 font-semibold whitespace-nowrap">{{ $rec->author ?: '-' }}</td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $rec->user?->name ?: 'Umum' }}</span>
                                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ $rec->user?->role?->role_name ?: 'Petugas' }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center font-semibold text-slate-700 whitespace-nowrap">
                                {{ $rec->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-14 text-center text-slate-500 font-medium">Tidak ada buku usulan baru yang tersedia.</td>
                        </tr>
                    @endforelse
                </x-table>
            </form>
        </section>
    </main>

    <script>
        const checkboxes = document.querySelectorAll('.rec-checkbox');
        const submitBtn = document.getElementById('submit-btn');
        const countSpan = document.getElementById('selected-count');

        function updateCount() {
            const checkedCount = document.querySelectorAll('.rec-checkbox:checked').length;
            countSpan.textContent = checkedCount;
            if (checkedCount > 0) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateCount);
        });

        // Toggle all checkboxes
        document.getElementById('select-all').addEventListener('change', function() {
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
            });
            updateCount();
        });
    </script>
</body>
</html>
