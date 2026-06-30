<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookSearchController extends Controller
{
    /**
     * Display the catalog search interface for students and lecturers.
     */
    public function index(Request $request)
    {
        \App\Models\Booking::checkExpiredBookings();

        $search = $request->input('search');
        $categoryId = $request->input('category');

        $query = Book::with(['category', 'collection']);

        // Pencarian berdasarkan judul, penulis, atau penerbit
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($categoryId) {
            $query->where('kategori_id', $categoryId);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();
        $categories = Category::orderBy('kategori_name', 'asc')->get();

        $user = auth()->user();

        if ($user->isDosen()) {
            return view('dosen.books.index', compact('books', 'categories', 'search', 'categoryId'));
        }

        return view('mahasiswa.books.index', compact('books', 'categories', 'search', 'categoryId'));
    }
}
