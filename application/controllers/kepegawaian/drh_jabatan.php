<?php
class Drh_jabatan extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('kepegawaian/drh_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
	}

//CRUD Pendidikan
	
	function json_jabatan_fungsional($id){
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'tgl_pelantikan') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'sk_jb_tgl') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('jenis !=','STRUKTURAL');
		$rows_all = $this->drh_model->get_data_jabatan($id);

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if(($field == 'tmt')||($field == 'tgl_pelantikan')||($field == 'sk_jb_tgl')) {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}else{
					$this->db->like($field,$value);
				}

			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$this->db->where('jenis !=','STRUKTURAL');
		$rows = $this->drh_model->get_data_jabatan($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_pegawai'		=> $act->id_pegawai,
				'nip_nit' 			=> $act->nip_nit,
				'tmt' 				=> $act->tmt,
				'jenis'				=> ucwords($act->jenis),
				'unor'				=> $act->unor,
				'id_mst_peg_struktural'		=> $act->id_mst_peg_struktural,
				'id_mst_peg_fungsional'		=> $act->id_mst_peg_fungsional,
				'sk_jb_tgl'			=> $act->sk_jb_tgl,
				'sk_jb_nomor'		=> $act->sk_jb_nomor,
				'sk_status'			=> $act->sk_status,
				'prosedur'			=> $act->prosedur,
				'code_cl_phc'		=> $act->code_cl_phc,
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

	function json_jabatan_struktural($id){
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if(($field == 'tmt')||($field == 'tgl_pelantikan')||($field == 'sk_jb_tgl')) {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('jenis','STRUKTURAL');
		$rows_all = $this->drh_model->get_data_jabatan($id);

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if(($field == 'tmt')||($field == 'tgl_pelantikan')||($field == 'sk_jb_tgl')) {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}else{
					$this->db->like($field,$value);
				}

			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('jenis','STRUKTURAL');
		$rows = $this->drh_model->get_data_jabatan($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_pegawai'		=> $act->id_pegawai,
				'nip_nit' 			=> $act->nip_nit,
				'tmt' 				=> $act->tmt,
				'jenis'				=> ucwords($act->jenis),
				'unor'				=> $act->unor,
				'id_mst_peg_struktural'		=> $act->id_mst_peg_struktural,
				'id_mst_peg_fungsional'		=> $act->id_mst_peg_fungsional,
				'sk_jb_tgl'			=> $act->sk_jb_tgl,
				'sk_jb_nomor'		=> $act->sk_jb_nomor,
				'sk_status'			=> $act->sk_status,
				'prosedur'			=> $act->prosedur,
				'code_cl_phc'		=> $act->code_cl_phc,
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

	function biodata_jabatan($pageIndex,$id){
		$data = array();
		$data['id']=$id;

		switch ($pageIndex) {
			case 1:
				die($this->parser->parse("kepegawaian/drh/form_jabatan_struktural",$data));
				break;
			case 2:
				die($this->parser->parse("kepegawaian/drh/form_jabatan_fungsional",$data));
				break;
			default:
				die($this->parser->parse("kepegawaian/drh/form_jabatan_fungsional",$data));
				break;
		}

	}

	

	function biodata_jabatan_struktural_del($id="",$id_diklat=0){
		$this->authentication->verify('kepegawaian','del');

		if($this->drh_model->delete_entry_jabatan_struktural($id,$id_diklat)){
			die ("OK");
		} else {
			die ("Error");
		}
	}

	function biodata_jabatan_struktural_add($id){
        $this->form_validation->set_rules('nama_diklat', 'Nama Diklat Struktural', 'trim|required');
        $this->form_validation->set_rules('mst_peg_id_diklat', 'Jenis Diklat', 'trim|required');
        $this->form_validation->set_rules('tgl_diklat', '', 'trim');
        $this->form_validation->set_rules('nomor_sertifikat', '', 'trim');

		$data['id']			 =$id;
	    $data['action']		 = "add";
		$data['alert_form']  = '';
		$data['kode_diklat'] = $this->drh_model->get_kode_diklat('struktural');

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("kepegawaian/drh/form_jabatan_struktural_form",$data));
		}elseif($this->drh_model->insert_entry_jabatan_struktural($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_jabatan_struktural_form",$data));
	}

	function biodata_jabatan_struktural_edit($id="",$id_diklat=0){
   		$this->form_validation->set_rules('nama_diklat', 'Nama Diklat Struktural', 'trim|required');
        $this->form_validation->set_rules('mst_peg_id_diklat', 'Jenis Diklat', 'trim|required');
        $this->form_validation->set_rules('tgl_diklat', '', 'trim');
        $this->form_validation->set_rules('nomor_sertifikat', '', 'trim');

		if($this->form_validation->run()== FALSE){
			$data 				 = $this->drh_model->get_data_jabatan_edit($id,$id_diklat);
			$data['kode_diklat'] = $this->drh_model->get_kode_diklat('struktural');
			$data['action']		 = "edit";
			$data['id']			 = $id;
			$data['id_diklat']	 = $id_diklat;
			$data['alert_form']  = '';
			$data['disable']	 = "disable";

			die($this->parser->parse("kepegawaian/drh/form_jabatan_struktural_form",$data));

		}elseif($this->drh_model->update_entry_jabatan_struktural($id,$id_diklat)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_jabatan_struktural_form",$data));
	}

	function add($id,$tmt=''){

        $this->form_validation->set_rules('id_mst_peg_golruang', 'Golongan Ruang', 'trim|required');
        $this->form_validation->set_rules('tmt', 'Terhitung Mulai Tanggal', 'trim|required');
        $this->form_validation->set_rules('bkn_tgl', 'Tanggal BKN', 'trim|required');
        $this->form_validation->set_rules('bkn_nomor', 'Nomor BKN', 'trim|required');
        $this->form_validation->set_rules('sk_tgl', 'SK Tanggal', 'trim|required');
        $this->form_validation->set_rules('sk_nomor', 'SK Nomor', 'trim|required');
        $this->form_validation->set_rules('sk_pejabat', 'SK Pejabat', 'trim|required');
        $this->form_validation->set_rules('statuspns', 'Status', 'trim|required');
        $this->form_validation->set_rules('codepus', 'Kode Puskesmas', 'trim|required');
        if ($this->input->post('statuspns')=='CPNS') {
        	$this->form_validation->set_rules('jenis_pengadaan', 'Jenis Pengadaan', 'trim|required');
        	$this->form_validation->set_rules('masa_krj_bln', 'Masa Kerja Golongan Bulan ', 'trim|required');
        	$this->form_validation->set_rules('masa_krj_thn', 'Masa Kerja Golongan Tahun', 'trim|required');
			$this->form_validation->set_rules('spmt_tgl', 'Tanggal SPMT', 'trim|required');
			$this->form_validation->set_rules('spmt_nomor', 'Nomor SPMT', 'trim|required');
			$this->form_validation->set_rules('nit', 'NIT', 'trim|required');
        }else if ($this->input->post('statuspns')=='PNS') {
        	$this->form_validation->set_rules('masa_krj_bln', 'Masa Kerja Golongan Bulan ', 'trim|required');
        	$this->form_validation->set_rules('masa_krj_thn', 'Masa Kerja Golongan Tahun', 'trim|required');
        	$this->form_validation->set_rules('penganggkatan', 'cek', 'trim');	
        	$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
        	if($this->input->post('penganggkatan') == '1'){
        		$this->form_validation->set_rules('sttpl_tgl', 'Tanggal STTPL', 'trim|required');
        		$this->form_validation->set_rules('sttpl_nomor', 'Nomor STTPL', 'trim|required');
        		$this->form_validation->set_rules('dokter_tgl', 'Tanggal Keterangan Dokter', 'trim|required');
        		$this->form_validation->set_rules('dokter_nomor', 'Nomor Keterangan Dokter', 'trim|required');
        	}else{
        		$this->form_validation->set_rules('jenis_pangkat', 'Jenis Pangkat', 'trim|required');
        	}
        }else {
        	$this->form_validation->set_rules('nit', 'NIT', 'trim|required');
        	$this->form_validation->set_rules('jenis_pengadaan', 'Jenis Pengadaan', 'trim|required');
        	$this->form_validation->set_rules('tat', 'Terhitung Akhir Tanggal', 'trim|required');
        	$this->form_validation->set_rules('spmt_tgl', 'SPMT Tanggal', 'trim|required');
        	$this->form_validation->set_rules('spmt_nomor', 'SPMT Nomor', 'trim|required');
        }
		$data['id']				= $id;
	    $data['action']			= "add";
		$data['alert_form'] 	= '';
		$data['tmt'] 			= '';

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		$this->db->order_by('no_urut','asc');
		$data['kode_status'] 	= $this->drh_model->kode_tabel('mst_peg_status');
		$data['kode_pns'] 		= $this->drh_model->kode_tabel('mst_peg_golruang');
		$data['kode_pengadaan']	= $this->pilihan_enums('pegawai_pangkat','jenis_pengadaan');
		$data['kode_pangkat']	= $this->pilihan_enums('pegawai_pangkat','jenis_pangkat');
		$data['masakerjaterakhir'] = $this->drh_model->masakerjaterakhir($id);
		$tambahdata = date("Y") - date("Y",strtotime($data['masakerjaterakhir']['tmt']));
		$data ['masa_krj_bln'] = $data['masakerjaterakhir']['masa_krj_bln'];
		$data ['masa_krj_thn'] = $data['masakerjaterakhir']['masa_krj_thn'];
		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("kepegawaian/drh/form_jabatan_form",$data));
		}elseif($st = $this->drh_model->insert_entry_cpns_formal($id)){
			die("OK | $st");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_jabatan_form",$data));
	}
	function pilihan_enums($table , $field){
	$query = "SHOW COLUMNS FROM ".$table." LIKE '$field'";
	 $row = $this->db->query("SHOW COLUMNS FROM ".$table." LIKE '$field'")->row()->Type;  
	 $regex = "/'(.*?)'/";
	        preg_match_all( $regex , $row, $enum_array );
	        $enum_fields = $enum_array[1];
	        foreach ($enum_fields as $key=>$value)
	        {
	            $enums[$value] = $value; 
	        }
	        return $enums;
	}
	function biodata_jabatan_fungsional_add($id){
        $this->form_validation->set_rules('nama_diklat', 'Nama Diklat Struktural', 'trim|required');
        $this->form_validation->set_rules('mst_peg_id_diklat', 'Jenis Diklat', 'trim|required');
        $this->form_validation->set_rules('tgl_diklat', '', 'trim');
        $this->form_validation->set_rules('lama_diklat', 'Lamanya Diklat', 'trim|required');
        $this->form_validation->set_rules('tipe', '', 'trim');
        $this->form_validation->set_rules('nomor_sertifikat', '', 'trim');
        $this->form_validation->set_rules('instansi', '', 'trim');
        $this->form_validation->set_rules('penyelenggara', '', 'trim');

		if($this->form_validation->run()== FALSE){
	    	$data['action']		 = "add";
			$data['id']			 = $id;
			$data['alert_form']  = '';
			$data['kode_diklat'] = $this->drh_model->get_kode_diklat('fungsional');
			die($this->parser->parse("kepegawaian/drh/form_jabatan_fungsional_form",$data));
		}elseif($this->drh_model->insert_entry_jabatan_fungsional($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_jabatan_fungsional_form",$data));
	}

	function biodata_jabatan_fungsional_edit($id="",$id_diklat=0){
        $this->form_validation->set_rules('nama_diklat', 'Nama Diklat Struktural', 'trim|required');
        $this->form_validation->set_rules('mst_peg_id_diklat', 'Jenis Diklat', 'trim|required');
        $this->form_validation->set_rules('tgl_diklat', '', 'trim');
        $this->form_validation->set_rules('lama_diklat', 'Lamanya Diklat', 'trim|required');
        $this->form_validation->set_rules('tipe', '', 'trim');
        $this->form_validation->set_rules('nomor_sertifikat', '', 'trim');
        $this->form_validation->set_rules('instansi', '', 'trim');
        $this->form_validation->set_rules('penyelenggara', '', 'trim');

		if($this->form_validation->run()== FALSE){
			$data 				 = $this->drh_model->get_data_jabatan_edit($id,$id_diklat);
			$data['kode_diklat'] = $this->drh_model->get_kode_diklat('fungsional');
			$data['action']		 = "edit";
			$data['id']			 = $id;
			$data['id_diklat']	 = $id_diklat;
			$data['alert_form']  = '';
			die($this->parser->parse("kepegawaian/drh/form_jabatan_fungsional_form",$data));

		}elseif($this->drh_model->update_entry_jabatan_fungsional($id,$id_diklat)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_jabatan_fungsional_form",$data));
	}

	function biodata_jabatan_fungsional_del($id="",$id_diklat=0){
		$this->authentication->verify('kepegawaian','del');

		if($this->drh_model->delete_entry_jabatan_fungsional($id,$id_diklat)){
			die ("OK");
		} else {
			die ("Error");
		}
	}

}