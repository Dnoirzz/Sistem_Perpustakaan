# SUBBAB 3.X: DIAGRAM USE CASE MASING-MASING PERAN PENGGUNA (ROLE)
## Sistem Informasi Perpustakaan (SIP) PSDKU POLNEP Sukamara

> **Petunjuk bagi Mahasiswa:**
> Dokumen ini berisi **Diagram Use Case khusus untuk masing-masing peran pengguna** (*Admin, Petugas Perpustakaan, Mahasiswa, dan Dosen*) serta **Diagram Use Case Keseluruhan Sistem**. 
> Setiap diagram gambar telah dilengkapi secara visual dengan relasi **`<<include>>`** (panah hubungan wajib) dan **`<<extend>>`** (panah hubungan kondisional/perluasan) sesuai standar penulisan Laporan Tugas Akhir.

---

## 📑 DAFTAR DIAGRAM USE CASE PER PERAN PENGGUNA

| No | Peran Pengguna (*Actor*) | Nomor Gambar | File Gambar Diagram |
| :---: | :--- | :---: | :--- |
| 1 | **Keseluruhan Sistem (Overview)** | Gambar 3.9 | `use_case_overall_1786783596528.png` |
| 2 | **Admin System** | Gambar 3.10 | `use_case_diagram_admin_1786783869224.png` |
| 3 | **Petugas Perpustakaan** | Gambar 3.11 | `use_case_petugas_1786783638991.png` |
| 4 | **Mahasiswa** | Gambar 3.12 | `use_case_mahasiswa_1786783659164.png` |
| 5 | **Dosen** | Gambar 3.13 | `use_case_mahasiswa_1786783659164.png` |

---

## 3.X.1 DIAGRAM USE CASE KESELURAHAN SISTEM (OVERALL)

Berikut adalah Diagram Use Case keseluruhan sistem yang menggambarkan hubungan 4 Aktor utama dengan System Boundary SIPUS POLNEP:

![Gambar 3.9 Diagram Use Case Keseluruhan Sistem Informasi Perpustakaan](file:///C:/Users/ASUS/.gemini/antigravity-ide/brain/e0b540e4-876c-486d-bc67-4af6c5eb5a5d/use_case_overall_1786783596528.png)

**Gambar 3.9** Diagram Use Case Keseluruhan Sistem Informasi Perpustakaan (SIPUS POLNEP)

---

## 3.X.2 DIAGRAM USE CASE PERAN ADMIN SYSTEM

Aktor **Admin System** bertugas mengelola master pengguna, struktur akademik, pengaturan gateway notifikasi, logo cetak bukti, serta audit trail aktivitas.

![Gambar 3.10 Diagram Use Case Peran Admin System](file:///C:/Users/ASUS/.gemini/antigravity-ide/brain/e0b540e4-876c-486d-bc67-4af6c5eb5a5d/use_case_diagram_admin_1786783869224.png)

**Gambar 3.10** Diagram Use Case Peran Admin System beserta Relasi `<<include>>` dan `<<extend>>`

### Rincian Relasi Include & Extend Peran Admin:
- `Kelola Data User` **`<<include>>`** `Autentikasi Login Admin` (Wajib terautentikasi).
- `Import Data User Excel` **`<<include>>`** `Download Template Excel` (Wajib menggunakan format template resmi).
- `Test Gateway Notifikasi` **`<<extend>>`** `Pengaturan WhatsApp & Telegram` (Kondisional saat melakukan pengujian jaringan).

---

## 3.X.3 DIAGRAM USE CASE PERAN PETUGAS PERPUSTAKAAN

Aktor **Petugas Perpustakaan** bertanggung jawab atas sirkulasi fisik (peminjaman & pengembalian), verifikasi booking, antrian, verifikasi repositori karya ilmiah, dan pengadaan voting buku.

![Gambar 3.11 Diagram Use Case Peran Petugas Perpustakaan](file:///C:/Users/ASUS/.gemini/antigravity-ide/brain/e0b540e4-876c-486d-bc67-4af6c5eb5a5d/use_case_petugas_1786783638991.png)

**Gambar 3.11** Diagram Use Case Peran Petugas Perpustakaan beserta Relasi `<<include>>` dan `<<extend>>`

### Rincian Relasi Include & Extend Peran Petugas:
- `Catat Transaksi Peminjaman` **`<<include>>`** `Autentikasi Login` & `Validasi Stok Koleksi` (Wajib cek ketersediaan stok $\ge 1$).
- `Verifikasi Arsip Digital` **`<<include>>`** `Terbitkan Surat Tanda Terima Bebas Perpus` (Wajib meng-generate nomor surat otomatis).
- `Inspeksi Fisik & Hitung Denda` **`<<extend>>`** `Proses Pengembalian Buku` (Hanya dieksekusi **JIKA** peminjaman terlambat atau kondisi fisik buku rusak/hilang).
- `Notifikasi WA Availability Antrian` **`<<extend>>`** `Proses Pengembalian Buku` (Hanya dieksekusi **JIKA** ada pemustaka yang sedang mengantri buku tersebut).
- `Kirim Pesan WhatsApp API` **`<<extend>>`** `Catat Transaksi Peminjaman` (Hanya dieksekusi **JIKA** nomor kontak pemustaka valid).

---

## 3.X.4 DIAGRAM USE CASE PERAN MAHASISWA

Aktor **Mahasiswa** memiliki akses ke pencarian katalog, reservasi booking online, antrian stok kosong, unggah berkas karya ilmiah (PKL, Proposal TA, Laporan TA), unduh surat bebas perpus, serta voting buku.

![Gambar 3.12 Diagram Use Case Peran Mahasiswa](file:///C:/Users/ASUS/.gemini/antigravity-ide/brain/e0b540e4-876c-486d-bc67-4af6c5eb5a5d/use_case_mahasiswa_1786783659164.png)

**Gambar 3.12** Diagram Use Case Peran Mahasiswa beserta Relasi `<<include>>` dan `<<extend>>`

### Rincian Relasi Include & Extend Peran Mahasiswa:
- `Pengajuan Booking Online` **`<<include>>`** `Autentikasi Login Mahasiswa` (Wajib terautentikasi).
- `Unggah Arsip Digital (PKL/TA)` **`<<include>>`** `Autentikasi Login Mahasiswa` & `Validasi Format PDF`.
- `Unduh Surat Bebas Perpus` **`<<include>>`** `Status Verifikasi Arsip Aktif`.
- `Daftar Antrian Stok Kosong` **`<<extend>>`** `Pencarian Katalog Buku` (Hanya dapat diakses **JIKA** stok buku `stock == 0`).
- `Voting Pengadaan Buku` **`<<extend>>`** `Usulan Rekomendasi Buku` (Hanya aktif **JIKA** periode voting sedang dibuka oleh petugas).

---

## 3.X.5 DIAGRAM USE CASE PERAN DOSEN

Aktor **Dosen** memiliki hak akses untuk mencari koleksi umum & repositori digital, melakukan booking online, masuk antrian stok kosong, mengusulkan buku pengadaan, serta memberikan suara voting.

![Gambar 3.13 Diagram Use Case Peran Dosen](file:///C:/Users/ASUS/.gemini/antigravity-ide/brain/e0b540e4-876c-486d-bc67-4af6c5eb5a5d/use_case_mahasiswa_1786783659164.png)

**Gambar 3.13** Diagram Use Case Peran Dosen beserta Relasi `<<include>>` dan `<<extend>>`

### Rincian Relasi Include & Extend Peran Dosen:
- `Pengajuan Booking Online` **`<<include>>`** `Autentikasi Login Dosen`.
- `Pratinjau / Baca Arsip Digital` **`<<include>>`** `Pencarian Katalog Repositori`.
- `Daftar Antrian Stok Kosong` **`<<extend>>`** `Pencarian Katalog Buku` (Aktif jika stok buku 0).

---

## 💬 CARA MEMASUKKAN GAMBAR KE LAPORAN TUGAS AKHIR (MS WORD)

1. Buka dokumen Word Laporan TA Anda pada **Bab 3 (Perancangan Sistem)**.
2. Salin (*Copy*) file gambar yang berada pada folder berikut:
   `C:\Users\ASUS\.gemini\antigravity-ide\brain\e0b540e4-876c-486d-bc67-4af6c5eb5a5d\`
   - `use_case_overall_1786783596528.png` (Overall System Diagram)
   - `use_case_diagram_admin_1786783869224.png` (Admin Role Diagram)
   - `use_case_petugas_1786783638991.png` (Petugas Role Diagram)
   - `use_case_mahasiswa_1786783659164.png` (Mahasiswa & Dosen Role Diagram)
3. *Paste* gambar pada Microsoft Word, lalu sesuaikan ukuran gambar agar berada di tengah margin (*Center Alignment*).
4. Berikan label judul Gambar di bawah masing-masing gambar:
   - **Gambar 3.9** *Diagram Use Case Keseluruhan Sistem Informasi Perpustakaan*
   - **Gambar 3.10** *Diagram Use Case Peran Admin System*
   - **Gambar 3.11** *Diagram Use Case Peran Petugas Perpustakaan*
   - **Gambar 3.12** *Diagram Use Case Peran Mahasiswa*
   - **Gambar 3.13** *Diagram Use Case Peran Dosen*

---
*Seluruh diagram gambar ini dirancang menggunakan standar simbol UML 2.5 untuk penulisan karya ilmiah perguruan tinggi.*
