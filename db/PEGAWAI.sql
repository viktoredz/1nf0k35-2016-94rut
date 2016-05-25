-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 25 Mei 2016 pada 03.32
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
('320520040001', NULL, NULL, '123121312321', 'Hj.', 'Ir', 'Agung Ailansyah', 'L', '1996-01-16', 'BALANGAN', 'is', 'tidak aktif', 'as', 'as', '1996-01-16', 'as', 'A', 'kw', '0'),
('320520040002', NULL, NULL, '11112222', 'Hj', 'Dr', 'Agung', 'P', '2000-04-02', 'Bandung', 'is', 'tidak aktif', 'Jl,abc', '12342', '2016-01-29', '22222', 'B', 'kw', '3205181203'),
('320520160001', NULL, NULL, '1231213123213123', '2', '3', '1', 'P', '2004-02-06', 'q', 'hd', 'aktif', 'q', 'w', '2016-02-01', 'w', 'AB', 'cr', '3205181203');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_diklat`
--

CREATE TABLE IF NOT EXISTS `pegawai_diklat` (
  `id_pegawai` varchar(12) NOT NULL,
  `mst_peg_id_diklat` int(10) NOT NULL,
  `tipe` enum('struktural','formal','informal') DEFAULT NULL,
  `nama_diklat` varchar(100) DEFAULT NULL,
  `lama_diklat` int(10) DEFAULT NULL,
  `tgl_diklat` date DEFAULT NULL,
  `nomor_sertifikat` varchar(45) DEFAULT NULL,
  `instansi` varchar(100) DEFAULT NULL,
  `penyelenggara` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pegawai_diklat`
--

INSERT INTO `pegawai_diklat` (`id_pegawai`, `mst_peg_id_diklat`, `tipe`, `nama_diklat`, `lama_diklat`, `tgl_diklat`, `nomor_sertifikat`, `instansi`, `penyelenggara`) VALUES
('320520040001', 1, 'struktural', 'as', NULL, '2016-02-29', 'as', NULL, NULL),
('320520040001', 22, 'formal', 'Enterp', 3, '2016-03-01', 'd', 'd', 'd'),
('320520040001', 42, 'informal', 'asdasd asd', 9, '2016-03-01', 's', 's', 's');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_dp3`
--

CREATE TABLE IF NOT EXISTS `pegawai_dp3` (
  `nip_nit` varchar(20) NOT NULL DEFAULT '',
  `tahun` int(10) NOT NULL,
  `setia` int(10) DEFAULT NULL,
  `prestasi` int(10) DEFAULT NULL,
  `tanggungjawab` int(10) DEFAULT NULL,
  `taat` int(10) DEFAULT NULL,
  `jujur` int(10) DEFAULT NULL,
  `kerjasama` int(10) DEFAULT NULL,
  `pimpin` int(10) DEFAULT NULL,
  `prakarsa` int(10) DEFAULT NULL,
  `jumlah` int(10) DEFAULT NULL,
  `ratarata` double(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_gaji`
--

CREATE TABLE IF NOT EXISTS `pegawai_gaji` (
  `nip_nit` varchar(20) NOT NULL,
  `tmt` date NOT NULL,
  `id_mst_peg_golruang` varchar(10) NOT NULL DEFAULT '',
  `sk_tgl` date DEFAULT NULL,
  `sk_no` varchar(50) DEFAULT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  `gapok` double(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_hukdis`
--

CREATE TABLE IF NOT EXISTS `pegawai_hukdis` (
  `nip_nit` varchar(20) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `jenis` enum('administrasi','disiplin') DEFAULT NULL,
  `nama_hukdis` varchar(100) DEFAULT NULL,
  `menetapkan` varchar(100) DEFAULT NULL,
  `tar_sk_tgl` date DEFAULT NULL,
  `tar_sk_no` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_jabatan`
--

CREATE TABLE IF NOT EXISTS `pegawai_jabatan` (
  `nip_nit` varchar(20) NOT NULL,
  `tmt` date NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `jenis` enum('Struktural','Struktural Berhenti','Fungsional','Fungsional Berhenti') DEFAULT NULL,
  `id_mst_peg_struktural` int(10) DEFAULT NULL,
  `id_mst_peg_fungsional` int(10) DEFAULT NULL,
  `tgl_pelantikan` date DEFAULT NULL,
  `sk_jb_tgl` date DEFAULT NULL,
  `sk_jb_nomor` varchar(50) DEFAULT NULL,
  `tar_status_aktif` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_keluarga`
--

CREATE TABLE IF NOT EXISTS `pegawai_keluarga` (
  `id_pegawai` varchar(12) NOT NULL DEFAULT '',
  `urut` int(10) NOT NULL,
  `id_mst_peg_keluarga` int(10) NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `code_cl_district` varchar(4) DEFAULT NULL,
  `bpjs` varchar(20) DEFAULT NULL,
  `status_hidup` int(1) DEFAULT '1',
  `status_pns` int(1) DEFAULT NULL,
  `status_menikah` enum('Menikah','Cerai') DEFAULT NULL,
  `tgl_menikah` date DEFAULT NULL,
  `akta_menikah` varchar(30) DEFAULT NULL,
  `tgl_meninggal` date DEFAULT NULL,
  `akta_meninggal` varchar(30) DEFAULT NULL,
  `tgl_cerai` date DEFAULT NULL,
  `akta_cerai` varchar(30) DEFAULT NULL,
  `kode_mst_peg_nikah` varchar(10) DEFAULT NULL,
  `status_anak` enum('Kandung','Angkat','Tiri') DEFAULT NULL,
  `id_mst_peg_tingkatpendidikan` varchar(4) DEFAULT NULL,
  `alasan_taksekolah` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pegawai_keluarga`
--

INSERT INTO `pegawai_keluarga` (`id_pegawai`, `urut`, `id_mst_peg_keluarga`, `nama`, `jenis_kelamin`, `tgl_lahir`, `code_cl_district`, `bpjs`, `status_hidup`, `status_pns`, `status_menikah`, `tgl_menikah`, `akta_menikah`, `tgl_meninggal`, `akta_meninggal`, `tgl_cerai`, `akta_cerai`, `kode_mst_peg_nikah`, `status_anak`, `id_mst_peg_tingkatpendidikan`, `alasan_taksekolah`) VALUES
('320520040001', 1, 3, 'Asep', 'L', '2000-02-26', '', '', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('320520040001', 2, 4, 'as', 'P', '2006-02-26', '', '', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('320520040001', 9, 2, 'w', '', '2016-03-23', 'ASMA', '', 0, 0, 'Menikah', '2016-03-23', '', '2016-03-23', '', '2016-03-23', '', NULL, NULL, NULL, NULL),
('320520040001', 8, 1, 'sss', '', '2016-03-23', 'ACEH', '', 0, 1, 'Menikah', '2016-03-23', '', '2016-03-23', '', '2016-03-23', '', NULL, NULL, NULL, NULL),
('320520040001', 7, 0, '0', '', '1970-01-01', '0', '0', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_listing`
--

CREATE TABLE IF NOT EXISTS `pegawai_listing` (
  `nip_nit` varchar(20) NOT NULL,
  `tahun` int(11) DEFAULT NULL,
  `bulan` int(11) DEFAULT NULL,
  `id_mst_peg_listing` int(10) DEFAULT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `keterangan` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_pangkat`
--

CREATE TABLE IF NOT EXISTS `pegawai_pangkat` (
  `id_pegawai` varchar(12) NOT NULL,
  `nip_nit` varchar(20) DEFAULT NULL,
  `tmt` date NOT NULL,
  `tat` date DEFAULT NULL,
  `id_mst_peg_golruang` varchar(10) NOT NULL,
  `lokasi` varchar(200) DEFAULT NULL,
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
  `status_pns` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pegawai_pangkat`
--

INSERT INTO `pegawai_pangkat` (`id_pegawai`, `nip_nit`, `tmt`, `tat`, `id_mst_peg_golruang`, `lokasi`, `is_pnsbaru`, `is_pengangkatan`, `status`, `jenis_pengadaan`, `jenis_pangkat`, `masa_krj_bln`, `masa_krj_thn`, `bkn_tgl`, `bkn_nomor`, `sk_pejabat`, `sk_tgl`, `sk_nomor`, `spmt_tgl`, `spmt_nomor`, `sttpl_tgl`, `sttpl_nomor`, `dokter_tgl`, `dokter_nomor`, `status_pns`) VALUES
('', '1223', '0000-00-00', NULL, 'I/D', NULL, 0, 0, 'PNS', NULL, 'pilihan', 4, 4, '2016-05-24', '12', '12', '2016-05-24', '12', NULL, NULL, NULL, NULL, NULL, NULL, '0'),
('320520040001', '34', '2016-05-26', NULL, 'I/D', NULL, 0, 0, 'PNS', NULL, NULL, 5, 10, '2016-05-24', '45', '45', '2016-05-24', '45', NULL, NULL, '2016-05-24', '56', '2016-05-24', '56', '1'),
('320520040001', '12', '2016-05-25', NULL, 'I/D', NULL, 0, 0, 'PNS', NULL, 'pilihan', 4, 4, '2016-05-24', '12', '12', '2016-05-24', '12', NULL, NULL, NULL, NULL, NULL, NULL, '0'),
('320520040001', '231212', '2016-05-24', NULL, 'II/B', NULL, 0, 0, 'CPNS', 'umum', NULL, 5, 4, '2016-05-24', '23', '23123', '2016-05-14', '23123', '2016-05-28', '23123123123123123123', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_pendidikan`
--

CREATE TABLE IF NOT EXISTS `pegawai_pendidikan` (
  `id_pegawai` varchar(12) NOT NULL,
  `id_mst_peg_jurusan` int(10) NOT NULL,
  `sekolah_nama` varchar(100) DEFAULT 'SIPIL',
  `sekolah_lokasi` varchar(50) DEFAULT NULL,
  `ijazah_tgl` varchar(20) DEFAULT NULL,
  `ijazah_no` varchar(20) DEFAULT NULL,
  `gelar_depan` varchar(45) DEFAULT NULL,
  `gelar_belakang` varchar(45) DEFAULT NULL,
  `status_pendidikan_cpns` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pegawai_pendidikan`
--

INSERT INTO `pegawai_pendidikan` (`id_pegawai`, `id_mst_peg_jurusan`, `sekolah_nama`, `sekolah_lokasi`, `ijazah_tgl`, `ijazah_no`, `gelar_depan`, `gelar_belakang`, `status_pendidikan_cpns`) VALUES
('320520040001', 12201, 'UNPAD', 'BADUNG', '2016-02-29', 'as', 'a', 'a', 1),
('320520040001', 0, 'undefined', 'undefined', '1970-01-01', 'undefined', 'undefined', 'undefined', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_penghargaan`
--

CREATE TABLE IF NOT EXISTS `pegawai_penghargaan` (
  `nip_nit` varchar(20) NOT NULL,
  `id_mst_peg_penghargaan` varchar(5) NOT NULL,
  `tar_pemberi` varchar(50) DEFAULT NULL,
  `sk_no` varchar(20) DEFAULT NULL,
  `sk_tgl` date DEFAULT NULL,
  `sk_pejabat` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_struktur`
--

CREATE TABLE IF NOT EXISTS `pegawai_struktur` (
  `nip` varchar(200) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `tar_id_struktur_org` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_peg_struktur_org`
--
ALTER TABLE `mst_peg_struktur_org`
  ADD PRIMARY KEY (`tar_id_struktur_org`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `pegawai_diklat`
--
ALTER TABLE `pegawai_diklat`
  ADD PRIMARY KEY (`id_pegawai`,`mst_peg_id_diklat`),
  ADD KEY `FK_Reference_2` (`id_pegawai`);

--
-- Indexes for table `pegawai_dp3`
--
ALTER TABLE `pegawai_dp3`
  ADD PRIMARY KEY (`tahun`,`nip_nit`);

--
-- Indexes for table `pegawai_gaji`
--
ALTER TABLE `pegawai_gaji`
  ADD PRIMARY KEY (`nip_nit`,`tmt`),
  ADD KEY `FK_Reference_23` (`id_mst_peg_golruang`);

--
-- Indexes for table `pegawai_hukdis`
--
ALTER TABLE `pegawai_hukdis`
  ADD PRIMARY KEY (`tgl_mulai`,`nip_nit`);

--
-- Indexes for table `pegawai_jabatan`
--
ALTER TABLE `pegawai_jabatan`
  ADD PRIMARY KEY (`nip_nit`,`tmt`);

--
-- Indexes for table `pegawai_keluarga`
--
ALTER TABLE `pegawai_keluarga`
  ADD PRIMARY KEY (`id_pegawai`,`urut`);

--
-- Indexes for table `pegawai_listing`
--
ALTER TABLE `pegawai_listing`
  ADD PRIMARY KEY (`nip_nit`),
  ADD KEY `FK_Reference_2` (`nip_nit`);

--
-- Indexes for table `pegawai_pangkat`
--
ALTER TABLE `pegawai_pangkat`
  ADD PRIMARY KEY (`tmt`,`id_pegawai`);

--
-- Indexes for table `pegawai_pendidikan`
--
ALTER TABLE `pegawai_pendidikan`
  ADD PRIMARY KEY (`id_pegawai`,`id_mst_peg_jurusan`);

--
-- Indexes for table `pegawai_penghargaan`
--
ALTER TABLE `pegawai_penghargaan`
  ADD PRIMARY KEY (`nip_nit`,`id_mst_peg_penghargaan`);

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
