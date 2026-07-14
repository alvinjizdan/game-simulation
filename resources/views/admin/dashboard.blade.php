@extends('layouts.app')

@section('content')
<div style="display: flex; flex: 1;">
    <!-- Sidebar -->
    <div style="width: 250px; background: var(--navy); padding: 2rem; color: white;">
        <h3 style="margin-top: 0; color: white;">Ruang Admin</h3>
        <ul style="list-style: none; padding: 0;">
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.dashboard') }}" style="color: white; text-decoration: none;">Rapor Peserta (Dashboard)</a></li>
            <li style="margin-bottom: 10px;"><a href="{{ route('admin.peserta') }}" style="color: #94a3b8; text-decoration: none;">Kelola Peserta</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div style="flex: 1; padding: 2rem;">
        <h2 style="margin-top: 0;">Rapor Progres Peserta</h2>
        <p style="color: #64748b; margin-bottom: 20px;">Pantau teknisi baru yang telah menyelesaikan Misi Pengenalan FTTH.</p>
        
        <div style="display: flex; gap: 20px; margin-bottom: 30px;">
            <div class="card" style="flex: 1; text-align: center;">
                <h3 style="font-size: 2rem; margin: 0; color: var(--navy);">{{ $totalPeserta }}</h3>
                <p style="margin: 0; color: #64748b;">Total Peserta</p>
            </div>
            <div class="card" style="flex: 1; text-align: center; border-bottom: 4px solid var(--success);">
                <h3 style="font-size: 2rem; margin: 0; color: var(--success);">{{ $selesai }}</h3>
                <p style="margin: 0; color: #64748b;">Misi Selesai</p>
            </div>
            <div class="card" style="flex: 1; text-align: center; border-bottom: 4px solid var(--danger);">
                <h3 style="font-size: 2rem; margin: 0; color: var(--danger);">{{ $belumSelesai }}</h3>
                <p style="margin: 0; color: #64748b;">Belum Selesai</p>
            </div>
        </div>

        <div style="background: var(--card-bg); padding: 1.5rem; border-radius: 8px;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 10px;">Nama Lengkap</th>
                        <th style="padding: 10px;">Username</th>
                        <th style="padding: 10px;">Status Misi</th>
                        <th style="padding: 10px;">Waktu Penyelesaian</th>
                        <th style="padding: 10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peserta as $p)
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 10px; font-weight: 500;">{{ $p->nama_lengkap }}</td>
                        <td style="padding: 10px; color: #64748b;">{{ $p->username }}</td>
                        <td style="padding: 10px;">
                            @php
                                $tugas = $p->tugas;
                                if($tugas) {
                                    $count = $tugas->progress_count;
                                    $percent = $tugas->progress_percentage;
                                    if($count == 5) {
                                        echo "<span style='background: var(--success); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;'>Lulus (5/5)</span>";
                                    } elseif($count > 0) {
                                        echo "<span style='background: var(--warning); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;'>Proses ($count/5)</span>";
                                    } else {
                                        echo "<span style='background: var(--danger); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;'>0/5 Selesai</span>";
                                    }
                                } else {
                                    echo "<span style='background: var(--danger); color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold;'>0/5 Selesai</span>";
                                }
                            @endphp
                        </td>
                        <td style="padding: 10px; color: #64748b;">
                            @php
                                $completedModules = $p->progressModul->where('status_tugas', 'Selesai');
                                $lastCompleted = $completedModules->max('updated_at');
                            @endphp
                            {{ $lastCompleted ? date('d/m/Y H:i', strtotime($lastCompleted)) : '-' }}
                        </td>
                        <td style="padding: 10px;">
                            <div style="display: flex; gap: 5px;">
                                <button onclick="openModal({{ $p->id_user }})" style="background: #38bdf8; color: var(--navy); border: none; padding: 5px 10px; border-radius: 4px; font-size: 0.8em; font-weight: bold; cursor: pointer;">Kelola Level</button>
                                <a href="{{ route('admin.peserta.edit', $p->id_user) }}" style="background: var(--secondary); color: var(--navy); padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 0.8em; font-weight: bold;">Edit Akun</a>
                                <form action="{{ route('admin.peserta.reset', $p->id_user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus/mereset seluruh progres misi peserta ini kembali ke 0?');">
                                    @csrf
                                    <button type="submit" style="background: var(--danger); color: white; border: none; padding: 5px 10px; border-radius: 4px; font-size: 0.8em; font-weight: bold; cursor: pointer;">Hapus Progres</button>
                                </form>
                            </div>

                            <!-- Modal Kelola Level -->
                            <div id="modal-{{ $p->id_user }}" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index: 1000;">
                                <div style="background: white; padding: 20px; border-radius: 8px; width: 400px; max-width: 90%;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                                        <h3 style="margin:0;">Kelola Level: {{ $p->nama_lengkap }}</h3>
                                        <button onclick="closeModal({{ $p->id_user }})" style="border:none; background:none; font-size:1.5rem; cursor:pointer;">&times;</button>
                                    </div>
                                    <div id="notif-{{ $p->id_user }}" style="color: white; background: #22c55e; padding: 8px; border-radius: 4px; font-size: 0.9em; margin-bottom: 10px; display: none;"></div>
                                    <table style="width: 100%; border-collapse: collapse;">
                                        @foreach($p->progressModul as $mod)
                                        <tr style="border-bottom: 1px solid #ddd;">
                                            <td style="padding: 10px 0;">{{ $mod->nama_modul }}</td>
                                            <td style="padding: 10px 0; text-align: right;">
                                                <select onchange="updateLevel({{ $mod->id_progress }}, this.value, {{ $p->id_user }})" style="padding: 5px; border-radius: 4px; border: 1px solid #ccc; font-weight:bold;">
                                                    <option value="Beginner" {{ $mod->tingkat_kesulitan == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                                    <option value="Intermediate" {{ $mod->tingkat_kesulitan == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                    <option value="Expert" {{ $mod->tingkat_kesulitan == 'Expert' ? 'selected' : '' }}>Expert</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($peserta->isEmpty())
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px; color: #94a3b8;">Belum ada peserta terdaftar.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById('modal-' + id).style.display = 'flex';
}
function closeModal(id) {
    document.getElementById('modal-' + id).style.display = 'none';
}
function updateLevel(idProgress, levelBaru, userId) {
    fetch('{{ route("admin.update_level") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            id_progress: idProgress,
            level_baru: levelBaru
        })
    })
    .then(r => r.json())
    .then(data => {
        if(data.success) {
            let notif = document.getElementById('notif-' + userId);
            notif.innerText = data.message;
            notif.style.display = 'block';
            setTimeout(() => notif.style.display = 'none', 3000);
        }
    });
}
</script>
@endsection
