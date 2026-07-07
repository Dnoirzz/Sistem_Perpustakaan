<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan WhatsApp.
     */
    public function waIndex()
    {
        $settings = [
            'fonnte_token' => AppSetting::get('fonnte_token', ''),
            'wa_notification_enabled' => AppSetting::get('wa_notification_enabled', 'false'),
            'wa_sender_name' => AppSetting::get('wa_sender_name', 'Perpustakaan PSDKU POLNEP'),
        ];

        return view('admin.settings.wa', compact('settings'));
    }

    /**
     * Simpan perubahan pengaturan WhatsApp.
     */
    public function waUpdate(Request $request)
    {
        $request->validate([
            'fonnte_token' => 'nullable|string',
            'wa_notification_enabled' => 'required|in:true,false',
            'wa_sender_name' => 'nullable|string|max:100',
        ]);

        AppSetting::set('fonnte_token', $request->fonnte_token ?? '');
        AppSetting::set('wa_notification_enabled', $request->wa_notification_enabled);
        AppSetting::set('wa_sender_name', $request->wa_sender_name ?? 'Perpustakaan PSDKU POLNEP');

        return redirect()->route('admin.settings.wa')
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

    /**
     * Tampilkan halaman pengaturan SMTP Email.
     */
    public function emailIndex()
    {
        $settings = [
            'mail_mailer' => AppSetting::get('mail_mailer', config('mail.default') ?? 'log'),
            'mail_host' => AppSetting::get('mail_host', config('mail.mailers.smtp.host') ?? '127.0.0.1'),
            'mail_port' => AppSetting::get('mail_port', config('mail.mailers.smtp.port') ?? '2525'),
            'mail_encryption' => AppSetting::get('mail_encryption', config('mail.mailers.smtp.encryption') ?? 'none'),
            'mail_username' => AppSetting::get('mail_username', config('mail.mailers.smtp.username') ?? ''),
            'mail_password' => AppSetting::get('mail_password', config('mail.mailers.smtp.password') ?? ''),
            'mail_from_address' => AppSetting::get('mail_from_address', config('mail.from.address') ?? 'hello@example.com'),
            'mail_from_name' => AppSetting::get('mail_from_name', config('mail.from.name') ?? 'Perpustakaan PSDKU POLNEP'),
        ];

        return view('admin.settings.email', compact('settings'));
    }

    /**
     * Simpan pengaturan SMTP Email.
     */
    public function emailUpdate(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|in:smtp,log',
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
            'mail_encryption' => 'required|in:none,tls,ssl',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string|max:100',
        ]);

        AppSetting::set('mail_mailer', $request->mail_mailer);
        AppSetting::set('mail_host', $request->mail_host ?? '');
        AppSetting::set('mail_port', $request->mail_port ?? 25);
        AppSetting::set('mail_encryption', $request->mail_encryption);
        AppSetting::set('mail_username', $request->mail_username ?? '');
        AppSetting::set('mail_password', $request->mail_password ?? '');
        AppSetting::set('mail_from_address', $request->mail_from_address);
        AppSetting::set('mail_from_name', $request->mail_from_name);

        return redirect()->route('admin.settings.email')
            ->with('success', 'Pengaturan SMTP Email berhasil diperbarui.');
    }

    /**
     * Kirim email uji coba secara real-time dengan pengaturan yang diinputkan.
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
            'test_subject' => 'required|string|max:200',
            'test_body' => 'required|string',
            'mail_mailer' => 'required|in:smtp,log',
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|integer',
            'mail_encryption' => 'required|in:none,tls,ssl',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        try {
            // Simpan konfigurasi asli
            $originalConfig = config('mail');

            // Set konfigurasi dinamis untuk mailer default dan smtp
            config([
                'mail.default' => $request->mail_mailer,
                'mail.mailers.smtp.host' => $request->mail_host,
                'mail.mailers.smtp.port' => $request->mail_port,
                'mail.mailers.smtp.encryption' => $request->mail_encryption === 'none' ? null : $request->mail_encryption,
                'mail.mailers.smtp.username' => $request->mail_username,
                'mail.mailers.smtp.password' => $request->mail_password,
                'mail.from.address' => $request->mail_from_address,
                'mail.from.name' => $request->mail_from_name,
            ]);

            // Bersihkan instans mailer yang sudah di-resolve agar memakai konfigurasi baru
            Mail::purge();

            // Kirim email mentah
            Mail::raw($request->test_body, function ($message) use ($request) {
                $message->to($request->test_email)
                    ->subject($request->test_subject);
            });

            // Kembalikan konfigurasi asli
            config(['mail' => $originalConfig]);
            Mail::purge();

            return response()->json([
                'success' => true,
                'message' => 'Email uji coba berhasil dikirim ke ' . $request->test_email
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email: ' . $e->getMessage()
            ], 400);
        }
    }
}
