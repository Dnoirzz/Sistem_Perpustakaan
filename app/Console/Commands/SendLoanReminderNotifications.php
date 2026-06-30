<?php

namespace App\Console\Commands;

use App\Models\Loan;
use App\Models\AppSetting;
use App\Services\WhatsAppService;
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
    protected $description = 'Kirim notifikasi pengingat H-1 jatuh tempo dan status terlambat via WhatsApp';

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
            if ($loan->user && !empty($loan->user->no_hp)) {
                $namaAnggota = $loan->user->name;
                $judulBuku = $loan->collection->book->judul ?? 'Buku Perpustakaan';
                $btsWaktu = Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y');

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
            if ($loan->user && !empty($loan->user->no_hp)) {
                $namaAnggota = $loan->user->name;
                $judulBuku = $loan->collection->book->judul ?? 'Buku Perpustakaan';
                $btsWaktu = Carbon::parse($loan->bts_waktu)->translatedFormat('d M Y');
                $daysLate = Carbon::parse($loan->bts_waktu)->diffInDays(Carbon::today());

                $message = "Halo, {$namaAnggota}! ⚠️\n\n" .
                           "Buku yang Anda pinjam telah *MELEWATI BATAS WAKTU* pengembalian (TERLAMBAT):\n" .
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
        }
        $this->info("Berhasil mengirim {$successOverdueCount} notifikasi terlambat.");
        
        Log::info("Scheduler loans:send-reminders selesai. H-1 terkirim: {$successH1Count}, Terlambat terkirim: {$successOverdueCount}");
        
        return Command::SUCCESS;
    }
}
