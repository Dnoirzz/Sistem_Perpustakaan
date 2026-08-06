# Alur E2E Petugas Perpustakaan

## Sistem Informasi Perpustakaan PSDKU POLNEP Sukamara

**Tanggal pembaruan:** 4 Agustus 2026  
**Role:** Petugas Perpustakaan  
**Dashboard:** `/petugas/dashboard`  
**Prefix route:** `/petugas`

> Dokumen ini khusus untuk pengujian operasional Petugas Perpustakaan.

> **Kerahasiaan:** Password di dalam dokumen ini adalah credential akun uji internal. Ganti password default sebelum production.

---

## 1. Kredensial Petugas

| ID | Nama | Email login | Password | Status | Keterangan |
|---:|---|---|---|---|---|
| 2 | Budi | `petugas@test.com` | `password` | verified | Akun Petugas aktif pada database runtime |

### Akun Petugas pada seeder

`database/seeders/UserSeeder.php` mendefinisikan akun:

```text
Email    : petugas@perpustakaan.com
Password : password
```

Alamat ini hanya dapat digunakan jika akun tersebut benar-benar tercipta pada database baru setelah seeding. Pada database aktif saat dokumen dibuat, gunakan `petugas@test.com`.

---

## 2. Hak akses Petugas

Petugas dapat mengakses:

- Dashboard Petugas.
- Buku, kategori, dan koleksi.
- Anggota Mahasiswa/Dosen.
- Verifikasi pendaftaran dan foto identitas.
- Arsip digital dan import arsip.
- Peminjaman dan pengembalian.
- Booking dan antrian.
- Denda dan sanksi.
- Rules checklist pengembalian.
- Usulan buku dan voting.
- Laporan dan ekspor Excel.
- Notifikasi bell dan profil.

Petugas tidak boleh mengakses route Admin, misalnya `/admin/users` atau `/admin/settings`, kecuali authorization memang diubah secara khusus.

---

## 3. Login dan dashboard Petugas

1. Buka `/login`.
2. Masukkan `petugas@test.com`.
3. Masukkan password `password`.
4. Klik **Masuk**.
5. Expected result: diarahkan ke `/petugas/dashboard`.
6. Verifikasi statistik buku, anggota, transaksi, arsip, booking, antrian, usulan, dan badge tugas pending.
7. Klik ikon lonceng dan uji baca, tandai semua dibaca, serta hapus notifikasi.
8. Logout melalui menu profil.

---

## 4. Kelola buku dan kategori

### 4.1 Tambah buku

1. Buka `/petugas/books`.
2. Klik **Tambah Buku Baru**.
3. Isi judul, penulis, penerbit, tahun terbit, kategori, stok, dan cover bila tersedia.
4. Simpan.
5. Expected result: buku tersimpan dan koleksi fisik tersinkronisasi.

### 4.2 Edit buku

1. Cari buku uji.
2. Klik **Edit**.
3. Ubah metadata atau stok.
4. Simpan.
5. Expected result: data buku/koleksi diperbarui dan transaksi aktif tetap konsisten.

### 4.3 Hapus buku

1. Pilih buku uji yang tidak memiliki loan, booking, atau antrian aktif.
2. Klik **Hapus** dan konfirmasi.
3. Expected result: buku dan koleksi terhapus sesuai aturan.
4. Uji hapus buku yang masih memiliki dependensi.
5. Expected result: sistem menolak atau menampilkan peringatan.

### 4.4 Kategori

1. Buka `/petugas/categories`.
2. Tambah kategori baru.
3. Edit nama kategori.
4. Hapus kategori yang tidak digunakan.
5. Coba hapus kategori yang masih dipakai buku.
6. Expected result: kategori yang sedang dipakai tidak boleh dihapus sembarangan.

---

## 5. Import buku Excel/CSV

1. Buka `/petugas/books-import`.
2. Download template.
3. Isi kolom Judul Buku, Penulis/Pengarang, Penerbit, Tahun Terbit, Stok, dan Kategori.
4. Upload `.xlsx`, `.xls`, atau `.csv` maksimal 10 MB.
5. Expected result:
   - buku dan koleksi valid tersimpan;
   - kategori dicari secara case-insensitive dan dibuat jika belum ada;
   - duplikat kombinasi judul + penulis di-skip;
   - activity log import tercatat.
6. Upload file yang sama lagi.
7. Expected result: tidak ada buku atau stok ganda.
8. Uji file kosong/header saja, format salah, stok negatif, tahun invalid, dan field wajib kosong.
9. Expected result: proses ditolak, error baris ditampilkan, dan seluruh batch rollback.

---

## 6. Kelola anggota dan verifikasi

### 6.1 Daftar anggota

1. Buka `/petugas/members`.
2. Gunakan tab **Terverifikasi** dan **Menunggu Verifikasi**.
3. Cari berdasarkan nama, email, NIM/NIP, role, atau prodi.
4. Buka detail anggota.
5. Verifikasi pinjaman aktif, riwayat, denda, dan log baca digital.

### 6.2 Tambah anggota manual

1. Klik **Tambah Anggota**.
2. Pilih Mahasiswa atau Dosen.
3. Isi data umum dan data akademik sesuai role.
4. Simpan.
5. Expected result: profil anggota tersimpan dan dapat dipakai pada transaksi.

### 6.3 Approval anggota pending

1. Buka `/petugas/members?tab=pending`.
2. Klik **Lihat KTM**.
3. Periksa nama, NIM/NIP, prodi, dan foto identitas.
4. Klik **Setujui**.
5. Expected result: status `verified`, notifikasi anggota, percobaan email approval, dan activity log.

### 6.4 Rejection anggota pending

1. Pilih akun pending yang akan ditolak.
2. Klik **Tolak**.
3. Isi alasan penolakan.
4. Kirim.
5. Expected result: email rejection dicoba, foto KTM dihapus bila ada, user/profil pending dibersihkan, dan alasan dicatat.

---

## 7. Import arsip digital

1. Buka `/petugas/arsip-import`.
2. Pilih Laporan PKL, Proposal TA, atau Laporan TA.
3. Download template sesuai jenis.
4. Isi NIM, nama mahasiswa, prodi, judul, pembimbing, penguji, tahun, dan tempat PKL bila tipe PKL.
5. Upload file.
6. Expected result:
   - akun alumni dapat dibuat jika NIM belum ada dan prodi valid;
   - arsip dan koleksi dibuat sesuai aturan import;
   - koleksi arsip awal memiliki stock `1`;
   - duplikat kombinasi NIM + jenis arsip di-skip;
   - activity log tercatat.
7. Uji prodi fiktif atau field wajib kosong.
8. Expected result: import rollback dan detail error ditampilkan.

---

## 8. Kelola arsip digital

### 8.1 Daftar dan detail

1. Buka `/petugas/arsip`.
2. Filter berdasarkan jenis dan status.
3. Cari berdasarkan judul, nama mahasiswa, NIM, atau prodi.
4. Buka detail arsip.
5. Uji download PDF asli, Word, dan preview.

### 8.2 Verifikasi arsip

1. Pilih arsip berstatus `menunggu`.
2. Klik **Verifikasi**.
3. Expected result:
   - status menjadi `diverifikasi`;
   - timestamp verifikasi tersimpan;
   - preview/surat tanda terima dan nomor surat tersedia;
   - email surat dicoba dikirim;
   - notifikasi bell dikirim ke Mahasiswa.

### 8.3 Tolak arsip

1. Klik **Tolak** pada arsip yang perlu perbaikan.
2. Isi catatan petugas.
3. Simpan.
4. Expected result: status `ditolak`, catatan tampil pada Mahasiswa, dan arsip dapat diedit/kirim ulang.

### 8.4 Konfirmasi penerimaan fisik

1. Pilih arsip berstatus `diverifikasi`.
2. Klik **Konfirmasi Terima**.
3. Expected result:
   - status menjadi `aktif`;
   - `received_at` tersimpan;
   - koleksi dibuat/di-update dengan stock `1`;
   - arsip tampil di katalog dan tersedia untuk booking/peminjaman.
4. Download Surat Tanda Terima.
5. Periksa nomor surat, nama mahasiswa, judul, pembimbing, penguji, dan kop.

---

## 9. Peminjaman manual

1. Buka `/petugas/loans/create`.
2. Cari anggota berdasarkan nama, NIM, atau NIP.
3. Pilih satu atau beberapa koleksi yang stoknya tersedia.
4. Isi tanggal pinjam dan batas waktu.
5. Klik **Proses Peminjaman**.
6. Expected result:
   - satu loan dibuat per koleksi;
   - status awal `dipinjam`;
   - stock berkurang `1` per item;
   - antrian aktif anggota untuk item tersebut menjadi `selesai`;
   - notifikasi bell dan activity log tercatat;
   - WA/Telegram dicoba jika konfigurasi tersedia.
7. Uji stok habis; transaksi harus ditolak.
8. Uji batas waktu sebelum tanggal pinjam; validasi harus gagal.
9. Uji anggota yang masih punya loan aktif untuk judul sama; duplikasi harus ditolak.

---

## 10. Pengembalian buku

### 10.1 Kondisi baik

1. Buka `/petugas/returns`.
2. Pilih transaksi aktif.
3. Klik **Kembalikan/Proses**.
4. Pilih **Ada / Inspeksi Fisik**.
5. Biarkan semua checklist baik.
6. Simpan.
7. Expected result: loan `dikembalikan`, tanggal kembali tersimpan, stock +1, dan tidak ada sanksi kerusakan.

### 10.2 Terlambat

1. Siapkan loan dengan batas waktu sebelum hari ini.
2. Buka daftar peminjaman agar status tersinkron menjadi `terlambat`.
3. Proses return kondisi baik.
4. Expected result: denda keterlambatan otomatis dibuat sesuai aturan `per_hari`, `flat`, atau `manual`.

### 10.3 Rusak

1. Pilih inspeksi fisik.
2. Hapus centang satu/lebih checklist.
3. Isi catatan inspeksi, jenis sanksi, metode penyelesaian, dan keterangan.
4. Simpan.
5. Expected result: loan ditutup, kondisi `bermasalah`, checklist/catatan tersimpan, penalty kerusakan dibuat, stock dan notifikasi mengikuti aturan.
6. Kondisi bermasalah tanpa catatan harus ditolak.

### 10.4 Buku hilang

1. Pilih mode **Buku Hilang**.
2. Isi catatan kehilangan.
3. Pilih metode uang tunai, ganti buku, atau kombinasi.
4. Simpan.
5. Expected result:
   - loan menjadi `hilang`;
   - penalty kehilangan dibuat;
   - penyelesaian uang tunai tidak menambah stock langsung;
   - penggantian/kombinasi menambah stock setelah penggantian dikonfirmasi.

---

## 11. Denda dan sanksi

1. Buka `/petugas/penalties`.
2. Cari berdasarkan nama, NIM/NIP, atau judul koleksi.
3. Buka detail penalty.
4. Verifikasi anggota, judul, jenis sanksi, metode, nominal, aturan, dan catatan.
5. Klik **Tandai Lunas** untuk pembayaran tunai.
6. Klik **Konfirmasi Penggantian** untuk penggantian buku.
7. Expected result: status penalty sesuai penyelesaian dan anggota melihat status pada **Denda Saya**.

---

## 12. Rules pengembalian

1. Buka `/petugas/return-settings`.
2. Tambah checklist inspeksi.
3. Edit nama, deskripsi, atau urutan.
4. Nonaktifkan checklist.
5. Buka kembali form pengembalian.
6. Expected result: checklist nonaktif tidak ditampilkan.
7. Edit aturan denda keterlambatan, kerusakan, dan kehilangan.
8. Uji return berikutnya.
9. Expected result: nominal, deskripsi, placeholder, dan metode default mengikuti aturan aktif.

---

## 13. Booking dan antrian

### 13.1 Booking

1. Buka `/petugas/bookings` dan filter `pending`.
2. Klik **Setujui**.
3. Isi jam pengambilan dan catatan.
4. Expected result: booking `disetujui`, batas waktu tersimpan, stock -1, dan notifikasi anggota dibuat.
5. Klik **Realisasi** pada booking disetujui.
6. Expected result: booking `selesai` dan loan aktif dibuat dengan jatuh tempo default 7 hari.
7. Uji **Tolak**.
8. Expected result: booking menjadi `dibatalkan` dengan catatan.

### 13.2 Antrian

1. Buka `/petugas/antrian`.
2. Filter `menunggu`, `tersedia`, atau `selesai`.
3. Setelah buku dikembalikan, pastikan antrian terdepan dipromosikan menjadi `tersedia`.
4. Pastikan bell/WA/Telegram dicoba sesuai konfigurasi.
5. Klik **Tandai Selesai**.
6. Expected result: status menjadi `selesai` dan tidak dapat diproses ulang.

---

## 14. Usulan dan voting buku

### 14.1 Usulan

1. Buka `/petugas/recommendations`.
2. Filter `pending`.
3. Setujui atau tolak usulan.
4. Saat menyetujui, opsional pilih sesi voting aktif.
5. Expected result: status usulan berubah dan kandidat dapat masuk voting.

### 14.2 Voting

1. Buka `/petugas/voting`.
2. Klik **Buat Sesi Voting**.
3. Isi judul, deskripsi, tanggal mulai, dan tanggal selesai.
4. Tambahkan kandidat dari usulan atau input manual.
5. Buka detail sesi.
6. Verifikasi ranking dan jumlah suara.
7. Hapus kandidat/sesi uji bila tidak dibutuhkan.

---

## 15. Laporan dan ekspor

1. Buka `/petugas/reports`.
2. Uji laporan Sirkulasi, Koleksi, Arsip Digital, dan Denda.
3. Uji filter tanggal, jenis, tahun, status, dan pencarian.
4. Klik **Print**.
5. Klik **Export Excel**.
6. Expected result: data, filter, total, dan kolom export sesuai dataset.

> Catatan: endpoint print saat ini perlu diverifikasi sebagai print view HTML. Jika requirement mengharuskan file PDF native, implementasi backend perlu ditegaskan atau diperbaiki.

---

## 16. Reminder otomatis

Command:

```powershell
php artisan loans:send-reminders
```

### H-1 jatuh tempo

1. Siapkan loan aktif dengan batas waktu besok.
2. Jalankan command.
3. Expected result: bell H-1 dibuat; WA/Telegram dicoba bila konfigurasi tersedia.

### Terlambat

1. Siapkan loan yang batas waktunya sudah lewat.
2. Jalankan command atau buka halaman transaksi.
3. Expected result: status menjadi `terlambat`, notifikasi dibuat, dan loan siap diproses return/denda.

---

## 17. Authorization

| Actor | URL | Expected result |
|---|---|---|
| Guest | `/petugas/dashboard` | Redirect ke `/login` |
| Petugas | `/admin/users` | `403 Forbidden` |
| Petugas | `/mahasiswa/arsip` | `403` atau route tidak tersedia |
| Mahasiswa | `/petugas/loans` | `403 Forbidden` |
| Dosen | `/petugas/loans` | `403 Forbidden` |

---

## 18. Checklist Petugas

- [ ] Login dan dashboard Petugas berhasil.
- [ ] CRUD buku berhasil.
- [ ] CRUD kategori berhasil.
- [ ] Import buku valid berhasil.
- [ ] Import buku invalid rollback.
- [ ] CRUD anggota berhasil.
- [ ] Lihat KTM berhasil.
- [ ] Approval dan rejection anggota berhasil.
- [ ] Import arsip berhasil.
- [ ] Verifikasi arsip berhasil.
- [ ] Rejection arsip dengan catatan berhasil.
- [ ] Konfirmasi penerimaan fisik berhasil.
- [ ] Surat Tanda Terima dapat diunduh.
- [ ] Peminjaman langsung mengurangi stock.
- [ ] Return kondisi baik menambah stock.
- [ ] Return terlambat membuat denda.
- [ ] Return rusak membuat sanksi.
- [ ] Return buku hilang membuat sanksi.
- [ ] Pembayaran/penggantian denda dapat dikonfirmasi.
- [ ] Booking approve/reject/realize berhasil.
- [ ] Antrian tersedia/selesai berhasil.
- [ ] Rules return dapat diedit.
- [ ] Usulan dapat diverifikasi.
- [ ] Voting dapat dikelola.
- [ ] Laporan print/export berhasil.
- [ ] Authorization ke route role lain ditolak.
- [ ] Logout berhasil.

---

## 19. Route Petugas

```text
/petugas/dashboard
/petugas/books
/petugas/books-import
/petugas/categories
/petugas/members
/petugas/members/{member}/approve
/petugas/members/{member}/reject
/petugas/arsip
/petugas/arsip-import
/petugas/loans
/petugas/loans/create
/petugas/returns
/petugas/bookings
/petugas/antrian
/petugas/penalties
/petugas/return-settings
/petugas/recommendations
/petugas/voting
/petugas/reports
```

## 20. Referensi

- `routes/web.php`
- `app/Http/Controllers/Petugas/BookController.php`
- `app/Http/Controllers/Petugas/CategoryController.php`
- `app/Http/Controllers/Petugas/MemberController.php`
- `app/Http/Controllers/Petugas/ArsipController.php`
- `app/Http/Controllers/Petugas/LoanController.php`
- `app/Http/Controllers/Petugas/ReturnController.php`
- `app/Http/Controllers/Petugas/PenaltyController.php`
- `app/Http/Controllers/Petugas/BookingController.php`
- `app/Http/Controllers/Petugas/AntrianController.php`
- `app/Http/Controllers/Petugas/ReturnSettingController.php`
- `app/Http/Controllers/Petugas/RecommendationController.php`
- `app/Http/Controllers/Petugas/VotingController.php`
- `app/Http/Controllers/Petugas/ReportController.php`
