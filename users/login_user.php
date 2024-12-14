<?php
session_start();
include('../config.php');  // Koneksi ke database

// Cek apakah form login telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Amankan input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query untuk memeriksa apakah username ada di database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header('Location: dashboard_user.php');
            exit();
        } else {
            $error_message = "Username atau password salah!";
        }
    } else {
        $error_message = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna - Perpustakaan Online</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #232946;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .container h2 {
            text-align: center;
            color: #eebbc3;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        .error-message {
            color: #ff6b6b;
            text-align: center;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background: #eebbc3;
            color: #232946;
            font-size: 1rem;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #eebbc3;
            border: none;
            border-radius: 5px;
            color: #232946;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #6e7dff;
        }
        p {
            text-align: center;
            color: #b0b0b0;
            font-size: 0.9rem;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Pengguna</h2>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php } ?>

        <!-- Form login -->
        <form action="login_user.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p>Belum punya akun? <a href="register_user.php">Daftar di sini</a></p>
    </div>
</body>
</html>
