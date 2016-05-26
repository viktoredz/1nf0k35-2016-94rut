<?php
class Drh_model extends CI_Model {

    var $tabel    = 'pegawai';
    var $t_puskesmas = 'cl_phc';
    var $t_alamat = 'pegawai_alamat';
    var $t_diklat = 'pegawai_diklat';
    var $t_dp3    = 'pegawai_dp3';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }

    public function getItem($id=0,$tmt=0)
    {
        $ttm = explode("-", $tmt);
        $tgl = $ttm[2].'-'.$ttm[1].'-'.$ttm[0];
        $this->db->where('id_pegawai',$id);
        $this->db->where('tmt',$tgl);
        $query = $this->db->get('pegawai_pangkat');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }
        $query->free_result();    
        return $data;
    }

    function get_data($start=0,$limit=999999,$options=array())
    {
        $this->db->select("pangkat.nip_nit, pangkat.tmt,pegawai.*,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lhr)), '%Y')+0 AS usia",false);
        $this->db->join('(SELECT  id_pegawai, nip_nit, tmt FROM pegawai_pangkat WHERE tmt IN (SELECT  MAX(tmt) FROM pegawai_pangkat GROUP BY id_pegawai)) AS pangkat','pangkat.id_pegawai = pegawai.id_pegawai','left');
		$this->db->order_by('id_pegawai','asc');
        $query = $this->db->get('pegawai',$limit,$start);
        return $query->result();
    }

    function get_data_alamat($start=0,$limit=999999,$options=array())
    {
    	$this->db->select('*');
        $this->db->join('cl_province','pegawai_alamat.code_cl_province=cl_province.code ','value as propinsi','inner');
        $this->db->join('cl_district','pegawai_alamat.code_cl_district=cl_district.code ','value as kota','inner');
        $this->db->join('cl_kec','pegawai_alamat.code_cl_kec=cl_kec.code ','nama as kecamatan','inner');
        $this->db->join('cl_village','pegawai_alamat.code_cl_village=cl_village.code ','value as kelurahan','inner');
        $query = $this->db->get('pegawai_alamat',$limit,$start);
        return $query->result();
    }
    function masakerjaterakhir($id = 0){
        $data = array();
        $options = array('id_pegawai'=>$id);
        $this->db->select('masa_krj_bln,masa_krj_thn,tmt');
        $this->db->order_by('tmt','desc');
        $this->db->limit(1);
        $query = $this->db->get_where('pegawai_pangkat',$options);
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }else{
            $data['masa_krj_bln'] ='';
            $data['masa_krj_thn'] ='';
            $data['tmt'] ='';
        }

        $query->free_result();    
        return $data;
    }
    function get_data_alamat_id($id,$urut=0)
    {
		$data = array();
        $options = array('id_pegawai'=>$id,'urut' => $urut);
		$query = $this->db->get_where($this->t_alamat,$options);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
    }

 	function get_data_row($id){
		$data = array();
		$options = array('id_pegawai' => $id);
        $this->db->select("pegawai.*,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lhr)), '%Y')+0 AS usia,(SELECT nip_nit FROM pegawai_pangkat WHERE id_pegawai = pegawai.id_pegawai ORDER BY tmt DESC LIMIT 1) AS nip",false);
		$query = $this->db->get_where($this->tabel,$options);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

    function get_kode_diklat($tipe=""){
        if($tipe=="struktural"){
            $this->db->where('jenis','struktural');
        }else{
            $this->db->where('jenis <> ','struktural');
        }
        $this->db->select('*');
        $this->db->from('mst_peg_diklat');
        $this->db->order_by('nama_diklat','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_kode_rumpun(){
        $this->db->select('*');
        $this->db->from('mst_peg_rumpunpendidikan');
        $this->db->order_by('nama_rumpun','asc');
        $query = $this->db->get();
        return $query->result();
    }
    function kode_tabel($table=''){
        $this->db->select('*');
        $this->db->from("$table");
        $query = $this->db->get();
        return $query->result();
    }
    function get_tingkat_pendidikan(){
        $this->db->select('*');
        $this->db->from('mst_peg_tingkatpendidikan');
        $this->db->order_by('id_tingkat','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_tingkat($id_rumpun){
        $this->db->select('distinct id_tingkat,deskripsi',false);
        $this->db->from('mst_peg_tingkatpendidikan');
        $this->db->join('mst_peg_jurusan','mst_peg_jurusan.id_mst_peg_tingkatpendidikan=mst_peg_tingkatpendidikan.id_tingkat AND mst_peg_jurusan.id_mst_peg_rumpunpendidikan="'.$id_rumpun.'"');
        $this->db->order_by('mst_peg_tingkatpendidikan.id_tingkat','asc');
        $query = $this->db->get('');
        return $query->result();
    }

    function get_rumpun_tingkat($id_jurusan){
        $data = array();
        $this->db->where('id_jurusan',$id_jurusan);
        $query = $this->db->get('mst_peg_jurusan');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }
        return $data;
    }

    function get_jurusan($id_rumpun,$id_tingkat){
        $this->db->select('id_jurusan,nama_jurusan',false);
        $this->db->from('mst_peg_jurusan');
        $this->db->where('id_mst_peg_tingkatpendidikan',$id_tingkat);
        $this->db->where('id_mst_peg_rumpunpendidikan',$id_rumpun);
        $this->db->order_by('nama_jurusan','asc');
        $query = $this->db->get('');
        return $query->result();
    }

    function get_kode_keluarga($jenis,$kode_kel=0){
        switch ($jenis) {
            case 'ortu':
                $this->db->where('id_keluarga',3);
                $this->db->or_where('id_keluarga',4);
                break;
            case 'anak':
                $this->db->where('(id_keluarga =5 OR id_keluarga=6)');
                $this->db->or_where('id_keluarga',7);
                break;
            default:
                $this->db->where('id_keluarga',1);
                $this->db->or_where('id_keluarga',2);
                break;
        }
        $this->db->select('*');
        $this->db->from('mst_peg_keluarga');
        $this->db->order_by('nama_keluarga','asc');
        $query = $this->db->get();
        return $query->result();
    }

	function get_kode_agama($kode_ag=0){
		$this->db->select('*');
		$this->db->from('mst_agama');
        $this->db->order_by('value','asc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_kode_nikah($kode_nk=0){
		$this->db->select('*');
		$this->db->from('mst_peg_nikah');
        $this->db->order_by('value','asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function getSelectedData($table,$data)
    {
        return $this->db->get_where($table, array('id_pegawai'=>$data));
    }

    function getIdPegawai($tgl_lhr){
        $tgl = explode("-", $tgl_lhr);
        $id  = substr($this->session->userdata('puskesmas'),0,4).$tgl[2];

        $this->db->select('MAX(id_pegawai) AS id');
        $this->db->like('id_pegawai',$id);
        $query = $this->db->get('pegawai');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
            $lastid = substr($data['id'],8,4) + 1;

            return $id.str_repeat("0", (4-strlen($lastid))).$lastid;
        }else{
            return $id.'0001';
        }
    }

// CRUD pegawai
    function insert_entry()
    {
        $data['id_pegawai']     = $this->getIdPegawai($this->input->post('tgl_lhr'));
        $data['nik']            = $this->input->post('nik');
        $data['gelar_depan']    = $this->input->post('gelar_depan');
    	$data['gelar_belakang']	= $this->input->post('gelar_belakang');
    	$data['nama']			= $this->input->post('nama');
    	$data['jenis_kelamin'] 	= $this->input->post('jenis_kelamin');
    	$data['tgl_lhr']        = date("Y-m-d",strtotime($this->input->post('tgl_lhr')));
        $data['tmp_lahir']      = $this->input->post('tmp_lahir');
        $data['kode_mst_agama'] = $this->input->post('kode_mst_agama');
        $data['kedudukan_hukum']= $this->input->post('kedudukan_hukum');
        $data['alamat']         = $this->input->post('alamat');
        $data['npwp']           = $this->input->post('npwp');
        $data['npwp_tgl']       = date("Y-m-d",strtotime($this->input->post('npwp_tgl')));
        $data['kartu_pegawai']  = $this->input->post('kartu_pegawai');
    	$data['goldar']			= $this->input->post('goldar');
        $data['kode_mst_nikah'] = $this->input->post('kode_mst_nikah');
        $data['code_cl_phc']    = $this->input->post('codepus');

		if($this->db->insert($this->tabel, $data)){
			return $data['id_pegawai']; 
		}else{
			return mysql_error();
		}
    }

    function update_entry($id)
    {
        $data['nik']            = $this->input->post('nik');
        $data['gelar_depan']    = $this->input->post('gelar_depan');
        $data['gelar_belakang'] = $this->input->post('gelar_belakang');
        $data['nama']           = $this->input->post('nama');
        $data['jenis_kelamin']  = $this->input->post('jenis_kelamin');
        $data['tgl_lhr']        = date("Y-m-d",strtotime($this->input->post('tgl_lhr')));
        $data['tmp_lahir']      = $this->input->post('tmp_lahir');
        $data['kode_mst_agama'] = $this->input->post('kode_mst_agama');
        $data['kedudukan_hukum']= $this->input->post('kedudukan_hukum');
        $data['alamat']         = $this->input->post('alamat');
        $data['npwp']           = $this->input->post('npwp');
        $data['npwp_tgl']       = date("Y-m-d",strtotime($this->input->post('npwp_tgl')));
        $data['kartu_pegawai']  = $this->input->post('kartu_pegawai');
        $data['goldar']         = $this->input->post('goldar');
        $data['kode_mst_nikah'] = $this->input->post('kode_mst_nikah');

		if($this->db->update($this->tabel, $data, array("id_pegawai"=>$id))){
			return true;
		}else{
			return mysql_error();
		}
    }

    
    function delete_entry_alamat($id,$urut)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('urut',$urut);

        return $this->db->delete($this->t_alamat);
    }

	function delete_entry($id)
	{
		$this->db->where('id_pegawai',$id);

		return $this->db->delete($this->tabel);
	}

    function delete_entry_ortu($id,$urut)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('urut',$urut);

        return $this->db->delete('pegawai_keluarga');
    }

    function delete_entry_anak($id,$urut)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('urut',$urut);

        return $this->db->delete('pegawai_keluarga');
    }

    function delete_entry_pasangan($id,$urut)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('urut',$urut);

        return $this->db->delete('pegawai_keluarga');
    }

    function get_data_ortu($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("pegawai_keluarga.*,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0 AS usia,mst_peg_keluarga.nama_keluarga,IF(pegawai_keluarga.status_hidup=1,'Hidup','Meninggal') as hidup",false);
        $this->db->where('pegawai_keluarga.id_pegawai',$id);
        $this->db->where('(id_mst_peg_keluarga =3 OR id_mst_peg_keluarga =4)');
        $this->db->order_by('tgl_lahir','asc');
        $this->db->join('mst_peg_keluarga','mst_peg_keluarga.id_keluarga=pegawai_keluarga.id_mst_peg_keluarga');
        $query = $this->db->get('pegawai_keluarga',$limit,$start);
        return $query->result();
    }


    function get_data_pasangan($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("pegawai_keluarga.*,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0 AS usia,mst_peg_keluarga.nama_keluarga,IF(pegawai_keluarga.status_pns=1,'Ya','Tidak') as pns",false);
        $this->db->where('pegawai_keluarga.id_pegawai',$id);
        $this->db->where('(id_mst_peg_keluarga = 1 OR id_mst_peg_keluarga = 2)');
        $this->db->order_by('tgl_lahir','asc');
        $this->db->join('mst_peg_keluarga','mst_peg_keluarga.id_keluarga=pegawai_keluarga.id_mst_peg_keluarga');
        $query = $this->db->get('pegawai_keluarga',$limit,$start);
        return $query->result();
    }


    function get_data_anak($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("pegawai_keluarga.*,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lahir)), '%Y')+0 AS usia,mst_peg_keluarga.nama_keluarga,IF(pegawai_keluarga.status_pns=1,'Ya','Tidak') as pns",false);
        $this->db->where('pegawai_keluarga.id_pegawai',$id);
        $this->db->where('(id_mst_peg_keluarga = 5 OR id_mst_peg_keluarga = 6 OR id_mst_peg_keluarga= 7)');
        $this->db->order_by('tgl_lahir','asc');
        $this->db->join('mst_peg_keluarga','mst_peg_keluarga.id_keluarga=pegawai_keluarga.id_mst_peg_keluarga');
        $query = $this->db->get('pegawai_keluarga',$limit,$start);
        return $query->result();
    }

    function get_data_ortu_edit($id,$urut){
        $data = array();

        $this->db->select("*");
        $this->db->where("id_pegawai",$id);
        $this->db->where("urut",$urut);
        $query = $this->db->get("pegawai_keluarga");
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }


    function get_data_anak_edit($id,$urut){
        $data = array();

        $this->db->select("*");
        $this->db->where("id_pegawai",$id);
        $this->db->where("urut",$urut);
        $query = $this->db->get("pegawai_keluarga");
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }


    function get_data_pasangan_edit($id,$urut){
        $data = array();

        $this->db->select("*");
        $this->db->where("id_pegawai",$id);
        $this->db->where("urut",$urut);
        $query = $this->db->get("pegawai_keluarga");
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function get_data_pendidikan_formal_edit($id,$id_jurusan){
        $data = array();

        $this->db->select("*");
        $this->db->where("id_pegawai",$id);
        $this->db->where("id_mst_peg_jurusan",$id_jurusan);
        $query = $this->db->get("pegawai_pendidikan");
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function get_data_pendidikan_struktural_edit($id,$id_diklat){
        $data = array();

        $this->db->select("*");
        $this->db->where("id_pegawai",$id);
        $this->db->where("mst_peg_id_diklat",$id_diklat);
        $query = $this->db->get("pegawai_diklat");
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function get_data_pendidikan_fungsional_edit($id,$id_diklat){
        $data = array();

        $this->db->select("*");
        $this->db->where("id_pegawai",$id);
        $this->db->where("mst_peg_id_diklat",$id_diklat);
        $query = $this->db->get("pegawai_diklat");
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function insert_entry_ortu($id)
    {
        $data['id_pegawai']         = $id;
        $data['id_mst_peg_keluarga']= $this->input->post('id_mst_peg_keluarga');
        $data['nama']               = $this->input->post('nama');
        $data['jenis_kelamin']      = $this->input->post('jenis_kelamin');
        $data['tgl_lahir']          = date("Y-m-d",strtotime($this->input->post('tgl_lahir')));
        $data['code_cl_district']   = $this->input->post('code_cl_district');
        $data['bpjs']               = $this->input->post('bpjs');
        $data['status_hidup']       = $this->input->post('status_hidup');
        $data['status_pns']         = $this->input->post('status_pns');
        $data['akta_menikah']       = $this->input->post('akta_menikah');
        $data['akta_meninggal']     = $this->input->post('akta_meninggal');
        $data['akta_cerai']         = $this->input->post('akta_cerai');


        $this->db->select('MAX(urut) as urut');
        $this->db->where('id_pegawai',$id);
        $urut = $this->db->get('pegawai_keluarga')->row();
        if(!empty($urut->urut)){
          $data['urut'] = $urut->urut+1;
        }else{
          $data['urut'] = 1;
        }

        if($this->db->insert('pegawai_keluarga', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function insert_entry_anak($id)
    {
        $data['id_pegawai']                   = $id;
        $data['id_mst_peg_keluarga']          = $this->input->post('id_mst_peg_keluarga');
        $data['id_mst_peg_tingkatpendidikan'] = $this->input->post('id_mst_peg_tingkatpendidikan');
        $data['nama']                         = $this->input->post('nama');
        $data['jenis_kelamin']                = $this->input->post('jenis_kelamin');
        $data['tgl_lahir']                    = date("Y-m-d",strtotime($this->input->post('tgl_lahir')));
        $data['code_cl_district']             = $this->input->post('code_cl_district');
        $data['bpjs']                         = $this->input->post('bpjs');
        $data['status_pns']                   = $this->input->post('status_pns');

        $this->db->select('MAX(urut) as urut');
        $this->db->where('id_pegawai',$id);
        $urut = $this->db->get('pegawai_keluarga')->row();
        if(!empty($urut->urut)){
          $data['urut'] = $urut->urut+1;
        }else{
          $data['urut'] = 1;
        }

        if($this->db->insert('pegawai_keluarga', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function insert_entry_pasangan($id)
    {
        $data['id_pegawai']         = $id;
        $data['id_mst_peg_keluarga']= $this->input->post('id_mst_peg_keluarga');
        $data['nama']               = $this->input->post('nama');
        $data['jenis_kelamin']      = $this->input->post('jenis_kelamin');
        $data['tgl_lahir']          = date("Y-m-d",strtotime($this->input->post('tgl_lahir')));
        $data['code_cl_district']   = $this->input->post('code_cl_district');
        $data['bpjs']               = $this->input->post('bpjs');
        $data['status_hidup']       = $this->input->post('status_hidup');
        $data['status_pns']         = $this->input->post('status_pns');
        $data['akta_menikah']       = $this->input->post('akta_menikah');
        $data['akta_meninggal']     = $this->input->post('akta_meninggal');
        $data['akta_cerai']         = $this->input->post('akta_cerai');
        $data['tgl_menikah']        = date("Y-m-d",strtotime($this->input->post('tgl_menikah')));
        $data['tgl_meninggal']      = date("Y-m-d",strtotime($this->input->post('tgl_meninggal')));
        $data['tgl_cerai']          = date("Y-m-d",strtotime($this->input->post('tgl_cerai')));
        $data['status_menikah']     = $this->input->post('status_menikah');

        $this->db->select('MAX(urut) as urut');
        $this->db->where('id_pegawai',$id);
        $urut = $this->db->get('pegawai_keluarga')->row();
        if(!empty($urut->urut)){
          $data['urut'] = $urut->urut+1;
        }else{
          $data['urut'] = 1;
        }

        if($this->db->insert('pegawai_keluarga', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function update_entry_ortu($id,$urut)
    {
        $data['id_mst_peg_keluarga']= $this->input->post('id_mst_peg_keluarga');
        $data['nama']               = $this->input->post('nama');
        $data['jenis_kelamin']      = $this->input->post('jenis_kelamin');
        $data['tgl_lahir']          = date("Y-m-d",strtotime($this->input->post('tgl_lahir')));
        $data['code_cl_district']   = $this->input->post('code_cl_district');
        $data['bpjs']               = $this->input->post('bpjs');
        $data['status_hidup']       = $this->input->post('status_hidup');
        $data['status_pns']         = $this->input->post('status_pns');

        $this->db->where('id_pegawai',$id);
        $this->db->where('urut',$urut);

        if($this->db->update('pegawai_keluarga', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function update_entry_anak($id,$urut)
    {
        $data['id_mst_peg_keluarga']            = $this->input->post('id_mst_peg_keluarga');
        $data['id_mst_peg_tingkatpendidikan']   = $this->input->post('id_mst_peg_tingkatpendidikan');
        $data['nama']                           = $this->input->post('nama');
        $data['jenis_kelamin']                  = $this->input->post('jenis_kelamin');
        $data['tgl_lahir']                      = date("Y-m-d",strtotime($this->input->post('tgl_lahir')));
        $data['code_cl_district']               = $this->input->post('code_cl_district');
        $data['bpjs']                           = $this->input->post('bpjs');
        $data['status_pns']                     = $this->input->post('status_pns');

        $this->db->where('id_pegawai',$id);
        $this->db->where('urut',$urut);

        if($this->db->update('pegawai_keluarga', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function update_entry_pasangan($id,$urut)
    {
        $data['id_mst_peg_keluarga']= $this->input->post('id_mst_peg_keluarga');
        $data['nama']               = $this->input->post('nama');
        $data['jenis_kelamin']      = $this->input->post('jenis_kelamin');
        $data['tgl_lahir']          = date("Y-m-d",strtotime($this->input->post('tgl_lahir')));
        $data['code_cl_district']   = $this->input->post('code_cl_district');
        $data['bpjs']               = $this->input->post('bpjs');
        $data['status_hidup']       = $this->input->post('status_hidup');
        $data['status_pns']         = $this->input->post('status_pns');
        $data['akta_menikah']       = $this->input->post('akta_menikah');
        $data['akta_meninggal']     = $this->input->post('akta_meninggal');
        $data['akta_cerai']         = $this->input->post('akta_cerai');
        $data['tgl_menikah']        = date("Y-m-d",strtotime($this->input->post('tgl_menikah')));
        $data['tgl_meninggal']      = date("Y-m-d",strtotime($this->input->post('tgl_meninggal')));
        $data['tgl_cerai']          = date("Y-m-d",strtotime($this->input->post('tgl_cerai')));
        $data['status_menikah']     = $this->input->post('status_menikah');

        $this->db->where('id_pegawai',$id);
        $this->db->where('urut',$urut);

        if($this->db->update('pegawai_keluarga', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function update_entry_pendidikan_struktural($id,$id_diklat)
    {
        $data['nama_diklat']        = $this->input->post('nama_diklat');
        $data['tgl_diklat']         = date("Y-m-d",strtotime($this->input->post('tgl_diklat')));
        $data['nomor_sertifikat']   = $this->input->post('nomor_sertifikat');
        $data['tipe']               = 'struktural';

        $this->db->where('id_pegawai',$id);
        $this->db->where('mst_peg_id_diklat',$id_diklat);

        if($this->db->update('pegawai_diklat', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function update_entry_pendidikan_fungsional($id,$id_diklat)
    {
        $data['id_pegawai']         = $id;
        $data['mst_peg_id_diklat']  = $this->input->post('mst_peg_id_diklat');
        $data['nama_diklat']        = $this->input->post('nama_diklat');
        $data['tgl_diklat']         = date("Y-m-d",strtotime($this->input->post('tgl_diklat')));
        $data['nomor_sertifikat']   = $this->input->post('nomor_sertifikat');
        $data['tipe']               = $this->input->post('tipe');
        $data['lama_diklat']        = intval($this->input->post('lama_diklat'));
        $data['instansi']           = $this->input->post('instansi');
        $data['penyelenggara']      = $this->input->post('penyelenggara');

        $this->db->where('id_pegawai',$id);
        $this->db->where('mst_peg_id_diklat',$id_diklat);

        if($this->db->update('pegawai_diklat', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    function update_entry_pns_formal($id,$tmt)
    {
        $ttm = explode("-", $tmt);
        $tgl = $ttm[2].'-'.$ttm[1].'-'.$ttm[0];
        $this->db->where('id_pegawai',$id);
        $this->db->where('tmt',$tmt);
        $data['id_mst_peg_golruang']= $this->input->post('id_mst_peg_golruang');
        $data['bkn_tgl']            = date("Y-m-d",strtotime($this->input->post('bkn_tgl')));
        $data['bkn_nomor']          = $this->input->post('bkn_nomor');//date("Y-m-d",strtotime($this->input->post('ijazah_tgl')));
        $data['sk_tgl']             = date("Y-m-d",strtotime($this->input->post('sk_tgl')));
        $data['sk_nomor']           = $this->input->post('sk_nomor');
        $data['sk_pejabat']         = $this->input->post('sk_pejabat');
        $data['status']                = $this->input->post('statuspns');
        $data['code_cl_phc']                = $this->input->post('codepus');
        if ($this->input->post('nit')!='') {
            $nip_nit = $this->input->post('nit');
        }else if ($this->input->post('nip')!='') {
            $nip_nit = $this->input->post('nip');
        }
        $data['nip_nit']            = $nip_nit;
        if ($this->input->post('statuspns')=='CPNS') {
            $data['jenis_pengadaan']            = $this->input->post('jenis_pengadaan');
            $data['masa_krj_bln']               = $this->input->post('masa_krj_bln');
            $data['masa_krj_thn']               = $this->input->post('masa_krj_thn');
            $data['spmt_tgl']                   = date("Y-m-d",strtotime($this->input->post('spmt_tgl')));
            $data['spmt_nomor']                 = $this->input->post('spmt_nomor');

        }else if ($this->input->post('statuspns')=='PNS') {
            $data['masa_krj_bln']               = $this->input->post('masa_krj_bln');
            $data['masa_krj_thn']               = $this->input->post('masa_krj_thn');
            $data['is_pengangkatan']               = $this->input->post('penganggkatan');
            if($this->input->post('penganggkatan') == '1'){
                $data['sttpl_tgl']               = date("Y-m-d",strtotime($this->input->post('sttpl_tgl')));
                $data['sttpl_nomor']             = $this->input->post('sttpl_nomor');
                $data['dokter_nomor']            = $this->input->post('dokter_nomor');
                $data['dokter_tgl']              = date("Y-m-d",strtotime($this->input->post('dokter_tgl')));
            }else{
                $data['jenis_pangkat']             = $this->input->post('jenis_pangkat');
            }
        }else {
            $data['jenis_pengadaan']            = $this->input->post('jenis_pengadaan');
            $data['tat']                        = date("Y-m-d",strtotime($this->input->post('tat')));
            $data['masa_krj_thn']               = $this->input->post('masa_krj_thn');
            $data['masa_krj_bln']               = $this->input->post('masa_krj_bln');
            $data['spmt_tgl']                   = date("Y-m-d",strtotime($this->input->post('spmt_tgl')));
            $data['spmt_nomor']                 = $this->input->post('spmt_nomor');
        }
            if($this->db->update('pegawai_pangkat', $data)){
                return $data['status']; 
            }else{
                return mysql_error();
            }
    }
    function get_data_pendidikan_formal($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("pegawai_pendidikan.*,IF(pegawai_pendidikan.status_pendidikan_cpns=1,'Ya','Tidak') as cpns,mst_peg_jurusan.nama_jurusan,mst_peg_tingkatpendidikan.deskripsi",false);
        $this->db->order_by('ijazah_tgl','asc');
        $this->db->join('mst_peg_jurusan','mst_peg_jurusan.id_jurusan=pegawai_pendidikan.id_mst_peg_jurusan');
        $this->db->join('mst_peg_tingkatpendidikan','mst_peg_tingkatpendidikan.id_tingkat=mst_peg_jurusan.id_mst_peg_tingkatpendidikan');
        $query = $this->db->get('pegawai_pendidikan',$limit,$start);
        return $query->result();
    }
    function get_data_pangkat_cpns($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("*",false);
        $query = $this->db->where('id_pegawai',$id);
        $query = $this->db->get('pegawai_pangkat',$limit,$start);
        return $query->result();
    }
    function insert_entry_cpns_formal($id)
    {
        $data['id_pegawai']         = $id;
        $data['id_mst_peg_golruang']= $this->input->post('id_mst_peg_golruang');
        $data['tmt']                = date("Y-m-d",strtotime($this->input->post('tmt')));
        $data['bkn_tgl']            = date("Y-m-d",strtotime($this->input->post('bkn_tgl')));
        $data['bkn_nomor']          = $this->input->post('bkn_nomor');//date("Y-m-d",strtotime($this->input->post('ijazah_tgl')));
        $data['sk_tgl']             = date("Y-m-d",strtotime($this->input->post('sk_tgl')));
        $data['sk_nomor']           = $this->input->post('sk_nomor');
        $data['sk_pejabat']         = $this->input->post('sk_pejabat');
        $data['status']                = $this->input->post('statuspns');
        $data['code_cl_phc']                = $this->input->post('codepus');
        if ($this->input->post('nit')!='') {
            $nip_nit = $this->input->post('nit');
        }else if ($this->input->post('nip')!='') {
            $nip_nit = $this->input->post('nip');
        }
        $data['nip_nit']            = $nip_nit;
        if ($this->input->post('statuspns')=='CPNS') {
            $data['jenis_pengadaan']            = $this->input->post('jenis_pengadaan');
            $data['masa_krj_bln']               = $this->input->post('masa_krj_bln');
            $data['masa_krj_thn']               = $this->input->post('masa_krj_thn');
            $data['spmt_tgl']                   = date("Y-m-d",strtotime($this->input->post('spmt_tgl')));
            $data['spmt_nomor']                 = $this->input->post('spmt_nomor');

        }else if ($this->input->post('statuspns')=='PNS') {
            $data['masa_krj_bln']               = $this->input->post('masa_krj_bln');
            $data['masa_krj_thn']               = $this->input->post('masa_krj_thn');
            $data['is_pengangkatan']                 = $this->input->post('penganggkatan');
            if($this->input->post('penganggkatan') == '1'){
                $data['sttpl_tgl']               = date("Y-m-d",strtotime($this->input->post('sttpl_tgl')));
                $data['sttpl_nomor']             = $this->input->post('sttpl_nomor');
                $data['dokter_nomor']            = $this->input->post('dokter_nomor');
                $data['dokter_tgl']              = date("Y-m-d",strtotime($this->input->post('dokter_tgl')));
            }else{
                $data['jenis_pangkat']           = $this->input->post('jenis_pangkat');
            }
        }else {
            $data['jenis_pengadaan']            = $this->input->post('jenis_pengadaan');
            $data['tat']                        = date("Y-m-d",strtotime($this->input->post('tat')));
            $data['masa_krj_thn']               = $this->input->post('masa_krj_thn');
            $data['masa_krj_bln']               = $this->input->post('masa_krj_bln');
            $data['spmt_tgl']                   = date("Y-m-d",strtotime($this->input->post('spmt_tgl')));
            $data['spmt_nomor']                 = $this->input->post('spmt_nomor');
        }
            if($this->db->insert('pegawai_pangkat', $data)){
                return $data['status']; 
            }else{
                return mysql_error();
            }
    }

    function get_data_pendidikan_fungsional($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("pegawai_diklat.*,mst_peg_diklat.nama_diklat as jenis_diklat,mst_peg_diklat.jenis",false);
        $this->db->order_by('tgl_diklat','asc');
        $this->db->where('pegawai_diklat.tipe <> ','struktural');
        $this->db->join('mst_peg_diklat','mst_peg_diklat.id_diklat=pegawai_diklat.mst_peg_id_diklat');
        $query = $this->db->get('pegawai_diklat',$limit,$start);
        return $query->result();
    }

    function insert_entry_pendidikan_fungsional($id)
    {
        $data['id_pegawai']         = $id;
        $data['mst_peg_id_diklat']  = $this->input->post('mst_peg_id_diklat');
        $data['nama_diklat']        = $this->input->post('nama_diklat');
        $data['tgl_diklat']         = date("Y-m-d",strtotime($this->input->post('tgl_diklat')));
        $data['nomor_sertifikat']   = $this->input->post('nomor_sertifikat');
        $data['tipe']               = $this->input->post('tipe');
        $data['lama_diklat']        = intval($this->input->post('lama_diklat'));
        $data['instansi']           = $this->input->post('instansi');
        $data['penyelenggara']      = $this->input->post('penyelenggara');

        $this->db->where('id_pegawai',$id);
        $this->db->where('mst_peg_id_diklat', $data['mst_peg_id_diklat']);
        $urut = $this->db->get('pegawai_diklat')->row();
        if(!empty($urut->mst_peg_id_diklat)){
            return false;
        }else{
            if($this->db->insert('pegawai_diklat', $data)){
                return true; 
            }else{
                return mysql_error();
            }
        }
    }
    
    function get_data_pendidikan_struktural($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("pegawai_diklat.*,mst_peg_diklat.nama_diklat as jenis_diklat,mst_peg_diklat.jenis",false);
        $this->db->order_by('tgl_diklat','asc');
        $this->db->where('pegawai_diklat.tipe','struktural');
        $this->db->join('mst_peg_diklat','mst_peg_diklat.id_diklat=pegawai_diklat.mst_peg_id_diklat');
        $query = $this->db->get('pegawai_diklat',$limit,$start);
        return $query->result();
    }

    function insert_entry_pendidikan_struktural($id)
    {
        $data['id_pegawai']         = $id;
        $data['mst_peg_id_diklat']  = $this->input->post('mst_peg_id_diklat');
        $data['nama_diklat']        = $this->input->post('nama_diklat');
        $data['tgl_diklat']         = date("Y-m-d",strtotime($this->input->post('tgl_diklat')));
        $data['nomor_sertifikat']   = $this->input->post('nomor_sertifikat');
        $data['tipe']               = 'struktural';

        $this->db->where('id_pegawai',$id);
        $this->db->where('mst_peg_id_diklat', $data['mst_peg_id_diklat']);
        $urut = $this->db->get('pegawai_diklat')->row();
        if(!empty($urut->mst_peg_id_diklat)){
            return false;
        }else{
            if($this->db->insert('pegawai_diklat', $data)){
                return true; 
            }else{
                return mysql_error();
            }
        }
    }
    

// CRUD alamat pegawai
    function get_alamat_id($id="")
    {
        $this->db->select('max(urut) as urut');
        $this->db->where('id_pegawai',$id);
        $jum = $this->db->get('pegawai')->row();
        
        if (empty($jum)){
            return 1;
        }else {
            return $jum->urut+1;
        }

    }

//Diklat
    function get_data_diklat($start=0,$limit=999999,$options=array())
    {
        $this->db->select('*');
        $this->db->join('mst_peg_kursus','pegawai_diklat.id_mst_peg_kursus=mst_peg_kursus.id_kursus ','inner');
        $query = $this->db->get('pegawai_diklat',$limit,$start);
        return $query->result();
    }

    function get_data_diklat_id($id,$id_mst_peg_kursus)
    {
        $data = array();
        $options = array('id_pegawai'=>$id,'id_mst_peg_kursus'=>$id_mst_peg_kursus);
        $query = $this->db->get_where($this->t_diklat,$options);
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }

        $query->free_result();    
        return $data;
    }

    function get_data_diklat1($id){
        $this->db->select('*');
        $kursus = 'kursus';
        $this->db->where('jenis !=',$kursus);
        $this->db->from('mst_peg_kursus');
        $query = $this->db->get();
        return $query->result();
    }

    function delete_entry_diklat($id,$id_mst_peg_kursus)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('id_mst_peg_kursus',$id_mst_peg_kursus);

        return $this->db->delete($this->t_diklat);
    }

//Pegawai DP3
    function get_data_dp3($start=0,$limit=999999,$options=array())
    {
        $this->db->order_by('id_pegawai','asc');
        $query = $this->db->get('pegawai_dp3',$limit,$start);
        return $query->result();
    }

    function get_data_dp3_id($id,$tahun)
    {
        $data = array();
        $options = array('id_pegawai'=>$id,'tahun'=>$tahun);
        $query = $this->db->get_where($this->t_dp3,$options);
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }

        $query->free_result();    
        return $data;
    }

    function delete_entry_dp3($id,$dp3)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('tahun',$tahun);

        return $this->db->delete($this->t_dp3);
    }

    function delete_entry_pendidikan_formal($id,$jurusan)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('id_mst_peg_jurusan',$jurusan);

        return $this->db->delete('pegawai_pendidikan');
    }

    function delete_entry_pns_formal($id,$tmt)
    {
        
        $ttm = explode("-", $tmt);
        $tgl = $ttm[2].'-'.$ttm[1].'-'.$ttm[0];
        $this->db->where('id_pegawai',$id);
        $this->db->where('tmt',$tgl);

        return $this->db->delete('pegawai_pangkat');
    }

    function delete_entry_pendidikan_fungsional($id,$id_diklat)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('mst_peg_id_diklat',$id_diklat);

        return $this->db->delete('pegawai_diklat');
    }

}
