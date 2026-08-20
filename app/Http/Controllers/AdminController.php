<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\ProgressModul;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Rapor Peserta Aggregates
        $totalPeserta = Pengguna::where('role', 'Peserta')->count();
        
        // Count users who have exactly 5 progress records marked as 'Selesai'
        $selesai = Pengguna::where('role', 'Peserta')->whereHas('progressModul', function($q) {
            $q->where('status_tugas', 'Selesai');
        }, '=', 5)->count();
        
        $belumSelesai = $totalPeserta - $selesai;

        // Paginated data for table
        $peserta = Pengguna::where('role', 'Peserta')->with('progressModul')->paginate(5);

        return view('admin.dashboard', compact('peserta', 'totalPeserta', 'selesai', 'belumSelesai'));
    }

    public function indexPeserta()
    {
        $peserta = Pengguna::where('role', 'Peserta')->paginate(5);
        return view('admin.peserta.index', compact('peserta'));
    }

    public function storePeserta(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:pengguna',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string',
        ]);

        $user = Pengguna::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'role' => 'Peserta'
        ]);

        // Beri tugas default 5 modul
        $moduls = ['OLT', 'ODC', 'ODP', 'ONT', 'Splicing'];
        foreach ($moduls as $modul) {
            ProgressModul::create([
                'id_user' => $user->id_user,
                'nama_modul' => $modul
            ]);
        }

        return redirect()->route('admin.peserta')->with('success', 'Peserta berhasil ditambahkan');
    }

    public function editPeserta($id)
    {
        $peserta = Pengguna::where('id_user', $id)->where('role', 'Peserta')->firstOrFail();
        return view('admin.peserta.edit', compact('peserta'));
    }

    public function updatePeserta(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|unique:pengguna,username,'.$id.',id_user',
            'nama_lengkap' => 'required|string',
        ]);

        $peserta = Pengguna::where('id_user', $id)->where('role', 'Peserta')->firstOrFail();
        $data = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $peserta->update($data);

        return redirect()->route('admin.peserta')->with('success', 'Data peserta berhasil diubah');
    }

    public function destroyPeserta($id)
    {
        Pengguna::where('id_user', $id)->where('role', 'Peserta')->firstOrFail()->delete();
        return redirect()->route('admin.peserta')->with('success', 'Peserta berhasil dihapus');
    }

    public function resetProgress($id)
    {
        ProgressModul::where('id_user', $id)->update(['status_tugas' => 'Belum Selesai']);
        return redirect()->back()->with('success', 'Progres misi peserta berhasil di-reset menjadi 0/5');
    }
}

