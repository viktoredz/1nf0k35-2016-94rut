-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 23 Mei 2016 pada 06.55
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
-- Struktur dari tabel `mst_peg_struktur_org`
--

CREATE TABLE IF NOT EXISTS `mst_peg_struktur_org` (
  `tar_id_struktur_org` int(11) NOT NULL,
  `tar_id_struktur_org_parent` int(11) DEFAULT '0',
  `tar_nama_posisi` varchar(100) NOT NULL,
  `tar_aktif` int(2) DEFAULT '1',
  `code_cl_phc` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mst_peg_struktur_org`
--

INSERT INTO `mst_peg_struktur_org` (`tar_id_struktur_org`, `tar_id_struktur_org_parent`, `tar_nama_posisi`, `tar_aktif`, `code_cl_phc`) VALUES
(1, 0, 'Kepala Puskesmas', 1, 'P3205181203'),
(2, 1, 'Kepala Sub Bagian Tata Usaha', 1, 'P3205181203'),
(3, 2, 'Sistem Informasi Puskesmas', 1, 'P3205181203'),
(4, 2, 'Kepegawaian', 1, 'P3205181203'),
(5, 2, 'Rumah Tangga', 1, 'P3205181203'),
(6, 2, 'Keuangan', 1, 'P3205181203'),
(7, 1, 'Penanggung Jawab UKM Essensial dan Keperawatan Masyarakat', 1, 'P3205181203'),
(8, 1, 'Penanggung jawab UKM Pengembangan', 1, 'P3205181203'),
(9, 1, 'Penanggung Jawab UKP, Kefarmasian dan Laboratorium', 1, 'P3205181203'),
(10, 1, 'Penanggung Jawab Jaringan Pelayanan Puskesmas dan Jejaring Puskesmas Pelayanan Kesehatan', 1, 'P3205181203'),
(11, 7, 'Pelayanan Promosi Kesehatan Termasuk UKS', 1, 'P3205181203'),
(12, 7, 'Pelayanan Kesehatan Lingkungan', 1, 'P3205181203'),
(13, 7, 'Pelayanan KIA-KB yang bersifat UKM', 1, 'P3205181203'),
(14, 7, 'Pelayanan Gizi yang Bersifat UKM', 1, 'P3205181203'),
(15, 7, 'Pelayanan Pencegahan dan Pengendalian Penyakit', 1, 'P3205181203'),
(16, 7, 'Pelayanan Keperawatan Kesehatan Masyarakat', 1, 'P3205181203'),
(17, 8, 'Pelayanan Kesehatan Jiwa', 1, 'P3205181203'),
(18, 8, 'Pelayanan Kesehatan Gigi Masyarakat', 1, 'P3205181203'),
(19, 8, 'Pelayanan Kesehatan Tradisional Komplementer', 1, 'P3205181203'),
(20, 8, 'Pelayanan Kesehatan Indera', 1, 'P3205181203'),
(21, 8, 'Pelayanan Kesehatan Olahraga', 1, 'P3205181203'),
(22, 8, 'Pelayanan Kesehatan Lansia', 1, 'P3205181203'),
(23, 8, 'Pelayanan Kesehatan Kerja', 1, 'P3205181203'),
(24, 8, 'Pelayanan Kesehatan Lainnya', 1, 'P3205181203'),
(25, 9, 'Pelayanan Pemeriksaan Umum', 1, 'P3205181203'),
(26, 9, 'Pelayanan Kesehatan Gigi dan Mulut', 1, 'P3205181203'),
(27, 9, 'Pelayanan Kesehatan KIA - KB yang bersifat UKP', 1, 'P3205181203'),
(28, 9, 'Pelayanan Gawat Darurat', 1, 'P3205181203'),
(29, 9, 'Pelayananan Gizi yang Bersifat UKP', 1, 'P3205181203'),
(30, 9, 'Pelayanan Persalinan', 1, 'P3205181203'),
(31, 9, 'Pelayanan Rawat Inap', 1, 'P3205181203'),
(32, 9, 'Pelayanan Kefarmasian', 1, 'P3205181203'),
(33, 9, 'Pelayanan Laboratorium', 1, 'P3205181203'),
(34, 10, 'Puskesmas Pembantu', 1, 'P3205181203'),
(35, 10, 'Puskesmas Keliling', 1, 'P3205181203'),
(36, 10, 'Jejaring Fasilitas Pelayanan Kesehatan', 1, 'P3205181203'),
(37, 10, 'Bidan Desa', 1, 'P3205181203'),
(38, 1, 'Dokter Umum', 1, 'P3205181203'),
(39, 1, 'Dokter Gigi', 1, 'P3205181203'),
(40, 1, 'Apoteker', 1, 'P3205181203'),
(41, 1, 'Asisten Apoteker', 1, 'P3205181203'),
(42, 1, 'Bidan', 1, 'P3205181203'),
(43, 1, 'Perawat', 1, 'P3205181203'),
(44, 1, 'Sanitarian', 1, 'P3205181203'),
(45, 1, 'Promosi Kesehatan', 1, 'P3205181203'),
(46, 1, 'Nutrisionis', 1, 'P3205181203'),
(47, 1, 'Analis', 1, 'P3205181203'),
(48, 1, 'Epidemiologi', 1, 'P3205181203'),
(49, 1, 'Entomologi', 1, 'P3205181203'),
(50, 1, 'Perawat Gigi', 1, 'P3205181203');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_peg_struktur_org`
--
ALTER TABLE `mst_peg_struktur_org`
  ADD PRIMARY KEY (`tar_id_struktur_org`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_peg_struktur_org`
--
ALTER TABLE `mst_peg_struktur_org`
  MODIFY `tar_id_struktur_org` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;