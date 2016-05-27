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
				'tmt' 				=> date("d-m-Y",strtotime($act->tmt)),
				'tar_nama_fungsional' => $act->tar_nama_fungsional,
				'tar_nama_struktural' => $act->tar_nama_struktural,
				'jenis'				=> ucwords($act->jenis),
				'unor'				=> $act->unor,
				'id_mst_peg_struktural'		=> $act->id_mst_peg_struktural,
				'id_mst_peg_fungsional'		=> $act->id_mst_peg_fungsional,
				'sk_jb_tgl'			=> $act->sk_jb_tgl,
				'tgl_pelantikan'	=> $act->tgl_pelantikan,
				'sk_jb_nomor'		=> ucwords($act->sk_jb_nomor),
				'sk_status'			=> $act->sk_status,
				'sk_jb_pejabat'			=> ucwords($act->sk_jb_pejabat),
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
				'tmt' 				=> date("d-m-Y",strtotime($act->tmt)),
				'jenis'				=> ucwords($act->jenis),
				'unor'				=> $act->unor,
				'tar_nama_fungsional' => $act->tar_nama_fungsional,
				'tar_nama_struktural' => $act->tar_nama_struktural,
				'id_mst_peg_struktural'		=> $act->id_mst_peg_struktural,
				'id_mst_peg_fungsional'		=> $act->id_mst_peg_fungsional,
				'sk_jb_tgl'			=> $act->sk_jb_tgl,
				'sk_jb_nomor'		=> ucwords($act->sk_jb_nomor),
				'tgl_pelantikan'	=> $act->tgl_pelantikan,
				'sk_jb_pejabat'		=> ucwords($act->sk_jb_pejabat),
				'tar_eselon'		=> $act->tar_eselon,
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

	

	function biodata_jabatan_del($id="",$tmt=0){
		$this->authentication->verify('kepegawaian','del');

		if($this->drh_model->delete_entry_jabatan($id,$tmt)){
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

        $this->form_validation->set_rules('nip', 'NIP', 'trim|required');
        $this->form_validation->set_rules('tmt', 'Terhitung Mulai Tanggal', 'trim|required');
        $this->form_validation->set_rules('jenis', 'Status', 'trim|required');
        $this->form_validation->set_rules('unor', 'Unit Organisasi', 'trim|required');
        $this->form_validation->set_rules('tgl_pelantikan', 'Tanggal Pelantikan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_tgl', 'Tanggal Surat Keputusan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_nomor', 'Nomor Surat Keputusan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_pejabat', 'Nama Pejabat', 'trim|required');
        $this->form_validation->set_rules('sk_status', 'SK Status', 'trim|required');
        $this->form_validation->set_rules('prosedur', 'Prosedur Awal', 'trim|required');
        $this->form_validation->set_rules('codepus', 'Puskesmas', 'trim|required');
        if ($this->input->post('jenis')=='STRUKTURAL') {
        	$this->form_validation->set_rules('id_mst_peg_struktural', 'Jabatan Struktural', 'trim|required');
        }else if ($this->input->post('jenis')=='FUNGSIONAL_TERTENTU') {
        	$this->form_validation->set_rules('id_mst_peg_fungsional_tertentu', 'Jabatan Fungsional', 'trim|required');
        }else{
        	$this->form_validation->set_rules('id_mst_peg_fungsional_umum', 'Jabatan Fungsional', 'trim|required');
        } 
        
        $data = $this->drh_model->get_data_row($id); 
		$data['id']				= $id;
	    $data['action']			= "add";
		$data['alert_form'] 	= '';
		$data['tmt'] 			= '';
		$data['statusjenis']	= $this->pilihan_enums('pegawai_jabatan','jenis');
		$data['statusjenissk']	= $this->pilihan_enums('pegawai_jabatan','sk_status');
		$data['mst_peg_struktural']			= $this->drh_model->get_datawhere('all','all','mst_peg_struktural');
		$data['mst_peg_fungsional_umum']	= $this->drh_model->get_datawhere('FUNGSIONAL_UMUM','tar_jenis','mst_peg_fungsional');
		$data['mst_peg_fungsional_tertentu']= $this->drh_model->get_datawhere('FUNGSIONAL_TERTENTU','tar_jenis','mst_peg_fungsional');
		$data['mst_peg_rumpunpendidikan']			= $this->drh_model->get_datawhere('all','all','mst_peg_rumpunpendidikan');
		$data['mst_peg_tingkatpendidikan']			= $this->drh_model->get_datawhere('all','all','mst_peg_tingkatpendidikan');


		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		
		
		if($this->form_validation->run()== FALSE){
			$data = $this->drh_model->get_data_row($id); 
			$data['statusjenis']	= $this->pilihan_enums('pegawai_jabatan','jenis');
			$data['statusjenissk']	= $this->pilihan_enums('pegawai_jabatan','sk_status');
			$data['mst_peg_struktural']			= $this->drh_model->get_datawhere('all','all','mst_peg_struktural');
			$data['mst_peg_rumpunpendidikan']			= $this->drh_model->get_datawhere('all','all','mst_peg_rumpunpendidikan');
			$data['mst_peg_fungsional_umum']	= $this->drh_model->get_datawhere('FUNGSIONAL_UMUM','tar_jenis','mst_peg_fungsional');
			$data['mst_peg_fungsional_tertentu']= $this->drh_model->get_datawhere('FUNGSIONAL_TERTENTU','tar_jenis','mst_peg_fungsional');
			$data['mst_peg_tingkatpendidikan']			= $this->drh_model->get_datawhere('all','all','mst_peg_tingkatpendidikan');
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
			$data['alert_form'] 	= '';
			die($this->parser->parse("kepegawaian/drh/form_jabatan_form",$data));
		}elseif($st = $this->drh_model->insert_entry_jabatan_formal($id)){
			die("OK | $st");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_jabatan_form",$data));
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
	function edit($id='',$tmt=''){

        $this->form_validation->set_rules('nip', 'NIP', 'trim|required');
        $this->form_validation->set_rules('tmt', 'Terhitung Mulai Tanggal', 'trim|required');
        $this->form_validation->set_rules('jenis', 'Status', 'trim|required');
        $this->form_validation->set_rules('unor', 'Unit Organisasi', 'trim|required');
        $this->form_validation->set_rules('tgl_pelantikan', 'Tanggal Pelantikan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_tgl', 'Tanggal Surat Keputusan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_nomor', 'Nomor Surat Keputusan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_pejabat', 'Nama Pejabat', 'trim|required');
        $this->form_validation->set_rules('sk_status', 'SK Status', 'trim|required');
        $this->form_validation->set_rules('prosedur', 'Prosedur Awal', 'trim|required');
        $this->form_validation->set_rules('codepus', 'Puskesmas', 'trim|required');
        if ($this->input->post('jenis')=='STRUKTURAL') {
        	$this->form_validation->set_rules('id_mst_peg_struktural', 'Jabatan Struktural', 'trim|required');
        }else if ($this->input->post('jenis')=='FUNGSIONAL_TERTENTU') {
        	$this->form_validation->set_rules('id_mst_peg_fungsional_tertentu', 'Jabatan Fungsional', 'trim|required');
        }else{
        	$this->form_validation->set_rules('id_mst_peg_fungsional_umum', 'Jabatan Fungsional', 'trim|required');
        } 
        
        $data = $this->drh_model->get_data_row($id); 
		$data['id']				= $id;
	    $data['action']			= "edit";
		$data['alert_form'] 	= '';
		$data['tmt'] 			= $tmt;
		$data['statusjenis']	= $this->pilihan_enums('pegawai_jabatan','jenis');
		$data['statusjenissk']	= $this->pilihan_enums('pegawai_jabatan','sk_status');
		$data['mst_peg_struktural']			= $this->drh_model->get_datawhere('all','all','mst_peg_struktural');
		$data['mst_peg_fungsional_umum']	= $this->drh_model->get_datawhere('FUNGSIONAL_UMUM','tar_jenis','mst_peg_fungsional');
		$data['mst_peg_fungsional_tertentu']= $this->drh_model->get_datawhere('FUNGSIONAL_TERTENTU','tar_jenis','mst_peg_fungsional');
		$data['mst_peg_rumpunpendidikan']			= $this->drh_model->get_datawhere('all','all','mst_peg_rumpunpendidikan');
		$data['mst_peg_tingkatpendidikan']			= $this->drh_model->get_datawhere('all','all','mst_peg_tingkatpendidikan');


		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		
		
		if($this->form_validation->run()== FALSE){
			$data = $this->drh_model->get_data_row_edit($id,$tmt); 
			$data['statusjenis']	= $this->pilihan_enums('pegawai_jabatan','jenis');
			$data['statusjenissk']	= $this->pilihan_enums('pegawai_jabatan','sk_status');
			$data['mst_peg_struktural']			= $this->drh_model->get_datawhere('all','all','mst_peg_struktural');
			$data['mst_peg_rumpunpendidikan']			= $this->drh_model->get_datawhere('all','all','mst_peg_rumpunpendidikan');
			$data['mst_peg_fungsional_umum']	= $this->drh_model->get_datawhere('FUNGSIONAL_UMUM','tar_jenis','mst_peg_fungsional');
			$data['mst_peg_fungsional_tertentu']= $this->drh_model->get_datawhere('FUNGSIONAL_TERTENTU','tar_jenis','mst_peg_fungsional');
			$data['mst_peg_tingkatpendidikan']			= $this->drh_model->get_datawhere('all','all','mst_peg_tingkatpendidikan');
			$data['id']				= $id;
		    $data['action']			= "edit";
			$data['alert_form'] 	= '';
			$data['tmt'] 			= $tmt;

			$kodepuskesmas = $this->session->userdata('puskesmas');
			if(strlen($kodepuskesmas) == 4){
				$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
			}else {
				$this->db->where('code','P'.$kodepuskesmas);
			}

			$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
			$data['alert_form'] 	= '';
			die($this->parser->parse("kepegawaian/drh/form_jabatan_form",$data));
		}elseif($st = $this->drh_model->update_entry_jabatan_formal($id,$tmt)){
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