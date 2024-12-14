-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2024 pada 07.36
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_online`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin123\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `borrowings`
--

CREATE TABLE `borrowings` (
  `id_peminjaman` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tanggal_peminjaman` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `jumlah_buku` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `title`, `author`, `publisher`, `year`, `jumlah_buku`, `image`, `created_at`, `updated_at`) VALUES
(6, 'Keong Mas', 'Mahrani', 'Salsa Nabila', 1990, 145, 'uploads/keongmas.jpg', '2024-11-15 08:53:21', '2024-12-13 08:03:04'),
(7, 'Timun Mas', 'Fajri Pratama', 'Gading Dasilva', 1985, 90, 'uploads/timunmas.png', '2024-11-18 03:57:39', '2024-12-13 08:02:18'),
(8, 'Bawang merah dan Bawang putih', 'Nata', 'Arif', 1999, 59, 'uploads/bawang.jpg', '2024-11-18 05:10:01', '2024-12-05 06:51:55'),
(9, 'Malin Kundang', 'Yura', 'Ika', 1950, 23, 'uploads/malinkundang.jpg', '2024-11-18 05:10:41', '2024-12-05 06:53:20'),
(11, 'Nyi Roro Kidul', 'Aldo', 'Ariel', 2000, 393, 'uploads/nyirorokidul.jpg', '2024-11-20 07:08:12', '2024-12-05 06:53:13'),
(12, 'Lutung Kasarung', 'Lidia', 'Aulia', 1995, 170, 'uploads/lutung.jpg', '2024-11-20 07:12:57', '2024-11-20 07:12:57'),
(14, 'Joko Kendil', 'Hafiz', 'Naufal', 2001, 97, 'uploads/jokokendil.jpg', '2024-11-20 07:14:34', '2024-12-05 06:56:42'),
(15, 'Telaga Biru', 'Denada', 'Putra', 1988, 89, 'uploads/telagabiru.jpg', '2024-11-20 07:15:14', '2024-12-05 06:59:33'),
(16, 'Ning Randa', 'Febby', 'Gracia', 1970, 109, 'uploads/ningranda.jpg', '2024-11-20 07:18:33', '2024-12-05 05:17:35'),
(17, 'Siamang Putri', 'Nana', 'Lulu', 234, 149, 'uploads/siamangputri.jpg', '2024-11-20 07:50:35', '2024-12-05 07:00:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_pengembalian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `id_user`, `id_buku`, `tanggal_pengembalian`) VALUES
(1, 24, 8, '2024-12-05'),
(2, 13, 11, '2024-12-05'),
(3, 13, 9, '2024-12-05'),
(4, 13, 14, '2024-12-05'),
(5, 13, 15, '2024-12-05'),
(6, 13, 17, '2024-12-05'),
(7, 13, 7, '2024-12-05'),
(8, 13, 7, '2024-12-12'),
(9, 13, 7, '2024-12-13'),
(10, 13, 7, '2024-12-13'),
(11, 13, 7, '2024-12-13'),
(12, 13, 7, '2024-12-13'),
(13, 13, 6, '2024-12-13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `name`, `email`, `role`, `created_at`, `updated_at`) VALUES
(13, 'salsa', '$2y$10$yBanxzrNwS0Tws58sH53Au0PPym3srQtmGxuVZjoE5T3jfcE.6B/m', 'salsanabila', 'sal@gmail.com', 'user', '2024-11-18 05:14:34', '2024-11-18 05:14:34'),
(24, 'rahman', '$2y$10$6VEAolhe2yWkLoKkTWz7xOPd69KCOJuFf0zlZUHJ56QItXeEm4SQ2', 'rahman', 'rahman@gmail.com', 'user', '2024-12-05 06:25:35', '2024-12-05 06:25:35');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`);

--
-- Indeks untuk tabel `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `borrowings_ibfk_1` (`id_user`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Ketidakleluasaan untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `pengembalian_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
