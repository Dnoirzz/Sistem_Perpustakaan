# KAMUS DATA TABEL DATABASE (BAB III PERANCANGAN SISTEM)

Dokumen ini berisi tabel-tabel **Kamus Data (Data Dictionary)** untuk 27 tabel aplikasi Sistem Informasi Perpustakaan yang disusun dengan penomoran standar laporan Tugas Akhir / Skripsi (`Tabel 3. 1` s/d `Tabel 3. 27`).

---

### Tabel 3. 1 Tabel Roles
Tabel roles digunakan untuk menyimpan data peran atau hak akses pengguna dalam sistem perpustakaan seperti pada Tabel 3. 1.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `role_id` | bigint | Primary Key |
| `role_name` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 2 Tabel Users
Tabel users digunakan untuk menyimpan data akun pengguna yang dapat mengakses sistem perpustakaan seperti pada Tabel 3. 2.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `user_id` | bigint | Primary Key |
| `role_id` | bigint | Foreign Key (roles.role_id) |
| `name` | varchar | |
| `email` | varchar | Unique |
| `email_verified_at` | timestamp | |
| `password` | varchar | |
| `no_hp` | varchar | |
| `foto` | varchar | |
| `remember_token` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 3 Tabel Jurusans
Tabel jurusans digunakan untuk menyimpan data jurusan yang terdapat pada lingkungan kampus seperti pada Tabel 3. 3.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `jurusan_id` | bigint | Primary Key |
| `nama_jurusan` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 4 Tabel Prodi
Tabel prodi digunakan untuk menyimpan data program studi yang berada di bawah jurusan tertentu seperti pada Tabel 3. 4.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `prodi_id` | bigint | Primary Key |
| `jurusan_id` | bigint | Foreign Key (jurusans.jurusan_id) |
| `nama_prodi` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 5 Tabel Mahasiswas
Tabel mahasiswas digunakan untuk menyimpan data mahasiswa yang menjadi anggota perpustakaan seperti pada Tabel 3. 5.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `mhs_id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `prodi_id` | bigint | Foreign Key (prodi.prodi_id) |
| `nim` | varchar | Unique |
| `semester` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 6 Tabel Dosens
Tabel dosens digunakan untuk menyimpan data dosen yang menjadi pengguna atau anggota perpustakaan seperti pada Tabel 3. 6.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `dosen_id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `nip` | varchar | Unique |
| `prodi_id` | bigint | Foreign Key (prodi.prodi_id) |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 7 Tabel Petugas
Tabel petugas digunakan untuk menyimpan data petugas yang mengelola layanan perpustakaan seperti pada Tabel 3. 7.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `staff_id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `nip` | varchar | Unique |
| `jabatan` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 8 Tabel Categories
Tabel categories digunakan untuk menyimpan data kategori buku yang tersedia di perpustakaan seperti pada Tabel 3. 8.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `kategori_id` | bigint | Primary Key |
| `kategori_name` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 9 Tabel Books
Tabel books digunakan untuk menyimpan data katalog buku fisik yang dimiliki perpustakaan seperti pada Tabel 3. 9.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `buku_id` | bigint | Primary Key |
| `kategori_id` | bigint | Foreign Key (categories.kategori_id) |
| `judul` | varchar | |
| `author` | varchar | |
| `publisher` | varchar | |
| `release` | year | |
| `stock` | int | |
| `cover_image` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 10 Tabel Collections
Tabel collections digunakan untuk menyimpan data koleksi yang dapat dipinjam atau diakses melalui sistem perpustakaan seperti pada Tabel 3. 10.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `koleksi_id` | bigint | Primary Key |
| `item_type` | varchar | Polymorphic Type |
| `item_id` | bigint | Polymorphic ID |
| `stock` | int | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 11 Tabel Loans
Tabel loans digunakan untuk menyimpan data transaksi peminjaman koleksi perpustakaan seperti pada Tabel 3. 11.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `loan_id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `koleksi_id` | bigint | Foreign Key (collections.koleksi_id) |
| `tgl_pinjam` | date | |
| `bts_waktu` | date | |
| `tgl_kembali` | date | |
| `status` | enum | dipinjam, dikembalikan, terlambat |
| `return_condition_status` | enum | baik, bermasalah |
| `return_condition_checks` | json | |
| `return_condition_notes` | text | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 12 Tabel Bookings
Tabel bookings digunakan untuk menyimpan data reservasi atau pemesanan koleksi perpustakaan oleh pengguna seperti pada Tabel 3. 12.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `booking_id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `koleksi_id` | bigint | Foreign Key (collections.koleksi_id) |
| `tgl_booking` | date | |
| `status` | enum | pending, disetujui, dibatalkan, selesai |
| `note` | text | |
| `batas_waktu_ambil` | datetime | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 13 Tabel Antrian
Tabel antrian digunakan untuk menyimpan data antrean pengguna ketika koleksi perpustakaan belum tersedia seperti pada Tabel 3. 13.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `antrian_id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `koleksi_id` | bigint | Foreign Key (collections.koleksi_id) |
| `no_antrian` | int | |
| `status` | enum | menunggu, tersedia, selesai, dibatalkan |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 14 Tabel Penalties
Tabel penalties digunakan untuk menyimpan data sanksi atau denda yang dikenakan kepada pengguna perpustakaan seperti pada Tabel 3. 14.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `penalti_id` | bigint | Primary Key |
| `loan_id` | bigint | Foreign Key (loans.loan_id) |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `type` | enum | keterlambatan, kehilangan, kerusakan |
| `penalti_type` | varchar | |
| `amount` | decimal | |
| `description` | text | |
| `status` | enum | belum_dibayar, lunas |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 15 Tabel Penalty Rules
Tabel penalty_rules digunakan untuk menyimpan data aturan perhitungan sanksi atau denda peminjaman seperti pada Tabel 3. 15.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `penalty_rule_id` | bigint | Primary Key |
| `code` | varchar | Unique |
| `rule_name` | varchar | |
| `calculation_type` | enum | per_hari, flat, manual |
| `default_settlement_method` | enum | uang_tunai, ganti_buku, kombinasi |
| `default_amount` | decimal | |
| `description` | text | |
| `is_active` | boolean | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 16 Tabel Return Checklists
Tabel return_checklists digunakan untuk menyimpan data daftar pemeriksaan kondisi koleksi saat proses pengembalian seperti pada Tabel 3. 16.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `return_checklist_id` | bigint | Primary Key |
| `item_name` | varchar | |
| `description` | varchar | |
| `sort_order` | int | |
| `is_active` | boolean | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 17 Tabel Laporan Pkl
Tabel laporan_pkl digunakan untuk menyimpan data arsip laporan Praktik Kerja Lapangan mahasiswa seperti pada Tabel 3. 17.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `id` | bigint | Primary Key |
| `mahasiswa_id` | bigint | Foreign Key (mahasiswas.mhs_id) |
| `judul_pkl` | varchar | |
| `nama_tempat_pkl` | varchar | |
| `pembimbing` | varchar | |
| `penguji_1` | varchar | |
| `penguji_2` | varchar | |
| `tahun` | year | |
| `file_pdf` | varchar | |
| `file_word` | varchar | |
| `status` | enum | pending, diverifikasi, aktif, ditolak |
| `catatan_petugas` | text | |
| `preview_pdf` | varchar | |
| `surat_tanda_terima_pdf` | varchar | |
| `nomor_surat` | varchar | |
| `verified_at` | timestamp | |
| `received_at` | timestamp | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 18 Tabel Proposal Ta
Tabel proposal_ta digunakan untuk menyimpan data arsip proposal Tugas Akhir mahasiswa seperti pada Tabel 3. 18.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `id` | bigint | Primary Key |
| `mahasiswa_id` | bigint | Foreign Key (mahasiswas.mhs_id) |
| `judul_proposal` | varchar | |
| `pembimbing` | varchar | |
| `penguji_1` | varchar | |
| `penguji_2` | varchar | |
| `tahun` | year | |
| `file_pdf` | varchar | |
| `file_word` | varchar | |
| `status` | enum | pending, diverifikasi, aktif, ditolak |
| `catatan_petugas` | text | |
| `preview_pdf` | varchar | |
| `surat_tanda_terima_pdf` | varchar | |
| `nomor_surat` | varchar | |
| `verified_at` | timestamp | |
| `received_at` | timestamp | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 19 Tabel Laporan Tugas Akhir
Tabel laporan_tugas_akhir digunakan untuk menyimpan data arsip laporan Tugas Akhir mahasiswa seperti pada Tabel 3. 19.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `id` | bigint | Primary Key |
| `mahasiswa_id` | bigint | Foreign Key (mahasiswas.mhs_id) |
| `judul_tgs_akhir` | varchar | |
| `pembimbing` | varchar | |
| `penguji_1` | varchar | |
| `penguji_2` | varchar | |
| `tahun` | year | |
| `file_pdf` | varchar | |
| `file_word` | varchar | |
| `status` | enum | pending, diverifikasi, aktif, ditolak |
| `catatan_petugas` | text | |
| `preview_pdf` | varchar | |
| `surat_tanda_terima_pdf` | varchar | |
| `nomor_surat` | varchar | |
| `verified_at` | timestamp | |
| `received_at` | timestamp | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 20 Tabel Archive Read Logs
Tabel archive_read_logs digunakan untuk menyimpan data riwayat akses baca arsip digital oleh pengguna seperti pada Tabel 3. 20.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `archive_id` | bigint | |
| `archive_type` | varchar | |
| `finished_at` | timestamp | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 21 Tabel Recommendations
Tabel recommendations digunakan untuk menyimpan data usulan pengadaan buku dari pengguna perpustakaan seperti pada Tabel 3. 21.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `rekomendasi_id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `title` | varchar | |
| `author` | varchar | |
| `reason` | text | |
| `status` | enum | pending, disetujui, ditolak |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 22 Tabel Votings
Tabel votings digunakan untuk menyimpan data sesi voting pengadaan buku yang dibuat oleh petugas seperti pada Tabel 3. 22.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `voting_id` | bigint | Primary Key |
| `title` | varchar | |
| `deskripsi` | text | |
| `tgl_mulai` | date | |
| `tgl_selesai` | date | |
| `created_by` | bigint | Foreign Key (users.user_id) |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 23 Tabel Voting Items
Tabel voting_items digunakan untuk menyimpan data pilihan rekomendasi buku yang dimasukkan ke dalam sesi voting seperti pada Tabel 3. 23.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `voting_item_id` | bigint | Primary Key |
| `voting_id` | bigint | Foreign Key (votings.voting_id) |
| `rekomendasi_id` | bigint | Foreign Key (recommendations.rekomendasi_id) |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 24 Tabel Votes
Tabel votes digunakan untuk menyimpan data suara pengguna terhadap item voting pengadaan buku seperti pada Tabel 3. 24.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `vote_id` | bigint | Primary Key |
| `voting_item_id` | bigint | Foreign Key (voting_items.voting_item_id) |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 25 Tabel Notifications Custom
Tabel notifications_custom digunakan untuk menyimpan data notifikasi internal yang dikirim kepada pengguna sistem seperti pada Tabel 3. 25.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `title` | varchar | |
| `message` | text | |
| `is_read` | boolean | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 26 Tabel Activity Logs
Tabel activity_logs digunakan untuk menyimpan data riwayat aktivitas pengguna di dalam sistem perpustakaan seperti pada Tabel 3. 26.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key (users.user_id) |
| `activity` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

---

### Tabel 3. 27 Tabel App Settings
Tabel app_settings digunakan untuk menyimpan data pengaturan global yang digunakan oleh aplikasi perpustakaan seperti pada Tabel 3. 27.

| Nama Field | Tipe Data | Keterangan |
| :--- | :---: | :--- |
| `id` | bigint | Primary Key |
| `key` | varchar | Unique |
| `value` | text | |
| `description` | varchar | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |
