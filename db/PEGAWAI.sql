-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30 Mei 2016 pada 09.29
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
-- Struktur dari tabel `pegawai`
--

CREATE TABLE IF NOT EXISTS `pegawai` (
  `id_pegawai` varchar(12) NOT NULL,
  `nip_lama` varchar(12) DEFAULT NULL,
  `nip_baru` varchar(20) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `gelar_depan` varchar(10) DEFAULT NULL,
  `gelar_belakang` varchar(20) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tgl_lhr` date DEFAULT NULL,
  `tmp_lahir` varchar(50) DEFAULT NULL,
  `kode_mst_agama` varchar(10) DEFAULT NULL,
  `kedudukan_hukum` enum('aktif','tidak aktif') DEFAULT NULL,
  `alamat` text,
  `npwp` varchar(30) DEFAULT NULL,
  `npwp_tgl` date DEFAULT NULL,
  `kartu_pegawai` varchar(30) DEFAULT NULL,
  `goldar` enum('A','B','AB','O') DEFAULT NULL,
  `kode_mst_nikah` varchar(10) DEFAULT NULL,
  `code_cl_phc` varchar(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nip_lama`, `nip_baru`, `nik`, `gelar_depan`, `gelar_belakang`, `nama`, `jenis_kelamin`, `tgl_lhr`, `tmp_lahir`, `kode_mst_agama`, `kedudukan_hukum`, `alamat`, `npwp`, `npwp_tgl`, `kartu_pegawai`, `goldar`, `kode_mst_nikah`, `code_cl_phc`) VALUES
('320520040001', NULL, NULL, '123121312321', 'Hj.', 'Ir', 'Agung Ailansyah', 'L', '1996-01-16', 'BALANGAN', 'is', 'tidak aktif', 'as', 'as', '1996-01-16', 'as', 'A', 'kw', 'P3205181203'),
('320520040002', NULL, NULL, '11112222', 'Hj', 'Dr', 'Agung', 'P', '2000-04-02', 'Bandung', 'is', 'tidak aktif', 'Jl,abc', '12342', '2016-01-29', '22222', 'B', 'kw', 'P3205181203'),
('320520160001', NULL, NULL, '1231213123213123', '2', '3', '1', 'P', '2004-02-06', 'q', 'hd', 'aktif', 'q', 'w', '2016-02-01', 'w', 'AB', 'cr', 'P3205181203');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
