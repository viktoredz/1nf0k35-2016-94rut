<?php
class Lap_bhp_pengeluaran_model extends CI_Model {

    var $tabel       = 'mst_inv_ruangan';
    var $t_puskesmas = 'cl_phc';
	var $lang	     = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    
	function get_pilihan_kondisi(){
		$this->db->select('code as id, value as val');
		$this->db->where('tipe','keadaan_barang');
		$q = $this->db->get('mst_inv_pilihan');
		return $q;
	}
	function get_data_permohonan($start=0,$limit=999999,$options=array())
    {	
    	/*$this->db->select("inv_permohonan_barang_item.*");
    	$this->db->join('inv_permohonan_barang', "inv_permohonan_barang.id_inv_permohonan_barang = inv_permohonan_barang_item.id_inv_permohonan_barang",'inner');
		$this->db->join('mst_inv_ruangan', "inv_permohonan_barang.id_mst_inv_ruangan = mst_inv_ruangan.id_mst_inv_ruangan and inv_permohonan_barang.code_cl_phc = mst_inv_ruangan.code_cl_phc ",'left');
		$this->db->join('mst_inv_pilihan', "inv_permohonan_barang.pilihan_status_pengadaan = mst_inv_pilihan.code AND mst_inv_pilihan.tipe='status_pengadaan'",'left');
		$this->db->where('inv_permohonan_barang.tanggal_permohonan >=', $this->input->post('filter_tanggal'));
		$this->db->where('inv_permohonan_barang.tanggal_permohonan <=', $this->input->post('filter_tanggal1'));
		$this->db->order_by('inv_permohonan_barang.id_inv_permohonan_barang','desc');
		$query =$this->db->get('inv_permohonan_barang_item',$limit,$start);*/
		$tanggal1 = $this->input->post('filter_tanggal');
    	$tanggal1 = $this->input->post('filter_tanggal1');
    	$pusksmas = "P".$this->session->userdata('puskesmas');
		$query =$this->db->query("
				SELECT inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai,mst_inv_barang_habispakai.uraian,mst_inv_pilihan.value, 
mst_inv_barang_habispakai.harga AS harga_asli, 
inv_inventaris_habispakai_pembelian_item.harga AS harga_beli,
DATE_FORMAT(tgl_update, \" %m-%Y \") AS MONTH, SUM(jml) 
FROM inv_inventaris_habispakai_pembelian_item
JOIN mst_inv_barang_habispakai ON (mst_inv_barang_habispakai.id_mst_inv_barang_habispakai = 
inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai AND code_cl_phc=".'"'.$pusksmas.'"'." )
LEFT JOIN mst_inv_pilihan ON (mst_inv_barang_habispakai.pilihan_satuan=mst_inv_pilihan.code AND mst_inv_pilihan.tipe='satuan_bhp' )
WHERE inv_inventaris_habispakai_pembelian_item.tgl_update >=".'"'.$tanggal1.'"'." AND
			inv_inventaris_habispakai_pembelian_item.tgl_update <= ".'"'.$tanggal1.'"'."
GROUP BY DATE_FORMAT(tgl_update, \" %m-%Y \") ,inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai
			");
        return $query->result();
    }
	function get_data_jenis()
    {
        $this->db->select('*');
        $query = $this->db->get('mst_inv_barang_habispakai_jenis');
        return $query->result();
    }
}