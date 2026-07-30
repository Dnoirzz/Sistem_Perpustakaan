<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\LaporanPkl;
use App\Models\ProposalTa;
use App\Models\LaporanTugasAkhir;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Collection;
use App\Models\Penalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    private const COLLECTION_REPORT_TYPES = [
        'all' => 'Semua Koleksi',
        'book' => 'Buku Umum',
        'laporan_pkl' => 'Laporan PKL',
        'proposal_ta' => 'Proposal TA',
        'laporan_ta' => 'Laporan TA',
    ];

    public function index()
    {
        Loan::syncOverdueStatuses();

        $stats = [
            'total_members' => User::whereHas('role', function ($query) {
                $query->whereIn('role_name', ['mahasiswa', 'dosen']);
            })->count(),
            'total_loans' => Loan::count(),
            'active_loans' => Loan::whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'total_collections' => Collection::sum('stock'),
            'total_books' => Book::count(),
            'total_archives' => LaporanPkl::count() + ProposalTa::count() + LaporanTugasAkhir::count(),
            'unpaid_penalties_amount' => Penalty::where('status', 'belum_dibayar')->sum('amount'),
            'unpaid_penalties_count' => Penalty::where('status', 'belum_dibayar')->count(),
        ];

        return view('petugas.reports.index', [
            'collectionReportTypes' => self::COLLECTION_REPORT_TYPES,
            'stats' => $stats,
        ]);
    }

    public function sirkulasi(Request $request)
    {
        Loan::syncOverdueStatuses();

        $search = $request->input('search');
        $status = $request->input('status');
        $tglAwal = $request->input('tgl_awal');
        $tglAkhir = $request->input('tgl_akhir');

        $query = Loan::with(['user.role', 'user.mahasiswa', 'user.dosen', 'collection.book']);

        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('tgl_pinjam', [$tglAwal, $tglAkhir]);
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                            $mq->where('nim', 'like', "%{$search}%");
                        })
                        ->orWhereHas('dosen', function ($dq) use ($search) {
                            $dq->where('nip', 'like', "%{$search}%");
                        });
                });
            });
        }

        $loans = $query->latest('tgl_pinjam')->paginate(15)->withQueryString();

        return view('petugas.reports.sirkulasi', compact('loans', 'search', 'status', 'tglAwal', 'tglAkhir'));
    }

    public function koleksi(Request $request)
    {
        $selectedCollectionType = $request->input('collection_type');
        $search = $request->input('search');

        $items = collect();

        if ($selectedCollectionType === 'book') {
            $query = Book::with(['category', 'collection']);
            if ($search) {
                $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('publisher', 'like', "%{$search}%");
            }
            $items = $query->orderBy('judul')->paginate(15)->withQueryString();
        } elseif ($selectedCollectionType === 'laporan_pkl') {
            $query = LaporanPkl::with(['mahasiswa.user', 'mahasiswa.prodi']);
            if ($search) {
                $query->where('judul_pkl', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa.user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            }
            $items = $query->latest()->paginate(15)->withQueryString();
        } elseif ($selectedCollectionType === 'proposal_ta') {
            $query = ProposalTa::with(['mahasiswa.user', 'mahasiswa.prodi']);
            if ($search) {
                $query->where('judul_proposal', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa.user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            }
            $items = $query->latest()->paginate(15)->withQueryString();
        } elseif ($selectedCollectionType === 'laporan_ta') {
            $query = LaporanTugasAkhir::with(['mahasiswa.user', 'mahasiswa.prodi']);
            if ($search) {
                $query->where('judul_tgs_akhir', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa.user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            }
            $items = $query->latest()->paginate(15)->withQueryString();
        }

        $collectionReportTypes = [
            'book' => 'Buku Umum',
            'laporan_pkl' => 'Laporan PKL',
            'proposal_ta' => 'Proposal Tugas Akhir (TA)',
            'laporan_ta' => 'Laporan Tugas Akhir (TA)',
        ];

        return view('petugas.reports.koleksi', compact('items', 'selectedCollectionType', 'search', 'collectionReportTypes'));
    }

    public function arsip(Request $request)
    {
        $jenisArsip = $request->input('jenis_arsip', 'all');
        $tglAwal = $request->input('tgl_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));

        $tglAwalCarbon = Carbon::parse($tglAwal);
        $tglAkhirCarbon = Carbon::parse($tglAkhir);

        $archives = $this->getArchivesData($tglAwalCarbon, $tglAkhirCarbon, $jenisArsip);

        return view('petugas.reports.arsip', compact('archives', 'jenisArsip', 'tglAwal', 'tglAkhir'));
    }

    public function denda(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');
        $type = $request->input('type', 'all');

        $query = Penalty::with(['user.mahasiswa', 'user.dosen', 'loan.collection']);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                        $mq->where('nim', 'like', "%{$search}%");
                    })
                    ->orWhereHas('dosen', function ($dq) use ($search) {
                        $dq->where('nip', 'like', "%{$search}%");
                    });
            });
        }

        $penalties = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'unpaid_amount' => Penalty::where('status', 'belum_dibayar')->sum('amount'),
            'unpaid_count' => Penalty::where('status', 'belum_dibayar')->count(),
            'paid_amount' => Penalty::where('status', 'dibayar')->sum('amount'),
            'paid_count' => Penalty::where('status', 'dibayar')->count(),
        ];

        return view('petugas.reports.denda', compact('penalties', 'search', 'status', 'type', 'stats'));
    }

    public function printDenda(Request $request)
    {
        $status = $request->input('status', 'all');
        $type = $request->input('type', 'all');

        $query = Penalty::with(['user.mahasiswa', 'user.dosen', 'loan.collection']);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }

        $penalties = $query->latest()->get();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mencetak laporan denda & sanksi perpustakaan',
        ]);

        return view('petugas.reports.print-denda', compact('penalties', 'status', 'type'));
    }

    public function exportDendaExcel(Request $request)
    {
        $status = $request->input('status', 'all');
        $type = $request->input('type', 'all');

        $query = Penalty::with(['user.mahasiswa', 'user.dosen', 'loan.collection']);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }

        $penalties = $query->latest()->get();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengekspor laporan denda & sanksi Excel',
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Denda');

        $sheet->setCellValue('A1', 'LAPORAN DENDA & SANKSI PERPUSTAKAAN PSDKU POLNEP');
        $sheet->setCellValue('A2', 'Tanggal Cetak: ' . now()->translatedFormat('d F Y H:i'));

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama Anggota');
        $sheet->setCellValue('C4', 'Koleksi / Buku');
        $sheet->setCellValue('D4', 'Jenis Sanksi');
        $sheet->setCellValue('E4', 'Metode Penyelesaian');
        $sheet->setCellValue('F4', 'Nominal Denda');
        $sheet->setCellValue('G4', 'Status');
        $sheet->setCellValue('H4', 'Keterangan');
        $sheet->getStyle('A4:H4')->getFont()->setBold(true);

        $rowNum = 5;
        foreach ($penalties as $index => $pen) {
            $sheet->setCellValue('A' . $rowNum, $index + 1);
            $sheet->setCellValue('B' . $rowNum, $pen->user?->name ?: '-');
            $sheet->setCellValue('C' . $rowNum, $pen->loan?->collection?->display_title ?: '-');
            $sheet->setCellValue('D' . $rowNum, ucfirst($pen->type));
            $sheet->setCellValue('E' . $rowNum, str_replace('_', ' ', ucfirst($pen->penalti_type ?? 'uang_tunai')));
            $sheet->setCellValue('F' . $rowNum, (float) $pen->amount);
            $sheet->getStyle('F' . $rowNum)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('G' . $rowNum, $pen->status === 'dibayar' ? 'LUNAS' : 'BELUM DIBAYAR');
            $sheet->setCellValue('H' . $rowNum, $pen->description ?: '-');
            $rowNum++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan-denda-' . date('Ymd-His') . '.xlsx';

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function printSirkulasi(Request $request)
    {
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
        ]);

        $tglAwal = Carbon::parse($request->tgl_awal);
        $tglAkhir = Carbon::parse($request->tgl_akhir);

        $loans = Loan::with(['user.role', 'collection'])
            ->whereBetween('tgl_pinjam', [$tglAwal->toDateString(), $tglAkhir->toDateString()])
            ->latest()
            ->get();

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mencetak laporan sirkulasi periode ' . $tglAwal->format('d/m/Y') . ' - ' . $tglAkhir->format('d/m/Y'),
        ]);

        return view('petugas.reports.print-sirkulasi', [
            'loans' => $loans,
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir,
        ]);
    }

    public function exportSirkulasiExcel(Request $request)
    {
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
        ]);

        $tglAwal = Carbon::parse($request->tgl_awal);
        $tglAkhir = Carbon::parse($request->tgl_akhir);

        $loans = Loan::with(['user', 'collection'])
            ->whereBetween('tgl_pinjam', [$tglAwal->toDateString(), $tglAkhir->toDateString()])
            ->latest()
            ->get();

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengekspor laporan sirkulasi Excel periode ' . $tglAwal->format('d/m/Y') . ' - ' . $tglAkhir->format('d/m/Y'),
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Sirkulasi');

        // Header Title
        $sheet->setCellValue('A1', 'LAPORAN TRANSAKSI SIRKULASI PERPUSTAKAAN PSDKU POLNEP');
        $sheet->setCellValue('A2', 'Periode: ' . $tglAwal->translatedFormat('d F Y') . ' s/d ' . $tglAkhir->translatedFormat('d F Y'));
        
        // Table Headers
        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama Anggota');
        $sheet->setCellValue('C4', 'Koleksi Buku / Arsip');
        $sheet->setCellValue('D4', 'Jenis Koleksi');
        $sheet->setCellValue('E4', 'Tanggal Pinjam');
        $sheet->setCellValue('F4', 'Batas Kembali');
        $sheet->setCellValue('G4', 'Tanggal Kembali');
        $sheet->setCellValue('H4', 'Status');

        // Style header row
        $sheet->getStyle('A4:H4')->getFont()->setBold(true);

        $rowNum = 5;
        foreach ($loans as $index => $loan) {
            $sheet->setCellValue('A' . $rowNum, $index + 1);
            $sheet->setCellValue('B' . $rowNum, $loan->user?->name ?: '-');
            $sheet->setCellValue('C' . $rowNum, $loan->collection?->display_title ?: '-');
            $sheet->setCellValue('D' . $rowNum, $loan->collection?->display_type_label ?: '-');
            $sheet->setCellValue('E' . $rowNum, $loan->tgl_pinjam ? Carbon::parse($loan->tgl_pinjam)->format('d-m-Y') : '-');
            $sheet->setCellValue('F' . $rowNum, $loan->bts_waktu ? Carbon::parse($loan->bts_waktu)->format('d-m-Y') : '-');
            $sheet->setCellValue('G' . $rowNum, $loan->tgl_kembali ? Carbon::parse($loan->tgl_kembali)->format('d-m-Y') : '-');
            $sheet->setCellValue('H' . $rowNum, strtoupper($loan->status));
            $rowNum++;
        }

        // Set autosize for columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan-sirkulasi-' . $tglAwal->format('Ymd') . '-ke-' . $tglAkhir->format('Ymd') . '.xlsx';

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function printKoleksi(Request $request)
    {
        $request->validate([
            'collection_type' => 'nullable|in:all,book,laporan_pkl,proposal_ta,laporan_ta',
        ]);

        $selectedCollectionType = $request->input('collection_type', 'all');
        $collectionTypeLabel = self::COLLECTION_REPORT_TYPES[$selectedCollectionType] ?? self::COLLECTION_REPORT_TYPES['all'];
        $collections = $this->getCollectionReportData($selectedCollectionType);

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mencetak laporan koleksi perpustakaan: ' . $collectionTypeLabel,
        ]);

        return view('petugas.reports.print-koleksi', [
            'books' => $collections['books'],
            'pkls' => $collections['pkls'],
            'ptas' => $collections['ptas'],
            'tas' => $collections['tas'],
            'selectedCollectionType' => $selectedCollectionType,
            'selectedCollectionTypeLabel' => $collectionTypeLabel,
        ]);
    }

    public function exportKoleksiExcel(Request $request)
    {
        $request->validate([
            'collection_type' => 'nullable|in:all,book,laporan_pkl,proposal_ta,laporan_ta',
        ]);

        $selectedCollectionType = $request->input('collection_type', 'all');
        $collectionTypeLabel = self::COLLECTION_REPORT_TYPES[$selectedCollectionType] ?? self::COLLECTION_REPORT_TYPES['all'];
        $collections = $this->getCollectionReportData($selectedCollectionType);

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengekspor laporan koleksi Excel: ' . $collectionTypeLabel,
        ]);

        $spreadsheet = new Spreadsheet();
        $sheetDefinitions = [];
        if ($selectedCollectionType === 'all' || $selectedCollectionType === 'book') {
            $sheetDefinitions['book'] = function ($sheet) use ($collections) {
                $sheet->setTitle('Buku Umum');
                $sheet->setCellValue('A1', 'LAPORAN KOLEKSI BUKU PERPUSTAKAAN PSDKU POLNEP');
                $sheet->setCellValue('A3', 'No');
                $sheet->setCellValue('B3', 'Judul Buku');
                $sheet->setCellValue('C3', 'Kategori');
                $sheet->setCellValue('D3', 'Penulis / Pengarang');
                $sheet->setCellValue('E3', 'Penerbit');
                $sheet->setCellValue('F3', 'Tahun Terbit');
                $sheet->setCellValue('G3', 'Stok Fisik');
                $sheet->getStyle('A3:G3')->getFont()->setBold(true);

                $row = 4;
                foreach ($collections['books'] as $index => $book) {
                    $sheet->setCellValue('A' . $row, $index + 1);
                    $sheet->setCellValue('B' . $row, $book->judul);
                    $sheet->setCellValue('C' . $row, $book->category?->kategori_name ?: '-');
                    $sheet->setCellValue('D' . $row, $book->penulis ?: '-');
                    $sheet->setCellValue('E' . $row, $book->penerbit ?: '-');
                    $sheet->setCellValue('F' . $row, $book->tahun_terbit ?: '-');
                    $sheet->setCellValue('G' . $row, $book->stock);
                    $row++;
                }

                foreach (range('A', 'G') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            };
        }

        if ($selectedCollectionType === 'all' || $selectedCollectionType === 'laporan_pkl') {
            $sheetDefinitions['laporan_pkl'] = function ($sheet) use ($collections) {
                $sheet->setTitle('Laporan PKL');
                $sheet->setCellValue('A1', 'LAPORAN KOLEKSI ARSIP DIGITAL - LAPORAN PKL');
                $sheet->setCellValue('A3', 'No');
                $sheet->setCellValue('B3', 'Judul PKL');
                $sheet->setCellValue('C3', 'Nama Mahasiswa');
                $sheet->setCellValue('D3', 'NIM');
                $sheet->setCellValue('E3', 'Program Studi');
                $sheet->setCellValue('F3', 'Dosen Pembimbing');
                $sheet->setCellValue('G3', 'Tahun');
                $sheet->setCellValue('H3', 'Status');
                $sheet->getStyle('A3:H3')->getFont()->setBold(true);

                $row = 4;
                foreach ($collections['pkls'] as $index => $pkl) {
                    $sheet->setCellValue('A' . $row, $index + 1);
                    $sheet->setCellValue('B' . $row, $pkl->judul_pkl);
                    $sheet->setCellValue('C' . $row, $pkl->mahasiswa?->user?->name ?: '-');
                    $sheet->setCellValue('D' . $row, $pkl->mahasiswa?->nim ?: '-');
                    $sheet->setCellValue('E' . $row, $pkl->mahasiswa?->prodi?->nama_prodi ?: '-');
                    $sheet->setCellValue('F' . $row, $pkl->pembimbing ?: '-');
                    $sheet->setCellValue('G' . $row, $pkl->tahun);
                    $sheet->setCellValue('H' . $row, strtoupper($pkl->status));
                    $row++;
                }

                foreach (range('A', 'H') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            };
        }

        if ($selectedCollectionType === 'all' || $selectedCollectionType === 'proposal_ta') {
            $sheetDefinitions['proposal_ta'] = function ($sheet) use ($collections) {
                $sheet->setTitle('Proposal TA');
                $sheet->setCellValue('A1', 'LAPORAN KOLEKSI ARSIP DIGITAL - PROPOSAL TA');
                $sheet->setCellValue('A3', 'No');
                $sheet->setCellValue('B3', 'Judul Proposal');
                $sheet->setCellValue('C3', 'Nama Mahasiswa');
                $sheet->setCellValue('D3', 'NIM');
                $sheet->setCellValue('E3', 'Program Studi');
                $sheet->setCellValue('F3', 'Dosen Pembimbing');
                $sheet->setCellValue('G3', 'Tahun');
                $sheet->setCellValue('H3', 'Status');
                $sheet->getStyle('A3:H3')->getFont()->setBold(true);

                $row = 4;
                foreach ($collections['ptas'] as $index => $pta) {
                    $sheet->setCellValue('A' . $row, $index + 1);
                    $sheet->setCellValue('B' . $row, $pta->judul_proposal);
                    $sheet->setCellValue('C' . $row, $pta->mahasiswa?->user?->name ?: '-');
                    $sheet->setCellValue('D' . $row, $pta->mahasiswa?->nim ?: '-');
                    $sheet->setCellValue('E' . $row, $pta->mahasiswa?->prodi?->nama_prodi ?: '-');
                    $sheet->setCellValue('F' . $row, $pta->pembimbing ?: '-');
                    $sheet->setCellValue('G' . $row, $pta->tahun);
                    $sheet->setCellValue('H' . $row, strtoupper($pta->status));
                    $row++;
                }

                foreach (range('A', 'H') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            };
        }

        if ($selectedCollectionType === 'all' || $selectedCollectionType === 'laporan_ta') {
            $sheetDefinitions['laporan_ta'] = function ($sheet) use ($collections) {
                $sheet->setTitle('Laporan TA');
                $sheet->setCellValue('A1', 'LAPORAN KOLEKSI ARSIP DIGITAL - LAPORAN TA');
                $sheet->setCellValue('A3', 'No');
                $sheet->setCellValue('B3', 'Judul Tugas Akhir');
                $sheet->setCellValue('C3', 'Nama Mahasiswa');
                $sheet->setCellValue('D3', 'NIM');
                $sheet->setCellValue('E3', 'Program Studi');
                $sheet->setCellValue('F3', 'Dosen Pembimbing');
                $sheet->setCellValue('G3', 'Tahun');
                $sheet->setCellValue('H3', 'Status');
                $sheet->getStyle('A3:H3')->getFont()->setBold(true);

                $row = 4;
                foreach ($collections['tas'] as $index => $ta) {
                    $sheet->setCellValue('A' . $row, $index + 1);
                    $sheet->setCellValue('B' . $row, $ta->judul_tgs_akhir);
                    $sheet->setCellValue('C' . $row, $ta->mahasiswa?->user?->name ?: '-');
                    $sheet->setCellValue('D' . $row, $ta->mahasiswa?->nim ?: '-');
                    $sheet->setCellValue('E' . $row, $ta->mahasiswa?->prodi?->nama_prodi ?: '-');
                    $sheet->setCellValue('F' . $row, $ta->pembimbing ?: '-');
                    $sheet->setCellValue('G' . $row, $ta->tahun);
                    $sheet->setCellValue('H' . $row, strtoupper($ta->status));
                    $row++;
                }

                foreach (range('A', 'H') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            };
        }

        $sheetIndex = 0;
        foreach ($sheetDefinitions as $sheetBuilder) {
            $sheet = $sheetIndex === 0 ? $spreadsheet->getActiveSheet() : $spreadsheet->createSheet();
            $sheetBuilder($sheet);
            $sheetIndex++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan-koleksi-perpustakaan.xlsx';

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function printArsip(Request $request)
    {
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'jenis_arsip' => 'required|in:all,laporan_pkl,proposal_ta,laporan_ta',
        ]);

        $tglAwal = Carbon::parse($request->tgl_awal);
        $tglAkhir = Carbon::parse($request->tgl_akhir);
        $jenisArsip = $request->jenis_arsip;

        $archives = $this->getArchivesData($tglAwal, $tglAkhir, $jenisArsip);

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mencetak laporan penerimaan arsip digital periode ' . $tglAwal->format('d/m/Y') . ' - ' . $tglAkhir->format('d/m/Y'),
        ]);

        return view('petugas.reports.print-arsip', [
            'archives' => $archives,
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir,
            'jenisArsip' => $jenisArsip,
        ]);
    }

    public function exportArsipExcel(Request $request)
    {
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date',
            'jenis_arsip' => 'required|in:all,laporan_pkl,proposal_ta,laporan_ta',
        ]);

        $tglAwal = Carbon::parse($request->tgl_awal);
        $tglAkhir = Carbon::parse($request->tgl_akhir);
        $jenisArsip = $request->jenis_arsip;

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengekspor laporan penerimaan arsip digital Excel periode ' . $tglAwal->format('d/m/Y') . ' - ' . $tglAkhir->format('d/m/Y'),
        ]);

        $spreadsheet = new Spreadsheet();
        $sheetIndex = 0;

        $types = [];
        if ($jenisArsip === 'all') {
            $types = [
                'laporan_pkl' => ['title' => 'Laporan PKL', 'model' => LaporanPkl::class, 'title_field' => 'judul_pkl'],
                'proposal_ta' => ['title' => 'Proposal TA', 'model' => ProposalTa::class, 'title_field' => 'judul_proposal'],
                'laporan_ta' => ['title' => 'Laporan TA', 'model' => LaporanTugasAkhir::class, 'title_field' => 'judul_tgs_akhir'],
            ];
        } else {
            if ($jenisArsip === 'laporan_pkl') {
                $types['laporan_pkl'] = ['title' => 'Laporan PKL', 'model' => LaporanPkl::class, 'title_field' => 'judul_pkl'];
            } elseif ($jenisArsip === 'proposal_ta') {
                $types['proposal_ta'] = ['title' => 'Proposal TA', 'model' => ProposalTa::class, 'title_field' => 'judul_proposal'];
            } elseif ($jenisArsip === 'laporan_ta') {
                $types['laporan_ta'] = ['title' => 'Laporan TA', 'model' => LaporanTugasAkhir::class, 'title_field' => 'judul_tgs_akhir'];
            }
        }

        foreach ($types as $key => $typeConfig) {
            if ($sheetIndex > 0) {
                $sheet = $spreadsheet->createSheet();
            } else {
                $sheet = $spreadsheet->getActiveSheet();
            }

            $sheet->setTitle($typeConfig['title']);

            // Title headers
            $sheet->setCellValue('A1', 'LAPORAN PENGUMPULAN ARSIP DIGITAL - ' . strtoupper($typeConfig['title']));
            $sheet->setCellValue('A2', 'Periode: ' . $tglAwal->translatedFormat('d F Y') . ' s/d ' . $tglAkhir->translatedFormat('d F Y'));
            
            $sheet->setCellValue('A4', 'No');
            $sheet->setCellValue('B4', 'Nama Mahasiswa');
            $sheet->setCellValue('C4', 'NIM');
            $sheet->setCellValue('D4', 'Program Studi');
            $sheet->setCellValue('E4', 'Judul Arsip');
            
            $hasPkl = ($key === 'laporan_pkl');
            if ($hasPkl) {
                $sheet->setCellValue('F4', 'Tempat PKL');
                $sheet->setCellValue('G4', 'Dosen Pembimbing');
                $sheet->setCellValue('H4', 'Tanggal Verifikasi');
                $sheet->setCellValue('I4', 'Status Penyerahan Fisik');
            } else {
                $sheet->setCellValue('F4', 'Dosen Pembimbing');
                $sheet->setCellValue('G4', 'Tanggal Verifikasi');
                $sheet->setCellValue('H4', 'Status Penyerahan Fisik');
            }

            $lastCol = $hasPkl ? 'I' : 'H';
            $sheet->getStyle('A4:' . $lastCol . '4')->getFont()->setBold(true);

            $items = $typeConfig['model']::with(['mahasiswa.user', 'mahasiswa.prodi'])
                ->whereIn('status', ['diverifikasi', 'aktif'])
                ->whereBetween('verified_at', [$tglAwal->toDateString() . ' 00:00:00', $tglAkhir->toDateString() . ' 23:59:59'])
                ->latest('verified_at')
                ->get();

            $rowNum = 5;
            foreach ($items as $index => $item) {
                $statusLabel = $item->status === 'aktif' ? 'Buku fisik telah diserahkan' : 'Belum penyerahan buku fisik';
                $sheet->setCellValue('A' . $rowNum, $index + 1);
                $sheet->setCellValue('B' . $rowNum, $item->mahasiswa?->user?->name ?: '-');
                $sheet->setCellValue('C' . $rowNum, $item->mahasiswa?->nim ?: '-');
                $sheet->setCellValue('D' . $rowNum, $item->mahasiswa?->prodi?->nama_prodi ?: '-');
                $sheet->setCellValue('E' . $rowNum, $item->{$typeConfig['title_field']} ?: '-');
                
                if ($hasPkl) {
                    $sheet->setCellValue('F' . $rowNum, $item->nama_tempat_pkl ?: '-');
                    $sheet->setCellValue('G' . $rowNum, $item->pembimbing ?: '-');
                    $sheet->setCellValue('H' . $rowNum, $item->verified_at ? Carbon::parse($item->verified_at)->format('d-m-Y') : '-');
                    $sheet->setCellValue('I' . $rowNum, $statusLabel);
                } else {
                    $sheet->setCellValue('F' . $rowNum, $item->pembimbing ?: '-');
                    $sheet->setCellValue('G' . $rowNum, $item->verified_at ? Carbon::parse($item->verified_at)->format('d-m-Y') : '-');
                    $sheet->setCellValue('H' . $rowNum, $statusLabel);
                }
                $rowNum++;
            }

            foreach (range('A', $lastCol) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $sheetIndex++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan-pengumpulan-arsip-' . $tglAwal->format('Ymd') . '-ke-' . $tglAkhir->format('Ymd') . '.xlsx';

        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    private function getArchivesData(Carbon $tglAwal, Carbon $tglAkhir, string $jenisArsip)
    {
        $data = collect();

        if ($jenisArsip === 'all' || $jenisArsip === 'laporan_pkl') {
            $pkls = LaporanPkl::with(['mahasiswa.user', 'mahasiswa.prodi'])
                ->whereIn('status', ['diverifikasi', 'aktif'])
                ->whereBetween('verified_at', [$tglAwal->toDateString() . ' 00:00:00', $tglAkhir->toDateString() . ' 23:59:59'])
                ->get()
                ->map(function ($item) {
                    $item->jenis_label = 'Laporan PKL';
                    $item->judul_display = $item->judul_pkl;
                    return $item;
                });
            $data = $data->concat($pkls);
        }

        if ($jenisArsip === 'all' || $jenisArsip === 'proposal_ta') {
            $ptas = ProposalTa::with(['mahasiswa.user', 'mahasiswa.prodi'])
                ->whereIn('status', ['diverifikasi', 'aktif'])
                ->whereBetween('verified_at', [$tglAwal->toDateString() . ' 00:00:00', $tglAkhir->toDateString() . ' 23:59:59'])
                ->get()
                ->map(function ($item) {
                    $item->jenis_label = 'Proposal TA';
                    $item->judul_display = $item->judul_proposal;
                    return $item;
                });
            $data = $data->concat($ptas);
        }

        if ($jenisArsip === 'all' || $jenisArsip === 'laporan_ta') {
            $tas = LaporanTugasAkhir::with(['mahasiswa.user', 'mahasiswa.prodi'])
                ->whereIn('status', ['diverifikasi', 'aktif'])
                ->whereBetween('verified_at', [$tglAwal->toDateString() . ' 00:00:00', $tglAkhir->toDateString() . ' 23:59:59'])
                ->get()
                ->map(function ($item) {
                    $item->jenis_label = 'Laporan TA';
                    $item->judul_display = $item->judul_tgs_akhir;
                    return $item;
                });
            $data = $data->concat($tas);
        }

        return $data->sortByDesc('verified_at')->values();
    }

    private function getCollectionReportData(string $selectedCollectionType): array
    {
        return [
            'books' => $selectedCollectionType === 'all' || $selectedCollectionType === 'book'
                ? Book::with('category')->orderBy('judul')->get()
                : collect(),
            'pkls' => $selectedCollectionType === 'all' || $selectedCollectionType === 'laporan_pkl'
                ? LaporanPkl::with('mahasiswa.user', 'mahasiswa.prodi')->get()
                : collect(),
            'ptas' => $selectedCollectionType === 'all' || $selectedCollectionType === 'proposal_ta'
                ? ProposalTa::with('mahasiswa.user', 'mahasiswa.prodi')->get()
                : collect(),
            'tas' => $selectedCollectionType === 'all' || $selectedCollectionType === 'laporan_ta'
                ? LaporanTugasAkhir::with('mahasiswa.user', 'mahasiswa.prodi')->get()
                : collect(),
        ];
    }
}
