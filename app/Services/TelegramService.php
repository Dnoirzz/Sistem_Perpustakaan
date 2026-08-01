<?php

namespace App\Services;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    /**
     * Mengecek apakah notifikasi Telegram diaktifkan di pengaturan sistem.
     *
     * @return bool
     */
    public static function isEnabled(): bool
    {
        return AppSetting::get('telegram_notification_enabled', 'false') === 'true';
    }

    /**
     * Mengambil Token Bot Telegram dari database pengaturan.
     *
     * @return string|null
     */
    public static function getBotToken(): ?string
    {
        return AppSetting::get('telegram_bot_token');
    }

    /**
     * Mengirim pesan ke pengguna via Telegram Bot API.
     *
     * @param string $chatId Telegram Chat ID penerima.
     * @param string $message Isi pesan yang akan dikirim.
     * @param string $parseMode Format pesan ('HTML' atau 'Markdown').
     * @return bool True jika berhasil dikirim, false jika gagal.
     */
    public static function send(string $chatId, string $message, string $parseMode = 'HTML'): bool
    {
        // 1. Cek apakah fitur Telegram diaktifkan
        if (!self::isEnabled()) {
            Log::info("TelegramService: Pengiriman pesan di-skip karena fitur dinonaktifkan.");
            return false;
        }

        // 2. Ambil token bot dari database
        $token = self::getBotToken();
        if (empty($token)) {
            Log::warning("TelegramService: Gagal mengirim pesan karena Telegram Bot Token belum dikonfigurasi.");
            return false;
        }

        // 3. Validasi Chat ID penerima
        if (empty($chatId)) {
            Log::warning("TelegramService: Gagal mengirim pesan karena Telegram Chat ID kosong.");
            return false;
        }

        // 4. Kirim request ke Telegram Bot API
        try {
            $endpoint = "https://api.telegram.org/bot{$token}/sendMessage";

            $response = Http::timeout(10)->post($endpoint, [
                'chat_id' => trim($chatId),
                'text' => $message,
                'parse_mode' => $parseMode,
                'disable_web_page_preview' => true,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['ok']) && $responseData['ok'] === true) {
                    Log::info("TelegramService: Pesan berhasil dikirim ke Chat ID {$chatId}.");
                    return true;
                } else {
                    $description = $responseData['description'] ?? 'Unknown error';
                    Log::warning("TelegramService: Telegram API merespons dengan status error: {$description}");
                    return false;
                }
            } else {
                Log::warning("TelegramService: Gagal terhubung ke Telegram API. HTTP Status: " . $response->status() . " Body: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("TelegramService: Terjadi exception saat mengirim pesan ke Chat ID {$chatId}. Error: " . $e->getMessage());
            return false;
        }
    }
}
