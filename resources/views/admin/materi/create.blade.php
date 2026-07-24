@extends('layouts.app')

@section('content')
<div style="padding: 2rem;">
    <h2>Tambah Materi Baru</h2>
    <form action="{{ route('admin.materi.store') }}" method="POST" class="card" style="padding: 20px; max-width: 600px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Modul Induk</label>
            <select name="nama_modul" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
                <option value="OLT">OLT</option>
                <option value="ODC">ODC</option>
                <option value="ODP">ODP</option>
                <option value="ONT">ONT</option>
                <option value="Splicing">Splicing</option>
            </select>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Judul Materi</label>
            <input type="text" name="judul" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Isi/Deskripsi Materi (Bisa HTML/Teks Biasa)</label>
            <textarea name="deskripsi" rows="5" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;"></textarea>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">URL Video Pembelajaran (Opsional, YouTube)</label>
            <input type="url" name="url_video" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Urutan Tampil</label>
            <input type="number" name="urutan" value="1" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Simpan Materi</button>
        <a href="{{ route('admin.materi.index') }}" style="margin-left: 10px; color: #ef4444; text-decoration: none;">Batal</a>
    </form>
</div>
@endsection
