@extends('layouts.app')

@section('content')
<style>
    /* === TEMA & RESET KHUSUS GAME === */
    .game-wrapper {
        font-family: 'Segoe UI', Tahoma, sans-serif;
        background: #0f172a;
        color: #f8fafc;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        min-height: 80vh;
    }
    .game-wrapper h1 { margin-bottom: 5px; color: #38bdf8; text-align: center; }
    .game-wrapper .subtitle { color: #94a3b8; margin-bottom: 30px; text-align: center; font-size: 0.9em; }
    
    .layout-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; width: 100%; max-width: 1100px; }

    /* === PANEL OLT (VISUAL HARDWARE) === */
    .hardware-panel { background: #1e293b; padding: 25px; border-radius: 12px; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
    
    /* Chassis OLT */
    .olt-chassis { width: 100%; background: #111827; border: 3px solid #64748b; border-radius: 4px; display: flex; flex-direction: column; padding: 10px; position: relative; box-shadow: inset 0 10px 20px rgba(0,0,0,0.5); }
    
    /* Fan Tray (Kipas) */
    .fan-tray { height: 40px; background: #1f2937; border: 1px solid #334155; margin-bottom: 10px; display: flex; justify-content: space-around; align-items: center; cursor: pointer; transition: 0.2s; }
    .fan-tray:hover { border-color: #38bdf8; background: #334155; }
    .fan { width: 30px; height: 30px; border-radius: 50%; border: 2px dashed #94a3b8; animation: spin 2s linear infinite; }
    @keyframes spin { 100% { transform: rotate(360deg); } }

    /* Area Board */
    .board-area { display: flex; height: 140px; }
    .board { border: 1px solid #334155; background: #1f2937; margin: 0 5px; padding: 10px; display: flex; flex-direction: column; justify-content: flex-end; position: relative; cursor: pointer; transition: 0.2s; }
    .board:hover { background: #334155; border-color: #38bdf8; }
    .board-title { position: absolute; top: 5px; left: 0; width: 100%; text-align: center; font-size: 0.65em; color: #94a3b8; font-weight: bold; text-transform: uppercase; }

    .board-power { flex: 0.5; }
    .power-socket { width: 30px; height: 20px; background: #000; border: 2px solid #ef4444; margin: 0 auto 10px; }
    
    .board-mcb { flex: 1; display: flex; gap: 5px; justify-content: center; align-items: flex-end; }
    .uplink-port { width: 20px; height: 20px; background: #000; border: 2px solid #facc15; border-radius: 3px; }

    .board-pon { flex: 2.5; display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
    .pon-slot { height: 30px; background: #000; border: 2px dashed #64748b; display: flex; align-items: center; justify-content: center; font-size: 0.6em; color: #64748b; transition: 0.3s; }
    .pon-slot.drag-over { background: #38bdf8; border-color: #fff; color: #fff; }
    .pon-slot.has-sfp { background: #d97706; border-style: solid; border-color: #f59e0b; color: white; cursor: pointer; }
    .pon-slot.has-cable { background: #22c55e; border-color: #166534; box-shadow: 0 0 10px #22c55e; }
    .pon-slot.has-dirty-cable { background: #ef4444; border-color: #991b1b; box-shadow: 0 0 10px #ef4444; }

    /* === INFO PANEL === */
    .info-panel { background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid #38bdf8; box-sizing: border-box; }
    .info-panel h3 { margin-top: 0; color: #38bdf8; border-bottom: 1px solid #334155; padding-bottom: 10px; }
    #info-content { font-size: 0.9em; line-height: 1.6; color: #cbd5e1; }

    /* === TOOLBOX === */
    .toolbox { margin-top: 20px; background: #1e293b; padding: 20px; border-radius: 8px; border: 1px dashed #64748b; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap; }
    .item-drag { background: #111827; border: 2px solid #cbd5e1; padding: 10px 15px; border-radius: 6px; cursor: grab; font-weight: bold; font-size: 0.85em; display: flex; align-items: center; transition: 0.2s; }
    .item-drag:active { transform: scale(0.95); cursor: grabbing; }
    
    #sfp-module { border-color: #f59e0b; color: #facc15; }
    #fiber-cleaner { border-color: #22c55e; color: #4ade80; display: none; }
    #patchcord { border-color: #38bdf8; color: #7dd3fc; display: none; transition: 0.3s; }
    #patchcord.cleaned { border-color: #22c55e; color: #22c55e; background: #064e3b; }
    #patchcord.drag-over { transform: scale(1.1); border-style: dashed; }

    /* === MONITOR SCREEN === */
    .monitor-screen { margin-top: 20px; width: 100%; background: #000; border: 4px solid #334155; border-radius: 8px; padding: 15px; box-sizing: border-box; font-family: monospace; color: #22c55e; font-size: 0.9em; display: none; }

    /* Custom Success Banner */
    #successBanner {
        display: none;
        background: #22c55e;
        color: white;
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        font-weight: bold;
        text-align: center;
        animation: slideDown 0.5s ease;
    }
    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

<div class="game-wrapper">
    <h1>Optical Line Terminal (OLT) Terintegrasi</h1>
    <p class="subtitle">Eksplorasi Perangkat Keras Utama & Praktik SOP Kebersihan Fiber Optik</p>

    <div class="layout-grid">
        <div class="hardware-panel">
            
            <div class="olt-chassis">
                <div class="fan-tray" onclick="tampilkanInfo('fan')">
                    <div class="board-title" style="position:relative; top:0; color:#94a3b8;">FAN TRAY (PENDINGIN)</div>
                    <div class="fan"></div><div class="fan"></div><div class="fan"></div><div class="fan"></div>
                </div>

                <div class="board-area">
                    <div class="board board-power" onclick="tampilkanInfo('power')">
                        <div class="board-title">PWR</div>
                        <div class="power-socket"></div>
                    </div>

                    <div class="board board-mcb" onclick="tampilkanInfo('mcb')">
                        <div class="board-title">MAIN CONTROL / UPLINK</div>
                        <div class="uplink-port"></div>
                        <div class="uplink-port"></div>
                        <div class="uplink-port" style="border-radius: 50%; border-color: #64748b;"></div>
                    </div>

                    <div class="board board-pon" onclick="tampilkanInfo('pon')">
                        <div class="board-title">GPON SERVICE BOARD</div>
                        <div class="pon-slot" id="pon-1" ondrop="dropSFP(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">PON 1</div>
                        <div class="pon-slot">PON 2</div>
                        <div class="pon-slot">PON 3</div>
                        <div class="pon-slot">PON 4</div>
                        <div class="pon-slot">PON 5</div>
                        <div class="pon-slot">PON 6</div>
                        <div class="pon-slot">PON 7</div>
                        <div class="pon-slot">PON 8</div>
                    </div>
                </div>
            </div>

            <div class="toolbox">
                <div class="item-drag" id="sfp-module" draggable="true" ondragstart="drag(event)">🖲️ Modul SFP GPON C+</div>
                
                <div class="item-drag" id="patchcord" draggable="true" ondragstart="drag(event)" ondrop="dropCleaner(event)" ondragover="allowDrop(event)" ondragleave="leaveDrop(event)">
                    🔌 Patchcord FO (Kotor)
                </div>

                <div class="item-drag" id="fiber-cleaner" draggable="true" ondragstart="drag(event)">
                    🧴 Fiber Optic Cleaner
                </div>
            </div>

            <div class="monitor-screen" id="cli-monitor">
                > OLT OS v2.1.0 BOOTING... OK<br>
                > CHECKING GPON PORT 1... <span id="status-sfp" style="color: #ef4444;">EMPTY</span><br>
                > LASER TX POWER: <span id="status-tx" style="color: #64748b;">OFF</span><br>
                <span style="animation: blink 1s infinite;">_</span>
            </div>

            <div id="successBanner">
                Selamat! Anda telah menyelesaikan SOP Instalasi OLT. Status tugas Anda telah diperbarui menjadi Selesai.
                <br><br>
                <a href="{{ url('/') }}" style="color: white; text-decoration: underline; font-weight: bold;">Kembali ke Beranda</a>
            </div>
        </div>

        <div class="info-panel">
            <h3 id="info-title">Pengenalan Hardware OLT</h3>
            <div id="info-content">
                Klik komponen sasis OLT (Kipas, PWR, Main Control, atau GPON Board) untuk mempelajari arsitektur fisiknya.
                <br><br>
                <b>Instruksi Praktik:</b><br>
                1. Pasang <b>Modul SFP</b> ke port PON 1.<br>
                2. ⚠️ <b>AWAS:</b> Patchcord FO masih kotor! Tarik <b>Fiber Cleaner</b> ke atas kabel Patchcord untuk membersihkan debu mikroskopis.<br>
                3. Tarik Patchcord yang sudah bersih ke SFP untuk mengalirkan cahaya internet yang optimal.
            </div>
        </div>
    </div>
</div>

<script>
    // --- DATA MATERI EDUKASI (KAMUS) ---
    const materiOLT = {
        'fan': { judul: 'Fan Tray (Modul Kipas)', deskripsi: 'OLT memproses data bergiga-giga per detik yang menghasilkan panas ekstrem. Modul kipas ini bisa dicabut-pasang (hot-swappable) tanpa mematikan OLT. Jika kipas mati, OLT akan overheat dan internet ribuan pelanggan bisa putus.' },
        'power': { judul: 'DC Power Board', deskripsi: 'Menerima pasokan listrik DC -48V dari sistem kelistrikan Data Center. Biasanya teknisi memasang dua jalur kabel listrik (A dan B) sebagai backup ganda jika salah satu jalur listrik bermasalah.' },
        'mcb': { judul: 'Main Control & Uplink Board', deskripsi: 'Otak dari OLT (Switch Fabric). Mengatur routing, VLAN, dan manajemen data. Dilengkapi port Uplink (untuk menyambung ke Core Router/Internet) dan port Console untuk konfigurasi Command Line teknisi.' },
        'pon': { judul: 'GPON Service Board', deskripsi: 'Papan antarmuka optik pasif. Satu papan ini bisa melayani ribuan rumah. Port PON tidak akan memancarkan laser sampai teknisi memasang modul SFP (Small Form-factor Pluggable) ke dalamnya.' }
    };

    function tampilkanInfo(bagian) {
        document.getElementById('info-title').innerText = materiOLT[bagian].judul;
        document.getElementById('info-content').innerHTML = materiOLT[bagian].deskripsi;
    }

    // --- STATE & DRAG DROP LOGIC ---
    let sfpTerpasang = false;
    let kabelBersih = false;

    function allowDrop(ev) { ev.preventDefault(); ev.target.classList.add('drag-over'); }
    function leaveDrop(ev) { ev.target.classList.remove('drag-over'); }
    function drag(ev) { ev.dataTransfer.setData("text", ev.target.id); }

    // TAHAP 1: Pasang SFP
    function dropSFP(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.dataTransfer.getData("text") === "sfp-module" && ev.target.id === "pon-1") {
            document.getElementById('sfp-module').style.display = "none";
            ev.target.classList.add('has-sfp');
            ev.target.innerHTML = "SFP C+";
            
            sfpTerpasang = true;
            document.getElementById('patchcord').style.display = "flex";
            document.getElementById('fiber-cleaner').style.display = "flex"; // Munculkan alat pembersih
            
            document.getElementById('cli-monitor').style.display = "block";
            document.getElementById('status-sfp').innerText = "SFP GPON C+ READY";
            document.getElementById('status-sfp').style.color = "#22c55e";
            
            ev.target.setAttribute("ondrop", "dropKabel(event)");
        }
    }

    // TAHAP 2: Membersihkan Kabel (SOP Baru)
    function dropCleaner(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.dataTransfer.getData("text") === "fiber-cleaner") {
            document.getElementById('fiber-cleaner').style.display = "none"; // Alat habis dipakai
            
            let kabel = document.getElementById('patchcord');
            kabel.classList.add('cleaned');
            kabel.innerHTML = "✨ Patchcord FO (Bersih)";
            kabelBersih = true;
            
            document.getElementById('info-title').innerText = "Kebersihan Terjaga";
            document.getElementById('info-content').innerHTML = "Konektor optik kini bebas dari debu. Kabel siap dicolokkan ke SFP dengan tingkat redaman minimal.";
        }
    }

    // TAHAP 3: Colok Kabel ke PON
    function dropKabel(ev) {
        ev.preventDefault(); ev.target.classList.remove('drag-over');
        if (ev.dataTransfer.getData("text") === "patchcord" && sfpTerpasang) {
            document.getElementById('patchcord').style.display = "none";
            
            if (kabelBersih) {
                // Kabel Bersih -> Sinyal Sempurna
                ev.target.classList.add('has-cable');
                ev.target.innerHTML = "ON (OK)";
                document.getElementById('status-tx').innerText = "+3.00 dBm (OPTIMAL)";
                document.getElementById('status-tx').style.color = "#38bdf8";
                
                document.getElementById('info-title').innerText = "✅ INSTALASI SEMPURNA";
                document.getElementById('info-content').innerHTML = "Luar biasa! Karena kamu membersihkan ujung kabel terlebih dahulu, laser merambat sempurna tanpa hambatan debu. Redaman di pusat stabil.";

                // Panggil API Penyelesaian Tugas
                selesaikanTugasAPI();

            } else {
                // Kabel Kotor -> Loss Tinggi (Sinyal Buruk)
                ev.target.classList.add('has-dirty-cable');
                ev.target.innerHTML = "ON (WARN)";
                document.getElementById('status-tx').innerText = "+1.40 dBm (DEGRADED - HIGH LOSS)";
                document.getElementById('status-tx').style.color = "#ef4444";
                
                document.getElementById('info-title').innerText = "⚠️ PERINGATAN: DEGRADASI SINYAL";
                document.getElementById('info-content').innerHTML = "Kamu mencolokkan kabel yang kotor! Debu mikroskopis menghalangi pancaran laser. Daya yang seharusnya +3.00 dBm anjlok menjadi +1.40 dBm. Hal ini akan menyebabkan pelanggan di ujung jalan mengalami internet lambat atau putus-putus.<br><br><i>Silakan refresh halaman untuk mengulang dari awal.</i>";
            }
        }
    }

    // TAHAP Akhir: Mengirim Request Selesai
    function selesaikanTugasAPI() {
        document.getElementById('successBanner').style.display = 'block';

        // Kirim AJAX ke server Laravel
        fetch('{{ route("api.selesai.tugas") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ kategori: 'olt' })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Tugas berhasil diselesaikan di sistem:', data);
        })
        .catch(error => {
            console.error('Gagal memperbarui progres:', error);
        });
    }
</script>
@endsection
