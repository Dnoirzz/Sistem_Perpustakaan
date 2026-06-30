<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use App\Models\Voting;
use App\Models\VotingItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        
        $recommendations = Recommendation::with('user')
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        // Ambil sesi voting aktif untuk dropdown "Masukkan ke Voting"
        $activeVotings = Voting::where('tgl_selesai', '>=', now()->toDateString())
            ->orderBy('tgl_selesai', 'asc')
            ->get();

        return view('petugas.recommendations.index', [
            'recommendations' => $recommendations,
            'activeVotings' => $activeVotings,
            'selectedStatus' => $status,
        ]);
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'voting_id' => 'nullable|exists:votings,voting_id',
        ]);

        $recommendation = Recommendation::findOrFail($id);
        $recommendation->update([
            'status' => $request->status,
        ]);

        // Jika disetujui dan ada voting_id yang dipilih, masukkan ke voting_items
        if ($request->status === 'disetujui' && $request->voting_id) {
            // Cek apakah sudah terdaftar di voting ini
            $exists = VotingItem::where('voting_id', $request->voting_id)
                ->where('rekomendasi_id', $recommendation->rekomendasi_id)
                ->exists();

            if (!$exists) {
                VotingItem::create([
                    'voting_id' => $request->voting_id,
                    'rekomendasi_id' => $recommendation->rekomendasi_id,
                ]);
            }
        }

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Memproses usulan buku "' . $recommendation->title . '" menjadi: ' . strtoupper($request->status),
        ]);

        return back()->with('success', 'Status usulan buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $recommendation = Recommendation::findOrFail($id);
        $title = $recommendation->title;
        $recommendation->delete();

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menghapus usulan buku "' . $title . '"',
        ]);

        return back()->with('success', 'Usulan buku berhasil dihapus.');
    }
}
