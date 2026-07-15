<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusans,nama_jurusan',
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
            'nama_jurusan.unique' => 'Nama jurusan sudah terdaftar.',
            'nama_jurusan.max' => 'Nama jurusan tidak boleh lebih dari 255 karakter.',
        ]);

        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('admin.prodis.index', ['tab' => 'jurusan'])
            ->with('success', 'Jurusan baru berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusans.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusans,nama_jurusan,' . $jurusan->jurusan_id . ',jurusan_id',
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
            'nama_jurusan.unique' => 'Nama jurusan sudah terdaftar.',
            'nama_jurusan.max' => 'Nama jurusan tidak boleh lebih dari 255 karakter.',
        ]);

        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('admin.prodis.index', ['tab' => 'jurusan'])
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        // Cek apakah ada prodi yang masih terhubung dengan jurusan ini
        $prodiCount = $jurusan->prodis()->count();

        if ($prodiCount > 0) {
            return redirect()->route('admin.prodis.index', ['tab' => 'jurusan'])
                ->with('error', 'Jurusan tidak dapat dihapus karena masih memiliki program studi terdaftar.');
        }

        $jurusan->delete();

        return redirect()->route('admin.prodis.index', ['tab' => 'jurusan'])
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}
