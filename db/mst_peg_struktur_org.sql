CREATE TABLE `mst_peg_struktur_org` (
  `tar_id_struktur_org` int(11) NOT NULL AUTO_INCREMENT,
  `tar_id_struktur_org_parent` int(11) DEFAULT '0',
  `tar_nama_posisi` varchar(100) NOT NULL,
  `tar_aktif` int(2) DEFAULT '1',
  `code_cl_phc` varchar(20) NOT NULL,
  PRIMARY KEY (`tar_id_struktur_org`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
