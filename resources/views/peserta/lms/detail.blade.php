@extends('layouts.app')

@section('content')
<div class="animate-fade-in" style="padding: 2rem 4rem; width: 100%;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
        <div>
            <div style="color: var(--text-secondary); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem;">Modul Pembelajaran</div>
            <h1 style="margin: 0; color: var(--text-primary); font-size: 2.5rem;">Modul {{ $nama_modul }}</h1>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline" style="border-radius: var(--radius-full);">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="glass-panel" style="border-left: 4px solid var(--success); padding: 1rem; margin-bottom: 2rem; color: var(--text-primary); display: flex; align-items: center; gap: 10px;">
            <span style="color: var(--success);">✅</span> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="glass-panel" style="border-left: 4px solid var(--danger); padding: 1rem; margin-bottom: 2rem; color: var(--text-primary); display: flex; align-items: center; gap: 10px;">
            <span style="color: var(--danger);">⚠️</span> {{ session('error') }}
        </div>
    @endif

    <div style="display: flex; flex-direction: column; gap: 1rem;">
           <!-- Kartu Materi -->
        <a href="{{ route('peserta.modul.materi', strtolower($nama_modul)) }}" class="glass-card" style="display: flex; align-items: center; justify-content: space-between; text-decoration: none; position: relative; overflow: hidden; padding: 1.5rem; transition: var(--transition);">
            <div style="position: absolute; top: 0; left: 0; bottom: 0; width: 4px; background: var(--primary); box-shadow: 0 0 10px var(--primary-glow);"></div>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="background: rgba(255,255,255,0.05); width: 60px; height: 60px; border-radius: var(--radius-sm); border: 1px solid var(--border-glass); display: flex; align-items: center; justify-content: center; color: var(--primary); flex-shrink: 0;">
                    <i data-lucide="book-open" style="width: 28px; height: 28px;"></i>
                </div>
                <div>
                    <h3 style="color: var(--text-primary); margin: 0 0 0.25rem 0; font-size: 1.25rem;">Materi Pembelajaran</h3>
                    <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0;">
                        Pelajari teori dan konsep dasar mengenai {{ $nama_modul }}.
                    </p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <span class="badge badge-pending" style="white-space: nowrap; color: #f59e0b; background: rgba(245, 158, 11, 0.1);">{{ $materiCount }} TOPIK TERSEDIA</span>
                <div class="btn btn-primary" style="pointer-events: none; border-radius: var(--radius-full); padding: 0.5rem 1.5rem; font-weight: 600; white-space: nowrap;">
                    Buka Materi &rarr;
                </div>
            </div>
        </a>

        <!-- Kartu Kuis -->
        <a href="{{ route('peserta.modul.kuis', strtolower($nama_modul)) }}" class="glass-card" style="display: flex; align-items: center; justify-content: space-between; text-decoration: none; position: relative; overflow: hidden; padding: 1.5rem; transition: var(--transition);">
            <div style="position: absolute; top: 0; left: 0; bottom: 0; width: 4px; background: #f59e0b; box-shadow: 0 0 10px rgba(245, 158, 11, 0.3);"></div>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="background: rgba(255,255,255,0.05); width: 60px; height: 60px; border-radius: var(--radius-sm); border: 1px solid var(--border-glass); display: flex; align-items: center; justify-content: center; color: #f59e0b; flex-shrink: 0;">
                    <i data-lucide="file-text" style="width: 28px; height: 28px;"></i>
                </div>
                <div>
                    <h3 style="color: var(--text-primary); margin: 0 0 0.25rem 0; font-size: 1.25rem;">Kuis</h3>
                    <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0;">
                        Uji pemahaman Anda dengan {{ $kuisCount }} pertanyaan evaluasi.
                    </p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="text-align: right; white-space: nowrap;">
                    <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Skor Tertinggi</div>
                    <div class="tabular-nums" style="font-size: 1.2rem; font-weight: 800; color: var(--text-primary);">{{ $nilai->skor_tertinggi ?? 0 }} / 100</div>
                </div>
                <div class="btn btn-primary" style="pointer-events: none; border-radius: var(--radius-full); padding: 0.5rem 1.5rem; font-weight: 600; white-space: nowrap; background: #f59e0b; border-color: #f59e0b;">
                    Mulai Kuis &rarr;
                </div>
            </div>
        </a>

        <!-- Kartu Game -->
        <a href="{{ route('simulasi.game', strtolower($nama_modul == 'Splicing' ? 'kabel' : $nama_modul)) }}" class="glass-card" style="display: flex; align-items: center; justify-content: space-between; text-decoration: none; position: relative; overflow: hidden; padding: 1.5rem; transition: var(--transition);">
            <div style="position: absolute; top: 0; left: 0; bottom: 0; width: 4px; background: var(--success); box-shadow: 0 0 10px var(--success-glow);"></div>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="background: rgba(255,255,255,0.05); width: 60px; height: 60px; border-radius: var(--radius-sm); border: 1px solid var(--border-glass); display: flex; align-items: center; justify-content: center; color: var(--success); flex-shrink: 0;">
                    <i data-lucide="gamepad-2" style="width: 28px; height: 28px;"></i>
                </div>
                <div>
                    <h3 style="color: var(--text-primary); margin: 0 0 0.25rem 0; font-size: 1.25rem;">Simulasi Praktik</h3>
                    <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0;">
                        Lakukan simulasi instalasi jaringan nyata untuk modul ini.
                    </p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                @if($progress->status_tugas == 'Selesai')
                    <span class="badge badge-success" style="white-space: nowrap;">Lulus Praktik</span>
                @else
                    <span class="badge badge-pending" style="white-space: nowrap;">Belum Dimulai</span>
                @endif
                <div class="btn btn-primary" style="pointer-events: none; border-radius: var(--radius-full); padding: 0.5rem 1.5rem; font-weight: 600; white-space: nowrap; background: var(--success); border-color: var(--success);">
                    Mulai Praktik &rarr;
                </div>
            </div>
        </a>

    </div>
</div>
@endsection
