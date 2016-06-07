<?php
class Struktur_model extends CI_Model {

    var $tabel    = '';
	var $lang	  = '';
    var $tb       = 'pegawai_struktur';

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
        $query= $this->db->get('pegawai_struktur');
        if ($query->num_rows()>0) {
            foreach ($query->result() as $key) {
                $no = $key->max+1;
            }
        }else{
            $no = 1;
        }
        return $no;

    }
    

 	function get_data($start=0,$limit=999999,$options=array())
    {
		$this->db->order_by('id_mst_akun','asc');
        $query = $this->db->get('mst_keu_akun',$limit,$start);
        return $query->result();
    }

    function get_data_akun($kodepuskesmas=""){     
        $this->db->where('mst_peg_struktur_org.code_cl_phc',$kodepuskesmas);
        $this->db->where('mst_peg_struktur_org.tar_aktif',1);
        $this->db->order_by('tar_id_struktur_org','asc');
        $this->db->select('mst_peg_struktur_org.*,(select count(id_pegawai) from pegawai_struktur where tar_id_struktur_org = mst_peg_struktur_org.tar_id_struktur_org) as jml_anggota',false);
        // ,pegawai.nama,pegawai.nik$this->db->join('pegawai_struktur','pegawai_struktur.tar_id_struktur_org = mst_peg_struktur_org.tar_id_struktur_org','left'); 
        // $this->db->join('pegawai','pegawai.id_pegawai = pegawai_struktur.id_pegawai','left'); 
        $query = $this->db->get('mst_peg_struktur_org');     
        return $query->result_array();  
    }

  
   

   function get_data_akun_detail($id){
        $data = array();
        $this->db->where("tar_id_struktur_org",$id);
        $this->db->join("pegawai",'pegawai.id_pegawai = pegawai.id_pegawai','left');
        $query = $this->db->get('xpegawai_struktur');
        // if($query->num_rows()>0){
        //     $data = $query->row_array();
        // }

        // $query->free_result();
        return $query->result();
    }

  

}

