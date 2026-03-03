<?php
session_start();
include 'koneksi.php'; 

$pesan = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query cek username dan password
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // --- PERBAIKAN DI SINI ---
        $_SESSION['admin_user'] = $data['username'];
        $_SESSION['level'] = 'admin'; // Tambahkan ini agar halaman feedback tahu Anda Admin!
        // -------------------------
        
        header("Location:menu_admin.php"); 
        exit;
    } else {
        $pesan = "❌ Username / Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <title>ASIKA</title>
    <style>
        body {
            margin: 0;
            font-family: "Poppins", Arial, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f8d7e8, #e6d9ff);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 35px;
            width: 380px;
            border-radius: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            color: #6a4c93;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #6a4c93;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px;
            border: none;
            border-radius: 20px;
            background-color: #f3e8ff;
            outline: none;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 20px;
            background: linear-gradient(90deg, #f4b6d8, #cdb4ff);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.85;
        }

        .error {
            text-align: center;
            color: red;
            margin-bottom: 10px;
            font-size: 14px;
        }

        p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        a {
            color: #a066c9;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Admin</h2>

    <?php if ($pesan != "") { ?>
        <div class="error"><?= $pesan ?></div>
    <?php } ?>

    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <p>Kembali ke <a href="index.php">Home</a></p>
</div>

</body>
</html>
