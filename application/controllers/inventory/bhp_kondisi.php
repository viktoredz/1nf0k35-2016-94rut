<?php
class Bhp_kondisi extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('inventory/bhp_kondisi_model');
		$this->load->model('mst/puskesmas_model');
	}

	function json(){
		$this->authentication->verify('inventory','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_update' ) {
					$value = date("Y-m-d",strtotime($value));

					$this->db->where($field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		if ($this->session->userdata('puskesmas')!='' or empty($this->session->userdata('puskesmas'))) {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		if($this->session->userdata('filter_jenisbarang')!=''){
			if($this->session->userdata('filter_jenisbarang')=="all"){

			}else{
				$this->db->where("id_mst_inv_barang_habispakai_jenis",$this->session->userdata('filter_jenisbarang'));
			}
		}
		$rows_all = $this->bhp_kondisi_model->getitem();


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_update' ) {
					$value = date("Y-m-d",strtotime($value));

					$this->db->where($field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		if ($this->session->userdata('puskesmas')!='' or empty($this->session->userdata('puskesmas'))) {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		if($this->session->userdata('filter_jenisbarang')!=''){
			if($this->session->userdata('filter_jenisbarang')=="all"){

			}else{
				$this->db->where("id_mst_inv_barang_habispakai_jenis",$this->session->userdata('filter_jenisbarang'));
			}
		}
		$activity = $this->bhp_kondisi_model->getitem($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(substr($kodepuskesmas, -2)=="01"){
			$unlock = 1;
		}else{
			$unlock = 0;
		}
		
		foreach($activity as $act) {
			$data[] = array(
				'id_inv_inventaris_habispakai_distribusi'   => $act->id_inv_inventaris_habispakai_distribusi,
				'code_cl_phc'   						=> $act->code_cl_phc,
				'jenis_bhp'								=> $act->jenis_bhp,
				'tgl_distribusi'						=> $act->tgl_distribusi,
				'id_mst_inv_barang_habispakai'			=> $act->id_mst_inv_barang_habispakai,
				'uraian'								=> $act->uraian,
				'id_mst_inv_barang_habispakai_jenis'	=> $act->id_mst_inv_barang_habispakai_jenis,
				'jml_distribusi'						=> $act->jml_distribusi,
				'batch'									=> $act->batch,
				'jml_opname'							=> $act->jml_opname,
				'tgl_opname'							=> $act->tgl_opname,
				'jmlawal'								=> $act->jmlawal,
				'edit'		=> 1,
				'delete'	=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	
	function pengadaan_export(){
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$this->authentication->verify('inventory','show');

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
		if($this->session->userdata('filter_jenisbarang')!=''){
			if($this->session->userdata('filter_jenisbarang')=="all"){

			}else{
				$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$this->session->userdata('filter_jenisbarang'));
			}
		}
		
		
		$rows_all = $this->bhp_kondisi_model->get_data_export();


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

		if($this->session->userdata('filter_jenisbarang')!=''){
			if($this->session->userdata('filter_jenisbarang')=="all"){
				
			}else{
				$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$this->session->userdata('filter_jenisbarang'));
			}
		}
		$rows = $this->bhp_kondisi_model->get_data_export();
		$data_tabel = array();
		$no=1;
		
		foreach($rows as $act) {
			if((isset($act->tgl_pembelian))||(isset($act->tgl_opname))){
	          if ($act->tgl_pembelian >= $act->tgl_opname) {
	            $harga = $act->harga_pembelian;
	          }else{
	            $harga =$act->harga_opname;
	          }
	        }else{
	          $harga = $act->harga;
	        }
			$data_tabel[] = array(
				'no'					=> $no++,
				'code'					=> $act->code,
				'uraian'				=> $act->uraian,
				'merek_tipe'			=> $act->merek_tipe,
				'nama_jenis'			=> $act->nama_jenis,
				'negara_asal'			=> $act->negara_asal,
				'jmlbaik'				=> ($act->jmlbaik+$act->totaljumlah)-($act->jml_rusak+$act->jml_tdkdipakai+$act->jmlpengeluaran),
				'jml_rusak'				=> $act->jml_rusak,
				'jml_tdkdipakai'			=> $act->jml_tdkdipakai,
				'pilihan_satuan'		=> $act->pilihan_satuan,
				'value'					=> $act->value,
				'totaljumlah'					=> $act->totaljumlah,
				'jmlpengeluaran'					=> $act->jmlpengeluaran,
				'tgl_update'			=> $act->tgl_update,
				'harga'					=> number_format($harga,2),
				'id_mst_inv_barang_habispakai'			=> $act->id_mst_inv_barang_habispakai,
				'id_mst_inv_barang_habispakai_jenis'	=> $act->id_mst_inv_barang_habispakai_jenis
			);
		}
		
		$puskes = $this->input->post('puskes'); 
		$tahun = date("Y");
		$data_puskesmas[] = array('nama_puskesmas' => $puskes,'tahun' => $tahun);
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/inventory/permohonan_pengadaan_barang.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		// Merge data in the first sheet
		$TBS->MergeBlock('a', $data_tabel);
		$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = uniqid();
		$output_file_name = 'public/files/hasil/hasil_export_permohonan_pengadaan_barang'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;
	}

	function filter_jenisbarang(){
		if($_POST) {
			if($this->input->post('jenisbarang') != '') {
				$this->session->set_userdata('filter_jenisbarang',$this->input->post('jenisbarang'));
			}
		}
	}
	function index(){
		$this->authentication->verify('inventory','edit');
		$data['title_group'] = "Barang Habis Pakai";
		$data['title_form'] = "Kondisi Barang";

		$kodepuskesmas = $this->session->userdata('puskesmas');
		$this->db->where('code','P'.$kodepuskesmas);

		$data['datapuskesmas'] 	= $this->bhp_kondisi_model->get_data_puskesmas();
		$data['jenisbaranghabis'] = $this->bhp_kondisi_model->get_data_jenis();
		$data['content'] = $this->parser->parse("inventory/bhp_kondisi/show",$data,true);
		$this->template->show($data,"home");
	}

	public function add_barang($kode=0)
	{	
		$data['action']			= "add";
		$data['kode']			= $kode;
        $this->form_validation->set_rules('jml', 'Jumlah Barang', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');

		if($this->form_validation->run()== FALSE){

			$data = $this->bhp_kondisi_model->get_data_detail_edit_barang($kode); 
			$data['action']			= "add";
			$data['kode']			= $kode;
			$data['notice']			= validation_errors();

			die($this->parser->parse('inventory/bhp_kondisi/barang_form', $data));
		}else{
			if($simpan=$this->bhp_kondisi_model->insertdata()){
				$id=$this->input->post('id_mst_inv_barang_habispakai');
				die("OK|$id|Tersimpan");
			}else{
				$id=$this->input->post('id_mst_inv_barang_habispakai');
				 die("Error|$id|Proses data gagal");
			}
			
		}
	}
	public function kondisi_barang($kode=0)
	{	
		$data['action']			= "kondisi";
		$data['kode']			= $kode;
        $this->form_validation->set_rules('jml', 'Jumlah Baik', 'trim|required');
        $this->form_validation->set_rules('jml_rusak', 'Jumlah Rusak', 'trim');
        $this->form_validation->set_rules('jml_tdkdipakai', 'Tidak dipakai', 'trim');

		if($this->form_validation->run()== FALSE){

			$data = $this->bhp_kondisi_model->get_data_detail_edit_barang($kode); 
			$data['action']			= "kondisi";
			$data['kode']			= $kode;
			$data['notice']			= validation_errors();

			die($this->parser->parse('inventory/bhp_kondisi/form', $data));
		}else{
			if($simpan=$this->bhp_kondisi_model->insertdatakondisi()){
				$id=$this->input->post('id_mst_inv_barang_habispakai');
				die("OK|$id|Tersimpan");
			}else{
				$id=$this->input->post('id_mst_inv_barang_habispakai');
				 die("Error|$id|Proses data gagal");
			}
			
		}
	}
	
	public function timeline_comment($id_barang = 0){
  		$data = array();
       	$data['data_barang'] 	= $this->bhp_kondisi_model->get_barang($id_barang);
  		echo $this->parser->parse("inventory/bhp_kondisi/barang",$data);


  		die();
  	}
  	public function timeline_kondisi_barang($id_barang = 0){
  		$data = array();
       	$data['data_kondisi'] 	= $this->bhp_kondisi_model->get_kondisi_barang($id_barang);
  		echo $this->parser->parse("inventory/bhp_kondisi/kondisi",$data);


  		die();
  	}
	function dodel_barang($kode=0,$id_barang="",$table=0){
		$this->authentication->verify('inventory','del');

		if($this->bhp_kondisi_model->delete_entryitem_table($kode,$id_barang,$table)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	

}
