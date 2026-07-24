@extends('layouts.app')

@section('content')
<div style="padding: 2rem;">
    <h2>Edit Materi: {{ $materi->judul }}</h2>
    <form action="{{ route('admin.materi.update', $materi->id_materi) }}" method="POST" class="card" style="padding: 20px; max-width: 600px;">
        @csrf @method('PUT')
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Modul Induk</label>
            <select name="nama_modul" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
                <option value="OLT" {{ $materi->nama_modul == 'OLT' ? 'selected' : '' }}>OLT</option>
                <option value="ODC" {{ $materi->nama_modul == 'ODC' ? 'selected' : '' }}>ODC</option>
                <option value="ODP" {{ $materi->nama_modul == 'ODP' ? 'selected' : '' }}>ODP</option>
                <option value="ONT" {{ $materi->nama_modul == 'ONT' ? 'selected' : '' }}>ONT</option>
                <option value="Splicing" {{ $materi->nama_modul == 'Splicing' ? 'selected' : '' }}>Splicing</option>
            </select>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Judul Materi</label>
            <input type="text" name="judul" value="{{ $materi->judul }}" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Isi/Deskripsi Materi</label>
            <textarea name="deskripsi" rows="5" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">{{ $materi->deskripsi }}</textarea>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">URL Video Pembelajaran</label>
            <input type="url" name="url_video" value="{{ $materi->url_video }}" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Urutan Tampil</label>
            <input type="number" name="urutan" value="{{ $materi->urutan }}" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Update Materi</button>
        <a href="{{ route('admin.materi.index') }}" style="margin-left: 10px; color: #ef4444; text-decoration: none;">Batal</a>
    </form>
</div>
@endsection
