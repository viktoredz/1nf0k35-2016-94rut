<?php
class Keuangan_transaksi extends CI_Controller {

 public function __construct(){
		parent::__construct();
		$this->load->model('mst/keutransaksi_model');
	}

	function index(){
		$this->authentication->verify('mst','edit');
		$data['title_group']   = "Keuangan";
		$data['title_form']    = "Master Data Keuangan";
		$data['ambildata'] 	   = $this->keutransaksi_model->get_data_kategori_transaksi();
		$data['content']       = $this->parser->parse("mst/keutransaksi/show",$data,true);		
		
		$this->template->show($data,"home");
	}

	function tab($pageIndex){
		$data = array();

		switch ($pageIndex) {
			case 1:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Kategori Transaksi";

				die($this->parser->parse("mst/keutransaksi/kategori_transaksi",$data));

				break;
			case 2:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Daftar Transaksi";
				$data['kategori']	   = $this->keutransaksi_model->get_data_kategori_transaksi();
				$this->session->set_userdata('filter_kategori','');
				
				die($this->parser->parse("mst/keutransaksi/transaksi",$data));

				break;
			case 3:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Daftar Transaksi Otomatis";
				
				die($this->parser->parse("mst/keutransaksi/transaksi_otomatis",$data));

				break;
			default:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Pengaturan Transaksi";
				
				die($this->parser->parse("mst/keutransaksi/show_pengaturan_transaksi",$data));
				break;
		}
	}

	function tab_pengaturan_transaksi($pageIndex){
		$data = array();

		switch ($pageIndex) {
			case 1:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Data Cetak";
				$data['datapuskesmas'] = $this->keutransaksi_model->get_data_puskesmas();
				
				die($this->parser->parse("mst/keutransaksi/data_cetak",$data));
				break;

			default:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Data Syarat Pembayaran";
				$data['kategori']	   = $this->keutransaksi_model->get_data_kategori_transaksi();
				
				die($this->parser->parse("mst/keutransaksi/syarat_pembayaran",$data));
				break;
		}
	}

	function json_kategori_transaksi(){
		$this->authentication->verify('mst','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lhr') {
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

		$rows_all = $this->keutransaksi_model->get_data_kategori_transaksi();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lhr') {
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

		$rows = $this->keutransaksi_model->get_data_kategori_transaksi($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_mst_kategori_transaksi'	=> $act->id_mst_kategori_transaksi,
				'nama'					    => $act->nama,
				'deskripsi'					=> $act->deskripsi,
				'edit'						=> 1,
				'delete'					=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function json_transaksi(){
		$this->authentication->verify('mst','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'nama') {
					$this->db->like('mst_keu_transaksi.'.$field,$value);
				}
				elseif($field == 'kategori') {
					$this->db->like('mst_keu_kategori_transaksi.nama',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows_all = $this->keutransaksi_model->get_data_transaksi();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'nama') {
					$this->db->like('mst_keu_transaksi.'.$field,$value);
				}
				elseif($field == 'kategori') {
					$this->db->like('mst_keu_kategori_transaksi.nama',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows = $this->keutransaksi_model->get_data_transaksi($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_mst_transaksi'			=> $act->id_mst_transaksi,
				'untuk_jurnal'				=> ucwords(str_replace("_"," ","$act->untuk_jurnal")),
				'nama'					    => $act->nama,
				'kategori'					=> $act->kategori,
				'id_mst_kategori_transaksi'	=> $act->id_mst_kategori_transaksi,
				'edit'						=> 1,
				'delete'					=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function json_transaksi_otomatis(){
		$this->authentication->verify('mst','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'nama') {
					$this->db->like('mst_keu_otomasi_transaksi.'.$field,$value);
				}
				elseif($field == 'kategori') {
					$this->db->like('mst_keu_otomasi_transaksi.nama',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows_all = $this->keutransaksi_model->get_data_transaksi_otomatis();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'nama') {
					$this->db->like('mst_keu_otomasi_transaksi.'.$field,$value);
				}
				elseif($field == 'kategori') {
					$this->db->like('mst_keu_kategori_transaksi.nama',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows = $this->keutransaksi_model->get_data_transaksi_otomatis($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_mst_otomasi_transaksi'	=> $act->id_mst_otomasi_transaksi,
				'untuk_jurnal'				=> ucwords(str_replace("_"," ","$act->untuk_jurnal")),
				'nama'					    => $act->nama,
				'kategori'					=> $act->kategori,
				'id_mst_kategori_transaksi'	=> $act->id_mst_kategori_transaksi,
				'edit'						=> 1,
				'delete'					=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function json_syarat_pembayaran(){
		$this->authentication->verify('mst','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lhr') {
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

		$rows_all = $this->keutransaksi_model->get_data_syarat_pembayaran();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lhr') {
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

		if($this->session->userdata('filter_kategori')!=''){
			if($this->session->userdata('filter_kategori')=="all"){

			}else{
				$this->db->where("id_mst_kategori_transaksi",$this->session->userdata('filter_kategori'));
			}
		}

		$rows = $this->keutransaksi_model->get_data_syarat_pembayaran($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_mst_syarat_pembayaran'	=> $act->id_mst_syarat_pembayaran,
				'nama'					    => $act->nama,
				'deskripsi'					=> $act->deskripsi,
				'aktif'						=> $act->aktif,
				'edit'						=> 1,
				'delete'					=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function filter_kategori(){
		if($_POST) {
			if($this->input->post('kategori') != '') {
				$this->session->set_userdata('filter_kategori',$this->input->post('kategori'));
			}
		}
	}

	function delete_kategori_transaksi($id=0){
		$this->authentication->verify('mst','del');

		if($this->keutransaksi_model->delete_kategori_transaksi($id)){
			$this->session->set_flashdata('alert', 'Delete data ('.$id.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	function kategori_transaksi_edit($id=0){
    	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');

		if($this->form_validation->run()== FALSE){

			$data 						= $this->keutransaksi_model->get_data_kategori_transaksi_edit($id);
			$data['template']			= $this->keutransaksi_model->get_data_template_kat_trans($id);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['alert_form'] 		= '';
			die($this->parser->parse("mst/keutransaksi/form_kategori_transaksi_edit",$data));
		
		}elseif($this->keutransaksi_model->update_kategori_transaksi($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_kategori_transaksi_edit",$data));
	}

	function kategori_transaksi_add(){
		$this->authentication->verify('mst','add');

    	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');

		$data['id_mst_kategori_transaksi']	= "";
	    $data['action']						= "add";
		$data['alert_form']		    		= '';

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keutransaksi/form_kategori_transaksi_add",$data));
		}elseif($this->keutransaksi_model->insert_kategori_transaksi()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_kategori_transaksi_add",$data));
	}

	function kategori_trans_template_update($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('template', 'Template', 'trim');
    	$this->form_validation->set_rules('kategori', 'Kategori', 'trim');

	    $data['action']				= "edit";
		$data['alert_form']		    = '';
		$data['id']					= $id;
		$data['template']			= $this->keutransaksi_model->get_data_template_kat_trans($id);


		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keutransaksi/form_kategori_transaksi_edit",$data));
		}elseif($this->keutransaksi_model->kategori_trans_template_update($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_kategori_transaksi_edit",$data));
	}

	function transaksi_template_update($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('template', 'Template', 'trim');
    	$this->form_validation->set_rules('kategori', 'Kategori', 'trim');

	    $data['action']				= "edit";
		$data['alert_form']		    = '';
		$data['id']					= $id;
		$data['template']			= $this->keutransaksi_model->get_data_template_trans($id);


		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
		}elseif($this->keutransaksi_model->transaksi_template_update($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
	}

	function transaksi_otomatis_template_update($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('template', 'Template', 'trim');
    	$this->form_validation->set_rules('kategori', 'Kategori', 'trim');

	    $data['action']				= "edit";
		$data['alert_form']		    = '';
		$data['id']					= $id;
		$data['template']			= $this->keutransaksi_model->get_data_template_trans_otomatis($id);


		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keutransaksi/form_transaksi_otomatis_edit",$data));
		}elseif($this->keutransaksi_model->transaksi_otomatis_template_update($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_transaksi_otomatis_edit",$data));
	}

	function jurnal_transaksi_pasangan_add($id=0){
		$this->authentication->verify('mst','add');
    	
    	$this->form_validation->set_rules('value','Value','trim');
    	$this->form_validation->set_rules('type','Tipe','trim');
    	$this->form_validation->set_rules('group','Group','trim');

		$data['id_mst_kategori_transaksi']	= "";
		$data['id']							= $id;
		$data['akun']						= $this->keutransaksi_model->get_data_akun();
	    $data['action']						= "add";
		$data['template']					= $this->keutransaksi_model->get_data_template_trans($id);
		$data['kategori']					= $this->keutransaksi_model->get_data_kategori_transaksi();
		$data['alert_form']		    		= '';

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
		}elseif($id=$this->keutransaksi_model->jurnal_transaksi_pasangan_add($id)){
			die("OK|$id");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
	}

    function jurnal_transaksi_add_debit($id=0){
		$this->authentication->verify('mst','add');
    	
    	$this->form_validation->set_rules('value','Value','trim');
    	$this->form_validation->set_rules('group','Group','trim');
    	$this->form_validation->set_rules('urutan','Urutan','trim');
    	$this->form_validation->set_rules('id_mst_akun','Akun','trim');

		$data['id_mst_kategori_transaksi']	= "";
		$data['id']							= $id;
		$data['akun']						= $this->keutransaksi_model->get_data_akun();
	    $data['action']						= "add";
		$data['template']					= $this->keutransaksi_model->get_data_template_trans($id);
		$data['kategori']					= $this->keutransaksi_model->get_data_kategori_transaksi();
		$data['alert_form']		    		= '';

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
		}elseif($id_mst_transaksi_item = $this->keutransaksi_model->jurnal_transaksi_add_debit($id)){
			die("OK|$id_mst_transaksi_item");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
	}

	function jurnal_transaksi_delete(){
		$this->authentication->verify('mst','del');
    	
    	$this->form_validation->set_rules('group','Group','trim');

		if($this->keutransaksi_model->jurnal_transaksi_delete()){
			die("OK");
		}else{
			alert("Delete data error");
		}
	}

	function jurnal_transaksi_delete_debit(){
		$this->authentication->verify('mst','del');

    	$this->form_validation->set_rules('id_mst_transaksi_item','ID','trim');

		if($this->keutransaksi_model->jurnal_transaksi_delete_debit()){
			die("OK");
		}else{
			alert("Delete data error");
		}
	}

	function jurnal_transaksi_delete_kredit(){
		$this->authentication->verify('mst','del');

    	$this->form_validation->set_rules('id_mst_transaksi_item','ID','trim');

		if($this->keutransaksi_model->jurnal_transaksi_delete_kredit()){
			die("OK");
		}else{
			alert("Delete data error");
		}
	}

	function jurnal_transaksi_edit_debit($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('id_mst_transaksi_item_from','Transaksi Item From','trim');
    	$this->form_validation->set_rules('group','Group','trim');
    	$this->form_validation->set_rules('id_mst_transaksi_item','Transaksi Item','trim');
    	$this->form_validation->set_rules('id_mst_transaksi','Transaksi','trim');
        $this->form_validation->set_rules('auto_fill','Isi Otomatis','trim');
        $this->form_validation->set_rules('opsional','Opsional','trim');
        $this->form_validation->set_rules('id_mst_akun','Akun','trim');
        $this->form_validation->set_rules('value','Value','trim');

		if($this->form_validation->run()== FALSE){

			$data['id']					= $id;
	   		$data['action']		        = "edit";
			$data['template']			= $this->keutransaksi_model->get_data_template_trans($id);
			$data['kategori']			= $this->keutransaksi_model->get_data_kategori_transaksi();
			$data['akun']				= $this->keutransaksi_model->get_data_akun();
			$data['kredit']			    = $this->keutransaksi_model->get_data_kredit($id);
			$data['debit']				= $this->keutransaksi_model->get_data_debit($id);
			$data['urutan']				= $this->keutransaksi_model->get_data_urutan_debit($id);

			die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data,true));
		}elseif($this->keutransaksi_model->jurnal_transaksi_update_debit($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
	}

	function jurnal_transaksi_add_kredit($id=0){
		$this->authentication->verify('mst','add');
    	
    	$this->form_validation->set_rules('id_mst_transaksi_item_from',' ID Mst Transaksi Item From','trim');
    	$this->form_validation->set_rules('value','Value','trim');
    	$this->form_validation->set_rules('group','Group','trim');
    	$this->form_validation->set_rules('urutan','Urutan','trim');
    	$this->form_validation->set_rules('id_mst_akun','Akun','trim');

		$data['id_mst_kategori_transaksi']	= "";
		$data['id']							= $id;
		$data['akun']						= $this->keutransaksi_model->get_data_akun();
	    $data['action']						= "add";
		$data['template']					= $this->keutransaksi_model->get_data_template_trans($id);
		$data['kategori']					= $this->keutransaksi_model->get_data_kategori_transaksi();
		$data['alert_form']		    		= '';
		$data['kredit']						= $this->keutransaksi_model->get_data_kredit($id);

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
		}elseif($id_mst_transaksi_item = $this->keutransaksi_model->jurnal_transaksi_add_kredit($id)){
			die("OK|$id_mst_transaksi_item");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
	}

	function jurnal_transaksi_edit_kredit($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('id_mst_transaksi_item_from','Transaksi Item From','trim');
    	$this->form_validation->set_rules('id_mst_transaksi_item','Transaksi Item','trim');
    	$this->form_validation->set_rules('id_mst_transaksi','Transaksi','trim');
        $this->form_validation->set_rules('auto_fill','Isi Otomatis','trim');
        $this->form_validation->set_rules('opsional','Opsional','trim');
        $this->form_validation->set_rules('id_mst_akun','Akun','trim');
        $this->form_validation->set_rules('value','Value','trim');

		if($this->form_validation->run()== FALSE){

			$data['id']					= $id;
	   		$data['action']		        = "edit";
			$data['template']			= $this->keutransaksi_model->get_data_template_trans($id);
			$data['kategori']			= $this->keutransaksi_model->get_data_kategori_transaksi();
			$data['akun']				= $this->keutransaksi_model->get_data_akun();
			$data['kredit']			    = $this->keutransaksi_model->get_data_kredit($id);
			$data['debit']				= $this->keutransaksi_model->get_data_debit($id);

			die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data,true));
		}elseif($this->keutransaksi_model->jurnal_transaksi_update_kredit($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data));
	}

	function set_debit_akun(){
		$this->authentication->verify('mst','edit');
		$this->session->set_userdata('debit_akun',$this->input->post('debit_akun'));		
	}

	function transaksi_add(){
		$this->authentication->verify('mst','add');

    	$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('untuk_jurnal', 'Jurnal', 'required|trim');
        $this->form_validation->set_rules('id_mst_kategori_transaksi', 'Kategori', 'required|trim');

		if($this->form_validation->run()== FALSE){
			$data['title_group'] 		= "Keuangan";
			$data['title_form']			= "Transaksi Baru / Ubah Transaksi";
			$data['action']				= "add";
			$data['kategori']			= $this->keutransaksi_model->get_data_kategori_transaksi();
			$data['id_mst_transaksi']	= "";
			$data['alert_form']		    = '';
			
			$data['content'] = $this->parser->parse("mst/keutransaksi/form_transaksi_add",$data,true);
		}elseif($id = $this->keutransaksi_model->transaksi_insert()){
			$this->session->set_flashdata('alert', 'Save data successful...');
			redirect(base_url()."mst/keuangan_transaksi/transaksi_edit/".$id);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."mst/keuangan_transaksi/transaksi_add");
		}

		$this->template->show($data,"home");
	}

	function delete_transaksi($id=0){
		$this->authentication->verify('mst','del');

		if($this->keutransaksi_model->delete_transaksi($id)){
			$this->session->set_flashdata('alert', 'Delete data ('.$id.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	function transaksi_edit($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('id_mst_kategori_transaksi', 'Kategori', 'trim');

		if($this->form_validation->run()== FALSE){

			$data 						= $this->keutransaksi_model->get_data_transaksi_edit($id);
			$data['id']					= $id;
			$data['akun']				= $this->keutransaksi_model->get_data_akun();
			$data['debit']				= $this->keutransaksi_model->get_data_debit($id);
			$data['group']   			= $this->keutransaksi_model->get_data_group($id);
			$data['kredit']				= $this->keutransaksi_model->get_data_kredit($id);
			$data['action']				= "edit";
			$data['template']			= $this->keutransaksi_model->get_data_template_trans($id);
			$data['kategori']			= $this->keutransaksi_model->get_data_kategori_transaksi();
			$data['title_form']			= "Transaksi Baru / Ubah Transaksi";
			$data['title_group'] 		= "Keuangan";
			$data['nilai_debit']		= $this->keutransaksi_model->get_data_nilai_debit($id);
			$data['urutan_debit']   	= $this->keutransaksi_model->get_data_urutan_debit($id);
			$data['urutan_kredit']   	= $this->keutransaksi_model->get_data_urutan_kredit($id);
			$data['jurnal_transaksi']	= $this->keutransaksi_model->get_data_jurnal_transaksi($id);

			$data['content'] = $this->parser->parse("mst/keutransaksi/form_transaksi_edit",$data,true);
		}elseif($this->keutransaksi_model->transaksi_update($id)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."mst/keuangan_transaksi/transaksi_edit/".$id);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."mst/keuangan_transaksi/transaksi_edit/".$id);
		}

		$this->template->show($data,"home");
	}

	function transaksi_kembali(){

		$data['title_group']   = "Keuangan";
		$data['title_form']    = "Daftar Transaksi";
		
		die($this->parser->parse("mst/keutransaksi/transaksi",$data));
	}

	function transaksi_otomatis_add(){
		$this->authentication->verify('mst','add');

    	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('untuk_jurnal', 'Jurnal', 'trim');
        $this->form_validation->set_rules('id_mst_kategori_transaksi', 'Kategori', 'trim');

		if($this->form_validation->run()== FALSE){
			$data['title_group'] 				= "Keuangan";
			$data['title_form']					= "Transaksi Baru / Ubah Transaksi Otomatis";
			$data['action']						= "add";
			$data['kategori']					= $this->keutransaksi_model->get_data_kategori_transaksi();
			$data['id_mst_otomasi_transaksi']	= "";
			
			die($this->parser->parse("mst/keutransaksi/form_transaksi_otomatis_add",$data,true));
		}elseif($this->keutransaksi_model->transaksi_otomatis_insert()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_transaksi_otomatis_add",$data));

	}

	function delete_transaksi_otomatis($id=0){
		$this->authentication->verify('mst','del');

		if($this->keutransaksi_model->delete_transaksi_otomatis($id)){
			$this->session->set_flashdata('alert', 'Delete data ('.$id.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	function transaksi_otomatis_edit($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('id_mst_kategori_transaksi', 'Kategori', 'trim');

		if($this->form_validation->run()== FALSE){

			$data 						= $this->keutransaksi_model->get_data_transaksi_otomatis_edit($id);
			$data['id']					= $id;
			$data['title_group'] 		= "Keuangan";
			$data['title_form']			= "Transaksi Baru / Ubah Transaksi Otomatis";
			$data['action']				= "edit";
			$data['template']			= $this->keutransaksi_model->get_data_template_trans_otomatis($id);
			$data['kategori']			= $this->keutransaksi_model->get_data_kategori_transaksi();
			
			die($this->parser->parse("mst/keutransaksi/form_transaksi_otomatis_edit",$data,true));
		}elseif($this->keutransaksi_model->transaksi_otomatis_update($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_transaksi_otomatis_edit",$data));
	}

	function transaksi_otomatis_kembali(){

		$data['title_group']   = "Keuangan";
		$data['title_form']    = "Daftar Transaksi Otomatis";
		
		die($this->parser->parse("mst/keutransaksi/transaksi_otomatis",$data));
	}

	function delete_syarat_pembayaran($id=0){
		$this->authentication->verify('mst','del');

		if($this->keutransaksi_model->delete_syarat_pembayaran($id)){
			$this->session->set_flashdata('alert', 'Delete data ('.$id.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	function syarat_pembayaran_edit($id=0){

    	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('aktif', 'Aktif', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');

		if($this->form_validation->run()== FALSE){

			$data 						= $this->keutransaksi_model->get_data_syarat_pembayaran_edit($id);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['alert_form'] 		= '';
			die($this->parser->parse("mst/keutransaksi/form_syarat_pembayaran",$data));
		
		}elseif($this->keutransaksi_model->update_syarat_pembayaran($id)){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_syarat_pembayaran",$data));
	}

	function syarat_pembayaran_add(){
		$this->authentication->verify('mst','add');
    	
    	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi','trim|required');
        $this->form_validation->set_rules('aktif', 'Aktif', 'trim');

		$data['id_mst_syarat_pembayaran']	= "";
	    $data['action']						= "add";
		$data['alert_form']		    		= '';

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keutransaksi/form_syarat_pembayaran",$data));
		}elseif($this->keutransaksi_model->insert_syarat_pembayaran()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keutransaksi/form_syarat_pembayaran",$data));
	}

	function getphoto($id){
        $path = 'media/images/photos/'.$id; 
		if (is_dir($path)){
		  if ($dh = opendir($path)){
		    while (($file = readdir($dh)) !== false){
		    	if($file !="." && $file !=".."){
			      readfile($path.'/'.$file);
			      die();
		    	}
		    }
		    closedir($dh);
		  }
		}
      	
      	readfile('media/images/profile.jpeg');
	}

	function douploadphoto($id,$resize_width=0){
		$this->authentication->verify('mst','add');
        
        $path = 'media/images/photos/'.$id; 
        if(!file_exists($path)){
        	mkdir($path);
        }

       	$config['upload_path'] = $path;

		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '1000';

		$config['max_width']  = '10000';
		$config['max_height']  = '8000';

		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload('uploadfile')){
			echo $this->upload->display_errors();
		}	
		else
		{
			$data = $this->upload->data();

			if($resize_width>0){
				$resize['image_library'] = 'gd2';
				$resize['source_image'] = $data['full_path'];
				$resize['width'] = $resize_width;
			}else{
			    $resize['image_library'] = 'gd2';
				$resize['source_image'] = $data['full_path'];
			}

			$this->load->library('image_lib', $resize);

			$this->image_lib->resize();		

			if (is_dir($path)){
			  if ($dh = opendir($path)){
			    while (($file = readdir($dh)) !== false){
			    	if($data['file_name'] != $file && $file !="." && $file !=".."){
				      unlink($path.'/'.$file);
			    	}
			    }
			    closedir($dh);
			  }
			}

			echo "success | ".$data['file_name'];
		}
	}


}

