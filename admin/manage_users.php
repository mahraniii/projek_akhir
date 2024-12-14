<?php
include('../config.php');  // Koneksi ke database
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}

// Query untuk menampilkan semua pengguna
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <style>
       /* Reset dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to right, #2c3e50, #3498db); /* Hanya latar belakang biru */
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

/* Konten */
.content {
    padding: 30px;
    background-color: transparent; /* Tidak ada warna latar belakang */
}

h2 {
    color: white; /* Mengubah warna teks menjadi putih */
    font-size: 32px;
    margin-bottom: 30px;
    text-align: center;
    background-color: transparent; /* Menghilangkan warna latar belakang pada judul */
}


/* Tabel */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #444;
}

th {
    background-color: #34495e; /* Mengubah warna latar belakang header tabel */
    color: white;
}

td {
    background-color: transparent; /* Menghapus warna latar belakang tabel */
    color: white; /* Menyesuaikan teks dengan warna latar belakang */
}

/* Menambahkan latar belakang dongker untuk kolom ID Pengguna, Username, Nama, Email, Role, dan Action */
td:first-child, td:nth-child(2), td:nth-child(3), td:nth-child(4), td:nth-child(5), td:last-child {
    background-color: #34495e; /* Warna dongker */
}

/* Menjaga warna teks untuk kolom action */
td a {
    color: #f44336;
    text-decoration: none;
}

td a:hover {
    color: #ff5722;
}

/* Responsif untuk mobile */
@media (max-width: 768px) {
    .navbar ul {
        flex-direction: column;
    }
}

    </style>
</head>
<body>
    <div class="navbar">
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
        <h2>Daftar Pengguna</h2>

        <table>
            <tr>
                <th>ID Pengguna</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['id_user'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= ucfirst($row['role']) ?></td>
                <td>
                    <a href="edit_user.php?id=<?= $row['id_user'] ?>">Edit</a> |
                    <a href="delete_user.php?id=<?= $row['id_user'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
