<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Collection;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    /**
     * Daftarkan anggota ke antrian untuk buku yang stoknya habis.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'koleksi_id' => ['required', 'exists:collections,koleksi_id'],
        ], [
            'koleksi_id.required' => 'Koleksi wajib dipilih.',
            'koleksi_id.exists' => 'Koleksi tidak ditemukan.',
        ]);

        $user = Auth::user();
        $koleksiId = $validated['koleksi_id'];

        $errorMessage = null;
        $nextNo = DB::transaction(function () use ($user, $koleksiId, &$errorMessage) {
            // The collection row acts as the per-collection mutex while the
            // duplicate check and next queue number are calculated.
            Collection::query()
                ->whereKey($koleksiId)
                ->lockForUpdate()
                ->firstOrFail();

            $sedangDipinjam = Loan::where('user_id', $user->user_id)
                ->where('koleksi_id', $koleksiId)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->exists();

            if ($sedangDipinjam) {
                $errorMessage = 'Anda sedang meminjam koleksi ini. Silakan kembalikan terlebih dahulu.';
                return null;
            }

            $existingQueue = Antrian::where('user_id', $user->user_id)
                ->where('koleksi_id', $koleksiId)
                ->whereIn('status', ['menunggu', 'tersedia'])
                ->exists();

            if ($existingQueue) {
                $errorMessage = 'Anda sudah terdaftar dalam antrian untuk koleksi ini.';
                return null;
            }

            $lastNo = Antrian::where('koleksi_id', $koleksiId)
                ->whereIn('status', ['menunggu', 'tersedia'])
                ->max('no_antrian') ?? 0;

            $nextNo = $lastNo + 1;

            Antrian::create([
                'user_id' => $user->user_id,
                'koleksi_id' => $koleksiId,
                'no_antrian' => $nextNo,
                'status' => 'menunggu',
            ]);

            return $nextNo;
        });

        if ($nextNo === null) {
            return back()->with('error', $errorMessage ?? 'Pendaftaran antrian tidak dapat dilakukan saat ini.');
        }

        return back()->with('success', 'Anda berhasil masuk antrian! Nomor antrian Anda: ' . $nextNo);
    }

    /**
     * Tampilkan daftar antrian milik anggota yang login.
     */
    public function myAntrian()
    {
        $user = Auth::user();

        $antrianList = Antrian::with(['collection.book'])
            ->where('user_id', $user->user_id)
            ->orderByRaw("CASE WHEN status = 'tersedia' THEN 0 WHEN status = 'menunggu' THEN 1 ELSE 2 END")
            ->orderBy('no_antrian')
            ->paginate(10);

        $antrianList->getCollection()->transform(function ($antrian) {
            if ($antrian->status === 'menunggu') {
                $antrian->people_ahead = Antrian::where('koleksi_id', $antrian->koleksi_id)
                    ->where('status', 'menunggu')
                    ->where('no_antrian', '<', $antrian->no_antrian)
                    ->count();
            } else {
                $antrian->people_ahead = 0;
            }

            return $antrian;
        });

        if ($user->isDosen()) {
            return view('dosen.antrian.index', compact('antrianList'));
        }

        return view('mahasiswa.antrian.index', compact('antrianList'));
    }

    /**
     * Batalkan antrian milik pengguna yang sedang login.
     */
    public function cancel($antrian_id)
    {
        $user = Auth::user();
        $promoteNext = false;
        $koleksiId = DB::transaction(function () use ($antrian_id, $user, &$promoteNext) {
            // Read the collection id first, then always acquire locks in the
            // shared order: collection -> queue row. This matches loan,
            // return, and queue-allocation transactions.
            $antrianRef = Antrian::query()
                ->where('antrian_id', $antrian_id)
                ->where('user_id', $user->user_id)
                ->firstOrFail();

            $collectionId = $antrianRef->koleksi_id;
            $collection = Collection::query()
                ->whereKey($collectionId)
                ->lockForUpdate()
                ->first();

            $antrian = Antrian::query()
                ->where('antrian_id', $antrian_id)
                ->where('user_id', $user->user_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($antrian->status, ['menunggu', 'tersedia'], true)) {
                return null;
            }

            $promoteNext = $antrian->status === 'tersedia' && $collection !== null;
            $antrian->update(['status' => 'dibatalkan']);

            return $collectionId;
        });

        if ($koleksiId === null) {
            return back()->with('error', 'Antrian yang sudah selesai tidak dapat dibatalkan.');
        }

        if ($promoteNext) {
            Antrian::checkAndNotifyAvailableQueue($koleksiId);
        }

        return back()->with('success', 'Antrian berhasil dibatalkan.');
    }
}
