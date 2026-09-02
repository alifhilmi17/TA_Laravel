/* =========================================================
   SISTEM ADMINISTRASI PETERNAKAN (LIBAS)
   File: public/js/dashboard.js
   Deskripsi: Script grafik Chart.js untuk Dasbor Utama
========================================================= */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Grafik Tren Produksi Telur (7 Hari Terakhir)
    const eggChartCtx = document.getElementById('eggProductionChart');
    if (eggChartCtx) {
        new Chart(eggChartCtx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Butir Telur',
                    data: [1100, 1150, 1200, 1180, 1220, 1250, 1250],
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
                        data: [4500000, 4800000, 4200000, 5000000],
                        backgroundColor: '#10b981',
                        borderRadius: 6
                    },
                    {
                        label: 'Pengeluaran (Rp)',
                        data: [2300000, 2100000, 2500000, 2300000],
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
});
