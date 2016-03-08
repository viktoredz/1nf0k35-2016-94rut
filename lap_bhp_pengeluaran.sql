-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2016 at 07:07 AM
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
-- Structure for view `lap_bhp_pengeluaran`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lap_bhp_pengeluaran` AS select `b`.`id_mst_inv_barang_habispakai` AS `id_mst_inv_barang_habispakai`,`mst_inv_barang_habispakai`.`uraian` AS `uraian`,`mst_inv_pilihan`.`value` AS `value`,`b`.`code_cl_phc` AS `code_cl_phc`,`mst_inv_barang_habispakai`.`harga` AS `hargamaster`,`b`.`tgl_update` AS `tglkeluar`,`b`.`harga` AS `hargakeluar`,(select `inv_inventaris_habispakai_opname`.`tgl_update` AS `tgl_opname` from `inv_inventaris_habispakai_opname` where ((`inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_opname`.`code_cl_phc` = `b`.`code_cl_phc`)) order by `inv_inventaris_habispakai_opname`.`tgl_update` desc limit 1) AS `tglopname`,(select `inv_inventaris_habispakai_opname`.`harga` AS `harga_opname` from `inv_inventaris_habispakai_opname` where ((`inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_opname`.`code_cl_phc` = `b`.`code_cl_phc`)) order by `inv_inventaris_habispakai_opname`.`tgl_update` desc limit 1) AS `hargaopname`,(select `inv_inventaris_habispakai_pembelian_item`.`tgl_update` AS `tgl_pembelian` from `inv_inventaris_habispakai_pembelian_item` where ((`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_pembelian_item`.`code_cl_phc` = `b`.`code_cl_phc`)) order by `inv_inventaris_habispakai_pembelian_item`.`tgl_update` desc limit 1) AS `tglpembelian`,(select `inv_inventaris_habispakai_pembelian_item`.`harga` AS `harga_pembelian` from `inv_inventaris_habispakai_pembelian_item` where ((`inv_inventaris_habispakai_pembelian_item`.`code_cl_phc` = `b`.`code_cl_phc`) and (`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`)) order by `inv_inventaris_habispakai_pembelian_item`.`tgl_update` desc limit 1) AS `hargapembelian`,sum(`b`.`jml`) AS `pengeluaranperhari`,(select `inv_inventaris_habispakai_opname`.`jml` AS `jml` from `inv_inventaris_habispakai_opname` where ((`inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_opname`.`code_cl_phc` = `b`.`code_cl_phc`)) order by `inv_inventaris_habispakai_opname`.`tgl_update` desc limit 1) AS `jmlopname`,(select sum(`inv_inventaris_habispakai_pembelian_item`.`jml`) AS `jmltotal` from (`inv_inventaris_habispakai_pembelian_item` join `inv_inventaris_habispakai_pembelian` on(((`inv_inventaris_habispakai_pembelian`.`id_inv_hasbispakai_pembelian` = `inv_inventaris_habispakai_pembelian_item`.`id_inv_hasbispakai_pembelian`) and (`inv_inventaris_habispakai_pembelian`.`code_cl_phc` = `inv_inventaris_habispakai_pembelian_item`.`code_cl_phc`) and (`inv_inventaris_habispakai_pembelian`.`pilihan_status_pembelian` = 2)))) where ((`inv_inventaris_habispakai_pembelian_item`.`code_cl_phc` = `b`.`code_cl_phc`) and (`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_pembelian_item`.`tgl_update` > if(((select max(`inv_inventaris_habispakai_opname`.`tgl_update`) from `inv_inventaris_habispakai_opname` where ((`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_pembelian_item`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`))) is not null),(select max(`inv_inventaris_habispakai_opname`.`tgl_update`) from `inv_inventaris_habispakai_opname` where ((`inv_inventaris_habispakai_pembelian_item`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai`) and (`inv_inventaris_habispakai_pembelian_item`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`))),(select min((`inv_inventaris_habispakai_pembelian_item`.`tgl_update` - interval 1 day)) from `inv_inventaris_habispakai_pembelian_item`))) and (`inv_inventaris_habispakai_pembelian_item`.`tgl_update` <= curdate()))) AS `totaljumlah`,(select sum(`a`.`jml`) AS `jmlpeng` from `inv_inventaris_habispakai_pengeluaran` `a` where ((`a`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`) and (`a`.`code_cl_phc` = `b`.`code_cl_phc`) and (`a`.`tgl_update` > if(((select max(`inv_inventaris_habispakai_opname`.`tgl_update`) from `inv_inventaris_habispakai_opname` where ((`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai`) and (`a`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`))) is not null),(select max(`inv_inventaris_habispakai_opname`.`tgl_update`) from `inv_inventaris_habispakai_opname` where ((`a`.`id_mst_inv_barang_habispakai` = `inv_inventaris_habispakai_opname`.`id_mst_inv_barang_habispakai`) and (`a`.`code_cl_phc` = `inv_inventaris_habispakai_opname`.`code_cl_phc`))),(select min((`inv_inventaris_habispakai_pengeluaran`.`tgl_update` - interval 1 day)) from `inv_inventaris_habispakai_pengeluaran`))) and (`a`.`tgl_update` <= curdate())) order by `a`.`tgl_update` desc limit 1) AS `totalpengeluaran` from ((`inv_inventaris_habispakai_pengeluaran` `b` join `mst_inv_barang_habispakai` on((`mst_inv_barang_habispakai`.`id_mst_inv_barang_habispakai` = `b`.`id_mst_inv_barang_habispakai`))) left join `mst_inv_pilihan` on(((convert(`mst_inv_barang_habispakai`.`pilihan_satuan` using utf8) = `mst_inv_pilihan`.`code`) and (`mst_inv_pilihan`.`tipe` = 'satuan_bhp')))) group by `b`.`tgl_update`,`b`.`id_mst_inv_barang_habispakai`;

--
-- VIEW  `lap_bhp_pengeluaran`
-- Data: None
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
