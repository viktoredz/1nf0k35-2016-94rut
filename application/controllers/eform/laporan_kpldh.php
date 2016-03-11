<?php
class Laporan_kpldh extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('eform/datakeluarga_model');
		$this->load->model('eform/pembangunan_keluarga_model');
		$this->load->model('eform/anggota_keluarga_kb_model');
		$this->load->model('eform/dataform_model');
		$this->load->model('eform/Laporan_kpldh_model');
		$this->load->model('admin_model');
		$this->load->model('inventory/inv_ruangan_model');
	}

	function index(){
		$this->authentication->verify('inventory','edit');
		$data['title_group'] 	= "Laporan";
		$data['title_form'] 	= "Ketuk Pintu Layani Dengan Hati";;

		$kode_sess = $this->session->userdata("puskesmas");
      	$data['datakecamatan'] = $this->datakeluarga_model->get_datawhere(substr($kode_sess, 0,7),"code","cl_kec");
      	$data['data_desa'] = $this->datakeluarga_model->get_desa();
      	$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');

		//$this->db->like('code','p'.substr($this->session->userdata('puskesmas'),0,7));
		$kodepuskesmas = $this->session->userdata('puskesmas');
		//	if(substr($kodepuskesmas, -2)=="01"){
		//		$this->db->like('code','P'.substr($kodepuskesmas, 0,7));
		//	}else {
			$this->db->like('code','P'.$kodepuskesmas);
		//	}
		$datapuskesmas = $this->inv_ruangan_model->get_data_puskesmas();
		foreach ($datapuskesmas as $row) {
			$bar[$row->code]['puskesmas'] = $row->value;
		}


		$j_barang_baik = $this->admin_model->get_jum_aset();
		foreach ($j_barang_baik as $row) {
			$bar[$row->id_cl_phc]['j_barang_baik'] = $row->jml;
		}

		$j_barang_baik1 = $this->admin_model->get_nilai_aset();
		foreach ($j_barang_baik1 as $row) {
			$bar[$row->id_cl_phc]['j_barang_baik1'] = $row->nilai;
		}


		$j_barang_rr = $this->admin_model->get_jum_aset1();
		foreach ($j_barang_rr as $row) {
			$bar[$row->id_cl_phc]['j_barang_rr'] = $row->jml;
		}

		$j_barang_rr1 = $this->admin_model->get_nilai_aset1();
		foreach ($j_barang_rr1 as $row) {
			$bar[$row->id_cl_phc]['j_barang_rr1'] = $row->nilai;
		}


		$j_barang_rb = $this->admin_model->get_jum_aset2();
		foreach ($j_barang_rb as $row) {
			$bar[$row->id_cl_phc]['j_barang_rb'] = $row->jml;
		}

		$j_barang_rb1 = $this->admin_model->get_nilai_aset2();
		foreach ($j_barang_rb1 as $row) {
			$bar[$row->id_cl_phc]['j_barang_rb1'] = $row->nilai;
		}


		$nilai_aset = $this->admin_model->get_jum_nilai_aset();
		foreach ($nilai_aset as $row) {
			$bar[$row->id_cl_phc]['nilai_aset'] = $row->jml;
		}

		$nilai_aset1 = $this->admin_model->get_jum_nilai_aset2();
		foreach ($nilai_aset1 as $row) {
			$bar[$row->id_cl_phc]['nilai_aset1'] = $row->nilai;
		}
		$data['bar']	= $bar;
		$data['color']	= $color;
		$data['content'] = $this->parser->parse("eform/laporan/show",$data,true);

		$this->template->show($data,"home");
	}
	function get_kecamatanfilter(){
		if($this->input->is_ajax_request()) {
			$kecamatan = $this->input->post('kecamatan');
			$kode 	= $this->datakeluarga_model->get_datawhere($kecamatan,"code","cl_village");

				echo '<option value="">Pilih Keluarahan</option>';
			foreach($kode as $kode) :
				echo $select = $kode->code == set_value('kelurahan') ? 'selected' : '';
				echo '<option value="'.$kode->code.'" '.$select.'>' . $kode->value . '</option>';
			endforeach;

			return FALSE;
		}

		show_404();
	}
	function get_kelurahanfilter(){
	if ($this->input->post('kelurahan')!="null") {
		if($this->input->is_ajax_request()) {
			$kelurahan = $this->input->post('kelurahan');
			$kode 	= $this->datakeluarga_model->get_datawhere($kelurahan,"id_desa","data_keluarga");

				echo '<option value="">Pilih Keluarahan</option>';
			foreach($kode as $kode) :
				echo $select = $kode->rw == set_value('rukuwarga') ? 'selected' : '';
				echo '<option value="'.$kode->rw.'" '.$select.'>' . $kode->rw . '</option>';
			endforeach;

			return FALSE;
		}

		show_404();
	}
	}
	public function datachart($value='')
	{
		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');

		$jmlkelamin = $this->Laporan_kpldh_model->get_jum_kelamin();
		foreach ($jmlkelamin as $row) {
			$bar[$row->nama_kecamatan]['kelamin'] = $row->kelamin;
			$bar[$row->nama_kecamatan]['jumlah'] = $row->jumlah;
		}

		$data['bar']	= $bar;
		$data['color']	= $color;
		return print_r($data);
	}
	
}
