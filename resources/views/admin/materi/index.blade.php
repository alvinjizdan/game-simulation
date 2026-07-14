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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Kelola Materi Edukasi</h2>
            <button onclick="document.getElementById('modalTambah').style.display='flex'" class="btn">+ Tambah Materi</button>
        </div>
        
        @if(session('success'))
            <div style="background: rgba(34, 197, 94, 0.1); color: #22c55e; padding: 10px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #22c55e;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Modal Tambah Data -->
        <div id="modalTambah" class="modal">
            <div class="modal-content" style="width: 800px; max-width: 95%;">
                <button onclick="document.getElementById('modalTambah').style.display='none'" class="close-modal">&times;</button>
                <h3 style="margin-top: 0;">Tambah Materi Baru</h3>
                <form id="materiForm" action="{{ route('admin.materi.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                    @csrf
                    <div style="display: flex; gap: 15px;">
                        <div style="flex: 2;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Judul Materi</label>
                            <input type="text" name="judul" style="width: 100%;" required>
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Kategori</label>
                            <select name="kategori_id" style="width: 100%;" required>
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                                @if($kategori->isEmpty())
                                    <option value="">Buat kategori via Database terlebih dahulu</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500;">Isi Konten (Dukung Link, Gambar, Video)</label>
                        <!-- WYSIWYG Editor Container -->
                        <div id="editor-container" style="height: 300px; background: white; color: black; border-radius: 4px; border: 1px solid #cbd5e1;"></div>
                        <input type="hidden" name="isi_materi" id="isi_materi_hidden">
                    </div>
                    <div style="text-align: right; margin-top: 10px;">
                        <button type="submit" class="btn">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="admin-card">
            <h3>Daftar Materi</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid #334155;">
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">Judul</th>
                        <th style="padding: 10px;">Kategori</th>
                        <th style="padding: 10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materi as $m)
                    <tr style="border-bottom: 1px solid #1e293b;">
                        <td style="padding: 10px;">{{ $m->id }}</td>
                        <td style="padding: 10px;">{{ $m->judul }}</td>
                        <td style="padding: 10px;">{{ $m->kategori->nama_kategori ?? '-' }}</td>
                        <td style="padding: 10px;">
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('admin.materi.edit', $m->id) }}" class="btn" style="background: #eab308; padding: 5px 10px; font-size: 0.8rem; text-decoration: none; color: white;">Edit</a>
                                <form action="{{ route('admin.materi.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn" style="background: #ef4444; padding: 5px 10px; font-size: 0.8rem;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
