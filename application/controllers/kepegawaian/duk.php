<?php
class Duk extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('kepegawaian/drh_model');
		$this->load->model('kepegawaian/duk_model');
		$this->load->model('inventory/inv_ruangan_model');
	}
	
	function index(){
		$this->authentication->verify('kepegawaian','edit');
		$data['title_group'] = "Kepegawaian";
		$data['title_form'] = "Penilaian DUK";
		

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(strlen($kodepuskesmas) == 4){
			$this->db->like('code','P'.substr($kodepuskesmas, 0,4));
		}else {
			$this->db->where('code','P'.$kodepuskesmas);
		}

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		// $data['dataformat'] = array('struktur' =>'Struktur' , 'fungsional' =>'Fungsional','normatif' =>'Normatif');
		// $data['dataunitkerja'] = $this->drh_model->get_datawhere('all','all','');
		$data['content'] = $this->parser->parse("kepegawaian/duk/show",$data,true);


		$this->template->show($data,"home");
	}

	function permohonan_export(){
		
		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$this->authentication->verify('kepegawaian','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lhr') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
				}elseif($field == 'namapendidikan') {
					$field = "pendidikan.nama_jurusan";
				}elseif($field == 'tahunijazah') {
					$field = "DATE_FORMAT(pendidikan.ijazah_tgl, '%Y')";
				}elseif($field == 'tmt_pangkat') {
					$value = date("Y-m-d",strtotime($value));
					$field = "pangkat.tmt";
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('pegawai.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		

		$rows_all = $this->duk_model->get_data('export');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lhr') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'tmt_pangkat') {
					$value = date("Y-m-d",strtotime($value));
					$field = "pangkat.tmt";
				}elseif($field == 'namapendidikan') {
					$field = "pendidikan.nama_jurusan";
				}elseif($field == 'tahunijazah') {
					$field = "DATE_FORMAT(pendidikan.ijazah_tgl, '%Y')";
				}elseif($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('pegawai.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows = $this->duk_model->get_data('export');
		$data_tabel = array();
		$no=1;
		foreach($rows as $act) {
			$data_tabel[] = array(
				'no' 					=> $no++,
				'id_pegawai' 			=> $act->id_pegawai,
				'nik'					=> $act->nik,
				'gelar_depan'			=> $act->gelar_depan,
				'gelar_belakang'		=> $act->gelar_belakang,
				'nama'					=> $act->gelar_depan.' '.$act->nama.' '.$act->gelar_belakang,
				'jenis_kelamin'			=> ($act->jenis_kelamin =='L' ? 'Laki-laki' : 'Perempuan'),
				'tgl_lhr'				=> $act->tgl_lhr,
				'tmpt_lahir'			=> $act->tmp_lahir.', '.date("d-m-Y",strtotime($act->tgl_lhr)),
				'alamat'				=> $act->alamat	,
				'code_cl_phc'			=> $act->code_cl_phc,
				'nip_nit'				=> $act->nip_nit,
				'sekolah_nama'			=> $act->sekolah_nama,
				'deskripsi'				=> $act->deskripsi,
				'tmp_lahir'				=> $act->tmp_lahir,
				'tmt_pangkat'			=> $act->tmt_pangkat !='' ? date("d-m-Y",strtotime($act->tmt_pangkat)) : '-',
				'pangkatterakhir'		=> $act->pangkatterakhir,
				'id_mst_peg_golruang'	=> $act->id_mst_peg_golruang,
				'jabatanterakhirstuktural'=> $act->jabatanterakhirstuktural,
				'jabatanterakhirfungsional'	=> $act->jabatanterakhirfungsional,
				'catatanmutasi'			=> $act->catatanmutasi,
				'keterangan'			=> $act->keterangan,
				'namajabatan'			=> $act->namajabatan,
				'tar_eselon'			=> $act->tar_eselon,
				'tmtstruktural'			=> $act->tmtstruktural,
				'tmtfungsional'			=> $act->tmtfungsional,
				'tmtjabatan'			=> $act->tmtjabatan,
				'masa_krj_bln'			=> $act->masa_krj_bln,
				'masa_krj_thn'			=> $act->masa_krj_thn,
				'diklatterakhir'		=> $act->diklatterakhir,
				'nama_diklat'			=> $act->nama_diklat,
				'tgl_diklat'			=> $act->tgl_diklat !='' ? date("d-m-Y",strtotime($act->tgl_diklat)) : '-',
				'lama_diklat'			=> $act->lama_diklat,
				'nama_jurusan'			=> $act->nama_jurusan,
				'ijazah_tgl'			=> $act->ijazah_tgl,
				'namapendidikan'		=> $act->namapendidikan,
				'tahunijazah'			=> $act->tahunijazah,
				'bulanusia'				=> $act->bulanusia,
				'tahunumur'				=> $act->tahunumur,
				'detail'	=> 1,
				'edit'		=> 1,
				'delete'	=> 1
			);
		}


		$puskes = $this->input->post('puskes'); 
		if(empty($puskes) or $puskes == 'Pilih Puskesmas'){
			$nama = 'Semua Data Puskesmas';
		}else{
			$nama = $this->input->post('puskes');
		}
		$tanggal = date('d-m-Y');

		$data_puskesmas[] = array('nama_puskesmas' => $nama,'tanggal' => $tanggal);
		
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/kepegawaian/duk.xlsx';		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
		$TBS->MergeBlock('a', $data_tabel);
		$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = uniqid();
		$output_file_name = 'public/files/hasil/hasil_exportdppp_'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;
		
	}
	
	function json($grid=''){
		$this->authentication->verify('kepegawaian','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lhr') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
				}elseif($field == 'namapendidikan') {
					$field = "pendidikan.nama_jurusan";
				}elseif($field == 'tahunijazah') {
					$field = "DATE_FORMAT(pendidikan.ijazah_tgl, '%Y')";
				}elseif($field == 'tmt_pangkat') {
					$value = date("Y-m-d",strtotime($value));
					$field = "pangkat.tmt";
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('pegawai.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		

		$rows_all = $this->duk_model->get_data($grid);

		$no=1;
		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_lhr') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'tmt_pangkat') {
					$value = date("Y-m-d",strtotime($value));
					$field = "pangkat.tmt";
				}elseif($field == 'namapendidikan') {
					$field = "pendidikan.nama_jurusan";
				}elseif($field == 'tahunijazah') {
					$field = "DATE_FORMAT(pendidikan.ijazah_tgl, '%Y')";
				}elseif($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		
		if ($this->session->userdata('puskesmas')!='') {
			$this->db->where('pegawai.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows = $this->duk_model->get_data($grid,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no = $this->input->post('recordstartindex')+1;
		foreach($rows as $act) {
			$data[] = array(
				'no' 					=> $no++,
				'id_pegawai' 			=> $act->id_pegawai,
				'nik'					=> $act->nik,
				'gelar_depan'			=> $act->gelar_depan,
				'gelar_belakang'		=> $act->gelar_belakang,
				'nama'					=> $act->gelar_depan.' '.$act->nama.' '.$act->gelar_belakang,
				'jenis_kelamin'			=> ($act->jenis_kelamin =='L' ? 'Laki-laki' : 'Perempuan'),
				'tgl_lhr'				=> $act->tgl_lhr,
				'alamat'				=> $act->alamat	,
				'code_cl_phc'			=> $act->code_cl_phc,
				'nip_nit'				=> $act->nip_nit,
				'sekolah_nama'			=> $act->sekolah_nama,
				'deskripsi'				=> $act->deskripsi,
				'tmp_lahir'				=> $act->tmp_lahir,
				'tmt_pangkat'			=> $act->tmt_pangkat,
				'pangkatterakhir'		=> $act->pangkatterakhir,
				'id_mst_peg_golruang'	=> $act->id_mst_peg_golruang,
				'jabatanterakhirstuktural'=> $act->jabatanterakhirstuktural,
				'jabatanterakhirfungsional'	=> $act->jabatanterakhirfungsional,
				'catatanmutasi'			=> $act->catatanmutasi,
				'keterangan'			=> $act->keterangan,
				'namajabatan'			=> $act->namajabatan,
				'tar_eselon'			=> $act->tar_eselon,
				'tmtstruktural'			=> $act->tmtstruktural,
				'tmtfungsional'			=> $act->tmtfungsional,
				'tmtjabatan'			=> $act->tmtjabatan,
				'masa_krj_bln'			=> $act->masa_krj_bln,
				'masa_krj_thn'			=> $act->masa_krj_thn,
				'diklatterakhir'		=> $act->diklatterakhir,
				'nama_diklat'			=> $act->nama_diklat,
				'tgl_diklat'			=> $act->tgl_diklat,
				'lama_diklat'			=> $act->lama_diklat,
				'nama_jurusan'			=> $act->nama_jurusan,
				'ijazah_tgl'			=> $act->ijazah_tgl,
				'namapendidikan'		=> $act->namapendidikan,
				'tahunijazah'			=> $act->tahunijazah,
				'bulanusia'				=> $act->bulanusia,
				'tahunumur'				=> $act->tahunumur,
				'detail'	=> 1,
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
	function filter(){
		if($_POST) {
			if($this->input->post('code_cl_phc') != '') {
				$this->session->set_userdata('filter_code_cl_phc',$this->input->post('code_cl_phc'));
			}
		}
	}
	
	public function total_permohonan($id){
		$this->db->where('code_cl_phc',"P".$this->session->userdata('puskesmas'));
		$this->db->where('id_inv_permohonan_barang',$id);
		$this->db->select('sum(jumlah) as totaljumlah,sum(jumlah*harga) as totalharga');
		$query = $this->db->get('inv_permohonan_barang_item')->result();
		foreach ($query as $q) {
			$totalpengadaan[] = array(
				'totaljumlah' => $q->totaljumlah, 
				'totalharga' => 'Rp. '.number_format($q->totalharga,2), 
			);
			echo json_encode($totalpengadaan);
		}
    }
	public function get_ruangan()
	{
		if($this->input->is_ajax_request()) {
			$code_cl_phc = $this->input->post('code_cl_phc');
			$id_mst_inv_ruangan = $this->input->post('id_mst_inv_ruangan');

			$kode 	= $this->inv_ruangan_model->getSelectedData('mst_inv_ruangan',$code_cl_phc)->result();

				echo '<option value="">Pilih Ruangan</option>';
			foreach($kode as $kode) :
				echo $select = $kode->id_mst_inv_ruangan == $id_mst_inv_ruangan ? 'selected' : '';
				echo '<option value="'.$kode->id_mst_inv_ruangan.'" '.$select.'>' . $kode->nama_ruangan . '</option>';
			endforeach;

			return FALSE;
		}

		show_404();
	}
	public function get_nama()
	{
		if($this->input->is_ajax_request()) {
			$code = $this->input->post('code');

			$this->db->where("code",$code);
			$kode 	= $this->invbarang_model->getSelectedData('mst_inv_barang',$code)->row();

			if(!empty($kode)) echo $kode->uraian;

			return TRUE;
		}

		show_404();
	}

}
