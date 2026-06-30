<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
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

        // Cek apakah sudah punya antrian aktif untuk koleksi ini
        $existingQueue = Antrian::where('user_id', $user->user_id)
            ->where('koleksi_id', $koleksiId)
            ->whereIn('status', ['menunggu', 'tersedia'])
            ->exists();

        if ($existingQueue) {
            return back()->with('error', 'Anda sudah terdaftar dalam antrian untuk koleksi ini.');
        }

        // Hitung nomor antrian berikutnya
        $lastNo = Antrian::where('koleksi_id', $koleksiId)->max('no_antrian') ?? 0;

        Antrian::create([
            'user_id' => $user->user_id,
            'koleksi_id' => $koleksiId,
            'no_antrian' => $lastNo + 1,
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Anda berhasil masuk antrian! Nomor antrian Anda: ' . ($lastNo + 1));
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

        if ($user->isDosen()) {
            return view('dosen.antrian.index', compact('antrianList'));
        }

        return view('mahasiswa.antrian.index', compact('antrianList'));
    }
}
