@extends('layouts.app')

@section('content')
<div class="container animate-fade-in" style="max-width: 800px;">
    <div style="margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <div style="color: var(--text-secondary); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem;">Kuis Interaktif</div>
            <h1 style="margin: 0; font-size: 2.5rem; color: var(--text-primary);">Modul {{ $nama_modul }}</h1>
        </div>
        <a href="{{ route('peserta.modul.detail', strtolower($nama_modul)) }}" class="btn btn-outline" style="border-radius: var(--radius-full);">
            &larr; Batalkan Ujian
        </a>
    </div>

    <form action="{{ route('peserta.modul.kuis.submit', strtolower($nama_modul)) }}" method="POST" id="quizForm">
        @csrf
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            @foreach($kuis as $index => $q)
            <div class="glass-card" style="padding: 2.5rem;">
                <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 2rem;">
                    <div style="background: rgba(255,255,255,0.05); min-width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-sm); font-weight: 800; font-size: 1.2rem; color: var(--primary); border: 1px solid var(--border-glass);">
                        {{ $index + 1 }}
                    </div>
                    <h3 style="margin: 0; color: var(--text-primary); font-size: 1.25rem; line-height: 1.5; padding-top: 5px;">{{ $q->pertanyaan }}</h3>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label class="quiz-radio">
                        <input type="radio" name="jawaban_{{ $q->id_kuis }}" value="A" required>
                        <span style="font-weight: 600; margin-right: 10px; color: var(--text-secondary);">A.</span> {{ $q->opsi_a }}
                    </label>
                    <label class="quiz-radio">
                        <input type="radio" name="jawaban_{{ $q->id_kuis }}" value="B" required>
                        <span style="font-weight: 600; margin-right: 10px; color: var(--text-secondary);">B.</span> {{ $q->opsi_b }}
                    </label>
                    <label class="quiz-radio">
                        <input type="radio" name="jawaban_{{ $q->id_kuis }}" value="C" required>
                        <span style="font-weight: 600; margin-right: 10px; color: var(--text-secondary);">C.</span> {{ $q->opsi_c }}
                    </label>
                    <label class="quiz-radio">
                        <input type="radio" name="jawaban_{{ $q->id_kuis }}" value="D" required>
                        <span style="font-weight: 600; margin-right: 10px; color: var(--text-secondary);">D.</span> {{ $q->opsi_d }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 3rem; text-align: right;">
            <button type="submit" id="submitBtn" class="btn btn-primary" style="padding: 1rem 3rem; font-size: 1.1rem; border-radius: var(--radius-full);">
                Kumpulkan Jawaban
            </button>
        </div>
    </form>
</div>

<script>
    // Vercel UI: Submit button stays enabled until request starts; spinner during request
    document.getElementById('quizForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = 'Memproses...';
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';
    });
</script>
@endsection
