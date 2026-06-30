# 📄 Panduan Desain Template Surat Tanda Terima Arsip Digital

**File:** `surat_tanda_terima_template.pdf`  
**Lokasi penyimpanan di project:** `storage/app/templates/surat_tanda_terima.pdf`  
**Software yang direkomendasikan:** Microsoft Word → Export ke PDF

---

## Ukuran & Orientasi Halaman

| Parameter | Nilai |
|-----------|-------|
| Ukuran Kertas | **A4** (210mm × 297mm) |
| Orientasi | **Portrait** (tegak) |
| Margin Atas | 25mm |
| Margin Kiri | 30mm (standar surat resmi) |
| Margin Kanan | 20mm |
| Margin Bawah | 20mm |

---

## Struktur Layout Template (Bagian Statis & Dinamis)

Bagian yang bertanda 🖊️ adalah area yang **dikosongkan di template** — data akan diisi otomatis oleh sistem saat generate surat.

```
┌──────────────────────────────────────────────────────────────┐
│                                                              │
│  [LOGO POLNEP — kiri]    POLITEKNIK NEGERI PONTIANAK        │
│                          KAMPUS PSDKU SUKAMARA              │
│                          PERPUSTAKAAN                        │
│                          Jl. [Alamat Perpustakaan]          │
│                          Telp: [No. Telp]                   │
│ ──────────────────────────────────────────────────────────── │
│                                                              │
│              SURAT TANDA TERIMA ARSIP DIGITAL               │
│           No: 🖊️[NOMOR SURAT]                               │
│                                                              │
│  Yang bertanda tangan di bawah ini, Perpustakaan PSDKU      │
│  Politeknik Negeri Pontianak di Kabupaten Sukamara           │
│  menerangkan bahwa:                                          │
│                                                              │
│  ┌────────────────────────────────────────────────────────┐  │
│  │ Nama Mahasiswa  : 🖊️[NAMA_MAHASISWA]                   │  │
│  │ NIM             : 🖊️[NIM]                              │  │
│  │ Program Studi   : 🖊️[PRODI]                            │  │
│  │ Jenis Arsip     : 🖊️[JENIS_ARSIP]                      │  │
│  │ Judul           :                                       │  │
│  │   🖊️[JUDUL_ARSIP_BARIS_1]                              │  │
│  │   🖊️[JUDUL_ARSIP_BARIS_2]  ← (jika judul panjang)     │  │
│  │ Pembimbing      : 🖊️[NAMA_PEMBIMBING]                  │  │
│  │ Tahun           : 🖊️[TAHUN]                            │  │
│  └────────────────────────────────────────────────────────┘  │
│                                                              │
│  telah menyerahkan arsip digital tersebut melalui sistem    │
│  informasi perpustakaan (SIPUS POLNEP) pada:                │
│                                                              │
│       Tanggal  : 🖊️[TANGGAL_VERIFIKASI]                     │
│                                                              │
│  Mahasiswa yang namanya tersebut di atas WAJIB menyerahkan  │
│  1 (satu) eksemplar dokumen FISIK (tercetak dan dijilid)    │
│  ke Perpustakaan PSDKU POLNEP paling lambat:                │
│                                                              │
│       🖊️[TANGGAL_BATAS]  (7 hari kerja setelah verifikasi)  │
│                                                              │
│  Surat ini digunakan sebagai bukti penyerahan dan akan      │
│  dicap resmi oleh perpustakaan setelah dokumen fisik        │
│  diterima.                                                   │
│                                                              │
│  Sukamara, 🖊️[TANGGAL_VERIFIKASI]                           │
│                                                              │
│  ┌──────────────────────┐  ┌──────────────────────────────┐ │
│  │  Mahasiswa,          │  │  Petugas Perpustakaan,       │ │
│  │                      │  │                              │ │
│  │  [Area Cap/TTD]      │  │  [Area Cap/TTD]              │ │
│  │  ← kosong untuk TTD  │  │  ← kosong untuk Cap Basah   │ │
│  │                      │  │                              │ │
│  │ (🖊️[NAMA_MAHASISWA]) │  │  (________________________) │ │
│  └──────────────────────┘  └──────────────────────────────┘ │
│                                                              │
│  ── Surat ini digenerate otomatis oleh SIPUS POLNEP ──     │
│         🖊️[NOMOR_SURAT] | 🖊️[TANGGAL_VERIFIKASI]           │
└──────────────────────────────────────────────────────────────┘
```

---

## Detail Setiap Placeholder (Data Dinamis)

Berikut adalah daftar semua placeholder yang akan diisi otomatis oleh sistem (kode PHP):

| Placeholder | Sumber Data | Contoh |
|-------------|-------------|--------|
| `[NOMOR_SURAT]` | Auto-generate oleh sistem | `STT/PKL/2026/0001` |
| `[NAMA_MAHASISWA]` | `users.name` | `Budi Santoso` |
| `[NIM]` | `mahasiswas.nim` | `3202316001` |
| `[PRODI]` | `prodis.prodi_name` | `D3 Teknik Informatika` |
| `[JENIS_ARSIP]` | Berdasarkan tipe arsip | `Laporan Praktik Kerja Lapangan` |
| `[JUDUL_ARSIP]` | Field judul di tabel arsip | `Sistem Informasi Inventaris Barang...` |
| `[NAMA_PEMBIMBING]` | Field `pembimbing` | `Suharsono, S.Kom., M.Kom.` |
| `[TAHUN]` | Field `tahun` | `2026` |
| `[TANGGAL_VERIFIKASI]` | `updated_at` saat verifikasi | `10 Juni 2026` |
| `[TANGGAL_BATAS]` | Tanggal verifikasi + 7 hari kerja | `19 Juni 2026` |

---

## Format Nomor Surat Otomatis

Nomor surat dibuat otomatis dengan format:

```
STT / [KODE_JENIS] / [TAHUN] / [NOMOR_URUT_4_DIGIT]
```

| Jenis Arsip | Kode | Contoh Nomor |
|-------------|------|--------------|
| Laporan PKL | `PKL` | `STT/PKL/2026/0001` |
| Proposal TA | `PTA` | `STT/PTA/2026/0001` |
| Laporan TA | `LTA` | `STT/LTA/2026/0001` |

Nomor urut di-reset setiap tahun dan dihitung berdasarkan berapa banyak arsip dengan jenis yang sama sudah diverifikasi di tahun tersebut.

---

## Koordinat Penulisan Teks (Untuk Kode FPDI)

Setelah template PDF selesai dibuat dan disimpan, catat koordinat (X, Y dalam mm) di mana setiap placeholder harus ditulis. Koordinat diukur dari pojok kiri atas halaman.

> **Cara mengukur koordinat:**
> Buka template PDF di Adobe Acrobat Reader → View → Page Display → Show Page Size.
> Atau, gunakan Adobe Acrobat Pro untuk melihat posisi cursor dalam satuan mm.
> Bisa juga diukur manual dari desain Word (jarak dari margin kiri dan dari atas halaman).

| Placeholder | Perkiraan X (mm) | Perkiraan Y (mm) | Catatan |
|-------------|-----------------|-----------------|---------|
| `[NOMOR_SURAT]` | ~55 | ~70 | Setelah teks "No:" |
| `[NAMA_MAHASISWA]` | ~70 | ~120 | Setelah "Nama Mahasiswa :" |
| `[NIM]` | ~70 | ~128 | Setelah "NIM :" |
| `[PRODI]` | ~70 | ~136 | Setelah "Program Studi :" |
| `[JENIS_ARSIP]` | ~70 | ~144 | Setelah "Jenis Arsip :" |
| `[JUDUL_ARSIP]` | ~70 | ~152 | Multi-line jika panjang |
| `[NAMA_PEMBIMBING]` | ~70 | ~168 | Setelah "Pembimbing :" |
| `[TAHUN]` | ~70 | ~176 | Setelah "Tahun :" |
| `[TANGGAL_VERIFIKASI]` | ~70 | ~195 | Setelah "Tanggal :" |
| `[TANGGAL_BATAS]` | ~55 | ~210 | Tanggal batas penyerahan |
| `[TANGGAL_KOTA]` | ~105 | ~235 | "Sukamara, [tanggal]" |
| `[NAMA_MAHASISWA_TTD]` | ~35 | ~270 | Nama di bawah kolom TTD |
| `[NOMOR_FOOTER]` | ~85 | ~285 | Nomor surat di footer |

> [!NOTE]
> Koordinat di atas adalah **perkiraan**. Setelah template selesai dibuat, koordinat harus dikalibrasi ulang sesuai posisi aktual elemen di PDF template. Proses kalibrasi dilakukan dengan cara run kode dan lihat hasilnya, lalu sesuaikan nilai X/Y.

---

## Checklist Pembuatan Template di Word

- [ ] Tambahkan **logo POLNEP** di sudut kiri atas kop surat
- [ ] Tulis informasi institusi di kop: nama politeknik, kampus, unit perpustakaan, alamat
- [ ] Buat **garis pemisah** tebal di bawah kop surat
- [ ] Tulis judul surat: **"SURAT TANDA TERIMA ARSIP DIGITAL"** (tebal, rata tengah)
- [ ] Buat baris "No:" dengan spasi kosong yang cukup untuk nomor surat
- [ ] Buat **kotak/tabel** untuk data mahasiswa dengan kolom label dan nilai yang jelas
- [ ] Tulis paragraf instruksi penyerahan fisik
- [ ] Buat **dua kolom tanda tangan** (kiri: mahasiswa, kanan: petugas + cap basah)
- [ ] Sisakan ruang kosong yang cukup di setiap area nilai (untuk teks yang akan ditulis sistem)
- [ ] Buat footer tipis dengan area nomor surat
- [ ] Export ke **PDF** dengan kualitas tinggi
- [ ] Simpan file Word asli untuk keperluan revisi di masa mendatang

---

## Cara Menyimpan ke Project Setelah Selesai

Setelah template PDF selesai dibuat:

1. Simpan file PDF dengan nama: **`surat_tanda_terima.pdf`**
2. Letakkan di: `storage/app/templates/surat_tanda_terima.pdf`  
   *(Folder `templates` perlu dibuat jika belum ada)*
3. Informasikan ke developer agar koordinat X/Y dapat dikalibrasi di `SuratTandaTerimaService.php`

---

*Dokumen ini dibuat sebagai panduan pembuatan template. Revisi dapat dilakukan sesuai kebutuhan perpustakaan.*
