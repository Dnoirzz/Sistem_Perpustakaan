<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Cek apakah pengguna sedang meminjam koleksi ini
        $sedangDipinjam = Loan::where('user_id', $user->user_id)
            ->where('koleksi_id', $koleksiId)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($sedangDipinjam) {
            return back()->with('error', 'Anda sedang meminjam koleksi ini. Silakan kembalikan terlebih dahulu.');
        }

        // Cek apakah sudah punya antrian aktif untuk koleksi ini
        $existingQueue = Antrian::where('user_id', $user->user_id)
            ->where('koleksi_id', $koleksiId)
            ->whereIn('status', ['menunggu', 'tersedia'])
            ->exists();

        if ($existingQueue) {
            return back()->with('error', 'Anda sudah terdaftar dalam antrian untuk koleksi ini.');
        }

        // Hitung nomor antrian berikutnya (reset ke 1 jika tidak ada antrian aktif)
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
        $antrian = Antrian::where('antrian_id', $antrian_id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        if (! in_array($antrian->status, ['menunggu', 'tersedia'], true)) {
            return back()->with('error', 'Antrian yang sudah selesai tidak dapat dibatalkan.');
        }

        $koleksiId = $antrian->koleksi_id;
        $oldStatus = $antrian->status;

        $antrian->update(['status' => 'dibatalkan']);

        // Jika antrian yang dibatalkan sebelumnya berstatus 'tersedia',
        // alokasikan giliran ketersediaan ke pendaftar antrian berikutnya
        if ($oldStatus === 'tersedia') {
            Antrian::checkAndNotifyAvailableQueue($koleksiId);
        }

        return back()->with('success', 'Antrian berhasil dibatalkan.');
    }
}

