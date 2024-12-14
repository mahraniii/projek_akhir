<?php
include('../config.php');  // Koneksi ke database
session_start();

// Cek apakah ada parameter 'id' yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Query untuk menghapus buku berdasarkan ID
    $query = "DELETE FROM buku WHERE id_buku = $id_buku";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, alihkan ke halaman dashboard admin dengan pesan sukses
        header('Location: dashboard_admin.php?message=success');
        exit;
    } else {
        // Jika gagal, alihkan ke halaman dashboard admin dengan pesan error
        header('Location: dashboard_admin.php?message=error');
        exit;
    }
} else {
    // Jika tidak ada ID buku, alihkan kembali ke halaman dashboard admin
    header('Location: dashboard_admin.php');
    exit;
}
?>
