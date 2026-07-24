<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::orderBy('nama_modul')->orderBy('urutan')->get();
        return view('admin.materi.index', compact('materi'));
    }

    public function create()
    {
        return view('admin.materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_modul' => 'required|in:OLT,ODC,ODP,ONT,Splicing',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'url_video' => 'nullable|url',
            'urutan' => 'required|integer|min:1'
        ]);

        Materi::create($request->all());

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil ditambahkan');
    }

    public function edit(Materi $materi)
    {
        return view('admin.materi.edit', compact('materi'));
    }

    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'nama_modul' => 'required|in:OLT,ODC,ODP,ONT,Splicing',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'url_video' => 'nullable|url',
            'urutan' => 'required|integer|min:1'
        ]);

        $materi->update($request->all());

        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil diupdate');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();
        return redirect()->route('admin.materi.index')->with('success', 'Materi berhasil dihapus');
    }
}
