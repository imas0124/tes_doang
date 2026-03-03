<?php
session_start();
include 'koneksi.php';

// --- PROSES UPDATE STATUS ---
if (isset($_POST['update_status'])) {
    $id = $_POST['id_aspirasi'];
    $status_baru = $_POST['status'];

    $query_update = "UPDATE aspirasi SET status = '$status_baru' WHERE id_aspirasi = '$id'";
    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Status berhasil diperbarui!'); window.location.href='data_aspirasi.php';</script>";
    }
}

// Query ambil data aspirasi dengan join kategori
$query_sql = "SELECT aspirasi.*, kategori.ket_kategori 
              FROM aspirasi 
              LEFT JOIN kategori ON aspirasi.id_kategori = kategori.id_kategori 
              ORDER BY aspirasi.id_aspirasi ASC";

$tampil_data = mysqli_query($conn, $query_sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA | Data Aspirasi</title>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 50%, #eff6ff 100%); 
        }
        /* Efek Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(15px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        /* Navbar Gradient Style */
        .nav-gradient {
            background: linear-gradient(90deg, #fbcfe8 0%, #e9d5ff 50%, #bfdbfe 100%);
        }
        table { border-collapse: separate; border-spacing: 0; width: 100%; }
        th { 
            background-color: #000 !important; 
            color: #fff !important; 
            text-transform: uppercase; 
            font-size: 11px; 
            letter-spacing: 1px;
            padding: 18px;
        }
        .border-r-custom { border-right: 1px solid #333; }
        .row-hover:hover { background-color: rgba(255, 255, 255, 0.4); }
    </style>
</head>
<body class="min-h-screen">

    <nav class="nav-gradient px-8 py-4 flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-3">
            <img src="img/logoo.png" alt="Logo" class="w-10 h-10">
            <span class="text-white text-2xl font-bold tracking-wider">ASIKA</span>
        </div>
        <a href="menu_admin.php" class="bg-[#fbcfe8] text-white px-6 py-2 rounded-xl font-bold hover:bg-red-600 transition shadow-md">
            ← Kembali
        </a>
    </nav>

    <main class="p-6 md:p-12">
        <header class="text-center mb-12">
            <h1 class="text-5xl font-light text-slate-800 tracking-tight">Data Aspirasi Masuk</h1>
        </header>

        <div class="max-w-[95%] mx-auto glass-card">
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th class="border-r-custom w-12 text-center">NO</th>
                            <th class="border-r-custom">NISN</th>
                            <th class="border-r-custom">Tanggal</th>
                            <th class="border-r-custom">Lokasi</th>
                            <th class="border-r-custom w-1/3 text-left pl-8">Deskripsi / Laporan</th>
                            <th class="border-r-custom text-center">Edit Status</th> 
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600 text-sm">
                        <?php 
                        $no = 1;
                        if (mysqli_num_rows($tampil_data) > 0) {
                            while($d = mysqli_fetch_array($tampil_data)) { 
                        ?>
                        <tr class="row-hover border-b border-gray-100 transition-all">
                            <td class="p-4 border-r border-gray-100 font-bold text-center"><?php echo $no++; ?></td>
                            <td class="p-4 border-r border-gray-100 text-center"><?php echo $d['nisn']; ?></td>
                            <td class="p-4 border-r border-gray-100 text-xs text-center">
                                <?php echo date('d/m/Y - H:i', strtotime($d['tanggal_input'])); ?>
                            </td>
                            <td class="p-4 border-r border-gray-100 text-center"><?php echo $d['lokasi']; ?></td>
                            <td class="p-4 border-r border-gray-100 text-left pl-8 italic">
                                "<?php echo $d['deskripsi']; ?>"
                            </td>
                            
                            <td class="p-4 border-r border-gray-100 text-center">
                                <form action="" method="POST">
                                    <input type="hidden" name="id_aspirasi" value="<?php echo $d['id_aspirasi']; ?>">
                                    <select name="status" onchange="this.form.submit()" 
                                        class="text-[10px] font-bold uppercase py-2 px-3 rounded-full shadow-sm outline-none transition-all
                                        <?php 
                                            if($d['status'] == 'menunggu') echo 'bg-yellow-100 text-yellow-600';
                                            elseif($d['status'] == 'proses') echo 'bg-blue-100 text-blue-600';
                                            elseif($d['status'] == 'selesai') echo 'bg-green-100 text-green-600'; 
                                        ?>">
                                        <option value="menunggu" <?php if($d['status'] == 'menunggu') echo 'selected'; ?>>Menunggu</option>
                                        <option value="proses" <?php if($d['status'] == 'proses') echo 'selected'; ?>>Proses</option>
                                        <option value="selesai" <?php if($d['status'] == 'selesai') echo 'selected'; ?>>Selesai</option>
                                    </select>
                                    <input type="hidden" name="update_status">
                                </form>
                            </td>

                            <td class="p-4 text-center">
                                <a href="formulir_feedback.php?id=<?php echo $d['id_aspirasi']; ?>" 
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-xs font-bold shadow-md hover:shadow-lg transition-all active:scale-95">
                                   Tanggapi
                                </a>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else { 
                        ?>
                        <tr>
                            <td colspan="7" class="p-24 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300 opacity-50"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                    <p class="italic text-xl">Belum ada data pengaduan yang masuk...</p>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>