@extends('layouts.app')
@section('content')
<div style="display: flex; flex: 1;">
    <!-- Sidebar -->
    <div style="width: 250px; background: var(--navy); padding: 2rem; color: white;">
        <h3 style="margin-top: 0; color: white;">Admin Dashboard</h3>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.dashboard') }}" style="color: #94a3b8; text-decoration: none;">Dashboard</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.pengguna') }}" style="color: #94a3b8; text-decoration: none;">Kelola Pengguna</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.perangkat') }}" style="color: #94a3b8; text-decoration: none;">Katalog Perangkat</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.materi') }}" style="color: white; text-decoration: none;">Materi & Media</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div style="flex: 1; padding: 2rem;">
        <div style="display: flex; align-items: center; margin-bottom: 20px; gap: 15px;">
            <a href="{{ route('admin.materi') }}" class="btn" style="background: #64748b;">&larr; Kembali</a>
            <h2 style="margin: 0;">Edit Materi</h2>
        </div>

        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #ef4444;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-card" style="max-width: 900px;">
            <form id="materiForm" action="{{ route('admin.materi.update', $materi->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                @csrf @method('PUT')
                <div style="display: flex; gap: 15px;">
                    <div style="flex: 2;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Judul Materi</label>
                        <input type="text" name="judul" value="{{ old('judul', $materi->judul) }}" style="width: 100%;" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Kategori</label>
                        <select name="kategori_id" style="width: 100%;" required>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}" {{ $materi->kategori_id == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Isi Konten (Dukung Link, Gambar, Video)</label>
                    <div id="editor-container" style="height: 400px; background: white; color: black; border-radius: 4px; border: 1px solid #cbd5e1;">{!! old('isi_materi', $materi->isi_materi) !!}</div>
                    <input type="hidden" name="isi_materi" id="isi_materi_hidden">
                </div>
                <div style="text-align: right; margin-top: 10px;">
                    <button type="submit" class="btn">Update Materi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Quill Stylesheet & Script -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Ketikkan materi, masukkan link, atau sematkan URL gambar/video di sini...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'align': [] }],
                ['link', 'image', 'video'],                       // link and image, video
                ['clean']                                         // remove formatting button
            ]
        }
    });

    // Populate hidden field before submit
    document.getElementById('materiForm').onsubmit = function() {
        var htmlContent = document.querySelector('.ql-editor').innerHTML;
        document.getElementById('isi_materi_hidden').value = htmlContent;
    };
</script>
@endsection
