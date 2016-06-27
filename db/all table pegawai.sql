-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 27 Jun 2016 pada 11.05
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
('320520160001', NULL, NULL, '195909151989011001', 'H.', 'Dr.', 'Harry Mulyono. S', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160002', NULL, NULL, '197401052009011008', NULL, 'SKM', 'Aep Supriatna', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160003', NULL, NULL, '196203181988032001', 'Hj', 'dr', 'Lilik. S', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160004', NULL, NULL, '196005091989112002', 'drg', NULL, 'Zulhelmi', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160005', NULL, NULL, '196005251982031012', 'Drs', NULL, 'Entis Sutisna', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160006', NULL, NULL, '196803301989011001', NULL, 'Amd.Kep', 'Asep Hidayat', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160007', NULL, NULL, '197111271991022001', NULL, 'Kep, Neurs', 'Aan Anita N S.', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160008', NULL, NULL, '197002211990122001', NULL, 'Amd.Keb', 'Eem Ratnaningsih', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160009', NULL, NULL, '196710091987022002', NULL, NULL, 'Sri Susi Rostiawati', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160010', NULL, NULL, '197511151997032003', NULL, 'S.Sos, M.Si', 'Wiwin Sopianti', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160011', NULL, NULL, '196411111989031002', NULL, NULL, 'Tatan Suryaman ', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160012', NULL, NULL, '196812121994032003', NULL, 'AMK', 'Enung Jubaedah', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160013', NULL, NULL, '197003221991032004', 'Hj', 'Amd.Kep', 'Risnawati', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160014', NULL, NULL, '197108061993012002', NULL, 'Amd.Keb.', 'Dedeh Maryati', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160015', NULL, NULL, '197004231991102001', NULL, NULL, 'Hernawati Diah', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160016', NULL, NULL, '197203011994032005', NULL, 'SST', 'Elis Lisda', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160017', NULL, NULL, '196610231991032004', NULL, 'Amd.Kep', 'Yani Rohaeni', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160018', NULL, NULL, '198111302005012007', NULL, 'SST', 'Rima Parida', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160019', NULL, NULL, '197911202007012010', NULL, 'Amd.Kep', 'Nulianti M', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160020', NULL, NULL, '197611172007012006', 'Hj', 'Am Keb', 'Elin Linda S', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160021', NULL, NULL, '198810062011011001', NULL, 'Amd.Kep', 'Riki Riznawan', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160022', NULL, NULL, '197704062003122004', 'Hj', 'Amd.Keb', 'Rini Suwarni', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160023', NULL, NULL, '196707021991031004', NULL, NULL, 'Damis', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160024', NULL, NULL, '197712152008012006', NULL, 'Amd.Keb', 'Lia Nurliani', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160025', NULL, NULL, '197904102008012006', NULL, 'Amd Kep', 'Evi Chandra', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160026', NULL, NULL, '197708162008012008', NULL, 'Amd.Keb', 'Lina Marlina', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160027', NULL, NULL, '196207012008022001', NULL, NULL, 'Ika Sartikawati', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160028', NULL, NULL, '197011142009012002', NULL, NULL, 'Tintin Sadiah', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160029', NULL, NULL, '197404072006042004', NULL, 'Amd.Keb', 'Rani Yuliana', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203'),
('320520160030', NULL, NULL, '198311252010012026', NULL, 'S.Si', 'Sheni Dwi Lengkana', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205181203');

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_dp3`
--

CREATE TABLE IF NOT EXISTS `pegawai_dp3` (
  `id_pegawai` varchar(12) NOT NULL DEFAULT '',
  `tahun` int(10) NOT NULL,
  `id_pegawai_penilai` varchar(12) DEFAULT NULL,
  `id_pegawai_penilai_atasan` varchar(12) DEFAULT NULL,
  `skp` double(10,2) DEFAULT NULL,
  `pelayanan` double(10,2) DEFAULT NULL,
  `integritas` double(10,2) DEFAULT NULL,
  `komitmen` double(10,2) DEFAULT NULL,
  `disiplin` double(10,2) DEFAULT NULL,
  `kerjasama` double(10,2) DEFAULT NULL,
  `kepemimpinan` double(10,2) DEFAULT NULL,
  `jumlah` double(10,2) DEFAULT NULL,
  `ratarata` double(10,2) DEFAULT NULL,
  `nilai_prestasi` double(10,2) DEFAULT NULL,
  `keberatan` text,
  `keberatan_tgl` date DEFAULT NULL,
  `tanggapan` text,
  `tanggapan_tgl` date DEFAULT NULL,
  `keputusan` text,
  `keputusan_tgl` date DEFAULT NULL,
  `rekomendasi` text,
  `tgl_diterima` date DEFAULT NULL,
  `tgl_dibuat` date DEFAULT NULL,
  `tgl_diterima_atasan` date DEFAULT NULL
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
-- Dumping data untuk tabel `pegawai_jabatan`
--

INSERT INTO `pegawai_jabatan` (`id_pegawai`, `nip_nit`, `tmt`, `jenis`, `unor`, `id_mst_peg_struktural`, `id_mst_peg_fungsional`, `tgl_pelantikan`, `sk_jb_tgl`, `sk_jb_nomor`, `sk_jb_pejabat`, `sk_status`, `prosedur`, `code_cl_phc`) VALUES
('320520160003', 'nip', '2016-06-27', 'FUNGSIONAL_TERTENTU', 'unit organisasi', 0, 43, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203'),
('320520160001', 'nip', '2016-06-27', 'STRUKTURAL', 'unit organisasi', 23, 0, '2016-06-27', '2016-06-27', 'nomor keputuasan', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203'),
('320520160002', 'nip', '2016-06-27', 'STRUKTURAL', 'unit oranisasi', 1, 0, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203'),
('320520160004', 'nip', '2016-06-27', 'FUNGSIONAL_TERTENTU', 'unit organisasi', 0, 46, '2016-06-27', '2016-06-27', 'nomor sk', 'sk pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203'),
('320520160005', 'nip', '2016-06-27', 'FUNGSIONAL_TERTENTU', 'unit organisasi', 0, 65, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203'),
('320520160006', 'nip', '2016-06-27', 'FUNGSIONAL_UMUM', 'unit organisasi', 0, 41, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203'),
('320520160007', 'nip', '2016-06-27', 'STRUKTURAL', 'unit organisasi', 43, 0, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203'),
('320520160008', 'nip', '2016-06-27', 'FUNGSIONAL_UMUM', 'unit organisasi', 0, 10, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203'),
('320520160009', 'nip', '2016-06-27', 'STRUKTURAL', 'unit organisasi', 22, 0, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203'),
('320520160010', 'nip', '2016-06-27', 'FUNGSIONAL_UMUM', 'organsiasi', 0, 26, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur', 'P3205181203');

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
  `status_pns` varchar(10) DEFAULT NULL,
  `code_cl_phc` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pegawai_pangkat`
--

INSERT INTO `pegawai_pangkat` (`id_pegawai`, `nip_nit`, `tmt`, `tat`, `id_mst_peg_golruang`, `lokasi`, `is_pnsbaru`, `is_pengangkatan`, `status`, `jenis_pengadaan`, `jenis_pangkat`, `masa_krj_bln`, `masa_krj_thn`, `bkn_tgl`, `bkn_nomor`, `sk_pejabat`, `sk_tgl`, `sk_nomor`, `spmt_tgl`, `spmt_nomor`, `sttpl_tgl`, `sttpl_nomor`, `dokter_tgl`, `dokter_nomor`, `status_pns`, `code_cl_phc`) VALUES
('320520160006', 'nip', '2016-06-27', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'reguler', 9, 9, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203'),
('320520160003', 'nip', '2016-06-27', NULL, 'IV/B', NULL, 0, 0, 'PNS', NULL, 'reguler', 6, 8, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203'),
('320520160004', 'nip', '2016-06-27', NULL, 'IV/B', NULL, 0, 0, 'PNS', NULL, 'reguler', 7, 14, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203'),
('320520160005', 'nip', '2016-06-27', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'reguler', 9, 4, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203'),
('320520160002', 'nip', '2016-06-27', NULL, 'II/A', NULL, 0, 0, 'PNS', NULL, 'reguler', 5, 2, '2016-06-09', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203'),
('320520160001', 'nip', '2016-06-27', NULL, 'IV/A', NULL, 0, 0, 'PNS', NULL, 'reguler', 2, 6, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203'),
('320520160007', 'nip', '2016-06-27', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'pilihan', 11, 5, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203'),
('320520160008', 'nip', '2016-06-27', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'reguler', 2, 4, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203'),
('320520160009', 'nip', '2016-06-27', NULL, 'III/C', NULL, 0, 0, 'PNS', NULL, 'reguler', 10, 11, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203'),
('320520160010', 'nip', '2016-06-27', NULL, 'III/C', NULL, 0, 0, 'PNS', NULL, 'reguler', 3, 13, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205181203');

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
('320520160002', 13201, 'Unikom', 'BANDUNG', '2016-06-27', 'nomor ijazah', 'SKM', '', 1),
('320520160001', 11201, 'BPI Bandung', 'BANDUNG', '2016-06-27', 'nomor ijazah', 'dr', '', 1),
('320520160003', 11201, 'STIKES Bandung', 'BANDUNG', '2016-06-27', 'nomor ijazah', 'dr', '', 1),
('320520160004', 11201, 'STIKES Bandung', 'BANDUNG BARAT', '2016-06-27', 'no ijazah', 'dr', '', 1),
('320520160005', 14201, 'Sekolah Keperawatan  Indonesia', 'KOTA JAKARTA SELATAN', '2016-06-27', 'no ijazah', 'dr', '', 1),
('320520160006', 14201, 'Sekolah Keperawatan  Indonesia', 'JAYAWIJAYA', '2016-06-27', 'nomor ijazah', 'Amd.Kep', '', 1),
('320520160007', 14201, 'Sekolah Keperawatan  Indonesia', 'KOTA BANDUNG', '2016-06-27', 'nomor ijazah', 'Amd.Keb', '', 1),
('320520160008', 15401, 'sekolah tinggi bandung', 'BANDUNG', '2016-06-27', 'nomor ijazah', 'Amd.Keb', '', 1),
('320520160009', 14901, 'Sekolah Keperawatan  Indonesia', 'BANDUNG', '2016-06-27', 'nomor ijazah', 'Amd.Keb', '', 1),
('320520160010', 63111, 'STAN', 'KOTA BANDA ACEH', '2016-06-27', 'nomor ijazah', 'S.Sos,', 'M.Si', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_penghargaan`
--

CREATE TABLE IF NOT EXISTS `pegawai_penghargaan` (
  `id_pegawai` varchar(12) NOT NULL,
  `id_mst_peg_penghargaan` varchar(5) NOT NULL,
  `tingkat` varchar(45) DEFAULT NULL,
  `instansi` varchar(50) DEFAULT NULL,
  `sk_no` varchar(20) DEFAULT NULL,
  `sk_tgl` date DEFAULT NULL,
  `sk_pejabat` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai_struktur`
--

CREATE TABLE IF NOT EXISTS `pegawai_struktur` (
  `tar_id_struktur_org` int(11) NOT NULL,
  `id_pegawai` varchar(12) NOT NULL DEFAULT '',
  `code_cl_phc` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id_pegawai`,`tahun`);

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
  ADD PRIMARY KEY (`id_pegawai`,`tmt`);

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
  ADD PRIMARY KEY (`id_pegawai`,`id_mst_peg_penghargaan`);

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

--
-- Indexes for table `pegawai_struktur`
--
ALTER TABLE `pegawai_struktur`
  ADD PRIMARY KEY (`tar_id_struktur_org`,`id_pegawai`,`code_cl_phc`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
