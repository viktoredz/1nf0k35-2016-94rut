DROP TABLE `pegawai_gaji`;

CREATE TABLE `pegawai_gaji` (
  `id_pegawai` varchar(12) NOT NULL,
  `tmt` date NOT NULL,
  `surat_nomor` varchar(50) NOT NULL,
  `id_mst_peg_golruang` varchar(10) NOT NULL,
  `gaji_lama` double(20,2) DEFAULT '0.00',
  `gaji_lama_pp` varchar(30) DEFAULT '0',
  `gaji_baru` double(20,2) DEFAULT '0.00',
  `gaji_baru_pp` varchar(30) DEFAULT '0',
  `sk_tgl` date DEFAULT NULL,
  `sk_nomor` varchar(50) DEFAULT NULL,
  `sk_pejabat` varchar(100) DEFAULT NULL,
  `masa_krj_bln` int(5) DEFAULT NULL,
  `masa_krj_thn` int(5) DEFAULT NULL,
  `code_cl_phc` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`,`tmt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
