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

    function get_data_kategori_transaksi_edit($id){
        $this->db->select('*',false);
        // $this->db->join('mst_keu_kategori_transaksi_setting','mst_keu_kategori_transaksi_setting.id_mst_kategori_transaksi=mst_keu_kategori_transaksi.id_mst_kategori_transaksi','left');
        $this->db->where('id_mst_kategori_transaksi',$id);
        $query = $this->db->get("mst_keu_kategori_transaksi");

        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
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

    function get_data_transaksi($start=0,$limit=999999,$options=array()){
        $this->db->select("mst_keu_transaksi.*,mst_keu_kategori_transaksi.id_mst_kategori_transaksi,mst_keu_kategori_transaksi.nama as kategori",false);
        $this->db->join("mst_keu_kategori_transaksi","mst_keu_kategori_transaksi.id_mst_kategori_transaksi=mst_keu_transaksi.id_mst_kategori_transaksi");
        $query = $this->db->get('mst_keu_transaksi',$limit,$start);
        return $query->result();
    }

    function get_data_transaksi_edit($id){
        $this->db->select('*',false);
        $this->db->join('mst_keu_transaksi_setting','mst_keu_transaksi_setting.id_mst_transaksi=mst_keu_transaksi.id_mst_transaksi','left');
        $this->db->where('mst_keu_transaksi.id_mst_transaksi',$id);
        $query = $this->db->get("mst_keu_transaksi");

        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
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

    function get_data_transaksi_otomatis($start=0,$limit=999999,$options=array()){
        $this->db->select("mst_keu_otomasi_transaksi.*,mst_keu_kategori_transaksi.nama as kategori",false);
        $this->db->join("mst_keu_kategori_transaksi","mst_keu_kategori_transaksi.id_mst_kategori_transaksi=mst_keu_otomasi_transaksi.id_mst_kategori_transaksi");
        $query = $this->db->get('mst_keu_otomasi_transaksi',$limit,$start);
        return $query->result();
    }

    function get_data_transaksi_otomatis_edit($id){
        $this->db->select('*',false);
        $this->db->join('mst_keu_otomasi_transaksi_setting','mst_keu_otomasi_transaksi_setting.id_mst_keu_otomasi_transaksi=mst_keu_otomasi_transaksi.id_mst_otomasi_transaksi','left');
        $this->db->where('mst_keu_otomasi_transaksi.id_mst_otomasi_transaksi',$id);
        $query = $this->db->get("mst_keu_otomasi_transaksi");

        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function get_data_template(){
         $this->db->select('*',false);
         $this->db->order_by('id_mst_setting_transaksi_template','asc');
         $query = $this->db->get('mst_keu_setting_transaksi_template');
        
         return $query->result();
    
    }

    // function get_data_template($id){
    //      $this->db->select('*',false);
    //      $this->db->join('mst_keu_kategori_transaksi_setting','mst_keu_kategori_transaksi_setting.id_mst_setting_transaksi=mst_keu_setting_transaksi_template.id_mst_setting_transaksi_template','left');
    //      $this->db->where('mst_keu_kategori_transaksi_setting.id_mst_kategori_transaksi',$id);
    //      $query = $this->db->get('mst_keu_setting_transaksi_template');
        
    //      return $query->result();
    
    // }

    function template_update($id){
        $data['nilai']      = $this->input->post('nilai');
       
        $this->db->where('id_mst_kategori_transaksi_setting',$id);

        if($this->db->update('mst_keu_kategori_transaksi_setting', $data)){
            $this->db->where('id_mst_kategori_transaksi_setting',$id);
            $this->db->select('nilai');
            $variable = $this->db->get('mst_keu_kategori_transaksi_setting');
            foreach ($variable->result() as $key) {
                if ($key->nilai=='1') {
                    return '1';
                }else{
                    return '2';    
                }
            }
        }else{
            return mysql_error();
        }
    }

    function aktifkan_status($id) {

        $kodepusk = 'P'.$this->session->userdata('puskesmas');

        $this->db->where('id_mst_setting_transaksi',$id);
        $this->db->select('nilai');

        $q = $this->db->get('mst_keu_kategori_transaksi_setting');

        if ( $q->num_rows() > 0 ) {
            if($q->nilai > 0){
            
            $pk   = array('id_mst_setting_transaksi'=>$kodepusk);
            $data = array('nilai'=>'0');

            $this->db->update('mst_keu_kategori_transaksi_setting',$data,$pk);
            
            }else{

            $pk   = array('id_mst_setting_transaksi'=>$kodepusk);
            $data = array('nilai'=>'1');

            $this->db->update('mst_keu_kategori_transaksi_setting',$data,$pk);

            }
        
        } else {
            $data = array(
                'id_mst_setting_transaksi'=>$id,
                // 'id_mst_kategori_transaksi'=>,
                'nilai'=>'1');
            $this->db->insert('mst_keu_kategori_transaksi_setting',$data);
        }

         return $q->result();
    }

    function get_data_syarat_pembayaran($start=0,$limit=999999,$options=array()){
        $this->db->select("*",false);
        $this->db->order_by('id_mst_syarat_pembayaran','asc');
        $query = $this->db->get('mst_keu_syarat_pembayaran',$limit,$start);
        return $query->result();
    }

    function get_data_syarat_pembayaran_edit($id){
        $this->db->select('*',false);
        $this->db->where('id_mst_syarat_pembayaran',$id);
        $query = $this->db->get("mst_keu_syarat_pembayaran");

        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function insert_syarat_pembayaran(){
        $data['nama']          = $this->input->post('nama');
        $data['aktif']         = $this->input->post('aktif');
        $data['deskripsi']     = $this->input->post('deskripsi');
    
        if($this->db->insert('mst_keu_syarat_pembayaran', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function delete_syarat_pembayaran($id){
        $this->db->where('id_mst_syarat_pembayaran',$id);

        return $this->db->delete('mst_keu_syarat_pembayaran');
    }

    function update_syarat_pembayaran($id){
        $data['nama']          = $this->input->post('nama');
        $data['aktif']         = $this->input->post('aktif');
        $data['deskripsi']     = $this->input->post('deskripsi');

        $this->db->where('id_mst_syarat_pembayaran',$id);

        if($this->db->update('mst_keu_syarat_pembayaran', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function get_data_puskesmas($start=0,$limit=999999,$options=array()){
        $this->db->order_by('value','asc');
        $query = $this->db->get('cl_phc',$limit,$start);
        return $query->result();
    }

}