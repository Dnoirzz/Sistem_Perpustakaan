<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use App\Models\DamagedBook;
use App\Models\Penalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DamagedBookController extends Controller
{
    /**
     * Tampilkan daftar pemantauan buku rusak.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = DamagedBook::with([
            'loan',
            'collection.book.category',
            'collection.laporanPkl.mahasiswa.prodi',
            'collection.proposalTa.mahasiswa.prodi',
            'collection.laporanTa.mahasiswa.prodi',
            'user.role',
            'reporter',
            'replacementCollection.book.category',
        ]);

        if ($status && in_array($status, ['menunggu_penggantian', 'selesai_diganti_sama', 'selesai_diganti_koleksi_baru', 'diafkir_perbaikan'], true)) {
            $query->where('status', $status);
        }

        if ($search) {
            $matchingCollectionIds = \App\Support\ArsipDigital::matchingCollectionIds($search);
            if ($matchingCollectionIds !== []) {
                $query->whereIn('koleksi_id', $matchingCollectionIds);
            } else {
                $query->whereHas('collection.book', function ($bq) use ($search) {
                    $bq->where('judul', 'like', "%{$search}%");
                });
            }
        }

        $damagedBooks = $query
            ->orderByRaw("CASE WHEN status = 'menunggu_penggantian' THEN 0 ELSE 1 END")
            ->orderByDesc('reported_at')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total_damaged' => DamagedBook::count(),
            'pending_replacement' => DamagedBook::where('status', 'menunggu_penggantian')->count(),
            'resolved_same' => DamagedBook::where('status', 'selesai_diganti_sama')->count(),
            'resolved_new' => DamagedBook::where('status', 'selesai_diganti_koleksi_baru')->count(),
            'scrapped' => DamagedBook::where('status', 'diafkir_perbaikan')->count(),
        ];

        $categories = Category::orderBy('kategori_name')->get();
        $allCollections = Collection::with(['book', 'laporanPkl', 'proposalTa', 'laporanTa'])->get();

        return view('petugas.damaged-books.index', compact('damagedBooks', 'stats', 'search', 'status', 'categories', 'allCollections'));
    }

    /**
     * Catat temuan fisik rusak dari inspeksi rutin internal rak (tanpa peminjam).
     * Mengurangi -1 stok ketersediaan di rak dan mencatat entri buku rusak.
     */
    public function storeInternal(Request $request)
    {
        $validated = $request->validate([
            'koleksi_id' => ['required', 'exists:collections,koleksi_id'],
            'condition_notes' => ['required', 'string', 'max:1000'],
        ], [
            'koleksi_id.required' => 'Pilih koleksi/arsip yang ditemukan rusak.',
            'condition_notes.required' => 'Catatan hasil temuan inspeksi wajib diisi.',
        ]);

        DB::transaction(function () use ($validated) {
            $collection = Collection::query()
                ->whereKey($validated['koleksi_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Kurangi stok ketersediaan di rak -1 karena fisik unit rusak ditarik dari sirkulasi
            $collection->syncBackingStock(-1);

            // Buat catatan damaged_book tanpa user_id & loan_id (inspeksi internal)
            DamagedBook::create([
                'loan_id' => null,
                'koleksi_id' => $collection->koleksi_id,
                'user_id' => null,
                'reported_by' => auth()->id(),
                'reported_at' => now(),
                'condition_notes' => $validated['condition_notes'],
                'status' => 'menunggu_penggantian',
                'replacement_notes' => 'Temuan Inspeksi Rutin Rak Internal (Stok rak berkurang -1, menunggu tindak lanjut).',
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Mencatat temuan rusak internal rak untuk koleksi: "' . $collection->display_title . '" (Stok berkurang -1)',
            ]);
        });

        return redirect()->route('petugas.damaged-books.index')->with('success', 'Temuan fisik rusak internal berhasil dicatat. Stok ketersediaan di rak berkurang -1.');
    }

    /**
     * Pulihkan fisik koleksi ke rak (+1 Stok Rak).
     * Dipakai jika koleksi yang sebelumnya rusak/dalam perbaikan telah selesai diperbaiki internal.
     */
    public function restoreToStock(Request $request, $id)
    {
        $damagedBook = DamagedBook::with(['collection'])->findOrFail($id);

        DB::transaction(function () use ($damagedBook, $request) {
            // Tambahkan +1 stok ketersediaan di rak
            if ($damagedBook->collection) {
                $damagedBook->collection->syncBackingStock(1);
            }

            $damagedBook->update([
                'status' => 'selesai_diperbaiki',
                'replacement_notes' => $request->input('notes', 'Selesai diperbaiki secara internal oleh perpustakaan & dikembalikan ke stok rak (+1).'),
                'resolved_at' => now(),
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Memulihkan fisik koleksi rusak ke rak (+1 stok) untuk koleksi: ' . ($damagedBook->collection?->display_title ?? '-'),
            ]);
        });

        return redirect()->back()->with('success', 'Fisik koleksi berhasil dipulihkan dan stok ketersediaan di rak bertambah +1.');
    }

    /**
     * Tandai koleksi dalam proses perbaikan/rekondisi internal.
     */
    public function markInRepair(Request $request, $id)
    {
        $damagedBook = DamagedBook::findOrFail($id);

        $damagedBook->update([
            'status' => 'dalam_perbaikan',
            'replacement_notes' => $request->input('notes', 'Sedang dalam proses perbaikan/rekondisi internal perpustakaan.'),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Memperbarui status koleksi rusak menjadi Dalam Perbaikan Internal (ID: ' . $id . ')',
        ]);

        return redirect()->back()->with('success', 'Status koleksi berhasil diperbarui menjadi Dalam Perbaikan Internal.');
    }

    /**
     * Tandai koleksi rusak sebagai Di-afkir Permanen (Dimusnahkan).
     */
    public function markScrapped(Request $request, $id)
    {
        $damagedBook = DamagedBook::findOrFail($id);

        $damagedBook->update([
            'status' => 'diafkir_perbaikan',
            'replacement_notes' => $request->input('notes', 'Di-afkir permanen / dimusnahkan dari inventaris.'),
            'resolved_at' => now(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Memperbarui status koleksi rusak menjadi Di-afkir Permanen (ID: ' . $id . ')',
        ]);

        return redirect()->back()->with('success', 'Status koleksi berhasil diperbarui menjadi Di-afkir Permanen.');
    }

    /**
     * Proses Penggantian Buku dengan Judul & Eksemplar SAMA PERSIS.
     * Menambah +1 stok ketersediaan dari unit fisik baru yang diserahkan.
     */
    public function resolveSameBook(Request $request, $id)
    {
        $damagedBook = DamagedBook::with(['collection.book', 'user'])->findOrFail($id);

        if ($damagedBook->status !== 'menunggu_penggantian') {
            return redirect()->back()->with('error', 'Status buku rusak ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($damagedBook, $request) {
            // Tambahkan +1 stok ketersediaan murni dari penerimaan unit fisik baru
            if ($damagedBook->collection) {
                $damagedBook->collection->syncBackingStock(1);
            }

            // Update status DamagedBook
            $damagedBook->update([
                'status' => 'selesai_diganti_sama',
                'replacement_notes' => $request->input('notes', 'Diganti dengan fisik buku baru yang sama persis oleh peminjam.'),
                'resolved_at' => now(),
            ]);

            // Lunaskan sanksi/denda fisik terkait jika ada
            if ($damagedBook->loan_id) {
                Penalty::where('loan_id', $damagedBook->loan_id)
                    ->where('status', 'belum_dibayar')
                    ->whereIn('type', ['kerusakan', 'kerusakan_parah', 'kehilangan'])
                    ->update(['status' => 'dibayar']);
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Memproses penggantian buku rusak (Judul Sama) untuk koleksi: ' . ($damagedBook->collection?->display_title ?? '-') . ' oleh peminjam: ' . ($damagedBook->user?->name ?? '-'),
            ]);
        });

        return redirect()->back()->with('success', 'Penyelesaian ganti buku (Judul Sama) berhasil diproses. Stok buku fisik baru bertambah +1.');
    }

    /**
     * Proses Penggantian Buku dengan Koleksi BARU (1 Kategori yang Sama).
     * Tidak menambah stok buku lama, namun mendaftarkan 1 Koleksi Judul Baru di perpustakaan.
     */
    public function resolveNewCollection(Request $request, $id)
    {
        $damagedBook = DamagedBook::with(['collection.book.category', 'user'])->findOrFail($id);

        if ($damagedBook->status !== 'menunggu_penggantian') {
            return redirect()->back()->with('error', 'Status buku rusak ini sudah diproses sebelumnya.');
        }

        // Ambil ID Kategori dari buku asli yang rusak
        $originalCategoryId = $damagedBook->collection?->book?->category_id;

        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'pengarang' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'isbn' => ['nullable', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'category_id' => $originalCategoryId ? ['nullable', 'integer'] : ['required', 'exists:categories,category_id'],
        ], [
            'judul.required' => 'Judul buku baru wajib diisi.',
            'pengarang.required' => 'Nama pengarang wajib diisi.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
        ]);

        $categoryIdToUse = $originalCategoryId ?: $validated['category_id'];

        DB::transaction(function () use ($damagedBook, $validated, $categoryIdToUse, $request) {
            // 1. Buat Buku Baru
            $newBook = Book::create([
                'category_id' => $categoryIdToUse,
                'judul' => $validated['judul'],
                'author' => $validated['pengarang'],
                'publisher' => $validated['penerbit'],
                'publication_year' => $validated['tahun_terbit'],
                'isbn' => $validated['isbn'] ?? null,
                'description' => $validated['deskripsi'] ?? ('Buku penggantian dari peminjam: ' . ($damagedBook->user?->name ?? '-')),
                'stock' => 1,
            ]);

            // 2. Buat Koleksi Baru untuk Buku Baru tersebut
            $newCollection = Collection::create([
                'item_type' => 'book',
                'item_id' => $newBook->buku_id,
                'stock' => 1,
            ]);

            // 3. Update status DamagedBook
            $damagedBook->update([
                'status' => 'selesai_diganti_koleksi_baru',
                'replacement_koleksi_id' => $newCollection->koleksi_id,
                'replacement_notes' => $request->input('notes', 'Diganti dengan koleksi buku baru 1 kategori: "' . $newBook->judul . '"'),
                'resolved_at' => now(),
            ]);

            // 4. Lunaskan denda fisik terkait
            if ($damagedBook->loan_id) {
                Penalty::where('loan_id', $damagedBook->loan_id)
                    ->where('status', 'belum_dibayar')
                    ->whereIn('type', ['kerusakan', 'kerusakan_parah', 'kehilangan'])
                    ->update(['status' => 'dibayar']);
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Memproses penggantian buku rusak dengan Koleksi Baru ("' . $newBook->judul . '") oleh peminjam: ' . ($damagedBook->user?->name ?? '-'),
            ]);
        });

        return redirect()->back()->with('success', 'Penyelesaian ganti buku (Koleksi Baru) berhasil. Judul buku baru telah terdaftar di katalog perpustakaan dengan stok = 1.');
    }
}
