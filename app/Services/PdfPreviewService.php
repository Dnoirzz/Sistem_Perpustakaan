<?php

namespace App\Services;

use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class PdfPreviewService
{
    public function generate(string $sourceRelativePath): string
    {
        $sourcePath = storage_path('app/' . ltrim($sourceRelativePath, '/'));

        if (! file_exists($sourcePath)) {
            throw new \RuntimeException('File PDF sumber tidak ditemukan.');
        }

        $directory = storage_path('app/private/arsip/preview');
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $outputRelativePath = 'private/arsip/preview/preview_' . Str::uuid() . '.pdf';
        $outputPath = storage_path('app/' . $outputRelativePath);

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($sourcePath);

        for ($pageNumber = 1; $pageNumber <= min($pageCount, 10); $pageNumber++) {
            $templateId = $pdf->importPage($pageNumber);
            $size = $pdf->getTemplateSize($templateId);
            $orientation = ($size['width'] ?? 0) > ($size['height'] ?? 0) ? 'L' : 'P';

            $pdf->AddPage($orientation, [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);
        }

        $pdf->Output('F', $outputPath);

        return $outputRelativePath;
    }
}
