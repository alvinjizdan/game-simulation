@extends('layouts.app')

@section('content')
<div class="container animate-fade-in" style="max-width: 800px;">
    <div style="margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <div style="color: var(--text-secondary); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem;">Baca Materi</div>
            <h1 style="margin: 0; font-size: 2.5rem; color: var(--text-primary);">Modul {{ $nama_modul }}</h1>
        </div>
        <a href="{{ route('peserta.modul.detail', strtolower($nama_modul)) }}" class="btn btn-outline" style="border-radius: var(--radius-full);">
            &larr; Kembali
        </a>
    </div>

    @if($materi->isEmpty())
        <div class="glass-panel" style="padding: 3rem; text-align: center; color: var(--text-secondary);">
            <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">📭</div>
            <h3 style="color: var(--text-primary); margin-bottom: 0.5rem;">Belum Ada Materi</h3>
            <p>Admin belum menambahkan materi untuk modul ini.</p>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            @foreach($materi as $index => $m)
            <div class="glass-card" style="padding: 2.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="background: rgba(255,255,255,0.05); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-sm); font-weight: 800; font-size: 1.2rem; color: var(--primary); border: 1px solid var(--border-glass);">
                        {{ $index + 1 }}
                    </div>
                    <h2 style="margin: 0; color: var(--text-primary); font-size: 1.5rem;">{{ $m->judul }}</h2>
                </div>
                
                @if($m->url_video)
                    <div style="margin-bottom: 2rem;">
                        <a href="{{ $m->url_video }}" target="_blank" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 8px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Tonton Video Pembelajaran
                        </a>
                    </div>
                @endif

                <div style="line-height: 1.8; color: #cbd5e1; font-size: 1.05rem; max-width: 65ch;">
                    {!! nl2br(e($m->deskripsi)) !!}
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
