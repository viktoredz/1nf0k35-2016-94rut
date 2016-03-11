<?php
class Laporan_kpldh extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('eform/datakeluarga_model');
		$this->load->model('eform/pembangunan_keluarga_model');
		$this->load->model('eform/anggota_keluarga_kb_model');
		$this->load->model('eform/dataform_model');
	}

	function index(){
		$this->authentication->verify('inventory','edit');
		$data['title_group'] 	= "Laporan";
		$data['title_form'] 	= "Ketuk Pintu Layani Dengan Hati";;

      	$data['data_kecamatan'] = $this->datakeluarga_model->get_kecamatan();
      	$data['data_desa'] = $this->datakeluarga_model->get_desa();

		$data['content'] = $this->parser->parse("eform/laporan/show",$data,true);

		$this->template->show($data,"home");
	}
	
}
