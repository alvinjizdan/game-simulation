@extends('layouts.app')

@section('content')
<style>
    .game-wrapper { font-family: 'Segoe UI', Tahoma, sans-serif; background: #0f172a; color: #f8fafc; display: flex; flex-direction: column; align-items: center; padding: 20px; min-height: 80vh; }
    .game-wrapper h1 { margin-bottom: 5px; color: #38bdf8; text-align: center; }
    .game-wrapper .subtitle { color: #94a3b8; margin-bottom: 30px; text-align: center; font-size: 0.9em; }
    
    .layout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; width: 100%; max-width: 1100px; }

    .hardware-panel { background: #1e293b; padding: 25px; border-radius: 12px; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.5); display: flex; flex-direction: column; align-items: center;}
    
    .splicer-device { width: 400px; background: #334155; border: 4px solid #facc15; border-radius: 8px; padding: 15px; position: relative; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
    
    .splicer-screen { width: 100%; height: 150px; background: #000; border: 2px solid #64748b; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;}
    
    .core-left { width: 45%; height: 4px; background: #38bdf8; position: absolute; left: -50%; transition: left 0.5s ease; }
    .core-right { width: 45%; height: 4px; background: #22c55e; position: absolute; right: -50%; transition: right 0.5s ease; }
    
    .arc-flash { width: 20px; height: 20px; background: white; border-radius: 50%; box-shadow: 0 0 20px 10px white; position: absolute; opacity: 0; }
    @keyframes flash { 0% {opacity: 1; transform: scale(1);} 50% {opacity: 1; transform: scale(2);} 100% {opacity: 0; transform: scale(1);} }

    .splicer-clamps { display: flex; justify-content: space-between; border-top: 1px solid #475569; padding-top: 15px; }
    .clamp { width: 40%; height: 60px; background: #1e293b; border: 2px dashed #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 0.7em; color: #cbd5e1; transition: 0.3s; }
    
    .drag-over { background: #475569 !important; border-color: #fff !important; }
    .has-core { background: #0f172a !important; border-style: solid !important; border-color: #cbd5e1 !important; }

    .btn-splice { margin-top: 20px; background: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; transition: 0.3s; opacity: 0.5; pointer-events: none; }
    .btn-splice.ready { opacity: 1; pointer-events: auto; background: #dc2626; box-shadow: 0 0 10px #ef4444; }
    .btn-splice.ready:active { transform: scale(0.95); }

    .info-panel { background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid #38bdf8; box-sizing: border-box; }
    .info-panel h3 { margin-top: 0; color: #38bdf8; border-bottom: 1px solid #334155; padding-bottom: 10px; }
    
    .toolbox { margin-top: 20px; background: #111827; padding: 20px; border-radius: 8px; border: 1px dashed #64748b; display: flex; gap: 15px; justify-content: center; width: 100%; box-sizing: border-box;}
    .item-drag { background: #1e293b; border: 2px solid #cbd5e1; padding: 10px 15px; border-radius: 6px; cursor: grab; font-weight: bold; font-size: 0.85em; display: flex; align-items: center; transition: 0.2s; }
    
    #core-biru { border-color: #38bdf8; color: #38bdf8; }
    #core-hijau { border-color: #22c55e; color: #22c55e; }

    #successBanner { display: none; background: #22c55e; color: white; padding: 15px; border-radius: 8px; margin-top: 20px; font-weight: bold; text-align: center; width: 100%; box-sizing: border-box;}
</style>

<div class="game-wrapper">
    <h1>Penyambungan Fiber (Splicing)</h1>
    <p class="subtitle">Simulasi Peleburan Kaca Core Menggunakan Fusion Splicer</p>

    <div class="layout-grid">
        <div class="hardware-panel">
            <div class="splicer-device">
                <div class="splicer-screen">
                    <span style="color: #64748b; font-family: monospace; position: absolute; top: 10px; left: 10px; font-size: 0.8em;" id="screen-text">SPLICER READY</span>
                    <div class="core-left" id="visual-core-l"></div>
                    <div class="core-right" id="visual-core-r"></div>
                    <div class="arc-flash" id="arc-flash"></div>
                </div>

                <div class="splicer-clamps">
                    <div class="clamp" id="clamp-left" ondrop="dropL(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">V-Groove Kiri</div>
                    <div class="clamp" id="clamp-right" ondrop="dropR(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">V-Groove Kanan</div>
                </div>
                
                <div style="text-align: center;">
                    <button class="btn-splice" id="btn-splice" onclick="mulaiSplicing()">🔥 SPLICE (LEBUR)</button>
                </div>
            </div>

            <div class="toolbox">
                <div class="item-drag" id="core-biru" draggable="true" ondragstart="drag(event)">🔹 Core Biru (Kupas & Potong)</div>
                <div class="item-drag" id="core-hijau" draggable="true" ondragstart="drag(event)">🔸 Core Hijau (Kupas & Potong)</div>
            </div>

            <div id="successBanner">
                Splicing Selesai! Estimasi Loss: 0.01 dB.
                <br><br>
                <a href="{{ url('/') }}" style="color: white; text-decoration: underline;">Kembali ke Beranda</a>
            </div>
        </div>

        <div class="info-panel">
            <h3 id="info-title">Fusion Splicer</h3>
            <div id="info-content">
                Splicer menggunakan lompatan listrik tegangan tinggi (Electric Arc) untuk melelehkan dan menyambungkan dua ujung kaca optik.
                <br><br>
                <b>Instruksi:</b><br>
                1. Letakkan <b>Core Kiri</b> ke Clamp/V-Groove Kiri.<br>
                2. Letakkan <b>Core Kanan</b> ke Clamp/V-Groove Kanan.<br>
                3. Tekan tombol <b>SPLICE</b> untuk menembakkan laser/listrik pelebur.
            </div>
        </div>
    </div>
</div>

<script>
    const currentLevel = "{{ $progress->tingkat_kesulitan ?? 'Beginner' }}";
    if(currentLevel === 'Expert') {
        document.querySelectorAll('.step').forEach(el => el.style.opacity = '0.5');
    }
    let leftReady = false;
    let rightReady = false;

    function allowDrop(ev) { ev.preventDefault(); ev.target.classList.add('drag-over'); }
    function leaveDrop(ev) { ev.target.classList.remove('drag-over'); }
    function drag(ev) { ev.dataTransfer.setData("text", ev.target.id); }

    function dropL(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.target.id === "clamp-left") {
            document.getElementById(ev.dataTransfer.getData("text")).style.display = "none";
            ev.target.classList.add('has-core');
            ev.target.innerHTML = "CORE KIRI OK";
            document.getElementById('visual-core-l').style.left = "0"; // Muncul di layar
            leftReady = true;
            cekTombol();
        }
    }

    function dropR(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.target.id === "clamp-right") {
            document.getElementById(ev.dataTransfer.getData("text")).style.display = "none";
            ev.target.classList.add('has-core');
            ev.target.innerHTML = "CORE KANAN OK";
            document.getElementById('visual-core-r').style.right = "0"; // Muncul di layar
            rightReady = true;
            cekTombol();
        }
    }

    function cekTombol() {
        if(leftReady && rightReady) {
            document.getElementById('btn-splice').classList.add('ready');
            document.getElementById('screen-text').innerText = "ALIGNMENT OK. PRESS SPLICE.";
        }
    }

    function mulaiSplicing() {
        document.getElementById('btn-splice').classList.remove('ready');
        document.getElementById('screen-text').innerText = "DISCHARGING ARC...";
        
        // Animasi Arc
        const flash = document.getElementById('arc-flash');
        flash.style.animation = "flash 1.5s ease";
        
        setTimeout(() => {
            // Gabung visualnya
            document.getElementById('visual-core-l').style.width = "50%";
            document.getElementById('visual-core-r').style.width = "50%";
            document.getElementById('screen-text').innerText = "SPLICING FINISHED. LOSS: 0.01 dB";
            
            document.getElementById('info-title').innerText = "Penyambungan Sempurna";
            document.getElementById('info-content').innerHTML = "Electric arc telah berhasil menyatukan dua core kaca tanpa cacat. Sinyal cahaya bisa merambat lurus.";

            selesaikanTugasAPI();
        }, 1500);
    }

    function selesaikanTugasAPI() {
        document.getElementById('successBanner').style.display = 'block';
        fetch('{{ route("api.selesai.tugas") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify({ kategori: 'kabel' })
        });
    }
</script>
@endsection
