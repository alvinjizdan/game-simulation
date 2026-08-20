<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SimulasiLpb;
use Illuminate\Support\Facades\Auth;

class TeknisiController extends Controller
{
    public function dashboard()
    {
        $simulasi = SimulasiLpb::with('hasilKelayakan')
            ->where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(5);
            
        return view('teknisi.dashboard', compact('simulasi'));
    }

    public function editSimulasi($id)
    {
        $simulasi = SimulasiLpb::where('id_simulasi', $id)->where('id_user', Auth::id())->firstOrFail();
        return view('teknisi.simulasi.edit', compact('simulasi'));
    }

    public function updateSimulasi(Request $request, $id)
    {
        $request->validate([
            'panjang_kabel' => 'required|numeric|min:0',
            'jumlah_splice' => 'required|integer|min:0',
            'jumlah_konektor' => 'required|integer|min:0',
            'rasio_splitter' => 'required|in:1:2,1:4,1:8,1:16',
        ]);

        $simulasi = SimulasiLpb::where('id_simulasi', $id)->where('id_user', Auth::id())->firstOrFail();
        $simulasi->update($request->only('panjang_kabel', 'jumlah_splice', 'jumlah_konektor', 'rasio_splitter'));

        // Recalculate
        $tx_power = 3.0; // dBm
        $loss_kabel = 0.35; // dB/Km
        $loss_splice = 0.1; // dB
        $loss_konektor = 0.2; // dB
        
        $splitter_losses = [
            '1:2' => 3.7, '1:4' => 7.25, '1:8' => 10.3, '1:16' => 14.1,
        ];

        $total_loss = ($request->panjang_kabel * $loss_kabel) + 
                      ($request->jumlah_splice * $loss_splice) + 
                      ($request->jumlah_konektor * $loss_konektor) + 
                      $splitter_losses[$request->rasio_splitter];

        $rx_power = $tx_power - $total_loss;
        $status = ($rx_power <= -8 && $rx_power >= -23) ? 'Layak' : 'Tidak Layak';

        $simulasi->hasilKelayakan()->update([
            'total_loss' => round($total_loss, 2),
            'daya_terima' => round($rx_power, 2),
            'status_link' => $status
        ]);

        return redirect()->route('teknisi.dashboard')->with('success', 'Riwayat simulasi berhasil diperbarui.');
    }

    public function destroySimulasi($id)
    {
        $simulasi = SimulasiLpb::where('id_simulasi', $id)->where('id_user', Auth::id())->firstOrFail();
        $simulasi->delete();
        return redirect()->route('teknisi.dashboard')->with('success', 'Riwayat simulasi berhasil dihapus.');
    }
}

