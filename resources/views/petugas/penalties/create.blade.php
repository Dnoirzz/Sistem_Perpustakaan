<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Buat Denda Manual - SIPUS PSDKU POLNEP</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-background": "#131b2e", "surface": "#faf8ff", "outline": "#777587",
                        "outline-variant": "#c7c4d8", "surface-container": "#eaedff",
                        "primary": "#00a5c0", "on-surface": "#131b2e", "on-surface-variant": "#464555",
                        "surface-container-low": "#f2f3ff", "error": "#ba1a1a", "on-primary": "#ffffff",
                        "primary-container": "#00a5c0", "on-error": "#ffffff"
                    },
                    "borderRadius": { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1rem", "3xl": "1.5rem", "full": "9999px" },
                    "spacing": { "container-max": "1280px", "base": "8px", "margin-mobile": "16px", "gutter": "24px", "margin-desktop": "40px" },
                    "fontFamily": { "headline-md": ["Outfit"], "label-md": ["Inter"], "body-md": ["Inter"] },
                    "fontSize": {
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "600"}],
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
        .ts-wrapper .ts-control { border: 1px solid rgba(199,196,216,0.4); border-radius: 1rem; padding: 0.75rem 1rem; font-size: 12px; font-weight: 600; background: white; min-height: 48px; }
        .ts-wrapper.focus .ts-control { border-color: #00a5c0; box-shadow: 0 0 0 2px rgba(0,165,192,0.2); }
        .ts-wrapper .ts-control input { font-size: 12px !important; }
        .ts-dropdown { border: 1px solid rgba(199,196,216,0.3); border-radius: 1rem; box-shadow: 0 8px 24px rgba(0,0,0,0.08); margin-top: 4px; }
        .ts-dropdown .option { padding: 10px 16px; font-size: 12px; font-weight: 600; }
        .ts-dropdown .active { background: #eaedff; color: #131b2e; }
    </style>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen">
    @include('petugas.layouts.sidebar')

    <main class="ml-64 p-margin-desktop bg-[#f8faff] min-h-screen">
        @include('layouts.header', [
            'title' => 'Buat Denda Manual',
            'subtitle' => 'Catat sanksi untuk keterlambatan, kerusakan, atau kehilangan buku.',
            'back_url' => route('petugas.penalties.index')
        ])

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-sm shadow-sm">
                <div class="flex items-center gap-2 mb-2 font-bold">
                    <span class="material-symbols-outlined text-rose-600 text-[18px]">error</span>
                    Terdapat kesalahan pada input Anda:
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="bg-white rounded-3xl shadow-sm border border-outline-variant/10 overflow-hidden max-w-4xl">
            <form action="{{ route('petugas.penalties.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <div>
                    <label for="loan_id" class="block font-label-md text-on-surface-variant mb-2">Transaksi Peminjaman <span class="text-error">*</span></label>
                    <select id="loan_id" name="loan_id" required>
                        <option value="">Pilih transaksi peminjaman...</option>
                        @foreach($activeLoans as $loan)
                            <option value="{{ $loan->loan_id }}" {{ old('loan_id') == $loan->loan_id ? 'selected' : '' }}>
                                {{ $loan->user->name ?? 'User' }} — {{ $loan->collection?->book?->judul ?? 'Buku' }} ({{ ucfirst($loan->status) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="type" class="block font-label-md text-on-surface-variant mb-2">Jenis Denda <span class="text-error">*</span></label>
                    <select id="type" name="type" required class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold">
                        <option value="">Pilih jenis denda...</option>
                        @foreach($penaltyRules as $code => $rule)
                            <option value="{{ $code }}" {{ old('type') === $code ? 'selected' : '' }}>
                                {{ $rule->rule_name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-[11px] text-outline font-medium">
                        Daftar ini mengikuti aturan yang aktif di menu
                        <a href="{{ route('petugas.return-settings.index') }}" class="text-primary font-bold hover:underline">Pengaturan Return</a>.
                    </p>
                </div>

                <div>
                    <label for="settlement_method" class="block font-label-md text-on-surface-variant mb-2">Metode Penyelesaian <span class="text-error">*</span></label>
                    <select id="settlement_method" name="settlement_method" required class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold">
                        <option value="">Pilih metode penyelesaian...</option>
                        <option value="uang_tunai" {{ old('settlement_method') === 'uang_tunai' ? 'selected' : '' }}>Denda uang tunai</option>
                        <option value="ganti_buku" {{ old('settlement_method') === 'ganti_buku' ? 'selected' : '' }}>Penggantian buku</option>
                        <option value="kombinasi" {{ old('settlement_method') === 'kombinasi' ? 'selected' : '' }}>Kombinasi buku + uang</option>
                    </select>
                </div>

                <div id="amount-wrapper">
                    <label for="amount" class="block font-label-md text-on-surface-variant mb-2">Nominal Denda (Rp) <span id="amount-required-indicator" class="text-error hidden">*</span></label>
                    <input type="number" id="amount" name="amount" min="0" step="500" value="{{ old('amount') }}" placeholder="Contoh: 50000" class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold"/>
                    <p id="amount-hint" class="mt-2 text-[11px] text-outline font-medium">Isi nominal jika penyelesaian melibatkan pembayaran uang tunai.</p>
                </div>

                <div>
                    <label for="description" class="block font-label-md text-on-surface-variant mb-2">Keterangan</label>
                    <textarea id="description" name="description" rows="3" placeholder="Deskripsi singkat tentang denda ini..." class="w-full px-4 py-3 rounded-2xl border border-outline-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 text-xs font-semibold resize-none">{{ old('description') }}</textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('petugas.penalties.index') }}" class="py-3 px-8 rounded-2xl border border-outline-variant/30 text-on-surface-variant hover:bg-slate-50 font-bold text-sm transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="py-3 px-8 rounded-2xl bg-primary text-white font-bold text-sm hover:bg-opacity-95 transition-all shadow-lg shadow-primary/20">
                        Simpan Denda
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
    <script>
        const penaltyRuleMap = {!! json_encode(
            $penaltyRules->mapWithKeys(function ($rule, $code) {
                return [
                    $code => [
                        'default_settlement_method' => $rule->default_settlement_method,
                        'default_amount' => (float) $rule->default_amount,
                        'description' => $rule->description,
                    ],
                ];
            })
        ) !!};

        new TomSelect('#loan_id', {
            placeholder: 'Ketik nama anggota atau judul buku...',
            allowEmptyOption: true,
            maxOptions: 10,
        });

        function syncPenaltyDefaults() {
            const type = document.getElementById('type').value;
            const rule = penaltyRuleMap[type];

            if (!rule) {
                return;
            }

            const settlementMethod = document.getElementById('settlement_method');
            const amountInput = document.getElementById('amount');
            const descriptionInput = document.getElementById('description');

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

            syncManualPenaltyMethod();
        }

        function syncManualPenaltyMethod() {
            const method = document.getElementById('settlement_method').value;
            const amountWrapper = document.getElementById('amount-wrapper');
            const amountInput = document.getElementById('amount');
            const amountHint = document.getElementById('amount-hint');
            const amountRequiredIndicator = document.getElementById('amount-required-indicator');
            const needsAmount = method === 'uang_tunai' || method === 'kombinasi';

            amountWrapper.classList.toggle('opacity-70', method === 'ganti_buku');
            amountInput.required = needsAmount;
            amountRequiredIndicator.classList.toggle('hidden', !needsAmount);

            if (method === 'ganti_buku') {
                amountInput.value = '';
                amountHint.textContent = 'Nominal dapat dikosongkan jika sanksi hanya berupa penggantian buku.';
            } else if (method === 'kombinasi') {
                amountHint.textContent = 'Isi nominal uang yang harus dibayarkan selain penggantian buku.';
            } else {
                amountHint.textContent = 'Isi nominal jika penyelesaian melibatkan pembayaran uang tunai.';
            }
        }

        document.getElementById('type').addEventListener('change', function () {
            document.getElementById('settlement_method').dataset.autoFill = 'true';
            document.getElementById('amount').dataset.autoFill = 'true';
            document.getElementById('description').dataset.autoFill = 'true';
            syncPenaltyDefaults();
        });
        document.getElementById('settlement_method').addEventListener('change', function () {
            this.dataset.autoFill = 'false';
            syncManualPenaltyMethod();
        });
        document.getElementById('amount').addEventListener('input', function () {
            this.dataset.autoFill = 'false';
        });
        document.getElementById('description').addEventListener('input', function () {
            this.dataset.autoFill = 'false';
        });
        syncPenaltyDefaults();
        syncManualPenaltyMethod();
    </script>
</body>
</html>
