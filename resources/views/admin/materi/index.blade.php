@extends('layouts.app')

@section('content')
<div class="shad-layout">
    <!-- Sidebar -->
    <aside class="shad-sidebar">
        <div class="shad-sidebar-header">
            ViberLink Admin
        </div>
        
        <div class="shad-nav-group">
            <div class="shad-nav-label">Dashboard</div>
            <a href="{{ route('admin.dashboard') }}" class="shad-link">
                <i data-lucide="layout-dashboard"></i>
                Rapor Peserta
            </a>
            
            <div class="shad-nav-label" style="margin-top: 1.5rem;">Manajemen</div>
            <a href="{{ route('admin.peserta') }}" class="shad-link">
                <i data-lucide="users"></i>
                Kelola Peserta
            </a>
            <a href="{{ route('admin.materi.index') }}" class="shad-link active">
                <i data-lucide="book-open"></i>
                Kelola Materi
            </a>
            <a href="{{ route('admin.kuis.index') }}" class="shad-link">
                <i data-lucide="check-square"></i>
                Kelola Kuis
            </a>
        </div>

        <div style="margin-top: auto; border-top: 1px solid var(--border-glass); padding-top: 1rem; display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 32px; height: 32px; background: var(--primary); border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-weight: bold; color: black; flex-shrink: 0;">
                    {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                </div>
                <div style="overflow: hidden;">
                    <div style="font-size: 0.875rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">Administrator</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                @csrf
                <button type="submit" class="btn btn-outline" style="width: 100%; border-color: rgba(239,68,68,0.5); color: var(--danger); justify-content: center; gap: 6px;">
                    <i data-lucide="log-out" style="width: 14px; height: 14px;"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="shad-main">


        <!-- Content Area -->
        <div class="shad-content">
            
            <div id="table-view" class="animate-fade-in">
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
                    <div>
                        <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.25rem;">Kelola Materi Pembelajaran</h1>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">Tambahkan bahan bacaan dan link video edukasi ke dalam modul.</p>
                    </div>
                    <button type="button" onclick="showCreateForm()" class="btn btn-primary" style="display: inline-flex; gap: 0.5rem; align-items: center;">
                        <i data-lucide="plus" style="width: 16px; height: 16px;"></i> Tambah Materi
                </button>
            </div>

            @if(session('success'))
                <div class="glass-panel" style="border-left: 4px solid var(--success); padding: 1rem; margin-bottom: 2rem; color: var(--text-primary); display: flex; align-items: center; gap: 10px;">
                    <i data-lucide="check-circle" style="color: var(--success); width: 20px; height: 20px;"></i> {{ session('success') }}
                </div>
            @endif

            <div class="glass-card" style="padding: 0; overflow: hidden;">
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Modul</th>
                                <th>Judul Materi</th>
                                <th>Urutan</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materi as $m)
                            <tr>
                                <td>
                                    <span class="badge badge-pending" style="display: inline-flex; align-items: center; gap: 4px;">
                                        <i data-lucide="package" style="width: 12px; height: 12px;"></i> {{ $m->nama_modul }}
                                    </span>
                                </td>
                                <td style="font-weight: 500; color: var(--text-primary);">{{ $m->judul }}</td>
                                <td>
                                    <div style="width: 28px; height: 28px; background: rgba(255,255,255,0.05); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;">
                                        {{ $m->urutan }}
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <button type="button" onclick="showEditForm('form-edit-{{ $m->id_materi }}')" class="btn btn-outline" style="padding: 0.4rem 0.75rem; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                        <i data-lucide="pencil" style="width: 14px; height: 14px;"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.materi.destroy', $m->id_materi) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus materi ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-outline" style="border-color: rgba(239,68,68,0.5); color: var(--danger); padding: 0.4rem 0.75rem; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px; margin-left: 0.5rem;">
                                            <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="padding: 1rem; border-top: 1px solid var(--border-glass);">
                    {{ $materi->links('pagination::bootstrap-5') }}
                </div>
                </div>
            </div>
        </div>

    <!-- Form Create -->
    <div id="form-create" class="animate-fade-in" style="display: none; width: 100%;">
        <div class="glass-card" style="padding: 2.5rem; width: 100%;">
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-primary);">Tambah Materi Baru</h2>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">Isi form di bawah ini untuk menambahkan materi ke dalam modul.</p>
            </div>
            <form action="{{ route('admin.materi.store') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Pilih Modul</label>
                        <select name="nama_modul" required style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; ">
                            <option value="OLT">OLT</option>
                            <option value="ODC">ODC</option>
                            <option value="ODP">ODP</option>
                            <option value="ONT">ONT</option>
                            <option value="Splicing">Splicing</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Judul Materi</label>
                        <input type="text" name="judul" required placeholder="Contoh: Pengenalan OLT" style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; ">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Deskripsi/Isi Materi</label>
                        <textarea name="deskripsi" rows="8" required placeholder="Tuliskan isi materi di sini..." style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; resize: vertical;"></textarea>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">URL Video Edukasi (Opsional)</label>
                        <input type="url" name="url_video" placeholder="https://youtube.com/..." style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; ">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Urutan Materi (Angka)</label>
                        <input type="number" name="urutan" required min="1" value="1" style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; ">
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-glass);">
                    <button type="button" onclick="showTable()" class="btn btn-outline">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Materi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Forms Edit -->
    @foreach($materi as $m)
    <div id="form-edit-{{ $m->id_materi }}" class="animate-fade-in form-edit-container" style="display: none; width: 100%;">
        <div class="glass-card" style="padding: 2.5rem; width: 100%;">
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-primary);">Edit Materi</h2>
                <p style="color: var(--text-secondary); font-size: 0.95rem;">Perbarui informasi materi di bawah ini.</p>
            </div>
            <form action="{{ route('admin.materi.update', $m->id_materi) }}" method="POST">
                @csrf
                @method('PUT')
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Pilih Modul</label>
                        <select name="nama_modul" required style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; ">
                            <option value="OLT" {{ $m->nama_modul == 'OLT' ? 'selected' : '' }}>OLT</option>
                            <option value="ODC" {{ $m->nama_modul == 'ODC' ? 'selected' : '' }}>ODC</option>
                            <option value="ODP" {{ $m->nama_modul == 'ODP' ? 'selected' : '' }}>ODP</option>
                            <option value="ONT" {{ $m->nama_modul == 'ONT' ? 'selected' : '' }}>ONT</option>
                            <option value="Splicing" {{ $m->nama_modul == 'Splicing' ? 'selected' : '' }}>Splicing</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Judul Materi</label>
                        <input type="text" name="judul" required value="{{ $m->judul }}" style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; ">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Deskripsi/Isi Materi</label>
                        <textarea name="deskripsi" rows="8" required style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; resize: vertical;">{{ $m->deskripsi }}</textarea>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">URL Video Edukasi (Opsional)</label>
                        <input type="url" name="url_video" value="{{ $m->url_video }}" style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; ">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Urutan Materi (Angka)</label>
                        <input type="number" name="urutan" required min="1" value="{{ $m->urutan }}" style="width: 100%; padding: 0.85rem; border: 1px solid var(--border-glass); border-radius: 0.5rem; ">
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-glass);">
                    <button type="button" onclick="showTable()" class="btn btn-outline">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

        </div>
    </main>
</div>

<script>
    function hideAllViews() {
        document.getElementById('table-view').style.display = 'none';
        document.getElementById('form-create').style.display = 'none';
        document.querySelectorAll('.form-edit-container').forEach(el => {
            el.style.display = 'none';
        });
    }

    function showTable() {
        hideAllViews();
        document.getElementById('table-view').style.display = 'block';
    }

    function showCreateForm() {
        hideAllViews();
        document.getElementById('form-create').style.display = 'block';
    }

    function showEditForm(id) {
        hideAllViews();
        document.getElementById(id).style.display = 'block';
    }
</script>

<style>
    body > .navbar { display: none !important; }
</style>
@endsection

