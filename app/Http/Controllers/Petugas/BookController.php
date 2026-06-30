<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'judul' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'release' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'stock' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:categories,kategori_id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Penulis buku wajib diisi.',
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
        $request->validate([
            'judul' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'release' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'stock' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:categories,kategori_id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'author.required' => 'Penulis buku wajib diisi.',
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

        $book->update($data);

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
}
