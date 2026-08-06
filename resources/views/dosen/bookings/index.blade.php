<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Booking Saya - SIPUS PSDKU POLNEP</title>
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
<body class="font-body-md text-body-md antialiased min-h-screen flex">
    @include('dosen.layouts.sidebar')

    <main class="ml-64 flex-1 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Pemesanan Buku (Booking Saya)',
            'subtitle' => 'Pantau status persetujuan pemesanan buku Anda sebelum mengambilnya di perpustakaan.'
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

        @if($errors->any())
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-900 text-sm shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold">
                    <span class="material-symbols-outlined text-amber-700 text-[18px]">warning</span>
                    Pembatalan booking belum lengkap:
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tampilan Desktop Tabel --}}
        <x-table :pagination="$bookings->hasPages() ? $bookings->links() : null">
            <x-slot name="headers">
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Buku</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Tanggal Booking</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Status</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Keterangan</th>
                <th class="px-8 py-4 font-bold text-xs uppercase tracking-wider text-center text-slate-700 whitespace-nowrap">Aksi</th>
            </x-slot>

            @forelse($bookings as $booking)
                <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group" data-booking-id="{{ $booking->booking_id }}" data-book-title="{{ $booking->collection?->display_title ?? 'Buku' }}" data-booking-status="{{ $booking->status }}">
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 text-sm group-hover:text-teal-700 transition-colors">{{ $booking->collection?->display_title ?? 'Buku tidak ditemukan' }}</span>
                            <span class="text-xs font-semibold text-slate-500 mt-0.5">
                                {{ $booking->collection?->book?->author ?? 'Penulis' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-700 font-medium whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($booking->tgl_booking)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($booking->status === 'pending')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-amber-100 text-amber-800 border border-amber-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-amber-600 mr-2 animate-pulse"></span>
                                Menunggu Persetujuan
                            </span>
                        @elseif($booking->status === 'disetujui')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2"></span>
                                Disetujui
                            </span>
                        @elseif($booking->status === 'dibatalkan')
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                <span class="w-2 h-2 rounded-full bg-rose-600 mr-2"></span>
                                Ditolak
                            </span>
                        @else
                            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-slate-100 text-slate-800 border border-slate-200 text-xs font-extrabold tracking-wide shadow-2xs">
                                {{ $booking->status }}
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-xs text-slate-700 font-medium">
                        @if($booking->note)
                            <span class="text-teal-700 font-bold block mb-1">Catatan:</span>
                            {{ $booking->note }}
                        @else
                            @if($booking->status === 'pending')
                                Permintaan Anda sedang ditinjau oleh staf petugas perpustakaan.
                            @elseif($booking->status === 'disetujui')
                                Buku siap diambil di meja sirkulasi perpustakaan.
                            @elseif($booking->status === 'dibatalkan')
                                Booking ditolak. Silakan hubungi petugas untuk informasi lebih lanjut.
                            @else
                                -
                            @endif
                        @endif
                    </td>
                    <td class="px-8 py-5 text-center whitespace-nowrap">
                        @if(in_array($booking->status, ['pending', 'disetujui'], true))
                            <button type="button" onclick="openCancelModal({{ $booking->booking_id }}, '{{ addslashes($booking->collection?->display_title ?? 'Buku') }}', '{{ $booking->status }}')" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-500 text-white font-bold text-xs hover:bg-rose-600 transition-all shadow-xs active:scale-95 shadow-rose-200">
                                <span class="material-symbols-outlined text-[18px]">cancel</span>
                                Batalkan
                            </button>
                        @else
                            <span class="text-xs text-slate-400 font-medium">Tidak ada aksi</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-8 py-14 text-center text-slate-500 font-medium">
                        Anda belum pernah melakukan booking buku online.
                    </td>
                </tr>
            @endforelse
        </x-table>

        {{-- Tampilan Mobile Card List --}}
        <div class="lg:hidden space-y-4">
            @forelse($bookings as $booking)
                <div class="bg-white p-6 rounded-3xl border border-outline-variant/100 shadow-sm flex flex-col gap-4">
                    <!-- Judul Buku & Penulis -->
                    <div>
                        <h4 class="font-bold text-on-surface text-sm">{{ $booking->collection?->display_title ?? 'Buku tidak ditemukan' }}</h4>
                        <p class="text-xs text-outline mt-0.5">{{ $booking->collection?->book?->author ?? 'Penulis' }}</p>
                    </div>

                    <!-- Info Tanggal -->
                    <div class="pt-4 border-t border-outline-variant/100">
                        <span class="text-[10px] text-outline uppercase tracking-wider block mb-1">Tanggal Booking</span>
                        <span class="text-xs font-semibold text-on-surface">
                            {{ \Carbon\Carbon::parse($booking->tgl_booking)->translatedFormat('d M Y') }}
                        </span>
                    </div>

                    <!-- Keterangan -->
                    <div class="pt-4 border-t border-outline-variant/100 flex flex-col gap-1">
                        <span class="text-[10px] text-outline uppercase tracking-wider block">Keterangan</span>
                        <span class="text-xs font-medium text-on-surface-variant">
                            @if($booking->note)
                                <span class="text-primary font-semibold block mb-1">Catatan:</span>
                                {{ $booking->note }}
                            @else
                                @if($booking->status === 'pending')
                                    Permintaan Anda sedang ditinjau oleh staf petugas perpustakaan.
                                @elseif($booking->status === 'disetujui')
                                    Buku siap diambil di meja sirkulasi perpustakaan.
                                @elseif($booking->status === 'dibatalkan')
                                    Booking ditolak. Silakan hubungi petugas untuk informasi lebih lanjut.
                                @else
                                    -
                                @endif
                            @endif
                        </span>
                    </div>

                    <!-- Status & Aksi -->
                    <div class="flex justify-between items-center pt-4 border-t border-outline-variant/100">
                        <div>
                            @if($booking->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                    Menunggu Persetujuan
                                </span>
                            @elseif($booking->status === 'disetujui')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    Disetujui
                                </span>
                            @elseif($booking->status === 'dibatalkan')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-wide">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                    Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-50 text-slate-600 text-[10px] font-bold uppercase tracking-wide">
                                    {{ $booking->status }}
                                </span>
                            @endif
                        </div>
                        <div>
                            @if(in_array($booking->status, ['pending', 'disetujui'], true))
                                <button type="button" onclick="openCancelModal({{ $booking->booking_id }}, '{{ addslashes($booking->collection?->display_title ?? 'Buku') }}', '{{ $booking->status }}')" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-rose-500 text-white font-bold text-xs hover:bg-rose-600 transition-all shadow-sm shadow-rose-200">
                                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                                    Batalkan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-3xl border border-outline-variant/100 text-center text-outline text-sm font-medium shadow-sm">
                    Anda belum pernah melakukan booking buku online.
                </div>
            @endforelse

            @if($bookings->hasPages())
                <div class="pt-2">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </main>

    <div id="cancel-booking-modal" class="fixed inset-0 z-[999] hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeCancelModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8 relative z-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-rose-600 text-[28px]">cancel</span>
                    </div>
                    <div>
                        <h3 class="font-headline-md text-on-surface text-lg">Batalkan Booking</h3>
                        <p class="text-xs text-outline">Alasan pembatalan wajib diisi.</p>
                    </div>
                </div>

                <div class="bg-surface-container-low rounded-2xl p-4 mb-6 space-y-2">
                    <div class="flex justify-between items-center gap-3">
                        <span class="text-xs text-outline font-semibold">Buku</span>
                        <span id="cancel-book-title" class="text-sm font-bold text-on-surface text-right max-w-[240px]"></span>
                    </div>
                    <div id="cancel-approved-warning" class="hidden text-xs text-amber-700 font-semibold pt-2 border-t border-amber-200/60">
                        Booking yang sudah disetujui akan dibatalkan dan stok buku dikembalikan ke sistem.
                    </div>
                </div>

                <form id="cancel-booking-form" method="POST" class="space-y-5">
                    @csrf
                    <input type="hidden" id="cancel-booking-id" name="cancel_booking_id" value="{{ old('cancel_booking_id') }}">

                    <div>
                        <label for="cancel_reason" class="block text-sm font-bold text-on-surface mb-2">Alasan pembatalan</label>
                        <textarea id="cancel_reason" name="cancel_reason" rows="4" placeholder="Tuliskan alasan pembatalan booking Anda..." class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm resize-none" required>{{ old('cancel_reason') }}</textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeCancelModal()" class="flex-1 py-3 px-6 rounded-2xl border border-outline-variant/100 text-on-surface-variant hover:bg-slate-50 font-bold text-sm transition-all">
                            Kembali
                        </button>
                        <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-rose-500 text-white font-bold text-sm hover:bg-rose-600 transition-all shadow-lg shadow-rose-200">
                            Ya, Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCancelModal(bookingId, bookTitle, status) {
            document.getElementById('cancel-booking-id').value = bookingId;
            document.getElementById('cancel-book-title').textContent = bookTitle;
            document.getElementById('cancel-booking-form').action = '/dosen/bookings/' + bookingId + '/cancel';
            document.getElementById('cancel-approved-warning').classList.toggle('hidden', status !== 'disetujui');
            document.getElementById('cancel-booking-modal').classList.remove('hidden');
        }

        function closeCancelModal() {
            document.getElementById('cancel-booking-modal').classList.add('hidden');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCancelModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const reopenBookingId = @json(old('cancel_booking_id'));
            if (!reopenBookingId) {
                return;
            }

            const bookingRow = document.querySelector('[data-booking-id="' + reopenBookingId + '"]');
            if (bookingRow) {
                openCancelModal(
                    reopenBookingId,
                    bookingRow.dataset.bookTitle,
                    bookingRow.dataset.bookingStatus
                );
            }
        });
    </script>
</body>
</html>
