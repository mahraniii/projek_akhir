<?php
include('../config.php');  // Koneksi ke database
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}

// Query untuk menampilkan semua buku
$query = "SELECT * FROM buku";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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

        /* Content styling */
        .content {
            background-color: #2c3e50;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 80%;
            margin: 40px auto;
        }

        h2 {
            color: #ecf0f1;
            margin-bottom: 20px;
        }

        /* Book Grid */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .book-card {
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
        }

        .book-details {
            margin-top: 15px;
            color: #ecf0f1;
        }

        .book-details h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .book-details p {
            margin: 5px 0;
            font-size: 14px;
        }

        .book-actions a {
            color: #1abc9c;
            text-decoration: none;
            margin: 0 5px;
        }

        .book-actions a:hover {
            text-decoration: underline;
        }

        /* Responsif */
        @media screen and (max-width: 768px) {
            .book-grid {
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
        <li><a href="dashboard_admin.php">Dashboard</a></li>
        <li><a href="add_book.php">Tambah Buku</a></li>
        <li><a href="manage_users.php">Kelola Pengguna</a></li>
        <li><a href="borrowed_books.php">Buku Dipinjam</a></li> <!-- Baru -->
        <li><a href="returned_books.php">Buku Dikembalikan</a></li> <!-- Baru -->
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</div>

    <div class="content">
        <h2>Daftar Buku</h2>
        <div class="book-grid">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="book-card">
                    <div class="book-image">
                        <?php if (!empty($row['image'])) { ?>
                            <img src="<?= $row['image'] ?>" alt="Book Image">
                        <?php } else { ?>
                            <img src="default-image.jpg" alt="No Image" />
                        <?php } ?>
                    </div>
                    <div class="book-details">
                        <h3><?= $row['title'] ?></h3>
                        <p><strong>Author:</strong> <?= $row['author'] ?></p>
                        <p><strong>Publisher:</strong> <?= $row['publisher'] ?></p>
                        <p><strong>Year:</strong> <?= $row['year'] ?></p>
                        <p><strong>Jumlah Buku:</strong> <?= $row['jumlah_buku'] ?></p>
                    </div>
                    <div class="book-actions">
                        <a href="edit_book.php?id=<?= $row['id_buku'] ?>">Edit</a> |
                        <a href="delete_book.php?id=<?= $row['id_buku'] ?>">Delete</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>
