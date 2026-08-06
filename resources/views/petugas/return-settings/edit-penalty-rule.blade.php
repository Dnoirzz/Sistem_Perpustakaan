<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Edit Aturan Denda - SIPUS PSDKU POLNEP</title>
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
            'title' => 'Edit Aturan Denda',
            'subtitle' => 'Perbarui aturan default untuk ' . strtolower($penaltyRule->rule_name) . '.',
            'back_url' => route('petugas.return-settings.index')
        ])

        <div class="max-w-4xl">
            <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/100 p-8">
                <form action="{{ route('petugas.return-settings.penalty-rules.update', $penaltyRule->penalty_rule_id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="rule_name" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Nama Aturan</label>
                            <input type="text" id="rule_name" name="rule_name" value="{{ old('rule_name', $penaltyRule->rule_name) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Kode Sistem</label>
                            <div class="px-4 py-3 rounded-2xl bg-slate-50 border border-outline-variant/100 text-sm font-bold text-on-surface uppercase">
                                {{ $penaltyRule->code }}
                            </div>
                        </div>
                        <div>
                            <label for="calculation_type" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Tipe Perhitungan</label>
                            <select id="calculation_type" name="calculation_type" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold">
                                <option value="per_hari" {{ old('calculation_type', $penaltyRule->calculation_type) === 'per_hari' ? 'selected' : '' }}>Per hari</option>
                                <option value="flat" {{ old('calculation_type', $penaltyRule->calculation_type) === 'flat' ? 'selected' : '' }}>Nominal tetap</option>
                                <option value="manual" {{ old('calculation_type', $penaltyRule->calculation_type) === 'manual' ? 'selected' : '' }}>Manual oleh petugas</option>
                            </select>
                        </div>
                        <div>
                            <label for="default_settlement_method" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Penyelesaian Default</label>
                            <select id="default_settlement_method" name="default_settlement_method" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold">
                                <option value="uang_tunai" {{ old('default_settlement_method', $penaltyRule->default_settlement_method) === 'uang_tunai' ? 'selected' : '' }}>Uang tunai</option>
                                <option value="ganti_buku" {{ old('default_settlement_method', $penaltyRule->default_settlement_method) === 'ganti_buku' ? 'selected' : '' }}>Ganti buku</option>
                                <option value="kombinasi" {{ old('default_settlement_method', $penaltyRule->default_settlement_method) === 'kombinasi' ? 'selected' : '' }}>Kombinasi</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="default_amount" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Nominal Default (Rp)</label>
                        <input type="number" id="default_amount" name="default_amount" min="0" step="500" value="{{ old('default_amount', $penaltyRule->default_amount) }}" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm font-semibold">
                        <p class="text-xs text-outline mt-2">Untuk aturan `per_hari`, nominal ini akan dikalikan jumlah hari keterlambatan.</p>
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold text-outline uppercase tracking-wider mb-2">Keterangan Aturan</label>
                        <textarea id="description" name="description" rows="4" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/100 focus:border-primary focus:ring-2 focus:ring-primary/20 text-sm resize-none">{{ old('description', $penaltyRule->description) }}</textarea>
                    </div>

                    <label class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50 border border-outline-variant/100">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-outline-variant/100 text-primary focus:ring-primary" {{ old('is_active', $penaltyRule->is_active) ? 'checked' : '' }}>
                        <span class="text-sm font-semibold text-on-surface">Aktifkan aturan ini</span>
                    </label>

                    <div class="flex gap-4">
                        <a href="{{ route('petugas.return-settings.index') }}" class="flex-1 py-4 text-center rounded-2xl border border-outline-variant/100 text-on-surface-variant font-bold text-sm hover:bg-slate-50 transition-all">
                            Kembali
                        </a>
                        <button type="submit" class="flex-1 py-4 rounded-2xl bg-primary text-white font-bold text-sm hover:bg-opacity-95 transition-all shadow-lg shadow-primary/20">
                            Simpan Aturan
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
