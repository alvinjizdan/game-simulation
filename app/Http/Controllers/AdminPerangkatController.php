<?php

namespace App\Http\Controllers;

use App\Models\PerangkatFtth;
use Illuminate\Http\Request;

class AdminPerangkatController extends Controller
{
    public function index()
    {
        $perangkat = PerangkatFtth::all();
        return view('admin.perangkat.index', compact('perangkat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perangkat' => 'required',
            'jenis_perangkat' => 'required',
            'loss_default' => 'required|numeric',
        ]);

        PerangkatFtth::create($request->all());
        return redirect()->back()->with('success', 'Perangkat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $perangkat = PerangkatFtth::findOrFail($id);
        return view('admin.perangkat.edit', compact('perangkat'));
    }

    public function update(Request $request, $id)
    {
        $perangkat = PerangkatFtth::findOrFail($id);
        $request->validate([
            'nama_perangkat' => 'required',
            'jenis_perangkat' => 'required',
            'loss_default' => 'required|numeric',
        ]);

        $perangkat->update($request->all());
        return redirect()->route('admin.perangkat')->with('success', 'Perangkat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        PerangkatFtth::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Perangkat berhasil dihapus.');
    }
}
