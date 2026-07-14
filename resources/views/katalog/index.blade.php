@extends('layouts.app')
@section('content')
<div class="header-center">
    <h2>Katalog Perangkat Fiber Optik</h2>
    <div class="tabs">
        <button class="tab-btn active" data-filter="all">Semua</button>
        <button class="tab-btn" data-filter="Kabel Feeder">Kabel Feeder</button>
        <button class="tab-btn" data-filter="ODC">ODC</button>
        <button class="tab-btn" data-filter="ODP">ODP</button>
    </div>
</div>

<div class="grid">
    @foreach($perangkat as $p)
    <div class="card" data-type="{{ $p->jenis_perangkat }}" data-name="{{ $p->nama_perangkat }}" data-desc="{{ $p->deskripsi_fungsi }}" data-loss="{{ $p->loss_default }}">
        <img src="{{ $p->gambar_aset ?? 'https://via.placeholder.com/200' }}" alt="{{ $p->nama_perangkat }}">
        <h3>{{ $p->nama_perangkat }}</h3>
        <p>{{ ucfirst($p->jenis_perangkat) }}</p>
    </div>
    @endforeach
</div>

<!-- Modal -->
<div id="deviceModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2 id="modalName"></h2>
        <p id="modalDesc"></p>
        <div style="background: rgba(14,165,233,0.1); padding: 10px; border-radius: 5px; margin-top: 15px;">
            <h4 id="modalLoss" style="color: var(--primary); margin: 0;"></h4>
            <p style="font-size: 0.8rem; margin: 5px 0 0; color: #94a3b8;">* SOP Instalasi: Pastikan konektor bersih sebelum instalasi untuk menghindari redaman berlebih.</p>
        </div>
    </div>
</div>
@endsection
