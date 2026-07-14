<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerangkatFtth;
use App\Models\ProgressModul;
use Illuminate\Support\Facades\Auth;

class SimulasiGameController extends Controller
{
    private $kategoriMap = [
        'olt' => 'OLT',
        'odc' => 'ODC',
        'odp' => 'ODP',
        'ont' => 'ONT',
        'kabel' => 'Splicing'
    ];

    public function index($kategori = 'olt')
    {
        $allowedKategori = array_keys($this->kategoriMap);
        if (!in_array($kategori, $allowedKategori)) {
            $kategori = 'olt';
        }
        
        $perangkat = PerangkatFtth::orderBy('urutan', 'asc')->get();
        
        $progress = null;
        if (Auth::check() && Auth::user()->role === 'Peserta') {
            $progress = ProgressModul::where('id_user', Auth::user()->id_user)
                ->where('nama_modul', $this->kategoriMap[$kategori])
                ->first();
        }

        return view('simulasi.game_' . $kategori, compact('perangkat', 'kategori', 'progress'));
    }

    public function selesaikanTugas(Request $request)
    {
        $user = Auth::user();
        $kategori = $request->input('kategori');
        $allowedKategori = array_keys($this->kategoriMap);
        
        if ($user && $user->role === 'Peserta' && in_array($kategori, $allowedKategori)) {
            $tugas = ProgressModul::where('id_user', $user->id_user)
                ->where('nama_modul', $this->kategoriMap[$kategori])
                ->first();
            
            if ($tugas) {
                $tugas->update([
                    'status_tugas' => 'Selesai'
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Modul ' . strtoupper($kategori) . ' berhasil diselesaikan!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
    }
}
