<?php
class Kursusdiklat_model extends CI_Model {

    var $tabel    = 'mst_peg_diklat';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    

    function get_data($start=0,$limit=999999,$options=array())
    {
		$this->db->order_by('id_diklat','asc');
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }

 	function get_data_row($id){
		$data = array();
		$options = array('id_diklat' => $id);
		$query = $this->db->get_where($this->tabel,$options);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	public function getSelectedData($table,$data)
    {
        return $this->db->get_where($table, array('id_diklat'=>$data));
    }

    function insert_entry()
    {
		$data['id_diklat']=$this->input->post('id_diklat');
		$data['nama_diklat']=$this->input->post('nama_diklat');
		$data['jenis']=$this->input->post('jenis');

		if($this->getSelectedData($this->tabel,$data['id_diklat'])->num_rows() > 0) {
			return 0;
		}else{
			if($this->db->insert($this->tabel, $data)){
			//$id= mysql_insert_id();
				return 1; 
			}else{
				return mysql_error();
			}
			
		}

    }
	function pilihan_enums($table , $field){
	$query = "SHOW COLUMNS FROM ".$table." LIKE '$field'";
	 $row = $this->db->query("SHOW COLUMNS FROM ".$table." LIKE '$field'")->row()->Type;  
	 $regex = "/'(.*?)'/";
	        preg_match_all( $regex , $row, $enum_array );
	        $enum_fields = $enum_array[1];
	        foreach ($enum_fields as $key=>$value)
	        {
	            $enums[$value] = $value; 
	        }
	        return $enums;
	}
    function update_entry($id)
    {
		$data['id_diklat']=$this->input->post('id_diklat');
		$data['nama_diklat']=$this->input->post('nama_diklat');
		$data['jenis']=$this->input->post('jenis');

		if($this->db->update($this->tabel, $data, array("id_diklat"=>$id))){
			return true;
		}else{
			return mysql_error();
		}
    }

	function delete_entry($id)
	{
		$this->db->where('id_diklat',$id);

		return $this->db->delete($this->tabel);
	}
}