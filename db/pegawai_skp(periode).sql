-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 13 Jun 2016 pada 10.55
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
-- Struktur dari tabel `pegawai_skp`
--

CREATE TABLE IF NOT EXISTS `pegawai_skp` (
  `id_pegawai` varchar(12) NOT NULL DEFAULT '',
  `tahun` int(10) NOT NULL,
  `id_pegawai_penilai` varchar(12) DEFAULT NULL,
  `skp` double(10,2) DEFAULT NULL,
  `tgl_dibuat` date DEFAULT NULL,
  `periode` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pegawai_skp`
--

INSERT INTO `pegawai_skp` (`id_pegawai`, `tahun`, `id_pegawai_penilai`, `skp`, `tgl_dibuat`, `periode`) VALUES
('320520040001', 2016, '320520160001', 0.00, '2016-06-13', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_skp_nilai`
--

CREATE TABLE IF NOT EXISTS `pegawai_skp_nilai` (
  `id_pegawai` varchar(12) NOT NULL DEFAULT '',
  `tahun` int(10) NOT NULL,
  `id_mst_peg_struktur_org` int(10) NOT NULL,
  `id_mst_peg_struktur_skp` int(10) NOT NULL,
  `ak` int(10) NOT NULL,
  `kuant` int(10) NOT NULL,
  `target` int(10) NOT NULL,
  `waktu` int(10) NOT NULL,
  `biaya` int(10) NOT NULL,
  `periode` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pegawai_skp_nilai`
--

INSERT INTO `pegawai_skp_nilai` (`id_pegawai`, `tahun`, `id_mst_peg_struktur_org`, `id_mst_peg_struktur_skp`, `ak`, `kuant`, `target`, `waktu`, `biaya`, `periode`) VALUES
('320520040001', 2016, 2, 1, 0, 1, 80, 12, 0, 1),
('320520040001', 2016, 2, 2, 0, 1, 80, 12, 0, 1),
('320520040001', 2016, 2, 3, 0, 1, 80, 12, 0, 1),
('320520040001', 2016, 2, 4, 0, 1, 80, 12, 0, 1),
('320520040001', 2016, 2, 6, 0, 1, 80, 3, 0, 1),
('320520040001', 2016, 2, 1515151, 0, 1, 80, 1, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pegawai_skp`
--
ALTER TABLE `pegawai_skp`
  ADD PRIMARY KEY (`id_pegawai`,`tahun`,`periode`);

--
-- Indexes for table `pegawai_skp_nilai`
--
ALTER TABLE `pegawai_skp_nilai`
  ADD PRIMARY KEY (`id_pegawai`,`tahun`,`id_mst_peg_struktur_org`,`id_mst_peg_struktur_skp`,`periode`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
