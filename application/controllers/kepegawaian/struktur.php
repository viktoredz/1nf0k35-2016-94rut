<?php
class Struktur extends CI_Controller {

	var $struktur	= 'struktur';
	var $parent;

    public function __construct(){
		parent::__construct();
		$this->load->model('kepegawaian/struktur_model');
		$this->load->model('morganisasi_model');
	}

	function index(){
		$this->authentication->verify('mst','edit');
		$data['title_group']   = "Kepegawaian";
		$data['title_form']    = "Struktur Organisasi";
		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] = $this->morganisasi_model->get_data_puskesmas();
		$data['content']       = $this->parser->parse("kepegawaian/struktur/show",$data,true);		
		
		$this->template->show($data,"home");
	}

	
	function api_data(){
		$this->authentication->verify('mst','edit');		
		
		$kodepuskesmas = 'P'.$this->session->userdata('puskesmas');
		$data['ambildata'] = $this->struktur_model->get_data_akun($kodepuskesmas);
		foreach($data['ambildata'] as $d){
			$txt = $d["tar_id_struktur_org"]." \t ".$d["tar_id_struktur_org_parent"]."\t".$d["tar_nama_posisi"]." \t ".$d["jml_anggota"]." \t ".$d["tar_aktif"]." \t ".$d["code_cl_phc"]." \n";				
			echo $txt;
		}
	}





	function non_aktif_akun($id){
		$data = array('tar_aktif' => 0);
		$this->db->where('tar_id_struktur_org',$id);
		$this->db->update('mst_peg_struktur_org',$data);

		$this->db->where('tar_id_struktur_org_parent',$id);
		$q = $this->db->get('mst_peg_struktur_org');
   		if ($q->num_rows() > 0 ) {
			$child = $q->result_array();
   			foreach ($child as $dt) {
   				$this->non_aktif_akun($dt['tar_id_struktur_org']);
   			}

   		}
	}

	function set_puskes(){
		$this->authentication->verify('mst','edit');
		$this->session->set_userdata('puskes',$this->input->post('puskes'));		
	}

	function filter_tahun(){
		if($_POST) {
			if($this->input->post('tahun') != '') {
				$this->session->set_userdata('filter_tahun',$this->input->post('tahun'));
			}
		}
	}

	function induk_add(){
		$this->authentication->verify('mst','add');

    	$this->form_validation->set_rules('tar_nama_posisi', 'Nama Jabatan', 'trim|required');
        $this->form_validation->set_rules('tar_status', 'Status', 'trim|required');

	    $data['action']				= "add";
		$data['alert_form']		    = '';
		$data['akun']				= $this->struktur_model->get_parent_akun();

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("kepegawaian/struktur/form_tambah_induk",$data));
		}elseif($this->struktur_model->insert_entry()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("kepegawaian/struktur/form_tambah_induk",$data));
	}


	function induk_detail($id=0){
			$data['all_pegawai']		= $this->struktur_model->get_data_akun_detail($id);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['alert_form'] 		= '';
			$data['disable']			= "disable";
			die($this->parser->parse("kepegawaian/struktur/form_detail_anggota",$data));
		
		$this->keuinstansi_model->update_entry_instansi($id);
		die($this->parser->parse("kepegawaian/struktur/form_detail_anggota",$data));
	}

	
	function akun_add(){
		$this->authentication->verify('mst','add');
		$this->form_validation->set_rules('tar_id_struktur_org','ID Jabatan','trim|required');
		$this->form_validation->set_rules('tar_id_struktur_org_parent','ID Jabatan Parent','trim|required');
		$this->form_validation->set_rules('tar_aktif','Status','trim|required');
		$this->form_validation->set_rules('tar_nama_posisi','Nama Jabatan','trim|required');

		if($this->form_validation->run()== TRUE){
			$this->struktur_model->akun_add();	
			echo "0";
		}else{			
			$err = validation_errors();
			echo str_replace("<p>", "", str_replace("</p>", "\n", $err));
		}	
	}

	
}
?>