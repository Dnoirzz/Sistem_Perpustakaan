<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Loan;
use App\Models\Penalty;
use App\Models\PenaltyRule;
use App\Models\ReturnChecklist;
use App\Support\ArsipDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    /**
     * Tampilkan daftar peminjaman aktif yang siap diproses pengembalian.
     */
    public function index(Request $request)
    {
        Loan::syncOverdueStatuses();

        $search = $request->input('search');
        $status = $request->input('status');

        $query = Loan::with([
            'user.role',
            'user.mahasiswa.prodi',
            'user.dosen.prodi',
            'collection.book.category',
        ]);

        if ($status && $status === 'dikembalikan') {
            $query->where('status', 'dikembalikan');
        } elseif ($status) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['dipinjam', 'terlambat']);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                            $mq->where('nim', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dosen', function ($dq) use ($search) {
                            $dq->where('nip', 'like', "%{$search}%");
                        });
                });

                $matchingCollectionIds = ArsipDigital::matchingCollectionIds($search);
                if ($matchingCollectionIds !== []) {
                    $q->orWhereIn('koleksi_id', $matchingCollectionIds);
                }
            });
        }

        $loans = $query
            ->orderByRaw("CASE WHEN status = 'terlambat' THEN 0 WHEN status = 'dipinjam' THEN 1 ELSE 2 END")
            ->orderByDesc('tgl_pinjam')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'active_loans' => Loan::whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'overdue_loans' => Loan::where('status', 'terlambat')->count(),
            'returned_today' => Loan::whereDate('tgl_kembali', today())->count(),
        ];

        $checklistItems = ReturnChecklist::active()->ordered()->get();
        $penaltyRules = PenaltyRule::active()
            ->whereIn('code', ['kerusakan', 'kehilangan'])
            ->orderBy('rule_name')
            ->get()
            ->keyBy('code');

        return view('petugas.returns.index', compact('loans', 'stats', 'search', 'status', 'checklistItems', 'penaltyRules'));
    }

    /**
     * Proses pengembalian buku.
     */
    public function process(Request $request, $loan_id)
    {
        $loan = Loan::with(['user', 'collection.book'])->findOrFail($loan_id);

        if (! in_array($loan->status, ['dipinjam', 'terlambat'], true)) {
            return redirect()
                ->route('petugas.returns.index')
                ->with('error', 'Peminjaman ini sudah dikembalikan sebelumnya.');
        }

        $checklistItems = ReturnChecklist::active()->ordered()->get();
        $penaltyRules = PenaltyRule::active()->get()->keyBy('code');
        $physicalPenaltyCodes = $penaltyRules->keys()
            ->reject(fn ($code) => $code === 'keterlambatan')
            ->values()
            ->all();

        $validated = $request->validate([
            'return_loan_id' => ['required', 'integer'],
            'condition_checks' => ['nullable', 'array'],
            'return_condition_notes' => ['nullable', 'string', 'max:1000'],
            'penalty_type' => ['nullable', 'string'],
            'settlement_method' => ['nullable', 'in:uang_tunai,ganti_buku,kombinasi'],
            'penalty_amount' => ['nullable', 'numeric', 'min:0'],
            'penalty_description' => ['nullable', 'string', 'max:1000'],
        ], [
            'return_loan_id.required' => 'Konteks transaksi pengembalian tidak ditemukan.',
            'settlement_method.in' => 'Metode penyelesaian sanksi tidak valid.',
            'penalty_amount.numeric' => 'Nominal sanksi harus berupa angka.',
            'penalty_amount.min' => 'Nominal sanksi tidak boleh negatif.',
        ]);

        if ((int) $validated['return_loan_id'] !== (int) $loan->loan_id) {
            return redirect()
                ->route('petugas.returns.index')
                ->with('error', 'Data pengembalian tidak sinkron. Silakan ulangi proses pengembalian.');
        }

        $conditionChecks = $this->extractConditionChecks($request, $checklistItems);
        $failedConditions = $this->getFailedConditionLabels($conditionChecks);
        $hasPhysicalIssue = $failedConditions !== [];

        if ($hasPhysicalIssue && $physicalPenaltyCodes === []) {
            return redirect()
                ->route('petugas.returns.index')
                ->with('error', 'Aturan sanksi kerusakan/kehilangan belum aktif. Silakan atur terlebih dahulu di menu Pengaturan Return.');
        }

        if ($hasPhysicalIssue) {
            $request->validate([
                'return_condition_notes' => ['required', 'string', 'max:1000'],
                'penalty_type' => ['required', 'in:' . implode(',', $physicalPenaltyCodes)],
                'settlement_method' => ['required', 'in:uang_tunai,ganti_buku,kombinasi'],
                'penalty_description' => ['required', 'string', 'max:1000'],
            ], [
                'return_condition_notes.required' => 'Catatan hasil pengecekan fisik wajib diisi jika ada kondisi buku yang bermasalah.',
                'penalty_type.required' => 'Jenis sanksi wajib dipilih jika kondisi buku tidak memenuhi kriteria.',
                'penalty_type.in' => 'Jenis sanksi harus mengikuti aturan yang aktif.',
                'settlement_method.required' => 'Metode penyelesaian sanksi wajib dipilih.',
                'penalty_description.required' => 'Keterangan sanksi wajib diisi agar tindak lanjut jelas.',
            ]);

            if (in_array($request->input('settlement_method'), ['uang_tunai', 'kombinasi'], true)) {
                $request->validate([
                    'penalty_amount' => ['required', 'numeric', 'min:0'],
                ], [
                    'penalty_amount.required' => 'Nominal sanksi wajib diisi untuk denda uang tunai atau kombinasi.',
                ]);
            }
        }

        $selectedPhysicalRule = $hasPhysicalIssue ? $penaltyRules->get($request->input('penalty_type')) : null;
        $lateRule = $penaltyRules->get('keterlambatan');

        $wasOverdue = $loan->isOverdue();
        $today = today();
        $shouldRestock = ! ($hasPhysicalIssue && $request->input('penalty_type') === 'kehilangan');
        $penaltyAmount = $request->filled('penalty_amount') ? (float) $request->input('penalty_amount') : 0;

        $notifiableQueue = null;

        DB::transaction(function () use (
            $loan,
            $today,
            $wasOverdue,
            $conditionChecks,
            $hasPhysicalIssue,
            $failedConditions,
            $shouldRestock,
            $penaltyAmount,
            $request,
            $lateRule,
            $selectedPhysicalRule,
            &$notifiableQueue
        ) {
            $loan->update([
                'tgl_kembali' => $today,
                'status' => 'dikembalikan',
                'return_condition_status' => $hasPhysicalIssue ? 'bermasalah' : 'baik',
                'return_condition_checks' => $conditionChecks,
                'return_condition_notes' => $request->input('return_condition_notes'),
            ]);

            if ($shouldRestock && $loan->collection) {
                $loan->collection->syncBackingStock(1);
            }

            if ($wasOverdue && $lateRule && $lateRule->is_active) {
                $daysLate = $loan->bts_waktu->diffInDays($today);
                $amount = $this->calculateLatePenaltyAmount($lateRule, $daysLate);

                if ($amount > 0) {
                    Penalty::create([
                        'loan_id' => $loan->loan_id,
                        'user_id' => $loan->user_id,
                        'type' => 'keterlambatan',
                        'penalti_type' => $lateRule->default_settlement_method,
                        'amount' => $amount,
                        'description' => $this->buildLatePenaltyDescription($lateRule, $daysLate),
                        'status' => 'belum_dibayar',
                    ]);
                }
            }

            if ($hasPhysicalIssue && $selectedPhysicalRule) {
                Penalty::create([
                    'loan_id' => $loan->loan_id,
                    'user_id' => $loan->user_id,
                    'type' => $selectedPhysicalRule->code,
                    'penalti_type' => $request->input('settlement_method'),
                    'amount' => $penaltyAmount,
                    'description' => $this->buildPhysicalPenaltyDescription(
                        $failedConditions,
                        $request->input('return_condition_notes'),
                        $request->input('penalty_description'),
                        $selectedPhysicalRule
                    ),
                    'status' => 'belum_dibayar',
                ]);
            }

            if ($shouldRestock && $loan->koleksi_id) {
                Antrian::checkAndNotifyAvailableQueue($loan->koleksi_id);
            }
        });

        // Catat Log Aktivitas (Fase 6)
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Memproses pengembalian koleksi "' . ($loan->collection->display_title ?? 'Koleksi') . '" oleh anggota: ' . $loan->user->name,
        ]);


        $bookTitle = $loan->collection?->display_title ?? 'koleksi';
        $message = "Pengembalian \"{$bookTitle}\" oleh {$loan->user->name} berhasil diproses.";

        if ($wasOverdue && $lateRule && $lateRule->is_active) {
            $message .= ' Denda keterlambatan otomatis telah dicatat sesuai aturan aktif.';
        }

        if ($hasPhysicalIssue) {
            $message .= ' Hasil inspeksi fisik dan sanksi tambahan juga telah disimpan.';
        }

        return redirect()
            ->route('petugas.returns.index')
            ->with('success', $message);
    }

    private function extractConditionChecks(Request $request, Collection $checklistItems): array
    {
        return $checklistItems->map(function (ReturnChecklist $item) use ($request) {
            $passed = $request->boolean('condition_checks.' . $item->return_checklist_id, true);

            return [
                'checklist_id' => $item->return_checklist_id,
                'item_name' => $item->item_name,
                'description' => $item->description,
                'passed' => $passed,
            ];
        })->values()->all();
    }

    private function getFailedConditionLabels(array $conditionChecks): array
    {
        return collect($conditionChecks)
            ->filter(fn (array $item) => ! ($item['passed'] ?? false))
            ->pluck('item_name')
            ->values()
            ->all();
    }

    private function calculateLatePenaltyAmount(PenaltyRule $rule, int $daysLate): float
    {
        return match ($rule->calculation_type) {
            'per_hari' => max(1, $daysLate) * (float) $rule->default_amount,
            'flat', 'manual' => (float) $rule->default_amount,
            default => 0,
        };
    }

    private function buildLatePenaltyDescription(PenaltyRule $rule, int $daysLate): string
    {
        $baseDescription = trim((string) $rule->description);

        $segments = match ($rule->calculation_type) {
            'per_hari' => ["Denda keterlambatan {$daysLate} hari x Rp " . number_format((float) $rule->default_amount, 0, ',', '.')],
            'flat' => ["Denda keterlambatan flat Rp " . number_format((float) $rule->default_amount, 0, ',', '.')],
            default => ['Denda keterlambatan sesuai aturan aktif'],
        };

        if ($baseDescription !== '') {
            $segments[] = $baseDescription;
        }

        return implode(' | ', $segments);
    }

    private function buildPhysicalPenaltyDescription(
        array $failedConditions,
        ?string $inspectionNotes,
        ?string $penaltyDescription,
        PenaltyRule $rule
    ): string {
        $segments = [
            'Aturan: ' . $rule->rule_name,
            'Checklist bermasalah: ' . implode(', ', $failedConditions),
        ];

        if ($rule->description) {
            $segments[] = 'Catatan aturan: ' . trim($rule->description);
        }

        if ($inspectionNotes) {
            $segments[] = 'Catatan inspeksi: ' . trim($inspectionNotes);
        }

        if ($penaltyDescription) {
            $segments[] = 'Tindak lanjut: ' . trim($penaltyDescription);
        }

        return implode(' | ', $segments);
    }
}
