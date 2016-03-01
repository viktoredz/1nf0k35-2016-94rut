<?php
class Lap_bhp_ketersediaan extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');		
		
		$this->load->model('inventory/lap_bhp_ketersediaan_model');
		$this->load->model('inventory/inv_barang_model');
		$this->load->model('inventory/distribusibarang_model');
		$this->load->model('inventory/lap_bhp_ketersediaan_model');
		$this->load->model('mst/puskesmas_model');
	}

	function index(){
		$this->authentication->verify('inventory','edit');
		$data['title_group'] 	= "Laporan";
		$data['title_form'] 	= "Kartu Ketersediaan BHP";
		$this->db->like('code','p'.substr($this->session->userdata('puskesmas'),0,7));

		$kodepuskesmas = $this->session->userdata('puskesmas');
		$this->db->where('code','P'.$kodepuskesmas);

		$data['kodepuskesmas'] = $this->puskesmas_model->get_data();
		$data['jenisbaranghabis'] = $this->lap_bhp_ketersediaan_model->get_data_jenis();
		$data['content'] = $this->parser->parse("inventory/lap_bhp_ketersediaan/detail",$data,true);

		$this->template->show($data,"home");
	}
	
	function permohonan_export(){
		
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
		if($this->input->post('jenisbarang')!=''){
			if($this->input->post('jenisbarang')=="all"){

			}else{
				$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$this->input->post('jenisbarang'));
			}
		}else{
			//$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$kode);
		}
		if((!empty($this->input->post('filter_tanggal')))||(!empty($this->input->post('filter_tanggal1')))){
			$this->db->where('inv_inventaris_habispakai_opname.tgl_update >=', $this->input->post('filter_tanggal'));
			$this->db->where('inv_inventaris_habispakai_opname.tgl_update <=', $this->input->post('filter_tanggal1'));
		}
		
		$rows_all = $this->lap_bhp_ketersediaan_model->get_data_export();


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
		if($this->input->post('jenisbarang')!=''){
			if($this->input->post('jenisbarang')=="all"){
				
			}else{
				$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$this->input->post('jenisbarang'));
			}
		}else{
			//$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$kode);
		}
		if((!empty($this->input->post('filter_tanggal')))||(!empty($this->input->post('filter_tanggal1')))){
			$this->db->where('inv_inventaris_habispakai_opname.tgl_update >=', $this->input->post('filter_tanggal'));
			$this->db->where('inv_inventaris_habispakai_opname.tgl_update <=', $this->input->post('filter_tanggal1'));
		}
		
		$rows = $this->lap_bhp_ketersediaan_model->get_data_export(/*$this->input->post('recordstartindex'), $this->input->post('pagesize')*/);
		$data_tabel = array();
		$no=1;
		//$unlock = 1;
		
		foreach($rows as $act) {
			if (($act->harga_opname==0)||$act->harga_opname==null) {
				$harga = $act->harga;
			}else{
				$harga = $act->harga_opname;
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

		
		/*
		$nama = $this->inv_barang_model->get_nama('value','cl_phc','code',$this->input->post('puskes'));
		$tanggal = $this->input->post('filter_tanggal'); 
		$tanggal1 = $this->input->post('filter_tanggal1'); 
		if(empty($tanggal) or $tanggal == '' or empty($tanggal1) or $tanggal1 == ''){
			$tanggal = date('d-m-Y');
			$tanggal1 = date('d-m-Y');
		}else{
			$tanggals = explode("-", $this->input->post('filter_tanggal'));
			$tanggal = $tanggals[2].'-'.$tanggals[1].'-'.$tanggals[0];
			$tanggals1 = explode("-", $this->input->post('filter_tanggal1'));
			$tanggal1 = $tanggals1[2].'-'.$tanggals1[1].'-'.$tanggals1[0];
		}

		$data_puskesmas[] = array('nama_puskesmas' => $nama,'tanggal' => $tanggal,'tanggal1' => $tanggal1);
		
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/inventory/rkbu.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		// Merge data in the first sheet
		$TBS->MergeBlock('a', $data_tabel);
		$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = uniqid();
		$output_file_name = 'public/files/hasil/laporan_rkbu_'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;
		*/
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

}
