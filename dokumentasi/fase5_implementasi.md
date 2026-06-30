# Dokumentasi Implementasi Fase 5: Arsip Digital

**Tanggal update:** 30 Juni 2026  
**Status:** Implementasi kode utama selesai, menunggu konfigurasi lingkungan dan uji end-to-end

## Ringkasan

Fase 5 untuk modul **Arsip Digital / Repository Mahasiswa** sudah diimplementasikan pada level kode.  
Fitur yang sudah dibangun mencakup:

- Upload arsip oleh mahasiswa untuk 3 jenis dokumen:
  - Laporan PKL
  - Proposal TA
  - Laporan TA
- Riwayat arsip mahasiswa dengan status:
  - `pending`
  - `diverifikasi`
  - `aktif`
  - `ditolak`
- Katalog arsip untuk mahasiswa dan dosen
- Preview PDF 10 halaman pertama
- Verifikasi arsip oleh petugas
- Penolakan arsip dengan catatan petugas
- Konfirmasi penerimaan fisik arsip
- Generate surat tanda terima PDF
- Pengiriman surat tanda terima via email
- Integrasi arsip aktif ke tabel `collections` agar bisa dipakai untuk booking, peminjaman, dan pengembalian fisik

## File dan Komponen yang Dibuat / Diubah

### Backend inti

- `app/Support/ArsipDigital.php`
  - Helper pemetaan tipe arsip, label, status, field judul, dan pencarian lintas model.

- `database/migrations/2026_06_30_000001_add_fase5_fields_to_arsip_tables.php`
  - Menambahkan field:
    - `status`
    - `catatan_petugas`
    - `preview_pdf`
    - `surat_tanda_terima_pdf`
    - `nomor_surat`
    - `verified_at`
    - `received_at`

- `app/Services/PdfPreviewService.php`
  - Menghasilkan file preview PDF maksimal 10 halaman menggunakan FPDI.

- `app/Services/SuratTandaTerimaService.php`
  - Membuat surat tanda terima arsip.
  - Mendukung 2 mode:
    - memakai template PDF jika tersedia
    - fallback generator PDF jika template belum tersedia

- `app/Mail/SuratTandaTerimaMail.php`
  - Mailable untuk mengirim surat tanda terima ke email mahasiswa.

### Controller baru

- `app/Http/Controllers/Mahasiswa/ArsipController.php`
  - `index`
  - `store`
  - `edit`
  - `update`
  - `destroy`

- `app/Http/Controllers/Petugas/ArsipController.php`
  - `index`
  - `show`
  - `verify`
  - `reject`
  - `confirmReceipt`
  - `edit`
  - `update`
  - `destroy`
  - `download`
  - `downloadSurat`

- `app/Http/Controllers/ArsipKatalogController.php`
  - `index`
  - `show`
  - `preview`

### Model yang diperbarui

- `app/Models/LaporanPkl.php`
- `app/Models/ProposalTa.php`
- `app/Models/LaporanTugasAkhir.php`
- `app/Models/Collection.php`
- `app/Models/Booking.php`

Perubahan utama:

- penambahan field fase 5 ke `$fillable`
- cast timestamp verifikasi dan penerimaan fisik
- auto delete collection saat arsip dihapus
- helper stok generik di `Collection`
- penyesuaian booking expiry agar stok arsip dan buku konsisten

### Integrasi transaksi yang diperbarui

- `app/Http/Controllers/Petugas/LoanController.php`
- `app/Http/Controllers/Petugas/BookingController.php`
- `app/Http/Controllers/Petugas/ReturnController.php`
- `app/Http/Controllers/BookingController.php`
- `app/Http/Controllers/AntrianController.php`

Perubahan utama:

- pencarian koleksi pada peminjaman tidak lagi hanya buku, tetapi juga arsip aktif
- stok koleksi diproses generik melalui `Collection::syncBackingStock()`
- booking, pengembalian, dan antrian bisa membaca `display_title` dari koleksi arsip

## View yang Dibuat

### Email

- `resources/views/emails/surat_tanda_terima.blade.php`

### Mahasiswa

- `resources/views/mahasiswa/arsip/index.blade.php`
- `resources/views/mahasiswa/arsip/edit.blade.php`
- `resources/views/mahasiswa/katalog-arsip/index.blade.php`
- `resources/views/mahasiswa/katalog-arsip/show.blade.php`

### Dosen

- `resources/views/dosen/katalog-arsip/index.blade.php`
- `resources/views/dosen/katalog-arsip/show.blade.php`

### Petugas

- `resources/views/petugas/arsip/index.blade.php`
- `resources/views/petugas/arsip/show.blade.php`
- `resources/views/petugas/arsip/edit.blade.php`

### Shared

- `resources/views/shared/arsip-katalog-index.blade.php`
- `resources/views/shared/arsip-katalog-show.blade.php`

## Route yang Ditambahkan

### Mahasiswa

- `/mahasiswa/arsip`
- `/mahasiswa/arsip/{type}/{id}/edit`
- `/mahasiswa/katalog-arsip`
- `/mahasiswa/katalog-arsip/{type}/{id}`
- `/mahasiswa/katalog-arsip/{type}/{id}/preview`

### Dosen

- `/dosen/katalog-arsip`
- `/dosen/katalog-arsip/{type}/{id}`
- `/dosen/katalog-arsip/{type}/{id}/preview`

### Petugas

- `/petugas/arsip`
- `/petugas/arsip/{type}/{id}`
- `/petugas/arsip/{type}/{id}/edit`
- `/petugas/arsip/{type}/{id}/verify`
- `/petugas/arsip/{type}/{id}/reject`
- `/petugas/arsip/{type}/{id}/confirm`
- `/petugas/arsip/{type}/{id}/download`
- `/petugas/arsip/{type}/{id}/surat`

## Navigasi yang Diperbarui

- Sidebar mahasiswa:
  - `Upload Repository` sekarang aktif ke route fase 5
  - ditambah menu `Katalog Arsip`

- Sidebar dosen:
  - ditambah menu `Katalog Arsip`

- Sidebar petugas:
  - `Kelola Buku` dipindah ke grup `Koleksi Perpustakaan`
  - ditambah submenu `Kelola Arsip Digital`

## Status Implementasi Saat Ini

### Sudah selesai di level kode

- Struktur data fase 5
- Service preview PDF
- Service surat tanda terima
- Upload dan riwayat arsip mahasiswa
- Katalog arsip mahasiswa/dosen
- Kelola arsip petugas
- Integrasi dengan sirkulasi fisik
- Cache Blade berhasil dikompilasi
- Route fase 5 berhasil terdaftar

### Belum selesai / masih perlu tindak lanjut

- Migration belum dijalankan ke database aktif
- Template final `surat_tanda_terima.pdf` belum disediakan di `storage/app/templates/`
- SMTP nyata belum dikonfigurasi di `.env`
- Uji alur end-to-end belum dijalankan penuh

## Hasil Verifikasi Teknis

### Berhasil

- `php -l` untuk file backend utama: sukses
- `php artisan view:cache`: sukses
- `php artisan route:list` untuk route arsip: sukses

### Catatan pengujian

- `php artisan test` masih gagal, tetapi kegagalannya berasal dari setup auth/factory lama project:
  - tabel `users.role_id` wajib diisi
  - test bawaan Laravel/Breeze belum disesuaikan dengan skema project ini
- Jadi kegagalan test saat ini **bukan indikasi langsung bug pada fase 5**

## Langkah Lanjutan yang Disarankan

1. Jalankan migration fase 5:
   - `php artisan migrate`

2. Siapkan template surat final:
   - `storage/app/templates/surat_tanda_terima.pdf`

3. Lengkapi konfigurasi email di `.env`

4. Uji skenario berikut:
   - mahasiswa upload arsip
   - petugas verifikasi
   - email surat terkirim
   - arsip muncul di katalog
   - petugas konfirmasi dokumen fisik
   - arsip aktif bisa dibooking dan dipinjam

5. Jika perlu, perbaiki test auth/factory agar sesuai dengan requirement `role_id` di tabel `users`
