-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 27 Mei 2016 pada 04.43
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
-- Struktur dari tabel `pegawai_jabatan`
--

CREATE TABLE IF NOT EXISTS `pegawai_jabatan` (
  `id_pegawai` varchar(12) NOT NULL,
  `nip_nit` varchar(20) NOT NULL,
  `tmt` date NOT NULL,
  `jenis` enum('STRUKTURAL','FUNGSIONAL_TERTENTU','FUNGSIONAL_UMUM') DEFAULT NULL,
  `unor` varchar(100) DEFAULT NULL COMMENT 'Unit Organisasi',
  `id_mst_peg_struktural` int(10) DEFAULT NULL,
  `id_mst_peg_fungsional` int(10) DEFAULT NULL,
  `tgl_pelantikan` date DEFAULT NULL,
  `sk_jb_tgl` date DEFAULT NULL,
  `sk_jb_nomor` varchar(50) DEFAULT NULL,
  `sk_jb_pejabat` varchar(100) DEFAULT NULL,
  `sk_status` enum('pengangkatan','pemberhentian') DEFAULT NULL,
  `prosedur` varchar(100) DEFAULT 'Mutasi Jabatan' COMMENT 'Prosedur Awal',
  `code_cl_phc` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pegawai_jabatan`
--
ALTER TABLE `pegawai_jabatan`
  ADD PRIMARY KEY (`id_pegawai`,`tmt`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
