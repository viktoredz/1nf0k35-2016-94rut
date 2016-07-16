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

    function jurnal_transaksi_add_debit($id_mst_transaksi=0){

        $data['type']                    = "debit";
        $data['urutan']                  = $this->input->post('urutan');
        $data['group']                   = $this->input->post('group');
        $data['id_mst_transaksi']        = $id_mst_transaksi;
        $data['id_mst_akun']             = '1';

        if($this->db->insert('mst_keu_transaksi_item', $data)){
           $lastInsertedID = $this->db->insert_id();
           $group = $this->input->post('group');
            return $lastInsertedID."|".$group;
        }else{
            return mysql_error();
        }
    }

    function jurnal_transaksi_add_kredit($id_mst_transaksi=0){

        $data['type']                       = "kredit";
        $data['urutan']                     = $this->input->post('urutan');
        $data['group']                      = $this->input->post('group');
        $data['id_mst_transaksi']           = $id_mst_transaksi;
        $data['id_mst_akun']                = '1';
        $data['id_mst_transaksi_item_from'] = $this->input->post('id_mst_transaksi_item_from');


        if($this->db->insert('mst_keu_transaksi_item', $data)){
           $lastInsertedID = $this->db->insert_id();
           $group = $this->input->post('group');
            return $lastInsertedID."|".$group;
        }else{
            return mysql_error();
        }
    }

    function get_data_kredit($id_mst_transaksi=0){
        $this->db->select('*');
        $this->db->where('id_mst_transaksi',$id_mst_transaksi);
        $this->db->where('type','kredit');
        $this->db->order_by('urutan','asc');
        $query = $this->db->get('mst_keu_transaksi_item');

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->group][] = $row;
            }
            return $data;
        }
        $query->free_result();
    }


    function get_data_debit($id_mst_transaksi=0){
        $data = array();
        $this->db->select('*');
        $this->db->where('id_mst_transaksi',$id_mst_transaksi);
        $this->db->where('type','debit');
        $this->db->order_by('urutan','asc');
        $query = $this->db->get('mst_keu_transaksi_item');

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[$row->group][] = $row;
            }
            return $data;
        }
        $query->free_result();
    }

    function get_data_jurnal_transaksi($id_mst_transaksi=0){
        $this->db->select('*');
        $this->db->where('id_mst_transaksi',$id_mst_transaksi);
        $this->db->group_by('id_mst_transaksi,`group`');
        $query = $this->db->get('mst_keu_transaksi_item');
        return $query->result();
    }

    function get_data_nilai_debit($id_mst_transaksi=0){
        $data = array();
        $this->db->select('mst_keu_transaksi_item.id_mst_akun, mst_keu_akun.uraian,mst_keu_transaksi_item.group');
        $this->db->join("mst_keu_akun","mst_keu_akun.id_mst_akun=mst_keu_transaksi_item.id_mst_akun");
        $this->db->where('id_mst_transaksi',$id_mst_transaksi);
        $this->db->where('type','debit');
        $query = $this->db->get('mst_keu_transaksi_item');

        if ($query->num_rows()>0) {
              foreach ($query->result() as $row) {
                $data[$row->group][] = $row;
              }
              return $data;
        }
        $query->free_result();
    }

    function get_data_urutan_debit($id_mst_transaksi=0,$start=0,$limit=1,$options=array()){
        $this->db->select('max(urutan) as urutan');
        $this->db->where('id_mst_transaksi',$id_mst_transaksi);
        $this->db->where('type','debit');
        $this->db->order_by('urutan','desc');
        $query = $this->db->get('mst_keu_transaksi_item',$limit);
        return $query->result();
    }

    function get_data_urutan_kredit($id_mst_transaksi=0,$start=0,$limit=1,$options=array()){
        $this->db->select('max(urutan) as urutan');
        $this->db->where('id_mst_transaksi',$id_mst_transaksi);
        $this->db->where('type','kredit');
        $this->db->order_by('urutan','desc');
        $query = $this->db->get('mst_keu_transaksi_item',$limit);
        return $query->result();
    }

    function get_data_group($id_mst_transaksi=0,$start=0,$limit=1,$options=array()){
        $this->db->select('max(`group`) as `group`');
        $this->db->where('id_mst_transaksi',$id_mst_transaksi);
        $this->db->order_by('`group`','desc');
        $query = $this->db->get('mst_keu_transaksi_item',$limit);
        return $query->result();
    }

    function jurnal_transaksi_pasangan_add($id_mst_transaksi=0){

        $data = array(
           array(
              '`group`'          => $this->input->post('group'),
              'id_mst_transaksi' => $id_mst_transaksi,
              'urutan'           => '1',
              'id_mst_akun'      => '1',
              'value'            => '0',
              'type'             => 'debit'
           ),
           array(
              '`group`'          => $this->input->post('group'),
              'id_mst_transaksi' => $id_mst_transaksi,
              'urutan'           => '1',
              'id_mst_akun'      => '1',
              'value'            => '100',
              'type'             => 'kredit'
           )
        );  

        if($this->db->insert_batch('mst_keu_transaksi_item',$data)){
             $first_id = $this->db->insert_id();
             $count = count($data);
             $last_id = $first_id + ($count-1);
             $group = $this->input->post('group');
             $value_k = 100;
            return $first_id."|".$last_id."|".$group."|".$value_k;
        }else{
            return mysql_error();
        }
    }

    function jurnal_transaksi_delete(){

        $this->db->where('`group`',$this->input->post('group'));

        return $this->db->delete('mst_keu_transaksi_item');
    }

    function jurnal_transaksi_delete_debit(){
        $this->db->where('id_mst_transaksi_item',$this->input->post('id_mst_transaksi_item'));

        return $this->db->delete('mst_keu_transaksi_item');
    }

    function jurnal_transaksi_delete_kredit(){
        $this->db->where('id_mst_transaksi_item',$this->input->post('id_mst_transaksi_item'));

        return $this->db->delete('mst_keu_transaksi_item');
    }


    function jurnal_transaksi_update_debit($id=0){
       
            $data['id_mst_transaksi']                      = $id;
            $data_akun['id_mst_akun']                      = $this->input->post('id_mst_akun');
            $data_auto['auto_fill']                        = $this->input->post('auto_fill');
            $data_opsional['opsional']                     = $this->input->post('opsional');
            $data_item_from['id_mst_transaksi_item_from']  = $this->input->post('id_mst_transaksi_item_from');


        if ($data_akun['id_mst_akun'] > 0){

            foreach ($data as $id=>$value){

                $up_data = array(
                        array(
                            'id_mst_transaksi_item'=>$this->input->post('id_mst_transaksi_item'),
                            'id_mst_akun'=>$data_akun['id_mst_akun'],
                            'id_mst_transaksi_item_from' => '0'
                        ),
                        array(
                            'id_mst_transaksi_item'=>$this->input->post('id_mst_transaksi_item_kredit'),
                            'id_mst_transaksi_item_from'=>$data_item_from['id_mst_transaksi_item_from']
                        )
                    );
            }

            if (count($up_data) == 0)
                return FALSE;

            $this->db->update_batch('mst_keu_transaksi_item', $up_data, 'id_mst_transaksi_item');
 
            if ($this->db->affected_rows() > 0){
                return TRUE;
            }else{
                return FALSE;
            }

        }elseif ($data_opsional['opsional'] > -1) {

            $this->db->set('opsional', $data_opsional['opsional']);     
            $this->db->where('id_mst_transaksi_item',$this->input->post('id_mst_transaksi_item'));
            $this->db->where('id_mst_transaksi',$id);
            $this->db->where('type','debit');

            if($this->db->update('mst_keu_transaksi_item')){
                return true;
            }else{
                return mysql_error();
            }

        }else{

            $this->db->set('auto_fill', $data_auto['auto_fill']); 
            $this->db->where('id_mst_transaksi_item',$this->input->post('id_mst_transaksi_item'));
            $this->db->where('id_mst_transaksi',$id);
            $this->db->where('type','debit');

            if($this->db->update('mst_keu_transaksi_item')){
                return true;
            }else{
                return mysql_error();
            }
        }
    }

    function jurnal_transaksi_update_kredit($id=0){
       
            $data['id_mst_transaksi']                       = $id;
            $data_opsional['opsional']                      = $this->input->post('opsional');
            $data_akun['id_mst_akun']                       = $this->input->post('id_mst_akun');
            $data_auto['auto_fill']                         = $this->input->post('auto_fill');
            $data_value['value']                            = $this->input->post('value');

        if( $data_akun['id_mst_akun']  > 0){
        
            $this->db->set('id_mst_akun', $data_akun['id_mst_akun']);  
            $this->db->where('id_mst_transaksi_item',$this->input->post('id_mst_transaksi_item'));
            $this->db->where('id_mst_transaksi',$id);
            $this->db->where('type','kredit');

            if($this->db->update('mst_keu_transaksi_item')){
                return true;
            }else{
                return mysql_error();
            }

        }elseif ($data_value['value'] > 0) {

            $this->db->set('value', $data_value['value']); 
            $this->db->where('id_mst_transaksi_item',$this->input->post('id_mst_transaksi_item'));
            $this->db->where('id_mst_transaksi',$id);
            $this->db->where('type','kredit');

            if($this->db->update('mst_keu_transaksi_item')){
                return true;
            }else{
                return mysql_error();
            }    

        }elseif ($data_opsional['opsional'] > -1) {

            $this->db->set('opsional', $data_opsional['opsional']); 
            $this->db->where('id_mst_transaksi_item',$this->input->post('id_mst_transaksi_item'));
            $this->db->where('id_mst_transaksi',$id);
            $this->db->where('type','kredit');

            if($this->db->update('mst_keu_transaksi_item')){
                return true;
            }else{
                return mysql_error();
            }

        } else {

            $this->db->set('auto_fill', $data_auto['auto_fill']);  
            $this->db->where('id_mst_transaksi_item',$this->input->post('id_mst_transaksi_item'));
            $this->db->where('id_mst_transaksi',$id);
            $this->db->where('type','kredit');

            if($this->db->update('mst_keu_transaksi_item')){
                return true;
            }else{
                return mysql_error();
            }
        }
    }

    function transaksi_insert(){
        $data_transaksi = array(
          'nama'                        => $this->input->post('nama'),
          'deskripsi'                   => $this->input->post('deskripsi'),
          'untuk_jurnal'                => $this->input->post('untuk_jurnal'),
          'id_mst_kategori_transaksi'   => $this->input->post('id_mst_kategori_transaksi'),
          'bisa_diubah'                 => 0,
          'jumlah_transaksi'            => 0
        );   

        if($this->db->insert('mst_keu_transaksi', $data_transaksi)){
           $lastInsertedID = $this->db->insert_id();

            $data_transaksi_item = array(
               array(
                  'id_mst_transaksi' => $lastInsertedID,
                  'urutan'           => 1,
                  '`group`'          => 1,
                  'id_mst_akun'      => 1,
                  'type'             => 'debit'
               ),
               array(
                  'id_mst_transaksi' => $lastInsertedID,
                  'urutan'           => 1,
                  '`group`'          => 1,
                  'id_mst_akun'      => 1,
                  'type'             => 'kredit'
               )
            ); 
           
           $this->db->insert_batch('mst_keu_transaksi_item',$data_transaksi_item);
            
            return $lastInsertedID;
        }else{
            return mysql_error();
        }
    }

    function delete_transaksi($id){
        $this->db->delete('mst_keu_transaksi', array('id_mst_transaksi' => $id));
        $this->db->delete('mst_keu_transaksi_setting', array('id_mst_transaksi' => $id));
        $this->db->delete('mst_keu_transaksi_item', array('id_mst_transaksi' => $id));

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