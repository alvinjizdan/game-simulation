@extends('layouts.app')
@section('content')
<div style="display: flex; flex: 1;">
    <!-- Sidebar -->
    <div style="width: 250px; background: var(--navy); padding: 2rem; color: white;">
        <h3 style="margin-top: 0; color: white;">Admin Dashboard</h3>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.dashboard') }}" style="color: white; text-decoration: none;">Dashboard</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.pengguna') }}" style="color: #94a3b8; text-decoration: none;">Kelola Pengguna</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.perangkat') }}" style="color: #94a3b8; text-decoration: none;">Katalog Perangkat</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.materi') }}" style="color: #94a3b8; text-decoration: none;">Materi & Media</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div style="flex: 1; padding: 2rem;">
        <div style="display: flex; align-items: center; margin-bottom: 20px; gap: 15px;">
            <a href="{{ route('admin.dashboard') }}" class="btn" style="background: #64748b;">&larr; Kembali</a>
            <h2 style="margin: 0;">Edit Riwayat Simulasi</h2>
        </div>

        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #ef4444;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-card" style="max-width: 600px;">
            <form action="{{ route('admin.simulasi.update', $simulasi->id_simulasi) }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                @csrf @method('PUT')
                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Panjang Kabel (Km)</label>
                        <input type="number" step="0.01" name="panjang_kabel" value="{{ old('panjang_kabel', $simulasi->panjang_kabel) }}" style="width: 100%;" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Rasio Splitter</label>
                        <select name="rasio_splitter" style="width: 100%;" required>
                            <option value="1:2" {{ $simulasi->rasio_splitter === '1:2' ? 'selected' : '' }}>1:2</option>
                            <option value="1:4" {{ $simulasi->rasio_splitter === '1:4' ? 'selected' : '' }}>1:4</option>
                            <option value="1:8" {{ $simulasi->rasio_splitter === '1:8' ? 'selected' : '' }}>1:8</option>
                            <option value="1:16" {{ $simulasi->rasio_splitter === '1:16' ? 'selected' : '' }}>1:16</option>
                        </select>
                    </div>
                </div>
                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Jumlah Splice</label>
                        <input type="number" name="jumlah_splice" value="{{ old('jumlah_splice', $simulasi->jumlah_splice) }}" style="width: 100%;" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Jumlah Konektor</label>
                        <input type="number" name="jumlah_konektor" value="{{ old('jumlah_konektor', $simulasi->jumlah_konektor) }}" style="width: 100%;" required>
                    </div>
                </div>
                
                <div style="background: rgba(15, 23, 42, 0.05); padding: 15px; border-radius: 6px; margin-top: 10px;">
                    <small style="color: #64748b;">Mengeklik tombol update akan otomatis menghitung ulang Total Loss, Daya Terima (Rx), dan Status Kelayakan.</small>
                </div>
                
                <div style="text-align: right; margin-top: 10px;">
                    <button type="submit" class="btn">Update Simulasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
