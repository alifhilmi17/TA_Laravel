/* =========================================================
   🐔 KODE SUMBER: MANAJEMEN DATA AYAM (LOCAL STORAGE)
   File: dataAyamTAalip.js
   ---------------------------------------------------------
   Deskripsi singkat:
   File ini mengelola sistem penyimpanan, tampilan, perubahan, 
   dan penghapusan (CRUD) data Populasi Ayam secara dinamis 
   menggunakan Local Storage (versi Firebase di-comment).
========================================================= */

// --- KODE FIREBASE ---
import { 
    collection, 
    addDoc, 
    updateDoc, 
    deleteDoc, 
    doc, 
    getDocs, 
    onSnapshot,
    query, 
    orderBy 
} from "https://www.gstatic.com/firebasejs/10.9.0/firebase-firestore.js";
import { db } from "../firebase.component/firebase-init.js";

// =========================================
// 1. DEKLARASI STATE (DATA AWAL)
// =========================================
let dataAyam = [];
let dataKesehatan = [];

// --- KODE FIREBASE ---
const ayamCollection = collection(db, "populasi_ayam");
const kesehatanCollection = collection(db, "kesehatan_ayam");

let unsubscribeAyam = null;
let unsubscribeKesehatan = null;

// =========================================
// 2. MODUL UTILITAS
// =========================================
/**
 * Fungsi utilitas untuk memformat string tanggal menjadi format Indonesia yang mudah dibaca
 * (Fungsi tersedia di ui-utils.js)
 */

/**
 * Utilitas untuk mengamankan input teks dari serangan XSS (Cross-Site Scripting).
 * (Fungsi tersedia di ui-utils.js)
 */

// =========================================
// 3. INISIALISASI PROGRAM & FETCH DATA
// =========================================

document.addEventListener("DOMContentLoaded", () => {
    // --- KODE FIREBASE ---
    unsubscribeAyam = onSnapshot(query(ayamCollection, orderBy("tglMasuk", "desc")), (snapshot) => {
        dataAyam = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));
        renderTable();
        updateQuickStats();
    }, (error) => {
        console.error("Firestore Error (Ayam): ", error);
        Swal.fire("Error", "Gagal memuat data ayam.", "error");
    });

    unsubscribeKesehatan = onSnapshot(kesehatanCollection, (snapshot) => {
        dataKesehatan = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));
        updateQuickStats();
    }, (error) => {
        console.error("Firestore Error (Kesehatan): ", error);
    });
    
    // VERSI LOCAL STORAGE (DI-COMMENT)
    /*
    const localDataAyam = localStorage.getItem("populasi_ayam");
    if (localDataAyam) {
        dataAyam = JSON.parse(localDataAyam);
        // Sortir descending berdasarkan tglMasuk
        dataAyam.sort((a, b) => new Date(b.tglMasuk) - new Date(a.tglMasuk));
    }
    
    const localDataKesehatan = localStorage.getItem("kesehatan_ayam");
    if (localDataKesehatan) {
        dataKesehatan = JSON.parse(localDataKesehatan);
    }
    
    renderTable();
    updateQuickStats();
    */
});

/**
 * Memperbarui nilai angka-angka pada Kartu Info Statistik di atas tabel.
 * @param {Array} filteredData - Data yang sudah difilter (opsional)
 */
function updateQuickStats(filteredData = null) {
    const dataToCalculate = filteredData || dataAyam;
    let totalBatchAktif = 0;
    let totalSisaAyam = 0;
    let ayamSakit = 0;
    let setKandang = new Set();

    dataToCalculate.forEach(ayam => {
        const status = (ayam.status || "").trim().toLowerCase();
        // Menghitung batch aktif dan populasi ayam yang masih ada di kandang
        if (status === 'aktif') {
            totalBatchAktif++;
            const sisa = parseInt(ayam.sisaAyam) || 0;
            totalSisaAyam += sisa;
            
            if (ayam.kandang) {
                setKandang.add(ayam.kandang);
            }

            // Hitung ayam sakit HANYA untuk batch ini yang masih aktif
            const sakitDiBatchIni = dataKesehatan
                .filter(x => x.batchId === ayam.id && x.status === "Dalam Perawatan")
                .reduce((sum, item) => sum + (parseInt(item.jmlSakit) || 0), 0);
            
            ayamSakit += sakitDiBatchIni;
        }
    });
    
    // Total Populasi Ayam Aktif Sehat = Sisa Ayam - Ayam Sakit (Batch Aktif)
    const totalPopulasiSehat = totalSisaAyam - ayamSakit;

    const elTotalBatch = document.getElementById('totalBatch');
    const elTotalPopulasi = document.getElementById('totalPopulasi');
    const elKandangTerisi = document.getElementById('kandangTerisi');

    if (elTotalBatch) elTotalBatch.innerText = totalBatchAktif;
    
    // Tampilkan total populasi sehat (sudah dikurangi ayam sakit)
    if (elTotalPopulasi) {
        let displayText = totalPopulasiSehat.toLocaleString('id-ID') + ' Ekor';
        if (ayamSakit > 0) {
            displayText += ` (${ayamSakit.toLocaleString('id-ID')} Sakit)`;
        }
        elTotalPopulasi.innerText = displayText;
    }
    
    if (elKandangTerisi) elKandangTerisi.innerText = setKandang.size + ' Kandang';
}

/**
 * Merender daftar baris (row) ke dalam tag Tabel Body (<tbody>) HTML.
 */
function renderTable() {
    const tbody = document.getElementById("ayamTableBody");
    const emptyState = document.getElementById("emptyState");
    const tableEl = document.getElementById("ayamTable");

    if (!tbody) return;
    tbody.innerHTML = "";

    if (dataAyam.length === 0) {
        tableEl.style.display = "none";
        emptyState.style.display = "block";
    } else {
        tableEl.style.display = "table";
        emptyState.style.display = "none";

        dataAyam.forEach((ayam) => {
            // Normalisasi status untuk penentuan class badge
            const statusNormal = (ayam.status || "").trim().toLowerCase();
            let badgeClass = "badge-default"; // Class cadangan jika status tidak dikenal
            
            if (statusNormal === 'aktif') badgeClass = "badge-aktif";
            else if (statusNormal === 'panen') badgeClass = "badge-panen";
            else if (statusNormal === 'afkir') badgeClass = "badge-afkir";

            const row = document.createElement("tr");
            row.setAttribute('data-id', ayam.id); // BUG-07 FIX: Embed ID untuk searchTable
            row.innerHTML = `
                <td><strong>${ayam.customId || ayam.id.substring(0, 5)}</strong></td>
                <td>${formatTanggal(ayam.tglMasuk)}</td>
                <td>${escapeHTML(ayam.jenis)}</td>
                <td>${(parseInt(ayam.jumlahAwal) || 0).toLocaleString('id-ID')}</td>
                <td><strong>${(parseInt(ayam.sisaAyam) || 0).toLocaleString('id-ID')}</strong></td>
                <td>${escapeHTML(ayam.kandang)}</td>
                <td><span class="badge ${badgeClass}">${ayam.status}</span></td>
                <td>
                    <button class="btn-edit" onclick="editAyam('${ayam.id}')">✏️ Edit</button>
                    <button class="btn-delete" onclick="deleteAyam('${ayam.id}')">🗑️ Hapus</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }
}

// =========================================
// 4. LOGIKA MODAL DAN CRUD FIRESTORE -> LOCAL STORAGE
// =========================================
const modal = document.getElementById('ayamModal');
const form = document.getElementById('ayamForm');

/**
 * Membuka jendela modal untuk menambah data batch ayam baru
 */
window.openAyamModal = function() {
    form.reset(); // Bersihkan formulir
    document.getElementById('ayamId').value = ""; // Pastikan ID kosong (Mode Tambah)
    document.getElementById('modalTitle').innerText = "Tambah Batch Ayam";
    
    // Otomatisasi sisaAyam agar mengikuti jumlahAwal saat pertama kali diinput
    const inputAwal = document.getElementById('jumlahAwal');
    const inputSisa = document.getElementById('sisaAyam');
    
    // Remove existing event listener before adding to avoid duplicates (safeguard)
    const newAwal = inputAwal.cloneNode(true);
    inputAwal.parentNode.replaceChild(newAwal, inputAwal);
    
    newAwal.addEventListener('input', () => {
        if (document.getElementById('ayamId').value === "") { // Hanya saat tambah baru
            inputSisa.value = newAwal.value;
        }
    });

    modal.classList.add('show'); // Tampilkan modal dengan class CSS
};

/**
 * Menutup jendela modal data ayam
 */
window.closeAyamModal = function() {
    modal.classList.remove('show');
};

/**
 * Menyimpan data ayam ke Firestore (Sekarang Local Storage)
 */
window.saveAyamData = async function(event) {
    event.preventDefault(); // Mencegah reload halaman

    // Menangkap nilai-nilai dari input form
    const docId = document.getElementById('ayamId').value;
    const tglMasuk = document.getElementById('tglMasuk').value;
    const jenisAyam = document.getElementById('jenisAyam').value;
    const jumlahAwal = parseInt(document.getElementById('jumlahAwal').value) || 0;
    const sisaAyam = parseInt(document.getElementById('sisaAyam').value) || 0;
    const kandang = document.getElementById('kandang').value;
    const statusAyam = document.getElementById('statusAyam').value;

    // Objek paket data (payload) yang akan dikirim ke database
    const payload = {
        tglMasuk,
        jenis: jenisAyam,
        jumlahAwal,
        sisaAyam,
        kandang,
        status: statusAyam,
        updatedAt: new Date().toISOString()
    };

    try {
        if (docId === "") {
            // LOGIKA MODE TAMBAH BARU (GLOBAL COUNTER + FORMAT TANGGAL)
            // 1. Ambil tanggal dari input form agar ID sinkron dengan data
            const dateStr = tglMasuk.replace(/-/g, ''); // Mengubah 2026-05-11 menjadi 20260511

            // 2. Cari counter tertinggi secara GLOBAL (semua batch)
            let maxCounter = 0;
            dataAyam.forEach(item => {
                if (item.customId && item.customId.startsWith('B-')) {
                    const parts = item.customId.split('-');
                    const lastPart = parts[parts.length - 1];
                    const num = parseInt(lastPart);
                    if (!isNaN(num) && num > maxCounter) maxCounter = num;
                }
            });

            const nextCounter = maxCounter + 1;
            const customId = `B-${dateStr}-${String(nextCounter).padStart(3, '0')}`;
            payload.customId = customId;
            payload.createdAt = new Date().toISOString();
            
            // --- KODE FIREBASE ---
            await addDoc(ayamCollection, payload);
            
            // VERSI LOCAL STORAGE (DI-COMMENT)
            /*
            payload.id = 'L-' + Date.now().toString(36) + Math.random().toString(36).substr(2, 5); // Generate unique ID
            dataAyam.push(payload);
            */
            
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data batch baru berhasil ditambahkan.',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            // LOGIKA MODE EDIT/UPDATE DATA LAMA
            // --- KODE FIREBASE ---
            const docRef = doc(db, "populasi_ayam", docId);
            await updateDoc(docRef, payload); // Perbarui dokumen di Firestore
            
            // VERSI LOCAL STORAGE (DI-COMMENT)
            /*
            const index = dataAyam.findIndex(a => a.id === docId);
            if (index !== -1) {
                dataAyam[index] = { ...dataAyam[index], ...payload };
            }
            */
            
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data ayam diperbarui.',
                timer: 2000,
                showConfirmButton: false
            });
        }
        
        // Simpan ke local storage (DI-COMMENT)
        /*
        localStorage.setItem("populasi_ayam", JSON.stringify(dataAyam));
        
        // Sorting dan Update UI
        dataAyam.sort((a, b) => new Date(b.tglMasuk) - new Date(a.tglMasuk));
        renderTable();
        updateQuickStats();
        */
        
        window.closeAyamModal(); // Tutup modal setelah sukses
    } catch (error) {
        console.error("Error saving document: ", error);
        Swal.fire("Error", "Gagal menyimpan data: " + error.message, "error");
    }
};

/**
 * Mengisi formulir modal dengan data ayam yang dipilih untuk diedit
 * @param {string} id - UID dokumen Firestore
 */
window.editAyam = function(id) {
    const ayam = dataAyam.find(a => a.id === id); // Cari data di memori lokal (state)
    if (ayam) {
        // Prefill kolom-kolom form
        document.getElementById('ayamId').value = ayam.id;
        document.getElementById('tglMasuk').value = ayam.tglMasuk;
        document.getElementById('jenisAyam').value = ayam.jenis;
        document.getElementById('jumlahAwal').value = ayam.jumlahAwal;
        document.getElementById('sisaAyam').value = ayam.sisaAyam;
        document.getElementById('kandang').value = ayam.kandang;
        document.getElementById('statusAyam').value = ayam.status;

        document.getElementById('modalTitle').innerText = "Edit Batch " + (ayam.customId || "");
        modal.classList.add('show');
    }
};

/**
 * Menghapus data batch ayam secara permanen dari Firestore
 * @param {string} id - UID dokumen Firestore
 */
window.deleteAyam = function(id) {
    Swal.fire({
        title: 'Hapus Data Batch?',
        text: "Peringatan: Seluruh data Produksi Harian dan Rekam Medis (Kesehatan) milik batch ini juga akan ikut terhapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff6b6b',
        cancelButtonColor: '#999',
        confirmButtonText: 'Ya, Hapus Semua!',
        cancelButtonText: 'Batal'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                // Tampilkan loading karena proses bisa memakan waktu
                Swal.fire({
                    title: 'Menghapus data...',
                    html: 'Mohon tunggu sejenak.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                // --- KODE FIREBASE ---
                // 1. Hapus semua data kesehatan terkait
                const kesSnapshot = await getDocs(collection(db, "kesehatan_ayam"));
                const kesPromises = [];
                kesSnapshot.forEach(docSnap => {
                    if (docSnap.data().batchId === id) kesPromises.push(deleteDoc(docSnap.ref));
                });
                
                // 2. Hapus semua data produksi terkait
                const prodSnapshot = await getDocs(collection(db, "produksi_harian"));
                const prodPromises = [];
                prodSnapshot.forEach(docSnap => {
                    if (docSnap.data().batchId === id) prodPromises.push(deleteDoc(docSnap.ref));
                });
                
                // Eksekusi cascade delete paralel
                await Promise.all([...kesPromises, ...prodPromises]);

                // 3. Hapus data batch utama
                await deleteDoc(doc(db, "populasi_ayam", id)); // Hapus dari Firestore

                // VERSI LOCAL STORAGE (DI-COMMENT)
                /*
                // Hapus kesehatan
                let localDataKes = localStorage.getItem("kesehatan_ayam");
                if (localDataKes) {
                    let kes = JSON.parse(localDataKes);
                    kes = kes.filter(k => k.batchId !== id);
                    localStorage.setItem("kesehatan_ayam", JSON.stringify(kes));
                    dataKesehatan = kes;
                }
                
                // Hapus produksi
                let localDataProd = localStorage.getItem("produksi_harian");
                if (localDataProd) {
                    let prod = JSON.parse(localDataProd);
                    prod = prod.filter(p => p.batchId !== id);
                    localStorage.setItem("produksi_harian", JSON.stringify(prod));
                }
                
                // Hapus ayam
                dataAyam = dataAyam.filter(a => a.id !== id);
                localStorage.setItem("populasi_ayam", JSON.stringify(dataAyam));
                
                renderTable();
                updateQuickStats();
                */

                Swal.fire('Terhapus!', 'Data batch beserta riwayatnya telah dihapus.', 'success');
            } catch (error) {
                Swal.fire("Error", "Gagal menghapus data: " + error.message, "error");
            }
        }
    });
};

/**
 * Fitur pencarian cepat di tabel (Client-side filtering)
 * Juga memperbarui kartu statistik agar sesuai dengan data yang tampil
 */
window.searchTable = function() {
    const input = document.getElementById("searchAyam").value.toLowerCase();
    const rows = document.querySelectorAll("#ayamTableBody tr");
    
    // BUG-07 FIX: Gunakan data-id attribute di setiap baris, bukan DOM index.
    // DOM index tidak sinkron dengan array dataAyam setelah sorting/filtering.
    const filteredResults = [];

    rows.forEach((row) => {
        const textContent = row.innerText.toLowerCase();
        const isMatch = textContent.includes(input);
        row.style.display = isMatch ? "" : "none";
        
        if (isMatch) {
            const rowId = row.getAttribute('data-id');
            if (rowId) {
                const matchedData = dataAyam.find(a => a.id === rowId);
                if (matchedData) filteredResults.push(matchedData);
            }
        }
    });

    // Update kartu statistik berdasarkan hasil pencarian
    updateQuickStats(filteredResults.length > 0 || input ? filteredResults : undefined);
};

/**
 * Mengunduh seluruh ringkasan data ayam dalam format berkas CSV
 */
window.downloadLaporanCSV = function() {
    if (dataAyam.length === 0) {
        Swal.fire({ icon: 'warning', title: 'Data Kosong', text: 'Tidak ada data ayam untuk diekspor.' });
        return;
    }

    // Header Tabel CSV
    let csvContent = "ID Batch,Tanggal Masuk,Jenis Telur Ayam,Populasi Awal,Sisa Ayam,Kandang,Status\n";
    
    // Looping data menjadi baris teks CSV
    dataAyam.forEach(ayam => {
        let row = `${ayam.customId || ayam.id},${ayam.tglMasuk},${ayam.jenis},${ayam.jumlahAwal},${ayam.sisaAyam},${ayam.kandang},${ayam.status}`;
        csvContent += row + "\n";
    });

    // Proses download browser
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    let date = new Date();
    let fileDate = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
    link.setAttribute("download", `Laporan_Data_Ayam_${fileDate}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

