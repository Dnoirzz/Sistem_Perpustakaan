<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use App\Models\VotingItem;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    /**
     * Display the list of active voting sessions.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Fetch active voting sessions
        $votings = Voting::with(['votingItems.recommendation.user', 'votingItems.votes'])
            ->where('tgl_mulai', '<=', now()->toDateString())
            ->where('tgl_selesai', '>=', now()->toDateString())
            ->get();

        foreach ($votings as $voting) {
            $voting->setRelation('votingItems', $voting->votingItems->sortByDesc(function ($item) {
                return $item->votes->count();
            }));
        }

        // Pluck the IDs of items this user has voted for
        $userVotes = Vote::where('user_id', $user->user_id)
            ->pluck('voting_item_id')
            ->toArray();

        if ($user->isMahasiswa()) {
            return view('mahasiswa.voting', compact('votings', 'userVotes'));
        } elseif ($user->isDosen()) {
            return view('dosen.voting', compact('votings', 'userVotes'));
        }

        abort(403, 'Akses ditolak.');
    }

    /**
     * Cast or toggle a vote on a candidate book.
     */
    public function vote(Request $request, $voting_item_id)
    {
        $user = Auth::user();
        $votingItem = VotingItem::with('voting')->findOrFail($voting_item_id);

        // Ensure the voting session is active
        if (!$votingItem->voting->isActive()) {
            return back()->with('error', 'Sesi voting ini sudah berakhir atau belum dimulai.');
        }

        // Toggle vote: if exists, delete it (cancel vote). If not, create it.
        $vote = Vote::where('voting_item_id', $votingItem->voting_item_id)
            ->where('user_id', $user->user_id)
            ->first();

        if ($vote) {
            $vote->delete();
            return back()->with('success', 'Pilihan suara Anda berhasil dibatalkan.');
        } else {
            Vote::create([
                'voting_item_id' => $votingItem->voting_item_id,
                'user_id' => $user->user_id,
            ]);
            return back()->with('success', 'Suara Anda berhasil disimpan.');
        }
    }
}
