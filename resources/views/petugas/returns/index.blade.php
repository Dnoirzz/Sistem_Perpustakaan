<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Transaksi Pengembalian - SIPUS PSDKU POLNEP</title>
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

    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Transaksi Pengembalian Buku</h1>
                <p class="text-sm text-outline">Proses pengembalian buku yang sedang dipinjam oleh anggota perpustakaan.</p>
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

        @if($errors->any())
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-900 text-sm shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold">
                    <span class="material-symbols-outlined text-amber-700 text-[18px]">warning</span>
                    Form pengembalian belum lengkap:
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Statistik --}}
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined">swap_horiz</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Peminjaman Aktif</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['active_loans'] }}</span>
                    <span class="text-xs text-outline font-semibold">transaksi</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 flex items-center justify-center text-white shadow-lg shadow-rose-200">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Pinjaman Terlambat</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold {{ $stats['overdue_loans'] > 0 ? 'text-rose-600' : 'text-on-surface' }}">{{ $stats['overdue_loans'] }}</span>
                    <span class="text-xs text-outline font-semibold">transaksi</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-white shadow-lg shadow-sky-200">
                        <span class="material-symbols-outlined">assignment_turned_in</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Dikembalikan Hari Ini</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['returned_today'] }}</span>
                    <span class="text-xs text-outline font-semibold">transaksi</span>
                </div>
            </div>
        </section>

        {{-- Filter & Search --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <section class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm flex-1">
                <form action="{{ route('petugas.returns.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                        <input type="text" name="search" placeholder="Cari nama, NIM, NIP, atau judul buku" class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold" value="{{ request('search') }}"/>
                    </div>
                    <div>
                        <select name="status" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                            <option value="">Semua Aktif</option>
                            <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-95 transition-all">
                            Terapkan Filter
                        </button>
                        @if(request()->filled('search') || request()->filled('status'))
                            <a href="{{ route('petugas.returns.index') }}" class="py-3 px-6 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-xs transition-all text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </section>
        </div>

        {{-- Tabel --}}
        <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Anggota</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Buku</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Tgl Pinjam</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Batas Waktu</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest">Status</th>
                            <th class="px-8 py-4 font-label-md text-outline-variant text-xs uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($loans as $loan)
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-primary text-xs uppercase border border-outline-variant/10 shadow-sm">
                                            {{ substr($loan->user->name, 0, 2) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-on-surface text-sm">{{ $loan->user->name }}</span>
                                            <span class="text-[10px] text-outline font-bold tracking-wider uppercase">
                                                @if($loan->user->role?->role_name === 'mahasiswa')
                                                    Mahasiswa • NIM {{ $loan->user->mahasiswa->nim ?? '-' }}
                                                @else
                                                    Dosen • NIP {{ $loan->user->dosen->nip ?? '-' }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface text-sm">{{ $loan->collection?->display_title ?? 'Buku tidak ditemukan' }}</span>
                                        <span class="text-[10px] text-outline font-semibold">
                                            {{ $loan->collection?->book?->author ?? $loan->collection?->display_type_label ?? 'Koleksi' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">
                                    {{ \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-8 py-5 text-sm {{ $loan->status === 'terlambat' ? 'text-rose-600 font-semibold' : 'text-on-surface-variant' }}">
                                    {{ \Carbon\Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y') }}
                                    @if($loan->status === 'terlambat')
                                        <div class="text-[10px] text-rose-500 font-bold mt-0.5">
                                            {{ \Carbon\Carbon::parse($loan->bts_waktu)->diffInDays(today()) }} hari terlambat
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-5">
                                    @if($loan->status === 'terlambat')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5 animate-pulse"></span>
                                            Terlambat
                                        </span>
                                    @elseif($loan->status === 'dikembalikan')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-sky-50 text-sky-600 text-[10px] font-bold uppercase tracking-wide">
                                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500 mr-1.5"></span>
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if(in_array($loan->status, ['dipinjam', 'terlambat']))
                                        <button
                                            type="button"
                                            data-return-trigger="true"
                                            data-loan-id="{{ $loan->loan_id }}"
                                            data-member-name="{{ $loan->user->name }}"
                                            data-book-title="{{ $loan->collection?->display_title ?? 'Buku' }}"
                                            data-status="{{ $loan->status }}"
                                            onclick="openReturnModalFromButton(this)"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-emerald-500 text-white font-bold text-xs hover:bg-emerald-600 transition-all shadow-sm shadow-emerald-200"
                                        >
                                            <span class="material-symbols-outlined text-[16px]">assignment_turned_in</span>
                                            Kembalikan
                                        </button>
                                    @else
                                        <span class="text-xs text-outline font-medium">
                                            {{ $loan->tgl_kembali ? \Carbon\Carbon::parse($loan->tgl_kembali)->translatedFormat('d M Y') : '-' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center text-outline font-medium">
                                    @if(request()->filled('search') || request()->filled('status'))
                                        Tidak ada transaksi yang cocok dengan filter pencarian.
                                    @else
                                        Tidak ada peminjaman aktif yang perlu diproses pengembalian.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($loans->hasPages())
                <div class="p-6 border-t border-outline-variant/10 bg-slate-50/50">
                    {{ $loans->links() }}
                </div>
            @endif
        </section>
    </main>

    {{-- Modal Konfirmasi Pengembalian --}}
    <div id="return-modal" class="fixed inset-0 z-[999] hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeReturnModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-8 relative z-10 transform transition-all">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-emerald-600 text-[28px]">assignment_turned_in</span>
                    </div>
                    <div>
                        <h3 class="font-headline-md text-on-surface text-lg">Konfirmasi Pengembalian</h3>
                        <p class="text-xs text-outline">Proses ini tidak dapat dibatalkan</p>
                    </div>
                </div>

                <div class="bg-surface-container-low rounded-2xl p-4 mb-6 space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-outline font-semibold">Anggota</span>
                        <span id="modal-member-name" class="text-sm font-bold text-on-surface"></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-outline font-semibold">Buku</span>
                        <span id="modal-book-title" class="text-sm font-bold text-on-surface text-right max-w-[200px] truncate"></span>
                    </div>
                </div>

                <div id="modal-overdue-warning" class="hidden mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                    <div class="flex items-center gap-2 text-amber-700 text-xs font-bold">
                        <span class="material-symbols-outlined text-[16px]">warning</span>
                        Peminjaman ini terlambat. Denda keterlambatan akan otomatis dicatat.
                    </div>
                </div>

                <form id="return-form" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" id="return-loan-id" name="return_loan_id" value="{{ old('return_loan_id') }}">

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-on-surface">Checklist Kondisi Fisik</h4>
                                <p class="text-xs text-outline">Biarkan tetap tercentang jika kondisi memenuhi kriteria. Hapus centang jika ditemukan masalah.</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-[10px] font-bold uppercase tracking-wide">
                                {{ $checklistItems->count() }} poin inspeksi
                            </span>
                        </div>

                        @if($checklistItems->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($checklistItems as $item)
                                    <label class="flex items-start gap-3 p-4 rounded-2xl border border-outline-variant/20 bg-surface-container-low {{ $loop->last && $checklistItems->count() % 2 === 1 ? 'md:col-span-2' : '' }}">
                                        <input type="hidden" name="condition_checks[{{ $item->return_checklist_id }}]" value="0">
                                        <input type="checkbox" name="condition_checks[{{ $item->return_checklist_id }}]" value="1" data-condition-checkbox class="mt-1 rounded border-outline-variant/50 text-primary focus:ring-primary" {{ old("condition_checks.{$item->return_checklist_id}", '1') ? 'checked' : '' }}>
                                        <span>
                                            <span class="block text-sm font-bold text-on-surface">{{ $item->item_name }}</span>
                                            <span class="block text-xs text-outline">{{ $item->description ?: 'Tidak ada deskripsi tambahan.' }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm">
                                Checklist aktif belum tersedia. Atur terlebih dahulu di menu
                                <a href="{{ route('petugas.return-settings.index') }}" class="font-bold text-primary hover:underline">Pengaturan Return</a>.
                            </div>
                        @endif
                    </div>

                    <div id="condition-issue-alert" class="hidden p-4 bg-rose-50 border border-rose-200 rounded-2xl">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-rose-600 text-[18px]">report</span>
                            <div>
                                <p class="text-sm font-bold text-rose-800">Ada kondisi fisik yang tidak memenuhi kriteria.</p>
                                <p class="text-xs text-rose-700 mt-1">Lengkapi catatan inspeksi dan detail sanksi sebelum pengembalian diproses.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="return_condition_notes" class="block text-sm font-bold text-on-surface mb-2">Catatan hasil inspeksi</label>
                        <textarea id="return_condition_notes" name="return_condition_notes" rows="3" placeholder="Catat kondisi fisik buku, misalnya halaman 12 sobek atau cover terlepas..." class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm resize-none">{{ old('return_condition_notes') }}</textarea>
                    </div>

                    <div id="penalty-fields" class="hidden space-y-4 border border-outline-variant/20 rounded-3xl p-5 bg-slate-50/80">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-on-surface">Sanksi Tambahan</h4>
                                <p class="text-xs text-outline">Isi sanksi berdasarkan hasil pemeriksaan petugas.</p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-[10px] font-bold uppercase tracking-wide">
                                Wajib diisi
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="penalty_type" class="block text-xs font-bold text-on-surface-variant mb-2">Jenis sanksi</label>
                                <select id="penalty_type" name="penalty_type" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                                    <option value="">Pilih jenis sanksi...</option>
                                    @foreach($penaltyRules as $code => $rule)
                                        <option value="{{ $code }}" {{ old('penalty_type') === $code ? 'selected' : '' }}>{{ $rule->rule_name }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-[11px] text-outline">
                                    Opsi ini mengikuti aturan aktif pada
                                    <a href="{{ route('petugas.return-settings.index') }}" class="text-primary font-bold hover:underline">Pengaturan Return</a>.
                                </p>
                            </div>

                            <div>
                                <label for="settlement_method" class="block text-xs font-bold text-on-surface-variant mb-2">Metode penyelesaian</label>
                                <select id="settlement_method" name="settlement_method" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                                    <option value="">Pilih metode...</option>
                                    <option value="uang_tunai" {{ old('settlement_method') === 'uang_tunai' ? 'selected' : '' }}>Denda uang tunai</option>
                                    <option value="ganti_buku" {{ old('settlement_method') === 'ganti_buku' ? 'selected' : '' }}>Penggantian buku</option>
                                    <option value="kombinasi" {{ old('settlement_method') === 'kombinasi' ? 'selected' : '' }}>Kombinasi buku + uang</option>
                                </select>
                            </div>
                        </div>

                        <div id="penalty-amount-wrapper">
                            <label for="penalty_amount" id="penalty-amount-label" class="block text-xs font-bold text-on-surface-variant mb-2">Nominal denda (Rp)</label>
                            <input type="number" id="penalty_amount" name="penalty_amount" min="0" step="500" value="{{ old('penalty_amount') }}" placeholder="Contoh: 50000" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm">
                            <p id="penalty-amount-hint" class="text-[11px] text-outline mt-2">Isi nominal jika sanksi melibatkan pembayaran uang tunai.</p>
                        </div>

                        <div>
                            <label for="penalty_description" class="block text-xs font-bold text-on-surface-variant mb-2">Keterangan sanksi</label>
                            <textarea id="penalty_description" name="penalty_description" rows="3" placeholder="Contoh: wajib mengganti buku edisi yang sama paling lambat 7 hari atau membayar sesuai harga buku." class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm resize-none">{{ old('penalty_description') }}</textarea>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeReturnModal()" class="flex-1 py-3 px-6 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-sm transition-all">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-emerald-500 text-white font-bold text-sm hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200">
                            Simpan & Proses Pengembalian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        $penaltyRuleMap = $penaltyRules->mapWithKeys(function ($rule, $code) {
            return [
                $code => [
                    'rule_name' => $rule->rule_name,
                    'default_settlement_method' => $rule->default_settlement_method,
                    'default_amount' => (float) $rule->default_amount,
                    'description' => $rule->description,
                ],
            ];
        })->toArray();
    @endphp

    <script>
        const penaltyRuleMap = @json($penaltyRuleMap);

        function resetReturnFormFields() {
            document.getElementById('return-loan-id').value = '';
            document.getElementById('return_condition_notes').value = '';
            document.getElementById('penalty_type').value = '';
            document.getElementById('settlement_method').value = '';
            document.getElementById('settlement_method').dataset.autoFill = 'true';
            document.getElementById('penalty_amount').value = '';
            document.getElementById('penalty_amount').dataset.autoFill = 'true';
            document.getElementById('penalty_description').value = '';
            document.getElementById('penalty_description').dataset.autoFill = 'true';

            document.querySelectorAll('[data-condition-checkbox]').forEach((checkbox) => {
                checkbox.checked = true;
            });
        }

        function syncPenaltyDefaults() {
            const type = document.getElementById('penalty_type').value;
            const rule = penaltyRuleMap[type];

            if (!rule) {
                return;
            }

            const settlementMethod = document.getElementById('settlement_method');
            const amountInput = document.getElementById('penalty_amount');
            const descriptionInput = document.getElementById('penalty_description');

            if (!settlementMethod.value || settlementMethod.dataset.autoFill === 'true') {
                settlementMethod.value = rule.default_settlement_method;
                settlementMethod.dataset.autoFill = 'true';
            }

            if (!amountInput.value || amountInput.dataset.autoFill === 'true') {
                amountInput.value = Number(rule.default_amount) > 0 ? Number(rule.default_amount) : '';
                amountInput.dataset.autoFill = 'true';
            }

            if (!descriptionInput.value || descriptionInput.dataset.autoFill === 'true') {
                descriptionInput.value = rule.description ?? '';
                descriptionInput.dataset.autoFill = 'true';
            }
        }

        function syncPenaltyMethodState() {
            const settlementMethod = document.getElementById('settlement_method').value;
            const amountWrapper = document.getElementById('penalty-amount-wrapper');
            const amountInput = document.getElementById('penalty_amount');
            const amountHint = document.getElementById('penalty-amount-hint');
            const requiresAmount = settlementMethod === 'uang_tunai' || settlementMethod === 'kombinasi';

            amountWrapper.classList.toggle('hidden', settlementMethod === 'ganti_buku');
            amountInput.required = requiresAmount;

            if (settlementMethod === 'ganti_buku') {
                amountInput.value = '';
                amountHint.textContent = 'Nominal tidak wajib untuk sanksi penggantian buku.';
            } else if (settlementMethod === 'kombinasi') {
                amountHint.textContent = 'Isi nominal uang tunai yang tetap harus dibayarkan selain penggantian buku.';
            } else {
                amountHint.textContent = 'Isi nominal jika sanksi melibatkan pembayaran uang tunai.';
            }
        }

        function syncInspectionState() {
            const hasIssue = Array.from(document.querySelectorAll('[data-condition-checkbox]')).some((checkbox) => !checkbox.checked);
            const issueAlert = document.getElementById('condition-issue-alert');
            const penaltyFields = document.getElementById('penalty-fields');
            const notesField = document.getElementById('return_condition_notes');
            const penaltyType = document.getElementById('penalty_type');
            const settlementMethod = document.getElementById('settlement_method');
            const penaltyDescription = document.getElementById('penalty_description');

            issueAlert.classList.toggle('hidden', !hasIssue);
            penaltyFields.classList.toggle('hidden', !hasIssue);
            notesField.required = hasIssue;
            penaltyType.required = hasIssue;
            settlementMethod.required = hasIssue;
            penaltyDescription.required = hasIssue;

            if (!hasIssue) {
                notesField.value = '';
                penaltyType.value = '';
                settlementMethod.value = '';
                document.getElementById('penalty_amount').value = '';
                penaltyDescription.value = '';
            }

            syncPenaltyDefaults();
            syncPenaltyMethodState();
        }

        function openReturnModalFromButton(button, preserveState = false) {
            openReturnModal({
                loanId: button.dataset.loanId,
                memberName: button.dataset.memberName,
                bookTitle: button.dataset.bookTitle,
                status: button.dataset.status,
            }, preserveState);
        }

        function openReturnModal(data, preserveState = false) {
            if (!preserveState) {
                resetReturnFormFields();
            }

            document.getElementById('modal-member-name').textContent = data.memberName;
            document.getElementById('modal-book-title').textContent = data.bookTitle;
            document.getElementById('return-form').action = '/petugas/returns/' + data.loanId + '/process';
            document.getElementById('return-loan-id').value = data.loanId;

            const warningEl = document.getElementById('modal-overdue-warning');
            warningEl.classList.toggle('hidden', data.status !== 'terlambat');

            syncInspectionState();
            document.getElementById('return-modal').classList.remove('hidden');
        }

        function closeReturnModal() {
            document.getElementById('return-modal').classList.add('hidden');
        }

        document.querySelectorAll('[data-condition-checkbox]').forEach((checkbox) => {
            checkbox.addEventListener('change', syncInspectionState);
        });

        document.getElementById('penalty_type').addEventListener('change', function () {
            document.getElementById('settlement_method').dataset.autoFill = 'true';
            document.getElementById('penalty_amount').dataset.autoFill = 'true';
            document.getElementById('penalty_description').dataset.autoFill = 'true';
            syncPenaltyDefaults();
            syncPenaltyMethodState();
        });
        document.getElementById('settlement_method').addEventListener('change', function () {
            this.dataset.autoFill = 'false';
            syncPenaltyMethodState();
        });
        document.getElementById('penalty_amount').addEventListener('input', function () {
            this.dataset.autoFill = 'false';
        });
        document.getElementById('penalty_description').addEventListener('input', function () {
            this.dataset.autoFill = 'false';
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeReturnModal();
        });

        document.addEventListener('DOMContentLoaded', function () {
            syncPenaltyDefaults();
            syncInspectionState();

            const reopenLoanId = @json(old('return_loan_id'));
            if (!reopenLoanId) {
                return;
            }

            const triggerButton = document.querySelector('[data-return-trigger="true"][data-loan-id="' + reopenLoanId + '"]');
            if (triggerButton) {
                openReturnModalFromButton(triggerButton, true);
            }
        });
    </script>
</body>
</html>
