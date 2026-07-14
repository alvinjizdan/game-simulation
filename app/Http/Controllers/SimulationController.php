<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimulasiLpb;
use App\Models\HasilKelayakan;
use Illuminate\Support\Str;

class SimulationController extends Controller
{
    public function index() {
        return view('simulasi.index');
    }

    public function calculate(Request $request) {
        $request->validate([
            'panjang_kabel' => 'required|numeric|min:0',
            'jumlah_splice' => 'required|integer|min:0',
            'jumlah_konektor' => 'required|integer|min:0',
            'rasio_splitter' => 'required|in:1:2,1:4,1:8,1:16',
        ]);

        $tx_power = 3.0; // dBm as assumed Tx
        $loss_kabel = 0.35; // dB/Km
        $loss_splice = 0.1; // dB
        $loss_konektor = 0.2; // dB
        
        $splitter_losses = [
            '1:2' => 3.7, '1:4' => 7.25, '1:8' => 10.3, '1:16' => 14.1,
        ];

        // Total Loss = (panjang_kabel * 0.35) + (jumlah_splice * 0.1) + (jumlah_konektor * 0.2) + loss_splitter
        $total_loss = ($request->panjang_kabel * $loss_kabel) + 
                      ($request->jumlah_splice * $loss_splice) + 
                      ($request->jumlah_konektor * $loss_konektor) + 
                      $splitter_losses[$request->rasio_splitter];

        // Daya Terima (Rx) = Tx - Total Loss
        $rx_power = $tx_power - $total_loss;

        // Status Kelayakan: -8 dBm s/d -23 dBm = Layak
        $status = ($rx_power <= -8 && $rx_power >= -23) ? 'Layak' : 'Tidak Layak';

        $simulasi = SimulasiLpb::create([
            'id_user' => auth()->id() ?? null,
            'kode_simulasi' => 'SIM-' . strtoupper(Str::random(6)),
            'panjang_kabel' => $request->panjang_kabel,
            'jumlah_splice' => $request->jumlah_splice,
            'jumlah_konektor' => $request->jumlah_konektor,
            'rasio_splitter' => $request->rasio_splitter,
        ]);

        $hasil = HasilKelayakan::create([
            'id_simulasi' => $simulasi->id_simulasi,
            'total_loss' => round($total_loss, 2),
            'daya_terima' => round($rx_power, 2),
            'status_link' => $status
        ]);

        return response()->json([
            'success' => true,
            'kode_simulasi' => $simulasi->kode_simulasi,
            'data' => $hasil
        ]);
    }
}
