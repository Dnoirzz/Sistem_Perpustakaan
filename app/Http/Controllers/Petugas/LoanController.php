<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Collection;
use App\Models\Loan;
use App\Models\User;
use App\Support\ArsipDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    private const COLLECTION_TYPE_OPTIONS = [
        'book' => 'Buku Umum',
        'laporan_pkl' => 'Laporan PKL',
        'proposal_ta' => 'Proposal TA',
        'laporan_ta' => 'Laporan TA',
    ];

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
            if ($status === 'dipinjam' || $status === 'aktif') {
                $query->whereIn('status', ['dipinjam', 'terlambat']);
            } else {
                $query->where('status', $status);
            }
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
            'available_books' => Collection::sum('stock'),
        ];

        return view('petugas.loans.index', compact('loans', 'stats', 'search', 'status'));
    }

    public function create(Request $request)
    {
        Loan::syncOverdueStatuses();

        $collectionTypes = self::COLLECTION_TYPE_OPTIONS;

        $selectedUserId = old('user_id', $request->input('user_id'));
        $members = collect();
        if ($selectedUserId) {
            $selectedMember = User::where('user_id', $selectedUserId)
                ->with(['role', 'mahasiswa.prodi', 'dosen.prodi'])
                ->first();
            if ($selectedMember) {
                $members = collect([$selectedMember]);
            }
        }

        $reqKoleksiId = $request->input('koleksi_id');
        $oldCollectionIds = old('koleksi_ids', old('koleksi_id') ? [old('koleksi_id')] : ($reqKoleksiId ? [$reqKoleksiId] : []));
        $collections = collect();
        if (!empty($oldCollectionIds)) {
            $collections = Collection::with(['book.category'])
                ->whereIn('koleksi_id', (array) $oldCollectionIds)
                ->get();
        }


        $stockSummary = [
            'book' => Collection::where('item_type', 'book')->sum('stock'),
            'laporan_pkl' => Collection::where('item_type', 'laporan_pkl')->sum('stock'),
            'proposal_ta' => Collection::where('item_type', 'proposal_ta')->sum('stock'),
            'laporan_ta' => Collection::where('item_type', 'laporan_ta')->sum('stock'),
        ];

        return view('petugas.loans.create', compact('members', 'collections', 'collectionTypes', 'stockSummary'));
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
        $type = $request->input('type');
        if (empty($q)) {
            return response()->json([]);
        }

        $collections = Collection::with(['book.category'])
            ->when(array_key_exists($type, self::COLLECTION_TYPE_OPTIONS), function ($query) use ($type) {
                $query->where('item_type', $type);
            })
            ->get()
            ->filter(function (Collection $collection) use ($q) {
                $haystack = strtolower(
                    $collection->display_title . ' ' .
                    $collection->display_type_label . ' ' .
                    ($collection->book?->author ?? '')
                );

                return str_contains($haystack, strtolower($q));
            })
            ->take(5)
            ->values()
            ->map(function (Collection $collection) {
                return [
                    'koleksi_id' => $collection->koleksi_id,
                    'judul' => $collection->display_title,
                    'author' => $collection->book?->author ?? '',
                    'type_label' => $collection->display_type_label,
                    'stock' => $collection->stock,
                    'is_available' => $collection->stock > 0,
                    'judul_display' => $collection->display_title . ' - ' . $collection->display_type_label . ' (Stok: ' . $collection->stock . ')',
                ];
            });

        return response()->json($collections);
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        if (!$request->has('koleksi_ids') && $request->has('koleksi_id')) {
            $requestData['koleksi_ids'] = [$request->input('koleksi_id')];
        }

        $validator = \Illuminate\Support\Facades\Validator::make($requestData, [
            'user_id' => ['required', 'exists:users,user_id'],
            'koleksi_ids' => ['required', 'array', 'min:1'],
            'koleksi_ids.*' => ['required', 'exists:collections,koleksi_id'],
            'tgl_pinjam' => ['required', 'date'],
            'bts_waktu' => ['required', 'date', 'after_or_equal:tgl_pinjam'],
        ], [
            'user_id.required' => 'Anggota peminjam wajib dipilih.',
            'user_id.exists' => 'Anggota yang dipilih tidak valid.',
            'koleksi_ids.required' => 'Minimal 1 koleksi yang dipinjam wajib dipilih.',
            'koleksi_ids.array' => 'Daftar koleksi tidak valid.',
            'koleksi_ids.min' => 'Minimal 1 koleksi yang dipinjam wajib dipilih.',
            'koleksi_ids.*.exists' => 'Koleksi yang dipilih tidak ditemukan.',
            'tgl_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'bts_waktu.required' => 'Batas waktu pengembalian wajib diisi.',
            'bts_waktu.after_or_equal' => 'Batas waktu harus sama atau setelah tanggal pinjam.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $member = User::with('role')->findOrFail($validated['user_id']);

        if (!$member->role || !in_array($member->role->role_name, ['mahasiswa', 'dosen'], true)) {
            throw ValidationException::withMessages([
                'user_id' => 'Peminjaman hanya dapat dibuat untuk anggota mahasiswa atau dosen.',
            ]);
        }

        $koleksiIds = array_values(array_unique($validated['koleksi_ids']));
        // A stable lock order prevents deadlocks when two multi-item loan
        // requests contain the same collections in different UI order.
        sort($koleksiIds, SORT_NUMERIC);

        $createdLoans = DB::transaction(function () use ($validated, $koleksiIds) {
            $loans = [];
            foreach ($koleksiIds as $koleksiId) {
                $collection = Collection::with('book')
                    ->where('koleksi_id', $koleksiId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($collection->stock < 1) {
                    throw ValidationException::withMessages([
                        'koleksi_ids' => 'Stok koleksi "' . $collection->display_title . '" sudah habis. Silakan pilih koleksi lain.',
                    ]);
                }

                $hasActiveLoan = Loan::where('user_id', $validated['user_id'])
                    ->where('koleksi_id', $collection->koleksi_id)
                    ->whereIn('status', ['dipinjam', 'terlambat'])
                    ->exists();

                if ($hasActiveLoan) {
                    throw ValidationException::withMessages([
                        'koleksi_ids' => 'Anggota ini masih memiliki peminjaman aktif untuk koleksi "' . $collection->display_title . '".',
                    ]);
                }

                $newLoan = Loan::create([
                    'user_id' => $validated['user_id'],
                    'koleksi_id' => $collection->koleksi_id,
                    'tgl_pinjam' => $validated['tgl_pinjam'],
                    'bts_waktu' => $validated['bts_waktu'],
                    'status' => 'dipinjam',
                ]);

                // Tandai antrian aktif milik anggota ini untuk koleksi tersebut sebagai 'selesai'
                Antrian::where('user_id', $validated['user_id'])
                    ->where('koleksi_id', $collection->koleksi_id)
                    ->whereIn('status', ['menunggu', 'tersedia'])
                    ->update(['status' => 'selesai']);

                $collection->syncBackingStock(-1);
                $loans[] = $newLoan;
            }

            return $loans;
        });

        $totalLoaned = count($createdLoans);

        // Catat Log Aktivitas (Fase 6)
        $logDetail = $totalLoaned === 1
            ? '"' . ($createdLoans[0]->collection?->display_title ?? 'Koleksi') . '"'
            : $totalLoaned . ' koleksi sekaligus';

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Mencatat peminjaman baru untuk anggota: ' . $member->name . ' (Detail: ' . $logDetail . ')',
        ]);

        // Kirim Notifikasi WhatsApp (Fase 6)
        try {
            if ($member->no_hp) {
                $namaAnggota = $member->name;
                $tglPinjam = \Carbon\Carbon::parse($validated['tgl_pinjam'])->translatedFormat('d M Y');
                $btsWaktu = \Carbon\Carbon::parse($validated['bts_waktu'])->translatedFormat('d M Y');
                $senderName = \App\Models\AppSetting::get('wa_sender_name', 'Perpustakaan PSDKU POLNEP');

                if ($totalLoaned === 1) {
                    $judulBuku = $createdLoans[0]->collection?->display_title ?? 'Koleksi Perpustakaan';
                    $message = "Halo, {$namaAnggota}! 📚\n\n" .
                               "Peminjaman buku baru Anda telah berhasil dicatat.\n\n" .
                               "Detail Peminjaman:\n" .
                               "• Judul Buku: *{$judulBuku}*\n" .
                               "• Tanggal Pinjam: {$tglPinjam}\n" .
                               "• Batas Pengembalian: *{$btsWaktu}*\n\n" .
                               "Mohon kembalikan tepat waktu untuk menghindari denda.\n\n" .
                               "Terima kasih — {$senderName}";
                } else {
                    $bookListLines = [];
                    foreach ($createdLoans as $idx => $l) {
                        $l->load('collection');
                        $num = $idx + 1;
                        $title = $l->collection?->display_title ?? 'Koleksi';
                        $bookListLines[] = "{$num}. *{$title}*";
                    }
                    $bookListText = implode("\n", $bookListLines);

                    $message = "Halo, {$namaAnggota}! 📚\n\n" .
                               "Peminjaman {$totalLoaned} koleksi baru Anda telah berhasil dicatat.\n\n" .
                               "Daftar Koleksi Dipinjam:\n" .
                               "{$bookListText}\n\n" .
                               "• Tanggal Pinjam: {$tglPinjam}\n" .
                               "• Batas Pengembalian: *{$btsWaktu}*\n\n" .
                               "Mohon kembalikan tepat waktu untuk menghindari denda.\n\n" .
                               "Terima kasih — {$senderName}";
                }

                \App\Services\WhatsAppService::send($member->no_hp, $message);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Gagal mengirim WA Peminjaman Baru: " . $e->getMessage());
        }

        // Kirim Notifikasi Telegram (Fase 6)
        try {
            if ($member->telegram_chat_id) {
                $namaAnggota = e($member->name);
                $tglPinjam = \Carbon\Carbon::parse($validated['tgl_pinjam'])->translatedFormat('d M Y');
                $btsWaktu = \Carbon\Carbon::parse($validated['bts_waktu'])->translatedFormat('d M Y');

                if ($totalLoaned === 1) {
                    $judulBuku = e($createdLoans[0]->collection?->display_title ?? 'Koleksi Perpustakaan');
                    $tgMessage = "<b>Halo, {$namaAnggota}!</b> 📚\n\n" .
                                 "Peminjaman buku baru Anda telah berhasil dicatat.\n\n" .
                                 "<b>Detail Peminjaman:</b>\n" .
                                 "• Judul Buku: <b>{$judulBuku}</b>\n" .
                                 "• Tanggal Pinjam: {$tglPinjam}\n" .
                                 "• Batas Pengembalian: <b>{$btsWaktu}</b>\n\n" .
                                 "Mohon kembalikan tepat waktu untuk menghindari denda.\n\n" .
                                 "<i>SIPUS PSDKU POLNEP Sukamara</i>";
                } else {
                    $bookListLines = [];
                    foreach ($createdLoans as $idx => $l) {
                        $l->load('collection');
                        $num = $idx + 1;
                        $title = e($l->collection?->display_title ?? 'Koleksi');
                        $bookListLines[] = "{$num}. <b>{$title}</b>";
                    }
                    $bookListText = implode("\n", $bookListLines);

                    $tgMessage = "<b>Halo, {$namaAnggota}!</b> 📚\n\n" .
                                 "Peminjaman {$totalLoaned} koleksi baru Anda telah berhasil dicatat.\n\n" .
                                 "<b>Daftar Koleksi Dipinjam:</b>\n" .
                                 "{$bookListText}\n\n" .
                                 "• Tanggal Pinjam: {$tglPinjam}\n" .
                                 "• Batas Pengembalian: <b>{$btsWaktu}</b>\n\n" .
                                 "Mohon kembalikan tepat waktu untuk menghindari denda.\n\n" .
                                 "<i>SIPUS PSDKU POLNEP Sukamara</i>";
                }

                \App\Services\TelegramService::send($member->telegram_chat_id, $tgMessage);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning("Gagal mengirim Telegram Peminjaman Baru: " . $e->getMessage());
        }

        // Kirim Notifikasi Sistem Bell
        $btsWaktuFormated = \Carbon\Carbon::parse($validated['bts_waktu'])->translatedFormat('d M Y');
        \App\Models\NotificationCustom::send(
            $member->user_id,
            'Peminjaman Buku Baru',
            "Peminjaman {$totalLoaned} koleksi baru Anda telah dicatat. Batas pengembalian: {$btsWaktuFormated}.",
            route('mahasiswa.loans.active'),
            'sirkulasi'
        );

        $successMsg = $totalLoaned === 1
            ? 'Transaksi peminjaman baru berhasil disimpan.'
            : "Transaksi peminjaman baru sebanyak {$totalLoaned} koleksi berhasil disimpan.";

        return redirect()
            ->route('petugas.loans.index')
            ->with('success', $successMsg);
    }
}
