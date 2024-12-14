<?php
include('../config.php');  // Koneksi ke database
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}

// Cek apakah ada parameter 'id' yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Query untuk mengambil data buku berdasarkan ID
    $query = "SELECT * FROM buku WHERE id_buku = $id_buku";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        // Jika tidak ada buku dengan ID tersebut, alihkan ke halaman dashboard admin
        header('Location: dashboard_admin.php');
        exit;
    }

    $book = mysqli_fetch_assoc($result);
} else {
    // Jika tidak ada ID buku, alihkan ke halaman dashboard admin
    header('Location: dashboard_admin.php');
    exit;
}

// Proses pembaruan data buku
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $year = $_POST['year'];
    $jumlah_buku = $_POST['jumlah_buku'];

    // Proses upload gambar jika ada
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";  // Folder untuk menyimpan gambar
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah ada gambar yang diupload
    if ($image != '') {
        // Validasi file gambar
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            // Pindahkan file gambar ke folder tujuan
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Jika ada gambar baru, update gambar ke database
                $image_query = ", image = '$target_file'";
            } else {
                $error_message = "Terjadi kesalahan saat mengunggah gambar.";
            }
        } else {
            $error_message = "Hanya file gambar dengan ekstensi JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        }
    } else {
        $image_query = ''; // Jika tidak ada gambar baru, jangan update gambar
    }

    // Query untuk memperbarui data buku
    $update_query = "UPDATE buku SET title = '$title', author = '$author', publisher = '$publisher', year = '$year', jumlah_buku = '$jumlah_buku' $image_query WHERE id_buku = $id_buku";

    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    } else {
        if (mysqli_query($conn, $update_query)) {
            header('Location: dashboard_admin.php?message=updated');
            exit;
        } else {
            $error_message = "Gagal memperbarui data buku: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
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
    <div class="form-container">
        <h2>Edit Buku</h2>
        <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>
        
        <form action="edit_book.php?id=<?= $book['id_buku'] ?>" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?= $book['title'] ?>" required><br>

            <label for="author">Author:</label>
            <input type="text" name="author" value="<?= $book['author'] ?>" required><br>

            <label for="publisher">Publisher:</label>
            <input type="text" name="publisher" value="<?= $book['publisher'] ?>" required><br>

            <label for="year">Year:</label>
            <input type="number" name="year" value="<?= $book['year'] ?>" required><br>

            <label for="jumlah_buku">Jumlah Buku:</label>
            <input type="number" name="jumlah_buku" value="<?= $book['jumlah_buku'] ?>" required><br>

            <label for="image">Image (Optio):</label>
            <input type="file" name="image"><br>

            <button type="submit">Update Buku</button>
        </form>

        <a href="dashboard_admin.php" style="color: #fff; display: block; text-align: center; margin-top: 20px;">Kembali ke Dashboard</a>
    </div>
</body>
</html>
