<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn     = mysqli_real_escape_string($conn, $_POST['nisn']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    // PERBAIKAN DI SINI: Gunakan $_POST dan tambahkan escape string
    $jk       = mysqli_real_escape_string($conn, $_POST['jk']); 
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $no_hp    = mysqli_real_escape_string($conn, $_POST['no_hp']);

    $sql = "INSERT INTO siswa (nisn, nama, jk, password, no_hp) 
            VALUES ('$nisn', '$nama', '$jk', '$password', '$no_hp')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pendaftaran Siswa Berhasil!'); window.location='siswa.php';</script>";
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
    <title>ASIKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: linear-gradient(135deg, #f8d7e8, #e6d9ff); }
        .daftar-box { background: rgba(255, 255, 255, 0.95); border-radius: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        input, select { background-color: #f3e8ff; outline: none; transition: 0.3s; }
        input:focus { box-shadow: 0 0 0 2px #cdb4ff; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="daftar-box w-full max-w-md p-10">
        <h2 class="text-2xl font-bold text-center text-[#6a4c93] mb-8">Registrasi Siswa</h2>
        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="text-sm font-semibold text-[#6a4c93] ml-2">NISN</label>
                <input type="text" name="nisn" placeholder="Masukkan NISN" class="w-full p-3 rounded-full mt-1 border-none" required>
            </div>
            <div>
                <label class="text-sm font-semibold text-[#6a4c93] ml-2">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan Nama" class="w-full p-3 rounded-full mt-1 border-none" required>
            </div>
            <div>
                <label class="text-sm font-semibold text-[#6a4c93] ml-2">Jenis Kelamin</label>
                <select name="jk" class="w-full p-3 rounded-full mt-1 border-none" required>
                    <option value="">-- Pilih --</option>
                    <option value="laki - laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-[#6a4c93] ml-2">Password</label>
                <input type="password" name="password" placeholder="Buat Password" class="w-full p-3 rounded-full mt-1 border-none" required>
            </div>
            <div>
                <label class="text-sm font-semibold text-[#6a4c93] ml-2">No HP</label>
                <input type="text" name="no_hp" placeholder="08xxxxxxxx" class="w-full p-3 rounded-full mt-1 border-none" required>
            </div>
            <button type="submit" class="w-full py-3 mt-4 bg-gradient-to-r from-[#f4b6d8] to-[#cdb4ff] text-white font-bold rounded-full hover:opacity-90 transition">
                DAFTAR SEKARANG
            </button>
        </form>
        <p class="text-center text-sm mt-6 text-[#6a4c93]">
            Sudah punya akun? <a href="login_siswa.php" class="font-bold hover:underline">Login</a>
        </p>
    </div>
</body>
</html>