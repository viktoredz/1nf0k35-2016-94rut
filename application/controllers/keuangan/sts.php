<?php
class Sts extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('keuangan/sts_model');
	}

	function convert_tgl($tgl){
		//2015-11-12
		$dataTgl = explode('-',$tgl);
		$tgl = $dataTgl[2].'-'.$dataTgl[1].'-'.$dataTgl[0];
		return $tgl;		
	}

	function index(){
		header("location:sts/general");
	}

	function set_versi(){
		$this->authentication->verify('keuangan','edit');
		$this->session->set_userdata('versi',$this->input->post('versi'));		
	}

	function api_data_sts_general(){
		$this->authentication->verify('keuangan','add');		
		
		if(!empty($this->session->userdata('puskes')) and  $this->session->userdata('puskes') != '0'){
			$data['ambildata'] = $this->sts_model->get_data_keu_sts_general($this->session->userdata('puskes'));
			foreach($data['ambildata'] as $d){
				$txt = $this->convert_tgl($d["tgl"])." \t ".$d["nomor"]." \t ".$d["total"]." \t ".$d["status"]." \t <a href=\"".base_url()."keuangan/sts/detail/".$d['tgl']."\"><img border=0 src='".base_url()."media/images/16_edit.gif'></a>  \t".($d['status'] == "buka" ? "  <a onclick=\"doDeleteSts('".$d['tgl']."')\" href=\"#\" ><img border=0 src='".base_url()."media/images/16_del.gif'></a>" : "<img border=0 src='".base_url()."media/images/16_lock.gif'>").  "\n ";				
				echo $txt;
			}
		}		
	}
	
	function api_data_sts_detail($id){
		$this->authentication->verify('keuangan','add');		
		
		
		if(!empty($this->session->userdata('puskes')) and  $this->session->userdata('puskes') != '0'){
			$data['ambildata'] = $this->sts_model->get_data_puskesmas_isi_sts($id);
			
			foreach($data['ambildata'] as $d){
				$txt = $d["id_mst_anggaran"]." \t ".$d["id_mst_anggaran_parent"]." \t ".$d["id_mst_akun"]." \t ".$d["kode_anggaran"]." \t ".$d["uraian"]." \t ".$d["tarif"]." \t ".$d["vol"]." \t ".$d["jumlah"]."\n";				
				echo $txt;
			}
		}		
	}

	function filter_bulan(){
		if($_POST) {
			if($this->input->post('bulan') != '') {
				$this->session->set_userdata('filter_bulan',$this->input->post('bulan'));
			}
		}
	}

	function filter_tahun(){
		if($_POST) {
			if($this->input->post('tahun') != '') {
				$this->session->set_userdata('filter_tahun',$this->input->post('tahun'));
			}
		}
	}

	function json_sts(){
		$this->authentication->verify('keuangan','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl') {
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

			if($this->session->userdata('filter_bulan')!=''){
			if($this->session->userdata('filter_bulan')=="all"){

			}else{
				$this->db->where("MONTH(tgl)",$this->session->userdata('filter_bulan'));
			}
		}else{
				$this->db->where("MONTH(tgl)",date("m"));
		}
		if($this->session->userdata('filter_tahun')!=''){
			if($this->session->userdata('filter_tahun')=="all"){

			}else{
				$this->db->where("YEAR(tgl)",$this->session->userdata('filter_tahun'));
			}
		}else{
			$this->db->where("YEAR(tgl)",date("Y"));
		}

		$rows_all = $this->sts_model->get_data();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl') {
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

		if($this->session->userdata('filter_bulan')!=''){
			if($this->session->userdata('filter_bulan')=="all"){

			}else{
				$this->db->where("MONTH(tgl)",$this->session->userdata('filter_bulan'));
			}
		}else{
				$this->db->where("MONTH(tgl)",date("m"));
		}
		if($this->session->userdata('filter_tahun')!=''){
			if($this->session->userdata('filter_tahun')=="all"){

			}else{
				$this->db->where("YEAR(tgl)",$this->session->userdata('filter_tahun'));
			}
		}else{
			$this->db->where("YEAR(tgl)",date("Y"));
		}

		$rows = $this->sts_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		
		foreach($rows as $act) {
	 		$data[] = array(
				'id_sts'   => $act->id_sts,
				'tgl'	   => date("d-m-Y",strtotime($act->tgl)),
				'nomor'	   => $act->nomor,
				'total'    => $act->total,
				'status'   => ucwords($act->status),
				'edit'	   => 1,
				'delete'   => 1
			);
		}
		
		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function delete_sts($id=0){
		$this->authentication->verify('keuangan','del');

		if($this->sts_model->delete_sts($id)){
			$this->session->set_flashdata('alert', 'Delete data ('.$id.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	function add_sts(){
		$this->authentication->verify('keuangan','add');

	    $this->form_validation->set_rules('id_sts', 'ID STS', 'trim|required');
		$this->form_validation->set_rules('nomor','Nomor','trim|required');
		$this->form_validation->set_rules('tgl','Tanggal','trim|required');

		$data['id_sts']	   			    = "";
	    $data['action']					= "add";
		$data['alert_form']		   	    = '';
		$data['nomor'] 					= $this->generate_nomor(date("Y-m-d H:i:s"));		

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("keuangan/form_tambah_sts",$data));
		}elseif($this->cek_tgl_sts($this->input->post('tgl'))){
				$this->sts_model->add_sts();
			die("OK");
		}else{
			$this->session->set_flashdata('alert_form', 'Tanggal harus lebih dari tanggal terakhir input dan tidak lebih dari tanggal hari ini.');
			redirect(base_url()."keuangan/sts/add_sts");
		}
		die($this->parser->parse("keuangan/form_tambah_sts",$data));
	}

	public function kodeSts($id=0){
		$this->db->where('code',"P".$this->session->userdata('puskesmas'));
		$query = $this->db->get('cl_phc')->result();
		foreach ($query as $q) {
			$kode[] = array(
				'kodests' => $q->code, 
			);
			echo json_encode($kode);
		}
	}
	
	function generate_nomor($date){
		//120/1/IX/15
		//nomorpertahun/tgldesimal/bulanromawi/2digittahun
		$tahun = substr(date("Y",strtotime($date)),2,2);
		$dataBulan = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XII','XIII'];
		$bulan = $dataBulan[date("n", strtotime($date))-1];
		$tanggal = date("j", strtotime($date));
		
		$this->db->select('nomor');
		$this->db->where("year(tgl) = ('".date("Y",strtotime($date))."')");
		$this->db->where('code_pl_phc',$this->session->userdata('puskes'));
		$this->db->order_by('tgl','desc');
		$this->db->limit('1');
		$query=$this->db->get('keu_sts');
		$no = 1;
		if(!empty($query->result())){
			foreach($query->result() as $q ){
				$no = explode('/',$q->nomor)[0]+1;				
			}
		}
		$ready = $no."/".$tanggal."/".$bulan."/".$tahun;
		return $ready;
		
	}
	function set_puskes(){
		$this->authentication->verify('keuangan','add');
		$this->session->set_userdata('puskes',$this->input->post('puskes'));
	}

	function general(){
		$this->authentication->verify('keuangan','add');
		$data['data_puskesmas']	= $this->sts_model->get_data_puskesmas();
		$data['title_group']    = "Surat Tanda Setoran";
		$data['title_form']     = "Surat Tanda Setoran";
		$data['nomor'] 			= $this->generate_nomor(date("Y-m-d H:i:s"));		
		// $data['nama_puskes'] 	= "";
		$this->session->set_userdata('filter_bulan','');
		$this->session->set_userdata('filter_tahun','');
		$data['bulan']			= array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');

		// if(!empty($this->session->userdata('puskes')) and $this->session->userdata('puskes')!= '0'){
		// 	$data['nama_puskes'] = $this->sts_model->get_puskesmas_name($this->session->userdata('puskes'));
		// }
			
		$data['content'] = $this->parser->parse("keuangan/main_sts",$data,true);						
		
		$this->template->show($data,"home");
	}

	function detail($id){
		$this->authentication->verify('keuangan','add');
		$data['data_puskesmas']	= $this->sts_model->get_data_puskesmas();
		$data['title_group'] = "Detail Surat Tanda Setoran";
		$data['title_form'] = "Detail Surat Tanda Setoran";
		$data['data_sts'] = $this->sts_model->get_data_sts($id, $this->session->userdata('puskes'));
		$data['data_sts_total'] = $this->sts_model->get_data_sts_total($id, $this->session->userdata('puskes'));
		$data['nomor'] = $this->generate_nomor(date("Y-m-d H:i:s"));		
		$data['id'] = $id;
		$data['content'] = $this->parser->parse("keuangan/detail_sts",$data,true);		
				
		$this->template->show($data,"home");
	}	

	function cek_tgl_sts($tgl_input){
		$this->db->select('tgl');
		$this->db->order_by('tgl','desc');
		$this->db->limit('1');
		$this->db->where('code_pl_phc',$this->session->userdata('puskes'));
		$query = $this->db->get('keu_sts');
		
		$datetime = new DateTime('tomorrow');
		$tgl_besok = $datetime->format('Y-m-d');
		$besok = strtotime($tgl_besok);
		#$sekarang = strtotime(date('Y-m-d'));
		$exp = explode('-', $tgl_input);
		//11/26/2015
		$tgl_input = $exp['2'].'-'.$exp['1'].'-'.$exp['0'];
		$tgl_inp = strtotime($tgl_input);

		if(!empty($query->result())){
			foreach($query->result() as $q){				
				$sekarang = strtotime($q->tgl);
				#echo "sekarang".$sekarang." # ".$q->tgl."<br>";
				#echo "besok".$besok." # ".$tgl_besok." <br>";
				#echo "inpput".$tgl_inp." # ".$tgl_input." <br>";
				if($tgl_inp > $sekarang and $tgl_inp < $besok){
					return true;
				}else{
					return false;
				}
			}
		}else{
			return true;
		}
	}

	function reopen(){
		$this->authentication->verify('keuangan','edit');
		$this->sts_model->reopen();
		echo "buka lagi";
	}
	
	function update_volume(){		
		$this->authentication->verify('keuangan','edit');		
		echo $this->sts_model->update_volume();
	}
	
	function tutup_sts(){		
		$this->authentication->verify('keuangan','edit');		
		$this->sts_model->tutup_sts();
		$this->sts_model->rekap_sts_rekening();
		#redirect(base_url().'keuangan/sts/general', 'refresh');
	}
	
	function update_ttd(){		
		$this->authentication->verify('keuangan','edit');		
		if(empty($this->input->post('delete'))){
			$this->sts_model->update_ttd();
		}

		$this->form_validation->set_rules('ttd_pimpinan_nama', 'Nama Pimpinan', 'trim|required');
		$this->form_validation->set_rules('ttd_penerima_nama', 'Nama Penerima', 'trim|required');
		$this->form_validation->set_rules('ttd_penyetor_nama', 'Nama Penyetor', 'trim|required');
		
		$this->form_validation->set_rules('ttd_pimpinan_nip', 'NIP Pimpinan', 'trim|required');
		$this->form_validation->set_rules('ttd_penerima_nip', 'NIP Penerima', 'trim|required');
		$this->form_validation->set_rules('ttd_penyetor_nip', 'NIP Penyetor', 'trim|required');

		if($this->form_validation->run()== FALSE){
			$this->session->set_flashdata('notif_content', validation_errors());
			$this->session->set_flashdata('notif_type', 'error');
			redirect(base_url().'keuangan/sts/detail/'.$this->input->post('id_sts'));
		}else{
			
			if(!empty($this->input->post('delete'))){
				$this->sts_model->update_ttd();
				$this->tutup_sts();
				$this->session->set_flashdata('notif_type', 'closed');
				
			}else{
				$this->session->set_flashdata('notif_type', 'saved');
				
			}
			redirect(base_url().'keuangan/sts/detail/'.$this->input->post('id_sts'));
		}
		
	}

	function detail_sts_export(){

		$TBS = new clsTinyButStrong;		
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$this->authentication->verify('keuangan','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl') {
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
			$this->db->where('code_pl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows_all = $this->sts_model->get_data_for_export();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl') {
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
			$this->db->where('code_pl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$rows = $this->sts_model->get_data_for_export();

		$data_tabel = array();
		$no=1;
		foreach($rows as $act) {
			$data_tabel[] = array(
				'no' 							=> $no++,
				'id_sts'  						=> $act->id_sts,
				'tgl'	   						=> $act->tgl,
				'tarif'							=> $act->tarif,
				'vol'							=> $act->vol,
				'jumlah'						=> $act->jumlah,
				'kode_anggaran'					=> $act->kode_anggaran,
				'uraian'						=> $act->uraian,
				'detail'						=> 1,
				'edit'							=> 1,
				'delete'						=> ($act->status_permintaan=='diterima') ? 0 : 1
			);
		}
		$kode_sess=$this->session->userdata('puskesmas');
		$kd_prov = $this->inv_barang_model->get_nama('value','cl_province','code',substr($kode_sess, 0,2));
		$kd_kab  = $this->inv_barang_model->get_nama('value','cl_district','code',substr($kode_sess, 0,4));
		// $kd_kec  = 'KEC. '.$this->inv_barang_model->get_nama('nama','cl_kec','code',substr($kode_sess, 0,7));
		$namapus  = $this->inv_barang_model->get_nama('value','cl_phc','code','P'.$kode_sess);
		$tahun  = date("Y");

		$data_puskesmas[] = array('nama_puskesmas' => $namapus,'kd_prov' => $kd_prov,'kd_kab' => $kd_kab,'tahun' => $tahun);
		$dir = getcwd().'/';
		$template = $dir.'public/files/template/keuangan_sts_detail.xlsx';		
		
		$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

		// Merge data in the first sheet
		$TBS->MergeBlock('a', $data_tabel);
		$TBS->MergeBlock('b', $data_puskesmas);
		
		$code = uniqid();
		$output_file_name = 'public/files/hasil/hasil_export_keuangan_sts_detail'.$code.'.xlsx';
		$output = $dir.$output_file_name;
		$TBS->Show(OPENTBS_FILE, $output); // Also merges all [onshow] automatic fields.
		
		echo base_url().$output_file_name ;
	}

	function koderekening(){
		$this->authentication->verify('keuangan','edit');
		$data['title_group'] = "Kode Anggaran";
		$data['title_form'] = "Master Data - Kode Anggaran";

		$data['content'] = $this->parser->parse("keuangan/kode_rekening",$data,true);						

		$this->template->show($data,"home");
	}
	
	function kode_rekening_json(){
		$this->authentication->verify('keuangan','edit');


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

		$rows_all = $this->sts_model->get_data_kode_rekening_all();


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

		$rows = $this->sts_model->get_data_kode_rekening_all($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $r) {
			$data[] = array(
				'code'			=> $r->code,
				'kode_rekening'	=> $r->kode_rekening,
				'uraian'		=> $r->uraian,
				'tipe'			=> $r->tipe,
				'edit'			=> "<a onclick=\"editform('".$r->code."','".$r->kode_rekening."','".$r->uraian."','".$r->tipe."')\" data-toggle=\"modal\" data-target=\"#myModal\" href=\"#\"><img border=0 src='".base_url()."media/images/16_edit.gif'></a>",
				'delete'		=> "<a onclick=\"delete_rekening('".$r->code."')\" href=\"#\"><img border=0 src='".base_url()."media/images/16_del.gif'></a>",
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	
	
}
