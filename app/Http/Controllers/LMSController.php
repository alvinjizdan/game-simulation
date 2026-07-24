<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Kuis;
use App\Models\NilaiKuis;
use App\Models\ProgressModul;
use Illuminate\Support\Facades\Auth;

class LMSController extends Controller
{
    public function detailModul($nama_modul)
    {
        $nama_modul = strtoupper($nama_modul);
        if ($nama_modul == 'KABEL' || $nama_modul == 'SPLICING') {
            $nama_modul = 'Splicing';
        }

        $materiCount = Materi::where('nama_modul', $nama_modul)->count();
        $kuisCount = Kuis::where('nama_modul', $nama_modul)->count();
        $nilai = NilaiKuis::where('id_user', Auth::user()->id_user)->where('nama_modul', $nama_modul)->first();
        
        $progress = ProgressModul::firstOrCreate(
            ['id_user' => Auth::user()->id_user, 'nama_modul' => $nama_modul]
        );

        return view('peserta.lms.detail', compact('nama_modul', 'materiCount', 'kuisCount', 'nilai', 'progress'));
    }

    public function bacaMateri($nama_modul)
    {
        $nama_modul = strtoupper($nama_modul);
        if ($nama_modul == 'KABEL' || $nama_modul == 'SPLICING') {
            $nama_modul = 'Splicing';
        }

        $materi = Materi::where('nama_modul', $nama_modul)->orderBy('urutan')->get();
        return view('peserta.lms.materi', compact('nama_modul', 'materi'));
    }

    public function kerjakanKuis($nama_modul)
    {
        $nama_modul = strtoupper($nama_modul);
        if ($nama_modul == 'KABEL' || $nama_modul == 'SPLICING') {
            $nama_modul = 'Splicing';
        }

        $kuis = Kuis::where('nama_modul', $nama_modul)->get();
        if ($kuis->isEmpty()) {
            return redirect()->route('peserta.modul.detail', strtolower($nama_modul))->with('error', 'Kuis untuk modul ini belum tersedia.');
        }

        return view('peserta.lms.kuis', compact('nama_modul', 'kuis'));
    }

    public function submitKuis(Request $request, $nama_modul)
    {
        $nama_modul = strtoupper($nama_modul);
        if ($nama_modul == 'KABEL' || $nama_modul == 'SPLICING') {
            $nama_modul = 'Splicing';
        }

        $kuis = Kuis::where('nama_modul', $nama_modul)->get();
        $benar = 0;
        $total = $kuis->count();

        foreach ($kuis as $q) {
            $jawabanUser = $request->input('jawaban_' . $q->id_kuis);
            if ($jawabanUser == $q->jawaban_benar) {
                $benar++;
            }
        }

        $skor = $total > 0 ? round(($benar / $total) * 100) : 0;

        $nilaiKuis = NilaiKuis::firstOrCreate(
            ['id_user' => Auth::user()->id_user, 'nama_modul' => $nama_modul]
        );

        if ($skor > $nilaiKuis->skor_tertinggi) {
            $nilaiKuis->update(['skor_tertinggi' => $skor]);
        }

        return redirect()->route('peserta.modul.detail', strtolower($nama_modul))
                         ->with('success', "Kuis selesai! Skor Anda: $skor (Benar $benar dari $total).");
    }
}
