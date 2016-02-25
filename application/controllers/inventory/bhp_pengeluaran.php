<?php
class Bhp_pengeluaran extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('inventory/bhp_pengeluaran_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
		$this->load->model('mst/invbarang_model');
	}

	function pengadaan_export(){
		$this->authentication->verify('inventory','show');
		
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_pengadaan') {
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
		$rows_all = $this->bhp_pengeluaran_model->get_data();


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_pengadaan') {
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
		//$rows = $this->bhp_pengeluaran_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$rows = $this->bhp_pengeluaran_model->get_data();
		$data = array();
		$no=1;
		

		$data_tabel = array();
		foreach($rows as $act) {
			$data_tabel[] = array(
				'tgl_pengadaan' 			=> date("d-m-Y",strtotime($act->tgl_pengadaan)),
				'nomor_kontrak' 			=> $act->nomor_kontrak,
				'nomor_kwitansi' 			=> $act->nomor_kwitansi,
				'tgl_kwitansi' 				=> date("d-m-Y",strtotime($act->tgl_kwitansi)),
				'pilihan_status_pengadaan' 	=> $this->bhp_pengeluaran_model->getPilihan("status_pengadaan",$act->pilihan_status_pengadaan),
				'jumlah_unit'				=> $act->jumlah_unit,
				'nilai_pengadaan'			=> number_format($act->nilai_pengadaan,2),
				'keterangan'				=> $act->keterangan,
				'detail'					=> 1,
				'edit'						=> 1,
				'delete'					=> 1
			);
		}


		$puskes = $this->input->post('puskes');
		if(empty($puskes) or $puskes == 'Pilih Puskesmas'){
			$nama = 'Semua Data Puskesmas';
		}else{
			$nama = $this->input->post('puskes');
		}
		$data_puskesmas[] = array('nama_puskesmas' => $nama);
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/inventory/pengadaan_barang.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		// Merge data in the first sheet
		$TBS->MergeBlock('a', $data_tabel);
		$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = date('Y-m-d-H-i-s');
		$output_file_name = 'public/files/hasil/hasil_export_'.$code.'.xlsx';
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
		
		
		$rows_all = $this->bhp_pengeluaran_model->get_data();


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
		$rows = $this->bhp_pengeluaran_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no=1;
		//$unlock = 1;
		foreach($rows as $act) {
			$data[] = array(
				'no'					=> $no++,
				//'code'					=> $act->code,
				'uraian'				=> $act->uraian,
				//'merek_tipe'			=> $act->merek_tipe,
				//'negara_asal'			=> $act->negara_asal,
				'jmlawal'				=> ($act->totaljumlah+$act->jmlbaik)-($act->jml_rusak+$act->jml_tdkdipakai),
				'jml_akhir'				=> $act->jml_rusak,
				'jml_selisih'			=> $act->jml_tdkdipakai,
				//'pilihan_satuan'		=> $act->pilihan_satuan,
				'value'					=> $act->value,
				'tgl_update'			=> $act->tgl_update,
				//'harga'					=> number_format($act->harga,2),
				'id_mst_inv_barang_habispakai'			=> $act->id_mst_inv_barang_habispakai,
				'id_mst_inv_barang_habispakai_jenis'	=> $act->id_mst_inv_barang_habispakai_jenis
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
		$this->authentication->verify('inventory','edit');
		$data['title_group'] = "Barang Habis Pakai";
		$data['title_form'] = "Pengeluaran Barang";

		$kodepuskesmas = $this->session->userdata('puskesmas');
		$this->db->where('code','P'.$kodepuskesmas);

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		$data['jenisbaranghabis'] = $this->bhp_pengeluaran_model->get_data_jenis();
		$data['content'] = $this->parser->parse("inventory/bhp_pengeluaran/show",$data,true);
		$this->template->show($data,"home");
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
        $this->form_validation->set_rules('dikeluarkan', 'Di Keluarkan', 'trim|required');
        $this->form_validation->set_rules('jumlahakhir', 'Jumlah Akhir', 'trim');

		if($this->form_validation->run()== FALSE){

			$data = $this->bhp_pengeluaran_model->get_data_detail_edit_barang($kode); 
			$data['action']			= "add";
			$data['kode']			= $kode;
			$data['notice']			= validation_errors();

			die($this->parser->parse('inventory/bhp_pengeluaran/barang_form', $data));
		}else{
			if($simpan=$this->bhp_pengeluaran_model->insertdata()){
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

			$data = $this->bhp_pengeluaran_model->get_data_detail_edit_barang($kode); 
			$data['action']			= "kondisi";
			$data['kode']			= $kode;
			$data['notice']			= validation_errors();

			die($this->parser->parse('inventory/bhp_pengeluaran/form', $data));
		}else{
			if($simpan=$this->bhp_pengeluaran_model->insertdatakondisi()){
				$id=$this->input->post('id_mst_inv_barang_habispakai');
				die("OK|$id|Tersimpan");
			}else{
				$id=$this->input->post('id_mst_inv_barang_habispakai');
				 die("Error|$id|Proses data gagal");
			}
			
		}
	}
	public function edit_barang($id_pengadaan=0,$kd_inventaris=0,$kode_proc=0)
	{
		$data['action']			= "edit";
		$data['kode']			= $kd_inventaris;
		$this->form_validation->set_rules('id_mst_inv_barang', 'Kode Barang', 'trim|required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga Satuan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			
			
   			$data = $this->bhp_pengeluaran_model->get_data_barang_edit_table($kd_inventaris,'inv_inventaris_barang_a'); 
   			$data['pilihan_satuan_barang_']			= $this->bhp_pengeluaran_model->get_data_pilihan('satuan');
   			$data['pilihan_status_hak_']			= $this->bhp_pengeluaran_model->get_data_pilihan('status_hak');
   			$data['pilihan_penggunaan_']			= $this->bhp_pengeluaran_model->get_data_pilihan('penggunaan');
			//$data = $this->bhp_pengeluaran_model->get_data_barang_edit($id_barang,$kd_proc,$kd_inventaris); 
   			$data['kodebarang']		= $this->bhp_pengeluaran_model->get_databarang();
   			$data['kodestatus_inv'] = $this->bhp_pengeluaran_model->pilih_data_status('status_inventaris');
			$data['action']			= "edit";
			$data['kode']			= $kd_inventaris;
			$data['id_pengadaan']	= $id_pengadaan;
			$data['kode_proc']		= $kode_proc;
			$data['disable']		= "disable";
			$data['notice']			= validation_errors();
   			/*end mengirim status pada masing2 form*/
			die($this->parser->parse('inventory/bhp_pengeluaran/barang_form_edit', $data));
		}else{
			$jumlah =$this->input->post('jumlah');
			$tanggalterima = explode("/",$this->input->post('tanggal_diterima'));
			$kodebarang_ = substr($kd_inventaris, -14,-12);
			$tanggal_diterima = $tanggalterima[2].'-'.$tanggalterima[1].'-'.$tanggalterima[0];
			$tanggal = $this->bhp_pengeluaran_model->tanggal($id_pengadaan);
			$data_update = array(
					'nama_barang' 			=> $this->input->post('nama_barang'),
					'harga' 				=> $this->input->post('harga'),
				//	'keterangan_pengadaan' 	=> $this->input->post('keterangan_pengadaan'),
					'pilihan_status_invetaris'  => $this->input->post('pilihan_status_invetaris'),
		            'tanggal_pembelian'     => $tanggal,
		            'tanggal_pengadaan'     => $tanggal,
		            'tanggal_diterima'      => $tanggal_diterima,
			);
			$key_update = array('barang_kembar_proc' => $kode_proc,
			 );
			$this->db->update('inv_inventaris_barang',$data_update,$key_update);
			
			if($simpan==true){
				$dataupdate__['terakhir_diubah']= date('Y-m-d H:i:s');
				$dataupdate__['nilai_pengadaan']= $this->bhp_pengeluaran_model->sum_jumlah_item( $id_pengadaan,'harga');
				$dataupdate__['jumlah_unit']= $this->bhp_pengeluaran_model->sum_unit($id_pengadaan)->num_rows();
				$key__['id_pengadaan'] = $id_pengadaan;
        		$this->db->update("inv_pengadaan",$dataupdate__,$key__);
				die("OK|");
			}else{
				 die("Error|Proses data gagal");
			}
		}
		
	}
	public function timeline_comment($id_barang = 0){
  		$data = array();
       	$data['data_barang'] 	= $this->bhp_pengeluaran_model->get_barang($id_barang);
  		echo $this->parser->parse("inventory/bhp_pengeluaran/barang",$data);


  		die();
  	}
  	public function timeline_kondisi_barang($id_barang = 0){
  		$data = array();
       	$data['data_kondisi'] 	= $this->bhp_pengeluaran_model->get_kondisi_barang($id_barang);
  		echo $this->parser->parse("inventory/bhp_pengeluaran/kondisi",$data);


  		die();
  	}
	function dodel_barang($kode=0,$id_barang="",$table=0){
		$this->authentication->verify('inventory','del');

		if($this->bhp_pengeluaran_model->delete_entryitem_table($kode,$id_barang,$table)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	public function add_barang_master($kode=0)
	{	
		$data['action']			= "add";
		$data['kode']			= $kode;
        $this->form_validation->set_rules('uraian_master', 'Uraian', 'trim|required');
        $this->form_validation->set_rules('code_master', 'Kode', 'trim');
        $this->form_validation->set_rules('merk_master', 'Merek Tipe', 'trim');
        $this->form_validation->set_rules('negara_master', 'Negara Asal', 'trim');
        $this->form_validation->set_rules('pilihan_satuan_barang_master', 'Satuan', 'trim');
        $this->form_validation->set_rules('harga_master', 'Harga', 'trim');

		if($this->form_validation->run()== FALSE){
			$data['kode']			= $kode;
			$data['noticemaster']		= validation_errors();
			$data['pilihan_jenis_barang'] = $this->bhp_pengeluaran_model->getnamajenis();
			$data['pilihan_satuan_barang'] = $this->bhp_pengeluaran_model->pilih_data_status('satuan_bhp');
			die($this->parser->parse('inventory/bhp_pengadaan/form_masterbarang', $data));
		}else{
				$values = array(
					'id_mst_inv_barang_habispakai_jenis'=> $this->input->post('pilihan_jenis_barang_master'),
					'code' 			=> $this->input->post('code_master'),
					'uraian'		=> $this->input->post('uraian_master'),
					'merek_tipe' 	=> $this->input->post('merk_master'),
					'negara_asal' 	=> $this->input->post('negara_master'),
					'pilihan_satuan' => $this->input->post('pilihan_satuan_barang_master'),
					'harga' => $this->input->post('harga_master'),
				);
				$simpan=$this->db->insert('mst_inv_barang_habispakai', $values);
				if($simpan==true){
				die("OK|Data disimpan");
			}else{
				 die("Error|Proses data gagal");
			}
			
		}
	}

}
