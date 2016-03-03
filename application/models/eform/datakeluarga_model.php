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
        $this->db->from('data_keluarga_profile');
        $this->db->where('id', 'D');
        $this->db->where('id_data_keluarga', $id_data_keluarga);
        $this->db->where('kode', $kode);
        $query = $this->db->get();
        if($query->num_rows() == 1){
            $this->db->query("update data_keluarga_profile set value='$value' where id='D' and id_data_keluarga='$id_data_keluarga' and kode='$kode'")->result();
        }else{
            $data=array(
                        'id' => 'D',
                        'id_data_keluarga'=> $id_data_keluarga,
                        'kode'=>$kode,
                        'value'=>$value,
                        );
            $this->db->insert('data_keluarga_profile',$data);
        }
    }

    function getNourutkel($kelurahan){
        $this->db->where('id_desa', $kelurahan);
        $this->db->order_by('id_data_keluarga', 'DESC');
        $id = $this->db->get('data_keluarga')->row();

        if(empty($id->id_data_keluarga)){
            $data = array(
                'id_data_keluarga'  => $kelurahan."001",
                'nourutkel'         => "001"
            );            
        }else{
            $last_id = substr($id->id_data_keluarga, -3) + 1;
            $last_id = str_repeat("0",3-strlen($last_id)).$last_id;

            $data = array(
                'id_data_keluarga'  => $kelurahan.$last_id,
                'nourutkel'         => $last_id
            );            
        }

        return $data;
    }
    
    function insert_entry(){
        $id = $this->getNourutkel($this->input->post('kelurahan'));

        $data=array(
            'id_data_keluarga'  => $id['id_data_keluarga'],
            'nourutkel'         => $id['nourutkel'],
            'tanggal_pengisian' => date("Y-m-d", strtotime($this->input->post('tgl_pengisian'))),
            'jam_data'          => $this->input->post('jam_data'),
            'alamat'            => $this->input->post('alamat'),
            'id_propinsi'       => $this->input->post('provinsi'),
            'id_kota'           => $this->input->post('kota'),
            'id_kecamatan'      => $this->input->post('id_kecamatan'),
            'id_desa'           => $this->input->post('kelurahan'),
            'id_kodepos'        => $this->input->post('kodepos'),
            'rw'                => $this->input->post('dusun'),
            'rt'                => $this->input->post('rt'),
            'norumah'           => $this->input->post('norumah'),
            'nama_komunitas'    => $this->input->post('namakomunitas'),
            'namakepalakeluarga'=> $this->input->post('namakepalakeluarga'),
            'notlp'             => $this->input->post('notlp'),
            'namadesawisma'     => $this->input->post('namadesawisma'),
            'id_pkk'            => $this->input->post('jabatanstuktural'),
        );
        if($this->db->insert('data_keluarga',$data)){
            return $id['id_data_keluarga'];
        }else{
            return mysql_error();
        }

    }

    function update_entry($id_data_keluarga){
        $data=array(
            'alamat'            => $this->input->post('alamat'),
            'id_kodepos'        => $this->input->post('kodepos'),
            'rw'                => $this->input->post('dusun'),
            'rt'                => $this->input->post('rt'),
            'norumah'           => $this->input->post('norumah'),
            'nama_komunitas'    => $this->input->post('namakomunitas'),
            'namakepalakeluarga'=> $this->input->post('namakepalakeluarga'),
            'notlp'             => $this->input->post('notlp'),
            'namadesawisma'     => $this->input->post('namadesawisma'),
            'id_pkk'            => $this->input->post('jabatanstuktural'),
            'nama_koordinator'  => $this->input->post('nama_koordinator'),
            'nama_pendata'      => $this->input->post('nama_pendata'),
            'jam_selesai'       => $this->input->post('jam_selesai')
        );
        if($this->db->update('data_keluarga',$data,array('id_data_keluarga' => $id_data_keluarga))){
            return true;
        }else{
            return mysql_error();
        }
    }
    
    function get_data_profile($id){
        $this->db->select('*');
        $this->db->from('data_keluarga_profile');
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
    
    function get_provinsi($provinsi=""){
        if($provinsi==""){
            $provinsi = substr($this->session->userdata('puskesmas'),0,2);
        }

        $this->db->where('code',$provinsi);
        $query = $this->db->get("cl_province");
        
        return $query->result();
    }

    function get_kotakab($kotakab=""){
        if($kotakab==""){
            $kotakab = substr($this->session->userdata('puskesmas'),0,4);
        }

        $this->db->where('code',$kotakab);
        $query = $this->db->get("cl_district");
        
        return $query->result();
    }

    function get_kecamatan($kecamatan=""){
        if($kecamatan==""){
            $kecamatan = substr($this->session->userdata('puskesmas'),0,7);
        }

        $this->db->where('code',$kecamatan);
        $query = $this->db->get("cl_kec");
        
        return $query->result();
    }
    
    function get_desa($kecamatan=""){
        if($kecamatan==""){
            $kecamatan = substr($this->session->userdata('puskesmas'),0,7);
        }

        $this->db->like('code',$kecamatan);
        $query = $this->db->get("cl_village");
        
        return $query->result();
    }
    
    function get_pos($kecamatan=""){
        if($kecamatan==""){
            $kecamatan = substr($this->session->userdata('puskesmas'),0,7);
        }

        $this->db->select('distinct pos',false);
        $this->db->order_by('pos','ASC');

        $this->db->like('code',$kecamatan);
        $query = $this->db->get("cl_village");
        
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