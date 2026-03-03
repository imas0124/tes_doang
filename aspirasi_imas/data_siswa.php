<?php
session_start();
include 'koneksi.php';

// 1. PROTEKSI HALAMAN
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    header("Location: login_admin.php");
    exit;
}

// 2. LOGIKA HAPUS SISWA (Jika ingin diaktifkan nanti)
if (isset($_GET['hapus_nisn'])) {
    $nisn_hapus = $_GET['hapus_nisn'];
    $query_hapus = "DELETE FROM siswa WHERE nisn = '$nisn_hapus'";
    
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>
                alert('Data siswa berhasil dihapus!'); 
                window.location.href='data_siswa.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menghapus: " . mysqli_error($conn) . "');</script>";
    }
}

// 3. AMBIL DATA SISWA
$query = "SELECT nisn, nama, jk, password, no_hp FROM siswa ORDER BY nama ASC";
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA | Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            /* Gradasi Background Soft Pink & Soft Purple */
            background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 100%); 
            background-attachment: fixed;
        }
        .nav-gradient {
            background: linear-gradient(90deg, #fbcfe8 0%, #e9d5ff 50%, #bfdbfe 100%);
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.4); 
            backdrop-filter: blur(20px); 
            border-radius: 40px; 
            border: 1px solid rgba(255, 255, 255, 0.5); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.05); 
        }
        th { 
            background-color: #000 !important; 
            color: #fff !important; 
            text-transform: uppercase; 
            font-size: 11px; 
            padding: 25px 15px; 
            letter-spacing: 1.5px; 
        }
    </style>
</head>
<body class="min-h-screen">


    <main class="p-8 flex flex-col items-center">
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-indigo-900 mb-2">Data Siswa</h1>
        </header>

        <div class="w-full max-w-6xl glass-card overflow-hidden mb-12">
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr>
                            <th class="rounded-tl-[40px] w-16">NO</th>
                            <th>NISN</th> 
                            <th>NAMA LENGKAP</th> 
                            <th>JENIS KELAMIN</th>
                            <th>NO HP</th>
                            <th class="rounded-tr-[40px]">PASSWORD</th>
                        </tr>
                    </thead>
                    <tbody class="text-indigo-900 font-medium">
                        <?php 
                        $no = 1;
                        if (mysqli_num_rows($sql) > 0) {
                            while($d = mysqli_fetch_array($sql)) { 
                        ?>
                        <tr class="hover:bg-white/40 transition-colors border-b border-white/20 last:border-0">
                            <td class="p-6 font-bold text-indigo-300"><?php echo $no++; ?></td>
                            <td class="p-6">
                                <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-[10px] font-bold border border-indigo-100">
                                    <?php echo htmlspecialchars($d['nisn']); ?>
                                </span>
                            </td>
                            <td class="p-6 font-bold text-slate-800 text-left uppercase tracking-tight"><?php echo htmlspecialchars($d['nama']); ?></td>
                            <td class="p-6">
                                <span class="px-4 py-1 rounded-lg text-xs <?php echo ($d['jk'] == 'L' || $d['jk'] == 'Laki-laki') ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600'; ?>">
                                    <?php echo htmlspecialchars($d['jk']); ?>
                                </span>
                            </td>
                            <td class="p-6 text-sm font-semibold italic text-indigo-500"><?php echo htmlspecialchars($d['no_hp']); ?></td>
                            <td class="p-6">
                                <span class="text-slate-500 font-mono text-xs bg-white/50 px-3 py-2 rounded-md border border-white/60 shadow-inner">
                                    <?php echo htmlspecialchars($d['password']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else { 
                        ?>
                        <tr>
                            <td colspan="6" class="p-24 text-center text-indigo-300 italic">
                                <div class="flex flex-col items-center gap-4 opacity-30">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                     <p>Belum ada data siswa yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <a href="menu_admin.php" class="group text-indigo-600 font-bold flex items-center gap-2 hover:gap-4 transition-all duration-300 uppercase tracking-widest text-sm bg-white/40 px-8 py-3 rounded-full shadow-sm hover:bg-white border border-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Dashboard
        </a>
    </main>

</body>
</html>