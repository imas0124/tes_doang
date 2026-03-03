<?php
session_start();
include 'koneksi.php';

// Proteksi login
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}
$nama_display = $_SESSION['admin_user'];

// --- HITUNG DATA SESUAI URUTAN BARU ---
// 1. Total Laporan
$q_total = mysqli_query($conn, "SELECT COUNT(*) as jml FROM aspirasi");
$total = mysqli_fetch_assoc($q_total)['jml'];

// 2. Proses
$q_proses = mysqli_query($conn, "SELECT COUNT(*) as jml FROM aspirasi WHERE status = 'proses'");
$proses = mysqli_fetch_assoc($q_proses)['jml'];

// 3. Menunggu (Sebelumnya label 'Baru')
$q_menunggu = mysqli_query($conn, "SELECT COUNT(*) as jml FROM aspirasi WHERE status = 'menunggu'");
$menunggu = mysqli_fetch_assoc($q_menunggu)['jml'];

// 4. Selesai
$q_selesai = mysqli_query($conn, "SELECT COUNT(*) as jml FROM aspirasi WHERE status = 'selesai'");
$selesai = mysqli_fetch_assoc($q_selesai)['jml'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(to bottom right, #fdf2f8, #f5f3ff, #eff6ff); 
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.6);
            border-radius: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-10px); background: rgba(255, 255, 255, 0.8); }
        .sidebar-active { background: linear-gradient(to right, #fbcfe8, #ddd6fe); color: white !important; }
    </style>
</head>
<body class="min-h-screen flex">

    <aside class="w-72 p-8 flex flex-col justify-between">
        <div>
            <div class="mb-12">
                <h1 class="text-2xl font-bold text-purple-600 tracking-wider">ASIKA</h1>
            </div>
            <nav class="space-y-4">
                <a href="#" class="block px-6 py-3 rounded-2xl sidebar-active font-bold shadow-sm">Dashboard</a>
                <a href="data_aspirasi.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Data Pengaduan</a>
                <a href="data_admin.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Data Petugas</a>
                <a href="data_siswa.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Data Siswa</a>
                <a href="menu_feedback_admin.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Feedback</a>
                <a href="kategori.php" class="block px-6 py-3 text-gray-500 hover:text-purple-600 transition font-semibold">Kategori</a>
            </nav>
        </div>
        <div>
            <a href="logout.php" class="px-6 py-3 text-red-400 italic hover:text-red-600 transition font-medium">keluar</a>
        </div>
    </aside>

    <main class="flex-1 p-12">
        <header class="mb-16">
            <h2 class="text-4xl font-bold text-slate-700">
                Selamat Datang, <span class="text-purple-500"><?php echo $nama_display; ?>!</span>
            </h2>
            <p class="text-slate-400 mt-2 text-lg">Berikut adalah ringkasan laporan hari ini.</p>
        </header>

        <div class="grid grid-cols-4 gap-8">
            
            <div class="stat-card p-10 flex flex-col items-center">
                <span class="text-blue-400 text-xs font-bold uppercase tracking-[0.2em] mb-4">Total Laporan</span>
                <span class="text-6xl font-bold text-blue-500"><?php echo $total; ?></span>
            </div>

            <div class="stat-card p-10 flex flex-col items-center">
                <span class="text-orange-400 text-xs font-bold uppercase tracking-[0.2em] mb-4">Proses</span>
                <span class="text-6xl font-bold text-orange-400"><?php echo $proses; ?></span>
            </div>

            <div class="stat-card p-10 flex flex-col items-center">
                <span class="text-pink-400 text-xs font-bold uppercase tracking-[0.2em] mb-4">Menunggu</span>
                <span class="text-6xl font-bold text-pink-400"><?php echo $menunggu; ?></span>
            </div>

            <div class="stat-card p-10 flex flex-col items-center">
                <span class="text-emerald-400 text-xs font-bold uppercase tracking-[0.2em] mb-4">Selesai</span>
                <span class="text-6xl font-bold text-emerald-400"><?php echo $selesai; ?></span>
            </div>

        </div>
    </main>

</body>
</html>