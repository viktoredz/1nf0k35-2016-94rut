-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2016 at 05:43 AM
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
-- Structure for view `bhp_expired`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bhp_expired` AS select `inv_inventaris_habispakai_opname_item`.`id_inv_inventaris_habispakai_opname` AS `id_inv_inventaris_habispakai_opname`,`inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai` AS `id_mst_inv_barang_habispakai`,`inv_inventaris_habispakai_opname_item`.`batch` AS `batch`,(select `inv_inventaris_habispakai_pembelian_item`.`tgl_kadaluarsa` from `inv_inventaris_habispakai_pembelian_item` where ((`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_pembelian_item`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`inv_inventaris_habispakai_pembelian_item`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`)) order by `inv_inventaris_habispakai_pembelian_item`.`tgl_kadaluarsa` desc limit 1) AS `tgl_kadaluarsa`,(select `mst_inv_pilihan`.`value` from ((`inv_inventaris_habispakai_pembelian_item` join `inv_inventaris_habispakai_pembelian` on((`inv_inventaris_habispakai_pembelian`.`id_inv_hasbispakai_pembelian` = `inv_inventaris_habispakai_pembelian_item`.`id_inv_hasbispakai_pembelian`))) left join `mst_inv_pilihan` on(((convert(`inv_inventaris_habispakai_pembelian`.`pilihan_sumber_dana` using utf8) = `mst_inv_pilihan`.`code`) and (`mst_inv_pilihan`.`tipe` = 'sumber_dana')))) where ((`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_pembelian_item`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`inv_inventaris_habispakai_pembelian_item`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`)) limit 1) AS `pilihan_sumber_dana`,ifnull(if(((select `inv_inventaris_habispakai_pembelian_item`.`tgl_kadaluarsa` from `inv_inventaris_habispakai_pembelian_item` where ((`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_pembelian_item`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`inv_inventaris_habispakai_pembelian_item`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`)) order by `inv_inventaris_habispakai_pembelian_item`.`tgl_kadaluarsa` desc limit 1) > curdate()),((select `inv_inventaris_habispakai_pembelian_item`.`tgl_kadaluarsa` from `inv_inventaris_habispakai_pembelian_item` where ((`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_pembelian_item`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`inv_inventaris_habispakai_pembelian_item`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`)) order by `inv_inventaris_habispakai_pembelian_item`.`tgl_kadaluarsa` desc limit 1) - curdate()),0),0) AS `jmlexpired`,`inv_inventaris_habispakai_opname_item`.`jml_awal` AS `jml_awal`,`inv_inventaris_habispakai_opname_item`.`jml_akhir` AS `jml_akhir`,`inv_inventaris_habispakai_opname_item`.`harga` AS `harga`,`mst_inv_barang_habispakai`.`uraian` AS `uraian`,`mst_inv_barang_habispakai`.`id_mst_inv_barang_habispakai_jenis` AS `id_mst_inv_barang_habispakai_jenis`,`mst_inv_barang_habispakai`.`pilihan_satuan` AS `pilihan_satuan`,`mst_inv_barang_habispakai`.`merek_tipe` AS `merek_tipe`,`inv_inventaris_habispakai_opname`.`tgl_opname` AS `tgl_opname`,`inv_inventaris_habispakai_opname`.`nomor_opname` AS `nomor_opname`,`inv_inventaris_habispakai_opname`.`code_cl_phc` AS `code_cl_phc`,`inv_inventaris_habispakai_opname`.`catatan` AS `catatan`,`inv_inventaris_habispakai_opname`.`jenis_bhp` AS `jenis_bhp`,`inv_inventaris_habispakai_opname`.`petugas_nama` AS `petugas_nama`,sum(`inv_inventaris_habispakai_opname_item`.`jml_akhir`) AS `sumjml_akhir`,sum(`inv_inventaris_habispakai_opname_item`.`jml_awal`) AS `sumjml_awal`,sum((`inv_inventaris_habispakai_opname_item`.`jml_akhir` - `inv_inventaris_habispakai_opname_item`.`jml_awal`)) AS `sumselisih`,ifnull((select `a`.`jml_akhir` from (`inv_inventaris_habispakai_opname_item` `a` join `inv_inventaris_habispakai_opname` `b` on((`a`.`id_inv_inventaris_habispakai_opname` = `b`.`id_inv_inventaris_habispakai_opname`))) where ((`a`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`)) order by `b`.`tgl_opname` desc limit 1),0) AS `totalopname`,ifnull((select sum(`inv_inventaris_habispakai_distribusi_item`.`jml`) from (`inv_inventaris_habispakai_distribusi_item` join `inv_inventaris_habispakai_distribusi` on((`inv_inventaris_habispakai_distribusi`.`id_inv_inventaris_habispakai_distribusi` = `inv_inventaris_habispakai_distribusi_item`.`id_inv_inventaris_habispakai_distribusi`))) where ((`inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_distribusi_item`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`inv_inventaris_habispakai_distribusi`.`tgl_distribusi` > ifnull((select `d`.`tgl_opname` from (`inv_inventaris_habispakai_opname_item` `c` join `inv_inventaris_habispakai_opname` `d` on((`c`.`id_inv_inventaris_habispakai_opname` = `d`.`id_inv_inventaris_habispakai_opname`))) where ((`c`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`c`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`) and (month(`d`.`tgl_opname`) < month(`inv_inventaris_habispakai_opname`.`tgl_opname`)) and (year(`d`.`tgl_opname`) <= year(`inv_inventaris_habispakai_opname`.`tgl_opname`))) order by `d`.`tgl_opname` desc limit 1),'0000-00-00')) and (month(`inv_inventaris_habispakai_distribusi`.`tgl_distribusi`) <= month(`inv_inventaris_habispakai_opname`.`tgl_opname`)) and (year(`inv_inventaris_habispakai_distribusi`.`tgl_distribusi`) <= year(`inv_inventaris_habispakai_opname`.`tgl_opname`)))),0) AS `totaldistribusi`,(ifnull((select `a`.`jml_akhir` from (`inv_inventaris_habispakai_opname_item` `a` join `inv_inventaris_habispakai_opname` `b` on((`a`.`id_inv_inventaris_habispakai_opname` = `b`.`id_inv_inventaris_habispakai_opname`))) where ((`a`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`)) order by `b`.`tgl_opname` desc limit 1),0) + ifnull((select sum(`inv_inventaris_habispakai_distribusi_item`.`jml`) from (`inv_inventaris_habispakai_distribusi_item` join `inv_inventaris_habispakai_distribusi` on((`inv_inventaris_habispakai_distribusi`.`id_inv_inventaris_habispakai_distribusi` = `inv_inventaris_habispakai_distribusi_item`.`id_inv_inventaris_habispakai_distribusi`))) where ((`inv_inventaris_habispakai_distribusi_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_distribusi_item`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`inv_inventaris_habispakai_distribusi`.`tgl_distribusi` > ifnull((select `d`.`tgl_opname` from (`inv_inventaris_habispakai_opname_item` `c` join `inv_inventaris_habispakai_opname` `d` on((`c`.`id_inv_inventaris_habispakai_opname` = `d`.`id_inv_inventaris_habispakai_opname`))) where ((`c`.`batch` = `inv_inventaris_habispakai_opname_item`.`batch`) and (`c`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`)) order by `d`.`tgl_opname` desc limit 1),'0000-00-00')) and (month(`inv_inventaris_habispakai_distribusi`.`tgl_distribusi`) <= month(`inv_inventaris_habispakai_opname`.`tgl_opname`)) and (year(`inv_inventaris_habispakai_distribusi`.`tgl_distribusi`) <= year(`inv_inventaris_habispakai_opname`.`tgl_opname`)))),0)) AS `jmlawal_opname` from ((`inv_inventaris_habispakai_opname_item` join `mst_inv_barang_habispakai` on((`mst_inv_barang_habispakai`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`))) join `inv_inventaris_habispakai_opname` on(((`inv_inventaris_habispakai_opname`.`id_inv_inventaris_habispakai_opname` = `inv_inventaris_habispakai_opname_item`.`id_inv_inventaris_habispakai_opname`) and (`mst_inv_barang_habispakai`.`id_mst_inv_barang_habispakai_jenis` = 8)))) group by `inv_inventaris_habispakai_opname_item`.`batch`,`inv_inventaris_habispakai_opname_item`.`id_mst_inv_barang_habispakai`,month(`inv_inventaris_habispakai_opname`.`tgl_opname`),year(`inv_inventaris_habispakai_opname`.`tgl_opname`) order by `inv_inventaris_habispakai_opname_item`.`id_inv_inventaris_habispakai_opname`;

--
-- VIEW  `bhp_expired`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;