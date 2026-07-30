<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Services\PdfPreviewService;
use App\Support\ArsipDigital;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArsipController extends Controller
{
    public function __construct(
        protected PdfPreviewService $pdfPreviewService
    ) {
    }

    public function index()
    {
        $mahasiswa = $this->currentMahasiswa();
        $archives = ArsipDigital::studentHistory($mahasiswa->mhs_id);
        $typeOptions = ArsipDigital::typeOptions();

        return view('mahasiswa.arsip.index', compact('archives', 'typeOptions'));
    }

    public function store(Request $request)
    {
        $mahasiswa = $this->currentMahasiswa();
        $validated = $this->validateArchive($request, true);
        $type = $validated['type'];
        $definition = ArsipDigital::definition($type);
        $payload = ArsipDigital::buildPayload($type, $validated);

        $payload['mahasiswa_id'] = $mahasiswa->mhs_id;
        $payload['file_pdf'] = $this->storeUploadedFile($request, 'file_pdf', 'private/arsip/full');
        $payload['file_word'] = $request->hasFile('file_word')
            ? $this->storeUploadedFile($request, 'file_word', 'private/arsip/word')
            : null;
        $payload['preview_pdf'] = $this->pdfPreviewService->generate($payload['file_pdf']);
        $payload['status'] = ArsipDigital::STATUS_PENDING;
        $payload['catatan_petugas'] = null;

        $definition['model']::create($payload);

        return redirect()
            ->route('mahasiswa.arsip.index')
            ->with('success', 'Arsip berhasil dikirim dan sedang menunggu verifikasi petugas.');
    }

    public function edit(string $type, int $id)
    {
        $archive = $this->findOwnedArchive($type, $id);
        $this->ensureEditable($archive);

        return view('mahasiswa.arsip.edit', [
            'archive' => $archive,
            'archiveType' => $type,
            'archiveTitle' => ArsipDigital::title($archive),
            'typeLabel' => ArsipDigital::definition($type)['label'],
        ]);
    }

    public function update(Request $request, string $type, int $id)
    {
        $archive = $this->findOwnedArchive($type, $id);
        $this->ensureEditable($archive);

        $validated = $this->validateArchive($request, false);
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

        $payload['status'] = ArsipDigital::STATUS_PENDING;
        $payload['catatan_petugas'] = null;
        $payload['surat_tanda_terima_pdf'] = null;
        $payload['nomor_surat'] = null;
        $payload['verified_at'] = null;
        $payload['received_at'] = null;

        $archive->update($payload);

        return redirect()
            ->route('mahasiswa.arsip.index')
            ->with('success', 'Arsip berhasil diperbarui dan dikirim ulang untuk verifikasi.');
    }

    public function destroy(string $type, int $id)
    {
        $archive = $this->findOwnedArchive($type, $id);
        $this->ensureEditable($archive);

        $this->deleteArchiveFiles($archive);
        $archive->delete();

        return redirect()
            ->route('mahasiswa.arsip.index')
            ->with('success', 'Arsip berhasil dihapus.');
    }

    protected function currentMahasiswa()
    {
        $mahasiswa = Auth::user()?->mahasiswa;

        abort_if(! $mahasiswa, 403, 'Profil mahasiswa tidak ditemukan.');

        return $mahasiswa;
    }

    protected function findOwnedArchive(string $type, int $id): Model
    {
        $archive = ArsipDigital::findOrFail($type, $id, ['mahasiswa.user', 'mahasiswa.prodi', 'collection']);

        abort_if($archive->mahasiswa_id !== $this->currentMahasiswa()->mhs_id, 403, 'Anda tidak memiliki akses ke arsip ini.');

        return $archive;
    }

    protected function ensureEditable(Model $archive): void
    {
        abort_unless(in_array($archive->status, ArsipDigital::editableStatuses(), true), 403, 'Arsip ini tidak dapat diubah lagi.');
    }

    protected function validateArchive(Request $request, bool $isCreate): array
    {
        $rules = [
            'judul' => ['required', 'string', 'max:255'],
            'pembimbing' => ['required', 'string', 'max:255'],
            'penguji_1' => ['required_without:penguji_2', 'nullable', 'string', 'max:255'],
            'penguji_2' => ['required_without:penguji_1', 'nullable', 'string', 'max:255'],
            'tahun' => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'file_pdf' => [$isCreate ? 'required' : 'nullable', 'file', 'mimes:pdf', 'max:20480'],
            'file_word' => [$isCreate ? 'required' : 'nullable', 'file', 'mimes:doc,docx', 'max:20480'],
        ];

        if ($isCreate) {
            $rules['type'] = ['required', 'in:' . implode(',', array_keys(ArsipDigital::definitions()))];
        }

        $type = $isCreate ? $request->input('type') : $request->route('type');

        if ($type === 'laporan-pkl') {
            $rules['nama_tempat_pkl'] = ['required', 'string', 'max:255'];
        } else {
            $rules['nama_tempat_pkl'] = ['nullable', 'string', 'max:255'];
        }

        return $request->validate($rules, [
            'type.required' => 'Jenis arsip wajib dipilih.',
            'judul.required' => 'Judul arsip wajib diisi.',
            'pembimbing.required' => 'Nama dosen pembimbing wajib diisi.',
            'penguji_1.required_without' => 'Isikan minimal satu penguji',
            'penguji_2.required_without' => 'Isikan minimal satu penguji',
            'tahun.required' => 'Tahun terbit wajib diisi.',
            'file_pdf.required' => 'File PDF utama wajib diunggah.',
            'file_pdf.mimes' => 'File utama harus berformat PDF.',
            'file_word.required' => 'File Word wajib diunggah.',
            'file_word.mimes' => 'File pendukung harus berformat DOC atau DOCX.',
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
