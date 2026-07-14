@extends('layouts.app')
@section('content')
<div style="display: flex; flex: 1;">
    <!-- Sidebar -->
    <div style="width: 250px; background: var(--navy); padding: 2rem; color: white;">
        <h3 style="margin-top: 0; color: white;">Admin Dashboard</h3>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.dashboard') }}" style="color: #94a3b8; text-decoration: none;">Dashboard</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.pengguna') }}" style="color: #94a3b8; text-decoration: none;">Kelola Pengguna</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.perangkat') }}" style="color: white; text-decoration: none;">Katalog Perangkat</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.materi') }}" style="color: #94a3b8; text-decoration: none;">Materi & Media</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div style="flex: 1; padding: 2rem;">
        <div style="display: flex; align-items: center; margin-bottom: 20px; gap: 15px;">
            <a href="{{ route('admin.perangkat') }}" class="btn" style="background: #64748b;">&larr; Kembali</a>
            <h2 style="margin: 0;">Edit Perangkat</h2>
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
            <form action="{{ route('admin.perangkat.update', $perangkat->id_perangkat) }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                @csrf @method('PUT')
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Nama Perangkat</label>
                    <input type="text" name="nama_perangkat" value="{{ old('nama_perangkat', $perangkat->nama_perangkat) }}" style="width: 100%;" required>
                </div>
                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Jenis Perangkat</label>
                        <select name="jenis_perangkat" style="width: 100%;" required>
                            <option value="Kabel Feeder" {{ $perangkat->jenis_perangkat === 'Kabel Feeder' ? 'selected' : '' }}>Kabel Feeder</option>
                            <option value="ODC" {{ $perangkat->jenis_perangkat === 'ODC' ? 'selected' : '' }}>ODC</option>
                            <option value="ODP" {{ $perangkat->jenis_perangkat === 'ODP' ? 'selected' : '' }}>ODP</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Loss Default (dB)</label>
                        <input type="number" step="0.01" name="loss_default" value="{{ old('loss_default', $perangkat->loss_default) }}" style="width: 100%;" required>
                    </div>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Deskripsi Fungsi</label>
                    <textarea name="deskripsi_fungsi" rows="3" style="width: 100%;">{{ old('deskripsi_fungsi', $perangkat->deskripsi_fungsi) }}</textarea>
                </div>
                <div style="text-align: right; margin-top: 10px;">
                    <button type="submit" class="btn">Update Perangkat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
