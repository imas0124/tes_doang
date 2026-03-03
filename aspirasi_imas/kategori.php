<?php
include 'koneksi.php';
// Proses Simpan Kategori
if(isset($_POST['simpan'])){
    $ket = $_POST['ket_kategori'];
    mysqli_query($conn, "INSERT INTO kategori (ket_kategori) VALUES ('$ket')");
    header("location:kategori.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <title>ASIKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 50%, #eff6ff 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(15px); border-radius: 1.5rem; border: 1px solid white; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); overflow: hidden; }
    </style>
</head>
<body class="p-10">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8">Kelola Kategori</h1>

        <div class="glass-card p-6 mb-6">
            <form method="POST" class="flex gap-2">
                <input type="text" name="ket_kategori" placeholder="Nama Kategori Baru..." class="flex-1 p-3 rounded-xl border border-gray-200 outline-none" required>
                <button type="submit" name="simpan" class="bg-black text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-800 transition-colors">Simpan</button>
            </form>
        </div>

        <div class="glass-card">
            <table class="w-full border-collapse">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="p-5 w-20 text-center">NO</th>
                        <th class="p-5 text-center">KATEGORI</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    <?php 
                    $no = 1;
                    $data = mysqli_query($conn, "SELECT * FROM kategori");
                    if(mysqli_num_rows($data) > 0) {
                        while($d = mysqli_fetch_array($data)){
                    ?>
                        <tr class="border-b border-gray-100 hover:bg-white/50 transition-colors">
                            <td class="p-5 font-bold text-center"><?php echo $no++; ?></td>
                            <td class="p-5 text-center capitalize"><?php echo $d['ket_kategori']; ?></td>
                        </tr>
                    <?php 
                        } 
                    } else {
                    ?>
                        <tr><td colspan="2" class="p-10 text-gray-400 italic text-center">Belum ada kategori.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-10 text-center">
        <a href="menu_admin.php" class="text-purple-600 font-bold hover:underline transition">
            ← Kembali ke Dashboard
        </a>
    </div>
</body>
</html>