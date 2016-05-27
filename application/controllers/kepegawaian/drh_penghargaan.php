<?php
class Drh_penghargaan extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('kepegawaian/drh_model');
		$this->load->model('mst/puskesmas_model');
	}

//CRUD Keluarga
	function json($id){
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'sk_tgl') {
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

		$rows_all = $this->drh_model->get_data_pengahargaan($id);

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'sk_tgl') {
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

		$rows = $this->drh_model->get_data_pengahargaan($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_pegawai'  		=> $act->id_pegawai,
				'id_mst_peg_penghargaan'	=> $act->id_mst_peg_penghargaan,
				'tingkat'    		=> $act->tingkat,
				'instansi'	  		=> $act->instansi,
				'sk_no'				=> $act->sk_no,
				'sk_tgl'			=> $act->sk_tgl,
				'sk_pejabat'		=> $act->sk_pejabat,
				'nama_penghargaan'	=> $act->nama_penghargaan,
				'edit'		        => 1,
				'delete'	        => 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	



	function add($id=0,$id_mst_peg_penghargaan=0){
        $this->form_validation->set_rules('id_mst_peg_penghargaan', 'Penghargaan', 'trim|required');
        $this->form_validation->set_rules('tingkat', 'Tingkat', 'trim|required');
        $this->form_validation->set_rules('instansi', 'Nama Negara/Instansi yang Memberi ', 'trim|required');
        $this->form_validation->set_rules('sk_tgl', 'Tanggal SK', 'trim|required');
        $this->form_validation->set_rules('sk_pejabat', 'SK Pejabat', 'trim|required');
        $this->form_validation->set_rules('sk_no', 'Nomor SK', 'trim|required');
		$data['id']					= $id;
	    $data['action']				= "add";
	    $data['id_mst_peg_penghargaan']	= "";
		$data['alert_form'] 		= '';
		$data['kodepenghargaan'] 			= $this->drh_model->get_datawhere('all','all','mst_peg_penghargaan');

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("kepegawaian/drh/form_penghargaan_form",$data));
		}elseif($res = $this->drh_model->insert_entry_penghargaan($id,$id_mst_peg_penghargaan)){
			if ($res == 'false') {
				die("NOTOK");
			}else{
				die("OK");
			}
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_penghargaan_form",$data));
	}

	function edit($id="",$id_mst_peg_penghargaan=0){

        $this->form_validation->set_rules('id_mst_peg_penghargaan', 'Penghargaan', 'trim|required');
        $this->form_validation->set_rules('tingkat', 'Tingkat', 'trim|required');
        $this->form_validation->set_rules('instansi', 'Nama Negara/Instansi yang Memberi ', 'trim|required');
        $this->form_validation->set_rules('sk_tgl', 'Tanggal SK', 'trim|required');
        $this->form_validation->set_rules('sk_pejabat', 'SK Pejabat', 'trim|required');
        $this->form_validation->set_rules('sk_no', 'Nomor SK', 'trim|required');
		$data['id']					= $id;
	    $data['action']				= "edit";
	    
		$data['alert_form'] 		= '';
		
		
		if($this->form_validation->run()== FALSE){
			$data 						= $this->drh_model->get_data_penghargan_edit($id,$id_mst_peg_penghargaan);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['id_mst_peg_penghargaan']	= $id_mst_peg_penghargaan;
			$data['alert_form'] 		= '';
			$data['disable']			= "disable";
			$data['kodepenghargaan'] 			= $this->drh_model->get_datawhere('all','all','mst_peg_penghargaan');
			die($this->parser->parse("kepegawaian/drh/form_penghargaan_form",$data));
		
		}elseif($this->drh_model->update_entry_penghargaan($id,$id_mst_peg_penghargaan)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("kepegawaian/drh/form_penghargaan_form",$data));
	}

	
	function delete($id=0,$id_mst_peg_penghargaan=0){

		 $this->authentication->verify('kepegawaian','del');

		 if($this->drh_model->delete_entry_penghargaan($id,$id_mst_peg_penghargaan)){
		 	die ("OK");
		 } else {
		 	die ("Error");
		 }
	}


	//CRUD Keluarga - END
}