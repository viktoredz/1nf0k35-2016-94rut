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
	
	
	function add($id_pegawai=0,$tahun=""){
		$this->authentication->verify('kepegawaian','add');

		$this->form_validation->set_rules('kode_inventaris_', 'Kode Inventaris', 'trim|required');
        $this->form_validation->set_rules('tgl', 'Tanggal Perngadaan', 'trim|required');
        $this->form_validation->set_rules('status', 'Status Pengadaan', 'trim|required');
        $this->form_validation->set_rules('nomor_kontrak', 'Nomor Kontrak', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Nomor Kontrak', 'trim');
        $this->form_validation->set_rules('nomor_kwitansi', 'Nomor Kontrak', 'trim');

		if($this->form_validation->run()== FALSE){
			$data['title_group'] = "kepegawaian";
			$data['title_form']="Tambah Pengadaan Barang";
			$data['action']="add";
			$data['kode']="";

			$kodepuskesmas = $this->session->userdata('puskesmas');
			if(strlen($kodepuskesmas) == 4){
				$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
			}else {
				$this->db->where('code','P'.$kodepuskesmas);
			}

			$data['kodepuskesmas'] = $this->puskesmas_model->get_data();

			
		
			$data['content'] = $this->parser->parse("kepegawaian/penilaiandppp/form",$data,true);
		}elseif($id = $this->pengadaanbarang_model->insert_entry()){
			$this->session->set_flashdata('alert', 'Save data successful...');
			redirect(base_url().'kepegawaian/penilaiandppp/');
			// redirect(base_url().'kepegawaian/penilaiandppp/edit/'.$id);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."kepegawaian/penilaiandppp/add");
		}

		$this->template->show($data,"home");
	}


	function edit($id_pegawai=0,$code_cl_phc=""){
		$this->authentication->verify('kepegawaian','edit');

			$data 	= $this->penilaiandppp_model->get_datapegawai($id_pegawai,$code_cl_phc); 

			$data['title_group'] 	= "Kepegawaian";
			$data['title_form']		= "Penilaian DPPP";
			$data['action']			= "edit";
			$data['kode']			= $id_pegawai;
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
			die($this->parser->parse('kepegawaian/penilaiandppp/form', $data));
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
		

		$rows_all = $this->penilaiandppp_model->get_data_detail($id);


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
		$rows = $this->penilaiandppp_model->get_data_detail($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
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


		
		$size = sizeof($rows_all);
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
		$this->db->select("pegawai.nama,pegawai.gelar_depan,pegawai.gelar_belakang,cl_district.value,nip_nit,id_mst_peg_golruang,ruang,IF(jabatanstruktural.sk_status = 'pengangkatan' AND jabatanfungsional.sk_status = 'pengangkatan', CONCAT(jabatanstruktural.tar_nama_struktural,'-', jabatanfungsional.tar_nama_fungsional),(IF(jabatanstruktural.sk_status = 'pengangkatan', jabatanstruktural.tar_nama_struktural, (IF(jabatanfungsional.sk_status = 'pengangkatan', jabatanfungsional.tar_nama_fungsional, '-'))))) AS namajabatan");
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
			);
			echo json_encode($nipterakhir);
		}
	}

	
	
}
