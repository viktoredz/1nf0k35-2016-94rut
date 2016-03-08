-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2016 at 07:06 AM
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
-- Structure for view `lap_bhp_pengadaan`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lap_bhp_pengadaan` AS select `b`.`id_mst_inv_barang_habispakai` AS `id_mst_inv_barang_habispakai`,`mst_inv_barang_habispakai`.`uraian` AS `uraian`,`mst_inv_pilihan`.`value` AS `value`,`b`.`code_cl_phc` AS `code_cl_phc`,`mst_inv_barang_habispakai`.`harga` AS `hargamaster`,date_format(`b`.`tgl_update`,' %m-%Y ') AS `bulan`,sum(`b`.`jml`) AS `jmlpembelian`,`b`.`tgl_update` AS `tglbeli`,`b`.`harga` AS `harga_beli`,(select `inv_inventaris_habispakai_opname`.`jml` AS `jml` from `inv_inventaris_habispakai_opname` where ((`inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_opname`.`code_cl_phc` = `b`.`code_cl_phc`)) order by `inv_inventaris_habispakai_opname`.`tgl_update` desc limit 1) AS `jmlopname`,(select `inv_inventaris_habispakai_opname`.`tgl_update` AS `tgl_opname` from `inv_inventaris_habispakai_opname` where ((`inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_opname`.`code_cl_phc` = `b`.`code_cl_phc`)) order by `inv_inventaris_habispakai_opname`.`tgl_update` desc limit 1) AS `tglopname`,(select `inv_inventaris_habispakai_opname`.`harga` AS `harga_opname` from `inv_inventaris_habispakai_opname` where ((`inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_opname`.`code_cl_phc` = `b`.`code_cl_phc`)) order by `inv_inventaris_habispakai_opname`.`tgl_update` desc limit 1) AS `hargaopname`,(select sum(`a`.`jml`) AS `jmltotal` from (`inv_inventaris_habispakai_pembelian_item` `a` join `inv_inventaris_habispakai_pembelian` on(((`inv_inventaris_habispakai_pembelian`.`id_inv_hasbispakai_pembelian` = `a`.`id_inv_hasbispakai_pembelian`) and (`inv_inventaris_habispakai_pembelian`.`code_cl_phc` = `a`.`code_cl_phc`) and (`inv_inventaris_habispakai_pembelian`.`pilihan_status_pembelian` = 2)))) where ((`a`.`code_cl_phc` = `b`.`code_cl_phc`) and (`a`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`a`.`tgl_update` > if(((select max(`inv_inventaris_habispakai_opname`.`tgl_update`) from `inv_inventaris_habispakai_opname` where ((`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai`) and (`a`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`))) is not null),(select max(`inv_inventaris_habispakai_opname`.`tgl_update`) from `inv_inventaris_habispakai_opname` where ((`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai`) and (`a`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`))),(select min((`inv_inventaris_habispakai_pembelian_item`.`tgl_update` - interval 1 day)) from `inv_inventaris_habispakai_pembelian_item`))) and (`a`.`tgl_update` <= curdate()))) AS `totaljumlah`,(select sum(`a`.`jml`) AS `jmlpeng` from `inv_inventaris_habispakai_pengeluaran` `a` where ((`a`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`a`.`code_cl_phc` = `b`.`code_cl_phc`) and (`a`.`tgl_update` > if(((select max(`inv_inventaris_habispakai_opname`.`tgl_update`) from `inv_inventaris_habispakai_opname` where ((`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai`) and (`a`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`))) is not null),(select max(`inv_inventaris_habispakai_opname`.`tgl_update`) from `inv_inventaris_habispakai_opname` where ((`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai`) and (`a`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`))),(select min((`inv_inventaris_habispakai_pengeluaran`.`tgl_update` - interval 1 day)) from `inv_inventaris_habispakai_pengeluaran`))) and (`a`.`tgl_update` <= curdate())) order by `a`.`tgl_update` desc limit 1) AS `totalpengeluaran` from ((`inv_inventaris_habispakai_pembelian_item` `b` join `mst_inv_barang_habispakai` on((`mst_inv_barang_habispakai`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`))) left join `mst_inv_pilihan` on(((convert(`mst_inv_barang_habispakai`.`pilihan_satuan` using utf8) = `mst_inv_pilihan`.`code`) and (`mst_inv_pilihan`.`tipe` = 'satuan_bhp')))) group by date_format(`b`.`tgl_update`,' %m-%Y '),`b`.`id_mst_inv_barang_habispakai`;

--
-- VIEW  `lap_bhp_pengadaan`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
