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

        return view('petugas.penalties.index', compact('penalties', 'stats', 'search', 'status'));
    }

    /**
     * Tandai denda sebagai lunas.
     */
    public function markPaid($penalti_id)
    {
        $penalty = Penalty::findOrFail($penalti_id);

        if ($penalty->status === 'lunas') {
            return redirect()
                ->route('petugas.penalties.index')
                ->with('error', 'Denda ini sudah lunas.');
        }

        $penalty->update(['status' => 'lunas']);

        \App\Models\NotificationCustom::send(
            $penalty->user_id,
            'Pelunasan Denda Dikonfirmasi',
            "Pembayaran denda sebesar Rp " . number_format($penalty->amount, 0, ',', '.') . " telah dikonfirmasi LUNAS.",
            null,
            'denda'
        );

        return redirect()
            ->route('petugas.penalties.index')
            ->with('success', 'Denda berhasil ditandai sebagai lunas.');
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
        $releasedCollectionId = null;
        $loan = null;

        try {
            $loan = DB::transaction(function () use ($validated, $amount, &$releasedCollectionId) {
                $loanReference = Loan::query()
                    ->select(['loan_id', 'koleksi_id'])
                    ->whereKey($validated['loan_id'])
                    ->firstOrFail();

                $collection = Collection::query()
                    ->whereKey($loanReference->koleksi_id)
                    ->lockForUpdate()
                    ->first();

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

                if (in_array($validated['settlement_method'], ['ganti_buku', 'kombinasi'], true) && $collection) {
                    $collection->syncBackingStock(1);
                    $releasedCollectionId = $loan->koleksi_id;
                }

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

        if ($releasedCollectionId) {
            Antrian::checkAndNotifyAvailableQueue($releasedCollectionId);
        }

        return redirect()
            ->route('petugas.penalties.index')
            ->with('success', 'Transaksi berhasil diproses sebagai buku hilang.');
    }
}
