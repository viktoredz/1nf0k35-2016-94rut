-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2016 at 12:53 PM
-- Server version: 5.6.26
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

-- --------------------------------------------------------

--
-- Structure for view `bhp_distribusi_opname`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bhp_distribusi_opname` AS select `func`() AS `func()`,`inv_inventaris_habispakai_distribusi`.`id_inv_inventaris_habispakai_distribusi` AS `id_inv_inventaris_habispakai_distribusi`,`inv_inventaris_habispakai_distribusi`.`code_cl_phc` AS `code_cl_phc`,`inv_inventaris_habispakai_distribusi`.`jenis_bhp` AS `jenis_bhp`,`inv_inventaris_habispakai_distribusi`.`bln_periode` AS `bln_periode`,`inv_inventaris_habispakai_distribusi`.`tgl_distribusi` AS `tgl_distribusi`,`inv_inventaris_habispakai_distribusi`.`nomor_dokumen` AS `nomor_dokumen`,`inv_inventaris_habispakai_distribusi`.`penerima_nama` AS `penerima_nama`,`inv_inventaris_habispakai_distribusi`.`penerima_nip` AS `penerima_nip`,`inv_inventaris_habispakai_distribusi`.`keterangan` AS `keterangan`,`inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai` AS `id_mst_inv_barang_habispakai`,`inv_inventaris_habispakai_distribusi_item`.`batch` AS `batch`,`mst_inv_barang_habispakai`.`uraian` AS `uraian`,`mst_inv_barang_habispakai`.`id_mst_inv_barang_habispakai_jenis` AS `id_mst_inv_barang_habispakai_jenis`,sum(`inv_inventaris_habispakai_distribusi_item`.`jml`) AS `jml_distribusi`,ifnull((select sum(`a`.`jml`) from (`inv_inventaris_habispakai_distribusi_item` `a` join `inv_inventaris_habispakai_distribusi` `b` on((`a`.`id_inv_inventaris_habispakai_distribusi` = `b`.`id_inv_inventaris_habispakai_distribusi`))) where ((`a`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`) and (`b`.`tgl_distribusi` > ifnull((select `c`.`tgl_opname` from (`inv_inventaris_habispakai_opname` `c` left join `inv_inventaris_habispakai_opname_item` `d` on((`c`.`id_inv_inventaris_habispakai_opname` = `d`.`id_inv_inventaris_habispakai_opname`))) where ((`d`.`batch` = `a`.`batch`) and (`d`.`id_mst_inv_barang_habispakai` = `a`.`id_mst_inv_barang_habispakai`)) order by `c`.`tgl_opname` desc limit 1),'0000-00-00')))),0) AS `jml_distribusi_opname`,ifnull((select `inv_inventaris_habispakai_pembelian_item`.`harga` from (`inv_inventaris_habispakai_pembelian` left join `inv_inventaris_habispakai_pembelian_item` on((`inv_inventaris_habispakai_pembelian`.`id_inv_hasbispakai_pembelian` = `inv_inventaris_habispakai_pembelian_item`.`id_inv_hasbispakai_pembelian`))) where ((`inv_inventaris_habispakai_pembelian_item`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`)) order by `inv_inventaris_habispakai_pembelian_item`.`tgl_update` desc limit 1),'0') AS `harga_beli`,ifnull((select `inv_inventaris_habispakai_pembelian_item`.`tgl_update` from (`inv_inventaris_habispakai_pembelian` left join `inv_inventaris_habispakai_pembelian_item` on((`inv_inventaris_habispakai_pembelian`.`id_inv_hasbispakai_pembelian` = `inv_inventaris_habispakai_pembelian_item`.`id_inv_hasbispakai_pembelian`))) where ((`inv_inventaris_habispakai_pembelian_item`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`)) order by `inv_inventaris_habispakai_pembelian_item`.`tgl_update` desc limit 1),'0000-00-00') AS `tgl_beli`,ifnull((select `inv_inventaris_habispakai_opname`.`tgl_opname` from (`inv_inventaris_habispakai_opname` left join `inv_inventaris_habispakai_opname_item` on((`inv_inventaris_habispakai_opname`.`id_inv_inventaris_habispakai_opname` = `inv_inventaris_habispakai_opname_item`.`id_inv_inventaris_habispakai_opname`))) where ((`inv_inventaris_habispakai_opname_item`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`)) order by `inv_inventaris_habispakai_opname`.`tgl_opname` desc limit 1),'0000-00-00') AS `tgl_opname`,ifnull((select `inv_inventaris_habispakai_opname_item`.`harga` from (`inv_inventaris_habispakai_opname` left join `inv_inventaris_habispakai_opname_item` on((`inv_inventaris_habispakai_opname`.`id_inv_inventaris_habispakai_opname` = `inv_inventaris_habispakai_opname_item`.`id_inv_inventaris_habispakai_opname`))) where ((`inv_inventaris_habispakai_opname_item`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`)) order by `inv_inventaris_habispakai_opname`.`tgl_opname` desc limit 1),'0') AS `harga_opname`,ifnull((select `inv_inventaris_habispakai_opname_item`.`jml_akhir` from (`inv_inventaris_habispakai_opname` left join `inv_inventaris_habispakai_opname_item` on((`inv_inventaris_habispakai_opname`.`id_inv_inventaris_habispakai_opname` = `inv_inventaris_habispakai_opname_item`.`id_inv_inventaris_habispakai_opname`))) where ((`inv_inventaris_habispakai_opname_item`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`)) order by `inv_inventaris_habispakai_opname`.`tgl_opname` desc limit 1),'0') AS `jml_opname`,ifnull((ifnull((select `inv_inventaris_habispakai_opname_item`.`jml_akhir` from (`inv_inventaris_habispakai_opname` left join `inv_inventaris_habispakai_opname_item` on((`inv_inventaris_habispakai_opname`.`id_inv_inventaris_habispakai_opname` = `inv_inventaris_habispakai_opname_item`.`id_inv_inventaris_habispakai_opname`))) where ((`inv_inventaris_habispakai_opname_item`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_opname`.`tgl_opname` < `func`())) order by `inv_inventaris_habispakai_opname`.`tgl_opname` desc limit 1),0) + ifnull((select sum(`a`.`jml`) from (`inv_inventaris_habispakai_distribusi_item` `a` join `inv_inventaris_habispakai_distribusi` `b` on((`a`.`id_inv_inventaris_habispakai_distribusi` = `b`.`id_inv_inventaris_habispakai_distribusi`))) where ((`a`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`) and (`b`.`tgl_distribusi` > ifnull((select `c`.`tgl_opname` from (`inv_inventaris_habispakai_opname` `c` left join `inv_inventaris_habispakai_opname_item` `d` on((`c`.`id_inv_inventaris_habispakai_opname` = `d`.`id_inv_inventaris_habispakai_opname`))) where ((`d`.`batch` = `a`.`batch`) and (`d`.`id_mst_inv_barang_habispakai` = `a`.`id_mst_inv_barang_habispakai`) and (`c`.`tgl_opname` < `func`())) order by `c`.`tgl_opname` desc limit 1),'0000-00-00')) and (`b`.`tgl_distribusi` <= `func`()))),0)),0) AS `jmlawal`,if((ifnull((select `inv_inventaris_habispakai_opname`.`tgl_opname` from (`inv_inventaris_habispakai_opname` left join `inv_inventaris_habispakai_opname_item` on((`inv_inventaris_habispakai_opname`.`id_inv_inventaris_habispakai_opname` = `inv_inventaris_habispakai_opname_item`.`id_inv_inventaris_habispakai_opname`))) where ((`inv_inventaris_habispakai_opname_item`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`)) order by `inv_inventaris_habispakai_opname`.`tgl_opname` desc limit 1),(curdate() + interval 1 day)) < curdate()),ifnull((select `inv_inventaris_habispakai_opname_item`.`harga` from (`inv_inventaris_habispakai_opname` left join `inv_inventaris_habispakai_opname_item` on((`inv_inventaris_habispakai_opname`.`id_inv_inventaris_habispakai_opname` = `inv_inventaris_habispakai_opname_item`.`id_inv_inventaris_habispakai_opname`))) where ((`inv_inventaris_habispakai_opname_item`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`)) order by `inv_inventaris_habispakai_opname`.`tgl_opname` desc limit 1),0),ifnull((select `inv_inventaris_habispakai_pembelian_item`.`harga` from (`inv_inventaris_habispakai_pembelian` left join `inv_inventaris_habispakai_pembelian_item` on((`inv_inventaris_habispakai_pembelian`.`id_inv_hasbispakai_pembelian` = `inv_inventaris_habispakai_pembelian_item`.`id_inv_hasbispakai_pembelian`))) where ((`inv_inventaris_habispakai_pembelian_item`.`batch` = `inv_inventaris_habispakai_distribusi_item`.`batch`) and (`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`)) order by `inv_inventaris_habispakai_pembelian_item`.`tgl_update` desc limit 1),0)) AS `harga` from ((`inv_inventaris_habispakai_distribusi` left join `inv_inventaris_habispakai_distribusi_item` on((`inv_inventaris_habispakai_distribusi`.`id_inv_inventaris_habispakai_distribusi` = `inv_inventaris_habispakai_distribusi_item`.`id_inv_inventaris_habispakai_distribusi`))) join `mst_inv_barang_habispakai` on((`mst_inv_barang_habispakai`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`))) group by `inv_inventaris_habispakai_distribusi_item`.`batch`,`inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai`;

--
-- VIEW  `bhp_distribusi_opname`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
