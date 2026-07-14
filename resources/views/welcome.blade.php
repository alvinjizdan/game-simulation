@extends('layouts.app')

@section('content')
<style>
    .hero-section {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 20px;
        color: #f8fafc;
    }

    .hero-title { font-size: 3rem; font-weight: 800; color: #38bdf8; margin-bottom: 20px; text-shadow: 0 4px 15px rgba(56, 189, 248, 0.4); }
    .hero-subtitle { font-size: 1.2rem; color: #94a3b8; max-width: 600px; margin-bottom: 40px; line-height: 1.6; }

    /* Dashboard Style */
    .dashboard-container { width: 100%; max-width: 900px; background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    .progress-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #334155; padding-bottom: 15px; }
    
    .progress-bar-bg { width: 100%; height: 20px; background: #0f172a; border-radius: 10px; overflow: hidden; margin-bottom: 30px; border: 1px solid #334155; }
    .progress-bar-fill { height: 100%; background: linear-gradient(90deg, #38bdf8, #22c55e); transition: width 1s ease; }

    .module-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
    .module-card { background: #0f172a; border: 2px solid #475569; border-radius: 8px; padding: 15px; text-align: center; transition: 0.3s; text-decoration: none; display: flex; flex-direction: column; justify-content: center; min-height: 120px; }
    .module-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); border-color: #38bdf8; }
    .module-card.completed { border-color: #22c55e; background: #064e3b; }
    .module-card.completed:hover { border-color: #4ade80; box-shadow: 0 10px 20px rgba(34, 197, 94, 0.2); }
    
    .mod-icon { font-size: 2em; margin-bottom: 10px; }
    .mod-title { font-weight: bold; color: white; font-size: 1.1em; }
    .mod-status { font-size: 0.8em; color: #94a3b8; margin-top: 5px; }
    .completed .mod-status { color: #4ade80; font-weight: bold; }

    .btn-primary { background: #38bdf8; color: #0f172a; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 1.1rem; transition: 0.3s; display: inline-block; }
    .btn-primary:hover { background: #7dd3fc; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(56, 189, 248, 0.3); }

    .badge-level { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 0.75em; font-weight: bold; margin-bottom: 10px; color: white; }
    .badge-beginner { background: #3b82f6; }
    .badge-intermediate { background: #f97316; }
    .badge-expert { background: #ef4444; }

</style>

<div class="hero-section">
    @auth
        @if(Auth::user()->role === 'Peserta')
            @php
                $progressModul = \App\Models\ProgressModul::where('id_user', Auth::user()->id_user)->get();
                $progressCount = $progressModul->where('status_tugas', 'Selesai')->count();
                $percentage = $progressModul->count() > 0 ? ($progressCount / $progressModul->count()) * 100 : 0;
            @endphp
            
            <div class="dashboard-container">
                <div class="progress-header">
                    <h2 style="margin: 0; color: #38bdf8;">Dashboard Progres Misi</h2>
                    <span style="font-size: 1.2em; font-weight: bold; color: #22c55e;">{{ $progressCount }} / 5 Selesai ({{ $percentage }}%)</span>
                </div>

                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $percentage }}%;"></div>
                </div>

                <div class="module-grid">
                    @foreach($progressModul as $mod)
                    <a href="{{ route('simulasi.game', strtolower($mod->nama_modul == 'Splicing' ? 'kabel' : $mod->nama_modul)) }}" class="module-card {{ $mod->status_tugas == 'Selesai' ? 'completed' : '' }}">
                        <div>
                            <span class="badge-level badge-{{ strtolower($mod->tingkat_kesulitan) }}">{{ $mod->tingkat_kesulitan }}</span>
                        </div>
                        <div class="mod-icon">
                            @if($mod->nama_modul == 'OLT') 🏢
                            @elseif($mod->nama_modul == 'ODC') 🗄️
                            @elseif($mod->nama_modul == 'ODP') 🔌
                            @elseif($mod->nama_modul == 'ONT') 🏡
                            @else ⚡ @endif
                        </div>
                        <div class="mod-title">Modul {{ $mod->nama_modul }}</div>
                        <div class="mod-status">{{ $mod->status_tugas == 'Selesai' ? '✅ Selesai' : 'Belum Dimulai' }}</div>
                    </a>
                    @endforeach
                </div>
            </div>

        @else
            <h1 class="hero-title">Selamat Datang, Administrator!</h1>
            <p class="hero-subtitle">Anda dapat mengelola akun Peserta dan memantau persentase rapor progres misi mereka melalui Ruang Admin.</p>
            <a href="{{ route('admin.dashboard') }}" class="btn-primary">Masuk ke Ruang Admin</a>
        @endif
    @else
        <h1 class="hero-title">Platform Edukasi FTTH Interaktif</h1>
        <p class="hero-subtitle">Pelajari dasar-dasar perangkat keras Fiber to the Home (FTTH) secara mendalam dengan simulasi gamifikasi praktis mulai dari Sasis OLT, Splitter ODC, ODP, hingga Instalasi Modem ONT.</p>
        <a href="{{ route('login') }}" class="btn-primary">Mulai Belajar Sekarang</a>
    @endauth
</div>
@endsection
