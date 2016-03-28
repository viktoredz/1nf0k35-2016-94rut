<?php
class Bhp_opname extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('inventory/bhp_opname_model');
		$this->load->model('inventory/inv_barang_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
		$this->load->model('inventory/bhp_opname_model');
		$this->load->model('mst/invbarang_model');
	}

	function pengeluaran_export(){
		$this->authentication->verify('inventory','show');
		
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		


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
		}else{
			//$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$kode);
		}
		
		
		$rows_all = $this->bhp_opname_model->get_data_export();


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
		}else{
			//$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$kode);
		}
		//$rows = $this->bhp_opname_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$rows = $this->bhp_opname_model->get_data_export();
		$data_tabel = array();
		$no=1;
		//$unlock = 1;
		foreach($rows as $act) {
			$data_tabel[] = array(
				'no'					=> $no++,
				//'code'					=> $act->code,
				'uraian'				=> $act->uraian,
				'merek_tipe'			=> $act->merek_tipe,
				//'negara_asal'			=> $act->negara_asal,
				'jmlawal'				=> ($act->totaljumlah+$act->jmlbaik),//-($act->jml_rusak+$act->jml_tdkdipakai),
				'jml_akhir'				=> ($act->totaljumlah+$act->jmlbaik)-(/*$act->jml_rusak+$act->jml_tdkdipakai+*/$act->jmlpengeluaran),
				'jml_selisih'			=> $act->jmlpengeluaran,
				//'pilihan_satuan'		=> $act->pilihan_satuan,
				'value'					=> $act->value,
				'tgl_update'			=> $act->tgl_update,
				'nama_jenis'			=> $act->nama_jenis,
				//'harga'					=> number_format($act->harga,2),
				'id_mst_inv_barang_habispakai'			=> $act->id_mst_inv_barang_habispakai,
				'id_mst_inv_barang_habispakai_jenis'	=> $act->id_mst_inv_barang_habispakai_jenis
			);
		}

		$jenisbarang = $this->input->post('jenisbarang');
		if(empty($jenisbarang) or $jenisbarang == 'All'){
			$nama_jenis = 'Semua Jenis Barang';
		}else{
			$nama_jenis = $this->input->post('puskes');
		}

		$kode_sess=$this->session->userdata('puskesmas');
		$kd_prov = $this->inv_barang_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$kd_kab  = $this->inv_barang_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		$nama_puskesmas = $this->input->post('nama_puskesmas');
		$tahun_ = date("Y");
		$data_puskesmas[] = array('nama_jenis' => $nama_jenis,'kd_prov' => $kd_prov,'kd_kab' => $kd_kab,'nama_puskesmas' => $nama_puskesmas,'tahun'=>$tahun_);
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/inventory/pengeluaran_habispakai.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		// Merge data in the first sheet
		$TBS->MergeBlock('a', $data_tabel);
		$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = date('Y-m-d-H-i-s');
		$output_file_name = 'public/files/hasil/hasil_pengeluaranhabispakai_'.$code.'.xlsx';
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
	function json(){
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
		}else{
			//$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$kode);
		}
		
		
		$rows_all = $this->bhp_opname_model->get_data();


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
		}else{
			//$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$kode);
		}
		$rows = $this->bhp_opname_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no=1;
		//$unlock = 1;
		foreach($rows as $act) {
			$data[] = array(
				'no'					=> $no++,
				'id_inv_inventaris_habispakai_opname'	=> $act->id_inv_inventaris_habispakai_opname,
				'code_cl_phc'			=> $act->code_cl_phc,
				'tgl_opname'			=> $act->tgl_opname,
				'jenis_bhp'				=> $act->jenis_bhp,
				'petugas_nip'			=> $act->petugas_nip,
				'petugas_nama'			=> $act->petugas_nama,
				'catatan'				=> $act->catatan,
				'nomor_opname'			=> $act->nomor_opname,
				'edit'					=> 1,
				'delete'				=> 1,
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function add_opname($value='')
	{
		$this->authentication->verify('inventory','add');

		$this->form_validation->set_rules('kode_distribusi_', 'Kode Opname', 'trim|required');
        $this->form_validation->set_rules('tgl_opname', 'Tanggal Opname', 'trim|required');
        $this->form_validation->set_rules('penerima_nama', 'Nama Penerima', 'trim|required');
        $this->form_validation->set_rules('penerima_nip', 'NIP Penerima', 'trim|required');
        $this->form_validation->set_rules('nomor_opname', 'Nomor Opname', 'trim|required');
        $this->form_validation->set_rules('catatan', 'Catatan', 'trim|required');
        $this->form_validation->set_rules('jenis_bhp', 'jenis_bhp', 'trim');
        $this->form_validation->set_rules('codepus', 'jenis_bhp', 'trim');

		if($this->form_validation->run()== FALSE){
			$data['title_group'] 	= "Bahan Habis Pakai";
			$data['title_form']		= "Tambah Opname";
			$data['action']			= "add";
			$data['kode']			= "";
			/*$data['bulan']			= array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');*/

			$kodepuskesmas = $this->session->userdata('puskesmas');
			$this->db->where('code','P'.$kodepuskesmas);
			$data['kodepuskesmas'] = $this->puskesmas_model->get_data();
		
			die($this->parser->parse("inventory/bhp_opname/form",$data,true));
		}elseif($id = $this->bhp_opname_model->insert_entry()){
			$this->session->set_flashdata('alert', 'Save data successful...');
			if ($this->input->post('jenis_bhp')=="obat") {
				$jenis='8';
			}else{
				$jenis='0';
			}
			$this->edit_opname($id,$jenis);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			daftar_opname();
		}

		$this->template->show($data,"home");
	}
	function edit_opname($id_opname=0,$jenis_bhp=0){

		if ($this->input->post('idjenis')!='' ||!empty($this->input->post('idjenis'))) {
			$jenis_bhp=$this->input->post('idjenis');
		}
		if ($this->input->post('id')!='' ||!empty($this->input->post('id'))) {
			$id_opname=$this->input->post('id');
		}
		

		$this->authentication->verify('inventory','edit');

        $this->form_validation->set_rules('kode_distribusi_', 'Kode Opname', 'trim|required');
        $this->form_validation->set_rules('tgl_opname', 'Tanggal Opname', 'trim|required');
        $this->form_validation->set_rules('penerima_nama', 'Nama Penerima', 'trim|required');
        $this->form_validation->set_rules('penerima_nip', 'NIP Penerima', 'trim|required');
        $this->form_validation->set_rules('nomor_opname', 'Nomor Opname', 'trim|required');
        $this->form_validation->set_rules('catatan', 'Catatan', 'trim|required');
        $this->form_validation->set_rules('jenis_bhp', 'jenis_bhp', 'trim');
        $this->form_validation->set_rules('codepus', 'jenis_bhp', 'trim');

		if($this->form_validation->run()== FALSE){
			$data 	= $this->bhp_opname_model->get_data_row($id_opname);
			$data['title_group'] 	= "Barang Habis Pakai";
			$data['title_form']		= "Ubah Stok Opname";
			$data['action']			= "edit";
			$data['kode']			= $id_opname;
			$data['jenis_bhp']		= $jenis_bhp;
			$data['bulan'] 			= array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');

			
			$kodepuskesmas = $this->session->userdata('puskesmas');
			$this->db->where('code','P'.$kodepuskesmas);
			$data['kodepuskesmas'] = $this->puskesmas_model->get_data();
			$data['kodestatus_inv'] = $this->bhp_opname_model->pilih_data_status('status_pembelian');
			$data['jenis_bhp']		= $jenis_bhp;

			$data['barang']	  			= $this->parser->parse('inventory/bhp_opname/barang', $data, TRUE);
			$data['barang_opname'] 	= $this->parser->parse('inventory/bhp_opname/barang_opname', $data, TRUE);
			die($this->parser->parse("inventory/bhp_opname/edit",$data,true));
		}elseif($this->bhp_opname_model->update_entry($id_opname)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			die(base_url()."inventory/bhp_opname/edit/".$id_opname);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			die(base_url()."inventory/bhp_opname/edit/".$id_opname);
		}

		$this->template->show($data,"home");
	}
	function jsonpengeluaran($id=0){
		$this->authentication->verify('inventory','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_update') {
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
		
		if ($id!=0) {
			$this->db->where("inv_inventaris_habispakai_pengeluaran.id_mst_inv_barang_habispakai",$id);
		}
		
		$rows_all = $this->bhp_opname_model->get_datapengeluaran();


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_update') {
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

		if ($id!=0) {
			$this->db->where("inv_inventaris_habispakai_pengeluaran.id_mst_inv_barang_habispakai",$id);
		}
		$rows = $this->bhp_opname_model->get_datapengeluaran($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no=1;
		//$unlock = 1;
		foreach($rows as $act) {
			$data[] = array(
				'uraian'				=> $act->uraian,
				'tgl_update'			=> $act->tgl_update,
				'nama_pilihan'			=> $act->nama_pilihan,
				/*'jmlawal'				=> ($act->totaljumlah+$act->jmlbaik)-($act->jml_rusak+$act->jml_tdkdipakai),
				'jml_akhir'				=> ($act->totaljumlah+$act->jmlbaik)-($act->jml_rusak+$act->jml_tdkdipakai+$act->jmlpengeluaran),*/
				'harga'					=> $act->harga,
				'jml'			=> $act->jml,
				'id_mst_inv_barang_habispakai'			=> $act->id_mst_inv_barang_habispakai,
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function json_barang($id=0){
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
		if ($id=='8') {
			$this->db->where('id_mst_inv_barang_habispakai_jenis',$id);
		}else{
			$this->db->where('id_mst_inv_barang_habispakai_jenis !=','8');
		}
		
		$rows_all_activity = $this->bhp_opname_model->getitem();


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
		if ($id=='8') {
			$this->db->where('id_mst_inv_barang_habispakai_jenis',$id);
		}else{
			$this->db->where('id_mst_inv_barang_habispakai_jenis !=','8');
		}
		$activity = $this->bhp_opname_model->getitem($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(substr($kodepuskesmas, -2)=="01"){
			$unlock = 1;
		}else{
			$unlock = 0;
		}
		
		foreach($activity as $act) {
			$data[] = array(
				'id_inv_hasbispakai_pembelian'   		=> $act->id_inv_hasbispakai_pembelian,
				'id_mst_inv_barang_habispakai'   		=> $act->id_mst_inv_barang_habispakai,
				'uraian'								=> $act->uraian,
				'jumlah'								=> $act->jumlah,
				'batch'									=> $act->batch,
				'harga'									=> number_format($act->harga,2),
				'subtotal'								=> number_format($act->jumlah*$act->harga,2),
				'tgl_update'							=> $act->tgl_update,
				'edit'		=> 1,
				'delete'	=> 1
			);
		}


		
		$size = sizeof($rows_all_activity);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function json_opname($id=0){
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

		$this->db->where('inv_inventaris_habispakai_opname_item.id_inv_inventaris_habispakai_opname',$id);
		
		$rows_all_activity = $this->bhp_opname_model->getitemopname();


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

		$this->db->where('inv_inventaris_habispakai_opname_item.id_inv_inventaris_habispakai_opname',$id);

		$activity = $this->bhp_opname_model->getitemopname($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(substr($kodepuskesmas, -2)=="01"){
			$unlock = 1;
		}else{
			$unlock = 0;
		}
		
		foreach($activity as $act) {
			$data[] = array(
				'inv_inventaris_habispakai_opname_item'   => $act->inv_inventaris_habispakai_opname_item,
				'id_mst_inv_barang_habispakai'   			=> $act->id_mst_inv_barang_habispakai,
				'batch'										=> $act->batch,
				'uraian'									=> $act->uraian,
				'jml_awal'									=> $act->jml_awal,
				'jml_akhir'									=> $act->jml_akhir,
				'harga'										=> $act->harga,
				'edit'		=> 1,
				'delete'	=> 1
			);
		}


		
		$size = sizeof($rows_all_activity);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function index(){
		$this->authentication->verify('inventory','edit');
		$data['title_group'] = "Barang Habis Pakai";

		$data['title_form'] = "Stock Opname";

		$data['content'] = $this->parser->parse("inventory/bhp_opname/show",$data,true);
		$this->template->show($data,"home");
	}

	function tab($index){
		if($index==1) $this->daftar_bhp();
		else $this->daftar_opname();
	}

	function daftar_bhp(){
		$kodepuskesmas = $this->session->userdata('puskesmas');
		$this->db->where('code','P'.$kodepuskesmas);

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		$data['jenisbaranghabis'] = array('obat'=>'Obat','umum'=>'Umum');

		die($this->parser->parse("inventory/bhp_opname/show_bhp",$data,true));
	}

	function daftar_opname(){
		$kodepuskesmas = $this->session->userdata('puskesmas');
		$this->db->where('code','P'.$kodepuskesmas);

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		$data['jenisbaranghabis'] = array('obat'=>'Obat','umum'=>'Umum');
		
		die($this->parser->parse("inventory/bhp_opname/show_opname",$data,true));
	}

	function autocomplite_barang(){
		$search = explode("&",$this->input->server('QUERY_STRING'));
		$search = str_replace("query=","",$search[0]);
		$search = str_replace("+"," ",$search);

		$kodepuskesmas = "P".$this->session->userdata("puskesmas");
		$this->db->like("uraian",$search);
		$this->db->order_by('id_mst_inv_barang_habispakai','asc');
		$this->db->limit(10,0);
		$this->db->select("mst_inv_barang_habispakai.*,
			(select jml as jml from  inv_inventaris_habispakai_opname where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jmlbaik,
            (select sum(jml) as jmltotal from inv_inventaris_habispakai_pembelian_item 
            JOIN inv_inventaris_habispakai_pembelian ON(inv_inventaris_habispakai_pembelian.id_inv_hasbispakai_pembelian = inv_inventaris_habispakai_pembelian_item.id_inv_hasbispakai_pembelian AND inv_inventaris_habispakai_pembelian.code_cl_phc = inv_inventaris_habispakai_pembelian_item.code_cl_phc AND inv_inventaris_habispakai_pembelian.pilihan_status_pembelian=2)  
            where inv_inventaris_habispakai_pembelian_item.code_cl_phc=".'"'.$kodepuskesmas.'"'." and id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai ) as totaljumlah,
            (select jml_rusak as jmlrusak from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai order by tgl_update desc limit 1) as jml_rusak,
            (select jml_tdkdipakai as jmltdkdipakai from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai order by tgl_update desc limit 1) as jml_tdkdipakai
			");
		$query= $this->db->get("mst_inv_barang_habispakai")->result();
		foreach ($query as $q) {
			$barang[] = array(
				'id_mst_inv_barang_habispakai' 	=> $q->id_mst_inv_barang_habispakai , 
				'uraian' 						=> $q->uraian, 
				'jmlbaik' 						=> $q->jmlbaik-($q->jml_rusak+$q->jml_tdkdipakai), 
				'totaljumlah' 					=> $q->totaljumlah, 
				'harga' 						=> $q->harga, 

			);
		}
		echo json_encode($barang);
	}
	public function add_barang($kode=0)
	{	
		$data['action']			= "add";
		$data['kode']			= $kode;
        $this->form_validation->set_rules('id_mst_inv_barang', 'ID Barang', 'trim|required');
        $this->form_validation->set_rules('jqxinput', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('jumlahawal', 'Jumlah Awal', 'trim|required');
        $this->form_validation->set_rules('dikeluarkan__', 'Di Keluarkan', 'trim|required');
        $this->form_validation->set_rules('jumlahakhir', 'Jumlah Akhir', 'trim');
        $this->form_validation->set_rules('harga', 'harga', 'trim');
        $this->form_validation->set_rules('rusakdipakai', 'rusakdipakai', 'trim');

		if($this->form_validation->run()== FALSE){

			$data = $this->bhp_opname_model->get_data_detail_edit_barang($kode); 
			$data['action']			= "add";
			$data['kode']			= $kode;
			$data['notice']			= validation_errors();

			die($this->parser->parse('inventory/bhp_opname/barang_form', $data));
		}else{
			if($simpan=$this->bhp_opname_model->insertdata()){
				$id=$this->input->post('id_mst_inv_barang');
				die("OK|$id|Tersimpan");
			}else{
				$id=$this->input->post('id_mst_inv_barang');
				 die("Error|$id|Proses data gagal");
			}
			
		}
	}
	
  	public function timeline_pengeluaran_barang($id_barang = 0){
  		$data = array();
  		$data['kode'] = $id_barang;
       	$data['data_kondisi'] 	= $this->bhp_opname_model->get_kondisi_barang($id_barang);
  		echo $this->parser->parse("inventory/bhp_opname/kondisi",$data);


  		die();
  	}
	
	function autocomplite_nama(){
		$search = explode("&",$this->input->server('QUERY_STRING'));
		$search = str_replace("term=","",$search[0]);
		$search = str_replace("+"," ",$search);

		$this->db->like("penerima_nama",$search);
		$this->db->order_by('id_inv_inventaris_habispakai_opname','asc');
		$this->db->limit(10,0);
		$this->db->select("penerima_nama");
		$query= $this->db->get("inv_inventaris_habispakai_opname")->result();
		foreach ($query as $q) {
			$barang[] = array(
				'value'	=> $q->penerima_nama,
			);
		}
		echo json_encode($barang);
	}
	function autocomplite_nip(){
		$search = explode("&",$this->input->server('QUERY_STRING'));
		$search = str_replace("term=","",$search[0]);
		$search = str_replace("+"," ",$search);

		$this->db->like("penerima_nip",$search);
		$this->db->order_by('id_inv_inventaris_habispakai_opname','asc');
		$this->db->limit(10,0);
		$this->db->select("penerima_nip");
		$query= $this->db->get("inv_inventaris_habispakai_opname")->result();
		foreach ($query as $q) {
			$barang[] = array(
				'value'	=> $q->penerima_nip,
			);
		}
		echo json_encode($barang);
	}
	
}
