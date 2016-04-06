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
		$data['ambildata'] 	   = $this->keusts_model->get_data();
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
				$data['kode_rekening'] = $this->keusts_model->get_data_kode_rekening();
				$data['kode_rek']	   = $this->keusts_model->get_data_kode_rek();

				die($this->parser->parse("mst/keusts/daftar_tarif_sts",$data));

				break;
			case 2:
				die($this->parser->parse("mst/keusts/pengaturan_sts",$data));

				break;
			default:

				die($this->parser->parse("mst/keusts/penggunaan_tarif_sts",$data));
				break;
		}
	}

	function json_penggunaan_tarif_sts($id){
		$this->authentication->verify('mst','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lahir') {
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

		$rows_all = $this->keusts_model->get_data_sts($versi);

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lahir') {
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

		$rows = $this->keusts_model->get_data_sts($versi,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_mst_anggaran'  		=> $act->id_mst_anggaran,
				'id_mst_anggaran_parent'=> $act->id_mst_anggaran_parent,
				'id_mst_akun'    		=> $act->id_mst_akun,
				'kode_anggaran'  		=> $act->kode_anggaran,
				'uraian'				=> $act->uraian,
				'tarif'					=> $act->tarif,
				'id_mst_anggaran_versi'	=> $act->id_mst_anggaran_versi,
				'edit'		 	        => 1,
				'delete'	     	    => 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}


	function versi_add(){
		$this->authentication->verify('mst','add');
		
	    $this->form_validation->set_rules('id_mst_anggaran_versi', 'Kode Versi', 'trim|required');
    	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('deskripsi', ' Deskripsi', 'trim|required');

		$data['id_mst_anggaran_versi']	= "";
	    $data['action']					= "add";
		$data['alert_form']		   	    = '';
		$data['versi'] 		            = $this->keusts_model->get_versi_sts();
	    $data['kode']		         	= "";

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keusts/form_tambah_versi",$data));
		}elseif($this->keusts_model->insert_versi()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}

		die($this->parser->parse("mst/keusts/form_tambah_versi",$data));
	}

	public function kodeVersi($id=0){
		$this->db->where('code',"P".$this->session->userdata('puskesmas'));
		$query = $this->db->get('cl_phc')->result();
		foreach ($query as $q) {
			$kode[] = array(
				'kodeversi' => $q->code, 
			);
			echo json_encode($kode);
		}
	}

	function get_versi(){

	if ($this->input->post('versi')!="null") {
		if($this->input->is_ajax_request()) {
			$versi = $this->input->post('versi');
			$this->session->set_userdata('versi',$this->input->post('versi'));
			$ver 	= $this->keusts_model->get_versi_sts();

				echo '<option value="">Pilih Versi</option>';
			foreach($ver as $ver) :
				echo $select = $ver->id_mst_anggaran_versi == set_value('versi') ? 'selected' : '';
				echo '<option value="'.$ver->id_mst_anggaran_versi.'" '.$select.'>' . $ver->nama . '</option>';
			endforeach;

			return FALSE;
		}

		 show_404();
	   }
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

	function kembali(){

		$data['title_group']   = "Keuangan";
		$data['title_form']    = "Daftar Tarif Surat Tanda Setoran";
		$data['ambildata']     = $this->keusts_model->get_data();
		$data['versi'] 		   = $this->keusts_model->get_versi_sts();
		$data['kode_rekening'] = $this->keusts_model->get_data_kode_rekening();
		$data['kode_rek']	   = $this->keusts_model->get_data_kode_rek();

		die($this->parser->parse("mst/keusts/daftar_tarif_sts",$data));
	}

	function api_data(){
		$this->authentication->verify('mst','edit');		
		
		$data['ambildata'] = $this->keusts_model->get_data_type_filter($this->session->userdata('versi'));
		foreach($data['ambildata'] as $d){
			$txt = $d["id_mst_anggaran"]." \t ".$d["id_mst_anggaran_parent"]." \t ".$d["kode_anggaran"]." \t ".$d["uraian"]." \t ".$d["tarif"]." \t ".$d["id_mst_anggaran_versi"]." \n";				
			echo $txt;
		}
		
	}

	function api_data_tarif(){
		$this->authentication->verify('mst','edit');		
		
		if(!empty($this->session->userdata('versi')) and  $this->session->userdata('versi') != '0'){
			$data['ambildata'] = $this->keusts_model->get_data_versi_filter($this->session->userdata('versi'));
			// $i=0;
			foreach($data['ambildata'] as $d){
				$txt = $d["id_mst_anggaran"]." \t ".$d["id_mst_anggaran_parent"]." \t ".$d["id_mst_akun"]." \t ".$d["kode_anggaran"]." \t ".$d["uraian"]." \t ".$d["tarif"]." \t".$d["id_mst_anggaran_versi"]." \n";				
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

	function set_versi(){
		$this->authentication->verify('mst','edit');
		$this->session->set_userdata('versi',$this->input->post('versi'));		
		
	}

	function anggaran_ubah(){
		$this->authentication->verify('mst','edit');
		// $data = $this->keusts_model->get_data_row($idversi);
	
		$data['ambildata'] = $this->keusts_model->get_data_row($this->session->userdata('versi'));

		$data['action']="edit";
		// $data['id_mst_anggaran_versi'] = $idversi;
		$data['alert_form'] = "";

		$data['title_group']   = "Tarif Surat Tanda Setoran";
		$data['title_form']    = "Ubah Daftar Tarif Surat Tanda Setoran";

		$data['ambildata']     = $this->keusts_model->get_data();
		// $data['versi'] 		   = $this->keusts_model->get_versi_sts();
		$data['kode_rekening'] = $this->keusts_model->get_data_kode_rekening();
		$data['kode_rek']	   = $this->keusts_model->get_data_kode_rek();
		$data['dataversi']	   = $this->keusts_model->get_versi_sts();

	 	die($this->parser->parse("mst/keusts/daftar_tarif_sts_form",$data));
	}

	

	function anggaran_tarif(){
		$this->authentication->verify('mst','edit');
		$data['title_group'] = "Keuangan";
		$data['title_form'] = "Master Data - Tarif STS";
		$data['ambildata'] = $this->keusts_model->get_data();
		$data['data_versi']	= $this->keusts_model->get_versi_sts();
		$data['content'] = $this->parser->parse("keuangan/anggaran_tarif",$data,true);					
		$this->template->show($data,"home");
	}
	
	function add_tarif(){
		$this->authentication->verify('mst','add');
		
		$this->form_validation->set_rules('id_mst_anggaran','ID Anggaran','trim|required');
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
		$this->form_validation->set_rules('id_mst_anggaran_parent','id_mst_anggaran_parent','trim|required');
		$this->form_validation->set_rules('kode_anggaran','Kode Anggaran','trim|required');
		$this->form_validation->set_rules('id_mst_akun','Kode Rekening','trim|required');
		if($this->form_validation->run()== TRUE){
			$this->keusts_model->add_anggaran();	
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



