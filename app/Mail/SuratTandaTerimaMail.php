<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuratTandaTerimaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $recipientName,
        public string $jenisArsip,
        public string $judulArsip,
        public string $nomorSurat,
        public string $attachmentPath
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[SIPUS POLNEP] Arsip Anda Telah Diverifikasi - Surat Tanda Terima Terlampir',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.surat_tanda_terima',
        );
    }

    public function attachments(): array
    {
        $absolutePath = storage_path('app/' . ltrim($this->attachmentPath, '/'));

        if (! file_exists($absolutePath)) {
            return [];
        }

        return [
            Attachment::fromPath($absolutePath)
                ->as('surat-tanda-terima.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
