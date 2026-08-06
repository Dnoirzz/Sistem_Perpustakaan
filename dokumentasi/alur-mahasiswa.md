# Alur E2E Mahasiswa

## Sistem Informasi Perpustakaan PSDKU POLNEP Sukamara

**Tanggal pembaruan:** 4 Agustus 2026  
**Role:** Mahasiswa  
**Dashboard:** `/mahasiswa/dashboard`  
**Prefix route:** `/mahasiswa`

> Dokumen ini khusus untuk pengujian end-to-end role Mahasiswa sebagai anggota perpustakaan dan pengguna repository digital.

> **Kerahasiaan:** Password di dalam dokumen ini adalah credential akun uji internal. Ganti password default sebelum production.

---

## 1. Kredensial Mahasiswa

### 1.1 Akun utama

| ID | Nama | NIM | Email login | Password | Status |
|---:|---|---|---|---|---|
| 4 | Ryan | `3202210001` | `mahasiswa@perpustakaan.com` | `password` | verified |

### 1.2 Akun alternatif hasil import

| ID | Nama | NIM | Email login | Password | Status |
|---:|---|---|---|---|---|
| 5 | Dika Muzalifah | `3202216130` | `3202216130@sipus.polnep.ac.id` | `sipus3202216130` | verified |
| 6 | Fadli Nurhidayat | `3202216063` | `3202216063@sipus.polnep.ac.id` | `sipus3202216063` | verified |
| 7 | Raycal Pranata | `3202216090` | `3202216090@sipus.polnep.ac.id` | `sipus3202216090` | verified |
| 8 | Sultan Arya Adhyaksa | `3202216094` | `3202216094@sipus.polnep.ac.id` | `sipus3202216094` | verified |
| 9 | Isma Nasution | `3202216143` | `3202216143@sipus.polnep.ac.id` | `sipus3202216143` | verified |
| 10 | Muhammad Ilham Yumar | `3202216084` | `3202216084@sipus.polnep.ac.id` | `sipus3202216084` | verified |
| 11 | Nizar Khawarizmi | `3202216105` | `3202216105@sipus.polnep.ac.id` | `sipus3202216105` | verified |
| 12 | Ariel Wira Ramadan | `3202216069` | `3202216069@sipus.polnep.ac.id` | `sipus3202216069` | verified |
| 13 | NANDA IKHWANUL NADLIRIN | `3202216125` | `3202216125@sipus.polnep.ac.id` | `sipus3202216125` | verified |
| 14 | Fachri Hibatul Haq | `3202216122` | `3202216122@sipus.polnep.ac.id` | `sipus3202216122` | verified |
| 15 | Muhamad Syafarudin Ilham | `3202216114` | `3202216114@sipus.polnep.ac.id` | `sipus3202216114` | verified |
| 16 | Belva Mieko Suparwanto | `3202216075` | `3202216075@sipus.polnep.ac.id` | `sipus3202216075` | verified |
| 17 | Aspariansyah | `3202216113` | `3202216113@sipus.polnep.ac.id` | `sipus3202216113` | verified |
| 18 | Ulfah Dwi Nazarina | `3202216004` | `3202216004@sipus.polnep.ac.id` | `sipus3202216004` | verified |
| 19 | Peti Lesmasari | `3202216010` | `3202216010@sipus.polnep.ac.id` | `sipus3202216010` | verified |
| 20 | Yoga Pradana | `3202216126` | `3202216126@sipus.polnep.ac.id` | `sipus3202216126` | verified |
| 21 | Nurul Ersya Citra | `3202216060` | `3202216060@sipus.polnep.ac.id` | `sipus3202216060` | verified |
| 22 | Wympi Saristo | `3202216021` | `3202216021@sipus.polnep.ac.id` | `sipus3202216021` | verified |
| 23 | Muhammad Rafli Nur Hidayat | `3202216142` | `3202216142@sipus.polnep.ac.id` | `sipus3202216142` | verified |
| 24 | Grata | `3202216066` | `3202216066@sipus.polnep.ac.id` | `sipus3202216066` | verified |
| 25 | Diana Dwi Apita | `3202216007` | `3202216007@sipus.polnep.ac.id` | `sipus3202216007` | verified |
| 26 | Satria Firlyandra | `3202216088` | `3202216088@sipus.polnep.ac.id` | `sipus3202216088` | verified |
| 27 | Yuliana Putri | `3202216081` | `3202216081@sipus.polnep.ac.id` | `sipus3202216081` | verified |
| 28 | Amelia | `3202216038` | `3202216038@sipus.polnep.ac.id` | `sipus3202216038` | verified |
| 29 | Utari Adistya Putri | `3202216025` | `3202216025@sipus.polnep.ac.id` | `sipus3202216025` | verified |
| 30 | Dayang Zulaikha Fakhira | `3202216129` | `3202216129@sipus.polnep.ac.id` | `sipus3202216129` | verified |
| 31 | Andika Jaya Nanda | `3202216064` | `3202216064@sipus.polnep.ac.id` | `sipus3202216064` | verified |
| 32 | Adinda Thalia Putri Salsabila | `3202216092` | `3202216092@sipus.polnep.ac.id` | `sipus3202216092` | verified |
| 33 | Eja Sapario | `3202216070` | `3202216070@sipus.polnep.ac.id` | `sipus3202216070` | verified |
| 34 | Muhamad Jakarya | `3202216024` | `3202216024@sipus.polnep.ac.id` | `sipus3202216024` | verified |
| 35 | Aini Jelita Puspa Ningrum | `3202216083` | `3202216083@sipus.polnep.ac.id` | `sipus3202216083` | verified |
| 36 | Anggi Nabila Sulistianingsih | `3202216039` | `3202216039@sipus.polnep.ac.id` | `sipus3202216039` | verified |
| 37 | Muhamad Sigit Firmansyah | `3202216146` | `3202216146@sipus.polnep.ac.id` | `sipus3202216146` | verified |
| 38 | Akram Nur Adha | `3202216053` | `3202216053@sipus.polnep.ac.id` | `sipus3202216053` | verified |
| 39 | Gilang Arya Libna | `3202216051` | `3202216051@sipus.polnep.ac.id` | `sipus3202216051` | verified |
| 40 | Rizky Puspita Sari | `3202216086` | `3202216086@sipus.polnep.ac.id` | `sipus3202216086` | verified |
| 41 | Ferry Perdian | `3202216011` | `3202216011@sipus.polnep.ac.id` | `sipus3202216011` | verified |
| 42 | Fellix | `3202216107` | `3202216107@sipus.polnep.ac.id` | `sipus3202216107` | verified |
| 43 | Radisa Pradiptya | `3202216073` | `3202216073@sipus.polnep.ac.id` | `sipus3202216073` | verified |
| 44 | Awang Praja Anugerah | `3202216068` | `3202216068@sipus.polnep.ac.id` | `sipus3202216068` | verified |
| 45 | Dhiya Apriana | `3202216012` | `3202216012@sipus.polnep.ac.id` | `sipus3202216012` | verified |
| 46 | Dwi Ananda Deli Hediyatna Putra | `3202216054` | `3202216054@sipus.polnep.ac.id` | `sipus3202216054` | verified |
| 47 | IRFAN AFIF | `3202216059` | `3202216059@sipus.polnep.ac.id` | `sipus3202216059` | verified |
| 48 | naia fatiha | `3202216110` | `3202216110@sipus.polnep.ac.id` | `sipus3202216110` | verified |
| 49 | Rifqi Rahmatullah | `3202216048` | `3202216048@sipus.polnep.ac.id` | `sipus3202216048` | verified |
| 50 | NIRMALA | `3202216065` | `3202216065@sipus.polnep.ac.id` | `sipus3202216065` | verified |
| 51 | Desi Viviani | `3202216008` | `3202216008@sipus.polnep.ac.id` | `sipus3202216008` | verified |
| 52 | Farah Khairina | `3202216111` | `3202216111@sipus.polnep.ac.id` | `sipus3202216111` | verified |
| 53 | Doni Fitriansyah | `3202216112` | `3202216112@sipus.polnep.ac.id` | `sipus3202216112` | verified |
| 54 | Juwita | `3202116053` | `3202116053@sipus.polnep.ac.id` | `sipus3202116053` | verified |
| 55 | Sinta | `3202216050` | `3202216050@sipus.polnep.ac.id` | `sipus3202216050` | verified |
| 56 | Atha Nala Isra Raditya | `3202216006` | `3202216006@sipus.polnep.ac.id` | `sipus3202216006` | verified |
| 57 | Siti Sabrina Oktavia | `3202216002` | `3202216002@sipus.polnep.ac.id` | `sipus3202216002` | verified |
| 58 | Fata Humam Asadillah | `3202216023` | `3202216023@sipus.polnep.ac.id` | `sipus3202216023` | verified |
| 59 | AHMAD NURSABANDI | `3202339015` | `3202339015@sipus.polnep.ac.id` | `sipus3202339015` | verified |
| 60 | Ayuning Lita | `3202339004` | `3202339004@sipus.polnep.ac.id` | `sipus3202339004` | verified |
| 61 | IHLASYA AMALIA | `3202339001` | `3202339001@sipus.polnep.ac.id` | `sipus3202339001` | verified |
| 62 | M.RIDHONI | `3202339012` | `3202339012@sipus.polnep.ac.id` | `sipus3202339012` | verified |
| 63 | MAHFUZAH | `3202339010` | `3202339010@sipus.polnep.ac.id` | `sipus3202339010` | verified |
| 64 | MUHAMMAD LINTANG SUSANTO | `3202339003` | `3202339003@sipus.polnep.ac.id` | `sipus3202339003` | verified |
| 65 | NURUL DIAH RAHMADIAH | `3202339007` | `3202339007@sipus.polnep.ac.id` | `sipus3202339007` | verified |
| 66 | PICA | `3202339011` | `3202339011@sipus.polnep.ac.id` | `sipus3202339011` | verified |
| 67 | RAYNA ADE SAKIRA | `3202339008` | `3202339008@sipus.polnep.ac.id` | `sipus3202339008` | verified |
| 68 | REFI YANDA | `3202339013` | `3202339013@sipus.polnep.ac.id` | `sipus3202339013` | verified |
| 69 | SAHID RAHMAN MAULANA | `3202339006` | `3202339006@sipus.polnep.ac.id` | `sipus3202339006` | verified |
| 70 | SULAIMAN AL MADANI | `3202339005` | `3202339005@sipus.polnep.ac.id` | `sipus3202339005` | verified |
| 71 | ZAHRAH YULIA RAHMAN | `3202339009` | `3202339009@sipus.polnep.ac.id` | `sipus3202339009` | verified |
| 72 | ZIA NOVITA | `3202339014` | `3202339014@sipus.polnep.ac.id` | `sipus3202339014` | verified |

> **Catatan:** Akun hasil import memakai password `sipus` + NIM. Jika password pernah diubah melalui Admin, gunakan password baru tersebut.

### 1.3 Akun yang memerlukan reset

| ID | Email | Keterangan |
|---:|---|---|
| 73 | `ryankrick06@gmail.com` | Password plaintext tidak tersedia; hanya hash tersimpan. Reset melalui Admin > Kelola User > Edit. |

---

## 2. Login dan dashboard Mahasiswa

1. Buka `/login`.
2. Masukkan `mahasiswa@perpustakaan.com` / `password` atau akun import pada tabel.
3. Klik **Masuk**.
4. Expected result: diarahkan ke `/mahasiswa/dashboard`.
5. Verifikasi ringkasan pinjaman, denda, booking/antrian, statistik, dan aktivitas.
6. Klik bell dan uji buka, tandai semua dibaca, serta hapus notifikasi.
7. Logout melalui menu profil.

---

## 3. Katalog Buku

1. Buka **Koleksi Perpustakaan > Buku** atau `/mahasiswa/books`.
2. Cari judul, penulis, dan kategori.
3. Uji pencarian dengan hasil dan tanpa hasil.
4. Expected result: kartu buku menampilkan judul, penulis, kategori, cover, stock, dan status.
5. Stock > 0 → **Booking Buku** tersedia.
6. Stock = 0 → **Daftar Antrian** tersedia.

---

## 4. Katalog Arsip Digital

1. Buka `/mahasiswa/katalog-arsip`.
2. Filter jenis arsip, prodi, tahun, dan judul.
3. Buka detail arsip.
4. Klik **Preview**; PDF preview harus tampil inline.
5. Klik **Baca Full / Stream**.
6. Expected result:
   - viewer PDF terbuka;
   - `ArchiveReadLog` dibuat untuk user;
   - file full disajikan dari storage private;
   - saat viewer/tab selesai/ditutup, `finished_at` diperbarui.
7. Buka `/mahasiswa/loans/history` dan pastikan riwayat baca digital tampil.

---

## 5. Booking Buku

### 5.1 Membuat booking

1. Pilih buku dengan stock > 0.
2. Klik **Booking Buku**.
3. Expected result:
   - booking berstatus `pending`;
   - bell Mahasiswa dibuat;
   - Petugas/Admin menerima notifikasi booking baru;
   - pesan menunggu persetujuan tampil.
4. Buka `/mahasiswa/bookings` dan verifikasi detail.

### 5.2 Membatalkan booking

1. Pilih booking `pending` atau `disetujui`.
2. Klik **Batalkan**.
3. Isi alasan dan konfirmasi.
4. Expected result: status `dibatalkan`; booking disetujui mengembalikan stock.

### 5.3 Validasi booking

| Skenario | Expected result |
|---|---|
| Booking aktif untuk judul sama | Ditolak sebagai duplikat |
| Masih memiliki loan judul sama | Ditolak |
| Membatalkan booking user lain | Ditolak |
| Alasan pembatalan kosong | Ditolak |

---

## 6. Antrian Buku

**Precondition:** koleksi memiliki stock `0`.

1. Dari katalog, klik **Daftar Antrian**.
2. Expected result: antrian `menunggu` dan nomor urut dibuat.
3. Buka `/mahasiswa/antrian`.
4. Verifikasi nomor dan jumlah orang di depan.
5. Klik **Batalkan** bila diperlukan.
6. Expected result: status menjadi `dibatalkan`.
7. Saat buku dikembalikan, antrian terdepan dapat menjadi `tersedia` dan notifikasi dikirim sesuai konfigurasi.

---

## 7. Rak Pinjam, riwayat, dan denda

### 7.1 Pinjaman aktif

1. Buka `/mahasiswa/loans`.
2. Pastikan hanya status `dipinjam` dan `terlambat` tampil.
3. Verifikasi tanggal pinjam, batas pengembalian, judul, dan badge.

### 7.2 Riwayat

1. Buka `/mahasiswa/loans/history`.
2. Expected result: loan `dikembalikan`/`hilang` dan riwayat baca digital tampil.
3. Verifikasi catatan terlambat/rusak/hilang jika tersedia.

### 7.3 Denda Saya

1. Buka `/mahasiswa/loans/penalties`.
2. Verifikasi jumlah belum dibayar, total nominal, jumlah lunas, jenis sanksi, metode, judul, dan catatan.
3. Setelah Petugas menandai lunas, refresh.
4. Expected result: status berubah menjadi lunas/masuk riwayat.

---

## 8. Upload Repository Digital

1. Buka `/mahasiswa/arsip`.
2. Klik **Unggah Karya Ilmiah**.
3. Pilih Laporan PKL, Proposal TA, atau Laporan Tugas Akhir.
4. Isi judul, pembimbing, minimal satu penguji, tahun, dan tempat PKL bila tipe PKL.
5. Upload PDF utama dan Word pendukung.
6. Klik **Simpan**.
7. Expected result:
   - arsip tersimpan `menunggu`;
   - file tersimpan di storage private;
   - preview PDF dibuat;
   - Petugas/Admin menerima notifikasi bell.
8. Edit arsip pending/ditolak dan kirim ulang.
9. Expected result: status kembali `menunggu`.
10. Hapus arsip yang masih editable.
11. Expected result: record dan file dihapus.

### Validasi upload

| Skenario | Expected result |
|---|---|
| Judul/pembimbing kosong | Ditolak |
| Penguji 1 dan 2 kosong | Ditolak |
| Tahun bukan 4 digit | Ditolak |
| Laporan PKL tanpa tempat PKL | Ditolak |
| PDF/Word tidak ada saat create | Ditolak |
| File bukan PDF/DOC/DOCX | Ditolak |
| File melewati ukuran maksimum | Ditolak |
| Arsip aktif diedit/dihapus mahasiswa | Ditolak |

---

## 9. Usulan Buku Baru

1. Buka `/mahasiswa/recommendations`.
2. Klik **Buat Usulan**.
3. Isi judul, penulis, dan alasan.
4. Kirim.
5. Expected result: usulan `pending`, tampil pada daftar milik Mahasiswa, dan activity log tercatat.
6. Judul kosong harus menghasilkan validasi.
7. Petugas dapat menyetujui usulan dan memasukkannya ke voting.

---

## 10. Voting Buku

1. Buka `/mahasiswa/voting`.
2. Pastikan sesi voting aktif tampil.
3. Klik **Vote** pada kandidat.
4. Expected result: suara tersimpan dan jumlah suara bertambah.
5. Klik kandidat yang sama lagi.
6. Expected result: suara dibatalkan/toggle, bukan digandakan.
7. Sesi belum dimulai/sudah selesai harus menolak vote.

---

## 11. Profil Mahasiswa

1. Buka `/profile`.
2. Ubah nama, email, nomor HP, atau Telegram Chat ID.
3. Simpan.
4. Ubah password dan konfirmasi.
5. Logout lalu login menggunakan password baru.
6. Password lama salah atau konfirmasi berbeda harus ditolak.
7. Hapus akun hanya pada akun disposable; session harus berakhir.

---

## 12. Notifikasi dan reminder

Uji notifikasi berikut pada akun Mahasiswa:

- registrasi dan approval;
- booking berhasil/disetujui/ditolak;
- peminjaman baru;
- denda baru;
- antrian tersedia;
- arsip diverifikasi/ditolak;
- reminder H-1;
- status terlambat;
- update usulan/voting.

Jalankan reminder lokal:

```powershell
php artisan loans:send-reminders
```

Bell in-app harus diuji sebagai channel utama. WA/Telegram hanya dianggap sukses jika service eksternal benar-benar merespons berhasil.

---

## 13. Authorization

| Actor | URL | Expected result |
|---|---|---|
| Guest | `/mahasiswa/dashboard` | Redirect ke `/login` |
| Mahasiswa | `/admin/dashboard` | `403 Forbidden` |
| Mahasiswa | `/petugas/loans` | `403 Forbidden` |
| Mahasiswa | `/dosen/dashboard` | `403 Forbidden` |
| Mahasiswa A | Arsip milik Mahasiswa B | `403 Forbidden` |
| Mahasiswa | Penalty anggota lain | Data tidak boleh terlihat |
| Mahasiswa | Booking/antrian user lain | Aksi ditolak |

---

## 14. Checklist Mahasiswa

- [ ] Login Mahasiswa berhasil.
- [ ] Dashboard Mahasiswa tampil.
- [ ] Notifikasi dapat dibuka/dibaca/dihapus.
- [ ] Katalog buku dapat dicari.
- [ ] Katalog arsip dapat difilter.
- [ ] Preview PDF tampil.
- [ ] Full stream membuat read log.
- [ ] Riwayat baca digital tampil.
- [ ] Booking buku tersedia berhasil.
- [ ] Booking dapat dibatalkan.
- [ ] Antrian buku habis berhasil.
- [ ] Antrian dapat dibatalkan.
- [ ] Pinjaman aktif tampil.
- [ ] Riwayat pinjaman tampil.
- [ ] Denda Saya tampil.
- [ ] Upload Laporan PKL berhasil.
- [ ] Upload Proposal TA berhasil.
- [ ] Upload Laporan TA berhasil.
- [ ] Edit/kirim ulang arsip berhasil.
- [ ] Hapus arsip editable berhasil.
- [ ] Validasi upload arsip berjalan.
- [ ] Usulan buku berhasil.
- [ ] Voting berhasil dan tidak double count.
- [ ] Profil dapat diubah.
- [ ] Password dapat diubah.
- [ ] Authorization ke Admin/Petugas/Dosen ditolak.
- [ ] Logout berhasil.

---

## 15. Route Mahasiswa

```text
/mahasiswa/dashboard
/mahasiswa/books
/mahasiswa/katalog-arsip
/mahasiswa/arsip
/mahasiswa/voting
/mahasiswa/recommendations
/mahasiswa/bookings
/mahasiswa/antrian
/mahasiswa/loans
/mahasiswa/loans/history
/mahasiswa/loans/penalties
```

## 16. Referensi

- `routes/web.php`
- `app/Http/Controllers/Mahasiswa/DashboardController.php`
- `app/Http/Controllers/BookSearchController.php`
- `app/Http/Controllers/Mahasiswa/ArsipController.php`
- `app/Http/Controllers/ArsipKatalogController.php`
- `app/Http/Controllers/BookingController.php`
- `app/Http/Controllers/AntrianController.php`
- `app/Http/Controllers/MemberLoanController.php`
- `app/Http/Controllers/RecommendationController.php`
- `app/Http/Controllers/VotingController.php`
- `app/Http/Controllers/ProfileController.php`
