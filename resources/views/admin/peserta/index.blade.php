@extends('layouts.app')

@section('content')
<div class="shad-layout">
    <!-- Sidebar -->
    <aside class="shad-sidebar">
        <div class="shad-sidebar-header">
            Viberlink Admin
        </div>
        
        <div class="shad-nav-group">
            <div class="shad-nav-label">Dashboard</div>
            <a href="{{ route('admin.dashboard') }}" class="shad-link">
                <i data-lucide="layout-dashboard"></i>
                Rapor Peserta
            </a>
            
            <div class="shad-nav-label" style="margin-top: 1.5rem;">Manajemen</div>
            <a href="{{ route('admin.peserta') }}" class="shad-link active">
                <i data-lucide="users"></i>
                Kelola Peserta
            </a>
            <a href="{{ route('admin.materi.index') }}" class="shad-link">
                <i data-lucide="book-open"></i>
                Kelola Materi
            </a>
            <a href="{{ route('admin.kuis.index') }}" class="shad-link">
                <i data-lucide="check-square"></i>
                Kelola Kuis
            </a>
        </div>

        <div style="margin-top: auto; border-top: 1px solid var(--border-glass); padding-top: 1rem; display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 32px; height: 32px; background: var(--primary); border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-weight: bold; color: black; flex-shrink: 0;">
                    {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                </div>
                <div style="overflow: hidden;">
                    <div style="font-size: 0.875rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">Administrator</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                @csrf
                <button type="submit" class="btn btn-outline" style="width: 100%; border-color: rgba(239,68,68,0.5); color: var(--danger); justify-content: center; gap: 6px;">
                    <i data-lucide="log-out" style="width: 14px; height: 14px;"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="shad-main">


        <!-- Content Area -->
        <div class="shad-content animate-fade-in">
            <div style="margin-bottom: 2rem;">
                <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.25rem;">Kelola Akun Peserta</h1>
                <p style="color: var(--text-secondary); font-size: 0.875rem;">Manajemen data pengguna dan teknisi yang terdaftar di sistem.</p>
            </div>
            
            @if(session('success'))
                <div class="glass-panel" style="border-left: 4px solid var(--success); padding: 1rem; margin-bottom: 2rem; color: var(--text-primary); display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="check-circle" style="color: var(--success); width: 20px; height: 20px;"></i> {{ session('success') }}
                </div>
            @endif

            <div class="glass-card" style="padding: 0; overflow: hidden;">
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peserta as $p)
                            <tr>
                                <td style="font-weight: 500; color: var(--text-primary);">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 32px; height: 32px; background: rgba(255,255,255,0.05); border-radius: 9999px; display: flex; align-items: center; justify-content: center;">
                                            <i data-lucide="user" style="width: 16px; height: 16px; color: var(--text-secondary);"></i>
                                        </div>
                                        {{ $p->username }}
                                    </div>
                                </td>
                                <td>{{ $p->nama_lengkap ?? '-' }}</td>
                                <td>{{ $p->email ?? '-' }}</td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.peserta.reset', $p->id_user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Reset progres simulasi untuk {{ $p->username }}?');">
                                        @csrf
                                        <button type="submit" class="btn btn-outline" style="padding: 0.4rem 0.75rem; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                            <i data-lucide="rotate-ccw" style="width: 14px; height: 14px;"></i> Reset Progres
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.peserta.destroy', $p->id_user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus peserta {{ $p->username }} secara permanen?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline" style="border-color: rgba(239,68,68,0.5); color: var(--danger); padding: 0.4rem 0.75rem; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px; margin-left: 0.5rem;">
                                            <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<style>
    body > .navbar { display: none !important; }
</style>
@endsection
