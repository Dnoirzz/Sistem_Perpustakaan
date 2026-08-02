<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('kategori_name', 'asc')->get();

        $query = Book::with(['category', 'collection']);

        // Pencarian berdasarkan judul atau penulis
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('kategori_id', $request->input('category'));
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('petugas.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('kategori_name', 'asc')->get();
        return view('petugas.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('stock')) {
            $request->merge([
                'stock' => preg_match('/^\d+$/', $request->stock) ? (int) $request->stock : $request->stock
            ]);
        }

        if ($request->has('release')) {
            $request->merge([
                'release' => preg_match('/^\d+$/', $request->release) ? (int) $request->release : $request->release
            ]);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'release' => 'required|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:categories,kategori_id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Penulis buku wajib diisi.',
            'release.required' => 'Tahun terbit wajib diisi.',
            'stock.required' => 'Stok buku wajib diisi.',
            'stock.min' => 'Stok tidak boleh bernilai negatif.',
            'kategori_id.required' => 'Kategori buku wajib dipilih.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format cover harus jpeg, png, jpg, atau webp.',
            'cover_image.max' => 'Ukuran cover tidak boleh lebih dari 2MB.',
        ]);

        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('covers', $filename, 'public');
            $data['cover_image'] = 'covers/' . $filename;
        }

        Book::create($data);

        return redirect()->route('petugas.books.index')
            ->with('success', 'Buku baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Category::orderBy('kategori_name', 'asc')->get();
        return view('petugas.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        if ($request->has('stock')) {
            $request->merge([
                'stock' => preg_match('/^\d+$/', $request->stock) ? (int) $request->stock : $request->stock
            ]);
        }

        if ($request->has('release')) {
            $request->merge([
                'release' => preg_match('/^\d+$/', $request->release) ? (int) $request->release : $request->release
            ]);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'release' => 'required|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:categories,kategori_id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Penulis buku wajib diisi.',
            'release.required' => 'Tahun terbit wajib diisi.',
            'stock.required' => 'Stok buku wajib diisi.',
            'stock.min' => 'Stok tidak boleh bernilai negatif.',
            'kategori_id.required' => 'Kategori buku wajib dipilih.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Format cover harus jpeg, png, jpg, atau webp.',
            'cover_image.max' => 'Ukuran cover tidak boleh lebih dari 2MB.',
        ]);

        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            // Hapus cover lama jika ada
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $file = $request->file('cover_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('covers', $filename, 'public');
            $data['cover_image'] = 'covers/' . $filename;
        }

        $updatedCollectionId = null;
        $updatedStock = null;

        if (array_key_exists('stock', $data)) {
            // Circulation transactions lock collection -> book. Follow the
            // same order here so a manual stock edit cannot overwrite a
            // concurrent booking/loan/return update.
            [$updatedCollectionId, $updatedStock] = DB::transaction(function () use ($book, $data) {
                $collection = Collection::query()
                    ->where('item_type', 'book')
                    ->where('item_id', $book->buku_id)
                    ->lockForUpdate()
                    ->first();

                $lockedBook = Book::query()
                    ->whereKey($book->buku_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $lockedBook->fill($data);
                $lockedBook->saveQuietly();

                if ($collection) {
                    $collection->update(['stock' => $lockedBook->stock]);
                }

                return [$collection?->koleksi_id, (int) $lockedBook->stock];
            });
        } else {
            $book->update($data);
        }

        // Preserve the previous Book observer behavior: if manual stock
        // editing makes a copy available, promote the next waiting member.
        if ($updatedCollectionId && $updatedStock > 0) {
            Antrian::checkAndNotifyAvailableQueue($updatedCollectionId);
        }

        return redirect()->route('petugas.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Hapus cover jika ada
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('petugas.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Show the book import form.
     */
    public function showImportForm()
    {
        return view('petugas.books.import');
    }

    /**
     * Download the import template for general books.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setTitle('Template Import Buku');
        $titleLabel = 'TEMPLATE IMPORT INVENTARIS BUKU UMUM';
        $headers = ['Judul Buku', 'Penulis / Pengarang', 'Penerbit', 'Tahun Terbit', 'Stok', 'Kategori'];
        $examples = [
            ['Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', '2005', '5', 'Novel'],
            ['Algoritma dan Pemrograman', 'Rinaldi Munir', 'Informatika Bandung', '2011', '3', 'Komputer']
        ];

        // Instructions
        $sheet->setCellValue('A1', $titleLabel);
        $sheet->setCellValue('A2', 'PANDUAN PENGISIAN TEMPLATE IMPORT BUKU:');
        $sheet->setCellValue('A3', '1. Kolom "Judul Buku", "Penulis / Pengarang", "Tahun Terbit", "Stok", dan "Kategori" wajib diisi.');
        $sheet->setCellValue('A4', '2. Kolom "Tahun Terbit" harus berupa 4 digit angka (contoh: 2020) dan minimal tahun 1900.');
        $sheet->setCellValue('A5', '3. Kolom "Stok" harus berupa angka bulat positif (>= 0).');
        $sheet->setCellValue('A6', '4. Kategori akan dicocokkan secara otomatis (case-insensitive). Jika Kategori belum terdaftar, sistem akan membuatnya secara otomatis.');

        $lastCol = 'F';
        
        // Merge cells for header instruction
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);

        // Header Tabel di baris 8
        $sheet->fromArray($headers, null, 'A8');

        // Style header tabel
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '00A5C0'], // POLNEP Turquoise
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $sheet->getStyle("A8:{$lastCol}8")->applyFromArray($headerStyle);

        // Contoh Data (Baris 9 dan 10)
        $sheet->fromArray($examples, null, 'A9');

        // Auto size columns
        foreach (range('A', $lastCol) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_import_buku.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    /**
     * Import books from uploaded excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'], // Max 10MB
        ]);

        $file = $request->file('file');

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Gagal membaca berkas Excel: ' . $e->getMessage()]);
        }

        $startIndex = 8; // Data dimulai dari baris 9 (index 8)
        $totalRows = count($rows);

        if ($totalRows <= $startIndex) {
            return back()->withErrors(['file' => 'Berkas Excel tidak memiliki data untuk di-import.']);
        }

        $errors = [];
        $categories = Category::all();

        // Tahap 1: Validasi format data di seluruh baris
        for ($i = $startIndex; $i < $totalRows; $i++) {
            $row = $rows[$i];
            
            $judul = isset($row[0]) ? trim($row[0]) : '';
            $author = isset($row[1]) ? trim($row[1]) : '';
            $publisher = isset($row[2]) ? trim($row[2]) : '';
            $release = isset($row[3]) ? trim($row[3]) : '';
            $stock = isset($row[4]) ? trim($row[4]) : '';
            $kategoriName = isset($row[5]) ? trim($row[5]) : '';

            // Jika baris kosong seluruhnya, lewati
            if (empty($judul) && empty($author) && empty($release) && empty($stock) && empty($kategoriName)) {
                continue;
            }

            $rowNum = $i + 1;

            if (empty($judul)) {
                $errors[] = "Baris {$rowNum}: Judul Buku wajib diisi.";
            }
            if (empty($author)) {
                $errors[] = "Baris {$rowNum}: Penulis / Pengarang wajib diisi.";
            }
            if (empty($release)) {
                $errors[] = "Baris {$rowNum}: Tahun Terbit wajib diisi.";
            } elseif (!is_numeric($release) || strlen($release) !== 4 || intval($release) < 1900 || intval($release) > date('Y')) {
                $errors[] = "Baris {$rowNum}: Tahun Terbit harus berupa 4 digit angka antara 1900 dan " . date('Y') . ".";
            }
            if ($stock === '') {
                $errors[] = "Baris {$rowNum}: Stok wajib diisi.";
            } elseif (!is_numeric($stock) || intval($stock) < 0) {
                $errors[] = "Baris {$rowNum}: Stok harus berupa angka bulat positif (>= 0).";
            }
            if (empty($kategoriName)) {
                $errors[] = "Baris {$rowNum}: Kategori wajib diisi.";
            }
        }

        // Jika ada kesalahan validasi baris, batalkan import dan tampilkan error
        if (count($errors) > 0) {
            return back()->withInput()->with('import_errors', $errors);
        }

        // Tahap 2: Lakukan import secara transaksional
        $importedCount = 0;
        $skippedCount = 0;

        DB::beginTransaction();
        try {
            for ($i = $startIndex; $i < $totalRows; $i++) {
                $row = $rows[$i];
                
                $judul = isset($row[0]) ? trim($row[0]) : '';
                $author = isset($row[1]) ? trim($row[1]) : '';
                $publisher = isset($row[2]) ? trim($row[2]) : '';
                $release = isset($row[3]) ? trim($row[3]) : '';
                $stock = isset($row[4]) ? trim($row[4]) : '';
                $kategoriName = isset($row[5]) ? trim($row[5]) : '';

                if (empty($judul) && empty($author) && empty($release) && empty($stock) && empty($kategoriName)) {
                    continue;
                }

                // 1. Cek duplikasi: Judul + Penulis (case-insensitive)
                $isDuplicate = Book::whereRaw('LOWER(judul) = ?', [strtolower($judul)])
                    ->whereRaw('LOWER(author) = ?', [strtolower($author)])
                    ->exists();

                if ($isDuplicate) {
                    $skippedCount++;
                    continue;
                }

                // 2. Cari/buat Kategori secara case-insensitive
                $category = $categories->first(function($cat) use ($kategoriName) {
                    return strtolower($cat->kategori_name) === strtolower($kategoriName);
                });

                if (!$category) {
                    // Buat kategori baru di DB
                    $category = Category::create([
                        'kategori_name' => $kategoriName
                    ]);
                    // Refresh koleksi local categories
                    $categories->push($category);
                }

                // 3. Simpan data buku
                Book::create([
                    'judul' => $judul,
                    'author' => $author,
                    'publisher' => $publisher ?: null,
                    'release' => intval($release),
                    'stock' => intval($stock),
                    'kategori_id' => $category->kategori_id,
                ]);

                $importedCount++;
            }

            // Log aktivitas ke ActivityLog
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => "Melakukan import data buku via Excel. Berhasil: {$importedCount}, Dilewati (Duplikat): {$skippedCount}.",
            ]);

            DB::commit();

            $message = "Proses import selesai. Berhasil menambahkan {$importedCount} data buku.";
            if ($skippedCount > 0) {
                $message .= " Sebanyak {$skippedCount} data buku dilewati karena kombinasi Judul & Penulis sudah ada di perpustakaan.";
            }

            return redirect()->route('petugas.books.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal import buku: ' . $e->getMessage());
            return back()->withErrors(['file' => 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage()]);
        }
    }
}
