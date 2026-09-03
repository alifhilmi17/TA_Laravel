/* =========================================================
   SISTEM ADMINISTRASI PETERNAKAN (LIBAS)
   File: public/js/dashboard/dashboard.js
   Deskripsi: Script grafik & fetch data dinamis untuk Dasbor Utama
========================================================= */

import { collection, getDocs, query, orderBy } from "https://www.gstatic.com/firebasejs/10.9.0/firebase-firestore.js";
import { db } from "../firebase.component/firebase-init.js";

document.addEventListener('DOMContentLoaded', async () => {
    try {
        await loadDashboardData();
    } catch (error) {
        console.error("Gagal memuat data dashboard:", error);
        
        // Update DOM dengan pesan error jika gagal
        const statIds = ['stat-telur', 'stat-ayam', 'stat-mortalitas', 'stat-pakan', 'stat-pendapatan', 'stat-pengeluaran'];
        statIds.forEach(id => {
            const el = document.getElementById(id);
            if(el) el.innerText = "Error";
        });
    }
});

async function loadDashboardData() {
    // 1. Get Today's Date
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const todayStr = `${yyyy}-${mm}-${dd}`;
    
    // 2. Fetch all required collections concurrently
    const [populasiSnap, produksiSnap, pakanSnap, keuanganSnap] = await Promise.all([
        getDocs(collection(db, "populasi_ayam")),
        getDocs(query(collection(db, "produksi_harian"), orderBy("tanggal", "desc"))),
        getDocs(collection(db, "stok_pakan")),
        getDocs(collection(db, "keuangan"))
    ]);

    // --- QUICK STATS CALCULATION ---

    // A. Populasi Ayam
    let totalAyamAktif = 0;
    populasiSnap.forEach(doc => {
        const data = doc.data();
        if ((data.status || "").toLowerCase() === 'aktif') {
            totalAyamAktif += (parseInt(data.sisaAyam) || 0);
        }
    });

    // B. Produksi Harian & Mortalitas Hari Ini
    let totalTelurToday = 0;
    let mortalitasToday = 0;
    
    // Untuk Grafik Produksi 7 Hari (Senin-Minggu atau 7 hari terakhir)
    const produksiPerHari = {};

    produksiSnap.forEach(doc => {
        const data = doc.data();
        const tgl = data.tanggal; // format YYYY-MM-DD
        
        if (tgl === todayStr) {
            totalTelurToday += (parseInt(data.totalTelur) || 0);
            mortalitasToday += (parseInt(data.ayamMati) || 0);
        }

        if (!produksiPerHari[tgl]) {
            produksiPerHari[tgl] = 0;
        }
        produksiPerHari[tgl] += (parseInt(data.totalTelur) || 0);
    });

    // C. Stok Pakan
    let pakanMasuk = 0;
    let pakanKeluar = 0;
    pakanSnap.forEach(doc => {
        const data = doc.data();
        const tipe = (data.tipe || "").toLowerCase();
        const jumlah = parseFloat(data.jumlah) || 0;
        if (tipe === 'masuk') pakanMasuk += jumlah;
        else if (tipe === 'keluar') pakanKeluar += jumlah;
    });
    const stokPakan = pakanMasuk - pakanKeluar;

    // D. Keuangan Bulan Ini
    let pendapatanBulan = 0;
    let pengeluaranBulan = 0;
    
    // Untuk Grafik Keuangan (4 Minggu)
    let financeMingguan = {
        minggu1: { in: 0, out: 0 },
        minggu2: { in: 0, out: 0 },
        minggu3: { in: 0, out: 0 },
        minggu4: { in: 0, out: 0 }
    };

    keuanganSnap.forEach(doc => {
        const data = doc.data();
        
        const tgl = data.tanggal || "";
        if (tgl.startsWith(`${yyyy}-${mm}`)) { // Data bulan ini
            const tanggalAngka = parseInt(tgl.split('-')[2]);
            let nominal = parseFloat(data.nominal || data.jumlah || 0);
            
            // Cek jika field langsung spesifik
            let pemasukan = parseFloat(data.pemasukan || 0);
            let pengeluaran = parseFloat(data.pengeluaran || 0);
            
            const jenis = (data.jenis || data.tipe || "").toLowerCase();
            if (jenis === 'pemasukan' || jenis === 'pendapatan') {
                pemasukan = nominal > 0 ? nominal : pemasukan;
            } else if (jenis === 'pengeluaran') {
                pengeluaran = nominal > 0 ? nominal : pengeluaran;
            }

            pendapatanBulan += pemasukan;
            pengeluaranBulan += pengeluaran;

            // Kelompokkan ke 4 minggu (Minggu 1: 1-7, 2: 8-14, 3: 15-21, 4: 22+)
            if (tanggalAngka <= 7) {
                financeMingguan.minggu1.in += pemasukan;
                financeMingguan.minggu1.out += pengeluaran;
            } else if (tanggalAngka <= 14) {
                financeMingguan.minggu2.in += pemasukan;
                financeMingguan.minggu2.out += pengeluaran;
            } else if (tanggalAngka <= 21) {
                financeMingguan.minggu3.in += pemasukan;
                financeMingguan.minggu3.out += pengeluaran;
            } else {
                financeMingguan.minggu4.in += pemasukan;
                financeMingguan.minggu4.out += pengeluaran;
            }
        }
    });

    // --- UPDATE DOM ELEMENTS ---
    const telurEl = document.getElementById('stat-telur');
    if(telurEl) telurEl.innerText = `${totalTelurToday.toLocaleString('id-ID')} Butir`;

    const ayamEl = document.getElementById('stat-ayam');
    if(ayamEl) ayamEl.innerText = `${totalAyamAktif.toLocaleString('id-ID')} Ekor`;

    const mortEl = document.getElementById('stat-mortalitas');
    if(mortEl) mortEl.innerText = `${mortalitasToday.toLocaleString('id-ID')} Ekor`;

    const pakanEl = document.getElementById('stat-pakan');
    if(pakanEl) pakanEl.innerText = `${stokPakan.toLocaleString('id-ID')} Kg`;

    const inEl = document.getElementById('stat-pendapatan');
    if(inEl) inEl.innerText = `Rp ${pendapatanBulan.toLocaleString('id-ID')}`;

    const outEl = document.getElementById('stat-pengeluaran');
    if(outEl) outEl.innerText = `Rp ${pengeluaranBulan.toLocaleString('id-ID')}`;

    // --- UPDATE CHARTS ---
    
    // Siapkan label 7 hari terakhir (H-6 s/d H-0)
    const labels7Hari = [];
    const data7Hari = [];
    
    for (let i = 6; i >= 0; i--) {
        const d = new Date(today);
        d.setDate(d.getDate() - i);
        const y = d.getFullYear();
        const m = String(d.getMonth() + 1).padStart(2, '0');
        const dt = String(d.getDate()).padStart(2, '0');
        const dateStr = `${y}-${m}-${dt}`;
        
        // Nama Hari
        const hari = d.toLocaleDateString('id-ID', { weekday: 'short' });
        labels7Hari.push(hari);
        data7Hari.push(produksiPerHari[dateStr] || 0);
    }

    // 1. Grafik Tren Produksi Telur
    const eggChartCtx = document.getElementById('eggProductionChart');
    if (eggChartCtx) {
        new Chart(eggChartCtx, {
            type: 'line',
            data: {
                labels: labels7Hari,
                datasets: [{
                    label: 'Butir Telur',
                    data: data7Hari,
                    borderColor: '#ff7e5f',
                    backgroundColor: 'rgba(255, 126, 95, 0.15)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    // 2. Grafik Pemasukan vs Pengeluaran
    const financeChartCtx = document.getElementById('financeChart');
    if (financeChartCtx) {
        new Chart(financeChartCtx, {
            type: 'bar',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [
                    {
                        label: 'Pemasukan (Rp)',
                        data: [
                            financeMingguan.minggu1.in, 
                            financeMingguan.minggu2.in, 
                            financeMingguan.minggu3.in, 
                            financeMingguan.minggu4.in
                        ],
                        backgroundColor: '#10b981',
                        borderRadius: 6
                    },
                    {
                        label: 'Pengeluaran (Rp)',
                        data: [
                            financeMingguan.minggu1.out, 
                            financeMingguan.minggu2.out, 
                            financeMingguan.minggu3.out, 
                            financeMingguan.minggu4.out
                        ],
                        backgroundColor: '#ef4444',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
}
