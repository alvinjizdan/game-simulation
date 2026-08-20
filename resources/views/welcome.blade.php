@extends('layouts.app')

@section('content')

    @auth
        @if(Auth::user()->role === 'Peserta')
            <div class="animate-fade-in" style="padding: 2rem 4rem; width: 100%;">
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

                <!-- Daftar Modul (List Vertikal) -->
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($progressModul as $mod)
                    <a href="{{ route('peserta.modul.detail', strtolower($mod->nama_modul == 'Splicing' ? 'kabel' : $mod->nama_modul)) }}" class="glass-card" style="display: flex; align-items: center; justify-content: space-between; text-decoration: none; position: relative; overflow: hidden; padding: 1.5rem; transition: var(--transition);">
                        <!-- Highlight kiri jika selesai -->
                        @if($mod->status_tugas == 'Selesai')
                            <div style="position: absolute; top: 0; left: 0; bottom: 0; width: 4px; background: var(--success); box-shadow: 0 0 10px var(--success-glow);"></div>
                        @endif

                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            <div style="background: rgba(255,255,255,0.05); width: 60px; height: 60px; border-radius: var(--radius-sm); border: 1px solid var(--border-glass); display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0;">
                                @if($mod->nama_modul == 'OLT') <i data-lucide="server" style="width: 28px; height: 28px;"></i>
                                @elseif($mod->nama_modul == 'ODC') <i data-lucide="database" style="width: 28px; height: 28px;"></i>
                                @elseif($mod->nama_modul == 'ODP') <i data-lucide="box" style="width: 28px; height: 28px;"></i>
                                @elseif($mod->nama_modul == 'ONT') <i data-lucide="router" style="width: 28px; height: 28px;"></i>
                                @else <i data-lucide="zap" style="width: 28px; height: 28px;"></i> @endif
                            </div>
                            <div>
                                <h3 style="color: var(--text-primary); margin: 0 0 0.25rem 0; font-size: 1.25rem;">Modul {{ $mod->nama_modul }}</h3>
                                <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0;">
                                    Pelajari materi, kerjakan kuis, dan simulasi jaringan {{ $mod->nama_modul }}.
                                </p>
                            </div>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            @if($mod->status_tugas == 'Selesai')
                                <span class="badge badge-success">Selesai</span>
                            @else
                                <span class="badge badge-pending">Belum Selesai</span>
                            @endif
                            <div class="btn btn-primary" style="pointer-events: none; border-radius: var(--radius-full); padding: 0.5rem 1.5rem; font-weight: 600;">
                                Mulai Belajar &rarr;
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        @endif
    @endauth

@endsection
