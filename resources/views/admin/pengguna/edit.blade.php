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
        <div style="display: flex; align-items: center; margin-bottom: 20px; gap: 15px;">
            <a href="{{ route('admin.pengguna') }}" class="btn" style="background: #64748b;">&larr; Kembali</a>
            <h2 style="margin: 0;">Edit Pengguna</h2>
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
            <form action="{{ route('admin.pengguna.update', $pengguna->id_user) }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                @csrf @method('PUT')
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Username</label>
                    <input type="text" name="username" value="{{ old('username', $pengguna->username) }}" style="width: 100%;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Password <small style="color: #64748b;">(Kosongkan jika tidak ingin mengubah password)</small></label>
                    <input type="password" name="password" style="width: 100%;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Role</label>
                    <select name="role" style="width: 100%;" required>
                        <option value="Admin" {{ $pengguna->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Teknisi Baru" {{ $pengguna->role === 'Teknisi Baru' ? 'selected' : '' }}>Teknisi Baru</option>
                        <option value="Teknisi Senior" {{ $pengguna->role === 'Teknisi Senior' ? 'selected' : '' }}>Teknisi Senior</option>
                    </select>
                </div>
                <div style="text-align: right; margin-top: 10px;">
                    <button type="submit" class="btn">Update Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
