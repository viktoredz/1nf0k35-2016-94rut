-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 27 Mei 2016 pada 04.29
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
-- Struktur dari tabel `mst_peg_fungsional`
--

CREATE TABLE IF NOT EXISTS `mst_peg_fungsional` (
  `tar_id_fungsional` int(10) NOT NULL,
  `tar_nama_fungsional` varchar(100) DEFAULT NULL,
  `tar_jenis` varchar(100) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `mst_peg_fungsional`
--

INSERT INTO `mst_peg_fungsional` (`tar_id_fungsional`, `tar_nama_fungsional`, `tar_jenis`) VALUES
(1, 'Pengadministrasi Bahan Penyusunan Rencana dan Pelaporan', 'FUNGSIONAL_UMUM'),
(2, 'Pengumpul dan Pengolah Data Laporan', 'FUNGSIONAL_UMUM'),
(3, 'Operator Komputer', 'FUNGSIONAL_UMUM'),
(4, 'Bendahara Pengeluaran', 'FUNGSIONAL_UMUM'),
(5, 'Bendahara Gaji', 'FUNGSIONAL_UMUM'),
(6, 'Penata Laporan Keuangan', 'FUNGSIONAL_UMUM'),
(7, 'Verifikator Keuangan', 'FUNGSIONAL_UMUM'),
(8, 'Agendaris dan Pramu Tamu', 'FUNGSIONAL_UMUM'),
(9, 'Pengadministrasi Umum Barang dan Perlengkapan', 'FUNGSIONAL_UMUM'),
(10, 'Pengelola Administrasi dan Pengembangan Pegawai', 'FUNGSIONAL_UMUM'),
(11, 'Pengolah Data Kepegawaian', 'FUNGSIONAL_UMUM'),
(12, 'Pengemudi', 'FUNGSIONAL_UMUM'),
(13, 'Pelaksana Teknis Pengembangan Promosi Kesehatan dan Jaminan Pemeliharaan Kesehatan', 'FUNGSIONAL_UMUM'),
(14, 'Pengadministrasi Program dan Laporan Promosi Kesehatan dan Jaminan Pemeliharaan Kesehatan Masyarakat', 'FUNGSIONAL_UMUM'),
(15, 'Pengadministrasi Program dan Laporan Pendataan dan Informasi Kesehatan', 'FUNGSIONAL_UMUM'),
(16, 'Pelaksana Teknis Pendataan dan Informasi Kesehatan', 'FUNGSIONAL_UMUM'),
(17, 'Pengadministrasi Program dan Laporan Akreditasi Institusi dan Tenaga Kesehatan', 'FUNGSIONAL_UMUM'),
(18, 'Penatausaha Teknis Akreditasi Institusi dan Tenaga Kesehatan', 'FUNGSIONAL_UMUM'),
(19, 'Bendahara Pengeluaran Pembantu', 'FUNGSIONAL_UMUM'),
(20, 'Pengadministrasi Program dan Laporan Surveilans', 'FUNGSIONAL_UMUM'),
(21, 'Pelaksana Teknis Pencegahan Penyakit dan Penanggulangan Kejadian Luar Biasa', 'FUNGSIONAL_UMUM'),
(22, 'Pengadministrasi Program dan Laporan Penyehatan Lingkungan', 'FUNGSIONAL_UMUM'),
(23, 'Pelaksana Teknis Penyehatan Lingkungan', 'FUNGSIONAL_UMUM'),
(24, 'Pengadministrasi Program dan Laporan Pemberantasan Penyakit', 'FUNGSIONAL_UMUM'),
(25, 'Pelaksana Teknis Pengendalian Penyakit', 'FUNGSIONAL_UMUM'),
(26, 'Pengadministrasi Program dan Laporan Pelayanan Kesehatan Dasar', 'FUNGSIONAL_UMUM'),
(27, 'Pelaksana Teknis Layanan Kesehatan Dasar dan Institusi', 'FUNGSIONAL_UMUM'),
(28, 'Pengadministrasi Program dan Laporan Pelayanan Kesehatan Khusus dan Rujukan', 'FUNGSIONAL_UMUM'),
(29, 'Pelaksana Teknis Pelayanan Kesehatan Khusus dan Rujukan', 'FUNGSIONAL_UMUM'),
(30, 'Pengadministrasi Program dan Laporan Pengawasan dan Perbekalan Farmasi', 'FUNGSIONAL_UMUM'),
(31, 'Pelaksana Teknis Pengawasan Farmasi, Makanan dan Minuman serta Perbekalan Kesehatan', 'FUNGSIONAL_UMUM'),
(32, 'Pengadministrasi Program dan Laporan Gizi Masyarakat', 'FUNGSIONAL_UMUM'),
(33, 'Pelaksana Teknis Kesehatan Keluarga dan Gizi Masyarakat', 'FUNGSIONAL_UMUM'),
(34, 'Pengadministrasi Program dan Laporan Kesehatan Ibu dan Anak', 'FUNGSIONAL_UMUM'),
(35, 'Pelaksana Teknis Layanan Kesehatan Ibu dan Anak', 'FUNGSIONAL_UMUM'),
(36, 'Pengadministrasi Program dan Laporan Kesehatan Remaja dan Usia Lanjut', 'FUNGSIONAL_UMUM'),
(37, 'Pelaksana Teknis Layanan Kesehatan Remaja dan Usia Lanjut', 'FUNGSIONAL_UMUM'),
(38, 'Pengadministrasi Umum dan Jamkesmas', 'FUNGSIONAL_UMUM'),
(39, 'Pengelola Sarana dan Prasarana', 'FUNGSIONAL_UMUM'),
(40, 'Pengadministrasi Umum', 'FUNGSIONAL_UMUM'),
(41, 'Pengelola Sarana dan Prasarana Laboratorium', 'FUNGSIONAL_UMUM'),
(42, 'Petugas Pembantu Laporan (asisten)', 'FUNGSIONAL_UMUM'),
(43, 'Dokter Pertama', 'FUNGSIONAL_TERTENTU'),
(44, 'Dokter Muda', 'FUNGSIONAL_TERTENTU'),
(45, 'Dokter Madya', 'FUNGSIONAL_TERTENTU'),
(46, 'Dokter Utama', 'FUNGSIONAL_TERTENTU'),
(47, 'Dokter Gigi Pertama', 'FUNGSIONAL_TERTENTU'),
(48, 'Dokter Gigi Muda', 'FUNGSIONAL_TERTENTU'),
(49, 'Dokter Gigi Madya', 'FUNGSIONAL_TERTENTU'),
(50, 'Dokter Gigi Utama', 'FUNGSIONAL_TERTENTU'),
(51, 'Bidan Pelaksana Pemula', 'FUNGSIONAL_TERTENTU'),
(52, 'Bidan Pelaksana ', 'FUNGSIONAL_TERTENTU'),
(53, 'Bidan Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(54, 'Bidan Penyelia', 'FUNGSIONAL_TERTENTU'),
(55, 'Bidan Pertama', 'FUNGSIONAL_TERTENTU'),
(56, 'Bidan Muda', 'FUNGSIONAL_TERTENTU'),
(57, 'Bidan Madya', 'FUNGSIONAL_TERTENTU'),
(58, 'Perawat Pelaksana Pemula', 'FUNGSIONAL_TERTENTU'),
(59, 'Perawat Pelaksana ', 'FUNGSIONAL_TERTENTU'),
(60, 'Perawat Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(61, 'Perawat Penyelia', 'FUNGSIONAL_TERTENTU'),
(62, 'Perawat Pertama', 'FUNGSIONAL_TERTENTU'),
(63, 'Perawat Muda', 'FUNGSIONAL_TERTENTU'),
(64, 'Perawat Madya', 'FUNGSIONAL_TERTENTU'),
(65, 'Perawat Gigi Pelaksana Pemula', 'FUNGSIONAL_TERTENTU'),
(66, 'Perawat Gigi Pelaksana ', 'FUNGSIONAL_TERTENTU'),
(67, 'Perawat Gigi Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(68, 'Perawat Gigi Penyelia', 'FUNGSIONAL_TERTENTU'),
(69, 'Pranata Laboratorium Kesehatan Pelaksana Pemula', 'FUNGSIONAL_TERTENTU'),
(70, 'Pranata Laboratorium Kesehatan Pelaksana ', 'FUNGSIONAL_TERTENTU'),
(71, 'Pranata Laboratorium Kesehatan Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(72, 'Pranata Laboratorium Kesehata Penyelia', 'FUNGSIONAL_TERTENTU'),
(73, 'Pranata Laboratorium Kesehatan Pertama', 'FUNGSIONAL_TERTENTU'),
(74, 'Pranata Laboratorium Kesehatan Muda', 'FUNGSIONAL_TERTENTU'),
(75, 'Pranata Laboratorium Kesehatan Madya', 'FUNGSIONAL_TERTENTU'),
(76, 'Sanitarian Pelaksana Pemula', 'FUNGSIONAL_TERTENTU'),
(77, 'Sanitarian Pelaksana ', 'FUNGSIONAL_TERTENTU'),
(78, 'Sanitarian Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(79, 'Sanitarian Penyelia', 'FUNGSIONAL_TERTENTU'),
(80, 'Sanitarian Pertama', 'FUNGSIONAL_TERTENTU'),
(81, 'Sanitarian Muda', 'FUNGSIONAL_TERTENTU'),
(82, 'Sanitarian Madya', 'FUNGSIONAL_TERTENTU'),
(83, 'Nutrisionis Pelaksana ', 'FUNGSIONAL_TERTENTU'),
(84, 'Nutrisionis Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(85, 'Nutrisionis Penyelia', 'FUNGSIONAL_TERTENTU'),
(86, 'Nutrisionis Pertama', 'FUNGSIONAL_TERTENTU'),
(87, 'Nutrisionis Muda', 'FUNGSIONAL_TERTENTU'),
(88, 'Nutrisionis Madya', 'FUNGSIONAL_TERTENTU'),
(89, 'Asisten Apoteker Pelaksana Pemula', 'FUNGSIONAL_TERTENTU'),
(90, 'Asisten Apoteker Pelaksana ', 'FUNGSIONAL_TERTENTU'),
(91, 'Asisten Apoteker Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(92, 'Asisten Apoteker Penyelia', 'FUNGSIONAL_TERTENTU'),
(93, 'Apoteker Pertama', 'FUNGSIONAL_TERTENTU'),
(94, 'Apoteker Muda', 'FUNGSIONAL_TERTENTU'),
(95, 'Apoteker Madya', 'FUNGSIONAL_TERTENTU'),
(96, 'Apoteker Utama', 'FUNGSIONAL_TERTENTU'),
(97, 'Radiografer Pelaksana ', 'FUNGSIONAL_TERTENTU'),
(98, 'Radiografer Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(99, 'Radiografer Penyelia', 'FUNGSIONAL_TERTENTU'),
(100, 'Penyuluh Kesehatan Masyarakat Pelaksana ', 'FUNGSIONAL_TERTENTU'),
(101, 'Penyuluh Kesehatan Masyarakat Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(102, 'Penyuluh Kesehatan Masyarakat Penyelia', 'FUNGSIONAL_TERTENTU'),
(103, 'Penyuluh Kesehatan Masyarakat Pertama', 'FUNGSIONAL_TERTENTU'),
(104, 'Penyuluh Kesehatan Masyarakat Muda', 'FUNGSIONAL_TERTENTU'),
(105, 'Penyuluh Kesehatan Masyarakat Madya', 'FUNGSIONAL_TERTENTU'),
(106, 'Perekam Medis Pelaksana', 'FUNGSIONAL_TERTENTU'),
(107, 'Perekam Medis Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(108, 'Perekam Medis Penyelia', 'FUNGSIONAL_TERTENTU'),
(109, 'Administrator Kesehatan Pertama', 'FUNGSIONAL_TERTENTU'),
(110, 'Administrator Kesehatan Muda', 'FUNGSIONAL_TERTENTU'),
(111, 'Administrator Kesehatan Madya', 'FUNGSIONAL_TERTENTU'),
(112, 'Administrator Kepegawaian Pertama', 'FUNGSIONAL_TERTENTU'),
(113, 'Administrator Kepegawaian Muda', 'FUNGSIONAL_TERTENTU'),
(114, 'Administrator Kepegawaian Madya', 'FUNGSIONAL_TERTENTU'),
(115, 'Pembimbing Keselamatan dan Kesehatan Kerja Pertama', 'FUNGSIONAL_TERTENTU'),
(116, 'Pembimbing Keselamatan dan Kesehatan Kerja Muda', 'FUNGSIONAL_TERTENTU'),
(117, 'Pembimbing Keselamatan dan Kesehatan Kerja Madya', 'FUNGSIONAL_TERTENTU'),
(118, 'Arsiparis Pelaksana', 'FUNGSIONAL_TERTENTU'),
(119, 'Arsiparis Pelaksana Lanjutan', 'FUNGSIONAL_TERTENTU'),
(120, 'Arsiparis Penyelia', 'FUNGSIONAL_TERTENTU'),
(121, 'Arsiparis Pertama', 'FUNGSIONAL_TERTENTU'),
(122, 'Arsiparis Muda', 'FUNGSIONAL_TERTENTU'),
(123, 'Arsiparis Madya', 'FUNGSIONAL_TERTENTU'),
(124, 'Arsiparis Utama', 'FUNGSIONAL_TERTENTU');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_peg_fungsional`
--
ALTER TABLE `mst_peg_fungsional`
  ADD PRIMARY KEY (`tar_id_fungsional`),
  ADD UNIQUE KEY `AK_Key_1` (`tar_id_fungsional`),
  ADD KEY `FK_Reference_27` (`tar_jenis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_peg_fungsional`
--
ALTER TABLE `mst_peg_fungsional`
  MODIFY `tar_id_fungsional` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=125;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
