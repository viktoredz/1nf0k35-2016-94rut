

--
-- Table structure for table `mst_peg_struktur_skp`
--

CREATE TABLE IF NOT EXISTS `mst_peg_struktur_skp` (
  `id_mst_peg_struktur_org` int(11) NOT NULL DEFAULT '0',
  `id_mst_peg_struktur_skp` int(11) NOT NULL AUTO_INCREMENT,
  `tugas` varchar(100) NOT NULL,
  `ak` int(2) DEFAULT '0',
  `kuant` int(2) DEFAULT '1',
  `output` varchar(50) DEFAULT NULL,
  `target` int(5) DEFAULT '100',
  `waktu` int(5) DEFAULT '12',
  `biaya` int(11) DEFAULT '0',
  `code_cl_phc` varchar(20) NOT NULL,
  PRIMARY KEY (`id_mst_peg_struktur_org`,`id_mst_peg_struktur_skp`,`code_cl_phc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `mst_peg_struktur_skp`
--

INSERT INTO `mst_peg_struktur_skp` (`id_mst_peg_struktur_org`, `id_mst_peg_struktur_skp`, `tugas`, `ak`, `kuant`, `output`, `target`, `waktu`, `biaya`, `code_cl_phc`) VALUES
(1, 1, 'Melaksanakan kegiatan pembinaan dan pengawasan Jamkesmas/Jamkesda', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(1, 2, 'Melaksanakan kegiatan  jaminan kesehatan nasional kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(1, 3, 'Melaksanakan kegiatan  jaminan kesehatan nasional non  kapitasi lanjutan (lanjutan)', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(1, 4, 'Melaksanakan kegiatan  pembayaran klaim Jamkesda Banprop', 0, 1, 'dokumen', 100, 12, 0, 'P3205181203'),
(1, 5, 'Melaporkan kegiatan tahunan seksi LKK', 0, 1, 'laporan', 100, 1, 0, 'P3205181203'),
(1, 6, 'Menyiapkan bahan perencanaan kegiatan seksi LKK Tahun 2016', 0, 1, 'konsep', 100, 3, 0, 'P3205181203');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_dp3`
--

CREATE TABLE IF NOT EXISTS `pegawai_dp3` (
  `id_pegawai` varchar(12) NOT NULL DEFAULT '',
  `tahun` int(10) NOT NULL,
  `id_pegawai_penilai` varchar(12) DEFAULT NULL,
  `id_pegawai_penilai_atasan` varchar(12) DEFAULT NULL,
  `skp` double(10,2) DEFAULT NULL,
  `pelayanan` int(10) DEFAULT NULL,
  `integritas` int(10) DEFAULT NULL,
  `komitmen` int(10) DEFAULT NULL,
  `disiplin` int(10) DEFAULT NULL,
  `kerjasama` int(10) DEFAULT NULL,
  `kepemimpinan` int(10) DEFAULT NULL,
  `jumlah` int(10) DEFAULT NULL,
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
  `tgl_diterima_atasan` date DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`,`tahun`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

