<?php
class Lap_bhp_pengeluaran extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');		
		
		$this->load->model('inventory/lap_bhp_pengeluaran_model');
		$this->load->model('inventory/inv_barang_model');
		$this->load->model('inventory/permohonanbarang_model');
		$this->load->model('inventory/distribusibarang_model');
		$this->load->model('mst/puskesmas_model');
	}

	function index(){
		$this->authentication->verify('inventory','edit');
		$data['title_group'] 	= "Laporan";
		$data['title_form'] 	= "RKBU - Rekab Kebutuhan Barang Unit";;
		$this->db->like('code','p'.substr($this->session->userdata('puskesmas'),0,7));

		$kodepuskesmas = $this->session->userdata('puskesmas');
			$this->db->where('code','P'.$kodepuskesmas);
		$data['kodepuskesmas'] = $this->puskesmas_model->get_data();
		$data['jenisbaranghabis'] = $this->lap_bhp_pengeluaran_model->get_data_jenis();
		$data['content'] = $this->parser->parse("inventory/lap_bhp_pengeluaran/detail",$data,true);

		$this->template->show($data,"home");
	}
	
	
	function permohonan_export(){
		//$rows_all = $this->lap_bhp_pengeluaran_model->get_data_permohonan();
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		//[data_tabel.no;block=tbs:row]	[data_tabel.tgl]	[data_tabel.ruangan]	[data_tabel.jumlah]	[data_tabel.keterangan]	[data_tabel.status]
		
		$this->authentication->verify('inventory','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal_permohonan') {
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
		$tanggals = explode("-", $this->input->post('filter_tanggal'));
		$rows_all = $this->lap_bhp_pengeluaran_model->get_data_permohonan($tanggals[1],$tanggals[0]);
		

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal_permohonan') {
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
		#$rows = $this->permohonanbarang_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$tanggals = explode("-", $this->input->post('filter_tanggal'));
		$rows = $this->lap_bhp_pengeluaran_model->get_data_permohonan($tanggals[1],$tanggals[0]);
		$data = array();
		
		//die(print_r($rows));
		$no=0;
		$data_tabel = array();
		foreach ($rows as $key => $val) {
		/*	$no=0;
			echo $key." : ";*/
			$no++;
			foreach ($val as $act => $value) {
			/*	echo  'keluar'.$act.'='.$value['pengeluaranperhari'].'/';
			}
			for ($kolom=0; $kolom < count($rows)-1 ; $kolom++) { 

				$data_tabel[] = array(
					'no'				=> $no+$kolom,								
					'uraian'			=> $key[$kolom]['uraian'],				
					);
			}*/
				$data_tabel[$key] = array(
					'no'				=> $no,								
					'uraian'			=> $key,				
					//'value'				=> $key->value,
					'harga'				=> $value['hargamaster'],
					'jumlah'			=> $value['jmlopname']*$value['totaljumlah'],
					'keluar1'			=> $act == 1 ? $value['pengeluaranperhari'] : '',
					'keluar2'			=> $act == 2 ? $value['pengeluaranperhari'] : '',
					'keluar3'			=> $act == 3 ? $value['pengeluaranperhari'] : '',
					'keluar4'			=> $act == 4 ? $value['pengeluaranperhari'] : '',
					'keluar5'			=> $act == 5 ? $value['pengeluaranperhari'] : '',
					'keluar6'			=> $act == 6 ? $value['pengeluaranperhari'] : '',
					'keluar7'			=> $act == 6 ? $data_tabel[$key]['keluar6'] : '',
					'keluar8'			=> $act == 8 ? $value['pengeluaranperhari'] : '',
					'keluar9'			=> $act == 9 ? $value['pengeluaranperhari'] : '',
					'keluar10'			=> $act == 10 ? $value['pengeluaranperhari'] : '',
					'keluar11'			=> $act == 11 ? $value['pengeluaranperhari'] : '',
					'keluar12'			=> $act == 12 ? $value['pengeluaranperhari'] : '',
					'keluar13'			=> $act == 13 ? $value['pengeluaranperhari'] : '',
					'keluar14'			=> $act == 14 ? $value['pengeluaranperhari'] : '',
					'keluar15'			=> $act == 15 ? $value['pengeluaranperhari'] : '',
					'keluar16'			=> $act == 16 ? $value['pengeluaranperhari'] : '',
					'keluar17'			=> $act == 17 ? $value['pengeluaranperhari'] : '',
					'keluar18'			=> $act == 18 ? $value['pengeluaranperhari'] : '',
					'keluar19'			=> $act == 19 ? $value['pengeluaranperhari'] : '',
					'keluar20'			=> $act == 20 ? $value['pengeluaranperhari'] : '',
					'keluar21'			=> $act == 21 ? $value['pengeluaranperhari'] : '',
					'keluar22'			=> $act == 22 ? $value['pengeluaranperhari'] : '',
					'keluar23'			=> $act == 23 ? $value['pengeluaranperhari'] : '',
					'keluar24'			=> $act == 24 ? $value['pengeluaranperhari'] : '',
					'keluar25'			=> $act == 25 ? $value['pengeluaranperhari'] : '',
					'keluar26'			=> $act == 26 ? $value['pengeluaranperhari'] : '',
					'keluar27'			=> $act == 27 ? $value['pengeluaranperhari'] : '',
					'keluar28'			=> $act == 28 ? $value['pengeluaranperhari'] : '',
					'keluar29'			=> $act == 29 ? $value['pengeluaranperhari'] : '',
					'keluar30'			=> $act == 30 ? $value['pengeluaranperhari'] : '',
					'keluar31'			=> $act == 31 ? $value['pengeluaranperhari'] : '',
				);
			}
		}

		die(print_r($data_tabel['285']['keluar6']));
		
		/*
		$data_tabel[] = array('no'=> '1', 'tgl'=>'10/10/2010' , 'ruangan'=>'Hill'      , 'jumlah'=>'19', 'keterangan'=>'bagus', 'status'=>'bagus');
		$data_tabel[] = array('no'=> '2', 'tgl'=>'10/10/2010' , 'ruangan'=>'Hill'      , 'jumlah'=>'19', 'keterangan'=>'bagus', 'status'=>'bagus');
		$data_tabel[] = array('no'=> '3', 'tgl'=>'10/10/2010' , 'ruangan'=>'Hill'      , 'jumlah'=>'19', 'keterangan'=>'bagus', 'status'=>'bagus');
		$data_tabel[] = array('no'=> '4', 'tgl'=>'10/10/2010' , 'ruangan'=>'Hill'      , 'jumlah'=>'19', 'keterangan'=>'bagus', 'status'=>'bagus');
		*/
		//die(print_r($data_tabel));
		$puskes = $this->input->post('puskes'); 
		if(empty($puskes) or $puskes == 'Pilih Puskesmas'){	
				$nama = 'Semua Data Puskesmas';
		}else{
				$nama = $this->inv_barang_model->get_nama('value','cl_phc','code',$this->input->post('puskes'));
		}
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
		$kode_sess=$this->session->userdata('puskesmas');
		$kd_prov = $this->inv_barang_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$kd_kab  = $this->inv_barang_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		$kd_kec  = 'KEC. '.$this->inv_barang_model->get_nama('nama','cl_kec','code',substr($kode_sess, 0,7));
		$tgl = date("d-m-Y");
		$data_puskesmas[] = array('nama_puskesmas' => $nama,'tgl1' => $tanggal,'tgl2' => $tanggal1,'kd_prov' => $kd_prov,'kd_kab' => $kd_kab,'tanggal_export'=>$tgl);
		
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/inventory/lap_bhp_pengeluaran.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		// Merge data in the first sheet
		$TBS->MergeBlock('a', $data_tabel);
		$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = uniqid();
		$output_file_name = 'public/files/hasil/laporan_bhp_pengeluaran_'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;
		
	}

}
