# Dokumentasi E2E dan Kredensial Aplikasi

## Sistem Informasi Perpustakaan PSDKU POLNEP Sukamara

**Tanggal pembaruan:** 4 Agustus 2026  
**Versi aplikasi:** 2.0  
**Framework:** Laravel 11  
**Zona waktu aplikasi:** `Asia/Jakarta`

> Panduan ini merangkum alur end-to-end seluruh role dan modul utama aplikasi. Bagian kredensial berisi akun yang terdeteksi dari seeder dan database aktif saat dokumen dibuat.

> **Kerahasiaan:** Dokumen ini berisi password akun uji. Simpan sebagai dokumen internal, jangan commit ke repository publik, dan ganti password default sebelum production.

---

## 1. Informasi lingkungan pengujian

### 1.1 URL aplikasi

| Kebutuhan | URL |
|---|---|
| Lokal Laravel | `http://localhost` |
| Lokal dengan artisan serve | `http://127.0.0.1:8000` |
| Tunnel terkonfigurasi | `https://sipus-polnep.my.id` |

Route dasar:

- Beranda: `/`
- Login: `/login`
- Registrasi: `/register`
- Dashboard router: `/dashboard`

### 1.2 Prasyarat

1. PHP 8.2+, Composer, Node.js/npm, dan dependency `vendor/` serta `node_modules/` tersedia.
2. MySQL aktif pada `127.0.0.1:3306` dan database `perpustakaan` dapat diakses oleh konfigurasi `.env`.
3. Migration sudah dijalankan dan database berisi role, prodi, kategori, akun, buku, koleksi, serta arsip yang diperlukan.
4. Siapkan file uji foto `.jpg/.jpeg/.png` maksimal 2 MB, PDF/Word arsip, serta Excel/CSV.
5. Untuk notifikasi eksternal, siapkan token/akun layanan secara terpisah. Token Fonnte, token Telegram, password SMTP, dan credential deployment tidak disalin ke dokumen ini.

### 1.3 Menjalankan aplikasi

```powershell
composer install
npm install
php artisan migrate
npm run build
php artisan serve
```

Jangan menjalankan `migrate:fresh --seed` pada database penting karena perintah tersebut menghapus seluruh tabel.

### 1.4 Verifikasi awal

1. Buka `/` dan `/login`; pastikan tidak ada error view.
2. Jalankan `php artisan route:list` dan pastikan route empat role muncul.
3. Jalankan `php artisan view:cache`.
4. Pastikan storage dapat membaca/menulis upload.
5. Snapshot database aktif saat dokumen dibuat:

   | Data | Jumlah |
   |---|---:|
   | User | 73 |
   | Admin | 1 |
   | Petugas | 1 |
   | Dosen | 1 |
   | Mahasiswa | 70 |
   | Buku | 50 |
   | Koleksi | 119 |
   | Arsip digital | 70 |
   | Sesi voting | 1 |
   | Usulan buku | 3 |
   | Peminjaman | 2 |
   | Booking | 2 |
   | Antrian | 0 |

---

---

## 2. Matriks akses role

| Role | Prefix route | Dashboard | Hak utama |
|---|---|---|---|
| Admin | `/admin` | `/admin/dashboard` | User, prodi/jurusan, konfigurasi notifikasi, template surat, audit log |
| Petugas | `/petugas` | `/petugas/dashboard` | Koleksi, anggota, transaksi, arsip, denda, laporan, usulan, voting |
| Dosen | `/dosen` | `/dosen/dashboard` | Katalog, booking, antrian, rak pinjam, usulan, voting, profil |
| Mahasiswa | `/mahasiswa` | `/mahasiswa/dashboard` | Katalog, booking, antrian, rak pinjam, arsip, usulan, voting, profil |

Route `/dashboard` mengarahkan user ke dashboard sesuai role. Akses role yang salah harus menghasilkan `403 Forbidden`.

---

---

## 3. Seluruh akun dan password

### 3.1 Akun aktif pada database runtime

Password berikut terverifikasi terhadap hash database aktif saat dokumen dibuat.

| ID | Nama | Role | Email login | Password | Status | Sumber |
|---:|---|---|---|---|---|---|
| 1 | Administrator | Admin | `admin@perpustakaan.com` | `admin123` | verified | seeder |
| 2 | Budi | Petugas | `petugas@test.com` | `password` | verified | runtime/manual |
| 3 | Suharsono, S.Kom., M.Kom. | Dosen | `dosen@perpustakaan.com` | `password` | verified | runtime/seeder role |
| 4 | Ryan | Mahasiswa | `mahasiswa@perpustakaan.com` | `password` | verified | runtime/seeder role |
| 5 | Dika Muzalifah | Mahasiswa | `3202216130@sipus.polnep.ac.id` | `sipus3202216130` | verified | import user |
| 6 | Fadli Nurhidayat | Mahasiswa | `3202216063@sipus.polnep.ac.id` | `sipus3202216063` | verified | import user |
| 7 | Raycal Pranata | Mahasiswa | `3202216090@sipus.polnep.ac.id` | `sipus3202216090` | verified | import user |
| 8 | Sultan Arya Adhyaksa | Mahasiswa | `3202216094@sipus.polnep.ac.id` | `sipus3202216094` | verified | import user |
| 9 | Isma Nasution | Mahasiswa | `3202216143@sipus.polnep.ac.id` | `sipus3202216143` | verified | import user |
| 10 | Muhammad Ilham Yumar | Mahasiswa | `3202216084@sipus.polnep.ac.id` | `sipus3202216084` | verified | import user |
| 11 | Nizar Khawarizmi | Mahasiswa | `3202216105@sipus.polnep.ac.id` | `sipus3202216105` | verified | import user |
| 12 | Ariel Wira Ramadan | Mahasiswa | `3202216069@sipus.polnep.ac.id` | `sipus3202216069` | verified | import user |
| 13 | NANDA IKHWANUL NADLIRIN | Mahasiswa | `3202216125@sipus.polnep.ac.id` | `sipus3202216125` | verified | import user |
| 14 | Fachri Hibatul Haq | Mahasiswa | `3202216122@sipus.polnep.ac.id` | `sipus3202216122` | verified | import user |
| 15 | Muhamad Syafarudin Ilham | Mahasiswa | `3202216114@sipus.polnep.ac.id` | `sipus3202216114` | verified | import user |
| 16 | Belva Mieko Suparwanto | Mahasiswa | `3202216075@sipus.polnep.ac.id` | `sipus3202216075` | verified | import user |
| 17 | Aspariansyah | Mahasiswa | `3202216113@sipus.polnep.ac.id` | `sipus3202216113` | verified | import user |
| 18 | Ulfah Dwi Nazarina | Mahasiswa | `3202216004@sipus.polnep.ac.id` | `sipus3202216004` | verified | import user |
| 19 | Peti Lesmasari | Mahasiswa | `3202216010@sipus.polnep.ac.id` | `sipus3202216010` | verified | import user |
| 20 | Yoga Pradana | Mahasiswa | `3202216126@sipus.polnep.ac.id` | `sipus3202216126` | verified | import user |
| 21 | Nurul Ersya Citra | Mahasiswa | `3202216060@sipus.polnep.ac.id` | `sipus3202216060` | verified | import user |
| 22 | Wympi Saristo | Mahasiswa | `3202216021@sipus.polnep.ac.id` | `sipus3202216021` | verified | import user |
| 23 | Muhammad Rafli Nur Hidayat | Mahasiswa | `3202216142@sipus.polnep.ac.id` | `sipus3202216142` | verified | import user |
| 24 | Grata | Mahasiswa | `3202216066@sipus.polnep.ac.id` | `sipus3202216066` | verified | import user |
| 25 | Diana Dwi Apita | Mahasiswa | `3202216007@sipus.polnep.ac.id` | `sipus3202216007` | verified | import user |
| 26 | Satria Firlyandra | Mahasiswa | `3202216088@sipus.polnep.ac.id` | `sipus3202216088` | verified | import user |
| 27 | Yuliana Putri | Mahasiswa | `3202216081@sipus.polnep.ac.id` | `sipus3202216081` | verified | import user |
| 28 | Amelia | Mahasiswa | `3202216038@sipus.polnep.ac.id` | `sipus3202216038` | verified | import user |
| 29 | Utari Adistya Putri | Mahasiswa | `3202216025@sipus.polnep.ac.id` | `sipus3202216025` | verified | import user |
| 30 | Dayang Zulaikha Fakhira | Mahasiswa | `3202216129@sipus.polnep.ac.id` | `sipus3202216129` | verified | import user |
| 31 | Andika Jaya Nanda | Mahasiswa | `3202216064@sipus.polnep.ac.id` | `sipus3202216064` | verified | import user |
| 32 | Adinda Thalia Putri Salsabila | Mahasiswa | `3202216092@sipus.polnep.ac.id` | `sipus3202216092` | verified | import user |
| 33 | Eja Sapario | Mahasiswa | `3202216070@sipus.polnep.ac.id` | `sipus3202216070` | verified | import user |
| 34 | Muhamad Jakarya | Mahasiswa | `3202216024@sipus.polnep.ac.id` | `sipus3202216024` | verified | import user |
| 35 | Aini Jelita Puspa Ningrum | Mahasiswa | `3202216083@sipus.polnep.ac.id` | `sipus3202216083` | verified | import user |
| 36 | Anggi Nabila Sulistianingsih | Mahasiswa | `3202216039@sipus.polnep.ac.id` | `sipus3202216039` | verified | import user |
| 37 | Muhamad Sigit Firmansyah | Mahasiswa | `3202216146@sipus.polnep.ac.id` | `sipus3202216146` | verified | import user |
| 38 | Akram Nur Adha | Mahasiswa | `3202216053@sipus.polnep.ac.id` | `sipus3202216053` | verified | import user |
| 39 | Gilang Arya Libna | Mahasiswa | `3202216051@sipus.polnep.ac.id` | `sipus3202216051` | verified | import user |
| 40 | Rizky Puspita Sari | Mahasiswa | `3202216086@sipus.polnep.ac.id` | `sipus3202216086` | verified | import user |
| 41 | Ferry Perdian | Mahasiswa | `3202216011@sipus.polnep.ac.id` | `sipus3202216011` | verified | import user |
| 42 | Fellix | Mahasiswa | `3202216107@sipus.polnep.ac.id` | `sipus3202216107` | verified | import user |
| 43 | Radisa Pradiptya | Mahasiswa | `3202216073@sipus.polnep.ac.id` | `sipus3202216073` | verified | import user |
| 44 | Awang Praja Anugerah | Mahasiswa | `3202216068@sipus.polnep.ac.id` | `sipus3202216068` | verified | import user |
| 45 | Dhiya Apriana | Mahasiswa | `3202216012@sipus.polnep.ac.id` | `sipus3202216012` | verified | import user |
| 46 | Dwi Ananda Deli Hediyatna Putra | Mahasiswa | `3202216054@sipus.polnep.ac.id` | `sipus3202216054` | verified | import user |
| 47 | IRFAN AFIF | Mahasiswa | `3202216059@sipus.polnep.ac.id` | `sipus3202216059` | verified | import user |
| 48 | naia fatiha | Mahasiswa | `3202216110@sipus.polnep.ac.id` | `sipus3202216110` | verified | import user |
| 49 | Rifqi Rahmatullah | Mahasiswa | `3202216048@sipus.polnep.ac.id` | `sipus3202216048` | verified | import user |
| 50 | NIRMALA | Mahasiswa | `3202216065@sipus.polnep.ac.id` | `sipus3202216065` | verified | import user |
| 51 | Desi Viviani | Mahasiswa | `3202216008@sipus.polnep.ac.id` | `sipus3202216008` | verified | import user |
| 52 | Farah Khairina | Mahasiswa | `3202216111@sipus.polnep.ac.id` | `sipus3202216111` | verified | import user |
| 53 | Doni Fitriansyah | Mahasiswa | `3202216112@sipus.polnep.ac.id` | `sipus3202216112` | verified | import user |
| 54 | Juwita | Mahasiswa | `3202116053@sipus.polnep.ac.id` | `sipus3202116053` | verified | import user |
| 55 | Sinta | Mahasiswa | `3202216050@sipus.polnep.ac.id` | `sipus3202216050` | verified | import user |
| 56 | Atha Nala Isra Raditya | Mahasiswa | `3202216006@sipus.polnep.ac.id` | `sipus3202216006` | verified | import user |
| 57 | Siti Sabrina Oktavia | Mahasiswa | `3202216002@sipus.polnep.ac.id` | `sipus3202216002` | verified | import user |
| 58 | Fata Humam Asadillah | Mahasiswa | `3202216023@sipus.polnep.ac.id` | `sipus3202216023` | verified | import user |
| 59 | AHMAD NURSABANDI | Mahasiswa | `3202339015@sipus.polnep.ac.id` | `sipus3202339015` | verified | import user |
| 60 | Ayuning Lita | Mahasiswa | `3202339004@sipus.polnep.ac.id` | `sipus3202339004` | verified | import user |
| 61 | IHLASYA AMALIA | Mahasiswa | `3202339001@sipus.polnep.ac.id` | `sipus3202339001` | verified | import user |
| 62 | M.RIDHONI | Mahasiswa | `3202339012@sipus.polnep.ac.id` | `sipus3202339012` | verified | import user |
| 63 | MAHFUZAH | Mahasiswa | `3202339010@sipus.polnep.ac.id` | `sipus3202339010` | verified | import user |
| 64 | MUHAMMAD LINTANG SUSANTO | Mahasiswa | `3202339003@sipus.polnep.ac.id` | `sipus3202339003` | verified | import user |
| 65 | NURUL DIAH RAHMADIAH | Mahasiswa | `3202339007@sipus.polnep.ac.id` | `sipus3202339007` | verified | import user |
| 66 | PICA | Mahasiswa | `3202339011@sipus.polnep.ac.id` | `sipus3202339011` | verified | import user |
| 67 | RAYNA ADE SAKIRA | Mahasiswa | `3202339008@sipus.polnep.ac.id` | `sipus3202339008` | verified | import user |
| 68 | REFI YANDA | Mahasiswa | `3202339013@sipus.polnep.ac.id` | `sipus3202339013` | verified | import user |
| 69 | SAHID RAHMAN MAULANA | Mahasiswa | `3202339006@sipus.polnep.ac.id` | `sipus3202339006` | verified | import user |
| 70 | SULAIMAN AL MADANI | Mahasiswa | `3202339005@sipus.polnep.ac.id` | `sipus3202339005` | verified | import user |
| 71 | ZAHRAH YULIA RAHMAN | Mahasiswa | `3202339009@sipus.polnep.ac.id` | `sipus3202339009` | verified | import user |
| 72 | ZIA NOVITA | Mahasiswa | `3202339014@sipus.polnep.ac.id` | `sipus3202339014` | verified | import user |
| 73 | Ryan | Mahasiswa | `ryankrick06@gmail.com` | **Tidak tersedia; hanya hash** | verified | runtime/manual |

### 3.2 Perbedaan seeder dan database aktif

`database/seeders/UserSeeder.php` mendefinisikan `petugas@perpustakaan.com` dengan password `password`, tetapi akun Petugas yang ditemukan aktif adalah `petugas@test.com`. Pada database baru, gunakan alamat yang benar-benar tercipta setelah seeding.

### 3.3 Pola akun hasil import

Fitur Admin > Kelola User > Import Excel membuat akun dengan aturan:

```text
Email    = [NIM/NIP]@sipus.polnep.ac.id
Password = sipus[NIM/NIP]
```

Contoh `3202216130` menjadi `3202216130@sipus.polnep.ac.id` / `sipus3202216130`.

### 3.4 Password yang tidak dapat dipulihkan

Password `ryankrick06@gmail.com` tidak tersedia sebagai plaintext di kode maupun konfigurasi. Database hanya menyimpan hash. Untuk membuatnya bisa dipakai:

1. Login sebagai Admin.
2. Buka **Kelola User**, cari `ryankrick06@gmail.com` atau NIM `3202316109`.
3. Klik **Edit**, isi password baru minimal 8 karakter dan konfirmasi, lalu simpan.
4. Simpan password baru di password manager internal, bukan di repository.

---

---

## 4. Alur E2E umum

1. Buka `/login`.
2. Isi email dan password dari matriks akun.
3. Klik **Masuk**.
4. Pastikan `/dashboard` mengarah ke dashboard role.
5. Jalankan fitur dari sidebar.
6. Verifikasi toast, perubahan database, stok, notifikasi, dan activity log.
7. Klik ikon lonceng untuk memeriksa unread, baca satu, tandai semua dibaca, dan hapus satu.
8. Logout melalui menu user.
9. Pastikan session berakhir dan route dashboard berikutnya mengarah ke `/login`.

### 4.1 Login berhasil

**Precondition:** akun `verified` dan password benar.

Expected result:

- Admin → `/admin/dashboard`;
- Petugas → `/petugas/dashboard`;
- Dosen → `/dosen/dashboard`;
- Mahasiswa → `/mahasiswa/dashboard`.

### 4.2 Login gagal

1. Uji password salah, email tidak terdaftar, dan format email invalid.
2. Expected result: validasi/pesan kredensial gagal dan session tidak terbentuk.
3. Ulangi kegagalan hingga melewati batas lima percobaan per email/IP.
4. Expected result: pesan throttling sementara tampil.

### 4.3 Registrasi akun pending

1. Buka `/register`, pilih Mahasiswa atau Dosen.
2. Isi nama, email unik, prodi, nomor HP, password, foto identitas, dan identitas role:
   - Mahasiswa: NIM dan semester;
   - Dosen: NIP.
3. Kirim form.
4. Expected result: user/profile dibuat dengan `status_verifikasi=pending`, foto tersimpan, notifikasi bell dikirim ke Admin/Petugas, lalu kembali ke login.
5. Coba login sebelum approval.
6. Expected result: login dibatalkan dan pesan akun belum terverifikasi tampil.

### 4.4 Verifikasi anggota

**Login Petugas:** `petugas@test.com` / `password`.

1. Buka `/petugas/members?tab=pending`.
2. Klik **Lihat KTM**, periksa data, lalu pilih **Setujui**.
3. Expected result: status `verified`, email approval dicoba, notifikasi bell anggota dibuat, dan activity log tercatat.
4. Ulangi dengan akun pending lain, pilih **Tolak**, isi alasan.
5. Expected result: email rejection dicoba, foto dan data pending dibersihkan, serta alasan tercatat.

---

---

## 5. E2E Mahasiswa

**Akun utama:** `mahasiswa@perpustakaan.com` / `password`.  
**Akun alternatif import:** `3202216130@sipus.polnep.ac.id` / `sipus3202216130`.

### 5.1 Dashboard dan notifikasi

1. Login dan pastikan `/mahasiswa/dashboard` tampil.
2. Verifikasi ringkasan pinjaman, denda, booking/antrian, statistik, dan rekomendasi/voting bila data tersedia.
3. Klik ikon lonceng; feed harus hanya berisi notifikasi user.
4. Klik satu item; item menjadi terbaca dan user diarahkan ke URL tujuan.
5. Uji **Tandai Semua Dibaca** dan hapus satu item.

### 5.2 Katalog buku

1. Buka **Koleksi Perpustakaan > Buku** (`/mahasiswa/books`).
2. Cari judul, penulis, dan kategori; uji hasil dan tanpa hasil.
3. Pastikan kartu menampilkan judul, penulis, kategori, cover, stok, dan status.
4. Stok > 0 harus menampilkan **Booking Buku**; stok = 0 harus menampilkan **Daftar Antrian**.

### 5.3 Booking buku tersedia

1. Pilih buku dengan stok > 0 dan klik **Booking Buku**.
2. Expected result:
   - booking dibuat dengan status `pending`;
   - notifikasi dikirim ke Mahasiswa serta Petugas/Admin;
   - halaman menampilkan pesan menunggu persetujuan.
3. Buka `/mahasiswa/bookings` dan pastikan judul, tanggal, serta status tampil.
4. Klik **Batalkan**, isi alasan, dan konfirmasi.
5. Expected result: status `dibatalkan`; bila sebelumnya `disetujui`, stok dikembalikan.

### 5.4 Antrian buku habis

**Precondition:** koleksi memiliki stok `0`.

1. Dari katalog, klik **Daftar Antrian**.
2. Expected result: record `menunggu`, nomor antrian, dan posisi orang di depan dibuat.
3. Buka `/mahasiswa/antrian` dan verifikasi nomor/status.
4. Klik **Batalkan** bila diperlukan.
5. Expected result: status `dibatalkan` dan tidak dapat dibatalkan ulang.

### 5.5 Rak pinjam, riwayat, dan denda

1. Buka `/mahasiswa/loans`; hanya loan `dipinjam`/`terlambat` yang tampil.
2. Buka `/mahasiswa/loans/history`; pastikan loan `dikembalikan`/`hilang` dan log baca digital tampil.
3. Buka `/mahasiswa/loans/penalties`; verifikasi jumlah denda belum dibayar, total nominal, status lunas, jenis sanksi, judul, dan keterangan.

### 5.6 Upload arsip digital

1. Buka `/mahasiswa/arsip` dan klik **Unggah Karya Ilmiah**.
2. Pilih Laporan PKL, Proposal TA, atau Laporan Tugas Akhir.
3. Isi judul, pembimbing, minimal satu penguji, tahun; untuk PKL isi tempat PKL.
4. Upload PDF utama dan Word pendukung lalu simpan.
5. Expected result:
   - status `menunggu`;
   - PDF/Word tersimpan di storage private;
   - preview PDF dibuat;
   - notifikasi bell dikirim ke Petugas/Admin.
6. Edit arsip pending/ditolak, ubah metadata/file, dan kirim ulang.
7. Expected result: status kembali `menunggu`.
8. Hapus arsip yang masih editable; file dan record harus terhapus.

Validasi minimum:

| Skenario | Expected result |
|---|---|
| Judul/pembimbing kosong | Ditolak |
| Penguji 1 dan 2 sama-sama kosong | Ditolak |
| Tahun bukan 4 digit | Ditolak |
| PKL tanpa tempat PKL | Ditolak |
| PDF/Word wajib create tidak ada | Ditolak |
| Ekstensi file salah atau melewati ukuran | Ditolak |
| Arsip sudah aktif diedit/hapus mahasiswa | Ditolak |

### 5.7 Voting buku

1. Buka `/mahasiswa/voting` dan pastikan sesi aktif tampil.
2. Klik **Vote** pada kandidat; jumlah suara bertambah.
3. Klik kandidat yang sama lagi; suara ditoggle/dibatalkan, bukan digandakan.
4. Uji sesi belum mulai/sudah berakhir; vote harus ditolak.

### 5.8 Usulan buku

1. Buka `/mahasiswa/recommendations` lalu **Buat Usulan**.
2. Isi judul, penulis, alasan, dan kirim.
3. Expected result: usulan tersimpan `pending`, muncul di daftar milik Mahasiswa, dan activity log tercatat.
4. Judul kosong harus menghasilkan validasi.

### 5.9 Profil Mahasiswa

1. Buka `/profile`, ubah nama/email/nomor HP/Telegram Chat ID, lalu simpan.
2. Ubah password dengan password baru dan konfirmasi yang sama.
3. Logout dan login dengan password baru.
4. Password lama atau konfirmasi yang salah harus ditolak.
5. Hapus akun hanya pada akun disposable; session harus berakhir.

---

## 6. E2E Dosen

**Akun:** `dosen@perpustakaan.com` / `password`.

Dosen menjalankan alur anggota untuk katalog, booking, antrian, rak pinjam, denda, riwayat, usulan, voting, notifikasi, dan profil. Dosen tidak memiliki menu upload repository mandiri.

### 6.1 Checklist Dosen

1. Login dan pastikan `/dosen/dashboard` tampil.
2. Buka `/dosen/books`; cari buku berdasarkan judul/penulis/kategori.
3. Buka `/dosen/katalog-arsip`; filter jenis, prodi, tahun, dan pencarian.
4. Buka detail, preview, dan **Baca Full / Stream**; pastikan read log dibuat.
5. Booking koleksi tersedia, lalu cek `/dosen/bookings` dan batalkan bila diperlukan.
6. Daftar antrian koleksi habis, lalu cek `/dosen/antrian`.
7. Buka `/dosen/loans`, `/dosen/loans/history`, dan `/dosen/loans/penalties`.
8. Buat usulan pada `/dosen/recommendations`.
9. Vote dan toggle vote pada `/dosen/voting`.
10. Pastikan Dosen tidak dapat membuka route Mahasiswa untuk upload arsip atau route Petugas/Admin.

---

## 7. E2E Petugas Perpustakaan

**Akun runtime:** `petugas@test.com` / `password`.  
**Akun seeder alternatif:** `petugas@perpustakaan.com` / `password` bila akun tersebut dibuat pada database baru.

### 7.1 Dashboard

1. Login dan pastikan `/petugas/dashboard` tampil.
2. Verifikasi statistik buku, anggota, transaksi, arsip, booking, antrian, usulan, dan badge tugas pending.

### 7.2 Kelola buku dan kategori

1. Buka `/petugas/books`, klik **Tambah Buku Baru**.
2. Isi judul, penulis, penerbit, tahun, kategori, stok, dan cover jika ada.
3. Simpan; buku dan koleksi fisik harus tersinkronisasi.
4. Edit metadata/stok dan simpan.
5. Hapus buku uji tanpa transaksi aktif.
6. Buka `/petugas/categories`; tambah, edit, dan hapus kategori yang tidak digunakan.
7. Hapus kategori yang masih digunakan; sistem harus menolak atau memberi peringatan.

### 7.3 Import buku Excel/CSV

1. Buka form **Import Excel** (`/petugas/books-import`) dan download template.
2. Isi judul, penulis, penerbit, tahun terbit, stok, dan kategori.
3. Upload `.xlsx`, `.xls`, atau `.csv` maksimal 10 MB.
4. Expected result: baris valid membuat buku/koleksi, kategori dicari case-insensitive atau dibuat, duplikat judul+penulis di-skip, dan activity log tercatat.
5. Uji file kosong/header saja; harus ditolak.
6. Uji stok negatif, tahun invalid, dan field wajib kosong; seluruh batch harus rollback dan detail error tampil.
7. Upload file sama lagi; baris duplikat harus di-skip.

### 7.4 Kelola anggota dan verifikasi

1. Buka `/petugas/members`.
2. Gunakan tab verified/pending dan filter nama, email, NIM/NIP, role, atau prodi.
3. Buka detail anggota; verifikasi pinjaman aktif, riwayat, denda, dan log baca digital.
4. Buat anggota baru, edit, reset password, dan hapus akun uji sesuai kebutuhan.
5. Pada tab pending, klik **Lihat KTM**, lalu **Setujui** atau **Tolak** dengan alasan.

### 7.5 Kelola arsip digital

1. Buka `/petugas/arsip`, filter jenis/status, cari judul/nama/NIM/prodi.
2. Buka detail dan uji download PDF asli, Word, serta preview.
3. Klik **Verifikasi** pada status `menunggu`.
4. Expected result: status `diverifikasi`, timestamp tersimpan, Surat Tanda Terima PDF dan nomor surat dibuat, email dicoba dikirim, dan notifikasi bell dikirim ke Mahasiswa.
5. Klik **Tolak**, isi catatan perbaikan, lalu simpan.
6. Expected result: status `ditolak`, catatan tampil pada Mahasiswa, dan Mahasiswa dapat edit/kirim ulang.
7. Pada status `diverifikasi`, klik **Konfirmasi Terima**.
8. Expected result: status `aktif`, `received_at` tersimpan, koleksi arsip dibuat/di-update dengan stock `1`, dan arsip masuk katalog serta sirkulasi.
9. Download Surat Tanda Terima dan periksa nomor, identitas, judul, pembimbing, penguji, serta kop.

### 7.6 Import arsip digital

1. Buka `/petugas/arsip-import`, pilih jenis, dan download template.
2. Isi NIM, nama, prodi, judul, pembimbing, penguji, tahun, dan tempat PKL bila tipe PKL.
3. Upload file.
4. Expected result: akun alumni dapat dibuat bila NIM belum ada dan prodi valid, arsip/koleksi dibuat sesuai aturan, duplikat NIM+jenis di-skip, dan activity log tercatat.
5. Prodi yang tidak cocok harus membatalkan import dan menampilkan error.

### 7.7 Peminjaman manual

1. Buka `/petugas/loans/create`.
2. Cari anggota berdasarkan nama/NIM/NIP dan pilih koleksi yang stoknya tersedia.
3. Isi tanggal pinjam dan batas waktu, lalu klik **Proses Peminjaman**.
4. Expected result:
   - loan dibuat per koleksi dengan status `dipinjam`;
   - stok berkurang `1` per item;
   - antrian aktif anggota untuk item tersebut menjadi selesai;
   - notifikasi bell dan activity log tercatat;
   - WA/Telegram dicoba bila konfigurasi aktif.
5. Stok habis, tanggal batas sebelum tanggal pinjam, atau pinjaman aktif duplikat harus ditolak.

### 7.8 Pengembalian kondisi baik

1. Buka `/petugas/returns`, pilih transaksi, dan klik **Kembalikan/Proses**.
2. Pilih **Ada / Inspeksi Fisik** dan biarkan semua checklist baik.
3. Simpan.
4. Expected result: loan `dikembalikan`, tanggal kembali tersimpan, stok +1, tidak ada sanksi kerusakan, dan denda terlambat hanya dibuat bila melewati jatuh tempo.

### 7.9 Pengembalian terlambat

1. Siapkan loan aktif dengan batas waktu sebelum hari ini.
2. Buka halaman transaksi agar status tersinkron menjadi `terlambat`.
3. Proses pengembalian kondisi baik.
4. Expected result: denda dibuat sesuai aturan `per_hari`, `flat`, atau `manual`.

### 7.10 Pengembalian rusak

1. Pilih inspeksi fisik, hapus centang satu/lebih checklist, isi catatan inspeksi, jenis sanksi, metode, dan keterangan.
2. Simpan.
3. Expected result: loan ditutup, kondisi `bermasalah`, checklist/catatan tersimpan, penalty tercipta, stok/notifikasi sesuai aturan.
4. Kondisi bermasalah tanpa catatan harus ditolak.

### 7.11 Buku hilang

1. Pilih mode **Buku Hilang**, isi catatan, dan pilih metode uang tunai, ganti buku, atau kombinasi.
2. Simpan.
3. Expected result: loan `hilang`, penalty kehilangan tercipta, stok tidak bertambah langsung untuk uang tunai, dan stok bertambah setelah penggantian dikonfirmasi untuk metode penggantian/kombinasi.
4. Buka `/petugas/penalties`; gunakan **Tandai Lunas** atau **Konfirmasi Penggantian**.

### 7.12 Booking dan antrian oleh Petugas

1. Buka `/petugas/bookings`, filter `pending`, lalu klik **Setujui**.
2. Isi jam pengambilan/catatan.
3. Expected result: booking `disetujui`, batas ambil tersimpan, stok -1, notifikasi anggota dibuat.
4. Klik **Realisasi**; expected result booking `selesai` dan loan aktif dibuat dengan jatuh tempo default 7 hari.
5. Uji **Tolak**; booking menjadi `dibatalkan` dengan catatan.
6. Buka `/petugas/antrian`; setelah return stok, pastikan antrian terdepan menjadi `tersedia`, notifikasi dicoba, dan **Tandai Selesai** mengubah status menjadi `selesai`.

### 7.13 Denda dan rules pengembalian

1. Buka `/petugas/penalties`, cari nama/NIM/NIP/judul, dan buka detail.
2. Pastikan anggota, koleksi, tipe, metode, nominal, dan aturan tampil benar.
3. Tandai denda lunas; status menjadi `lunas` dan muncul pada Denda Saya.
4. Buka `/petugas/return-settings`; tambah/edit/nonaktifkan checklist.
5. Edit aturan keterlambatan, kerusakan, dan kehilangan, lalu uji pengembalian berikutnya.

### 7.14 Usulan, voting, laporan

1. Buka `/petugas/recommendations`; filter pending, setujui/tolak, dan opsional masukkan ke voting aktif.
2. Buka `/petugas/voting`; buat sesi, isi judul/deskripsi/tanggal, tambahkan kandidat dari usulan atau manual, dan periksa peringkat suara.
3. Buka `/petugas/reports`; uji Sirkulasi, Koleksi, Arsip, dan Denda dengan filter.
4. Uji Print dan Export Excel.
5. Catatan: endpoint print saat ini perlu diverifikasi sebagai print view HTML; bila requirement meminta PDF native, lakukan perubahan implementasi sebelum menyatakan lulus penuh.

---

---

## 8. E2E Admin

**Akun:** `admin@perpustakaan.com` / `admin123`.

### 8.1 Dashboard dan user

1. Login dan pastikan `/admin/dashboard` tampil.
2. Buka `/admin/users`, cari berdasarkan nama/email/NIM/NIP/role.
3. Tambah user Admin, Petugas, Dosen, atau Mahasiswa sesuai field role.
4. Edit user dan uji reset password.
5. Hapus hanya akun disposable.
6. Expected result: data user dan profil role tetap konsisten.

### 8.2 Prodi dan jurusan

1. Buka `/admin/prodis`.
2. Tambah prodi dan jurusan, edit data, lalu periksa form registrasi/import.
3. Expected result: prodi baru tersedia sebagai pilihan.
4. Hapus data akademik hanya jika tidak memiliki dependensi.

### 8.3 Import user Excel/CSV

1. Buka `/admin/users-import` dan download template.
2. Isi Nama Lengkap, NIM/NIP, Jurusan, Program Studi, dan Semester.
3. Semester terisi → Mahasiswa; Semester kosong → Dosen.
4. Upload file `.xlsx`, `.xls`, atau `.csv` maksimal 10 MB.
5. Expected result:
   - email `[NIM/NIP]@sipus.polnep.ac.id` dibuat;
   - password awal `sipus[NIM/NIP]` dibuat;
   - NIM/NIP duplikat di-skip;
   - pencocokan prodi tidak sensitif huruf besar/kecil;
   - activity log import tercatat.
6. Upload file yang sama lagi; data harus di-skip tanpa akun ganda.
7. Uji prodi fiktif atau field wajib kosong; seluruh batch harus rollback dan error baris ditampilkan.

### 8.4 WhatsApp/Fonnte

1. Buka `/admin/settings/wa`.
2. Isi token Fonnte pada konfigurasi internal, toggle aktif/nonaktif, dan nama pengirim.
3. Simpan dan jalankan **Test Kirim WA** dengan nomor/pesan uji.
4. Expected result: pengaturan tersimpan; layanan valid mengirim pesan; kegagalan tersedia di `storage/logs/laravel.log`.

### 8.5 Telegram

1. Buka `/admin/settings/telegram`.
2. Isi Bot Token, username bot, toggle aktif, dan simpan.
3. Isi Chat ID penerima yang sudah menekan `/start`, lalu klik **Test Kirim Telegram**.
4. Expected result: pesan terkirim jika token, Chat ID, dan bot benar; toggle nonaktif melewati pengiriman dan dicatat pada log.

### 8.6 Email SMTP

1. Buka `/admin/settings/email`.
2. Isi mailer, host, port, encryption, username, password, alamat, dan nama pengirim.
3. Simpan dan jalankan **Test Kirim Email Real-Time**.
4. Expected result: konfigurasi valid mengirim email; invalid menampilkan error tanpa merusak konfigurasi awal.
5. Password SMTP tidak boleh masuk screenshot, export, log CI, atau dokumen lain.

### 8.7 Surat Tanda Terima dan activity log

1. Buka `/admin/settings/receipt`.
2. Isi nama penerima, NIP, jabatan, kode surat, tiga baris kop, alamat, dan upload logo maksimal 2 MB.
3. Klik **Preview PDF Real-Time**.
4. Expected result: PDF preview tampil dengan data override dan layout tidak terpotong.
5. Buka `/admin/activity-logs`.
6. Cari aktivitas login, import, CRUD, transaksi, verifikasi arsip, voting, dan logout.

---

## 9. Alur bisnis E2E lintas role

### 9.1 Registrasi → verifikasi → login

```text
Mahasiswa/Dosen register
        ↓
Isi profil + foto identitas
        ↓
User status pending
        ↓
Bell ke Admin/Petugas
        ↓
Petugas memeriksa data
        ├── Tolak → email alasan + data pending dibersihkan
        └── Setujui → verified + notifikasi anggota
                              ↓
                    Anggota login ke dashboard
```

### 9.2 Booking → persetujuan → peminjaman

```text
Anggota memilih stok > 0
        ↓
Booking pending
        ↓
Petugas menyetujui + batas ambil
        ↓
Booking disetujui, stock -1
        ↓
Petugas Realisasi
        ↓
Booking selesai + Loan dipinjam
```

### 9.3 Buku habis → antrian → return

```text
Stok = 0 → daftar antrian → nomor menunggu
        ↓
Peminjam sebelumnya return
        ↓
Antrian terdepan menjadi tersedia
        ↓
Bell/WA/Telegram sesuai konfigurasi
        ↓
Anggota mengambil, membatalkan, atau Petugas menandai selesai
```

### 9.4 Peminjaman → pengembalian → denda

```text
Petugas membuat loan → stock -1 → dipinjam
        ↓
Return kondisi baik → dikembalikan + stock 1
        ↓
Jika terlambat → denda otomatis
        ↓
Jika rusak/hilang → inspeksi/sanksi → Denda Saya
```

### 9.5 Upload arsip → verifikasi → surat → katalog

```text
Mahasiswa upload PDF + Word
        ↓
Menunggu
        ├── Tolak → catatan → edit + kirim ulang
        └── Verifikasi → diverifikasi + preview/surat/nomor
                                      ↓
                            Fisik diterima
                                      ↓
                   Konfirmasi Terima → aktif + stock 1
                                      ↓
                        katalog → stream → read log
```

### 9.6 Usulan → voting

```text
Mahasiswa/Dosen mengusulkan buku
        ↓
Pending
        ↓
Petugas menyetujui/reject
        ↓
Usulan masuk sesi voting
        ↓
Mahasiswa/Dosen vote atau cancel vote
        ↓
Petugas melihat ranking kandidat
```

---

## 10. Scheduler, reminder, dan katalog arsip

Command reminder:

```powershell
php artisan loans:send-reminders
```

Scheduler terdaftar pada `routes/console.php` dan dijadwalkan harian pukul `10:33` waktu aplikasi.

### 10.1 Reminder H-1

1. Siapkan loan aktif berstatus `dipinjam` dengan batas waktu besok.
2. Jalankan command.
3. Expected result: bell H-1 dibuat, WA dicoba jika nomor/token tersedia, Telegram dicoba jika Chat ID/bot aktif, dan output command menampilkan counter.

### 10.2 Reminder terlambat

1. Siapkan loan dengan batas waktu terlewati.
2. Jalankan command atau buka halaman transaksi yang menjalankan sinkronisasi status.
3. Expected result: status menjadi `terlambat`, bell keterlambatan dibuat, WA/Telegram dicoba, dan Petugas dapat memproses return/denda.

### 10.3 Katalog dan read log

1. Login Mahasiswa/Dosen dan buka katalog arsip.
2. Filter jenis, prodi, tahun, dan pencarian.
3. Buka detail, preview PDF, lalu **Baca Full / Stream**.
4. Expected result: viewer inline terbuka, `ArchiveReadLog` dibuat, dan saat viewer/tab selesai endpoint close log mengisi `finished_at`.
5. Buka riwayat; aktivitas digital tampil bersama riwayat fisik.

Jika token eksternal kosong, transaksi database inti tetap harus selesai; kegagalan channel tercatat di `storage/logs/laravel.log`.

---

## 11. Authorization dan keamanan dasar

| Actor | URL | Expected result |
|---|---|---|
| Guest | `/admin/dashboard` | Redirect ke `/login` |
| Mahasiswa | `/admin/dashboard` | `403 Forbidden` |
| Mahasiswa | `/petugas/loans` | `403 Forbidden` |
| Dosen | `/petugas/loans` | `403 Forbidden` |
| Petugas | `/admin/users` | `403 Forbidden` |
| Admin | `/petugas/loans` | `403 Forbidden` |
| Dosen | `/mahasiswa/arsip` | `403`/route tidak tersedia |
| Mahasiswa A | Edit arsip Mahasiswa B | `403 Forbidden` |
| Guest | File private arsip | Login/ditolak |
| Anggota | Penalty anggota lain | Data tidak terlihat |
| Anggota | Booking/antrian user lain | Ditolak |

Uji CSRF pada seluruh form POST/PUT/PATCH/DELETE dan pastikan token tidak dihilangkan.

---

## 12. Checklist E2E singkat

### 12.1 Autentikasi

- [ ] Beranda dan login tampil.
- [ ] Login Admin, Petugas, Dosen, Mahasiswa berhasil.
- [ ] Password salah, email invalid, dan throttling diuji.
- [ ] Registrasi Mahasiswa/Dosen menghasilkan pending.
- [ ] Approval mengubah verified.
- [ ] Rejection menghapus data pending dan menyimpan alasan.
- [ ] Lupa/reset password diuji.
- [ ] Logout mengakhiri session.

### 12.2 Anggota

- [ ] Dashboard role tampil.
- [ ] Katalog buku dan arsip dapat dicari/filter.
- [ ] Preview/full stream dan read log berjalan.
- [ ] Booking tersedia dan pembatalan berjalan.
- [ ] Antrian stok habis dan pembatalan berjalan.
- [ ] Pinjaman aktif, riwayat, dan Denda Saya tampil.
- [ ] Upload/edit/delete arsip berjalan.
- [ ] Usulan dan voting berjalan tanpa double vote.
- [ ] Profil dan perubahan password berjalan.

### 12.3 Petugas

- [ ] CRUD/import buku dan kategori.
- [ ] CRUD/import anggota dan verifikasi identitas.
- [ ] Import/verifikasi/reject/confirm arsip.
- [ ] Surat tanda terima dapat dibuat/diunduh.
- [ ] Peminjaman dan stok berjalan.
- [ ] Return baik/terlambat/rusak/hilang berjalan.
- [ ] Booking approval/reject/realize berjalan.
- [ ] Antrian tersedia/selesai berjalan.
- [ ] Denda dan rules return berjalan.
- [ ] Laporan print/export berjalan.
- [ ] Usulan dan sesi voting berjalan.

### 12.4 Admin

- [ ] CRUD seluruh role berjalan.
- [ ] Import user membuat email/password pola.
- [ ] Prodi/jurusan dapat dikelola.
- [ ] Pengaturan WA/Telegram/SMTP dapat disimpan dan diuji.
- [ ] Template surat/logo dapat diubah dan dipreview.
- [ ] Activity log mencatat aktivitas lintas modul.

---

## 13. Artefak bukti uji

Simpan bukti internal dengan nama tanpa password:

```text
e2e-01-login-admin.png
e2e-02-login-petugas.png
e2e-03-register-pending.png
e2e-04-approval-member.png
e2e-05-booking-approved.png
e2e-06-loan-active.png
e2e-07-return-penalty.png
e2e-08-archive-verified.png
e2e-09-receipt-preview.pdf
e2e-10-voting-result.png
e2e-11-report-export.xlsx
e2e-12-activity-log.png
```

Jangan menyimpan password di screenshot, browser autofill, log CI, export, atau nama file bukti.

---

## 14. Route ringkas per role

### Public dan autentikasi

```text
GET  /                         welcome
GET  /login                    login form
POST /login                    submit login
GET  /register                 registration form
POST /register                 submit registration
GET  /forgot-password          reset request
POST /forgot-password          send reset link
GET  /reset-password/{token}   reset form
POST /reset-password           save new password
POST /logout                   logout
GET  /profile                  profile form
PATCH /profile                 update profile
DELETE /profile               delete own account
```

### Admin

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

### Petugas

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

### Mahasiswa

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

### Dosen

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

---

## 15. Catatan operasional dan referensi

1. Password database disimpan dalam bentuk hash; hanya password seeder dan pola generator import yang dapat ditulis plaintext.
2. Password akun runtime dapat berubah melalui Admin; jika berubah, tabel ini perlu diperbarui secara internal.
3. `petugas@test.com` adalah akun aktif runtime; `petugas@perpustakaan.com` adalah alamat yang didefinisikan seeder.
4. `ryankrick06@gmail.com` memerlukan reset password melalui Admin.
5. Token Fonnte, Telegram, password SMTP, APP_KEY, credential database, Cloudflare, dan deployment harus berada di secret manager/`.env`, bukan dokumen E2E.
6. Data uji harus diberi label, dicatat ID-nya, dan dibersihkan hanya bila tidak terlibat transaksi aktif.
7. Endpoint print laporan saat ini perlu diverifikasi sebagai print view HTML; requirement PDF native mungkin memerlukan perubahan backend.

Referensi kode/dokumen:

- `routes/web.php` dan `routes/auth.php` — route dan middleware.
- `database/seeders/AdminSeeder.php` dan `UserSeeder.php` — akun/data awal.
- `app/Http/Controllers/Auth/RegisteredUserController.php` — registrasi.
- `app/Http/Controllers/Admin/UserController.php` — CRUD/import user.
- `app/Http/Controllers/Petugas/MemberController.php` — anggota/approval/KTM.
- `app/Http/Controllers/Petugas/BookController.php` — buku/import.
- `app/Http/Controllers/Petugas/ArsipController.php` — arsip/verifikasi/surat/import.
- `app/Http/Controllers/Petugas/LoanController.php` — peminjaman.
- `app/Http/Controllers/Petugas/ReturnController.php` — pengembalian/inspeksi.
- `app/Http/Controllers/Petugas/PenaltyController.php` — denda/penyelesaian.
- `app/Http/Controllers/BookingController.php` dan `Petugas/BookingController.php` — booking.
- `app/Http/Controllers/AntrianController.php` dan `Petugas/AntrianController.php` — antrian.
- `app/Http/Controllers/ArsipKatalogController.php` — katalog/preview/stream/read log.
- `app/Console/Commands/SendLoanReminderNotifications.php` — reminder.
- `dokumentasi/user_manual_dan_uat.md` — manual dan UAT.
- `dokumentasi/blackbox_testing.md` — black-box testing.
- `dokumentasi/implementation_plan_import_users.md` — import user.
- `dokumentasi/implementation_plan_import_buku.md` — import buku.
- `dokumentasi/implementation_plan_import_arsip.md` — import arsip.

**Akhir dokumen.**
