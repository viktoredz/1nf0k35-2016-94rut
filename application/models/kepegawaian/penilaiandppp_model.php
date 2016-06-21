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
    function get_data_detail($id=0,$start=0,$limit=999999,$options=array())
    {	$puskesmas_ = 'P'.$this->session->userdata('puskesmas');
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
    function get_data($start=0,$limit=999999,$options=array())
    {	
        $puskesmas_ = 'P'.$this->session->userdata('puskesmas');
        $filter_tahun=$this->session->userdata('filter_tahun');
        if ($filter_tahun!='') {
            $this->db->select("mst_peg_golruang.ruang, app_users_list.username,pegawai.*, pangkat.nip_nit,mst_peg_struktur_org.tar_nama_posisi, pangkat.id_mst_peg_golruang,(select nilai_prestasi from pegawai_dp3  where id_pegawai = pegawai.id_pegawai and tahun=".'"'.$filter_tahun.'"'." limit 1) as nilai_prestasi,ifnull((select tahun from pegawai_dp3  where id_pegawai = pegawai.id_pegawai and tahun=".'"'.$filter_tahun.'"'." limit 1 ),$filter_tahun) as tahun_penilaian",false);
        }else{
            $this->db->select("mst_peg_golruang.ruang, app_users_list.username,pegawai.*, pangkat.nip_nit,mst_peg_struktur_org.tar_nama_posisi, pangkat.id_mst_peg_golruang,(select nilai_prestasi from pegawai_dp3  where id_pegawai = pegawai.id_pegawai order by tahun desc limit 1) as nilai_prestasi,ifnull((select tahun from pegawai_dp3  where id_pegawai = pegawai.id_pegawai order by tahun desc limit 1 ),YEAR(CURDATE())) as tahun_penilaian");
        }
    	$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("pegawai_struktur",'pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_golruang",'mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
        $this->db->join("app_users_list",'app_users_list.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_struktur_org",'mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
		$query =$this->db->get('pegawai',$limit,$start);
        return $query->result();
    }
    function getakmaster($id_mst_peg_struktur_org=0,$id_mst_peg_struktur_skp=0){
        $this->db->where('id_mst_peg_struktur_org',$id_mst_peg_struktur_org);
        $this->db->where('id_mst_peg_struktur_skp',$id_mst_peg_struktur_skp);
        $query = $this->db->get('mst_peg_struktur_skp');
        if($query->num_rows > 0){
            foreach ($query->result() as $key) {
                $data = $key->ak;
            }
        }else{
            $data = 0;
        }
        return $data;
    }
    function get_data_row_pengukuran($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$periode=0){
        $this->db->where('tahun',$tahun);
        $this->db->where('periode',$periode);
        $this->db->where('id_pegawai',$id_pegawai);
        $query = $this->db->get('pegawai_skp');
        if($query->num_rows > 0){
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
    function dppp_update (){
    	

        
		$biaya = $this->input->post('biaya');
		$waktu = $this->input->post('waktu');
		$target = $this->input->post('target');
		$kuant = $this->input->post('kuant');
        $periode = $this->input->post('periode');
		$id_mst_peg_struktur_skp = $this->input->post('id_mst_peg_struktur_skp');
		$id_mst_peg_struktur_org = $this->input->post('id_mst_peg_struktur_org');
		$tahun = $this->input->post('tahun');
		$id_pegawai = $this->input->post('id_pegawai');
        $aksimpan = $this->getakmaster($id_mst_peg_struktur_org,$id_mst_peg_struktur_skp);
        $ak = $aksimpan * $kuant;

    	$this->db->where('id_pegawai',$id_pegawai);
    	$this->db->where('tahun',$tahun);
        $this->db->where('periode',$periode);
    	$this->db->where('id_mst_peg_struktur_org',$id_mst_peg_struktur_org);
    	$this->db->where('id_mst_peg_struktur_skp',$id_mst_peg_struktur_skp);
    	$query = $this->db->get('pegawai_skp_nilai');
    	if ($query->num_rows() >0) {
    		$this->db->where('id_pegawai',$id_pegawai);
	    	$this->db->where('tahun',$tahun);
            $this->db->where('periode',$periode);
	    	$this->db->where('id_mst_peg_struktur_org',$id_mst_peg_struktur_org);
	    	$this->db->where('id_mst_peg_struktur_skp',$id_mst_peg_struktur_skp);
    		$value = array(
    				'ak'	=> $ak,
    				'kuant' => $kuant,
    				'target' => $target,
    				'waktu' => $waktu,
    				'biaya' => $biaya,
    			);
    		$this->db->update('pegawai_skp_nilai',$value);
    	}else{
    		$this->db->where('',$id_pegawai);
	    	$this->db->where('',$tahun);
	    	$this->db->where('',$id_mst_peg_struktur_org);
	    	$this->db->where('',$id_mst_peg_struktur_skp);
    		$value = array(
    				'ak'						=> $ak,
    				'kuant' 					=> $kuant,
    				'target'					=> $target,
    				'waktu' 					=> $waktu,
    				'biaya' 					=> $biaya,
                    'periode'                     => $periode,
    				'id_pegawai'				=> $id_pegawai,
    				'tahun' 					=> $tahun,
    				'id_mst_peg_struktur_org' 	=> $id_mst_peg_struktur_org,
    				'id_mst_peg_struktur_skp' 	=> $id_mst_peg_struktur_skp,
    			);
    		$this->db->insert('pegawai_skp_nilai',$value);
    	}
        $nilaiskp =$this->nilairataskp($id_mst_peg_struktur_org,$id_pegawai,$tahun,$periode);
        $dataupdet= array('skp' => $nilaiskp);
        $keyupdet= array(
                'id_pegawai'=> $id_pegawai,
                'tahun'     => $tahun,
                'periode'   => $periode,
            );
        $this->db->update('pegawai_skp',$dataupdet,$keyupdet);
    }
    function nilairataskp($id=0,$id_pegawai=0,$tahun=0,$periode=0){
        $this->db->select("((sum((((pegawai_skp_nilai.kuant / mst_peg_struktur_skp.kuant)*100)+((pegawai_skp_nilai.target / mst_peg_struktur_skp.target)*100)+(((1.76*mst_peg_struktur_skp.waktu - pegawai_skp_nilai.waktu)/mst_peg_struktur_skp.waktu)*100))/3))/6) as nilairata");
        $this->db->where('mst_peg_struktur_skp.id_mst_peg_struktur_org',$id);
        $this->db->join('pegawai_skp_nilai',"mst_peg_struktur_skp.id_mst_peg_struktur_skp = pegawai_skp_nilai.id_mst_peg_struktur_skp AND pegawai_skp_nilai.id_pegawai=".'"'.$id_pegawai.'"'." and tahun=".'"'.$tahun.'"'."and periode=".'"'.$periode.'"'."",'left');
        $query = $this->db->get('mst_peg_struktur_skp');
        if ($query->num_rows() >0) {
            foreach ($query->result() as $key) {
                $data = $key->nilairata;
            }
        }else{
            $data =0;
        }
        return $data;
    }
    function get_nama($kolom_sl,$tabel,$kolom_wh,$kond){
       $this->db->where($kolom_wh,$kond);
        $this->db->select($kolom_sl);
        $query = $this->db->get($tabel)->result();
        foreach ($query as $key) {
            return $key->$kolom_sl;
        }
    }
    function get_data_skp($id=0,$id_pegawai=0,$tahun=0,$periode=0,$start=0,$limit=999999,$options=array())
    {
        $this->db->select("mst_peg_struktur_skp.*,pegawai_skp_nilai.id_pegawai as id_pegawai_nilai,pegawai_skp_nilai.tahun as tahun_nilai,pegawai_skp_nilai.id_mst_peg_struktur_org as id_mst_peg_struktur_org_nilai,pegawai_skp_nilai.id_mst_peg_struktur_skp as id_mst_peg_struktur_skp_nilai,pegawai_skp_nilai.ak as ak_nilai,pegawai_skp_nilai.kuant as kuant_nilai,pegawai_skp_nilai.target as target_nilai,pegawai_skp_nilai.waktu as waktu_nilai,pegawai_skp_nilai.biaya as biaya_nilai,(((pegawai_skp_nilai.kuant / mst_peg_struktur_skp.kuant)*100)+((pegawai_skp_nilai.target / mst_peg_struktur_skp.target)*100)+(((1.76*mst_peg_struktur_skp.waktu - pegawai_skp_nilai.waktu)/mst_peg_struktur_skp.waktu)*100)) as perhitungan_nilai,((((pegawai_skp_nilai.kuant / mst_peg_struktur_skp.kuant)*100)+((pegawai_skp_nilai.target / mst_peg_struktur_skp.target)*100)+(((1.76*mst_peg_struktur_skp.waktu - pegawai_skp_nilai.waktu)/mst_peg_struktur_skp.waktu)*100))/3) as pencapaian_nilai");
        $this->db->where('mst_peg_struktur_skp.id_mst_peg_struktur_org',$id);
        $this->db->join('pegawai_skp_nilai',"mst_peg_struktur_skp.id_mst_peg_struktur_skp = pegawai_skp_nilai.id_mst_peg_struktur_skp AND pegawai_skp_nilai.id_pegawai=".'"'.$id_pegawai.'"'." and tahun=".'"'.$tahun.'"'."and periode=".'"'.$periode.'"'."",'left');
        $query = $this->db->get('mst_peg_struktur_skp',$limit,$start);
        return $query->result();
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
    
	function delete_dppp($id_pegawai,$tahun)
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->where('tahun',$tahun);

		return $this->db->delete('pegawai_dp3');

	}
    function delete_pengukuran($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$periode=0){
        $this->db->where('id_pegawai',$id_pegawai);
        $this->db->where('tahun',$tahun);
        $this->db->where('id_mst_peg_struktur_org',$id_mst_peg_struktur_org);
        $this->db->where('periode',$periode);

        $this->db->delete('pegawai_skp_nilai');
        
        $this->db->where('id_pegawai',$id_pegawai);
        $this->db->where('tahun',$tahun);
        $this->db->where('periode',$periode);
        return $this->db->delete('pegawai_skp');
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
}