<?php 
include 'koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASIKA </title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(to right, #fbc2eb 0%, #a6c1ee 100%); margin: 0; padding: 40px 20px; min-height: 100vh; display: flex; justify-content: center; }
        .container { background-color: white; width: 100%; max-width: 1250px; padding: 30px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); }
        h2 { color: #6a5acd; text-align: center; margin-bottom: 25px; font-size: 28px; }
        .btn-kembali { display: inline-block; background: linear-gradient(to right, #fbc2eb, #a6c1ee); color: white; padding: 10px 25px; border-radius: 25px; text-decoration: none; font-weight: bold; margin-bottom: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: 0.3s; }
        .table-wrapper { border-radius: 20px; overflow: hidden; border: 1px solid #eee; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background-color: #000000; color: #ffffff; padding: 20px 10px; text-transform: uppercase; font-size: 12px; border: none; }
        td { padding: 20px 10px; border-bottom: 1px solid #f0f0f0; border-right: 1px solid #f0f0f0; color: #444; text-align: center; font-size: 14px; vertical-align: middle; }
        td:last-child { border-right: none; }
        .btn-lihat { background-color: #00d2ff; color: white; padding: 6px 15px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: bold; }
        .btn-opsi { background-color: #7f8c8d; color: white; padding: 5px 10px; border-radius: 6px; text-decoration: none; font-size: 11px; display: block; margin: 3px auto; width: 60px; }
        .status-badge { padding: 5px 10px; border-radius: 12px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .status-menunggu { background: #ffeaa7; color: #d35400; }
        .status-proses { background: #81ecec; color: #0097e6; }
        .status-selesai { background: #55efc4; color: #00b894; }
    </style>
</head>
<body>

<div class="container">
    <a href="menu_siswa.php" class="btn-kembali">← Kembali</a>
    
    <h2>Riwayat Pengaduan</h2>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>ID Pengaduan</th>
                    <th>Tanggal</th>
                    <th>NISN</th>
                    <th style="width: 25%;">Isi Laporan</th>
                    <th>Status</th>
                    <th>Tanggapan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $sql = "SELECT * FROM aspirasi ORDER BY tanggal_input DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $status_class = "";
                        if($row['status'] == 'menunggu') $status_class = "status-menunggu";
                        elseif($row['status'] == 'proses') $status_class = "status-proses";
                        elseif($row['status'] == 'selesai') $status_class = "status-selesai";
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_aspirasi']; ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['tanggal_input'])); ?></td>
                    <td><?= $row['nisn']; ?></td>
                    <td style="text-align: left;"><?= $row['deskripsi']; ?></td>
                    <td>
                        <span class="status-badge <?= $status_class; ?>">
                            <?= $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <a href="menu_feedback_siswa.php?id=<?= $row['id_aspirasi']; ?>" class="btn-lihat">Lihat</a>
                    </td>
                    
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='8'>Belum ada riwayat pengaduan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>