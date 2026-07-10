<?php

namespace App\Services;

use App\Models\AppSetting;
use App\Support\ArsipDigital;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class SuratTandaTerimaService
{
    public function generate(Model $archive): array
    {
        $definition = ArsipDigital::resolveFromModel($archive);
        $verifiedAt = $archive->verified_at ? Carbon::parse($archive->verified_at) : now();
        $nomorSurat = $archive->nomor_surat ?: $this->generateNomorSurat($archive, $definition, $verifiedAt);
        $relativePath = 'private/arsip/surat/surat_' . $definition['code'] . '_' . Str::uuid() . '.pdf';
        $absolutePath = storage_path('app/' . $relativePath);

        $directory = dirname($absolutePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $deadline = $this->addWorkingDays($verifiedAt->copy(), 7);

        // Always draw custom PDF dynamically using admin settings and layout rules
        $this->generateFallbackPdf($absolutePath, $archive, $definition, $nomorSurat, $verifiedAt, $deadline);

        return [
            'path' => $relativePath,
            'nomor_surat' => $nomorSurat,
            'verified_at' => $verifiedAt,
            'deadline' => $deadline,
        ];
    }

    public function generatePreview(Model $archive, array $overrides, string $outputPath): void
    {
        $definition = ArsipDigital::resolveFromModel($archive);
        $verifiedAt = $archive->verified_at ? Carbon::parse($archive->verified_at) : now();
        $nomorSurat = $archive->nomor_surat;
        $deadline = $this->addWorkingDays($verifiedAt->copy(), 7);

        $this->generateFallbackPdf($outputPath, $archive, $definition, $nomorSurat, $verifiedAt, $deadline, $overrides);
    }

    protected function generateNomorSurat(Model $archive, array $definition, Carbon $verifiedAt): string
    {
        $sequence = $definition['model']::query()
            ->whereYear('verified_at', $verifiedAt->year)
            ->whereNotNull('nomor_surat')
            ->when($archive->exists, fn($query) => $query->whereKeyNot($archive->getKey()))
            ->count() + 1;

        $formatKode = AppSetting::get('receipt_kode_surat', '/PL.16.A3/KM/');
        $sequenceStr = sprintf('%03d', $sequence); // 3 digits sequence

        return $sequenceStr . $formatKode . $verifiedAt->year;
    }

    protected function generateFallbackPdf(
        string $outputPath,
        Model $archive,
        array $definition,
        string $nomorSurat,
        Carbon $verifiedAt,
        Carbon $deadline,
        array $overrides = []
    ): void {
        $pdf = new Fpdi();
        $pdf->AddPage('P', 'A4');
        $pdf->SetMargins(20, 15, 20);
        $pdf->SetAutoPageBreak(true, 15);

        // Get dynamic settings from AppSetting or override parameters
        $kop1 = $overrides['receipt_kop_line_1'] ?? AppSetting::get('receipt_kop_line_1', "KEMENTERIAN PENDIDIKAN TINGGI, SAINS,\nDAN TEKNOLOGI");
        $kop2 = $overrides['receipt_kop_line_2'] ?? AppSetting::get('receipt_kop_line_2', 'POLITEKNIK NEGERI PONTIANAK');
        $kop3 = $overrides['receipt_kop_line_3'] ?? AppSetting::get('receipt_kop_line_3', 'PERPUSTAKAAN PSDKU POLNEP DI KABUPATEN SUKAMARA');
        $kopAlamat = $overrides['receipt_kop_alamat'] ?? AppSetting::get('receipt_kop_alamat', "Jalan Jenderal Ahmad Yani - Pontianak 78124, Kalimantan Barat\nTelepon: (0561)736180, Faksimile: (0561)740143, Kotak Pos: 1286");

        // Get logo path (check if custom logo exists, else default)
        $logoPath = storage_path('app/templates/logo_custom.png');
        if (!file_exists($logoPath)) {
            $logoPath = storage_path('app/templates/logo_default.png');
        }

        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 20, 14, 30, 32);
        }

        // 1. Draw Kop Surat (Letterhead) using Times New Roman (official font)
        // Offset to the right of the logo (logo X:20, width:22, so start at X:45)
        $pdf->SetFont('Times', 'B', 16);
        $pdf->SetXY(45, 15);
        $pdf->MultiCell(145, 6, $this->encode($kop1), 0, 'C');
        $pdf->SetFont('Times', 'B', 14);
        $pdf->SetX(45);
        $pdf->Cell(145, 6, $this->encode($kop2), 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->SetX(45);
        $pdf->Cell(145, 5, $this->encode($kop3), 0, 1, 'C');

        $pdf->SetFont('Times', '', 11);
        $pdf->SetX(45);
        $pdf->MultiCell(145, 4.5, $this->encode($kopAlamat), 0, 'C');
        $pdf->Ln(4);

        // 2. Draw Separator Double Line
        $separatorY = $pdf->GetY();
        $pdf->SetLineWidth(0.8);
        $pdf->Line(20, $separatorY, 190, $separatorY);
        $pdf->Ln(5);

        // 3. Determine specific metadata based on archive type
        $title = '';
        $subTitleLabel = '';
        $extraLabel = '';
        $extraValue = '';

        if ($definition['type'] === 'laporan-pkl') {
            $title = 'BUKTI SERAH TERIMA BUKU PRAKTIK KERJA LAPANGAN';
            $subTitleLabel = 'Telah diterima 1 (satu) Buku Praktik Kerja Lapangan (PKL):';
            $extraLabel = 'Nama Tempat PKL';
            $extraValue = $archive->nama_tempat_pkl ?? '-';
        } elseif ($definition['type'] === 'proposal-ta') {
            $title = 'BUKTI SERAH TERIMA BUKU PROPOSAL TUGAS AKHIR';
            $subTitleLabel = 'Telah diterima 1 (satu) Buku Proposal Tugas Akhir (TA):';
            $extraLabel = 'Tahun Proposal TA';
            $extraValue = $archive->tahun ?? '-';
        } elseif ($definition['type'] === 'laporan-ta') {
            $title = 'BUKTI SERAH TERIMA BUKU LAPORAN TUGAS AKHIR';
            $subTitleLabel = 'Telah diterima 1 (satu) Buku Laporan Tugas Akhir (LTA):';
            $extraLabel = 'Tahun Lulus';
            $extraValue = $archive->tahun ?? '-';
        }

        // 4. Draw Document Title & Number
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 6, $this->encode($title), 0, 1, 'C');
        $pdf->SetFont('Times', '', 14);
        $pdf->Cell(0, 5, $this->encode('NOMOR: ' . $nomorSurat), 0, 1, 'C');
        $pdf->Ln(6);

        // 5. Draw Opening Sentence
        $pdf->SetFont('Times', '', 14);
        $pdf->MultiCell(0, 6, $this->encode($subTitleLabel));
        $pdf->Ln(2);

        // 6. Draw Details Table
        $mhs = $archive->mahasiswa;
        $mhsName = $mhs?->user?->name ?? '-';
        $nim = $mhs?->nim ?? '-';
        $prodi = $mhs?->prodi?->nama_prodi ?? '-';

        // Resolve Jurusan dynamically from Program Studi
        $jurusan = 'Teknologi Informasi';
        if (str_contains(strtolower($prodi), 'sipil')) {
            $jurusan = 'Teknik Sipil';
        } elseif (str_contains(strtolower($prodi), 'mesin')) {
            $jurusan = 'Teknik Mesin';
        } elseif (str_contains(strtolower($prodi), 'elektro')) {
            $jurusan = 'Teknik Elektro';
        } elseif (str_contains(strtolower($prodi), 'akuntansi')) {
            $jurusan = 'Akuntansi';
        } elseif (str_contains(strtolower($prodi), 'administrasi')) {
            $jurusan = 'Administrasi Bisnis';
        }

        $details = [
            'Nama Mahasiswa' => $mhsName,
            'Nomor Induk Mahasiswa' => $nim,
            'Jurusan' => $jurusan,
            'Program Studi' => $prodi,
        ];

        if ($extraLabel) {
            $details[$extraLabel] = $extraValue;
        }

        // Draw normal properties
        foreach ($details as $label => $val) {
            $pdf->Cell(52, 9, $this->encode($label), 0, 0);
            $pdf->Cell(3, 9, ':', 0, 0);
            $pdf->Cell(0, 9.1, $this->encode($val), 0, 1);
        }

        // Draw wrapped title row (Judul Laporan PKL / Judul TA)
        $titleLabel = $definition['type'] === 'laporan-pkl'
            ? 'Judul Laporan PKL'
            : ($definition['type'] === 'proposal-ta' ? 'Judul Proposal TA' : 'Judul TA');

        $pdf->Cell(52, 9, $this->encode($titleLabel), 0, 0);
        $pdf->Cell(3, 9, ':', 0, 0);

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell(105, 9.5, $this->encode(ArsipDigital::title($archive)), 0);
        $pdf->Ln(5);

        // 8. Draw Signatures - swapped columns to match the official Word templates exactly
        $pdf->SetFont('Times', '', 14);
        $currY = $pdf->GetY();

        // Left Column (Yang Menerima - dynamic from admin settings or overrides)
        $penerimaNama = $overrides['receipt_penerima_nama'] ?? AppSetting::get('receipt_penerima_nama', 'Fathul Romdani S.Pd');
        $penerimaNip = $overrides['receipt_penerima_nip'] ?? AppSetting::get('receipt_penerima_nip', 'NUP. 199912072023091991');
        $penerimaJabatan = $overrides['receipt_penerima_jabatan'] ?? AppSetting::get('receipt_penerima_jabatan', 'Staff Perpustakaan');

        $pdf->SetXY(20, $currY);
        $pdf->Cell(80, 5, '', 0, 1, 'L'); // space alignment
        $pdf->SetX(20);
        $pdf->Cell(80, 5, $this->encode('Yang Menerima,'), 0, 1, 'L');
        $pdf->Ln(20);
        $pdf->SetX(20);
        $pdf->Cell(80, 5, $this->encode($penerimaNama), 0, 1, 'L');
        $pdf->SetX(20);
        $pdf->Cell(80, 5, $this->encode($penerimaNip), 0, 1, 'L');

        // Right Column (Yang Menyerahkan)
        $pdf->SetXY(110, $currY);
        $pdf->Cell(80, 5, $this->encode('Sukamara, ' . $verifiedAt->translatedFormat('d F Y')), 0, 1, 'L');
        $pdf->SetX(110);
        $pdf->Cell(80, 5, $this->encode('Yang Menyerahkan,'), 0, 1, 'L');
        $pdf->Ln(20);
        $pdf->SetX(110);
        $pdf->Cell(80, 5, $this->encode($mhsName), 0, 1, 'L');
        $pdf->SetX(110);
        $pdf->Cell(80, 5, $this->encode('NIM. ' . $nim), 0, 1, 'L');

        $pdf->Output('F', $outputPath);
    }

    protected function addWorkingDays(Carbon $date, int $days): Carbon
    {
        $remaining = $days;

        while ($remaining > 0) {
            $date->addDay();

            if (!$date->isWeekend()) {
                $remaining--;
            }
        }

        return $date;
    }

    protected function splitTitle(string $title, int $maxLength): array
    {
        $wrapped = wordwrap($title, $maxLength, "\n", true);

        return array_slice(explode("\n", $wrapped), 0, 2);
    }

    protected function encode(string $text): string
    {
        $encoded = iconv('UTF-8', 'windows-1252//TRANSLIT//IGNORE', $text);

        return $encoded !== false ? $encoded : $text;
    }
}
