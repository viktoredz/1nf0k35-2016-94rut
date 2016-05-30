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
	
	function index(){
		$this->authentication->verify('inventory','edit');
		$data['title_group'] = "Inventory";
		$data['title_form'] = "Daftar Permohonan Barang";
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
		
		$this->authentication->verify('inventory','show');


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
	
	function permohonan_detail_export(){
		$code_cl_phc = $this->input->post('code_cl_phc');
		$id = $this->input->post('kode');
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		//[data_tabel.no;block=tbs:row]	[data_tabel.tgl]	[data_tabel.ruangan]	[data_tabel.jumlah]	[data_tabel.keterangan]	[data_tabel.status]
		
		$this->authentication->verify('inventory','show');

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
		
		#$rows = $this->stuktur_kepegawaian_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		
		$this->db->where('code_cl_phc',$code_cl_phc);
		$activity = $this->stuktur_kepegawaian_model->getItem('inv_permohonan_barang_item', array('id_inv_permohonan_barang'=>$id))->result();
		$data = array();
		$no=1;
		
		$data_tabel = array();
		foreach($activity as $act) {
			$data_tabel[] = array(
				'no'							=> $no++,				
				'nama_barang'   				=> $act->nama_barang,
				'jumlah'						=> $act->jumlah,
				'harga'							=> number_format($act->harga,2),
				'subtotal'						=> number_format($act->harga*$act->jumlah,2),
				'keterangan'					=> $act->keterangan				
			);
		}

		$nama_puskesmas = $this->input->post('nama_puskesmas');
		if(empty($nama_puskesmas) or $nama_puskesmas == 'Pilih Puskesmas'){
			$nama = 'Semua Data Puskesmas';
		}else{
			$nama = $this->input->post('nama_puskesmas');
		}
		$tanggal = $this->input->post('tanggal');
		$keterangan = $this->input->post('keterangan');
		$ruang = $this->input->post('ruang');
		$puskesmas = $nama;
		$jumlahtotal= $this->stuktur_kepegawaian_model->totalharga($this->input->post('kode'));
		#$data_puskesmas[] = array('nama_puskesmas' => $nama, 'tanggal'=> $tanggal, 'keterangan'=>$keterangan, 'ruang'=>$ruang);
		$data_puskesmas['nama_puskesmas'] = $nama;
		$data_puskesmas['tanggal'] = $tanggal;
		$data_puskesmas['ruang'] = $ruang;
		$data_puskesmas['keterangan'] = $keterangan;
		$data_puskesmas['totalharga'] = 'Rp. '.number_format($jumlahtotal['totalharga'],2);
		$data_puskesmas['totaljumlah'] = $jumlahtotal['totaljumlah'];

		
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data_puskesmas;
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/kepegawaian/stuktur_kepegawaian_detail.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		
		// Merge data in the first sheet
		$TBS->MergeBlock('a', $data_tabel);
		#$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = date('Y-m-d-H-i-s');
		$output_file_name = 'public/files/hasil/hasil_detail_export_'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;

		/*
		$output_file_name = dirname(__FILE__).'\..\..\..\public\files\hasil\hasil_detail_export_'.$code.'.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
		
		echo base_url().'public/files/hasil/hasil_detail_export_'.$code.'.xlsx' ;
		*/
		
	}
	

	function json(){
		$this->authentication->verify('inventory','show');


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
				'detail'	=> 1,
				'edit'		=> 1,
				'delete'	=> 1
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
	
	
	

	function add(){
		$this->authentication->verify('inventory','add');

		$this->form_validation->set_rules('id_inv_permohonan_barang', 'Kode Lokasi', 'trim|required');
        $this->form_validation->set_rules('tgl', 'Tanggal Permohonan', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
        $this->form_validation->set_rules('codepus', 'Puskesmas', 'trim|required');

		if($this->form_validation->run()== FALSE){
			$data['title_group'] = "Inventory";
			$data['title_form']="Tambah Permohonan Barang";
			$data['action']="add";
			$data['kode']="";

			$kodepuskesmas = $this->session->userdata('puskesmas');
			if(strlen($kodepuskesmas) == 4){
				$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
			}else {
				$this->db->where('code','P'.$kodepuskesmas);
			}
			$data['kodepuskesmas'] = $this->puskesmas_model->get_data();
		
			$data['content'] = $this->parser->parse("kepegawaian/stuktur_kepegawaian/form",$data,true);
		}elseif($id = $this->stuktur_kepegawaian_model->insert_entry()){
			$this->session->set_flashdata('alert', 'Save data successful...');
			redirect(base_url().'kepegawaian/stuktur_kepegawaian/edit/'. $id.'/'.$this->input->post('codepus'));
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."kepegawaian/stuktur_kepegawaian/add");
		}

		$this->template->show($data,"home");
	}

	function edit($kode=0,$code_cl_phc=""){
		$this->authentication->verify('inventory','edit');

        $this->form_validation->set_rules('tgl', 'Tanggal Permohonan', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_rules('codepus', 'Puskesmas', 'trim|required');
        $this->form_validation->set_rules('ruangan', 'Ruangan', 'trim');
        $this->form_validation->set_rules('statuspengadaan', 'Status Permohonan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			$data 	= $this->stuktur_kepegawaian_model->get_data_row($code_cl_phc,$kode); 

			$data['title_group'] 	= "Inventory";
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

	function detail($kode=0,$code_cl_phc=""){
		$this->authentication->verify('inventory','edit');

        $this->form_validation->set_rules('tgl', 'Tanggal Permohonan', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        $this->form_validation->set_rules('codepus', 'Puskesmas', 'trim|required');
        $this->form_validation->set_rules('ruangan', 'Ruangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			$data 	= $this->stuktur_kepegawaian_model->get_data_row($code_cl_phc,$kode); 

			$data['title_group'] 	= "Inventory";
			$data['title_form']		= "Ubah Permohonan Barang";
			$data['action']			= "edit";
			$data['kode']			= $kode;
			$data['code_cl_phc']	= $code_cl_phc;

			$this->db->where('code',$code_cl_phc);
			$data['kodepuskesmas'] 	= $this->puskesmas_model->get_data();
			$data['ruang']		= $this->stuktur_kepegawaian_model->get_detail_ruang($kode, $code_cl_phc);
			$data['barang']	  	= $this->parser->parse('kepegawaian/stuktur_kepegawaian/detail_barang', $data, TRUE);
			$data['content'] 	= $this->parser->parse("kepegawaian/stuktur_kepegawaian/detail",$data,true);
		}elseif($this->stuktur_kepegawaian_model->update_entry($kode,$code_cl_phc)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."kepegawaian/stuktur_kepegawaian/edit/".$kode."/".$code_cl_phc);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."kepegawaian/stuktur_kepegawaian/edit/".$kode."/".$code_cl_phc);
		}

		$this->template->show($data,"home");
	}

	
	function dodel($kode=0,$code_cl_phc=""){
		$this->authentication->verify('inventory','del');

		if($this->stuktur_kepegawaian_model->delete_entry($kode,$code_cl_phc)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
			redirect(base_url()."kepegawaian/stuktur_kepegawaian");
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
			redirect(base_url()."kepegawaian/stuktur_kepegawaian");
		}
	}
	function updatestatus(){
		//$this->authentication->verify('inventory','edit');
		$this->stuktur_kepegawaian_model->update_status();				
	}
	function dodelpermohonan($kode=0,$code_cl_phc="",$kode_item=""){
		$this->authentication->verify('inventory','del');

		if($this->stuktur_kepegawaian_model->delete_entryitem($kode,$code_cl_phc,$kode_item)){
			$dataupdate['jumlah_unit']= $this->stuktur_kepegawaian_model->sum_jumlah_item( $kode,$code_cl_phc);
			$key['id_inv_permohonan_barang'] = $kode;
			$this->db->update("inv_permohonan_barang",$dataupdate,$key);
			$this->session->set_flashdata('alert', 'Delete data ('.$kode_item.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	public function barang($id = 0,$code_cl_phc="")
	{
		$data	  	= array();
		$filter 	= array();
		$filterLike = array();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'date_received' || $field == 'date_accepted') {
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
		$this->db->where('code_cl_phc',$code_cl_phc);
		$activity = $this->stuktur_kepegawaian_model->getItem('inv_permohonan_barang_item', array('id_inv_permohonan_barang'=>$id))->result();
		$no=1;
		foreach($activity as $act) {
			$data[] = array(
				'no'							=> $no++,
				'id_inv_permohonan_barang_item' => $act->id_inv_permohonan_barang_item,
				'nama_barang'   				=> $act->nama_barang,
				'jumlah'						=> $act->jumlah,
				'keterangan'					=> $act->keterangan,
				'harga'							=> number_format($act->harga,2),
				'subtotal'						=> number_format($act->harga*$act->jumlah,2),
				'id_inv_permohonan_barang'		=> $act->id_inv_permohonan_barang,
				'code_mst_inv_barang'   		=> substr(chunk_split($act->code_mst_inv_barang, 2, '.'),0,14),
				'edit'		=> 1,
				'delete'	=> 1
			);
		}

		$json = array(
			'TotalRows' => sizeof($data),
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	public function add_barang($kode=0,$code_cl_phc="")
	{	
		$data['action']			= "add";
		$data['kode']			= $kode;
		$data['code_cl_phc']	= $code_cl_phc;
		$data['id_inv_permohonan_barang_item']=0;
        $this->form_validation->set_rules('code_mst_inv_barang', 'Kode Barang', 'trim|required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
        $this->form_validation->set_rules('pilihan_satuan_barang', 'Pilihan Satuan Barang', 'trim|required');
        $this->form_validation->set_rules('rekening', 'Rekening', 'trim');
        $this->form_validation->set_rules('merk_tipe', 'Merek Tipe', 'trim');
        $this->form_validation->set_rules('jqxinput', 'jqxinput Tipe', 'trim');

        $this->form_validation->set_rules('v_kode_barang', 'v_kode_barang', 'trim');
        $this->form_validation->set_rules('code_mst_inv', 'code_mst_inv', 'trim');

		if($this->form_validation->run()== FALSE){
			$data['kodebarang']		= $this->stuktur_kepegawaian_model->get_databarang();
			$data['notice']			= validation_errors();
			$data['pilihan_satuan_barang_']	= $this->inv_barang_model->get_data_pilihan('satuan');
			die($this->parser->parse('kepegawaian/stuktur_kepegawaian/barang_form', $data));
		}else{
			$values = array(
				'id_inv_permohonan_barang_item'=>$this->stuktur_kepegawaian_model->get_permohonanbarangitem_id($kode),
				'code_mst_inv_barang' => $this->input->post('code_mst_inv_barang'),
				'nama_barang' => $this->input->post('nama_barang'),
				'jumlah' => $this->input->post('jumlah'),
				'harga' => $this->input->post('harga'),
				'rekening' => $this->input->post('rekening'),
				'merk_tipe' => $this->input->post('merk_tipe'),
				'keterangan' => $this->input->post('keterangan'),
				'pilihan_satuan_barang' => $this->input->post('pilihan_satuan_barang'),
				'code_cl_phc' => $code_cl_phc,
				'id_inv_permohonan_barang' => $kode
			);
			if($this->db->insert('inv_permohonan_barang_item', $values)){
				$dataupdate['jumlah_unit']= $this->stuktur_kepegawaian_model->sum_jumlah_item( $kode,$code_cl_phc);
				$key['id_inv_permohonan_barang'] = $kode;
        		$this->db->update("inv_permohonan_barang",$dataupdate,$key);

				die("OK|");
			}else{
				die("Error|Proses data gagal");
			}
		}
	}
	public function edit_barang($kode=0,$code_cl_phc="",$id_inv_permohonan_barang_item=0)
	{
		$data['action']			= "edit";
		$data['kode']			= $kode;
		$data['code_cl_phc']	= $code_cl_phc;
		$data['id_inv_permohonan_barang_item']	= $id_inv_permohonan_barang_item;
		$this->form_validation->set_rules('code_mst_inv_barang', 'Kode Barang', 'trim|required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
        $this->form_validation->set_rules('pilihan_satuan_barang', 'Pilihan Satuan Barang', 'trim|required');

		if($this->form_validation->run()== FALSE){
			$data 					= $this->stuktur_kepegawaian_model->get_data_barang_edit($code_cl_phc, $kode, $id_inv_permohonan_barang_item); 
			$data['kodebarang']		= $this->stuktur_kepegawaian_model->get_databarang();
			$data['notice']			= validation_errors();
			$data['action']			= "edit";
			$data['kode']			= $kode;
			$data['code_cl_phc']	= $code_cl_phc;
			$data['pilihan_satuan_barang_']	= $this->inv_barang_model->get_data_pilihan('satuan');
			$data['disable']			= "disable";
			die($this->parser->parse('kepegawaian/stuktur_kepegawaian/barang_form', $data));
		}else{
			$values = array(
				'code_mst_inv_barang' 	=> $this->input->post('code_mst_inv_barang'),
				'nama_barang' 			=> $this->input->post('nama_barang'),
				'jumlah' 				=> $this->input->post('jumlah'),
				'harga' 				=> $this->input->post('harga'),
				'rekening' 				=> $this->input->post('rekening'),
				'merk_tipe' 			=> $this->input->post('merk_tipe'),
				'pilihan_satuan_barang' => $this->input->post('pilihan_satuan_barang'),
				'keterangan' 			=> $this->input->post('keterangan')
			);

			if($this->db->update('inv_permohonan_barang_item', $values,array('id_inv_permohonan_barang_item' => $id_inv_permohonan_barang_item,'code_cl_phc'=>$code_cl_phc,'id_inv_permohonan_barang'=>$kode))){
				$dataupdate['jumlah_unit']= $this->stuktur_kepegawaian_model->sum_jumlah_item( $kode,$code_cl_phc);
				$key['id_inv_permohonan_barang'] = $kode;
        		$this->db->update("inv_permohonan_barang",$dataupdate,$key);
				die("OK|");
			}else{
				die("Error|Proses data gagal");
			}
		}
		
	}
	
	function dodel_barang($kode=0,$code_cl_phc="",$id_inv_permohonan_barang_item=0){
		$this->authentication->verify('inventory','del');

		if($this->stuktur_kepegawaian_model->delete_entry($kode,$code_cl_phc)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
			redirect(base_url()."kepegawaian/stuktur_kepegawaian");
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
			redirect(base_url()."kepegawaian/stuktur_kepegawaian");
		}
	}

	
	
}
