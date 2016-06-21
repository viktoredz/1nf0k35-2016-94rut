<?php
class Drh_dp3 extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('kepegawaian/drh_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}

//CRUD Pendidikan
	
	function form_tab_dpp($pageIndex,$id_pegawai=0){
		$data = array();
		$data['id_pegawai']=$id_pegawai;
		switch ($pageIndex) {
			case 1:
				die($this->parser->parse("kepegawaian/drh/form_dp3_pengukuran",$data));
				break;
			case 2:
				die($this->parser->parse("kepegawaian/drh/form_dp3_penilaian",$data));
				break;
			default:
			die($this->parser->parse("kepegawaian/drh/form_dp3_pengukuran",$data));
				break;
		}

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
		

		$rows_all = $this->drh_model->get_data_detail($id);


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
		$rows = $this->drh_model->get_data_detail($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
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
				// 'id_mst_peg_struktur_org'			=> $act->id_mst_peg_struktur_org,
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
		

		$rows_all = $this->drh_model->get_data_detail_pengukuran($id);


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
		$rows = $this->drh_model->get_data_detail_pengukuran($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
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
	function pengukuran($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0,$periode=0){
		$data						= $this->drh_model->get_data_row_pengukuran($id_pegawai,$tahun,$id_mst_peg_struktur_org,$periode);
		$data['action']				= "add";
		$data['id_pegawai']			= $id_pegawai;
		$data['tahun']				= $tahun;
		$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
		$data['periode']			= $periode;
		

		die($this->parser->parse('kepegawaian/drh/dp3_pengukuran', $data));
		
	}
	function edit_dppp($id_pegawai=0,$tahun=0,$id_mst_peg_struktur_org=0){
		$data['action']				= "edit";
		$data['id_pegawai']			= $id_pegawai;
		$data['tahun']				= $tahun;
		$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
		$data['idlogin']							= $this->drh_model->idlogin();

		$daftaranakbuah			= $this->drh_model->getanakbuah($data['idlogin']);
		
		if (in_array($id_pegawai, $daftaranakbuah)) {
	    $data['statusanakbuah'] = "anakbuah";
		}else if ($id_pegawai == $data['idlogin']) {
			$data['statusanakbuah'] = "diasendiri";
		}else{
			$data['statusanakbuah'] = "atasan";
		}
		$data['tahun']				= $tahun;
		$data										= $this->drh_model->getusername($id_pegawai);

        $this->form_validation->set_rules('tgl_dibuat', 'Tanggal dibuat', 'trim|required');
        $this->form_validation->set_rules('tgl_diterima_atasan', 'tanggal diterima Atasan', 'trim|required');
        $this->form_validation->set_rules('id_pegawai', 'id Pegawai', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_penilai', 'id_penilai', 'trim|required');
        $this->form_validation->set_rules('id_pegawai_penilai_atasan', 'id_penilai_atasan', 'trim');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('tanggapan_tgl', 'Tanggal Tanggapan', 'trim|required');
        $this->form_validation->set_rules('tanggapan', 'Tanggapan', 'trim|required');
        $this->form_validation->set_rules('username', 'username', 'trim');
        $userdataname = $this->session->userdata('username');
        $username = $this->input->post('username');
		if ($username == $userdataname) {
        	$this->form_validation->set_rules('keberatan_tgl', 'Tanggal Keberatan', 'trim');
        	$this->form_validation->set_rules('keberatan', 'Keberatan', 'trim');
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
			$data										= $this->drh_model->get_rowdata($id_pegawai,$tahun);
			$data['action']				= "edit";
			$data['id_pegawai']			= $id_pegawai;
			$data['tahun']				= $tahun;
			$data['id_mst_peg_struktur_org']			= $id_mst_peg_struktur_org;
			$data['idlogin']		= $this->drh_model->idlogin();

			$daftaranakbuah			= $this->drh_model->getanakbuah($data['idlogin']);
			
			if (in_array($id_pegawai, $daftaranakbuah)) {
		    	$data['statusanakbuah'] = "anakbuah";
			}else if ($id_pegawai == $data['idlogin']) {
				$data['statusanakbuah'] = "diasendiri";
			}else{
				$data['statusanakbuah'] = "atasan";
			}
			$data['tahun']				= $tahun;
			$data['notice']							= validation_errors();
			die($this->parser->parse('kepegawaian/drh/form_dppp', $data));
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
			$keyup =array(
				'id_pegawai' 			=> $id_pegawai,
				'tahun' 				=> $this->input->post('tahun')
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
			
			if($this->db->update('pegawai_dp3', $datainsert,$keyup)){
				die("OK|");
			}else{
				die("Error|Proses data gagal");
			}	
			
		}
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
		$rows = $this->drh_model->get_data_skp($id_mst_peg_struktur_org,$id_pegawai,$tahun,$periode);
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
		$datadetailpenilaian	= $this->drh_model->get_data_row_pengukuran($id_pegawai,$tahun,$id_mst_peg_struktur_org,$periode);
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
		$kd_prov = $this->drh_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$puskes = $this->drh_model->get_nama('value','cl_phc','code','P'.$kode_sess);
		$kd_kab  = $this->drh_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		$kd_kec  = 'KEC. '.$this->drh_model->get_nama('nama','cl_kec','code',substr($kode_sess, 0,7));
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
		$rows = $this->drh_model->get_data_skp($id,$id_pegawai,$tahun,$periode,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
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
        // $this->db->join('pegawai_skp_nilai',"mst_peg_struktur_skp.id_mst_peg_struktur_skp = pegawai_skp_nilai.id_mst_peg_struktur_skp AND pegawai_skp_nilai.id_pegawai=".'"'.$id_pegawai.'"'." and tahun=".'"'.$tahun.'"'."and periode=".'"'.$periode.'"'."",'left');
        $this->db->join("(SELECT concat(id_pegawai,tahun,periode),pegawai_skp_nilai.*  FROM pegawai_skp_nilai where concat(id_pegawai,tahun,periode) in (select concat(id_pegawai,max(tahun),max(periode)) from pegawai_skp_nilai where id_pegawai=".'"'.$id_pegawai.'"'.")) as pegawai_skp_nilai","mst_peg_struktur_skp.id_mst_peg_struktur_skp = pegawai_skp_nilai.id_mst_peg_struktur_skp AND mst_peg_struktur_skp.id_mst_peg_struktur_org = pegawai_skp_nilai.id_mst_peg_struktur_org",'left');
        $query = $this->db->get('mst_peg_struktur_skp');
		foreach ($query->result() as $q) {
			$nilairataskp[] = array(
				'nilai' => number_format($q->nilairata,2)  
			);
			echo json_encode($nilairataskp);
		}
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
	function bulan($bulan)
	{
		Switch ($bulan){
		    case 1 : $bulan="Januari";
		        Break;
		    case 2 : $bulan="Februari";
		        Break;
		    case 3 : $bulan="Maret";
		        Break;
		    case 4 : $bulan="April";
		        Break;
		    case 5 : $bulan="Mei";
		        Break;
		    case 6 : $bulan="Juni";
		        Break;
		    case 7 : $bulan="Juli";
		        Break;
		    case 8 : $bulan="Agustus";
		        Break;
		    case 9 : $bulan="September";
		        Break;
		    case 10 : $bulan="Oktober";
		        Break;
		    case 11 : $bulan="November";
		        Break;
		    case 12 : $bulan="Desember";
		        Break;
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

		$rows = $this->drh_model->get_rowdataexport($id_pegawai,$tahun);
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
		$kd_prov = $this->drh_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$puskes = $this->drh_model->get_nama('value','cl_phc','code','P'.$kode_sess);
		$kd_kab  = $this->drh_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		$kd_kec  = 'KEC. '.$this->drh_model->get_nama('nama','cl_kec','code',substr($kode_sess, 0,7));
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
}