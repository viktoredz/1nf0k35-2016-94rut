<?php
class Bhp_opname extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('inventory/bhp_opname_model');
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
		$rows_all = $this->bhp_opname_model->get_data();


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
		//$rows = $this->bhp_opname_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$rows = $this->bhp_opname_model->get_data();
		$data = array();
		$no=1;
		

		$data_tabel = array();
		foreach($rows as $act) {
			$data_tabel[] = array(
				'tgl_pengadaan' 			=> date("d-m-Y",strtotime($act->tgl_pengadaan)),
				'nomor_kontrak' 			=> $act->nomor_kontrak,
				'nomor_kwitansi' 			=> $act->nomor_kwitansi,
				'tgl_kwitansi' 				=> date("d-m-Y",strtotime($act->tgl_kwitansi)),
				'pilihan_status_pengadaan' 	=> $this->bhp_opname_model->getPilihan("status_pengadaan",$act->pilihan_status_pengadaan),
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
				'code'					=> $act->code,
				'uraian'				=> $act->uraian,
				'merek_tipe'			=> $act->merek_tipe,
				'negara_asal'			=> $act->negara_asal,
				'pilihan_satuan'		=> $act->negara_asal,
				'nama_satuan'			=> $act->nama_satuan,
				'harga'					=> number_format($act->harga,2),
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
		$data['title_form'] = "Stok Opname";

		$kodepuskesmas = $this->session->userdata('puskesmas');
		$this->db->where('code','P'.$kodepuskesmas);

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		$data['jenisbaranghabis'] = $this->bhp_opname_model->get_data_jenis();
		$data['content'] = $this->parser->parse("inventory/bhp_opname/show",$data,true);
		$this->template->show($data,"home");
	}

	public function add_barang($kode=0)
	{	
		$data['action']			= "add";
		$data['kode']			= $kode;
        $this->form_validation->set_rules('jml', 'Jumlah Barang', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required');

		if($this->form_validation->run()== FALSE){

			$data = $this->bhp_opname_model->get_data_detail_edit($kode); 
			$data['action']			= "add";
			$data['kode']			= $kode;
			$data['notice']			= validation_errors();

			die($this->parser->parse('inventory/bhp_opname/barang_form', $data));
		}else{
			if($simpan=$this->bhp_opname_model->insertdata()){
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

			$data = $this->bhp_opname_model->get_data_detail_edit_barang($kode); 
			$data['action']			= "kondisi";
			$data['kode']			= $kode;
			$data['notice']			= validation_errors();

			die($this->parser->parse('inventory/bhp_opname/form', $data));
		}else{
			if($simpan=$this->bhp_opname_model->insertdatakondisi()){
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
       // $this->form_validation->set_rules('keterangan_pengadaan', 'Keterangan', 'trim|required');
      	/*validasi kode barang*/
	    $kodebarang_ = substr($kd_inventaris, -14,-12);
	    if($kodebarang_=='01') {
	    	$this->form_validation->set_rules('luas', 'Luas', 'trim|required');
	    	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_satuan_barang', 'Pilihan Satuan Barang', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_status_hak', 'Pilihan Status Hak', 'trim|required');
	    	$this->form_validation->set_rules('status_sertifikat_tanggal', 'Tanggal Status Sertifikat', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_penggunaan', 'Pilihan Penggunaan', 'trim|required');
	    	$this->form_validation->set_rules('status_sertifikat_nomor', 'Nomor Sertifikat', 'trim|required');
	    }else if($kodebarang_=='02') {	
	    	$this->form_validation->set_rules('merek_type', 'Merek Tipe', 'trim|required');
	    	$this->form_validation->set_rules('identitas_barang', 'Identitas Barang', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_bahan', 'Pilihan Bahan', 'trim|required');
	    	$this->form_validation->set_rules('ukuran_barang', 'Ukuran Barang', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_satuan', 'Pilihan Satuan', 'trim|required');
	    	$this->form_validation->set_rules('tanggal_bpkb', 'Tanggal BPKB', 'trim|required');
	    	$this->form_validation->set_rules('nomor_bpkb', 'Nomor BPKB', 'trim|required');
	    	$this->form_validation->set_rules('no_polisi', 'No Polisi', 'trim|required');
	    	$this->form_validation->set_rules('tanggal_perolehan', 'Tanggal Perolehan', 'trim|required');
	    }else if($kodebarang_=='03') {
	    	$this->form_validation->set_rules('luas_lantai', 'Luas Lantai', 'trim|required');
	    	$this->form_validation->set_rules('letak_lokasi_alamat', 'Letak Lokasi Alamat', 'trim|required');
	    	$this->form_validation->set_rules('pillihan_status_hak', 'Pillihan Status Hak', 'trim|required');
	    	$this->form_validation->set_rules('nomor_kode_tanah', 'Nomor Kode Tanah', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_kons_tingkat', 'Pilihan Kontruksi Tingkat', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_kons_beton', 'Pilihan Konstruksi Beton', 'trim|required');
	    	$this->form_validation->set_rules('dokumen_tanggal', 'Tanggal Dokumen', 'trim|required');
	    	$this->form_validation->set_rules('dokumen_nomor', 'Nomor Dokumen', 'trim|required');
	    }else if($kodebarang_=='04') {
	    	$this->form_validation->set_rules('konstruksi', 'Konstruksi', 'trim|required');
	    	$this->form_validation->set_rules('panjang', 'Panjang', 'trim|required');
	    	$this->form_validation->set_rules('lebar', 'Lebar', 'trim|required');
	    	$this->form_validation->set_rules('luas', 'Luas', 'trim|required');
	    	$this->form_validation->set_rules('letak_lokasi_alamat', 'Lokasi Alamat', 'trim|required');
	    	$this->form_validation->set_rules('dokumen_tanggal', 'Tanggal Dokumen', 'trim|required');
	    	$this->form_validation->set_rules('dokumen_nomor', 'Nomor Dokumen', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_status_tanah', 'Pilihan Status Tanah', 'trim|required');
	    	$this->form_validation->set_rules('nomor_kode_tanah', 'Nomor Kode Tanah', 'trim|required');
	    }else if($kodebarang_=='05') {
	    	$this->form_validation->set_rules('buku_judul_pencipta', 'Judul Buku Pencipta', 'trim|required');
	    	$this->form_validation->set_rules('buku_spesifikasi', 'Spesifikasi Buku', 'trim|required');
	    	$this->form_validation->set_rules('budaya_asal_daerah', 'Budaya Asal Daerah', 'trim|required');
	    	$this->form_validation->set_rules('budaya_pencipta', 'Pencipta Budaya', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_budaya_bahan', 'pilihan Budaya Bahan', 'trim|required');
	    	$this->form_validation->set_rules('flora_fauna_jenis', 'Jenis Flora Fauna', 'trim|required');
	    	$this->form_validation->set_rules('flora_fauna_ukuran', 'Ukuran Flora Fauna', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_satuan', 'Pilihan Satuan', 'trim|required');
	    	$this->form_validation->set_rules('tahun_cetak_beli', 'Tahun Cetak Beli', 'trim|required');
	    }else if($kodebarang_=='06') {
	    	$this->form_validation->set_rules('bangunan', 'Bangunan', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_konstruksi_bertingkat', 'Pilihan Konstruksi Bertingkat', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_konstruksi_beton', 'Pilihan Konstruksi Beton', 'trim|required');
	    	$this->form_validation->set_rules('luas', 'Luas', 'trim|required');
	    	$this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required');
	    	$this->form_validation->set_rules('dokumen_tanggal', 'Tanggal Dokumen', 'trim|required');
	    	$this->form_validation->set_rules('dokumen_nomor', 'Nomor Dokumen', 'trim|required');
	    	$this->form_validation->set_rules('tanggal_mulai', 'Mulai Tanggal', 'trim|required');
	    	$this->form_validation->set_rules('pilihan_status_tanah', 'Pilihan Status Tanah', 'trim|required');
	    }
		/*end validasi kode barang*/
		if($this->form_validation->run()== FALSE){
			
			
			/*mengirim status pada masing2 form*/

			$kodebarang_ = substr($kd_inventaris, -14,-12);
	   		if($kodebarang_=='01') {
	   			$data = $this->bhp_opname_model->get_data_barang_edit_table($kd_inventaris,'inv_inventaris_barang_a'); 
	   			$data['pilihan_satuan_barang_']			= $this->bhp_opname_model->get_data_pilihan('satuan');
	   			$data['pilihan_status_hak_']			= $this->bhp_opname_model->get_data_pilihan('status_hak');
	   			$data['pilihan_penggunaan_']			= $this->bhp_opname_model->get_data_pilihan('penggunaan');
	   		}else if($kodebarang_=='02') {
	   			$data = $this->bhp_opname_model->get_data_barang_edit_table($kd_inventaris,'inv_inventaris_barang_b'); 
	   			$data['pilihan_bahan_']				= $this->bhp_opname_model->get_data_pilihan('bahan');
	   			$data['pilihan_satuan_']				= $this->bhp_opname_model->get_data_pilihan('satuan');
	   		}else if($kodebarang_=='03') {
	   			$data = $this->bhp_opname_model->get_data_barang_edit_table($kd_inventaris,'inv_inventaris_barang_c'); 
	   			$data['pillihan_status_hak_']		= $this->bhp_opname_model->get_data_pilihan('status_hak');
	   			$data['pilihan_kons_tingkat_']		= $this->bhp_opname_model->get_data_pilihan('kons_tingkat');
	   			$data['pilihan_kons_beton_']			= $this->bhp_opname_model->get_data_pilihan('kons_beton');
	   		}else if($kodebarang_=='04') {
	   			$data = $this->bhp_opname_model->get_data_barang_edit_table($kd_inventaris,'inv_inventaris_barang_d'); 
	   			$data['pilihan_status_tanah_']		= $this->bhp_opname_model->get_data_pilihan('status_hak');
	   		}else if($kodebarang_=='05') {
	   			$data = $this->bhp_opname_model->get_data_barang_edit_table($kd_inventaris,'inv_inventaris_barang_e'); 
	   			$data['pilihan_budaya_bahan_']		= $this->bhp_opname_model->get_data_pilihan('bahan');
	   			$data['pilihan_satuan_']				= $this->bhp_opname_model->get_data_pilihan('satuan');
   			}else if($kodebarang_=='06') {
   				$data = $this->bhp_opname_model->get_data_barang_edit_table($kd_inventaris,'inv_inventaris_barang_f'); 
   				$data['pilihan_konstruksi_bertingkat_']= $this->bhp_opname_model->get_data_pilihan('kons_tingkat');
	   			$data['pilihan_konstruksi_beton_']	= $this->bhp_opname_model->get_data_pilihan('kons_beton');
	   			$data['pilihan_status_tanah_']		= $this->bhp_opname_model->get_data_pilihan('status_hak');
   			}
   			//$data = $this->bhp_opname_model->get_data_barang_edit($id_barang,$kd_proc,$kd_inventaris); 
   			$data['kodebarang']		= $this->bhp_opname_model->get_databarang();
   			$data['kodestatus_inv'] = $this->bhp_opname_model->pilih_data_status('status_inventaris');
			$data['action']			= "edit";
			$data['kode']			= $kd_inventaris;
			$data['id_pengadaan']	= $id_pengadaan;
			$data['kode_proc']		= $kode_proc;
			$data['disable']		= "disable";
			$data['notice']			= validation_errors();
   			/*end mengirim status pada masing2 form*/
			die($this->parser->parse('inventory/bhp_opname/barang_form_edit', $data));
		}else{
			$jumlah =$this->input->post('jumlah');
			$tanggalterima = explode("/",$this->input->post('tanggal_diterima'));
			$kodebarang_ = substr($kd_inventaris, -14,-12);
			$tanggal_diterima = $tanggalterima[2].'-'.$tanggalterima[1].'-'.$tanggalterima[0];
			$tanggal = $this->bhp_opname_model->tanggal($id_pengadaan);
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
			//$simpan = $this->dodelpermohonan($kd_inventaris,$id_barang,$kd_proc);
			//for($i=1;$i<=$jumlah;$i++){
			//	$id = $this->bhp_opname_model->insert_data_from($id_barang,$kode_proc,$tanggal_diterima,$id_pengadaan);
					/*simpan pada bedadatabase*/
			$id_inv = $this->db->query("SELECT id_inventaris_barang,id_mst_inv_barang FROM inv_inventaris_barang WHERE  barang_kembar_proc=$kode_proc")->result();
        	foreach ($id_inv as $keyinv) {
        		$kodebarang_ = substr($keyinv->id_mst_inv_barang,0,2);
		   		if($kodebarang_=='01') {	
		   			$this->db->where('id_inventaris_barang',$keyinv->id_inventaris_barang);
				 	$this->db->delete('inv_inventaris_barang_a');
		   			/*$jumlah = $this->bhp_opname_model->jumlahtable('inv_inventaris_barang_a',$keyinv->id_inventaris);
		   			if ($jumlah>0) {
		   				$tanggal = explode("/",$this->input->post('status_sertifikat_tanggal'));
		   				$status_sertifikat_tanggal = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
		   				$values = array(
							'luas' 					=> $this->input->post('luas'),
							'alamat' 				=> $this->input->post('alamat'),
							'pilihan_satuan_barang' => $this->input->post('pilihan_satuan_barang'),
							'pilihan_status_hak' 	=> $this->input->post('pilihan_status_hak'),
							'status_sertifikat_tanggal' => $status_sertifikat_tanggal,
							'status_sertifikat_nomor'=> $this->input->post('status_sertifikat_nomor'),
							'pilihan_penggunaan' 	=> $this->input->post('pilihan_penggunaan'),
						);
						$key = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
							);
						$simpan=$this->db->update('inv_inventaris_barang_a', $values,$key);
		   			}else{*/
		   				$tanggal = explode("/",$this->input->post('status_sertifikat_tanggal'));
		   				$status_sertifikat_tanggal = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
		   				$values = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
							'id_mst_inv_barang'		=> $keyinv->id_mst_inv_barang,
							'luas' 					=> $this->input->post('luas'),
							'alamat' 				=> $this->input->post('alamat'),
							'pilihan_satuan_barang' => $this->input->post('pilihan_satuan_barang'),
							'pilihan_status_hak' 	=> $this->input->post('pilihan_status_hak'),
							'status_sertifikat_tanggal' => $status_sertifikat_tanggal,
							'status_sertifikat_nomor'=> $this->input->post('status_sertifikat_nomor'),
							'pilihan_penggunaan' 	=> $this->input->post('pilihan_penggunaan'),
						);
						$simpan=$this->db->insert('inv_inventaris_barang_a', $values);
						
					//}
		   		}else if($kodebarang_=='02') {
		   			$this->db->where('id_inventaris_barang',$keyinv->id_inventaris_barang);
				 	$this->db->delete('inv_inventaris_barang_b');
		   			/*$jumlah = $this->bhp_opname_model->jumlahtable('inv_inventaris_barang_b',$keyinv->id_inventaris);
		   			if($jumlah>0){
		   				$tanggal = explode("/",$this->input->post('tanggal_bpkb'));
			   			$tanggal_bpkb = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$tanggal_ = explode("/",$this->input->post('tanggal_perolehan'));
			   			$tanggal_perolehan = $tanggal_[2].'-'.$tanggal_[1].'-'.$tanggal_[0];
			   			$values = array(
							'merek_type' 			=> $this->input->post('merek_type'),
							'identitas_barang' 		=> $this->input->post('identitas_barang'),
							'pilihan_bahan' 		=> $this->input->post('pilihan_bahan'),
							'ukuran_barang' 		=> $this->input->post('ukuran_barang'),
							'pilihan_satuan' 		=> $this->input->post('pilihan_satuan'),
							'tanggal_bpkb'			=> $tanggal_bpkb,
							'nomor_bpkb'		 	=> $this->input->post('nomor_bpkb'),
							'no_polisi'		 		=> $this->input->post('no_polisi'),
							'tanggal_perolehan'	 	=> $tanggal_perolehan,
						);
						$key = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
						 );	
						$simpan=$this->db->update('inv_inventaris_barang_b', $values,$key);
		   			}else{*/
			   			$tanggal = explode("/",$this->input->post('tanggal_bpkb'));
			   			$tanggal_bpkb = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$tanggal_ = explode("/",$this->input->post('tanggal_perolehan'));
			   			$tanggal_perolehan = $tanggal_[2].'-'.$tanggal_[1].'-'.$tanggal_[0];
			   			$values = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
							'id_mst_inv_barang'		=> $keyinv->id_mst_inv_barang,
							'merek_type' 			=> $this->input->post('merek_type'),
							'identitas_barang' 		=> $this->input->post('identitas_barang'),
							'pilihan_bahan' 		=> $this->input->post('pilihan_bahan'),
							'ukuran_barang' 		=> $this->input->post('ukuran_barang'),
							'pilihan_satuan' 		=> $this->input->post('pilihan_satuan'),
							'tanggal_bpkb'			=> $tanggal_bpkb,
							'nomor_bpkb'		 	=> $this->input->post('nomor_bpkb'),
							'no_polisi'		 		=> $this->input->post('no_polisi'),
							'tanggal_perolehan'	 	=> $tanggal_perolehan,
						);
						$simpan=$this->db->insert('inv_inventaris_barang_b', $values);
					//}
		   		}else if($kodebarang_=='03') {
		   			$this->db->where('id_inventaris_barang',$keyinv->id_inventaris_barang);
				 	$this->db->delete('inv_inventaris_barang_c');
		   			/*$jumlah = $this->bhp_opname_model->jumlahtable('inv_inventaris_barang_c',$keyinv->id_inventaris);
		   			if ($jumlah>0) {
		   				$tanggal = explode("/",$this->input->post('dokumen_tanggal'));
			   			$dokumen_tanggal = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$values = array(
							'luas_lantai' 			=> $this->input->post('luas_lantai'),
							'letak_lokasi_alamat' 	=> $this->input->post('letak_lokasi_alamat'),
							'pillihan_status_hak' 	=> $this->input->post('pillihan_status_hak'),
							'nomor_kode_tanah' 		=> $this->input->post('nomor_kode_tanah'),
							'pilihan_kons_tingkat' 	=> $this->input->post('pilihan_kons_tingkat'),
							'pilihan_kons_beton'	=> $this->input->post('pilihan_kons_beton'),
							'dokumen_tanggal'		=> $dokumen_tanggal,
							'dokumen_nomor'		 	=> $this->input->post('dokumen_nomor'),
						);
						$key = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
						 );	
						$simpan=$this->db->update('inv_inventaris_barang_c', $values,$key);
		   			}else {*/
			   			$tanggal = explode("/",$this->input->post('dokumen_tanggal'));
			   			$dokumen_tanggal = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$values = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
							'id_mst_inv_barang'		=> $keyinv->id_mst_inv_barang,
							'luas_lantai' 			=> $this->input->post('luas_lantai'),
							'letak_lokasi_alamat' 	=> $this->input->post('letak_lokasi_alamat'),
							'pillihan_status_hak' 	=> $this->input->post('pillihan_status_hak'),
							'nomor_kode_tanah' 		=> $this->input->post('nomor_kode_tanah'),
							'pilihan_kons_tingkat' 	=> $this->input->post('pilihan_kons_tingkat'),
							'pilihan_kons_beton'	=> $this->input->post('pilihan_kons_beton'),
							'dokumen_tanggal'		=> $dokumen_tanggal,
							'dokumen_nomor'		 	=> $this->input->post('dokumen_nomor'),
						);
						$simpan=$this->db->insert('inv_inventaris_barang_c', $values);
					//}
		   		}else if($kodebarang_=='04') {
		   			$this->db->where('id_inventaris_barang',$keyinv->id_inventaris_barang);
				 	$this->db->delete('inv_inventaris_barang_d');
		   			/*$jumlah = $this->bhp_opname_model->jumlahtable('inv_inventaris_barang_d',$keyinv->id_inventaris);
		   			if($jumlah>0){
		   				$tanggal = explode("/",$this->input->post('dokumen_tanggal'));
			   			$dokumen_tanggal = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$values = array(
							'konstruksi' 			=> $this->input->post('konstruksi'),
							'panjang' 				=> $this->input->post('panjang'),
							'lebar' 				=> $this->input->post('lebar'),
							'luas' 					=> $this->input->post('luas'),
							'letak_lokasi_alamat' 	=> $this->input->post('letak_lokasi_alamat'),
							'dokumen_tanggal'		=> $dokumen_tanggal,
							'dokumen_nomor'			=> $this->input->post('dokumen_nomor'),
							'pilihan_status_tanah'	=> $this->input->post('pilihan_status_tanah'),
							'nomor_kode_tanah'		=> $this->input->post('nomor_kode_tanah'),
						);
		   				$key = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
						 );	
						$simpan=$this->db->update('inv_inventaris_barang_d', $values,$key);
		   			}else{*/
			   			$tanggal = explode("/",$this->input->post('dokumen_tanggal'));
			   			$dokumen_tanggal = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$values = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
							'id_mst_inv_barang'		=> $keyinv->id_mst_inv_barang,
							'konstruksi' 			=> $this->input->post('konstruksi'),
							'panjang' 				=> $this->input->post('panjang'),
							'lebar' 				=> $this->input->post('lebar'),
							'luas' 					=> $this->input->post('luas'),
							'letak_lokasi_alamat' 	=> $this->input->post('letak_lokasi_alamat'),
							'dokumen_tanggal'		=> $dokumen_tanggal,
							'dokumen_nomor'			=> $this->input->post('dokumen_nomor'),
							'pilihan_status_tanah'	=> $this->input->post('pilihan_status_tanah'),
							'nomor_kode_tanah'		=> $this->input->post('nomor_kode_tanah'),
						);
						$simpan=$this->db->insert('inv_inventaris_barang_d', $values);
					//}
		   		}else if($kodebarang_=='05') {
		   			$this->db->where('id_inventaris_barang',$keyinv->id_inventaris_barang);
				 	$this->db->delete('inv_inventaris_barang_e');
		   			/*$jumlah = $this->bhp_opname_model->jumlahtable('inv_inventaris_barang_e',$keyinv->id_inventaris);
		   			if ($jumlah>0) {
		   				$tanggal = explode("/",$this->input->post('tahun_cetak_beli'));
			   			$tahun_cetak_beli = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$values = array(
							'buku_judul_pencipta' 	=> $this->input->post('buku_judul_pencipta'),
							'buku_spesifikasi' 		=> $this->input->post('buku_spesifikasi'),
							'budaya_asal_daerah' 	=> $this->input->post('budaya_asal_daerah'),
							'budaya_pencipta' 		=> $this->input->post('budaya_pencipta'),
							'pilihan_budaya_bahan' 	=> $this->input->post('pilihan_budaya_bahan'),
							'flora_fauna_jenis'		=> $this->input->post('flora_fauna_jenis'),
							'flora_fauna_ukuran'	=> $this->input->post('flora_fauna_ukuran'),
							'pilihan_satuan'		=> $this->input->post('pilihan_satuan'),
							'tahun_cetak_beli'		=> $tahun_cetak_beli,
						);
		   				$key = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
						 );	
						$simpan=$this->db->update('inv_inventaris_barang_e', $values,$key);
		   			}else{*/
			   			$tanggal = explode("/",$this->input->post('tahun_cetak_beli'));
			   			$tahun_cetak_beli = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$values = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
							'id_mst_inv_barang'		=> $keyinv->id_mst_inv_barang,
							'buku_judul_pencipta' 	=> $this->input->post('buku_judul_pencipta'),
							'buku_spesifikasi' 		=> $this->input->post('buku_spesifikasi'),
							'budaya_asal_daerah' 	=> $this->input->post('budaya_asal_daerah'),
							'budaya_pencipta' 		=> $this->input->post('budaya_pencipta'),
							'pilihan_budaya_bahan' 	=> $this->input->post('pilihan_budaya_bahan'),
							'flora_fauna_jenis'		=> $this->input->post('flora_fauna_jenis'),
							'flora_fauna_ukuran'	=> $this->input->post('flora_fauna_ukuran'),
							'pilihan_satuan'		=> $this->input->post('pilihan_satuan'),
							'tahun_cetak_beli'		=> $tahun_cetak_beli,
						);
						$simpan=$this->db->insert('inv_inventaris_barang_e', $values);
					//}
				}else if($kodebarang_=='06') {
					$this->db->where('id_inventaris_barang',$keyinv->id_inventaris_barang);
				 	$this->db->delete('inv_inventaris_barang_f');
					/*$jumlah = $this->bhp_opname_model->jumlahtable('inv_inventaris_barang_f',$keyinv->id_inventaris);
					if($jumlah>0){
						$tanggal = explode("/",$this->input->post('tanggal_mulai'));
			   			$tanggal_mulai = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$values = array(
							'bangunan' 				=> $this->input->post('bangunan'),
							'pilihan_konstruksi_bertingkat' => $this->input->post('pilihan_konstruksi_bertingkat'),
							'pilihan_konstruksi_beton' 	=> $this->input->post('pilihan_konstruksi_beton'),
							'luas' 					=> $this->input->post('luas'),
							'lokasi' 				=> $this->input->post('lokasi'),
							'dokumen_tanggal'		=> $this->input->post('dokumen_tanggal'),
							'dokumen_nomor'			=> $this->input->post('dokumen_nomor'),
							'tanggal_mulai'			=> $tanggal_mulai,
							'pilihan_status_tanah'	=> $this->input->post('pilihan_status_tanah'),
						);
						$key = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
						 );	
						$simpan=$this->db->update('inv_inventaris_barang_f', $values,$key);
					}else{*/
						$tanggal = explode("/",$this->input->post('tanggal_mulai'));
			   			$tanggal_mulai = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			   			$values = array(
							'id_inventaris_barang' 	=> $keyinv->id_inventaris_barang,
							'id_mst_inv_barang'		=> $keyinv->id_mst_inv_barang,
							'bangunan' 				=> $this->input->post('bangunan'),
							'pilihan_konstruksi_bertingkat' => $this->input->post('pilihan_konstruksi_bertingkat'),
							'pilihan_konstruksi_beton' 	=> $this->input->post('pilihan_konstruksi_beton'),
							'luas' 					=> $this->input->post('luas'),
							'lokasi' 				=> $this->input->post('lokasi'),
							'dokumen_tanggal'		=> $this->input->post('dokumen_tanggal'),
							'dokumen_nomor'			=> $this->input->post('dokumen_nomor'),
							'tanggal_mulai'			=> $tanggal_mulai,
							'pilihan_status_tanah'	=> $this->input->post('pilihan_status_tanah'),
						);
						$simpan=$this->db->insert('inv_inventaris_barang_f', $values);
					//}
				}
				/*end simpan pada bedadatabase form*/
			}
			
			if($simpan==true){
				$dataupdate__['terakhir_diubah']= date('Y-m-d H:i:s');
				$dataupdate__['nilai_pengadaan']= $this->bhp_opname_model->sum_jumlah_item( $id_pengadaan,'harga');
				$dataupdate__['jumlah_unit']= $this->bhp_opname_model->sum_unit($id_pengadaan)->num_rows();
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
       	$data['data_barang'] 	= $this->bhp_opname_model->get_barang($id_barang);
  		echo $this->parser->parse("inventory/bhp_opname/barang",$data);


  		die();
  	}
  	public function timeline_kondisi_barang($id_barang = 0){
  		$data = array();
       	$data['data_kondisi'] 	= $this->bhp_opname_model->get_kondisi_barang($id_barang);
  		echo $this->parser->parse("inventory/bhp_opname/kondisi",$data);


  		die();
  	}
	function dodel_barang($kode=0,$id_barang="",$table=0){
		$this->authentication->verify('inventory','del');

		if($this->bhp_opname_model->delete_entryitem_table($kode,$id_barang,$table)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	

}
