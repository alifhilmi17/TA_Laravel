<!-- =========================================================
     SISTEM ADMINISTRASI PETERNAKAN (LIBAS)
     File: resources/views/dashboard.blade.php
     Deskripsi: Halaman Dasbor Utama (Dashboard) Laravel
========================================================= -->
@extends('layouts.layout')

@section('title', 'LIBAS - Dasbor Utama')

@section('content')
  <!-- Header Mobile -->
  <header class="mobile-header">
    <div class="mobile-logo">🐔 LIBAS</div>
    <button class="menu-toggle" onclick="document.querySelector('.sidebar').classList.toggle('active')">☰</button>
  </header>

  <!-- Kartu Sambutan -->
  <section class="welcome-card animate__animated animate__fadeInDown">
    <h2>Selamat Datang Kembali, {{ Auth::user()->name ?? 'Peternak' }}! 🐣</h2>
    <p>Kelola pakan, jadwal produksi, dan keuangan peternakan Anda dengan efisien.</p>
  </section>

  <!-- 1. STATISTIK CEPAT -->
  <section class="quick-stats animate__animated animate__fadeInUp">
    <div class="stat-card">
      <div class="stat-icon">🥚</div>
      <div class="stat-info">
        <h4>Total Telur Hari Ini</h4>
        <p id="stat-telur">{{ number_format($stats['total_telur_today'] ?? 1250, 0, ',', '.') }} Butir</p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon">🐓</div>
      <div class="stat-info">
        <h4>Total Ayam Aktif</h4>
        <p id="stat-ayam">{{ number_format($stats['total_ayam_aktif'] ?? 1500, 0, ',', '.') }} Ekor</p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon">💀</div>
      <div class="stat-info">
        <h4>Mortalitas Hari Ini</h4>
        <p id="stat-mortalitas">{{ $stats['mortalitas_today'] ?? 1 }} Ekor</p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon">🌾</div>
      <div class="stat-info">
        <h4>Stok Pakan Tersisa</h4>
        <p id="stat-pakan">{{ $stats['stok_pakan_kg'] ?? 450 }} Kg</p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon">💰</div>
      <div class="stat-info">
        <h4>Pendapatan Bulan Ini</h4>
        <p id="stat-pendapatan">Rp {{ number_format($stats['pendapatan_bulan'] ?? 18500000, 0, ',', '.') }}</p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon">💸</div>
      <div class="stat-info">
        <h4>Pengeluaran Bulan Ini</h4>
        <p id="stat-pengeluaran">Rp {{ number_format($stats['pengeluaran_bulan'] ?? 9200000, 0, ',', '.') }}</p>
      </div>
    </div>
  </section>

  <!-- 2. GRAFIK ANALITIK -->
  <section class="charts-section animate__animated animate__fadeInUp">
    <div class="chart-container chart-produksi-card">
      <div class="chart-header">
        <div class="chart-title-group">
          <h3>📈 Tren Produksi Telur (7 Hari Terakhir)</h3>
        </div>
      </div>
      <div class="chart-canvas-wrapper" style="padding: 1rem; height: 300px;">
        <canvas id="eggProductionChart"></canvas>
      </div>
    </div>

    <div class="chart-container">
      <h3>📊 Pemasukan vs Pengeluaran</h3>
      <div style="padding: 1rem; height: 300px;">
        <canvas id="financeChart"></canvas>
      </div>
    </div>
  </section>

  <!-- 3. AKSI CEPAT & JADWAL VAKSINASI -->
  <section class="widgets-row animate__animated animate__fadeInUp">
    <!-- Kartu Kiri: Aksi Cepat -->
    <div class="widget-card-purple">
      <!-- Header -->
      <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1.25rem;">
        <span style="font-size: 1.5rem; line-height: 1;">⚡</span>
        <div>
          <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0; color: #fff;">Aksi Cepat</h3>
          <p style="font-size: 0.85rem; margin: 0; opacity: 0.9; color: #fff;">Operasi harian dalam satu klik</p>
        </div>
      </div>

      <!-- Grid 2x2 Tombol Aksi Cepat -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem; margin-bottom: 0.85rem;">
        <!-- Input Produksi -->
        <button type="button" onclick="window.location.href='{{ url('/input-produksi') }}'" class="qa-grid-btn">
          <div style="font-size: 1.3rem; margin-bottom: 0.25rem;">🥚</div>
          <div style="font-weight: 700; font-size: 0.9rem;">Input Produksi</div>
          <div style="font-size: 0.72rem; opacity: 0.8;">Catat hasil telur hari ini</div>
        </button>

        <!-- Kelola Pakan -->
        <button type="button" onclick="window.location.href='{{ url('/stok-pakan') }}'" class="qa-grid-btn">
          <div style="font-size: 1.3rem; margin-bottom: 0.25rem;">🥬</div>
          <div style="font-weight: 700; font-size: 0.9rem;">Kelola Pakan</div>
          <div style="font-size: 0.72rem; opacity: 0.8;">Update stok pakan</div>
        </button>

        <!-- Catat Transaksi -->
        <button type="button" onclick="window.location.href='{{ url('/keuangan') }}'" class="qa-grid-btn">
          <div style="font-size: 1.3rem; margin-bottom: 0.25rem;">💰</div>
          <div style="font-weight: 700; font-size: 0.9rem;">Catat Transaksi</div>
          <div style="font-size: 0.72rem; opacity: 0.8;">Input pemasukan/pengeluaran</div>
        </button>

        <!-- Cek Kesehatan -->
        <button type="button" onclick="window.location.href='{{ url('/kesehatan-ayam') }}'" class="qa-grid-btn">
          <div style="font-size: 1.3rem; margin-bottom: 0.25rem;">🩺</div>
          <div style="font-weight: 700; font-size: 0.9rem;">Cek Kesehatan</div>
          <div style="font-size: 0.72rem; opacity: 0.8;">Monitor kondisi ayam</div>
        </button>
      </div>

      <!-- Tombol Rekap Harian (Lebar Penuh) -->
      <button type="button" onclick="Swal.fire('Rekap Harian', 'Menampilkan rekapitulasi harian', 'info')" class="qa-recap-btn">
        <span>🗓️</span>
        <span>Lihat Rekap Harian</span>
      </button>
    </div>

    <!-- Kartu Kanan: Jadwal Vaksinasi -->
    <div class="widget-card-cyan">
      <!-- Header -->
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem;">
        <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
          <span style="font-size: 1.5rem; line-height: 1;">💉</span>
          <div>
            <h3 style="font-size: 1.25rem; font-weight: 700; margin: 0; color: #fff;">Jadwal Vaksinasi</h3>
            <p style="font-size: 0.85rem; margin: 0; opacity: 0.9; color: #fff;">Semua jadwal vaksin sudah selesai</p>
          </div>
        </div>
        <a href="{{ url('/kesehatan-ayam') }}" class="vaccine-link-btn">
          Lihat Semua →
        </a>
      </div>

      <!-- Konten Tengah (Empty State) -->
      <div style="flex: 1; display: flex; align-items: center; justify-content: center; min-height: 180px; padding: 2rem 1rem; text-align: center;">
        <p style="font-size: 0.95rem; opacity: 0.95; color: #fff; font-weight: 500; max-width: 320px; line-height: 1.5; margin: 0;">
          Tidak ada jadwal vaksinasi mendatang. Semua vaksin sudah selesai.
        </p>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
  @if(session('success'))
    <script>
      showToast('Berhasil Masuk', "{{ session('success') }}", 'success');
    </script>
  @endif
@endpush
