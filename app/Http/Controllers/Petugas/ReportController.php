<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Book;
use App\Models\LaporanPkl;
use App\Models\ProposalTa;
use App\Models\LaporanTugasAkhir;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    public function index()
    {
        return view('petugas.reports.index');
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

    public function printKoleksi()
    {
        $books = Book::with('category')->orderBy('judul')->get();
        $pkls = LaporanPkl::with('mahasiswa.user', 'mahasiswa.prodi')->get();
        $ptas = ProposalTa::with('mahasiswa.user', 'mahasiswa.prodi')->get();
        $tas = LaporanTugasAkhir::with('mahasiswa.user', 'mahasiswa.prodi')->get();

        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mencetak laporan seluruh koleksi perpustakaan',
        ]);

        return view('petugas.reports.print-koleksi', [
            'books' => $books,
            'pkls' => $pkls,
            'ptas' => $ptas,
            'tas' => $tas,
        ]);
    }

    public function exportKoleksiExcel()
    {
        // Catat Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Mengekspor laporan seluruh koleksi Excel',
        ]);

        $spreadsheet = new Spreadsheet();
        
        // Sheet 1: Buku
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Buku Teks');
        $sheet1->setCellValue('A1', 'LAPORAN KOLEKSI BUKU PERPUSTAKAAN PSDKU POLNEP');
        $sheet1->setCellValue('A3', 'No');
        $sheet1->setCellValue('B3', 'Judul Buku');
        $sheet1->setCellValue('C3', 'Kategori');
        $sheet1->setCellValue('D3', 'Penulis / Pengarang');
        $sheet1->setCellValue('E3', 'Penerbit');
        $sheet1->setCellValue('F3', 'Tahun Terbit');
        $sheet1->setCellValue('G3', 'Stok Fisik');
        $sheet1->getStyle('A3:G3')->getFont()->setBold(true);

        $books = Book::with('category')->orderBy('judul')->get();
        $row = 4;
        foreach ($books as $index => $book) {
            $sheet1->setCellValue('A' . $row, $index + 1);
            $sheet1->setCellValue('B' . $row, $book->judul);
            $sheet1->setCellValue('C' . $row, $book->category?->kategori_name ?: '-');
            $sheet1->setCellValue('D' . $row, $book->penulis ?: '-');
            $sheet1->setCellValue('E' . $row, $book->penerbit ?: '-');
            $sheet1->setCellValue('F' . $row, $book->tahun_terbit ?: '-');
            $sheet1->setCellValue('G' . $row, $book->stock);
            $row++;
        }
        foreach (range('A', 'G') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // Sheet 2: Laporan PKL
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Laporan PKL');
        $sheet2->setCellValue('A1', 'LAPORAN KOLEKSI ARSIP DIGITAL - LAPORAN PKL');
        $sheet2->setCellValue('A3', 'No');
        $sheet2->setCellValue('B3', 'Judul PKL');
        $sheet2->setCellValue('C3', 'Nama Mahasiswa');
        $sheet2->setCellValue('D3', 'NIM');
        $sheet2->setCellValue('E3', 'Program Studi');
        $sheet2->setCellValue('F3', 'Dosen Pembimbing');
        $sheet2->setCellValue('G3', 'Tahun');
        $sheet2->setCellValue('H3', 'Status');
        $sheet2->getStyle('A3:H3')->getFont()->setBold(true);

        $pkls = LaporanPkl::with('mahasiswa.user', 'mahasiswa.prodi')->get();
        $row = 4;
        foreach ($pkls as $index => $pkl) {
            $sheet2->setCellValue('A' . $row, $index + 1);
            $sheet2->setCellValue('B' . $row, $pkl->judul_pkl);
            $sheet2->setCellValue('C' . $row, $pkl->mahasiswa?->user?->name ?: '-');
            $sheet2->setCellValue('D' . $row, $pkl->mahasiswa?->nim ?: '-');
            $sheet2->setCellValue('E' . $row, $pkl->mahasiswa?->prodi?->nama_prodi ?: '-');
            $sheet2->setCellValue('F' . $row, $pkl->pembimbing ?: '-');
            $sheet2->setCellValue('G' . $row, $pkl->tahun);
            $sheet2->setCellValue('H' . $row, strtoupper($pkl->status));
            $row++;
        }
        foreach (range('A', 'H') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        // Sheet 3: Proposal TA
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Proposal TA');
        $sheet3->setCellValue('A1', 'LAPORAN KOLEKSI ARSIP DIGITAL - PROPOSAL TA');
        $sheet3->setCellValue('A3', 'No');
        $sheet3->setCellValue('B3', 'Judul Proposal');
        $sheet3->setCellValue('C3', 'Nama Mahasiswa');
        $sheet3->setCellValue('D3', 'NIM');
        $sheet3->setCellValue('E3', 'Program Studi');
        $sheet3->setCellValue('F3', 'Dosen Pembimbing');
        $sheet3->setCellValue('G3', 'Tahun');
        $sheet3->setCellValue('H3', 'Status');
        $sheet3->getStyle('A3:H3')->getFont()->setBold(true);

        $ptas = ProposalTa::with('mahasiswa.user', 'mahasiswa.prodi')->get();
        $row = 4;
        foreach ($ptas as $index => $pta) {
            $sheet3->setCellValue('A' . $row, $index + 1);
            $sheet3->setCellValue('B' . $row, $pta->judul_proposal);
            $sheet3->setCellValue('C' . $row, $pta->mahasiswa?->user?->name ?: '-');
            $sheet3->setCellValue('D' . $row, $pta->mahasiswa?->nim ?: '-');
            $sheet3->setCellValue('E' . $row, $pta->mahasiswa?->prodi?->nama_prodi ?: '-');
            $sheet3->setCellValue('F' . $row, $pta->pembimbing ?: '-');
            $sheet3->setCellValue('G' . $row, $pta->tahun);
            $sheet3->setCellValue('H' . $row, strtoupper($pta->status));
            $row++;
        }
        foreach (range('A', 'H') as $col) {
            $sheet3->getColumnDimension($col)->setAutoSize(true);
        }

        // Sheet 4: Laporan TA
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Laporan TA');
        $sheet4->setCellValue('A1', 'LAPORAN KOLEKSI ARSIP DIGITAL - LAPORAN TA');
        $sheet4->setCellValue('A3', 'No');
        $sheet4->setCellValue('B3', 'Judul Tugas Akhir');
        $sheet4->setCellValue('C3', 'Nama Mahasiswa');
        $sheet4->setCellValue('D3', 'NIM');
        $sheet4->setCellValue('E3', 'Program Studi');
        $sheet4->setCellValue('F3', 'Dosen Pembimbing');
        $sheet4->setCellValue('G3', 'Tahun');
        $sheet4->setCellValue('H3', 'Status');
        $sheet4->getStyle('A3:H3')->getFont()->setBold(true);

        $tas = LaporanTugasAkhir::with('mahasiswa.user', 'mahasiswa.prodi')->get();
        $row = 4;
        foreach ($tas as $index => $ta) {
            $sheet4->setCellValue('A' . $row, $index + 1);
            $sheet4->setCellValue('B' . $row, $ta->judul_tgs_akhir);
            $sheet4->setCellValue('C' . $row, $ta->mahasiswa?->user?->name ?: '-');
            $sheet4->setCellValue('D' . $row, $ta->mahasiswa?->nim ?: '-');
            $sheet4->setCellValue('E' . $row, $ta->mahasiswa?->prodi?->nama_prodi ?: '-');
            $sheet4->setCellValue('F' . $row, $ta->pembimbing ?: '-');
            $sheet4->setCellValue('G' . $row, $ta->tahun);
            $sheet4->setCellValue('H' . $row, strtoupper($ta->status));
            $row++;
        }
        foreach (range('A', 'H') as $col) {
            $sheet4->getColumnDimension($col)->setAutoSize(true);
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
}
