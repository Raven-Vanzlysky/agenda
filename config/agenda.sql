-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Okt 2024 pada 04.03
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
-- Database: `agenda`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dftr_agnd`
--

CREATE TABLE `dftr_agnd` (
  `id_agnd` int(11) NOT NULL,
  `id_hsil` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `jam` time NOT NULL,
  `mtri` varchar(255) NOT NULL,
  `absn` varchar(255) NOT NULL,
  `ktr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(30) NOT NULL,
  `nip` int(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `agama` varchar(30) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id_guru`, `nip`, `nama`, `alamat`, `jenis_kelamin`, `agama`, `foto`, `email`, `username`, `password`, `level`) VALUES
(1, 1, 'Prof. Raven', 'Galaxy Bimasakti', 'Pria', 'Islam', '67035976632cd.png', 'asdjcds@gmail.com', 'Chiron', '$2y$10$yzFphaV4fWBIyfn8DPqs6uhfpMssXAPzT3hlBRz5B/SuiDILWIk4e', 'Admin'),
(2, 4324374, 'Suki', 'Pluto', 'Wanita', 'Konghuchu', '67035aeeb62d4.jpg', 'cdsada@gmail.com', 'Guru0', '$2y$10$z7rcgBvpVmo3OxBd6bBlleDIIYsgita8l8ZcAMm5hYla1oiVDe9Z6', 'Guru'),
(3, 0, 'Bozetmars', 'Merkurius', 'Pria', 'Islam', '67035b7d020cc.png', 'bozet@gmail.com', 'Guru', '$2y$10$W2lhUapTgS3ao6PtCbrJ4ed1WOa2Svp9BfaFC6OGRDa9ie4USX2vS', 'Guru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_guru`
--

CREATE TABLE `hasil_guru` (
  `id_hsil` int(11) NOT NULL,
  `nip` int(30) NOT NULL,
  `mpl` varchar(255) NOT NULL,
  `kls` varchar(50) NOT NULL,
  `jrsn` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `jrsn` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `jrsn`) VALUES
(1, 'RPL'),
(2, 'ATPH'),
(3, 'TBSM');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `kls` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `kls`) VALUES
(4, 'XII'),
(5, 'XI'),
(6, 'X');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `mpl` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `mpl`) VALUES
(2, 'Kejuruan RPL'),
(3, 'Kejuruan ATPH'),
(4, 'Kejuruan TBSM'),
(5, 'Bahasa Indonesia'),
(6, 'Bahasa Inggris'),
(7, 'Bahasa Sunda'),
(8, 'Matematika'),
(9, 'Pendidikan Kewarganegaraan'),
(10, 'Ilmu Pengetahuan Alam & Sosial'),
(11, 'Pendidikan Jasmani'),
(12, 'Pendidikan Agama & Budi Pekerti'),
(13, 'PKKR'),
(14, 'Sejarah'),
(15, 'Bimbingan Konseling');

-- --------------------------------------------------------

--
-- Struktur dari tabel `thn_ajar`
--

CREATE TABLE `thn_ajar` (
  `id_ajaran` int(11) NOT NULL,
  `tahun_ajaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `thn_ajar`
--

INSERT INTO `thn_ajar` (`id_ajaran`, `tahun_ajaran`) VALUES
(1, '2024 - 2025');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dftr_agnd`
--
ALTER TABLE `dftr_agnd`
  ADD PRIMARY KEY (`id_agnd`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `hasil_guru`
--
ALTER TABLE `hasil_guru`
  ADD PRIMARY KEY (`id_hsil`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `thn_ajar`
--
ALTER TABLE `thn_ajar`
  ADD PRIMARY KEY (`id_ajaran`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dftr_agnd`
--
ALTER TABLE `dftr_agnd`
  MODIFY `id_agnd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `hasil_guru`
--
ALTER TABLE `hasil_guru`
  MODIFY `id_hsil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `thn_ajar`
--
ALTER TABLE `thn_ajar`
  MODIFY `id_ajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
