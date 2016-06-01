<?php
class Penilaiandppp extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('kepegawaian/penilaiandppp_model');
		$this->load->model('inventory/inv_barang_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
		$this->load->model('mst/invbarang_model');
	}
	
	function index(){
		$this->authentication->verify('kepegawaian','edit');
		$data['title_group'] = "Kepegawaian";
		$data['title_form'] = "Struktur Kepegawaian";
		$data['statusjabatan'] = $this->penilaiandppp_model->get_data_status();

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		$data['content'] = $this->parser->parse("kepegawaian/penilaiandppp/show",$data,true);


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
		$rows_all = $this->penilaiandppp_model->get_data();
		

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
		#$rows = $this->penilaiandppp_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$rows = $this->penilaiandppp_model->get_data();
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
		$template = $dir.'public/files/template/kepegawaian/penilaiandppp.xlsx';		
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
	
	
	
	function filter(){
		if($_POST) {
			if($this->input->post('code_cl_phc') != '') {
				$this->session->set_userdata('filter_code_cl_phc',$this->input->post('code_cl_phc'));
			}
		}
	}
	
	
	


	function edit($kode=0,$code_cl_phc=""){
		$this->authentication->verify('kepegawaian','edit');

			$data 	= $this->penilaiandppp_model->get_datapegawai($kode,$code_cl_phc); 

			$data['title_group'] 	= "Kepegawaian";
			$data['title_form']		= "Penilaian DPPP";
			$data['action']			= "edit";
			$data['kode']			= $kode;
			$data['code_cl_phc']	= $code_cl_phc;

			$data['penilaian']	  	= $this->parser->parse('kepegawaian/penilaiandppp/penilaian', $data, TRUE);
			$data['content'] 	= $this->parser->parse("kepegawaian/penilaiandppp/detail",$data,true);

			$this->template->show($data,"home");
	}
	function add_dppp($id_pegorganisasi=0,$id_dppp=0,$code_cl_phc=0){
		$data['action']			= "add";
		$data['kode']			= $id_pegorganisasi;
		$data['code_cl_phc']	= $code_cl_phc;
		$data['id_dppp']			= $id_dppp;

        $this->form_validation->set_rules('tugas', 'Tugas', 'trim|required');
        $this->form_validation->set_rules('output', 'Output', 'trim|required');
        $this->form_validation->set_rules('target', 'Target', 'trim|required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
        $this->form_validation->set_rules('biaya', 'Biaya', 'trim|required');
		if($this->form_validation->run()== FALSE){
			
			// $data					= $this->pegorganisasi_model->get_data_akun();
			$data['kode']			= $id_pegorganisasi;
			$data['code_cl_phc']	= $code_cl_phc;
			$data['id_dppp']			= $id_dppp;
			$data['action']			= "add";
			$data['notice']			= validation_errors();
			die($this->parser->parse('kepegawaian/penilaiandppp/form_dppp', $data));
		}else{
			
			$code_cl = substr($code_cl_phc, 0,12);
			$values = array(
				'id_mst_peg_struktur_org' => $id_pegorganisasi,
				'id_mst_peg_struktur_skp' => $this->urut($id_pegorganisasi),
				'tugas' => $this->input->post('tugas'),
				'ak' => '0',
				'kuant' => '1',
				'output' => $this->input->post('output'),
				'target' => $this->input->post('target'),
				'waktu' => $this->input->post('waktu'),
				'biaya' => $this->input->post('biaya'),
				'code_cl_phc' => $code_cl,
			);
			
			if($this->db->insert('mst_peg_struktur_skp', $values)){
				die("OK|");
			}else{
				die("Error|Proses data gagal");
			}	
			
		}
	}
	function edit_dppp($id_pegorganisasi=0,$id_dppp=0,$code_cl_phc=0){
		$data['action']			= "add";
		$data['kode']			= $id_pegorganisasi;
		$data['code_cl_phc']	= $code_cl_phc;
		$data['id_dppp']			= $id_dppp;

        $this->form_validation->set_rules('tugas', 'Tugas', 'trim|required');
        $this->form_validation->set_rules('output', 'Output', 'trim|required');
        $this->form_validation->set_rules('target', 'Target', 'trim|required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
        $this->form_validation->set_rules('biaya', 'Biaya', 'trim|required');
        $data					= $this->pegorganisasi_model->get_data_row_dppp($id_pegorganisasi,$id_dppp,$code_cl_phc);
		if($this->form_validation->run()== FALSE){
			
			$data					= $this->pegorganisasi_model->get_data_row_dppp($id_pegorganisasi,$id_dppp,$code_cl_phc);
			$data['kode']			= $id_pegorganisasi;
			$data['code_cl_phc']	= $code_cl_phc;
			$data['id_dppp']			= $id_dppp;
			$data['action']			= "edit";
			$data['notice']			= validation_errors();
			die($this->parser->parse('kepegawaian/penilaiandppp/form_dppp', $data));
		}else{
			
			$code_cl = substr($code_cl_phc, 0,12);
			$values = array(
				'tugas' => $this->input->post('tugas'),
				'ak' => '0',
				'kuant' => '1',
				'output' => $this->input->post('output'),
				'target' => $this->input->post('target'),
				'waktu' => $this->input->post('waktu'),
				'biaya' => $this->input->post('biaya'),
			);
			$keyup = array(
			'id_mst_peg_struktur_org' => $id_pegorganisasi,
			'id_mst_peg_struktur_skp' => $id_dppp,
			'code_cl_phc' => $code_cl
			);
			if($this->db->update('mst_peg_struktur_dppp', $values,$keyup)){
				die("OK|");
			}else{
				die("Error|Proses data gagal");
			}	
			
		}
	}
	function urut($kode){
		$this->db->select("max(id_mst_peg_struktur_skp) as max");
		$query = $this->db->get_where('mst_peg_struktur_skp',array('id_mst_peg_struktur_org'=>$kode));
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $key) {
				$data = $key->max+1;
			}
		}else{
			$data = 1;
		}
		return $data;
	}
	function json_dppp($id=""){
		$this->authentication->verify('kepegawaian','show');


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
		$rows = $this->penilaiandppp_model->get_data_dppp($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_mst_peg_struktur_org'			=> $act->id_mst_peg_struktur_org,
				'tugas'								=> $act->tugas,
				'id_mst_peg_struktur_skp'			=> $act->id_mst_peg_struktur_skp,
				'ak'								=> $act->ak,
				'kuant'								=> $act->kuant,
				'output'							=> $act->output,
				'target'							=> $act->target,
				'waktu'								=> $act->waktu,
				'biaya'								=> $act->biaya,
				'code_cl_phc'						=> $act->code_cl_phc,
				'edit'		=> 1,
				'delete'	=> 1
			);
		}

		$size = sizeof($data);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function dodel_dppp($id_org=0,$id_dppp=0,$code_cl_phc=""){
		$this->authentication->verify('kepegawaian','del');

		$this->pegorganisasi_model->delete_dppp($id_org,$id_dppp,$code_cl_phc);
	}
	

	
	
}
