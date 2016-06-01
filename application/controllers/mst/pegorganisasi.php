<?php
class Pegorganisasi extends CI_Controller {

	var $mst_keu_akun	= 'mst_keu_akun';
	var $parent;

    public function __construct(){
		parent::__construct();
		$this->load->model('mst/pegorganisasi_model');
		$this->load->model('morganisasi_model');
	}

	function index(){
		$this->authentication->verify('mst','edit');
		$data['title_group']   = "Parameter ";
		$data['title_form']    = "Master Data - Struktur Organisasi";
		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] = $this->morganisasi_model->get_data_puskesmas();
		$data['content']       = $this->parser->parse("mst/pegorganisasi/show",$data,true);		
		
		$this->template->show($data,"home");
	}

	function api_data(){
		$this->authentication->verify('mst','edit');		
		
		$kodepuskesmas = 'P'.$this->session->userdata('puskesmas');
		$data['ambildata'] = $this->pegorganisasi_model->get_data_akun($kodepuskesmas);
		foreach($data['ambildata'] as $d){
			$txt = $d["tar_id_struktur_org"]." \t ".$d["tar_id_struktur_org_parent"]."\t".$d["tar_nama_posisi"]." \t ".($d["tar_aktif"]==1 ? "<i class='icon fa fa-check-square-o'></i>" : "-")." \t ".$d["code_cl_phc"]." \n";				
			echo $txt;
		}
	}

	function api_data_akun_non_aktif(){
		$this->authentication->verify('mst','edit');		
		
		$data['ambildata'] = $this->pegorganisasi_model->get_data_akun_non_aktif();
		foreach($data['ambildata'] as $d){
			$id = $d["id_mst_akun_parent"];
			$this->parent = "";
			$this->have_parent($id);
			$txt = $d["id_mst_akun"]." \t ".$d["id_mst_akun_parent"]."\t".$d["kode"]." \t ".$d["uraian"]." \t ".ucwords($d["saldo_normal"])." \t ".$this->parent." \n";				
			echo $txt;
		}
	}

	function aktifkan_akun($id){
		$data = array('aktif' => 1);
		$this->db->where('id_mst_akun',$id);
		$this->db->update('mst_keu_akun',$data);

		$this->db->where('id_mst_akun_parent',$id);
		$q = $this->db->get('mst_keu_akun');
   		if ($q->num_rows() > 0 ) {
			$child = $q->result_array();
   			foreach ($child as $dt) {
   				$this->aktifkan_akun($dt['id_mst_akun']);
   			}

   		}
	}
	function cekstatustambah(){
		$kodepuskesmas = 'P'.$this->session->userdata('puskesmas');
        $this->db->where('code_cl_phc',$kodepuskesmas);
		$query = $this->db->get('mst_peg_struktur_org');
		if ($query->num_rows() > 0) {
			die('1');
		}else{
			die('0');
		}
	}
	function non_aktif_akun($id=0,$status=''){
		if ($status=='nonaktif') {
			$data = array('tar_aktif' => 0);
		}else{
			$data = array('tar_aktif' => 1);
		}
		$this->db->where('tar_id_struktur_org',$id);
		$this->db->update('mst_peg_struktur_org',$data);

		$this->db->where('tar_id_struktur_org_parent',$id);
		$q = $this->db->get('mst_peg_struktur_org');
   		if ($q->num_rows() > 0 ) {
			$child = $q->result_array();
   			foreach ($child as $dt) {
   				if ($status=='nonaktif') {
					$this->non_aktif_akun($dt['tar_id_struktur_org'],'nonaktif');
				}else{
					$this->non_aktif_akun($dt['tar_id_struktur_org'],'aktip');
				}
   				
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
		$data['akun']				= $this->pegorganisasi_model->get_parent_akun();

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/pegorganisasi/form_tambah_induk",$data));
		}elseif($this->pegorganisasi_model->insert_entry()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/pegorganisasi/form_tambah_induk",$data));
	}

	

	function induk_detail($id=0){
			$data 						= $this->pegorganisasi_model->get_data_akun_detail($id);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['alert_form'] 		= '';
			$data['disable']			= "disable";
			die($this->parser->parse("mst/pegorganisasi/form_detail_akun",$data));
		
		$this->keuinstansi_model->update_entry_instansi($id);
		die($this->parser->parse("mst/pegorganisasi/form_detail_akun",$data));
	}

	function akun_non_aktif_detail($id=0){
			$data 						= $this->pegorganisasi_model->get_data_akun_non_aktif_detail($id);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['alert_form'] 		= '';
			$data['disable']			= "disable";
			die($this->parser->parse("mst/pegorganisasi/form_detail_akun_non_aktif",$data));
		
		$this->keuinstansi_model->update_entry_instansi($id);
		die($this->parser->parse("mst/pegorganisasi/form_detail_akun_non_aktif",$data));
	}

	function akun_add(){
		$this->authentication->verify('mst','add');
		$this->form_validation->set_rules('tar_id_struktur_org','ID Jabatan','trim|required');
		$this->form_validation->set_rules('tar_id_struktur_org_parent','ID Jabatan Parent','trim|required');
		$this->form_validation->set_rules('tar_aktif','Status','trim|required');
		$this->form_validation->set_rules('tar_nama_posisi','Nama Jabatan','trim|required');

		if($this->form_validation->run()== TRUE){
			$this->pegorganisasi_model->akun_add();	
			echo "0";
		}else{			
			$err = validation_errors();
			echo str_replace("<p>", "", str_replace("</p>", "\n", $err));
		}	
	}

	function akun_update(){
		$this->authentication->verify('mst','edit');
		$this->form_validation->set_rules('tar_id_struktur_org','ID Jabatan','trim|required');
		$this->form_validation->set_rules('tar_id_struktur_org_parent','ID Jabatan Parent','trim|required');
		$this->form_validation->set_rules('tar_nama_posisi','Nama Jabatan','trim|required');
		$this->form_validation->set_rules('tar_aktif','Status','trim|required');

		if($this->form_validation->run()== TRUE){
			$this->pegorganisasi_model->akun_update();	
			echo "0";
		}else{			
			$err = validation_errors();
			echo str_replace("<p>", "", str_replace("</p>", "\n", $err));
		}	
	}

	function akun_delete(){
		$this->authentication->verify('mst','del');
		$this->pegorganisasi_model->akun_delete($this->input->post('tar_id_struktur_org'));				
	}
	function add_skp($id_pegorganisasi=0,$code_cl_phc=0){
		$data['action']			= "add";
		$data['kode']			= $id_pegorganisasi;
		$data['code_cl_phc']	= $code_cl_phc;
		$data['id_inv_permohonan_barang_item']=0;
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('cekpassword', 'Konfirmasi Password', 'trim|required');
        $pas1=$this->input->post('password');
        $pas2=$this->input->post('cekpassword');
		if($this->form_validation->run()== FALSE){
			
			$data					= $this->pegorganisasi_model->get_data_akun();
			$data['kode']			= $id_pegorganisasi;
			$data['code_cl_phc']	= $code_cl_phc;
			$data['action']			= "add";
			$data['notice']			= validation_errors();
			die($this->parser->parse('mst/pegorganisasi/form_skp', $data));
		}else if($pas1 != $pas2){
			die("Error|Maaf, Password tidak sama dengan Konfirmasi Password");
		}else{
			
			$this->db->where('username',$this->input->post('username'));
			$query = $this->db->get('app_users_list');

			if ($query->num_rows() > 0) {
				die("Error|Maaf, Username telah tersedia. Silahkan ganti username Anda !");
			}else{
				$code_cl = substr($code_cl_phc, 1,11);
				$values = array(
					'username' => $this->input->post('username'),
					'password' => $this->encrypt->sha1($this->input->post('password').$this->config->item('encryption_key')),
					'code' => $code_cl,
					'level' => 'kepegawaian',
					'status_active' => 1,
					'status_aproved' => 1,
					'id_pegawai' => $id_pegawai,

				);
				if($this->db->insert('app_users_list', $values)){
					$profile = array(
                      'username'     	=> $this->input->post('username'),
                      'code'         	=> $code_cl,
                      'nama'         	=> $this->input->post('username'),
                      'phone_number'    => '',
                      'email'         	=> '',
                      'status'         	=> 1
                 );
                 $this->db->insert('app_users_profile', $profile);

					die("OK|");
				}else{
					die("Error|Proses data gagal");
				}	
			}
			
		}
	}
	
}
?>