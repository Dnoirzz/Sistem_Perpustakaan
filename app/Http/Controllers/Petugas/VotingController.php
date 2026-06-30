<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Voting;
use App\Models\VotingItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    /**
     * Display a listing of the voting sessions.
     */
    public function index()
    {
        $votings = Voting::with('votingItems.votes')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('petugas.voting.index', compact('votings'));
    }

    /**
     * Show the form for creating a new voting session.
     */
    public function create()
    {
        return view('petugas.voting.create');
    }

    /**
     * Store a newly created voting session in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $voting = Voting::create([
            'title' => $request->title,
            'deskripsi' => $request->deskripsi,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'created_by' => Auth::id(),
        ]);

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Membuat sesi voting pengadaan buku baru: ' . $voting->title,
        ]);

        return redirect()->route('petugas.voting.index')
            ->with('success', 'Sesi voting pengadaan buku berhasil dibuat.');
    }

    /**
     * Display the specified voting session details and results.
     */
    public function show($id)
    {
        $voting = Voting::with(['votingItems.recommendation.user', 'votingItems.votes.user'])
            ->findOrFail($id);

        // Hitung total suara masuk dalam sesi ini
        $totalSessionVotes = $voting->votingItems->sum(function ($item) {
            return $item->votes->count();
        });

        return view('petugas.voting.show', compact('voting', 'totalSessionVotes'));
    }

    /**
     * Remove the specified voting session from storage.
     */
    public function destroy($id)
    {
        $voting = Voting::findOrFail($id);
        $title = $voting->title;

        $voting->delete();

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menghapus sesi voting pengadaan buku: ' . $title,
        ]);

        return redirect()->route('petugas.voting.index')
            ->with('success', 'Sesi voting berhasil dihapus.');
    }
}
