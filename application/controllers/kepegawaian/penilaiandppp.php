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
		$data['title_form'] = "Penilaian DP3";
		$this->session->set_userdata('filter_tahun','');
		$this->session->set_userdata('filter_tahundata','');
		$this->session->set_userdata('filter_periodedata','');
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

	function data_export($id_pegawai="",$tahun='',$id_mst_peg_struktur_org=0,$periode=0){
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		
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
		if ($this->session->userdata('filter_tahundata')!='') {
			$tahun = $this->session->userdata('filter_tahundata');
		}else{
			$tahun = date("Y");
		}
		if ($this->session->userdata('filter_periodedata')!='') {
			$periode = $this->session->userdata('filter_periodedata');
		}else{
			$periode = 1;
		}
		$rows = $this->penilaiandppp_model->get_data_skp($id_mst_peg_struktur_org,$id_pegawai,$tahun,$periode);
		$data_table = array();
		$no=1;
		foreach($rows as $act) {
			$data_table[] = array(
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
				'target_nilai'						=> $act->target_nilai,
				'kuant_output_nilai'				=> $act->target_nilai,
				'perhitungan_nilai'					=> number_format($act->perhitungan_nilai,2),
				'pencapaian_nilai'					=> number_format($act->pencapaian_nilai,2),
				'waktu_nilai'						=> $act->waktu_nilai,
				'biaya_nilai'						=> $act->biaya_nilai,
				'id_pegawai_nilai'					=> $act->id_pegawai_nilai,
				'edit'		=> 1,
				'delete'	=> 1
			);
		}

		$datapenilai 			= $this->nipterakhirpenilaiprint($id_pegawai);
		$dataatasanpenilai 		= $this->atasannipterakhirpenilaiprint($id_pegawai);
		$pegawaiyangditilai 	= $this->yangditilai($id_pegawai);
		$datadetailpenilaian	= $this->penilaiandppp_model->get_data_row_pengukuran($id_pegawai,$tahun,$id_mst_peg_struktur_org,$periode);
		if ($datapenilai != '0') {
			$data_penilai[] = array(
				'nama_penilai'		=>$datapenilai['gelar_depan'].' '.$datapenilai['nama'].' '.$datapenilai['gelar_belakang'],
				'nip_nit_penilai'	=>$datapenilai['nip_nit'],
				'pangkat_penilai'	=>$datapenilai['id_mst_peg_golruang'].' '.$datapenilai['ruang'],
				'jabatan_penilai'	=>$datapenilai['namajabatan'],
				'unit_penilai'		=>'Dinas Kesehatan '.$datapenilai['value']
				);
		}else{
			$data_penilai[] = array('nama_penilai'=>'-','nip_nit_penilai'=>'-','pangkat_penilai'=>'-','jabatan_penilai'=>'-','unit_penilai'=>'-');
		}
		 
		if ($dataatasanpenilai !=0) {
			$dataatasan_penilai[] = array(
				'nama_atasan_penilai'	=>$dataatasanpenilai['gelar_depan'].' '.$dataatasanpenilai['nama'].' '.$dataatasanpenilai['gelar_belakang'],
				'nip_nit_atasan_penilai'=>$dataatasanpenilai['nip_nit'],
				'pangkat_atasan_penilai'=>$dataatasanpenilai['id_mst_peg_golruang'].' '.$dataatasanpenilai['ruang'],
				'jabatan_atasan_penilai'=>$dataatasanpenilai['namajabatan'],
				'unit_atasan_penilai'	=>'Dinas Kesehatan '.$dataatasanpenilai['value']);
		}else{
			$dataatasan_penilai[] = array('nama_atasan_penilai'=>'-','nip_nit_atasan_penilai'=>'-','pangkat_atasan_penilai'=>'-','jabatan_atasan_penilai'=>'-','unit_atasan_penilai'=>'-');
		}
		if ($pegawaiyangditilai !=0) {
			$data_yangdinilai[] = array(
				'nama_pegawai'	=>$pegawaiyangditilai['gelar_depan'].' '.$pegawaiyangditilai['nama'].' '.$pegawaiyangditilai['gelar_belakang'],
				'nip_nit_pegawai'=>$pegawaiyangditilai['nip_nit'],
				'pangkat_pegawai'=>$pegawaiyangditilai['id_mst_peg_golruang'].' '.$pegawaiyangditilai['ruang'],
				'jabatan_pegawai'=>$pegawaiyangditilai['namajabatan'],
				'unit_pegawai'	=>'Dinas Kesehatan '.$pegawaiyangditilai['value']);
		}else{
			$data_yangdinilai[] = array('nama_pegawai'=>'-','nama_pegawai'=>'-','pangkat_pegawai'=>'-','jabatan_pegawai'=>'-','unit_pegawai'=>'-');
		}
		if ($datadetailpenilaian['periode']==2) {
			$periodebulan ='Juli - Desember';
		}else{
			$periodebulan ='Januari - Juni';
		}
		if ($datadetailpenilaian!=0) {
			$datadetail_nilai[] = array('tgl_penilian'=>date("d-m-Y",strtotime($datadetailpenilaian['tgl_dibuat'])),'periode'=>$periodebulan,'ratarata'=>$datadetailpenilaian['skp']);
		}else{
			$datadetail_nilai[] = array('tgl_penilian'=>'-','periode'=>'-','ratarata'=>'-');
		}
		$puskes = $this->input->post('puskes');
		$kode_sess=$this->session->userdata('puskesmas');
		$kd_prov = $this->penilaiandppp_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$puskes = $this->penilaiandppp_model->get_nama('value','cl_phc','code','P'.$kode_sess);
		$kd_kab  = $this->penilaiandppp_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		$kd_kec  = 'KEC. '.$this->penilaiandppp_model->get_nama('nama','cl_kec','code',substr($kode_sess, 0,7));
		$tahun_ = date("Y");
		$data_puskesmas[] = array('nama_puskesmas' => $puskes,'kd_prov' => $kd_prov,'kd_kab' => $kd_kab,'tahun' => $tahun_);
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/kepegawaian/dppp_pengukuran.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		// Merge data in the first sheet
		$TBS->MergeBlock('d', $data_puskesmas);
		$TBS->MergeBlock('a', $data_table);
		$TBS->MergeBlock('b', $data_penilai);
		$TBS->MergeBlock('c', $data_yangdinilai);
		$TBS->MergeBlock('e', $datadetail_nilai);
		
		$code = date('Y-m-d-H-i-s');
		$output_file_name = 'public/files/hasil/hasil_export_dppppengukuran'.$code.'.xlsx';
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
				'tahun_penilaian'		=> $act->tahun_penilaian,
				'ruang'					=> ucwords(strtolower($act->ruang)),
				'username'				=> $act->username,
				'nilai_prestasi'		=> $act->nilai_prestasi,
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
	
	function filtertahun(){
		if($_POST) {
			if($this->input->post('filtertahun') != '') {
				$this->session->set_userdata('filter_tahun',$this->input->post('filtertahun'));
			}
		}
	}
	


	function edit($id_pegawai=0,$code_cl_phc=""){
		$this->authentication->verify('kepegawaian','edit');

			$data 	= $this->penilaiandppp_model->get_datapegawai($id_pegawai,$code_cl_phc); 

			$data['title_group'] 	= "Kepegawaian";
			$data['title_form']		= "Penilaian DP3";
			$data['action']			= "edit";
			$data['kode']			= $id_pegawai;
			$data['code_cl_phc']	= $code_cl_phc;
			$data['tahun']			= '0';
			$data['id_mst_peg_struktur_skp']	= '0';
			$data['idlogin']		= $this->penilaiandppp_model->idlogin();

			$daftaranakbuah			= $this->penilaiandppp_model->getanakbuah($data['idlogin']);
			
			if (in_array($id_pegawai, $daftaranakbuah)) {
		    $data['statusanakbuah'] = "anakbuah";
			}else if ($id_pegawai == $data['idlogin']) {
				$data['statusanakbuah'] = "diasendiri";
			}else{
				$data['statusanakbuah'] = "atasan";
			}


			// $data['penilaian']	  	= $this->parser->parse('kepegawaian/penilaiandppp/penilaian', $data, TRUE);
			$data['penilaian']	  	= $this->parser->parse('kepegawaian/penilaiandppp/tab_dppp', $data, TRUE);
			$data['content'] 	= $this->parser->parse("kepegawaian/penilaiandppp/detail",$data,true);

			$this->template->show($data,"home");
	}
	// function adddatadppp($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$id_mst_peg_struktur_skp=0){
	// 	$this->authentication->verify('kepegawaian','add');

	// 	$data['title_group'] = "Kepegawaian";
	// 	$data['title_form']="Penilaian DP3";
	// 	$data['id_pegawai']=$id_pegawai;

	// 	$data['id_mst_peg_struktur_org']=$id_mst_peg_struktur_org;
	// 	$data['tahun']=$tahun;
	// 	$data['id_mst_peg_struktur_skp']=$id_mst_peg_struktur_skp;

	// 	die($this->parser->parse("kepegawaian/penilaiandppp/tab_dppp",$data));
	// }
	function add_pengukuran($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$id_mst_peg_struktur_skp=0){
		$data['action']				= "add";
		$data['id_pegawai']			= $id_pegawai;
		$data['tahun']				= $tahun;
		$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
		$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;
		$data['idlogin']							= $this->penilaiandppp_model->idlogin();
		$daftaranakbuah			= $this->penilaiandppp_model->getanakbuah($data['idlogin']);
		
		if (in_array($id_pegawai, $daftaranakbuah)) {
		    $data['statusanakbuah'] = "anakbuah";
		}else if ($id_pegawai == $data['idlogin']) {
			$data['statusanakbuah'] = "diasendiri";
		}else{
			$data['statusanakbuah'] = "atasan";
		}
		$data										= $this->penilaiandppp_model->getusername($id_pegawai);

        $this->form_validation->set_rules('tgl_dibuat_pengukuran', 'Tanggal dibuat', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_pengukuran', 'id Pegawai', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_pengukuran_penilai', 'id_penilai', 'trim|required');
        $this->form_validation->set_rules('periode', 'Periode', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_pengukuran_penilai_atasan', 'id_penilai_atasan', 'trim');
        $this->form_validation->set_rules('tahun_pengukuran', 'Tahun', 'trim|required');

		if($this->form_validation->run()== FALSE){

			$data['action']				= "add";
			$data['id_pegawai']			= $id_pegawai;
			$data['tahun']				= $tahun;
			$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
			$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;
			$data['idlogin']			= $this->penilaiandppp_model->idlogin();

			$daftaranakbuah				= $this->penilaiandppp_model->getanakbuah($data['idlogin']);
			
			if (in_array($id_pegawai, $daftaranakbuah)) {
		    $data['statusanakbuah'] = "anakbuah";
			}else if ($id_pegawai == $data['idlogin']) {
				$data['statusanakbuah'] = "diasendiri";
			}else{
				$data['statusanakbuah'] = "atasan";
			}
			$data['notice']							= validation_errors();
			die($this->parser->parse('kepegawaian/penilaiandppp/form_pengukuran', $data));
		}else{
			$this->db->where('id_pegawai',$id_pegawai);
			$this->db->where('tahun',$this->input->post('tahun_pengukuran'));
			$this->db->where('periode',$this->input->post('periode'));
			$query = $this->db->get('pegawai_skp');

			if ($query->num_rows() > 0) {
				$tahunnilai = $this->input->post('tahun_pengukuran');

				die("Error|Maaf pegawai ini sudah di nilai ditahun $tahunnilai");
			}else{
				
				$tgl_di = explode("-", $this->input->post('tgl_dibuat_pengukuran'));
				$tgl_dibuat = $tgl_di[2].'-'.$tgl_di[1].'-'.$tgl_di[0];
				
				$values = array(
					'id_pegawai' 			=> $id_pegawai,
					'tgl_dibuat' 			=> $tgl_dibuat,
					'id_pegawai_penilai' 	=> $this->input->post('id_pegawai_pengukuran_penilai'),
					'tahun' 				=> $this->input->post('tahun_pengukuran'),
					'periode' 				=> $this->input->post('periode'),
					'skp' 					=> '0',
					);
				
				if($this->db->insert('pegawai_skp', $values)){
					die("OK|");
				}else{
					die("Error|Proses data gagal");
				}
			}
		}
	}

	function form_tab_dpp($pageIndex,$id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$id_mst_peg_struktur_skp=0){
		$data = array();
		$data['id_pegawai']=$id_pegawai;
		$data['id_mst_peg_struktur_org']=$id_mst_peg_struktur_org;
		$data['id_mst_peg_struktur_skp']=$id_mst_peg_struktur_skp;
		$data['tahun']=$tahun;
		$data['idlogin']		= $this->penilaiandppp_model->idlogin();

		$daftaranakbuah			= $this->penilaiandppp_model->getanakbuah($data['idlogin']);
		
		if (in_array($id_pegawai, $daftaranakbuah)) {
	    $data['statusanakbuah'] = "anakbuah";
		}else if ($id_pegawai == $data['idlogin']) {
			$data['statusanakbuah'] = "diasendiri";
		}else{
			$data['statusanakbuah'] = "atasan";
		}
		switch ($pageIndex) {
			case 1:
				die($this->parser->parse("kepegawaian/penilaiandppp/pengukuran_show",$data));
				// $this->pengukuran($id_pegawai,$tahun,$id_mst_peg_struktur_org,$id_mst_peg_struktur_skp);
				break;
			case 2:
				// if ($action=='edit') {
				// 	$this->edit_dppp($id_pegawai,$tahun,$id_mst_peg_struktur_org,$id_mst_peg_struktur_skp);
				// }else{
				// 	$this->add_dppp($id_pegawai,$tahun,$id_mst_peg_struktur_org,$id_mst_peg_struktur_skp);	
				// }
				die($this->parser->parse("kepegawaian/penilaiandppp/penilaian",$data));
				break;
			default:
				// $this->pengukuran($id_pegawai,$tahun,$id_mst_peg_struktur_org,$id_mst_peg_struktur_skp);
			die($this->parser->parse("kepegawaian/penilaiandppp/pengukuran_show",$data));
				break;
		}

	}

	function add_dppp($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$id_mst_peg_struktur_skp=0){
		$data['action']				= "add";
		$data['id_pegawai']			= $id_pegawai;
		$data['tahun']				= $tahun;
		$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
		$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;
		$data['periode']							= 0;
		$data['idlogin']							= $this->penilaiandppp_model->idlogin();
		$daftaranakbuah			= $this->penilaiandppp_model->getanakbuah($data['idlogin']);
		
		if (in_array($id_pegawai, $daftaranakbuah)) {
		    $data['statusanakbuah'] = "anakbuah";
		}else if ($id_pegawai == $data['idlogin']) {
			$data['statusanakbuah'] = "diasendiri";
		}else{
			$data['statusanakbuah'] = "atasan";
		}
		$data										= $this->penilaiandppp_model->getusername($id_pegawai);

        $this->form_validation->set_rules('tgl_dibuat', 'Tanggal dibuat', 'trim|required');
        $this->form_validation->set_rules('tgl_diterima_atasan', 'tanggal diterima Atasan', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'id Pegawai', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_penilai', 'id_penilai', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_penilai_atasan', 'id_penilai_atasan', 'trim');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('tanggapan_tgl', 'Tanggal Tanggapan', 'trim');
        $this->form_validation->set_rules('tanggapan', 'Tanggapan', 'trim');
        $this->form_validation->set_rules('username', 'username', 'trim');
        $userdataname = $this->session->userdata('username');
        $username = $this->input->post('username');
		if ($username == $userdataname) {
        	$this->form_validation->set_rules('keberatan_tgl', 'Tanggal Keberatan', 'trim');
        	$this->form_validation->set_rules('keberatan', 'Keberatan', 'trim|required');
    	}
        $this->form_validation->set_rules('keputusan_tgl', 'Tanggal Keputusan', 'trim');
        $this->form_validation->set_rules('keputusan', 'Keputusan', 'trim');
        $this->form_validation->set_rules('rekomendasi', 'Rekomendasi', 'trim');
        $this->form_validation->set_rules('tgl_diterima', 'Tanggal di Terima', 'trim');
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
        $this->form_validation->set_rules('nilaiskp', 'Nilai SKP', 'trim');
        $this->form_validation->set_rules('nilaipelayanan', 'Nilai Pelayanan', 'trim');
        $this->form_validation->set_rules('nilaiintegritas', 'Nilai Integritas', 'trim');
        $this->form_validation->set_rules('nilaikomitmen', 'Nilai Komitmen', 'trim');
        $this->form_validation->set_rules('nilaidisiplin', 'Nilai Disiplin', 'trim');
        $this->form_validation->set_rules('nilaikerjasama', 'Nilai Kerjasama', 'trim');
        $this->form_validation->set_rules('nilaikepemimpinan', 'Kilai Kepemimpinan', 'trim');
        $this->form_validation->set_rules('nilaijumlah', 'Nilai Jumlah', 'trim');
        $this->form_validation->set_rules('nilairatarata', 'Nilai Rata-rata', 'trim');
        $this->form_validation->set_rules('nilai_nilai_prestasi', 'Nilai Prestasi', 'trim');
        
		if($this->form_validation->run()== FALSE){

			$data['action']				= "add";
			$data['id_pegawai']			= $id_pegawai;
			$data['tahun']				= $tahun;
			$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
			$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;
			$data['idlogin']		= $this->penilaiandppp_model->idlogin();

			$daftaranakbuah			= $this->penilaiandppp_model->getanakbuah($data['idlogin']);
			
			if (in_array($id_pegawai, $daftaranakbuah)) {
		    $data['statusanakbuah'] = "anakbuah";
			}else if ($id_pegawai == $data['idlogin']) {
				$data['statusanakbuah'] = "diasendiri";
			}else{
				$data['statusanakbuah'] = "atasan";
			}
			$data['notice']							= validation_errors();
			die($this->parser->parse('kepegawaian/penilaiandppp/form', $data));
		}else{
			
			$this->db->where('id_pegawai',$id_pegawai);
			
			$this->db->where('tahun',$this->input->post('tahun'));
			$query = $this->db->get('pegawai_dp3');

			if ($query->num_rows() > 0) {
				$tahunnilai = $this->input->post('tahun');

				die("Error|Maaf pegawai ini sudah di nilai ditahun $tahunnilai");
			}else{
				$tanggapan_t = explode("-", $this->input->post('tanggapan_tgl'));
				$tanggapan_tgl = $tanggapan_t[2].'-'.$tanggapan_t[1].'-'.$tanggapan_t[0];
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
				
				if ($username == $userdataname) {
					$keberatan_tgl = $keberatan_t[2].'-'.$keberatan_t[1].'-'.$keberatan_t[0];
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
	}
	function pengukuran($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$periode=0){
		$data						= $this->penilaiandppp_model->get_data_row_pengukuran($id_pegawai,$tahun,$id_mst_peg_struktur_org,$periode);
		$data['action']				= "add";
		$data['id_pegawai']			= $id_pegawai;
		$data['tahun']				= $tahun;
		$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
		$data['periode']			= $periode;
		$data['idlogin']							= $this->penilaiandppp_model->idlogin();
		$daftaranakbuah				= $this->penilaiandppp_model->getanakbuah($data['idlogin']);
		
		if (in_array($id_pegawai, $daftaranakbuah)) {
		    $data['statusanakbuah'] = "anakbuah";
		}else if ($id_pegawai == $data['idlogin']) {
			$data['statusanakbuah'] = "diasendiri";
		}else{
			$data['statusanakbuah'] = "atasan";
		}
		

		die($this->parser->parse('kepegawaian/penilaiandppp/pengukuran', $data));
		
	}
	function edit_dppp($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$id_mst_peg_struktur_skp=0){
		$data['action']				= "edit";
		$data['id_pegawai']			= $id_pegawai;
		$data['tahun']				= $tahun;
		$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
		$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;
		$data['idlogin']							= $this->penilaiandppp_model->idlogin();

		$daftaranakbuah			= $this->penilaiandppp_model->getanakbuah($data['idlogin']);
		
		if (in_array($id_pegawai, $daftaranakbuah)) {
	    $data['statusanakbuah'] = "anakbuah";
		}else if ($id_pegawai == $data['idlogin']) {
			$data['statusanakbuah'] = "diasendiri";
		}else{
			$data['statusanakbuah'] = "atasan";
		}

		$data										= $this->penilaiandppp_model->getusername($id_pegawai);

        $this->form_validation->set_rules('tgl_dibuat', 'Tanggal dibuat', 'trim|required');
        $this->form_validation->set_rules('tgl_diterima_atasan', 'tanggal diterima Atasan', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'id Pegawai', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_penilai', 'id_penilai', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_penilai_atasan', 'id_penilai_atasan', 'trim');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('tanggapan_tgl', 'Tanggal Tanggapan', 'trim');
        $this->form_validation->set_rules('tanggapan', 'Tanggapan', 'trim');
        $this->form_validation->set_rules('username', 'username', 'trim');
        $userdataname = $this->session->userdata('username');
        $username = $this->input->post('username');
		if ($username == $userdataname) {
        	$this->form_validation->set_rules('keberatan_tgl', 'Tanggal Keberatan', 'trim');
        	$this->form_validation->set_rules('keberatan', 'Keberatan', 'trim');
    	}
        $this->form_validation->set_rules('keputusan_tgl', 'Tanggal Keputusan', 'trim');
        $this->form_validation->set_rules('keputusan', 'Keputusan', 'trim');
        $this->form_validation->set_rules('rekomendasi', 'Rekomendasi', 'trim');
        $this->form_validation->set_rules('tgl_diterima', 'Tanggal di Terima', 'trim');
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
        $this->form_validation->set_rules('nilaiskp', 'Nilai SKP', 'trim');
        $this->form_validation->set_rules('nilaipelayanan', 'Nilai Pelayanan', 'trim');
        $this->form_validation->set_rules('nilaiintegritas', 'Nilai Integritas', 'trim');
        $this->form_validation->set_rules('nilaikomitmen', 'Nilai Komitmen', 'trim');
        $this->form_validation->set_rules('nilaidisiplin', 'Nilai Disiplin', 'trim');
        $this->form_validation->set_rules('nilaikerjasama', 'Nilai Kerjasama', 'trim');
        $this->form_validation->set_rules('nilaikepemimpinan', 'Kilai Kepemimpinan', 'trim');
        $this->form_validation->set_rules('nilaijumlah', 'Nilai Jumlah', 'trim');
        $this->form_validation->set_rules('nilairatarata', 'Nilai Rata-rata', 'trim');
        $this->form_validation->set_rules('nilai_nilai_prestasi', 'Nilai Prestasi', 'trim');
        
		if($this->form_validation->run()== FALSE){
			$data										= $this->penilaiandppp_model->get_rowdata($id_pegawai,$tahun);
			$data['action']				= "edit";
			$data['id_pegawai']			= $id_pegawai;
			$data['tahun']				= $tahun;
			$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
			$data['id_mst_peg_struktur_skp']			= $id_mst_peg_struktur_skp;
			$data['idlogin']		= $this->penilaiandppp_model->idlogin();

			$daftaranakbuah			= $this->penilaiandppp_model->getanakbuah($data['idlogin']);
			
			if (in_array($id_pegawai, $daftaranakbuah)) {
		    	$data['statusanakbuah'] = "anakbuah";
			}else if ($id_pegawai == $data['idlogin']) {
				$data['statusanakbuah'] = "diasendiri";
			}else{
				$data['statusanakbuah'] = "atasan";
			}

			$data['notice']							= validation_errors();
			die($this->parser->parse('kepegawaian/penilaiandppp/form', $data));
		}else{
			$tanggapan_t = explode("-", $this->input->post('tanggapan_tgl'));
			$tanggapan_tgl = $tanggapan_t[2].'-'.$tanggapan_t[1].'-'.$tanggapan_t[0];
			$tgl_di = explode("-", $this->input->post('tgl_dibuat'));
			$tgl_dibuat = $tgl_di[2].'-'.$tgl_di[1].'-'.$tgl_di[0];
			$tgl_dite = explode("-", $this->input->post('tgl_diterima_atasan'));
			$tgl_diterima_atasan = $tgl_dite[2].'-'.$tgl_dite[1].'-'.$tgl_dite[0];
			$keputu = explode("-", $this->input->post('keputusan_tgl'));
			$keputusan_tgl = $keputu[2].'-'.$keputu[1].'-'.$keputu[0];
			$tgl_diterim = explode("-", $this->input->post('tgl_diterima'));
			$tgl_diterima = $tgl_diterim[2].'-'.$tgl_diterim[1].'-'.$tgl_diterim[0];
			
			$values = array(
				'tgl_dibuat' 			=> $tgl_dibuat,
				'tgl_diterima_atasan' 	=> $tgl_diterima_atasan,
				'id_pegawai_penilai' 	=> $this->input->post('id_pegawai_penilai'),
				'id_pegawai_penilai_atasan' 					=> $this->input->post('id_pegawai_penilai_atasan'),
				'tanggapan' 			=> $this->input->post('tanggapan'),
				'tanggapan_tgl' 		=> $tanggapan_tgl,
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
			$keyup =array(
				'id_pegawai' 			=> $id_pegawai,
				'tahun' 				=> $this->input->post('tahun')
				);
			$userdataname = $this->session->userdata('username');
        	$username = $this->input->post('username');
        	$keberatan_t = explode("-", $this->input->post('keberatan_tgl'));
			
			if ($username == $userdataname) {
				$keberatan_tgl = $keberatan_t[2].'-'.$keberatan_t[1].'-'.$keberatan_t[0];
				$valuestanggapan = array(
						'keberatan_tgl' 		=> $keberatan_tgl,
						'keberatan' 			=> $this->input->post('keberatan')
					);
				$datainsert = array_merge($values,$valuestanggapan);
			}else{
				$datainsert = $values;
			}
			
			if($this->db->update('pegawai_dp3', $datainsert,$keyup)){
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
				'id_pegawai'						=> $act->id_pegawai,
				'tahun'								=> $act->tahun,
				'id_pegawai_penilai'				=> $act->id_pegawai_penilai,
				'id_pegawai_penilai_atasan' 		=> $act->id_pegawai_penilai_atasan,
				'skp'								=> $act->skp,
				'namapegawai'						=> $act->namapegawai,
				'nama_penilai'						=> $act->gelardepannama_penilai.' '.$act->nama_penilai.' '.$act->gelarbelakangnama_penilai,
				'namaatasanpenilai'					=> $act->gelardepannamaatasanpenilai.' '.$act->namaatasanpenilai.' '.$act->gelarbelakangnamaatasanpenilai,
				'pelayanan'							=> $act->pelayanan,
				'integritas'						=> $act->integritas,
				'komitmen'							=> $act->komitmen,
				'disiplin'							=> $act->disiplin,
				'kerjasama'							=> $act->kerjasama,
				'kepemimpinan'						=> $act->kepemimpinan,
				'jumlah'							=> $act->jumlah,
				'ratarata'							=> $act->ratarata,
				'nilai_prestasi'					=> $act->nilai_prestasi,
				'keberatan'							=> (isset($act->keberatan) ? "<i class='icon fa fa-check-square-o'></i>" : "-"),
				'keberatan_tgl'						=> $act->keberatan_tgl,
				'tanggapan'							=> (isset($act->tanggapan) ? "<i class='icon fa fa-check-square-o'></i>" : "-"),
				'tanggapan_tgl'						=> $act->tanggapan_tgl,
				'keputusan_tgl'						=> $act->keputusan_tgl,
				'keputusan'							=> (isset($act->keputusan) 	 ? "<i class='icon fa fa-check-square-o'></i>" : "-"),
				'rekomendasi'						=> (isset($act->rekomendasi) ? "<i class='icon fa fa-check-square-o'></i>" : "-"),
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
	function json_pengukuran($id=""){
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
		

		$rows_all = $this->penilaiandppp_model->get_data_detail_pengukuran($id);


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
		$rows = $this->penilaiandppp_model->get_data_detail_pengukuran($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_pegawai'						=> $act->id_pegawai,
				'tahun'								=> $act->tahun,
				'id_pegawai_penilai'				=> $act->id_pegawai_penilai,
				'periode' 							=> $act->periode,
				'tgl_dibuat' 						=> $act->tgl_dibuat,
				'jumlah' 							=> number_format($act->jumlah,2),
				'ratarata' 							=> number_format($act->ratarata,2),
				'skp'								=> $act->skp,
				'nama'								=> $act->gelar_depan.' '.$act->nama.' '.$act->gelar_belakang,
				'nama_penilai'						=> $act->gelardepannama_penilai.' '.$act->nama_penilai.' '.$act->gelarbelakangnama_penilai,
				'id_mst_peg_struktur_org'			=> $act->id_mst_peg_struktur_org,
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
	function dodelpermohonan($id_pegawai=0,$tahun=0){
		$this->authentication->verify('kepegawaian','del');

		$this->penilaiandppp_model->delete_dppp($id_pegawai,$tahun);
	}
	function dodelpermohonanpengukuran($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$periode=0){
		$this->authentication->verify('kepegawaian','del');

		$this->penilaiandppp_model->delete_pengukuran($id_pegawai,$tahun,$id_mst_peg_struktur_org,$periode);
	}
	function nipterakhirpegawai($id=0){
		$this->db->where('pegawai.id_pegawai',$id);
		$this->db->select("cl_district.value,nip_nit,id_mst_peg_golruang,ruang,mst_peg_struktur_org.tar_nama_posisi AS namajabatan");
		$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_golruang','mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
		$this->db->join('cl_district','cl_district.code = substr(pegawai.code_cl_phc,2,4)','left');
		$this->db->join('pegawai_struktur','pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_struktur_org','mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
		$query = $this->db->get('pegawai',1);
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

	function nippenilai($id_pegawai=0){
		$query = $this->db->query("select id_pegawai from pegawai_struktur where tar_id_struktur_org= (select tar_id_struktur_org_parent from mst_peg_struktur_org where tar_id_struktur_org = (select tar_id_struktur_org from pegawai_struktur where id_pegawai =".'"'.$id_pegawai.'"'."))");
		if($query->num_rows() >0 ){
			foreach ($query->result() as $key) {
				$data = $key->id_pegawai;
			}
		}else{
			$dat = 0;
		}
		return $data;
	}
	function nipterakhirpenilai($id=0){
		$id_penilai = $this->nippenilai($id);
		$this->db->where('pegawai.id_pegawai',$id_penilai);
		$this->db->select("pegawai.nama,pegawai.gelar_depan,pegawai.gelar_belakang,cl_district.value,nip_nit,id_mst_peg_golruang,ruang,mst_peg_struktur_org.tar_nama_posisi AS namajabatan,pegawai.id_pegawai AS id_atasanpenilai",false);
		$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_golruang','mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
		$this->db->join('cl_district','cl_district.code = substr(pegawai.code_cl_phc,2,4)','left');
		$this->db->join('pegawai_struktur','pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_struktur_org','mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
		$query = $this->db->get('pegawai',1);
		
		foreach ($query->result() as $q) {
			$nipterakhir[] = array(
				'namaterakhir' => $q->gelar_depan.' '.$q->nama.' '.$q->gelar_belakang,  
				'nipterakhir' => $q->nip_nit,  
				'pangkatterakhir' => $q->id_mst_peg_golruang.' - '.$q->ruang,  
				'jabatanterakhir' => $q->namajabatan,  
				'ukterakhir' => 'Dinas Kesehatan '.$q->value,    
				'id_pegawai_penilai' => $q->id_atasanpenilai,  
			);
			echo json_encode($nipterakhir);
		}
	}
	function nippenilaiatasan($id_pegawai=0){
		$query = $this->db->query("select id_pegawai from pegawai_struktur where tar_id_struktur_org = (select tar_id_struktur_org_parent from mst_peg_struktur_org where tar_id_struktur_org=(select tar_id_struktur_org from pegawai_struktur where id_pegawai = (select id_pegawai from pegawai_struktur where tar_id_struktur_org= (select tar_id_struktur_org_parent from mst_peg_struktur_org where tar_id_struktur_org = (select tar_id_struktur_org from pegawai_struktur where id_pegawai =".'"'.$id_pegawai.'"'.")))))");
		if($query->num_rows() >0 ){
			foreach ($query->result() as $key) {
				$data = $key->id_pegawai;
			}
		}else{
			$data = 0;
		}
		return $data;
	}
	function atasannipterakhirpenilai($id=0){
		$id_penilai = $this->nippenilaiatasan($id);
		$this->db->where('pegawai.id_pegawai',$id_penilai);
		$this->db->select("pegawai.nama,pegawai.gelar_depan,pegawai.gelar_belakang,cl_district.value,nip_nit,id_mst_peg_golruang,ruang,mst_peg_struktur_org.tar_nama_posisi AS namajabatan,pegawai.id_pegawai AS id_atasanpenilai",false);
		$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_golruang','mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
		$this->db->join('cl_district','cl_district.code = substr(pegawai.code_cl_phc,2,4)','left');
		$this->db->join('pegawai_struktur','pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_struktur_org','mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
		$query = $this->db->get('pegawai',1);
		
		foreach ($query->result() as $q) {
			$nipterakhir[] = array(
				'namaterakhir' => $q->gelar_depan.' '.$q->nama.' '.$q->gelar_belakang,  
				'nipterakhir' => $q->nip_nit,  
				'pangkatterakhir' => $q->id_mst_peg_golruang.' - '.$q->ruang,  
				'jabatanterakhir' => $q->namajabatan,  
				'ukterakhir' => 'Dinas Kesehatan '.$q->value,    
				'id_atasan_penilai' => $q->id_atasanpenilai,  
			);
			echo json_encode($nipterakhir);
		}
	}
	function filtertahundata(){
		if($_POST) {
			if($this->input->post('filtertahundata') != '') {
				$this->session->set_userdata('filter_tahundata',$this->input->post('filtertahundata'));
			}
			if($this->input->post('filterperiodedata') != '') {
				$this->session->set_userdata('filter_periodedata',$this->input->post('filterperiodedata'));
			}
		}
	}
	function json_skp($id="",$id_pegawai='',$tahun=0){
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
		if ($this->session->userdata('filter_tahundata')!='') {
			$tahun = $this->session->userdata('filter_tahundata');
		}else{
			$tahun = date("Y");
		}
		if ($this->session->userdata('filter_periodedata')!='') {
			$periode = $this->session->userdata('filter_periodedata');
		}else{
			$periode = 1;
		}
		$rows = $this->penilaiandppp_model->get_data_skp($id,$id_pegawai,$tahun,$periode,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
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
				'target_nilai'						=> $act->target_nilai,
				'kuant_output_nilai'				=> $act->target_nilai,
				'perhitungan_nilai'					=> number_format($act->perhitungan_nilai,2),
				'pencapaian_nilai'					=> number_format($act->pencapaian_nilai,2),
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
	function nilairataskp($id=0,$id_pegawai=0,$tahun=0,$periode=0){
		$this->db->select("((sum((((pegawai_skp_nilai.kuant / mst_peg_struktur_skp.kuant)*100)+((pegawai_skp_nilai.target / mst_peg_struktur_skp.target)*100)+(((1.76*mst_peg_struktur_skp.waktu - pegawai_skp_nilai.waktu)/mst_peg_struktur_skp.waktu)*100))/3))/6) as nilairata");
        $this->db->where('mst_peg_struktur_skp.id_mst_peg_struktur_org',$id);
        $this->db->join('pegawai_skp_nilai',"mst_peg_struktur_skp.id_mst_peg_struktur_skp = pegawai_skp_nilai.id_mst_peg_struktur_skp AND pegawai_skp_nilai.id_pegawai=".'"'.$id_pegawai.'"'." and tahun=".'"'.$tahun.'"'."and periode=".'"'.$periode.'"'."",'left');
        $query = $this->db->get('mst_peg_struktur_skp');
		foreach ($query->result() as $q) {
			$nilairataskp[] = array(
				'nilai' => number_format($q->nilairata,2)  
			);
			echo json_encode($nilairataskp);
		}
	}
	function nilairataskpterakhir($id=0,$id_pegawai=0,$tahun=0,$periode=0){
		$this->db->select("((sum((((pegawai_skp_nilai.kuant / mst_peg_struktur_skp.kuant)*100)+((pegawai_skp_nilai.target / mst_peg_struktur_skp.target)*100)+(((1.76*mst_peg_struktur_skp.waktu - pegawai_skp_nilai.waktu)/mst_peg_struktur_skp.waktu)*100))/3))/6) as nilairata");
        $this->db->where('mst_peg_struktur_skp.id_mst_peg_struktur_org',$id);
        $this->db->join("(SELECT concat(id_pegawai,tahun,periode),pegawai_skp_nilai.*  FROM pegawai_skp_nilai where concat(id_pegawai,tahun,periode) in (select concat(id_pegawai,max(tahun),max(periode)) from pegawai_skp_nilai where id_pegawai=".'"'.$id_pegawai.'"'.")) as pegawai_skp_nilai","mst_peg_struktur_skp.id_mst_peg_struktur_skp = pegawai_skp_nilai.id_mst_peg_struktur_skp AND mst_peg_struktur_skp.id_mst_peg_struktur_org = pegawai_skp_nilai.id_mst_peg_struktur_org",'left');
        $query = $this->db->get('mst_peg_struktur_skp');
		foreach ($query->result() as $q) {
			$nilairataskp[] = array(
				'nilai' => number_format($q->nilairata,2)  
			);
			echo json_encode($nilairataskp);
		}
	}
	function updatenilaiskp(){
		$this->authentication->verify('kepegawaian','edit');
		$this->form_validation->set_rules('id_pegawai','Realisasi ID Pegawait','trim|required');
		$this->form_validation->set_rules('tahun','Realisasi tahun','trim|required');
		$this->form_validation->set_rules('id_mst_peg_struktur_org','Realisasi id_mst_peg_struktur_org','trim|required');
		$this->form_validation->set_rules('id_mst_peg_struktur_skp',' Realisasi id_mst_peg_struktur_skp ','trim|required');
		$this->form_validation->set_rules('kuant','Realisasi kuant','trim|required');
		$this->form_validation->set_rules('periode','Realisasi Periode','trim|required');
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
	function atasannipterakhirpenilaiprint($id=0){
		$id_penilai = $this->nippenilaiatasan($id);
		$this->db->where('pegawai.id_pegawai',$id_penilai);
		$this->db->select("pegawai.nama,pegawai.gelar_depan,pegawai.gelar_belakang,cl_district.value,nip_nit,id_mst_peg_golruang,ruang,mst_peg_struktur_org.tar_nama_posisi AS namajabatan,pegawai.id_pegawai AS id_atasanpenilai",false);
		$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_golruang','mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
		$this->db->join('cl_district','cl_district.code = substr(pegawai.code_cl_phc,2,4)','left');
		$this->db->join('pegawai_struktur','pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_struktur_org','mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
		$query = $this->db->get('pegawai',1);
		
		if ($query->num_rows() > 0) {
			$data = $query->row_array();
		}else{
			$data=0;
		}
		$query->free_result();
		return $data;
	}
	function yangditilai($id=0){
		$this->db->where('pegawai.id_pegawai',$id);
		$this->db->select("pegawai.nama,pegawai.gelar_depan,pegawai.gelar_belakang,cl_district.value,nip_nit,id_mst_peg_golruang,ruang,mst_peg_struktur_org.tar_nama_posisi AS namajabatan,pegawai.id_pegawai AS id_atasanpenilai",false);
		$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_golruang','mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
		$this->db->join('cl_district','cl_district.code = substr(pegawai.code_cl_phc,2,4)','left');
		$this->db->join('pegawai_struktur','pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_struktur_org','mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
		$query = $this->db->get('pegawai',1);
		
		if ($query->num_rows() > 0) {
			$data = $query->row_array();
		}else{
			$data=0;
		}
		$query->free_result();
		return $data;
	}
	function nilaidata($nilai=0){
		if ($nilai < 60 ) {
			return 'D';
		}else if ($nilai < 70 ) {
			return 'C';
		}else if ($nilai <= 80 ) {
			return 'B';
		}else if ($nilai <= 100 ) {
			return 'A';
		}else{
			return '-';
		}
	}
function tgldatadp3($tgl='1'){
		$nama_bulan = array('01'=>"Januari", '02'=>"Februari", '03'=>"Maret", '04'=>"April", '05'=>"Mei", '06'=>"Juni", '07'=>"Juli", '08'=>"Agustus", '09'=>"September", '10'=>"Oktober", '11'=>"November", '12'=>"Desember");
		$tglex = explode('-', $tgl);
		$databenar = date("d-M-Y",strtotime($tgl));//$tglex[0].'-'.$tglex[1].'-'.$tglex[2];
		return $databenar;

	}
	function data_export_dp3($id_pegawai=0,$tahun=0){
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		
		$this->authentication->verify('kepegawaian','show');

		$rows = $this->penilaiandppp_model->get_rowdataexport($id_pegawai,$tahun);
		$data_table = array();
		$no=1;
		
		$data_table[] = array(
			'skp'						=> $rows['skp'],
			'nilaiskp'					=> ($rows['skp']*60/100),
			'id_pegawai'				=> $rows['id_pegawai'],
			'tahun'						=> $rows['tahun'],
			'id_pegawai_penilai'		=> $rows['id_pegawai_penilai'],
			'id_pegawai_penilai_atasan'	=> $rows['id_pegawai_penilai_atasan'],
			'pelayanan'					=> $rows['pelayanan'],
			'nilai_pelayanan'			=> $this->nilaidata($rows['pelayanan']),
			'integritas'				=> $rows['integritas'],
			'nilai_integritas'			=> $this->nilaidata($rows['integritas']),
			'komitmen'					=> $rows['komitmen'],
			'nilai_komitmen'			=> $this->nilaidata($rows['komitmen']),
			'disiplin'					=> $rows['disiplin'],
			'nilai_disiplin'			=> $this->nilaidata($rows['disiplin']),
			'kerjasama'					=> $rows['kerjasama'],
			'nilai_kerjasama'			=> $this->nilaidata($rows['kerjasama']),
			'kepemimpinan'				=> $rows['kepemimpinan'],
			'nilai_kepemimpinan'		=> $this->nilaidata($rows['kepemimpinan']),
			'jumlah'					=> $rows['jumlah'],
			'nilai_jumlah'				=> $this->nilaidata($rows['jumlah']),
			'ratarata'					=> $rows['ratarata'],
			'nilai_ratarata'			=> $this->nilaidata($rows['ratarata']),
			'nilai_rata'				=> ($rows['ratarata']*40/100),
			'nilai_prestasi'			=> $rows['nilai_prestasi'],
			'nilai_nilai_prestasi'		=> $this->nilaidata($rows['nilai_prestasi']),
			'keberatan'					=> $rows['keberatan'],
			'keberatan_tgl'				=> $this->tgldatadp3($rows['keberatan_tgl']),
			'tanggapan'					=> $rows['tanggapan'],
			'tanggapan_tgl'				=> $this->tgldatadp3($rows['tanggapan_tgl']),
			'keputusan'					=> $rows['keputusan'],
			'keputusan_tgl'				=> $this->tgldatadp3($rows['keputusan_tgl']),
			'rekomendasi'				=> $rows['rekomendasi'],
			'tgl_diterima'				=> $this->tgldatadp3($rows['tgl_diterima']),
			'tgl_dibuat'				=> $this->tgldatadp3($rows['tgl_dibuat']),
			'tgl_diterima_atasan'		=> $this->tgldatadp3($rows['tgl_diterima_atasan']),
		);
		
		// die(print_r($data_table));
		$datapenilai = $this->nipterakhirpenilaiprint($id_pegawai);
		$dataatasanpenilai =$this->atasannipterakhirpenilaiprint($id_pegawai);
		$pegawaiyangditilai = $this->yangditilai($id_pegawai);
		
		if ($datapenilai != '0') {
			$data_penilai[] = array(
				'nama_penilai'		=>$datapenilai['gelar_depan'].' '.$datapenilai['nama'].' '.$datapenilai['gelar_belakang'],
				'nip_nit_penilai'	=>$datapenilai['nip_nit'],
				'pangkat_penilai'	=>$datapenilai['id_mst_peg_golruang'].' '.$datapenilai['ruang'],
				'jabatan_penilai'	=>$datapenilai['namajabatan'],
				'unit_penilai'		=>'Dinas Kesehatan '.$datapenilai['value']
				);
		}else{
			$data_penilai[] = array('nama_penilai'=>'-','nip_nit_penilai'=>'-','pangkat_penilai'=>'-','jabatan_penilai'=>'-','unit_penilai'=>'-');
		}
		 
		if ($dataatasanpenilai !=0) {
			$dataatasan_penilai[] = array(
				'nama_atasan_penilai'	=>$dataatasanpenilai['gelar_depan'].' '.$dataatasanpenilai['nama'].' '.$dataatasanpenilai['gelar_belakang'],
				'nip_nit_atasan_penilai'=>$dataatasanpenilai['nip_nit'],
				'pangkat_atasan_penilai'=>$dataatasanpenilai['id_mst_peg_golruang'].' '.$dataatasanpenilai['ruang'],
				'jabatan_atasan_penilai'=>$dataatasanpenilai['namajabatan'],
				'unit_atasan_penilai'	=>'Dinas Kesehatan '.$dataatasanpenilai['value']);
		}else{
			$dataatasan_penilai[] = array('nama_atasan_penilai'=>'-','nip_nit_atasan_penilai'=>'-','pangkat_atasan_penilai'=>'-','jabatan_atasan_penilai'=>'-','unit_atasan_penilai'=>'-');
		}
		if ($pegawaiyangditilai !=0) {
			$data_yangdinilai[] = array(
				'nama_pegawai'	=>$pegawaiyangditilai['gelar_depan'].' '.$pegawaiyangditilai['nama'].' '.$pegawaiyangditilai['gelar_belakang'],
				'nip_nit_pegawai'=>$pegawaiyangditilai['nip_nit'],
				'pangkat_pegawai'=>$pegawaiyangditilai['id_mst_peg_golruang'].' '.$pegawaiyangditilai['ruang'],
				'jabatan_pegawai'=>$pegawaiyangditilai['namajabatan'],
				'unit_pegawai'	=>'Dinas Kesehatan '.$pegawaiyangditilai['value']);
		}else{
			$data_yangdinilai[] = array('nama_pegawai'=>'-','nama_pegawai'=>'-','pangkat_pegawai'=>'-','jabatan_pegawai'=>'-','unit_pegawai'=>'-');
		}
		$puskes = $this->input->post('puskes');
		$kode_sess=$this->session->userdata('puskesmas');
		$kd_prov = $this->penilaiandppp_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$puskes = $this->penilaiandppp_model->get_nama('value','cl_phc','code','P'.$kode_sess);
		$kd_kab  = $this->penilaiandppp_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		$kd_kec  = 'KEC. '.$this->penilaiandppp_model->get_nama('nama','cl_kec','code',substr($kode_sess, 0,7));
		$tahun_ = date("Y");
		$data_puskesmas[] = array('nama_puskesmas' => $puskes,'kd_prov' => $kd_prov,'kd_kab' => $kd_kab,'tahun' => $tahun_);
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/kepegawaian/dppp_pengukuran_belakang.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		// Merge data in the first sheet
		$TBS->MergeBlock('d', $dataatasan_penilai);
		$TBS->MergeBlock('a', $data_table);
		$TBS->MergeBlock('b', $data_yangdinilai);
		$TBS->MergeBlock('c', $data_penilai);
		
		$code = date('Y-m-d-H-i-s');
		$output_file_name = 'public/files/hasil/hasil_export_penilaiandppp'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;
	}
	function nipterakhirpenilaiprint($id=0){
		$id_penilai = $this->nippenilai($id);
		$this->db->where('pegawai.id_pegawai',$id_penilai);
		$this->db->select("pegawai.nama,pegawai.gelar_depan,pegawai.gelar_belakang,cl_district.value,nip_nit,id_mst_peg_golruang,ruang,mst_peg_struktur_org.tar_nama_posisi AS namajabatan,pegawai.id_pegawai AS id_atasanpenilai",false);
		$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_golruang','mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
		$this->db->join('cl_district','cl_district.code = substr(pegawai.code_cl_phc,2,4)','left');
		$this->db->join('pegawai_struktur','pegawai_struktur.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join('mst_peg_struktur_org','mst_peg_struktur_org.tar_id_struktur_org = pegawai_struktur.tar_id_struktur_org','left');
		$query = $this->db->get('pegawai',1);
		
		if ($query->num_rows() > 0) {
			$data = $query->row_array();
		}else{
			$data=0;
		}
		$query->free_result();
		return $data;
	}
}
