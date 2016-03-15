<?php
class Laporan_kpldh extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('eform/datakeluarga_model');
		$this->load->model('eform/pembangunan_keluarga_model');
		$this->load->model('eform/anggota_keluarga_kb_model');
		$this->load->model('eform/dataform_model');
		$this->load->model('eform/laporan_kpldh_model');
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
	function pilihchart($judul=0){
		$judul = $this->input->post("judul");
		$kecamatan = $this->input->post("kecamatan");
		$kelurahan = $this->input->post("kelurahan");
		$rw = $this->input->post("rw");
		if($judul=="Distribusi Penduduk Berdasarkan Jenis Kelamin"){
			$this->datakelamin($kecamatan,$kelurahan,$rw);
		}else if($judul=="Distribusi Penduduk Menurut Usia"){
			$this->datausia($kecamatan,$kelurahan,$rw);
		}else if($judul=="Distribusi Penduduk Menurut Tingkat Pendidikan"){
			$this->datapendidikan($kecamatan,$kelurahan,$rw);
		}else if($judul=="Distribusi Penduduk Berdasarkan Pekerjaan"){
			$this->datapekerjaan($kecamatan,$kelurahan,$rw);
		}else if($judul=="Distribusi Penduduk Mengikuti Kegiatan Posyandu"){
			$this->datakegiatanposyandu($kecamatan,$kelurahan,$rw);
		}else if($judul=="Distribusi Penduduk Penyandang Disabilitas"){
			$this->datadisabilitas($kecamatan,$kelurahan,$rw);
		}else if($judul=="Distribusi Penduduk Jaminan Kesehatan"){
			$this->datajaminankesehatan($kecamatan,$kelurahan,$rw);
		}else if($judul=="Distribusi Penduduk Keikutsertaan KB"){
			$this->datakeikutsertaankb($kecamatan,$kelurahan,$rw);
		}else if($judul=="Distribusi Penduduk Alasan Tidak KB"){
			$this->dataalsantidakkb($kecamatan,$kelurahan,$rw);
		}else{
			return $judul;
		}
	}
	public function datakelamin($kecamatan=0,$kelurahan=0,$rw=0)
	{
		
		//$data['data_formprofile']  = $this->dataform_model->get_data_formprofile($kode); 
		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');

		$jmlkelamin = $this->laporan_kpldh_model->get_jum_kelamin($kecamatan,$kelurahan,$rw);
		//$total = 0;
		foreach ($jmlkelamin as $row) {
			//$total = $total+$row->jumlah;
			$bar[$row->nama_kecamatan]['kelamin'] = $row->kelamin;
			$bar[$row->nama_kecamatan]['jumlah'] = $row->jumlah;
		//	$bar[$row->nama_kecamatan]['totalkel'] = $row->jumlah/$total*100;
		}
		$data['jumlahorang'] = $this->laporan_kpldh_model->jumlahorang($kecamatan,$kelurahan,$rw);
		$data['showkelamin'] = $jmlkelamin;
		$data['bar']	= $bar;
	//	print_r($bar);
	//	die();
		$data['color']	= $color;
		die($this->parser->parse("eform/laporan/chartkelamin",$data));
	}
	public function datausia($kecamatan=0,$kelurahan=0,$rw=0)
	{

		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');

		/*$datapuskesmas = $this->laporan_kpldh_model->get_datawhere($kecamatan,'code','cl_kec');
		foreach ($datapuskesmas as $row) {
			$bar[$row->code]['puskesmas'] = $row->nama;
		}*/
		$kecamatan = substr($this->session->userdata("puskesmas"), 0,7);
		$totalorang = $this->laporan_kpldh_model->totaljumlah($kecamatan,$kelurahan,$rw);
		if ($totalorang!=0) {
			foreach ($totalorang as $row) {
				$bar[/*$row->id_kecamatan*/$kecamatan]['total'] = $row->totalorang;
				$bar[/*$row->id_kecamatan*/$kecamatan]['puskesmas'] = $row->nama_kecamatan;
			}
		}
		
		$infant = $this->laporan_kpldh_model->get_nilai_infant($kecamatan,$kelurahan,$rw);
		foreach ($infant as $row) {
			$bar[/*$row->id_kecamatan*/$kecamatan]['jmlinfant'] = $row->jumlah;
		}
		/*$total = $this->laporan_kpldh_model->get_nilai_infant($kecamatan,$kelurahan,$rw);
		foreach ($total as $row) {
			$bar[$row->id_kecamatan]['total'] = $row->total;
		}*/

		$toddler = $this->laporan_kpldh_model->get_nilai_usia('1','3',$kecamatan,$kelurahan,$rw);
		foreach ($toddler as $row) {
			$bar[/*$row->id_kecamatan*/$kecamatan]['jmltoddler'] = $row->jumlah;
		}


		$Preschool = $this->laporan_kpldh_model->get_nilai_usia('4','5',$kecamatan,$kelurahan,$rw);
		foreach ($Preschool as $row) {
			$bar[/*$row->id_kecamatan*/$kecamatan]['jmlpreschool'] = $row->jumlah;
		}

		$sekolah = $this->laporan_kpldh_model->get_nilai_usia('6','12',$kecamatan,$kelurahan,$rw);
		foreach ($sekolah as $row) {
			$bar[/*$row->id_kecamatan*/$kecamatan]['jmlsekolah'] = $row->jumlah;
		}


		$remaja = $this->laporan_kpldh_model->get_nilai_usia('13','20',$kecamatan,$kelurahan,$rw);
		foreach ($remaja as $row) {
			$bar[/*$row->id_kecamatan*/$kecamatan]['jmlremaja'] = $row->jumlah;
		}

		$dewasa = $this->laporan_kpldh_model->get_nilai_usia('21','44',$kecamatan,$kelurahan,$rw);
		foreach ($dewasa as $row) {
			$bar[/*$row->id_kecamatan*/$kecamatan]['jmldewasa'] = $row->jumlah;
		}


		$prelansia = $this->laporan_kpldh_model->get_nilai_usia('45','59',$kecamatan,$kelurahan,$rw);
		foreach ($prelansia as $row) {
			$bar[/*$row->id_kecamatan*/$kecamatan]['jmlprelansia'] = $row->jumlah;
		}

		$lansia = $this->laporan_kpldh_model->get_nilai_lansia('60',$kecamatan,$kelurahan,$rw);
		foreach ($lansia as $row) {
			$bar[/*$row->id_kecamatan*/$kecamatan]['jmllansia'] = $row->jumlah;
		}
		$data['jumlahorang'] = $this->laporan_kpldh_model->jumlahorang($kecamatan,$kelurahan,$rw);
		$data['bar']	= $bar;
		$data['color']	= $color;
		die($this->parser->parse("eform/laporan/chartusia",$data));
	}
	public function datapendidikan($kecamatan=0,$kelurahan=0,$rw=0)
	{
		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');

		/*$datapuskesmas = $this->laporan_kpldh_model->get_datawhere($kecamatan,'code','cl_kec');
		foreach ($datapuskesmas as $row) {
			$bar[$row->code]['puskesmas'] = $row->nama;
		}*/
		$totalorang = $this->laporan_kpldh_model->totaljumlah($kecamatan,$kelurahan,$rw);
		if ($totalorang!=0) {
			foreach ($totalorang as $row) {
				$bar[$row->id_kecamatan]['totalorang'] = $row->totalorang;
				$bar[$row->id_kecamatan]['puskesmas'] = $row->nama_kecamatan;
			}
		}


		$blm_sekolah = $this->laporan_kpldh_model->get_jml_pendidikan('40',$kecamatan,$kelurahan,$rw);
		foreach ($blm_sekolah as $row) {
			$bar[$row->id_kecamatan]['blmsekolah'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalblmsekolah'] = $row->total;
		}

		$tidak_sekolah = $this->laporan_kpldh_model->get_jml_pendidikan('41',$kecamatan,$kelurahan,$rw);
		foreach ($tidak_sekolah as $row) {
			$bar[$row->id_kecamatan]['tidaksekolah'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totaltidaksekolah'] = $row->total;
		}

		$tdk_tamatsd = $this->laporan_kpldh_model->get_jml_pendidikan('14',$kecamatan,$kelurahan,$rw);
		foreach ($tdk_tamatsd as $row) {
			$bar[$row->id_kecamatan]['tdktamatsd'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totaltdktamatsd'] = $row->total;
		}


		$masih_sd = $this->laporan_kpldh_model->get_jml_pendidikan('15',$kecamatan,$kelurahan,$rw);
		foreach ($masih_sd as $row) {
			$bar[$row->id_kecamatan]['masihsd'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalmasihsd'] = $row->total;
		}

		$tamat_sd = $this->laporan_kpldh_model->get_jml_pendidikan('16',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_sd as $row) {
			$bar[$row->id_kecamatan]['tamatsd'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totaltamatsd'] = $row->total;
		}


		$masih_smp = $this->laporan_kpldh_model->get_jml_pendidikan('17',$kecamatan,$kelurahan,$rw);
		foreach ($masih_smp as $row) {
			$bar[$row->id_kecamatan]['masihsmp'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalmasihsmp'] = $row->total;
		}

		$tamat_smp = $this->laporan_kpldh_model->get_jml_pendidikan('18',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_smp as $row) {
			$bar[$row->id_kecamatan]['tamatsmp'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totaltamatsmp'] = $row->total;
		}


		$masih_sma = $this->laporan_kpldh_model->get_jml_pendidikan('19',$kecamatan,$kelurahan,$rw);
		foreach ($masih_sma as $row) {
			$bar[$row->id_kecamatan]['masihsma'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalmasihsma'] = $row->total;
		}

		$tamat_sma = $this->laporan_kpldh_model->get_jml_pendidikan('20',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_sma as $row) {
			$bar[$row->id_kecamatan]['tamatsma'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totaltamatsma'] = $row->total;
		}

		$masih_pt = $this->laporan_kpldh_model->get_jml_pendidikan('21',$kecamatan,$kelurahan,$rw);
		foreach ($masih_pt as $row) {
			$bar[$row->id_kecamatan]['masihpt'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalmasihpt'] = $row->total;
		}
		$tamat_pt = $this->laporan_kpldh_model->get_jml_pendidikan('22',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_pt as $row) {
			$bar[$row->id_kecamatan]['tamatpt'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totaltamatpt'] = $row->total;
		}
		
		$data['bar']	= $bar;
		$data['color']	= $color;
		die($this->parser->parse("eform/laporan/chartpendidikan",$data));
	}
	public function datapekerjaan($kecamatan=0,$kelurahan=0,$rw=0)
	{
		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');

	/*	$datapuskesmas = $this->laporan_kpldh_model->get_datawhere($kecamatan,'code','cl_kec');
		foreach ($datapuskesmas as $row) {
			$bar[$row->code]['puskesmas'] = $row->nama;
			$bar[$row->code]['totalorang'] = 0;
		}*/
		$totalorang = $this->laporan_kpldh_model->totaljumlah($kecamatan,$kelurahan,$rw);
		if ($totalorang!=0) {
			foreach ($totalorang as $row) {
				$bar[$row->id_kecamatan]['totalorang'] = $row->totalorang;
				$bar[$row->id_kecamatan]['puskesmas'] = $row->nama_kecamatan;
			}
		}

		$blm_sekolah = $this->laporan_kpldh_model->get_jml_pekerjaan('24',$kecamatan,$kelurahan,$rw);
		foreach ($blm_sekolah as $row) {
			$bar[$row->id_kecamatan]['petani'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalpetani'] = $row->total;
		}

		$tidak_sekolah = $this->laporan_kpldh_model->get_jml_pekerjaan('25',$kecamatan,$kelurahan,$rw);
		foreach ($tidak_sekolah as $row) {
			$bar[$row->id_kecamatan]['nelayan'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalnelayan'] = $row->total;
		}

		$tdk_tamatsd = $this->laporan_kpldh_model->get_jml_pekerjaan('26',$kecamatan,$kelurahan,$rw);
		foreach ($tdk_tamatsd as $row) {
			$bar[$row->id_kecamatan]['pnstniporli'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalpnstniporli'] = $row->total;
		}


		$masih_sd = $this->laporan_kpldh_model->get_jml_pekerjaan('27',$kecamatan,$kelurahan,$rw);
		foreach ($masih_sd as $row) {
			$bar[$row->id_kecamatan]['swasta'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalswasta'] = $row->total;
		}

		$tamat_sd = $this->laporan_kpldh_model->get_jml_pekerjaan('28',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_sd as $row) {
			$bar[$row->id_kecamatan]['wiraswasta'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalwiraswasta'] = $row->total;
		}


		$masih_smp = $this->laporan_kpldh_model->get_jml_pekerjaan('29',$kecamatan,$kelurahan,$rw);
		foreach ($masih_smp as $row) {
			$bar[$row->id_kecamatan]['pensiunan'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalpensiunan'] = $row->total;
		}

		$tamat_smp = $this->laporan_kpldh_model->get_jml_pekerjaan('30',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_smp as $row) {
			$bar[$row->id_kecamatan]['pekerjalepas'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalpekerjalepas'] = $row->total;
		}


		$masih_sma = $this->laporan_kpldh_model->get_jml_pekerjaan('31',$kecamatan,$kelurahan,$rw);
		foreach ($masih_sma as $row) {
			$bar[$row->id_kecamatan]['lainnya'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totallainnya'] = $row->total;
		}

		$tamat_sma = $this->laporan_kpldh_model->get_jml_pekerjaan('32',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_sma as $row) {
			$bar[$row->id_kecamatan]['tidakbelumkerja'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totaltidakbelumkerja'] = $row->total;
		}

		$masih_pt = $this->laporan_kpldh_model->get_jml_pekerjaan('42',$kecamatan,$kelurahan,$rw);
		foreach ($masih_pt as $row) {
			$bar[$row->id_kecamatan]['bekerja'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalbekerja'] = $row->total;
		}
		$tamat_pt = $this->laporan_kpldh_model->get_jml_pekerjaan('43',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_pt as $row) {
			$bar[$row->id_kecamatan]['belumkerja'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totalbelumkerja'] = $row->total;
		}
		$tamat_pt = $this->laporan_kpldh_model->get_jml_pekerjaan('44',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_pt as $row) {
			$bar[$row->id_kecamatan]['tidakkerja'] = $row->jumlah;
			$bar[$row->id_kecamatan]['totaltidakkerja'] = $row->total;
		}
		$tamat_pt = $this->laporan_kpldh_model->get_jml_pekerjaan('45',$kecamatan,$kelurahan,$rw);
		foreach ($tamat_pt as $row) {
			$bar[$row->id_kecamatan]['irt'] = $row->jumlah;
			$bar[$row->id_kecamatan]['irt'] = $row->total;
		}
		
		
		$data['bar']	= $bar;
		$data['color']	= $color;
		die($this->parser->parse("eform/laporan/chartpekerjaan",$data));
	}
	public function datakegiatanposyandu($kecamatan=0,$kelurahan=0,$rw=0)
	{
		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');
		
		$kecamatan = substr($this->session->userdata("puskesmas"), 0,7);
		
		$data['tdkposyandu'] = $this->laporan_kpldh_model->get_data_posyandu('1',$kecamatan,$kelurahan,$rw);
		$data['ikutposyandu']= $this->laporan_kpldh_model->get_data_posyandu('0',$kecamatan,$kelurahan,$rw);
		
		$data['jumlahorang'] = $this->laporan_kpldh_model->get_data_jmlposyandu($kecamatan,$kelurahan,$rw);
		$data['bar']	= $bar;
		//print_r($data);
		//die();
	//	print_r($bar);
	//	die();
		$data['color']	= $color;
		die($this->parser->parse("eform/laporan/chartposyandu",$data));
	}
	function datadisabilitas($kecamatan=0,$kelurahan=0,$rw=0)
	{
		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');
		
		$kecamatan = substr($this->session->userdata("puskesmas"), 0,7);
		
		$data['tdkdisabilitas'] = $this->laporan_kpldh_model->get_data_disabilitas('1',$kecamatan,$kelurahan,$rw);
		$data['disabilitas']= $this->laporan_kpldh_model->get_data_disabilitas('0',$kecamatan,$kelurahan,$rw);
		
		$data['jumlahorang'] = $this->laporan_kpldh_model->totaljmldisabilitas($kecamatan,$kelurahan,$rw);
		$data['bar']	= $bar;
		$data['color']	= $color;
		die($this->parser->parse("eform/laporan/chartdisabilitas",$data));
	}
	function datajaminankesehatan($kecamatan=0,$kelurahan=0,$rw=0)
	{
		
		//$data['data_formprofile']  = $this->dataform_model->get_data_formprofile($kode); 
		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');

		$jmljkn = $this->laporan_kpldh_model->get_data_kesehatan($kecamatan,$kelurahan,$rw);
		//$total = 0;
		foreach ($jmljkn as $row) {
			$bar[$row->nama_kecamatan]['jkn'] = $row->jkn;
			$bar[$row->nama_kecamatan]['jumlah'] = $row->jumlah;
		}
		$data['jumlahorang'] = $this->laporan_kpldh_model->jumlahorang($kecamatan,$kelurahan,$rw);
		$data['showjkn'] = $jmljkn;
		$data['bar']	= $bar;
		$data['color']	= $color;
		die($this->parser->parse("eform/laporan/chartkesehatan",$data));
	}
	function datakeikutsertaankb($kecamatan=0,$kelurahan=0,$rw=0)
	{
		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');
		
		$kecamatan = substr($this->session->userdata("puskesmas"), 0,7);
		
		$data['sedang'] = $this->laporan_kpldh_model->get_data_ikutkb('0',$kecamatan,$kelurahan,$rw);
		$data['pernah']= $this->laporan_kpldh_model->get_data_ikutkb('1',$kecamatan,$kelurahan,$rw);
		$data['tidakpernah']= $this->laporan_kpldh_model->get_data_ikutkb('2',$kecamatan,$kelurahan,$rw);
		
		$data['jumlahorang'] = $this->laporan_kpldh_model->totaljmlkb($kecamatan,$kelurahan,$rw);
		$data['bar']	= $bar;
		$data['color']	= $color;
		die($this->parser->parse("eform/laporan/chatikutkb",$data));
	}
	function dataalsantidakkb($kecamatan=0,$kelurahan=0,$rw=0)
	{
		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');
		
		$sedang_hamil = $this->laporan_kpldh_model->get_data_alasankb('berencana_II_7_berkb_hamil_cebox',$kecamatan,$kelurahan,$rw);
		foreach ($sedang_hamil as $row) {
			$bar[$kecamatan]['sedanghamil'] = $row->jumlah;
			if($row->jumlah!=0){
				$temp1=1;
			}else{
				$temp1=0;
			}
		}

		$tidak_setuju = $this->laporan_kpldh_model->get_data_alasankb('berencana_II_7_berkb_tidaksetuju_cebox',$kecamatan,$kelurahan,$rw);
		foreach ($tidak_setuju as $row) {
			$bar[$kecamatan]['tidaksetuju'] = $row->jumlah;
			if($row->jumlah!=0){
				$temp2=1;
			}else{
				$temp2=0;
			}
		}


		$tidak_tahu = $this->laporan_kpldh_model->get_data_alasankb('berencana_II_7_berkb_tidaktahu_cebox',$kecamatan,$kelurahan,$rw);
		foreach ($tidak_tahu as $row) {
			$bar[$kecamatan]['tidaktahu'] = $row->jumlah;
			if($row->jumlah!=0){
				$temp3=1;
			}else{
				$temp3=0;
			}
		}

		$takut_efekkb = $this->laporan_kpldh_model->get_data_alasankb('berencana_II_7_berkb_efeksamping_cebox',$kecamatan,$kelurahan,$rw);
		foreach ($takut_efekkb as $row) {
			$bar[$kecamatan]['takutefekkb'] = $row->jumlah;
			if($row->jumlah!=0){
				$temp4=1;
			}else{
				$temp4=0;
			}
		}


		$pelayanan_kb = $this->laporan_kpldh_model->get_data_alasankb('berencana_II_7_berkb_pelayanan_cebox',$kecamatan,$kelurahan,$rw);
		foreach ($pelayanan_kb as $row) {
			$bar[$kecamatan]['pelayanankb'] = $row->jumlah;
			if($row->jumlah!=0){
				$temp5=1;
			}else{
				$temp5=0;
			}
		}

		$mahal_kb = $this->laporan_kpldh_model->get_data_alasankb('berencana_II_7_berkb_tidakmampu_cebox',$kecamatan,$kelurahan,$rw);
		foreach ($mahal_kb as $row) {
			$bar[$kecamatan]['mahalkb'] = $row->jumlah;
			if($row->jumlah!=0){
				$temp6=1;
			}else{
				$temp6=0;
			}
		}

		$fertilasi_kb = $this->laporan_kpldh_model->get_data_alasankb('berencana_II_7_berkb_fertilasi_cebox',$kecamatan,$kelurahan,$rw);
		foreach ($fertilasi_kb as $row) {
			$bar[$kecamatan]['fertilasi'] = $row->jumlah;
			if($row->jumlah!=0){
				$temp7=1;
			}else{
				$temp7=0;
			}
		}


		$lainnya_kb = $this->laporan_kpldh_model->get_data_alasankb('berencana_II_7_berkb_lainya_cebox',$kecamatan,$kelurahan,$rw);
		foreach ($lainnya_kb as $row) {
			$bar[$kecamatan]['lainnyakb'] = $row->jumlah;
			if($row->jumlah!=0){
				$temp8=1;
			}else{
				$temp8=0;
			}
		}
		$kecamatan = substr($this->session->userdata("puskesmas"), 0,7);
		$totalorang = $this->laporan_kpldh_model->totalorang($kecamatan,$kelurahan,$rw);
		if ($totalorang!=0) {
			foreach ($totalorang as $row) {
				$bar[$kecamatan]['total'] = $temp1+$temp2+$temp3+$temp4+$temp5+$temp6+$temp7+$temp8;
				$bar[$kecamatan]['puskesmas'] = $row->nama_kecamatan;
			}
		}
		$data['jumlahorang'] = $this->laporan_kpldh_model->jumlahorang($kecamatan,$kelurahan,$rw);
		$data['bar']	= $bar;
		$data['color']	= $color;
		die($this->parser->parse("eform/laporan/chartalasankb",$data));
	}
}
