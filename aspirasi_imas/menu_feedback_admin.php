<?php
session_start();
include 'koneksi.php';

// 1. Ambil Level User & ID Aspirasi (Gunakan @ atau isset agar tidak error)
$user_level = isset($_SESSION['level']) ? strtolower(trim($_SESSION['level'])) : 'admin'; 
$id_aspirasi = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// 2. LOGIKA TOMBOL KEMBALI
$link_kembali = "data_aspirasi.php";
$label_kembali = "KEMBALI KE DATA ASPIRASI";

// 3. LOGIKA HAPUS (Hanya Admin)
if (isset($_GET['hapus']) && $user_level == 'admin') {
    $id_feedback_hapus = mysqli_real_escape_string($conn, $_GET['hapus']);
    $query_hapus = "DELETE FROM feedback WHERE id_feedback = '$id_feedback_hapus'";
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>alert('Tanggapan berhasil dihapus!'); window.location.href='menu_feedback_admin.php';</script>";
        exit;
    }
}

// 4. QUERY TAMPIL DATA (Dibuat tanpa WHERE id agar semua feedback muncul)
$query = "SELECT feedback.*, aspirasi.nisn 
          FROM feedback 
          INNER JOIN aspirasi ON feedback.id_aspirasi = aspirasi.id_aspirasi 
          ORDER BY feedback.id_feedback DESC";

$sql = mysqli_query($conn, $query);
$no = 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: #f8faff; }
        .glass-card { background: white; border-radius: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
        th { background-color: #000 !important; color: #fff !important; text-transform: uppercase; font-size: 11px; padding: 25px 15px; }
    </style>
</head>
<body class="min-h-screen p-8 flex flex-col items-center">

    <h1 class="text-4xl font-bold text-slate-800 mb-10 text-center">Riwayat Tanggapan (Admin)</h1>

    <div class="w-full max-w-7xl glass-card overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr>
                        <th class="rounded-l-[40px]">NO</th>
                        <th>NISN</th> 
                        <th>ID Aspirasi</th> 
                        <th>ID Tanggapan</th>
                        <th>Tanggal</th>
                        <th>ID Admin</th>
                        <th class="w-1/4 text-center">Pesan Balasan</th>
                        <th class="rounded-r-[40px]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    <?php 
                    if (mysqli_num_rows($sql) > 0) {
                        while($row = mysqli_fetch_array($sql)) { 
                    ?>
                        <tr class="hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-0">
                            <td class="p-8 font-bold"><?php echo $no++; ?></td>
                            <td class="p-8 font-bold text-indigo-600">#<?php echo $row['nisn']; ?></td>
                            <td class="p-8">
                                <span class="bg-gray-100 px-4 py-1 rounded-full text-[10px] font-bold">
                                    ID: <?php echo $row['id_aspirasi']; ?>
                                </span>
                            </td>
                            <td class="p-8 font-semibold"><?php echo $row['id_feedback']; ?></td>
                            <td class="p-8 text-xs text-gray-400"><?php echo $row['tanggal_feedback']; ?></td>
                            <td class="p-8 font-semibold"><?php echo $row['id_admin']; ?></td>
                            
                            <td class="p-8 italic text-sm text-gray-500 text-center">
                                "<?php echo $row['pesan']; ?>"
                            </td>

                            <td class="p-8">
                                <div class="flex flex-col gap-2">
                                    <a href="halaman_edit.php?id=<?php echo $row['id_feedback']; ?>" 
                                       class="bg-amber-400 text-white px-5 py-2 rounded-xl text-[10px] font-bold uppercase hover:bg-amber-500 transition shadow-md text-center">
                                       EDIT
                                    </a>
                                    <a href="menu_feedback_admin.php?hapus=<?php echo $row['id_feedback']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus tanggapan ini?')" 
                                       class="bg-pink-500 text-white px-5 py-2 rounded-xl text-[10px] font-bold uppercase hover:bg-pink-600 transition text-center shadow-md">
                                       HAPUS
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        } 
                    } else { 
                    ?>
                        <tr><td colspan="8" class="p-20 text-gray-300 italic text-center">Belum ada data tanggapan.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="menu_admin.php" class="text-xs text-gray-400 hover:text-[#6a4c93] transition">
                    ← Kembali ke Beranda
                </a>
            </div>

</body>
</html>