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
        // $tar_nama_posisi        = $this->input->post('tar_nama_posisi');
        // $status  = $this->input->post('status');
        // $this->db->where('tar_id_struktur_org',$akun_urutan_induk);
        // $dt = $this->db->get($this->tb)->row();
        // if($akun_urutan == "sebelum"){
        //     $data['urutan']  = $dt->urutan;
        // }else{
        //     $data['urutan']  = $dt->urutan+1;
        // }

        
        $data['tar_nama_posisi']   = $this->input->post('tar_nama_posisi');
        $data['tar_id_struktur_org']   = $this->nourut(0);
        $data['tar_id_struktur_org_parent']              = 0;
        $data['tar_aktif']         = $this->input->post('tar_status');
        $data['code_cl_phc']     = $puskes;
	
		if($this->db->insert($this->tb, $data)){
            // $id = mysql_insert_id();
            // $this->db->query("UPDATE mst_keu_akun SET urutan=urutan+1 WHERE isnull(`id_mst_akun_parent`) AND urutan >= ".$data['urutan']." AND `id_mst_akun`<>".$id);
            return 1;
		}else{
			return mysql_error();
		}
    }

    function mendukung_transaksi_update($id){
        $data['mendukung_transaksi']      = $this->input->post('mendukung_transaksi');
       
        $this->db->where('id_mst_akun',$id);

        if($this->db->update($this->tb, $data)){
            $this->db->where('id_mst_akun',$id);
            $this->db->select('mendukung_transaksi');
            $variable = $this->db->get('mst_keu_akun');
            foreach ($variable->result() as $key) {
                if ($key->mendukung_transaksi=='1') {
                    return '1';
                }else{
                    return '2';    
                }
            }
        }else{
            return mysql_error();
        }
    }

    function mendukung_anggaran_update($id){
        $data['mendukung_anggaran']       = $this->input->post('mendukung_anggaran');
       
        $this->db->where('id_mst_akun',$id);

        if($this->db->update($this->tb, $data)){
            $this->db->where('id_mst_akun',$id);
            $this->db->select('mendukung_anggaran');
            $variable = $this->db->get('mst_keu_akun');
            foreach ($variable->result() as $key) {
                if($key->mendukung_anggaran=='1'){
                    return '1';
                }else{
                    return '2';
                }
            }
        }else{
            return mysql_error();
        }
    }

    function mendukung_target_update($id){
        $data['mendukung_target']         = $this->input->post('mendukung_target');
       
        $this->db->where('id_mst_akun',$id);

        if($this->db->update($this->tb, $data)){
            $this->db->where('id_mst_akun',$id);
            $this->db->select('mendukung_target');
            $variable = $this->db->get('mst_keu_akun');
            foreach ($variable->result() as $key ) {
               if ($key->mendukung_target=='1') {
                   return '1';
               }else{
                   return '2';
               }
            }
        }else{
            return mysql_error();
        }
    }

    function akun_delete($id=0){  
        $this->db->where('tar_id_struktur_org_parent',$id);
        $q = $this->db->get('mst_peg_struktur_org');
        if ($q->num_rows() > 0 ) {
            $child = $q->result_array();
            foreach ($child as $dt) {
                $this->akun_delete($dt['tar_id_struktur_org']);
            }

        }
        $this->db->where('tar_id_struktur_org', $id);
        $this->db->delete($this->tb);
        

        
    }

    function akun_add(){
        if(strlen($this->session->userdata('puskesmas'))=='4') {
            $puskes = 'P'.$this->session->userdata('puskesmas');
        }else{
            $puskes = 'P'.$this->session->userdata('puskesmas');
        }
        $data = array(
           'tar_id_struktur_org'     => $this->nourut($this->input->post('tar_id_struktur_org')),
           'tar_id_struktur_org_parent' => $this->input->post('tar_id_struktur_org_parent') ,
           'tar_aktif'               => $this->input->post('tar_aktif'),
           'tar_nama_posisi'         => $this->input->post('tar_nama_posisi'),
           'code_cl_phc'             => $puskes,
        );

        if(($this->db->insert($this->tb, $data))){
            return 1;
        }else{
            return mysql_error();
        }
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
    function akun_update(){
        $data = array(
           'tar_id_struktur_org_parent'  => $this->input->post('tar_id_struktur_org_parent'),
           'tar_nama_posisi'             => $this->input->post('tar_nama_posisi') ,
           'tar_aktif'                   => $this->input->post('tar_aktif') ,
        );
        $this->db->where('tar_id_struktur_org', $this->input->post('tar_id_struktur_org'));
        return $this->db->update($this->tb, $data);             
    }

 	function get_data($start=0,$limit=999999,$options=array())
    {
		$this->db->order_by('id_mst_akun','asc');
        $query = $this->db->get('mst_keu_akun',$limit,$start);
        return $query->result();
    }

    function get_data_akun(){     
        //$this->db->where('tar_aktif',1);
        $this->db->order_by('tar_id_struktur_org','asc');
        $query = $this->db->get('mst_peg_struktur_org');     
        return $query->result_array();  
    }

    function get_data_akun_non_aktif(){     
        $this->db->where('aktif','0');
        $query = $this->db->get('mst_keu_akun');     
        return $query->result_array();  
    }

    function get_parent_akun(){     
        $this->db->where('id_mst_akun_parent IS NULL');
        $this->db->order_by('uraian','asc');
        $query = $this->db->get('mst_keu_akun');     
        return $query->result();  
    }

   function get_data_akun_detail($id){
        $data = array();
        $this->db->where("tar_id_struktur_org",$id);
        $query = $this->db->get('mst_peg_struktur_org');
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function get_data_akun_non_aktif_detail($id){
        $data = array();
        $this->db->where("id_mst_akun",$id);
        $this->db->where('aktif',0);
        $query = $this->db->get('mst_keu_akun');
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

}

