<?php
class Datakeluarga_model extends CI_Model {

    var $tabel    = 'data_keluarga';
    var $lang     = '';

    function __construct() {
        parent::__construct();
        $this->lang   = $this->config->item('language');
    }
    
    function get_data($start=0,$limit=999999,$options=array()){
        $this->db->select("$this->tabel.*,cl_village.value");
		$this->db->join('cl_village', "data_keluarga.id_desa = cl_village.code",'inner');

		$this->db->order_by('data_keluarga.tanggal_pengisian','asc');
		$query =$this->db->get($this->tabel,$limit,$start);
        
        return $query->result();
    }

    function get_data_row($id){
        $data = array();
        $options = array('id_data_keluarga' => $id);
        $query = $this->db->get_where($this->tabel,$options);
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }

        $query->free_result();    
        return $data;
    }
    
    public function getSelectedData($table,$data){
        return $this->db->get_where($table, array('code'=>$data));
    }
    
    function insertDataTable(){
        $id_data_keluarga = $this->input->post('id_data_keluarga');
        $kode = $this->input->post('kode');
        $value = $this->input->post('value');
        $this->db->select('*');
        $this->db->from('data_profile');
        $this->db->where('id', 'D');
        $this->db->where('id_data_keluarga', $id_data_keluarga);
        $this->db->where('kode', $kode);
        $query = $this->db->get();
        if($query->num_rows() == 1){
            $this->db->query("update data_profile set value='$value' where id='D' and id_data_keluarga='$id_data_keluarga' and kode='$kode'")->result();
         }else{
            $data=array(
                        'id' => 'D',
                        'id_data_keluarga'=> $id_data_keluarga,
                        'kode'=>$kode,
                        'value'=>$value,
                        );
            $this->db->insert('data_profile',$data);
         }
    }
    
   function insert_entry(){
        $data=array(
            'tanggal_pengisian'=>$this->input->post('tgl_pengisian'),
            'jam_data'=>$this->input->post('jam_data'),
            'alamat'=>$this->input->post('alamat'),
            'id_propinsi'=>$this->input->post('provinsi'),
            'id_kota'=>$this->input->post('kota'),
            'id_kecamatan'=>$this->input->post('id_kecamatan'),
            'id_desa'=>$this->input->post('kelurahan'),
            'rw'=>$this->input->post('dusun'),
            'rt'=>$this->input->post('rt'),
            'norumah'=>$this->input->post('norumah'),
            'nokeluarga'=>$this->input->post('nokeluarga'),
            'nourutkel'=>$this->input->post('nourutkel'),
            'id_kodepos'=>$this->input->post('kodepos'),
            'nama_komunitas'=>$this->input->post('namakomunitas'),
            'namakepalakeluarga'=>$this->input->post('namakepalakeluarga'),
            'notlp'=>$this->input->post('notlp'),
            'namadesawisma'=>$this->input->post('namadesawisma'),
            'id_pkk'=>$this->input->post('jabatanstuktural'),
        );
        if($this->db->insert('data_keluarga',$data)){
            return $this->db->insert_id();
        }else{
            return mysql_error();
        }

    }

    function update_entry($kode){
        $data=array(
            'id_data_keluarga'=>$this->input->post('id_data_keluarga'),
            'alamat'=>$this->input->post('alamat'),
            'id_propinsi'=>$this->input->post('provinsi'),
            'id_kota'=>$this->input->post('kota'),
            'id_kecamatan'=>$this->input->post('id_kecamatan'),
            'id_desa'=>$this->input->post('kelurahan'),
            'rw'=>$this->input->post('dusun'),
            'rt'=>$this->input->post('rt'),
            'norumah'=>$this->input->post('norumah'),
            'nokeluarga'=>$this->input->post('nokeluarga'),
            'nourutkel'=>$this->input->post('nourutkel'),
            'id_kodepos'=>$this->input->post('kodepos'),
            'nama_komunitas'=>$this->input->post('namakomunitas'),
            'namakepalakeluarga'=>$this->input->post('namakepalakeluarga'),
            'notlp'=>$this->input->post('notlp'),
            'namadesawisma'=>$this->input->post('namadesawisma'),
            'id_pkk'=>$this->input->post('jabatanstuktural'),
        );
        if($this->db->update('data_keluarga',$data,array('id_data_keluarga' => $this->input->post('id_data_keluarga')))){
            return true;
        }else{
            return mysql_error();
        }
    }
    
    function get_data_profile($id){
        $this->db->select('*');
        $this->db->from('data_profile');
        $this->db->where('id', 'D');
        $this->db->where('id_data_keluarga', $id);
        $query = $this->db->get();
        if($query->num_rows() >= 1){
            return $query->result(); 
         }else{
            return 'salah';
         }
    }

    function delete_entry($kode){
        $this->db->where('id_data_keluarga',$kode);

        return $this->db->delete($this->tabel);
    }
    
    function get_desa($kecamatan){
        $query = $this->db->query("SELECT * FROM cl_village WHERE code LIKE '".$kecamatan."%'");
        
        return $query->result();
    }
    
    function get_pos($kecamatan){
        $query = $this->db->query("SELECT distinct pos FROM cl_village WHERE code LIKE '".$kecamatan."%' ORDER BY pos ASC");
        
        return $query->result();
    }
    
    function get_pkk(){
        $this->db->order_by('id_pkk','asc');
        $query = $this->db->get('mas_pkk');
        
        return $query->result();
    }
    
    function get_pkk_value($id){
        $query = $this->db->get_where('mas_pkk',array('id_pkk'=>$id));
        
        return $query->row_array();
    }
}