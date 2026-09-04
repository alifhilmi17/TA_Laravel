<!-- =========================================================
     🐔 KODE SUMBER: HALAMAN REGISTRASI (DAFTAR AKUN)
     File: signup.blade.php
     ---------------------------------------------------------
     Deskripsi singkat:
     File ini menangani antarmuka (UI) pendaftaran akun baru
     untuk petugas kandang peternakan ke dalam sistem LIBAS.
========================================================= -->
<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Menyiapkan halaman mendukung karakter universal dan tata letak untuk HP / Laptop -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Judul bar atas memori Browser -->
    <title>LIBAS - Pendaftaran Akun</title>

    <!-- Mengintegrasikan huruf 'Poppins' untuk desain tampilan profesional -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap"
        rel="stylesheet"
    />

    <!-- Menautkan stylesheet (File CSS) khusus untuk mengelola dekorasi warna formulir daftar ini -->
    <link rel="stylesheet" href="{{ asset('css/signup/signup.css') }}" />

    <!-- Mengimpor library SweetAlert2 untuk menampilkan popup notifikasi interaktif -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- ===== 1. AREA BACKGROUND ===== -->
    <!-- Bingkai pembantalan yang menampung efek noise atau tekstur dasar laman web -->
    <div class="background">
        <!-- Overlay membuat bintik-bintik modern semu transparan di atas background polos -->
        <div class="noise-overlay"></div>
    </div>

    <!-- ===== 2. KOTAK FORMULIR REGISTRASI ===== -->
    <!-- Kotak pusat yang mengapung di tengah layar untuk mengisi biodata profil -->
    <div class="signup-card">
        <!-- Judul Formulir -->
        <h2>Daftar Akun Petugas</h2>
        <p class="subtitle">Daftarkan diri Anda sebagai Petugas Kandang LIBAS</p>

        <!-- Formulir Eksekusi -->
        <form
            action="{{ route('signup.perform') }}"
            method="POST"
            id="signupForm"
        >
            @csrf

            <!-- 1. Kolom Input Nama Lengkap Asli -->
            <div class="input-group">
                <label for="fullname">Nama Lengkap</label>
                <input
                    type="text"
                    id="fullname"
                    name="fullname"
                    value="{{ old('fullname') }}"
                    placeholder="Masukkan nama lengkap Anda"
                    required
                />
                @error ('fullname')
                    <span
                        style="
                            color: #ff7e5f;
                            font-size: 12px;
                            margin-top: 4px;
                            display: block;
                        "
                        >{{ $message }}</span
                    >
                @enderror
            </div>

            <!-- 2. Kolom Input Nama Panggilan / Alias Kredensial -->
            <div class="input-group">
                <label for="username">Username Akses</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Buat username unik"
                    required
                />
                @error ('username')
                    <span
                        style="
                            color: #ff7e5f;
                            font-size: 12px;
                            margin-top: 4px;
                            display: block;
                        "
                        >{{ $message }}</span
                    >
                @enderror
            </div>

            <!-- 3. Kolom Input Alamat Surel (Email) -->
            <div class="input-group">
                <label for="email">Alamat Email Aktif</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@peternak.com"
                    required
                />
                @error ('email')
                    <span
                        style="
                            color: #ff7e5f;
                            font-size: 12px;
                            margin-top: 4px;
                            display: block;
                        "
                        >{{ $message }}</span
                    >
                @enderror
            </div>

            <!-- 4. Kolom Input Sandi Rahasia -->
            <div class="input-group">
                <label for="password">Sandi (Password)</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Buat kata sandi yang kuat"
                    required
                />
                @error ('password')
                    <span
                        style="
                            color: #ff7e5f;
                            font-size: 12px;
                            margin-top: 4px;
                            display: block;
                        "
                        >{{ $message }}</span
                    >
                @enderror
            </div>

            <!-- Tombol Penyelesaian Registrasi Data -->
            <button type="submit" class="signup-btn">Daftar Sekarang</button>
        </form>

        <!-- ===== TAUTAN TAMBAHAN (NAVIGASI) ===== -->
        <!-- Jika ternyata sudah mendaftar atau ingin membatalkan/kembali ke awal -->
        <div class="extra-links">
            <p>Apakah Anda sudah memiliki akun? <a href="{{ route('login') }}" title="Masuk ke Akun Lama">Masuk/Login</a></p>
            <p style="margin-top: 10px">
                <a
                    href="{{ route('index') }}"
                    style="font-size: 13px; opacity: 0.8"
                    title="Kembali ke Layar Beranda"
                    >← Kembali ke Halaman Utama</a
                >
            </p>
        </div>
    </div>

    <!-- ========================= SCRIPT UTAMA ========================== -->
    <!-- Hapus signup.js karena pendaftaran ditangani oleh Backend (Laravel) -->
    <script src="{{ asset('js/shared/ui-utils.js') }}"></script>
</body>
</html>
