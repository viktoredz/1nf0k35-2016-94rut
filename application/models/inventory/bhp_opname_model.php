<?php
class Bhp_opname_model extends CI_Model {

    var $tabel    = 'mst_inv_barang_habispakai';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');

    }
    
    function get_data($start=0,$limit=999999,$options=array())
    {
        $data = array();
        $this->db->select("mst_inv_barang_habispakai.*,mst_inv_pilihan.value as nama_satuan");
        $this->db->join('mst_inv_pilihan',"mst_inv_barang_habispakai.pilihan_satuan=mst_inv_pilihan.code and mst_inv_pilihan.tipe='satuan'",'left');
        $query = $this->db->get('mst_inv_barang_habispakai',$limit,$start);
        return $query->result();
    }
    function get_data_jenis()
    {
        $this->db->select('*');
        $query = $this->db->get('mst_inv_barang_habispakai_jenis');
        return $query->result();
    }
    function get_data_detail_edit($kode){
        $data = array();
        $this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai",$kode);
        $this->db->select("mst_inv_barang_habispakai.*,mst_inv_pilihan.value as nama_satuan");
        $this->db->join('mst_inv_pilihan',"mst_inv_barang_habispakai.pilihan_satuan=mst_inv_pilihan.code and mst_inv_pilihan.tipe='satuan'",'left');
        $query = $this->db->get('mst_inv_barang_habispakai');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }
        $query->free_result();    
        return $data;
    }
    function get_barang($kode){
        $this->db->order_by('tgl_update','desc');
        $this->db->where("id_mst_inv_barang_habispakai",$kode);
        $this->db->select("*");
        return $query = $this->db->get('inv_inventaris_habispakai_opname',3,0)->result();
    }
    function get_kondisi_barang($kode){
        $this->db->order_by('tgl_update','desc');
        $this->db->where("id_mst_inv_barang_habispakai",$kode);
        $this->db->select("*");
        return $query = $this->db->get('inv_inventaris_habispakai_kondisi',3,0)->result();
    }
    function insertdata(){
        $this->db->where('tgl_update',date('Y-m-d'));
        $this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
        $this->db->where('id_mst_inv_barang_habispakai',$this->input->post('id_mst_inv_barang_habispakai'));
        $this->db->select("*");
        $query = $this->db->get("inv_inventaris_habispakai_opname");
           if ($query->num_rows() > 0){
                $dataupdate = array(
                    'jml' => $this->input->post('jml'),
                    'harga' => $this->input->post('harga'),
                    );
                $datakey = array(
                    'id_mst_inv_barang_habispakai'  =>$this->input->post('id_mst_inv_barang_habispakai'),
                    'code_cl_phc'                   =>'P'.$this->session->userdata('puskesmas') ,
                    'tgl_update'=> date('Y-m-d'),
                     );
                if($simpan=$this->db->update("inv_inventaris_habispakai_opname",$dataupdate,$datakey)){
                    return true;
                }else{
                    return mysql_error();
                }
            }else{
                $values = array(
                    'id_mst_inv_barang_habispakai'  =>$this->input->post('id_mst_inv_barang_habispakai'),
                    'code_cl_phc'                   =>'P'.$this->session->userdata('puskesmas') ,
                    'tgl_update'=> date('Y-m-d'),
                    'jml' => $this->input->post('jml'),
                    'harga' => $this->input->post('harga'),
                );
                if($simpan=$this->db->insert('inv_inventaris_habispakai_opname', $values)){
                    return true;
                }else{
                    return mysql_error();
                }
            }
            
    }
    function insertdatakondisi(){
        $this->db->where('tgl_update',date('Y-m-d'));
        $this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
        $this->db->where('id_mst_inv_barang_habispakai',$this->input->post('id_mst_inv_barang_habispakai'));
        $this->db->select("*");
        $query = $this->db->get("inv_inventaris_habispakai_kondisi");
           if ($query->num_rows() > 0){
                $dataupdate = array(
                    'jml_rusak' => $this->input->post('jml_rusak'),
                    'jml_tdkdipakai' => $this->input->post('jml_tdkdipakai'),
                    );
                $datakey = array(
                    'id_mst_inv_barang_habispakai'  =>$this->input->post('id_mst_inv_barang_habispakai'),
                    'code_cl_phc'                   =>'P'.$this->session->userdata('puskesmas') ,
                    'tgl_update'=> date('Y-m-d'),
                     );
                if($simpan=$this->db->update("inv_inventaris_habispakai_kondisi",$dataupdate,$datakey)){
                    return true;
                }else{
                    return mysql_error();
                }
            }else{
                $values = array(
                    'id_mst_inv_barang_habispakai'  =>$this->input->post('id_mst_inv_barang_habispakai'),
                    'code_cl_phc'                   =>'P'.$this->session->userdata('puskesmas') ,
                    'tgl_update'=> date('Y-m-d'),
                    'jml_rusak' => $this->input->post('jml_rusak'),
                    'jml_tdkdipakai' => $this->input->post('jml_tdkdipakai'),
                );
                if($simpan=$this->db->insert('inv_inventaris_habispakai_kondisi', $values)){
                    return true;
                }else{
                    return mysql_error();
                }
            }
            
    }
}