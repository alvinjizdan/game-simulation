<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\KategoriMateri;
use Illuminate\Http\Request;

class AdminMateriController extends Controller
{
    public function index()
    {
        $materi = Materi::with('kategori')->get();
        $kategori = KategoriMateri::all();
        return view('admin.materi.index', compact('materi', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi_materi' => 'required',
            'kategori_id' => 'required|exists:kategori_materi,id',
        ]);

        Materi::create($request->all());
        return redirect()->back()->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        $kategori = KategoriMateri::all();
        return view('admin.materi.edit', compact('materi', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);
        $request->validate([
            'judul' => 'required',
            'isi_materi' => 'required',
            'kategori_id' => 'required|exists:kategori_materi,id',
        ]);

        $materi->update($request->all());
        return redirect()->route('admin.materi')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Materi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Materi berhasil dihapus.');
    }
}
