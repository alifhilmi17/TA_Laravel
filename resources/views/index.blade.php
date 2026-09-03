<!-- =========================================================
     🐔 KODE SUMBER: HALAMAN UTAMA (LANDING PAGE)
     File: index.blade.php
     ---------------------------------------------------------
     Deskripsi singkat:
     File ini menangani antarmuka halaman selamat datang (Landing Page)
     sebagai gerbang masuk utama sistem LIBAS.
========================================================= -->
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Lintau Buo Administration System - Portal Profesional Peternakan">

  <title>Selamat Datang di LIBAS</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- File CSS via Helper Asset Laravel -->
  <link rel="stylesheet" href="{{ asset('css/index/index.css') }}">
</head>

<body>

  <!-- ===== 1. AREA BACKGROUND ===== -->
  <div class="background-wrapper">
    <div class="glow-orb orb-1"></div>
    <div class="glow-orb orb-2"></div>
    <div class="glow-orb orb-3"></div>
    <div class="noise-overlay"></div>
  </div>

  <!-- ===== 2. KONTEN UTAMA (HERO SECTION) ===== -->
  <main class="hero-container">
    <div class="hero-glass">

      <!-- Logo Brand -->
      <div class="brand-icon" style="font-size: 42px; line-height: 1; user-select: none;">
        🐔
      </div>

      <!-- Judul Sambutan -->
      <h1 class="welcome-title">Selamat Datang di <span class="gradient-text">LIBAS</span></h1>
      <p class="subtitle">Lintau Buo Administration</p>

      <!-- Badge Fitur -->
      <div class="features-list">
        <span class="badge">Profesional</span>
        <span class="badge">Efisien</span>
        <span class="badge">Terorganisir</span>
      </div>

      <!-- Tombol Autentikasi -->
      <div class="auth-buttons">

        <!-- Tombol Login -->
        <a href="{{ route('login') }}" class="btn btn-primary" title="Masuk ke Akun Anda">
          <span>Masuk ke Portal</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3" />
          </svg>
        </a>

        <!-- Tombol Pendaftaran -->
        <a href="#" class="btn btn-secondary" title="Daftar sebagai Petugas Baru">
          <span>Buat Akun Petugas</span>
        </a>

      </div>
    </div>
  </main>

  <!-- ========================= SCRIPT UTAMA ========================== -->
  <script src="{{ asset('js/shared/ui-utils.js') }}"></script>
</body>

</html>
