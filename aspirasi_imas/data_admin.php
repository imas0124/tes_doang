<?php
session_start();
include 'koneksi.php';

// 1. PROTEKSI HALAMAN
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 2. LOGIKA HAPUS
if (isset($_GET['hapus_id'])) {
    $id_hapus = $_GET['hapus_id'];
    $query_hapus = "DELETE FROM admin WHERE id_admin = '$id_hapus'";
    
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>
                alert('Petugas berhasil dihapus!'); 
                window.location.href='data_admin.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menghapus: " . mysqli_error($conn) . "');</script>";
    }
}

// 3. AMBIL DATA
$query = "SELECT id_admin, username, password FROM admin ORDER BY id_admin ASC";
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA - Data Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Quicksand', sans-serif; 
            /* Gradasi Soft Pink & Soft Purple */
            background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 100%); 
            background-attachment: fixed;
        }
        .glass-card { 
            background: rgba(255, 255, 255, 0.4); 
            backdrop-filter: blur(20px); 
            border-radius: 40px; 
            border: 1px solid rgba(255, 255, 255, 0.5); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.05); 
        }
        th { 
            background-color: #1e1b4b !important; /* Indigo sangat gelap untuk kontras */
            color: #fff !important; 
            text-transform: uppercase; 
            font-size: 11px; 
            padding: 25px 15px; 
            letter-spacing: 1.5px; 
        }
        .btn-add {
            background: linear-gradient(90deg, #ec4899, #a855f7);
            transition: all 0.3s ease;
        }
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(168, 85, 247, 0.3);
        }
    </style>
</head>
<body class="min-h-screen p-8 flex flex-col items-center">

    <header class="text-center mb-10">
        <h1 class="text-4xl font-bold text-indigo-900 mb-2">Data Petugas Admin</h1>
        <p class="text-indigo-600/70 italic text-sm font-medium">Kelola akun petugas administrator sistem.</p>
    </header>

    <div class="w-full max-w-5xl mb-6 flex justify-end">
        <a href="daftar_admin.php" class="btn-add text-white px-8 py-3 rounded-full text-xs font-bold shadow-md flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            TAMBAH PETUGAS
        </a>
    </div>

    <div class="w-full max-w-5xl glass-card overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr>
                        <th class="rounded-tl-[40px] w-20">NO</th>
                        <th>ID ADMIN</th> 
                        <th>USERNAME</th> 
                        <th>PASSWORD</th>
                        <th class="rounded-tr-[40px]">AKSI</th>
                    </tr>
                </thead>
                <tbody class="text-indigo-900">
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($sql) > 0) {
                        while($d = mysqli_fetch_array($sql)) { 
                    ?>
                    <tr class="hover:bg-white/30 transition-colors border-b border-white/20 last:border-0">
                        <td class="p-6 font-bold text-indigo-400"><?php echo $no++; ?></td>
                        <td class="p-6">
                            <span class="bg-white/50 text-indigo-600 px-4 py-1 rounded-full text-[10px] font-bold border border-indigo-100">
                                ID: <?php echo $d['id_admin']; ?>
                            </span>
                        </td>
                        <td class="p-6 font-bold italic tracking-tight text-indigo-800">@<?php echo htmlspecialchars($d['username']); ?></td>
                        
                        <td class="p-6">
                            <span class="text-indigo-500 font-mono text-xs bg-white/40 px-3 py-1 rounded-md border border-white/60">
                                <?php echo htmlspecialchars($d['password']); ?>
                            </span>
                        </td>

                        <td class="p-6">
                            <div class="flex justify-center">
                                <a href="data_admin.php?hapus_id=<?php echo $d['id_admin']; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus petugas ini?')" 
                                   class="bg-white/80 text-red-500 px-5 py-2 rounded-2xl text-[10px] font-bold hover:bg-red-500 hover:text-white transition shadow-sm border border-red-100">
                                    HAPUS
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else { 
                    ?>
                    <tr>
                        <td colspan="5" class="p-20 text-center text-indigo-400 italic font-medium">
                            Belum ada data petugas yang terdaftar.
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="menu_admin.php" class="text-indigo-600 font-bold flex items-center gap-2 hover:gap-4 transition-all duration-300 uppercase tracking-widest text-sm bg-white/50 px-6 py-2 rounded-full shadow-sm hover:bg-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali ke Dashboard
    </a>

</body>
</html>