<?php
class Keuangan_akun extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('mst/keuakun_model');

	}

	function index(){
		$this->authentication->verify('mst','edit');
		$data['title_group']   = "Keuangan";
		$data['title_form']    = "Master Data Keuangan";
		$data['ambildata'] 	   = $this->keuakun_model->get_data();
		$data['content']       = $this->parser->parse("mst/keuakun/show",$data,true);		
		
		$this->template->show($data,"home");
	}

	function keu_akun($pageIndex){
		$data = array();

		switch ($pageIndex) {
			case 1:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Daftar Akun";
				$data['ambildata']     = $this->keuakun_model->get_data();

				die($this->parser->parse("mst/keuakun/akun",$data));

				break;
			case 2:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Anggaran Akun";
				$data['ambildata']     = $this->keuakun_model->get_data();

				die($this->parser->parse("mst/keuakun/anggaran_akun",$data));

				break;
			case 3:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Target Penerimaan Akun";
				$data['ambildata']     = $this->keuakun_model->get_data();
				die($this->parser->parse("mst/keuakun/target_penerimaan",$data));

				break;
			default:

				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Daftar Akun Non Aktif ";
				$data['ambildata']     = $this->keuakun_model->get_data();

				die($this->parser->parse("mst/keuakun/akun_non_aktif",$data));
				break;
		}
	}

	function api_data(){
		$this->authentication->verify('mst','edit');		
		
		$data['ambildata'] = $this->keuakun_model->get_data_akun();
		foreach($data['ambildata'] as $d){
			$txt = $d["id_mst_akun"]." \t ".$d["id_mst_akun_parent"]."\t".$d["kode"]." \t ".$d["uraian"]." \t ".ucwords($d["saldo_normal"])." \t ".$d["saldo_awal"]." \t ".$d["mendukung_transaksi"]." \n";				
			echo $txt;
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

    	$this->form_validation->set_rules('uraian', 'Uraian', 'trim|required');
        $this->form_validation->set_rules('saldo_normal', ' Saldo Normal', 'trim|required');

	    $data['action']				= "add";
		$data['alert_form']		    = '';
		$data['akun']				= $this->keuakun_model->get_parent_akun();

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keuakun/form_tambah_induk",$data));
		}elseif($this->keuakun_model->insert_entry()){
			die("OK");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keuakun/form_tambah_induk",$data));
	}

	function mendukung_target_update($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('mendukung_target', 'Mendukung Target', 'trim');

	    $data['action']				= "edit";
		$data['alert_form']		    = '';
		$data['id']					= $id;

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keuakun/form_detail_akun",$data));
		}elseif($mendukung_target=$this->keuakun_model->mendukung_target_update($id)){
			die("OK|$mendukung_target");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keuakun/form_detail_akun",$data));
	}

	function mendukung_anggaran_update($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('mendukung_anggaran', 'Mendukung Anggaran', 'trim');

	    $data['action']				= "edit";
		$data['alert_form']		    = '';
		$data['id']					= $id;

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keuakun/form_detail_akun",$data));
		}elseif($mendukung_anggaran=$this->keuakun_model->mendukung_anggaran_update($id)){
			die("OK|$mendukung_anggaran");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keuakun/form_detail_akun",$data));
	}

	function mendukung_transaksi_update($id=0){
		$this->authentication->verify('mst','edit');

    	$this->form_validation->set_rules('mendukung_transaksi', 'Mendukung Transaksi', 'trim');

	    $data['action']				= "edit";
		$data['alert_form']		    = '';
		$data['id']					= $id;

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keuakun/form_detail_akun",$data));
		}elseif($mendukung_transaksi=$this->keuakun_model->mendukung_transaksi_update($id)){
			die("OK|$mendukung_transaksi");
		}else{
			$data['alert_form'] = 'Save data failed...';
		}
		die($this->parser->parse("mst/keuakun/form_detail_akun",$data));
	}

	function induk_detail($id=0){
			$data 						= $this->keuakun_model->get_data_akun_detail($id);
			$data['notice']				= validation_errors();
			$data['action']				= "edit";
			$data['id']					= $id;
			$data['alert_form'] 		= '';
			$data['disable']			= "disable";
			die($this->parser->parse("mst/keuakun/form_detail_akun",$data));
		
		$this->keuinstansi_model->update_entry_instansi($id);
		die($this->parser->parse("mst/keuakun/form_detail_akun",$data));
	}

	function akun_add(){
		$this->authentication->verify('mst','add');
		$this->form_validation->set_rules('id_mst_akun_parent','ID Akun Parent','trim|required');
		$this->form_validation->set_rules('kode','Kode','trim|required');
		$this->form_validation->set_rules('uraian','Uraian','trim|required');
		$this->form_validation->set_rules('saldo_awal','Saldo Awal','trim|required');
		$this->form_validation->set_rules('saldo_normal','Saldo Normal','trim|required');

		if($this->form_validation->run()== TRUE){
			$this->keuakun_model->akun_add();	
			echo "0";
		}else{			
			$err = validation_errors();
			echo str_replace("<p>", "", str_replace("</p>", "\n", $err));
		}	
	}

	function akun_delete(){
		$this->authentication->verify('mst','del');
		$this->keuakun_model->akun_delete();				
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

		$rows_all = $this->keuakun_model->get_data();

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

		$rows = $this->keuakun_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
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