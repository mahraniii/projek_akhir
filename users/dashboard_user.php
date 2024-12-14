<?php
session_start();
include('../config.php');  // Koneksi ke database

// Ambil data buku yang dipinjam oleh pengguna
$id_user = $_SESSION['id_user'];
$query = "SELECT br.id_peminjaman, b.title, b.author, b.publisher, b.year, br.tanggal_peminjaman 
          FROM borrowings br 
          JOIN buku b ON br.id_buku = b.id_buku 
          WHERE br.id_user = $id_user";
$result = mysqli_query($conn, $query);

// Cek apakah ada buku yang dipinjam
$borrowed_books = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #2c3e50, #3498db); /* Gradient background */
            color: white; /* Teks berwarna putih */
        }

        /* Navbar styling */
        .navbar {
            background-color: #34495e; /* Biru gelap */
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
            background-color: #2980b9; /* Biru terang */
        }

        /* Container styling */
        .container {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
        }

        /* Content styling */
        .content {
            background-color: #2c3e50; /* Latar belakang abu-abu gelap */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        h2, h3 {
            color: #ecf0f1;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin: 15px 0;
            color: #bdc3c7;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #bdc3c7;
            text-align: left;
        }

        table th {
            background-color: #2980b9;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #34495e;
        }

        table tr:nth-child(odd) {
            background-color: #2c3e50;
        }

        table td {
            color: #ecf0f1;
        }

        table tr:hover {
            background-color: #16a085; /* Efek hover baris tabel */
            cursor: pointer;
        }

        /* Mobile responsiveness */
        @media screen and (max-width: 768px) {
            .navbar li {
                display: block;
                width: 100%;
                margin: 5px 0;
            }

            .container {
                width: 95%;
            }

            table th, table td {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <ul>
            <li><a href="dashboard_user.php">Dashboard</a></li>
            <li><a href="view_books.php">Lihat Buku</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Notifikasi -->
    <div class="container">
        <?php if (isset($_SESSION['message'])) { ?>
            <div style="background-color: #2ecc71; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div style="background-color: #e74c3c; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php } ?>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="content">
            <h2>Selamat datang, <?= $_SESSION['username'] ?>!</h2>
            <p>Anda berhasil login sebagai <?= $_SESSION['role'] ?>.</p>

            <h3>Buku yang telah Anda pinjam:</h3>
            <?php if (empty($borrowed_books)) { ?>
                <p>Anda belum meminjam buku apapun.</p>
            <?php } else { ?>
                <table>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>22
                        <th>Tanggal Peminjaman</th>
                        <th>Aksi</th>
                    </tr>
                    <?php foreach ($borrowed_books as $book) { ?>
                        <tr>
                            <td><?= $book['title'] ?></td>
                            <td><?= $book['author'] ?></td>
                            <td><?= $book['publisher'] ?></td>
                            <td><?= $book['year'] ?></td>
                            <td><?= $book['tanggal_peminjaman'] ?></td>
                            <td>
                                <form action="return_books.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_peminjaman" value="<?= $book['id_peminjaman'] ?>">
                                    <button type="submit" style="background-color: #e74c3c; color: white; padding: 8px 16px; border: none; border-radius: 5px; cursor: pointer;">
                                        Kembalikan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>
    </div>
</body>
</html>
