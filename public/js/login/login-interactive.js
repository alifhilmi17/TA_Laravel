/* =========================================================
   SISTEM ADMINISTRASI PETERNAKAN (LIBAS)
   File: public/js/login/login-interactive.js
   Deskripsi: Logika interaktif Card Flip 3D & Toggle Password
========================================================= */

document.addEventListener('DOMContentLoaded', () => {
    const loginCard = document.getElementById('loginCard');
    const btnRolePetugas = document.getElementById('btnRolePetugas');
    const btnRoleAdmin = document.getElementById('btnRoleAdmin');
    const btnBackToRoles = document.getElementById('btnBackToRoles');
    const roleInput = document.getElementById('roleInput');
    const formTitle = document.getElementById('formTitle');
    const formSubtitle = document.getElementById('formSubtitle');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // 1. Klik Role Petugas -> Putar Kartu ke Depan Form Petugas
    if (btnRolePetugas) {
        btnRolePetugas.addEventListener('click', () => {
            if (loginCard) {
                loginCard.classList.remove('role-admin');
                loginCard.classList.add('role-petugas', 'flipped');
            }
            if (roleInput) roleInput.value = 'petugas';
            if (formTitle) formTitle.textContent = 'Login Petugas';
            if (formSubtitle) formSubtitle.textContent = 'Masukkan akun petugas kandang Anda.';
        });
    }

    // 2. Klik Role Admin -> Putar Kartu ke Depan Form Admin (Aksen Emas)
    if (btnRoleAdmin) {
        btnRoleAdmin.addEventListener('click', () => {
            if (loginCard) {
                loginCard.classList.remove('role-petugas');
                loginCard.classList.add('role-admin', 'flipped');
            }
            if (roleInput) roleInput.value = 'admin';
            if (formTitle) formTitle.textContent = 'Login Admin / Owner';
            if (formSubtitle) formSubtitle.textContent = 'Masukkan akun pengelola utama peternakan.';
        });
    }

    // 3. Tombol Ganti Peran -> Kembalikan Kartu ke Pilihan Role
    if (btnBackToRoles) {
        btnBackToRoles.addEventListener('click', () => {
            if (loginCard) {
                loginCard.classList.remove('flipped');
            }
        });
    }

    // 4. Toggle Tampilkan / Sembunyikan Kata Sandi
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        });
    }

    // 5. Efek Spotlight Kursor Kaca (Glassmorphism Spotlight)
    document.querySelectorAll('.card-face').forEach(face => {
        face.addEventListener('mousemove', (e) => {
            const rect = face.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            face.style.setProperty('--mouse-x', `${x}px`);
            face.style.setProperty('--mouse-y', `${y}px`);
        });
    });
});
