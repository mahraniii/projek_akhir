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
    header('Location: manage_users.php');
    exit;
}

// Ambil ID pengguna dari parameter URL
$id_user = $_GET['id'];

// Query untuk menghapus pengguna berdasarkan ID
$delete_query = "DELETE FROM users WHERE id_user = '$id_user'";

if (mysqli_query($conn, $delete_query)) {
    header('Location: manage_users.php'); // Arahkan kembali setelah penghapusan
} else {
    echo "Gagal menghapus pengguna: " . mysqli_error($conn);
}
?>
