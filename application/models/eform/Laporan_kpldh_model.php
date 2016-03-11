<?php
class Laporan_kpldh_model extends CI_Model {

    var $tabel    = 'data_keluarga';
    var $lang     = '';

    function __construct() {
        parent::__construct();
        $this->lang   = $this->config->item('language');
    }
    
    public function get_jum_kelamin($kecamatan=0,$kelurahan=0,$rw=0)
    {
        if ($kecamatan!=0) {
            $this->db->where("id_kecamatan",$kecamatan);
        }
        if ($kelurahan!=0) {
            $this->db->where("id_desa",$kelurahan);
        }
        if ($rw!=0) {
            $this->db->where("rw",$rw);
        }
        $this->db->select("cl_kec.nama as nama_kecamatan,mst_keluarga_pilihan.value as kelamin, COUNT(data_keluarga_anggota.id_pilihan_kelamin) as jumlah");
        $this->db->join("data_keluarga","data_keluarga_anggota.id_data_keluarga = data_keluarga.id_data_keluarga");
        $this->db->join("mst_keluarga_pilihan",'data_keluarga_anggota.id_pilihan_kelamin = mst_keluarga_pilihan.id_pilihan AND tipe="jk"');
        $this->db->join("cl_kec",'data_keluarga.id_kecamatan = cl_kec.code');
        $query = $this->db->get('data_keluarga_anggota');
        return $query->result();
        
    }

}