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
        $this->db->select("pegawai.id_pegawai, pangkat.nip_nit, pangkat.tmt, aa,pegawai.*,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lhr)), '%Y')+0 AS usia",false);
        $this->db->join('(SELECT id_pegawai, nip_nit, tmt, CONCAT(tmt, id_pegawai) AS aa FROM pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT 
                CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) AS pangkat','pangkat.id_pegawai = pegawai.id_pegawai','left');
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
    function get_datawhere ($code,$condition,$table){
        $this->db->select("*");
        if (($condition=='all') && ($code=='all')) {
            # code...
        }else{
            $this->db->where($condition,$code);
        }
        return $this->db->get($table)->result();
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
    function get_data_row_edit($id='0',$tmt='0'){
        $ttm = explode("-", $tmt);
        $tgl = $ttm[2].'-'.$ttm[1].'-'.$ttm[0];
        $data = array();
        $options = array('pegawai_jabatan.id_pegawai' => $id);
        $options = array('pegawai_jabatan.tmt' => $tgl);
        $this->db->select("pegawai_jabatan.*,pegawai.*,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lhr)), '%Y')+0 AS usia,(SELECT nip_nit FROM pegawai_pangkat WHERE id_pegawai = pegawai.id_pegawai ORDER BY tmt DESC LIMIT 1) AS nip",false);
        $this->db->join('pegawai_jabatan','pegawai_jabatan.id_pegawai = pegawai.id_pegawai','left');
        $query = $this->db->get_where($this->tabel,$options);
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }

        $query->free_result();    
        return $data;
    }
    function get_data_penghargan_edit ($id='0',$penghargaan='0'){
        $data = array();
        $options = array('pegawai_penghargaan.id_pegawai' => $id);
        $options = array('pegawai_penghargaan.id_mst_peg_penghargaan' => $penghargaan);
        $query = $this->db->get_where('pegawai_penghargaan',$options);
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
    function delete_entry_penghargaan($id,$penghargaan)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('id_mst_peg_penghargaan',$penghargaan);

        return $this->db->delete('pegawai_penghargaan');
    }

    function getusernamedelete($id){
        $this->db->where('id_pegawai',$id);
        $query = $this->db->get('app_users_list');
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }else{
            $data = 0;
        }
        $query->free_result();
        return $data;
    }
    function deleteall($id){
        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_diklat');

        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_dp3');

        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_jabatan');

        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_keluarga');

        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_pangkat');

        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_penghargaan');

        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_skp');

        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_skp_nilai');

        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_struktur');

        $this->db->where('id_pegawai',$id);
        $this->db->delete('pegawai_pendidikan');

        $this->db->where('id_pegawai',$id);
        return $this->db->delete($this->tabel);
    }
	function delete_entry($id)
	{
        $username = $this->getusernamedelete($id);

        if ($username !=0) {
            $this->db->where('code',$username['code']);
            $this->db->where('username',$username['username']);
            $this->db->delete('app_users_profile');

            $this->db->where('id_pegawai',$id);
            $this->db->delete('app_users_list');
            $this->deleteall($id);
        }else{
            $this->deleteall($id);    
        }
        
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

    function get_data_gaji_edit($id,$tmt){
        $data = array();

        $this->db->select("*");
        $this->db->where("id_pegawai",$id);
        $this->db->where("tmt",$tmt);
        $query = $this->db->get("pegawai_gaji");
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function get_data_gaji($id=0,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("*,mst_peg_golruang.id_golongan,mst_peg_golruang.ruang",false);
        $this->db->where('pegawai_gaji.id_pegawai',$id);
        $this->db->order_by('tmt','desc');
        $this->db->join('mst_peg_golruang','mst_peg_golruang.id=pegawai_gaji.id_mst_peg_golruang');
        $query = $this->db->get('pegawai_gaji',$limit,$start);
        return $query->result();
    }

    function update_entry_gaji($id,$tmt){
        $data['surat_nomor']            = $this->input->post('surat_nomor');
        $data['id_mst_peg_golruang']    = $this->input->post('id_mst_peg_golruang');
        $data['gaji_lama']              = $this->input->post('gaji_lama');
        $data['gaji_lama_pp']           = $this->input->post('gaji_lama_pp');
        $data['gaji_baru']              = $this->input->post('gaji_baru');
        $data['gaji_baru_pp']              = $this->input->post('gaji_baru_pp');
        $data['sk_tgl']                 = date("Y-m-d",strtotime($this->input->post('sk_tgl')));
        $data['sk_nomor']               = $this->input->post('sk_nomor');
        $data['sk_pejabat']             = $this->input->post('sk_pejabat');
        $data['masa_krj_bln']           = $this->input->post('masa_krj_bln');
        $data['masa_krj_thn']           = $this->input->post('masa_krj_thn');
        $this->db->where('id_pegawai',$id);
        $this->db->where('tmt',$tmt);
        if($this->db->update('pegawai_gaji', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }
    function delete_entry_gaji($id,$tmt)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('tmt',$tmt);

        return $this->db->delete('pegawai_gaji');
    }

    function get_data_pengahargaan($id=0,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("*,mst_peg_penghargaan.nama_penghargaan",false);
        $this->db->where('pegawai_penghargaan.id_pegawai',$id);
        $this->db->order_by('sk_tgl','desc');
        $this->db->join('mst_peg_penghargaan','mst_peg_penghargaan.id_penghargaan=pegawai_penghargaan.id_mst_peg_penghargaan');
        $query = $this->db->get('pegawai_penghargaan',$limit,$start);
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
    function insert_entry_penghargaan($id,$penghargaan){
        $data['id_pegawai']             = $id;
        $data['id_mst_peg_penghargaan'] = $this->input->post('id_mst_peg_penghargaan');
        $data['tingkat']                = $this->input->post('tingkat');
        $data['instansi']               = $this->input->post('instansi');
        $data['sk_tgl']                 = date("Y-m-d",strtotime($this->input->post('sk_tgl')));
        $data['sk_no']                  = $this->input->post('sk_no');
        $data['sk_pejabat']             = $this->input->post('sk_pejabat');
        $this->db->where('id_pegawai',$id);
        $this->db->where('id_mst_peg_penghargaan',$this->input->post('id_mst_peg_penghargaan'));
        $query = $this->db->get('pegawai_penghargaan');
        if ($query->num_rows() > 0) {
            return 'false';
        }else{
            if($this->db->insert('pegawai_penghargaan', $data)){
                return 'true'; 
            }else{
                return mysql_error();
            }    
        }
        
    }
    function update_entry_penghargaan($id,$penghargaan){
        $data['tingkat']                = $this->input->post('tingkat');
        $data['instansi']               = $this->input->post('instansi');
        $data['sk_tgl']                 = date("Y-m-d",strtotime($this->input->post('sk_tgl')));
        $data['sk_no']                  = $this->input->post('sk_no');
        $data['sk_pejabat']             = $this->input->post('sk_pejabat');
        $this->db->where('id_pegawai',$id);
        $this->db->where('id_mst_peg_penghargaan',$penghargaan);
        if($this->db->update('pegawai_penghargaan', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }
    function insert_entry_gaji($id){
        $data['id_pegawai']             = $id;
        $data['tmt']                    = date("Y-m-d",strtotime($this->input->post('tmt')));
        $data['surat_nomor']            = $this->input->post('surat_nomor');
        $data['id_mst_peg_golruang']    = $this->input->post('id_mst_peg_golruang');
        $data['gaji_lama']              = $this->input->post('gaji_lama');
        $data['gaji_lama_pp']           = $this->input->post('gaji_lama_pp');
        $data['gaji_baru']              = $this->input->post('gaji_baru');
        $data['gaji_baru_pp']              = $this->input->post('gaji_baru_pp');
        $data['sk_tgl']                 = date("Y-m-d",strtotime($this->input->post('sk_tgl')));
        $data['sk_nomor']               = $this->input->post('sk_nomor');
        $data['sk_pejabat']             = $this->input->post('sk_pejabat');
        $data['masa_krj_bln']           = $this->input->post('masa_krj_bln');
        $data['masa_krj_thn']           = $this->input->post('masa_krj_thn');
        $this->db->where('id_pegawai',$id);
        $this->db->where('tmt',date("Y-m-d",strtotime($this->input->post('tmt'))));
        $query = $this->db->get('pegawai_gaji');
        if ($query->num_rows() > 0) {
            return 'false';
        }else{
            if($this->db->insert('pegawai_gaji', $data)){
                return 'true'; 
            }else{
                return mysql_error();
            }    
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
        $this->db->where('id_pegawai',$id);
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
    function insert_entry_jabatan_formal($id)
    {
        $data['id_pegawai']         = $id;
        $data['nip_nit']            = $this->input->post('nip');
        $data['tmt']                = date("Y-m-d",strtotime($this->input->post('tmt')));
        $data['jenis']              = $this->input->post('jenis');
        $data['unor']               = $this->input->post('unor');
        $data['tgl_pelantikan']     = date("Y-m-d",strtotime($this->input->post('tgl_pelantikan')));
        $data['sk_jb_tgl']          = date("Y-m-d",strtotime($this->input->post('sk_jb_tgl')));
        $data['sk_jb_nomor']        = $this->input->post('sk_jb_nomor');
        $data['sk_jb_pejabat']        = $this->input->post('sk_jb_pejabat');
        $data['sk_status']          = $this->input->post('sk_status');
        $data['prosedur']           = $this->input->post('prosedur');
        $data['code_cl_phc']        = $this->input->post('codepus');
        if ($this->input->post('jenis')=='STRUKTURAL') {
            $data['id_mst_peg_struktural']        = $this->input->post('id_mst_peg_struktural');
            $data['id_mst_peg_fungsional']        = '-';
            $this->form_validation->set_rules('', 'Jabatan Struktural', 'trim|required');
        }else if ($this->input->post('jenis')=='FUNGSIONAL_TERTENTU') {
            $data['id_mst_peg_struktural']        = '-';
            $data['id_mst_peg_fungsional']        = $this->input->post('id_mst_peg_fungsional_tertentu');
        }else{
            $data['id_mst_peg_struktural']        = '-';
            $data['id_mst_peg_fungsional']        = $this->input->post('id_mst_peg_fungsional_umum');
        } 
            if($this->db->insert('pegawai_jabatan', $data)){
                return $data['jenis']; 
            }else{
                return mysql_error();
            }
    }
    function update_entry_jabatan_formal($id=0,$tmt=0)
    {
        $ttm = explode("-", $tmt);
        $tgl = $ttm[2].'-'.$ttm[1].'-'.$ttm[0];
        $data['nip_nit']            = $this->input->post('nip');
        $data['jenis']              = $this->input->post('jenis');
        $data['unor']               = $this->input->post('unor');
        $data['tgl_pelantikan']     = date("Y-m-d",strtotime($this->input->post('tgl_pelantikan')));
        $data['sk_jb_tgl']          = date("Y-m-d",strtotime($this->input->post('sk_jb_tgl')));
        $data['sk_jb_nomor']        = $this->input->post('sk_jb_nomor');
        $data['sk_jb_pejabat']        = $this->input->post('sk_jb_pejabat');
        $data['sk_status']          = $this->input->post('sk_status');
        $data['prosedur']           = $this->input->post('prosedur');
        $data['code_cl_phc']        = $this->input->post('codepus');
        if ($this->input->post('jenis')=='STRUKTURAL') {
            $data['id_mst_peg_struktural']        = $this->input->post('id_mst_peg_struktural');
            $data['id_mst_peg_fungsional']        = '-';
            $this->form_validation->set_rules('', 'Jabatan Struktural', 'trim|required');
        }else if ($this->input->post('jenis')=='FUNGSIONAL_TERTENTU') {
            $data['id_mst_peg_struktural']        = '-';
            $data['id_mst_peg_fungsional']        = $this->input->post('id_mst_peg_fungsional_tertentu');
        }else{
            $data['id_mst_peg_struktural']        = '-';
            $data['id_mst_peg_fungsional']        = $this->input->post('id_mst_peg_fungsional_umum');
        } 
        $this->db->where('id_pegawai',$id);
        $this->db->where('tmt',$tgl);
            if($this->db->update('pegawai_jabatan', $data)){
                return $data['jenis']; 
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
    
    function insert_entry_pendidikan_formal($id)
    {
        $data['id_pegawai']                 = $id;
        $data['id_mst_peg_jurusan']         = $this->input->post('id_jurusan');
        $data['sekolah_nama']               = $this->input->post('sekolah_nama');
        $data['ijazah_tgl']                 = date("Y-m-d",strtotime($this->input->post('ijazah_tgl')));
        $data['sekolah_lokasi']             = $this->input->post('sekolah_lokasi');
        $data['ijazah_no']                  = $this->input->post('ijazah_no');
        $data['gelar_depan']                = $this->input->post('gelar_depan');
        $data['gelar_belakang']             = $this->input->post('gelar_belakang');
        $data['status_pendidikan_cpns']     = $this->input->post('status_pendidikan_cpns');

       
        if($this->db->insert('pegawai_pendidikan', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }
    function update_entry_pendidikan_formal($id=0,$id_mst_peg_jurusan=0)
    {
        $data['sekolah_nama']               = $this->input->post('sekolah_nama');
        $data['ijazah_tgl']                 = date("Y-m-d",strtotime($this->input->post('ijazah_tgl')));
        $data['sekolah_lokasi']             = $this->input->post('sekolah_lokasi');
        $data['ijazah_no']                  = $this->input->post('ijazah_no');
        $data['gelar_depan']                = $this->input->post('gelar_depan');
        $data['gelar_belakang']             = $this->input->post('gelar_belakang');
        $data['status_pendidikan_cpns']     = $this->input->post('status_pendidikan_cpns');

       $this->db->where('id_pegawai',$id);
       $this->db->where('id_mst_peg_jurusan',$id_mst_peg_jurusan);
        if($this->db->update('pegawai_pendidikan', $data)){
            return true; 
        }else{
            return mysql_error();
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
    function get_data_jabatan($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("*,mst_peg_struktural.tar_nama_struktural,mst_peg_fungsional.tar_nama_fungsional,mst_peg_struktural.tar_eselon",false);
        $this->db->order_by('tmt','desc');
        $this->db->where('id_pegawai',$id);
        $this->db->join('mst_peg_struktural','mst_peg_struktural.tar_id_struktural=pegawai_jabatan.id_mst_peg_struktural','left');
        $this->db->join('mst_peg_fungsional','mst_peg_fungsional.tar_id_fungsional=pegawai_jabatan.id_mst_peg_fungsional','left');
        $query = $this->db->get('pegawai_jabatan',$limit,$start);
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
    function delete_entry_jabatan($id,$tmt)
    {
        
        $ttm = explode("-", $tmt);
        $tgl = $ttm[2].'-'.$ttm[1].'-'.$ttm[0];
        $this->db->where('id_pegawai',$id);
        $this->db->where('tmt',$tgl);

        return $this->db->delete('pegawai_jabatan');
    }
function get_nama($kolom_sl,$tabel,$kolom_wh,$kond){
       $this->db->where($kolom_wh,$kond);
        $this->db->select($kolom_sl);
        $query = $this->db->get($tabel)->result();
        foreach ($query as $key) {
            return $key->$kolom_sl;
        }
    }
    function delete_entry_pendidikan_fungsional($id,$id_diklat)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('mst_peg_id_diklat',$id_diklat);

        return $this->db->delete('pegawai_diklat');
    }
    function get_data_detail($id=0,$start=0,$limit=999999,$options=array())
    {   $puskesmas_ = 'P'.$this->session->userdata('puskesmas');
        // $this->db->where('pegawai_dp3.tahun',$tahun);
        $this->db->where('pegawai_dp3.id_pegawai',$id);

        $this->db->select("pegawai_dp3.*,mst_peg_golruang.ruang, mst_peg_struktur_org.*, pangkat.nip_nit,mst_peg_struktur_org.tar_nama_posisi, pangkat.id_mst_peg_golruang,pegawai.nama as namapegawai,penilai.gelar_depan as gelardepannama_penilai,penilai.nama as nama_penilai,penilai.gelar_belakang as gelarbelakangnama_penilai,atasanpenilai.nama as namaatasanpenilai,atasanpenilai.gelar_depan as gelardepannamaatasanpenilai,atasanpenilai.gelar_belakang as gelarbelakangnamaatasanpenilai ");
        $this->db->join("pegawai",'pegawai_dp3.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai as penilai",'pegawai_dp3.id_pegawai_penilai = penilai.id_pegawai','left');
        $this->db->join("pegawai as atasanpenilai",'pegawai_dp3.id_pegawai_penilai_atasan = atasanpenilai.id_pegawai','left');
        $this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai_struktur",'pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_golruang",'mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
        $this->db->join("mst_peg_struktur_org",'mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
        $query =$this->db->get('pegawai_dp3',$limit,$start);
        return $query->result();
    }
    function get_data_detail_pengukuran($id=0,$start=0,$limit=999999,$options=array())
    {   
        $this->db->order_by('tahun','desc');
        $this->db->order_by('periode','desc');
        $this->db->where('pegawai_skp.id_pegawai',$id);
        $this->db->select("pegawai_skp.*,pegawai.gelar_depan,pegawai.nama,pegawai.gelar_belakang,penilai.gelar_depan as gelardepannama_penilai,penilai.nama as nama_penilai,penilai.gelar_belakang as gelarbelakangnama_penilai, (SELECT 
            ((SUM((((pegawai_skp_nilai.kuant / mst_peg_struktur_skp.kuant) * 100) + ((pegawai_skp_nilai.target / mst_peg_struktur_skp.target) * 100) + (((1.76 * mst_peg_struktur_skp.waktu - pegawai_skp_nilai.waktu) / mst_peg_struktur_skp.waktu) * 100)) / 3)) / 6) AS nilairata FROM pegawai_skp_nilai JOIN mst_peg_struktur_skp ON mst_peg_struktur_skp.id_mst_peg_struktur_org = pegawai_skp_nilai.id_mst_peg_struktur_org AND mst_peg_struktur_skp.id_mst_peg_struktur_skp = pegawai_skp_nilai.id_mst_peg_struktur_skp WHERE pegawai_skp_nilai.id_pegawai =pegawai_skp.id_pegawai and
            pegawai_skp_nilai.tahun = pegawai_skp.tahun and  pegawai_skp_nilai.periode = pegawai_skp.periode) AS ratarata,(SELECT 
            ((SUM((((pegawai_skp_nilai.kuant / mst_peg_struktur_skp.kuant) * 100) + ((pegawai_skp_nilai.target / mst_peg_struktur_skp.target) * 100) + (((1.76 * mst_peg_struktur_skp.waktu - pegawai_skp_nilai.waktu) / mst_peg_struktur_skp.waktu) * 100)) / 3))) AS nilairata FROM pegawai_skp_nilai JOIN mst_peg_struktur_skp ON mst_peg_struktur_skp.id_mst_peg_struktur_org = pegawai_skp_nilai.id_mst_peg_struktur_org AND mst_peg_struktur_skp.id_mst_peg_struktur_skp = pegawai_skp_nilai.id_mst_peg_struktur_skp WHERE pegawai_skp_nilai.id_pegawai =pegawai_skp.id_pegawai and
            pegawai_skp_nilai.tahun = pegawai_skp.tahun and pegawai_skp_nilai.periode = pegawai_skp.periode) AS jumlah, pegawai_struktur.tar_id_struktur_org as id_mst_peg_struktur_org");
        $this->db->join("pegawai",'pegawai_skp.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai as penilai",'pegawai_skp.id_pegawai_penilai = penilai.id_pegawai','left');
        $this->db->join("pegawai_struktur",'pegawai_struktur.id_pegawai = pegawai_skp.id_pegawai','left');
        $query =$this->db->get('pegawai_skp',$limit,$start);
        return $query->result();
    }

    function get_data_row_pengukuran($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$periode=0){
        $this->db->where('tahun',$tahun);
        $this->db->where('periode',$periode);
        $this->db->where('id_pegawai',$id_pegawai);
        $query = $this->db->get('pegawai_skp');
        if($query->num_rows > 0){
           $data = $query->row_array();
        }else{
            $data =0;
        }
        $query->free_result();
        return $data;
    }
    function getanakbuah($id=0){
        $puskesmas_ = 'P'.$this->session->userdata('puskesmas');
        $query = $this->db->query("select b.id_pegawai from pegawai_struktur b where b.tar_id_struktur_org in (SELECT mst_peg_struktur_org.tar_id_struktur_org FROM mst_peg_struktur_org WHERE mst_peg_struktur_org.tar_id_struktur_org_parent = (SELECT  a.tar_id_struktur_org FROM pegawai_struktur a WHERE a.id_pegawai = ".'"'.$id.'"'." and a.code_cl_phc=".'"'.$puskesmas_.'"'."))",false);
        $data=array();
        foreach ($query->result_array() as $key) {
            $data[] = $key['id_pegawai'];
        }
        return $data;
    }
    function getusername($id=0){
        $this->db->select('app_users_list.username,pegawai_struktur.tar_id_struktur_org,(SELECT tar_id_struktur_org_parent FROM mst_peg_struktur_org WHERE tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org) AS parent');
        $this->db->join('pegawai_struktur','app_users_list.id_pegawai = pegawai_struktur.id_pegawai AND app_users_list.code = SUBSTR(pegawai_struktur.code_cl_phc,2,11)','left');
        $this->db->where("app_users_list.id_pegawai",$id);
        $query = $this->db->get('app_users_list');
        return $query->row_array();
    }
    function get_rowdata($id_pegawai,$tahun){
        $puskesmas_ = 'P'.$this->session->userdata('puskesmas');
        $this->db->where('pegawai_dp3.tahun',$tahun);
        $this->db->where('pegawai_dp3.id_pegawai',$id_pegawai);

        $this->db->select("app_users_list.username,pegawai_dp3.*,mst_peg_golruang.ruang, mst_peg_struktur_org.*, pangkat.nip_nit,mst_peg_struktur_org.tar_nama_posisi, pangkat.id_mst_peg_golruang,pegawai.nama as namapegawai,penilai.gelar_depan as gelardepannama_penilai,penilai.nama as nama_penilai,penilai.gelar_belakang as gelarbelakangnama_penilai,atasanpenilai.nama as namaatasanpenilai,atasanpenilai.gelar_depan as gelardepannamaatasanpenilai,atasanpenilai.gelar_belakang as gelarbelakangnamaatasanpenilai ");
        $this->db->join("pegawai",'pegawai_dp3.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai as penilai",'pegawai_dp3.id_pegawai_penilai = penilai.id_pegawai','left');
        $this->db->join("pegawai as atasanpenilai",'pegawai_dp3.id_pegawai_penilai_atasan = atasanpenilai.id_pegawai','left');
        $this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai_struktur",'pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_golruang",'mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
        $this->db->join("app_users_list",'app_users_list.id_pegawai = pegawai_dp3.id_pegawai','left');
        $this->db->join("mst_peg_struktur_org",'mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
        $query =$this->db->get('pegawai_dp3');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }

        $query->free_result();    
        return $data;
    }
    function get_rowdataexport($id_pegawai,$tahun){
        $puskesmas_ = 'P'.$this->session->userdata('puskesmas');
        $this->db->where('pegawai_dp3.tahun',$tahun);
        $this->db->where('pegawai_dp3.id_pegawai',$id_pegawai);

        $this->db->select("app_users_list.username,pegawai_dp3.*,(pegawai_dp3.skp* 60/100) as nilaiskp,mst_peg_golruang.ruang, mst_peg_struktur_org.*, pangkat.nip_nit,mst_peg_struktur_org.tar_nama_posisi, pangkat.id_mst_peg_golruang,pegawai.nama as namapegawai,penilai.gelar_depan as gelardepannama_penilai,penilai.nama as nama_penilai,penilai.gelar_belakang as gelarbelakangnama_penilai,atasanpenilai.nama as namaatasanpenilai,atasanpenilai.gelar_depan as gelardepannamaatasanpenilai,atasanpenilai.gelar_belakang as gelarbelakangnamaatasanpenilai ");
        $this->db->join("pegawai",'pegawai_dp3.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai as penilai",'pegawai_dp3.id_pegawai_penilai = penilai.id_pegawai','left');
        $this->db->join("pegawai as atasanpenilai",'pegawai_dp3.id_pegawai_penilai_atasan = atasanpenilai.id_pegawai','left');
        $this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai_struktur",'pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_golruang",'mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
        $this->db->join("app_users_list",'app_users_list.id_pegawai = pegawai_dp3.id_pegawai','left');
        $this->db->join("mst_peg_struktur_org",'mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
        $query =$this->db->get('pegawai_dp3');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }

        $query->free_result();    
        return $data;
    }
    function idlogin(){
        $id_login = $this->session->userdata('username');
        $this->db->where('username',$id_login);
        $this->db->select('app_users_list.id_pegawai AS idlogin');
        $this->db->join('pegawai_struktur','app_users_list.id_pegawai = pegawai_struktur.id_pegawai AND app_users_list.code = SUBSTR(pegawai_struktur.code_cl_phc,2,11)','left');
        $query = $this->db->get('app_users_list',1);
        if ($query->num_rows() >0) {
            foreach ($query->result() as $key) {
                if ($key->idlogin==null) {
                    $data = 'puskesmas';
                }else{
                    $data = $key->idlogin;
                }
            }
        }else{
            $data = '';
        }
        return $data;
    }
     function get_data_skp($id=0,$id_pegawai=0,$tahun=0,$periode=0,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("mst_peg_struktur_skp.*,pegawai_skp_nilai.id_pegawai as id_pegawai_nilai,pegawai_skp_nilai.tahun as tahun_nilai,pegawai_skp_nilai.id_mst_peg_struktur_org as id_mst_peg_struktur_org_nilai,pegawai_skp_nilai.id_mst_peg_struktur_skp as id_mst_peg_struktur_skp_nilai,pegawai_skp_nilai.ak as ak_nilai,pegawai_skp_nilai.kuant as kuant_nilai,pegawai_skp_nilai.target as target_nilai,pegawai_skp_nilai.waktu as waktu_nilai,pegawai_skp_nilai.biaya as biaya_nilai,(((pegawai_skp_nilai.kuant / mst_peg_struktur_skp.kuant)*100)+((pegawai_skp_nilai.target / mst_peg_struktur_skp.target)*100)+(((1.76*mst_peg_struktur_skp.waktu - pegawai_skp_nilai.waktu)/mst_peg_struktur_skp.waktu)*100)) as perhitungan_nilai,((((pegawai_skp_nilai.kuant / mst_peg_struktur_skp.kuant)*100)+((pegawai_skp_nilai.target / mst_peg_struktur_skp.target)*100)+(((1.76*mst_peg_struktur_skp.waktu - pegawai_skp_nilai.waktu)/mst_peg_struktur_skp.waktu)*100))/3) as pencapaian_nilai");
        $this->db->where('mst_peg_struktur_skp.id_mst_peg_struktur_org',$id);
        $this->db->join('pegawai_skp_nilai',"mst_peg_struktur_skp.id_mst_peg_struktur_skp = pegawai_skp_nilai.id_mst_peg_struktur_skp AND pegawai_skp_nilai.id_pegawai=".'"'.$id_pegawai.'"'." and tahun=".'"'.$tahun.'"'."and periode=".'"'.$periode.'"'."",'left');
        $query = $this->db->get('mst_peg_struktur_skp',$limit,$start);
        return $query->result();
    }
}
