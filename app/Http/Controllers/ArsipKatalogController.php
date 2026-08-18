<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Support\ArsipDigital;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArsipKatalogController extends Controller
{
    public function index()
    {
        $filters = [
            'search' => request('search'),
            'search_by' => request('search_by'),
            'prodi_id' => request('prodi_id'),
            'year' => request('year'),
        ];

        $type = request('type');
        $archives = ArsipDigital::catalog($filters)
            ->when($type, fn ($collection) => $collection->where('type', $type)->values());

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 12;
        $paginated = new LengthAwarePaginator(
            $archives->forPage($page, $perPage)->values(),
            $archives->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view($this->viewPrefix() . '.katalog-arsip.index', [
            'archives' => $paginated,
            'typeOptions' => ArsipDigital::typeOptions(),
            'prodis' => Prodi::query()->orderBy('nama_prodi')->get(),
            'selectedType' => $type,
        ]);
    }

    public function show(string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id, ['mahasiswa.user', 'mahasiswa.prodi', 'collection']);
        abort_unless(in_array($archive->status, ArsipDigital::catalogStatuses(), true), 404);

        $viewToken = Str::random(40);
        if (Auth::check()) {
            session()->put("pdf_view_token_{$viewToken}", [
                'archive_id' => $archive->getKey(),
                'archive_type' => $type,
                'user_id' => Auth::id(),
                'expires_at' => now()->addMinutes(30)->timestamp,
            ]);
        }

        return view($this->viewPrefix() . '.katalog-arsip.show', [
            'archive' => $archive,
            'archiveType' => $type,
            'typeDefinition' => ArsipDigital::definition($type),
            'archiveTitle' => ArsipDigital::title($archive),
            'viewToken' => $viewToken,
        ]);
    }

    public function preview(string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id);
        abort_unless(in_array($archive->status, ArsipDigital::catalogStatuses(), true), 404);
        abort_unless($archive->preview_pdf && Storage::disk('local')->exists($archive->preview_pdf), 404);

        return response()->file(
            storage_path('app/' . $archive->preview_pdf),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="preview-arsip.pdf"',
            ]
        );
    }

    public function full(string $type, int $id, string $slug = '')
    {
        $viewToken = request('view_token');
        $tokenData = $viewToken ? session("pdf_view_token_{$viewToken}") : null;

        abort_unless(
            $tokenData &&
            $tokenData['archive_id'] == $id &&
            $tokenData['archive_type'] === $type &&
            $tokenData['user_id'] === auth()->id(),
            403,
            'Akses Halaman Pembaca Ditolak: Tautan viewer tidak valid atau disebarkan dari sesi akun lain.'
        );

        abort_if(
            now()->timestamp > ($tokenData['expires_at'] ?? 0),
            403,
            'Akses Halaman Pembaca Ditolak: Tautan viewer telah kadaluarsa.'
        );

        $archive = ArsipDigital::findOrFail($type, $id);
        abort_unless(in_array($archive->status, ArsipDigital::catalogStatuses(), true), 404);
        abort_unless($archive->file_pdf && Storage::disk('local')->exists($archive->file_pdf), 404);

        // Record the reading history
        $log = \App\Models\ArchiveReadLog::create([
            'user_id' => auth()->id(),
            'archive_id' => $archive->getKey(),
            'archive_type' => $type,
        ]);

        $archiveTitle = ArsipDigital::title($archive);
        
        // Generate a temporary access token bound to the current user's session (valid for 15 minutes)
        $token = Str::random(40);
        session()->put("pdf_token_{$token}", [
            'archive_id' => $archive->getKey(),
            'archive_type' => $type,
            'user_id' => auth()->id(),
            'expires_at' => now()->addMinutes(15)->timestamp,
        ]);

        $streamUrl = route('katalog-arsip.stream', [
            'type' => $type,
            'id' => $id,
            'slug' => $slug ?: Str::slug($archiveTitle),
        ]) . '?token=' . $token;

        return view('shared.arsip-pdf-viewer', [
            'logId' => $log->id,
            'archiveTitle' => $archiveTitle,
            'streamUrl' => $streamUrl,
        ]);
    }

    public function stream(Request $request, string $type, int $id, string $slug = '')
    {
        $token = $request->query('token');
        $tokenData = $token ? session("pdf_token_{$token}") : null;

        abort_unless(
            $tokenData &&
            $tokenData['archive_id'] == $id &&
            $tokenData['archive_type'] === $type &&
            $tokenData['user_id'] === auth()->id(),
            403,
            'Akses naskah ditolak: Token tidak valid atau sesi pengguna tidak sesuai.'
        );

        abort_if(
            now()->timestamp > ($tokenData['expires_at'] ?? 0),
            403,
            'Akses naskah ditolak: Token telah kadaluarsa.'
        );

        $archive = ArsipDigital::findOrFail($type, $id);
        abort_unless(in_array($archive->status, ArsipDigital::catalogStatuses(), true), 404);
        abort_unless($archive->file_pdf && Storage::disk('local')->exists($archive->file_pdf), 404);

        $filename = ($slug ?: Str::slug(ArsipDigital::title($archive))) . '.pdf';

        return response()->file(
            storage_path('app/' . $archive->file_pdf),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]
        );
    }

    public function closeReadLog(int $id)
    {
        $log = \App\Models\ArchiveReadLog::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $log->update([
            'finished_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    protected function viewPrefix(): string
    {
        $user = Auth::user();

        return $user->isDosen() ? 'dosen' : 'mahasiswa';
    }
}
