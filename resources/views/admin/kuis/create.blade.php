@extends('layouts.app')

@section('content')
<div style="padding: 2rem;">
    <h2>Tambah Soal Kuis</h2>
    <form action="{{ route('admin.kuis.store') }}" method="POST" class="card" style="padding: 20px; max-width: 600px;">
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
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Pertanyaan</label>
            <textarea name="pertanyaan" rows="3" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required></textarea>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Opsi A</label>
            <input type="text" name="opsi_a" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Opsi B</label>
            <input type="text" name="opsi_b" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Opsi C</label>
            <input type="text" name="opsi_c" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Opsi D</label>
            <input type="text" name="opsi_d" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Jawaban Benar</label>
            <select name="jawaban_benar" style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" required>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
        </div>
        <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Simpan Soal</button>
        <a href="{{ route('admin.kuis.index') }}" style="margin-left: 10px; color: #ef4444; text-decoration: none;">Batal</a>
    </form>
</div>
@endsection
