<?php
class Data_kepala_keluarga extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('eform/datakeluarga_model');
	}
    
	function json(){
		$this->authentication->verify('eform','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				$this->db->like($field,$value);
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows_all = $this->datakeluarga_model->get_data();

    	if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				$this->db->like($field,$value);
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows = $this->datakeluarga_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_data_keluarga'		=> $act->id_data_keluarga,
				'tanggal_pengisian'		=> $act->tanggal_pengisian,
				'jam_data'				=> $act->jam_data,
				'alamat'				=> $act->alamat,
				'id_propinsi'			=> $act->id_propinsi,
				'id_kota'				=> $act->id_kota,
				'id_kecamatan'			=> $act->id_kecamatan,
				'value'					=> $act->value,
				'rt'					=> $act->rt,
				'rw'					=> $act->rw,
				'norumah'				=> $act->norumah,
				'nokeluarga'			=> $act->nokeluarga,
				'nourutkel'				=> $act->nourutkel,
				'id_kodepos'			=> $act->id_kodepos,
				'namakepalakeluarga'	=> $act->namakepalakeluarga,
				'notlp'					=> $act->notlp,
				'namadesawisma'			=> $act->namadesawisma,
				'id_pkk'				=> $act->id_pkk,
				'nama_komunitas'		=> $act->nama_komunitas,
				'edit'					=> 1,
				'delete'				=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function index(){
		$this->authentication->verify('eform','edit');
		$data['title_group'] = "eForm - Ketuk Pintu";
		$data['title_form'] = "Data Kepala Keluarga";

		$data['content'] = $this->parser->parse("eform/datakeluarga/show",$data,true);

		$this->template->show($data,"home");
	}


	function add(){
		$this->authentication->verify('eform','add');

        $this->form_validation->set_rules('tgl_pengisian', 'Tanggal Pengisian', 'trim|required');
        $this->form_validation->set_rules('jam_data', 'Jam Pendataan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('dusun', 'Dusun / RW', 'trim|required');
        $this->form_validation->set_rules('rt', 'RT', 'trim|required');
        $this->form_validation->set_rules('norumah', 'No Rumah', 'trim|required');
        $this->form_validation->set_rules('namakomunitas', 'Nama Komunitas', 'trim|required');
        $this->form_validation->set_rules('namakepalakeluarga', 'Nama Kepala Keluarga', 'trim|required');
        $this->form_validation->set_rules('notlp', 'No. HP / Telepon', 'trim|required');
        $this->form_validation->set_rules('namadesawisma', 'Nama Desa Wisma', 'trim|required');
        $this->form_validation->set_rules('jabatanstuktural', '', 'trim');
        $this->form_validation->set_rules('kelurahan', '', 'trim');
        $this->form_validation->set_rules('kodepos', '', 'trim');
        
		if($this->form_validation->run()== FALSE){
			$data['title_group'] = "eForm - Ketuk Pintu";
			$data['title_form']="Tambah Data Keluarga";
			$data['action']="add";
			$data['kode']="";
          	$data['data_desa'] = $this->datakeluarga_model->get_desa(3172100);
          	$data['data_pos'] = $this->datakeluarga_model->get_pos(3172100);
          	$data['data_pkk'] = $this->datakeluarga_model->get_pkk();

			$data['content'] = $this->parser->parse("eform/datakeluarga/form",$data,true);
			$this->template->show($data,"home");
		}elseif($id = $this->datakeluarga_model->insert_entry()){
			$this->session->set_flashdata('alert', 'Save data successful...');
			redirect(base_url().'eform/data_kepala_keluarga/edit/'.$id);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."eform/data_kepala_keluarga/");
		}

	}
    
	function addtable(){
		 $this->datakeluarga_model->insertDataTable();
	}
    
	function edit($kode=0){
		$this->authentication->verify('eform','edit');

        $this->form_validation->set_rules('tgl_pengisian', 'Tanggal Pengisian', 'trim|required');
        $this->form_validation->set_rules('jam_data', 'Jam Pendataan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('dusun', 'Dusun / RW', 'trim|required');
        $this->form_validation->set_rules('rt', 'RT', 'trim|required');
        $this->form_validation->set_rules('norumah', 'No Rumah', 'trim|required');
        $this->form_validation->set_rules('namakomunitas', 'Nama Komunitas', 'trim|required');
        $this->form_validation->set_rules('namakepalakeluarga', 'Nama Kepala Keluarga', 'trim|required');
        $this->form_validation->set_rules('notlp', 'No. HP / Telepon', 'trim|required');
        $this->form_validation->set_rules('namadesawisma', 'Nama Desa Wisma', 'trim|required');
        $this->form_validation->set_rules('jabatanstuktural', '', 'trim');
        $this->form_validation->set_rules('kelurahan', '', 'trim');
        $this->form_validation->set_rules('kodepos', '', 'trim');

		if($this->form_validation->run()== FALSE){
			$data = $this->datakeluarga_model->get_data_row($kode); 

			$data['title_group'] = "eForm";
			$data['title_form']="Ubah Data Keluarga";
			$data['action']="edit";
			$data['id_data_keluarga'] = $kode;
          	$data['data_desa'] = $this->datakeluarga_model->get_desa(3172100);
          	$data['data_pos'] = $this->datakeluarga_model->get_pos(3172100);
          	$data['data_pkk'] = $this->datakeluarga_model->get_pkk();
			$data['data_profile']  = $this->datakeluarga_model->get_data_profile($kode); 
            $data['jabatan_pkk'] = $this->datakeluarga_model->get_pkk_value($data['id_pkk']);
            $data['data_print'] = $this->parser->parse("eform/datakeluarga/print", $data, true);

		
			$data['content'] = $this->parser->parse("eform/datakeluarga/form_detail",$data,true);
			$this->template->show($data,"home");
		}elseif($this->datakeluarga_model->update_entry($kode)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."eform/data_kepala_keluarga/edit/".$this->input->post('id_data_keluarga'));
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."eform/data_kepala_keluarga/edit/".$kode);
		}
	}

	function tab($pageIndex,$id_data_keluarga){
		$data = array();
		$data['id_data_keluarga']=$id_data_keluarga;

		switch ($pageIndex) {
			case 1:
				die($this->parser->parse("eform/datakeluarga/form_profile",$data));

				break;
			case 2:
				die($this->parser->parse("eform/datakeluarga/form_profile",$data));

				break;
			case 3:
				die($this->parser->parse("eform/datakeluarga/form_profile",$data));

				break;
			default:

				die($this->parser->parse("eform/datakeluarga/form_profile",$data));
				break;
		}

	}

	function dodel($kode=0){
		$this->authentication->verify('eform','del');

		if($this->datakeluarga_model->delete_entry($kode)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
			redirect(base_url()."eform/data_kepala_keluarga/");
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
			redirect(base_url()."eform/data_kepala_keluarga/");
		}
	}
}
