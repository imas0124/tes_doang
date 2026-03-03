<?php
session_start();
include 'koneksi.php';

// Di file ini, kita paksa levelnya jadi 'siswa' karena ini folder/halaman akses siswa
$user_level = 'siswa';

// 1. Ambil ID Aspirasi dari URL
$id_aspirasi = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// 2. LOGIKA KEMBALI (Khusus Siswa)
$link_kembali = "riwayat_aspirasi_siswa.php";
$label_kembali = "KEMBALI KE RIWAYAT SAYA";

// 3. QUERY TAMPIL DATA (Menampilkan tanggapan dari Admin untuk aspirasi siswa tersebut)
$query = "SELECT feedback.*, aspirasi.nisn 
          FROM feedback 
          INNER JOIN aspirasi ON feedback.id_aspirasi = aspirasi.id_aspirasi 
          WHERE feedback.id_aspirasi = '$id_aspirasi'
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
        /* Header Tabel tetap Hitam sesuai permintaan kamu */
        th { background-color: #000 !important; color: #fff !important; text-transform: uppercase; font-size: 11px; padding: 25px 15px; }
    </style>
</head>
<body class="min-h-screen p-8 flex flex-col items-center">

    <h1 class="text-4xl font-bold text-slate-800 mb-10 text-center">Tanggapan Petugas</h1>

    <div class="w-full max-w-7xl glass-card overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr>
                        <th class="rounded-l-[40px]">NO</th>
                        <th>NISN</th> 
                        <th>ID Aspirasi</th> 
                        <th>ID Tanggapan</th>
                        <th>Tanggal Balasan</th>
                        <th>Petugas</th>
                        <th class="w-1/3">Isi Tanggapan</th>
                        <th class="rounded-r-[40px]">STATUS</th>
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
                            <td class="p-8"><span class="bg-gray-100 px-4 py-1 rounded-full text-[10px] font-bold">ID: <?php echo $row['id_aspirasi']; ?></span></td>
                            <td class="p-8 font-semibold"><?php echo $row['id_feedback']; ?></td>
                            <td class="p-8 text-xs text-gray-400"><?php echo $row['tanggal_feedback']; ?></td>
                            <td class="p-8 font-semibold text-slate-800"><?php echo $row['id_admin']; ?></td>
                            <td class="p-8 italic text-sm text-gray-500 text-center">
                                "<?php echo $row['pesan']; ?>"
                            </td>
                            <td class="p-8">
                                <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest">
                                    Diterima
                                </span>
                            </td>
                        </tr>
                    <?php 
                        } 
                    } else { 
                    ?>
                        <tr><td colspan="8" class="p-20 text-gray-300 italic text-lg">Belum ada balasan dari petugas untuk aspirasi ini.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="<?php echo $link_kembali; ?>" class="text-indigo-600 font-bold flex items-center gap-2 hover:gap-4 transition-all duration-300 uppercase tracking-widest text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        <?php echo $label_kembali; ?>
    </a>

</body>
</html>