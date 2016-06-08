<?php
class stuktur_kepegawaian extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('kepegawaian/stuktur_kepegawaian_model');
		$this->load->model('inventory/inv_barang_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
		$this->load->model('mst/invbarang_model');
	}
	function json_kode_jabatan(){
		$rows = $this->stuktur_kepegawaian_model->get_data_status(0);

		echo json_encode($rows);
	}
	function index(){
		$this->authentication->verify('kepegawaian','edit');
		$data['title_group'] = "Kepegawaian";
		$data['title_form'] = "Struktur Kepegawaian";
		$data['statusjabatan'] = $this->stuktur_kepegawaian_model->get_data_status();

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		$data['content'] = $this->parser->parse("kepegawaian/stuktur_kepegawaian/show",$data,true);


		$this->template->show($data,"home");
	}

	function permohonan_export(){
		
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		//[data_tabel.no;block=tbs:row]	[data_tabel.tgl]	[data_tabel.ruangan]	[data_tabel.jumlah]	[data_tabel.keterangan]	[data_tabel.status]
		
		$this->authentication->verify('kepegawaian','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal_permohonan') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		/*if($this->session->userdata('filter_code_cl_phc') != '') {
			$this->db->where('inv_permohonan_barang.code_cl_phc',$this->session->userdata('filter_code_cl_phc'));
		}*/
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('inv_permohonan_barang.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows_all = $this->stuktur_kepegawaian_model->get_data();
		

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal_permohonan') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		/*if($this->session->userdata('filter_code_cl_phc') != '') {
			$this->db->where('inv_permohonan_barang.code_cl_phc',$this->session->userdata('filter_code_cl_phc'));
		}*/
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('inv_permohonan_barang.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		#$rows = $this->stuktur_kepegawaian_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$rows = $this->stuktur_kepegawaian_model->get_data();
		$data = array();
		$no=1;
		
		$data_tabel = array();
		foreach($rows as $act) {
			
			$data_tabel[] = array(
				'no'		=> $no++,								
				'tgl'		=> date("d-m-Y",strtotime($act->tanggal_permohonan)),				
				'ruangan'	=> $act->nama_ruangan,
				'jumlah'	=> $act->jumlah_unit,
				'totalharga'=> number_format($act->totalharga),
				'keterangan'=> $act->keterangan,
				'status'	=> $act->value				
			);
		}

		
		
		/*
		$data_tabel[] = array('no'=> '1', 'tgl'=>'10/10/2010' , 'ruangan'=>'Hill'      , 'jumlah'=>'19', 'keterangan'=>'bagus', 'status'=>'bagus');
		$data_tabel[] = array('no'=> '2', 'tgl'=>'10/10/2010' , 'ruangan'=>'Hill'      , 'jumlah'=>'19', 'keterangan'=>'bagus', 'status'=>'bagus');
		$data_tabel[] = array('no'=> '3', 'tgl'=>'10/10/2010' , 'ruangan'=>'Hill'      , 'jumlah'=>'19', 'keterangan'=>'bagus', 'status'=>'bagus');
		$data_tabel[] = array('no'=> '4', 'tgl'=>'10/10/2010' , 'ruangan'=>'Hill'      , 'jumlah'=>'19', 'keterangan'=>'bagus', 'status'=>'bagus');
		*/
		$puskes = $this->input->post('puskes'); 
		if(empty($puskes) or $puskes == 'Pilih Puskesmas'){
			$nama = 'Semua Data Puskesmas';
		}else{
			$nama = $this->input->post('puskes');
		}
		$data_puskesmas[] = array('nama_puskesmas' => $nama);
		
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/kepegawaian/stuktur_kepegawaian.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
		//print_r($data_tabel);
		//die();
		// Merge data in the first sheet
		$TBS->MergeBlock('a', $data_tabel);
		$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = uniqid();
		$output_file_name = 'public/files/hasil/hasil_export_'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;
		
	}
	
	
	function json(){
		$this->authentication->verify('kepegawaian','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal_permohonan') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'keterangan') {
					$this->db->like('inv_permohonan_barang.'.$field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('pegawai.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		

		$rows_all = $this->stuktur_kepegawaian_model->get_data();


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal_permohonan') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'keterangan') {
					$this->db->like('inv_permohonan_barang.'.$field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
	
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('pegawai.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows = $this->stuktur_kepegawaian_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no=1;
		foreach($rows as $act) {
			$data[] = array(
				'no'					=> $no++,
				'nip_nit' 				=> $act->nip_nit,
				'nama' 					=> $act->gelar_depan.' '.$act->nama.' '.$act->gelar_belakang,
				'id_mst_peg_golruang'	=> $act->id_mst_peg_golruang,
				'tar_nama_posisi'		=> $act->tar_nama_posisi,
				'code_cl_phc'			=> $act->code_cl_phc,
				'ruang'					=> ucwords(strtolower($act->ruang)),
				'username'				=> $act->username,
				'id_pegawai'			=> $act->id_pegawai,
				'detail'	=> 1,
			);
		}


		
		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function filter(){
		if($_POST) {
			if($this->input->post('code_cl_phc') != '') {
				$this->session->set_userdata('filter_code_cl_phc',$this->input->post('code_cl_phc'));
			}
		}
	}
	
	
	

	function add($id_pegawai=0,$code_cl_phc=0){
		$data['action']			= "add";
		$data['kode']			= $id_pegawai;
		$data['code_cl_phc']	= $code_cl_phc;
		$data['id_inv_permohonan_barang_item']=0;
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('cekpassword', 'Konfirmasi Password', 'trim|required');
        $pas1=$this->input->post('password');
        $pas2=$this->input->post('cekpassword');
		if($this->form_validation->run()== FALSE){
			
			$data					= $this->stuktur_kepegawaian_model->get_datapegawai($id_pegawai,$code_cl_phc);
			$data['kode']			= $id_pegawai;
			$data['code_cl_phc']	= $code_cl_phc;
			$data['action']			= "add";
			$data['notice']			= validation_errors();
			die($this->parser->parse('kepegawaian/stuktur_kepegawaian/login_form', $data));
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
					'level' => 'pegawai',
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

	function edit($kode=0,$code_cl_phc=""){
		$this->authentication->verify('kepegawaian','edit');

        $this->form_validation->set_rules('tgl', 'Tanggal Permohonan', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_rules('codepus', 'Puskesmas', 'trim|required');
        $this->form_validation->set_rules('ruangan', 'Ruangan', 'trim');
        $this->form_validation->set_rules('statuspengadaan', 'Status Permohonan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			$data 	= $this->stuktur_kepegawaian_model->get_data_row($code_cl_phc,$kode); 

			$data['title_group'] 	= "kepegawaian";
			$data['title_form']		= "Ubah Permohonan Barang";
			$data['action']			= "edit";
			$data['kode']			= $kode;
			$data['code_cl_phc']	= $code_cl_phc;

			$this->db->where('code',$code_cl_phc);
			$data['kodepuskesmas'] 	= $this->puskesmas_model->get_data();
			$data['statusjabatan'] = $this->stuktur_kepegawaian_model->get_data_status();

			$data['barang']	  	= $this->parser->parse('kepegawaian/stuktur_kepegawaian/barang', $data, TRUE);
			$data['content'] 	= $this->parser->parse("kepegawaian/stuktur_kepegawaian/edit",$data,true);
		}elseif($this->stuktur_kepegawaian_model->update_entry($kode,$code_cl_phc)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."kepegawaian/stuktur_kepegawaian/edit/".$kode."/".$code_cl_phc);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."kepegawaian/stuktur_kepegawaian/edit/".$kode."/".$code_cl_phc);
		}

		$this->template->show($data,"home");
	}

	
	function updatestatus(){
		$this->authentication->verify('kepegawaian','edit');
		$this->stuktur_kepegawaian_model->update_status();				
	}
	

	
	
}
