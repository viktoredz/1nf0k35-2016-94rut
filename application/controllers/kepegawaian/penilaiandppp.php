<?php
class Penilaiandppp extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('kepegawaian/penilaiandppp_model');
		$this->load->model('mst/puskesmas_model');
	}
	
	function index(){
		$this->authentication->verify('kepegawaian','edit');
		$data['title_group'] = "Kepegawaian";
		$data['title_form'] = "Penilaian DPPP";
		

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] 	= $this->puskesmas_model->get_data();
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
		$rows = $this->penilaiandppp_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
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
	
	
	


	function edit($id_pegawai=0,$code_cl_phc=""){
		$this->authentication->verify('kepegawaian','edit');

			$data 	= $this->penilaiandppp_model->get_datapegawai($id_pegawai,$code_cl_phc); 

			$data['title_group'] 	= "Kepegawaian";
			$data['title_form']		= "Penilaian DPPP";
			$data['action']			= "edit";
			$data['kode']			= $id_pegawai;
			$data['code_cl_phc']	= $code_cl_phc;
			$data['tahun']	= '0';
			$data['id_mst_peg_struktur_skp']	= '0';
			$data['idlogin']							= $this->penilaiandppp_model->idlogin();

			$data['penilaian']	  	= $this->parser->parse('kepegawaian/penilaiandppp/penilaian', $data, TRUE);
			$data['content'] 	= $this->parser->parse("kepegawaian/penilaiandppp/detail",$data,true);

			$this->template->show($data,"home");
	}

	function add_dppp($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$id_mst_peg_struktur_skp=0){
		$data['action']				= "add";
		$data['id_pegawai']			= $id_pegawai;
		$data['tahun']				= $tahun;
		$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
		$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;
		$data['idlogin']							= $this->penilaiandppp_model->idlogin();
		$data										= $this->penilaiandppp_model->getusername($id_pegawai);

        $this->form_validation->set_rules('tgl_dibuat', 'Tanggal dibuat', 'trim|required');
        $this->form_validation->set_rules('tgl_diterima_atasan', 'tanggal diterima Atasan', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'id Pegawai', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_penilai', 'id_penilai', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_penilai_atasan', 'id_penilai_atasan', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('tanggapan_tgl', 'Tanggal Tanggapan', 'trim|required');
        $this->form_validation->set_rules('tanggapan', 'Tanggapan', 'trim|required');
        $this->form_validation->set_rules('username', 'username', 'trim');
        $userdataname = $this->session->userdata('username');
        $username = $this->input->post('username');
		if ($username == $userdataname) {
        	$this->form_validation->set_rules('keberatan_tgl', 'Tanggal Keberatan', 'trim|required');
        	$this->form_validation->set_rules('keberatan', 'Keberatan', 'trim|required');
    	}
        $this->form_validation->set_rules('keputusan_tgl', 'Tanggal Keputusan', 'trim|required');
        $this->form_validation->set_rules('keputusan', 'Keputusan', 'trim|required');
        $this->form_validation->set_rules('rekomendasi', 'Rekomendasi', 'trim|required');
        $this->form_validation->set_rules('tgl_diterima', 'Tanggal di Terima', 'trim|required');
        $this->form_validation->set_rules('pelayanan', 'Pelayanan', 'trim|required');
        $this->form_validation->set_rules('skp', 'SKP', 'trim|required');
        $this->form_validation->set_rules('integritas', 'integritas', 'trim|required');
        $this->form_validation->set_rules('komitmen', 'Komitmen', 'trim|required');
        $this->form_validation->set_rules('disiplin', 'Disiplin', 'trim|required');
        $this->form_validation->set_rules('kerjasama', 'Kerjasama', 'trim|required');
        $this->form_validation->set_rules('kepemimpinan', 'Kepemimpinan', 'trim|required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
        $this->form_validation->set_rules('ratarata', 'Rata-rata', 'trim|required');
        $this->form_validation->set_rules('nilai_prestasi', 'Nilai Prestasi', 'trim|required');
        $this->form_validation->set_rules('nilai_skp', 'Nilai SKP', 'trim');
        $this->form_validation->set_rules('nilai_pelayanan', 'Nilai Pelayanan', 'trim');
        $this->form_validation->set_rules('nilai_integritas', 'Nilai Integritas', 'trim');
        $this->form_validation->set_rules('nilai_komitmen', 'Nilai Komitmen', 'trim');
        $this->form_validation->set_rules('nilai_disiplin', 'Nilai Disiplin', 'trim');
        $this->form_validation->set_rules('nilai_kerjasama', 'Nilai Kerjasama', 'trim');
        $this->form_validation->set_rules('nilai_kepemimpinan', 'Kilai Kepemimpinan', 'trim');
        $this->form_validation->set_rules('nilai_jumlah', 'Nilai Jumlah', 'trim');
        $this->form_validation->set_rules('nilai_ratarata', 'Nilai Rata-rata', 'trim');
        $this->form_validation->set_rules('nilai_nilai_prestasi', 'Nilai Prestasi', 'trim');
        
		if($this->form_validation->run()== FALSE){

			$data['action']				= "add";
			$data['id_pegawai']			= $id_pegawai;
			$data['tahun']				= $tahun;
			$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
			$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;
			$data['idlogin']							= $this->penilaiandppp_model->idlogin();
			$data['notice']							= validation_errors();
			die($this->parser->parse('kepegawaian/penilaiandppp/form', $data));
		}else{
			$tanggapan_t = explode("-", $this->input->post('tanggapan_tgl'));
			$tanggapan_tgl = $tanggapan_t[2].'-'.$keberatan_t[1].'-'.$tanggapan_t[0];
			$tgl_di = explode("-", $this->input->post('tgl_dibuat'));
			$tgl_dibuat = $tgl_di[2].'-'.$tgl_di[1].'-'.$tgl_di[0];
			$tgl_dite = explode("-", $this->input->post('tgl_diterima_atasan'));
			$tgl_diterima_atasan = $tgl_dite[2].'-'.$tgl_dite[1].'-'.$tgl_dite[0];
			$keputu = explode("-", $this->input->post('keputusan_tgl'));
			$keputusan_tgl = $keputu[2].'-'.$keputu[1].'-'.$keputu[0];
			$tgl_diterim = explode("-", $this->input->post('tgl_diterima'));
			$tgl_diterima = $tgl_diterim[2].'-'.$tgl_diterim[1].'-'.$tgl_diterim[0];
			
			$values = array(
				'id_pegawai' 			=> $id_pegawai,
				'tgl_dibuat' 			=> $tgl_dibuat,
				'tgl_diterima_atasan' 	=> $tgl_diterima_atasan,
				'id_pegawai_penilai' 	=> $this->input->post('id_pegawai_penilai'),
				'id_pegawai_penilai_atasan' 					=> $this->input->post('id_pegawai_penilai_atasan'),
				'tahun' 				=> $this->input->post('tahun'),
				'tanggapan' 			=> $this->input->post('tanggapan'),
				'tanggapan_tgl' 		=> $this->input->post('tanggapan_tgl'),
				'keputusan_tgl' 		=> $keputusan_tgl,
				'keputusan' 			=> $this->input->post('keputusan'),
				'rekomendasi' 			=> $this->input->post('rekomendasi'),
				'skp' 					=> $this->input->post('skp'),
				'integritas' 			=> $this->input->post('integritas'),
				'komitmen' 				=> $this->input->post('komitmen'),
				'pelayanan' 			=> $this->input->post('pelayanan'),
				'disiplin' 				=> $this->input->post('disiplin'),
				'kerjasama' 			=> $this->input->post('kerjasama'),
				'kepemimpinan' 			=> $this->input->post('kepemimpinan'),
				'jumlah' 				=> $this->input->post('jumlah'),
				'ratarata' 				=> $this->input->post('ratarata'),
				'nilai_prestasi' 		=> $this->input->post('nilai_prestasi')
			);
			$userdataname = $this->session->userdata('username');
        	$username = $this->input->post('username');
        	$keberatan_t = explode("-", $this->input->post('keberatan_tgl'));
			$keberatan_tgl = $keberatan_t[2].'-'.$keberatan_t[1].'-'.$keberatan_t[0];
			if ($username == $userdataname) {
				$valuestanggapan = array(
						'keberatan_tgl' 		=> $keberatan_tgl,
						'keberatan' 			=> $this->input->post('keberatan')
					);
				$datainsert = array_merge($values,$valuestanggapan);
			}else{
				$datainsert = $values;
			}
			
			if($this->db->insert('pegawai_dp3', $values)){
				die("OK|");
			}else{
				die("Error|Proses data gagal");
			}	
			
		}
	}
	function edit_dppp($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$id_mst_peg_struktur_skp=0){
		$data['action']				= "edit";
		$data['id_pegawai']			= $id_pegawai;
		$data['tahun']				= $tahun;
		$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
		$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;

        $this->form_validation->set_rules('tugas', 'Tugas', 'trim|required');
        $this->form_validation->set_rules('output', 'Output', 'trim|required');
        $this->form_validation->set_rules('target', 'Target', 'trim|required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
        $this->form_validation->set_rules('biaya', 'Biaya', 'trim|required');
        $data					= $this->penilaiandppp_model->get_data_row_dppp($id_pegorganisasi,$id_dppp,$code_cl_phc);
		if($this->form_validation->run()== FALSE){
			
			$data					= $this->penilaiandppp_model->get_data_row_dppp($id_pegorganisasi,$id_dppp,$code_cl_phc);
			$data['action']				= "edit";
			$data['id_pegawai']			= $id_pegawai;
			$data['tahun']				= $tahun;
			$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
			$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;
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
	function json_dppp($id="",$tahun=''){
		$this->authentication->verify('kepegawaian','show');


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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('pegawai.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		

		$rows_all = $this->penilaiandppp_model->get_data_detail($id,'2016');


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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('pegawai.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows = $this->penilaiandppp_model->get_data_detail($id,'2016',$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_pegawai'						=> $act->id_pegawai,
				'tahun'								=> $act->tahun,
				'id_pegawai_penilai'				=> $act->id_pegawai_penilai,
				'id_pegawai_penilai_atasan' 		=> $act->id_pegawai_penilai_atasan,
				'skp'								=> $act->skp,
				'namapegawai'						=> $act->namapegawai,
				'nama_penilai'						=> $act->nama_penilai,
				'namaatasanpenilai'					=> $act->namaatasanpenilai,
				'pelayanan'							=> $act->pelayanan,
				'integritas'						=> $act->integritas,
				'komitmen'							=> $act->komitmen,
				'disiplin'							=> $act->disiplin,
				'kerjasama'							=> $act->kerjasama,
				'kepemimpinan'						=> $act->kepemimpinan,
				'jumlah'							=> $act->jumlah,
				'ratarata'							=> $act->ratarata,
				'nilai_prestasi'					=> $act->nilai_prestasi,
				'keberatan'							=> $act->keberatan,
				'keberatan_tgl'						=> $act->keberatan_tgl,
				'tanggapan'							=> $act->tanggapan,
				'tanggapan_tgl'						=> $act->tanggapan_tgl,
				'keputusan_tgl'						=> $act->keputusan_tgl,
				'rekomendasi'						=> $act->rekomendasi,
				'tgl_diterima'						=> $act->tgl_diterima,
				'tgl_dibuat'						=> $act->tgl_dibuat,
				'tgl_diterima_atasan'				=> $act->tgl_diterima_atasan,
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
	function dodel_dppp($id_org=0,$id_dppp=0,$code_cl_phc=""){
		$this->authentication->verify('kepegawaian','del');

		$this->penilaiandppp_model->delete_dppp($id_org,$id_dppp,$code_cl_phc);
	}
	function nipterakhirpegawai($id=0){
		$this->db->order_by('tmt','desc');
		$this->db->where('pegawai_pangkat.id_pegawai',$id);
		$this->db->select("cl_district.value,nip_nit,id_mst_peg_golruang,ruang,IF(jabatanstruktural.sk_status = 'pengangkatan' AND jabatanfungsional.sk_status = 'pengangkatan', CONCAT(jabatanstruktural.tar_nama_struktural,'-', jabatanfungsional.tar_nama_fungsional),(IF(jabatanstruktural.sk_status = 'pengangkatan', jabatanstruktural.tar_nama_struktural, (IF(jabatanfungsional.sk_status = 'pengangkatan', jabatanfungsional.tar_nama_fungsional, '-'))))) AS namajabatan");
		$this->db->join('mst_peg_golruang','mst_peg_golruang.id_golongan = pegawai_pangkat.id_mst_peg_golruang','left');
		$this->db->join('cl_district','cl_district.code = substr(pegawai_pangkat.code_cl_phc,2,4)','left');
		$this->db->join("(SELECT  id_pegawai, sk_status, tar_eselon, mst_peg_struktural.tar_nama_struktural, CONCAT(tmt, id_pegawai) AS jabatanterakhirstuktural, tmt AS tmtstruktural FROM pegawai_jabatan LEFT JOIN mst_peg_struktural ON pegawai_jabatan.id_mst_peg_struktural = mst_peg_struktural.tar_id_struktural WHERE jenis = 'STRUKTURAL' AND CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM
                pegawai_jabatan WHERE jenis = 'STRUKTURAL' GROUP BY id_pegawai)) jabatanstruktural","jabatanstruktural.id_pegawai = pegawai_pangkat.id_pegawai",'left');
        $this->db->join("(SELECT  id_pegawai, sk_status, mst_peg_fungsional.tar_nama_fungsional, CONCAT(tmt, id_pegawai) AS jabatanterakhirfungsional,
            tmt AS tmtfungsional FROM pegawai_jabatan LEFT JOIN mst_peg_fungsional ON pegawai_jabatan.id_mst_peg_fungsional = mst_peg_fungsional.tar_id_fungsional WHERE jenis LIKE 'FUNGSIONAL%' AND CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_jabatan WHERE jenis LIKE 'FUNGSIONAL%' GROUP BY id_pegawai)) jabatanfungsional","jabatanfungsional.id_pegawai = pegawai_pangkat.id_pegawai","left");
		$query = $this->db->get('pegawai_pangkat',1);
		foreach ($query->result() as $q) {
			$nipterakhir[] = array(
				'nip' => $q->nip_nit,  
				'pangkat' => $q->id_mst_peg_golruang.' - '.$q->ruang,  
				'jabatan' => $q->namajabatan,  
				'uk' => 'Dinas Kesehatan '.$q->value,  
			);
			echo json_encode($nipterakhir);
		}
	}
	function nipterakhirpenilai($id=0){
		$this->db->order_by('tmt','desc');
		$this->db->where('pegawai_pangkat.id_pegawai',$id);
		$this->db->select("pegawai.nama,pegawai.gelar_depan,pegawai.gelar_belakang,cl_district.value,nip_nit,id_mst_peg_golruang,ruang,IF(jabatanstruktural.sk_status = 'pengangkatan' AND jabatanfungsional.sk_status = 'pengangkatan', CONCAT(jabatanstruktural.tar_nama_struktural,'-', jabatanfungsional.tar_nama_fungsional),(IF(jabatanstruktural.sk_status = 'pengangkatan', jabatanstruktural.tar_nama_struktural, (IF(jabatanfungsional.sk_status = 'pengangkatan', jabatanfungsional.tar_nama_fungsional, '-'))))) AS namajabatan,ifnull((select id_pegawai from pegawai_struktur where tar_id_struktur_org = (select tar_id_struktur_org_parent from mst_peg_struktur_org where tar_id_struktur_org = (SELECT 
            tar_id_struktur_org FROM pegawai_struktur WHERE id_pegawai = pegawai_pangkat.id_pegawai))),$id) AS id_atasanpenilai");
		$this->db->join('mst_peg_golruang','mst_peg_golruang.id_golongan = pegawai_pangkat.id_mst_peg_golruang','left');
		$this->db->join('pegawai','pegawai.id_pegawai = pegawai_pangkat.id_pegawai','left');
		$this->db->join('cl_district','cl_district.code = substr(pegawai_pangkat.code_cl_phc,2,4)','left');
		$this->db->join("(SELECT  id_pegawai, sk_status, tar_eselon, mst_peg_struktural.tar_nama_struktural, CONCAT(tmt, id_pegawai) AS jabatanterakhirstuktural, tmt AS tmtstruktural FROM pegawai_jabatan LEFT JOIN mst_peg_struktural ON pegawai_jabatan.id_mst_peg_struktural = mst_peg_struktural.tar_id_struktural WHERE jenis = 'STRUKTURAL' AND CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM
                pegawai_jabatan WHERE jenis = 'STRUKTURAL' GROUP BY id_pegawai)) jabatanstruktural","jabatanstruktural.id_pegawai = pegawai_pangkat.id_pegawai",'left');
        $this->db->join("(SELECT  id_pegawai, sk_status, mst_peg_fungsional.tar_nama_fungsional, CONCAT(tmt, id_pegawai) AS jabatanterakhirfungsional,
            tmt AS tmtfungsional FROM pegawai_jabatan LEFT JOIN mst_peg_fungsional ON pegawai_jabatan.id_mst_peg_fungsional = mst_peg_fungsional.tar_id_fungsional WHERE jenis LIKE 'FUNGSIONAL%' AND CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_jabatan WHERE jenis LIKE 'FUNGSIONAL%' GROUP BY id_pegawai)) jabatanfungsional","jabatanfungsional.id_pegawai = pegawai_pangkat.id_pegawai","left");
		$query = $this->db->get('pegawai_pangkat',1);
		
		foreach ($query->result() as $q) {
			$nipterakhir[] = array(
				'namaterakhir' => $q->gelar_depan.' '.$q->nama.' '.$q->gelar_belakang,  
				'nipterakhir' => $q->nip_nit,  
				'pangkatterakhir' => $q->id_mst_peg_golruang.' - '.$q->ruang,  
				'jabatanterakhir' => $q->namajabatan,  
				'ukterakhir' => 'Dinas Kesehatan '.$q->value,    
				'id_atasanpenilai' => $q->id_atasanpenilai,  
			);
			echo json_encode($nipterakhir);
		}
	}

	function json_skp($id="",$id_pegawai=''){
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
		$rows = $this->penilaiandppp_model->get_data_skp($id,$id_pegawai,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no=1;
		foreach($rows as $act) {
			$data[] = array(
				'no'								=> $no++,
				'id_mst_peg_struktur_org'			=> $act->id_mst_peg_struktur_org,
				'tugas'								=> $act->tugas,
				'id_mst_peg_struktur_skp'			=> $act->id_mst_peg_struktur_skp,
				'ak'								=> $act->ak,
				'kuant'								=> $act->kuant,
				'output'							=> $act->output,
				'target'							=> $act->kuant.'  '.$act->output,
				'kuant_output'						=> $act->target,
				'waktu'								=> $act->waktu,
				'biaya'								=> $act->biaya,
				'code_cl_phc'						=> $act->code_cl_phc,
				'ak_nilai'							=> $act->ak_nilai,
				'kuant_nilai'						=> $act->kuant_nilai,
				'target_nilai'						=> $act->kuant_nilai,
				'kuant_output_nilai'				=> $act->target_nilai,
				'waktu_nilai'						=> $act->waktu_nilai,
				'biaya_nilai'						=> $act->biaya_nilai,
				'id_pegawai_nilai'					=> $act->id_pegawai_nilai,
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
	function updatenilaiskp(){
		$this->authentication->verify('kepegawaian','edit');
		$this->form_validation->set_rules('id_pegawai','Realisasi ID Pegawait','trim|required');
		$this->form_validation->set_rules('tahun','Realisasi tahun','trim|required');
		$this->form_validation->set_rules('id_mst_peg_struktur_org','Realisasi id_mst_peg_struktur_org','trim|required');
		$this->form_validation->set_rules('id_mst_peg_struktur_skp',' Realisasi id_mst_peg_struktur_skp ','trim|required');
		$this->form_validation->set_rules('ak','ak','Realisasi trim|required');
		$this->form_validation->set_rules('kuant','Realisasi kuant','trim|required');
		$this->form_validation->set_rules('target','Realisasi target','trim|required');
		$this->form_validation->set_rules('waktu','Realisasi waktu','trim|required');
		$this->form_validation->set_rules('biaya','Realisasi biaya','trim|required');

		if($this->form_validation->run()== TRUE){
			$this->penilaiandppp_model->dppp_update();	
			echo "0";
		}else{			
			$err = validation_errors();
			echo str_replace("<p>", "", str_replace("</p>", "\n", $err));
		}	
	}
}
