<?php
class Keuangan_sts extends CI_Controller {

 public function __construct(){
		parent::__construct();
		$this->load->model('mst/keusts_model');
	}

	function index(){
		$this->authentication->verify('mst','edit');
		$data['title_group']   = "Keuangan";
		$data['title_form']    = "Daftar Tarif Surat Tanda Setoran";
		$data['ambildata']     = $this->keusts_model->get_data();
		$data['kode_rekening'] = $this->keusts_model->get_kode_rek();
		$data['content']       = $this->parser->parse("mst/keusts/show",$data,true);		
		
		$this->template->show($data,"home");
	}

	function sts($pageIndex){
		$data = array();

		switch ($pageIndex) {
			case 1:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Daftar Tarif Surat Tanda Setoran";
				$data['ambildata']     = $this->keusts_model->get_data();
				$data['versi'] 		   = $this->keusts_model->get_versi_sts();
				$data['kode_rekening'] = $this->keusts_model->get_data_kode_rekening();
				$data['kode_rek']	   = $this->keusts_model->get_data_kode_rek();

				die($this->parser->parse("mst/keusts/daftar_tarif_sts",$data));

				break;
			case 2:
				die($this->parser->parse("mst/keusts/pengaturan_sts",$data));

				break;
		}
	}

	function sts_sts($pageIndex){
		$data = array();

		switch ($pageIndex) {
			case 1:
				$data['title_group']   = "Keuangan";
			    $data['title_form']    = "Ubah Daftar Tarif Surat Tanda Setoran";
			    $data['title_pupup']   = "Buat Versi Daftar Tarif STS Baru";
				$data['ambildata']     = $this->keusts_model->get_data();
				$data['versi'] 		   = $this->keusts_model->get_versi_sts();
				$data['kode_rekening'] = $this->keusts_model->get_data_kode_rekening();
				
				die($this->parser->parse("mst/keusts/daftar_tarif_sts_form",$data));

				break;
			case 2:
				die($this->parser->parse("mst/keusts/pengaturan_sts",$data));

				break;
		}
	}

	function versi_add(){
		$this->authentication->verify('mst','add');

    	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('deskripsi', ' Deskripsi', 'trim|required');
        $this->form_validation->set_rules('tanggal_dibuat', 'Tanggal Dibuat', 'trim|required');

		$data['id_mst_anggaran_versi']	= "";
	    $data['action']					= "add";
		$data['alert_form']		   	    = '';

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keusts/form_tambah_versi",$data));
		}elseif($this->keuinstansi_model->insert_versi()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("mst/keusts/form_tambah_versi",$data));
	}

	function induk_add(){
		$this->authentication->verify('mst','add');

    	$this->form_validation->set_rules('kode_anggaran', 'Kode Anggaran', 'trim|required');
        $this->form_validation->set_rules('uraian', ' Uraian', 'trim|required');
        $this->form_validation->set_rules('id_mst_akun', 'Kode Akun', 'trim|required');

		$data['id_mst_anggaran_versi']	= "";
		$data['kode_rek']		   	    = $this->keusts_model->get_kode_rek();
	    $data['action']					= "add";
		$data['alert_form']		   	    = '';

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keusts/form_tambah_induk",$data));
		}elseif($this->keusts_model->insert_induk()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("mst/keusts/form_tambah_induk",$data));
	}

	function induk_edit($id=0){
 	 	$this->form_validation->set_rules('kode_anggaran', 'Kode Anggaran', 'trim|required');
        $this->form_validation->set_rules('uraian', ' Uraian', 'trim|required');
        $this->form_validation->set_rules('id_mst_akun', 'Kode Akun', 'trim|required');

		if($this->form_validation->run()== FALSE){

			$data 						= $this->keusts_model->get_data_induk_edit($id);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['alert_form'] 		= '';
			$data['disable']			= "disable";
			$data['kode_rek']		    = $this->keusts_model->get_kode_rek();

			die($this->parser->parse("mst/keusts/form_tambah_induk",$data));

		}elseif($this->keusts_model->update_entry_induk($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("mst/keusts/form_tambah_induk",$data));
	}

	function api_data(){
		$this->authentication->verify('mst','edit');		
		
		if(empty($this->session->userdata('tipe'))){
			$this->session->userdata('tipe','kec');
		}
		
		$data['ambildata'] = $this->keusts_model->get_data_type_filter($this->session->userdata('tipe'));
		foreach($data['ambildata'] as $d){
			$txt = $d["id_mst_anggaran"]." \t ".$d["id_mst_anggaran_parent"]." \t ".$d["id_mst_akun"]."-".$d["kode_anggaran"]." \t ".$d["uraian"]." \t ".$d["tarif"]." \t ".$d["id_mst_anggaran_versi"]." \n";				
			echo $txt;
		}
		
	}
	
	function api_data_tarif(){
		$this->authentication->verify('mst','edit');		
		
		if(!empty($this->session->userdata('puskes')) and  $this->session->userdata('puskes') != '0'){
			$data['ambildata'] = $this->sts_model->get_data_puskesmas_filter($this->session->userdata('puskes'));
			$i=0;
			foreach($data['ambildata'] as $d){
				$txt = $d["id_anggaran"]." \t ".$d["sub_id"]." \t ".$d["rekening"]." \t ".$d["kode_anggaran"]." \t ".$d["uraian"]." \t ".$d["type"]." \t".$i++." \t".$d["id_keu_anggaran"]." \t".$d["tarif"]." \t".$d["code_cl_phc"]." \n";				
				echo $txt;
			}
		}
		
	}
	
	function set_type(){
		$this->authentication->verify('mst','edit');
		$this->session->set_userdata('tipe',$this->input->post('tipe'));
	}
	
	function set_puskes(){
		$this->authentication->verify('mst','edit');
		$this->session->set_userdata('puskes',$this->input->post('puskes'));		
		
	}

	function anggaran_ubah(){
		$this->authentication->verify('mst','edit');
		$data['title_group']   = "Tarif Surat Tanda Setoran";
		$data['title_form']    = "Ubah Daftar Tarif Surat Tanda Setoran";
		
		$data['content']       = $this->parser->parse("mst/keusts/show_edit",$data,true);		
		
		$this->template->show($data,"home");
	}

	function anggaran_tarif(){
		$this->authentication->verify('mst','edit');
		$data['title_group'] = "Keuangan";
		$data['title_form'] = "Master Data - Tarif STS";
		$data['ambildata'] = $this->keusts_model->get_data();
		$data['data_puskesmas']	= $this->keusts_model->get_data_puskesmas();
		$data['content'] = $this->parser->parse("keuangan/anggaran_tarif",$data,true);					
		$this->template->show($data,"home");
	}
	
	function add_tarif(){
		$this->authentication->verify('mst','add');
		
		$this->form_validation->set_rules('id_anggaran','ID Anggaran','trim|required');
		$this->form_validation->set_rules('tarif','Tarif','trim|required');
				
		if($this->form_validation->run()== TRUE){
			$this->sts_model->add_tarif();	
			echo "0";
		}else{			
			echo validation_errors();
		}	
	}
	
	function anggaran_add(){
		$this->authentication->verify('mst','add');
		$this->form_validation->set_rules('sub_id','sub_id','trim|required');
		$this->form_validation->set_rules('kode_anggaran','Kode Anggaran','trim|required');
		$this->form_validation->set_rules('kode_rekening','Kode Rekening','trim|required');
		if($this->form_validation->run()== TRUE){
			$this->sts_model->add_anggaran();	
			echo "0";
		}else{			
			echo validation_errors();
		}	
	}

	function anggaran_update(){
		$this->authentication->verify('mst','edit');		
		
		$this->form_validation->set_rules('kode_rekening','Kode Rekening','trim|required');
		$this->form_validation->set_rules('id_anggaran','ID Anggaran','trim|required');
		$this->form_validation->set_rules('sub_id','Sub Id','trim|required');
		$this->form_validation->set_rules('kode_anggaran','Kode Anggaran','trim|required');
		$this->form_validation->set_rules('uraian','Uraian','trim|required');		
		
		if($this->form_validation->run()== TRUE){
			$this->sts_model->update_anggaran();
			echo "0";			
		}else{						
			echo validation_errors();
		}
	}

	function anggaran_delete(){
		$this->authentication->verify('mst','del');
		$this->sts_model->delete_anggaran();				
	}
	
	function kode_rekening_add(){
		#var_dump($_POST);
		$this->authentication->verify('mst','add');
		
		$this->form_validation->set_rules('kode_rekening','Kode Rekening','trim|required');
		$this->form_validation->set_rules('uraian','Uraian Anggaran','trim|required');
		$this->form_validation->set_rules('tipe','Tipe Rekening','trim|required');
		
		if($this->form_validation->run()== TRUE){
			$this->sts_model->add_kode_rekening();
			echo "0";
		}else{			
			echo validation_errors();
		}	
	}
	
	function kode_rekening_update(){
		#var_dump($_POST);
		$this->authentication->verify('mst','edit');
		$this->form_validation->set_rules('kode_rekening','Kode Rekening','trim|required');
		$this->form_validation->set_rules('uraian','Uraian Anggaran','trim|required');
		$this->form_validation->set_rules('tipe','Tipe Rekening','trim|required');
		$this->form_validation->set_rules('code','Tipe Rekening','trim|required');
				
		if($this->form_validation->run()== TRUE){
			$this->sts_model->update_kode_rekening();
			echo "0";
		}else{			
			echo validation_errors();
		}		
	}
	
	function kode_rekening_delete(){
		#var_dump($_POST);
		$this->authentication->verify('mst','edit');		
		$this->form_validation->set_rules('code','Tipe Rekening','trim|required');
		
		if($this->form_validation->run()== TRUE){
			$this->sts_model->delete_kode_rekening();
		}else{
			echo "ups";
		}	
	}
}


