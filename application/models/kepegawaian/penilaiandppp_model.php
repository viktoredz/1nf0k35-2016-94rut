<?php
class Penilaiandppp_model extends CI_Model {

    var $tabel    = 'inv_permohonan_barang';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
   
    function get_detail_ruang($id, $code_cl_phc){
		$this->db->where('id_inv_permohonan_barang',$id);
		$this->db->where('inv_permohonan_barang.code_cl_phc',$code_cl_phc);
		#$this->db->join('cl_phc','inv_permohonan_barang.code_cl_phc = cl_phc.code');
		$this->db->join('mst_inv_ruangan','inv_permohonan_barang.id_mst_inv_ruangan = mst_inv_ruangan.id_mst_inv_ruangan');
		$q = $this->db->get('inv_permohonan_barang',1);		
		return $q->result();
	}
    
    function get_data($start=0,$limit=999999,$options=array())
    {	$puskesmas_ = 'P'.$this->session->userdata('puskesmas');
    	$this->db->select("$this->tabel.*,mst_inv_ruangan.nama_ruangan,mst_inv_pilihan.value");
    	$this->db->select("(select SUM(harga*jumlah) AS hrg FROM inv_permohonan_barang_item WHERE id_inv_permohonan_barang=inv_permohonan_barang.id_inv_permohonan_barang and code_cl_phc="."'".$puskesmas_."'".") AS totalharga");
		$this->db->join('mst_inv_ruangan', "inv_permohonan_barang.id_mst_inv_ruangan = mst_inv_ruangan.id_mst_inv_ruangan and inv_permohonan_barang.code_cl_phc = mst_inv_ruangan.code_cl_phc ",'left');
		$this->db->join('mst_inv_pilihan', "inv_permohonan_barang.pilihan_status_pengadaan = mst_inv_pilihan.code AND mst_inv_pilihan.tipe='status_pengadaan'",'left');
		$this->db->order_by('inv_permohonan_barang.id_inv_permohonan_barang','desc');
		$query =$this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }
    
}