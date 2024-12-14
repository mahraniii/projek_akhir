<?php
include('../config.php'); // File koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $year = $_POST['year'];
    $jumlah_buku = $_POST['jumlah_buku'];

    // Proses upload gambar
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";  // Folder untuk menyimpan gambar
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid
    if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Insert data buku ke database
            $query = "INSERT INTO buku (title, author, publisher, year, jumlah_buku, image) 
                      VALUES ('$title', '$author', '$publisher', '$year', '$jumlah_buku', '$target_file')";
            
            if (mysqli_query($conn, $query)) {
                // Redirect ke halaman dashboard untuk menampilkan buku yang baru ditambahkan
                header('Location: dashboard_admin.php');
                exit;
            } else {
                echo "Gagal menambahkan buku: " . mysqli_error($conn);
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah gambar.";
        }
    } else {
        echo "Hanya file gambar dengan ekstensi JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
    }
}
?>
