document.addEventListener('DOMContentLoaded', () => {
    // 1. FILTER KATALOG INTERAKTIF
    const tabBtns = document.querySelectorAll('.tab-btn');
    const cards = document.querySelectorAll('.card');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const filter = btn.dataset.filter;
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.type === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // 2. MODAL POP-UP DETAIL
    const modal = document.getElementById('deviceModal');
    if (modal) {
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', () => {
                document.getElementById('modalName').innerText = card.dataset.name;
                document.getElementById('modalDesc').innerText = card.dataset.desc;
                document.getElementById('modalLoss').innerText = `Default Loss: ${card.dataset.loss} dB`;
                modal.style.display = 'flex';
            });
        });

        document.querySelector('.close-modal').addEventListener('click', () => modal.style.display = 'none');
        window.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });
    }

    // 3. FETCH API AJAX SIMULASI LPB
    const simForm = document.getElementById('simForm');
    if (simForm) {
        simForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btnSubmit = simForm.querySelector('button[type="submit"]');
            btnSubmit.innerText = 'Menghitung...';
            btnSubmit.disabled = true;

            try {
                const response = await fetch('/simulasi/calculate', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: new FormData(simForm)
                });
                
                const res = await response.json();
                if (res.success) {
                    const resultBox = document.getElementById('resultBox');
                    const isLayak = res.data.status_link === 'Layak';
                    const statusClass = isLayak ? 'status-layak' : 'status-tidak-layak';
                    
                    resultBox.style.display = 'block';
                    resultBox.style.borderColor = isLayak ? 'var(--success)' : 'var(--danger)';
                    resultBox.innerHTML = `
                        <h3 style="margin-top:0;">Hasil LPB (${res.kode_simulasi})</h3>
                        <p>Total Redaman (Loss): <strong>${res.data.total_loss} dB</strong></p>
                        <p>Daya Terima (Rx): <strong>${res.data.daya_terima} dBm</strong></p>
                        <p>Status: <span class="${statusClass}">${res.data.status_link}</span></p>
                    `;
                }
            } catch (err) {
                alert("Gagal melakukan kalkulasi. Periksa koneksi.");
            } finally {
                btnSubmit.innerText = 'Hitung Redaman';
                btnSubmit.disabled = false;
            }
        });
    }
});
