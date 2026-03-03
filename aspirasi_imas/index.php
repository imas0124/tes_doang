<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/ico" href="img/logoo.png">
    <meta charset="UTF-8">
    <title>ASIKA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            font-family: "Poppins", Arial, sans-serif;
            background: linear-gradient(135deg, #f8d7e8, #e6d9ff);
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background: linear-gradient(90deg, #f4b6d8, #cdb4ff);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Container Logo + Teks */
        .nav-left {
            display: flex;
            align-items: center;
            gap: 12px; 
        }

        .navbar img {
            height: 60px;
        }

        .nav-right a {
            text-decoration: none;
            color: #ffffff;
            margin-left: 20px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 20px;
            background-color: rgba(255,255,255,0.25);
            transition: 0.3s;
        }

        .nav-right a:hover {
            background-color: rgba(255,255,255,0.45);
            color: #6a4c93;
        }

        /* Konten Tengah */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 80vh;
            text-align: center;
        }

        .container img {
            width: 200px;
            margin-bottom: 20px;
        }

        .welcome-title {
            color: #6a4c93;
            font-size: 32px;
            background-color: rgba(255,255,255,0.6);
            padding: 15px 30px;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="nav-left">
            <img src="img/logoo.png" alt="Logo Kiri">
            <h1 class="text-2xl font-bold text-white tracking-wider">ASIKA</h1>
        </div>

        <div class="nav-right">
            <a href="siswa.php">Siswa</a>
            <a href="admin.php">Admin</a>
        </div>
    </div>

    <div class="container">
        <img src="img/logoo.png" alt="Logo Tengah">
        <h1 class="welcome-title">Selamat Datang di Aspirasi Siswa</h1>
    </div>

</body>
</html>