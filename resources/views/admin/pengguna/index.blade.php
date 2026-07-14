@extends('layouts.app')
@section('content')
<div style="display: flex; flex: 1;">
    <!-- Sidebar -->
    <div style="width: 250px; background: var(--navy); padding: 2rem; color: white;">
        <h3 style="margin-top: 0; color: white;">Admin Dashboard</h3>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.dashboard') }}" style="color: #94a3b8; text-decoration: none;">Dashboard</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.pengguna') }}" style="color: white; text-decoration: none;">Kelola Pengguna</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.perangkat') }}" style="color: #94a3b8; text-decoration: none;">Katalog Perangkat</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.materi') }}" style="color: #94a3b8; text-decoration: none;">Materi & Media</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div style="flex: 1; padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Kelola Pengguna & Teknisi</h2>
            <button onclick="document.getElementById('modalTambah').style.display='flex'" class="btn">+ Tambah Pengguna</button>
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
                <h3 style="margin-top: 0;">Tambah Pengguna Baru</h3>
                <form action="{{ route('admin.pengguna.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                    @csrf
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Username</label>
                        <input type="text" name="username" style="width: 100%;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Password</label>
                        <input type="password" name="password" style="width: 100%;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Role</label>
                        <select name="role" style="width: 100%;" required>
                            <option value="Admin">Admin</option>
                            <option value="Teknisi Baru">Teknisi Baru</option>
                            <option value="Teknisi Senior">Teknisi Senior</option>
                        </select>
                    </div>
                    <div style="text-align: right; margin-top: 10px;">
                        <button type="submit" class="btn">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="admin-card">
            <h3>Daftar Pengguna</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid #334155;">
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">Username</th>
                        <th style="padding: 10px;">Role</th>
                        <th style="padding: 10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengguna as $p)
                    <tr style="border-bottom: 1px solid #1e293b;">
                        <td style="padding: 10px;">{{ $p->id_user }}</td>
                        <td style="padding: 10px;">{{ $p->username }}</td>
                        <td style="padding: 10px;">{{ $p->role }}</td>
                        <td style="padding: 10px;">
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('admin.pengguna.edit', $p->id_user) }}" class="btn" style="background: #eab308; padding: 5px 10px; font-size: 0.8rem; text-decoration: none; color: white;">Edit</a>
                                <form action="{{ route('admin.pengguna.destroy', $p->id_user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');">
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
    </div>
</div>
@endsection
