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
	
		if($this->db->insert('mst_keu_akun', $data)){
			return 1;
		}else{
			return mysql_error();
		}
    }

    function induk_delete(){  
        $this->db->where('id_mst_akun', $this->input->post('id_mst_akun'));
        $this->db->delete('mst_keu_akun');
                
        $this->db->where('id_mst_akun_parent', $this->input->post('id_mst_akun'));
        $this->db->delete('mst_keu_akun');
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
          ($this->db->insert('mst_keu_akun', $data));
            return 1;
        }else{
            return mysql_error();
        }
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

    function delete_entry($id)
	{
		$this->db->where('code',$id);

		return $this->db->delete('mst_inv_pbf');
	}

   function get_data_instansi_edit($id){
        $data = array();

        $this->db->select("*");
        $this->db->where("code",$id);
        $query = $this->db->get("mst_inv_pbf");
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function update_entry_instansi($id)
    {
    	$data['nama']          = $this->input->post('nama');
        $data['tlp']		   = $this->input->post('tlp');
        $data['alamat']        = $this->input->post('alamat');
        $data['kategori']      = $this->input->post('kategori');
        $data['status']        = $this->input->post('status');

        $this->db->where('code',$id);

        if($this->db->update('mst_inv_pbf', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

     	function get_data_row($id){
		$data = array();
		$options = array('code' => $id);
		$query = $this->db->get_where('mst_inv_pbf',$options);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}


}

