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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Katalog Perangkat FTTH</h2>
            <button onclick="document.getElementById('modalTambah').style.display='flex'" class="btn">+ Tambah Perangkat</button>
        </div>
        
        @if(session('success'))
            <div style="background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #22c55e;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Modal Tambah Data -->
        <div id="modalTambah" class="modal">
            <div class="modal-content">
                <button onclick="document.getElementById('modalTambah').style.display='none'" class="close-modal">&times;</button>
                <h3 style="margin-top: 0;">Tambah Perangkat Baru</h3>
                <form action="{{ route('admin.perangkat.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                    @csrf
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Nama Perangkat</label>
                        <input type="text" name="nama_perangkat" style="width: 100%;" required>
                    </div>
                    <div style="display: flex; gap: 15px;">
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Jenis Perangkat</label>
                            <select name="jenis_perangkat" style="width: 100%;" required>
                                <option value="Kabel Feeder">Kabel Feeder</option>
                                <option value="ODC">ODC</option>
                                <option value="ODP">ODP</option>
                            </select>
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Loss Default (dB)</label>
                            <input type="number" step="0.01" name="loss_default" value="0" style="width: 100%;" required>
                        </div>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Deskripsi Fungsi</label>
                        <textarea name="deskripsi_fungsi" rows="3" style="width: 100%;"></textarea>
                    </div>
                    <div style="text-align: right; margin-top: 10px;">
                        <button type="submit" class="btn">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="admin-card">
            <h3>Daftar Perangkat</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid #334155;">
                        <th style="padding: 10px;">Nama</th>
                        <th style="padding: 10px;">Jenis</th>
                        <th style="padding: 10px;">Loss (dB)</th>
                        <th style="padding: 10px;">Deskripsi</th>
                        <th style="padding: 10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($perangkat as $p)
                    <tr style="border-bottom: 1px solid #1e293b;">
                        <td style="padding: 10px;">{{ $p->nama_perangkat }}</td>
                        <td style="padding: 10px;">{{ $p->jenis_perangkat }}</td>
                        <td style="padding: 10px;">{{ $p->loss_default }}</td>
                        <td style="padding: 10px;">{{ \Illuminate\Support\Str::limit($p->deskripsi_fungsi, 50) }}</td>
                        <td style="padding: 10px;">
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('admin.perangkat.edit', $p->id_perangkat) }}" class="btn" style="background: #eab308; padding: 5px 10px; font-size: 0.8rem; text-decoration: none; color: white;">Edit</a>
                                <form action="{{ route('admin.perangkat.destroy', $p->id_perangkat) }}" method="POST" onsubmit="return confirm('Hapus perangkat ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn" style="background: #ef4444; padding: 5px 10px; font-size: 0.8rem;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                </div>
                <div style="padding: 1rem; border-top: 1px solid var(--border-glass);">
                    {{ $perangkat->links('pagination::bootstrap-5') }}
                </div>
        </div>
    </div>
</div>
@endsection

