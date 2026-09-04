/* =========================================================
   CORE ALGORITHM: MOVING AVERAGE (MA)
   File: ma-core.js
   ---------------------------------------------------------
   Deskripsi singkat:
   File ini berisi pure function untuk kalkulasi statistik 
   Algoritma Moving Average dan evaluasi akurasi (MAE).
========================================================= */

/**
 * Menghitung prediksi menggunakan algoritma Moving Average.
 * 
 * @param {Array} historyData - Array data historis (urutan lama ke baru)
 * @param {number} periodeMA - Jumlah hari yang digunakan untuk rata-rata (N)
 * @param {number} forecastDays - Jumlah hari ke depan yang ingin diprediksi
 * @param {number} penaltyFactor - Faktor penalti (0.0 - 1.0) untuk simulasi ayam sakit
 * @returns {Object} - Prediksi hari esok dan array proyeksi masa depan
 */
window.calculateMovingAverage = function(historyData, periodeMA, forecastDays, penaltyFactor) {
    let currentData = [...historyData];
    let proyeksiMasaDepan = [];
    
    // 1. Prediksi untuk besok (H+1)
    let sum = 0;
    for (let i = currentData.length - periodeMA; i < currentData.length; i++) {
        sum += currentData[i];
    }
    let prediksiBesok = sum / periodeMA;
    
    // Terapkan penalti jika ada faktor penyakit/kematian tinggi
    if (penaltyFactor > 0) {
        prediksiBesok = prediksiBesok * (1 - penaltyFactor);
    }
    
    // 2. Prediksi berantai (Chain Forecasting) untuk N hari ke depan
    let simData = [...currentData];
    for (let d = 0; d < forecastDays; d++) {
        let simSum = 0;
        for (let i = simData.length - periodeMA; i < simData.length; i++) {
            simSum += simData[i];
        }
        let nextPred = simSum / periodeMA;
        
        // Terapkan penalti secara persisten
        if (penaltyFactor > 0) {
            nextPred = nextPred * (1 - penaltyFactor);
        }
        
        proyeksiMasaDepan.push(nextPred);
        
        // Masukkan hasil tebakan ini ke dalam array sebagai "data historis" 
        // untuk perhitungan tebakan di hari berikutnya
        simData.push(nextPred);
    }
    
    return {
        prediksiBesok: prediksiBesok,
        proyeksiMasaDepan: proyeksiMasaDepan
    };
};

/**
 * Mengevaluasi seberapa akurat model MA yang dipilih menggunakan 
 * Mean Absolute Error (MAE) terhadap data historis (Backtesting).
 * 
 * @param {Array} evalDataButir - Array data aktual produksi masa lalu (dalam Butir)
 * @param {number} periodeMA - Periode MA yang sedang dievaluasi
 * @returns {Object} - Hasil evaluasi (MAE, Persentase Akurasi)
 */
window.evaluateModelAccuracy = function(evalDataButir, periodeMA) {
    let mae = 0;
    let validCount = 0;
    let akurasi = 0;
    
    // Evaluasi hanya bisa dilakukan jika data yang tersedia lebih banyak dari periode MA
    if (evalDataButir.length > periodeMA) {
        let totalError = 0;
        
        // Lakukan simulasi prediksi mundur ke masa lalu, dan cocokkan dengan data aktual yang sudah terjadi
        for (let i = periodeMA; i < evalDataButir.length; i++) {
            let sum = 0;
            // Ambil data N hari ke belakang dari titik i
            for (let j = i - periodeMA; j < i; j++) {
                sum += evalDataButir[j];
            }
            let pred = sum / periodeMA;
            let actual = evalDataButir[i];
            
            // Hitung selisih mutlak
            totalError += Math.abs(pred - actual);
            validCount++;
        }
        
        mae = totalError / validCount;
        
        // Hitung rata-rata aktual sebagai basis (baseline) perbandingan persentase
        let sumActual = 0;
        for (let i = periodeMA; i < evalDataButir.length; i++) {
            sumActual += evalDataButir[i];
        }
        let avgActual = sumActual / validCount;
        
        // Kalkulasi Akurasi (%) = 100% - (Error Margin)
        if (avgActual > 0) {
            let errorPercentage = (mae / avgActual) * 100;
            akurasi = Math.max(0, 100 - errorPercentage);
        }
    }
    
    return {
        mae: mae,
        akurasi: akurasi,
        isAkurasiValid: validCount > 0
    };
};
