@extends('layouts.app')
@section('content')
<div class="container animate-fade-in" style="padding-top: 2rem; padding-bottom: 4rem;">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.25rem;">Dashboard Teknisi</h1>
        <p style="color: var(--text-secondary); font-size: 0.95rem;">Selamat datang, {{ Auth::user()->username }}! Di sini Anda dapat melihat riwayat simulasi yang pernah Anda buat.</p>
    </div>

    <div style="display: flex; gap: 15px; margin-bottom: 2rem;">
        <a href="{{ route('simulasi.index') }}" class="btn btn-primary">Buat Simulasi Baru</a>
        <a href="{{ route('katalog.index') }}" class="btn btn-outline">Lihat Katalog Perangkat</a>
    </div>

    <div class="glass-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-glass);">
            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600;">Riwayat Simulasi LPB Saya</h3>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Simulasi</th>
                        <th>Tanggal</th>
                        <th>Panjang (Km)</th>
                        <th>Loss (dB)</th>
                        <th>Rx (dBm)</th>
                        <th>Status</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($simulasi as $sim)
                    <tr>
                        <td>{{ $sim->kode_simulasi }}</td>
                        <td>{{ $sim->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $sim->panjang_kabel }}</td>
                        <td>{{ $sim->hasilKelayakan->total_loss ?? '-' }}</td>
                        <td>{{ $sim->hasilKelayakan->daya_terima ?? '-' }}</td>
                        <td>
                            @if(($sim->hasilKelayakan->status_link ?? '') == 'Layak')
                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; background: rgba(34, 197, 94, 0.1); color: var(--success); font-size: 0.75rem; font-weight: 600;">Layak</span>
                            @else
                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; background: rgba(239, 68, 68, 0.1); color: var(--danger); font-size: 0.75rem; font-weight: 600;">Tidak Layak</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                <a href="{{ route('teknisi.simulasi.edit', $sim->id_simulasi) }}" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; height: auto;">Edit</a>
                                <form action="{{ route('teknisi.simulasi.destroy', $sim->id_simulasi) }}" method="POST" onsubmit="return confirm('Hapus riwayat simulasi ini?');" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.8rem; height: auto; color: var(--danger); border-color: rgba(239, 68, 68, 0.2);">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($simulasi->isEmpty())
                    <tr>
                        <td colspan="7" style="padding: 2rem; text-align: center; color: var(--text-secondary);">Belum ada riwayat simulasi.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div style="padding: 1rem; border-top: 1px solid var(--border-glass);">
            {{ $simulasi->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
