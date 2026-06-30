<?php

namespace App\Services;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Mengecek apakah notifikasi WA diaktifkan di pengaturan sistem.
     *
     * @return bool
     */
    public static function isEnabled(): bool
    {
        return AppSetting::get('wa_notification_enabled', 'false') === 'true';
    }

    /**
     * Mengirim pesan WhatsApp via Fonnte API.
     *
     * @param string $phone Nomor HP penerima.
     * @param string $message Isi pesan WhatsApp.
     * @return bool True jika berhasil dikirim, false jika gagal.
     */
    public static function send(string $phone, string $message): bool
    {
        // 1. Cek apakah fitur WA diaktifkan
        if (!self::isEnabled()) {
            Log::info("WhatsAppService: Pengiriman pesan di-skip karena fitur dinonaktifkan.");
            return false;
        }

        // 2. Ambil token dari database
        $token = AppSetting::get('fonnte_token');
        if (empty($token)) {
            Log::warning("WhatsAppService: Gagal mengirim pesan karena Fonnte API Token belum dikonfigurasi.");
            return false;
        }

        // 3. Validasi dan normalisasi nomor HP
        if (empty($phone)) {
            Log::warning("WhatsAppService: Gagal mengirim pesan karena nomor HP kosong.");
            return false;
        }

        $formattedPhone = self::formatPhoneNumber($phone);

        // 4. Kirim request ke Fonnte API
        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->timeout(10)->post('https://api.fonnte.com/send', [
                'target' => $formattedPhone,
                'message' => $message,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['status']) && $responseData['status'] === true) {
                    Log::info("WhatsAppService: Pesan berhasil dikirim ke {$formattedPhone}.");
                    return true;
                } else {
                    $reason = $responseData['reason'] ?? 'Unknown reason';
                    Log::warning("WhatsAppService: Fonnte API merespons dengan status error: {$reason}. Detail: " . json_encode($responseData));
                    return false;
                }
            } else {
                Log::warning("WhatsAppService: Gagal terhubung ke Fonnte API. HTTP Status: " . $response->status() . " Response: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("WhatsAppService: Terjadi exception saat mengirim pesan ke {$formattedPhone}. Pesan Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Menormalisasi nomor telepon ke format internasional (misal: 628xxxx).
     *
     * @param string $phone
     * @return string
     */
    private static function formatPhoneNumber(string $phone): string
    {
        // Hapus karakter non-digit (seperti +, -, spasi, dll)
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Jika nomor diawali dengan '0', ganti menjadi '62'
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // Jika nomor langsung diawali dengan '8', tambahkan '62' di depannya
        if (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}
