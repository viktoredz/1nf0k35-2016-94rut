-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2016 at 02:27 AM
-- Server version: 5.6.26
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
-- Table structure for table `mst_keluarga_pilihan`
--

CREATE TABLE IF NOT EXISTS `mst_keluarga_pilihan` (
  `id_pilihan` int(11) NOT NULL,
  `tipe` enum('hubungan','jk','agama','pendidikan','pekerjaan','kawin','jkn') NOT NULL,
  `value` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_keluarga_pilihan`
--

INSERT INTO `mst_keluarga_pilihan` (`id_pilihan`, `tipe`, `value`) VALUES
(1, 'hubungan', 'KK'),
(2, 'hubungan', 'istri'),
(3, 'hubungan', 'Anak'),
(4, 'hubungan', 'Lain-lain'),
(5, 'jk', 'Laki-laki'),
(6, 'jk', 'Perempuan'),
(7, 'agama', 'Islam'),
(8, 'agama', 'Kristen'),
(9, 'agama', 'Katolik'),
(10, 'agama', 'Hindu'),
(11, 'agama', 'Budha'),
(12, 'agama', 'Konghucu'),
(13, 'agama', 'Lainnya'),
(14, 'pendidikan', 'Tidak Tamat SD/MI'),
(15, 'pendidikan', 'Masih SD/MI'),
(16, 'pendidikan', 'Tamat SD/MI'),
(17, 'pendidikan', 'Masih SLTP/MTSN'),
(18, 'pendidikan', 'Tamat SLTP/MTSN'),
(19, 'pendidikan', 'Masih SLTA/MA'),
(20, 'pendidikan', 'Tamat SLTA/MA'),
(21, 'pendidikan', 'Masih PT/Akademi'),
(22, 'pendidikan', 'Tamat PT/Akademi'),
(23, 'pendidikan', 'Tidak/Belum Sekolah'),
(24, 'pekerjaan', 'Petani'),
(25, 'pekerjaan', 'Nelayan'),
(26, 'pekerjaan', 'PNS/TNI/Polri'),
(27, 'pekerjaan', 'Pegawai Swasta'),
(28, 'pekerjaan', 'Wiraswasta'),
(29, 'pekerjaan', 'Pensiunan'),
(30, 'pekerjaan', 'Pekerja Lepas'),
(31, 'pekerjaan', 'Lainnya'),
(32, 'pekerjaan', 'Tidak/Belum Bekerja'),
(33, 'kawin', 'Belum Kawin'),
(34, 'kawin', 'Kawin'),
(35, 'kawin', 'Janda/Duda'),
(36, 'jkn', 'BPJS-PBI'),
(37, 'jkn', 'BPJS-NonPBI'),
(38, 'jkn', 'Non BPJS'),
(39, 'jkn', 'Tidak Memiliki'),
(40, 'pendidikan', 'Belum Sekolah'),
(41, 'pendidikan', 'Tidak Sekolah'),
(42, 'pekerjaan', 'Bekerja'),
(43, 'pekerjaan', 'Belum Bekerja'),
(44, 'pekerjaan', 'Tidak Bekerja'),
(45, 'pekerjaan', 'IRT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_keluarga_pilihan`
--
ALTER TABLE `mst_keluarga_pilihan`
  ADD PRIMARY KEY (`id_pilihan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_keluarga_pilihan`
--
ALTER TABLE `mst_keluarga_pilihan`
  MODIFY `id_pilihan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
