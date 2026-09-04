<!-- =========================================================
     SISTEM ADMINISTRASI PETERNAKAN (LIBAS)
     File: resources/views/kesehatanayam.blade.php
     Deskripsi: Halaman Kesehatan Ayam - LIBAS
========================================================= -->
@extends ('layouts.layout')

@section ('title', 'Kesehatan Ayam')

@section ('content')
    <!-- Page Specific CSS -->
    <link
        rel="stylesheet"
        href="{{ asset('css/kesehatanayam/kesehatanayam.css') }}"
    />

    <!-- ===== HEADER MOBILE / HAMBURGER MENU ===== -->
    <header class="mobile-header">
        <div class="mobile-logo">🐔 LIBAS</div>
        <button
            class="menu-toggle"
            onclick="
                document.querySelector('.sidebar').classList.toggle('active')
            "
            aria-label="Toggle Sidebar"
        >
            ☰
        </button>
    </header>

    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />

    <!-- ===== HEADER KESEHATAN AYAM ===== -->
    <header class="page-header animate__animated animate__fadeInDown">
        <div class="header-text">
            <h2>🏥 Kesehatan & Vaksinasi</h2>
            <p>Kelola riwayat medis, pantau kesehatan, dan jadwalkan vaksinasi secara terstruktur.</p>
        </div>

        <!-- Area tombol tindakan pemicu interaksi form/modal -->
        <div class="header-actions">
            <button
                class="btn-warning animate__animated animate__pulse animate__infinite pulse-soft"
                onclick="openKesehatanModal()"
            >
                🩺 Catat Kesehatan
            </button>
            <button
                class="btn-success animate__animated animate__pulse animate__infinite pulse-soft"
                onclick="openVaksinModal()"
            >
                💉 Jadwal Vaksin
            </button>
        </div>
    </header>

    <!-- ===== KARTU RINGKASAN KESEHATAN ===== -->
    <section class="quick-stats animate__animated animate__fadeInUp">
        <div class="stat-card">
            <div class="stat-icon warning-icon">🤒</div>
            <div class="stat-info">
                <h4>Ayam Sakit (Dirawat)</h4>
                <p id="statAyamSakit">0 Ekor</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon danger-icon">💀</div>
            <div class="stat-info">
                <h4>Total Kematian</h4>
                <p id="statAyamMati">0 Ekor</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success-icon">💉</div>
            <div class="stat-info">
                <h4>Vaksin Terjadwal</h4>
                <p id="statVaksinMendatang">0 Jadwal</p>
            </div>
        </div>
    </section>

    <!-- ===== NAVIGASI TAB KESEHATAN & VAKSIN ===== -->
    <div class="tabs-container animate__animated animate__fadeInUp">
        <button class="tab-btn active" onclick="switchTab('kesehatan')">
            Riwayat Kesehatan (Medis)
        </button>
        <button class="tab-btn" onclick="switchTab('vaksin')">
            Jadwal & Catatan Vaksinasi
        </button>
    </div>

    <!-- ===== TABEL 1: KESEHATAN (MEDIS) ===== -->
    <section
        id="tabKesehatan"
        class="tab-content active animate__animated animate__fadeIn"
    >
        <div class="table-container shadow-card">
            <div class="table-header">
                <h3>📋 Histori Perawatan & Kesehatan Ayam</h3>
                <div class="table-actions">
                    <label for="filterKesehatanTanggal" class="filter-label"
                        >Tanggal:</label
                    >
                    <input
                        type="date"
                        id="filterKesehatanTanggal"
                        class="filter-input"
                        onchange="renderKesehatanTable()"
                        title="Filter Tanggal"
                    />
                    <button
                        class="btn-export"
                        onclick="exportKesehatanCSV()"
                        title="Ekspor Data Kesehatan"
                    >
                        📥 Eksport CSV
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Batch / Kandang</th>
                            <th>Gejala</th>
                            <th>Jumlah Sakit / Mati</th>
                            <th>Penanganan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kesehatanTableBody">
                        <!-- Data JS -->
                    </tbody>
                </table>
                <div id="kesehatanEmpty" class="empty-state">
                    <span class="empty-icon">🩺</span>
                    <p>Belum ada catatan kesehatan. Silakan tambah data!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TABEL 2: VAKSINASI ===== -->
    <section
        id="tabVaksin"
        class="tab-content animate__animated animate__fadeIn"
        style="display: none"
    >
        <div class="table-container shadow-card">
            <div class="table-header">
                <h3>📅 Jadwal & Riwayat Vaksinasi</h3>
                <div class="table-actions">
                    <label for="filterVaksinStatus" class="filter-label"
                        >Status:</label
                    >
                    <select
                        id="filterVaksinStatus"
                        class="filter-input"
                        onchange="renderVaksinTable()"
                    >
                        <option value="all">Semua Status</option>
                        <option value="Terjadwal">Terjadwal</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                    <button
                        class="btn-export"
                        onclick="exportVaksinCSV()"
                        title="Ekspor Data Vaksin"
                    >
                        📥 Eksport CSV
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Jadwal Vaksin</th>
                            <th>Batch / Kandang</th>
                            <th>Jenis Vaksin</th>
                            <th>Metode</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="vaksinTableBody">
                        <!-- Data JS -->
                    </tbody>
                </table>
                <div id="vaksinEmpty" class="empty-state">
                    <span class="empty-icon">💉</span>
                    <p>Belum ada jadwal vaksinasi. Silakan buat jadwal!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals -->
    <!-- ========================= MODAL TAMBAH DATA KESEHATAN ========================== -->
    <!-- Formulir pop-up/overlay untuk mencatat data kesehatan ayam -->
    <div id="kesehatanModal" class="modal">
        <div class="modal-content animate__animated animate__zoomIn">
            <div class="modal-header">
                <h3 id="modalKesehatanTitle">Catat Kesehatan Ayam</h3>
                <button class="close-btn" onclick="closeKesehatanModal()">
                    &times;
                </button>
            </div>

            <!-- Form penginputan detail medis penyakit ayam -->
            <form id="kesehatanForm" onsubmit="saveKesehatan(event)">
                <input type="hidden" id="kesehatanId" />

                <div class="form-group">
                    <label for="kesTanggal">Tanggal Pencatatan</label>
                    <input type="date" id="kesTanggal" required />
                </div>

                <div class="form-group">
                    <label for="kesBatch">Batch Ayam</label>
                    <select
                        id="kesBatch"
                        required
                        onchange="onBatchSakitChange()"
                    >
                        <option value="" disabled selected>
                            Pilih Batch...
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="kesKandang">Kandang</label>
                    <input
                        type="text"
                        id="kesKandang"
                        readonly
                        class="readonly-input"
                    />
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="kesJmlSakit">Jml Ayam Sakit</label>
                        <!-- Mengumpulkan angka mutlak yang sakit -->
                        <input
                            type="number"
                            id="kesJmlSakit"
                            min="0"
                            value="0"
                            required
                        />
                    </div>
                    <div class="form-group half">
                        <label for="kesJmlMati"
                            >Jml Ayam Mati
                            <small>(Akan mengurangi stok pop.)</small></label
                        >
                        <!-- Mengumpulkan pencatatan yang gugur/mati dalam satu peristiwa -->
                        <input
                            type="number"
                            id="kesJmlMati"
                            min="0"
                            value="0"
                            required
                        />
                    </div>
                </div>

                <div class="form-group">
                    <label for="kesGejala">Gejala / Penyakit</label>
                    <input
                        type="text"
                        id="kesGejala"
                        placeholder="Contoh: Mencret, Ngorok, dll."
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="kesPenanganan">Tindakan Penanganan</label>
                    <textarea
                        id="kesPenanganan"
                        rows="3"
                        placeholder="Contoh: Pemberian vitamin, karantina..."
                        required
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="kesStatus">Status saat ini</label>
                    <select id="kesStatus" required>
                        <option value="Dalam Perawatan">
                            Dalam Perawatan (Sakit)
                        </option>
                        <option value="Sembuh">Sudah Sembuh</option>
                        <option value="Mati Semua">
                            Mati Semua (Terkait kasus ini)
                        </option>
                    </select>
                </div>

                <div class="modal-actions">
                    <button
                        type="button"
                        class="btn-secondary"
                        onclick="closeKesehatanModal()"
                    >
                        Batal
                    </button>
                    <button type="submit" class="btn-primary">
                        💾 Simpan Kasus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================= MODAL PENJADWALAN VAKSIN ========================== -->
    <!-- Formulir pop-up/overlay untuk membuat atau mengedit jadwal vaksinasi -->
    <div id="vaksinModal" class="modal">
        <div class="modal-content animate__animated animate__zoomIn">
            <div class="modal-header">
                <h3 id="modalVaksinTitle">Jadwal Vaksinasi Baru</h3>
                <button class="close-btn" onclick="closeVaksinModal()">
                    &times;
                </button>
            </div>

            <!-- Form penginputan spesifikasi vaksinasi -->
            <form id="vaksinForm" onsubmit="saveVaksin(event)">
                <input type="hidden" id="vaksinId" />

                <div class="form-group">
                    <label for="vakTanggal">Tanggal Jadwal Vaksin</label>
                    <input type="date" id="vakTanggal" required />
                </div>

                <div class="form-group">
                    <label for="vakBatch">Batch Ayam</label>
                    <select
                        id="vakBatch"
                        required
                        onchange="onBatchVaksinChange()"
                    >
                        <option value="" disabled selected>
                            Pilih Batch Target...
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vakKandang">Kandang</label>
                    <input
                        type="text"
                        id="vakKandang"
                        readonly
                        class="readonly-input"
                    />
                </div>

                <div class="form-group">
                    <label for="vakJenis">Jenis Vaksin</label>
                    <select id="vakJenis" required>
                        <option value="" disabled selected>
                            Pilih Vaksin...
                        </option>
                        <option value="ND (Newcastle Disease)">
                            ND (Newcastle Disease)
                        </option>
                        <option value="IB (Infectious Bronchitis)">
                            IB (Infectious Bronchitis)
                        </option>
                        <option value="AI (Avian Influenza)">
                            AI (Avian Influenza)
                        </option>
                        <option value="Gumboro">Gumboro</option>
                        <option value="Lainnya">Lainnya...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vakMetode">Metode Pemberian</label>
                    <select id="vakMetode" required>
                        <option value="Air Minum">Air Minum</option>
                        <option value="Tetes Mata/Hidung">
                            Tetes Mata/Hidung
                        </option>
                        <option value="Suntikan">Suntikan</option>
                        <option value="Spray">Spray (Semprot)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vakCatatan">Catatan / Dosis</label>
                    <textarea
                        id="vakCatatan"
                        rows="2"
                        placeholder="Contoh: Dosis 1 botol per 1000 ekor"
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="vakStatus">Status Kegiatan</label>
                    <select id="vakStatus" required>
                        <option value="Terjadwal">
                            Terjadwal (Belum dilakukan)
                        </option>
                        <option value="Selesai">
                            Selesai (Sudah divaksin)
                        </option>
                    </select>
                </div>

                <div class="modal-actions">
                    <button
                        type="button"
                        class="btn-secondary"
                        onclick="closeVaksinModal()"
                    >
                        Batal
                    </button>
                    <button type="submit" class="btn-primary">
                        💾 Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================= SCRIPT UTAMA ========================== -->
    <!-- File logika penggerak halaman, pencatatan kesehatan dan vaksinasi -->

@endsection

@push ('scripts')
    <script
        type="module"
        src="{{ asset('js/kesehatanayam/kesehatanayam.js') }}"
    ></script>
@endpush
