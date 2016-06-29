<?php
class Bukupenjagaan extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('kepegawaian/bukupenjagaan_model');
		$this->load->model('inventory/inv_barang_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
		$this->load->model('mst/invbarang_model');
	}

	function index(){
		$this->authentication->verify('kepegawaian','edit');
		$data['title_group'] = "Kepegawaian";
		$data['title_form'] = "Buku Penjagaan";
		$data['content'] = $this->parser->parse("kepegawaian/bukupenjagaan/show",$data,true);
		$this->template->show($data,"home");
	}
	function tmtteakhir(){
		$kodepus = 'P'.$this->session->userdata('puskesmas');
		$this->db->where('code_cl_phc',$kodepus);
		$this->db->select('max(tmt) as maxtmt');
		$query = $this->db->get('pegawai_pangkat');
		if ($query->num_rows() > 0) {
			$data = $query->row_array();
		}else{
			$data = 0;
		}
		return $data;
	}
	function tabbuku($pageIndex){
		$data = array();
		$this->authentication->verify('kepegawaian','edit');
		$data['title_group'] = "Kepegawaian";
		$data['title_form'] = "Buku Penjagaan";
		$kodepuskesmas = $this->session->userdata('puskesmas');
		$this->db->where('code','P'.$kodepuskesmas);

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		switch ($pageIndex) {
			case 1:
				$tmt = $this->tmtteakhir();
				$data['tmtteakhir'] = $tmt['maxtmt'];
				die($this->parser->parse("kepegawaian/bukupenjagaan/show_kenaikanpangkat",$data));

				break;
			case 2:
				die($this->parser->parse("kepegawaian/bukupenjagaan/show_pensiun",$data));

				break;
			case 3:
				die($this->parser->parse("kepegawaian/bukupenjagaan/show_gaji",$data));

				break;
			default:

				die($this->parser->parse("kepegawaian/bukupenjagaan/show_kenaikanpangkat",$data));
				break;
		}

	}
	function json_gaji(){
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows_all = $this->bukupenjagaan_model->get_datagaji();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
			
		$rows = $this->bukupenjagaan_model->get_datagaji($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		
		$no=$this->input->post('recordstartindex')+1;
		foreach($rows as $act) {
			$data[] = array(
				'no' 							=> $no++,
				'id_pegawai' 					=> $act->id_pegawai,
				'code_cl_phc' 					=> $act->code_cl_phc,
				'nik' 							=> $act->nik,
				'nama'							=> $act->gelar_depan.' '.$act->nama.' '.$act->gelar_belakang,
				'tgl_lhr'						=> $act->tgl_lhr,
				'tmp_lahir'						=> $act->tmp_lahir,
				'nip_nit'						=> $act->nip_nit,
				'tmt'							=> $act->tmt,
				'gaji_baru'						=> number_format($act->gaji_baru,2),
				'tmtdata'						=> $act->tmt,
				'bulanpensiun'					=> $this->bulan(date("n",strtotime($act->tgl_lhr))),
				'tahunpensiun'					=> date("Y",strtotime($act->tgl_lhr))+56,
				'id_mst_peg_golruang'			=> $act->id_mst_peg_golruang,
				'ruang'							=> $act->id_mst_peg_golruang.' - '.$act->ruang,
				'keterangan'					=> $act->keterangan,
				'detail'						=> 1,
				'edit'							=> 1,
			);
		}
		
		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function json(){
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows_all = $this->bukupenjagaan_model->get_data();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
			
		$rows = $this->bukupenjagaan_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		
		$no=$this->input->post('recordstartindex')+1;
		foreach($rows as $act) {
			$data[] = array(
				'no' 							=> $no++,
				'id_pegawai' 					=> $act->id_pegawai,
				'code_cl_phc' 					=> $act->code_cl_phc,
				'nik' 							=> $act->nik,
				'nama'							=> $act->gelar_depan.' '.$act->nama.' '.$act->gelar_belakang,
				'tgl_lhr'						=> $act->tgl_lhr,
				'tmp_lahir'						=> $act->tmp_lahir,
				'nip_nit'						=> $act->nip_nit,
				'tmt'							=> $act->tmt,
				'tmtdata'						=> $act->tmt,
				'bulanpensiun'					=> $this->bulan(date("n",strtotime($act->tgl_lhr))),
				'tahunpensiun'					=> date("Y",strtotime($act->tgl_lhr))+56,
				'id_mst_peg_golruang'			=> $act->id_mst_peg_golruang,
				'ruang'							=> $act->id_mst_peg_golruang.' - '.$act->ruang,
				'keterangan'					=> $act->keterangan,
				'detail'						=> 1,
				'edit'							=> 1,
			);
		}
		
		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function bulan($bulan)
	{
		Switch ($bulan){
		    case 1 : $bulan="Januari";
		        Break;
		    case 2 : $bulan="Februari";
		        Break;
		    case 3 : $bulan="Maret";
		        Break;
		    case 4 : $bulan="April";
		        Break;
		    case 5 : $bulan="Mei";
		        Break;
		    case 6 : $bulan="Juni";
		        Break;
		    case 7 : $bulan="Juli";
		        Break;
		    case 8 : $bulan="Agustus";
		        Break;
		    case 9 : $bulan="September";
		        Break;
		    case 10 : $bulan="Oktober";
		        Break;
		    case 11 : $bulan="November";
		        Break;
		    case 12 : $bulan="Desember";
		        Break;
		    }
		return $bulan;
	}
	public function barang($id = 0){
		$this->authentication->verify('kepegawaian','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'harga' ) {
					$this->db->where('inv_inventaris_habispakai_permintaan_item.harga',$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$this->db->where('inv_inventaris_habispakai_permintaan_item.id_inv_hasbispakai_permintaan',$id);
		$rows_all_activity = $this->bukupenjagaan_model->getItem();


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'harga' ) {
					$this->db->where('inv_inventaris_habispakai_permintaan_item.harga',$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$this->db->where('inv_inventaris_habispakai_permintaan_item.id_inv_hasbispakai_permintaan',$id);
		$activity = $this->bukupenjagaan_model->getItem($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(substr($kodepuskesmas, -2)=="01"){
			$unlock = 1;
		}else{
			$unlock = 0;
		}
		
		foreach($activity as $act) {
			$data[] = array(
				'id_inv_hasbispakai_permintaan'   		=> $act->id_inv_hasbispakai_permintaan,
				'id_mst_inv_barang_habispakai'   		=> $act->id_mst_inv_barang_habispakai,
				'uraian'								=> $act->uraian,
				'jml'									=> $act->jml,
				'harga'									=> number_format($act->harga,2),
				'subtotal'								=> number_format($act->jml*$act->harga,2),
				'tgl_permintaan'							=> $act->tgl_permintaan,
				'status_permintaan'							=> $act->status_permintaan,
				'pilihan_satuan'							=> $act->pilihan_satuan,
			);
		}


		
		$size = sizeof($rows_all_activity);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function permintaan_export_pangkat()
	{
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows_all = $this->bukupenjagaan_model->get_data();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
			
		$rows = $this->bukupenjagaan_model->get_data();

		$datatahun=array();
		$temp=array();
		$datamerge=array();
		
		$tmtakhir = explode("-", date("Y-m-d"));
		for($i=0; $i<=4;$i++){
			$temp = $datamerge;
			$dt=$i+1;
			$datatahun = array(
					"th$dt" => $tmtakhir[0]+$i,
				);
			$datamerge= array_merge($temp,$datatahun);
		}
		$datatampil = array();
		$datatampil[] = $datamerge;



		$data_tabel = array();
		
		$no=1;
		foreach($rows as $act) {
			$databulan = explode('-', $act->tmt);
			$data_tabel[] = array(
				'no' 							=> $no++,
				'id_pegawai' 					=> $act->id_pegawai,
				'code_cl_phc' 					=> $act->code_cl_phc,
				'nik' 							=> $act->nik,
				'nama'							=> $act->gelar_depan.' '.$act->nama.' '.$act->gelar_belakang,
				'tgl_lhr'						=> $act->tgl_lhr,
				'tmpt_tgl_lahir'				=> $act->tmp_lahir.', '.date("d-m-Y",strtotime($act->tgl_lhr)),
				'tmp_lahir'						=> $act->tmp_lahir,
				'nip_nit'						=> $act->nip_nit,
				'tmt'							=> $act->tmt,
				'tmtdata'						=> $act->tmt,
				'bulanpensiun'					=> $this->bulan(date("n",strtotime($act->tgl_lhr))),
				'tahunpensiun'					=> date("Y",strtotime($act->tgl_lhr))+56,
				'id_mst_peg_golruang'			=> $act->id_mst_peg_golruang,
				'ruang'							=> $act->id_mst_peg_golruang.' - '.$act->ruang,
				'keterangan'					=> $act->keterangan,
				'aprilth_1'						=> (($databulan[0]+4 == $datatampil[0]['th1']  && $databulan[1] =='4') ? 'v' : '-'),
				'septemberth_1'					=> (($databulan[0]+4 == $datatampil[0]['th1']  && $databulan[1] =='10') ? 'v' : '-'),
				'aprilth_2'						=> (($databulan[0]+4 == $datatampil[0]['th2']  && $databulan[1] =='4') ? 'v' : '-'),
				'septemberth_2'					=> (($databulan[0]+4 == $datatampil[0]['th2']  && $databulan[1] =='10') ? 'v' : '-'),
				'aprilth_3'						=> (($databulan[0]+4 == $datatampil[0]['th3']  && $databulan[1] =='4') ? 'v' : '-'),
				'septemberth_3'					=> (($databulan[0]+4 == $datatampil[0]['th3']  && $databulan[1] =='10') ? 'v' : '-'),
				'aprilth_4'						=> (($databulan[0]+4 == $datatampil[0]['th4']  && $databulan[1] =='4') ? 'v' : '-'),
				'septemberth_4'					=> (($databulan[0]+4 == $datatampil[0]['th4']  && $databulan[1] =='10') ? 'v' : '-'),
				'aprilth_5'						=> (($databulan[0]+4 == $datatampil[0]['th5']  && $databulan[1] =='4') ? 'v' : '-'),
				'septemberth_5'					=> (($databulan[0]+4 == $datatampil[0]['th5']  && $databulan[1] =='10') ? 'v' : '-'),
				'detail'						=> 1,
				'edit'							=> 1,
			);
			
		}
		

		$kode_sess=$this->session->userdata('puskesmas');
		$kd_prov = $this->inv_barang_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$kd_kab  = $this->inv_barang_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		$kd_kec  = 'KEC. '.$this->inv_barang_model->get_nama('nama','cl_kec','code',substr($kode_sess, 0,7));
		$namapus  = $this->inv_barang_model->get_nama('value','cl_phc','code','P'.$kode_sess);
		$tahun  = date("Y");

		$data_puskesmas[] = array('nama_puskesmas' => $namapus,'kd_prov' => $kd_prov,'kd_kab' => $kd_kab,'tahun' => $tahun);
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/kepegawaian/bukupenjagaan_pangkat.xlsx';		
		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		
		
		$TBS->MergeBlock('b', $data_puskesmas);
		$TBS->MergeBlock('a', $data_tabel); 
		$TBS->MergeBlock('c', $datatampil); 

		
		$code = uniqid();
		$output_file_name = 'public/files/hasil/hasil_export_bukupenjagaan_pangkat'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;

	}
	
	function permintaan_export_pensiun()
	{
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows_all = $this->bukupenjagaan_model->get_data();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
			
		$rows = $this->bukupenjagaan_model->get_data();
		$data_tabel = array();
		
		$no=$this->input->post('recordstartindex')+1;
		foreach($rows as $act) {
			$data_tabel[] = array(
				'no' 							=> $no++,
				'id_pegawai' 					=> $act->id_pegawai,
				'code_cl_phc' 					=> $act->code_cl_phc,
				'nik' 							=> $act->nik,
				'nama'							=> $act->gelar_depan.' '.$act->nama.' '.$act->gelar_belakang,
				'tmp_tgl_lahir'					=> $act->tmp_lahir.', '.date("d-m-Y",strtotime($act->tgl_lhr)),
				'tgl_lhr'						=> $act->tgl_lhr,
				'tmp_lahir'						=> $act->tmp_lahir,
				'nip_nit'						=> $act->nip_nit,
				'tmt'							=> $act->tmt,
				'tmtdata'						=> $act->tmt,
				'bulanpensiun'					=> $this->bulan(date("n",strtotime($act->tgl_lhr))),
				'tahunpensiun'					=> date("Y",strtotime($act->tgl_lhr))+56,
				'id_mst_peg_golruang'			=> $act->id_mst_peg_golruang,
				'ruang'							=> $act->id_mst_peg_golruang.' - '.$act->ruang,
				'keterangan'					=> $act->keterangan,
				'detail'						=> 1,
				'edit'							=> 1,
			);
		}
		$kode_sess=$this->session->userdata('puskesmas');
		$kd_prov = $this->inv_barang_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$kd_kab  = $this->inv_barang_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		$kd_kec  = 'KEC. '.$this->inv_barang_model->get_nama('nama','cl_kec','code',substr($kode_sess, 0,7));
		$namapus  = $this->inv_barang_model->get_nama('value','cl_phc','code','P'.$kode_sess);
		$tahun  = date("Y");

		$data_puskesmas[] = array('nama_puskesmas' => $namapus,'kd_prov' => $kd_prov,'kd_kab' => $kd_kab,'tahun' => $tahun);
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/kepegawaian/bukupenjagaan_pensiun.xlsx';		
		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		// Merge data in the first sheet
		$TBS->MergeBlock('a', $data_tabel);
		$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = uniqid();
		$output_file_name = 'public/files/hasil/hasil_export_bukupenjagaan_pensiun'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;

	}
	function permintaan_export_gaji()
	{
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$this->authentication->verify('kepegawaian','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows_all = $this->bukupenjagaan_model->get_datagaji();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tmt') {
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
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
			
		$rows = $this->bukupenjagaan_model->get_datagaji();

		$datatahun=array();
		$temp=array();
		$datamerge=array();
		
		$tmtakhir = explode("-", date("Y-m-d"));
		for($i=0; $i<=4;$i++){
			$temp = $datamerge;
			$dt=$i+1;
			$datatahun = array(
					"th$dt" => $tmtakhir[0]+$i,
				);
			$datamerge= array_merge($temp,$datatahun);
		}
		$datatampil = array();
		$datatampil[] = $datamerge;



		$data_tabel = array();
		
		$no=1;
		foreach($rows as $act) {
			$databulan = explode('-', $act->tmt);
			$data_tabel[] = array(
				'no' 							=> $no++,
				'id_pegawai' 					=> $act->id_pegawai,
				'code_cl_phc' 					=> $act->code_cl_phc,
				'nik' 							=> $act->nik,
				'nama'							=> $act->gelar_depan.' '.$act->nama.' '.$act->gelar_belakang,
				'tgl_lhr'						=> $act->tgl_lhr,
				'tmpt_tgl_lahir'				=> $act->tmp_lahir.', '.date("d-m-Y",strtotime($act->tgl_lhr)),
				'tmp_lahir'						=> $act->tmp_lahir,
				'nip_nit'						=> $act->nip_nit,
				'tmt'							=> $act->tmt,
				'tmtdata'						=> $act->tmt,
				'gaji_baru'						=> number_format($act->gaji_baru,2),
				'bulanpensiun'					=> $this->bulan(date("n",strtotime($act->tgl_lhr))),
				'tahunpensiun'					=> date("Y",strtotime($act->tgl_lhr))+55,
				'id_mst_peg_golruang'			=> $act->id_mst_peg_golruang,
				'ruang'							=> $act->id_mst_peg_golruang.' - '.$act->ruang,
				'keterangan'					=> $act->keterangan,
				'gajith_1'						=> (($databulan[0]+2 == $datatampil[0]['th1']  ) ? $databulan[2].'-'.$databulan[1].'-'.(($databulan[0])+2) : '-'),
				'gajith_2'						=> (($databulan[0]+2 == $datatampil[0]['th2']  ) ? $databulan[2].'-'.$databulan[1].'-'.(($databulan[0])+2) : '-'),
				'gajith_3'						=> (($databulan[0]+2 == $datatampil[0]['th3']  ) ? $databulan[2].'-'.$databulan[1].'-'.(($databulan[0])+2) : '-'),
				'gajith_4'						=> (($databulan[0]+2 == $datatampil[0]['th4']  ) ? $databulan[2].'-'.$databulan[1].'-'.(($databulan[0])+2) : '-'),
				'gajith_5'						=> (($databulan[0]+2 == $datatampil[0]['th5']  ) ? $databulan[2].'-'.$databulan[1].'-'.(($databulan[0])+2) : '-'),
				'detail'						=> 1,
				'edit'							=> 1,
			);
			
		}
		

		$kode_sess=$this->session->userdata('puskesmas');
		$kd_prov = $this->inv_barang_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$kd_kab  = $this->inv_barang_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		$kd_kec  = 'KEC. '.$this->inv_barang_model->get_nama('nama','cl_kec','code',substr($kode_sess, 0,7));
		$namapus  = $this->inv_barang_model->get_nama('value','cl_phc','code','P'.$kode_sess);
		$tahun  = date("Y");

		$data_puskesmas[] = array('nama_puskesmas' => $namapus,'kd_prov' => $kd_prov,'kd_kab' => $kd_kab,'tahun' => $tahun);
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/kepegawaian/bukupenjagaan_gaji.xlsx';		
		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		
		
		$TBS->MergeBlock('b', $data_puskesmas);
		$TBS->MergeBlock('a', $data_tabel); 
		$TBS->MergeBlock('c', $datatampil); 

		
		$code = uniqid();
		$output_file_name = 'public/files/hasil/hasil_export_bukupenjagaan_gaji'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;

	}
}

