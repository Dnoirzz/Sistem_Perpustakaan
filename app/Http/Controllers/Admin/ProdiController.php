<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
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
        $activeTab = $request->input('tab', 'prodi');

        // Search variables localized to tab
        $prodiSearch = $activeTab === 'prodi' ? $search : null;
        $jurusanSearch = $activeTab === 'jurusan' ? $search : null;

        // Paginated Prodi list
        $prodis = Prodi::with(['jurusan'])->withCount(['mahasiswas', 'dosens'])
            ->when($prodiSearch, function ($query, $prodiSearch) {
                return $query->where('nama_prodi', 'like', "%{$prodiSearch}%");
            })
            ->orderBy('nama_prodi', 'asc')
            ->paginate(10, ['*'], 'prodi_page')
            ->withQueryString();

        // Paginated Jurusan list
        $jurusansPage = Jurusan::withCount(['prodis'])
            ->when($jurusanSearch, function ($query, $jurusanSearch) {
                return $query->where('nama_jurusan', 'like', "%{$jurusanSearch}%");
            })
            ->orderBy('nama_jurusan', 'asc')
            ->paginate(10, ['*'], 'jurusan_page')
            ->withQueryString();

        // All Jurusans for dropdown menus
        $jurusans = Jurusan::orderBy('nama_jurusan', 'asc')->get();

        return view('admin.prodis.index', compact('prodis', 'jurusansPage', 'jurusans', 'search', 'activeTab'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi',
            'jurusan_id' => 'required|exists:jurusans,jurusan_id',
        ], [
            'nama_prodi.required' => 'Nama program studi wajib diisi.',
            'nama_prodi.unique' => 'Nama program studi sudah terdaftar.',
            'nama_prodi.max' => 'Nama program studi tidak boleh lebih dari 255 karakter.',
            'jurusan_id.required' => 'Jurusan wajib dipilih.',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
        ]);

        Prodi::create([
            'nama_prodi' => $request->nama_prodi,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('admin.prodis.index')
            ->with('success', 'Program Studi baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        $jurusans = \App\Models\Jurusan::orderBy('nama_jurusan', 'asc')->get();
        return view('admin.prodis.edit', compact('prodi', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255|unique:prodi,nama_prodi,' . $prodi->prodi_id . ',prodi_id',
            'jurusan_id' => 'required|exists:jurusans,jurusan_id',
        ], [
            'nama_prodi.required' => 'Nama program studi wajib diisi.',
            'nama_prodi.unique' => 'Nama program studi sudah terdaftar.',
            'nama_prodi.max' => 'Nama program studi tidak boleh lebih dari 255 karakter.',
            'jurusan_id.required' => 'Jurusan wajib dipilih.',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
        ]);

        $prodi->update([
            'nama_prodi' => $request->nama_prodi,
            'jurusan_id' => $request->jurusan_id,
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
