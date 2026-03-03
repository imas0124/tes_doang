<?php
session_start();
include 'koneksi.php';

// 1. Ambil ID dari URL jika ada
$id_feedback = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// 2. LOGIKA PEMBUKA AKSES: Jika ID kosong, otomatis ambil data terakhir yang ada di database
if (empty($id_feedback)) {
    $ambil_terakhir = mysqli_query($conn, "SELECT id_feedback FROM feedback ORDER BY id_feedback DESC LIMIT 1");
    if (mysqli_num_rows($ambil_terakhir) > 0) {
        $row_t = mysqli_fetch_assoc($ambil_terakhir);
        $id_feedback = $row_t['id_feedback'];
    } else {
        // Jika database benar-benar kosong melompong
        echo "<script>alert('Database feedback masih kosong!'); window.location.href='index.php';</script>";
        exit;
    }
}

// 3. Ambil data gabungan untuk ditampilkan di form
$query_data = mysqli_query($conn, "SELECT f.*, a.nisn 
                                   FROM feedback f
                                   JOIN aspirasi a ON f.id_aspirasi = a.id_aspirasi 
                                   WHERE f.id_feedback = '$id_feedback'");
$data = mysqli_fetch_assoc($query_data);

// 4. Logika Simpan Perubahan
if (isset($_POST['update_feedback'])) {
    $pesan_baru = mysqli_real_escape_string($conn, $_POST['pesan']);
    $id_asp = $_POST['id_aspirasi'];

    $sql_update = "UPDATE feedback SET pesan = '$pesan_baru' WHERE id_feedback = '$id_feedback'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Tanggapan Berhasil Diperbarui!'); window.location.href='menu_feedback_admin.php?id=$id_asp';</script>";
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
        body { font-family: 'Quicksand', sans-serif; background: linear-gradient(135deg, #fce7f3 0%, #f5f3ff 50%, #fdf2f8 100%); }
        .form-container { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border-radius: 20px; border: 1px solid white; box-shadow: 0 20px 40px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6">

    <h1 class="text-2xl md:text-3xl font-black text-purple-500 mb-8 italic uppercase text-center drop-shadow-sm">
        EDIT TANGGAPAN NISN : <?php echo $data['nisn']; ?>
    </h1>

    <div class="form-container p-8 w-full max-w-md">
        <form method="POST">
            <input type="hidden" name="id_aspirasi" value="<?php echo $data['id_aspirasi']; ?>">
            
            <div class="mb-5">
                <label class="block text-purple-700 font-bold mb-1 text-sm uppercase">ID Tanggapan</label>
                <input type="text" value="<?php echo $id_feedback; ?>" readonly class="w-full border-2 border-purple-100 rounded-xl p-3 bg-gray-50 text-gray-400 outline-none">
            </div>

            <div class="mb-5">
                <label class="block text-pink-700 font-bold mb-1 text-sm uppercase">Isi Balasan</label>
                <textarea name="pesan" rows="5" class="w-full border-2 border-pink-200 rounded-xl p-3 outline-none focus:ring-4 focus:ring-pink-100 transition-all shadow-sm italic text-slate-700" required><?php echo $data['pesan']; ?></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="submit" name="update_feedback" class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white px-6 py-2.5 rounded-xl text-[10px] font-bold uppercase hover:scale-105 transition-all">
                    Simpan Perubahan
                </button>
                <a href="menu_feedback_admin.php" class="bg-gradient-to-r from-pink-500 to-rose-500 text-white px-6 py-2.5 rounded-xl text-[10px] font-bold uppercase hover:scale-105 transition-all">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</body>
</html>