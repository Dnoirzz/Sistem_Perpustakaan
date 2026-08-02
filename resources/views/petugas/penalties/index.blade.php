<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Denda & Sanksi - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-background": "#131b2e", "surface": "#faf8ff", "outline": "#777587",
                        "on-tertiary-fixed": "#40000d", "secondary-fixed": "#6ffbbe", "secondary-fixed-dim": "#4edea3",
                        "on-tertiary": "#ffffff", "outline-variant": "#c7c4d8", "surface-container-highest": "#dae2fd",
                        "surface-container-high": "#e2e7ff", "on-error": "#ffffff", "background": "#faf8ff",
                        "on-primary": "#ffffff", "on-secondary": "#ffffff", "on-secondary-fixed": "#002113",
                        "tertiary-fixed-dim": "#ffb2b7", "surface-variant": "#dae2fd", "surface-container": "#eaedff",
                        "secondary-container": "#6cf8bb", "secondary": "#006c49", "tertiary": "#95002b",
                        "tertiary-fixed": "#ffdadb", "primary": "#00a5c0", "on-primary-container": "#dad7ff",
                        "surface-dim": "#d2d9f4", "tertiary-container": "#bf0f3c", "on-tertiary-fixed-variant": "#92002a",
                        "error-container": "#ffdad6", "inverse-on-surface": "#eef0ff", "on-secondary-fixed-variant": "#005236",
                        "surface-bright": "#faf8ff", "surface-container-lowest": "#ffffff", "on-surface": "#131b2e",
                        "surface-tint": "#00a5c0", "on-primary-fixed-variant": "#007b91", "inverse-surface": "#283044",
                        "surface-container-low": "#f2f3ff", "error": "#ba1a1a", "on-surface-variant": "#464555",
                        "primary-fixed": "#e2dfff", "on-secondary-container": "#00714d", "primary-container": "#00a5c0",
                        "primary-fixed-dim": "#c3c0ff", "on-primary-fixed": "#0f0069", "on-tertiary-container": "#ffd0d2",
                        "on-error-container": "#93000a", "inverse-primary": "#c3c0ff"
                    },
                    "borderRadius": { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1rem", "3xl": "1.5rem", "full": "9999px" },
                    "spacing": { "container-max": "1280px", "base": "8px", "margin-mobile": "16px", "gutter": "24px", "margin-desktop": "40px" },
                    "fontFamily": { "headline-md": ["Outfit"], "label-md": ["Inter"], "display-lg": ["Outfit"], "caption": ["Inter"], "headline-lg": ["Outfit"], "headline-lg-mobile": ["Outfit"], "body-lg": ["Inter"], "body-md": ["Inter"] },
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
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #f8faff; color: #131b2e; }
        .sidebar-active { background-color: #00a5c0; color: white; box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2); }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c7c4d8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #b1afc2; }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')

    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('petugas.layouts.header', [
            'title' => 'Denda & Sanksi',
            'subtitle' => 'Kelola denda keterlambatan, kehilangan, dan kerusakan buku perpustakaan.'
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

        <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <span class="material-symbols-outlined">gavel</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Denda Aktif</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold {{ $stats['unpaid_count'] > 0 ? 'text-rose-600' : 'text-on-surface' }}">{{ $stats['unpaid_count'] }}</span>
                    <span class="text-xs text-outline font-semibold">denda</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Total Nominal Belum Bayar</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">Rp {{ number_format($stats['unpaid_total'], 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Lunas Hari Ini</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['paid_today'] }}</span>
                    <span class="text-xs text-outline font-semibold">denda</span>
                </div>
            </div>
        </section>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <section class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm flex-1">
                <form action="{{ route('petugas.penalties.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                        <input type="text" name="search" placeholder="Cari nama anggota, NIM, NIP, atau judul buku..." class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold" value="{{ request('search') }}"/>
                    </div>
                    <div>
                        <select name="status" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                            <option value="">Semua Status</option>
                            <option value="belum_dibayar" {{ request('status') === 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-95 transition-all">Terapkan Filter</button>
                        @if(request()->filled('search') || request()->filled('status'))
                            <a href="{{ route('petugas.penalties.index') }}" class="py-3 px-6 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-xs transition-all text-center">Reset</a>
                        @endif
                    </div>
                </form>
            </section>
            <a href="{{ route('petugas.penalties.create') }}" class="flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-primary text-white font-bold text-sm shadow-lg shadow-primary/20 hover:bg-opacity-95 transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Buat Denda Manual
            </a>
        </div>

        <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Anggota</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Buku</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Jenis</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Penyelesaian</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Nominal</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Status</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($penalties as $penalty)
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase border border-outline-variant/10 shadow-sm">
                                            {{ substr($penalty->user->name ?? '', 0, 2) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-on-surface text-sm">{{ $penalty->user->name ?? '-' }}</span>
                                            <span class="text-[10px] text-outline font-bold tracking-wider uppercase">
                                                @if($penalty->user?->role?->role_name === 'mahasiswa')
                                                    NIM {{ $penalty->user->mahasiswa->nim ?? '-' }}
                                                @elseif($penalty->user?->role?->role_name === 'dosen')
                                                    NIP {{ $penalty->user->dosen->nip ?? '-' }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface text-sm">{{ $penalty->loan?->collection?->display_title ?? '-' }}</span>
                                        @if($penalty->loan?->collection)
                                            <span class="text-[10px] text-outline font-semibold">{{ $penalty->loan->collection->display_type_label }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    @php
                                        $typeColors = [
                                            'keterlambatan' => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                            'kehilangan' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                            'kerusakan' => 'bg-orange-50 text-orange-700 border-orange-200/60',
                                        ];
                                        $color = $typeColors[$penalty->type] ?? 'bg-slate-50 text-slate-700 border-slate-200/60';
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $color }} border text-[10px] font-bold uppercase tracking-wider whitespace-nowrap shadow-sm">
                                        {{ ucfirst($penalty->type) }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    @php
                                        $settlementColors = [
                                            'uang_tunai' => 'bg-sky-50 text-sky-700 border-sky-200/60',
                                            'denda' => 'bg-sky-50 text-sky-700 border-sky-200/60',
                                            'ganti_buku' => 'bg-violet-50 text-violet-700 border-violet-200/60',
                                            'kombinasi' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                        ];
                                        $settlementColor = $settlementColors[$penalty->penalti_type] ?? 'bg-slate-50 text-slate-700 border-slate-200/60';
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $settlementColor }} border text-[10px] font-bold uppercase tracking-wider whitespace-nowrap shadow-sm">
                                        {{ $penalty->settlement_method_label }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="font-bold text-on-surface text-sm">Rp {{ number_format($penalty->amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    @if($penalty->status === 'belum_dibayar')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200/60 text-[10px] font-bold uppercase tracking-wider whitespace-nowrap shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                            Belum Dibayar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60 text-[10px] font-bold uppercase tracking-wider whitespace-nowrap shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Lunas
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <button
                                            type="button"
                                            class="inline-flex items-center justify-center w-10 h-10 rounded-2xl border border-outline-variant/20 bg-slate-50 text-on-surface-variant hover:bg-surface-container transition-all"
                                            title="Lihat keterangan"
                                            aria-label="Lihat keterangan denda"
                                            data-penalty-info
                                            data-member="{{ $penalty->user->name ?? '-' }}"
                                            data-book="{{ $penalty->loan?->collection?->display_title ?? '-' }}"
                                            data-type="{{ ucfirst($penalty->type) }}"
                                            data-settlement="{{ $penalty->settlement_method_label }}"
                                            data-amount="Rp {{ number_format($penalty->amount, 0, ',', '.') }}"
                                            data-description="{{ $penalty->description ?: 'Tidak ada keterangan tambahan.' }}"
                                        >
                                            <span class="material-symbols-outlined text-[18px]">info</span>
                                        </button>

                                        @if($penalty->status === 'belum_dibayar')
                                            <form method="POST" action="{{ route('petugas.penalties.mark-paid', $penalty->penalti_id) }}" onsubmit="return confirm('Tandai denda ini sebagai lunas?')">
                                                @csrf
                                                @method('PATCH')
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-emerald-500 text-white hover:bg-emerald-600 transition-all shadow-sm shadow-emerald-200"
                                                    title="Tandai lunas"
                                                    aria-label="Tandai denda sebagai lunas"
                                                >
                                                    <span class="material-symbols-outlined text-[18px]">check</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-slate-100 text-outline" title="Sudah lunas">
                                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-12 text-center text-outline font-medium">Belum ada data denda atau sanksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($penalties->hasPages())
                <div class="p-6 border-t border-outline-variant/10 bg-slate-50/50">{{ $penalties->links() }}</div>
            @endif
        </section>
    </main>

    <div id="penalty-info-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-slate-950/45" data-close-penalty-info></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-xl rounded-3xl bg-white border border-outline-variant/10 shadow-2xl overflow-hidden">
                <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-outline-variant/10">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Informasi Denda</p>
                        <h2 class="mt-1 font-headline-md text-on-surface">Detail Keterangan</h2>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-slate-100 text-on-surface-variant hover:bg-slate-200 transition-all"
                        aria-label="Tutup detail denda"
                        data-close-penalty-info
                    >
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>

                <div class="px-6 py-5 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Anggota</p>
                            <p id="penalty-info-member" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Buku</p>
                            <p id="penalty-info-book" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Jenis</p>
                            <p id="penalty-info-type" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Penyelesaian</p>
                            <p id="penalty-info-settlement" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3 sm:col-span-2">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Nominal</p>
                            <p id="penalty-info-amount" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-outline-variant/10 bg-slate-50 px-5 py-4">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Keterangan</p>

                        <div class="mt-3 space-y-3">
                            <div id="penalty-info-rule-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Aturan</p>
                                <p id="penalty-info-rule" class="mt-1 text-sm leading-6 text-on-surface-variant">-</p>
                            </div>

                            <div id="penalty-info-failed-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Checklist Bermasalah</p>
                                <div id="penalty-info-failed-list" class="mt-2 flex flex-wrap gap-2"></div>
                            </div>

                            <div id="penalty-info-inspection-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Catatan Inspeksi</p>
                                <p id="penalty-info-inspection" class="mt-1 text-sm leading-6 text-on-surface-variant">-</p>
                            </div>

                            <div id="penalty-info-rule-note-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Catatan Sanksi</p>
                                <p id="penalty-info-rule-note" class="mt-1 text-sm leading-6 text-on-surface-variant">-</p>
                            </div>

                            <div id="penalty-info-extra-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Informasi Lain</p>
                                <div id="penalty-info-extra-list" class="mt-2 space-y-2"></div>
                            </div>

                            <div id="penalty-info-plain-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Keterangan Umum</p>
                                <p id="penalty-info-plain" class="mt-1 text-sm leading-6 text-on-surface-variant whitespace-pre-line">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const penaltyInfoModal = document.getElementById('penalty-info-modal');
        const penaltyInfoTriggers = document.querySelectorAll('[data-penalty-info]');
        const penaltyInfoClosers = document.querySelectorAll('[data-close-penalty-info]');

        const penaltyInfoFields = {
            member: document.getElementById('penalty-info-member'),
            book: document.getElementById('penalty-info-book'),
            type: document.getElementById('penalty-info-type'),
            settlement: document.getElementById('penalty-info-settlement'),
            amount: document.getElementById('penalty-info-amount'),
            ruleWrap: document.getElementById('penalty-info-rule-wrap'),
            rule: document.getElementById('penalty-info-rule'),
            failedWrap: document.getElementById('penalty-info-failed-wrap'),
            failedList: document.getElementById('penalty-info-failed-list'),
            ruleNoteWrap: document.getElementById('penalty-info-rule-note-wrap'),
            ruleNote: document.getElementById('penalty-info-rule-note'),
            inspectionWrap: document.getElementById('penalty-info-inspection-wrap'),
            inspection: document.getElementById('penalty-info-inspection'),
            extraWrap: document.getElementById('penalty-info-extra-wrap'),
            extraList: document.getElementById('penalty-info-extra-list'),
            plainWrap: document.getElementById('penalty-info-plain-wrap'),
            plain: document.getElementById('penalty-info-plain'),
        };

        function setSectionVisibility(element, visible) {
            element.classList.toggle('hidden', !visible);
        }

        function normalizeLabel(label) {
            return label.trim().toLowerCase();
        }

        function parsePenaltyDescription(description) {
            const rawText = (description || '').trim();

            if (!rawText) {
                return { plain: 'Tidak ada keterangan tambahan.', extras: [] };
            }

            const structured = {
                rule: '',
                failedChecklist: [],
                ruleNote: '',
                inspectionNote: '',
                followUp: '',
                extras: [],
                plain: '',
            };

            const segments = rawText.split(/\s+\|\s+/).map((segment) => segment.trim()).filter(Boolean);

            if (!segments.some((segment) => segment.includes(':'))) {
                structured.plain = rawText;
                return structured;
            }

            segments.forEach((segment) => {
                const separatorIndex = segment.indexOf(':');

                if (separatorIndex === -1) {
                    structured.extras.push({ label: 'Informasi', value: segment });
                    return;
                }

                const label = normalizeLabel(segment.slice(0, separatorIndex));
                const value = segment.slice(separatorIndex + 1).trim();

                if (!value) {
                    return;
                }

                if (label === 'aturan') {
                    structured.rule = value;
                    return;
                }

                if (label === 'checklist bermasalah') {
                    structured.failedChecklist = value.split(',').map((item) => item.trim()).filter(Boolean);
                    return;
                }

                if (label === 'catatan aturan') {
                    structured.ruleNote = value;
                    return;
                }

                if (label === 'catatan inspeksi') {
                    structured.inspectionNote = value;
                    return;
                }

                if (label === 'tindak lanjut') {
                    structured.followUp = value;
                    return;
                }

                structured.extras.push({
                    label: segment.slice(0, separatorIndex).trim(),
                    value,
                });
            });

            const hasStructuredContent = structured.rule
                || structured.failedChecklist.length
                || structured.ruleNote
                || structured.inspectionNote
                || structured.followUp
                || structured.extras.length;

            if (!hasStructuredContent) {
                structured.plain = rawText;
            }

            return structured;
        }

        function renderPenaltyDescription(description) {
            const parsed = parsePenaltyDescription(description);

            penaltyInfoFields.rule.textContent = parsed.rule || '-';
            setSectionVisibility(penaltyInfoFields.ruleWrap, Boolean(parsed.rule));

            penaltyInfoFields.failedList.innerHTML = '';
            if (parsed.failedChecklist.length) {
                parsed.failedChecklist.forEach((item) => {
                    const chip = document.createElement('span');
                    chip.className = 'inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-semibold';
                    chip.textContent = item;
                    penaltyInfoFields.failedList.appendChild(chip);
                });
            }
            setSectionVisibility(penaltyInfoFields.failedWrap, parsed.failedChecklist.length > 0);

            penaltyInfoFields.ruleNote.textContent = parsed.ruleNote || '-';
            setSectionVisibility(penaltyInfoFields.ruleNoteWrap, Boolean(parsed.ruleNote));

            penaltyInfoFields.inspection.textContent = parsed.inspectionNote || '-';
            setSectionVisibility(penaltyInfoFields.inspectionWrap, Boolean(parsed.inspectionNote));

            penaltyInfoFields.extraList.innerHTML = '';
            if (parsed.extras.length) {
                parsed.extras.forEach((item) => {
                    const row = document.createElement('div');
                    row.className = 'rounded-2xl bg-white/70 px-4 py-3 border border-outline-variant/10';

                    const title = document.createElement('p');
                    title.className = 'text-[11px] font-bold uppercase tracking-widest text-outline';
                    title.textContent = item.label;

                    const content = document.createElement('p');
                    content.className = 'mt-1 text-sm leading-6 text-on-surface-variant';
                    content.textContent = item.value;

                    row.appendChild(title);
                    row.appendChild(content);
                    penaltyInfoFields.extraList.appendChild(row);
                });
            }
            setSectionVisibility(penaltyInfoFields.extraWrap, parsed.extras.length > 0);

            penaltyInfoFields.plain.textContent = parsed.plain || 'Tidak ada keterangan tambahan.';
            setSectionVisibility(
                penaltyInfoFields.plainWrap,
                Boolean(parsed.plain) || (
                    !parsed.rule
                    && !parsed.failedChecklist.length
                    && !parsed.ruleNote
                    && !parsed.inspectionNote
                    && !parsed.followUp
                    && !parsed.extras.length
                )
            );
        }

        function openPenaltyInfo(button) {
            penaltyInfoFields.member.textContent = button.dataset.member || '-';
            penaltyInfoFields.book.textContent = button.dataset.book || '-';
            penaltyInfoFields.type.textContent = button.dataset.type || '-';
            penaltyInfoFields.settlement.textContent = button.dataset.settlement || '-';
            penaltyInfoFields.amount.textContent = button.dataset.amount || '-';
            renderPenaltyDescription(button.dataset.description || '');
            penaltyInfoModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closePenaltyInfo() {
            penaltyInfoModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        penaltyInfoTriggers.forEach((button) => {
            button.addEventListener('click', () => openPenaltyInfo(button));
        });

        penaltyInfoClosers.forEach((button) => {
            button.addEventListener('click', closePenaltyInfo);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !penaltyInfoModal.classList.contains('hidden')) {
                closePenaltyInfo();
            }
        });
    </script>
</body>
</html>
