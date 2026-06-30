<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Rules Pengembalian - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "outline": "#777587",
                        "outline-variant": "#c7c4d8",
                        "surface-container-low": "#f2f3ff",
                        "surface-container": "#eaedff",
                        "primary": "#00a5c0",
                        "primary-container": "#00a5c0",
                        "on-surface": "#131b2e",
                        "on-surface-variant": "#464555",
                        "error": "#ba1a1a"
                    },
                    borderRadius: {
                        "2xl": "1rem",
                        "3xl": "1.5rem"
                    },
                    spacing: {
                        "margin-desktop": "40px"
                    },
                    fontFamily: {
                        "headline-md": ["Outfit"],
                        "body-md": ["Inter"],
                        "label-md": ["Inter"]
                    }
                },
            },
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

    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-headline-md text-on-surface">Rules Pengembalian</h1>
                <p class="text-sm text-outline">Atur checklist inspeksi fisik dan aturan denda untuk proses pengembalian.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-on-surface">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-outline font-medium uppercase tracking-wide">Petugas Perpustakaan</p>
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
                    Ada input yang perlu diperbaiki:
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
            <section class="xl:col-span-2 bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
                <div class="p-8 border-b border-outline-variant/10">
                    <h2 class="font-headline-md text-on-surface text-lg">Checklist Pengembalian</h2>
                    <p class="text-xs text-outline mt-1">Item aktif akan muncul pada modal inspeksi fisik saat petugas memproses pengembalian.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-surface-container-low/50">
                                <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant">Urutan</th>
                                <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant">Item</th>
                                <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant">Status</th>
                                <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            @forelse($checklists as $checklist)
                                <tr class="hover:bg-surface-container-low/30 transition-colors">
                                    <td class="px-8 py-5 text-sm font-bold text-on-surface">{{ $checklist->sort_order }}</td>
                                    <td class="px-8 py-5">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-on-surface text-sm">{{ $checklist->item_name }}</span>
                                            <span class="text-xs text-outline">{{ $checklist->description ?: 'Tanpa deskripsi tambahan.' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full {{ $checklist->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }} text-[10px] font-bold uppercase tracking-wide">
                                            {{ $checklist->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('petugas.return-settings.checklists.edit', $checklist->return_checklist_id) }}" class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center transition-all" title="Edit checklist">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </a>
                                            <form action="{{ route('petugas.return-settings.checklists.destroy', $checklist->return_checklist_id) }}" method="POST" onsubmit="return confirm('Hapus checklist ini dari sistem?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-9 h-9 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 flex items-center justify-center transition-all" title="Hapus checklist">
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-outline font-medium">Belum ada checklist pengembalian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="font-headline-md text-on-surface text-lg">Tambah Checklist</h2>
                        <p class="text-xs text-outline mt-1">Tambahkan poin inspeksi baru sesuai kebutuhan perpustakaan.</p>
                    </div>
                    <span class="material-symbols-outlined text-primary">playlist_add</span>
                </div>

                <form action="{{ route('petugas.return-settings.checklists.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="item_name" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Nama Item</label>
                        <input type="text" id="item_name" name="item_name" value="{{ old('item_name') }}" placeholder="Contoh: Tidak ada bekas terbakar" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold">
                    </div>
                    <div>
                        <label for="description" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="3" placeholder="Jelaskan kriteria pemeriksaan..." class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm resize-none">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Urutan Tampil</label>
                        <input type="number" id="sort_order" name="sort_order" min="1" value="{{ old('sort_order', $checklists->count() + 1) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold">
                    </div>
                    <label class="flex items-center gap-3 p-4 rounded-2xl bg-surface-container-low border border-outline-variant/20">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-outline-variant/50 text-primary focus:ring-primary" {{ old('is_active', '1') ? 'checked' : '' }}>
                        <span class="text-sm font-semibold text-on-surface">Aktifkan checklist ini</span>
                    </label>
                    <button type="submit" class="w-full py-3 px-6 rounded-2xl bg-primary text-white font-bold text-sm hover:bg-opacity-95 transition-all shadow-lg shadow-primary/20">
                        Simpan Checklist
                    </button>
                </form>
            </section>
        </div>

        <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <div class="p-8 border-b border-outline-variant/10">
                <h2 class="font-headline-md text-on-surface text-lg">Aturan Denda Default</h2>
                <p class="text-xs text-outline mt-1">Aturan aktif akan dipakai untuk mengisi default denda keterlambatan, kerusakan, dan kehilangan.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low/50">
                            <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant">Jenis</th>
                            <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant">Perhitungan</th>
                            <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant">Penyelesaian Default</th>
                            <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant">Nominal Default</th>
                            <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant">Status</th>
                            <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-outline-variant text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @foreach($penaltyRules as $rule)
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-on-surface text-sm">{{ $rule->rule_name }}</span>
                                        <span class="text-xs text-outline">{{ $rule->description ?: 'Tanpa catatan tambahan.' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-sm font-semibold text-on-surface-variant">{{ $rule->calculation_type_label }}</td>
                                <td class="px-8 py-5 text-sm font-semibold text-on-surface-variant">{{ $rule->default_settlement_method_label }}</td>
                                <td class="px-8 py-5 text-sm font-bold text-on-surface">Rp {{ number_format($rule->default_amount, 0, ',', '.') }}</td>
                                <td class="px-8 py-5">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full {{ $rule->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }} text-[10px] font-bold uppercase tracking-wide">
                                        {{ $rule->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <a href="{{ route('petugas.return-settings.penalty-rules.edit', $rule->penalty_rule_id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-amber-50 text-amber-700 font-bold text-xs hover:bg-amber-100 transition-all">
                                        <span class="material-symbols-outlined text-[16px]">tune</span>
                                        Ubah Aturan
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
