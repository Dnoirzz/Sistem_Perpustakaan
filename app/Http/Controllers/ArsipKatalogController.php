<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Support\ArsipDigital;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArsipKatalogController extends Controller
{
    public function index()
    {
        $filters = [
            'search' => request('search'),
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

        return view($this->viewPrefix() . '.katalog-arsip.show', [
            'archive' => $archive,
            'archiveType' => $type,
            'typeDefinition' => ArsipDigital::definition($type),
            'archiveTitle' => ArsipDigital::title($archive),
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

    protected function viewPrefix(): string
    {
        $user = Auth::user();

        return $user->isDosen() ? 'dosen' : 'mahasiswa';
    }
}
