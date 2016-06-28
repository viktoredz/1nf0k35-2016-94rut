-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 28 Jun 2016 pada 08.27
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
-- Struktur dari tabel `app_files`
--

CREATE TABLE IF NOT EXISTS `app_files` (
  `id` int(10) NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'ina',
  `filename` varchar(100) NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `id_theme` int(10) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=165 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `app_files`
--

INSERT INTO `app_files` (`id`, `lang`, `filename`, `module`, `id_theme`) VALUES
(1, 'ina', 'Home', 'morganisasi', 2),
(3, 'ina', 'Permohonan', 'permohonan', 2),
(2, 'en', 'Users', 'admin_user', 2),
(4, 'en', 'Pemeriksaan', 'pemeriksaan', 2),
(3, 'en', 'Permohonan', 'permohonan', 2),
(4, 'ina', 'Pemeriksaan', 'pemeriksaan', 2),
(5, 'en', 'Sertifikat', 'sertifikat', 2),
(5, 'ina', 'Sertifikat', 'sertifikat', 2),
(6, 'ina', 'Master Data', '#', 2),
(6, 'en', 'Master Data', '#', 2),
(2, 'ina', 'Users', 'admin_user', 2),
(1, 'en', 'Home', 'index.php', 2),
(31, 'ina', 'Admin', 'admin', 3),
(31, 'en', 'Admin', 'admin', 3),
(36, 'ina', 'Menu', 'admin_menu', 2),
(36, 'en', 'Menu', 'admin_menu', 2),
(37, 'ina', 'File', 'admin_file', 2),
(37, 'en', 'Files', 'admin_file', 2),
(38, 'ina', 'Hak Akses', 'admin_role', 2),
(38, 'en', 'Role', 'admin_role', 2),
(39, 'ina', 'Dashboard', '#', 2),
(39, 'en', 'Dashboard', '#', 2),
(40, 'ina', 'Profil', 'morganisasi/profile', 2),
(40, 'en', 'Profile', 'morganisasi/profile', 2),
(41, 'ina', 'Laporan', '#', 2),
(41, 'en', 'Report', '#', 2),
(42, 'ina', 'Daftar Produsen Benih', 'lap_penangkar', 2),
(42, 'en', 'List of Seed Producers', 'lap_penangkar', 2),
(43, 'ina', 'Rekapitulasi Sertifikasi', 'lap_rekap', 2),
(43, 'en', 'Recapitulation Certification', 'lap_rekap', 2),
(44, 'ina', 'Daftar Komoditi', 'lap_komoditi', 2),
(44, 'en', 'Commodity List', 'lap_komoditi', 2),
(45, 'ina', 'Charts', '#', 2),
(45, 'en', 'Charts', '#', 2),
(46, 'ina', 'Daerah Produsen Benih', 'chart_penangkar', 2),
(46, 'en', 'Regional Seed Producers', 'chart_penangkar', 2),
(47, 'ina', 'Rekapitulasi Sertifikat', 'chart_sert', 2),
(47, 'en', 'Recapitulation Certificate', 'chart_sert', 2),
(48, 'ina', 'Rekapitulasi Komoditi', 'chart_komd', 2),
(48, 'en', 'Commodity recapitulation', 'chart_komd', 2),
(49, 'ina', 'Admin Panel', '#', 2),
(49, 'en', 'Admin Panel', '#', 2),
(50, 'ina', 'Konfigurasi', 'admin_config', 2),
(50, 'en', 'Configuration', 'admin_config', 2),
(51, 'ina', 'Data Master', '#', 2),
(51, 'en', 'Master Data', '#', 2),
(52, 'ina', 'Puskesmas', 'mst/puskesmas', 2),
(52, 'en', 'Puskesmas', 'mst/puskesmas', 2),
(53, 'ina', 'Kepegawaian', '#', 2),
(53, 'en', 'officialdom', '#', 2),
(54, 'ina', 'Daftar Riwayat Hidup', 'kepegawaian/drh', 2),
(54, 'en', 'Daftar Riwayat Hidup', 'kepegawaian/drh', 2),
(55, 'ina', 'Keuangan', '#', 2),
(55, 'en', 'Finansial', '#', 2),
(56, 'ina', '#Target Penerimaan', 'keuangan/target_penerimaan', 2),
(56, 'en', '#Target Penerimaan', 'keuangan/target_penerimaan', 2),
(57, 'ina', 'Aset Tetap', '#', 2),
(57, 'en', 'Aset Tetap', '#', 2),
(58, 'ina', 'Pengadaan Barang', 'inventory/pengadaanbarang', 2),
(58, 'en', 'Pengadaan Barang', 'inventory/pengadaanbarang', 2),
(59, 'ina', 'SMS Gateway', '#', 2),
(59, 'en', 'SMS Gateway', '#', 2),
(60, 'ina', 'SMS Dashboard', 'sms/sms', 2),
(60, 'en', 'SMS Dashboard', 'sms/sms', 2),
(61, 'ina', 'SMS Diterima', 'sms/inbox', 2),
(61, 'en', 'SMS Diterima', 'sms/inbox', 2),
(62, 'ina', 'Buku Telepon', 'sms/pbk', 2),
(62, 'en', 'Phonebook', 'sms/pbk', 2),
(63, 'ina', 'SMS Grup', 'sms/group', 2),
(63, 'en', 'SMS Grup', 'sms/group', 2),
(64, 'ina', 'SMS Info', 'sms/autoreply', 2),
(64, 'en', 'SMS Info', 'sms/autoreply', 2),
(120, 'ina', 'Kepegawaian', 'kepegawaian', 2),
(66, 'ina', 'Daftar Urut Pegawai (D.U.P)', 'kepegawaian/lap_dup', 2),
(66, 'en', 'Daftar Urut Pegawai (D.U.P)', 'kepegawaian/lap_dup', 2),
(67, 'ina', 'Agama', 'mst/agama', 2),
(67, 'en', 'Religion', 'mst/agama', 2),
(68, 'ina', 'Desa / Kelurahan', 'mst/desa', 2),
(68, 'en', 'Village / Sub', 'mst/desa', 2),
(69, 'ina', 'Kota / Kabupaten', 'mst/kabupatenkota', 2),
(69, 'en', 'City / County', 'mst/kabupatenkota', 2),
(70, 'ina', 'Kecamatan', 'mst/kecamatan', 2),
(70, 'en', 'Districts', 'mst/kecamatan', 2),
(71, 'ina', 'Provinsi', 'mst/provinsi', 2),
(71, 'en', 'Province', 'mst/provinsi', 2),
(72, 'ina', 'Inv Barang', 'mst/invbarang', 2),
(72, 'en', 'Inventory', 'mst/invbarang', 2),
(74, 'ina', 'Kepegawaian', '#', 2),
(74, 'en', 'Employee Affair', '#', 2),
(75, 'ina', 'SMS Setting', 'sms/setting', 2),
(75, 'en', 'SMS Setting', 'sms/setting', 2),
(76, 'ina', 'Inventaris Ruangan', 'inventory/inv_ruangan', 2),
(76, 'en', 'Inventaris Ruangan', 'inventory/inv_ruangan', 2),
(77, 'ina', 'Permohonan Barang', 'inventory/permohonanbarang', 2),
(77, 'en', 'Permohonan Barang', 'inventory/permohonanbarang', 2),
(78, 'ina', 'inventory', 'inventory', 2),
(78, 'en', 'inventory', 'inventory', 2),
(79, 'ina', 'mst', 'mst', 2),
(79, 'en', 'mst', 'mst', 2),
(80, 'ina', 'Keu Tarif STS', 'mst/keuangan_sts', 2),
(80, 'en', 'Keu Tarif STS', 'mst/keuangan_sts', 2),
(81, 'ina', 'keuangan', 'keuangan', 2),
(81, 'en', 'keuangan', 'keuangan', 2),
(82, 'ina', 'sms', 'sms', 2),
(82, 'en', 'sms', 'sms', 2),
(83, 'ina', 'SMS Terkirim', 'sms/sentitems', 2),
(83, 'en', 'SMS Terkirim', 'sms/sentitems', 2),
(84, 'ina', 'Peg Status Nikah', 'mst/pegnikah', 2),
(84, 'en', 'Kep Status Nikah', 'mst/pegnikah', 2),
(85, 'ina', 'Inv Pilihan', 'mst/invpilihan', 2),
(85, 'en', 'Inv Pilihan', 'mst/invpilihan', 2),
(86, 'ina', 'Keu Kode Rekening', 'mst/keuangan_rekening', 2),
(86, 'en', 'Keu Kode Rekening', 'mst/keuangan_rekening', 2),
(87, 'ina', 'Peg Rumpun Pendidikan', 'mst/pegpendidikanrumpun', 2),
(87, 'en', 'Peg Rumpun Pendidikan', 'mst/pegpendidikanrumpun', 2),
(88, 'ina', 'Peg Tingkat Pendidikan', 'mst/pegpendidikantingkat', 2),
(88, 'en', 'Peg Tingkat Pendidikan', 'mst/pegpendidikantingkat', 2),
(89, 'ina', 'Peg Jurusan Pendidikan', 'mst/pegpendidikanjurusan', 2),
(89, 'en', 'Peg Jurusan Pendidikan', 'mst/pegpendidikanjurusan', 2),
(90, 'ina', 'Peg Kursus/Diklat', 'mst/kursusdiklat', 2),
(90, 'en', 'Peg Kursus/Diklat', 'mst/kursusdiklat', 2),
(91, 'ina', 'Peg Penghargaan', 'mst/pegpenghargaan', 2),
(91, 'en', 'Peg Penghargaan', 'mst/pegpenghargaan', 2),
(92, 'ina', 'Peg Golongan/Ruang', 'mst/peggolongan', 2),
(92, 'en', 'Peg Golongan/Ruang', 'mst/peggolongan', 2),
(93, 'ina', 'Peg Jabatan Fungsional', 'mst/pegfungsional', 2),
(93, 'en', 'Peg Jabatan Fungsional', 'mst/pegfungsional', 2),
(94, 'ina', 'Peg Jabatan Struktural', 'mst/pegstruktural', 2),
(94, 'en', 'Peg Jabatan Struktural', 'mst/pegstruktural', 2),
(95, 'ina', 'Peg Listing', 'mst/peglisting', 2),
(95, 'en', 'Peg Listing', 'mst/peglisting', 2),
(96, 'ina', 'PNS : Listing', 'kepegawaian/listing_pns', 2),
(96, 'en', 'PNS : Listing', 'kepegawaian/listing_pns', 2),
(97, 'ina', 'Absensi', 'kepegawaian/absensi', 2),
(97, 'en', 'Absensi', 'kepegawaian/absensi', 2),
(98, 'ina', 'Daftar Urut Kepangkatan (D.U.K)', 'kepegawaian/lap_duk', 2),
(98, 'en', 'Daftar Urut Kepangkatan (D.U.K)', 'kepegawaian/lap_duk', 2),
(99, 'ina', 'Rekap Tenaga Medis', 'kepegawaian/lap_tenagamedis', 2),
(99, 'en', 'Rekap Tenaga Medis', 'kepegawaian/lap_tenagamedis', 2),
(100, 'ina', 'Statistik Absensi', 'kepegawaian/lap_absensi', 2),
(100, 'en', 'Statistik Absensi', 'kepegawaian/lap_absensi', 2),
(101, 'ina', 'Kenaikan Pangkat', 'kepegawaian/lap_pangkat', 2),
(101, 'en', 'Kenaikan Pangkat', 'kepegawaian/lap_pangkat', 2),
(102, 'ina', 'Kenaikan Jabatan', 'kepegawaian/lap_jabatan', 2),
(102, 'en', 'Kenaikan Jabatan', 'kepegawaian/lap_jabatan', 2),
(103, 'ina', 'Non PNS : Listing TKD', 'kepegawaian/listing_nonpns', 2),
(103, 'en', 'Non PNS : Listing TKD', 'kepegawaian/listing_nonpns', 2),
(104, 'ina', 'Penilaian Angka Kredit (P.A.K)', 'kepegawaian/pak', 2),
(104, 'en', 'Penilaian Angka Kredit (P.A.K)', 'kepegawaian/pak', 2),
(105, 'ina', 'Penilaian Sasaran Kerja Pegawai', 'kepegawaian/skp', 2),
(105, 'en', 'Penilaian Sasaran Kerja Pegawai', 'kepegawaian/skp', 2),
(106, 'ina', 'Inventaris Barang', 'inventory/inv_barang', 2),
(106, 'en', 'Inventaris Barang', 'inventory/inv_barang', 2),
(107, 'ina', 'K I R', 'inventory/lap_kir', 2),
(107, 'en', 'K I R', 'inventory/lap_kir', 2),
(108, 'ina', 'K I B - A', 'inventory/lap_kiba', 2),
(108, 'en', 'K I B - A', 'inventory/lap_kiba', 2),
(109, 'ina', 'K I B - B', 'inventory/lap_kibb', 2),
(109, 'en', 'K I B - B', 'inventory/lap_kibb', 2),
(110, 'ina', 'K I B - C', 'inventory/lap_kibc', 2),
(110, 'en', 'K I B - C', 'inventory/lap_kibc', 2),
(111, 'ina', 'K I B - D', 'inventory/lap_kibd', 2),
(111, 'en', 'K I B - D', 'inventory/lap_kibd', 2),
(112, 'ina', 'K I B - E', 'inventory/lap_kibe', 2),
(112, 'en', 'K I B - E', 'inventory/lap_kibe', 2),
(113, 'ina', 'K I B - F', 'inventory/lap_kibf', 2),
(113, 'en', 'K I B - F', 'inventory/lap_kibf', 2),
(114, 'ina', 'Subsidi - BKU Subsidi', 'keuangan/subsidi_bku', 2),
(114, 'en', 'Subsidi - BKU Subsidi', 'keuangan/subsidi_bku', 2),
(115, 'ina', 'Surat Tanda Setoran', 'keuangan/sts/general', 2),
(115, 'en', 'Surat Tanda Setoran', 'keuangan/sts/general', 2),
(116, 'ina', 'Opini Publik', 'sms/opini', 2),
(116, 'en', 'Opini Publik', 'sms/opini', 2),
(118, 'ina', 'SMS Tipe', 'sms/tipe', 2),
(117, 'ina', 'SMS Masal', 'sms/bc', 2),
(117, 'en', 'SMS Masal', 'sms/bc', 2),
(118, 'en', 'SMS Tipe', 'sms/tipe', 2),
(119, 'ina', 'SMS Menu', 'sms/menu_sms', 2),
(119, 'en', 'SMS Menu', 'sms/menu_sms', 2),
(120, 'en', 'Kepegawaian', 'kepegawaian', 2),
(121, 'ina', '#BKU Penerimaan Pembantu', 'keuangan/bku_penerimaan', 2),
(121, 'en', '#BKU Penerimaan Pembantu', 'keuangan/bku_penerimaan', 2),
(122, 'ina', 'Distribusi Barang', 'inventory/distribusibarang', 2),
(122, 'en', 'Distribusi Barang', 'inventory/distribusibarang', 2),
(123, 'ina', 'L P L P O', 'inventory/lap_lplpo', 2),
(123, 'en', 'L P L P O', 'inventory/lap_lplpo', 2),
(124, 'ina', 'R K B U', 'inventory/lap_rkbu', 2),
(124, 'en', 'R K B U', 'inventory/lap_rkbu', 2),
(125, 'ina', 'Lap. Pengadaan Barang', 'inventory/lap_pengadaan', 2),
(125, 'en', 'Lap. Pengadaan Barang', 'inventory/lap_pengadaan', 2),
(126, 'ina', 'Bahan Habis Pakai', '#', 2),
(126, 'en', 'Bahan Habis Pakai', '#', 2),
(127, 'ina', 'Penerimaan', 'inventory/bhp_pengadaan', 2),
(127, 'en', 'Penerimaan', 'inventory/bhp_pengadaan', 2),
(129, 'ina', 'Bahan Habis Pakai', 'mst/invbaranghabispakai', 2),
(129, 'en', 'Bahan Habis Pakai', 'mst/invbaranghabispakai', 2),
(130, 'ina', 'Riwayat Pengadaan BHP', 'inventory/lap_bhp_pengadaan', 2),
(130, 'en', 'Riwayat Pengadaan BHP', 'inventory/lap_bhp_pengadaan', 2),
(131, 'ina', 'Stock BHP', 'inventory/lap_bhp_pengeluaran', 2),
(131, 'en', 'Stock BHP', 'inventory/lap_bhp_pengeluaran', 2),
(132, 'ina', 'Kartu Ketersediaan BHP', 'inventory/lap_bhp_ketersediaan', 2),
(132, 'en', 'Kartu Ketersediaan BHP', 'inventory/lap_bhp_ketersediaan', 2),
(133, 'ina', 'Buku Inventaris', 'inventory/lap_bukuinventaris', 2),
(133, 'en', 'Buku Inventaris', 'inventory/lap_bukuinventaris', 2),
(134, 'ina', 'Daftar Mutasi Barang', 'inventory/lap_mutasibarang', 2),
(134, 'en', 'Daftar Mutasi Barang', 'inventory/lap_mutasibarang', 2),
(135, 'ina', 'Stock Opname', 'inventory/bhp_opname', 2),
(135, 'en', 'Stock Opname', 'inventory/bhp_opname', 2),
(136, 'ina', 'Ketuk Pintu', '#', 2),
(136, 'en', 'Ketuk Pintu', '#', 2),
(137, 'ina', 'Data Keluarga', 'eform/data_kepala_keluarga', 2),
(137, 'en', 'Data Keluarga', 'eform/data_kepala_keluarga', 2),
(138, 'ina', 'eForm', 'eform', 2),
(138, 'en', 'eForm', 'eform', 2),
(139, 'ina', 'Penilaian DP3', 'kepegawaian/penilaiandppp', 2),
(139, 'en', 'Penilaian DP3', 'kepegawaian/penilaiandppp', 2),
(140, 'ina', 'D U K', 'kepegawaian/duk', 2),
(140, 'en', 'D U K', 'kepegawaian/duk', 2),
(141, 'ina', 'Laporan Hasil KPLDH', 'eform/laporan_kpldh', 2),
(141, 'en', 'Laporan Hasil KPLDH', 'eform/laporan_kpldh', 2),
(142, 'ina', 'Retur Barang', 'inventory/bhp_retur', 2),
(142, 'en', 'Retur Barang', 'inventory/bhp_retur', 2),
(161, 'ina', 'Struktur Organisasi', 'kepegawaian/struktur', 2),
(161, 'en', 'Struktur Organisasi', 'kepegawaian/struktur', 2),
(144, 'ina', 'Pemusnahan Sediaan', 'inventory/bhp_pemusnahan', 2),
(144, 'en', 'Pemusnahan Sediaan', 'inventory/bhp_pemusnahan', 2),
(145, 'ina', 'Distribusi', 'inventory/bhp_distribusi', 2),
(145, 'en', 'Distribusi', 'inventory/bhp_distribusi', 2),
(146, 'ina', 'Keu Akun', 'mst/keuangan_akun', 2),
(146, 'en', 'Keu Akun', 'mst/keuangan_akun', 2),
(147, 'ina', 'Dashboard', 'keuangan/dashboard', 2),
(147, 'en', 'Dashboard', 'keuangan/dashboard', 2),
(148, 'ina', 'Penyusutan Inventaris', 'keuangan/penyusutan', 2),
(148, 'en', 'Penyusutan Inventaris', 'keuangan/penyusutan', 2),
(149, 'ina', 'Jurnal', 'keuangan/jurnal', 2),
(149, 'en', 'Jurnal', 'keuangan/jurnal', 2),
(150, 'ina', 'Buku Besar', 'keuangan/bukubesar', 2),
(150, 'en', 'Buku Besar', 'keuangan/bukubesar', 2),
(151, 'ina', 'Neraca Lajur', 'keuangan/neracalajur', 2),
(151, 'en', 'Neraca Lajur', 'keuangan/neracalajur', 2),
(154, 'ina', 'Keu Instansi', 'mst/keuangan_instansi', 2),
(153, 'ina', 'Laporan Keuangan', 'keuangan/laporan', 2),
(153, 'en', 'Laporan Keuangan', 'keuangan/laporan', 2),
(154, 'en', 'Keu Instansi', 'mst/keuangan_instansi', 2),
(155, 'ina', 'Keu Laporan', 'mst/keuangan_laporan', 2),
(155, 'en', 'Keu Laporan', 'mst/keuangan_laporan', 2),
(156, 'ina', 'Keu Transaksi', 'mst/keuangan_transaksi', 2),
(156, 'en', 'Keu Transaksi', 'mst/keuangan_transaksi', 2),
(157, 'ina', 'Keu Inventaris', 'mst/keuangan_inventaris', 2),
(157, 'en', 'Keu Inventaris', 'mst/keuangan_inventaris', 2),
(158, 'ina', 'Keu Buku Besar', 'mst/keuangan_bukubesar', 2),
(158, 'en', 'Keu Buku Besar', 'mst/keuangan_bukubesar', 2),
(159, 'ina', 'Kondisi Barang', 'inventory/bhp_kondisi', 2),
(159, 'en', 'Kondisi Barang', 'inventory/bhp_kondisi', 2),
(160, 'ina', 'Permintaan', 'inventory/bhp_permintaan', 2),
(160, 'en', 'Permintaan', 'inventory/bhp_permintaan', 2),
(162, 'ina', 'Peg Organisasi', 'mst/pegorganisasi', 2),
(162, 'en', 'Peg Organisasi', 'mst/pegorganisasi', 2),
(163, 'ina', 'Stuktur Kepegawaian', 'kepegawaian/stuktur_kepegawaian', 2),
(163, 'en', 'Stuktur Kepegawaian', 'kepegawaian/stuktur_kepegawaian', 2),
(164, 'ina', 'Buku Penjagaan', 'kepegawaian/bukupenjagaan', 2),
(164, 'en', 'Buku Penjagaan', 'kepegawaian/bukupenjagaan', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `app_menus`
--

CREATE TABLE IF NOT EXISTS `app_menus` (
  `position` int(10) NOT NULL,
  `id` int(10) NOT NULL,
  `sub_id` int(10) NOT NULL DEFAULT '0',
  `sort` int(10) NOT NULL DEFAULT '0',
  `file_id` int(10) NOT NULL,
  `id_theme` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `app_menus`
--

INSERT INTO `app_menus` (`position`, `id`, `sub_id`, `sort`, `file_id`, `id_theme`) VALUES
(1, 76, 26, 29, 63, 2),
(1, 13, 10, 6, 62, 2),
(1, 12, 10, 2, 61, 2),
(1, 79, 1, 1, 60, 2),
(1, 10, 0, 7, 59, 2),
(1, 8, 0, 1, 57, 2),
(1, 7, 6, 9, 56, 2),
(1, 2, 1, 0, 1, 2),
(1, 9, 8, 1, 58, 2),
(1, 15, 10, 4, 64, 2),
(1, 6, 0, 3, 55, 2),
(1, 1, 0, 0, 39, 2),
(1, 3, 1, 2, 40, 2),
(1, 4, 0, 4, 74, 2),
(1, 17, 0, 5, 41, 2),
(1, 5, 4, 0, 54, 2),
(1, 77, 6, 10, 121, 2),
(1, 19, 0, 9, 49, 2),
(1, 20, 19, 0, 50, 2),
(1, 21, 19, 4, 2, 2),
(1, 22, 19, 2, 37, 2),
(1, 23, 19, 3, 38, 2),
(1, 24, 19, 5, 36, 2),
(1, 25, 19, 1, 75, 2),
(1, 26, 0, 8, 6, 2),
(1, 27, 26, 12, 52, 2),
(1, 28, 26, 11, 67, 2),
(1, 29, 26, 14, 68, 2),
(1, 30, 26, 15, 69, 2),
(1, 31, 26, 13, 70, 2),
(1, 32, 26, 16, 71, 2),
(1, 33, 26, 9, 72, 2),
(1, 72, 10, 3, 117, 2),
(1, 37, 8, 3, 76, 2),
(1, 36, 8, 0, 77, 2),
(1, 110, 26, 1, 80, 2),
(1, 39, 10, 5, 83, 2),
(1, 40, 26, 18, 84, 2),
(1, 41, 26, 10, 85, 2),
(1, 42, 26, 7, 86, 2),
(1, 43, 26, 26, 89, 2),
(1, 44, 26, 25, 87, 2),
(1, 45, 26, 27, 88, 2),
(1, 46, 26, 21, 90, 2),
(1, 47, 26, 19, 91, 2),
(1, 48, 26, 22, 92, 2),
(1, 49, 26, 23, 93, 2),
(1, 50, 26, 24, 94, 2),
(1, 51, 26, 20, 95, 2),
(1, 82, 17, 10, 125, 2),
(1, 81, 17, 7, 124, 2),
(1, 80, 17, 11, 123, 2),
(1, 78, 8, 2, 122, 2),
(1, 62, 8, 4, 106, 2),
(1, 63, 17, 0, 107, 2),
(1, 64, 17, 1, 108, 2),
(1, 65, 17, 2, 109, 2),
(1, 66, 17, 3, 110, 2),
(1, 67, 17, 4, 111, 2),
(1, 68, 17, 5, 112, 2),
(1, 69, 17, 6, 113, 2),
(1, 71, 6, 1, 115, 2),
(1, 73, 10, 1, 116, 2),
(1, 74, 26, 28, 118, 2),
(1, 75, 26, 30, 119, 2),
(1, 83, 0, 2, 126, 2),
(1, 84, 83, 1, 127, 2),
(1, 86, 26, 8, 129, 2),
(1, 87, 17, 13, 130, 2),
(1, 88, 17, 12, 131, 2),
(1, 89, 17, 14, 132, 2),
(1, 90, 17, 8, 133, 2),
(1, 91, 17, 9, 134, 2),
(1, 92, 83, 3, 135, 2),
(1, 93, 0, 6, 136, 2),
(1, 94, 93, 1, 137, 2),
(1, 95, 4, 3, 140, 2),
(1, 96, 4, 4, 139, 2),
(1, 97, 93, 2, 141, 2),
(1, 98, 83, 2, 145, 2),
(1, 99, 83, 5, 142, 2),
(1, 118, 4, 1, 161, 2),
(1, 101, 83, 7, 144, 2),
(1, 102, 26, 0, 146, 2),
(1, 103, 6, 0, 147, 2),
(1, 104, 6, 2, 148, 2),
(1, 105, 6, 3, 149, 2),
(1, 106, 6, 4, 150, 2),
(1, 107, 6, 5, 151, 2),
(1, 108, 6, 6, 152, 2),
(1, 109, 6, 7, 153, 2),
(1, 111, 26, 6, 154, 2),
(1, 112, 26, 4, 155, 2),
(1, 113, 26, 2, 156, 2),
(1, 114, 26, 3, 157, 2),
(1, 115, 26, 5, 158, 2),
(1, 116, 83, 4, 159, 2),
(1, 117, 83, 0, 160, 2),
(1, 119, 26, 17, 162, 2),
(1, 120, 4, 2, 163, 2),
(1, 121, 4, 5, 164, 2);

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
(50, 1, 'Perawat Gigi', 1, 'P3205181203'),
(1, 0, 'Kepala Puskesmas', 1, 'P3205240101');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_peg_struktur_skp`
--

CREATE TABLE IF NOT EXISTS `mst_peg_struktur_skp` (
  `id_mst_peg_struktur_org` int(11) NOT NULL DEFAULT '0',
  `id_mst_peg_struktur_skp` int(11) NOT NULL,
  `tugas` varchar(100) NOT NULL,
  `ak` int(2) DEFAULT '0',
  `kuant` int(2) DEFAULT '1',
  `output` varchar(50) DEFAULT NULL,
  `target` int(5) DEFAULT '100',
  `waktu` int(5) DEFAULT '12',
  `biaya` int(11) DEFAULT '0',
  `code_cl_phc` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mst_peg_struktur_skp`
--

INSERT INTO `mst_peg_struktur_skp` (`id_mst_peg_struktur_org`, `id_mst_peg_struktur_skp`, `tugas`, `ak`, `kuant`, `output`, `target`, `waktu`, `biaya`, `code_cl_phc`) VALUES
(1, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(1, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(1, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(1, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(1, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(1, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(2, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(2, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(2, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(2, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(2, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(2, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(3, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(3, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(3, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(3, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(3, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(3, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(4, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(4, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(4, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(4, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(4, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(4, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(5, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(5, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(5, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(5, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(5, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(5, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(6, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(6, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(6, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(6, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(6, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(6, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(7, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(7, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(7, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(7, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(7, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(7, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(8, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(8, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(8, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(8, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(8, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(8, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(9, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(9, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(9, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(9, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(9, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(9, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(10, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(10, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(10, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(10, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(10, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(10, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(11, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(11, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(11, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(11, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(11, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(11, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(12, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(12, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(12, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(12, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(12, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(12, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(13, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(13, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(13, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(13, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(13, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(13, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(14, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(14, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(14, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(14, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(14, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(14, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(15, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(15, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(15, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(15, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(15, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(15, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(16, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(16, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(16, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(16, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(16, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(16, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(17, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(17, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(17, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(17, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(17, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(17, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(18, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(18, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(18, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(18, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(18, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(18, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(19, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(19, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(19, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(19, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(19, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(19, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(20, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(20, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(20, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(20, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(20, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(20, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(21, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(21, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(21, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(21, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(21, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(21, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(22, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(22, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(22, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(22, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(22, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(22, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(23, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(23, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(23, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(23, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(23, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(23, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(24, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(24, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(24, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(24, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(24, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(24, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(25, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(25, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(25, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(25, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(25, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(25, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(26, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(26, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(26, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(26, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(26, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(26, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(27, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(27, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(27, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(27, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(27, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(27, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(28, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(28, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(28, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(28, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(28, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(28, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(29, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(29, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(29, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(29, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(29, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(29, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(30, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(30, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(30, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(30, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(30, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(30, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(31, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(31, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(31, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(31, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(31, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(31, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(32, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(32, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(32, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(32, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(32, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(32, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(33, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(33, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(33, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(33, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(33, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(33, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(34, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(34, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(34, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(34, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(34, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(34, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(35, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(35, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(35, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(35, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(35, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(35, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(36, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(36, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(36, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(36, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(36, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(36, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(37, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(37, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(37, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(37, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(37, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(37, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(38, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(38, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(38, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(38, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(38, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(38, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(39, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(39, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(39, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(39, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(39, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(39, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(40, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(40, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(40, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(40, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(40, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(40, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(41, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(41, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(41, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(41, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(41, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(41, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(42, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(42, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(42, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(42, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(42, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(42, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(43, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(43, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(43, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(43, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(43, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(43, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(44, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(44, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(44, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(44, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(44, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(44, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(45, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(45, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(45, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(45, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(45, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(45, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(46, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(46, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(46, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(46, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(46, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(46, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(47, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(47, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(47, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(47, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(47, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(47, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(48, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(48, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(48, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(48, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(48, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(48, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(49, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(49, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(49, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(49, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(49, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(49, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203'),
(50, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(50, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(50, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(50, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(50, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(50, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203');

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
('320520160001', NULL, NULL, '195909151989011001', 'H.', 'Dr.', 'Harry Mulyono. S', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160002', NULL, NULL, '197401052009011008', NULL, 'SKM', 'Aep Supriatna', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160003', NULL, NULL, '196203181988032001', 'Hj', 'dr', 'Lilik. S', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160004', NULL, NULL, '196005091989112002', 'drg', NULL, 'Zulhelmi', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160005', NULL, NULL, '196005251982031012', 'Drs', NULL, 'Entis Sutisna', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160006', NULL, NULL, '196803301989011001', NULL, 'Amd.Kep', 'Asep Hidayat', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160007', NULL, NULL, '197111271991022001', NULL, 'Kep, Neurs', 'Aan Anita N S.', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160008', NULL, NULL, '197002211990122001', NULL, 'Amd.Keb', 'Eem Ratnaningsih', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160009', NULL, NULL, '196710091987022002', NULL, NULL, 'Sri Susi Rostiawati', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160010', NULL, NULL, '197511151997032003', NULL, 'S.Sos, M.Si', 'Wiwin Sopianti', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160011', NULL, NULL, '196411111989031002', NULL, NULL, 'Tatan Suryaman ', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160012', NULL, NULL, '196812121994032003', NULL, 'AMK', 'Enung Jubaedah', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160013', NULL, NULL, '197003221991032004', 'Hj', 'Amd.Kep', 'Risnawati', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160014', NULL, NULL, '197108061993012002', NULL, 'Amd.Keb.', 'Dedeh Maryati', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160015', NULL, NULL, '197004231991102001', NULL, NULL, 'Hernawati Diah', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160016', NULL, NULL, '197203011994032005', NULL, 'SST', 'Elis Lisda', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160017', NULL, NULL, '196610231991032004', NULL, 'Amd.Kep', 'Yani Rohaeni', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160018', NULL, NULL, '198111302005012007', NULL, 'SST', 'Rima Parida', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160019', NULL, NULL, '197911202007012010', NULL, 'Amd.Kep', 'Nulianti M', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160020', NULL, NULL, '197611172007012006', 'Hj', 'Am Keb', 'Elin Linda S', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160021', NULL, NULL, '198810062011011001', NULL, 'Amd.Kep', 'Riki Riznawan', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160022', NULL, NULL, '197704062003122004', 'Hj', 'Amd.Keb', 'Rini Suwarni', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160023', NULL, NULL, '196707021991031004', NULL, NULL, 'Damis', 'L', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160024', NULL, NULL, '197712152008012006', NULL, 'Amd.Keb', 'Lia Nurliani', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160025', NULL, NULL, '197904102008012006', NULL, 'Amd Kep', 'Evi Chandra', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160026', NULL, NULL, '197708162008012008', NULL, 'Amd.Keb', 'Lina Marlina', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160027', NULL, NULL, '196207012008022001', NULL, NULL, 'Ika Sartikawati', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160028', NULL, NULL, '197011142009012002', NULL, NULL, 'Tintin Sadiah', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160029', NULL, NULL, '197404072006042004', NULL, 'Amd.Keb', 'Rani Yuliana', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101'),
('320520160030', NULL, NULL, '198311252010012026', NULL, 'S.Si', 'Sheni Dwi Lengkana', 'P', '2016-06-27', 'Jakarta', 'is', 'aktif', 'Jakarta', 'npwp', '2016-06-27', 'kartupegawai', 'A', 'bk', 'P3205240101');

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
('320520160003', 'nip', '2016-06-27', 'FUNGSIONAL_TERTENTU', 'unit organisasi', 0, 43, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160001', 'nip', '2016-06-27', 'STRUKTURAL', 'unit organisasi', 23, 0, '2016-06-27', '2016-06-27', 'nomor keputuasan', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160002', 'nip', '2016-06-27', 'STRUKTURAL', 'unit oranisasi', 1, 0, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160004', 'nip', '2016-06-27', 'FUNGSIONAL_TERTENTU', 'unit organisasi', 0, 46, '2016-06-27', '2016-06-27', 'nomor sk', 'sk pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160005', 'nip', '2016-06-27', 'FUNGSIONAL_TERTENTU', 'unit organisasi', 0, 65, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160006', 'nip', '2016-06-27', 'FUNGSIONAL_UMUM', 'unit organisasi', 0, 41, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160007', 'nip', '2016-06-27', 'STRUKTURAL', 'unit organisasi', 43, 0, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160008', 'nip', '2016-06-27', 'FUNGSIONAL_UMUM', 'unit organisasi', 0, 10, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160009', 'nip', '2016-06-27', 'STRUKTURAL', 'unit organisasi', 22, 0, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160010', 'nip', '2016-06-27', 'FUNGSIONAL_UMUM', 'organsiasi', 0, 26, '2016-06-27', '2016-06-27', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur', 'P3205240101'),
('320520160011', 'nip', '2016-06-28', 'STRUKTURAL', 'unit organisasi', 17, 0, '2016-06-28', '2016-06-28', 'nomor sk', 'NAMA Pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160012', 'nip', '2016-06-28', 'FUNGSIONAL_TERTENTU', 'unit organisasi', 0, 59, '2016-06-28', '2016-06-28', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205240101'),
('320520160013', 'nip', '2016-06-28', 'STRUKTURAL', 'unit organsasi', 30, 0, '2016-06-28', '2016-06-28', 'nomor sk', 'nama pejabat', 'pengangkatan', 'prosedur awal', 'P3205181203');

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
('320520160006', 'nip', '2008-09-02', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'reguler', 8, 1, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160003', 'nip', '2004-10-27', NULL, 'IV/B', NULL, 0, 0, 'PNS', NULL, 'reguler', 12, 3, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160004', 'nip', '2003-10-15', NULL, 'IV/B', NULL, 0, 0, 'PNS', NULL, 'reguler', 7, 14, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160005', 'nip', '2009-09-12', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'reguler', 9, 4, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160002', 'nip', '2013-09-27', NULL, 'II/A', NULL, 0, 0, 'PNS', NULL, 'reguler', 5, 2, '2016-06-09', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160001', 'nip', '2001-10-28', NULL, 'IV/A', NULL, 0, 0, 'PNS', NULL, 'reguler', 2, 6, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160007', 'nip', '2008-09-22', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'pilihan', 11, 5, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160008', 'nip', '2009-10-17', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'reguler', 2, 4, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160009', 'nip', '2008-10-23', NULL, 'III/C', NULL, 0, 0, 'PNS', NULL, 'reguler', 10, 11, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160010', 'nip', '2009-09-17', NULL, 'III/C', NULL, 0, 0, 'PNS', NULL, 'reguler', 3, 13, '2016-06-27', 'nomor bkn', 'nama pejabat', '2016-06-27', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160011', 'nip', '2009-10-08', NULL, 'III/B', NULL, 0, 0, 'PNS', NULL, 'reguler', 3, 5, '2016-06-28', 'nomor bkn', 'nama pejabat', '2016-06-28', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160012', 'nip', '2008-10-28', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'reguler', 7, 10, '2016-06-28', 'nomor bkn', 'nama pejabat', '2016-06-28', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101'),
('320520160013', 'nip', '2008-10-11', NULL, 'III/D', NULL, 0, 0, 'PNS', NULL, 'reguler', 7, 4, '2016-06-28', 'nomor bkn', 'nama pejabat', '2016-06-28', 'nomor sk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'P3205240101');

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
('320520160010', 63111, 'STAN', 'KOTA BANDA ACEH', '2016-06-27', 'nomor ijazah', 'S.Sos,', 'M.Si', 1),
('320520160011', 3, 'SMAN 1 Bandung', 'BANDUNG', '2016-06-28', 'nomor ijazah', '', '', 1),
('320520160012', 15401, 'STIKES Bandung', 'KOTA CIMAHI', '2016-06-28', 'nomor ijazah', '', 'AMK', 1),
('320520160013', 14401, 'STIKES Budi Luhur', 'KOTA CIMAHI', '2016-06-28', 'nomor ijazah', '', 'AMK', 1);

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
-- Indexes for table `app_files`
--
ALTER TABLE `app_files`
  ADD PRIMARY KEY (`id`,`lang`);

--
-- Indexes for table `app_menus`
--
ALTER TABLE `app_menus`
  ADD PRIMARY KEY (`position`,`id`),
  ADD KEY `fk_menus_files` (`file_id`);

--
-- Indexes for table `mst_peg_struktur_org`
--
ALTER TABLE `mst_peg_struktur_org`
  ADD PRIMARY KEY (`tar_id_struktur_org`,`code_cl_phc`);

--
-- Indexes for table `mst_peg_struktur_skp`
--
ALTER TABLE `mst_peg_struktur_skp`
  ADD PRIMARY KEY (`id_mst_peg_struktur_org`,`id_mst_peg_struktur_skp`,`code_cl_phc`);

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

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_files`
--
ALTER TABLE `app_files`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=165;
--
-- AUTO_INCREMENT for table `mst_peg_struktur_org`
--
ALTER TABLE `mst_peg_struktur_org`
  MODIFY `tar_id_struktur_org` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `mst_peg_struktur_skp`
--
ALTER TABLE `mst_peg_struktur_skp`
  MODIFY `id_mst_peg_struktur_skp` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
