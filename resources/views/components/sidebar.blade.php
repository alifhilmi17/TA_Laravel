<!-- =========================================================
     SISTEM ADMINISTRASI PETERNAKAN (LIBAS)
     File: resources/views/components/sidebar.blade.php
     Deskripsi: Komponen Sidebar Navigasi Reusable
========================================================= -->
<aside class="sidebar" aria-label="Sidebar Navigasi">
  <div class="sidebar-content">
    <!-- ===== LOGO BRAND ===== -->
    <h2 class="logo">🐔 LIBAS</h2>

    <!-- ===== NAVIGASI UTAMA ===== -->
    <nav class="main-nav">
      <!-- ===== MENU DASHBOARD ===== -->
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Dashboard">
        🏠 Dashboard
      </a>

      <!-- ===== FASE 2: SETUP POPULASI ===== -->
      <button type="button" class="has-submenu {{ request()->is('data-ayam*') ? 'active-parent' : '' }}" onclick="toggleSidebarMenu('ternakSubmenu')" aria-expanded="{{ request()->is('data-ayam*') ? 'true' : 'false' }}">
        🐣 Manajemen Populasi <span class="arrow">▸</span>
      </button>
      <div class="submenu {{ request()->is('data-ayam*') ? 'show' : '' }}" id="ternakSubmenu" aria-hidden="{{ request()->is('data-ayam*') ? 'false' : 'true' }}">
        <a href="{{ url('/data-ayam') }}" class="{{ request()->is('data-ayam') ? 'active' : '' }}">🐓 Data Batch Ayam</a>
      </div>

      <!-- ===== FASE 3: RUTINITAS HARIAN ===== -->
      <button type="button" class="has-submenu {{ request()->is('input-produksi*', 'kesehatan-ayam*') ? 'active-parent' : '' }}" onclick="toggleSidebarMenu('harianSubmenu')" aria-expanded="{{ request()->is('input-produksi*', 'kesehatan-ayam*') ? 'true' : 'false' }}">
        📋 Operasional Harian <span class="arrow">▸</span>
      </button>
      <div class="submenu {{ request()->is('input-produksi*', 'kesehatan-ayam*') ? 'show' : '' }}" id="harianSubmenu" aria-hidden="{{ request()->is('input-produksi*', 'kesehatan-ayam*') ? 'false' : 'true' }}">
        <a href="{{ url('/input-produksi') }}" class="{{ request()->is('input-produksi') ? 'active' : '' }}">📝 Input Produksi Telur</a>
        <a href="{{ url('/kesehatan-ayam') }}" class="{{ request()->is('kesehatan-ayam') ? 'active' : '' }}">🏥 Data Kesehatan & Vaksin</a>
      </div>

      <!-- ===== FASE 4: LOGISTIK & PERSEDIAAN ===== -->
      <button type="button" class="has-submenu {{ request()->is('stok-pakan*', 'restock-reminder*') ? 'active-parent' : '' }}" onclick="toggleSidebarMenu('persediaanSubmenu')" aria-expanded="{{ request()->is('stok-pakan*', 'restock-reminder*') ? 'true' : 'false' }}">
        📦 Stok & Logistik <span class="arrow">▸</span>
      </button>
      <div class="submenu {{ request()->is('stok-pakan*', 'restock-reminder*') ? 'show' : '' }}" id="persediaanSubmenu" aria-hidden="{{ request()->is('stok-pakan*', 'restock-reminder*') ? 'false' : 'true' }}">
        <a href="{{ url('/stok-pakan') }}" class="{{ request()->is('stok-pakan') ? 'active' : '' }}">🥬 Pencatatan Stok Pakan</a>
        <a href="{{ url('/restock-reminder') }}" class="{{ request()->is('restock-reminder') ? 'active' : '' }}">⏰ Restock Reminder</a>
      </div>

      <!-- ===== FASE 5: KEUANGAN ===== -->
      <button type="button" class="has-submenu {{ request()->is('keuangan*') ? 'active-parent' : '' }}" onclick="toggleSidebarMenu('keuanganSubmenu')" aria-expanded="{{ request()->is('keuangan*') ? 'true' : 'false' }}">
        💵 Pembukuan Finansial <span class="arrow">▸</span>
      </button>
      <div class="submenu {{ request()->is('keuangan*') ? 'show' : '' }}" id="keuanganSubmenu" aria-hidden="{{ request()->is('keuangan*') ? 'false' : 'true' }}">
        <a href="{{ url('/keuangan') }}" class="{{ request()->is('keuangan') ? 'active' : '' }}">💰 Pemasukan & Pengeluaran</a>
      </div>

      <!-- ===== FASE 6: PREDIKSI & ANALISIS ===== -->
      <button type="button" class="has-submenu {{ request()->is('prediksi-hasil*') ? 'active-parent' : '' }}" onclick="toggleSidebarMenu('kelolaSubmenu')" aria-expanded="{{ request()->is('prediksi-hasil*') ? 'true' : 'false' }}">
        🔮 Analisis Prediktif <span class="arrow">▸</span>
      </button>
      <div class="submenu {{ request()->is('prediksi-hasil*') ? 'show' : '' }}" id="kelolaSubmenu" aria-hidden="{{ request()->is('prediksi-hasil*') ? 'false' : 'true' }}">
        <a href="{{ url('/prediksi-hasil') }}" class="{{ request()->is('prediksi-hasil') ? 'active' : '' }}">📈 Prediksi Hasil & Laba</a>
      </div>

      <!-- ===== FASE 7: DOKUMEN & PELAPORAN ===== -->
      <button type="button" class="has-submenu {{ request()->is('dokumen*') ? 'active-parent' : '' }}" onclick="toggleSidebarMenu('dokumenSubmenu')" aria-expanded="{{ request()->is('dokumen*') ? 'true' : 'false' }}">
        📂 Pusat Dokumen <span class="arrow">▸</span>
      </button>
      <div class="submenu {{ request()->is('dokumen*') ? 'show' : '' }}" id="dokumenSubmenu" aria-hidden="{{ request()->is('dokumen*') ? 'false' : 'true' }}">
        <a href="{{ url('/dokumen') }}" class="{{ request()->is('dokumen') ? 'active' : '' }}">📄 Ekspor Laporan</a>
      </div>

      <!-- ===== PANEL KHUSUS ADMIN ===== -->
      @if(Auth::user() && (Auth::user()->role === 'admin' || Auth::user()->is_admin))
        <div id="adminSwitchContainer" style="margin-top: 1.5rem">
          <a href="{{ url('/admin') }}" class="admin-back-btn" title="Kembali ke Panel Kontrol">
            🛡️ Kembali ke Admin
          </a>
        </div>
      @endif
    </nav>

    <!-- ===== PROFIL PENGGUNA ===== -->
    <div class="sidebar-profile">
      <img src="{{ asset('images/profilepicture.png') }}" alt="Foto Profil" class="profile-pic" onclick="window.location.href='{{ url('/edit-profile') }}'" />
      <div class="profile-name-container">
        <p class="profile-name">{{ Auth::user()->name ?? 'Peternak' }}</p>
        <a href="{{ url('/edit-profile') }}" class="edit-profile-icon" title="Edit Profil">&#x270E;</a>
      </div>

      <!-- Form Logout Laravel -->
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">🚪 Logout</button>
      </form>
    </div>
  </div>
</aside>
