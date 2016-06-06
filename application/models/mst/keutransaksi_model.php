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

    function get_data_kategori_transaksi_template($id){

        $this->db->select('id_mst_setting_transaksi, nilai');
        $this->db->where('id_mst_kategori_transaksi',$id);
        $query = $this->db->get('mst_keu_kategori_transaksi_setting');
        return $query->result();
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
        $this->db->select('mst_keu_transaksi.*,mst_keu_kategori_transaksi.nama as kategori');
        $this->db->join('mst_keu_kategori_transaksi','mst_keu_kategori_transaksi.id_mst_kategori_transaksi=mst_keu_transaksi.id_mst_kategori_transaksi','left');
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

    function jurnal_transaksi_add_debit(){

        $data['type']                    = "debit";
        $data['value']                   = 99;
        $data['urutan']                  = $this->input->post('urutan');

        if($this->db->insert('mst_keu_transaksi_item', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function jurnal_transaksi_add_kredit(){

        $data['type']                    = "kredit";
        $data['value']                   = 98;
        $data['urutan']                  = $this->input->post('urutan');
        $data['id_mst_transaksi']        = $this->input->post('id_mst_transaksi');

        if($this->db->insert('mst_keu_transaksi_item', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function jurnal_transaksi_add(){

        $data = array(
           array(
              '`group`'      => $this->input->post('group'),
              'type'         => 'debit'
           ),
           array(
              '`group`'      => $this->input->post('group'),
              'type'         => 'kredit'
           )
        );  

        if($this->db->insert_batch('mst_keu_transaksi_item',$data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function jurnal_transaksi_update($id){
       
        // $data = array(
        //    array(
        //       'id_mst_transaksi'   => $this->input->post('id_mst_transaksi'),
        //       'id_mst_akun'        => $this->input->post('id_mst_akun'),
        //       'value'              => $this->input->post('value')
        //    ),
        //    array(
        //       'id_mst_transaksi'   => $this->input->post('id_mst_transaksi'),
        //       'id_mst_akun'        => $this->input->post('id_mst_akun'),
        //       'value'              => $this->input->post('value')
        //    )
        // );
        
        $data['id_mst_transaksi']        = $this->input->post('id_mst_transaksi');
        $data['id_mst_akun']             = $this->input->post('id_mst_akun');
        $data['value']                   = $this->input->post('value');
        
        $this->db->where('id_mst_transaksi_item',$id);

        if($this->db->update('mst_keu_transaksi_item', $data)){
            return true;
        }else{
            return mysql_error();
        }
    }

    function transaksi_insert(){

        $data['nama']                               = $this->input->post('nama');
        $data['deskripsi']                          = $this->input->post('deskripsi');
        $data['untuk_jurnal']                       = $this->input->post('untuk_jurnal');
        $data['id_mst_kategori_transaksi']          = $this->input->post('id_mst_kategori_transaksi');
        $data['bisa_diubah']                        = 0;
        $data['jumlah_transaksi']                   = 0;
        if($this->db->insert('mst_keu_transaksi', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function delete_transaksi($id){

        $this->db->where('id_mst_transaksi',$id);

        return $this->db->delete('mst_keu_transaksi');
    }

    function transaksi_update($id){
       
        $data['nama']                               = $this->input->post('nama');
        $data['deskripsi']                          = $this->input->post('deskripsi');
        $data['untuk_jurnal']                       = $this->input->post('untuk_jurnal');
        $data['id_mst_kategori_transaksi']          = $this->input->post('id_mst_kategori_transaksi');
        
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

     function transaksi_otomatis_insert(){

        $data['nama']                               = $this->input->post('nama');
        $data['deskripsi']                          = $this->input->post('deskripsi');
        $data['untuk_jurnal']                       = $this->input->post('untuk_jurnal');
        $data['id_mst_kategori_transaksi']          = $this->input->post('id_mst_kategori_transaksi');
        $data['waktu']                              = date('Y-m-d H:i:s');;
        if($this->db->insert('mst_keu_otomasi_transaksi', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }
    


    function delete_transaksi_otomatis($id){
        $this->db->where('id_mst_otomasi_transaksi',$id);

        return $this->db->delete('mst_keu_otomasi_transaksi');
    }

    function transaksi_otomatis_update($id){

        $data['nama']                               = $this->input->post('nama');
        $data['deskripsi']                          = $this->input->post('deskripsi');
        $data['untuk_jurnal']                       = $this->input->post('untuk_jurnal');
        $data['id_mst_kategori_transaksi']          = $this->input->post('id_mst_kategori_transaksi');
       
        $this->db->where('id_mst_otomasi_transaksi',$id);

        if($this->db->update('mst_keu_otomasi_transaksi', $data)){
            return true;
        }else{
            return mysql_error();
        }
    }

    function get_data_template_kat_trans($id_mst_kategori_transaksi=0){
        $this->db->select('mst_keu_setting_transaksi_template.*,mst_keu_kategori_transaksi_setting.id_mst_kategori_transaksi',false);
        $this->db->join("mst_keu_kategori_transaksi_setting","mst_keu_kategori_transaksi_setting.id_mst_kategori_transaksi=".$id_mst_kategori_transaksi." AND mst_keu_kategori_transaksi_setting.id_mst_setting_transaksi=mst_keu_setting_transaksi_template.id_mst_setting_transaksi_template","LEFT");
        $this->db->order_by('id_mst_setting_transaksi_template','asc');
        $query = $this->db->get('mst_keu_setting_transaksi_template');
        
         return $query->result();
    }


    function get_data_template_trans($id_mst_transaksi=0){
        $this->db->select('mst_keu_setting_transaksi_template.*,mst_keu_transaksi_setting.id_mst_transaksi',false);
        $this->db->join("mst_keu_transaksi_setting","mst_keu_transaksi_setting.id_mst_transaksi=".$id_mst_transaksi." AND mst_keu_transaksi_setting.id_mst_setting_transaksi=mst_keu_setting_transaksi_template.id_mst_setting_transaksi_template","LEFT");
        $this->db->order_by('id_mst_setting_transaksi_template','asc');
        $query = $this->db->get('mst_keu_setting_transaksi_template');
        
         return $query->result();
    }

    function get_data_template_trans_otomatis($id_mst_keu_otomasi_transaksi=0){
        $this->db->select('mst_keu_setting_transaksi_template.*,mst_keu_otomasi_transaksi_setting.id_mst_keu_otomasi_transaksi',false);
        $this->db->join("mst_keu_otomasi_transaksi_setting","mst_keu_otomasi_transaksi_setting.id_mst_keu_otomasi_transaksi=".$id_mst_keu_otomasi_transaksi." AND mst_keu_otomasi_transaksi_setting.id_mst_setting_transaksi=mst_keu_setting_transaksi_template.id_mst_setting_transaksi_template","LEFT");
        $this->db->order_by('id_mst_setting_transaksi_template','asc');
        $query = $this->db->get('mst_keu_setting_transaksi_template');
        
         return $query->result();
    }

    function get_data_akun(){
        $this->db->select('*',false);
        $this->db->order_by('id_mst_akun','asc');
        $query = $this->db->get('mst_keu_akun');
        
         return $query->result();
    }


    function kategori_trans_template_update($id){
        $data['id_mst_kategori_transaksi']   = $id;
        $data['id_mst_setting_transaksi']    = $this->input->post('template');

        $query = $this->db->get_where('mst_keu_kategori_transaksi_setting',$data);
        if ($query->num_rows() > 0) {
            $this->db->delete('mst_keu_kategori_transaksi_setting', $data);
        }else{
            $this->db->insert('mst_keu_kategori_transaksi_setting', $data);
        }
    }

    function transaksi_template_update($id){
        $data['id_mst_transaksi']           = $id;
        $data['id_mst_setting_transaksi']   = $this->input->post('template');

        $query = $this->db->get_where('mst_keu_transaksi_setting',$data);
        if ($query->num_rows() > 0) {
            $this->db->delete('mst_keu_transaksi_setting', $data);
        }else{
            $this->db->insert('mst_keu_transaksi_setting', $data);
        }
    }

    function transaksi_otomatis_template_update($id){
        $data['id_mst_keu_otomasi_transaksi'] = $id;
        $data['id_mst_setting_transaksi']     = $this->input->post('template');

        $query = $this->db->get_where('mst_keu_otomasi_transaksi_setting',$data);
        if ($query->num_rows() > 0) {
            $this->db->delete('mst_keu_otomasi_transaksi_setting', $data);
        }else{
            $this->db->insert('mst_keu_otomasi_transaksi_setting', $data);
        }
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
        $data['deskripsi']     = $this->input->post('deskripsi');
        $data['aktif']         = $this->input->post('aktif');
    
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