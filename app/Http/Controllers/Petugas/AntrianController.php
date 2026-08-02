<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    /**
     * Tampilkan daftar semua antrian.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Antrian::with([
            'user.role',
            'user.mahasiswa',
            'user.dosen',
            'collection.book',
        ]);

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                            $mq->where('nim', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dosen', function ($dq) use ($search) {
                            $dq->where('nip', 'like', "%{$search}%");
                        });
                })->orWhereHas('collection.book', function ($bq) use ($search) {
                    $bq->where('judul', 'like', "%{$search}%");
                });
            });
        }

        $antrianList = $query
            ->orderByRaw("CASE WHEN status = 'tersedia' THEN 0 WHEN status = 'menunggu' THEN 1 ELSE 2 END")
            ->orderBy('no_antrian')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'waiting' => Antrian::where('status', 'menunggu')->count(),
            'available' => Antrian::where('status', 'tersedia')->count(),
            'done' => Antrian::where('status', 'selesai')->count(),
        ];

        return view('petugas.antrian.index', compact('antrianList', 'stats', 'search', 'status'));
    }

    /**
     * Tandai antrian sebagai selesai.
     */
    public function markDone($antrian_id)

    {
        $result = DB::transaction(function () use ($antrian_id) {
            $antrianRef = Antrian::query()->whereKey($antrian_id)->firstOrFail();

            // Keep this in the same lock order as all other queue operations.
            Collection::query()
                ->whereKey($antrianRef->koleksi_id)
                ->lockForUpdate()
                ->first();

            $antrian = Antrian::query()
                ->whereKey($antrian_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($antrian->status === 'selesai') {
                return false;
            }

            $antrian->update(['status' => 'selesai']);

            return true;
        });

        if (! $result) {
            return redirect()
                ->route('petugas.antrian.index')
                ->with('error', 'Antrian ini sudah selesai.');
        }

        return redirect()
            ->route('petugas.antrian.index')
            ->with('success', 'Antrian berhasil ditandai sebagai selesai.');
    }
}
