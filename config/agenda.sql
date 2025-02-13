-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Feb 2025 pada 09.09
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
  `id_guru` int(30) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `jam` time NOT NULL,
  `mtri` text NOT NULL,
  `absn` varchar(255) NOT NULL,
  `ktr` text NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dftr_agnd`
--

INSERT INTO `dftr_agnd` (`id_agnd`, `id_hsil`, `id_guru`, `id_mapel`, `id_kelas`, `id_jurusan`, `tgl`, `jam`, `mtri`, `absn`, `ktr`, `file`) VALUES
(5, 1, 11, 2, 4, 1, '2025-01-21', '15:00:00', 'er', 'er', 'er', '67abf9d336df5.pptx'),
(6, 2, 11, 7, 5, 3, '2025-02-05', '09:44:00', '11', 'qq', 'qq', '67abfa1e8a457.xlsx');

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
(1, 1, 'Mandala Raven Aditya', 'Galaxy Bimasakti', 'Pria', 'Islam', '675bddc4562d7.png', 'asdjcds@gmail.com', 'Chiron', '$2y$10$rUSFLIfl.YWgL7ycQHhoxuwCTsidZ5lyeAi3TdsRyx9KCKhwOmCkS', 'Admin'),
(11, 666, 'Raze', 'Galaxy Andromeda', 'Pria', 'Islam', '67a183018b42d.png', 'lutzslwly@proton.me', 'Guru0', '$2y$10$wgn6h6k.wBgZ4erfj4rX7eMGwqJlEq0xDbEx5J6TUB6iTG3.NsYhy', 'Guru'),
(12, 4324, 'Guru32', 'bbb', 'Wanita', 'Islam', '67a196525a903.png', 'casdafd@fasf', 'Guru1', '$2y$10$0RMi44SKsZvCG8bv7ZMuzO/rCPf2PHulQYyEYQD1jvcKqi4GM8ls.', 'Guru'),
(13, 8432, 'Siapa', 'Dimana', 'Pria', 'Islam', '67a199a9b724b.jpeg', 'Ipsumh@outlook.co.id', 'fauzi', '$2y$10$H8vJSZ7h15lXVdnFOkg5FuG2F7VxasAjvWIcoec7dcmEg2pQFXwMu', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_guru`
--

CREATE TABLE `hasil_guru` (
  `id_hsil` int(11) NOT NULL,
  `id_guru` int(30) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_guru`
--

INSERT INTO `hasil_guru` (`id_hsil`, `id_guru`, `id_kelas`, `id_mapel`, `id_jurusan`) VALUES
(1, 11, 4, 2, 1),
(2, 11, 5, 7, 3);

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
-- Struktur dari tabel `kepsek`
--

CREATE TABLE `kepsek` (
  `id_kepsek` int(11) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kepsek`
--

INSERT INTO `kepsek` (`id_kepsek`, `nip`, `nama`, `username`, `password`) VALUES
(1, '1974111020050152010\r\n', 'Walyati Retnoningsih,S.Si.,M.AP', 'retno', 'retno');

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
  `tahun_ajaran` varchar(50) NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `thn_ajar`
--

INSERT INTO `thn_ajar` (`id_ajaran`, `tahun_ajaran`, `status`) VALUES
(2, '2024 - 2025', 'Y'),
(3, '2025 - 2030', 'T');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dftr_agnd`
--
ALTER TABLE `dftr_agnd`
  ADD PRIMARY KEY (`id_agnd`),
  ADD KEY `id_hsil` (`id_hsil`,`id_guru`,`id_mapel`,`id_kelas`,`id_jurusan`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `hasil_guru`
--
ALTER TABLE `hasil_guru`
  ADD PRIMARY KEY (`id_hsil`),
  ADD KEY `id_guru` (`id_guru`,`id_kelas`,`id_mapel`,`id_jurusan`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_jurusan` (`id_jurusan`);

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
-- Indeks untuk tabel `kepsek`
--
ALTER TABLE `kepsek`
  ADD PRIMARY KEY (`id_kepsek`);

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
  MODIFY `id_agnd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `hasil_guru`
--
ALTER TABLE `hasil_guru`
  MODIFY `id_hsil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kepsek`
--
ALTER TABLE `kepsek`
  MODIFY `id_kepsek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `thn_ajar`
--
ALTER TABLE `thn_ajar`
  MODIFY `id_ajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dftr_agnd`
--
ALTER TABLE `dftr_agnd`
  ADD CONSTRAINT `dftr_agnd_ibfk_1` FOREIGN KEY (`id_hsil`) REFERENCES `hasil_guru` (`id_hsil`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dftr_agnd_ibfk_3` FOREIGN KEY (`id_mapel`) REFERENCES `hasil_guru` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dftr_agnd_ibfk_4` FOREIGN KEY (`id_kelas`) REFERENCES `hasil_guru` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dftr_agnd_ibfk_5` FOREIGN KEY (`id_jurusan`) REFERENCES `hasil_guru` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dftr_agnd_ibfk_6` FOREIGN KEY (`id_guru`) REFERENCES `hasil_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `hasil_guru`
--
ALTER TABLE `hasil_guru`
  ADD CONSTRAINT `hasil_guru_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_guru_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_guru_ibfk_3` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_guru_ibfk_4` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
