CREATE TABLE `mst_keu_kategori_transaksi_setting` (
  `id_mst_kategori_transaksi` int(11) NOT NULL,
  `id_mst_setting_transaksi` int(11) NOT NULL,
  PRIMARY KEY (`id_mst_kategori_transaksi`,`id_mst_setting_transaksi`),
  KEY `fk_mst_keu_kategori_transaksi_setting_mst_keu_kategori_tran_idx` (`id_mst_kategori_transaksi`),
  KEY `fk_mst_keu_kategori_transaksi_setting_mst_keu_setting_trans_idx` (`id_mst_setting_transaksi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
