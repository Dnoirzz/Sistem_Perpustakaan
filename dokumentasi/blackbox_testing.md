# Dokumen Black Box Testing
# Sistem Informasi Perpustakaan PSDKU POLNEP

**Nama Sistem** : Sistem Informasi Perpustakaan PSDKU POLNEP  
**Metode Pengujian** : Black Box Testing (Equivalence Partitioning & Boundary Value Analysis)  
**Tanggal Pengujian** : ___________________  
**Penguji** : ___________________

---

## Keterangan Status

| Simbol | Keterangan |
|---|---|
| ✅ | Berhasil / Sesuai Harapan |
| ❌ | Gagal / Tidak Sesuai |
| ⬜ | Belum Diuji |

---

## 1. Pengujian Autentikasi & Registrasi (Auth & Registration)

### 1.1 Login

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-AUTH-01 | Login dengan kredensial valid (Admin) | Email & password Admin yang benar | Diarahkan ke dashboard Admin | ✅ |
| TC-AUTH-02 | Login dengan kredensial valid (Petugas) | Email & password Petugas yang benar | Diarahkan ke dashboard Petugas | ✅ |
| TC-AUTH-03 | Login dengan kredensial valid (Dosen) | Email & password Dosen yang benar | Diarahkan ke dashboard Dosen | ✅ |
| TC-AUTH-04 | Login dengan kredensial valid (Mahasiswa) | Email & password Mahasiswa yang benar | Diarahkan ke dashboard Mahasiswa | ✅ |
| TC-AUTH-05 | Login dengan password salah | Email valid + password salah | Muncul pesan error "kredensial tidak cocok" | ✅ |
| TC-AUTH-06 | Login dengan email tidak terdaftar | Email tidak ada + password sembarang | Muncul pesan error | ✅ |
| TC-AUTH-07 | Login dengan field kosong | Semua field dibiarkan kosong | Muncul validasi "field wajib diisi" | ✅ |
| TC-AUTH-08 | Login dengan format email tidak valid | `bukanemail` di field email | Muncul validasi format email | ✅ |

### 1.2 Logout

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-AUTH-09 | Logout dari sesi aktif | Klik tombol Logout | Session dihapus, diarahkan ke halaman login | ✅ |
| TC-AUTH-10 | Akses halaman dashboard setelah logout | URL dashboard diakses langsung | Diarahkan ke halaman login | ✅ |

### 1.3 Kontrol Akses Role (Authorization)

| ID | Skenario Uji | Aktor | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-AUTH-11 | Mahasiswa akses URL admin | Login Mahasiswa, akses `/admin/dashboard` | Ditolak (403 Forbidden) | ✅ |
| TC-AUTH-12 | Dosen akses URL petugas | Login Dosen, akses `/petugas/loans` | Ditolak (403 Forbidden) | ✅ |
| TC-AUTH-13 | Petugas akses URL admin | Login Petugas, akses `/admin/users` | Ditolak (403 Forbidden) | ✅ |

### 1.4 Registrasi Mandiri & Verifikasi Identitas (KTM / Kartu Pegawai)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-REG-01 | Registrasi Mahasiswa dengan data valid | Nama, email, NIM, prodi, semester, no. HP, foto KTM valid | Akun terbuat dengan status `pending`, notifikasi terkirim ke Petugas/Admin, diarahkan ke Login | ⬜ |
| TC-REG-02 | Registrasi Dosen dengan data valid | Nama, email, NIP, prodi, no. HP, foto kartu identitas valid | Akun terbuat dengan status `pending`, notifikasi terkirim ke Petugas/Admin | ⬜ |
| TC-REG-03 | Registrasi dengan NIM/NIP duplikat | NIM/NIP yang sudah terdaftar di sistem | Muncul error validasi "NIM/NIP sudah terdaftar" | ⬜ |
| TC-REG-04 | Registrasi tanpa upload foto KTM/Kartu Pegawai | Field `foto_ktm` dikosongkan | Muncul validasi "foto KTM wajib diunggah" | ⬜ |
| TC-REG-05 | Registrasi dengan format file KTM bukan gambar | Upload file `.pdf` atau `.txt` | Muncul validasi "file harus berupa gambar (jpg, png)" | ⬜ |
| TC-REG-06 | Registrasi dengan ukuran file KTM > 2MB | Upload gambar ukuran > 2MB | Muncul validasi ukuran file maksimal 2MB | ⬜ |
| TC-REG-07 | Login akun anggota berstatus `pending` (belum diverifikasi) | Email & password anggota yang baru mendaftar | Login berhasil namun muncul notifikasi status verifikasi belum disetujui | ⬜ |
| TC-REG-08 | Petugas verifikasi (Approve) anggota baru | Klik "Setujui" pada daftar anggota pending | Status anggota berubah `aktif`, anggota dapat menggunakan seluruh layanan | ⬜ |
| TC-REG-09 | Petugas tolak (Reject) pendaftaran anggota | Klik "Tolak" pada pendaftaran anggota pending | Status pendaftaran ditolak dengan alasan penolakan | ⬜ |
| TC-REG-10 | Petugas lihat foto KTM pendaftar | Klik ikon/tombol "Lihat KTM" pada tabel anggota | Modal/tab terbuka menampilkan foto KTM pendaftar | ⬜ |

---

## 2. Pengujian Manajemen Pengguna & Akademik (Admin)

### 2.1 Tambah Pengguna Manual

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-USER-01 | Tambah mahasiswa baru dengan data valid | Nama, email, NIM, prodi, no. HP valid | Pengguna tersimpan, muncul di daftar | ⬜ |
| TC-USER-02 | Tambah dosen baru dengan data valid | Nama, email, NIP, prodi, no. HP valid | Pengguna tersimpan, muncul di daftar | ⬜ |
| TC-USER-03 | Tambah pengguna dengan email duplikat | Email yang sudah ada di database | Muncul error "email sudah digunakan" | ⬜ |
| TC-USER-04 | Tambah pengguna dengan field wajib kosong | Nama atau email dikosongkan | Muncul pesan validasi | ⬜ |
| TC-USER-05 | Tambah pengguna dengan NIM duplikat | NIM yang sudah terdaftar | Muncul error duplikasi | ⬜ |

### 2.2 Edit & Hapus Pengguna

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-USER-06 | Edit data pengguna yang ada | Ubah nama atau no. HP | Data berhasil diperbarui | ⬜ |
| TC-USER-07 | Hapus pengguna | Klik hapus pada salah satu pengguna | Pengguna terhapus dari daftar | ⬜ |
| TC-USER-08 | Reset password pengguna | Klik reset password | Password pengguna berhasil direset | ⬜ |

### 2.3 Import Pengguna via Excel

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-USER-09 | Import dengan file template yang valid | File `.xlsx` sesuai template | Semua pengguna berhasil diimpor | ⬜ |
| TC-USER-10 | Import dengan file format salah | File `.pdf` atau `.txt` | Muncul error format file tidak valid | ⬜ |
| TC-USER-11 | Import dengan data duplikat di file | NIM/email yang sudah ada | Baris duplikat diskip/error, sisanya berhasil | ⬜ |
| TC-USER-12 | Download template import | Klik tombol "Download Template" | File template `.xlsx` berhasil diunduh | ⬜ |

### 2.4 Kelola Program Studi & Jurusan

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-PRODI-01 | Tambah Program Studi baru | Nama prodi & jenjang valid | Prodi tersimpan di sistem | ⬜ |
| TC-PRODI-02 | Edit nama Program Studi | Ubah nama prodi | Nama prodi berhasil diperbarui | ⬜ |
| TC-PRODI-03 | Tambah Jurusan baru | Nama jurusan valid | Jurusan tersimpan di sistem | ⬜ |
| TC-PRODI-04 | Hapus Prodi yang tidak digunakan | Klik hapus prodi | Prodi berhasil terhapus | ⬜ |

---

## 3. Pengujian Manajemen Buku & Koleksi (Petugas)

### 3.1 Tambah Buku

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-BOOK-01 | Tambah buku baru dengan data lengkap | Judul, penulis, kategori, stok, cover | Buku tersimpan dan muncul di daftar | ⬜ |
| TC-BOOK-02 | Tambah buku dengan field wajib kosong | Judul dikosongkan | Muncul pesan validasi | ⬜ |
| TC-BOOK-03 | Tambah buku dengan stok negatif | Stok = -1 | Muncul validasi stok tidak boleh negatif | ⬜ |
| TC-BOOK-04 | Tambah buku dengan cover gambar valid | File `.jpg`/`.png` ukuran normal | Cover tersimpan dan ditampilkan | ⬜ |
| TC-BOOK-05 | Tambah buku dengan file cover bukan gambar | File `.pdf` di field cover | Muncul error format tidak valid | ⬜ |

### 3.2 Edit & Hapus Buku

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-BOOK-06 | Edit data buku yang ada | Ubah judul atau stok | Data berhasil diperbarui | ⬜ |
| TC-BOOK-07 | Hapus buku yang tidak sedang dipinjam | Klik hapus | Buku terhapus dari daftar | ⬜ |

### 3.3 Import Buku via Excel

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-BOOK-08 | Import buku dengan file template valid | File `.xlsx` sesuai template | Semua buku berhasil diimpor | ⬜ |
| TC-BOOK-09 | Import dengan file kosong (header saja) | File template tanpa data | Muncul notifikasi tidak ada data yang diimpor | ⬜ |
| TC-BOOK-10 | Download template import buku | Klik "Download Template" | File template `.xlsx` terunduh | ⬜ |

### 3.4 Manajemen Kategori

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-CAT-01 | Tambah kategori baru | Nama kategori valid | Kategori tersimpan | ⬜ |
| TC-CAT-02 | Edit nama kategori | Ubah nama kategori | Nama berhasil diperbarui | ⬜ |
| TC-CAT-03 | Hapus kategori yang masih digunakan buku | Klik hapus | Ditolak / muncul peringatan | ⬜ |

---

## 4. Pengujian Peminjaman Buku (Petugas)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-LOAN-01 | Catat peminjaman baru dengan data valid | Anggota valid, koleksi buku/arsip tersedia | Peminjaman tersimpan, stok berkurang 1 | ⬜ |
| TC-LOAN-02 | Catat peminjaman buku stok habis | Pilih buku dengan stok = 0 | Muncul error "stok habis" | ⬜ |
| TC-LOAN-03 | Catat peminjaman dengan batas waktu sebelum tanggal pinjam | `bts_waktu` < `tgl_pinjam` | Muncul validasi tanggal tidak valid | ⬜ |
| TC-LOAN-04 | Catat peminjaman anggota yang sudah meminjam koleksi sama | Anggota + koleksi sama dengan pinjaman aktif | Muncul error duplikasi peminjaman aktif | ⬜ |
| TC-LOAN-05 | Notifikasi WA terkirim setelah peminjaman dicatat | Peminjaman berhasil + WA aktif | Log menunjukkan WA terkirim | ⬜ |
| TC-LOAN-06 | Sinkronisasi status "terlambat" otomatis | Buka halaman peminjaman | Peminjaman melewati batas waktu berubah jadi "terlambat" | ⬜ |
| TC-LOAN-07 | Filter peminjaman berdasarkan status | Pilih filter "terlambat" | Hanya tampil data terlambat | ⬜ |
| TC-LOAN-08 | Pencarian peminjaman (Buku & Laporan PKL/TA) | Ketik nama anggota, NIM, NIP, atau judul Laporan PKL | Data peminjaman ditemukan secara presisi | ⬜ |

---

## 5. Pengujian Pengembalian Buku & Checklist (Petugas)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-RET-01 | Proses pengembalian buku kondisi baik | Opsi "Ada (Inspeksi Fisik)", semua checklist centang "Baik" | Status berubah "dikembalikan", stok bertambah 1 | ⬜ |
| TC-RET-02 | Proses pengembalian buku terlambat | Buku terlambat, kondisi baik | Denda keterlambatan otomatis dicatat sesuai aturan | ⬜ |
| TC-RET-03 | Proses pengembalian buku rusak | Opsi "Ada", 1/lebih checklist di-uncheck | Wajib isi catatan & sanksi fisik, denda terbuat | ⬜ |
| TC-RET-04 | Proses pengembalian mode **"Buku Hilang"** (Bayar Tunai) | Pilih opsi "Buku Hilang", metode penyelesaian "Uang Tunai" | Checklist fisik tersembunyi, sanksi `kehilangan` terbuat, **stok TIDAK bertambah** | ⬜ |
| TC-RET-05 | Proses pengembalian mode **"Buku Hilang"** (Ganti Buku Fisik) | Pilih opsi "Buku Hilang", metode penyelesaian "Ganti Buku" | Sanksi `kehilangan` terbuat, **stok bertambah 1** | ⬜ |
| TC-RET-06 | Placeholder otomatis pada Keterangan Sanksi | Pilih jenis sanksi pada modal pengembalian | Placeholder textarea otomatis menampilkan deskripsi aturan sanksi aktif | ⬜ |
| TC-RET-07 | Notifikasi WA antrian tersedia setelah return | Ada antrian menunggu pada buku tersebut | WA dikirim ke anggota berikutnya di antrian | ⬜ |
| TC-RET-08 | Proses pengembalian buku yang sudah dikembalikan | Buka pinjaman berstatus "dikembalikan" | Muncul error "sudah dikembalikan sebelumnya" | ⬜ |

---

## 6. Pengujian Denda & Sanksi (Petugas)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-FINE-01 | Lihat daftar denda yang belum dibayar | Buka halaman Denda | Semua denda "belum_dibayar" tampil dengan badge terformat rapi | ⬜ |
| TC-FINE-02 | Penampilan nama koleksi (Buku Umum & Laporan PKL/TA) | Buka halaman Denda pada peminjaman Laporan PKL/TA | Judul Laporan PKL/TA tampil dengan benar (bukan `-`) beserta badge kategorinya | ⬜ |
| TC-FINE-03 | Pencarian denda Laporan PKL / Tugas Akhir | Ketik judul Laporan PKL/TA di pencarian denda | Denda terkait Laporan PKL/TA berhasil ditemukan | ⬜ |
| TC-FINE-04 | Modal Detail Keterangan Denda | Klik tombol Info (i) pada baris denda | Modal menampilkan detail anggota, judul koleksi, jenis, penyelesaian, dan rincian aturan | ⬜ |
| TC-FINE-05 | Tandai denda sebagai lunas | Klik "Tandai Lunas" | Status denda berubah menjadi "lunas", notifikasi terkirim | ⬜ |
| TC-FINE-06 | Tambah denda manual oleh petugas | Isi form denda manual | Denda tersimpan | ⬜ |
| TC-FINE-07 | Aturan denda keterlambatan per hari | Atur Rp 1.000/hari, kembalikan 5 hari terlambat | Denda otomatis = Rp 5.000 | ⬜ |
| TC-FINE-08 | Aturan denda keterlambatan flat | Atur Rp 10.000 flat, kembalikan kapanpun terlambat | Denda = Rp 10.000 terlepas dari jumlah hari | ⬜ |

---

## 7. Pengujian Pengaturan Return (Petugas)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-SET-RET-01 | Tambah item checklist pengembalian baru | Nama item & deskripsi valid | Item checklist tersimpan & tampil di modal pengembalian | ⬜ |
| TC-SET-RET-02 | Edit item checklist pengembalian | Ubah nama item atau sort order | Item checklist berhasil diperbarui | ⬜ |
| TC-SET-RET-03 | Toggle aktif/nonaktif item checklist | Matikan toggle `is_active` | Item checklist non-aktif tidak muncul di modal pengembalian | ⬜ |
| TC-SET-RET-04 | Edit deskripsi & metode default Aturan Sanksi | Ubah deskripsi sanksi `kehilangan` | Deskripsi baru tersimpan & menjadi placeholder pada modal pengembalian | ⬜ |

---

## 8. Pengujian Booking & Antrian (Petugas & Anggota)

### 8.1 Booking (Anggota)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-BKG-01 | Mahasiswa buat booking buku tersedia | Pilih buku, ajukan booking | Booking tersimpan dengan status "menunggu" | ⬜ |
| TC-BKG-02 | Mahasiswa batalkan booking | Klik tombol batalkan | Status booking berubah jadi "dibatalkan" | ⬜ |

### 8.2 Kelola Booking (Petugas)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-BKG-03 | Petugas setujui booking | Klik "Setujui" pada booking | Status booking berubah "disetujui" | ⬜ |
| TC-BKG-04 | Petugas tolak booking | Klik "Tolak" pada booking | Status booking berubah "ditolak" | ⬜ |
| TC-BKG-05 | Petugas realisasi booking jadi peminjaman | Klik "Realisasi" | Booking jadi peminjaman aktif | ⬜ |

### 8.3 Antrian

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-ANT-01 | Mahasiswa daftar antrian buku habis stok | Klik "Daftar Antrian" | Masuk antrian dengan nomor urut | ⬜ |
| TC-ANT-02 | Notifikasi WA saat antrian tersedia | Buku dikembalikan, ada antrian | WA terkirim ke anggota di antrian terdepan | ⬜ |

---

## 9. Pengujian Arsip Digital & Katalog Publik (Petugas, Mahasiswa & Dosen)

### 9.1 Upload Arsip (Mahasiswa)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-ARSIP-01 | Upload laporan PKL dengan file PDF valid | File `.pdf`, judul, pembimbing valid | Arsip tersimpan dengan status "menunggu" | ⬜ |
| TC-ARSIP-02 | Upload dengan file bukan PDF | File `.docx` atau `.jpg` | Muncul error format tidak valid | ⬜ |
| TC-ARSIP-03 | Upload arsip dengan field wajib kosong | Judul dikosongkan | Muncul pesan validasi | ⬜ |
| TC-ARSIP-04 | Mahasiswa edit arsip yang belum diverifikasi | Ubah judul atau file | Data berhasil diperbarui | ⬜ |
| TC-ARSIP-05 | Mahasiswa hapus arsip milik sendiri | Klik hapus | Arsip terhapus | ⬜ |

### 9.2 Verifikasi Arsip (Petugas)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-ARSIP-06 | Petugas verifikasi arsip | Klik "Verifikasi" | Status arsip berubah "terverifikasi" | ⬜ |
| TC-ARSIP-07 | Petugas tolak arsip | Klik "Tolak" | Status arsip berubah "ditolak" | ⬜ |
| TC-ARSIP-08 | Petugas konfirmasi penerimaan & generate surat | Klik "Konfirmasi Terima" | Surat Tanda Terima PDF berhasil digenerate | ⬜ |
| TC-ARSIP-09 | Download file arsip | Klik download pada arsip | File PDF berhasil diunduh | ⬜ |
| TC-ARSIP-10 | Import arsip via Excel (batch) | File `.xlsx` template arsip | Semua arsip berhasil diimpor | ⬜ |

### 9.3 Katalog Publik, Stream PDF & Log Pembacaan

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-ARSIP-11 | Lihat katalog arsip yang sudah terverifikasi | Buka halaman katalog arsip | Hanya arsip terverifikasi yang tampil | ⬜ |
| TC-ARSIP-12 | Stream PDF arsip di browser | Klik tombol "Baca Full / Stream" | PDF terbuka dalam viewer terproteksi (`/stream/{slug}.pdf`) | ⬜ |
| TC-ARSIP-13 | Pencatatan Log Pembacaan saat tab ditutup | Buka dokumen lalu tutup tab browser | Event `closeReadLog` mencatat durasi & aktivitas pembacaan di server | ⬜ |

---

## 10. Pengujian Usulan Buku (Rekomendasi)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-REC-01 | Mahasiswa/dosen buat usulan buku | Judul, alasan valid | Usulan tersimpan | ⬜ |
| TC-REC-02 | Usulan dengan field wajib kosong | Field judul kosong | Muncul validasi | ⬜ |
| TC-REC-03 | Petugas verifikasi usulan | Klik "Verifikasi" | Status berubah "diverifikasi" | ⬜ |
| TC-REC-04 | Petugas hapus usulan | Klik hapus | Usulan terhapus | ⬜ |

---

## 11. Pengujian Voting Buku (Petugas, Dosen & Mahasiswa)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-VOTE-01 | Petugas buat sesi voting baru | Judul, tanggal mulai & akhir | Sesi voting tersimpan | ⬜ |
| TC-VOTE-02 | Petugas tambah item buku ke voting | Pilih dari usulan / input manual | Buku berhasil ditambahkan ke sesi | ⬜ |
| TC-VOTE-03 | Mahasiswa/dosen vote buku | Klik "Vote" pada salah satu buku | Vote tercatat, jumlah suara bertambah | ⬜ |
| TC-VOTE-04 | Anggota vote dua kali pada sesi yang sama | Klik "Vote" lagi setelah pernah vote | Ditolak / tidak double vote | ⬜ |
| TC-VOTE-05 | Petugas hapus item dari voting | Klik hapus item | Item dihapus dari sesi | ⬜ |

---

## 12. Pengujian Notifikasi Multichannel (WA, Telegram, Email & Lonceng)

### 12.1 Notifikasi WhatsApp (Fonnte)

| ID | Skenario Uji | Kondisi | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-NOTIF-01 | WA terkirim saat peminjaman baru dicatat | Fitur WA aktif, no. HP valid, Fonnte terhubung | Pesan konfirmasi pinjam terkirim via WA | ⬜ |
| TC-NOTIF-02 | WA H-1 jatuh tempo terkirim via scheduler | Ada peminjaman jatuh tempo besok, scheduler jalan | Pesan pengingat H-1 terkirim via WA | ⬜ |
| TC-NOTIF-03 | WA status terlambat terkirim via scheduler | Ada peminjaman berstatus "terlambat", scheduler jalan | Pesan keterlambatan terkirim via WA | ⬜ |
| TC-NOTIF-04 | WA di-skip saat fitur dinonaktifkan | `wa_notification_enabled = false` | Tidak ada WA yang dikirim, log muncul "di-skip" | ⬜ |

### 12.2 Notifikasi Bot Telegram

| ID | Skenario Uji | Kondisi | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-NOTIF-05 | Telegram terkirim saat transaksi/pendaftaran | Fitur Telegram aktif, Chat ID terhubung | Pesan notifikasi terkirim via Bot Telegram | ⬜ |
| TC-NOTIF-06 | Test kirim Telegram dari halaman pengaturan | Isi Chat ID & pesan, klik "Test Kirim" | Pesan uji coba berhasil masuk di aplikasi Telegram | ⬜ |
| TC-NOTIF-07 | Telegram di-skip saat fitur dinonaktifkan | `telegram_notification_enabled = false` | Tidak ada pesan Telegram dikirim | ⬜ |

### 12.3 Notifikasi Email SMTP

| ID | Skenario Uji | Kondisi | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-NOTIF-08 | Email konfirmasi/pengingat terkirim | Mailer SMTP terkonfigurasi | Email otomatis masuk ke Inbox user | ⬜ |
| TC-NOTIF-09 | Test kirim email dari halaman pengaturan | Isi email tujuan, subject, body, klik "Test Kirim" | Email uji coba berhasil diterima di inbox | ⬜ |

### 12.4 Notifikasi In-App Lonceng (Bell Feed)

| ID | Skenario Uji | Kondisi | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-NOTIF-10 | Real-time counter unread pada ikon lonceng | Ada notifikasi baru masuk | Counter merah di lonceng bertambah secara real-time (`/notifications/feed`) | ⬜ |
| TC-NOTIF-11 | Klik item notifikasi lonceng | Klik salah satu notifikasi di feed | Notifikasi ditandai dibaca (`is_read = true`) dan diarahkan ke halaman tujuan | ⬜ |
| TC-NOTIF-12 | Tandai semua notifikasi dibaca | Klik "Tandai Semua Dibaca" | Counter unread menjadi 0 dan seluruh notifikasi bertanda dibaca | ⬜ |
| TC-NOTIF-13 | Hapus notifikasi lonceng | Klik hapus pada salah satu notifikasi | Notifikasi terhapus dari daftar | ⬜ |

---

## 13. Pengujian Laporan & Ekspor Data (Petugas)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-RPT-01 | Cetak laporan sirkulasi peminjaman (PDF) | Filter tanggal valid | File PDF laporan sirkulasi terunduh/terbuka | ⬜ |
| TC-RPT-02 | Ekspor laporan sirkulasi (Excel) | Filter tanggal valid | File `.xlsx` laporan sirkulasi terunduh | ⬜ |
| TC-RPT-03 | Cetak laporan koleksi buku (PDF) | - | File PDF koleksi buku terunduh | ⬜ |
| TC-RPT-04 | Ekspor laporan koleksi buku (Excel) | - | File `.xlsx` koleksi buku terunduh | ⬜ |
| TC-RPT-05 | Cetak laporan arsip digital (PDF) | - | File PDF laporan arsip terunduh | ⬜ |
| TC-RPT-06 | Ekspor laporan arsip digital (Excel) | - | File `.xlsx` laporan arsip terunduh | ⬜ |

---

## 14. Pengujian Pengaturan Sistem (Admin)

### 14.1 Pengaturan WhatsApp

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-SET-01 | Simpan token Fonnte valid | Token valid diinput | Pengaturan tersimpan, notifikasi sukses | ⬜ |
| TC-SET-02 | Toggle aktif/nonaktif notifikasi WA | Ubah toggle | Pengaturan tersimpan | ⬜ |

### 14.2 Pengaturan Bot Telegram

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-SET-03 | Simpan Token Bot & Username Telegram | Token valid & username bot diinput | Pengaturan tersimpan | ⬜ |
| TC-SET-04 | Toggle aktif/nonaktif notifikasi Telegram | Ubah toggle | Pengaturan tersimpan | ⬜ |

### 14.3 Pengaturan Email SMTP

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-SET-05 | Simpan pengaturan SMTP valid | Host, port, kredensial valid | Pengaturan tersimpan | ⬜ |
| TC-SET-06 | Simpan pengaturan SMTP dengan format email salah | `from_address` bukan format email | Muncul validasi format email | ⬜ |

### 14.4 Pengaturan Surat Tanda Terima & Kop Surat

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-SET-07 | Simpan pengaturan template surat | Ubah nama penerima, NIP, kop surat | Pengaturan tersimpan | ⬜ |
| TC-SET-08 | Preview Surat Tanda Terima real-time | Klik "Preview" | PDF preview surat terbuka di browser dengan inputan saat ini | ⬜ |
| TC-SET-09 | Upload logo kop surat | Upload file `.png` valid | Logo tersimpan & muncul di preview kop surat | ⬜ |

---

## 15. Pengujian Log Aktivitas (Admin)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-LOG-01 | Lihat log aktivitas setelah peminjaman dicatat | Catat peminjaman, buka halaman log | Aktivitas peminjaman tercatat di log | ⬜ |
| TC-LOG-02 | Lihat log aktivitas setelah pengembalian diproses | Proses pengembalian, buka halaman log | Aktivitas pengembalian tercatat di log | ⬜ |

---

## 16. Pengujian Profil Pengguna (Semua Role)

| ID | Skenario Uji | Data Masukan | Output yang Diharapkan | Status |
|---|---|---|---|---|
| TC-PROF-01 | Edit nama & informasi profil | Ubah nama | Data profil berhasil diperbarui | ⬜ |
| TC-PROF-02 | Ubah password dengan data valid | Password lama benar + password baru valid | Password berhasil diubah | ⬜ |
| TC-PROF-03 | Ubah password dengan password lama salah | Password lama salah | Muncul error validasi | ⬜ |
| TC-PROF-04 | Hapus akun sendiri | Klik "Hapus Akun" + konfirmasi | Akun dihapus, session berakhir | ⬜ |

---

## Ringkasan Hasil Pengujian

| Modul | Total TC | Berhasil (✅) | Gagal (❌) | Belum Diuji (⬜) |
|---|---|---|---|---|
| Autentikasi & Registrasi | 23 | 13 | 0 | 10 |
| Manajemen Pengguna & Akademik | 16 | 0 | 0 | 16 |
| Manajemen Buku & Koleksi | 12 | 0 | 0 | 12 |
| Peminjaman Buku | 8 | 0 | 0 | 8 |
| Pengembalian Buku & Checklist | 8 | 0 | 0 | 8 |
| Denda & Sanksi | 8 | 0 | 0 | 8 |
| Pengaturan Return | 4 | 0 | 0 | 4 |
| Booking & Antrian | 7 | 0 | 0 | 7 |
| Arsip Digital & Katalog Publik | 13 | 0 | 0 | 13 |
| Usulan Buku | 4 | 0 | 0 | 4 |
| Voting Buku | 5 | 0 | 0 | 5 |
| Notifikasi Multichannel | 13 | 0 | 0 | 13 |
| Laporan & Ekspor | 6 | 0 | 0 | 6 |
| Pengaturan Sistem | 9 | 0 | 0 | 9 |
| Log Aktivitas | 2 | 0 | 0 | 2 |
| Profil Pengguna | 4 | 0 | 0 | 4 |
| **TOTAL** | **142** | **13** | **0** | **129** |

---

## Catatan Penguji

> _Isi dengan temuan, bug, atau catatan tambahan selama pengujian berlangsung._

| No | ID TC | Temuan / Catatan | Tindak Lanjut |
|---|---|---|---|
| 1 | | | |
| 2 | | | |
| 3 | | | |

---

*Dokumen ini diperbarui untuk pengujian ulang fitur Sirkulasi, Pengembalian Buku Hilang, Denda Arsip Digital, Pengaturan Return, Registrasi & Verifikasi Anggota, Notifikasi Multichannel, Stream PDF & Reading Log, serta Manajemen Akademik pada Tugas Akhir Semester 6 Program Studi Teknologi Informasi POLNEP.*
