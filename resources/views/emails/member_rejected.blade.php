<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Pendaftaran Akun - SIPUS POLNEP</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8faff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #131b2e;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 20px; border: 1px solid #e2e7ff; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #ba1a1a, #93000a); padding: 30px 20px; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 22px; font-weight: 700;">SIPUS PSDKU POLNEP</h1>
                            <p style="margin: 5px 0 0; font-size: 13px; opacity: 0.9;">Perpustakaan Digital PSDKU POLNEP Sukamara</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 35px 30px;">
                            <h2 style="margin: 0 0 15px; font-size: 18px; color: #ba1a1a;">Informasi Pendaftaran Akun Perpustakaan</h2>
                            <p style="margin: 0 0 15px; font-size: 14px; line-height: 1.6; color: #464555;">
                                Halo <strong>{{ $userName }}</strong>,
                            </p>
                            <p style="margin: 0 0 20px; font-size: 14px; line-height: 1.6; color: #464555;">
                                Mohon maaf, pendaftaran akun perpustakaan digital Anda belum dapat disetujui oleh Petugas Perpustakaan PSDKU POLNEP Sukamara.
                            </p>
                            
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffdad6; border-radius: 12px; padding: 15px; margin-bottom: 25px; border: 1px solid #ffb4ab;">
                                <tr>
                                    <td style="font-size: 13px; color: #93000a; line-height: 1.5;">
                                        <strong>Alasan Penolakan Petugas:</strong><br>
                                        <em>"{{ $reason }}"</em>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 25px; font-size: 14px; line-height: 1.6; color: #464555;">
                                Anda dapat mendaftar kembali di aplikasi SIPUS POLNEP dengan melampirkan foto Kartu Tanda Mahasiswa (KTM) / Kartu Identitas yang jelas dan valid.
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('register') }}" target="_blank" style="display: inline-block; padding: 14px 30px; background-color: #283044; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 700; border-radius: 12px;">Daftar Ulang Kembali &rarr;</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #faf8ff; padding: 20px; border-top: 1px solid #eaedff; font-size: 12px; color: #777587;">
                            <p style="margin: 0 0 5px;">Pesan ini dikirim otomatis oleh Sistem Informasi Perpustakaan PSDKU POLNEP Sukamara.</p>
                            <p style="margin: 0;">&copy; {{ date('Y') }} PSDKU POLNEP Sukamara. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
