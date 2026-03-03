<?php
include 'koneksi.php';

// Ambil ID Aspirasi dan NISN dari URL agar formulir tahu siapa yang ditanggapi
$id_asp_otomatis = isset($_GET['id']) ? $_GET['id'] : '';
$nisn_otomatis   = isset($_GET['nisn']) ? $_GET['nisn'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_feedback      = $_POST['id_feedback']; 
    $id_aspirasi      = $_POST['id_aspirasi']; // Ini id_aspirasi asli untuk database
    $id_admin         = $_POST['id_admin'];
    $pesan            = mysqli_real_escape_string($conn, $_POST['pesan']);
    $tanggal_feedback = $_POST['tanggal_feedback'];

    // Query simpan ke tabel feedback (Sesuai kolom di databasemu)
    $query = "INSERT INTO feedback (id_feedback, id_aspirasi, id_admin, pesan, tanggal_feedback) 
              VALUES ('$id_feedback', '$id_aspirasi', '$id_admin', '$pesan', '$tanggal_feedback')";

    // ... bagian atas kode tetap sama ...

if (mysqli_query($conn, $query)) {
    // Otomatis update status aspirasi menjadi SELESAI
    mysqli_query($conn, "UPDATE aspirasi SET status='SELESAI' WHERE id_aspirasi='$id_aspirasi'");
    
    // PERBAIKAN: Tambahkan ?id= agar halaman riwayat tahu data mana yang mau dibuka
    echo "<script>alert('Tanggapan Berhasil Dikirim!'); window.location.href='menu_feedback_admin.php?id=$id_aspirasi';</script>";
} else {
    echo "<script>alert('Gagal! ID Tanggapan mungkin sudah ada.');</script>";
}

// ... sisa kode formulir ke bawah tetap sama ...
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
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-slate-50 font-['Quicksand']">
    <div class="w-full max-w-md bg-white p-10 rounded-[2.5rem] shadow-xl border border-white">
        <h1 class="text-2xl font-bold text-slate-800 text-center mb-1">Feedback Petugas</h1>

        <form action="" method="POST" class="space-y-5">
            <input type="hidden" name="id_aspirasi" value="<?php echo $id_asp_otomatis; ?>">
            <input type="hidden" name="tanggal_feedback" value="<?php echo date('Y-m-d H:i:s'); ?>">

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-1 uppercase">ID Tanggapan (Isi Manual)</label>
                <input type="number" name="id_feedback" class="w-full p-4 rounded-2xl bg-slate-50 border-none outline-none focus:ring-2 focus:ring-indigo-300" placeholder="Contoh: 101" required>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-1 uppercase">ID Petugas</label>
                <input type="number" name="id_admin" class="w-full p-4 rounded-2xl bg-slate-50 border-none outline-none focus:ring-2 focus:ring-indigo-300" placeholder="Masukkan ID Anda" required>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 mb-1 uppercase">Isi Balasan</label>
                <textarea name="pesan" rows="4" class="w-full p-4 rounded-2xl bg-slate-50 border-none outline-none focus:ring-2 focus:ring-indigo-300" placeholder="Tulis tanggapan..." required></textarea>
            </div>

            <button type="submit" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all uppercase text-[10px] tracking-widest shadow-lg shadow-indigo-100">
                Kirim Feedback
            </button>
            <div class="mt-12 text-center">
        <a href="data_aspirasi.php" class="text-indigo-600 font-bold hover:underline">← Kembali ke Menu</a>
    </div>
        </form>
    </div>
</body>
</html>
 