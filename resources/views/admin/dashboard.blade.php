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
            <a href="{{ route('admin.dashboard') }}" class="shad-link active">
                <i data-lucide="layout-dashboard"></i>
                Rapor Peserta
            </a>
            
            <div class="shad-nav-label" style="margin-top: 1.5rem;">Manajemen</div>
            <a href="{{ route('admin.peserta') }}" class="shad-link">
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
                <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.25rem;">Rapor Progres Peserta</h1>
                <p style="color: var(--text-secondary); font-size: 0.875rem;">Pantau teknisi baru yang telah menyelesaikan Misi Pengenalan FTTH.</p>
            </div>
            
            <!-- Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
                <div class="glass-card" style="border-left: 4px solid var(--primary); padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Total Peserta</div>
                            <div class="tabular-nums" style="font-size: 2rem; font-weight: 700;">{{ $totalPeserta }}</div>
                        </div>
                        <i data-lucide="users" style="color: var(--primary);"></i>
                    </div>
                </div>

                <div class="glass-card" style="border-left: 4px solid var(--success); padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Misi Selesai</div>
                            <div class="tabular-nums" style="font-size: 2rem; font-weight: 700;">{{ $selesai }}</div>
                        </div>
                        <i data-lucide="check-circle" style="color: var(--success);"></i>
                    </div>
                </div>

                <div class="glass-card" style="border-left: 4px solid var(--danger); padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div style="color: var(--text-secondary); font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Belum Selesai</div>
                            <div class="tabular-nums" style="font-size: 2rem; font-weight: 700;">{{ $belumSelesai }}</div>
                        </div>
                        <i data-lucide="alert-circle" style="color: var(--danger);"></i>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="glass-card" style="padding: 0; overflow: hidden;">
                <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-glass);">
                    <h3 style="font-size: 1.125rem; font-weight: 600;">Detail Progres Peserta</h3>
                </div>
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Peserta</th>
                                <th>OLT</th>
                                <th>ODC</th>
                                <th>ODP</th>
                                <th>ONT</th>
                                <th>Splicing</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peserta as $p)
                            <tr>
                                <td style="font-weight: 500; color: var(--text-primary);">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div style="width: 24px; height: 24px; background: rgba(255,255,255,0.1); border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem;">
                                            {{ strtoupper(substr($p->username, 0, 1)) }}
                                        </div>
                                        {{ $p->nama_lengkap ?? $p->username }}
                                    </div>
                                </td>
                                @php $moduls = ['OLT', 'ODC', 'ODP', 'ONT', 'Splicing']; @endphp
                                @foreach($moduls as $m)
                                    @php
                                        $prog = $p->progressModul->where('nama_modul', $m)->first();
                                        $status = $prog ? $prog->status_tugas : 'Belum Selesai';
                                    @endphp
                                    <td>
                                        @if($status == 'Selesai')
                                            <span class="badge badge-success" style="display: inline-flex; align-items: center; gap: 4px;">
                                                <i data-lucide="check" style="width: 12px; height: 12px;"></i> Selesai
                                            </span>
                                        @else
                                            <span class="badge badge-pending" style="display: inline-flex; align-items: center; gap: 4px; opacity: 0.5;">
                                                <i data-lucide="x" style="width: 12px; height: 12px;"></i> Belum
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- Menyembunyikan Navbar bawaan layouts.app.blade.php khusus di halaman Admin ini -->
<style>
    body > .navbar { display: none !important; }
</style>
@endsection
