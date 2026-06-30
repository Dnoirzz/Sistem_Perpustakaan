<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Loan;
use App\Models\User;
use App\Support\ArsipDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
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

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('mahasiswa', function ($mahasiswaQuery) use ($search) {
                            $mahasiswaQuery->where('nim', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dosen', function ($dosenQuery) use ($search) {
                            $dosenQuery->where('nip', 'like', "%{$search}%");
                        });
                });

                $matchingCollectionIds = ArsipDigital::matchingCollectionIds($search);
                if ($matchingCollectionIds !== []) {
                    $q->orWhereIn('koleksi_id', $matchingCollectionIds);
                }
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $loans = $query
            ->orderByRaw("CASE WHEN status = 'terlambat' THEN 0 WHEN status = 'dipinjam' THEN 1 ELSE 2 END")
            ->orderByDesc('tgl_pinjam')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'active_loans' => Loan::where('status', 'dipinjam')->count(),
            'overdue_loans' => Loan::where('status', 'terlambat')->count(),
            'returned_today' => Loan::whereDate('tgl_kembali', today())->count(),
            'available_books' => Collection::sum('stock'),
        ];

        return view('petugas.loans.index', compact('loans', 'stats', 'search', 'status'));
    }

    public function create()
    {
        Loan::syncOverdueStatuses();

        $oldUserId = old('user_id');
        $members = collect();
        if ($oldUserId) {
            $selectedMember = User::where('user_id', $oldUserId)
                ->with(['role', 'mahasiswa.prodi', 'dosen.prodi'])
                ->first();
            if ($selectedMember) {
                $members = collect([$selectedMember]);
            }
        }

        $oldCollectionId = old('koleksi_id');
        $collections = collect();
        if ($oldCollectionId) {
            $selectedCollection = Collection::with(['book.category'])
                ->where('koleksi_id', $oldCollectionId)
                ->first();
            if ($selectedCollection) {
                $collections = collect([$selectedCollection]);
            }
        }

        return view('petugas.loans.create', compact('members', 'collections'));
    }

    public function searchMembers(Request $request)
    {
        $q = $request->input('q');
        if (empty($q)) {
            return response()->json([]);
        }

        $members = User::whereHas('role', function ($query) {
            $query->whereIn('role_name', ['mahasiswa', 'dosen']);
        })
        ->where(function ($query) use ($q) {
            $query->where('name', 'like', "%{$q}%")
                ->orWhereHas('mahasiswa', function ($mq) use ($q) {
                    $mq->where('nim', 'like', "%{$q}%");
                })
                ->orWhereHas('dosen', function ($dq) use ($q) {
                    $dq->where('nip', 'like', "%{$q}%");
                });
        })
        ->with(['role', 'mahasiswa', 'dosen'])
        ->limit(5)
        ->get()
        ->map(function ($user) {
            $roleName = strtoupper($user->role->role_name ?? '');
            $identifier = '';
            if ($user->role && $user->role->role_name === 'mahasiswa') {
                $identifier = ' (NIM: ' . ($user->mahasiswa->nim ?? '-') . ')';
            } elseif ($user->role && $user->role->role_name === 'dosen') {
                $identifier = ' (NIP: ' . ($user->dosen->nip ?? '-') . ')';
            }
            return [
                'user_id' => $user->user_id,
                'name' => $user->name,
                'name_display' => $user->name . ' - ' . $roleName . $identifier
            ];
        });

        return response()->json($members);
    }

    public function searchBooks(Request $request)
    {
        $q = $request->input('q');
        if (empty($q)) {
            return response()->json([]);
        }

        $collections = Collection::with(['book.category'])
            ->where('stock', '>', 0)
            ->get()
            ->filter(function (Collection $collection) use ($q) {
                $haystack = strtolower(
                    $collection->display_title . ' ' .
                    $collection->display_type_label . ' ' .
                    ($collection->book?->author ?? '')
                );

                return str_contains($haystack, strtolower($q));
            })
            ->limit(5)
            ->values()
            ->map(function (Collection $collection) {
                return [
                    'koleksi_id' => $collection->koleksi_id,
                    'judul' => $collection->display_title,
                    'judul_display' => $collection->display_title . ' - ' . $collection->display_type_label . ' (Stok: ' . $collection->stock . ')',
                ];
            });

        return response()->json($collections);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,user_id'],
            'koleksi_id' => ['required', 'exists:collections,koleksi_id'],
            'tgl_pinjam' => ['required', 'date'],
            'bts_waktu' => ['required', 'date', 'after_or_equal:tgl_pinjam'],
        ], [
            'user_id.required' => 'Anggota peminjam wajib dipilih.',
            'user_id.exists' => 'Anggota yang dipilih tidak valid.',
            'koleksi_id.required' => 'Koleksi yang dipinjam wajib dipilih.',
            'koleksi_id.exists' => 'Koleksi yang dipilih tidak ditemukan.',
            'tgl_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'bts_waktu.required' => 'Batas waktu pengembalian wajib diisi.',
            'bts_waktu.after_or_equal' => 'Batas waktu harus sama atau setelah tanggal pinjam.',
        ]);

        $member = User::with('role')->findOrFail($validated['user_id']);

        if (!$member->role || !in_array($member->role->role_name, ['mahasiswa', 'dosen'], true)) {
            throw ValidationException::withMessages([
                'user_id' => 'Peminjaman hanya dapat dibuat untuk anggota mahasiswa atau dosen.',
            ]);
        }

        $loan = DB::transaction(function () use ($validated) {
            $collection = Collection::with('book')
                ->where('koleksi_id', $validated['koleksi_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($collection->stock < 1) {
                throw ValidationException::withMessages([
                    'koleksi_id' => 'Stok koleksi sudah habis. Silakan pilih koleksi lain atau tunggu pengembalian.',
                ]);
            }

            $hasActiveLoan = Loan::where('user_id', $validated['user_id'])
                ->where('koleksi_id', $collection->koleksi_id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->exists();

            if ($hasActiveLoan) {
                throw ValidationException::withMessages([
                    'koleksi_id' => 'Anggota ini masih memiliki peminjaman aktif untuk koleksi yang sama.',
                ]);
            }

            $newLoan = Loan::create([
                'user_id' => $validated['user_id'],
                'koleksi_id' => $collection->koleksi_id,
                'tgl_pinjam' => $validated['tgl_pinjam'],
                'bts_waktu' => $validated['bts_waktu'],
                'status' => 'dipinjam',
            ]);

            $collection->syncBackingStock(-1);

            return $newLoan;
        });

        // Catat Log Aktivitas (Fase 6)
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Mencatat peminjaman baru untuk anggota: ' . $member->name . ' (Koleksi: "' . ($loan->collection->display_title ?? 'Koleksi') . '")',
        ]);

        // Kirim Notifikasi WhatsApp (Fase 6)
        try {
            $loan->load(['user', 'collection.book']);
            if ($loan->user && !empty($loan->user->no_hp)) {
                $judulBuku = $loan->collection->display_title ?? 'Koleksi Perpustakaan';
                $namaAnggota = $loan->user->name;
                $tglPinjam = \Carbon\Carbon::parse($loan->tgl_pinjam)->translatedFormat('d M Y');
                $btsWaktu = \Carbon\Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y');
                $senderName = \App\Models\AppSetting::get('wa_sender_name', 'Perpustakaan PSDKU POLNEP');

                $message = "Halo, {$namaAnggota}! 📚\n\n" .
                           "Peminjaman buku baru Anda telah berhasil dicatat.\n\n" .
                           "Detail Peminjaman:\n" .
                           "• Judul Buku: *{$judulBuku}*\n" .
                           "• Tanggal Pinjam: {$tglPinjam}\n" .
                           "• Batas Pengembalian: *{$btsWaktu}*\n\n" .
                           "Mohon kembalikan tepat waktu untuk menghindari denda.\n\n" .
                           "Terima kasih — {$senderName}";

                \App\Services\WhatsAppService::send($loan->user->no_hp, $message);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Gagal mengirim WA Peminjaman Baru: " . $e->getMessage());
        }

        return redirect()
            ->route('petugas.loans.index')
            ->with('success', 'Transaksi peminjaman baru berhasil disimpan.');
    }
}
