@extends('layouts.app')

@section('content')
<style>
    .game-wrapper { font-family: 'Segoe UI', Tahoma, sans-serif; background: #0f172a; color: #f8fafc; display: flex; flex-direction: column; align-items: center; padding: 20px; min-height: 80vh; }
    .game-wrapper h1 { margin-bottom: 5px; color: #38bdf8; text-align: center; }
    .game-wrapper .subtitle { color: #94a3b8; margin-bottom: 30px; text-align: center; font-size: 0.9em; }
    
    .layout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; width: 100%; max-width: 1100px; }

    .hardware-panel { background: #1e293b; padding: 25px; border-radius: 12px; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.5); display: flex; flex-direction: column; align-items: center;}
    
    .ont-device { width: 250px; background: #f8fafc; border-radius: 8px; padding: 15px; position: relative; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
    .ont-antennas { display: flex; justify-content: space-between; position: absolute; top: -30px; left: 20px; right: 20px; }
    .antenna { width: 8px; height: 40px; background: #cbd5e1; border-radius: 4px; }
    
    .ont-logo { text-align: center; color: #334155; font-weight: bold; font-size: 1.2em; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 15px; }
    
    .ont-leds { display: flex; justify-content: space-around; margin-bottom: 20px; }
    .led-group { text-align: center; }
    .led-light { width: 12px; height: 12px; background: #cbd5e1; border-radius: 50%; margin: 0 auto 5px; transition: 0.3s; }
    .led-label { font-size: 0.6em; color: #64748b; font-weight: bold; text-transform: uppercase;}
    
    .led-active-green { background: #22c55e; box-shadow: 0 0 8px #22c55e; }
    .led-active-red { background: #ef4444; box-shadow: 0 0 8px #ef4444; animation: blink 1s infinite; }

    @keyframes blink { 0% {opacity:1;} 50% {opacity:0.3;} 100% {opacity:1;} }

    .ont-ports { display: flex; justify-content: space-around; border-top: 2px solid #e2e8f0; padding-top: 15px; }
    .port { width: 40px; height: 30px; background: #1e293b; border: 2px dashed #94a3b8; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.6em; color: white; transition: 0.3s; }
    
    .drag-over { background: #38bdf8 !important; border-color: #0284c7 !important; }
    .has-power { background: #000 !important; border-style: solid !important; border-color: #334155 !important; }
    .has-pon { background: #22c55e !important; border-style: solid !important; border-color: #166534 !important; }

    .info-panel { background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid #38bdf8; box-sizing: border-box; }
    .info-panel h3 { margin-top: 0; color: #38bdf8; border-bottom: 1px solid #334155; padding-bottom: 10px; }
    
    .toolbox { margin-top: 20px; background: #111827; padding: 20px; border-radius: 8px; border: 1px dashed #64748b; display: flex; gap: 15px; justify-content: center; width: 100%; box-sizing: border-box;}
    .item-drag { background: #1e293b; border: 2px solid #cbd5e1; padding: 10px 15px; border-radius: 6px; cursor: grab; font-weight: bold; font-size: 0.85em; display: flex; align-items: center; transition: 0.2s; }
    
    #pwr-adapter { border-color: #facc15; color: #facc15; }
    #pon-cable { border-color: #38bdf8; color: #38bdf8; }

    #successBanner { display: none; background: #22c55e; color: white; padding: 15px; border-radius: 8px; margin-top: 20px; font-weight: bold; text-align: center; width: 100%; box-sizing: border-box;}
</style>

<div class="game-wrapper">
    <h1>Optical Network Terminal (ONT)</h1>
    <p class="subtitle">Instalasi Modem Router WiFi di Rumah Pelanggan</p>

    <div class="layout-grid">
        <div class="hardware-panel">
            <div class="ont-device">
                <div class="ont-antennas">
                    <div class="antenna"></div><div class="antenna"></div>
                </div>
                
                <div class="ont-logo">Wi-Fi Router ONT</div>
                
                <div class="ont-leds">
                    <div class="led-group">
                        <div class="led-light" id="led-pwr"></div>
                        <div class="led-label">PWR</div>
                    </div>
                    <div class="led-group">
                        <div class="led-light" id="led-pon"></div>
                        <div class="led-label">PON</div>
                    </div>
                    <div class="led-group">
                        <div class="led-light" id="led-los"></div>
                        <div class="led-label">LOS</div>
                    </div>
                </div>

                <div class="ont-ports">
                    <div class="port" id="port-pon" ondrop="dropPon(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">PON</div>
                    <div class="port" id="port-pwr" ondrop="dropPwr(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">PWR</div>
                </div>
            </div>

            <div class="toolbox">
                <div class="item-drag" id="pwr-adapter" draggable="true" ondragstart="drag(event)">🔌 Power Adapter</div>
                <div class="item-drag" id="pon-cable" draggable="true" ondragstart="drag(event)">🟢 Patchcord Roset (Kuning)</div>
            </div>

            <div id="successBanner">
                Instalasi ONT Berhasil! Pelanggan kini bisa menikmati internet.
                <br><br>
                <a href="{{ url('/') }}" style="color: white; text-decoration: underline;">Kembali ke Beranda</a>
            </div>
        </div>

        <div class="info-panel">
            <h3 id="info-title">Pengenalan Modem ONT</h3>
            <div id="info-content">
                ONT bertugas merubah sinyal optik menjadi sinyal elektrik/digital (Ethernet & Wi-Fi).
                <br><br>
                <b>Instruksi:</b><br>
                1. Pasang <b>Power Adapter</b> ke port PWR untuk menyalakan perangkat.<br>
                2. Perhatikan LED LOS berkedip merah karena tidak ada sinyal cahaya.<br>
                3. Colokkan kabel optik dari Roset (Patchcord) ke port PON.
            </div>
        </div>
    </div>
</div>

<script>
    const currentLevel = "{{ $progress->tingkat_kesulitan ?? 'Beginner' }}";
    if(currentLevel === 'Expert') {
        document.querySelectorAll('.step').forEach(el => el.style.opacity = '0.5');
    }
    let pwrOn = false;

    function allowDrop(ev) { ev.preventDefault(); ev.target.classList.add('drag-over'); }
    function leaveDrop(ev) { ev.target.classList.remove('drag-over'); }
    function drag(ev) { ev.dataTransfer.setData("text", ev.target.id); }

    function dropPwr(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.dataTransfer.getData("text") === "pwr-adapter" && ev.target.id === "port-pwr") {
            document.getElementById('pwr-adapter').style.display = "none";
            ev.target.classList.add('has-power');
            ev.target.innerHTML = "DC IN";
            
            pwrOn = true;
            document.getElementById('led-pwr').classList.add('led-active-green');
            document.getElementById('led-los').classList.add('led-active-red'); // LOS Merah karena kabel optic blm masuk
            
            document.getElementById('info-title').innerText = "ONT Menyala (LOS Merah)";
            document.getElementById('info-content').innerHTML = "Perangkat hidup, namun LED LOS (Loss of Signal) menyala merah. Ini berarti kabel fiber belum dicolok atau putus.";
        }
    }

    function dropPon(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.dataTransfer.getData("text") === "pon-cable" && ev.target.id === "port-pon") {
            if(!pwrOn) {
                alert("Nyalakan Power (PWR) terlebih dahulu!");
                return;
            }
            
            document.getElementById('pon-cable').style.display = "none";
            ev.target.classList.add('has-pon');
            ev.target.innerHTML = "OPTIK";
            
            document.getElementById('led-los').classList.remove('led-active-red'); // Mati
            document.getElementById('led-pon').classList.add('led-active-green'); // Nyala hijau mantap
            
            document.getElementById('info-title').innerText = "Koneksi Berhasil";
            document.getElementById('info-content').innerHTML = "LED PON menyala hijau stabil. OLT di sentral telah mendeteksi ONT ini dengan sukses.";

            selesaikanTugasAPI();
        }
    }

    function selesaikanTugasAPI() {
        document.getElementById('successBanner').style.display = 'block';
        fetch('{{ route("api.selesai.tugas") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            body: JSON.stringify({ kategori: 'ont' })
        });
    }
</script>
@endsection
