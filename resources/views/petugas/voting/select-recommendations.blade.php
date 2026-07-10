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

    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <!-- Top Bar / Header Info -->
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <a href="{{ route('petugas.voting.show', $voting->voting_id) }}" class="p-2 rounded-2xl bg-white border border-outline-variant/30 text-outline hover:text-on-surface hover:shadow-sm transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-headline-md text-on-surface">Pilih Usulan Buku</h1>
                    <p class="text-sm text-outline font-medium">Pilih satu atau beberapa usulan buku civitas akademika untuk dimasukkan ke sesi: <strong class="text-primary">{{ $voting->title }}</strong></p>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-primary-container flex items-center justify-center overflow-hidden border-2 border-white shadow-sm">
                <img alt="User Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e2e7ff&color=00a5c0&bold=true"/>
            </div>
        </header>

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
                        <button type="submit" class="flex-1 md:flex-initial px-6 py-3 rounded-2xl bg-primary hover:bg-primary/90 text-white text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2">
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
                    <span class="text-xs text-outline font-semibold">Terpilih: <strong id="selected-count" class="text-primary text-sm font-bold">0</strong> usulan</span>
                    <button type="submit" id="submit-btn" disabled class="px-8 py-3 rounded-2xl bg-primary hover:bg-primary/90 disabled:bg-slate-100 disabled:text-outline text-white text-xs font-bold transition-all shadow-md flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">add_circle</span>
                        Tambahkan Buku Terpilih
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-outline-variant/15 text-outline uppercase tracking-wider text-[10px] font-bold">
                                <th class="pb-4 pt-2 w-12 text-center">
                                    <input type="checkbox" id="select-all" class="rounded text-primary focus:ring-primary/20 border-outline-variant/50 cursor-pointer">
                                </th>
                                <th class="pb-4 pt-2 w-12 text-center">No</th>
                                <th class="pb-4 pt-2">Judul Buku & Riwayat Sesi</th>
                                <th class="pb-4 pt-2">Penulis</th>
                                <th class="pb-4 pt-2">Pengusul</th>
                                <th class="pb-4 pt-2 text-center">Tanggal Usulan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10 text-xs font-semibold text-on-surface-variant">
                            @forelse($recommendations as $index => $rec)
                                <tr>
                                    <td class="py-4 text-center">
                                        <input type="checkbox" name="rekomendasi_ids[]" value="{{ $rec->rekomendasi_id }}" class="rec-checkbox rounded text-primary focus:ring-primary/20 border-outline-variant/50 cursor-pointer">
                                    </td>
                                    <td class="py-4 text-center text-outline">
                                        {{ $recommendations->firstItem() + $index }}
                                    </td>
                                    <td class="py-4">
                                        <div>
                                            <span class="font-bold text-on-surface text-sm block leading-snug">{{ $rec->title }}</span>
                                            
                                            <!-- Riwayat Voting Sebelumnya -->
                                            @foreach($rec->votingItems as $vi)
                                                @if($vi->voting)
                                                    <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded bg-amber-50 text-amber-700 text-[10px] font-semibold border border-amber-200">
                                                        Pernah di-voting pada: {{ $vi->voting->title }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-4 font-medium">{{ $rec->author ?: '-' }}</td>
                                    <td class="py-4">
                                        <div>
                                            <span class="font-bold text-on-surface block">{{ $rec->user?->name ?: 'Umum' }}</span>
                                            <span class="text-[10px] text-outline font-semibold uppercase tracking-wider">{{ $rec->user?->role?->role_name ?: 'Petugas' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center font-medium text-outline">
                                        {{ $rec->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-outline font-medium">Tidak ada buku usulan baru yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pt-4 border-t border-outline-variant/10">
                    {{ $recommendations->appends(['search' => $search, 'sort_by' => $sortBy])->links() }}
                </div>
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
