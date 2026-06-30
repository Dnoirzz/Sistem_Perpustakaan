<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recommendations = Recommendation::where('user_id', $user->user_id)
            ->latest()
            ->paginate(10);

        $rolePrefix = $user->isDosen() ? 'dosen' : 'mahasiswa';

        return view($rolePrefix . '.recommendations.index', [
            'recommendations' => $recommendations,
            'rolePrefix' => $rolePrefix,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $rolePrefix = $user->isDosen() ? 'dosen' : 'mahasiswa';

        return view($rolePrefix . '.recommendations.create', [
            'rolePrefix' => $rolePrefix,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'reason' => 'nullable|string',
        ]);

        $user = Auth::user();

        $recommendation = Recommendation::create([
            'user_id' => $user->user_id,
            'title' => $request->title,
            'author' => $request->author,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => $user->user_id,
            'activity' => 'Mengusulkan buku baru: "' . $request->title . '"',
        ]);

        $rolePrefix = $user->isDosen() ? 'dosen' : 'mahasiswa';

        return redirect()->route($rolePrefix . '.recommendations.index')
            ->with('success', 'Usulan buku berhasil dikirim dan sedang menunggu persetujuan petugas.');
    }
}
