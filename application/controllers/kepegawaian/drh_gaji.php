<?php
class Drh_gaji extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('kepegawaian/drh_model');
		$this->load->model('mst/puskesmas_model');
	}

	function json($id){
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
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows_all = $this->drh_model->get_data_gaji($id);

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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

		$rows = $this->drh_model->get_data_gaji($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_pegawai'  			=> $act->id_pegawai,
				'tmt'					=> $act->tmt,
				'tmt2'					=> $act->tmt,
				'surat_nomor'    		=> $act->surat_nomor,
				'id_mst_peg_golruang'	=> $act->id_golongan.' - '.$act->ruang,
				'gaji_baru'				=> $act->gaji_baru,
				'masa_krj'				=> $act->masa_krj_thn.' thn '.$act->masa_krj_bln.' bln ',
				'edit'		        	=> 1,
				'delete'	        	=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	
	function add($id=0,$tmt=0){
        $this->form_validation->set_rules('tmt', 'TMT', 'trim|required');
        $this->form_validation->set_rules('surat_nomor', 'Nomor Surat', 'trim|required');
        $this->form_validation->set_rules('id_mst_peg_golruang', 'Golongan', 'trim|required');
        $this->form_validation->set_rules('gaji_lama', 'gaji_lama', 'trim');
        $this->form_validation->set_rules('gaji_lama_pp', 'gaji_lama_pp', 'trim');
        $this->form_validation->set_rules('gaji_baru', 'Gaji Baru', 'trim|required');
        $this->form_validation->set_rules('gaji_baru_pp', 'PP Gaji Baru ', 'trim|required');
        $this->form_validation->set_rules('sk_tgl', 'sk_tgl ', 'trim');
        $this->form_validation->set_rules('sk_nomor', 'sk_nomor ', 'trim');
        $this->form_validation->set_rules('sk_pejabat', 'sk_pejabat ', 'trim');
        $this->form_validation->set_rules('masa_krj_bln', 'masa_krj_bln ', 'trim');
        $this->form_validation->set_rules('masa_krj_thn', 'masa_krj_thn ', 'trim');
		$data['id']			= $id;
	    $data['action']		= "add";
	    $data['tmt']		= "";
		$data['alert_form'] = '';
		$data['disable']	= '';
		$data['golongan'] 	= $this->drh_model->kode_tabel('mst_peg_golruang');

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("kepegawaian/drh/form_gaji_form",$data));
		}elseif($res = $this->drh_model->insert_entry_gaji($id)){
			if ($res == 'false') {
				die("NOTOK");
			}else{
				die("OK");
			}
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_gaji_form",$data));
	}

	function edit($id="",$tmt=0){

        $this->form_validation->set_rules('surat_nomor', 'Nomor Surat', 'trim|required');
        $this->form_validation->set_rules('id_mst_peg_golruang', 'Golongan', 'trim|required');
        $this->form_validation->set_rules('gaji_lama', 'gaji_lama', 'trim');
        $this->form_validation->set_rules('gaji_lama_pp', 'gaji_lama_pp', 'trim');
        $this->form_validation->set_rules('gaji_baru', 'Gaji Baru', 'trim|required');
        $this->form_validation->set_rules('gaji_baru_pp', 'PP Gaji Baru ', 'trim|required');
        $this->form_validation->set_rules('sk_tgl', 'sk_tgl ', 'trim');
        $this->form_validation->set_rules('sk_nomor', 'sk_nomor ', 'trim');
        $this->form_validation->set_rules('sk_pejabat', 'sk_pejabat ', 'trim');
        $this->form_validation->set_rules('masa_krj_bln', 'masa_krj_bln ', 'trim');
        $this->form_validation->set_rules('masa_krj_thn', 'masa_krj_thn ', 'trim');
		$data['id']				= $id;
	    $data['action']			= "edit";
		$data['alert_form']		= '';
		
		
		if($this->form_validation->run()== FALSE){
			$data 						= $this->drh_model->get_data_gaji_edit($id,$tmt);
			$data['notice']				= validation_errors();
			$data['tmt']	= $tmt;
			$data['disable']			= "disable";
			$data['golongan'] 	= $this->drh_model->kode_tabel('mst_peg_golruang');
			die($this->parser->parse("kepegawaian/drh/form_gaji_form",$data));
		
		}elseif($this->drh_model->update_entry_gaji($id,$tmt)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_gaji_form",$data));
	}

	
	function delete($id=0,$tmt=0){
		 $this->authentication->verify('kepegawaian','del');

		 if($this->drh_model->delete_entry_gaji($id,$tmt)){
		 	die ("OK");
		 } else {
		 	die ("Error");
		 }
	}


	//CRUD Keluarga - END
}