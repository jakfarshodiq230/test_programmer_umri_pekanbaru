-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 08 Agu 2024 pada 23.24
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tes_umri`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayar`
--

CREATE TABLE `bayar` (
  `id` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_jenis_bayar` int NOT NULL,
  `id_mahasiswa` int NOT NULL,
  `jumlah` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bayar`
--

INSERT INTO `bayar` (`id`, `tanggal`, `id_jenis_bayar`, `id_mahasiswa`, `jumlah`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, '2024-08-09 00:00:00', 2, 153510357, 120000, '2024-08-09 05:54:54', '2024-08-09 06:14:45', '2024-08-09 06:14:45'),
(4, '2024-08-09 00:00:00', 2, 153510357, 12000045, '2024-08-09 06:09:40', '2024-08-09 06:09:40', NULL),
(5, '2024-08-09 00:00:00', 2, 153510357, 78999, '2024-08-09 06:13:53', '2024-08-09 06:14:27', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_bayar`
--

CREATE TABLE `jenis_bayar` (
  `id` int NOT NULL,
  `nama_pembayaran` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jenis_bayar`
--

INSERT INTO `jenis_bayar` (`id`, `nama_pembayaran`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SPP', '2024-08-08 17:45:17', '2024-08-08 17:45:17', NULL),
(2, 'SPP 4', '2024-08-08 17:48:04', '2024-08-08 17:48:51', '2024-08-08 05:48:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mtr_mahasiswa`
--

CREATE TABLE `mtr_mahasiswa` (
  `nim_mhs` char(10) NOT NULL,
  `nama_mhs` varchar(255) NOT NULL,
  `id_program_studi` int NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `mtr_mahasiswa`
--

INSERT INTO `mtr_mahasiswa` (`nim_mhs`, `nama_mhs`, `id_program_studi`, `password`, `tanggal_lahir`, `created_at`, `updated_at`, `deleted_at`) VALUES
('123456788', 'shodiq', 2, '$2y$12$UxRcjAk0EG3NnoAA47Tw.uPFPMMB7dzn1mLArDsCpA36TH35b5/fm', '2024-08-08', '2024-08-08 11:48:16', '2024-08-08 11:48:16', NULL),
('123456789', 'asasss', 1, '$2y$12$Nzlja3jij8TRw6WPJNY9dOWM9EWL/DXakflDlXs8PwaKa9eocSBLy', '2024-08-07', '2024-08-08 10:55:13', '2024-08-08 11:06:57', '2024-08-08 11:06:57'),
('153510357', 'Jakfar Shodiq', 1, '12345', '2024-08-08', '2024-08-08 03:16:50', '2024-08-08 03:16:50', NULL),
('999999999', 'heru', 2, '$2y$12$44E87r7aOBjMozbT9tSubOSvxd1JYvCmZQrK7s2E6Znw2Y1CKLJQm', '2024-08-08', '2024-08-08 12:18:32', '2024-08-08 12:19:01', '2024-08-08 12:19:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mtr_prodi`
--

CREATE TABLE `mtr_prodi` (
  `id` int NOT NULL,
  `nama_prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `mtr_prodi`
--

INSERT INTO `mtr_prodi` (`id`, `nama_prodi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Teknik Informatika', '2024-08-08 03:31:58', '2024-08-08 03:31:58', NULL),
(2, 'Pendidikan', '2024-08-08 11:36:23', '2024-08-08 11:36:23', NULL),
(4, 'Pendidikanaass', '2024-08-08 11:41:12', '2024-08-08 11:42:58', '2024-08-08 11:42:58'),
(5, 'Agama Islam', '2024-08-08 11:45:57', '2024-08-08 11:45:57', NULL),
(6, 'Jakfar', '2024-08-08 12:12:15', '2024-08-08 12:12:33', '2024-08-08 12:12:33');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bayar`
--
ALTER TABLE `bayar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jenis_bayar`
--
ALTER TABLE `jenis_bayar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mtr_mahasiswa`
--
ALTER TABLE `mtr_mahasiswa`
  ADD PRIMARY KEY (`nim_mhs`);

--
-- Indeks untuk tabel `mtr_prodi`
--
ALTER TABLE `mtr_prodi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bayar`
--
ALTER TABLE `bayar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jenis_bayar`
--
ALTER TABLE `jenis_bayar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `mtr_prodi`
--
ALTER TABLE `mtr_prodi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
