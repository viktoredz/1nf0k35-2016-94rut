<?php
class Bhp_permintaan extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('inventory/bhp_permintaan_model');
		$this->load->model('inventory/inv_barang_model');
		$this->load->model('mst/puskesmas_model');
		$this->load->model('inventory/inv_ruangan_model');
		$this->load->model('mst/invbarang_model');
	}

	function index(){
		$this->authentication->verify('inventory','edit');
		$data['title_group'] = "Bahan Habis Pakai";
		$data['title_form'] = "Permintaan / Permohonan";

		$kodepuskesmas = $this->session->userdata('puskesmas');
		$this->db->where('code','P'.$kodepuskesmas);

		$data['datapuskesmas'] 	= $this->inv_ruangan_model->get_data_puskesmas();
		$data['content'] = $this->parser->parse("inventory/bhp_permintaan/show",$data,true);
		$this->template->show($data,"home");
	}

	function autocomplite_barang($obat=0){
		$kodepuskesmas = "P".$this->session->userdata("puskesmas");
		$search = explode("&",$this->input->server('QUERY_STRING'));
		$search = str_replace("term=","",$search[0]);
		$search = str_replace("+"," ",$search);

		$this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis",$obat);
		$this->db->like("uraian",$search);
		$this->db->order_by('id_mst_inv_barang_habispakai','asc');
		$this->db->limit(10,0);
		$this->db->select("mst_inv_barang_habispakai.*");
		$query= $this->db->get("mst_inv_barang_habispakai")->result();
		foreach ($query as $q) {
			$barang[] = array(
				'key' 		=> $q->id_mst_inv_barang_habispakai , 
				'value' 	=> $q->uraian,
				'satuan'	=>$q->pilihan_satuan, 
				
			);
		}
		echo json_encode($barang);
	}

	function autocomplite_bnf($obat=0){
		$kodepuskesmas = "P".$this->session->userdata("puskesmas");
		$search = explode("&",$this->input->server('QUERY_STRING'));
		$search = str_replace("term=","",$search[0]);
		$search = str_replace("+"," ",$search);

		//$this->db->where("id_mst_inv_barang_habispakai_jenis",$obat);
		$this->db->like("nama",$search);
		$this->db->order_by('code','asc');
		$this->db->limit(10,0);
		$this->db->select("code,nama");
		$query= $this->db->get("mst_inv_pbf")->result();
		foreach ($query as $q) {
			$barang[] = array(
				'key' 	=> $q->code, 
				'value'	=> $q->nama,
			);
		}
		echo json_encode($barang);
	}
	
	function total_permintaan($id){
		$this->db->where('id_inv_hasbispakai_pembelian',$id);
		$query = $this->db->get('inv_inventaris_habispakai_pembelian')->result();
		foreach ($query as $q) {
			$totalpermintaan[] = array(
				'jumlah_unit' => $q->jumlah_unit, 
				'nilai_permintaan' => number_format($q->nilai_pembelian,2), 
				'waktu_dibuat' => date("d-m-Y H:i:s",strtotime($q->waktu_dibuat)),
				'terakhir_diubah' => date("d-m-Y H:i:s",strtotime($q->terakhir_diubah)),
			);
			echo json_encode($totalpermintaan);
		}
    }
    
    function deskripsi($id){
    	$kodepuskesmas = "P".$this->session->userdata("puskesmas");
		$this->db->where("id_mst_inv_barang_habispakai","$id");
		$this->db->select("mst_inv_barang_habispakai.*,
			(SELECT harga AS hrg FROM inv_inventaris_habispakai_opname_item JOIN inv_inventaris_habispakai_opname ON (inv_inventaris_habispakai_opname_item.id_inv_inventaris_habispakai_opname = inv_inventaris_habispakai_opname.id_inv_inventaris_habispakai_opname)  WHERE code_cl_phc=".'"'.$kodepuskesmas.'"'." AND id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai ORDER BY tgl_opname DESC LIMIT 1) AS harga_opname,
			(select harga as hargapembelian from inv_inventaris_habispakai_pembelian_item 
            where code_cl_phc=".'"'.$kodepuskesmas.'"'." and id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai order by tgl_update desc limit 1 ) as harga_pembelian,
            (SELECT tgl_opname AS tglopname FROM inv_inventaris_habispakai_opname_item JOIN inv_inventaris_habispakai_opname ON (inv_inventaris_habispakai_opname_item.id_inv_inventaris_habispakai_opname = inv_inventaris_habispakai_opname.id_inv_inventaris_habispakai_opname) WHERE id_mst_inv_barang_habispakai = mst_inv_barang_habispakai.id_mst_inv_barang_habispakai AND code_cl_phc=".'"'.$kodepuskesmas.'"'."ORDER BY tgl_opname DESC LIMIT 1) AS tgl_opname,
            (select tgl_update  as tglpembelian from inv_inventaris_habispakai_pembelian_item where id_mst_inv_barang_habispakai = mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as tgl_pembelian");
		$query= $this->db->get("mst_inv_barang_habispakai")->result();
		foreach ($query as $q) {
			if (($q->tgl_pembelian!=null)||($q->tgl_opname!=null)) {
	          if($q->tgl_opname==null){
	            $tgl_opname = 0;
	          }else{
	            $tgl_opname = $q->tgl_opname;
	          }

	          if ($q->tgl_pembelian==null) {
	            $tgl_pembelian = 0;
	          }else{
	            $tgl_pembelian = $q->tgl_pembelian;
	          }
	          if( $tgl_pembelian>= $tgl_opname){
	            $hargabarang = $q->harga_pembelian;  
	          }else{
	            $hargabarang = $q->harga_opname;  
	          }
	        }else{
	          if ($q->harga==null) {
	            $hargaasli =0;
	          }else{
	            $hargaasli =$q->harga;
	          }

	          $hargabarang = $hargaasli;
            }
			$totalpermintaan[] = array(
				'hargabarang' 					=> $hargabarang, 
			);
			echo json_encode($totalpermintaan);
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

				if($field == 'tgl_permohonan') {
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

		$rows_all = $this->bhp_permintaan_model->get_data();


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_permohonan') {
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
		$rows = $this->bhp_permintaan_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();

		$kodepuskesmas = $this->session->userdata('puskesmas');
		if(substr($kodepuskesmas, -2)=="01"){
			$unlock = 1;
		}else{
			$unlock = 0;
		}
		
		foreach($rows as $act) {
			$data[] = array(
				'id_inv_hasbispakai_pembelian' 	=> $act->id_inv_hasbispakai_pembelian,
				'code_cl_phc' 					=> $act->code_cl_phc,
				'pilihan_status_pembelian' 		=> $act->pilihan_status_pembelian,
				'tgl_permohonan' 				=> $act->tgl_permohonan,
				'tgl_pembelian' 				=> $act->tgl_pembelian,
				'tgl_kwitansi'					=> $act->tgl_kwitansi,
				'nomor_kwitansi'				=> $act->nomor_kwitansi,
				'nomor_kontrak'					=> $act->nomor_kontrak,
				'jumlah_unit'					=> $act->jumlah_unit,
				'uraian'						=> $act->uraian,
				'nilai_pembelian'				=> $act->nilai_pembelian,
				'jumlah_unit'					=> $act->jumlah_unit,
				'nilai_pembelian'				=> number_format($act->nilai_pembelian),
				'value'							=> $act->value,
				'keterangan'					=> $act->keterangan,
				'detail'						=> 1,
				'edit'							=> 1,//$unlock,
				'delete'						=> ($act->pilihan_status_pembelian==2) ? 0 : 1
			);
		}


		
		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	public function barang($id = 0){
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
			$this->db->where('inv_inventaris_habispakai_pembelian_item.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$this->db->where('inv_inventaris_habispakai_pembelian_item.id_inv_hasbispakai_pembelian',$id);
		$rows_all_activity = $this->bhp_permintaan_model->getItem();


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
			$this->db->where('inv_inventaris_habispakai_pembelian_item.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$this->db->where('inv_inventaris_habispakai_pembelian_item.id_inv_hasbispakai_pembelian',$id);
		$activity = $this->bhp_permintaan_model->getItem($this->input->post('recordstartindex'), $this->input->post('pagesize'));
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
				'jml'									=> $act->jml,
				'batch'									=> $act->batch,
				'harga'									=> number_format($act->harga,2),
				'subtotal'								=> number_format($act->jml*$act->harga,2),
				'tgl_update'							=> $act->tgl_update,
				'jml_distribusi'						=> $act->tgl_distribusi !='' ? 1:0
			);
		}


		
		$size = sizeof($rows_all_activity);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	public function get_nama(){
		if($this->input->is_ajax_request()) {
			$code = $this->input->post('code');

			$this->db->where("code",$code);
			$kode 	= $this->invbarang_model->getSelectedData('mst_inv_barang',$code)->row();

			if(!empty($kode)) echo $kode->uraian;

			return TRUE;
		}

		show_404();
	}

	function add(){
		$this->authentication->verify('inventory','add');

		$this->form_validation->set_rules('kode_inventaris_', 'Kode Inventaris', 'trim|required');
        $this->form_validation->set_rules('tgl', 'Tanggal Permintaan', 'trim|required');
        $this->form_validation->set_rules('id_mst_inv_barang_habispakai_jenis', 'Jenis Barang', 'trim|required');
        $this->form_validation->set_rules('status', 'Status Permintaan', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			$data['title_group'] 	= "Bahan Habis Pakai";
			$data['title_form']		= "Tambah Permintaan / Permohonan";
			$data['action']			= "add";
			$data['kode']			= "";

			$kodepuskesmas = $this->session->userdata('puskesmas');
			$this->db->where('code','P'.$kodepuskesmas);
			$data['kodepuskesmas'] = $this->puskesmas_model->get_data();

			$data['kodestatus'] = $this->bhp_permintaan_model->get_data_status();
			$data['kodejenis'] = $this->bhp_permintaan_model->get_data_jenis();
		
			$data['content'] = $this->parser->parse("inventory/bhp_permintaan/form",$data,true);
		}elseif($id = $this->bhp_permintaan_model->insert_entry()){
			$this->session->set_flashdata('alert', 'Save data successful...');
			redirect(base_url().'inventory/bhp_permintaan/edit/'.$id);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."inventory/bhp_permintaan/add");
		}

		$this->template->show($data,"home");
	}

	function edit($id_permintaan=0){
		$this->authentication->verify('inventory','edit');

        $this->form_validation->set_rules('tgl', 'Tanggal Permintaan', 'trim|required');
        $this->form_validation->set_rules('id_mst_inv_barang_habispakai_jenis', 'Jenis Barang', 'trim|required');
        $this->form_validation->set_rules('status', 'Status Permintaan', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			$data 	= $this->bhp_permintaan_model->get_data_row($id_permintaan);
			$data['title_group'] 	= "Barang Habis Pakai";
			$data['title_form']		= "Ubah Permohonan/Pengadaan Barang";
			$data['action']			= "edit";
			$data['kode']			= $id_permintaan;
			$data['bulan'] 			= array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');

			
			$kodepuskesmas = $this->session->userdata('puskesmas');
			$this->db->where('code','P'.$kodepuskesmas);
			
			$data['kodepuskesmas'] 	= $this->puskesmas_model->get_data();
			$data['kodestatus'] 	= $this->bhp_permintaan_model->get_data_status();
			$data['kodestatus_inv'] = $this->bhp_permintaan_model->pilih_data_status('status_pembelian');
			$data['kodejenis'] 		= $this->bhp_permintaan_model->get_data_jenis();
			$data['kodedana'] 		= $this->bhp_permintaan_model->pilih_data_status('sumber_dana');

			$data['barang']	  	= $this->parser->parse('inventory/bhp_permintaan/barang', $data, TRUE);
			$data['content'] 	= $this->parser->parse("inventory/bhp_permintaan/edit",$data,true);
		}elseif($this->bhp_permintaan_model->update_entry($id_permintaan)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."inventory/bhp_permintaan/edit/".$id_permintaan);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."inventory/bhp_permintaan/edit/".$id_permintaan);
		}

		$this->template->show($data,"home");
	}
	function detail($id_permohonan=0){
		$this->authentication->verify('inventory','edit');
		if($this->form_validation->run()== FALSE){
			$data 	= $this->bhp_permintaan_model->get_data_row($id_permohonan);
			$data['title_group'] 	= "Barang Habis Pakai";
			$data['title_form']		= "Permohonan / Pengadaan Barang";
			$data['action']			= "view";
			$data['kode']			= $id_permohonan;
			$data['viewreadonly']	= "readonly=''";

			
			$data['unlock'] = 1;
			$data['bulan'] 			= array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
			$data['kodejenis'] = $this->bhp_permintaan_model->get_data_jenis();
			$data['kodedana'] = $this->bhp_permintaan_model->pilih_data_status('sumber_dana');
			$data['kodepuskesmas'] = $this->puskesmas_model->get_data();
			$data['kodestatus'] = $this->bhp_permintaan_model->get_data_status();
			$data['kodestatus_inv'] = $this->bhp_permintaan_model->pilih_data_status('status_pembelian');
			//$data['tgl_opnamecond']		= $this->bhp_permintaan_model->gettgl_opname($id_permohonan);
			$data['barang']	  	= $this->parser->parse('inventory/bhp_permintaan/barang', $data, TRUE);
			$data['content'] 	= $this->parser->parse("inventory/bhp_permintaan/edit",$data,true);
			$this->template->show($data,"home");
		}
	}
	function dodel($kode=0){
		$this->authentication->verify('inventory','del');

		if($this->bhp_permintaan_model->delete_entry($kode)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
			redirect(base_url()."inventory/bhp_permintaan");
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
			redirect(base_url()."inventory/bhp_permintaan");
		}
	}
	function updatestatus_barang(){
		$this->authentication->verify('inventory','edit');
		$this->bhp_permintaan_model->update_status();				
	}
	function dodelpermohonan($kode=0,$barang=0,$batch=""){
		if($this->bhp_permintaan_model->delete_entryitem($kode,$barang,$batch)){
				
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
				$dataupdate['terakhir_diubah']= date('Y-m-d H:i:s');
				$dataupdate['jumlah_unit']=  $this->bhp_permintaan_model->sum_jumlah_item( $kode,'jml');
				$dataupdate['nilai_pembelian']= $this->bhp_permintaan_model->sum_jumlah_item_jumlah( $kode,'harga');
				$key['id_inv_hasbispakai_pembelian'] = $kode;
        		$this->db->update("inv_inventaris_habispakai_pembelian",$dataupdate,$key);
	}
	function cekdelete($kode=0,$barang=0,$batch=""){
		$hasil = $this->bhp_permintaan_model->cekdelete($barang,$batch);
		if($hasil=='1'){
			die('1');
		}else{
			die('0');
		}

	}

	public function kodeInvetaris($id=0){
		$this->db->where('code',"P".$this->session->userdata('puskesmas'));
		$query = $this->db->get('cl_phc')->result();
		foreach ($query as $q) {
			$kode[] = array(
				'kodeinv' => $q->cd_kompemilikbarang.'.'.$q->cd_propinsi.'.'.$q->cd_kabkota.'.'.$q->cd_bidang.'.'.$q->cd_unitbidang.'.'.$q->cd_satuankerja, 
			);
			echo json_encode($kode);
		}
	}
	/*
	public function tanggalopnamecondisi($id='')
	{
		$query = $this->bhp_permintaan_model->gettgl_opname($id);
			$totalpermintaan[] = array(
				'tgl_opname' => date("Y-m-d",strtotime($query)), 
			);
			echo json_encode($totalpermintaan);
	}*/

	public function add_barang($kode=0,$obat=0)
	{	
		$data['action']			= "add";
		$data['kode']			= $kode;
        $this->form_validation->set_rules('id_permohonan_barang', 'Kode Barang', 'trim|required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga Satuan', 'trim|required');
        $this->form_validation->set_rules('jqxinput', 'Nama Barang', 'trim');
        $this->form_validation->set_rules('subtotal', 'subtotal', 'trim');
        $this->form_validation->set_rules('id_mst_inv_barang', 'barang', 'trim');
        if(!empty($this->input->post('obat'))&&($this->input->post('obat')=="8")){
        	$this->form_validation->set_rules('batch', 'Nomor Batch', 'trim|required');
        }

		if($this->form_validation->run()== FALSE){

			$data['kodebarang']		= $this->bhp_permintaan_model->get_databarang();
			$data['notice']			= validation_errors();
			$data['kode']			= $kode;
			$data['obat']			= $obat;
			die($this->parser->parse('inventory/bhp_permintaan/barang_form', $data));
		}else{
			if($this->bhp_permintaan_model->insertdata($kode)!=0){
				$dataupdate['terakhir_diubah']= date('Y-m-d H:i:s');
				$dataupdate['jumlah_unit']=  $this->bhp_permintaan_model->sum_jumlah_item( $kode,'jml');
				$dataupdate['nilai_pembelian']= $this->bhp_permintaan_model->sum_jumlah_item_jumlah( $kode,'harga');
				$key['id_inv_hasbispakai_pembelian'] = $kode;
        		$this->db->update("inv_inventaris_habispakai_pembelian",$dataupdate,$key);
				die("OK|Data Tersimpan");
			}else{
				 die("Error|Maaf, data tidak dapat diproses");
			}
			
		}
	}
	public function edit_barang($obat=0,$id_permohonan=0,$kd_barang=0)
	{
		$data['action']			= "edit";
		$data['kode']			= $id_permohonan;
		$this->form_validation->set_rules('id_permohonan_barang', 'Kode Barang', 'trim|required');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim|required');
        $this->form_validation->set_rules('harga', 'Harga Satuan', 'trim|required');
        $this->form_validation->set_rules('jqxinput', 'Nama Barang', 'trim');
        $this->form_validation->set_rules('subtotal', 'subtotal', 'trim');
        $this->form_validation->set_rules('id_mst_inv_barang', 'barang', 'trim');
        $this->form_validation->set_rules('jml_rusak', 'rusak', 'trim');
        if(!empty($this->input->post('obat'))&&($this->input->post('obat')=="8")){
        	$this->form_validation->set_rules('batch', 'Nomor Batch', 'trim|required');
        }
		if($this->form_validation->run()== FALSE){
			$data = $this->bhp_permintaan_model->get_data_barang_edit_table($id_permohonan,$kd_barang); 
			$data['action']			= "edit";
			$data['kode']			= $id_permohonan;
			$data['obat']			= $obat;
			$data['notice']			= validation_errors();
			
			die($this->parser->parse('inventory/bhp_permintaan/barang_form_edit', $data));
		}else{
			if(!empty($this->input->post('obat'))&&($this->input->post('obat')=='8')){
				$tgl_kadaluarsa = explode("-", $this->input->post('tgl_kadaluarsa'));
				$batch = $this->input->post('batch');
			}else{
				$tgl_kadaluarsa = explode("-", "00-00-0000");
				$batch = "-";
			}
   			$values = array(
					'jml' => $this->input->post('jumlah'),
					'harga' => $this->input->post('harga'),
					'tgl_update' => $this->bhp_permintaan_model->tanggal($id_permohonan),
					'code_cl_phc' => 'P'.$this->session->userdata('puskesmas'),
					'batch' => $batch,
					'jml_rusak' => $this->input->post('jml_rusak'),
					'tgl_kadaluarsa' => $tgl_kadaluarsa[2]."-".$tgl_kadaluarsa[1]."-".$tgl_kadaluarsa[0],
				);
   			$keyupdate = array(
					'id_inv_hasbispakai_pembelian'=>$this->input->post('id_permohonan_barang'),
					'id_mst_inv_barang_habispakai'=> $this->input->post('id_mst_inv_barang'),
   				);
			$simpan=$this->db->update('inv_inventaris_habispakai_pembelian_item', $values,$keyupdate);
			if($simpan==true){
				$dataupdate['terakhir_diubah']= date('Y-m-d H:i:s');
				$dataupdate['jumlah_unit']=  $this->bhp_permintaan_model->sum_jumlah_item( $id_permohonan,'jml');
				$dataupdate['nilai_pembelian']= $this->bhp_permintaan_model->sum_jumlah_item_jumlah( $id_permohonan,'harga');
				$key['id_inv_hasbispakai_pembelian'] = $id_permohonan;
        		$this->db->update("inv_inventaris_habispakai_pembelian",$dataupdate,$key);
				die("OK|Data Telah di Ubah");
			}else{
				 die("Error|Proses data gagal");
			}
		}
		
	}

	function dodel_barang($kode=0,$id_barang="",$table=0){
		$this->authentication->verify('inventory','del');

		if($this->bhp_permintaan_model->delete_entryitem_table($kode,$id_barang,$table)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	
	public function get_autonama() {
        $kode = $this->input->post('code_mst_inv_barang',TRUE); //variabel kunci yang di bawa dari input text id kode
        $query = $this->mkota->get_allkota(); //query model
 
        $kota       =  array();
        foreach ($query as $d) {
            $kota[]     = array(
                'label' => $d->nama_kota, //variabel array yg dibawa ke label ketikan kunci
                'nama' => $d->nama_kota , //variabel yg dibawa ke id nama
                'ibukota' => $d->ibu_kota, //variabel yang dibawa ke id ibukota
                'keterangan' => $d->keterangan //variabel yang dibawa ke id keterangan
            );
        }
        echo json_encode($kota);      //data array yang telah kota deklarasikan dibawa menggunakan json
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
			$data['pilihan_jenis_barang'] = $this->bhp_permintaan_model->getnamajenis();
			$data['pilihan_satuan_barang'] = $this->bhp_permintaan_model->pilih_data_status('satuan_bhp');
			die($this->parser->parse('inventory/bhp_permintaan/form_masterbarang', $data));
		}else{
				$values = array(
					'id_mst_inv_barang_habispakai_jenis'=> $this->input->post('id_mst_inv_barang_habispakai_jenis'),
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
