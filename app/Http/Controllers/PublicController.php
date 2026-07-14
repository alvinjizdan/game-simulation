<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimulasiLpb;

class PublicController extends Controller
{
    public function trackSimulation(Request $request)
    {
        $request->validate([
            'kode_simulasi' => 'required|string'
        ]);

        $simulasi = SimulasiLpb::with('hasilKelayakan')->where('kode_simulasi', $request->kode_simulasi)->first();

        if ($simulasi) {
            return response()->json([
                'success' => true,
                'data' => $simulasi
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Simulasi tidak ditemukan.'
        ]);
    }
}
