# SUBBAB 3.X: SKENARIO USE CASE DAN SEQUENCE DIAGRAM
## Sistem Informasi Perpustakaan (SIP) PSDKU POLNEP Sukamara

> **Petunjuk bagi Mahasiswa (Dokumen Siap Pakai untuk Laporan TA):**
> Dokumen ini disusun menggunakan **Standar Penulisan Ilmiah Tugas Akhir/Skripsi (IEEE / UML Standard)**. 
> Penomoran Tabel (**Tabel 3.1, 3.2, dst.**) dan Gambar (**Gambar 3.1, 3.2, dst.**) telah disesuaikan agar Anda dapat langsung menyalinnya (*copy-paste*) ke dalam **Bab 3 (Perancangan Sistem)** atau **Bab 4 (Implementasi Sistem)** Laporan Tugas Akhir Anda.

---

## 📑 DAFTAR SPESIFIKASI SKENARIO & DIAGRAM SEQUENCE

| No | Nama Modul / Fitur Sistem | Kode Use Case | Nomor Tabel Skenario | Nomor Gambar Sequence |
| :---: | :--- | :---: | :---: | :---: |
| 1 | Autentikasi Pengguna & Routing Multi-Role | UC-01 | Tabel 3.1 | Gambar 3.1 |
| 2 | Sirkulasi Peminjaman Buku / Koleksi Baru | UC-02 | Tabel 3.2 | Gambar 3.2 |
| 3 | Pengembalian Buku, Inspeksi Fisik, & Denda | UC-03 | Tabel 3.3 | Gambar 3.3 |
| 4 | Reservasi Booking Buku Online | UC-04 | Tabel 3.4 | Gambar 3.4 |
| 5 | Antrian Stok Kosong & Auto Waiting List | UC-05 | Tabel 3.5 | Gambar 3.5 |
| 6 | Repositori Digital & Verifikasi Karya Ilmiah | UC-06 | Tabel 3.6 | Gambar 3.6 |
| 7 | Usulan Rekomendasi & Voting Pengadaan Buku | UC-07 | Tabel 3.7 | Gambar 3.7 |
| 8 | Scheduler WA Automatic Reminder (H-1 & Overdue) | UC-08 | Tabel 3.8 | Gambar 3.8 |

---

## 3.X.1 MODUL 1: AUTENTIKASI PENGGUNA & ROUTING DASHBOARD PERAN

### A. Tabel Skenario Use Case UC-01

**Tabel 3.1** Skenario Use Case Autentikasi Pengguna & Penentuan Dashboard Peran

| Komponen Skenario | Spesifikasi Detail |
| :--- | :--- |
| **Nama Use Case** | Autentikasi Pengguna & Penentuan Dashboard Sesuai Peran (*Login & Multi-Role Routing*) |
| **Kode Use Case** | **UC-01** |
| **Aktor Utama** | Mahasiswa, Dosen, Petugas Perpustakaan, Admin |
| **Deskripsi** | Pengguna menginputkan kredensial (email dan kata sandi). Sistem mengautentikasi akun dan mengarahkan pengguna ke halaman Dashboard yang sesuai dengan hak akses perannya. |
| **Pre-kondisi** | Pengguna dalam status belum terautentikasi (*guest*) dan berada pada halaman Login. |
| **Post-kondisi** | Pengguna berhasil terautentikasi (*authenticated*) dan diarahkan ke halaman Dashboard sesuai perannya (Admin, Petugas, Mahasiswa, atau Dosen). |
| **Alur Utama (Normal Flow)** | 1. Pengguna memasukkan **Email** dan **Password** pada formulir login.<br>2. Pengguna mengklik tombol **Login**.<br>3. Sistem menerima data masukan dan memvalidasi kelengkapan serta formatnya.<br>4. Sistem mencocokkan kredensial pengguna dengan data akun yang terdaftar di basis data.<br>5. Jika data sesuai, sistem membuat dan meregenerasi sesi login baru pengguna untuk keamanan.<br>6. Sistem memeriksa hak akses peran pengguna.<br>7. Sistem mengarahkan pengguna ke rute halaman Dashboard yang sesuai dengan perannya:<br>&nbsp;&nbsp;&nbsp;&nbsp;a. Peran Admin $\rightarrow$ Diarahkan ke Dashboard Admin<br>&nbsp;&nbsp;&nbsp;&nbsp;b. Peran Petugas $\rightarrow$ Diarahkan ke Dashboard Petugas<br>&nbsp;&nbsp;&nbsp;&nbsp;c. Peran Mahasiswa $\rightarrow$ Diarahkan ke Dashboard Mahasiswa<br>&nbsp;&nbsp;&nbsp;&nbsp;d. Peran Dosen $\rightarrow$ Diarahkan ke Dashboard Dosen<br>8. Antarmuka halaman Dashboard yang sesuai berhasil ditampilkan kepada pengguna. |
| **Alur Alternatif (Alternative Flow)** | **3a. Kredensial Tidak Valid**: Jika email atau kata sandi salah, sistem menampilkan pesan kesalahan *"Kredensial yang dimasukkan tidak cocok dengan catatan kami"* dan pengguna tetap berada di halaman login.<br>**8a. Akses Dibatasi**: Jika pengguna mencoba mengakses halaman yang tidak sesuai dengan hak akses perannya (misalnya Mahasiswa mencoba membuka halaman Dashboard Admin), sistem menghentikan akses dan menampilkan pesan peringatan bahwa hak akses dibatasi. |

---

### B. Sequence Diagram UC-01

![Gambar 3.1 Sequence Diagram Autentikasi Pengguna](file:///d:/POLNEP/Semester%206/Tugas%20Akhir/perpustakaan/dokumentasi/DIAGRAM_SEQUENCE_DAN_SKENARIO.md)

**Gambar 3.1** Sequence Diagram Autentikasi Pengguna & Multi-Role Routing

```mermaid
sequenceDiagram
    autonumber
    actor User as Pengguna (Mahasiswa/Dosen/Petugas/Admin)
    participant View as Login View (Blade)
    participant AuthCtrl as AuthenticatedSessionController
    participant Middleware as Auth & Role Middleware
    participant UserModel as User & Role Model
    participant DB as MySQL Database

    User->>View: Input Email & Password, Klik "Login"
    View->>AuthCtrl: HTTP POST /login (credentials)
    AuthCtrl->>UserModel: authenticate(email, password)
    UserModel->>DB: SELECT * FROM users WHERE email = ? LIMIT 1
    DB-->>UserModel: Data User & Hashed Password
    
    alt Kredensial Valid
        UserModel-->>AuthCtrl: Authentication Success (User Object)
        AuthCtrl->>User: Redirect GET /dashboard
        User->>Middleware: HTTP GET /dashboard
        Middleware->>UserModel: checkRole(auth()->user())
        UserModel-->>Middleware: role_name (admin / petugas / mahasiswa / dosen)
        Middleware-->>User: Redirect to Role Dashboard Route
        User->>View: Render Dashboard Halaman Sesuai Peran
    else Kredensial Tidak Valid
        UserModel-->>AuthCtrl: Authentication Failed
        AuthCtrl-->>View: Back with Errors ("Credentials do not match")
        View-->>User: Tampilkan Pesan Error Login
    end
```

#### Deskripsi Komponen & Interaksi Sequence Diagram Gambar 3.1:
1. **Komponen Boundary (View)**: Form login Blade yang menerima masukan pengguna.
2. **Komponen Control (Controller & Middleware)**: `AuthenticatedSessionController` mengolah otentikasi, sedangkan `RoleMiddleware` mengarahkan rute sesuai role.
3. **Komponen Entity (Model & Database)**: Model `User` dan `Role` merepresentasikan entitas pengguna di tabel `users` dan `roles`.

---

## 3.X.2 MODUL 2: TRANSAKSI SIRKULASI PEMINJAMAN BUKU

### A. Tabel Skenario Use Case UC-02

**Tabel 3.2** Skenario Use Case Pencatatan Transaksi Peminjaman Koleksi

| Komponen Skenario | Spesifikasi Detail |
| :--- | :--- |
| **Nama Use Case** | Pencatatan Transaksi Peminjaman Koleksi (*Physical Circulation Loan*) |
| **Kode Use Case** | **UC-02** |
| **Aktor Utama** | Petugas Perpustakaan |
| **Aktor Pendukung** | Pemustaka (Mahasiswa / Dosen) |
| **Deskripsi** | Petugas mencatat transaksi peminjaman satu atau lebih koleksi buku/arsip kepada pemustaka. Sistem mengamankan transaksi data stok dan mengirimkan notifikasi otomatis via WhatsApp. |
| **Pre-kondisi** | Petugas telah terautentikasi dan membuka halaman peminjaman koleksi. |
| **Post-kondisi** | Transaksi peminjaman tersimpan dengan status 'Dipinjam', stok koleksi berkurang, status antrian aktif pengguna diselesaikan, dan notifikasi konfirmasi dikirimkan ke nomor WhatsApp pemustaka. |
| **Alur Utama (Normal Flow)** | 1. Petugas mencari dan memilih data pemustaka (Mahasiswa atau Dosen).<br>2. Petugas memilih satu atau lebih koleksi (buku/arsip) yang akan dipinjam.<br>3. Petugas menetapkan Tanggal Peminjaman dan Batas Waktu Pengembalian.<br>4. Petugas mengklik tombol **Simpan Transaksi Peminjaman**.<br>5. Sistem memvalidasi kelayakan status akun pemustaka yang melakukan peminjaman.<br>6. Sistem mengurutkan data koleksi untuk mencegah benturan transaksi (*deadlock*).<br>7. Sistem membuka proses transaksi yang aman dan terisolasi:<br>&nbsp;&nbsp;&nbsp;&nbsp;a. Memeriksa ketersediaan stok fisik koleksi dan mengunci data sisa stok sementara.<br>&nbsp;&nbsp;&nbsp;&nbsp;b. Memeriksa bahwa pemustaka tidak sedang meminjam judul koleksi yang sama.<br>&nbsp;&nbsp;&nbsp;&nbsp;c. Mencatat data transaksi peminjaman baru.<br>&nbsp;&nbsp;&nbsp;&nbsp;d. Memperbarui status antrian aktif pemustaka untuk koleksi ini menjadi selesai.<br>&nbsp;&nbsp;&nbsp;&nbsp;e. Mengurangi jumlah stok fisik koleksi secara otomatis.<br>8. Sistem mencatat riwayat aktivitas transaksi ke dalam log sistem.<br>9. Sistem mengirimkan pesan notifikasi rincian peminjaman dan tanggal jatuh tempo pengembalian ke nomor WhatsApp pemustaka.<br>10. Halaman menampilkan pesan konfirmasi bahwa transaksi peminjaman berhasil disimpan. |
| **Alur Alternatif (Alternative Flow)** | **8b. Stok Kosong**: Jika stok koleksi habis, transaksi dibatalkan dan sistem menampilkan pesan kesalahan *"Stok koleksi sudah habis"*.<br>**8c. Peminjaman Ganda**: Jika pemustaka masih memiliki transaksi peminjaman aktif untuk koleksi yang sama, sistem menolak transaksi dengan pesan *"Pemustaka masih memiliki peminjaman aktif untuk koleksi ini"*. |

---

### B. Sequence Diagram UC-02

**Gambar 3.2** Sequence Diagram Transaksi Sirkulasi Peminjaman Koleksi

```mermaid
sequenceDiagram
    autonumber
    actor Petugas as Petugas Perpustakaan
    participant View as Form Loan View (Blade)
    participant LoanCtrl as Petugas\LoanController
    participant ColModel as Collection Model
    participant LoanModel as Loan Model
    participant AntrianModel as Antrian Model
    participant DB as MySQL Database (Pessimistic Lock)
    participant WAService as WhatsAppService (Fonnte API)
    actor Member as Pemustaka (Mahasiswa/Dosen)

    Petugas->>View: Pilih Member, Pilih Koleksi, Set Tgl Pinjam & Batas Waktu
    Petugas->>View: Klik "Simpan Peminjaman"
    View->>LoanCtrl: HTTP POST /petugas/loans (user_id, koleksi_ids, tgl_pinjam, bts_waktu)
    
    LoanCtrl->>DB: DB::beginTransaction()
    loop Untuk Setiap Koleksi ID
        LoanCtrl->>ColModel: Collection::where('koleksi_id', id)->lockForUpdate()->firstOrFail()
        ColModel->>DB: SELECT * FROM collections WHERE koleksi_id = ? FOR UPDATE
        DB-->>ColModel: Collection Data & Stock Level
        
        alt Stock < 1
            ColModel-->>LoanCtrl: Stock Empty
            LoanCtrl->>DB: DB::rollBack()
            LoanCtrl-->>View: Validation Exception ("Stok Koleksi Habis")
            View-->>Petugas: Tampilkan Pesan Error Stok Habis
        else Stock Available
            LoanCtrl->>LoanModel: Loan::create([user_id, koleksi_id, tgl_pinjam, bts_waktu, status='dipinjam'])
            LoanModel->>DB: INSERT INTO loans ...
            
            LoanCtrl->>AntrianModel: Antrian::where(user_id, koleksi_id)->update(['status' => 'selesai'])
            AntrianModel->>DB: UPDATE antrians SET status='selesai' ...
            
            LoanCtrl->>ColModel: syncBackingStock(-1)
            ColModel->>DB: UPDATE collections SET stock = stock - 1 ...
        end
    end
    LoanCtrl->>DB: DB::commit()
    
    LoanCtrl->>WAService: send(member->no_hp, message_text)
    WAService->>Member: Kirim Pesan WA ("Peminjaman Berhasil, Batas Pengembalian: dd/mm/yyyy")
    
    LoanCtrl-->>View: Redirect /petugas/loans with Success Message
    View-->>Petugas: Tampilkan Alert "Transaksi Peminjaman Berhasil Disimpan"
```

#### Deskripsi Komponen Sequence Diagram Gambar 3.2:
- **`lockForUpdate()`**: Mencegah *race condition* (peminjaman bersamaan oleh 2 petugas untuk 1 stok sisa).
- **`syncBackingStock(-1)`**: Metode Eloquent Model yang otomatis mengurangi stok pada tabel koleksi.
- **`WhatsAppService`**: Class Helper pengirim HTTP Request ke REST API Fonnte WhatsApp Gateway.

---

## 3.X.3 MODUL 3: TRANSAKSI PENGEMBALIAN BUKU & INSPEKSI FISIK

### A. Tabel Skenario Use Case UC-03

**Tabel 3.3** Skenario Use Case Pengembalian Buku & Inspeksi Kondisi Fisik

| Komponen Skenario | Spesifikasi Detail |
| :--- | :--- |
| **Nama Use Case** | Pemrosesan Pengembalian Buku, Inspeksi Fisik, & Sanksi Denda |
| **Kode Use Case** | **UC-03** |
| **Aktor Utama** | Petugas Perpustakaan |
| **Deskripsi** | Petugas memproses pengembalian buku, melakukan pemeriksaan fisik (*checklist*), menghitung denda keterlambatan/kerusakan, mengembalikan stok, dan memicu notifikasi antrian berikutnya. |
| **Pre-kondisi** | Peminjaman berada dalam status 'Dipinjam' atau 'Terlambat'. |
| **Post-kondisi** | Status transaksi menjadi 'Dikembalikan', stok koleksi bertambah 1 unit, denda/sanksi dicatat jika ada, dan pemustaka pada antrian berikutnya menerima notifikasi bahwa buku telah tersedia. |
| **Alur Utama (Normal Flow)** | 1. Petugas membuka formulir pemrosesan pengembalian buku.<br>2. Petugas menginspeksi kondisi fisik buku sesuai daftar periksa (sampul, kelengkapan halaman, kebersihan dari coretan, keutuhan lembar, dan kondisi kering).<br>3. Petugas mengklik tombol **Proses Pengembalian**.<br>4. Sistem memproses pengembalian secara aman dan terisolasi:<br>&nbsp;&nbsp;&nbsp;&nbsp;a. Mengunci data transaksi peminjaman dan data koleksi.<br>&nbsp;&nbsp;&nbsp;&nbsp;b. Mengubah status transaksi menjadi 'Dikembalikan' dan mencatat tanggal pengembalian.<br>&nbsp;&nbsp;&nbsp;&nbsp;c. Menambah jumlah stok fisik koleksi sebanyak 1 unit.<br>5. Sistem memeriksa daftar antrian pemustaka untuk koleksi tersebut:<br>&nbsp;&nbsp;&nbsp;&nbsp;a. Mengambil data pemustaka pada urutan antrian teratas yang berstatus menunggu.<br>&nbsp;&nbsp;&nbsp;&nbsp;b. Mengubah status antrian pemustaka tersebut menjadi 'Tersedia'.<br>&nbsp;&nbsp;&nbsp;&nbsp;c. Mengirimkan pesan notifikasi WhatsApp kepada pemustaka antrian berikutnya bahwa buku telah tersedia.<br>6. Halaman diperbarui dengan notifikasi bahwa pemrosesan pengembalian berhasil. |
| **Alur Alternatif (Alternative Flow)** | **4d. Peminjaman Terlambat**: Jika pengembalian melewati batas waktu, sistem secara otomatis menghitung nominal denda berdasarkan aturan tarif harian dan mencatat data sanksi keterlambatan dengan status 'Belum Dibayar'.<br>**4e. Fisik Rusak/Hilang**: Jika buku mengalami kerusakan atau hilang, Petugas memilih jenis sanksi dan metode penyelesaian (Uang Tunai / Ganti Buku / Kombinasi), lalu sistem mencatat data sanksi kerusakan tersebut. |

---

### B. Sequence Diagram UC-03

**Gambar 3.3** Sequence Diagram Pengembalian Buku & Notifikasi Antrian

```mermaid
sequenceDiagram
    autonumber
    actor Petugas as Petugas Perpustakaan
    participant View as Return Modal View
    participant ReturnCtrl as Petugas\ReturnController
    participant LoanModel as Loan Model
    participant ColModel as Collection Model
    participant PenaltyModel as Penalty Model
    participant AntrianModel as Antrian Model
    participant WAService as WhatsAppService (Fonnte API)
    actor MemberQueue as Pemustaka Antrian Berikutnya

    Petugas->>View: Checklist Kondisi Fisik, Klik "Proses Pengembalian"
    View->>ReturnCtrl: HTTP POST /petugas/returns/{loan}/process (condition_checks, penalty_data)
    
    ReturnCtrl->>LoanModel: DB::transaction() & lockForUpdate()
    LoanModel->>ColModel: syncBackingStock(+1)
    ReturnCtrl->>LoanModel: update([tgl_kembali => today, status => 'dikembalikan', return_condition_status])
    
    opt Peminjaman Terlambat (isOverdue == true)
        ReturnCtrl->>PenaltyModel: Penalty::create([type => 'keterlambatan', amount => daysLate * rate, status => 'belum_dibayar'])
    end
    
    opt Kondisi Fisik Rusak / Bermasalah
        ReturnCtrl->>PenaltyModel: Penalty::create([type => 'kerusakan', amount => penalty_amount, penalti_type => settlement_method])
    end
    
    ReturnCtrl->>AntrianModel: Antrian::checkAndNotifyAvailableQueue(koleksi_id)
    AntrianModel->>AntrianModel: Pick next queue (status='menunggu' ORDER BY no_antrian ASC)
    
    opt Terdapat Pemustaka Menunggu Antrian
        AntrianModel->>AntrianModel: Update status = 'tersedia'
        AntrianModel->>WAService: send(nextUser->no_hp, "Koleksi yang Anda tunggu kini TERSEDIA!")
        WAService->>MemberQueue: Kirim Pesan WA Notifikasi Ketersediaan Koleksi
    end
    
    ReturnCtrl-->>View: Redirect /petugas/returns with Success Message
    View-->>Petugas: Tampilkan Notifikasi "Pengembalian Berhasil Diproses"
```

---

## 3.X.4 MODUL 4: RESERVASI BOOKING BUKU ONLINE

### A. Tabel Skenario Use Case UC-04

**Tabel 3.4** Skenario Use Case Reservasi Booking Buku Online

| Komponen Skenario | Spesifikasi Detail |
| :--- | :--- |
| **Nama Use Case** | Pengajuan Booking Online oleh Pemustaka & Persetujuan Petugas |
| **Kode Use Case** | **UC-04** |
| **Aktor Utama** | Mahasiswa / Dosen (Pemustaka) |
| **Aktor Pendukung** | Petugas Perpustakaan |
| **Deskripsi** | Pemustaka memesan koleksi secara online. Petugas meninjau dan menyetujui permohonan booking, lalu stok buku dikunci sementara hingga diambil di perpustakaan. |
| **Pre-kondisi** | Stok koleksi tersedia (stok > 0) dan pemustaka tidak memiliki reservasi aktif untuk koleksi yang sama. |
| **Post-kondisi** | Data reservasi tersimpan dalam status 'Disetujui', stok koleksi berkurang 1 unit, dan siap direalisasikan menjadi transaksi peminjaman aktif. |
| **Alur Utama (Normal Flow)** | 1. Pemustaka memilih buku pada katalog online dan mengklik tombol **Booking Buku**.<br>2. Sistem mencatat pengajuan reservasi dengan status menunggu persetujuan (pending).<br>3. Petugas meninjau daftar permohonan reservasi yang masuk.<br>4. Petugas mengklik **Setujui Booking** dan menentukan batas waktu pengambilan buku.<br>5. Sistem mengubah status reservasi menjadi disetujui dan mengurangi stok koleksi secara otomatis.<br>6. Pemustaka mendatangi perpustakaan untuk mengambil buku yang telah dipesan.<br>7. Petugas mengklik **Realisasikan ke Peminjaman**, sistem mengubah status reservasi menjadi direalisasikan dan menerbitkan data transaksi peminjaman aktif baru. |
| **Alur Alternatif (Alternative Flow)** | **5a. Booking Ditolak**: Jika Petugas mengklik **Tolak**, status berubah menjadi ditolak dan stok buku tidak berkurang.<br>**7a. Reservasi Kadaluarsa (Expired)**: Jika pemustaka tidak mengambil buku hingga melampaui batas waktu pengambilan, sistem mengubah status reservasi menjadi kadaluarsa dan mengembalikan stok koleksi (+1). |

---

### B. Sequence Diagram UC-04

**Gambar 3.4** Sequence Diagram Reservasi Booking Buku Online

```mermaid
sequenceDiagram
    autonumber
    actor Member as Pemustaka (Mahasiswa/Dosen)
    participant KatalogView as Katalog / Detail Buku View
    participant BookCtrl as BookingController
    actor Petugas as Petugas Perpustakaan
    participant PetugasView as Petugas Booking View
    participant PetugasBookCtrl as Petugas\BookingController
    participant BookingModel as Booking Model
    participant ColModel as Collection Model
    participant DB as MySQL Database

    Member->>KatalogView: Klik "Booking Buku Ini"
    KatalogView->>BookCtrl: HTTP POST /mahasiswa/bookings (koleksi_id)
    BookCtrl->>BookingModel: Booking::create([user_id, koleksi_id, status='pending'])
    BookingModel->>DB: INSERT INTO bookings ...
    BookCtrl-->>KatalogView: Alert "Pengajuan Booking Berhasil, Menunggu Persetujuan"
    
    Petugas->>PetugasView: Buka Daftar Booking Pending
    Petugas->>PetugasView: Input Batas Waktu Pengambilan, Klik "Setujui"
    PetugasView->>PetugasBookCtrl: HTTP POST /petugas/bookings/{id}/approve (batas_waktu_ambil)
    
    PetugasBookCtrl->>DB: DB::transaction()
    PetugasBookCtrl->>BookingModel: update([status => 'disetujui', batas_waktu_ambil])
    PetugasBookCtrl->>ColModel: syncBackingStock(-1)
    ColModel->>DB: UPDATE collections SET stock = stock - 1 ...
    PetugasBookCtrl->>DB: DB::commit()
    
    PetugasBookCtrl-->>PetugasView: Redirect /petugas/bookings with Success
    
    note over Member, Petugas: Pemustaka datang ke Perpustakaan me-realisasikan Booking
    Petugas->>PetugasView: Klik "Realisasikan ke Peminjaman Active"
    PetugasView->>PetugasBookCtrl: HTTP POST /petugas/bookings/{id}/realize
    PetugasBookCtrl->>BookingModel: update([status => 'direalisasikan'])
    PetugasBookCtrl->>DB: INSERT INTO loans (user_id, koleksi_id, status='dipinjam')
    PetugasBookCtrl-->>PetugasView: Transaksi Peminjaman Resmi Aktif
```

---

## 3.X.5 MODUL 5: ANTRIAN STOK KOSONG

### A. Tabel Skenario Use Case UC-05

**Tabel 3.5** Skenario Use Case Pendaftaran Antrian Stok Kosong

| Komponen Skenario | Spesifikasi Detail |
| :--- | :--- |
| **Nama Use Case** | Pendaftaran Antrian Pemustaka Saat Stok Kosong (*Queue Waiting List*) |
| **Kode Use Case** | **UC-05** |
| **Aktor Utama** | Mahasiswa / Dosen (Pemustaka) |
| **Deskripsi** | Pemustaka mendaftar antrian untuk koleksi yang stoknya sedang habis. Sistem menetapkan nomor urut antrian berurutan dan menginfokan posisi antrian. |
| **Pre-kondisi** | Stok fisik koleksi berada dalam kondisi kosong (stok = 0). |
| **Post-kondisi** | Data antrian tersimpan dengan status 'Menunggu' dan pemustaka memperoleh nomor urut antrian. |
| **Alur Utama (Normal Flow)** | 1. Pemustaka membuka halaman detail koleksi yang stoknya habis.<br>2. Pemustaka mengklik tombol **Gabung Antrian Stok Kosong**.<br>3. Sistem menghitung nomor urut antrian berikutnya secara otomatis berdasarkan jumlah antrian aktif.<br>4. Sistem mendaftarkan pemustaka ke dalam daftar antrian dengan status menunggu.<br>5. Pemustaka dapat memantau posisi dan nomor urut antriannya pada menu halaman antrian pemustaka. |

---

### B. Sequence Diagram UC-05

**Gambar 3.5** Sequence Diagram Pendaftaran Antrian Stok Kosong

```mermaid
sequenceDiagram
    autonumber
    actor Member as Pemustaka (Mahasiswa/Dosen)
    participant View as Katalog Detail View
    participant AntrianCtrl as AntrianController
    participant AntrianModel as Antrian Model
    participant DB as MySQL Database

    Member->>View: Klik "Masuk Antrian Buku Ini" (Stok = 0)
    View->>AntrianCtrl: HTTP POST /mahasiswa/antrian (koleksi_id)
    AntrianCtrl->>AntrianModel: SELECT MAX(no_antrian) FROM antrians WHERE koleksi_id=? AND status IN ('menunggu','tersedia')
    AntrianModel->>DB: Query Max Queue Number
    DB-->>AntrianModel: Returns Max No (e.g. 2)
    
    AntrianCtrl->>AntrianModel: Antrian::create([user_id, koleksi_id, no_antrian=3, status='menunggu'])
    AntrianModel->>DB: INSERT INTO antrians ...
    
    AntrianCtrl-->>View: Back with Success ("Anda Berhasil Masuk Antrian #3")
    View-->>Member: Tampilkan Badge Status Antrian #3 (Menunggu)
```

---

## 3.X.6 MODUL 6: REPOSITORI ARSIP DIGITAL KARYA ILMIAH

### A. Tabel Skenario Use Case UC-06

**Tabel 3.6** Skenario Use Case Unggah & Verifikasi Repositori Arsip Digital

| Komponen Skenario | Spesifikasi Detail |
| :--- | :--- |
| **Nama Use Case** | Unggah Dokumen Karya Ilmiah & Verifikasi Surat Bebas Perpus |
| **Kode Use Case** | **UC-06** |
| **Aktor Utama** | Mahasiswa |
| **Aktor Pendukung** | Petugas Perpustakaan |
| **Deskripsi** | Mahasiswa mengunggah berkas PDF Laporan PKL/Proposal/TA. Petugas memverifikasi kelayakan berkas dan menerbitkan Surat Tanda Terima Bebas Perpustakaan. |
| **Pre-kondisi** | Mahasiswa terautentikasi dan memiliki berkas karya ilmiah berformat PDF. |
| **Post-kondisi** | Status berkas menjadi 'Aktif', terintegrasi ke dalam katalog repositori digital perpustakaan, dan Surat Tanda Terima PDF dapat diunduh oleh mahasiswa. |
| **Alur Utama (Normal Flow)** | 1. Mahasiswa mengunggah berkas PDF dan mengisi data identitas karya ilmiah pada halaman unggah arsip.<br>2. Sistem menyimpan berkas pada media penyimpanan terproteksi dan mencatat data dokumen dengan status 'Menunggu Verifikasi'.<br>3. Petugas memeriksa pratinjau dokumen PDF pada halaman verifikasi.<br>4. Petugas mengklik **Verifikasi & Menerbitkan Surat**.<br>5. Sistem mengubah status dokumen menjadi aktif, menerbitkan nomor surat resmi secara otomatis, dan mengintegrasikan dokumen ke repositori publik perpustakaan.<br>6. Mahasiswa dapat mengunduh dokumen Surat Tanda Terima Penyerahan Karya Ilmiah berformat PDF. |

---

### B. Sequence Diagram UC-06

**Gambar 3.6** Sequence Diagram Repositori Arsip Digital

```mermaid
sequenceDiagram
    autonumber
    actor Mahasiswa as Mahasiswa (Penulis)
    participant MhsView as Upload Arsip View
    participant MhsArsipCtrl as Mahasiswa\ArsipController
    actor Petugas as Petugas Perpustakaan
    participant PetugasView as Verifikasi Arsip View
    participant PetugasArsipCtrl as Petugas\ArsipController
    participant ArsipModel as LaporanTugasAkhir / LaporanPkl Model
    participant Storage as File Storage (PDF Disk)
    participant DB as MySQL Database

    Mahasiswa->>MhsView: Unggah PDF & Metadata Karya Ilmiah, Klik "Simpan"
    MhsView->>MhsArsipCtrl: HTTP POST /mahasiswa/arsip (file_pdf, judul, abstrak)
    MhsArsipCtrl->>Storage: storeAs('public/arsip/', filename.pdf)
    MhsArsipCtrl->>ArsipModel: create([mahasiswa_id, judul, file_pdf, status='pending'])
    ArsipModel->>DB: INSERT INTO laporan_tugas_akhirs ...
    MhsArsipCtrl-->>MhsView: Alert "Arsip Berhasil Diunggah, Menunggu Verifikasi"
    
    Petugas->>PetugasView: Buka Detail Arsip Pending & Preview PDF
    Petugas->>PetugasView: Klik "Verifikasi & Menerbitkan Surat"
    PetugasView->>PetugasArsipCtrl: HTTP POST /petugas/arsip/{type}/{id}/verify
    
    PetugasArsipCtrl->>ArsipModel: update([status => 'aktif', no_surat => generateNoSurat()])
    PetugasArsipCtrl->>DB: Sync to Polymorphic collections table
    PetugasArsipCtrl-->>PetugasView: Status Berubah menjadi Aktif / Diverifikasi
    
    Mahasiswa->>MhsView: Klik "Unduh Surat Tanda Terima Digital"
    MhsView->>MhsArsipCtrl: GET /petugas/arsip/{type}/{id}/surat
    MhsArsipCtrl-->>Mahasiswa: Render PDF Surat Tanda Terima Penyerahan Laporan
```

---

## 3.X.7 MODUL 7: USULAN BUKU & VOTING PENGADAAN

### A. Tabel Skenario Use Case UC-07

**Tabel 3.7** Skenario Use Case Usulan Rekomendasi & Voting Pengadaan Buku

| Komponen Skenario | Spesifikasi Detail |
| :--- | :--- |
| **Nama Use Case** | Usulan Judul Buku Baru & Voting Demokrasi Pengadaan Buku |
| **Kode Use Case** | **UC-07** |
| **Aktor Utama** | Mahasiswa & Dosen (Pemustaka) |
| **Aktor Pendukung** | Petugas Perpustakaan |
| **Deskripsi** | Pemustaka mengusulkan buku baru. Petugas membuka sesi voting, lalu pemustaka memberikan suara untuk menentukan prioritas pengadaan buku. |
| **Pre-kondisi** | Periode voting sedang dibuka dan berstatus aktif oleh Petugas. |
| **Post-kondisi** | Pilihan suara berhasil dicatat (1 akun pengguna hanya dapat memberikan 1 suara per judul usulan) dan total perolehan suara pada usulan buku bertambah. |
| **Alur Utama (Normal Flow)** | 1. Pemustaka mengisikan formulir usulan judul buku baru (judul, pengarang, penerbit, dan alasan usulan).<br>2. Sistem mencatat data usulan buku baru dengan status menunggu peninjauan.<br>3. Petugas membuat periode voting baru dan memasukkan judul-judul usulan ke dalam daftar voting.<br>4. Pemustaka membuka halaman voting aktif dan mengklik tombol **Vote / Berikan Suara** pada buku pilihan.<br>5. Sistem memeriksa riwayat pemberian suara pemustaka.<br>6. Jika belum pernah memberikan suara pada judul tersebut, sistem mencatat suara dan menambah total perolehan suara buku tersebut.<br>7. Halaman menampilkan pesan konfirmasi bahwa suara berhasil disimpan. |
| **Alur Alternatif (Alternative Flow)** | **5a. Suara Ganda**: Jika pemustaka sudah pernah memberikan suara pada judul buku yang sama, sistem menampilkan pesan kesalahan *"Anda sudah memberikan suara pada buku ini"*. |

---

### B. Sequence Diagram UC-07

**Gambar 3.7** Sequence Diagram Usulan & Voting Buku Baru

```mermaid
sequenceDiagram
    autonumber
    actor Member as Pemustaka (Mahasiswa/Dosen)
    participant RecView as Form Usul Buku View
    participant RecCtrl as RecommendationController
    actor Petugas as Petugas Perpustakaan
    participant VotingAdminView as Kelola Voting View
    participant PetugasVotingCtrl as Petugas\VotingController
    participant MemberVotingCtrl as VotingController
    participant DB as MySQL Database

    Member->>RecView: Input Judul Buku, Pengarang, Penerbit, Alasan
    RecView->>RecCtrl: HTTP POST /mahasiswa/recommendations
    RecCtrl->>DB: INSERT INTO book_recommendations (user_id, judul, status='pending')
    
    Petugas->>VotingAdminView: Buat Periode Voting Baru & Pilih Usulan Rekomendasi
    VotingAdminView->>PetugasVotingCtrl: HTTP POST /petugas/voting (nama_sesi, tgl_mulai, tgl_selesai)
    PetugasVotingCtrl->>DB: INSERT INTO votings & voting_items
    
    Member->>RecView: Buka Halaman Voting Aktif
    Member->>RecView: Klik "Vote / Berikan Suara" pada Item Buku Pilihan
    RecView->>MemberVotingCtrl: HTTP POST /mahasiswa/voting/{voting_item_id}/vote
    
    MemberVotingCtrl->>DB: SELECT * FROM votes WHERE user_id=? AND voting_item_id=?
    alt Belum Pernah Vote Item Ini
        MemberVotingCtrl->>DB: INSERT INTO votes (user_id, voting_item_id)
        MemberVotingCtrl->>DB: UPDATE voting_items SET total_votes = total_votes + 1
        MemberVotingCtrl-->>RecView: Alert "Suara Anda Berhasil Disimpan!"
    else Sudah Pernah Vote
        MemberVotingCtrl-->>RecView: Error "Anda Sudah Memberikan Suara pada Buku Ini"
    end
```

---

## 3.X.8 MODUL 8: NOTIFIKASI OTOMATIS VIA LARAVEL SCHEDULER

### A. Tabel Skenario Use Case UC-08

**Tabel 3.8** Skenario Use Case Scheduler Notifikasi Pengingat WA Otomatis

| Komponen Skenario | Spesifikasi Detail |
| :--- | :--- |
| **Nama Use Case** | Pengiriman Otomatis Pengingat Jatuh Tempo (H-1 & Terlambat) via WA |
| **Kode Use Case** | **UC-08** |
| **Aktor Utama** | System / Server Scheduler |
| **Aktor Penerima** | Pemustaka yang memiliki peminjaman aktif |
| **Deskripsi** | Proses pengingat otomatis dijalankan secara berkala oleh server. Sistem mencari transaksi peminjaman yang mendekati jatuh tempo (H-1) atau terlambat, memperbarui status transaksi, dan mengirimkan pesan pengingat ke WhatsApp pemustaka. |
| **Pre-kondisi** | Layanan penjadwalan otomatis (scheduler) aktif dan pengirim pesan WhatsApp terkonfigurasi pada sistem. |
| **Post-kondisi** | Pesan pengingat terkirim ke nomor WhatsApp pemustaka dan status transaksi peminjaman yang terlambat diperbarui pada basis data. |
| **Alur Utama (Normal Flow)** | 1. Layanan penjadwalan otomatis pada server mengeksekusi tugas pengingat sesuai jadwal harian yang ditentukan.<br>2. Sistem memindai seluruh transaksi peminjaman aktif dan memperbarui status peminjaman yang melewati batas waktu menjadi 'Terlambat'.<br>3. Sistem mencari daftar peminjaman aktif yang akan jatuh tempo esok hari (H-1) serta peminjaman yang berstatus terlambat.<br>4. Untuk setiap transaksi peminjaman yang ditemukan, sistem menyusun pesan pengingat.<br>5. Sistem mengirimkan pesan notifikasi pengingat secara otomatis ke nomor WhatsApp masing-masing pemustaka.<br>6. Sistem mencatat ringkasan hasil pengiriman pengingat ke dalam log aktivitas server. |

---

### B. Sequence Diagram UC-08

**Gambar 3.8** Sequence Diagram Scheduler Notifikasi WhatsApp Otomatis

```mermaid
sequenceDiagram
    autonumber
    participant Cron as Server Cron / Windows Task Scheduler
    participant Artisan as Laravel Artisan (loans:send-reminders)
    participant Command as SendLoanReminderNotifications Command
    participant LoanModel as Loan Model & Sync
    participant DB as MySQL Database
    participant WAService as WhatsAppService
    participant FonnteAPI as Fonnte WhatsApp API Gateway
    actor Member as Pemustaka (WhatsApp Receiver)

    Cron->>Artisan: Execute `php artisan schedule:run` Daily at 08:00 AM
    Artisan->>Command: handle()
    
    Command->>LoanModel: Loan::syncOverdueStatuses()
    LoanModel->>DB: UPDATE loans SET status='terlambat' WHERE bts_waktu < TODAY AND status='dipinjam'
    
    Command->>LoanModel: Query Loans Due Tomorrow (H-1) & Overdue Loans
    LoanModel->>DB: SELECT * FROM loans WHERE status IN ('dipinjam', 'terlambat') WITH user
    DB-->>Command: Return List of Matching Active Loans
    
    loop Untuk Setiap Transaksi Peminjaman
        Command->>WAService: WhatsAppService::send(user->no_hp, reminderMessage)
        WAService->>FonnteAPI: HTTP POST https://api.fonnte.com/send (target, message, token)
        FonnteAPI-->>WAService: Response JSON { status: true, id: "msg_12345" }
        FonnteAPI->>Member: Delivery Pesan WhatsApp ("Pengingat: Peminjaman Buku X Jatuh Tempo Besok!")
    end
    
    Command-->>Artisan: Console Command Completed Successfully (Log Summary)
```

---

## 💡 PANDUAN PRAKTIS & TIPS SIDANG TUGAS AKHIR

### 1. Cara Memindahkan Tabel ke Microsoft Word
1. Blok seluruh bagian **Tabel 3.X Skenario Use Case** pada dokumen markdown ini.
2. *Copy* (Ctrl + C) lalu *Paste* (Ctrl + V) ke Microsoft Word.
3. Di Microsoft Word: Pilih tabel $\rightarrow$ Tab **Table Design** $\rightarrow$ Pilih Style *Grid Table 4 - Accent 1* atau aktifkan **Header Row** & **Borders**.
4. Atur Font menjadi **Times New Roman 11pt**, Spasi Baris **1.15**.

### 2. Cara Mengubah Diagram Sequence (Mermaid) Menjadi Gambar HD
1. Di VS Code, pastikan ekstensi **Markdown Preview Mermaid Support** aktif.
2. Klik kanan pada diagram Mermaid yang muncul di Preview $\rightarrow$ Pilih **Save Image As PNG** atau **Copy Image**.
3. *Paste* gambar ke MS Word di bawah subbab diagram yang bersangkutan.
4. Berikan keterangan caption di bawah gambar: **Gambar 3.X** *Sequence Diagram ...* (Centrum, Times New Roman 10pt Italic).

### 3. Jawaban Siap Pakai Saat Dosen Penguji Bertanya di Sidang TA:
- **Dosen Penguji**: *"Mengapa pada Sequence Diagram Peminjaman (Gambar 3.2) ada penguncian baris `lockForUpdate()`?"*
- **Jawaban Anda**: *"Izin menjawab Bapak/Ibu Penguji, penguncian baris `lockForUpdate()` dinamakan Pessimistic Locking. Hal ini diterapkan di `LoanController` untuk mencegah kondisi Race Condition, yaitu apabila terdapat dua petugas yang memproses transaksi peminjaman untuk satu-satunya stok sisa buku pada detik yang bersamaan. Dengan `lockForUpdate()`, database akan memblokir request kedua hingga request pertama selesai commit, sehingga stok tidak pernah menjadi negatif (-1)."*

---
*Dokumen perancangan ini telah divalidasi dan disesuaikan 100% dengan struktur source code Laravel SIPUS POLNEP.*
