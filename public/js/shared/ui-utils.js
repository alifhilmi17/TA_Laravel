/* =========================================================
   🐔 KODE SUMBER: UTILITAS ANTARMUKA & FORMAT DATA
   File: ui-utils.js
   ---------------------------------------------------------
   Deskripsi singkat:
   File ini berisi kumpulan fungsi global untuk manipulasi UI,
   pemformatan tanggal, mata uang, dan notifikasi SweetAlert.
========================================================= */

// =========================================
// 1. FUNGSI PEMFORMATAN DATA
// =========================================
/**
 * Memformat string tanggal (YYYY-MM-DD) menjadi format bahasa Indonesia (DD MMM YYYY).
 * @param {string} tglString - String tanggal
 * @returns {string} Tanggal yang diformat
 */
window.formatTanggal = function (tglString) {
    if (!tglString) return "-";
    const options = { day: "numeric", month: "short", year: "numeric" };
    return new Date(tglString + "T00:00:00").toLocaleDateString(
        "id-ID",
        options,
    );
};

/**
 * Mendapatkan tanggal hari ini dalam format YYYY-MM-DD sesuai zona waktu lokal.
 * Berguna untuk set default value pada input type="date".
 * @returns {string} Tanggal dalam format YYYY-MM-DD
 */
window.getLocalDateString = function () {
    const today = new Date();
    const offset = today.getTimezoneOffset() * 60000;
    return new Date(today.getTime() - offset).toISOString().split("T")[0];
};

/**
 * Mencegah XSS dengan mengkonversi karakter khusus HTML menjadi entitas.
 * @param {string} str - Teks input
 * @returns {string} Teks yang sudah aman (escaped)
 */
window.escapeHTML = function (str) {
    if (!str) return "-";
    if (typeof str !== "string") return str;
    return str.replace(
        /[&<>'"]/g,
        (tag) =>
            ({
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                "'": "&#39;",
                '"': "&quot;",
            })[tag] || tag,
    );
};

/**
 * Memformat angka menjadi format mata uang Rupiah (Rp X.XXX.XXX).
 * @param {number|string} angka - Nilai nominal uang
 * @returns {string} Format Rupiah
 */
window.formatRupiah = function (angka) {
    if (angka === undefined || angka === null || isNaN(angka)) return "Rp 0";
    return "Rp " + Math.round(angka).toLocaleString("id-ID");
};

/**
 * Memformat angka dengan pemisah ribuan standar Indonesia (X.XXX).
 * @param {number|string} angka - Nilai angka bulat/desimal
 * @returns {string} Angka dengan pemisah ribuan
 */
window.formatRibuan = function (angka) {
    if (angka === undefined || angka === null || isNaN(angka)) return "0";
    return Math.round(angka).toLocaleString("id-ID");
};

/**
 * Memformat input teks secara langsung saat mengetik (oninput)
 * agar memiliki pemisah ribuan otomatis (hanya angka).
 * @param {HTMLInputElement} input - Elemen input
 */
window.formatNumberInput = function (input) {
    if (!input) return;
    let value = input.value.replace(/[^0-9]/g, "");
    if (value === "") {
        input.value = "";
        return;
    }
    input.value = parseInt(value, 10).toLocaleString("id-ID");
};

// =========================================
// 2. FUNGSI NOTIFIKASI & KOMPONEN UI
// =========================================

/**
 * Menampilkan notifikasi popup ringan (Toast) menggunakan SweetAlert2.
 * @param {string} title - Judul notifikasi
 * @param {string} text - Pesan detail
 * @param {string} icon - Tipe ikon ('success', 'error', 'info', dll)
 */
window.showToast = function (title, text, icon = "success") {
    if (typeof Swal !== "undefined") {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
    } else {
        alert(`${title}: ${text}`);
    }
};

/**
 * Membuka atau menutup menu anak (submenu) pada Sidebar Navigasi.
 * @param {string} menuId - ID elemen submenu yang dituju
 */
window.toggleSidebarMenu = function (menuId) {
    const menu = document.getElementById(menuId);
    if (menu) {
        const isShown = menu.classList.contains("show");
        menu.classList.toggle("show");
        menu.setAttribute("aria-hidden", isShown ? "true" : "false");

        const button = menu.previousElementSibling;
        if (button && button.classList.contains("has-submenu")) {
            button.setAttribute("aria-expanded", isShown ? "false" : "true");
        }
    }
};
