# Dokumen Panduan Pengguna (User Manual) & User Acceptance Testing (UAT)
# Sistem Informasi Perpustakaan PSDKU POLNEP

**Nama Sistem** : Sistem Informasi Perpustakaan PSDKU POLNEP  
**Versi Sistem** : 2.0 (Terintegrasi Sirkulasi, Repository Digital & Notifikasi Multichannel)  
**Program Studi** : Teknologi Informasi - PSDKU POLNEP Kabupaten Sukamara  
**Tanggal Dokumen** : 2026  

---

## DAFTAR ISI

1. **BAGIAN I: PANDUAN PENGGUNA (USER MANUAL)**
   - 1.1 Panduan Role Mahasiswa
   - 1.2 Panduan Role Dosen
   - 1.3 Panduan Role Petugas Perpustakaan
   - 1.4 Panduan Role Admin
2. **BAGIAN II: LEMBAR SKENARIO TUGAS UAT (TASK-BASED SCENARIOS)**
   - 2.1 Skenario Tugas UAT - Mahasiswa
   - 2.2 Skenario Tugas UAT - Dosen
   - 2.3 Skenario Tugas UAT - Petugas Perpustakaan
   - 2.4 Skenario Tugas UAT - Admin
3. **BAGIAN III: KUESIONER KEPUASAN PENGGUNA (SKALA LIKERT 1–5)**
4. **BAGIAN IV: METODE PERHITUNGAN SKOR & KRITERIA KELAYAKAN**
5. **BAGIAN V: TEMPLATE BERITA ACARA PENGESAHAN UAT**

---

# BAGIAN I: PANDUAN PENGGUNA (USER MANUAL)

---

## 1.1 Panduan Role Mahasiswa

### A. Registrasi Akun Mandiri & Upload Foto KTM
1. Buka halaman utama aplikasi $\rightarrow$ Klik tombol **"Daftar / Registrasi"**.
2. Pilih peran sebagai **Mahasiswa**.
3. Isi data diri meliputi **Nama Lengkap**, **Email**, **NIM**, **Program Studi**, **Semester**, **Nomor WhatsApp/HP**, dan **Password**.
4. Unggah foto Kartu Tanda Mahasiswa (KTM) yang jelas dalam format `.jpg` / `.png` (maksimal 2MB).
5. Klik **"Daftar Akun"**. Akun Anda akan berstatus *Pending* dan menunggu verifikasi oleh Petugas Perpustakaan.

### B. Login & Navigasi Utama
1. Masuk ke halaman Login $\rightarrow$ Masukkan Email dan Password Anda.
2. Setelah login, Anda akan diarahkan ke **Dashboard Mahasiswa** yang menampilkan ringkasan buku dipinjam, riwayat denda, dan pemberitahuan penting.

### C. Pencarian Buku & Katalog Arsip Digital
1. Akses menu **"Katalog Buku"** untuk mencari buku umum berdasarkan Judul, Penulis, atau Kategori.
2. Akses menu **"Katalog Arsip Digital"** untuk membaca Laporan PKL, Proposal Tugas Akhir, atau Laporan Skripsi/TA.
3. Klik tombol **"Baca Full / Stream"** untuk membuka viewer PDF yang terproteksi. *Catatan: Pembacaan Anda akan tercatat secara otomatis di sistem.*

### D. Pengajuan Booking & Antrian Buku
1. **Booking Buku**: Jika stok buku tersedia (stok > 0), klik tombol **"Booking Buku"** untuk mengamankan buku sebelum diambil di perpustakaan.
2. **Daftar Antrian**: Jika stok buku habis (stok = 0), klik **"Daftar Antrian"**. Anda akan mendapatkan nomor antrian dan menerima notifikasi otomatis via WhatsApp/Telegram saat buku telah dikembalikan oleh peminjam sebelumnya.

### E. Mengelola Rak Pinjam (Peminjaman Aktif, Denda Saya & Riwayat)
1. Buka menu **"Rak Pinjam"** $\rightarrow$ **Pinjaman** untuk melihat tanggal pinjam dan batas waktu pengembalian buku Anda.
2. Buka sub-menu **"Denda Saya"** untuk melihat rincian tagihan denda belum dibayar (nominal, jenis sanksi, dan petunjuk penyelesaian) serta riwayat denda yang telah lunas.
3. Buka tab **Riwayat** untuk melihat riwayat buku dan dokumen digital yang pernah Anda akses.

### F. Upload Repository Mandiri (PKL, Proposal TA, Laporan TA)
1. Akses menu **"Repository Saya"** $\rightarrow$ Klik **"Unggah Karya Ilmiah"**.
2. Pilih jenis karya ilmiah (**Laporan PKL**, **Proposal TA**, atau **Laporan Tugas Akhir**).
3. Isi formulir judul, tempat PKL/dosen pembimbing, penguji, tahun, dan unggah file PDF karya ilmiah Anda.
4. Klik **"Simpan"**. Karya ilmiah Anda akan diverifikasi oleh Petugas Perpustakaan sebelum diterbitkan dan dicetak Surat Tanda Terimanya.

### G. Usulan Buku Baru & Voting Buku
1. **Usulan Buku**: Akses menu **"Usulan Buku"** $\rightarrow$ Isi judul buku dan alasan pengusulan jika buku yang Anda cari belum ada di perpustakaan.
2. **Voting Buku**: Akses menu **"Voting Buku"** $\rightarrow$ Pilih dan dukung buku favorit Anda pada sesi voting aktif agar dibeli oleh pihak perpustakaan.

---

## 1.2 Panduan Role Dosen

### A. Registrasi & Login Dosen
1. Registrasi akun baru dengan memilih peran **Dosen**, menginput **NIP**, **Program Studi**, **No. HP/WhatsApp**, dan mengunggah foto **Kartu Pegawai/Identitas Dosen**.
2. Setelah akun disetujui petugas, lakukan Login menggunakan Email dan Password.

### B. Pencarian & Booking Koleksi
1. Cari buku atau laporan tugas akhir mahasiswa di **Katalog Buku** dan **Katalog Arsip Digital**.
2. Ajukan **Booking** atau **Antrian** koleksi untuk keperluan riset dan mengajar.

### C. Usulan Buku & Voting Dosen
1. Ajukan referensi buku baru yang dibutuhkan untuk mata kuliah melalui menu **"Usulan Buku"**.
2. Berikan suara (*vote*) pada sesi voting pengadaan buku perpustakaan.

---

## 1.3 Panduan Role Petugas Perpustakaan

### A. Verifikasi Pendaftaran Anggota Baru
1. Buka menu **"Kelola Anggota"** $\rightarrow$ Tab **Menunggu Verifikasi**.
2. Klik ikon **"Lihat KTM"** untuk memeriksa keabsahan foto identitas yang diunggah pendaftar.
3. Klik tombol **"Setujui"** (Approve) untuk mengaktifkan akun anggota atau **"Tolak"** (Reject) jika data tidak sesuai.

### B. Transaksi Peminjaman Baru
1. Buka menu **"Sirkulasi"** $\rightarrow$ **"Peminjaman Baru"**.
2. Cari nama/NIM/NIP anggota perpustakaan.
3. Cari dan pilih judul koleksi (Buku Umum atau Laporan PKL/TA).
4. Tentukan batas waktu pengembalian $\rightarrow$ Klik **"Proses Peminjaman"**. Notifikasi WhatsApp otomatis akan terkirim ke anggota.

### C. Transaksi Pengembalian Buku & Inspeksi Fisik
1. Buka menu **"Transaksi Pengembalian"** $\rightarrow$ Klik tombol **"Kembalikan"** pada baris transaksi anggota.
2. **Mode 1: Ada (Inspeksi Fisik)**:
   - Periksa fisik buku. Jika kondisi baik, biarkan checklist tercentang semua.
   - Jika ditemukan masalah (misal halaman sobek/cover rusak), hapus centang pada poin checklist terkait.
   - Form sanksi fisik akan terbuka otomatis. Isi jenis sanksi, metode penyelesaian, dan nominal denda.
3. **Mode 2: Buku Hilang**:
   - Jika peminjam melaporkan buku hilang, pilih opsi radio **"Buku Hilang"**.
   - Checklist fisik otomatis disembunyikan dan sanksi jenis *Kehilangan* terpilih secara otomatis.
   - Pilih metode penyelesaian (**Denda Uang Tunai**, **Penggantian Buku Fisik**, atau **Kombinasi**).
   - *Catatan Stok*: Jika diselesaikan dengan Uang Tunai, stok buku tidak bertambah. Jika diselesaikan dengan Penggantian Buku Fisik, stok buku otomatis bertambah (+1).
4. Klik **"Simpan & Proses Pengembalian"**.

### D. Kelola Denda & Sanksi
1. Buka menu **"Denda & Sanksi"** untuk melihat seluruh tagihan denda keterlambatan, kerusakan, atau kehilangan.
2. Judul koleksi (Buku atau Laporan PKL/TA) ditampilkan secara jelas beserta badge kategorinya.
3. Klik tombol ikon **Info (i)** untuk membaca rincian aturan dan catatan inspeksi.
4. Klik tombol centang hijau **"Tandai Lunas"** jika anggota telah menyelesaikan pembayaran/penggantian denda.

### E. Verifikasi Repository Arsip Digital & Surat Tanda Terima
1. Buka menu **"Kelola Arsip Digital"** $\rightarrow$ Pilih laporan PKL/TA yang diunggah mahasiswa.
2. Klik **"Verifikasi"** untuk menyetujui atau **"Tolak"** untuk meminta perbaikan.
3. Setelah fisik laporan diserahkan ke perpustakaan, klik **"Konfirmasi Terima"**. Sistem akan otomatis menerbitkan **Surat Tanda Terima Penyerahan Laporan (PDF)** resmi.

### F. Pengaturan Return & Checklist
1. Buka menu **"Pengaturan Return"**.
2. **Tabel Checklist Pengembalian**: Tambah, edit, atau non-aktifkan poin inspeksi fisik yang muncul pada form pengembalian.
3. **Tabel Aturan Sanksi**: Edit besaran tarif denda keterlambatan per hari, denda flat, atau deskripsi aturan sanksi kehilangan/kerusakan.

### G. Ekspor Laporan & Cetak Data
1. Buka menu **"Laporan"**.
2. Pilih jenis laporan (**Sirkulasi**, **Koleksi**, **Arsip Digital**, atau **Denda**).
3. Filter berdasarkan rentang tanggal $\rightarrow$ Klik **"Cetak PDF"** atau **"Ekspor Excel"**.

---

## 1.4 Panduan Role Admin

### A. Manajemen Pengguna & Akademik
1. **Kelola User**: Tambah, edit, reset password, atau hapus akun Admin, Petugas, Dosen, dan Mahasiswa.
2. **Import Excel**: Unggah file `.xlsx` menggunakan template yang disediakan untuk mengimpor data masal anggota.
3. **Kelola Prodi & Jurusan**: Buka menu **"Program Studi"** untuk mengelola data prodi dan jurusan di POLNEP.

### B. Pengaturan Saluran Notifikasi Multichannel
1. **WhatsApp (Fonnte)**: Buka menu **Pengaturan** $\rightarrow$ **WhatsApp**. Masukkan Token Fonnte API, atur toggle aktif, dan gunakan tombol **Test Kirim WA** untuk menguji pesan uji coba.
2. **Bot Telegram**: Buka menu **Pengaturan** $\rightarrow$ **Bot Telegram**. Masukkan Telegram Bot Token dan Username Bot (`@SipusPolnep_bot`), lalu uji dengan tombol **Test Kirim Telegram**.
3. **Email SMTP**: Buka menu **Pengaturan** $\rightarrow$ **Email SMTP**. Konfigurasi Host, Port, Username, Password SMTP, dan alamat pengirim (`mail_from_address`), lalu gunakan fitur **Test Kirim Email Real-Time**.
4. **Surat Tanda Terima & Kop Surat**: Buka menu **Pengaturan** $\rightarrow$ **Surat Tanda Terima**. Atur nama pejabat penerima, NIP, kode surat, kop lembaga, unggah file **Logo Kop Surat (.png)**, dan klik **Preview PDF Real-Time** untuk melihat tampilan surat tanda terima.

### C. Audit Trail Log Aktivitas
1. Buka menu **"Log Aktivitas"** untuk memantau seluruh rekam jejak tindakan pengguna di dalam sistem secara kronologis.

---

# BAGIAN II: LEMBAR SKENARIO TUGAS UAT (TASK-BASED SCENARIOS)

---

## 2.1 Skenario Tugas UAT - Peran Mahasiswa

**Nama Penguji** : ___________________________  
**NIM / Prodi** : ___________________________  

| No | Instruksi Tugas (Task Scenario) | Hasil Pengujian | Catatan Penguji |
|---|---|---|---|
| 1 | Lakukan pendaftaran akun baru sebagai Mahasiswa dengan mengisi data diri dan mengunggah foto KTM. | [ ] Berhasil<br>[ ] Gagal | |
| 2 | Lakukan login menggunakan Email dan Password yang telah Anda daftarkan. | [ ] Berhasil<br>[ ] Gagal | |
| 3 | Lakukan pencarian buku judul "Laravel" pada menu Katalog Buku. | [ ] Berhasil<br>[ ] Gagal | |
| 4 | Lakukan pencarian Laporan PKL atau Skripsi pada menu Katalog Arsip Digital. | [ ] Berhasil<br>[ ] Gagal | |
| 5 | Bukalah dokumen Laporan PKL/TA dan coba jalankan pemutar PDF terproteksi (*Stream PDF*). | [ ] Berhasil<br>[ ] Gagal | |
| 6 | Cobalah mengajukan *Booking* pada buku yang stoknya tersedia. | [ ] Berhasil<br>[ ] Gagal | |
| 7 | Cobalah mendaftar *Antrian* pada buku yang stoknya sedang habis. | [ ] Berhasil<br>[ ] Gagal | |
| 8 | Bukalah menu *Rak Pinjam* untuk melihat daftar peminjaman aktif dan riwayat Anda. | [ ] Berhasil<br>[ ] Gagal | |
| 9 | Cobalah mengunggah dokumen Laporan PKL/TA PDF mandiri pada menu *Repository Saya*. | [ ] Berhasil<br>[ ] Gagal | |
| 10 | Berikan suara (*Vote*) Anda pada salah satu buku di menu *Voting Buku*. | [ ] Berhasil<br>[ ] Gagal | |

---

## 2.2 Skenario Tugas UAT - Peran Dosen

**Nama Penguji** : ___________________________  
**NIP / Prodi** : ___________________________  

| No | Instruksi Tugas (Task Scenario) | Hasil Pengujian | Catatan Penguji |
|---|---|---|---|
| 1 | Lakukan login akun Dosen dan periksa tampilan Dashboard Dosen. | [ ] Berhasil<br>[ ] Gagal | |
| 2 | Lakukan pencarian bahan pustaka dan laporan penelitian di Katalog Arsip Digital. | [ ] Berhasil<br>[ ] Gagal | |
| 3 | Ajukan permohonan *Booking Buku* untuk keperluan mengajar. | [ ] Berhasil<br>[ ] Gagal | |
| 4 | Bukalah menu *Rak Pinjam* untuk mengecek status pinjaman Anda. | [ ] Berhasil<br>[ ] Gagal | |
| 5 | Buatlah rekomendasi judul buku baru pada menu *Usulan Buku*. | [ ] Berhasil<br>[ ] Gagal | |

---

## 2.3 Skenario Tugas UAT - Peran Petugas Perpustakaan

**Nama Penguji** : ___________________________  
**Jabatan** : ___________________________  

| No | Instruksi Tugas (Task Scenario) | Hasil Pengujian | Catatan Penguji |
|---|---|---|---|
| 1 | Buka menu Kelola Anggota, periksa foto KTM pendaftar baru, lalu klik "Setujui" (Approve). | [ ] Berhasil<br>[ ] Gagal | |
| 2 | Catat transaksi peminjaman baru untuk mahasiswa pada menu *Peminjaman Baru*. | [ ] Berhasil<br>[ ] Gagal | |
| 3 | Proses pengembalian buku kondisi baik menggunakan checklist inspeksi fisik. | [ ] Berhasil<br>[ ] Gagal | |
| 4 | Proses pengembalian buku dengan memilih opsi **"Buku Hilang"** dan pilih metode penyelesaian. | [ ] Berhasil<br>[ ] Gagal | |
| 5 | Bukalah menu *Denda & Sanksi*, periksa detail nama Laporan PKL/Buku, lalu tandai denda sebagai Lunas. | [ ] Berhasil<br>[ ] Gagal | |
| 6 | Buka menu *Kelola Arsip Digital*, verifikasi Laporan PKL mahasiswa, dan klik "Konfirmasi Terima" untuk generate Surat Tanda Terima PDF. | [ ] Berhasil<br>[ ] Gagal | |
| 7 | Bukalah menu *Pengaturan Return* untuk menambah/mengedit item checklist atau aturan sanksi. | [ ] Berhasil<br>[ ] Gagal | |
| 8 | Cetak Laporan Sirkulasi PDF dan Ekspor Laporan Denda ke format Excel. | [ ] Berhasil<br>[ ] Gagal | |

---

## 2.4 Skenario Tugas UAT - Peran Admin System

**Nama Penguji** : ___________________________  
**Jabatan** : ___________________________  

| No | Instruksi Tugas (Task Scenario) | Hasil Pengujian | Catatan Penguji |
|---|---|---|---|
| 1 | Bukalah menu Kelola User dan lakukan pengimporan data anggota masal via file Excel. | [ ] Berhasil<br>[ ] Gagal | |
| 2 | Buka menu Pengaturan WhatsApp, lalu uji pengiriman pesan uji coba via tombol *Test Kirim WA*. | [ ] Berhasil<br>[ ] Gagal | |
| 3 | Buka menu Pengaturan Bot Telegram, lalu jalankan tes pengiriman pesan via *Test Kirim Telegram*. | [ ] Berhasil<br>[ ] Gagal | |
| 4 | Buka menu Pengaturan Email SMTP, lalu jalankan pengujian kirim email real-time. | [ ] Berhasil<br>[ ] Gagal | |
| 5 | Buka Pengaturan Surat Tanda Terima, unggah logo kop surat (.png), lalu jalankan fitur *Live Preview PDF*. | [ ] Berhasil<br>[ ] Gagal | |
| 6 | Bukalah menu *Log Aktivitas* untuk memeriksa audit trail rekam jejak sistem. | [ ] Berhasil<br>[ ] Gagal | |

---

# BAGIAN III: KUESIONER KEPUASAN PENGGUNA (SKALA LIKERT 1–5)

Responden memberikan penilaian terhadap pernyataan di bawah ini dengan memberikan tanda centang ($\checkmark$) pada kolom nilai:
* **1** = Sangat Tidak Setuju (STS)
* **2** = Tidak Setuju (TS)
* **3** = Cukup / Ragu-ragu (C)
* **4** = Setuju (S)
* **5** = Sangat Setuju (SS)

---

### A. Aspek Kemudahan Penggunaan (Usability)

| No | Pernyataan Pengujian | 1 (STS) | 2 (TS) | 3 (C) | 4 (S) | 5 (SS) |
|---|---|:---:|:---:|:---:|:---:|:---:|
| U1 | Antarmuka aplikasi mudah dipahami dan dipelajari oleh pengguna baru. | | | | | |
| U2 | Alur pendaftaran akun, pencarian buku, hingga peminjaman berjalan dengan jelas. | | | | | |
| U3 | Fitur pengembalian buku dan checklist inspeksi memudahkan petugas dalam memproses sirkulasi. | | | | | |
| U4 | Informasi status peminjaman, booking, dan denda disajikan secara transparan. | | | | | |

---

### B. Aspek Tampilan & Estetika (UI / Visual Design)

| No | Pernyataan Pengujian | 1 (STS) | 2 (TS) | 3 (C) | 4 (S) | 5 (SS) |
|---|---|:---:|:---:|:---:|:---:|:---:|
| V1 | Tata letak (layout), kombinasi warna, dan tipografi terlihat modern, rapi, dan konsisten. | | | | | |
| V2 | Penampilan badge status (Dipinjam, Lunas, Belum Dibayar, Terlambat) jelas dan estetik. | | | | | |
| V3 | Pemutar PDF (Stream Viewer) untuk membaca Laporan PKL/TA nyaman digunakan. | | | | | |

---

### C. Aspek Kesesuaian Fungsi & Fitur (Utility & Functionality)

| No | Pernyataan Pengujian | 1 (STS) | 2 (TS) | 3 (C) | 4 (S) | 5 (SS) |
|---|---|:---:|:---:|:---:|:---:|:---:|
| F1 | Fitur penanganan **Buku Hilang** dan pencatatan sanksi fisik bekerja sesuai kebutuhan operasional. | | | | | |
| F2 | Fitur penerbitan otomatis **Surat Tanda Terima Laporan PDF** sangat membantu kelengkapan administrasi. | | | | | |
| F3 | Fitur notifikasi otomatis via WhatsApp, Telegram, Email, dan Lonceng membantu mengingatkan jadwal pengembalian. | | | | | |
| F4 | Fitur cetak laporan PDF dan ekspor data Excel memudahkan pelaporan periodik. | | | | | |

---

### D. Aspek Kecepatan & Keandalan (Performance & Reliability)

| No | Pernyataan Pengujian | 1 (STS) | 2 (TS) | 3 (C) | 4 (S) | 5 (SS) |
|---|---|:---:|:---:|:---:|:---:|:---:|
| P1 | Respon perpindahan halaman dan pencarian katalog terasa cepat tanpa kendala. | | | | | |
| P2 | Sistem bebas dari kesalahan (*bug/error*) fatal saat digunakan melakukan transaksi. | | | | | |

---

# BAGIAN IV: METODE PERHITUNGAN SKOR & KRITERIA KELAYAKAN

Untuk mengolah data hasil pengisian kuesioner UAT pada Bab 4 Laporan Tugas Akhir Anda, gunakan rumus kuantitatif berikut:

### 1. Rumus Skor Maksimal ($Y$)
$$Y = N \times S \times 5$$

*Di mana:*
* $N$ = Jumlah Responden Penguji
* $S$ = Jumlah Total Pernyataan Kuesioner (12 Soal)
* $5$ = Skor Tertinggi Skala Likert

---

### 2. Rumus Persentase Kelayakan ($P$)
$$P = \left( \frac{\sum X}{Y} \right) \times 100\%$$

*Di mana:*
* $\sum X$ = Total Keseluruhan Skor Aktual dari Seluruh Responden
* $Y$ = Total Skor Maksimal
* $P$ = Persentase Nilai UAT (%)

---

### 3. Tabel Kategori Skala Kelayakan UAT

| Rentang Persentase (%) | Kategori Kelayakan | Tindak Lanjut Sistem |
|---|---|---|
| **81% – 100%** | **Sangat Layak / Sangat Diterima** | Sistem Siap Diterapkan (*Production Ready*) |
| **61% – 80%** | **Layak / Diterima** | Sistem Diterapkan dengan Revisi Kecil |
| **41% – 60%** | **Cukup Layak** | Perlu Perbaikan Fitur Utama |
| **21% – 40%** | **Tidak Layak** | Ditolak / Perlu Rombak Mayor |
| **0% – 20%** | **Sangat Tidak Layak** | Gagal Total |

---

# BAGIAN V: TEMPLATE BERITA ACARA PENGESAHAN UAT

```text
=================================================================================
                    BERITA ACARA USER ACCEPTANCE TESTING (UAT)
               SISTEM INFORMASI PERPUSTAKAAN PSDKU POLNEP SUKAMARA
=================================================================================

Pada hari ini, ............... Tanggal ...... Bulan .................. Tahun 2026, telah
dilaksanakan pengujian User Acceptance Testing (UAT) terhadap Sistem Informasi 
Perpustakaan PSDKU POLNEP Kabupaten Sukamara oleh para perwakilan pengguna.

Berdasarkan hasil pengujian tugas operasional dan rekapitulasi nilai kuesioner kepuasan 
pengguna, diperoleh hasil akhir pengujian sebagai berikut:

   Total Skor Aktual (∑X)   : ..................
   Total Skor Maksimal (Y)  : ..................
   Persentase Kelayakan (P) : .......... %
   Kategori Kelayakan       : [ SATISFACTORY / SANGAT LAYAK ]

KESIMPULAN:
Sistem Informasi Perpustakaan PSDKU POLNEP dinyatakan LAYAK dan DAPAT DITERIMA untuk 
diimplementasikan dalam operasional Perpustakaan PSDKU POLNEP Kabupaten Sukamara.


Sukamara, .............................. 2026

        Penguji / Representative,                       Pengembang Sistem,



     ( ................................ )             ( ................................ )


                                   Mengetahui,
                             Dosen Pembimbing Utama,



     ( ................................ )
     NIP.
=================================================================================
```

---

*Dokumen Panduan Pengguna & UAT ini disusun untuk melengkapi lampiran dan Bab Hasil Pengujian pada Tugas Akhir Semester 6 Program Studi Teknologi Informasi POLNEP.*
