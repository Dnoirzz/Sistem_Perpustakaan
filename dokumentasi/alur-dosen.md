# Alur E2E Dosen

## Sistem Informasi Perpustakaan PSDKU POLNEP Sukamara

**Tanggal pembaruan:** 4 Agustus 2026  
**Role:** Dosen  
**Dashboard:** `/dosen/dashboard`  
**Prefix route:** `/dosen`

> Dokumen ini khusus untuk pengujian end-to-end role Dosen sebagai anggota perpustakaan.

> **Kerahasiaan:** Password di dalam dokumen ini adalah credential akun uji internal. Ganti password default sebelum production.

---

## 1. Kredensial Dosen

| ID | Nama | NIP | Email login | Password | Status |
|---:|---|---|---|---|---|
| 3 | Suharsono, S.Kom., M.Kom. | `198603012020121001` | `dosen@perpustakaan.com` | `password` | verified |

---

## 2. Hak akses Dosen

Dosen dapat mengakses:

- Dashboard Dosen.
- Katalog Buku.
- Katalog Arsip Mahasiswa.
- Booking buku.
- Antrian buku.
- Pinjaman aktif.
- Riwayat pinjaman dan pembacaan digital.
- Denda Saya.
- Usulan Buku Baru.
- Voting Buku.
- Notifikasi bell.
- Profil dan perubahan password.

Dosen tidak memiliki menu Upload Arsip Digital Mahasiswa. Dosen tidak boleh mengakses route Admin atau Petugas.

---

## 3. Login dan dashboard

1. Buka `/login`.
2. Masukkan email `dosen@perpustakaan.com`.
3. Masukkan password `password`.
4. Klik **Masuk**.
5. Expected result: diarahkan ke `/dosen/dashboard`.
6. Verifikasi ringkasan pinjaman, booking/antrian, denda, katalog, dan aktivitas yang tersedia.
7. Klik ikon lonceng.
8. Baca notifikasi, tandai semua dibaca, dan hapus satu notifikasi.

---

## 4. Katalog Buku

1. Buka **Koleksi Perpustakaan > Buku** atau `/dosen/books`.
2. Cari berdasarkan judul, penulis, atau kategori.
3. Uji kata pencarian yang menghasilkan data dan yang tidak menghasilkan data.
4. Expected result: buku menampilkan judul, penulis, kategori, cover, stock, dan status ketersediaan.
5. Jika stock > 0, tombol **Booking Buku** tersedia.
6. Jika stock = 0, tombol **Daftar Antrian** tersedia.

---

## 5. Katalog Arsip Mahasiswa

1. Buka `/dosen/katalog-arsip`.
2. Filter berdasarkan jenis arsip, Program Studi, tahun, dan pencarian.
3. Buka detail arsip yang tersedia di katalog.
4. Klik **Preview**.
5. Expected result: preview PDF terbuka inline.
6. Klik **Baca Full / Stream**.
7. Expected result:
   - viewer PDF terbuka;
   - pembacaan dicatat dalam `ArchiveReadLog`;
   - file full disajikan dari storage private;
   - saat viewer/tab selesai atau ditutup, `finished_at` read log diperbarui.
8. Buka `/dosen/loans/history`.
9. Expected result: aktivitas baca digital tampil bersama riwayat pinjaman fisik.

---

## 6. Booking Buku

### 6.1 Membuat booking

1. Dari katalog, pilih buku dengan stock > 0.
2. Klik **Booking Buku**.
3. Expected result:
   - booking dibuat dengan status `pending`;
   - notifikasi bell Dosen dibuat;
   - Petugas/Admin menerima notifikasi booking baru;
   - pesan menunggu persetujuan tampil.
4. Buka `/dosen/bookings`.
5. Pastikan judul, tanggal, status, dan catatan tampil.

### 6.2 Membatalkan booking

1. Pilih booking berstatus `pending` atau `disetujui`.
2. Klik **Batalkan**.
3. Isi alasan pembatalan.
4. Konfirmasi.
5. Expected result: status menjadi `dibatalkan`; jika sebelumnya disetujui, stock dikembalikan.

### 6.3 Validasi booking

| Skenario | Expected result |
|---|---|
| Booking judul yang sama masih aktif | Ditolak sebagai duplikat |
| User masih meminjam judul yang sama | Ditolak |
| Membatalkan booking milik user lain | Ditolak |
| Alasan pembatalan kosong | Ditolak |

---

## 7. Antrian Buku

**Precondition:** pilih koleksi dengan stock `0`.

1. Dari katalog, klik **Daftar Antrian**.
2. Expected result: antrian dibuat dengan status `menunggu` dan nomor urut.
3. Buka `/dosen/antrian`.
4. Verifikasi nomor antrian dan jumlah orang di depan.
5. Klik **Batalkan**.
6. Expected result: status menjadi `dibatalkan`.
7. Saat buku dikembalikan oleh peminjam sebelumnya, Petugas memproses return.
8. Expected result: antrian terdepan dapat berubah menjadi `tersedia` dan Dosen menerima bell/WA/Telegram sesuai konfigurasi.

---

## 8. Rak Pinjam, riwayat, dan denda

### 8.1 Pinjaman aktif

1. Buka `/dosen/loans`.
2. Expected result: hanya loan berstatus `dipinjam` dan `terlambat` yang tampil.
3. Verifikasi judul koleksi, tanggal pinjam, batas pengembalian, dan badge status.

### 8.2 Riwayat

1. Buka `/dosen/loans/history`.
2. Expected result: pinjaman `dikembalikan`/`hilang` serta riwayat pembacaan arsip tampil.
3. Verifikasi catatan keterlambatan, kerusakan, atau kehilangan jika tersedia.

### 8.3 Denda Saya

1. Buka `/dosen/loans/penalties`.
2. Verifikasi jumlah denda belum dibayar, total tagihan, jumlah lunas, status, jenis, metode, nominal, dan keterangan.
3. Setelah Petugas menandai denda lunas, refresh halaman.
4. Expected result: denda berpindah ke riwayat lunas.

---

## 9. Usulan Buku Baru

1. Buka `/dosen/recommendations`.
2. Klik **Buat Usulan**.
3. Isi judul, penulis, dan alasan.
4. Kirim formulir.
5. Expected result:
   - usulan tersimpan dengan status `pending`;
   - usulan tampil pada daftar milik Dosen;
   - activity log tercatat.
6. Uji judul kosong.
7. Expected result: validasi wajib tampil dan data tidak tersimpan.
8. Petugas dapat menyetujui usulan dan memasukkannya ke voting.

---

## 10. Voting Buku

1. Buka `/dosen/voting`.
2. Pastikan sesi dengan tanggal aktif tampil.
3. Baca deskripsi dan kandidat.
4. Klik **Vote** pada kandidat.
5. Expected result: suara tersimpan dan jumlah suara bertambah.
6. Klik kandidat yang sama sekali lagi.
7. Expected result: suara dibatalkan/toggle dan tidak terjadi double vote.
8. Uji sesi yang belum dimulai atau telah selesai.
9. Expected result: vote ditolak dengan pesan sesi tidak aktif.

---

## 11. Profil Dosen

1. Buka `/profile`.
2. Ubah nama, email, nomor HP, atau Telegram Chat ID.
3. Simpan.
4. Ubah password dengan password baru dan konfirmasi yang sama.
5. Logout.
6. Login menggunakan password baru.
7. Expected result: password baru berlaku.
8. Uji password lama salah dan konfirmasi berbeda.
9. Expected result: validasi gagal.
10. Hapus akun hanya pada akun disposable.

---

## 12. Notifikasi dan reminder

Event yang perlu diverifikasi pada akun Dosen:

- booking berhasil;
- booking disetujui/ditolak;
- pinjaman baru;
- denda baru;
- antrian tersedia;
- reminder H-1;
- status terlambat;
- update usulan/voting.

Command reminder untuk pengujian lokal:

```powershell
php artisan loans:send-reminders
```

Expected result: bell selalu diuji; WA/Telegram hanya dianggap terkirim jika token, nomor, Chat ID, dan layanan eksternal valid.

---

## 13. Authorization

| Actor | URL | Expected result |
|---|---|---|
| Guest | `/dosen/dashboard` | Redirect ke `/login` |
| Dosen | `/admin/dashboard` | `403 Forbidden` |
| Dosen | `/petugas/loans` | `403 Forbidden` |
| Dosen | `/mahasiswa/arsip` | `403` atau route tidak tersedia |
| Dosen | `/petugas/members/{member}/ktm` | `403 Forbidden` |
| Dosen A | Booking/antrian Dosen B | Data/aksi ditolak |

---

## 14. Checklist Dosen

- [ ] Login Dosen berhasil.
- [ ] Dashboard Dosen tampil.
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
- [ ] Usulan buku berhasil dibuat.
- [ ] Vote berhasil dan tidak double count.
- [ ] Notifikasi bell dapat dibaca/dihapus.
- [ ] Profil dapat diubah.
- [ ] Password dapat diubah.
- [ ] Authorization ke Admin/Petugas ditolak.
- [ ] Logout berhasil.

---

## 15. Route Dosen

```text
/dosen/dashboard
/dosen/books
/dosen/katalog-arsip
/dosen/voting
/dosen/recommendations
/dosen/bookings
/dosen/antrian
/dosen/loans
/dosen/loans/history
/dosen/loans/penalties
```

## 16. Referensi

- `routes/web.php`
- `app/Http/Controllers/Dosen/DashboardController.php`
- `app/Http/Controllers/BookSearchController.php`
- `app/Http/Controllers/ArsipKatalogController.php`
- `app/Http/Controllers/BookingController.php`
- `app/Http/Controllers/AntrianController.php`
- `app/Http/Controllers/MemberLoanController.php`
- `app/Http/Controllers/RecommendationController.php`
- `app/Http/Controllers/VotingController.php`
- `app/Http/Controllers/ProfileController.php`
