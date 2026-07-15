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

    /**
     * Tampilkan halaman pengaturan Surat Tanda Terima.
     */
    public function receiptIndex()
    {
        $settings = [
            'receipt_penerima_nama' => AppSetting::get('receipt_penerima_nama', 'Fathul Romdani S.Pd'),
            'receipt_penerima_nip' => AppSetting::get('receipt_penerima_nip', 'NUP. 199912072023091991'),
            'receipt_penerima_jabatan' => AppSetting::get('receipt_penerima_jabatan', 'Staff Perpustakaan'),
            'receipt_kode_surat' => AppSetting::get('receipt_kode_surat', '/PL.16.A3/KM/'),
            'receipt_kop_line_1' => AppSetting::get('receipt_kop_line_1', 'KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI'),
            'receipt_kop_line_2' => AppSetting::get('receipt_kop_line_2', 'POLITEKNIK NEGERI PONTIANAK'),
            'receipt_kop_line_3' => AppSetting::get('receipt_kop_line_3', 'PERPUSTAKAAN PSDKU POLNEP DI KABUPATEN SUKAMARA'),
            'receipt_kop_alamat' => AppSetting::get('receipt_kop_alamat', 'Jalan Jenderal Ahmad Yani - Pontianak 78124, Kalimantan Barat Telepon: (0561)736180, Faksimile: (0561)740143, Kotak Pos: 1286'),
        ];

        return view('admin.settings.receipt', compact('settings'));
    }

    /**
     * Simpan perubahan pengaturan Surat Tanda Terima.
     */
    public function receiptUpdate(Request $request)
    {
        $request->validate([
            'receipt_penerima_nama' => 'required|string|max:255',
            'receipt_penerima_nip' => 'required|string|max:255',
            'receipt_penerima_jabatan' => 'required|string|max:255',
            'receipt_kode_surat' => 'required|string|max:255',
            'receipt_kop_line_1' => 'required|string|max:255',
            'receipt_kop_line_2' => 'required|string|max:255',
            'receipt_kop_line_3' => 'required|string|max:255',
            'receipt_kop_alamat' => 'required|string|max:1000',
            'receipt_logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        AppSetting::set('receipt_penerima_nama', $request->receipt_penerima_nama);
        AppSetting::set('receipt_penerima_nip', $request->receipt_penerima_nip);
        AppSetting::set('receipt_penerima_jabatan', $request->receipt_penerima_jabatan);
        AppSetting::set('receipt_kode_surat', $request->receipt_kode_surat);
        AppSetting::set('receipt_kop_line_1', $request->receipt_kop_line_1);
        AppSetting::set('receipt_kop_line_2', $request->receipt_kop_line_2);
        AppSetting::set('receipt_kop_line_3', $request->receipt_kop_line_3);
        AppSetting::set('receipt_kop_alamat', $request->receipt_kop_alamat);

        if ($request->hasFile('receipt_logo')) {
            $destDir = storage_path('app/templates');
            if (!is_dir($destDir)) {
                mkdir($destDir, 0777, true);
            }
            $request->file('receipt_logo')->move($destDir, 'logo_custom.png');
        }

        return redirect()->route('admin.settings.receipt')
            ->with('success', 'Pengaturan template Surat Tanda Terima berhasil diperbarui.');
    }

    /**
     * Aliran file logo tanda terima (dari folder private templates).
     */
    public function receiptLogo()
    {
        $logoPath = storage_path('app/templates/logo_custom.png');
        if (!file_exists($logoPath)) {
            $logoPath = storage_path('app/templates/logo_default.png');
        }

        if (!file_exists($logoPath)) {
            abort(404);
        }

        return response()->file($logoPath);
    }

    /**
     * Preview Surat Tanda Terima dengan inputan form saat ini secara real-time.
     */
    public function receiptPreview(Request $request)
    {
        $overrides = $request->validate([
            'receipt_penerima_nama' => 'required|string|max:255',
            'receipt_penerima_nip' => 'required|string|max:255',
            'receipt_penerima_jabatan' => 'required|string|max:255',
            'receipt_kode_surat' => 'required|string|max:255',
            'receipt_kop_line_1' => 'required|string|max:255',
            'receipt_kop_line_2' => 'required|string|max:255',
            'receipt_kop_line_3' => 'required|string|max:255',
            'receipt_kop_alamat' => 'required|string|max:1000',
        ]);

        // Create dummy LaporanPkl
        $archive = new \App\Models\LaporanPkl([
            'judul_pkl' => 'DESAIN DAN IMPLEMENTASI APLIKASI WEB PERPUSTAKAAN PSDKU POLNEP KABUPATEN SUKAMARA',
            'nama_tempat_pkl' => 'Kantor Bupati Sukamara - Bagian TIK',
            'pembimbing' => 'Hendra, M.T.',
            'penguji_1' => 'Agus, M.Cs.',
            'penguji_2' => 'Budi, M.T.',
            'tahun' => date('Y'),
            'nomor_surat' => '024' . $overrides['receipt_kode_surat'] . date('Y'),
            'verified_at' => now(),
        ]);

        // Setup relations
        $dummyUser = new \App\Models\User(['name' => 'MUHAMMAD RIZKY']);
        $dummyProdi = new \App\Models\Prodi(['nama_prodi' => 'Teknologi Informasi']);
        $dummyJurusan = new \App\Models\Jurusan(['nama_jurusan' => 'Teknologi Informasi']);
        $dummyProdi->setRelation('jurusan', $dummyJurusan);

        $dummyMahasiswa = new \App\Models\Mahasiswa(['nim' => '3202116001']);
        $dummyMahasiswa->setRelation('user', $dummyUser);
        $dummyMahasiswa->setRelation('prodi', $dummyProdi);

        $archive->setRelation('mahasiswa', $dummyMahasiswa);

        // Generate temporary file in storage directory to avoid OS temp permissions issues
        $tempDir = storage_path('app/temp_previews');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        $tempPath = $tempDir . '/' . uniqid('receipt_') . '.pdf';

        $service = new \App\Services\SuratTandaTerimaService();
        $service->generatePreview($archive, $overrides, $tempPath);

        return response()->file($tempPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="preview_tanda_terima.pdf"'
        ])->deleteFileAfterSend(true);
    }
}
