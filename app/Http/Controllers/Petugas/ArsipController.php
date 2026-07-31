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
use App\Models\User;
use App\Models\Role;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\ActivityLog;
use App\Models\LaporanPkl;
use App\Models\ProposalTa;
use App\Models\LaporanTugasAkhir;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


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

        $statusPriority = [
            ArsipDigital::STATUS_PENDING => 1,
            ArsipDigital::STATUS_DIVERIFIKASI => 2,
            ArsipDigital::STATUS_AKTIF => 3,
            ArsipDigital::STATUS_DITOLAK => 4,
        ];

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
            ->sort(function ($a, $b) use ($statusPriority) {
                $priorityA = $statusPriority[$a['status']] ?? 99;
                $priorityB = $statusPriority[$b['status']] ?? 99;

                if ($priorityA === $priorityB) {
                    $timeA = strtotime((string) ($a['created_at'] ?? 0));
                    $timeB = strtotime((string) ($b['created_at'] ?? 0));

                    return $timeB <=> $timeA;
                }

                return $priorityA <=> $priorityB;
            })
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

    /**
     * Show the archive import form.
     */
    public function showImportForm()
    {
        $typeOptions = ArsipDigital::typeOptions();
        return view('petugas.arsip.import', compact('typeOptions'));
    }

    /**
     * Download the import template based on archive type.
     */
    public function downloadTemplate(Request $request)
    {
        $type = $request->query('type');
        
        $validTypes = ['laporan-pkl', 'proposal-ta', 'laporan-ta'];
        if (!in_array($type, $validTypes)) {
            abort(400, 'Tipe template tidak valid.');
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $titleLabel = '';
        $headers = [];
        $examples = [];
        
        if ($type === 'laporan-pkl') {
            $sheet->setTitle('Template Import PKL');
            $titleLabel = 'TEMPLATE IMPORT LAPORAN PKL MAHASISWA';
            $headers = ['No. Surat Tanda Terima', 'NIM', 'Nama Mahasiswa', 'Program Studi', 'Judul PKL', 'Tempat PKL', 'Pembimbing', 'Penguji 1', 'Penguji 2', 'Tahun'];
            $examples = [
                ['024', '3202316109', 'Rian Yulianto', 'D3 Teknik Informatika', 'Sistem Informasi Perpustakaan Digital', 'Kantor Walikota Sukamara', 'Herianto, M.Kom.', 'M. Fadli, M.T.', 'Indra, M.Cs.', '2025'],
                ['025', '3202316110', 'Budi Santoso', 'D3 Teknik Informatika', 'Aplikasi E-Commerce UMKM', 'Dinas Kominfo', 'Yusuf, M.T.', 'Ahmad, M.Kom.', 'Siti, M.Cs.', '2025']
            ];
        } else {
            $sheet->setTitle($type === 'proposal-ta' ? 'Template Import Proposal TA' : 'Template Import Laporan TA');
            $titleLabel = $type === 'proposal-ta' ? 'TEMPLATE IMPORT PROPOSAL TUGAS AKHIR' : 'TEMPLATE IMPORT LAPORAN TUGAS AKHIR';
            $headers = ['No. Surat Tanda Terima', 'NIM', 'Nama Mahasiswa', 'Program Studi', 'Judul', 'Pembimbing', 'Penguji 1', 'Penguji 2', 'Tahun'];
            $examples = [
                ['024', '3202316109', 'Rian Yulianto', 'D3 Teknik Informatika', 'Rancang Bangun IoT untuk Smart Agriculture', 'Herianto, M.Kom.', 'M. Fadli, M.T.', 'Indra, M.Cs.', '2026'],
                ['025', '3202316110', 'Budi Santoso', 'D3 Teknik Informatika', 'Implementasi Deep Learning untuk Deteksi Hama', 'Yusuf, M.T.', 'Ahmad, M.Kom.', 'Siti, M.Cs.', '2026']
            ];
        }

        // Panduan Pengisian di bagian atas
        $sheet->setCellValue('A1', $titleLabel);
        $sheet->setCellValue('A2', 'PANDUAN PENGISIAN TEMPLATE IMPORT ARSIP:');
        $sheet->setCellValue('A3', '1. Kolom "No. Surat Tanda Terima" cukup diisi nomor urutnya saja (contoh: 24, 25), "NIM", "Nama Mahasiswa", "Program Studi", "Judul", dan "Tahun" wajib diisi.');
        if ($type === 'laporan-pkl') {
            $sheet->setCellValue('A4', '2. Kolom "Tempat PKL" wajib diisi khusus untuk tipe Laporan PKL.');
        } else {
            $sheet->setCellValue('A4', '2. Kolom "Pembimbing" dan "Penguji" disarankan diisi lengkap.');
        }
        $sheet->setCellValue('A5', '3. Nama Program Studi harus sama persis dengan nama Program Studi yang terdaftar di database.');
        $sheet->setCellValue('A6', '4. Jika NIM Mahasiswa belum terdaftar, sistem akan otomatis membuatkan akun Alumni baru.');
        $sheet->setCellValue('A7', '5. Sistem otomatis membuat akun: Email = [NIM]@sipus.polnep.ac.id | Password = sipus[NIM].');

        $lastCol = $type === 'laporan-pkl' ? 'J' : 'I';
        
        // Merge cells for header instruction
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);

        // Header Tabel di baris 9
        $sheet->fromArray($headers, null, 'A9');

        // Style header tabel
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '00A5C0'], // POLNEP Turquoise brand color
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $sheet->getStyle("A9:{$lastCol}9")->applyFromArray($headerStyle);

        // Contoh Data (Baris 10 dan 11)
        $sheet->fromArray($examples, null, 'A10');

        // Auto size columns
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_import_' . str_replace('-', '_', $type) . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Import archives from uploaded excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'type' => ['required', 'string', 'in:laporan-pkl,proposal-ta,laporan-ta'],
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'], // Max 10MB
        ]);

        $type = $request->input('type');
        $file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Gagal membaca berkas Excel: ' . $e->getMessage()]);
        }

        $startIndex = 9;
        $totalRows = count($rows);

        if ($totalRows <= $startIndex) {
            return back()->withErrors(['file' => 'Berkas Excel tidak memiliki data untuk di-import.']);
        }

        $errors = [];
        $prodis = Prodi::all();
        $roleMahasiswa = Role::where('role_name', 'mahasiswa')->first();
        if (!$roleMahasiswa) {
            return back()->withErrors(['file' => 'Peran (Role) mahasiswa tidak ditemukan di sistem.']);
        }

        // Tahap 1: Validasi format data di seluruh baris
        for ($i = $startIndex; $i < $totalRows; $i++) {
            $row = $rows[$i];
            
            $nomorSurat = isset($row[0]) ? trim($row[0]) : '';
            $nim = isset($row[1]) ? trim($row[1]) : '';
            $nama = isset($row[2]) ? trim($row[2]) : '';
            $prodiName = isset($row[3]) ? trim($row[3]) : '';
            $judul = isset($row[4]) ? trim($row[4]) : '';
            
            if ($type === 'laporan-pkl') {
                $tempatPkl = isset($row[5]) ? trim($row[5]) : '';
                $pembimbing = isset($row[6]) ? trim($row[6]) : '';
                $penguji1 = isset($row[7]) ? trim($row[7]) : '';
                $penguji2 = isset($row[8]) ? trim($row[8]) : '';
                $tahun = isset($row[9]) ? trim($row[9]) : '';
            } else {
                $tempatPkl = '';
                $pembimbing = isset($row[5]) ? trim($row[5]) : '';
                $penguji1 = isset($row[6]) ? trim($row[6]) : '';
                $penguji2 = isset($row[7]) ? trim($row[7]) : '';
                $tahun = isset($row[8]) ? trim($row[8]) : '';
            }

            // Jika baris kosong seluruhnya, lewati
            if (empty($nomorSurat) && empty($nim) && empty($nama) && empty($prodiName) && empty($judul) && empty($tahun)) {
                continue;
            }

            $rowNum = $i + 1;

            // Auto-format jika nomor surat diisi angka saja (nomor urut)
            if (!empty($nomorSurat) && preg_match('/^\d+$/', $nomorSurat) && !empty($tahun)) {
                $formatKode = \App\Models\AppSetting::get('receipt_kode_surat', '/PL.16.A3/KM/');
                $sequenceStr = sprintf('%03d', (int)$nomorSurat);
                $formattedNomorSurat = $sequenceStr . $formatKode . $tahun;
            } else {
                $formattedNomorSurat = $nomorSurat;
            }

            if (empty($nomorSurat)) {
                $errors[] = "Baris {$rowNum}: Nomor Surat Tanda Terima wajib diisi.";
            } else {
                // Check if nomor_surat already exists in the database
                $nomorSuratExists = false;
                if ($type === 'laporan-pkl') {
                    $nomorSuratExists = LaporanPkl::where('nomor_surat', $formattedNomorSurat)->exists();
                } elseif ($type === 'proposal-ta') {
                    $nomorSuratExists = ProposalTa::where('nomor_surat', $formattedNomorSurat)->exists();
                } elseif ($type === 'laporan-ta') {
                    $nomorSuratExists = LaporanTugasAkhir::where('nomor_surat', $formattedNomorSurat)->exists();
                }
                if ($nomorSuratExists) {
                    $errors[] = "Baris {$rowNum}: Nomor Surat Tanda Terima '{$formattedNomorSurat}' sudah terdaftar di sistem.";
                }
            }

            if (empty($nim)) {
                $errors[] = "Baris {$rowNum}: NIM wajib diisi.";
            }
            if (empty($nama)) {
                $errors[] = "Baris {$rowNum}: Nama Mahasiswa wajib diisi.";
            }
            if (empty($prodiName)) {
                $errors[] = "Baris {$rowNum}: Program Studi wajib diisi.";
            } else {
                // Cocokkan prodi case-insensitive
                $prodiMatch = $prodis->first(function($p) use ($prodiName) {
                    return strtolower($p->nama_prodi) === strtolower($prodiName);
                });
                if (!$prodiMatch) {
                    $errors[] = "Baris {$rowNum}: Program Studi '{$prodiName}' tidak terdaftar di database.";
                }
            }
            if (empty($judul)) {
                $errors[] = "Baris {$rowNum}: Judul wajib diisi.";
            }
            if ($type === 'laporan-pkl' && empty($tempatPkl)) {
                $errors[] = "Baris {$rowNum}: Tempat PKL wajib diisi untuk Laporan PKL.";
            }
            if (empty($tahun)) {
                $errors[] = "Baris {$rowNum}: Tahun wajib diisi.";
            } elseif (!is_numeric($tahun) || strlen($tahun) !== 4) {
                $errors[] = "Baris {$rowNum}: Tahun harus berupa 4 digit angka.";
            }
        }

        // Jika ada kesalahan validasi baris, batalkan import dan tampilkan error
        if (count($errors) > 0) {
            return back()->withInput()->with('import_errors', $errors);
        }

        // Tahap 2: Lakukan import secara transaksional
        $importedCount = 0;
        $skippedCount = 0;

        DB::beginTransaction();
        try {
            for ($i = $startIndex; $i < $totalRows; $i++) {
                $row = $rows[$i];
                
                $nomorSurat = isset($row[0]) ? trim($row[0]) : '';
                $nim = isset($row[1]) ? trim($row[1]) : '';
                $nama = isset($row[2]) ? trim($row[2]) : '';
                $prodiName = isset($row[3]) ? trim($row[3]) : '';
                $judul = isset($row[4]) ? trim($row[4]) : '';
                
                if ($type === 'laporan-pkl') {
                    $tempatPkl = isset($row[5]) ? trim($row[5]) : '';
                    $pembimbing = isset($row[6]) ? trim($row[6]) : '';
                    $penguji1 = isset($row[7]) ? trim($row[7]) : '';
                    $penguji2 = isset($row[8]) ? trim($row[8]) : '';
                    $tahun = isset($row[9]) ? trim($row[9]) : '';
                } else {
                    $tempatPkl = '';
                    $pembimbing = isset($row[5]) ? trim($row[5]) : '';
                    $penguji1 = isset($row[6]) ? trim($row[6]) : '';
                    $penguji2 = isset($row[7]) ? trim($row[7]) : '';
                    $tahun = isset($row[8]) ? trim($row[8]) : '';
                }

                if (empty($nomorSurat) && empty($nim) && empty($nama) && empty($prodiName) && empty($judul) && empty($tahun)) {
                    continue;
                }

                // Auto-format jika nomor surat diisi angka saja (nomor urut)
                if (!empty($nomorSurat) && preg_match('/^\d+$/', $nomorSurat) && !empty($tahun)) {
                    $formatKode = \App\Models\AppSetting::get('receipt_kode_surat', '/PL.16.A3/KM/');
                    $sequenceStr = sprintf('%03d', (int)$nomorSurat);
                    $formattedNomorSurat = $sequenceStr . $formatKode . $tahun;
                } else {
                    $formattedNomorSurat = $nomorSurat;
                }

                // 1. Cari mahasiswa berdasarkan NIM
                $mahasiswa = Mahasiswa::where('nim', $nim)->first();

                // Jika mahasiswa belum ada, buat mahasiswa & user dummy (alumni) baru
                if (!$mahasiswa) {
                    $prodi = $prodis->first(function($p) use ($prodiName) {
                        return strtolower($p->nama_prodi) === strtolower($prodiName);
                    });

                    // Cek email user agar tidak bentrok
                    $email = $nim . '@sipus.polnep.ac.id';
                    $user = User::where('email', $email)->first();
                    
                    if (!$user) {
                        $user = User::create([
                            'name' => $nama,
                            'email' => $email,
                            'password' => Hash::make('sipus' . $nim),
                            'role_id' => $roleMahasiswa->role_id,
                        ]);
                    }

                    $mahasiswa = Mahasiswa::create([
                        'user_id' => $user->user_id,
                        'prodi_id' => $prodi->prodi_id,
                        'nim' => $nim,
                        'semester' => 'Alumni',
                    ]);
                }

                // 2. Cek duplikasi: Mahasiswa + Tipe Arsip terpilih ATAU Nomor Surat
                $isDuplicate = false;
                if ($type === 'laporan-pkl') {
                    $isDuplicate = LaporanPkl::where('mahasiswa_id', $mahasiswa->mhs_id)
                        ->orWhere('nomor_surat', $formattedNomorSurat)
                        ->exists();
                } elseif ($type === 'proposal-ta') {
                    $isDuplicate = ProposalTa::where('mahasiswa_id', $mahasiswa->mhs_id)
                        ->orWhere('nomor_surat', $formattedNomorSurat)
                        ->exists();
                } elseif ($type === 'laporan-ta') {
                    $isDuplicate = LaporanTugasAkhir::where('mahasiswa_id', $mahasiswa->mhs_id)
                        ->orWhere('nomor_surat', $formattedNomorSurat)
                        ->exists();
                }

                if ($isDuplicate) {
                    $skippedCount++;
                    continue;
                }

                // 3. Simpan data arsip
                $archiveId = null;
                if ($type === 'laporan-pkl') {
                    $archive = LaporanPkl::create([
                        'mahasiswa_id' => $mahasiswa->mhs_id,
                        'judul_pkl' => $judul,
                        'nama_tempat_pkl' => $tempatPkl,
                        'pembimbing' => $pembimbing,
                        'penguji_1' => $penguji1,
                        'penguji_2' => $penguji2,
                        'tahun' => $tahun,
                        'status' => ArsipDigital::STATUS_AKTIF,
                        'nomor_surat' => $formattedNomorSurat,
                        'received_at' => now(),
                    ]);
                    $archiveId = $archive->id;
                } elseif ($type === 'proposal-ta') {
                    $archive = ProposalTa::create([
                        'mahasiswa_id' => $mahasiswa->mhs_id,
                        'judul_proposal' => $judul,
                        'pembimbing' => $pembimbing,
                        'penguji_1' => $penguji1,
                        'penguji_2' => $penguji2,
                        'tahun' => $tahun,
                        'status' => ArsipDigital::STATUS_AKTIF,
                        'nomor_surat' => $formattedNomorSurat,
                        'received_at' => now(),
                    ]);
                    $archiveId = $archive->id;
                } elseif ($type === 'laporan-ta') {
                    $archive = LaporanTugasAkhir::create([
                        'mahasiswa_id' => $mahasiswa->mhs_id,
                        'judul_tgs_akhir' => $judul,
                        'pembimbing' => $pembimbing,
                        'penguji_1' => $penguji1,
                        'penguji_2' => $penguji2,
                        'tahun' => $tahun,
                        'status' => ArsipDigital::STATUS_AKTIF,
                        'nomor_surat' => $formattedNomorSurat,
                        'received_at' => now(),
                    ]);
                    $archiveId = $archive->id;
                }

                // 4. Buat entri di tabel collections dengan stock = 1
                Collection::updateOrCreate(
                    [
                        'item_type' => ArsipDigital::itemType($type),
                        'item_id' => $archiveId,
                    ],
                    [
                        'stock' => 1,
                    ]
                );

                $importedCount++;
            }

            // Log aktivitas ke ActivityLog
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => "Melakukan import arsip digital ({$type}) via Excel. Berhasil: {$importedCount}, Dilewati (Duplikat): {$skippedCount}.",
            ]);

            DB::commit();

            $message = "Proses import selesai. Berhasil menambahkan {$importedCount} data arsip.";
            if ($skippedCount > 0) {
                $message .= " Sebanyak {$skippedCount} data dilewati karena mahasiswa terkait sudah memiliki arsip dengan tipe tersebut.";
            }

            return redirect()->route('petugas.arsip.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal import arsip: ' . $e->getMessage());
            return back()->withErrors(['file' => 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage()]);
        }
    }
}
