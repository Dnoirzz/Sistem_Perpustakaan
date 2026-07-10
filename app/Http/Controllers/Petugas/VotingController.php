<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Voting;
use App\Models\VotingItem;
use App\Models\ActivityLog;
use App\Models\Recommendation;
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

        // Urutkan kandidat berdasarkan suara terbanyak
        $voting->setRelation('votingItems', $voting->votingItems->sortByDesc(function ($item) {
            return $item->votes->count();
        }));

        return view('petugas.voting.show', compact('voting', 'totalSessionVotes'));
    }

    public function selectRecommendations(Request $request, $id)
    {
        $voting = Voting::findOrFail($id);
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'latest');

        // Ambil ID rekomendasi yang sudah didaftarkan pada sesi voting ini agar tidak double
        $existingRekomendasiIds = $voting->votingItems->pluck('rekomendasi_id')->filter()->toArray();

        // Query usulan yang belum terdaftar di sesi ini, berstatus pending atau disetujui
        // Load relasi votingItems.voting untuk mendeteksi riwayat sesi voting lain
        $query = Recommendation::with(['user', 'votingItems.voting'])
            ->whereNotIn('rekomendasi_id', $existingRekomendasiIds)
            ->whereIn('status', ['pending', 'disetujui'])
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
                });
            });

        if ($sortBy === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sortBy === 'title_asc') {
            $query->orderBy('title', 'asc');
        } elseif ($sortBy === 'title_desc') {
            $query->orderBy('title', 'desc');
        } else {
            $query->latest(); // Default: terbaru
        }

        $recommendations = $query->paginate(15);

        return view('petugas.voting.select-recommendations', compact('voting', 'recommendations', 'search', 'sortBy'));
    }

    public function addRecommendationsBatch(Request $request, $id)
    {
        $request->validate([
            'rekomendasi_ids' => 'required|array',
            'rekomendasi_ids.*' => 'exists:recommendations,rekomendasi_id',
        ]);

        $voting = Voting::findOrFail($id);
        $addedCount = 0;

        \DB::transaction(function () use ($voting, $request, &$addedCount) {
            foreach ($request->rekomendasi_ids as $recId) {
                $exists = VotingItem::where('voting_id', $voting->voting_id)
                    ->where('rekomendasi_id', $recId)
                    ->exists();

                if (!$exists) {
                    $recommendation = Recommendation::find($recId);
                    if ($recommendation->status !== 'disetujui') {
                        $recommendation->update(['status' => 'disetujui']);
                    }

                    VotingItem::create([
                        'voting_id' => $voting->voting_id,
                        'rekomendasi_id' => $recId,
                    ]);
                    $addedCount++;
                }
            }
        });

        // Catat log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menambahkan ' . $addedCount . ' usulan buku secara batch ke sesi voting: ' . $voting->title,
        ]);

        return redirect()->route('petugas.voting.show', $voting->voting_id)
            ->with('success', $addedCount . ' kandidat buku usulan berhasil ditambahkan.');
    }

    public function addManual(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
        ]);

        $voting = Voting::findOrFail($id);

        // Buat usulan baru buatan petugas/instansi
        $recommendation = Recommendation::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'author' => $request->author,
            'reason' => 'Permintaan Instansi',
            'status' => 'disetujui',
        ]);

        // Hubungkan ke voting item
        VotingItem::create([
            'voting_id' => $id,
            'rekomendasi_id' => $recommendation->rekomendasi_id,
        ]);

        // Catat log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menambahkan buku instansi "' . $recommendation->title . '" secara manual ke sesi voting: ' . $voting->title,
        ]);

        return back()->with('success', 'Buku instansi berhasil ditambahkan secara manual sebagai kandidat voting.');
    }

    public function removeItem($id, $itemId)
    {
        $voting = Voting::findOrFail($id);
        $votingItem = VotingItem::with('recommendation')->where('voting_id', $id)->findOrFail($itemId);
        $title = $votingItem->recommendation?->title ?: 'Buku';

        // Hapus vote terkait terlebih dahulu
        $votingItem->votes()->delete();

        // Hapus voting item
        $votingItem->delete();

        // Catat log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Menghapus kandidat buku "' . $title . '" dari sesi voting: ' . $voting->title,
        ]);

        return back()->with('success', 'Kandidat buku berhasil dihapus dari sesi voting.');
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
