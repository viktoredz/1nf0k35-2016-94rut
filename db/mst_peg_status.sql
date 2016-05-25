-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 25 Mei 2016 pada 08.18
-- Versi Server: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epus_prog_3205`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_peg_status`
--

CREATE TABLE IF NOT EXISTS `mst_peg_status` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mst_peg_status`
--

INSERT INTO `mst_peg_status` (`kode`, `nama`, `no_urut`) VALUES
('CPNS', 'Calon Pegawai Negeri Sipil', 2),
('HONORER', 'Honorer', 7),
('KAT2', 'Kat 2', 8),
('NRPTT', 'NR. PTT', 4),
('PNS', 'Pegawai Negeri Sipil', 1),
('PTT', 'PTT', 3),
('PTTPONED', 'PTT Poned', 5),
('SUKWAN', 'Sukwan', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_peg_status`
--
ALTER TABLE `mst_peg_status`
  ADD PRIMARY KEY (`kode`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
