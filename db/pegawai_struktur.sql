CREATE TABLE `pegawai_struktur` (
  `tar_id_struktur_org` int(11) NOT NULL,
  `id_pegawai` varchar(12) NOT NULL DEFAULT '',
  PRIMARY KEY (`tar_id_struktur_org`,`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
