# Alur E2E Admin

## Sistem Informasi Perpustakaan PSDKU POLNEP Sukamara

**Tanggal pembaruan:** 4 Agustus 2026  
**Role:** Administrator Sistem  
**Dashboard:** `/admin/dashboard`  
**Prefix route:** `/admin`

> Dokumen ini khusus untuk pengujian end-to-end role Admin. Isinya mencakup kredensial akun Admin, alur kerja, expected result, validasi, dan checklist pengujian.

> **Kerahasiaan:** Password di dalam dokumen ini adalah credential akun uji. Simpan secara internal dan ganti password default sebelum production.

---

## 1. Kredensial Admin

| ID | Nama | Email | Password | Status | Sumber |
|---:|---|---|---|---|---|
| 1 | Administrator | `admin@perpustakaan.com` | `admin123` | verified | Seeder dan database aktif |

### Login Admin

1. Buka `/login`.
2. Masukkan email `admin@perpustakaan.com`.
3. Masukkan password `admin123`.
4. Klik **Masuk**.
5. Expected result: diarahkan ke `/admin/dashboard`.

### Logout Admin

1. Buka menu profil di kanan atas.
2. Klik **Logout**.
3. Expected result: session dihapus dan user kembali ke `/`.
4. Coba buka `/admin/dashboard`.
5. Expected result: diarahkan ke `/login`.

---

## 2. Hak akses Admin

Admin dapat mengakses:

- Dashboard Admin.
- Kelola seluruh user dan profil role.
- Import user melalui Excel/CSV.
- Kelola Program Studi dan Jurusan.
- Pengaturan WhatsApp/Fonnte.
- Pengaturan Telegram Bot.
- Pengaturan Email SMTP.
- Template dan preview Surat Tanda Terima.
- Log Aktivitas Sistem.
- Notifikasi bell dan profil Admin.

Admin tidak boleh mengakses menu operasional Petugas melalui route `/petugas/*` kecuali memang ada perubahan authorization yang disepakati. Pengujian role yang salah harus menghasilkan `403 Forbidden`.

---

## 3. E2E Dashboard Admin

1. Login menggunakan kredensial Admin.
2. Pastikan dashboard `/admin/dashboard` tampil tanpa error.
3. Verifikasi ringkasan jumlah anggota, buku, koleksi, arsip, transaksi, dan statistik yang tersedia.
4. Klik ikon notifikasi bell.
5. Pastikan feed hanya menampilkan notifikasi yang berhak dilihat Admin.
6. Baca satu notifikasi.
7. Expected result: notifikasi ditandai terbaca dan jika memiliki URL, user diarahkan ke halaman tujuan.
8. Uji **Tandai Semua Dibaca** dan hapus satu notifikasi.

---

## 4. E2E Manajemen User

### 4.1 Lihat dan cari user

1. Buka `/admin/users` atau klik **Kelola User**.
2. Cari berdasarkan nama, email, NIM, NIP, atau nomor identitas.
3. Filter berdasarkan role.
4. Expected result: daftar user menampilkan role, data profil akademik, status, dan aksi yang tersedia.

### 4.2 Tambah user Admin

1. Klik **Tambah User**.
2. Pilih role Admin.
3. Isi nama, email unik, nomor HP, password minimal 8 karakter, dan konfirmasi password.
4. Simpan.
5. Expected result: user Admin baru tersimpan dan dapat login.

### 4.3 Tambah user Petugas

1. Klik **Tambah User**.
2. Pilih role Petugas.
3. Isi nama, email, nomor HP, password, NIP 18 digit, dan jabatan.
4. Simpan.
5. Expected result: user dan profil Petugas tersimpan.

### 4.4 Tambah user Dosen

1. Pilih role Dosen.
2. Isi nama, email, nomor HP, password, NIP 18 digit, dan Program Studi.
3. Simpan.
4. Expected result: user dan profil Dosen tersimpan.

### 4.5 Tambah user Mahasiswa

1. Pilih role Mahasiswa.
2. Isi nama, email, nomor HP, password, NIM 10 digit, Program Studi, dan semester.
3. Simpan.
4. Expected result: user dan profil Mahasiswa tersimpan.

### 4.6 Edit dan reset password

1. Cari user uji.
2. Klik **Edit**.
3. Ubah nama, nomor HP, atau data akademik.
4. Isi password baru jika ingin reset password.
5. Simpan.
6. Logout dan login dengan password baru.
7. Expected result: password lama tidak berlaku dan password baru dapat digunakan.

### 4.7 Validasi CRUD user

| Skenario | Expected result |
|---|---|
| Email kosong | Ditolak |
| Email format salah | Ditolak |
| Email duplikat | Ditolak |
| Password kurang dari 8 karakter | Ditolak |
| Konfirmasi password berbeda | Ditolak |
| NIM bukan 10 digit | Ditolak |
| NIP bukan 18 digit | Ditolak |
| Prodi tidak tersedia | Ditolak |
| Field role-specific kosong | Ditolak |
| Hapus akun uji | User dan profil terkait terhapus sesuai aturan |

---

## 5. E2E Import User Excel/CSV

### 5.1 Import valid

1. Buka `/admin/users-import`.
2. Download template import.
3. Isi kolom:
   - Nama Lengkap;
   - NIM / NIP;
   - Jurusan;
   - Program Studi;
   - Semester.
4. Isi Semester untuk mendeteksi Mahasiswa.
5. Kosongkan Semester untuk mendeteksi Dosen.
6. Upload `.xlsx`, `.xls`, atau `.csv` maksimal 10 MB.
7. Expected result:
   - user baru dibuat;
   - Mahasiswa/Dosen dibuat sesuai kolom Semester;
   - email dibuat dengan format `[NIM/NIP]@sipus.polnep.ac.id`;
   - password awal dibuat dengan format `sipus[NIM/NIP]`;
   - activity log import tercatat.

### 5.2 Contoh credential hasil import

```text
NIM      : 3202216130
Email    : 3202216130@sipus.polnep.ac.id
Password : sipus3202216130
```

### 5.3 Import duplikat

1. Upload ulang file yang sama.
2. Expected result: baris yang NIM/NIP atau emailnya sudah ada di-skip dan tidak membuat akun ganda.

### 5.4 Import invalid dan rollback

Uji file dengan:

- Program Studi fiktif;
- Nama kosong;
- NIM/NIP kosong;
- Jurusan kosong;
- format file tidak didukung;
- file kosong/header saja.

Expected result: proses ditolak, detail error per baris ditampilkan, dan tidak ada sebagian data invalid yang tersimpan.

---

## 6. E2E Prodi dan Jurusan

1. Buka `/admin/prodis`.
2. Tambah jurusan bila diperlukan.
3. Tambah Program Studi dan hubungkan ke Jurusan.
4. Edit nama/deskripsi prodi.
5. Buka form registrasi dan form import user.
6. Expected result: prodi baru tersedia sebagai pilihan.
7. Uji penghapusan prodi/jurusan yang tidak memiliki dependensi.
8. Untuk data yang masih digunakan user/arsip, sistem harus menolak penghapusan atau menampilkan peringatan.

---

## 7. E2E Pengaturan WhatsApp/Fonnte

1. Buka `/admin/settings/wa`.
2. Isi token Fonnte pada field konfigurasi internal.
3. Atur toggle notifikasi aktif/nonaktif.
4. Isi nama pengirim.
5. Klik **Simpan**.
6. Expected result: konfigurasi tersimpan ke AppSetting.
7. Isi nomor tujuan dan pesan uji.
8. Klik **Test Kirim WA**.
9. Expected result:
   - token dan nomor valid → pesan dikirim;
   - token kosong/invalid → respons gagal dan detail dapat dilihat di `storage/logs/laravel.log`;
   - transaksi database inti tidak ikut rollback karena layanan eksternal gagal.

> Jangan menyalin token Fonnte ke dokumen, screenshot, git, atau log CI.

---

## 8. E2E Pengaturan Telegram

1. Buka `/admin/settings/telegram`.
2. Isi Telegram Bot Token.
3. Isi username bot.
4. Aktifkan notifikasi Telegram.
5. Simpan.
6. Isi Chat ID penerima yang sudah menjalankan `/start` pada bot.
7. Isi pesan uji.
8. Klik **Test Kirim Telegram**.
9. Expected result: pesan diterima pada Telegram jika token, Chat ID, dan bot benar.
10. Nonaktifkan toggle lalu ulangi pengiriman.
11. Expected result: pengiriman dilewati dan dicatat sebagai skip pada log.

---

## 9. E2E Pengaturan Email SMTP

1. Buka `/admin/settings/email`.
2. Isi mailer (`smtp` atau `log`), host, port, encryption, username, password, alamat pengirim, dan nama pengirim.
3. Simpan.
4. Jalankan **Test Kirim Email Real-Time**.
5. Expected result: email terkirim bila konfigurasi valid.
6. Uji alamat pengirim invalid.
7. Expected result: validasi format email muncul.
8. Uji SMTP host/password invalid.
9. Expected result: error dikembalikan tanpa merusak transaksi konfigurasi lain.

> Password SMTP wajib dianggap secret dan tidak boleh dicantumkan pada bukti uji.

---

## 10. E2E Template Surat Tanda Terima

1. Buka `/admin/settings/receipt`.
2. Isi nama penerima, NIP, jabatan, kode surat, tiga baris kop, dan alamat.
3. Upload logo `.png`, `.jpg`, atau `.jpeg` maksimal 2 MB.
4. Simpan.
5. Klik **Preview PDF Real-Time**.
6. Expected result: PDF preview terbuka dengan data override, logo, nomor surat contoh, dan layout tidak terpotong.
7. Lanjutkan alur arsip dengan Petugas untuk memastikan template yang tersimpan dipakai pada Surat Tanda Terima nyata.

---

## 11. E2E Log Aktivitas

1. Buka `/admin/activity-logs`.
2. Cari aktivitas setelah login Admin.
3. Jalankan aksi CRUD user, import, perubahan setting, dan perubahan prodi.
4. Refresh log aktivitas.
5. Expected result: actor, aktivitas, timestamp, dan urutan kronologis tampil.

---

## 12. Pengujian authorization

| Actor | URL | Expected result |
|---|---|---|
| Guest | `/admin/dashboard` | Redirect ke `/login` |
| Admin | `/petugas/loans` | `403 Forbidden` |
| Admin | `/mahasiswa/arsip` | `403` atau route tidak tersedia |
| Admin | `/dosen/voting` | `403` atau route tidak tersedia |
| Admin | Detail penalty milik anggota | Data anggota tidak boleh bocor ke Admin jika route bukan haknya |

---

## 13. Checklist Admin

- [ ] Login Admin berhasil.
- [ ] Dashboard Admin tampil.
- [ ] Feed notifikasi dan mark as read berjalan.
- [ ] CRUD Admin berhasil.
- [ ] CRUD Petugas berhasil.
- [ ] CRUD Dosen berhasil.
- [ ] CRUD Mahasiswa berhasil.
- [ ] Reset password berhasil.
- [ ] Import user valid berhasil.
- [ ] Import user duplikat di-skip.
- [ ] Import user invalid rollback.
- [ ] Prodi dan Jurusan dapat dikelola.
- [ ] Pengaturan WhatsApp tersimpan dan dapat dites.
- [ ] Pengaturan Telegram tersimpan dan dapat dites.
- [ ] Pengaturan SMTP tersimpan dan dapat dites.
- [ ] Preview Surat Tanda Terima berhasil.
- [ ] Activity log mencatat aksi Admin.
- [ ] Authorization ke route role lain ditolak.
- [ ] Logout berhasil.

---

## 14. Route Admin

```text
/admin/dashboard
/admin/users
/admin/users/create
/admin/users/{user}/edit
/admin/users-import
/admin/users-import/template
/admin/prodis
/admin/jurusans/{jurusan}/edit
/admin/settings/wa
/admin/settings/telegram
/admin/settings/email
/admin/settings/receipt
/admin/settings/receipt/preview
/admin/activity-logs
```

## 15. Referensi

- `routes/web.php`
- `app/Http/Controllers/Admin/UserController.php`
- `app/Http/Controllers/Admin/SettingController.php`
- `app/Http/Controllers/Admin/ActivityLogController.php`
- `app/Http/Controllers/Admin/ProdiController.php`
- `app/Http/Controllers/Admin/JurusanController.php`
- `database/seeders/AdminSeeder.php`
- `database/seeders/UserSeeder.php`
