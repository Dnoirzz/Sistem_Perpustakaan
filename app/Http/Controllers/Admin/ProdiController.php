<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $prodis = Prodi::withCount(['mahasiswas', 'dosens'])
            ->when($search, function ($query, $search) {
                return $query->where('nama_prodi', 'like', "%{$search}%");
            })
            ->orderBy('nama_prodi', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.prodis.index', compact('prodis', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi',
        ], [
            'nama_prodi.required' => 'Nama program studi wajib diisi.',
            'nama_prodi.unique' => 'Nama program studi sudah terdaftar.',
            'nama_prodi.max' => 'Nama program studi tidak boleh lebih dari 255 karakter.',
        ]);

        Prodi::create([
            'nama_prodi' => $request->nama_prodi,
        ]);

        return redirect()->route('admin.prodis.index')
            ->with('success', 'Program Studi baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        return view('admin.prodis.edit', compact('prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi,' . $prodi->prodi_id . ',prodi_id',
        ], [
            'nama_prodi.required' => 'Nama program studi wajib diisi.',
            'nama_prodi.unique' => 'Nama program studi sudah terdaftar.',
            'nama_prodi.max' => 'Nama program studi tidak boleh lebih dari 255 karakter.',
        ]);

        $prodi->update([
            'nama_prodi' => $request->nama_prodi,
        ]);

        return redirect()->route('admin.prodis.index')
            ->with('success', 'Program Studi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        // Cek apakah ada mahasiswa atau dosen yang masih terhubung dengan prodi ini
        $mahasiswaCount = $prodi->mahasiswas()->count();
        $dosenCount = $prodi->dosens()->count();

        if ($mahasiswaCount > 0 || $dosenCount > 0) {
            return redirect()->route('admin.prodis.index')
                ->with('error', 'Program studi tidak dapat dihapus karena masih memiliki mahasiswa atau dosen terdaftar.');
        }

        $prodi->delete();

        return redirect()->route('admin.prodis.index')
            ->with('success', 'Program Studi berhasil dihapus.');
    }
}
