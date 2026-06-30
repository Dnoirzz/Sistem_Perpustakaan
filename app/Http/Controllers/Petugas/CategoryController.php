<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('books')
            ->orderBy('kategori_name', 'asc')
            ->paginate(10);

        return view('petugas.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_name' => 'required|string|max:255|unique:categories,kategori_name',
        ], [
            'kategori_name.required' => 'Nama kategori wajib diisi.',
            'kategori_name.unique' => 'Nama kategori sudah terdaftar.',
            'kategori_name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
        ]);

        Category::create([
            'kategori_name' => $request->kategori_name,
        ]);

        return redirect()->route('petugas.categories.index')
            ->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('petugas.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'kategori_name' => 'required|string|max:255|unique:categories,kategori_name,' . $category->kategori_id . ',kategori_id',
        ], [
            'kategori_name.required' => 'Nama kategori wajib diisi.',
            'kategori_name.unique' => 'Nama kategori sudah terdaftar.',
            'kategori_name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
        ]);

        $category->update([
            'kategori_name' => $request->kategori_name,
        ]);

        return redirect()->route('petugas.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Cek apakah ada buku yang menggunakan kategori ini
        if ($category->books()->count() > 0) {
            return redirect()->route('petugas.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa buku.');
        }

        $category->delete();

        return redirect()->route('petugas.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
