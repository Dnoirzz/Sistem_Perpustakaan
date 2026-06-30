<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Tanda Terima Arsip</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f8fb; padding:24px; color:#163047;">
    <div style="max-width:640px; margin:0 auto; background:#ffffff; border-radius:18px; padding:32px; border:1px solid #d8e4ee;">
        <h1 style="margin:0 0 16px; font-size:24px; color:#00a5c0;">Arsip Anda Telah Diverifikasi</h1>
        <p style="margin:0 0 12px;">Halo {{ $recipientName }},</p>
        <p style="margin:0 0 12px;">
            Arsip digital Anda untuk <strong>{{ $jenisArsip }}</strong> dengan judul
            <strong>{{ $judulArsip }}</strong> telah diverifikasi oleh petugas perpustakaan.
        </p>
        <p style="margin:0 0 12px;">
            Nomor surat tanda terima: <strong>{{ $nomorSurat }}</strong>.
        </p>
        <p style="margin:0 0 12px;">
            Surat tanda terima kami lampirkan pada email ini. Mohon bawa surat tersebut saat menyerahkan dokumen fisik ke perpustakaan.
        </p>
        <p style="margin:16px 0 0;">Salam,<br>Perpustakaan PSDKU POLNEP</p>
    </div>
</body>
</html>
