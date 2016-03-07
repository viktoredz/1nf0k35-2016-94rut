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
    	$this->db->select("inv_permohonan_barang_item.*");
    	$this->db->join('inv_permohonan_barang', "inv_permohonan_barang.id_inv_permohonan_barang = inv_permohonan_barang_item.id_inv_permohonan_barang",'inner');
		$this->db->join('mst_inv_ruangan', "inv_permohonan_barang.id_mst_inv_ruangan = mst_inv_ruangan.id_mst_inv_ruangan and inv_permohonan_barang.code_cl_phc = mst_inv_ruangan.code_cl_phc ",'left');
		$this->db->join('mst_inv_pilihan', "inv_permohonan_barang.pilihan_status_pengadaan = mst_inv_pilihan.code AND mst_inv_pilihan.tipe='status_pengadaan'",'left');
		$this->db->where('inv_permohonan_barang.tanggal_permohonan >=', $this->input->post('filter_tanggal'));
		$this->db->where('inv_permohonan_barang.tanggal_permohonan <=', $this->input->post('filter_tanggal1'));
		$this->db->order_by('inv_permohonan_barang.id_inv_permohonan_barang','desc');
		$query =$this->db->get('inv_permohonan_barang_item',$limit,$start);
        return $query->result();
    }
	function get_data_jenis()
    {
        $this->db->select('*');
        $query = $this->db->get('mst_inv_barang_habispakai_jenis');
        return $query->result();
    }
}