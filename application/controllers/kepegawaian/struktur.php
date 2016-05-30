<?php
class Struktur extends CI_Controller {

	var $struktur	= 'struktur';
	var $parent;

    public function __construct(){
		parent::__construct();
		$this->load->model('kepegawaian/struktur_model');
		$this->load->model('morganisasi_model');
	}

	function index(){
		$this->authentication->verify('mst','edit');
		$data['title_group']   = "Kepegawaian";
		$data['title_form']    = "Struktur Organisasi";
		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] = $this->morganisasi_model->get_data_puskesmas();
		$data['content']       = $this->parser->parse("kepegawaian/struktur/show",$data,true);		
		
		$this->template->show($data,"home");
	}

	function keu_akun($pageIndex){
		$data = array();

		switch ($pageIndex) {
			case 1:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Daftar Akun";
				$data['ambildata']     = $this->struktur_model->get_data();

				die($this->parser->parse("kepegawaian/struktur/akun",$data));

				break;
			case 2:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Anggaran Akun";
				$data['ambildata']     = $this->struktur_model->get_data();

				die($this->parser->parse("kepegawaian/struktur/anggaran_akun",$data));

				break;
			case 3:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Target Penerimaan Akun";
				$data['ambildata']     = $this->struktur_model->get_data();
				die($this->parser->parse("kepegawaian/struktur/target_penerimaan",$data));

				break;
			default:

				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Daftar Akun Non Aktif ";
				$data['ambildata']     = $this->struktur_model->get_data();

				die($this->parser->parse("kepegawaian/struktur/akun_non_aktif",$data));
				break;
		}
	}

	function api_data(){
		$this->authentication->verify('mst','edit');		
		
		$kodepuskesmas = 'P'.$this->session->userdata('puskesmas');
		$data['ambildata'] = $this->struktur_model->get_data_akun($kodepuskesmas);
		foreach($data['ambildata'] as $d){
			$txt = $d["tar_id_struktur_org"]." \t ".$d["tar_id_struktur_org_parent"]."\t".$d["tar_nama_posisi"]." \t ".$d["nik"]." \t ".$d["nama"]." \t ".$d["tar_aktif"]." \t ".$d["code_cl_phc"]." \n";				
			echo $txt;
		}
	}

	function have_parent($id){
		$this->db->where("id_mst_akun",$id);		
		$dt=$this->db->get("struktur")->row();		

		if(!empty($dt->uraian))$this->parent.=" &raquo; ".$dt->uraian;
  		if(!empty($dt->id_mst_akun_parent) && $dt->id_mst_akun_parent !=0){
   			$this->have_parent($dt->id_mst_akun_parent);
		}						
	}

	function api_data_akun_non_aktif(){
		$this->authentication->verify('mst','edit');		
		
		$data['ambildata'] = $this->struktur_model->get_data_akun_non_aktif();
		foreach($data['ambildata'] as $d){
			$id = $d["id_mst_akun_parent"];
			$this->parent = "";
			$this->have_parent($id);
			$txt = $d["id_mst_akun"]." \t ".$d["id_mst_akun_parent"]."\t".$d["kode"]." \t ".$d["uraian"]." \t ".ucwords($d["saldo_normal"])." \t ".$this->parent." \n";				
			echo $txt;
		}
	}

	function aktifkan_akun($id){
		$data = array('aktif' => 1);
		$this->db->where('id_mst_akun',$id);
		$this->db->update('struktur',$data);

		$this->db->where('id_mst_akun_parent',$id);
		$q = $this->db->get('struktur');
   		if ($q->num_rows() > 0 ) {
			$child = $q->result_array();
   			foreach ($child as $dt) {
   				$this->aktifkan_akun($dt['id_mst_akun']);
   			}

   		}
	}

	function non_aktif_akun($id){
		$data = array('tar_aktif' => 0);
		$this->db->where('tar_id_struktur_org',$id);
		$this->db->update('mst_peg_struktur_org',$data);

		$this->db->where('tar_id_struktur_org_parent',$id);
		$q = $this->db->get('mst_peg_struktur_org');
   		if ($q->num_rows() > 0 ) {
			$child = $q->result_array();
   			foreach ($child as $dt) {
   				$this->non_aktif_akun($dt['tar_id_struktur_org']);
   			}

   		}
	}

	function set_puskes(){
		$this->authentication->verify('mst','edit');
		$this->session->set_userdata('puskes',$this->input->post('puskes'));		
	}

	function filter_tahun(){
		if($_POST) {
			if($this->input->post('tahun') != '') {
				$this->session->set_userdata('filter_tahun',$this->input->post('tahun'));
			}
		}
	}

	function induk_add(){
		$this->authentication->verify('mst','add');

    	$this->form_validation->set_rules('tar_nama_posisi', 'Nama Jabatan', 'trim|required');
        $this->form_validation->set_rules('tar_status', 'Status', 'trim|required');

	    $data['action']				= "add";
		$data['alert_form']		    = '';
		$data['akun']				= $this->struktur_model->get_parent_akun();

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("kepegawaian/struktur/form_tambah_induk",$data));
		}elseif($this->struktur_model->insert_entry()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("kepegawaian/struktur/form_tambah_induk",$data));
	}

	function mendukung_target_update($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('mendukung_target', 'Mendukung Target', 'trim');

	    $data['action']				= "edit";
		$data['alert_form']		    = '';
		$data['id']					= $id;

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("kepegawaian/struktur/form_detail_akun",$data));
		}elseif($mendukung_target=$this->struktur_model->mendukung_target_update($id)){
			die("OK|$mendukung_target");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("kepegawaian/struktur/form_detail_akun",$data));
	}

	function mendukung_anggaran_update($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('mendukung_anggaran', 'Mendukung Anggaran', 'trim');

	    $data['action']				= "edit";
		$data['alert_form']		    = '';
		$data['id']					= $id;

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("kepegawaian/struktur/form_detail_akun",$data));
		}elseif($mendukung_anggaran=$this->struktur_model->mendukung_anggaran_update($id)){
			die("OK|$mendukung_anggaran");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("kepegawaian/struktur/form_detail_akun",$data));
	}

	function mendukung_transaksi_update($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('mendukung_transaksi', 'Mendukung Transaksi', 'trim');

	    $data['action']				= "edit";
		$data['alert_form']		    = '';
		$data['id']					= $id;

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("kepegawaian/struktur/form_detail_akun",$data));
		}elseif($mendukung_transaksi=$this->struktur_model->mendukung_transaksi_update($id)){
			die("OK|$mendukung_transaksi");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("kepegawaian/struktur/form_detail_akun",$data));
	}

	function induk_detail($id=0){
			$data 						= $this->struktur_model->get_data_akun_detail($id);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['alert_form'] 		= '';
			$data['disable']			= "disable";
			die($this->parser->parse("kepegawaian/struktur/form_detail_akun",$data));
		
		$this->keuinstansi_model->update_entry_instansi($id);
		die($this->parser->parse("kepegawaian/struktur/form_detail_akun",$data));
	}

	function akun_non_aktif_detail($id=0){
			$data 						= $this->struktur_model->get_data_akun_non_aktif_detail($id);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['alert_form'] 		= '';
			$data['disable']			= "disable";
			die($this->parser->parse("kepegawaian/struktur/form_detail_akun_non_aktif",$data));
		
		$this->keuinstansi_model->update_entry_instansi($id);
		die($this->parser->parse("kepegawaian/struktur/form_detail_akun_non_aktif",$data));
	}

	function akun_add(){
		$this->authentication->verify('mst','add');
		$this->form_validation->set_rules('tar_id_struktur_org','ID Jabatan','trim|required');
		$this->form_validation->set_rules('tar_id_struktur_org_parent','ID Jabatan Parent','trim|required');
		$this->form_validation->set_rules('tar_aktif','Status','trim|required');
		$this->form_validation->set_rules('tar_nama_posisi','Nama Jabatan','trim|required');

		if($this->form_validation->run()== TRUE){
			$this->struktur_model->akun_add();	
			echo "0";
		}else{			
			$err = validation_errors();
			echo str_replace("<p>", "", str_replace("</p>", "\n", $err));
		}	
	}

	function akun_update(){
		$this->authentication->verify('mst','edit');
		$this->form_validation->set_rules('tar_id_struktur_org','ID Jabatan','trim|required');
		$this->form_validation->set_rules('tar_id_struktur_org_parent','ID Jabatan Parent','trim|required');
		$this->form_validation->set_rules('tar_nama_posisi','Nama Jabatan','trim|required');
		$this->form_validation->set_rules('tar_aktif','Status','trim|required');

		if($this->form_validation->run()== TRUE){
			$this->struktur_model->akun_update();	
			echo "0";
		}else{			
			$err = validation_errors();
			echo str_replace("<p>", "", str_replace("</p>", "\n", $err));
		}	
	}

	function akun_delete(){
		$this->authentication->verify('mst','del');
		$this->struktur_model->akun_delete();				
	}

	function json_akun(){
		$this->authentication->verify('mst','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows_all = $this->struktur_model->get_data();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows = $this->struktur_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_mst_akun'	  	 => $act->id_mst_akun,
				'kode'	   			 => $act->kode,
				'uraian'   			 => $act->uraian,
				'saldo_normal'   	 => ucwords($act->saldo_normal),
				'saldo_awal'     	 => $act->saldo_awal,
				'aktif' 			 => $act->aktif,
				'mendukung_anggaran' => $act->mendukung_anggaran,
				'edit'			 	 => 1,
				'delete'			 => 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
}
?>