-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 25 Mei 2016 pada 03.53
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

DELIMITER $$
--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `bulan`() RETURNS varchar(4) CHARSET latin1
RETURN @bulan$$

CREATE DEFINER=`root`@`localhost` FUNCTION `func`() RETURNS date
RETURN @var$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tahun`() RETURNS varchar(4) CHARSET latin1
RETURN @tahun$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tglkondisi`() RETURNS date
RETURN @tglkondisi$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tglrusak`() RETURNS date
RETURN @tglrusak$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_peg_status`
--

CREATE TABLE IF NOT EXISTS `mst_peg_status` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mst_peg_status`
--

INSERT INTO `mst_peg_status` (`kode`, `nama`) VALUES
('CPNS', 'Calon Pegawai Negeri Sipil'),
('HONORER', 'Honorer'),
('KAT2', 'Kat 2'),
('NRPTT', 'NR. PTT'),
('PNS', 'Pegawai Negeri Sipil'),
('PTT', 'PTT'),
('PTTPONED', 'PTT Poned'),
('SUKWAN', 'Sukwan');

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
