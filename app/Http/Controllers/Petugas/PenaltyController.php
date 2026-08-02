<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Penalty;
use App\Models\PenaltyRule;
use App\Support\ArsipDigital;
use Illuminate\Http\Request;

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
        $activeLoans = Loan::with(['user', 'collection.book'])
            ->whereIn('status', ['dipinjam', 'terlambat', 'dikembalikan'])
            ->orderByDesc('created_at')
            ->get();

        $penaltyRules = PenaltyRule::active()
            ->whereIn('code', ['keterlambatan', 'kehilangan', 'kerusakan'])
            ->orderBy('rule_name')
            ->get()
            ->keyBy('code');

        return view('petugas.penalties.create', compact('activeLoans', 'penaltyRules'));
    }

    /**
     * Simpan denda manual baru.
     */
    public function store(Request $request)
    {
        $penaltyRules = PenaltyRule::active()
            ->whereIn('code', ['keterlambatan', 'kehilangan', 'kerusakan'])
            ->get()
            ->keyBy('code');

        $validTypes = $penaltyRules->keys()->values()->all();

        $validated = $request->validate([
            'loan_id' => ['required', 'exists:loans,loan_id'],
            'type' => ['required', 'in:' . implode(',', $validTypes)],
            'settlement_method' => ['required', 'in:uang_tunai,ganti_buku,kombinasi'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:500'],
        ], [
            'loan_id.required' => 'Transaksi peminjaman wajib dipilih.',
            'loan_id.exists' => 'Transaksi peminjaman tidak valid.',
            'type.required' => 'Jenis denda wajib dipilih.',
            'type.in' => 'Jenis denda tidak valid.',
            'settlement_method.required' => 'Metode penyelesaian wajib dipilih.',
            'settlement_method.in' => 'Metode penyelesaian tidak valid.',
            'amount.numeric' => 'Nominal denda harus berupa angka.',
            'amount.min' => 'Nominal denda tidak boleh negatif.',
        ]);

        if (in_array($validated['settlement_method'], ['uang_tunai', 'kombinasi'], true)) {
            $request->validate([
                'amount' => ['required', 'numeric', 'min:0'],
            ], [
                'amount.required' => 'Nominal denda wajib diisi untuk penyelesaian uang tunai atau kombinasi.',
            ]);
        }

        $loan = Loan::findOrFail($validated['loan_id']);
        $rule = $penaltyRules->get($validated['type']);
        $amount = $validated['amount'] ?? (float) ($rule?->default_amount ?? 0);

        Penalty::create([
            'loan_id' => $loan->loan_id,
            'user_id' => $loan->user_id,
            'type' => $validated['type'],
            'penalti_type' => $validated['settlement_method'],
            'amount' => $amount,
            'description' => $validated['description'] ?? null,
            'status' => 'belum_dibayar',
        ]);

        \App\Models\NotificationCustom::send(
            $loan->user_id,
            'Catatan Sanksi Denda Baru',
            "Tercatat sanksi denda sebesar Rp " . number_format($amount, 0, ',', '.') . " untuk peminjaman koleksi.",
            null,
            'denda'
        );

        return redirect()
            ->route('petugas.penalties.index')
            ->with('success', 'Denda manual berhasil ditambahkan.');
    }
}
