/* =========================================================
   SISTEM ADMINISTRASI PETERNAKAN (LIBAS)
   File: public/js/shared/ui-utils.js
   Deskripsi: Kumpulan fungsi UI global & pemformat data
========================================================= */

window.formatTanggal = function(tglString) {
    if (!tglString) return "-";
    const options = { day: 'numeric', month: 'short', year: 'numeric' };
    return new Date(tglString + 'T00:00:00').toLocaleDateString('id-ID', options);
};

window.escapeHTML = function(str) {
    if (!str) return '-';
    if (typeof str !== 'string') return str;
    return str.replace(/[&<>'"]/g, tag => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;'
    }[tag] || tag));
};

window.formatRupiah = function(angka) {
    if (angka === undefined || angka === null || isNaN(angka)) return 'Rp 0';
    return 'Rp ' + Math.round(angka).toLocaleString('id-ID');
};

window.formatRibuan = function(angka) {
    if (angka === undefined || angka === null || isNaN(angka)) return '0';
    return Math.round(angka).toLocaleString('id-ID');
};

window.showToast = function(title, text, icon = 'success') {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
    } else {
        alert(`${title}: ${text}`);
    }
};

window.toggleSidebarMenu = function(menuId) {
    const menu = document.getElementById(menuId);
    if (menu) {
        const isShown = menu.classList.contains('show');
        menu.classList.toggle('show');
        menu.setAttribute('aria-hidden', isShown ? 'true' : 'false');

        const button = menu.previousElementSibling;
        if (button && button.classList.contains('has-submenu')) {
            button.setAttribute('aria-expanded', isShown ? 'false' : 'true');
        }
    }
};
