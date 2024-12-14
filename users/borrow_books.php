<?php
include('../config.php'); 
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header('Location: login_user.php');
    exit;
}

// Cek apakah ID buku diterima dari URL
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Query untuk mendapatkan detail buku berdasarkan ID
    $query = "SELECT * FROM buku WHERE id_buku = $id_buku";
    $result = mysqli_query($conn, $query);

    // Jika buku ditemukan
    if (mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);
    } else {
        echo "Buku tidak ditemukan!";
        exit;
    }

    // Proses peminjaman buku
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Cek apakah jumlah buku masih tersedia
        if ($book['jumlah_buku'] > 0) {
            // Insert data peminjaman ke tabel peminjaman
            $id_user = $_SESSION['id_user'];
            $query = "INSERT INTO borrowings (id_user, id_buku, tanggal_peminjaman) VALUES ($id_user, $id_buku, NOW())";

            if (mysqli_query($conn, $query)) {
                // Update jumlah buku di tabel buku
                $new_quantity = $book['jumlah_buku'] - 1;
                $update_query = "UPDATE buku SET jumlah_buku = $new_quantity WHERE id_buku = $id_buku";
                mysqli_query($conn, $update_query);

                // Redirect ke halaman dashboard_user.php setelah berhasil meminjam
                header("Location: dashboard_user.php?message=Buku berhasil dipinjam!");
                exit();
            } else {
                echo "Gagal meminjam buku: " . mysqli_error($conn);
            }
        } else {
            echo "Maaf, stok buku ini habis.";
        }
    }
} else {
    echo "ID buku tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam Buku</title>
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

        /* Container styling */
        .container {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
        }

        .content {
            background-color: #2c3e50;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: #ecf0f1;
            margin-bottom: 20px;
        }

        /* Book Grid */
        .book-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .book-item {
            background-color: #34495e;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .book-image img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .book-details {
            color: #ecf0f1;
        }

        .book-details p {
            margin: 5px 0;
            font-size: 14px;
        }

        .borrow-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #2980b9;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .borrow-button:hover {
            background-color: #1abc9c;
        }

        /* Responsif */
        @media screen and (max-width: 768px) {
            .book-list {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .book-image img {
                height: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="dashboard_user.php">Dashboard</a></li>
            <li><a href="view_books.php">Lihat Buku</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Pinjam Buku: <?= $book['title'] ?></h2>

        <!-- Formulir peminjaman buku -->
        <form action="borrow_books.php?id=<?= $book['id_buku'] ?>" method="post">
            <div class="book-details">
            <img src="../admin/<?= $book['image'] ?>" alt="Book Image" width="150" height="150">
                <p><strong>Judul Buku:</strong> <?= $book['title'] ?></p>
                <p><strong>Penulis:</strong> <?= $book['author'] ?></p>
                <p><strong>Penerbit:</strong> <?= $book['publisher'] ?></p>
                <p><strong>Tahun:</strong> <?= $book['year'] ?></p>
                <p><strong>Jumlah Tersedia:</strong> <?= $book['jumlah_buku'] ?></p>

                <?php if ($book['jumlah_buku'] > 0) { ?>
                    <button type="submit">Pinjam Buku</button>
                <?php } else { ?>
                    <p>Maaf, stok buku ini habis.</p>
                <?php } ?>
            </div>
        </form>
    </div>
</body>
</html>
