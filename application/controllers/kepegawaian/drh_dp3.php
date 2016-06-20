<?php
class Drh_dp3 extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('kepegawaian/drh_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
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
	
}