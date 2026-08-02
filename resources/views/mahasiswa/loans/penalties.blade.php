<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Denda & Sanksi Saya - SIPUS PSDKU POLNEP</title>
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
                    "fontFamily": {
                        "headline-md": ["Outfit"],
                        "label-md": ["Inter"],
                        "display-lg": ["Outfit"],
                        "caption": ["Inter"],
                        "headline-lg": ["Outfit"],
                        "headline-lg-mobile": ["Outfit"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"]
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
    @include('mahasiswa.layouts.sidebar')

    <main class="ml-64 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Denda & Sanksi Saya',
            'subtitle' => 'Daftar rincian denda keterlambatan, kerusakan, atau sanksi kehilangan koleksi perpustakaan.'
        ])

        {{-- Widget Statistik Ringkasan Denda --}}
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
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Denda Sudah Lunas</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['paid_count'] }}</span>
                    <span class="text-xs text-outline font-semibold">denda</span>
                </div>
            </div>
        </section>

        {{-- Tampilan Desktop Tabel --}}
        <x-table :pagination="$penalties->hasPages() ? $penalties->links() : null">
            <x-slot name="headers">
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Koleksi</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Jenis Sanksi</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Penyelesaian</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Nominal</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Status</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-center text-slate-700 whitespace-nowrap">Rincian</th>
            </x-slot>

            @forelse($penalties as $penalty)
                <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group">
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 text-sm group-hover:text-teal-700 transition-colors">
                                {{ $penalty->loan?->collection?->display_title ?? 'Koleksi' }}
                            </span>
                            <span class="text-xs font-semibold text-slate-500 mt-0.5 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">book</span>
                                {{ $penalty->loan?->collection?->display_type_label ?? 'Buku' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @php
                            $typeBadge = match($penalty->type) {
                                'kehilangan' => 'bg-rose-100 text-rose-800 border-rose-300',
                                'kerusakan' => 'bg-amber-100 text-amber-800 border-amber-300',
                                default => 'bg-slate-100 text-slate-800 border-slate-300',
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border shadow-2xs {{ $typeBadge }}">
                            {{ ucfirst($penalty->type) }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-700 font-semibold whitespace-nowrap">
                        @php
                            $settlementText = match($penalty->penalti_type) {
                                'uang_tunai' => '💵 Bayar Uang Tunai',
                                'ganti_buku' => '📚 Penggantian Buku Fisik',
                                'kombinasi' => '🔄 Kombinasi (Buku & Uang)',
                                default => '-',
                            };
                        @endphp
                        {{ $settlementText }}
                    </td>
                    <td class="px-8 py-5 text-sm font-extrabold text-slate-900 whitespace-nowrap">
                        @if($penalty->amount > 0)
                            <span class="{{ $penalty->status === 'belum_dibayar' ? 'text-rose-600' : 'text-slate-800' }}">
                                Rp {{ number_format($penalty->amount, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="text-slate-400 font-semibold text-xs">Fisik (Tanpa Uang)</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($penalty->status === 'belum_dibayar')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-rose-600 mr-2 animate-pulse"></span>
                                Belum Dibayar
                            </span>
                        @else
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2"></span>
                                Lunas
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-center whitespace-nowrap">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-700 border border-slate-200 hover:bg-teal-600 hover:text-white hover:border-teal-600 transition-all shadow-xs active:scale-95"
                            title="Lihat rincian sanksi & keterangan"
                            aria-label="Lihat rincian sanksi"
                            data-penalty-info
                            data-member="{{ Auth::user()->name }}"
                            data-book="{{ $penalty->loan?->collection?->display_title ?? 'Koleksi' }}"
                            data-type="{{ ucfirst($penalty->type) }}"
                            data-settlement="{{ $penalty->settlement_method_label }}"
                            data-amount="Rp {{ number_format($penalty->amount, 0, ',', '.') }}"
                            data-description="{{ $penalty->description ?: 'Tidak ada keterangan tambahan.' }}"
                        >
                            <span class="material-symbols-outlined text-[20px]">info</span>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-8 py-14 text-center text-slate-500 font-medium">
                        <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3 border border-emerald-200">
                            <span class="material-symbols-outlined text-[36px]">verified_user</span>
                        </div>
                        <p class="text-base font-bold text-slate-800">Tidak Ada Catatan Denda</p>
                        <p class="text-xs text-slate-500 mt-1">Selamat! Anda tidak memiliki catatan denda atau sanksi perpustakaan saat ini.</p>
                    </td>
                </tr>
            @endforelse
        </x-table>

        {{-- Tampilan Mobile Card List --}}
        <div class="lg:hidden space-y-4">
            @forelse($penalties as $penalty)
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm flex flex-col gap-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-on-surface text-sm">
                                {{ $penalty->loan?->collection?->display_title ?? 'Koleksi' }}
                            </h4>
                            <p class="text-xs text-outline mt-0.5">
                                {{ $penalty->loan?->collection?->display_type_label ?? 'Buku' }}
                            </p>
                        </div>
                        @if($penalty->status === 'belum_dibayar')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wide">
                                Belum Dibayar
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wide">
                                Lunas
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-3 border-t border-outline-variant/10 text-xs">
                        <div>
                            <span class="text-[10px] text-outline uppercase block mb-0.5">Jenis Sanksi</span>
                            <span class="font-semibold text-on-surface">{{ ucfirst($penalty->type) }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-outline uppercase block mb-0.5">Nominal</span>
                            @if($penalty->amount > 0)
                                <span class="font-bold text-rose-600">Rp {{ number_format($penalty->amount, 0, ',', '.') }}</span>
                            @else
                                <span class="font-semibold text-outline">Penggantian Fisik</span>
                            @endif
                        </div>
                    </div>

                    <div class="pt-3 border-t border-outline-variant/10 flex justify-between items-center">
                        <span class="text-xs text-outline font-medium">Rincian Info:</span>
                        <button
                            type="button"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl border border-outline-variant/20 bg-slate-50 text-primary font-bold text-xs hover:bg-primary hover:text-white transition-all"
                            data-penalty-info
                            data-member="{{ Auth::user()->name }}"
                            data-book="{{ $penalty->loan?->collection?->display_title ?? 'Koleksi' }}"
                            data-type="{{ ucfirst($penalty->type) }}"
                            data-settlement="{{ $penalty->settlement_method_label }}"
                            data-amount="Rp {{ number_format($penalty->amount, 0, ',', '.') }}"
                            data-description="{{ $penalty->description ?: 'Tidak ada keterangan tambahan.' }}"
                        >
                            <span class="material-symbols-outlined text-[16px]">info</span>
                            <span>Lihat Detail</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 text-center text-outline text-sm font-medium shadow-sm">
                    <span class="material-symbols-outlined text-[36px] text-emerald-500 block mb-2">verified_user</span>
                    Selamat! Anda tidak memiliki catatan denda atau sanksi saat ini.
                </div>
            @endforelse

            @if($penalties->hasPages())
                <div class="pt-2">
                    {{ $penalties->links() }}
                </div>
            @endif
        </div>
    </main>

    {{-- Modal Detail Info Denda --}}
    <div id="penalty-info-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-slate-950/45" data-close-penalty-info></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-xl rounded-3xl bg-white border border-outline-variant/10 shadow-2xl overflow-hidden">
                <div class="flex items-start justify-between gap-4 px-6 py-5 border-b border-outline-variant/10">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Informasi Denda Saya</p>
                        <h2 class="mt-1 font-headline-md text-on-surface">Rincian & Catatan Sanksi</h2>
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
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Nama Anggota</p>
                            <p id="penalty-info-member" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Judul Koleksi</p>
                            <p id="penalty-info-book" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Jenis Sanksi</p>
                            <p id="penalty-info-type" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Metode Penyelesaian</p>
                            <p id="penalty-info-settlement" class="mt-1 font-semibold text-on-surface">-</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 px-4 py-3 sm:col-span-2">
                            <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Nominal Denda</p>
                            <p id="penalty-info-amount" class="mt-1 font-bold text-rose-600 text-base">-</p>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-outline-variant/10 bg-slate-50 px-5 py-4">
                        <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Keterangan Tambahan</p>

                        <div class="mt-3 space-y-3">
                            <div id="penalty-info-rule-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Aturan Sanksi</p>
                                <p id="penalty-info-rule" class="mt-1 text-sm leading-6 text-on-surface-variant">-</p>
                            </div>

                            <div id="penalty-info-failed-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Checklist Kerusakan Fisik</p>
                                <div id="penalty-info-failed-list" class="mt-2 flex flex-wrap gap-2"></div>
                            </div>

                            <div id="penalty-info-inspection-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Catatan Inspeksi Petugas</p>
                                <p id="penalty-info-inspection" class="mt-1 text-sm leading-6 text-on-surface-variant">-</p>
                            </div>

                            <div id="penalty-info-rule-note-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Catatan Petugas</p>
                                <p id="penalty-info-rule-note" class="mt-1 text-sm leading-6 text-on-surface-variant">-</p>
                            </div>

                            <div id="penalty-info-extra-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Informasi Tambahan</p>
                                <div id="penalty-info-extra-list" class="mt-2 space-y-2"></div>
                            </div>

                            <div id="penalty-info-plain-wrap" class="hidden">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-outline">Catatan Keterangan</p>
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
