@extends('layouts.app')

@section('content')
<div class="container animate-fade-in" style="padding-top: 4rem; padding-bottom: 4rem;">
    <!-- Welcome Banner / Hero -->
    <div style="text-align: center; margin-bottom: 4rem;">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; line-height: 1.2;">
            Selamat Datang di <span class="text-gradient">Viberlink LMS</span>
        </h1>
        <p style="color: var(--text-secondary); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
            Platform pembelajaran Teknisi Fiber To The Home (FTTH). Mulai asah kemampuan instalasi jaringan Anda hari ini.
        </p>
    </div>

    @auth
        @if(Auth::user()->role === 'Peserta')
            <!-- Progress Summary Card -->
            <div class="glass-card" style="margin-bottom: 3rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                <div>
                    <h3 style="margin-bottom: 0.5rem;">Progres Pembelajaran Anda</h3>
                    <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem;">Selesaikan seluruh modul materi, kuis, dan simulasi game untuk lulus.</p>
                </div>
                <div style="display: flex; gap: 30px;">
                    <div style="text-align: center;">
                        <div class="tabular-nums text-gradient" style="font-size: 2.5rem; font-weight: 800; line-height: 1;">{{ $progressModul->where('status_tugas', 'Selesai')->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Modul Selesai</div>
                    </div>
                    <div style="text-align: center;">
                        <div class="tabular-nums" style="font-size: 2.5rem; font-weight: 800; line-height: 1; color: var(--text-primary);">5</div>
                        <div style="color: var(--text-secondary); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Total Modul</div>
                    </div>
                </div>
            </div>

            <!-- Bento Grid untuk Modul -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                @foreach($progressModul as $mod)
                <a href="{{ route('peserta.modul.detail', strtolower($mod->nama_modul == 'Splicing' ? 'kabel' : $mod->nama_modul)) }}" class="glass-card" style="display: flex; flex-direction: column; text-decoration: none; position: relative; overflow: hidden;">
                    <!-- Highlight atas jika selesai -->
                    @if($mod->status_tugas == 'Selesai')
                        <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--success); box-shadow: 0 0 10px var(--success-glow);"></div>
                    @endif

                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                        <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-glass); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            @if($mod->nama_modul == 'OLT') <i data-lucide="server" style="width: 36px; height: 36px;"></i>
                            @elseif($mod->nama_modul == 'ODC') <i data-lucide="database" style="width: 36px; height: 36px;"></i>
                            @elseif($mod->nama_modul == 'ODP') <i data-lucide="box" style="width: 36px; height: 36px;"></i>
                            @elseif($mod->nama_modul == 'ONT') <i data-lucide="router" style="width: 36px; height: 36px;"></i>
                            @else <i data-lucide="zap" style="width: 36px; height: 36px;"></i> @endif
                        </div>
                        <div>
                            @if($mod->status_tugas == 'Selesai')
                                <span class="badge badge-success">Selesai</span>
                            @else
                                <span class="badge badge-pending">Belum Selesai</span>
                            @endif
                        </div>
                    </div>
                    <h3 style="color: var(--text-primary); margin-bottom: 0.5rem; font-size: 1.25rem;">Modul {{ $mod->nama_modul }}</h3>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0; flex-grow: 1;">
                        Pelajari materi, kerjakan kuis, dan simulasi jaringan {{ $mod->nama_modul }}.
                    </p>
                    <div style="margin-top: 1.5rem; color: var(--primary); font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 5px;">
                        Mulai Belajar <span>&rarr;</span>
                    </div>
                </a>
                @endforeach
            </div>
        @elseif(Auth::user()->role === 'Admin')
            <div class="glass-card" style="text-align: center; max-width: 500px; margin: 0 auto;">
                <h3 style="margin-bottom: 1rem;">Selamat datang, Admin!</h3>
                <p style="color: var(--text-secondary); margin-bottom: 2rem;">Silakan menuju Ruang Admin untuk mengelola data peserta, kuis, dan materi pembelajaran.</p>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Masuk ke Ruang Admin</a>
            </div>
        @endif
    @else
        <!-- Guest View -->
        <div style="text-align: center;">
            <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 1rem 2.5rem; font-size: 1.1rem; border-radius: var(--radius-full);">
                Mulai Pembelajaran
            </a>
        </div>
    @endauth
</div>
@endsection
