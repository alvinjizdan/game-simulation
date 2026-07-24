@extends('layouts.app')

@section('content')
<div class="container animate-fade-in" style="max-width: 900px;">
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

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
        
        <!-- Kartu Materi -->
        <a href="{{ route('peserta.modul.materi', strtolower($nama_modul)) }}" class="glass-card" style="text-align: center; text-decoration: none; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 250px;">
            <div style="margin-bottom: 1.5rem; color: var(--primary); filter: drop-shadow(0 0 10px rgba(6, 182, 212, 0.3));">
                <i data-lucide="book-open" style="width: 56px; height: 56px;"></i>
            </div>
            <h3 style="color: var(--text-primary); margin-bottom: 0.5rem; font-size: 1.25rem;">Materi Pembelajaran</h3>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0;">
                <span class="badge badge-pending">{{ $materiCount }} Topik Tersedia</span>
            </p>
        </a>

        <!-- Kartu Kuis -->
        <a href="{{ route('peserta.modul.kuis', strtolower($nama_modul)) }}" class="glass-card" style="text-align: center; text-decoration: none; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 250px;">
            <div style="margin-bottom: 1.5rem; color: #f59e0b; filter: drop-shadow(0 0 10px rgba(245, 158, 11, 0.3));">
                <i data-lucide="file-text" style="width: 56px; height: 56px;"></i>
            </div>
            <h3 style="color: var(--text-primary); margin-bottom: 0.5rem; font-size: 1.25rem;">Kuis Interaktif</h3>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0; line-height: 1.6;">
                {{ $kuisCount }} Pertanyaan<br>
                Skor Tertinggi: <strong class="tabular-nums text-gradient" style="font-size: 1.2rem;">{{ $nilai->skor_tertinggi ?? 0 }} / 100</strong>
            </p>
        </a>

        <!-- Kartu Game -->
        <a href="{{ route('simulasi.game', strtolower($nama_modul)) }}" class="glass-card" style="text-align: center; text-decoration: none; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 250px; position: relative; overflow: hidden;">
            @if($progress->status_tugas == 'Selesai')
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--success); box-shadow: 0 0 15px var(--success-glow);"></div>
            @endif
            <div style="margin-bottom: 1.5rem; color: var(--success); filter: drop-shadow(0 0 10px rgba(34, 197, 94, 0.3));">
                <i data-lucide="gamepad-2" style="width: 56px; height: 56px;"></i>
            </div>
            <h3 style="color: var(--text-primary); margin-bottom: 0.5rem; font-size: 1.25rem;">Simulasi Praktik</h3>
            <p style="color: var(--text-secondary); font-size: 0.95rem; margin: 0;">
                Status: 
                @if($progress->status_tugas == 'Selesai')
                    <span class="badge badge-success">Lulus Praktik</span>
                @else
                    <span class="badge badge-pending">Belum Dimulai</span>
                @endif
            </p>
        </a>

    </div>
</div>
@endsection
