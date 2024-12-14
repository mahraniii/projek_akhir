<?php
session_start();
include('../config.php'); // Koneksi ke database

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login_user.php");
    exit();
}

// Ambil id_peminjaman dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_peminjaman = $_POST['id_peminjaman'];

    // Validasi id_peminjaman
    if (empty($id_peminjaman)) {
        $_SESSION['error'] = "ID peminjaman tidak valid.";
        header("Location: dashboard_user.php");
        exit();
    }

    // Ambil data buku dan id_user berdasarkan peminjaman
    $query_borrowing = "SELECT id_user, id_buku FROM borrowings WHERE id_peminjaman = ?";
    $stmt_borrowing = mysqli_prepare($conn, $query_borrowing);
    
    if ($stmt_borrowing) {
        mysqli_stmt_bind_param($stmt_borrowing, 'i', $id_peminjaman);
        mysqli_stmt_execute($stmt_borrowing);
        mysqli_stmt_bind_result($stmt_borrowing, $id_user, $id_buku);
        mysqli_stmt_fetch($stmt_borrowing);
        mysqli_stmt_close($stmt_borrowing);

        // Dapatkan tanggal pengembalian saat ini
        $tanggal_pengembalian = date("Y-m-d");

        // Insert data pengembalian ke tabel pengembalian
        $query_insert = "INSERT INTO pengembalian (id_user, id_buku, tanggal_pengembalian) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $query_insert);

        if ($stmt_insert) {
            mysqli_stmt_bind_param($stmt_insert, 'iis', $id_user, $id_buku, $tanggal_pengembalian);
            $success_insert = mysqli_stmt_execute($stmt_insert); // Eksekusi query insert ke pengembalian

            if ($success_insert) {
                // Hapus data peminjaman dari tabel borrowings
                $query_delete = "DELETE FROM borrowings WHERE id_peminjaman = ?";
                $stmt_delete = mysqli_prepare($conn, $query_delete);

                if ($stmt_delete) {
                    mysqli_stmt_bind_param($stmt_delete, 'i', $id_peminjaman);
                    $success_delete = mysqli_stmt_execute($stmt_delete); // Eksekusi query delete

                    if ($success_delete) {
                        $_SESSION['message'] = "Buku berhasil dikembalikan.";
                    } else {
                        $_SESSION['error'] = "Gagal menghapus peminjaman. Silakan coba lagi.";
                    }

                    mysqli_stmt_close($stmt_delete); // Tutup prepared statement untuk delete
                }
            } else {
                $_SESSION['error'] = "Gagal memasukkan data ke pengembalian. Silakan coba lagi.";
            }

            mysqli_stmt_close($stmt_insert); // Tutup prepared statement untuk insert
        }
    } else {
        $_SESSION['error'] = "Gagal mendapatkan data peminjaman. Silakan coba lagi.";
    }

    // Redirect ke halaman yang sesuai setelah proses
    header("Location: dashboard_user.php");
    exit();
}
?>
