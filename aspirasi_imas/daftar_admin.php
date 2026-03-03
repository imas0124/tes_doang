<?php
session_start();
include 'koneksi.php';

// Cek apakah form sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dan amankan dari SQL Injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query khusus untuk tabel admin
    $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pendaftaran Admin Berhasil!'); window.location='data_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . $conn->error . "');</script>";
    }
}
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
        body { 
            font-family: 'Quicksand', sans-serif; 
            background: linear-gradient(135deg, #f8d7e8, #e6d9ff); 
        }
        .glass-box { 
            background: rgba(255, 255, 255, 0.95); 
            border-radius: 30px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
        }
        input { 
            background-color: #f3e8ff; 
            outline: none; 
            transition: 0.3s; 
        }
        input:focus { 
            box-shadow: 0 0 0 2px #cdb4ff; 
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="glass-box w-full max-w-sm p-10">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-[#6a4c93]">Daftar Admin</h2>
            <p class="text-gray-500 text-sm mt-2 italic">Tambahkan akses petugas baru</p>
        </div>

        <form action="" method="POST" class="space-y-6">
            <div>
                <label class="text-sm font-semibold text-[#6a4c93] ml-2">Username Petugas</label>
                <input type="text" name="username" placeholder="Buat Username" 
                       class="w-full p-4 rounded-full mt-1 border-none" required>
            </div>

            <div>
                <label class="text-sm font-semibold text-[#6a4c93] ml-2">Password</label>
                <input type="password" name="password" placeholder="Buat Password" 
                       class="w-full p-4 rounded-full mt-1 border-none" required>
            </div>

            <button type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-[#f4b6d8] to-[#cdb4ff] text-white font-bold rounded-full hover:shadow-lg hover:opacity-90 transition transform hover:-translate-y-1">
                DAFTARKAN ADMIN
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="login_admin.php" class="text-sm font-bold text-[#a066c9] hover:underline">
                Sudah punya akun? Login Admin
            </a>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="data_admin.php" class="text-xs text-gray-400 hover:text-[#6a4c93] transition">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

</body>
</html>