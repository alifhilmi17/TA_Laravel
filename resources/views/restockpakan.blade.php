<!-- =========================================================
     SISTEM ADMINISTRASI PETERNAKAN (LIBAS)
     File: resources/views/restockpakan.blade.php
     Deskripsi: Halaman Restock Reminder - LIBAS
========================================================= -->
@extends('layouts.layout')

@section('title', 'Restock Reminder - LIBAS')

@section('content')
<!-- ========================= FONT & ANIMASI ========================== -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<!-- ========================= CSS KUSTOM ========================== -->
<link rel="stylesheet" href="{{ asset('css/stokpakan/stokpakan.css') }}" />
<link rel="stylesheet" href="{{ asset('css/restockpakan/restockpakan.css') }}" />

<!-- ========================= MAIN CONTENT ========================== -->
<header class="page-header animate__animated animate__fadeInDown">
    <div class="header-text">
        <h2>⏰ Restock Reminder</h2>
        <p>Pengingat pemesanan ulang pakan untuk mencegah kehabisan stok</p>
    </div>
    <div class="header-actions" id="actionsContainer">
        <button class="btn-primary" onclick="openReminderModal()" id="btnActionReminder">
            ➕ Ajukan Kebutuhan Pakan
        </button>
    </div>
</header>

<!-- Live Feed Stock Tracker Widget -->
<div class="live-stock-widget animate__animated animate__fadeInUp">
    <div class="widget-header">
        <h3>📊 Live Feed Stock Tracker</h3>
        <span class="refresh-indicator">⚡ Terhubung Secara Real-time</span>
    </div>
    <div class="widget-grid" id="liveStockGrid">
        <div class="empty-state" style="grid-column: 1/-1; padding: 10px; text-align: center;">
            <p style="margin: 0; color: #64748b; font-size: 0.85rem;">Memuat data stok pakan riil...</p>
        </div>
    </div>
</div>

<section class="animate__animated animate__fadeInUp" style="margin-top:20px;">
    <div class="shadow-card" style="padding: 20px;">
        <!-- Tabs Navigation -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="switchTab('pending')" id="tabPendingBtn">
                ⏳ Butuh Restock <span class="tab-badge count-zero" id="badgePendingCount">0</span>
            </button>
            <button class="tab-btn" onclick="switchTab('selesai')" id="tabSelesaiBtn">
                ✅ Riwayat Restock <span class="tab-badge count-zero" id="badgeSelesaiCount">0</span>
            </button>
        </div>

        <div id="reminderListContainer">
            <div class="empty-state">
                <span class="empty-icon">📂</span>
                <p>Memuat data pengingat...</p>
            </div>
        </div>
    </div>
</section>

<!-- ========================= MODAL FORM ========================== -->
<div id="reminderModal" class="modal">
    <div class="modal-content animate__animated animate__zoomIn">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Reminder Pakan</h3>
            <button type="button" class="close-btn" onclick="closeReminderModal()">&times;</button>
        </div>
        <form id="reminderForm" onsubmit="saveReminder(event)">
            <input type="hidden" id="reminderId">

            <div class="form-group">
                <label>Batas Tanggal (Tenggat Waktu)</label>
                <input type="date" id="tglReminder" required>
            </div>

            <div class="form-group">
                <label>Target Jenis Pakan</label>
                <input type="text" id="jenisPakan" placeholder="Contoh: Konsentrat BP11" required>
            </div>

            <div class="form-group">
                <label>Tingkat Prioritas</label>
                <select id="prioritas" required>
                    <option value="Sedang">Sedang (Rutin)</option>
                    <option value="Tinggi">Tinggi (Mendesak / Stok Menipis)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Pesan / Catatan Tambahan</label>
                <textarea id="catatan" rows="3" placeholder="Contoh: Pesan 50 karung ke Supplier A"></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeReminderModal()">Batal</button>
                <button type="submit" class="btn-primary">💾 Simpan Reminder</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- Script Utama -->
<script type="module" src="{{ asset('js/restockpakan/restockpakan.js') }}"></script>
@endpush