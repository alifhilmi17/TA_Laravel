<!-- =========================================================
     SISTEM ADMINISTRASI PETERNAKAN (LIBAS)
     File: resources/views/login.blade.php
     Deskripsi: Halaman Login Laravel (Dual Role: Petugas & Admin)
========================================================= -->
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LIBAS - Akses Masuk</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

  <!-- CSS Login & SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('css/login/login.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <!-- ========================= EFEK BACKGROUND ANIMASI 3D ========================== -->
  <div class="shapes-container">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
  </div>

  <div class="background">
    <div class="noise-overlay"></div>
  </div>

  <!-- ========================= AREA FORM PANEL LOGIN ========================== -->
  <div class="login-wrapper">
    <div class="login-card-container">
      <div class="login-card" id="loginCard">

        <!-- SISI DEPAN: PILIHAN ROLE (FRONT FACE) -->
        <div class="card-face card-front">
          <div class="card-spotlight"></div>

          <!-- Logo Brand -->
          <div class="brand-icon" style="font-size: 48px; line-height: 1; margin-bottom: 16px; user-select: none;">
            🐔
          </div>

          <h2>Pilih Peran Akses</h2>
          <p class="subtitle" style="margin-bottom: 24px;">Silakan pilih peran Anda untuk masuk ke portal administrasi LIBAS.</p>

          <div class="role-selection-group">
            <!-- Tombol Pilih Petugas -->
            <button type="button" class="role-btn role-btn-petugas" id="btnRolePetugas">
              <div class="role-icon">👨‍🌾</div>
              <div class="role-info">
                <span class="role-title">Masuk sebagai Petugas</span>
                <span class="role-desc">Operator kandang & pencatat harian</span>
              </div>
              <div class="role-arrow">→</div>
            </button>

            <!-- Tombol Pilih Admin/Owner -->
            <button type="button" class="role-btn role-btn-admin" id="btnRoleAdmin">
              <div class="role-icon">👑</div>
              <div class="role-info">
                <span class="role-title">Masuk sebagai Admin</span>
                <span class="role-desc">Pengelola utama & Pemilik peternakan</span>
              </div>
              <div class="role-arrow">→</div>
            </button>
          </div>

          <div class="extra-links" style="margin-top: 30px;">
            <a href="{{ route('index') }}" style="font-size: 13px; opacity: 0.8;">← Kembali ke Beranda Utama</a>
          </div>
        </div>

        <!-- SISI BELAKANG: FORM LOGIN (BACK FACE) -->
        <div class="card-face card-back">
          <div class="card-spotlight"></div>

          <!-- Tombol Ganti Peran -->
          <button type="button" class="back-to-roles" id="btnBackToRoles" title="Kembali ke Pilihan Peran">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <line x1="19" y1="12" x2="5" y2="12"></line>
              <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Ganti Peran</span>
          </button>

          <h2 id="formTitle" style="margin-top: 10px;">Selamat Datang Kembali!</h2>
          <p class="subtitle" id="formSubtitle">Mohon isi data akses Anda untuk memasuki portal.</p>

          <!-- Form Login Laravel dengan Token CSRF -->
          <form action="{{ route('login.perform') }}" method="POST" id="loginForm">
            @csrf

            <!-- Input Hidden untuk Menyimpan Role Terpilih -->
            <input type="hidden" name="role" id="roleInput" value="petugas">

            <!-- Field Username -->
            <div class="input-group">
              <label for="username">Username Akses</label>
              <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username Anda" autocomplete="off" required autofocus>
              @error('username')
              <span style="color: #ff7e5f; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
              @enderror
            </div>

            <!-- Field Password -->
            <div class="input-group">
              <label for="password">Kata Sandi (Password)</label>
              <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Masukkan kode sandi" required>
                <span class="toggle-password" id="togglePassword" title="Tampilkan / Sembunyikan Sandi">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" fill="#fff" fill-opacity="0.7" />
                  </svg>
                </span>
              </div>
              @error('password')
              <span style="color: #ff7e5f; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
              @enderror
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="login-btn" id="loginBtn">
              <span class="btn-text">Masuk</span>
              <div class="loader"></div>
            </button>
          </form>

          <div class="extra-links" id="signupLinkContainer">
            <p>Belum sempat mendaftarkan diri? <a href="{{ route('signup') }}">Daftar Akun Baru</a></p>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Notification Error Handler via SweetAlert2 -->
  @if(session('error'))
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal Masuk',
      text: "{{ session('error') }}",
      confirmButtonColor: '#ff7e5f'
    });
  </script>
  @endif

  <!-- JS Interaktif Flip Card & Utilities -->
  <script src="{{ asset('js/login/login-interactive.js') }}"></script>
  <script src="{{ asset('js/shared/ui-utils.js') }}"></script>
  
  @if(session()->has('firebase_logout'))
  <script type="module">
    import { signOut } from "https://www.gstatic.com/firebasejs/10.9.0/firebase-auth.js";
    import { auth } from "{{ asset('js/firebase.component/firebase-init.js') }}";
    
    signOut(auth).then(() => {
        console.log("Firebase Auth synced logout successfully.");
    }).catch((err) => console.error(err));
  </script>
  @endif
</body>

</html>