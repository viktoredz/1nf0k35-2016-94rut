DROP TABLE `pegawai_dp3`;
DROP TABLE `pegawai_skp`;
DROP TABLE `pegawai_skp_nilai`;


CREATE TABLE `pegawai_dp3` (
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
  `tgl_diterima_atasan` date DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`,`tahun`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `pegawai_skp` (
  `id_pegawai` varchar(12) NOT NULL DEFAULT '',
  `tahun` int(10) NOT NULL,
  `id_pegawai_penilai` varchar(12) DEFAULT NULL,
  `skp` double(10,2) DEFAULT NULL,
  `tgl_dibuat` date DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`,`tahun`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `pegawai_skp_nilai` (
  `id_pegawai` varchar(12) NOT NULL DEFAULT '',
  `tahun` int(10) NOT NULL,
  `id_mst_peg_struktur_org` int(10) NOT NULL,
  `id_mst_peg_struktur_skp` int(10) NOT NULL,
  `ak` int(10) NOT NULL,
  `kuant` int(10) NOT NULL,
  `target` int(10) NOT NULL,
  `waktu` int(10) NOT NULL,
  `biaya` int(10) NOT NULL,
  PRIMARY KEY (`id_pegawai`,`tahun`,`id_mst_peg_struktur_org`,`id_mst_peg_struktur_skp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
