@extends('layouts.app')

@section('content')
<div style="padding: 2rem;">
    <h2>Edit Soal Kuis</h2>
    <form action="{{ route('admin.kuis.update', $kuis->id_kuis) }}" method="POST" class="card" style="padding: 20px; max-width: 600px;">
        @csrf @method('PUT')
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Modul Induk</label>
            <select name="nama_modul" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
                <option value="OLT" {{ $kuis->nama_modul == 'OLT' ? 'selected' : '' }}>OLT</option>
                <option value="ODC" {{ $kuis->nama_modul == 'ODC' ? 'selected' : '' }}>ODC</option>
                <option value="ODP" {{ $kuis->nama_modul == 'ODP' ? 'selected' : '' }}>ODP</option>
                <option value="ONT" {{ $kuis->nama_modul == 'ONT' ? 'selected' : '' }}>ONT</option>
                <option value="Splicing" {{ $kuis->nama_modul == 'Splicing' ? 'selected' : '' }}>Splicing</option>
            </select>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Pertanyaan</label>
            <textarea name="pertanyaan" rows="3" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>{{ $kuis->pertanyaan }}</textarea>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Opsi A</label>
            <input type="text" name="opsi_a" value="{{ $kuis->opsi_a }}" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Opsi B</label>
            <input type="text" name="opsi_b" value="{{ $kuis->opsi_b }}" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Opsi C</label>
            <input type="text" name="opsi_c" value="{{ $kuis->opsi_c }}" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Opsi D</label>
            <input type="text" name="opsi_d" value="{{ $kuis->opsi_d }}" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Jawaban Benar</label>
            <select name="jawaban_benar" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
                <option value="A" {{ $kuis->jawaban_benar == 'A' ? 'selected' : '' }}>A</option>
                <option value="B" {{ $kuis->jawaban_benar == 'B' ? 'selected' : '' }}>B</option>
                <option value="C" {{ $kuis->jawaban_benar == 'C' ? 'selected' : '' }}>C</option>
                <option value="D" {{ $kuis->jawaban_benar == 'D' ? 'selected' : '' }}>D</option>
            </select>
        </div>
        <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Update Soal</button>
        <a href="{{ route('admin.kuis.index') }}" style="margin-left: 10px; color: #ef4444; text-decoration: none;">Batal</a>
    </form>
</div>
@endsection
