<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Edit Checklist Return - SIPUS PSDKU POLNEP</title>
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
                        "primary": "#00a5c0",
                        "primary-container": "#00a5c0",
                        "on-surface": "#131b2e",
                        "on-surface-variant": "#464555",
                    },
                    borderRadius: { "2xl": "1rem", "3xl": "1.5rem" },
                    spacing: { "margin-desktop": "40px" },
                    fontFamily: { "headline-md": ["Outfit"], "body-md": ["Inter"], "label-md": ["Inter"] }
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
        @include('layouts.header', [
            'title' => 'Edit Checklist Pengembalian',
            'subtitle' => 'Perbarui item inspeksi fisik yang akan ditampilkan pada proses return.',
            'back_url' => route('petugas.return-settings.index')
        ])

        <div class="max-w-3xl">
            <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 p-8">
                <form action="{{ route('petugas.return-settings.checklists.update', $checklist->return_checklist_id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="item_name" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Nama Item</label>
                        <input type="text" id="item_name" name="item_name" value="{{ old('item_name', $checklist->item_name) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold">
                    </div>
                    <div>
                        <label for="description" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm resize-none">{{ old('description', $checklist->description) }}</textarea>
                    </div>
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Urutan Tampil</label>
                        <input type="number" id="sort_order" name="sort_order" min="1" value="{{ old('sort_order', $checklist->sort_order) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold">
                    </div>
                    <label class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50 border border-outline-variant/20">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-outline-variant/50 text-primary focus:ring-primary" {{ old('is_active', $checklist->is_active) ? 'checked' : '' }}>
                        <span class="text-sm font-semibold text-on-surface">Checklist aktif</span>
                    </label>
                    <div class="flex gap-4">
                        <a href="{{ route('petugas.return-settings.index') }}" class="flex-1 py-4 text-center rounded-2xl border border-outline-variant/30 text-on-surface-variant font-bold text-sm hover:bg-slate-50 transition-all">
                            Kembali
                        </a>
                        <button type="submit" class="flex-1 py-4 rounded-2xl bg-primary text-white font-bold text-sm hover:bg-opacity-95 transition-all shadow-lg shadow-primary/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
