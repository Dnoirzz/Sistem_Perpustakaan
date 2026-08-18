<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pemantauan Buku Rusak &amp; Inspeksi - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-background": "#131b2e",
                        "surface": "#faf8ff",
                        "outline": "#777587",
                        "outline-variant": "#c7c4d8",
                        "background": "#faf8ff",
                        "primary": "#00a5c0",
                        "surface-container": "#eaedff",
                        "on-surface": "#131b2e"
                    },
                    "borderRadius": {
                        "2xl": "1rem",
                        "3xl": "1.5rem"
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #f8faff; color: #131b2e; }
        .sidebar-active { background-color: #00a5c0; color: white; box-shadow: 0 4px 12px rgba(0, 165, 192, 0.2); }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')
    
    <main class="ml-64 p-6 sm:p-10 bg-[#f8faff] min-h-screen">
        @include('petugas.layouts.header', [
            'title' => 'Pemantauan Koleksi & Arsip Fisik Rusak',
            'subtitle' => 'Pantau koleksi buku dan arsip mahasiswa  yang bermasalah/rusak.'
        ])

        <!-- Alert Section -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3 text-emerald-800 text-sm shadow-sm font-semibold">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl flex items-center gap-3 text-rose-800 text-sm shadow-sm font-semibold">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <!-- Stat Card & Action Button Grid -->
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="bg-white p-5 rounded-3xl border border-outline-variant/100 shadow-sm flex items-center gap-4 min-w-[260px]">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl">report_problem</span>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Koleksi Rusak</span>
                    <span class="text-2xl font-black text-slate-900">{{ $stats['total_damaged'] }}</span>
                </div>
            </div>

            <button type="button" onclick="openInternalModal()" class="px-5 py-3.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2 active:scale-95 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Catat Temuan Koleksi Rusak
            </button>
        </div>

        <!-- Filter Bar -->
        <section class="mb-8 rounded-3xl border border-outline-variant/100 bg-white p-6 shadow-sm">
            <form action="{{ route('petugas.damaged-books.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                    <input type="text" name="search" placeholder="Cari berdasarkan judul koleksi..." value="{{ $search }}" class="w-full pl-12 pr-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold">
                </div>
                <div>
                    <select name="status" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold text-on-surface-variant">
                        <option value="">Semua Status Penanganan</option>
                        <option value="menunggu_penggantian" @selected($status === 'menunggu_penggantian')>Menunggu Penggantian</option>
                        <option value="selesai_diganti_sama" @selected($status === 'selesai_diganti_sama')>Selesai (Penggantian Sama)</option>
                        <option value="selesai_diganti_koleksi_baru" @selected($status === 'selesai_diganti_koleksi_baru')>Selesai (Koleksi Baru)</option>
                        <option value="diafkir_perbaikan" @selected($status === 'diafkir_perbaikan')>Di-afkir / Perbaikan</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 py-3 px-6 rounded-2xl bg-primary text-white font-bold text-xs hover:bg-opacity-90 transition-all shadow-sm">
                        Terapkan Filter
                    </button>
                    @if($search !== null || $status !== null)
                        <a href="{{ route('petugas.damaged-books.index') }}" class="py-3 px-6 rounded-2xl border border-outline-variant/100 text-on-surface-variant hover:bg-slate-50 font-bold text-xs transition-all text-center flex items-center justify-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>

        <!-- Table Container -->
        <x-table :pagination="$damagedBooks->hasPages() ? $damagedBooks->links() : null">
            <x-slot name="headers">
                <th class="px-4 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700 w-1/3">Judul Koleksi</th>
                <th class="px-4 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700 w-1/3">Catatan Kerusakan</th>
                <th class="px-4 py-3.5 font-bold text-xs uppercase tracking-wider text-slate-700 whitespace-nowrap">Status Fisik</th>
                <th class="px-4 py-3.5 font-bold text-xs uppercase tracking-wider text-center text-slate-700 whitespace-nowrap">Aksi</th>
            </x-slot>

            @forelse($damagedBooks as $row)
                <tr class="even:bg-slate-50/40 hover:bg-teal-50/40 transition-colors duration-150 group border-b border-slate-100">
                    <td class="px-4 py-3.5">
                        <div class="flex flex-col min-w-0">
                            <span class="font-bold text-slate-900 text-xs sm:text-sm group-hover:text-teal-700 transition-colors truncate">{{ $row->collection?->display_title ?? 'Koleksi' }}</span>
                            <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 border border-teal-200">
                                    {{ $row->collection?->display_type_label ?? 'Koleksi' }}
                                </span>
                                @if($row->collection?->item_type === 'book' && $row->collection?->book?->category)
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $row->collection->book->category->kategori_name }}
                                    </span>
                                @elseif($row->collection?->author_name)
                                    <span class="text-[10px] text-slate-500 font-medium">
                                        • {{ $row->collection->author_name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3.5">
                        <span class="text-xs font-semibold text-slate-700 leading-relaxed block">
                            {{ $row->condition_notes ?: 'Kondisi fisik bermasalah / rusak' }}
                        </span>
                    </td>

                    <td class="px-4 py-3.5 whitespace-nowrap">
                        @if($row->status === 'menunggu_penggantian')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200 text-[11px] font-extrabold">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mr-1.5 animate-pulse"></span>
                                Menunggu Tindak Lanjut
                            </span>
                        @elseif($row->status === 'dalam_perbaikan')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-800 border border-indigo-200 text-[11px] font-extrabold">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 mr-1.5 animate-pulse"></span>
                                Dalam Perbaikan
                            </span>
                        @elseif($row->status === 'selesai_diperbaiki')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-[11px] font-extrabold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-1.5"></span>
                                Selesai (Kembali ke Rak)
                            </span>
                        @elseif($row->status === 'selesai_diganti_sama')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 text-[11px] font-extrabold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-1.5"></span>
                                Selesai (Diganti Buku Sama)
                            </span>
                        @elseif($row->status === 'selesai_diganti_koleksi_baru')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-sky-100 text-sky-800 border border-sky-200 text-[11px] font-extrabold">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600 mr-1.5"></span>
                                Selesai (Koleksi Baru)
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 border border-rose-200 text-[11px] font-extrabold">
                                Di-afkir Permanen
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3.5 text-center whitespace-nowrap">
                        @if(!in_array($row->status, ['selesai_diperbaiki', 'selesai_diganti_sama', 'selesai_diganti_koleksi_baru', 'diafkir_perbaikan'], true))
                            <button type="button" 
                                    onclick="openActionModal(
                                        '{{ $row->damaged_book_id }}', 
                                        '{{ addslashes($row->collection?->display_title ?? 'Koleksi') }}', 
                                        '{{ $row->status }}', 
                                        '{{ route('petugas.damaged-books.restore-stock', $row->damaged_book_id) }}', 
                                        '{{ route('petugas.damaged-books.mark-repair', $row->damaged_book_id) }}', 
                                        '{{ route('petugas.damaged-books.mark-scrapped', $row->damaged_book_id) }}', 
                                        '{{ $row->user_id ? route('petugas.penalties.index', ['search' => $row->user?->name]) : '' }}'
                                    )" 
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-primary text-white font-bold text-xs hover:bg-opacity-90 transition-all shadow-xs active:scale-95 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">tune</span>
                                <span>Pilih Aksi</span>
                            </button>
                        @else
                            <span class="text-xs text-slate-400 font-bold flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span> Tuntas
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-5 py-12 text-center text-slate-500 font-medium">Belum ada data buku/arsip rusak.</td>
                </tr>
            @endforelse
        </x-table>
    </main>

    <!-- MODAL CATAT TEMUAN RUSAK INTERNAL (INSPEKSI RAK) -->
    <div id="modal-internal-damaged" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl space-y-4 my-auto relative">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2 text-rose-700">
                    <span class="material-symbols-outlined text-2xl">report_problem</span>
                    <h3 class="font-bold text-base text-slate-800">Catat Temuan Rusak (Inspeksi Rak)</h3>
                </div>
                <button type="button" onclick="closeInternalModal()" class="text-slate-400 hover:text-slate-600 rounded-full p-1">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <form method="POST" action="{{ route('petugas.damaged-books.store-internal') }}" class="space-y-4">
                @csrf
                <div class="p-3 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-900 space-y-1">
                    <p class="font-bold">⚠️ Pencatatan Inspeksi Internal Rak</p>
                    <p class="text-[11px] leading-relaxed">Gunakan form ini untuk mencatat koleksi/arsip yang ditemukan rusak saat stock opname rak. Stok ketersediaan koleksi di rak akan <strong>otomatis berkurang 1</strong>.</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Cari &amp; Pilih Koleksi / Arsip <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[18px]">search</span>
                        <input type="text" id="modal-collection-search" oninput="filterModalCollections()" placeholder="Ketik judul koleksi atau arsip..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-semibold focus:border-rose-500 focus:bg-white transition-all">
                    </div>

                    <input type="hidden" name="koleksi_id" id="selected_koleksi_id" required>

                    <!-- Scrollable Collection List -->
                    <div id="modal-collection-list" class="max-h-48 overflow-y-auto border border-slate-200 rounded-2xl divide-y divide-slate-100 bg-slate-50/50 p-1 space-y-1">
                        @foreach($allCollections as $col)
                            <div data-title="{{ strtolower($col->display_title) }}" data-id="{{ $col->koleksi_id }}" onclick="selectModalCollection(this, '{{ $col->koleksi_id }}')" class="collection-item p-2.5 rounded-xl cursor-pointer hover:bg-rose-50 transition-all flex items-center justify-between border border-transparent">
                                <div class="min-w-0 pr-2">
                                    <div class="font-bold text-xs text-slate-800 truncate">{{ $col->display_title }}</div>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="text-[9px] font-extrabold px-1.5 py-0.5 rounded-md bg-teal-50 text-teal-700 border border-teal-200">
                                            {{ $col->display_type_label }}
                                        </span>
                                        <span class="text-[10px] text-slate-500 font-medium">Stok Rak: {{ $col->stock }}</span>
                                    </div>
                                </div>
                                <span class="check-icon material-symbols-outlined text-rose-600 text-lg hidden">check_circle</span>
                            </div>
                        @endforeach
                        <div id="no-collections-found" class="p-4 text-center text-xs text-slate-400 font-medium hidden">
                            Judul koleksi tidak ditemukan.
                        </div>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Catatan Kerusakan Fisik <span class="text-rose-500">*</span></label>
                    <textarea name="condition_notes" required rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs resize-none font-medium focus:border-rose-500" placeholder="Misal: Ditemukan halaman sobek/jamuran saat stock opname di Rak A3."></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" onclick="closeInternalModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md">Simpan &amp; Kurangi Stok Rak (-1)</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL TINDAK LANJUT AKSI KOLEKSI RUSAK (OPSI B) -->
    <div id="modal-action-damaged" class="fixed inset-0 z-[99999] hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 my-auto relative">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-base text-slate-800">Tindak Lanjut Koleksi Rusak</h3>
                    <p id="action-modal-title" class="text-xs font-bold text-teal-700 truncate max-w-xs mt-0.5"></p>
                </div>
                <button type="button" onclick="closeActionModal()" class="text-slate-400 hover:text-slate-600 rounded-full p-1">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <div class="space-y-2.5">
                <!-- Option 1: Pulihkan ke Rak (+1 Stok) -->
                <form id="form-restore-stock" method="POST" action="" onsubmit="return confirm('Konfirmasi pemulihan fisik koleksi ke rak (+1 Stok)?')">
                    @csrf
                    <button type="submit" class="w-full p-3.5 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-left transition-all group flex items-start gap-3 cursor-pointer">
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-lg">build_circle</span>
                        </div>
                        <div>
                            <span class="font-bold text-xs text-emerald-900 block">Pulihkan ke Rak (+1 Stok)</span>
                            <span class="text-[11px] text-emerald-700 font-medium leading-tight block">Fisik koleksi selesai diperbaiki internal &amp; dikembalikan ke sirkulasi.</span>
                        </div>
                    </button>
                </form>

                <!-- Option 2: Dalam Perbaikan Internal -->
                <form id="form-mark-repair" method="POST" action="">
                    @csrf
                    <button type="submit" class="w-full p-3.5 rounded-2xl bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 text-left transition-all group flex items-start gap-3 cursor-pointer">
                        <div class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-lg">build</span>
                        </div>
                        <div>
                            <span class="font-bold text-xs text-indigo-900 block">Dalam Perbaikan</span>
                            <span class="text-[11px] text-indigo-700 font-medium leading-tight block">Fisik koleksi sedang dalam proses perbaikan.</span>
                        </div>
                    </button>
                </form>

                <!-- Option 3: Denda & Sanksi Peminjam -->
                <a id="link-fine-penalty" href="#" class="w-full p-3.5 rounded-2xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-left transition-all group flex items-start gap-3 cursor-pointer">
                    <div class="w-9 h-9 rounded-xl bg-amber-600 text-white flex items-center justify-center font-bold shrink-0 mt-0.5">
                        <span class="material-symbols-outlined text-lg">gavel</span>
                    </div>
                    <div>
                        <span class="font-bold text-xs text-amber-900 block">Kelola di Denda &amp; Sanksi</span>
                        <span class="text-[11px] text-amber-800 font-medium leading-tight block">Proses pelunasan denda &amp; penggantian buku oleh peminjam.</span>
                    </div>
                </a>

                <!-- Option 4: Afkir Permanen -->
                <form id="form-mark-scrapped" method="POST" action="" onsubmit="return confirm('Tandai fisik koleksi ini sebagai Di-afkir Permanen (Dimusnahkan)?')">
                    @csrf
                    <button type="submit" class="w-full p-3.5 rounded-2xl bg-rose-50 hover:bg-rose-100 border border-rose-200 text-left transition-all group flex items-start gap-3 cursor-pointer">
                        <div class="w-9 h-9 rounded-xl bg-rose-600 text-white flex items-center justify-center font-bold shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-lg">delete_forever</span>
                        </div>
                        <div>
                            <span class="font-bold text-xs text-rose-900 block">Afkir Permanen</span>
                            <span class="text-[11px] text-rose-700 font-medium leading-tight block">Fisik koleksi rusak parah &amp; resmi dihapus dari inventaris rak atau diberikan kepada pihak tertentu.</span>
                        </div>
                    </button>
                </form>
            </div>

            <div class="pt-2 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeActionModal()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl cursor-pointer">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function openActionModal(id, title, status, restoreUrl, repairUrl, scrappedUrl, penaltyUrl) {
            document.getElementById('action-modal-title').innerText = title;
            
            document.getElementById('form-restore-stock').action = restoreUrl;
            document.getElementById('form-mark-repair').action = repairUrl;
            document.getElementById('form-mark-scrapped').action = scrappedUrl;

            const penaltyLink = document.getElementById('link-fine-penalty');
            if (penaltyUrl) {
                penaltyLink.href = penaltyUrl;
                penaltyLink.classList.remove('hidden');
            } else {
                penaltyLink.classList.add('hidden');
            }

            document.getElementById('modal-action-damaged').classList.remove('hidden');
        }

        function closeActionModal() {
            document.getElementById('modal-action-damaged').classList.add('hidden');
        }

        function openInternalModal() {
            document.getElementById('modal-internal-damaged').classList.remove('hidden');
        }
        function closeInternalModal() {
            document.getElementById('modal-internal-damaged').classList.add('hidden');
        }

        function filterModalCollections() {
            const query = document.getElementById('modal-collection-search').value.toLowerCase().trim();
            const items = document.querySelectorAll('#modal-collection-list .collection-item');
            let hasMatch = false;

            items.forEach(item => {
                const title = item.getAttribute('data-title');
                if (title.includes(query)) {
                    item.classList.remove('hidden');
                    hasMatch = true;
                } else {
                    item.classList.add('hidden');
                }
            });

            const noResult = document.getElementById('no-collections-found');
            if (noResult) {
                if (!hasMatch) {
                    noResult.classList.remove('hidden');
                } else {
                    noResult.classList.add('hidden');
                }
            }
        }

        function selectModalCollection(element, id) {
            document.querySelectorAll('#modal-collection-list .collection-item').forEach(item => {
                item.classList.remove('bg-rose-50', 'border-rose-300');
                item.querySelector('.check-icon').classList.add('hidden');
            });

            element.classList.add('bg-rose-50', 'border-rose-300');
            element.querySelector('.check-icon').classList.remove('hidden');
            document.getElementById('selected_koleksi_id').value = id;
        }
    </script>
</body>
</html>
