<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan WhatsApp.
     */
    public function index()
    {
        $settings = [
            'fonnte_token' => AppSetting::get('fonnte_token', ''),
            'wa_notification_enabled' => AppSetting::get('wa_notification_enabled', 'false'),
            'wa_sender_name' => AppSetting::get('wa_sender_name', 'Perpustakaan PSDKU POLNEP'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Simpan perubahan pengaturan WhatsApp.
     */
    public function update(Request $request)
    {
        $request->validate([
            'fonnte_token' => 'nullable|string',
            'wa_notification_enabled' => 'required|in:true,false',
            'wa_sender_name' => 'nullable|string|max:100',
        ]);

        AppSetting::set('fonnte_token', $request->fonnte_token ?? '');
        AppSetting::set('wa_notification_enabled', $request->wa_notification_enabled);
        AppSetting::set('wa_sender_name', $request->wa_sender_name ?? 'Perpustakaan PSDKU POLNEP');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan WhatsApp berhasil diperbarui.');
    }

    /**
     * Kirim pesan WhatsApp uji coba.
     */
    public function testWa(Request $request)
    {
        $request->validate([
            'test_phone' => 'required|string',
            'test_message' => 'required|string',
        ]);

        // Kirim WA menggunakan WhatsAppService yang memproses token saat ini
        // Kita juga bisa kirim pesan custom dengan footer nama pengirim
        $senderName = AppSetting::get('wa_sender_name', 'Perpustakaan PSDKU POLNEP');
        $fullMessage = $request->test_message . "\n\n---\nKirim uji coba dari: " . $senderName;

        $sent = WhatsAppService::send($request->test_phone, $fullMessage);

        if ($sent) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan uji coba berhasil dikirim ke ' . $request->test_phone
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan uji coba. Silakan cek log Laravel untuk melihat detail kesalahannya.'
            ], 400);
        }
    }
}
