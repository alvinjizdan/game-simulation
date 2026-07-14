@extends('layouts.app')
@section('content')
<div style="padding: 2rem;">
    <h2>Dashboard Teknisi</h2>
    <p style="color: #94a3b8;">Selamat datang, {{ Auth::user()->username }}! Di sini Anda dapat melihat riwayat simulasi yang pernah Anda buat.</p>

    <div style="display: flex; gap: 15px; margin-bottom: 20px;">
        <a href="{{ route('simulasi.index') }}" class="btn">Buat Simulasi Baru</a>
        <a href="{{ route('katalog.index') }}" class="btn" style="background: var(--secondary); color: var(--bg-dark);">Lihat Katalog Perangkat</a>
    </div>

    <div style="background: var(--card-bg); padding: 1.5rem; border-radius: 8px;">
        <h3 style="margin-top: 0;">Riwayat Simulasi LPB Saya</h3>
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid #334155;">
                    <th style="padding: 10px;">ID Simulasi</th>
                    <th style="padding: 10px;">Tanggal</th>
                    <th style="padding: 10px;">Panjang (Km)</th>
                    <th style="padding: 10px;">Loss (dB)</th>
                    <th style="padding: 10px;">Rx (dBm)</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px; width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($simulasi as $sim)
                <tr style="border-bottom: 1px solid #1e293b;">
                    <td style="padding: 10px;">{{ $sim->kode_simulasi }}</td>
                    <td style="padding: 10px;">{{ $sim->created_at->format('d/m/Y H:i') }}</td>
                    <td style="padding: 10px;">{{ $sim->panjang_kabel }}</td>
                    <td style="padding: 10px;">{{ $sim->hasilKelayakan->total_loss ?? '-' }}</td>
                    <td style="padding: 10px;">{{ $sim->hasilKelayakan->daya_terima ?? '-' }}</td>
                    <td style="padding: 10px;">
                        @if(($sim->hasilKelayakan->status_link ?? '') == 'Layak')
                            <span style="color: var(--success); font-weight: bold;">Layak</span>
                        @else
                            <span style="color: var(--danger); font-weight: bold;">Tidak Layak</span>
                        @endif
                    </td>
                    <td style="padding: 10px;">
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('teknisi.simulasi.edit', $sim->id_simulasi) }}" class="btn" style="background: #eab308; padding: 5px 10px; font-size: 0.8rem; text-decoration: none; color: white;">Edit</a>
                            <form action="{{ route('teknisi.simulasi.destroy', $sim->id_simulasi) }}" method="POST" onsubmit="return confirm('Hapus riwayat simulasi ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn" style="background: #ef4444; padding: 5px 10px; font-size: 0.8rem; border: none; cursor: pointer; color: white;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($simulasi->isEmpty())
                <tr>
                    <td colspan="7" style="padding: 20px; text-align: center; color: #94a3b8;">Belum ada riwayat simulasi.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
