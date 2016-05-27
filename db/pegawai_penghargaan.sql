CREATE TABLE `pegawai_penghargaan` (
  `id_pegawai` varchar(12) NOT NULL,
  `id_mst_peg_penghargaan` varchar(5) NOT NULL,
  `tingkat` varchar(45) DEFAULT NULL,
  `instansi` varchar(50) DEFAULT NULL,
  `sk_no` varchar(20) DEFAULT NULL,
  `sk_tgl` date DEFAULT NULL,
  `sk_pejabat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`,`id_mst_peg_penghargaan`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
