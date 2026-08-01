<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AppSetting;
use App\Models\Collection;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';
    protected $primaryKey = 'antrian_id';

    protected $fillable = [
        'user_id',
        'koleksi_id',
        'no_antrian',
        'status',
    ];

    /**
     * Relasi: Antrian milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi: Antrian milik satu Collection
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class, 'koleksi_id', 'koleksi_id');
    }

    /**
     * Cek dan alokasikan antrian berikutnya menjadi 'tersedia' jika stok koleksi > 0.
     * Mengirim notifikasi WhatsApp otomatis jika terkonfigurasi.
     */
    public static function checkAndNotifyAvailableQueue($koleksiId)
    {
        $collection = Collection::find($koleksiId);
        if (! $collection || $collection->stock < 1) {
            return null;
        }

        $nextInQueue = static::where('koleksi_id', $koleksiId)
            ->where('status', 'menunggu')
            ->orderBy('no_antrian', 'asc')
            ->first();

        if ($nextInQueue) {
            $nextInQueue->update(['status' => 'tersedia']);

            try {
                $nextInQueue->load(['user', 'collection.book']);
                if ($nextInQueue->user && ! empty($nextInQueue->user->no_hp)) {
                    $judulBuku = $nextInQueue->collection?->display_title ?? 'Koleksi Perpustakaan';
                    $namaAnggota = $nextInQueue->user->name;
                    $senderName = AppSetting::get('wa_sender_name', 'Perpustakaan PSDKU POLNEP');

                    $message = "Halo, {$namaAnggota}! 📚\n\n".
                               "Kabar baik! Buku *{$judulBuku}* yang Anda tunggu di antrian kini sudah *TERSEDIA* untuk dipinjam.\n\n".
                               "Silakan datang ke perpustakaan untuk memproses peminjaman buku tersebut.\n\n".
                               "Terima kasih — {$senderName}";

                    \App\Services\WhatsAppService::send($nextInQueue->user->no_hp, $message);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal mengirim WA Antrian Tersedia: '.$e->getMessage());
            }

            try {
                if ($nextInQueue->user && ! empty($nextInQueue->user->telegram_chat_id)) {
                    $judulBuku = e($nextInQueue->collection?->display_title ?? 'Koleksi Perpustakaan');
                    $namaAnggota = e($nextInQueue->user->name);

                    $tgMessage = "<b>Halo, {$namaAnggota}!</b> 📚\n\n".
                                 "Kabar baik! Buku <b>{$judulBuku}</b> yang Anda tunggu di antrian kini sudah <b>TERSEDIA</b> untuk dipinjam.\n\n".
                                 "Silakan datang ke perpustakaan untuk memproses peminjaman buku tersebut.\n\n".
                                 "<i>SIPUS PSDKU POLNEP Sukamara</i>";

                    \App\Services\TelegramService::send($nextInQueue->user->telegram_chat_id, $tgMessage);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal mengirim Telegram Antrian Tersedia: '.$e->getMessage());
            }
        }

        return $nextInQueue;
    }
}

