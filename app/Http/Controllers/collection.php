// 1. Data Inti Peternakan
$populasiAyam = $database->collection('populasi_ayam');
$produksiHarian = $database->collection('produksi_harian');
$stokPakan = $database->collection('stok_pakan');

// 2. Kesehatan dan Perawatan
$kesehatanAyam = $database->collection('kesehatan_ayam');
$vaksinasiAyam = $database->collection('vaksinasi_ayam');

// 3. Keuangan dan Analitik
$keuangan = $database->collection('keuangan');
$prediksiHistory = $database->collection('prediksi_history');

// 4. Aktivitas dan Dashboard
$dailyActivities = $database->collection('daily_activities');
$schedules = $database->collection('schedules');
$announcements = $database->collection('announcements');
$restockReminders= $database->collection('restock_reminders');
$aktivitasEkspor = $database->collection('aktivitas_ekspor');