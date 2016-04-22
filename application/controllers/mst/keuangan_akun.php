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
				$data['title_form']    = "Master Data Keuangan";
				$data['ambildata']     = $this->keuakun_model->get_data();

				die($this->parser->parse("mst/keuakun/akun",$data));

				break;
			case 2:
				
				die($this->parser->parse("mst/keuakun/anggaran_akun",$data));

				break;
			case 3:
				
				die($this->parser->parse("mst/keuakun/target_penerimaan",$data));

				break;
			default:

				die($this->parser->parse("mst/keuakun/akun_non_aktif",$data));
				break;
		}
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