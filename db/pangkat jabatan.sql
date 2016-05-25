-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2016 at 04:41 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `epus_prog_3205`
--
CREATE DATABASE IF NOT EXISTS `epus_prog_3205` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `epus_prog_3205`;

DELIMITER $$
--
-- Functions
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
-- Table structure for table `pegawai_jabatan`
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
  `sk_status` enum('pengangkatan','pemberhentian') DEFAULT NULL,
  `prosedur` varchar(100) DEFAULT 'Mutasi Jabatan' COMMENT 'Prosedur Awal',
  `code_cl_phc` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`,`tmt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_pangkat`
--

CREATE TABLE IF NOT EXISTS `pegawai_pangkat` (
  `id_pegawai` varchar(12) NOT NULL,
  `nip_nit` varchar(20) DEFAULT NULL,
  `tmt` date NOT NULL,
  `tat` date DEFAULT NULL,
  `id_mst_peg_golruang` varchar(10) NOT NULL,
  `is_pnsbaru` int(2) DEFAULT '0',
  `is_pengangkatan` int(5) DEFAULT '0',
  `status` varchar(20) DEFAULT NULL,
  `jenis_pengadaan` enum('umum','honorer','penggantian') DEFAULT NULL,
  `jenis_pangkat` enum('reguler','pilihan','istimewa','penyesuaian ijazah') DEFAULT NULL,
  `masa_krj_bln` int(5) DEFAULT NULL,
  `masa_krj_thn` int(5) DEFAULT NULL,
  `bkn_tgl` date DEFAULT NULL,
  `bkn_nomor` varchar(30) DEFAULT NULL,
  `sk_pejabat` varchar(50) DEFAULT NULL,
  `sk_tgl` date DEFAULT NULL,
  `sk_nomor` varchar(30) DEFAULT NULL,
  `spmt_tgl` date DEFAULT NULL,
  `spmt_nomor` varchar(30) DEFAULT NULL,
  `sttpl_tgl` date DEFAULT NULL,
  `sttpl_nomor` varchar(30) DEFAULT NULL,
  `dokter_tgl` date DEFAULT NULL,
  `dokter_nomor` varchar(30) DEFAULT NULL,
  `status_pns` varchar(10) DEFAULT NULL,
  `code_cl_phc` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`,`tmt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pegawai_pangkat`
--

INSERT INTO `pegawai_pangkat` (`id_pegawai`, `nip_nit`, `tmt`, `tat`, `id_mst_peg_golruang`, `is_pnsbaru`, `is_pengangkatan`, `status`, `jenis_pengadaan`, `jenis_pangkat`, `masa_krj_bln`, `masa_krj_thn`, `bkn_tgl`, `bkn_nomor`, `sk_pejabat`, `sk_tgl`, `sk_nomor`, `spmt_tgl`, `spmt_nomor`, `sttpl_tgl`, `sttpl_nomor`, `dokter_tgl`, `dokter_nomor`, `status_pns`, `code_cl_phc`) VALUES
('320520040001', '34', '2016-05-26', NULL, 'I/D', 0, 0, 'PNS', NULL, NULL, 5, 10, '2016-05-24', '45', '45', '2016-05-24', '45', NULL, NULL, '2016-05-24', '56', '2016-05-24', '56', '1', NULL),
('320520040001', '12', '2016-05-25', NULL, 'I/D', 0, 0, 'PNS', NULL, 'pilihan', 4, 4, '2016-05-24', '12', '12', '2016-05-24', '12', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL),
('320520040001', '231212', '2016-05-24', NULL, 'II/B', 0, 0, 'CPNS', 'umum', NULL, 5, 4, '2016-05-24', '23', '23123', '2016-05-14', '23123', '2016-05-28', '23123123123123123123', NULL, NULL, NULL, NULL, NULL, NULL),
('320520160001', '1234 1234 1234 1234', '2000-01-01', '2002-01-01', '-', 0, 0, 'PTTPONED', 'umum', NULL, 0, 0, '2016-05-25', '-', '-', '2016-05-25', '-', '2016-05-25', '-', NULL, NULL, NULL, NULL, NULL, NULL),
('320520160001', '1234 1234 1234 1234', '2002-01-03', NULL, '-', 0, 0, 'CPNS', 'umum', NULL, 2, 2, '2016-05-25', '-', '-', '2016-05-25', '-', '2016-05-25', '-', NULL, NULL, NULL, NULL, NULL, NULL),
('320520160001', '1234 1234 1234 1236', '2010-05-01', NULL, 'III/A', 0, 0, 'PNS', NULL, 'reguler', 7, 7, '2016-05-25', '-', '-', '2016-05-25', '-', NULL, NULL, '2016-05-25', '-', '2016-05-25', '-', '1', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
