<?php
class Pegorganisasi_model extends CI_Model {

    var $tabel    = '';
	var $lang	  = '';
    var $tb       = 'mst_peg_struktur_org';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }

    function insert_entry(){
        if(strlen($this->session->userdata('puskesmas'))=='4') {
            $puskes = 'P'.$this->session->userdata('puskesmas');
        }else{
            $puskes = 'P'.$this->session->userdata('puskesmas');
        }
        
        $data['tar_nama_posisi']        = $this->input->post('tar_nama_posisi');
        $data['tar_id_struktur_org']    = $this->nourut(0);
        $data['tar_aktif']              = $this->input->post('tar_status');
        $data['code_cl_phc']            = $puskes;
        $data['tar_id_struktur_org_parent'] = 0;
	
		if($this->db->insert($this->tb, $data)){
            return 1;
		}else{
			return mysql_error();
		}
    }

    function akun_delete($id=0){  
        $puskes = 'P'.$this->session->userdata('puskesmas');
        $this->db->where('code_cl_phc',$puskes);
        $this->db->where('tar_id_struktur_org_parent',$id);
        $q = $this->db->get('mst_peg_struktur_org');
        if ($q->num_rows() == 0 ) {
            $this->db->where('code_cl_phc',$puskes);
            $this->db->where('tar_id_struktur_org', $id);
            $this->db->delete($this->tb);
        }
    }

    function akun_add(){
        $puskes = 'P'.$this->session->userdata('puskesmas');
        $data = array(
           'tar_id_struktur_org'     => $this->nourut($this->input->post('tar_id_struktur_org')),
           'tar_aktif'               => $this->input->post('tar_aktif'),
           'tar_nama_posisi'         => $this->input->post('tar_nama_posisi'),
           'code_cl_phc'             => $puskes,
           'tar_id_struktur_org_parent' => $this->input->post('tar_id_struktur_org_parent') 
        );

        if(($this->db->insert($this->tb, $data))){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function akun_update(){
        $puskes = 'P'.$this->session->userdata('puskesmas');
        $data = array(
           'tar_id_struktur_org_parent' => $this->input->post('tar_id_struktur_org_parent'),
           'tar_nama_posisi'            => $this->input->post('tar_nama_posisi') ,
           'tar_aktif'                  => $this->input->post('tar_aktif') ,
        );
        $this->db->where('code_cl_phc',$puskes);
        $this->db->where('tar_id_struktur_org', $this->input->post('tar_id_struktur_org'));
        return $this->db->update($this->tb, $data);             
    }

    function nourut($id=0){
        if ($id=0) {
            $no = 'P'.$this->session->userdata('puskesmas');
        }else{
            $no = 'P'.$this->session->userdata('puskesmas');
        }
        $this->db->select('max(tar_id_struktur_org) as max');
        $this->db->where('code_cl_phc',$no);
        $query= $this->db->get('mst_peg_struktur_org');
        if ($query->num_rows>0) {
            foreach ($query->result() as $key) {
                $no = $key->max+1;
            }
        }else{
            $no = 1;
        }
        return $no;

    }

    function get_data_akun($kodepuskesmas = ""){     
        $this->db->where('code_cl_phc',$kodepuskesmas);
        $this->db->order_by('tar_id_struktur_org','asc');
        $query = $this->db->get('mst_peg_struktur_org');     
        return $query->result_array();  
    }

    function get_parent_akun(){     
        $this->db->where('id_mst_akun_parent IS NULL');
        $this->db->order_by('uraian','asc');
        $query = $this->db->get('mst_keu_akun');     
        return $query->result();  
    }

   function get_data_akun_detail($id,$code_cl_phc){
        $data = array();
        $this->db->where("tar_id_struktur_org",$id);
        $this->db->where("code_cl_phc",$code_cl_phc);
        $query = $this->db->get('mst_peg_struktur_org');
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }
    function get_data_skp($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("*");
        $this->db->where('id_mst_peg_struktur_org',$id);
        $query = $this->db->get('mst_peg_struktur_skp',$limit,$start);
        return $query->result();
    }
    function delete_skp($id_org=0,$id_skp=0,$code_cl_phc=""){
        $this->db->where('id_mst_peg_struktur_org',$id_org);
        $this->db->where('id_mst_peg_struktur_skp',$id_skp);
        $this->db->where('code_cl_phc',$code_cl_phc);
        $this->db->delete('mst_peg_struktur_skp');
    }

    function get_data_row_skp($id_org=0,$id_skp=0,$code_cl_phc=""){
        $this->db->where('id_mst_peg_struktur_org',$id_org);
        $this->db->where('id_mst_peg_struktur_skp',$id_skp);
        $this->db->where('code_cl_phc',$code_cl_phc);
        $query = $this->db->get('mst_peg_struktur_skp');   
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }

        $query->free_result();    
        return $data;
    }
}

