<?php

namespace App\Services;

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
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $templatePath = storage_path('app/templates/surat_tanda_terima.pdf');
        $deadline = $this->addWorkingDays($verifiedAt->copy(), 7);

        if (file_exists($templatePath)) {
            $this->generateFromTemplate($templatePath, $absolutePath, $archive, $definition, $nomorSurat, $verifiedAt, $deadline);
        } else {
            $this->generateFallbackPdf($absolutePath, $archive, $definition, $nomorSurat, $verifiedAt, $deadline);
        }

        return [
            'path' => $relativePath,
            'nomor_surat' => $nomorSurat,
            'verified_at' => $verifiedAt,
            'deadline' => $deadline,
        ];
    }

    protected function generateNomorSurat(Model $archive, array $definition, Carbon $verifiedAt): string
    {
        $sequence = $definition['model']::query()
            ->whereYear('verified_at', $verifiedAt->year)
            ->whereNotNull('nomor_surat')
            ->when($archive->exists, fn ($query) => $query->whereKeyNot($archive->getKey()))
            ->count() + 1;

        return sprintf('STT/%s/%d/%04d', $definition['code'], $verifiedAt->year, $sequence);
    }

    protected function generateFromTemplate(
        string $templatePath,
        string $outputPath,
        Model $archive,
        array $definition,
        string $nomorSurat,
        Carbon $verifiedAt,
        Carbon $deadline
    ): void {
        $pdf = new Fpdi();
        $pageId = $pdf->setSourceFile($templatePath);
        $templateId = $pdf->importPage(min(1, $pageId));
        $size = $pdf->getTemplateSize($templateId);
        $orientation = ($size['width'] ?? 0) > ($size['height'] ?? 0) ? 'L' : 'P';

        $pdf->AddPage($orientation, [$size['width'], $size['height']]);
        $pdf->useTemplate($templateId);
        $pdf->SetFont('Arial', '', 11);

        $lines = $this->splitTitle(ArsipDigital::title($archive), 62);
        $pdf->SetXY(55, 70);
        $pdf->Cell(100, 6, $this->encode($nomorSurat), 0, 1);
        $pdf->SetXY(70, 120);
        $pdf->Cell(100, 6, $this->encode($archive->mahasiswa?->user?->name ?? '-'), 0, 1);
        $pdf->SetXY(70, 128);
        $pdf->Cell(100, 6, $this->encode($archive->mahasiswa?->nim ?? '-'), 0, 1);
        $pdf->SetXY(70, 136);
        $pdf->Cell(100, 6, $this->encode($archive->mahasiswa?->prodi?->prodi_name ?? '-'), 0, 1);
        $pdf->SetXY(70, 144);
        $pdf->Cell(100, 6, $this->encode($definition['full_label']), 0, 1);
        $pdf->SetXY(70, 152);
        $pdf->MultiCell(110, 6, $this->encode($lines[0] ?? '-'), 0);
        if (isset($lines[1])) {
            $pdf->SetXY(70, 158);
            $pdf->MultiCell(110, 6, $this->encode($lines[1]), 0);
        }
        $pdf->SetXY(70, 168);
        $pdf->Cell(100, 6, $this->encode($archive->pembimbing ?? '-'), 0, 1);
        $pdf->SetXY(70, 176);
        $pdf->Cell(100, 6, $this->encode((string) ($archive->tahun ?? '-')), 0, 1);
        $pdf->SetXY(70, 195);
        $pdf->Cell(100, 6, $this->encode($verifiedAt->translatedFormat('d F Y')), 0, 1);
        $pdf->SetXY(55, 210);
        $pdf->Cell(100, 6, $this->encode($deadline->translatedFormat('d F Y')), 0, 1);
        $pdf->SetXY(105, 235);
        $pdf->Cell(100, 6, $this->encode($verifiedAt->translatedFormat('d F Y')), 0, 1);
        $pdf->SetXY(35, 270);
        $pdf->Cell(80, 6, $this->encode($archive->mahasiswa?->user?->name ?? '-'), 0, 1);
        $pdf->SetXY(85, 285);
        $pdf->Cell(100, 6, $this->encode($nomorSurat . ' | ' . $verifiedAt->translatedFormat('d F Y')), 0, 1);

        $pdf->Output('F', $outputPath);
    }

    protected function generateFallbackPdf(
        string $outputPath,
        Model $archive,
        array $definition,
        string $nomorSurat,
        Carbon $verifiedAt,
        Carbon $deadline
    ): void {
        $pdf = new Fpdi();
        $pdf->AddPage('P', 'A4');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, $this->encode('PERPUSTAKAAN PSDKU POLNEP'), 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, $this->encode('SURAT TANDA TERIMA ARSIP DIGITAL'), 0, 1, 'C');
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(0, 7, $this->encode('Nomor: ' . $nomorSurat), 0, 1);
        $pdf->Ln(4);
        $pdf->MultiCell(0, 7, $this->encode('Perpustakaan PSDKU POLNEP menerangkan bahwa mahasiswa berikut telah menyerahkan arsip digital melalui SIPUS POLNEP:'));
        $pdf->Ln(2);
        $pdf->Cell(50, 7, $this->encode('Nama Mahasiswa'));
        $pdf->Cell(0, 7, $this->encode(': ' . ($archive->mahasiswa?->user?->name ?? '-')), 0, 1);
        $pdf->Cell(50, 7, $this->encode('NIM'));
        $pdf->Cell(0, 7, $this->encode(': ' . ($archive->mahasiswa?->nim ?? '-')), 0, 1);
        $pdf->Cell(50, 7, $this->encode('Program Studi'));
        $pdf->Cell(0, 7, $this->encode(': ' . ($archive->mahasiswa?->prodi?->prodi_name ?? '-')), 0, 1);
        $pdf->Cell(50, 7, $this->encode('Jenis Arsip'));
        $pdf->Cell(0, 7, $this->encode(': ' . $definition['full_label']), 0, 1);
        $pdf->Cell(50, 7, $this->encode('Pembimbing'));
        $pdf->Cell(0, 7, $this->encode(': ' . ($archive->pembimbing ?? '-')), 0, 1);
        $pdf->Cell(50, 7, $this->encode('Tahun'));
        $pdf->Cell(0, 7, $this->encode(': ' . ($archive->tahun ?? '-')), 0, 1);
        $pdf->Ln(2);
        $pdf->MultiCell(0, 7, $this->encode('Judul: ' . ArsipDigital::title($archive)));
        $pdf->Ln(3);
        $pdf->Cell(50, 7, $this->encode('Tanggal Verifikasi'));
        $pdf->Cell(0, 7, $this->encode(': ' . $verifiedAt->translatedFormat('d F Y')), 0, 1);
        $pdf->Cell(50, 7, $this->encode('Batas Penyerahan Fisik'));
        $pdf->Cell(0, 7, $this->encode(': ' . $deadline->translatedFormat('d F Y')), 0, 1);
        $pdf->Ln(12);
        $pdf->Cell(0, 7, $this->encode('Sukamara, ' . $verifiedAt->translatedFormat('d F Y')), 0, 1, 'R');
        $pdf->Ln(18);
        $pdf->Cell(0, 7, $this->encode('(' . ($archive->mahasiswa?->user?->name ?? '-') . ')'), 0, 1, 'L');
        $pdf->Output('F', $outputPath);
    }

    protected function addWorkingDays(Carbon $date, int $days): Carbon
    {
        $remaining = $days;

        while ($remaining > 0) {
            $date->addDay();

            if (! $date->isWeekend()) {
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
