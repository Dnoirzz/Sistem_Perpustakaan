<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\ActivityLog;
use App\Models\Collection;
use App\Models\Loan;
use App\Models\NotificationCustom;
use App\Models\Penalty;
use App\Models\PenaltyRule;
use App\Services\TelegramService;
use App\Services\WhatsAppService;
use App\Support\ArsipDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PenaltyController extends Controller
{
    /**
     * Tampilkan daftar semua denda/sanksi.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Penalty::with([
            'user.role',
            'user.mahasiswa',
            'user.dosen',
            'loan.collection.book',
        ]);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                            $mq->where('nim', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dosen', function ($dq) use ($search) {
                            $dq->where('nip', 'like', "%{$search}%");
                        });
                })->orWhereHas('loan.collection.book', function ($bq) use ($search) {
                    $bq->where('judul', 'like', "%{$search}%");
                });

                $matchingCollectionIds = ArsipDigital::matchingCollectionIds($search);
                if ($matchingCollectionIds !== []) {
                    $q->orWhereHas('loan', function ($lq) use ($matchingCollectionIds) {
                        $lq->whereIn('koleksi_id', $matchingCollectionIds);
                    });
                }
            });
        }

        $penalties = $query
            ->orderByRaw("CASE WHEN status = 'belum_dibayar' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'unpaid_count' => Penalty::where('status', 'belum_dibayar')->count(),
            'unpaid_total' => Penalty::where('status', 'belum_dibayar')->sum('amount'),
            'paid_today' => Penalty::where('status', 'lunas')->whereDate('updated_at', today())->count(),
        ];

        $categories = \App\Models\Category::orderBy('kategori_name')->get();

        return view('petugas.penalties.index', compact('penalties', 'stats', 'search', 'status', 'categories'));
    }

    /**
     * Konfirmasi bahwa buku pengganti yang SAMA PERSIS telah diterima.
     * Menambah +1 stok ketersediaan dari unit fisik baru yang diserahkan.
     */
    public function confirmReplacementSame(Request $request, $penalti_id)
    {
        $releasedCollectionId = null;

        DB::transaction(function () use ($penalti_id, $request, &$releasedCollectionId) {
            $penalty = Penalty::query()->whereKey($penalti_id)->lockForUpdate()->firstOrFail();

            if (! in_array($penalty->penalti_type, ['ganti_buku', 'kombinasi'], true) && ! in_array($penalty->type, ['kerusakan', 'kehilangan'], true)) {
                throw ValidationException::withMessages([
                    'penalty' => 'Metode sanksi ini tidak membutuhkan konfirmasi fisik buku pengganti.',
                ]);
            }

            if ($penalty->replacement_received_at !== null) {
                throw ValidationException::withMessages([
                    'penalty' => 'Buku pengganti untuk sanksi ini sudah pernah dikonfirmasi diterima.',
                ]);
            }

            $loan = Loan::with(['user', 'collection.book'])->whereKey($penalty->loan_id)->lockForUpdate()->firstOrFail();
            $collection = Collection::query()->whereKey($loan->koleksi_id)->lockForUpdate()->first();

            if ($collection) {
                $collection->syncBackingStock(1);
                $releasedCollectionId = $collection->koleksi_id;
            }

            $replacementReceivedAt = now();
            $isCombination = $penalty->penalti_type === 'kombinasi';
            $isFullySettled = ! $isCombination || $penalty->payment_received_at !== null;

            $penalty->update([
                'replacement_received_at' => $replacementReceivedAt,
                'status' => $isFullySettled ? 'lunas' : 'belum_dibayar',
            ]);

            // Update catatan di pemantauan buku rusak jika ada
            \App\Models\DamagedBook::where('loan_id', $loan->loan_id)
                ->where('status', 'menunggu_penggantian')
                ->update([
                    'status' => 'selesai_diganti_sama',
                    'replacement_notes' => $request->input('notes', 'Penggantian buku fisik baru yang sama persis dikonfirmasi di Halaman Denda.'),
                    'resolved_at' => now(),
                ]);

            $collectionTitle = $loan->collection?->display_title ?? 'Koleksi';
            $notificationMessage = $isCombination && ! $isFullySettled
                ? "Buku pengganti (Judul Sama) untuk koleksi \"{$collectionTitle}\" telah diterima. Pembayaran tunai masih belum dikonfirmasi."
                : "Buku pengganti (Judul Sama) untuk koleksi \"{$collectionTitle}\" telah diterima dan sanksi dinyatakan lunas.";

            NotificationCustom::send(
                $penalty->user_id,
                'Buku Pengganti Diterima',
                $notificationMessage,
                $penalty->user?->isDosen() ? route('dosen.loans.penalties') : route('mahasiswa.loans.penalties'),
                'denda'
            );

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Mengonfirmasi buku pengganti (Judul Sama) untuk koleksi "' . $collectionTitle . '" dari anggota: ' . ($penalty->user?->name ?? 'Anggota'),
            ]);
        });

        if ($releasedCollectionId) {
            Antrian::checkAndNotifyAvailableQueue($releasedCollectionId);
        }

        return redirect()->route('petugas.penalties.index')->with('success', 'Buku pengganti (Judul Sama) berhasil dikonfirmasi diterima. Stok ketersediaan buku bertambah +1.');
    }

    /**
     * Konfirmasi bahwa buku pengganti KOLEKSI BARU (1 Kategori) telah diterima.
     * Mendaftarkan 1 Koleksi Judul Baru di katalog perpustakaan tanpa menambah stok buku lama.
     */
    public function confirmReplacementNew(Request $request, $penalti_id)
    {
        $penalty = Penalty::with(['loan.collection.book.category', 'user'])->findOrFail($penalti_id);

        if ($penalty->replacement_received_at !== null) {
            return redirect()->back()->with('error', 'Buku pengganti untuk sanksi ini sudah pernah dikonfirmasi diterima.');
        }

        $originalCategoryId = $penalty->loan?->collection?->book?->category_id;

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'pengarang' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'isbn' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'category_id' => $originalCategoryId ? ['nullable', 'integer'] : ['required', 'exists:categories,category_id'],
        ], [
            'judul.required' => 'Judul buku baru wajib diisi.',
            'pengarang.required' => 'Nama pengarang wajib diisi.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
        ]);

        $categoryIdToUse = $originalCategoryId ?: $validated['category_id'];

        DB::transaction(function () use ($penalty, $validated, $categoryIdToUse, $request) {
            // 1. Buat Buku Baru
            $newBook = \App\Models\Book::create([
                'category_id' => $categoryIdToUse,
                'judul' => $validated['judul'],
                'author' => $validated['pengarang'],
                'publisher' => $validated['penerbit'],
                'publication_year' => $validated['tahun_terbit'],
                'isbn' => $validated['isbn'] ?? null,
                'description' => $validated['deskripsi'] ?? ('Buku penggantian dari peminjam: ' . ($penalty->user?->name ?? '-')),
                'stock' => 1,
            ]);

            // 2. Buat Koleksi Baru untuk Buku Baru tersebut
            $newCollection = Collection::create([
                'item_type' => 'book',
                'item_id' => $newBook->buku_id,
                'stock' => 1,
            ]);

            // 3. Update status Penalty
            $isCombination = $penalty->penalti_type === 'kombinasi';
            $isFullySettled = ! $isCombination || $penalty->payment_received_at !== null;

            $penalty->update([
                'replacement_received_at' => now(),
                'status' => $isFullySettled ? 'lunas' : 'belum_dibayar',
            ]);

            // 4. Update status DamagedBook jika ada
            if ($penalty->loan_id) {
                \App\Models\DamagedBook::where('loan_id', $penalty->loan_id)
                    ->where('status', 'menunggu_penggantian')
                    ->update([
                        'status' => 'selesai_diganti_koleksi_baru',
                        'replacement_koleksi_id' => $newCollection->koleksi_id,
                        'replacement_notes' => $request->input('notes', 'Diganti koleksi baru: "' . $newBook->judul . '" (Dikonfirmasi di Halaman Denda).'),
                        'resolved_at' => now(),
                    ]);
            }

            $collectionTitle = $penalty->loan?->collection?->display_title ?? 'Koleksi';
            $notificationMessage = "Buku pengganti koleksi baru (\"{$newBook->judul}\") untuk penggantian \"{$collectionTitle}\" telah diterima dan dikatalogkan.";

            NotificationCustom::send(
                $penalty->user_id,
                'Buku Pengganti Baru Diterima',
                $notificationMessage,
                $penalty->user?->isDosen() ? route('dosen.loans.penalties') : route('mahasiswa.loans.penalties'),
                'denda'
            );

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Mengonfirmasi buku pengganti Koleksi Baru ("' . $newBook->judul . '") dari peminjam: ' . ($penalty->user?->name ?? 'Anggota'),
            ]);
        });

        return redirect()->route('petugas.penalties.index')->with('success', 'Buku pengganti (Koleksi Baru) berhasil dikatalogkan dengan stok = 1 dan sanksi telah dilunaskan.');
    }

    /**
     * Tandai denda sebagai lunas.
     */
    public function markPaid($penalti_id)
    {
        $penalty = Penalty::with(['user.role', 'loan.collection.book'])->findOrFail($penalti_id);

        if ($penalty->status === 'lunas') {
            return redirect()
                ->route('petugas.penalties.index')
                ->with('error', 'Denda ini sudah lunas.');
        }

        $isCombination = $penalty->type === 'kehilangan' && $penalty->penalti_type === 'kombinasi';

        if ($isCombination && $penalty->payment_received_at !== null) {
            return redirect()
                ->route('petugas.penalties.index')
                ->with('error', 'Pembayaran tunai untuk sanksi ini sudah pernah dikonfirmasi.');
        }

        if ($penalty->type === 'kehilangan'
            && $penalty->penalti_type === 'ganti_buku'
            && $penalty->replacement_received_at === null) {
            return redirect()
                ->route('petugas.penalties.index')
                ->with('error', 'Gunakan aksi Konfirmasi Buku Pengganti Diterima untuk sanksi ganti buku.');
        }

        $paymentReceivedAt = now();
        $isFullySettled = ! $isCombination || $penalty->replacement_received_at !== null;

        $penalty->update([
            'status' => $isFullySettled ? 'lunas' : 'belum_dibayar',
            'payment_received_at' => $paymentReceivedAt,
        ]);

        $collectionTitle = $penalty->loan?->collection?->display_title ?? 'Koleksi';
        $amountLabel = 'Rp ' . number_format((float) $penalty->amount, 0, ',', '.');
        [$notificationTitle, $notificationMessage] = $isCombination && ! $isFullySettled
            ? [
                'Pembayaran Tunai Dikonfirmasi',
                "Pembayaran tunai sebesar {$amountLabel} untuk sanksi kehilangan koleksi \"{$collectionTitle}\" telah dikonfirmasi. Buku pengganti masih menunggu penerimaan.",
            ]
            : match ($penalty->type) {
            'keterlambatan' => [
                'Denda Keterlambatan Lunas',
                "Denda keterlambatan sebesar {$amountLabel} untuk koleksi \"{$collectionTitle}\" telah dikonfirmasi lunas.",
            ],
            'kerusakan' => [
                'Sanksi Kerusakan Buku Lunas',
                "Sanksi kerusakan buku sebesar {$amountLabel} untuk koleksi \"{$collectionTitle}\" telah dikonfirmasi lunas.",
            ],
            'kehilangan' => [
                'Sanksi Kehilangan Buku Lunas',
                "Sanksi kehilangan buku sebesar {$amountLabel} untuk koleksi \"{$collectionTitle}\" telah dikonfirmasi lunas.",
            ],
            default => [
                'Pelunasan Denda Dikonfirmasi',
                "Tagihan denda sebesar {$amountLabel} untuk koleksi \"{$collectionTitle}\" telah dikonfirmasi lunas.",
            ],
        };

        NotificationCustom::send(
            $penalty->user_id,
            $notificationTitle,
            $notificationMessage,
            $penalty->user?->isDosen() ? route('dosen.loans.penalties') : route('mahasiswa.loans.penalties'),
            'denda'
        );

        return redirect()
            ->route('petugas.penalties.index')
            ->with('success', $isCombination && ! $isFullySettled
                ? 'Pembayaran tunai berhasil dikonfirmasi. Buku pengganti masih menunggu penerimaan.'
                : 'Denda berhasil ditandai sebagai lunas.');
    }

    /**
     * Konfirmasi bahwa buku pengganti sudah diterima perpustakaan.
     */
    public function confirmReplacement($penalti_id)
    {
        $releasedCollectionId = null;

        DB::transaction(function () use ($penalti_id, &$releasedCollectionId) {
            $penalty = Penalty::query()
                ->whereKey($penalti_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($penalty->type !== 'kehilangan' || ! in_array($penalty->penalti_type, ['ganti_buku', 'kombinasi'], true)) {
                throw ValidationException::withMessages([
                    'penalty' => 'Konfirmasi buku pengganti hanya tersedia untuk sanksi kehilangan dengan metode ganti buku atau kombinasi.',
                ]);
            }

            if ($penalty->replacement_received_at !== null) {
                throw ValidationException::withMessages([
                    'penalty' => 'Buku pengganti untuk sanksi ini sudah pernah dikonfirmasi diterima.',
                ]);
            }

            $loan = Loan::with(['user', 'collection.book'])
                ->whereKey($penalty->loan_id)
                ->lockForUpdate()
                ->firstOrFail();
            $collection = Collection::query()
                ->whereKey($loan->koleksi_id)
                ->lockForUpdate()
                ->first();

            if (! $collection) {
                throw ValidationException::withMessages([
                    'penalty' => 'Koleksi buku tidak ditemukan sehingga stok tidak dapat diperbarui.',
                ]);
            }

            $collection->syncBackingStock(1);
            $releasedCollectionId = $collection->koleksi_id;

            $replacementReceivedAt = now();
            $isCombination = $penalty->penalti_type === 'kombinasi';
            $isFullySettled = ! $isCombination || $penalty->payment_received_at !== null;

            $penalty->update([
                'replacement_received_at' => $replacementReceivedAt,
                'status' => $isFullySettled ? 'lunas' : 'belum_dibayar',
            ]);

            $collectionTitle = $loan->collection?->display_title ?? 'Koleksi';
            $notificationMessage = $isCombination && ! $isFullySettled
                ? "Buku pengganti untuk koleksi \"{$collectionTitle}\" telah diterima. Pembayaran tunai masih belum dikonfirmasi."
                : "Buku pengganti untuk koleksi \"{$collectionTitle}\" telah diterima dan sanksi kehilangan dinyatakan lunas.";

            NotificationCustom::send(
                $penalty->user_id,
                'Buku Pengganti Diterima',
                $notificationMessage,
                $penalty->user?->isDosen() ? route('dosen.loans.penalties') : route('mahasiswa.loans.penalties'),
                'denda'
            );

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Mengonfirmasi buku pengganti untuk koleksi "' . $collectionTitle . '" telah diterima dari anggota: ' . ($penalty->user?->name ?? 'Anggota'),
            ]);
        });

        if ($releasedCollectionId) {
            Antrian::checkAndNotifyAvailableQueue($releasedCollectionId);
        }

        return redirect()
            ->route('petugas.penalties.index')
            ->with('success', 'Buku pengganti berhasil dikonfirmasi diterima dan stok koleksi bertambah 1.');
    }

    /**
     * Tampilkan form buat denda manual.
     */
    public function create()
    {
        Loan::syncOverdueStatuses();

        $activeLoans = Loan::with(['user', 'collection.book'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->orderByDesc('created_at')
            ->get();

        $penaltyRules = PenaltyRule::active()
            ->where('code', 'kehilangan')
            ->orderBy('rule_name')
            ->get()
            ->keyBy('code');

        return view('petugas.penalties.create', compact('activeLoans', 'penaltyRules'));
    }

    /**
     * Proses transaksi sebagai buku hilang.
     */
    public function store(Request $request)
    {
        $amountRules = ['nullable', 'numeric', 'min:0'];
        if (in_array($request->input('settlement_method'), ['uang_tunai', 'kombinasi'], true)) {
            $amountRules[0] = 'required';
        }

        $validated = $request->validate([
            'loan_id' => ['required', 'exists:loans,loan_id'],
            'settlement_method' => ['required', 'in:uang_tunai,ganti_buku,kombinasi'],
            'amount' => $amountRules,
            'description' => ['required', 'string', 'max:500'],
        ], [
            'loan_id.required' => 'Transaksi peminjaman wajib dipilih.',
            'loan_id.exists' => 'Transaksi peminjaman tidak valid.',
            'settlement_method.required' => 'Metode penyelesaian wajib dipilih.',
            'settlement_method.in' => 'Metode penyelesaian tidak valid.',
            'amount.required' => 'Nominal wajib diisi untuk metode uang tunai atau kombinasi.',
            'amount.numeric' => 'Nominal uang harus berupa angka.',
            'amount.min' => 'Nominal uang tidak boleh negatif.',
            'description.required' => 'Keterangan kehilangan wajib diisi.',
            'description.max' => 'Keterangan kehilangan maksimal 500 karakter.',
        ]);

        $amount = (float) ($validated['amount'] ?? 0);
        $loan = null;

        try {
            $loan = DB::transaction(function () use ($validated, $amount) {
                $loanReference = Loan::query()
                    ->select(['loan_id', 'koleksi_id'])
                    ->whereKey($validated['loan_id'])
                    ->firstOrFail();

                $loan = Loan::with(['user', 'collection.book'])
                    ->whereKey($loanReference->loan_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (! in_array($loan->status, ['dipinjam', 'terlambat'], true)) {
                    throw ValidationException::withMessages([
                        'loan_id' => 'Transaksi ini sudah tidak aktif dan tidak dapat diproses sebagai buku hilang.',
                    ]);
                }

                if ($loan->penalties()->where('type', 'kehilangan')->exists()) {
                    throw ValidationException::withMessages([
                        'loan_id' => 'Sanksi kehilangan untuk transaksi ini sudah pernah dibuat.',
                    ]);
                }

                $lateRule = PenaltyRule::active()
                    ->where('code', 'keterlambatan')
                    ->first();
                $wasOverdue = $loan->isOverdue();

                $loan->update([
                    'tgl_kembali' => today(),
                    'status' => 'hilang',
                    'return_condition_status' => 'bermasalah',
                    'return_condition_checks' => null,
                    'return_condition_notes' => $validated['description'],
                ]);

                $createdPenalties = [];

                if ($wasOverdue && $lateRule && $loan->penalties()->where('type', 'keterlambatan')->doesntExist()) {
                    $daysLate = $loan->bts_waktu->diffInDays(today());
                    $lateAmount = match ($lateRule->calculation_type) {
                        'per_hari' => max(1, $daysLate) * (float) $lateRule->default_amount,
                        'flat', 'manual' => (float) $lateRule->default_amount,
                        default => 0,
                    };

                    if ($lateAmount > 0) {
                        $createdPenalties[] = Penalty::create([
                            'loan_id' => $loan->loan_id,
                            'user_id' => $loan->user_id,
                            'type' => 'keterlambatan',
                            'penalti_type' => $lateRule->default_settlement_method,
                            'amount' => $lateAmount,
                            'description' => 'Denda keterlambatan otomatis sebelum proses buku hilang.',
                            'status' => 'belum_dibayar',
                        ]);
                    }
                }

                $createdPenalties[] = Penalty::create([
                    'loan_id' => $loan->loan_id,
                    'user_id' => $loan->user_id,
                    'type' => 'kehilangan',
                    'penalti_type' => $validated['settlement_method'],
                    'amount' => $amount,
                    'description' => $validated['description'],
                    'status' => 'belum_dibayar',
                ]);

                $collectionTitle = $loan->collection?->display_title ?? 'Koleksi';
                $targetUrl = $loan->user?->isDosen() ? route('dosen.loans.penalties') : route('mahasiswa.loans.penalties');

                foreach ($createdPenalties as $penalty) {
                    $amountLabel = $penalty->amount > 0
                        ? 'Rp ' . number_format($penalty->amount, 0, ',', '.')
                        : 'Penggantian buku';

                    NotificationCustom::send(
                        $loan->user_id,
                        $penalty->type === 'kehilangan' ? 'Proses Buku Hilang' : 'Denda Keterlambatan',
                        $penalty->type === 'kehilangan'
                            ? "Transaksi koleksi \"{$collectionTitle}\" telah diproses sebagai buku hilang. Penyelesaian: {$penalty->settlement_method_label} ({$amountLabel}). Silakan cek halaman Denda Saya."
                            : "Denda keterlambatan sebesar {$amountLabel} telah dicatat untuk transaksi koleksi \"{$collectionTitle}\". Silakan cek halaman Denda Saya.",
                        $targetUrl,
                        'warning'
                    );

                    if ($loan->user && ! empty($loan->user->no_hp)) {
                        WhatsAppService::send(
                            $loan->user->no_hp,
                            "Halo, {$loan->user->name}!\n\n" . ($penalty->type === 'kehilangan'
                                ? "Transaksi koleksi *{$collectionTitle}* telah diproses sebagai *Buku Hilang*.\nMetode penyelesaian: *{$penalty->settlement_method_label}*\nNominal: *{$amountLabel}*\nKeterangan: {$validated['description']}"
                                : "Denda keterlambatan sebesar *{$amountLabel}* telah dicatat untuk koleksi *{$collectionTitle}*.") . "\n\nSilakan cek halaman Denda Saya."
                        );
                    }

                    if ($loan->user && ! empty($loan->user->telegram_chat_id)) {
                        TelegramService::send(
                            $loan->user->telegram_chat_id,
                            '<b>' . ($penalty->type === 'kehilangan' ? 'Proses Buku Hilang' : 'Denda Keterlambatan') . '</b>\n\n' .
                            ($penalty->type === 'kehilangan'
                                ? 'Transaksi koleksi <b>' . e($collectionTitle) . '</b> telah diproses sebagai <b>Buku Hilang</b>.\nMetode penyelesaian: <b>' . e($penalty->settlement_method_label) . '</b>\nNominal: <b>' . e($amountLabel) . '</b>\nKeterangan: ' . e($validated['description'])
                                : 'Denda keterlambatan sebesar <b>' . e($amountLabel) . '</b> telah dicatat untuk koleksi <b>' . e($collectionTitle) . '</b>') .
                            '\n\nSilakan cek halaman Denda Saya.'
                        );
                    }
                }

                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'activity' => 'Memproses buku hilang dari koleksi "' . $collectionTitle . '" oleh anggota: ' . ($loan->user?->name ?? 'Anggota'),
                ]);

                return $loan;
            });
        } catch (ValidationException $exception) {
            throw $exception;
        }

        return redirect()
            ->route('petugas.penalties.index')
            ->with('success', 'Transaksi berhasil diproses sebagai buku hilang.');
    }
}
