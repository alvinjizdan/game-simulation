@extends('layouts.app')

@section('content')
<div style="display: flex; flex: 1;">
    <!-- Sidebar -->
    <div style="width: 250px; background: var(--navy); padding: 2rem; color: white;">
        <h3 style="margin-top: 0; color: white;">Ruang Admin</h3>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.dashboard') }}" style="color: #94a3b8; text-decoration: none;">Rapor Peserta (Dashboard)</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.peserta') }}" style="color: white; text-decoration: none;">Kelola Peserta</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div style="flex: 1; padding: 2rem;">
        <h2 style="margin-top: 0;">Kelola Peserta (Teknisi Baru)</h2>

        @if(session('success'))
            <div style="background: rgba(34, 197, 94, 0.1); color: var(--success); padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid var(--success);">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #ef4444;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="display: flex; gap: 20px; align-items: flex-start;">
            <!-- Tabel Daftar Peserta -->
            <div class="admin-card" style="flex: 2; padding: 1.5rem;">
                <h3 style="margin-top: 0;">Daftar Akun Peserta</h3>
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 10px;">Nama Lengkap</th>
                            <th style="padding: 10px;">Username</th>
                            <th style="padding: 10px; width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peserta as $p)
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 10px;">{{ $p->nama_lengkap }}</td>
                            <td style="padding: 10px;">{{ $p->username }}</td>
                            <td style="padding: 10px;">
                                <div style="display: flex; gap: 5px;">
                                    <a href="{{ route('admin.peserta.edit', $p->id_user) }}" class="btn" style="background: #eab308; padding: 5px 10px; font-size: 0.8rem; text-decoration: none; color: white;">Edit</a>
                                    <form action="{{ route('admin.peserta.destroy', $p->id_user) }}" method="POST" onsubmit="return confirm('Hapus peserta ini? Seluruh progres tugasnya akan hilang.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn" style="background: #ef4444; padding: 5px 10px; font-size: 0.8rem; border: none; cursor: pointer; color: white;">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @if($peserta->isEmpty())
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 20px; color: #94a3b8;">Belum ada akun peserta.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Form Tambah Peserta -->
            <div class="admin-card" style="flex: 1; padding: 1.5rem; background: var(--bg-light); border: 1px solid #cbd5e1;">
                <h3 style="margin-top: 0; border-bottom: 2px solid var(--primary); padding-bottom: 10px;">Daftarkan Peserta Baru</h3>
                <form action="{{ route('admin.peserta.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                    @csrf
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" style="width: 100%;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Username (Untuk Login)</label>
                        <input type="text" name="username" value="{{ old('username') }}" style="width: 100%;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Password Sementara</label>
                        <input type="password" name="password" style="width: 100%;" required>
                        <small style="color: #64748b;">Minimal 6 karakter.</small>
                    </div>
                    
                    <button type="submit" class="btn" style="margin-top: 10px;">Buat Akun Peserta</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
