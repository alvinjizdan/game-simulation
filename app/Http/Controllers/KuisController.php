<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use Illuminate\Http\Request;

class KuisController extends Controller
{
    public function index()
    {
        $kuis = Kuis::orderBy('nama_modul')->paginate(5);
        return view('admin.kuis.index', compact('kuis'));
    }

    public function create()
    {
        return view('admin.kuis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_modul' => 'required|in:OLT,ODC,ODP,ONT,Splicing',
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D'
        ]);

        Kuis::create($request->all());

        return redirect()->route('admin.kuis.index')->with('success', 'Soal Kuis berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kuis = Kuis::findOrFail($id);
        return view('admin.kuis.edit', compact('kuis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_modul' => 'required|in:OLT,ODC,ODP,ONT,Splicing',
            'pertanyaan' => 'required|string',
            'opsi_a' => 'required|string',
            'opsi_b' => 'required|string',
            'opsi_c' => 'required|string',
            'opsi_d' => 'required|string',
            'jawaban_benar' => 'required|in:A,B,C,D'
        ]);

        $kuis = Kuis::findOrFail($id);
        $kuis->update($request->all());

        return redirect()->route('admin.kuis.index')->with('success', 'Soal Kuis berhasil diupdate');
    }

    public function destroy($id)
    {
        $kuis = Kuis::findOrFail($id);
        $kuis->delete();
        return redirect()->route('admin.kuis.index')->with('success', 'Soal Kuis berhasil dihapus');
    }
}

