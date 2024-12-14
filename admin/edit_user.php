<?php
include('../config.php'); 
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}

// Cek apakah ada ID pengguna yang dikirimkan
if (!isset($_GET['id'])) {
    header('Location: manage_users.php'); // Jika tidak ada ID, kembali ke halaman kelola pengguna
    exit;
}

// Ambil ID pengguna dari parameter URL
$user_id = $_GET['id'];

// Query untuk mengambil data pengguna berdasarkan ID
$query = "SELECT * FROM users WHERE id_user = '$user_id'";
$result = mysqli_query($conn, $query);

// Jika pengguna ditemukan
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    header('Location: manage_users.php');
    exit;
}

// Proses update data pengguna jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update query untuk mengubah data pengguna
    $update_query = "UPDATE users SET username = '$username', name = '$name', email = '$email', role = '$role' WHERE id_user = '$user_id'";

    if (mysqli_query($conn, $update_query)) {
        header('Location: manage_users.php'); // Arahkan kembali ke kelola pengguna setelah update
    } else {
        echo "Gagal memperbarui data pengguna: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #2c3e50, #3498db);
            color: white;
        }

        /* Navbar styling */
        .navbar {
            background-color: #34495e;
            overflow: hidden;
            padding: 10px 0;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .navbar li {
            display: inline-block;
            margin: 0 20px;
        }

        .navbar a {
            display: block;
            padding: 14px 20px;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }

        .navbar a:hover {
            background-color: #2980b9;
        }

        .form-container {
    margin: 40px auto;
    max-width: 600px;
    padding: 30px;
    background-color: #1e1e1e; /* Latar belakang form */
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    text-align: left; /* Align content to left */
}

.form-container h2 {
    color: #007bff;
    font-size: 28px;
    margin-bottom: 30px;
}

label {
    font-size: 16px;
    margin-bottom: 5px;
    display: inline-block; /* Allow labels to sit beside inputs */
    width: 150px; /* Set a fixed width for the labels */
}
       /* Form Styling */
.form-container {
    margin: 40px auto;
    max-width: 600px;
    padding: 30px;
    background-color: #1e1e1e; /* Latar belakang form */
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    text-align: left; /* Align content to left */
}

.form-container h2 {
    color: #007bff;
    font-size: 28px;
    margin-bottom: 30px;
}

label {
    font-size: 16px;
    margin-bottom: 5px;
    display: inline-block; /* Allow labels to sit beside inputs */
    width: 150px; /* Set a fixed width for the labels */
}

input[type="text"],
input[type="number"],
input[type="file"] {
    width: calc(100% - 160px); /* Subtract width of label and margin */
    padding: 10px;
    margin-bottom: 15px;
    background-color: #333;
    border: 1px solid #444;
    border-radius: 5px;
    color: #fff;
    font-size: 16px;
    display: inline-block;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="file"]:focus {
    border-color: #007bff;
    outline: none;
}

button {
    background-color: #007bff;
    color: #fff;
    font-size: 18px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background-color: #0056b3;
}

/* Responsive Layout for smaller screens */
@media screen and (max-width: 768px) {
    .form-container {
        width: 80%; /* Adjust the form width */
        padding: 20px;
    }

    .navbar ul {
        padding: 0;
    }

    .navbar li {
        display: block;
        margin: 5px 0;
    }

    /* Adjust form input widths for mobile */
    label {
        width: 100%;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
        width: 100%;
    }
}
        </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard_admin.php">Dashboard</a></li>
                <li><a href="add_book.php">Tambah Buku</a></li>
                <li><a href="manage_users.php">Kelola Pengguna</a></li>
                <li><a href="borrowed_books.php">Buku Dipinjam</a></li> <!-- Baru -->
                <li><a href="returned_books.php">Buku Dikembalikan</a></li> <!-- Baru -->
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="content">
            <h2>Edit Pengguna</h2>

            <form action="edit_user.php?id=<?= $user['id_user'] ?>" method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?= $user['username'] ?>" required><br>

                <label for="name">Nama:</label>
                <input type="text" name="name" value="<?= $user['name'] ?>" required><br>

                <label for="email">Email:</label>
                <input type="email" name="email" value="<?= $user['email'] ?>" required><br>

                <label for="role">Role:</label>
                <select name="role">
                    <option value="user" <?= ($user['role'] == 'user') ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                </select><br>

                <button type="submit">Update Pengguna</button>
            </form>
        </div>
    </div>
</body>
</html>
d