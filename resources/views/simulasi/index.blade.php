@extends('layouts.app')
@section('content')
<div class="sim-container">
    <h2 style="text-align: center;">Ruang Simulasi LPB</h2>
    <p style="text-align: center; color: #94a3b8;">Asumsi Output Tx OLT = +3 dBm</p>
    
    <form id="simForm">
        <div class="form-group">
            <label>Panjang Lintasan Kabel (Km) - <i>0.35 dB/km</i></label>
            <input type="number" step="0.01" name="panjang_kabel" required>
        </div>
        <div class="form-group">
            <label>Pengukur Titik Sambungan (Splice) - <i>0.1 dB/titik</i></label>
            <input type="number" name="jumlah_splice" required>
        </div>
        <div class="form-group">
            <label>Penghitung Sambungan Mekanis (Konektor) - <i>0.2 dB/titik</i></label>
            <input type="number" name="jumlah_konektor" required>
        </div>
        <div class="form-group">
            <label>Selector Rasio Pembagi (Splitter)</label>
            <select name="rasio_splitter" required>
                <option value="1:2">1:2 (3.7 dB)</option>
                <option value="1:4">1:4 (7.25 dB)</option>
                <option value="1:8">1:8 (10.3 dB)</option>
                <option value="1:16">1:16 (14.1 dB)</option>
            </select>
        </div>
        <button type="submit" class="btn" style="width: 100%;">Hitung Kelayakan</button>
    </form>
    <div id="resultBox" class="result-box"></div>
</div>
@endsection
