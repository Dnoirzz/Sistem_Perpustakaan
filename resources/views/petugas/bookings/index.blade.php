<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Booking Online - SIPUS PSDKU POLNEP</title>
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

    <main class="ml-64 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('petugas.layouts.header', [
            'title' => 'Kelola Booking Online',
            'subtitle' => 'Konfirmasi dan proses permintaan pemesanan buku dari anggota secara online.'
        ])

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div class="font-semibold">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center gap-3 text-rose-800 text-sm shadow-sm animate-fade-in">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <div class="font-semibold">{{ session('error') }}</div>
            </div>
        @endif

        {{-- Statistik --}}
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                        <span class="material-symbols-outlined">hourglass_empty</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Booking Pending</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['pending'] }}</span>
                    <span class="text-xs text-outline font-semibold">antrian</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Booking Disetujui</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['approved'] }}</span>
                    <span class="text-xs text-outline font-semibold">disetujui</span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-400 to-sky-600 flex items-center justify-center text-white shadow-lg shadow-sky-200">
                        <span class="material-symbols-outlined">analytics</span>
                    </div>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-sm mb-1">Total Transaksi Booking</h3>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['total'] }}</span>
                    <span class="text-xs text-outline font-semibold">booking</span>
                </div>
            </div>
        </section>

        {{-- Filter & Search --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <section class="bg-white p-6 rounded-3xl border border-outline-variant/10 shadow-sm flex-1">
                <form action="{{ route('petugas.bookings.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                        <input type="text" name="search" placeholder="Cari nama, NIM, NIP, atau judul buku" class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold" value="{{ request('search') }}"/>
                    </div>
                    <div>
                        <select name="status" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan / Ditolak</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-95 transition-all shadow-sm">
                            Terapkan Filter
                        </button>
                        @if(request()->filled('search') || request()->filled('status'))
                            <a href="{{ route('petugas.bookings.index') }}" class="py-3 px-6 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-xs transition-all text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </section>
        </div>

        {{-- Tabel --}}
        <x-table :pagination="$bookings->hasPages() ? $bookings->links() : null">
            <x-slot name="headers">
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Anggota</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Buku</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Tgl Booking</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Status</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-center text-slate-700 whitespace-nowrap">Aksi</th>
            </x-slot>

            @forelse($bookings as $booking)
                <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center font-bold text-teal-700 text-xs uppercase border border-outline-variant/10 shadow-xs">
                                {{ substr($booking->user->name, 0, 2) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 text-sm group-hover:text-teal-700 transition-colors">{{ $booking->user->name }}</span>
                                <span class="text-[10px] text-slate-500 font-bold tracking-wider uppercase">
                                    @if($booking->user->role?->role_name === 'mahasiswa')
                                        Mahasiswa • NIM {{ $booking->user->mahasiswa->nim ?? '-' }}
                                    @else
                                        Dosen • NIP {{ $booking->user->dosen->nip ?? '-' }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 text-sm">{{ $booking->collection?->display_title ?? 'Buku tidak ditemukan' }}</span>
                            <span class="text-[10px] text-slate-500 font-semibold">
                                Stok: {{ $booking->collection?->stock ?? 0 }} eks
                            </span>
                            @if($booking->note)
                                <span class="text-[10px] text-teal-800 font-bold mt-1 bg-teal-50 px-2 py-0.5 rounded-lg border border-teal-200 w-fit">
                                    Catatan: {{ $booking->note }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-700 font-medium whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($booking->tgl_booking)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($booking->status === 'pending')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-amber-600 mr-2 animate-pulse"></span>
                                Pending
                            </span>
                        @elseif($booking->status === 'disetujui')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2"></span>
                                Disetujui
                            </span>
                        @elseif($booking->status === 'dibatalkan')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-rose-600 mr-2"></span>
                                Dibatalkan
                            </span>
                        @else
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-slate-100 text-slate-800 border border-slate-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                {{ $booking->status }}
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-center whitespace-nowrap">
                        @if($booking->status === 'pending')
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openProcessModal({{ $booking->booking_id }}, 'approve', '{{ addslashes($booking->user->name) }}', '{{ addslashes($booking->collection?->display_title ?? 'Buku') }}')" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-500 text-white font-bold text-xs hover:bg-emerald-600 transition-all shadow-xs active:scale-95 shadow-emerald-200">
                                    <span class="material-symbols-outlined text-[16px]">check</span>
                                    Setujui
                                </button>
                                <button onclick="openProcessModal({{ $booking->booking_id }}, 'reject', '{{ addslashes($booking->user->name) }}', '{{ addslashes($booking->collection?->display_title ?? 'Buku') }}')" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-rose-500 text-white font-bold text-xs hover:bg-rose-600 transition-all shadow-xs active:scale-95 shadow-rose-200">
                                    <span class="material-symbols-outlined text-[16px]">close</span>
                                    Tolak
                                </button>
                            </div>
                        @elseif($booking->status === 'disetujui')
                            <div class="flex justify-center items-center gap-2">
                                <form action="{{ route('petugas.bookings.realize', $booking->booking_id) }}" method="POST" onsubmit="return confirm('Realisasikan booking ini menjadi peminjaman aktif?')" class="inline-block">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-primary text-white font-bold text-xs hover:bg-primary/90 transition-all shadow-xs active:scale-95">
                                        <span class="material-symbols-outlined text-[16px]">assignment_returned</span>
                                        Proses Pinjam
                                    </button>
                                </form>
                                <button onclick="openProcessModal({{ $booking->booking_id }}, 'cancel', '{{ addslashes($booking->user->name) }}', '{{ addslashes($booking->collection?->display_title ?? 'Buku') }}')" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-rose-500 text-white font-bold text-xs hover:bg-rose-600 transition-all shadow-xs active:scale-95 shadow-rose-200">
                                    <span class="material-symbols-outlined text-[16px]">close</span>
                                    Batalkan
                                </button>
                            </div>
                        @else
                            <span class="text-xs text-slate-400 font-medium">Selesai diproses</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-8 py-14 text-center text-slate-500 font-medium">
                        Tidak ada data booking online.
                    </td>
                </tr>
            @endforelse
        </x-table>
    </main>

    {{-- Modal Proses Booking --}}
    <div id="process-modal" class="fixed inset-0 z-[999] hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeProcessModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative z-10 transform transition-all">
                <div class="flex items-center gap-4 mb-6">
                    <div id="modal-icon-bg" class="w-14 h-14 rounded-2xl flex items-center justify-center">
                        <span id="modal-icon" class="material-symbols-outlined text-[28px]">info</span>
                    </div>
                    <div>
                        <h3 id="modal-title" class="font-headline-md text-on-surface text-lg">Proses Booking</h3>
                        <p class="text-xs text-outline">Berikan keterangan/catatan tambahan untuk anggota</p>
                    </div>
                </div>

                <form id="process-form" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="bg-surface-container-low rounded-2xl p-4 space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-outline font-semibold">Anggota</span>
                            <span id="modal-member-name" class="font-bold text-on-surface"></span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-outline font-semibold">Buku</span>
                            <span id="modal-book-title" class="font-bold text-on-surface text-right max-w-[200px] truncate"></span>
                        </div>
                    </div>

                    <div id="pickup-time-container" class="hidden">
                        <label class="block text-xs font-bold text-on-surface mb-2 uppercase tracking-wide font-medium">Batas Waktu Pengambilan (Format 24 Jam)</label>
                        <div class="flex items-center gap-2">
                            <!-- Hour Selection -->
                            <div class="relative flex-1">
                                <input type="hidden" id="modal-pickup-hour" name="pickup_hour" value="13">
                                <button type="button" id="pickup-hour-btn" onclick="toggleHourDropdown(event)" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant flex justify-between items-center bg-white shadow-sm">
                                    <span id="pickup-hour-label">13</span>
                                    <span class="material-symbols-outlined text-[18px] text-outline">expand_more</span>
                                </button>
                                <div id="pickup-hour-menu" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-outline-variant/40 rounded-2xl shadow-xl max-h-[160px] overflow-y-auto divide-y divide-outline-variant/10">
                                    @for($i = 0; $i < 24; $i++)
                                        @php $hourStr = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                        <button type="button" onclick="selectHour('{{ $hourStr }}', event)" class="w-full px-4 py-2 text-left text-xs font-semibold hover:bg-slate-50 text-on-surface-variant transition-colors">
                                            {{ $hourStr }}
                                        </button>
                                    @endfor
                                </div>
                            </div>
                            
                            <span class="font-bold text-on-surface text-lg">:</span>

                            <!-- Minute Selection -->
                            <div class="relative flex-1">
                                <input type="hidden" id="modal-pickup-minute" name="pickup_minute" value="00">
                                <button type="button" id="pickup-minute-btn" onclick="toggleMinuteDropdown(event)" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant flex justify-between items-center bg-white shadow-sm">
                                    <span id="pickup-minute-label">00</span>
                                    <span class="material-symbols-outlined text-[18px] text-outline">expand_more</span>
                                </button>
                                <div id="pickup-minute-menu" class="hidden absolute z-50 left-0 right-0 mt-2 bg-white border border-outline-variant/40 rounded-2xl shadow-xl max-h-[160px] overflow-y-auto divide-y divide-outline-variant/10">
                                    @for($i = 0; $i < 60; $i++)
                                        @php $minStr = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                        <button type="button" onclick="selectMinute('{{ $minStr }}', event)" class="w-full px-4 py-2 text-left text-xs font-semibold hover:bg-slate-50 text-on-surface-variant transition-colors">
                                            {{ $minStr }}
                                        </button>
                                    @endfor
                                </div>
                            </div>

                            <span class="text-xs font-bold text-outline">WIB</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-on-surface mb-2 uppercase tracking-wide">Keterangan / Catatan</label>
                        <textarea id="modal-note" name="note" rows="3" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant" placeholder="Tulis keterangan untuk anggota..."></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeProcessModal()" class="flex-1 py-3 px-6 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-sm transition-all">
                            Batal
                        </button>
                        <button type="submit" id="modal-submit-btn" class="flex-1 py-3 px-6 rounded-2xl text-white font-bold text-sm transition-all shadow-lg">
                            Simpan & Proses
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateApproveNote() {
            const hourVal = document.getElementById('modal-pickup-hour').value;
            const minVal = document.getElementById('modal-pickup-minute').value;
            document.getElementById('modal-note').value = 'Buku dapat diambil sebelum pukul ' + hourVal + ':' + minVal + ' WIB';
        }

        function toggleHourDropdown(e) {
            e.stopPropagation();
            document.getElementById('pickup-minute-menu').classList.add('hidden');
            document.getElementById('pickup-hour-menu').classList.toggle('hidden');
        }

        function toggleMinuteDropdown(e) {
            e.stopPropagation();
            document.getElementById('pickup-hour-menu').classList.add('hidden');
            document.getElementById('pickup-minute-menu').classList.toggle('hidden');
        }

        function selectHour(hour, e) {
            e.stopPropagation();
            document.getElementById('modal-pickup-hour').value = hour;
            document.getElementById('pickup-hour-label').textContent = hour;
            document.getElementById('pickup-hour-menu').classList.add('hidden');
            updateApproveNote();
        }

        function selectMinute(minute, e) {
            e.stopPropagation();
            document.getElementById('modal-pickup-minute').value = minute;
            document.getElementById('pickup-minute-label').textContent = minute;
            document.getElementById('pickup-minute-menu').classList.add('hidden');
            updateApproveNote();
        }

        window.addEventListener('click', function() {
            const hourMenu = document.getElementById('pickup-hour-menu');
            const minuteMenu = document.getElementById('pickup-minute-menu');
            if (hourMenu) hourMenu.classList.add('hidden');
            if (minuteMenu) minuteMenu.classList.add('hidden');
        });

        function openProcessModal(bookingId, action, memberName, bookTitle) {
            document.getElementById('modal-member-name').textContent = memberName;
            document.getElementById('modal-book-title').textContent = bookTitle;
            
            const form = document.getElementById('process-form');
            const noteTextarea = document.getElementById('modal-note');
            const iconBg = document.getElementById('modal-icon-bg');
            const icon = document.getElementById('modal-icon');
            const title = document.getElementById('modal-title');
            const submitBtn = document.getElementById('modal-submit-btn');
            const timeContainer = document.getElementById('pickup-time-container');

            if (action === 'approve') {
                form.action = '/petugas/bookings/' + bookingId + '/approve';
                title.textContent = 'Setujui Booking';
                
                timeContainer.classList.remove('hidden');
                document.getElementById('modal-pickup-hour').value = '13';
                document.getElementById('pickup-hour-label').textContent = '13';
                document.getElementById('modal-pickup-minute').value = '00';
                document.getElementById('pickup-minute-label').textContent = '00';
                updateApproveNote();
                
                iconBg.className = 'w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center';
                icon.textContent = 'check_circle';
                icon.className = 'material-symbols-outlined text-emerald-600 text-[28px]';
                
                submitBtn.textContent = 'Setujui';
                submitBtn.className = 'flex-1 py-3 px-6 rounded-2xl bg-emerald-500 text-white font-bold text-sm hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-200';
            } else if (action === 'cancel') {
                form.action = '/petugas/bookings/' + bookingId + '/reject';
                title.textContent = 'Batalkan Booking';
                
                timeContainer.classList.add('hidden');
                noteTextarea.value = 'Booking dibatalkan karena melewati batas waktu pengambilan.';
                
                iconBg.className = 'w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center';
                icon.textContent = 'cancel';
                icon.className = 'material-symbols-outlined text-rose-600 text-[28px]';
                
                submitBtn.textContent = 'Batalkan';
                submitBtn.className = 'flex-1 py-3 px-6 rounded-2xl bg-rose-500 text-white font-bold text-sm hover:bg-rose-600 transition-all shadow-lg shadow-rose-200';
            } else {
                form.action = '/petugas/bookings/' + bookingId + '/reject';
                title.textContent = 'Tolak Booking';
                
                timeContainer.classList.add('hidden');
                noteTextarea.value = 'Maaf, buku tidak tersedia saat ini.';
                
                iconBg.className = 'w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center';
                icon.textContent = 'cancel';
                icon.className = 'material-symbols-outlined text-rose-600 text-[28px]';
                
                submitBtn.textContent = 'Tolak';
                submitBtn.className = 'flex-1 py-3 px-6 rounded-2xl bg-rose-500 text-white font-bold text-sm hover:bg-rose-600 transition-all shadow-lg shadow-rose-200';
            }

            document.getElementById('process-modal').classList.remove('hidden');
        }

        function closeProcessModal() {
            document.getElementById('process-modal').classList.add('hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeProcessModal();
        });
    </script>
</body>
</html>
