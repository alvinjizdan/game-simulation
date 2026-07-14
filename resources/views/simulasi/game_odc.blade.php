@extends('layouts.app')

@section('content')
<style>
    /* === TEMA & RESET KHUSUS GAME === */
    .game-wrapper { font-family: 'Segoe UI', Tahoma, sans-serif; background: #0f172a; color: #f8fafc; display: flex; flex-direction: column; align-items: center; padding: 20px; min-height: 80vh; }
    .game-wrapper h1 { margin-bottom: 5px; color: #38bdf8; text-align: center; }
    .game-wrapper .subtitle { color: #94a3b8; margin-bottom: 30px; text-align: center; font-size: 0.9em; }
    
    .layout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; width: 100%; max-width: 1100px; }

    /* === PANEL ODC === */
    .hardware-panel { background: #1e293b; padding: 25px; border-radius: 12px; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    
    /* Cabinet ODC */
    .odc-cabinet { width: 100%; background: #94a3b8; border: 3px solid #475569; border-radius: 8px 8px 0 0; padding: 15px; position: relative; box-shadow: inset 0 10px 20px rgba(0,0,0,0.3); display: flex; gap: 20px; box-sizing: border-box; }
    
    /* Panel Feeder & Distribusi */
    .panel-section { flex: 1; background: #cbd5e1; border: 2px solid #64748b; border-radius: 4px; padding: 10px; display: flex; flex-direction: column; align-items: center; box-sizing: border-box; }
    .panel-title { color: #1e293b; font-weight: bold; font-size: 0.85em; margin-bottom: 15px; text-transform: uppercase; border-bottom: 2px solid #94a3b8; padding-bottom: 5px; width: 100%; text-align: center; }
    
    /* Port & Splitter */
    .port-in { width: 40px; height: 40px; background: #1e293b; border: 2px dashed #0f172a; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; transition: 0.3s; margin-bottom: 20px; }
    .splitter-box { width: 100%; background: #334155; color: white; text-align: center; padding: 10px 0; font-weight: bold; font-size: 0.8em; margin-top: auto; border: 2px solid #0f172a; position: relative; }
    
    .port-out-group { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; width: 100%; }
    .port-out { height: 35px; background: #1e293b; border: 2px dashed #0f172a; display: flex; align-items: center; justify-content: center; font-size: 0.7em; color: white; transition: 0.3s; }
    
    .drag-over { background: #38bdf8 !important; border-color: #fff !important; }
    .has-cable { background: #22c55e !important; border-style: solid !important; border-color: #166534 !important; color: white !important; font-weight: bold; }

    /* === INFO PANEL === */
    .info-panel { background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid #38bdf8; box-sizing: border-box; }
    .info-panel h3 { margin-top: 0; color: #38bdf8; border-bottom: 1px solid #334155; padding-bottom: 10px; }
    #info-content { font-size: 0.9em; line-height: 1.6; color: #cbd5e1; }

    /* === TOOLBOX === */
    .toolbox { margin-top: 20px; background: #1e293b; padding: 20px; border-radius: 8px; border: 1px dashed #64748b; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; }
    .item-drag { background: #111827; border: 2px solid #cbd5e1; padding: 10px 15px; border-radius: 6px; cursor: grab; font-weight: bold; font-size: 0.85em; display: flex; align-items: center; transition: 0.2s; }
    .item-drag:active { transform: scale(0.95); cursor: grabbing; }
    
    #feeder-cable { border-color: #facc15; color: #facc15; }
    #dist-cable { border-color: #38bdf8; color: #38bdf8; display: none; }

    #successBanner { display: none; background: #22c55e; color: white; padding: 15px; border-radius: 8px; margin-top: 20px; font-weight: bold; text-align: center; animation: slideDown 0.5s ease; }
    @keyframes slideDown { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<div class="game-wrapper">
    <h1>Optical Distribution Cabinet (ODC)</h1>
    <p class="subtitle">Eksplorasi Lemari Pasif & Konfigurasi Splitter 1:4</p>

    <div class="layout-grid">
        <div class="hardware-panel">
            
            <div class="odc-cabinet">
                <!-- Sisi Feeder -->
                <div class="panel-section" onclick="tampilkanInfo('feeder')">
                    <div class="panel-title">Feeder Panel (In)</div>
                    <div class="port-in" id="port-feeder" ondrop="dropFeeder(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">IN</div>
                    
                    <div class="splitter-box" onclick="tampilkanInfo('splitter')">
                        SPLITTER PASIF 1:4
                        <div style="font-size: 0.8em; font-weight: normal; margin-top: 5px;">Rasio Pembagian Daya</div>
                    </div>
                </div>

                <!-- Sisi Distribusi -->
                <div class="panel-section" onclick="tampilkanInfo('distribusi')">
                    <div class="panel-title">Distribution Panel (Out)</div>
                    <div class="port-out-group">
                        <div class="port-out" id="port-d1" ondrop="dropDist(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">OUT 1</div>
                        <div class="port-out">OUT 2</div>
                        <div class="port-out">OUT 3</div>
                        <div class="port-out">OUT 4</div>
                    </div>
                </div>
            </div>

            <div class="toolbox">
                <div class="item-drag" id="feeder-cable" draggable="true" ondragstart="drag(event)">⚡ Kabel Feeder (Dari OLT)</div>
                <div class="item-drag" id="dist-cable" draggable="true" ondragstart="drag(event)">🔌 Kabel Distribusi (Ke ODP)</div>
            </div>

            <div id="successBanner">
                Selamat! Anda telah berhasil mengonfigurasi ODC.
                <br><br>
                <a href="{{ url('/') }}" style="color: white; text-decoration: underline; font-weight: bold;">Kembali ke Beranda</a>
            </div>
        </div>

        <div class="info-panel">
            <h3 id="info-title">Pengenalan Kabinet ODC</h3>
            <div id="info-content">
                ODC (Optical Distribution Cabinet) adalah lemari luar ruangan yang tidak membutuhkan aliran listrik (Pasif).
                <br><br>
                <b>Instruksi Praktik:</b><br>
                1. Tarik dan sambungkan <b>Kabel Feeder</b> dari OLT ke port IN (Feeder Panel).<br>
                2. Setelah daya masuk, sambungkan <b>Kabel Distribusi</b> ke port OUT 1 menuju area pelanggan.
            </div>
        </div>
    </div>
</div>

<script>
    const currentLevel = "{{ $progress->tingkat_kesulitan ?? 'Beginner' }}";
    if(currentLevel === 'Expert') {
        document.querySelectorAll('.step').forEach(el => el.style.opacity = '0.5');
    }
    const materiODC = {
        'feeder': { judul: 'Feeder Panel', deskripsi: 'Titik terminasi untuk kabel utama (Kabel Feeder) yang datang langsung dari Sentral (OLT). Kapasitasnya sangat besar.' },
        'splitter': { judul: 'Pasif Splitter (1:4)', deskripsi: 'Komponen kaca prisma tanpa listrik yang memecah 1 sinar laser dari kabel feeder menjadi 4 sinar laser ke kabel distribusi. Setiap pembagian akan menurunkan daya optik (Redaman).' },
        'distribusi': { judul: 'Distribution Panel', deskripsi: 'Panel keluaran yang menghubungkan ODC dengan ODP-ODP yang ada di kompleks atau area perumahan.' }
    };

    function tampilkanInfo(bagian) {
        document.getElementById('info-title').innerText = materiODC[bagian].judul;
        document.getElementById('info-content').innerHTML = materiODC[bagian].deskripsi;
    }

    let feederTerpasang = false;

    function allowDrop(ev) { ev.preventDefault(); ev.target.classList.add('drag-over'); }
    function leaveDrop(ev) { ev.target.classList.remove('drag-over'); }
    function drag(ev) { ev.dataTransfer.setData("text", ev.target.id); }

    function dropFeeder(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.dataTransfer.getData("text") === "feeder-cable" && ev.target.id === "port-feeder") {
            document.getElementById('feeder-cable').style.display = "none";
            ev.target.classList.add('has-cable');
            ev.target.innerHTML = "IN";
            
            feederTerpasang = true;
            document.getElementById('dist-cable').style.display = "flex";
            
            document.getElementById('info-title').innerText = "Daya Masuk (Feeder)";
            document.getElementById('info-content').innerHTML = "Kabel Feeder berhasil diterminasi. Cahaya laser kini masuk ke Splitter 1:4 dan siap didistribusikan.";
        }
    }

    function dropDist(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.dataTransfer.getData("text") === "dist-cable" && feederTerpasang && ev.target.id === "port-d1") {
            document.getElementById('dist-cable').style.display = "none";
            ev.target.classList.add('has-cable');
            ev.target.innerHTML = "OUT 1";
            
            document.getElementById('info-title').innerText = "Distribusi Sukses";
            document.getElementById('info-content').innerHTML = "Kabel Distribusi berhasil terhubung. Jalur menuju ODP kini telah aktif.";

            selesaikanTugasAPI();
        }
    }

    function selesaikanTugasAPI() {
        document.getElementById('successBanner').style.display = 'block';
        fetch('{{ route("api.selesai.tugas") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify({ kategori: 'odc' })
        });
    }
</script>
@endsection
