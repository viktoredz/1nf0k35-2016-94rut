<?php
class Drh_pangkat extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('kepegawaian/drh_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
	}

//CRUD Pendidikan
	function json_pangkat_cpns($id){
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'ijazah_tgl') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'cpns') {
					$value = $value == 'Ya' ? 1 : 0;
					$this->db->where('pegawai_pendidikan.status_pendidikan_cpns',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('status !=','PNS');
		$rows_all = $this->drh_model->get_data_pangkat_cpns($id);

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'ijazah_tgl') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'cpns') {
					$value = $value == 'Ya' ? 1 : 0;
					$this->db->where('pegawai_pendidikan.status_pendidikan_cpns',$value);
				}else{
					$this->db->like($field,$value);
				}

			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('status !=','PNS');
		$rows = $this->drh_model->get_data_pangkat_cpns($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_pegawai'		=> $act->id_pegawai,
				'nip_nit' 			=> $act->nip_nit,
				'tmt'				=> date("d-m-Y",strtotime($act->tmt)),
				'id_mst_peg_golruang'=> $act->id_mst_peg_golruang,
				'is_pnsbaru'		=> $act->is_pnsbaru,
				'status'			=> $act->status,
				'jenis_pengadaan'	=> ucwords($act->jenis_pengadaan),
				'jenis_pangkat'		=> ucwords($act->jenis_pangkat),
				'masa_krj_bln'		=> $act->masa_krj_bln,
				'masa_krj_thn'		=> $act->masa_krj_thn,
				'bkn_tgl'			=> $act->bkn_tgl,
				'bkn_nomor'			=> $act->bkn_nomor,
				'sk_pejabat'		=> $act->sk_pejabat,
				'sk_tgl'			=> $act->sk_tgl,
				'spmt_tgl'			=> $act->spmt_tgl,
				'spmt_nomor'		=> $act->spmt_nomor,
				'sk_nomor'			=> $act->sk_nomor,
				'sttpl_tgl'			=> $act->sttpl_tgl,
				'sttpl_nomor'		=> $act->sttpl_nomor,
				'dokter_tgl'		=> $act->dokter_tgl,
				'dokter_nomor'		=> $act->dokter_nomor,
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

	function json_pangkat_pns($id){
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'ijazah_tgl') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'cpns') {
					$value = $value == 'Ya' ? 1 : 0;
					$this->db->where('pegawai_pendidikan.status_pendidikan_cpns',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('status','PNS');
		$this->db->where('is_pengangkatan ','1');
		$rows_all = $this->drh_model->get_data_pangkat_cpns($id);

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'ijazah_tgl') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'cpns') {
					$value = $value == 'Ya' ? 1 : 0;
					$this->db->where('pegawai_pendidikan.status_pendidikan_cpns',$value);
				}else{
					$this->db->like($field,$value);
				}

			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('status','PNS');
		$this->db->where('is_pengangkatan','1');
		$rows = $this->drh_model->get_data_pangkat_cpns($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_pegawai'		=> $act->id_pegawai,
				'nip_nit' 			=> $act->nip_nit,
				'tmt'				=> date("d-m-Y",strtotime($act->tmt)),
				'id_mst_peg_golruang'=> $act->id_mst_peg_golruang,
				'is_pnsbaru'		=> $act->is_pnsbaru,
				'status'			=> $act->status,
				'jenis_pengadaan'	=> ucwords($act->jenis_pengadaan),
				'jenis_pangkat'		=> ucwords($act->jenis_pangkat),
				'masa_krj_bln'		=> $act->masa_krj_bln,
				'masa_krj_thn'		=> $act->masa_krj_thn,
				'bkn_tgl'			=> $act->bkn_tgl,
				'bkn_nomor'			=> $act->bkn_nomor,
				'sk_pejabat'		=> $act->sk_pejabat,
				'sk_tgl'			=> $act->sk_tgl,
				'sk_nomor'			=> $act->sk_nomor,
				'sttpl_tgl'			=> $act->sttpl_tgl,
				'spmt_tgl'			=> $act->spmt_tgl,
				'spmt_nomor'		=> $act->spmt_nomor,
				'sttpl_nomor'		=> $act->sttpl_nomor,
				'dokter_tgl'		=> $act->dokter_tgl,
				'dokter_nomor'		=> $act->dokter_nomor,
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

	function json_pangkat_setelahpns($id){
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'ijazah_tgl') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'cpns') {
					$value = $value == 'Ya' ? 1 : 0;
					$this->db->where('pegawai_pendidikan.status_pendidikan_cpns',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('status','PNS');
		$this->db->where('is_pengangkatan !=','1');
		$rows_all = $this->drh_model->get_data_pangkat_cpns($id);

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'ijazah_tgl') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'cpns') {
					$value = $value == 'Ya' ? 1 : 0;
					$this->db->where('pegawai_pendidikan.status_pendidikan_cpns',$value);
				}else{
					$this->db->like($field,$value);
				}

			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('status','PNS');
		$this->db->where('is_pengangkatan !=','1');
		$rows = $this->drh_model->get_data_pangkat_cpns($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_pegawai'		=> $act->id_pegawai,
				'nip_nit' 			=> $act->nip_nit,
				'tmt'				=> date("d-m-Y",strtotime($act->tmt)),
				'id_mst_peg_golruang'=> $act->id_mst_peg_golruang,
				'is_pnsbaru'		=> $act->is_pnsbaru,
				'status'			=> $act->status,
				'jenis_pengadaan'	=> ucwords($act->jenis_pengadaan),
				'jenis_pangkat'		=> ucwords($act->jenis_pangkat),
				'masa_krj_bln'		=> $act->masa_krj_bln,
				'masa_krj_thn'		=> $act->masa_krj_thn,
				'bkn_tgl'			=> $act->bkn_tgl,
				'bkn_nomor'			=> $act->bkn_nomor,
				'sk_pejabat'		=> $act->sk_pejabat,
				'sk_tgl'			=> $act->sk_tgl,
				'sk_nomor'			=> $act->sk_nomor,
				'sttpl_tgl'			=> $act->sttpl_tgl,
				'sttpl_nomor'		=> $act->sttpl_nomor,
				'dokter_tgl'		=> $act->dokter_tgl,
				'dokter_nomor'		=> $act->dokter_nomor,
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

	function biodata_pangkat($pageIndex,$id){
		$data = array();
		$data['id']=$id;

		switch ($pageIndex) {
			case 1:
				die($this->parser->parse("kepegawaian/drh/from_pangkat_cpns",$data));
				break;
			case 2:
				die($this->parser->parse("kepegawaian/drh/from_pangkat_pns",$data));
				break;
			default:
				die($this->parser->parse("kepegawaian/drh/form_pangkat_setelahpns",$data));
				break;
		}

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
			die($this->parser->parse("kepegawaian/drh/form_pangkat_form",$data));
		}elseif($st = $this->drh_model->insert_entry_cpns_formal($id)){
			die("OK | $st");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_pangkat_form",$data));
	}

	function edit($id="",$tmt=0){
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
        $kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		$wak = date("d-m-Y",strtotime($tmt));
		$data = $this->drh_model->getItem($id,$wak);
        $data['id']				= $id;
	    $data['action']			= "edit";
		$data['alert_form'] 	= '';

		$this->db->order_by('no_urut','asc');
		$data['kode_status'] 	= $this->drh_model->kode_tabel('mst_peg_status');
		$data['kode_pns'] 		= $this->drh_model->kode_tabel('mst_peg_golruang');
		$data['kode_pengadaan']	= $this->pilihan_enums('pegawai_pangkat','jenis_pengadaan');
		$data['kode_pangkat']	= $this->pilihan_enums('pegawai_pangkat','jenis_pangkat');
		if($this->form_validation->run()== FALSE){
			$data['id']				= $id;
		    $data['action']			= "edit";
			$data['alert_form'] 	= '';
			$kodepuskesmas = $this->session->userdata('puskesmas');
			if(strlen($kodepuskesmas) == 4){
				$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
			}else {
				$this->db->where('code','P'.$kodepuskesmas);
			}

			$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
			die($this->parser->parse("kepegawaian/drh/form_pangkat_form",$data));
		}else if($st=$this->drh_model->update_entry_pns_formal($id,$tmt)){
			die("OK | $st");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("kepegawaian/drh/form_pangkat_form",$data));
	}

	function biodata_pangkat_setelahpns_del($id="",$tmt=0){
		$this->authentication->verify('kepegawaian','del');

		if($this->drh_model->delete_entry_pns_formal($id,$tmt)){
			die ("OK");
		} else {
			die ("Error");
		}
	}

	function biodata_pangkat_cpns_del($id="",$tmt=0){
		$this->authentication->verify('kepegawaian','del');

		if($this->drh_model->delete_entry_pns_formal($id,$tmt)){
			die ("OK");
		} else {
			die ("Error");
		}
	}
	function biodata_pangkat_pns_del($id="",$tmt=0){
		$this->authentication->verify('kepegawaian','del');

		if($this->drh_model->delete_entry_pns_formal($id,$tmt)){
			die ("OK");
		} else {
			die ("Error");
		}
	}

}