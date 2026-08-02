<?php

namespace App\Console\Commands;

use App\Models\Loan;
use App\Models\AppSetting;
use App\Models\NotificationCustom;
use App\Services\WhatsAppService;
use App\Services\TelegramService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendLoanReminderNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loans:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi pengingat H-1 jatuh tempo dan status terlambat via WhatsApp, Telegram, dan Lonceng Web';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi status keterlambatan...');
        // Sinkronisasi status terlambat terlebih dahulu
        if (method_exists(Loan::class, 'syncOverdueStatuses')) {
            Loan::syncOverdueStatuses();
        }

        $senderName = AppSetting::get('wa_sender_name', 'Perpustakaan PSDKU POLNEP');
        
        // --- 1. PROSES PENGINGAT H-1 JATUH TEMPO ---
        $tomorrow = Carbon::tomorrow()->toDateString();
        $this->info("Mencari peminjaman yang jatuh tempo besok ({$tomorrow})...");
        
        $upcomingLoans = Loan::with(['user', 'collection.book'])
            ->where('status', 'dipinjam')
            ->whereDate('bts_waktu', $tomorrow)
            ->get();

        $this->info("Ditemukan " . $upcomingLoans->count() . " peminjaman H-1.");
        
        $successH1Count = 0;
        foreach ($upcomingLoans as $loan) {
            $judulBuku = $loan->collection?->display_title ?? 'Buku Perpustakaan';
            $btsWaktu = Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y');

            // Kirim Notifikasi Lonceng Web
            if ($loan->user_id) {
                $targetUrl = $loan->user?->isDosen() ? route('dosen.loans.active') : route('mahasiswa.loans.active');
                NotificationCustom::create([
                    'user_id' => $loan->user_id,
                    'title' => 'Pengingat Pengembalian Buku (H-1)',
                    'message' => "Buku \"{$judulBuku}\" akan jatuh tempo BESOK ({$btsWaktu}). Mohon persiapkan pengembalian.",
                    'url' => $targetUrl,
                    'type' => 'warning',
                    'is_read' => false,
                ]);
            }

            if ($loan->user && !empty($loan->user->no_hp)) {
                $namaAnggota = $loan->user->name;

                $message = "Halo, {$namaAnggota}! ⏰\n\n" .
                           "Ini adalah pengingat bahwa batas pengembalian buku berikut jatuh tempo *BESOK*:\n" .
                           "• Judul Buku: *{$judulBuku}*\n" .
                           "• Tanggal Jatuh Tempo: *{$btsWaktu}*\n\n" .
                           "Mohon kembalikan tepat waktu untuk menghindari denda keterlambatan.\n\n" .
                           "Terima kasih — {$senderName}";

                $sent = WhatsAppService::send($loan->user->no_hp, $message);
                if ($sent) {
                    $successH1Count++;
                }
                // Beri jeda 1 detik untuk menghindari rate limit API
                sleep(1);
            }

            // Kirim Telegram H-1 jika terkonfigurasi
            if ($loan->user && !empty($loan->user->telegram_chat_id)) {
                $namaAnggota = e($loan->user->name);
                $judulBukuEsc = e($judulBuku);

                $tgMessage = "<b>Halo, {$namaAnggota}!</b> ⏰\n\n" .
                             "Ini adalah pengingat bahwa batas pengembalian buku berikut jatuh tempo <b>BESOK</b>:\n" .
                             "• Judul Buku: <b>{$judulBukuEsc}</b>\n" .
                             "• Tanggal Jatuh Tempo: <b>{$btsWaktu}</b>\n\n" .
                             "Mohon kembalikan tepat waktu untuk menghindari denda keterlambatan.\n\n" .
                             "<i>SIPUS PSDKU POLNEP Sukamara</i>";

                TelegramService::send($loan->user->telegram_chat_id, $tgMessage);
            }
        }
        $this->info("Berhasil mengirim {$successH1Count} notifikasi H-1.");

        // --- 2. PROSES PENGINGAT TERLAMBAT ---
        $this->info("Mencari peminjaman dengan status terlambat...");
        
        $overdueLoans = Loan::with(['user', 'collection.book'])
            ->where('status', 'terlambat')
            ->get();

        $this->info("Ditemukan " . $overdueLoans->count() . " peminjaman terlambat.");
        
        $successOverdueCount = 0;
        foreach ($overdueLoans as $loan) {
            $judulBuku = $loan->collection?->display_title ?? 'Buku Perpustakaan';
            $btsWaktu = Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y');
            $daysLate = Carbon::parse($loan->bts_waktu)->diffInDays(Carbon::today());

            // Kirim Notifikasi Lonceng Web
            if ($loan->user_id) {
                $targetUrl = $loan->user?->isDosen() ? route('dosen.loans.active') : route('mahasiswa.loans.active');
                NotificationCustom::create([
                    'user_id' => $loan->user_id,
                    'title' => 'Peringatan Terlambat Pengembalian',
                    'message' => "Buku yang anda pinjam dengan judul \"{$judulBuku}\" telah melewati batas waktu pengembalian selama {$daysLate} hari. Segera lakukan pengembalian buku ke perpustakaan.",
                    'url' => $targetUrl,
                    'type' => 'danger',
                    'is_read' => false,
                ]);
            }

            if ($loan->user && !empty($loan->user->no_hp)) {
                $namaAnggota = $loan->user->name;

                $message = "Halo, {$namaAnggota}! ⚠️\n\n" .
                           "Buku yang Anda pinjam telah *MELEWATI BATAS WAKTU* pengembalian:\n" .
                           "• Judul Buku: *{$judulBuku}*\n" .
                           "• Tanggal Jatuh Tempo: {$btsWaktu}\n" .
                           "• Keterlambatan: *{$daysLate} Hari*\n\n" .
                           "Mohon segera kembalikan buku tersebut ke perpustakaan untuk menghentikan akumulasi denda keterlambatan.\n\n" .
                           "Terima kasih — {$senderName}";

                $sent = WhatsAppService::send($loan->user->no_hp, $message);
                if ($sent) {
                    $successOverdueCount++;
                }
                // Beri jeda 1 detik untuk menghindari rate limit API
                sleep(1);
            }

            // Kirim Telegram Terlambat jika terkonfigurasi
            if ($loan->user && !empty($loan->user->telegram_chat_id)) {
                $namaAnggota = e($loan->user->name);
                $judulBukuEsc = e($judulBuku);

                $tgMessage = "<b>Halo, {$namaAnggota}!</b> ⚠️\n\n" .
                             "Buku yang Anda pinjam telah <b>MELEWATI BATAS WAKTU</b> pengembalian:\n" .
                             "• Judul Buku: <b>{$judulBukuEsc}</b>\n" .
                             "• Tanggal Jatuh Tempo: {$btsWaktu}\n" .
                             "• Keterlambatan: <b>{$daysLate} Hari</b>\n\n" .
                             "Mohon segera kembalikan buku tersebut ke perpustakaan untuk menghentikan akumulasi denda keterlambatan.\n\n" .
                             "<i>SIPUS PSDKU POLNEP Sukamara</i>";

                TelegramService::send($loan->user->telegram_chat_id, $tgMessage);
            }
        }
        $this->info("Berhasil mengirim {$successOverdueCount} notifikasi terlambat.");
        
        Log::info("Scheduler loans:send-reminders selesai. H-1 terkirim: {$successH1Count}, Terlambat terkirim: {$successOverdueCount}");
        
        return Command::SUCCESS;
    }
}
