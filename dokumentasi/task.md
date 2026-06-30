# Tracker Tugas — Aplikasi Perpustakaan PSDKU POLNEP Sukamara

## Fase 1: Setup Project & Fondasi ✅
- [x] Inisialisasi project Laravel 11
- [x] Konfigurasi `.env` (database MySQL, timezone, locale)
- [x] Buat migration files (6 migration files, 22+ tabel)
- [x] Buat 18 Eloquent Models + relasi lengkap
- [x] Buat Seeders (roles, prodi, kategori, admin default)
- [x] Jalankan migration & seed — VERIFIED ✅

## Fase 2: Autentikasi & Manajemen User ✅
- [x] Setup Laravel Breeze
- [x] Halaman login kustom (UI modern & premium)
- [x] Halaman registrasi kustom (Mahasiswa/Dosen)
- [x] Middleware role-based access control (RBAC)
- [x] Manajemen User (CRUD Petugas & Anggota oleh Admin)

## Dashboard Overhaul ✅
- [x] Desain ulang Dashboard Admin — COMPLETED ✅
- [x] Desain ulang Dashboard Petugas — COMPLETED ✅
- [x] Uji coba & verifikasi visual (Admin & Petugas) — VERIFIED ✅

## Fase 3: Manajemen Data Perpustakaan ✅
- [x] CRUD Buku & Kategori — COMPLETED ✅
- [x] CRUD Koleksi (Terakomodasi otomatis di sinkronisasi Buku & Transaksi) — COMPLETED ✅
- [x] CRUD Anggota — COMPLETED ✅
- [x] Pencarian buku — COMPLETED ✅
- [x] Uji coba & verifikasi fungsional — VERIFIED ✅
- [x] Penambahan kolom "Dipinjam" pada kelola buku — COMPLETED ✅
- [x] Proteksi edit role Anggota (Mahasiswa/Dosen terkunci) — COMPLETED ✅
- [x] Penyesuaian lebar form container (max-w-6xl) — COMPLETED ✅

## Fase 4: Transaksi Perpustakaan ✅
- [x] Peminjaman buku
- [x] Pengembalian buku
- [x] Booking online
- [x] Sistem antrian
- [x] Manajemen sanksi/denda

## Fase 5: Arsip Digital
- [x] Install dependency PDF `setasign/fpdi` dan `setasign/fpdf`
- [x] Buat migration penambahan field status, catatan petugas, preview, surat, nomor surat, dan timestamp verifikasi/terima fisik
- [x] Buat helper `ArsipDigital` untuk mapping tipe arsip, status, dan katalog lintas model
- [x] Buat `PdfPreviewService` untuk generate preview PDF 10 halaman pertama
- [x] Buat `SuratTandaTerimaService` untuk generate surat tanda terima PDF
- [x] Buat `SuratTandaTerimaMail` dan template email verifikasi arsip
- [x] Update model `LaporanPkl`, `ProposalTa`, `LaporanTugasAkhir`, dan `Collection`
- [x] Buat controller mahasiswa untuk upload, edit, update, dan hapus arsip
- [x] Buat controller petugas untuk daftar arsip, detail, verifikasi, tolak, konfirmasi fisik, edit, update, hapus, dan download
- [x] Buat controller katalog arsip untuk mahasiswa dan dosen
- [x] Tambah route fase 5 untuk mahasiswa, dosen, dan petugas
- [x] Tambah view mahasiswa: upload repository, edit arsip, katalog arsip, detail arsip
- [x] Tambah view dosen: katalog arsip dan detail arsip
- [x] Tambah view petugas: daftar arsip, detail, dan edit
- [x] Update sidebar mahasiswa, dosen, dan petugas
- [x] Integrasi arsip aktif ke alur `collections`, booking, peminjaman, dan pengembalian
- [ ] Jalankan migration fase 5 di database aktif
- [ ] Siapkan template final `storage/app/templates/surat_tanda_terima.pdf`
- [ ] Konfigurasi SMTP `.env` untuk pengiriman email nyata
- [ ] Uji end-to-end upload -> verifikasi -> email -> konfirmasi fisik -> booking/peminjaman fisik

## Fase 6: Fitur Tambahan
- [ ] Notifikasi Email (SMTP)
- [ ] Notifikasi WhatsApp
- [ ] Rekomendasi & Voting buku
- [ ] Dashboard monitoring (Admin, Petugas, Mahasiswa)
- [ ] Activity logging
- [ ] Laporan cetak/export

## Fase 7: Testing & Deployment
- [ ] Black Box Testing
- [ ] User Acceptance Testing
- [ ] Deployment
