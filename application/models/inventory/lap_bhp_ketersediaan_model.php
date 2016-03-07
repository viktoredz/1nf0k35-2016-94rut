<?php
class Lap_bhp_ketersediaan_model extends CI_Model {

    var $tabel       = 'mst_inv_ruangan';
    var $t_puskesmas = 'cl_phc';
	var $lang	     = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    function get_data_jenis()
    {
        $this->db->select('*');
        $query = $this->db->get('mst_inv_barang_habispakai_jenis');
        return $query->result();
    }
	function get_data_export($start=0,$limit=999999,$options=array())
    {
        $kodepuskesmas = "P".$this->session->userdata("puskesmas");
        $tanggal1 = $this->input->post('filter_tanggal');
        $tanggal2 = $this->input->post('filter_tanggal1');
        $data = array();
        $this->db->distinct();
       $this->db->select("mst_inv_barang_habispakai.*,mst_inv_pilihan.value as value, 
            (select jml as jml from  inv_inventaris_habispakai_opname where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jmlbaik,
            (select jml_rusak as jmlrusak from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai  and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jml_rusak,
            (select jml_tdkdipakai as jmltdkdipakai from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jml_tdkdipakai,
            (SELECT SUM(jml) AS jmltotal   FROM inv_inventaris_habispakai_pembelian_item JOIN inv_inventaris_habispakai_pembelian ON (inv_inventaris_habispakai_pembelian.id_inv_hasbispakai_pembelian = inv_inventaris_habispakai_pembelian_item.id_inv_hasbispakai_pembelian AND inv_inventaris_habispakai_pembelian.code_cl_phc = inv_inventaris_habispakai_pembelian_item.code_cl_phc AND inv_inventaris_habispakai_pembelian.pilihan_status_pembelian=2)   WHERE inv_inventaris_habispakai_pembelian_item.code_cl_phc=".'"'.$kodepuskesmas.'"'." AND id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai AND inv_inventaris_habispakai_pembelian_item.tgl_update > IF((SELECT MAX(tgl_update) FROM inv_inventaris_habispakai_opname WHERE inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai=inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai AND inv_inventaris_habispakai_pembelian_item.code_cl_phc=inv_inventaris_habispakai_opname.code_cl_phc) IS NOT NULL,(SELECT MAX(tgl_update) FROM inv_inventaris_habispakai_opname WHERE inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai=inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai AND inv_inventaris_habispakai_pembelian_item.code_cl_phc=inv_inventaris_habispakai_opname.code_cl_phc),  (SELECT MIN(tgl_update- INTERVAL 1 DAY) FROM inv_inventaris_habispakai_pembelian_item))AND inv_inventaris_habispakai_pembelian_item.tgl_update <= CURDATE()) AS totaljumlah,
            (SELECT SUM(jml) AS jmlpeng  FROM inv_inventaris_habispakai_pengeluaran WHERE id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai AND code_cl_phc=".'"'.$kodepuskesmas.'"'." AND inv_inventaris_habispakai_pengeluaran.tgl_update > IF((SELECT MAX(tgl_update) FROM inv_inventaris_habispakai_opname WHERE inv_inventaris_habispakai_pengeluaran.id_mst_inv_barang_habispakai = inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai AND inv_inventaris_habispakai_pengeluaran.code_cl_phc = inv_inventaris_habispakai_opname.code_cl_phc) IS NOT NULL,(SELECT MAX(tgl_update) FROM inv_inventaris_habispakai_opname WHERE inv_inventaris_habispakai_pengeluaran.id_mst_inv_barang_habispakai = inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai AND inv_inventaris_habispakai_pengeluaran.code_cl_phc = inv_inventaris_habispakai_opname.code_cl_phc), (SELECT MIN(tgl_update - INTERVAL 1 DAY) FROM inv_inventaris_habispakai_pengeluaran)) AND inv_inventaris_habispakai_pengeluaran.tgl_update <= CURDATE()   ORDER BY tgl_update DESC LIMIT 1) AS jmlpengeluaran,
            (select tgl_update as tglupdate from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as tgl_update,
            (select harga as hargaopname from  inv_inventaris_habispakai_opname where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as harga_opname,
            (select harga as hargapembelian from inv_inventaris_habispakai_pembelian_item 
            where code_cl_phc=".'"'.$kodepuskesmas.'"'." and id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai 
            ORDER BY tgl_update DESC LIMIT 1) as harga_pembelian,
            (select tgl_update  as tglopname from inv_inventaris_habispakai_opname where id_mst_inv_barang_habispakai = mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as tgl_opname,
            (select tgl_update  as tglpembelian from inv_inventaris_habispakai_pembelian_item where id_mst_inv_barang_habispakai = mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as tgl_pembelian
             ");
        $this->db->join('mst_inv_pilihan',"mst_inv_barang_habispakai.pilihan_satuan=mst_inv_pilihan.code and mst_inv_pilihan.tipe='satuan_bhp'",'left');
        $this->db->join('inv_inventaris_habispakai_pembelian_item',"inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai = mst_inv_barang_habispakai.id_mst_inv_barang_habispakai AND inv_inventaris_habispakai_pembelian_item.code_cl_phc=".'"'.$kodepuskesmas.'"'."",'left');
        $this->db->join('inv_inventaris_habispakai_opname',"inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai = mst_inv_barang_habispakai.id_mst_inv_barang_habispakai AND inv_inventaris_habispakai_opname.code_cl_phc=".'"'.$kodepuskesmas.'"'."");
        $query = $this->db->get('mst_inv_barang_habispakai',$limit,$start);
        return $query->result();
    }
}