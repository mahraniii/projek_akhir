<?php
session_start();
include('config.php'); // Koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Online</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #1e1e2f, #232946);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #2a2f4f;
            border-radius: 15px;
            padding: 30px;
            max-width: 500px; /* Lebar maksimal kontainer lebih besar */
            width: 100%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .container h2 {
            color: #eebbc3;
            font-size: 2rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
        }
        .error-message {
            color: #ff6b6b;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }
        button {
            background: #eebbc3;
            border: none;
            border-radius: 50px;
            color: #232946;
            font-size: 1.1rem;
            font-weight: bold;
            padding: 15px;
            width: 50%; /* Membuat tombol memanjang penuh */
            margin: 10px 0;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        button:hover {
            background: #ff7f50;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }
        p {
            color: #b8c1ec;
            font-size: 0.9rem;
            margin-top: 30px;
        }
        a {
            color: #eebbc3;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
        }
        a:hover {
            text-decoration: underline;
            color: #ff7f50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selamat Datang di Perpustakaan Online</h2>
        
        <a href="users/login_user.php">
            <button>Login Pengguna</button>
        </a>
        <a href="users/register_user.php">
            <button>Registrasi Pengguna</button>
        </a>

        <p>Anda admin? <a href="admin/login_admin.php">Login Admin</a></p>
    </div>
</body>
</html>
