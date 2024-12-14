<?php
include('../config.php'); // Koneksi ke database

// Proses registrasi ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Validasi input
    if (empty($username) || empty($password) || empty($name) || empty($email)) {
        $error_message = "Semua field harus diisi!";
    } else {
        // Cek apakah username sudah ada
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Username sudah terdaftar!";
        } else {
            // Enkripsi password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Query untuk menyimpan data pengguna
            $insert_query = "INSERT INTO users (username, password, name, email, role, created_at) 
                             VALUES ('$username', '$hashed_password', '$name', '$email', 'user', NOW())";

            if (mysqli_query($conn, $insert_query)) {
                // Jika registrasi berhasil, arahkan pengguna ke halaman login
                header('Location: login_user.php');
                exit;
            } else {
                $error_message = "Gagal mendaftar: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
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
        input[type="password"],
        input[type="email"] {
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
    <script>
        // Fungsi untuk mengisi email dengan nama pengguna yang dimasukkan
        function autofillEmail() {
            const name = document.getElementById('name').value;
            const email = name.toLowerCase().replace(/\s+/g, '') + '@gmail.com'; // Atur email sesuai nama
            document.getElementById('email').value = email;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Registrasi Pengguna</h2>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php } ?>

        <!-- Form registrasi -->
        <form action="register_user.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="name">Nama Lengkap:</label>
            <input type="text" name="name" id="name" required oninput="autofillEmail()">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <button type="submit">Daftar</button>
        </form>

    </div>
</body>
</html>
