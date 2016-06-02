<?php
class Penilaiandppp_model extends CI_Model {

    var $tabel    = 'inv_permohonan_barang';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
     function get_data_dppp($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("*");
        $this->db->where('id_mst_peg_struktur_org',$id);
        $query = $this->db->get('mst_peg_struktur_skp',$limit,$start);
        return $query->result();
    }
    function get_data_detail($start=0,$limit=999999,$options=array())
    {	$puskesmas_ = 'P'.$this->session->userdata('puskesmas');
    	$this->db->select("mst_peg_golruang.ruang, mst_peg_struktur_org.*, pangkat.nip_nit,mst_peg_struktur_org.tar_nama_posisi, pangkat.id_mst_peg_golruang");
    	$this->db->join("pegawai",'pegawai_dp3.id_pegawai = pegawai.id_pegawai','left');
    	$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai_struktur",'pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_golruang",'mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
        $this->db->join("mst_peg_struktur_org",'mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
		$query =$this->db->get('pegawai_dp3',$limit,$start);
        return $query->result();
    }
    function get_data($start=0,$limit=999999,$options=array())
    {	$puskesmas_ = 'P'.$this->session->userdata('puskesmas');
    	$this->db->select("mst_peg_golruang.ruang, app_users_list.username,pegawai.*, pangkat.nip_nit,mst_peg_struktur_org.tar_nama_posisi, pangkat.id_mst_peg_golruang");
    	$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai_struktur",'pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_golruang",'mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
        $this->db->join("app_users_list",'app_users_list.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_struktur_org",'mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
		$query =$this->db->get('pegawai',$limit,$start);
        return $query->result();
    }
    function get_data_skp($id,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("*");
        $this->db->where('id_mst_peg_struktur_org',$id);
        $query = $this->db->get('mst_peg_struktur_skp',$limit,$start);
        return $query->result();
    }
    function getusername($id=0){
    	$this->db->select('app_users_list.username,pegawai_struktur.tar_id_struktur_org,(SELECT tar_id_struktur_org_parent FROM mst_peg_struktur_org WHERE tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org) AS parent');
    	$this->db->join('pegawai_struktur','app_users_list.id_pegawai = pegawai_struktur.id_pegawai AND app_users_list.code = SUBSTR(pegawai_struktur.code_cl_phc,2,11)','left');
    	$this->db->where("app_users_list.id_pegawai",$id);
    	$query = $this->db->get('app_users_list');
    	return $query->row_array();
    }
 	function get_datapegawai($kode,$code_cl_phc){
 		$code_cl_phc = substr($code_cl_phc, 0,12);
		$data = array();
		$this->db->select("app_users_list.username,pegawai.*,pegawai_struktur.tar_id_struktur_org as id_mst_peg_struktur_org, TIMESTAMPDIFF(YEAR, tgl_lhr, CURDATE()) AS usia");
		$this->db->where("pegawai.code_cl_phc",$code_cl_phc);
		$this->db->where("pegawai.id_pegawai",$kode);
		$this->db->join("pegawai_struktur","pegawai_struktur.id_pegawai=pegawai.id_pegawai and pegawai.code_cl_phc=pegawai_struktur.code_cl_phc",'left');
		$this->db->join("app_users_list","app_users_list.id_pegawai=pegawai.id_pegawai",'left');
		$query = $this->db->get("pegawai");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	function get_data_barang_edit($code_cl_phc, $permohonanbarang, $permohonanitem){
		$data = array();
		
		$this->db->select("*");
		$this->db->where("id_inv_permohonan_barang_item",$permohonanitem);
		$this->db->where("code_cl_phc",$code_cl_phc);
		$this->db->where("id_inv_permohonan_barang",$permohonanbarang);
		$query = $this->db->get("inv_permohonan_barang_item");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	public function getSelectedData($table,$data)
    {
        return $this->db->get_where($table, array('id_inv_permohonan_barang'=>$data));
    }

   
   function insert_entry()
    {
    	$data['id_inv_permohonan_barang']	= $this->kode_permohonan($this->input->post('id_inv_permohonan_barang'));
    	$data['tanggal_permohonan']	= date("Y-m-d",strtotime($this->input->post('tgl')));
		$data['keterangan']			= $this->input->post('keterangan');
		$data['code_cl_phc']		= $this->input->post('codepus');
		$data['id_mst_inv_ruangan']	= $this->input->post('ruangan');

		$data['waktu_dibuat']		= date('Y-m-d');
		$data['jumlah_unit']      	= 0;
		$data['app_users_list_username'] 	= $this->session->userdata('username'); 
		//$data['id_inv_permohonan_barang']	= $this->get_permohonan_id($this->input->post('codepus'));
		if($this->db->insert($this->tabel, $data)){
			return $data['id_inv_permohonan_barang'];
		}else{
			return mysql_error();
		}
    }

    function update_entry($kode,$code_cl_phc)
    {
    	$data['tanggal_permohonan']	= date("Y-m-d",strtotime($this->input->post('tgl')));
		$data['keterangan']			= $this->input->post('keterangan');
		$data['code_cl_phc']		= $this->input->post('codepus');
		$data['id_mst_inv_ruangan']	= $this->input->post('ruangan');
        $data['pilihan_status_pengadaan'] = $this->input->post('statuspengadaan');

		$this->db->where('id_inv_permohonan_barang',$kode);
		$this->db->where('code_cl_phc',$code_cl_phc);

		if($this->db->update($this->tabel, $data)){
			return true;
		}else{
			return mysql_error();
		}
    }
    function getdatawhere($table='',$data=''){
    	
    	$query = $this->db->get_where($table,$data);
    	if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
    }
    function update_status()
    {	
    	
    	$idstatus= $this->input->post('id_jabatan');
    	if ($idstatus!='') {
	    	$id= $this->input->post('id_pegawai');
	    	$code_cl_phc= $this->input->post('code_cl_phc');
	    	// $data	= $this->getdatawhere('mst_peg_struktur_org',array('tar_nama_posisi' => $status));
	    	$querydata = $this->db->get_where('pegawai_struktur',array('id_pegawai' => $id,'code_cl_phc' => $code_cl_phc ));
	    	if ($querydata->num_rows() > 0) {
	    		if($this->db->update('pegawai_struktur', array('tar_id_struktur_org'=> $idstatus),array('id_pegawai'=> $id,'code_cl_phc'=>$code_cl_phc))){
					return true;
				}else{
					return mysql_error();
				}	
	    	}else{
	    		if($this->db->insert('pegawai_struktur',array('tar_id_struktur_org'=> $idstatus,'id_pegawai'=> $id,'code_cl_phc'=>$code_cl_phc))){
					return true;
				}else{
					return mysql_error();
				}
	    	}
	    }
		
    }
    
	function delete_entry($kode,$code_cl_phc)
	{
		$this->db->where('id_inv_permohonan_barang',$kode);
		$this->db->delete('inv_permohonan_barang_item');

		$this->db->where('id_inv_permohonan_barang',$kode);
		$this->db->where('code_cl_phc',$code_cl_phc);

		return $this->db->delete($this->tabel);

	}
	function delete_entryitem($kode,$code_cl_phc,$kode_item)
	{
		$this->db->where('id_inv_permohonan_barang',$kode);
		$this->db->where('id_inv_permohonan_barang_item',$kode_item);
		$this->db->where('code_cl_phc',$code_cl_phc);
		return $this->db->delete('inv_permohonan_barang_item');
	}
	function get_databarang($start=0,$limit=999999)
    {
		$this->db->order_by('uraian','asc');
        $query = $this->db->get('mst_inv_barang',$limit,$start);
        return $query->result();
    }
}