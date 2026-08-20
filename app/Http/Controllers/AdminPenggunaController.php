<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminPenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::paginate(5);
        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:pengguna',
            'password' => 'required|min:6',
            'role' => 'required|in:Admin,Teknisi Baru,Teknisi Senior'
        ]);

        Pengguna::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $request->validate([
            'username' => 'required|unique:pengguna,username,' . $pengguna->id_user . ',id_user',
            'role' => 'required|in:Admin,Teknisi Baru,Teknisi Senior'
        ]);

        $data = ['username' => $request->username, 'role' => $request->role];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);
        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pengguna::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}

