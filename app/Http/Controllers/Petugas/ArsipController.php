<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Mail\SuratTandaTerimaMail;
use App\Models\Antrian;
use App\Models\Booking;
use App\Models\Collection;
use App\Models\Loan;
use App\Services\PdfPreviewService;
use App\Services\SuratTandaTerimaService;
use App\Support\ArsipDigital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArsipController extends Controller
{
    public function __construct(
        protected PdfPreviewService $pdfPreviewService,
        protected SuratTandaTerimaService $suratTandaTerimaService
    ) {
    }

    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $type = $request->string('type')->toString();
        $search = $request->string('search')->toString();

        $archives = collect(ArsipDigital::definitions())
            ->flatMap(function (array $definition, string $archiveType) use ($status, $type, $search) {
                if ($type !== '' && $type !== $archiveType) {
                    return collect();
                }

                $titleField = $definition['title_field'];
                $query = $definition['model']::with(['mahasiswa.user', 'mahasiswa.prodi', 'collection']);

                if ($status !== '') {
                    $query->where('status', $status);
                }

                if ($search !== '') {
                    $query->where(function ($builder) use ($search, $titleField) {
                        $builder->where($titleField, 'like', "%{$search}%")
                            ->orWhere('pembimbing', 'like', "%{$search}%")
                            ->orWhereHas('mahasiswa.user', function ($userQuery) use ($search) {
                                $userQuery->where('name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('mahasiswa', function ($mhsQuery) use ($search) {
                                $mhsQuery->where('nim', 'like', "%{$search}%");
                            });
                    });
                }

                return $query->get()->map(fn (Model $archive) => ArsipDigital::toSummary($archive, $archiveType));
            })
            ->sortByDesc('created_at')
            ->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
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

        return view('petugas.arsip.index', [
            'archives' => $paginated,
            'typeOptions' => ArsipDigital::typeOptions(),
            'statusOptions' => ArsipDigital::statuses(),
            'selectedType' => $type,
            'selectedStatus' => $status,
            'search' => $search,
        ]);
    }

    public function show(string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id, ['mahasiswa.user', 'mahasiswa.prodi', 'collection']);

        return view('petugas.arsip.show', [
            'archive' => $archive,
            'archiveType' => $type,
            'typeDefinition' => ArsipDigital::definition($type),
            'archiveTitle' => ArsipDigital::title($archive),
        ]);
    }

    public function verify(string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id, ['mahasiswa.user', 'mahasiswa.prodi']);

        if ($archive->status !== ArsipDigital::STATUS_PENDING) {
            return back()->with('error', 'Hanya arsip dengan status pending yang dapat diverifikasi.');
        }

        DB::transaction(function () use ($archive) {
            $archive->update([
                'status' => ArsipDigital::STATUS_DIVERIFIKASI,
                'catatan_petugas' => null,
                'verified_at' => now(),
            ]);

            $result = $this->suratTandaTerimaService->generate($archive->fresh(['mahasiswa.user', 'mahasiswa.prodi']));

            $archive->update([
                'surat_tanda_terima_pdf' => $result['path'],
                'nomor_surat' => $result['nomor_surat'],
                'verified_at' => $result['verified_at'],
            ]);
        });

        $archive->refresh();

        $recipientEmail = $archive->mahasiswa?->user?->email;

        if (! $recipientEmail) {
            return back()->with('error', 'Arsip sudah diverifikasi, tetapi email mahasiswa belum tersedia sehingga surat belum bisa dikirim.');
        }

        try {
            Mail::to($recipientEmail)->send(new SuratTandaTerimaMail(
                recipientName: $archive->mahasiswa?->user?->name ?? 'Mahasiswa',
                jenisArsip: ArsipDigital::definition($type)['full_label'],
                judulArsip: ArsipDigital::title($archive),
                nomorSurat: $archive->nomor_surat ?? '-',
                attachmentPath: $archive->surat_tanda_terima_pdf ?? ''
            ));
        } catch (\Throwable $throwable) {
            Log::warning('Gagal mengirim email surat tanda terima: ' . $throwable->getMessage());

            return back()->with('error', 'Arsip sudah diverifikasi, tetapi pengiriman email surat tanda terima gagal.');
        }

        return back()->with('success', 'Arsip berhasil diverifikasi dan surat tanda terima telah dikirim melalui email.');
    }

    public function reject(Request $request, string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id);

        if ($archive->status === ArsipDigital::STATUS_AKTIF) {
            return back()->with('error', 'Arsip yang sudah aktif tidak dapat ditolak.');
        }

        $validated = $request->validate([
            'catatan_petugas' => ['required', 'string', 'max:1000'],
        ], [
            'catatan_petugas.required' => 'Catatan penolakan wajib diisi.',
        ]);

        if ($archive->collection) {
            $archive->collection()->delete();
        }

        $archive->update([
            'status' => ArsipDigital::STATUS_DITOLAK,
            'catatan_petugas' => $validated['catatan_petugas'],
            'received_at' => null,
        ]);

        return back()->with('success', 'Arsip berhasil ditandai sebagai ditolak.');
    }

    public function confirmReceipt(string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id, ['collection']);

        if ($archive->status !== ArsipDigital::STATUS_DIVERIFIKASI) {
            return back()->with('error', 'Hanya arsip diverifikasi yang dapat dikonfirmasi fisiknya.');
        }

        DB::transaction(function () use ($archive, $type) {
            Collection::updateOrCreate(
                [
                    'item_type' => ArsipDigital::itemType($type),
                    'item_id' => $archive->getKey(),
                ],
                [
                    'stock' => 1,
                ]
            );

            $archive->update([
                'status' => ArsipDigital::STATUS_AKTIF,
                'received_at' => now(),
            ]);
        });

        return back()->with('success', 'Dokumen fisik sudah diterima dan arsip kini aktif untuk sirkulasi.');
    }

    public function edit(string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id, ['mahasiswa.user', 'mahasiswa.prodi']);

        return view('petugas.arsip.edit', [
            'archive' => $archive,
            'archiveType' => $type,
            'typeLabel' => ArsipDigital::definition($type)['label'],
            'archiveTitle' => ArsipDigital::title($archive),
        ]);
    }

    public function update(Request $request, string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id);
        $validated = $this->validateArchive($request, $type);
        $payload = ArsipDigital::buildPayload($type, $validated);

        if ($request->hasFile('file_pdf')) {
            $this->deleteFileIfExists($archive->file_pdf);
            $this->deleteFileIfExists($archive->preview_pdf);
            $payload['file_pdf'] = $this->storeUploadedFile($request, 'file_pdf', 'private/arsip/full');
            $payload['preview_pdf'] = $this->pdfPreviewService->generate($payload['file_pdf']);
        }

        if ($request->hasFile('file_word')) {
            $this->deleteFileIfExists($archive->file_word);
            $payload['file_word'] = $this->storeUploadedFile($request, 'file_word', 'private/arsip/word');
        }

        $archive->update($payload);

        return redirect()
            ->route('petugas.arsip.show', [$type, $archive->getKey()])
            ->with('success', 'Data arsip berhasil diperbarui.');
    }

    public function destroy(string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id, ['collection']);
        $collection = $archive->collection;

        if ($collection) {
            $hasActiveLoan = Loan::query()
                ->where('koleksi_id', $collection->koleksi_id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->exists();
            $hasActiveBooking = Booking::query()
                ->where('koleksi_id', $collection->koleksi_id)
                ->whereIn('status', ['pending', 'disetujui'])
                ->exists();
            $hasActiveQueue = Antrian::query()
                ->where('koleksi_id', $collection->koleksi_id)
                ->whereIn('status', ['menunggu', 'tersedia'])
                ->exists();

            if ($hasActiveLoan || $hasActiveBooking || $hasActiveQueue) {
                return back()->with('error', 'Arsip tidak dapat dihapus karena masih terlibat transaksi atau antrian aktif.');
            }
        }

        $this->deleteArchiveFiles($archive);
        $archive->delete();

        return redirect()
            ->route('petugas.arsip.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }

    public function download(Request $request, string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id);
        $kind = $request->string('kind')->toString() ?: 'pdf';
        $path = $kind === 'word' ? $archive->file_word : $archive->file_pdf;

        abort_unless($path && Storage::disk('local')->exists($path), 404, 'File tidak ditemukan.');

        return response()->download(storage_path('app/' . $path));
    }

    public function downloadSurat(string $type, int $id)
    {
        $archive = ArsipDigital::findOrFail($type, $id);
        $path = $archive->surat_tanda_terima_pdf;

        abort_unless($path && Storage::disk('local')->exists($path), 404, 'Surat tanda terima belum tersedia.');

        return response()->download(storage_path('app/' . $path));
    }

    protected function validateArchive(Request $request, string $type): array
    {
        $rules = [
            'judul' => ['required', 'string', 'max:255'],
            'pembimbing' => ['nullable', 'string', 'max:255'],
            'penguji_1' => ['nullable', 'string', 'max:255'],
            'penguji_2' => ['nullable', 'string', 'max:255'],
            'tahun' => ['nullable', 'digits:4', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'file_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'file_word' => ['nullable', 'file', 'mimes:doc,docx', 'max:20480'],
        ];

        if ($type === 'laporan-pkl') {
            $rules['nama_tempat_pkl'] = ['required', 'string', 'max:255'];
        } else {
            $rules['nama_tempat_pkl'] = ['nullable', 'string', 'max:255'];
        }

        return $request->validate($rules, [
            'nama_tempat_pkl.required' => 'Nama tempat PKL wajib diisi.',
        ]);
    }

    protected function storeUploadedFile(Request $request, string $field, string $directory): string
    {
        $file = $request->file($field);
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($directory, $filename, 'local');
    }

    protected function deleteArchiveFiles(Model $archive): void
    {
        foreach ([
            $archive->file_pdf,
            $archive->file_word,
            $archive->preview_pdf,
            $archive->surat_tanda_terima_pdf,
        ] as $path) {
            $this->deleteFileIfExists($path);
        }
    }

    protected function deleteFileIfExists(?string $path): void
    {
        if ($path && Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
        }
    }
}
