<?php
class Drh_model extends CI_Model {

    var $tabel    = 'pegawai';
    var $t_puskesmas = 'cl_phc';
    var $t_alamat = 'pegawai_alamat';
    var $t_diklat = 'pegawai_diklat';
    var $t_dp3 = 'pegawai_dp3';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    


    public function getItem($t_alamat,$data)
    {
        return $this->db->get_where($t_alamat, $data);
    }

    function get_data($start=0,$limit=999999,$options=array())
    {
        $this->db->select("pegawai.*,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lhr)), '%Y')+0 AS usia",false);
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
        $this->db->select("pegawai.*,DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),tgl_lhr)), '%Y')+0 AS usia",false);
		$query = $this->db->get_where($this->tabel,$options);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	function get_kode_agama($kode_ag){
		$this->db->select('*');
		$this->db->from('mst_agama');
        $this->db->order_by('value','asc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_kode_nikah($kode_nk){
		$this->db->select('*');
		$this->db->from('mst_peg_nikah');
        $this->db->order_by('value','asc');
		$query = $this->db->get();
		return $query->result();
	}

    function provinsi_option($id=0){
        $html ="<option value=''>-</option>";
        $sql = "select * from cl_province ORDER BY value ASC";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            if($id==$row->code)
                $html .= "<option value=".$row->code." selected>".$row->value."</option>";
            else
                $html .= "<option value=".$row->code.">".$row->value."</option>";
        }
        return $html;
    }

   function kota_option($kode_provinsi="",$id=0){
        if($kode_provinsi=="") $kode_provinsi ="-";
        $html ="<option value=''>-</option>";
        $sql = "select * from cl_district where code like '".$kode_provinsi."%' ORDER BY value ASC";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            if($id==$row->code)
                $html .= "<option value=".$row->code." selected>".$row->value."</option>";
            else
                $html .= "<option value=".$row->code.">".$row->value."</option>";
        }
        return $html;
    }

    function kecamatan_option($kode_kota, $id=""){
        $html ="<option value=''>-</option>";
        if($kode_kota=="") $kode_kota ="-";
        $sql = "select * from cl_kec where code like '".$kode_kota."%' ORDER BY nama ASC";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            if($id==$row->code)
                $html .= "<option value=".$row->code." selected>".$row->nama."</option>";
            else
                $html .= "<option value=".$row->code.">".$row->nama."</option>";
        }
        return $html;
    }

    function desa_option($kode_kec, $id=""){
        $html ="<option value=''>-</option>";
        if($kode_kec=="") $kode_kec ="-";
        $sql = "select * from cl_village where code like '".$kode_kec."%' ORDER BY value ASC";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            if($id==$row->code)
                $html .= "<option value=".$row->code." selected>".$row->value."</option>";
            else
                $html .= "<option value=".$row->code.">".$row->value."</option>";
        }
        return $html;
    }

    function get_kota($kode_provinsi, $id=""){
        if($kode_provinsi=="") $kode_provinsi ="-";
        $sql = "select * from cl_district where code like '".$kode_provinsi."%' ORDER BY value ASC";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            $data[$row->code] = $row->value;
        }

        return $data;
    }

    function get_kecamatan($kode_kota, $id=""){
        if($kode_kota=="") $kode_kota ="-";
        $sql = "select * from cl_kec where code like '".$kode_kota."%' ORDER BY nama ASC";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            $data[$row->code] = $row->nama;
        }

        return $data;
    }

    function get_desa($kode_kec, $id=""){
        if($kode_kec=="") $kode_kec ="-";
        $sql = "select * from cl_village where code like '".$kode_kec."%' ORDER BY value ASC";
        $query = $this->db->query($sql);
        foreach($query->result() as $row){
            $data[$row->code] = $row->value;
        }

        return $data;
    }

	function get_data_puskesmas($start=0,$limit=999999,$options=array())
    {
    	$this->db->order_by('value','asc');
    	// $this->db->where(code)
        $query = $this->db->get($this->t_puskesmas,$limit,$start);
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
        $data['code_cl_phc']    = $this->session->userdata('puskesmas');

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

	function delete_entry($id)
	{
		$this->db->where('id_pegawai',$id);

		return $this->db->delete($this->tabel);
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

    function delete_entry_alamat($id,$urut)
    {
        $this->db->where('id_pegawai',$id);
        $this->db->where('urut',$urut);

        return $this->db->delete($this->t_alamat);
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


}