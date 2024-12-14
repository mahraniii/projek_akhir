<?php
include('../config.php'); 
session_start();

// Query untuk menampilkan buku
$query = "SELECT * FROM buku";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Buku</title>
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

    <!-- Navbar -->
    <div class="navbar">
        <ul>
            <li><a href="dashboard_user.php">Dashboard</a></li>
            <li><a href="view_books.php">Lihat Buku</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Konten Utama -->
    <div class="content">
        <h2>Daftar Buku</h2>
        <div class="book-list">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="book-item">
                    <div class="book-image">
                        <?php if (!empty($row['image'])) { ?>
                            <img src="../admin/<?= $row['image'] ?>" alt="Book Image">
                        <?php } else { ?>
                            <p>No Image</p>
                        <?php } ?>
                    </div>
                    <div class="book-details">
                        <p><strong>Title:</strong> <?= $row['title'] ?></p>
                        <p><strong>Author:</strong> <?= $row['author'] ?></p>
                        <p><strong>Publisher:</strong> <?= $row['publisher'] ?></p>
                        <p><strong>Year:</strong> <?= $row['year'] ?></p>
                        <p><strong>Jumlah Buku:</strong> <?= $row['jumlah_buku'] ?></p>
                    </div>
                    <a href="borrow_books.php?id=<?= $row['id_buku'] ?>" class="borrow-button">Pinjam</a>
                </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>
