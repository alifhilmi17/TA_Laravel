/* =========================================================
   🐔 KODE SUMBER: INISIALISASI DATABASE (FIRESTORE)
   File: firebase-init.js
   ---------------------------------------------------------
   Deskripsi singkat:
   File ini berisi konfigurasi utama untuk menghubungkan 
   aplikasi web dengan layanan backend Google Firebase.
========================================================= */

// =========================================
// 1. IMPOR MODUL FIREBASE CORE
// =========================================
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.9.0/firebase-app.js";
import { getAuth } from "https://www.gstatic.com/firebasejs/10.9.0/firebase-auth.js";
import { getFirestore, enableIndexedDbPersistence } from "https://www.gstatic.com/firebasejs/10.9.0/firebase-firestore.js";

import { firebaseConfig } from './firebase-env.js';

// =========================================
// 2. KONFIGURASI KREDENSIAL APLIKASI
// =========================================
/* 
   Objek konfigurasi koneksi yang didapatkan dari platform Firebase Console.
   Berisi kumpulan "kunci rahasia" (API keys) dan alamat ID unik project Web.
*/
export { firebaseConfig };

// =========================================
// 3. INISIALISASI MESIN & EKSPOR LAYANAN
// =========================================
// Menjalankan mesin Firebase App memakai data kunci dari firebaseConfig
const app = initializeApp(firebaseConfig);

// Mengekspor variabel 'auth' (Layanan Autentikasi) yang siap digunakan 
// di file JS lain untuk memvalidasi user login atau registrasi
export const auth = getAuth(app);

// Mengekspor variabel 'db' (Layanan Firestore) 
// untuk dipakai menyimpan data biodata user dll
export const db = getFirestore(app);

// =========================================
// 4. MENGAKTIFKAN DUKUNGAN OFFLINE (INDEXEDDB)
// =========================================
enableIndexedDbPersistence(db).catch((err) => {
    if (err.code == 'failed-precondition') {
        console.warn("Offline Support: Multiple tabs open, persistence can only be enabled in one tab at a a time.");
    } else if (err.code == 'unimplemented') {
        console.warn("Offline Support: The current browser does not support all of the features required to enable persistence.");
    }
});
