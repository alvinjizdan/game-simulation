@extends('layouts.app')

@section('content')
<style>
    /* === TEMA KHUSUS GAME === */
    .game-wrapper { font-family: 'Segoe UI', Tahoma, sans-serif; background: #0f172a; color: #f8fafc; display: flex; flex-direction: column; align-items: center; padding: 20px; min-height: 80vh; }
    .game-wrapper h1 { margin-bottom: 5px; color: #38bdf8; text-align: center; }
    .game-wrapper .subtitle { color: #94a3b8; margin-bottom: 30px; text-align: center; font-size: 0.9em; }
    
    .layout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; width: 100%; max-width: 1100px; }

    /* === PANEL ODP === */
    .hardware-panel { background: #1e293b; padding: 25px; border-radius: 12px; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.5); display: flex; flex-direction: column; align-items: center;}
    
    .odp-box { width: 300px; background: #e2e8f0; border: 4px solid #64748b; border-radius: 10px; padding: 20px; position: relative; box-shadow: 0 15px 25px rgba(0,0,0,0.4); display: flex; flex-direction: column; align-items: center; }
    
    .odp-header { color: #1e293b; font-weight: bold; font-size: 1.2em; border-bottom: 2px solid #94a3b8; width: 100%; text-align: center; padding-bottom: 10px; margin-bottom: 20px; }

    .odp-ports { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; width: 100%; }
    .odp-port { height: 40px; background: #0f172a; border: 2px dashed #94a3b8; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.8em; color: #94a3b8; transition: 0.3s; }
    
    .drag-over { background: #38bdf8 !important; border-color: #fff !important; color: white !important;}
    .has-cable-in { background: #facc15 !important; border-style: solid !important; border-color: #ca8a04 !important; color: #000 !important; font-weight: bold; }
    .has-cable-out { background: #22c55e !important; border-style: solid !important; border-color: #166534 !important; color: white !important; font-weight: bold; }

    /* === INFO & TOOLBOX === */
    .info-panel { background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid #38bdf8; box-sizing: border-box; }
    .info-panel h3 { margin-top: 0; color: #38bdf8; border-bottom: 1px solid #334155; padding-bottom: 10px; }
    
    .toolbox { margin-top: 20px; background: #111827; padding: 20px; border-radius: 8px; border: 1px dashed #64748b; display: flex; gap: 15px; justify-content: center; width: 100%; box-sizing: border-box;}
    .item-drag { background: #1e293b; border: 2px solid #cbd5e1; padding: 10px 15px; border-radius: 6px; cursor: grab; font-weight: bold; font-size: 0.85em; display: flex; align-items: center; transition: 0.2s; }
    
    #kabel-dist { border-color: #38bdf8; color: #38bdf8; }
    #kabel-drop { border-color: #22c55e; color: #22c55e; display: none; }

    #successBanner { display: none; background: #22c55e; color: white; padding: 15px; border-radius: 8px; margin-top: 20px; font-weight: bold; text-align: center; animation: slideDown 0.5s ease; width: 100%; box-sizing: border-box;}
    @keyframes slideDown { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<div class="game-wrapper">
    <h1>Optical Distribution Point (ODP)</h1>
    <p class="subtitle">Simulasi Terminasi Kotak Distribusi Akhir di Tiang</p>

    <div class="layout-grid">
        <div class="hardware-panel">
            <div class="odp-box">
                <div class="odp-header" onclick="tampilkanInfo('odp')">ODP-Pole-01</div>
                
                <div style="width: 100%; margin-bottom: 20px;">
                    <div style="font-size: 0.75em; color: #64748b; margin-bottom: 5px; text-transform: uppercase;">Port Input (Dari ODC)</div>
                    <div class="odp-port" id="port-in" ondrop="dropIn(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">IN / SPLITTER 1:8</div>
                </div>

                <div style="width: 100%;">
                    <div style="font-size: 0.75em; color: #64748b; margin-bottom: 5px; text-transform: uppercase;">Port Output (Ke Rumah)</div>
                    <div class="odp-ports">
                        <div class="odp-port" id="port-out-1" ondrop="dropOut(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">PORT 1</div>
                        <div class="odp-port">PORT 2</div>
                        <div class="odp-port">PORT 3</div>
                        <div class="odp-port">PORT 4</div>
                    </div>
                </div>
            </div>

            <div class="toolbox">
                <div class="item-drag" id="kabel-dist" draggable="true" ondragstart="drag(event)">⚡ Kabel Distribusi</div>
                <div class="item-drag" id="kabel-drop" draggable="true" ondragstart="drag(event)">🏡 Drop Core (Hitam)</div>
            </div>

            <div id="successBanner">
                ODP Terhubung! Drop Core siap ditarik ke rumah pelanggan.
                <br><br>
                <a href="{{ url('/') }}" style="color: white; text-decoration: underline;">Kembali ke Beranda</a>
            </div>
        </div>

        <div class="info-panel">
            <h3 id="info-title">Pengenalan Kotak ODP</h3>
            <div id="info-content">
                ODP biasanya dipasang di tiang listrik atau dinding rumah. Ini adalah titik di mana satu *core* kabel distribusi dibagi lagi untuk 8 rumah.
                <br><br>
                <b>Instruksi:</b><br>
                1. Pasang <b>Kabel Distribusi</b> (dari ODC) ke port Input ODP.<br>
                2. Colokkan kabel <b>Drop Core</b> ke Port 1 untuk disambung ke rumah pelanggan pertama.
            </div>
        </div>
    </div>
</div>

<script>
    const currentLevel = "{{ $progress->tingkat_kesulitan ?? 'Beginner' }}";
    if(currentLevel === 'Expert') {
        document.querySelectorAll('.step').forEach(el => el.style.opacity = '0.5');
    }
    const materiODP = {
        'odp': { judul: 'Kotak ODP (Closure/Pole)', deskripsi: 'Menyediakan titik terminasi antara kabel distribusi jaringan dengan kabel drop yang menuju langsung ke rumah pelanggan. Tahan cuaca dan panas.' }
    };

    function tampilkanInfo(bagian) {
        document.getElementById('info-title').innerText = materiODP[bagian].judul;
        document.getElementById('info-content').innerHTML = materiODP[bagian].deskripsi;
    }

    let inputTerpasang = false;

    function allowDrop(ev) { ev.preventDefault(); ev.target.classList.add('drag-over'); }
    function leaveDrop(ev) { ev.target.classList.remove('drag-over'); }
    function drag(ev) { ev.dataTransfer.setData("text", ev.target.id); }

    function dropIn(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.dataTransfer.getData("text") === "kabel-dist" && ev.target.id === "port-in") {
            document.getElementById('kabel-dist').style.display = "none";
            ev.target.classList.add('has-cable-in');
            ev.target.innerHTML = "IN AKTIF";
            
            inputTerpasang = true;
            document.getElementById('kabel-drop').style.display = "flex";
            
            document.getElementById('info-title').innerText = "Sinyal Distribusi Masuk";
            document.getElementById('info-content').innerHTML = "Sinyal dari ODC kini telah mencapai ODP. Pasang kabel Drop Core ke port output untuk rumah pelanggan.";
        }
    }

    function dropOut(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.dataTransfer.getData("text") === "kabel-drop" && inputTerpasang && ev.target.id === "port-out-1") {
            document.getElementById('kabel-drop').style.display = "none";
            ev.target.classList.add('has-cable-out');
            ev.target.innerHTML = "USER 1";
            
            selesaikanTugasAPI();
        }
    }

    function selesaikanTugasAPI() {
        document.getElementById('successBanner').style.display = 'block';
        fetch('{{ route("api.selesai.tugas") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify({ kategori: 'odp' })
        });
    }
</script>
@endsection
