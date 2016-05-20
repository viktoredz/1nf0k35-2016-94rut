<?php
class Keutransaksi_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->lang   = $this->config->item('language');
    }


    function get_data_kategori_transaksi($start=0,$limit=999999,$options=array()){
        $this->db->select("*",false);
        $this->db->order_by('id_mst_kategori_transaksi','asc');
        $query = $this->db->get('mst_keu_kategori_transaksi',$limit,$start);
        return $query->result();
    }

    function get_data_transaksi($start=0,$limit=999999,$options=array()){
        $this->db->select("mst_keu_transaksi.*,mst_keu_kategori_transaksi.id_mst_kategori_transaksi,mst_keu_kategori_transaksi.nama as kategori",false);
        $this->db->join("mst_keu_kategori_transaksi","mst_keu_kategori_transaksi.id_mst_kategori_transaksi=mst_keu_transaksi.id_mst_kategori_transaksi");
        $query = $this->db->get('mst_keu_transaksi',$limit,$start);
        return $query->result();
    }

    function get_data_kategori_transaksi_edit($id){
        $this->db->select('*',false);
        $this->db->join('mst_keu_kategori_transaksi_setting','mst_keu_kategori_transaksi_setting.id_mst_kategori_transaksi=mst_keu_kategori_transaksi.id_mst_kategori_transaksi','left');
        $this->db->where('mst_keu_kategori_transaksi.id_mst_kategori_transaksi',$id);
        $query = $this->db->get("mst_keu_kategori_transaksi");

        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function get_data_transaksi_edit($id){
        $this->db->select('*',false);
        $this->db->join('mst_keu_kategori_transaksi_setting','mst_keu_kategori_transaksi_setting.id_mst_kategori_transaksi=mst_keu_kategori_transaksi.id_mst_kategori_transaksi','left');
        $this->db->where('mst_keu_kategori_transaksi.id_mst_kategori_transaksi',$id);
        $query = $this->db->get("mst_keu_kategori_transaksi");

        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }


    function get_data_transaksi_otomatis($start=0,$limit=999999,$options=array()){
        $this->db->select("mst_keu_otomasi_transaksi.*,mst_keu_kategori_transaksi.nama as kategori",false);
        $this->db->join("mst_keu_kategori_transaksi","mst_keu_kategori_transaksi.id_mst_kategori_transaksi=mst_keu_otomasi_transaksi.id_mst_kategori_transaksi");
        $query = $this->db->get('mst_keu_otomasi_transaksi',$limit,$start);
        return $query->result();
    }


    function update_kategori_transaksi($id){
        $data['nama']          = $this->input->post('nama');
        $data['deskripsi']     = $this->input->post('deskripsi');

        $this->db->where('id_mst_kategori_transaksi',$id);

        if($this->db->update('mst_keu_kategori_transaksi', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function insert_kategori_transaksi(){
        $data['nama']          = $this->input->post('nama');
        $data['deskripsi']     = $this->input->post('deskripsi');
    
        if($this->db->insert('mst_keu_kategori_transaksi', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function delete_kategori_transaksi($id){
        $this->db->where('id_mst_kategori_transaksi',$id);

        return $this->db->delete('mst_keu_kategori_transaksi');
    }

    function get_data_template(){
         $this->db->select('*');
         $query = $this->db->get('mst_keu_setting_transaksi_template');
        
         return $query->result();
    
    }

    function template_update($id){
        $data['nilai']         = $this->input->post('nilai');
       
        $this->db->where('id_mst_kategori_transaksi_setting',$id);

        if($this->db->update('mst_keu_kategori_transaksi_setting', $data)){
            return true;
        }else{
            return mysql_error();
        }
    }

    function template_insert(){
        $data['nilai'] = $this->input->post('nilai');

        if($this->db->insert('mst_keu_kategori_transaksi_setting', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function transaksi_insert(){
        $data['id_inv_hasbispakai_permintaan']      = $this->kode_pengadaan($this->input->post('kode_inventaris_'));
        $data['code_cl_phc']                        = $this->input->post('codepus');
        $data['id_mst_inv_barang_habispakai_jenis'] = $this->input->post('id_mst_inv_barang_habispakai_jenis');
        $data['tgl_permintaan']                     = date("Y-m-d",strtotime($this->input->post('tgl')));
        $data['status_permintaan']                  = $this->input->post('status');
        $data['keterangan']                         = $this->input->post('keterangan');
        $data['waktu_dibuat']                       = date('Y-m-d H:i:s');
        $data['terakhir_diubah']                    = "0000-00-00 00:00:00";
        $data['jumlah_unit']                        = 0;
        $data['nilai_pembelian']                    = 0;
        if($this->db->insert('mst_keu_transaksi', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function transaksi_update($id){
       
        $this->db->where('id_mst_transaksi',$id);

        if($this->db->update('mst_keu_transaksi', $data)){
            return true;
        }else{
            return mysql_error();
        }
    }






  
}