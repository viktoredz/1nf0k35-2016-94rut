<?php
class Keuakun_model extends CI_Model {

    var $tabel    = '';
	var $lang	  = '';
    var $tb       = 'mst_keu_akun';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }


    function insert_entry()
    {
        $data['uraian']          = $this->input->post('uraian');
        $data['saldo_normal']    = $this->input->post('saldo_normal');
	
		if($this->db->set('saldo_awal',0)){
          ($this->db->set('mendukung_anggaran',0));
		  ($this->db->insert($this->tb, $data));
            return 1;
		}else{
			return mysql_error();
		}
    }

    function akun_delete(){  
        $this->db->where('id_mst_akun', $this->input->post('id_mst_akun'));
        $this->db->delete($this->tb);
                
        $this->db->where('id_mst_akun_parent', $this->input->post('id_mst_akun'));
        $this->db->delete($this->tb);
    }

    function akun_add(){
        $data = array(
           'id_mst_akun_parent'     => $this->input->post('id_mst_akun_parent'),
           'kode'                   => $this->input->post('kode') ,
           'saldo_normal'           => $this->input->post('saldo_normal'),
           'saldo_awal'             => $this->input->post('saldo_awal'),
           'uraian'                 => $this->input->post('uraian'),
           'mendukung_anggaran'     => $this->input->post('mendukung_anggaran')
        );

         if($this->db->set('tanggal_dibuat', 'NOW()', FALSE)){
           ($this->db->insert($this->tb, $data));
            return 1;
        }else{
            return mysql_error();
        }
    }

    function akun_update(){
        $data = array(
           'id_mst_akun_parent' => $this->input->post('id_mst_akun_parent'),
           'kode'               => $this->input->post('kode') ,
           'saldo_normal'       => $this->input->post('saldo_normal') ,
           'saldo_awal'         => $this->input->post('saldo_awal'),
           'uraian'             => $this->input->post('uraian'),
           'mendukung_anggaran' => $this->input->post('mendukung_anggaran')
        );
        $this->db->where('id_mst_akun', $this->input->post('id_mst_akun'));
        return $this->db->update($this->tb, $data);             
    }

 	function get_data($start=0,$limit=999999,$options=array())
    {
		$this->db->order_by('id_mst_akun','asc');
        $query = $this->db->get('mst_keu_akun',$limit,$start);
        return $query->result();
    }

    function get_data_akun()
    {     
        $this->db->select('*');
        $this->db->order_by('uraian','asc');
        $query = $this->db->get('mst_keu_akun');     
        return $query->result_array();  
    }

   function get_data_akun_detail($id){
        $data = array();
        $this->db->select("*");
        $this->db->where("id_mst_akun",$id);
        $query = $this->db->get('mst_keu_akun');
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

}

