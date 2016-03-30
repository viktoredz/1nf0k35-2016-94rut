<?php
class Bhp_permintaan_model extends CI_Model {

    var $tabel    = 'id_inv_hasbispakai_permintaan';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');

    }

    function insertdata($kode=0){
        $this->db->where("id_inv_hasbispakai_permintaan",$this->input->post('id_permohonan_barang'));
        $this->db->where("id_mst_inv_barang_habispakai",$this->input->post('id_mst_inv_barang'));
        $cek=$this->db->get("id_inv_hasbispakai_permintaan_item");
        if ($cek->num_rows() > 0) {
            return false;
        }else{
            if(!empty($this->input->post('obat'))&&($this->input->post('obat')=="8")){
                $tgl_kadaluarsa = explode("-", $this->input->post('tgl_kadaluarsa'));
                $batch = $this->input->post('batch');
            }else{
                $tgl_kadaluarsa = explode("-", "00-00-0000");
                $batch = "-";
            }
            $values = array(
                        'id_inv_hasbispakai_permintaan'=>$this->input->post('id_permohonan_barang'),
                        'id_mst_inv_barang_habispakai'=> $this->input->post('id_mst_inv_barang'),
                        'batch' => $batch,
                        'jml' => $this->input->post('jumlah'),
                        'jml_rusak' => $this->input->post('jml_rusak'),
                        'tgl_kadaluarsa' => $tgl_kadaluarsa[2]."-".$tgl_kadaluarsa[1]."-".$tgl_kadaluarsa[0],
                        'harga' => $this->input->post('harga'),
                        'tgl_update' => $this->bhp_pengadaan_model->tanggal($kode),
                        'code_cl_phc' => 'P'.$this->session->userdata('puskesmas'),
            );
            if ($this->cekdata($values['id_mst_inv_barang_habispakai'],$values['batch'],$values['tgl_update'],$values['code_cl_phc'])==1) {
                return false;
            }else{
                if($this->db->insert('id_inv_hasbispakai_permintaan_item', $values)){
                    return true;
                }else{
                    return false;
                }
            }
        }

    }
    function cekdata($idpakai=0,$batch=0,$tgl_update=0,$code_cl_phc=0)
    {
        $this->db->where('id_mst_inv_barang_habispakai',$idpakai);
        $this->db->where('batch',$batch);
        $this->db->where('tgl_distribusi >=',$tgl_update);
        $this->db->where('code_cl_phc',$code_cl_phc);
        $query = $this->db->get('bhp_distribusi_item');
        if ($query->num_rows() > 0) {
            return 1;
        }else{
            return 0;
        }

    }
    function kode_invetaris($kode){
        $inv=explode(".", $kode);
        $kode_invetaris = $inv[0].$inv[1].$inv[2].$inv[3].$inv[4].$inv[5].$inv[6];
        $tahun          = $inv[6];
        $id_barang      = $inv[7].$inv[8].$inv[9].$inv[10].$inv[11];
        $register = $this->register($kode_invetaris,$id_barang);
        return  $kode_invetaris.$id_barang.$register;
    }

    function get_data_status()
    {   
        $this->db->where("mst_inv_pilihan.tipe",'status_pembelian');
        $this->db->select('mst_inv_pilihan.*');     
        $this->db->order_by('mst_inv_pilihan.code','asc');
        $query = $this->db->get('mst_inv_pilihan'); 
        return $query->result();    
    }
    function get_data_jenis()
    {   
        $query = $this->db->get('mst_inv_barang_habispakai_jenis'); 
        return $query->result();    
    }
    function pilih_data_status($status)
    {   
        $this->db->where("mst_inv_pilihan.tipe",$status);
        $this->db->select('mst_inv_pilihan.*');     
        $this->db->order_by('mst_inv_pilihan.code','asc');
        $query = $this->db->get('mst_inv_pilihan'); 
        return $query->result();    
    }
    function get_data_pilihan($pilih)
    {   
        $this->db->where("mst_inv_pilihan.tipe",$pilih);
        $this->db->select('mst_inv_pilihan.*');     
        $this->db->order_by('mst_inv_pilihan.code','asc');
        $query = $this->db->get('mst_inv_pilihan'); 
        return $query->result();    
    }
    function get_data($start=0,$limit=999999,$options=array())
    {
        $this->db->order_by('tgl_permohonan','desc');
        $this->db->select("mst_inv_barang_habispakai_jenis.uraian,$this->tabel.*,mst_inv_pilihan.value");
        $this->db->join('mst_inv_pilihan', "id_inv_hasbispakai_permintaan.pilihan_status_pembelian = mst_inv_pilihan.code AND mst_inv_pilihan.tipe='status_pembelian'",'left');
        $this->db->join('mst_inv_barang_habispakai_jenis', "mst_inv_barang_habispakai_jenis.id_mst_inv_barang_habispakai_jenis = id_inv_hasbispakai_permintaan.id_mst_inv_barang_habispakai_jenis",'left');
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }
    public function getItem($start=0,$limit=999999,$options=array()){
        $this->db->order_by('mst_inv_barang_habispakai.uraian','asc');
        $this->db->select("id_inv_hasbispakai_permintaan_item.*,mst_inv_barang_habispakai.uraian, tgl_distribusi",false);
        $this->db->join("bhp_distribusi_item",
            "id_inv_hasbispakai_permintaan_item.id_mst_inv_barang_habispakai = bhp_distribusi_item.id_mst_inv_barang_habispakai AND id_inv_hasbispakai_permintaan_item.batch = bhp_distribusi_item.batch AND id_inv_hasbispakai_permintaan_item.code_cl_phc = bhp_distribusi_item.code_cl_phc AND id_inv_hasbispakai_permintaan_item.tgl_update <= bhp_distribusi_item.tgl_distribusi",
            "LEFT");
        $this->db->join("mst_inv_barang_habispakai","mst_inv_barang_habispakai.id_mst_inv_barang_habispakai=id_inv_hasbispakai_permintaan_item.id_mst_inv_barang_habispakai","inner");
        $query = $this->db->get("id_inv_hasbispakai_permintaan_item",$limit,$start);
        return $query->result();
    }

 	function get_data_row($kode){
		$data = array();
		$this->db->where("id_inv_hasbispakai_permintaan.id_inv_hasbispakai_permintaan",$kode);
		$this->db->select("mst_inv_pbf.nama as nama_pbf,$this->tabel.*,mst_inv_pilihan.value");
        $this->db->join('mst_inv_pilihan', "id_inv_hasbispakai_permintaan.pilihan_status_pembelian = mst_inv_pilihan.code AND mst_inv_pilihan.tipe='status_pengadaan'",'left');
        $this->db->join('mst_inv_pbf', "mst_inv_pbf.code = id_inv_hasbispakai_permintaan.mst_inv_pbf_code",'left');
		$query = $this->db->get($this->tabel);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
    function get_data_nama($kode){
        $data = array();
        $this->db->select('*');
        $this->db->where('code',$kode);
        $query=$this->db->get('cl_phc');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }

        $query->free_result();    
        return $data;
    }
	function get_data_barang_edit($id_barang,$kd_proc,$kd_inventaris){
		$data = array();
		
        $sql="SELECT inv_inventaris_barang.*,COUNT(inv_inventaris_barang.barang_kembar_proc) AS jumlah FROM inv_inventaris_barang WHERE inv_inventaris_barang.barang_kembar_proc = (SELECT barang_kembar_proc FROM inv_inventaris_barang WHERE id_inventaris_barang= ? )";
		$query = $this->db->query($sql, array($kd_inventaris));
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
    function get_data_barang_edit_table($kd_permohonan,$id_barang){
        $data = array();
        $this->db->where('id_inv_hasbispakai_permintaan_item.id_inv_hasbispakai_permintaan',$kd_permohonan);
        $this->db->where('id_inv_hasbispakai_permintaan_item.id_mst_inv_barang_habispakai',$id_barang);
        $this->db->join("mst_inv_barang_habispakai","mst_inv_barang_habispakai.id_mst_inv_barang_habispakai=id_inv_hasbispakai_permintaan_item.id_mst_inv_barang_habispakai");
        $this->db->select("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai_jenis,id_inv_hasbispakai_permintaan_item.*,mst_inv_barang_habispakai.uraian");
        $query= $this->db->get("id_inv_hasbispakai_permintaan_item");
        
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }

        $query->free_result();    
        return $data;
    }
	public function getSelectedData($table,$data)
    {
        return $this->db->get_where($table, $data);
    }

    function get_permohonan_id($puskesmas="")
    {
    	$this->db->select('MAX(id_inv_permohonan_barang)+1 as id');
    	$this->db->where('code_cl_phc',$puskesmas);
    	$permohonan = $this->db->get('inv_permohonan_barang')->row();
    	if (empty($permohonan->id)) {
    		return 1;
    	}else {
    		return $permohonan->id;
    	}
	}
	function get_inventarisbarang_id($id,$barang,$table)
    {
    	$query  = $this->db->query("SELECT MAX(id_inventaris_barang) as id from $table WHERE id_pengadaan=$id AND id_mst_inv_barang=$barang");
        $result = $query->result();
    	if(empty($result)){
    		return 1;
    	}else {
    		foreach ($query->result() as $jum ) {
    			return $jum->id+1;
    		}
    	}

	}

   function insert_entry(){
        $data['id_inv_hasbispakai_permintaan'] = $this->kode_pengadaan($this->input->post('kode_inventaris_'));
        $data['code_cl_phc']                = $this->input->post('codepus');
        $data['id_mst_inv_barang_habispakai_jenis'] = $this->input->post('id_mst_inv_barang_habispakai_jenis');
    	$data['tgl_permohonan']	            = date("Y-m-d",strtotime($this->input->post('tgl')));
        $data['tgl_pembelian']              = date("Y-m-d",strtotime($this->input->post('tgl2')));
        $data['jenis_transaksi']            = $this->input->post('jenistransaksi');
		$data['pilihan_status_pembelian']	= $this->input->post('status');
        $data['bln_periode']                = $this->input->post('thn_periode')."-".$this->input->post('bln_periode');
        $data['thn_dana']                   = $this->input->post('thn_dana');
        $data['pilihan_sumber_dana']        = $this->input->post('pilihan_sumber_dana');
        $data['mst_inv_pbf_code']           = $this->input->post('id_mst_inv_pbf_code');
		$data['keterangan']		            = $this->input->post('keterangan');
		$data['waktu_dibuat']		        = date('Y-m-d H:i:s');
        $data['terakhir_diubah']            = "0000-00-00 00:00:00";
		$data['jumlah_unit']      	        = 0;
        $data['nilai_pembelian']            = 0;
		if($this->db->insert($this->tabel, $data)){
			return $data['id_inv_hasbispakai_permintaan'];
		}else{
			return mysql_error();
		}
    }
    function kode_pengadaan($kode){
        $inv=explode(".", $kode);
        $kode_pengadaan = $inv[0].$inv[1].$inv[2].$inv[3].$inv[4].$inv[5].$inv[6];
        $tahun          = $inv[6];
        $urut = $this->nourut($kode_pengadaan);
        return  $kode_pengadaan.$urut;
    }
    function nourut($kode_pengadaan){
        $q = $this->db->query("select MAX(RIGHT(id_inv_hasbispakai_permintaan,6)) as kd_max from id_inv_hasbispakai_permintaan where (LEFT(id_inv_hasbispakai_permintaan,15))=$kode_pengadaan");
        $nourut="";
        if($q->num_rows()>0)
        {
            foreach($q->result() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $nourut = sprintf("%06s", $tmp);
            }
        }
        else
        {
            $nourut = "000001";
        }
        return $nourut;
    }
    function tanggal($pengadaan){
        $query = $this->db->query("select tgl_pembelian from id_inv_hasbispakai_permintaan where id_inv_hasbispakai_permintaan =".'"'.$pengadaan.'"'."")->result();
        foreach ($query as $key) {
            return $key->tgl_pembelian;
        }
    }
    function update_entry($kode)
    {
        $data['jenis_transaksi']            = $this->input->post('jenis_transaksi');
        $data['keterangan']                 = $this->input->post('keterangan');
        $data['nomor_kontrak']              = $this->input->post('nomor_kontrak');
        $data['tgl_permohonan']             = date("Y-m-d",strtotime($this->input->post('tgl')));
        $data['tgl_pembelian']              = date("Y-m-d",strtotime($this->input->post('tgl2')));
        $data['tgl_kwitansi']               = date("Y-m-d",strtotime($this->input->post('tgl1')));
        $data['nomor_kwitansi']             = $this->input->post('nomor_kwitansi');
        $data['mst_inv_pbf_code']           = $this->input->post('id_mst_inv_pbf_code');
        $data['bln_periode']                = $this->input->post('thn_periode')."-".$this->input->post('bln_periode');
        $data['pilihan_sumber_dana']        = $this->input->post('pilihan_sumber_dana');
        $data['thn_dana']                   = $this->input->post('thn_dana');
        $data['pilihan_status_pembelian']   = $this->input->post('status');
        $data['terakhir_diubah']            = date('Y-m-d H:i:s');
		$this->db->where('id_inv_hasbispakai_permintaan',$kode);

		if($this->db->update($this->tabel, $data)){
            $this->db->select("*");
            $this->db->where('id_inv_hasbispakai_permintaan',$kode);
            $query = $this->db->get("id_inv_hasbispakai_permintaan_item");
            if($query->num_rows()>0){
                $dataupdateitem['tgl_update']              = date("Y-m-d",strtotime($this->input->post('tgl2')));
                $this->db->where('id_inv_hasbispakai_permintaan',$kode);
                $this->db->update("id_inv_hasbispakai_permintaan_item",$dataupdateitem);
            }
			return true;
		}else{
			return mysql_error();
		}
    }

    function tampilstatus_id($status,$tipe){
        $this->db->select('code');
        $this->db->where('value',$status);
        $this->db->where('tipe',$tipe);
        $query=$this->db->get('mst_inv_pilihan');
        if($query->num_rows()>0)
        {
            foreach($query->result() as $k)
            {
                $id = $k->code;
            }
        }
        else
        {
            $id = 1;
        }
            return  $id;
    }

    function getPilihan($tipe,$code){
        $this->db->select('value');
        $this->db->where('code',$code);
        $this->db->where('tipe',$tipe);
        $query=$this->db->get('mst_inv_pilihan')->row();
        if(!empty($query)){
            return  $query->value;
        }else{
            return $tipe;
        }
    }

    
    function sum_jumlah_item($kode,$tipe){
        $namapus = "P".$this->session->userdata('puskesmas');
    	$this->db->select_sum($tipe);
    	$this->db->where('id_inv_hasbispakai_permintaan',$kode);
        $this->db->where('code_cl_phc',$namapus);
		$query=$this->db->get('id_inv_hasbispakai_permintaan_item');
		if($query->num_rows()>0)
        {
            foreach($query->result() as $k)
            {
                $jumlah = $k->$tipe;
            }
        }
        else
        {
            $jumlah = 0;
        }
        return  $jumlah;
    }
    function sum_jumlah_item_jumlah($kode,$tipe){
        $namapus = "P".$this->session->userdata('puskesmas');
        $query=$this->db->query("SELECT SUM(jml*harga) as totalharga FROM id_inv_hasbispakai_permintaan_item WHERE id_inv_hasbispakai_permintaan = ".'"'.$kode.'"'." and code_cl_phc= ".'"'.$namapus.'"'."");
        if($query->num_rows()>0)
        {
            foreach($query->result() as $k)
            {
                $jumlah = $k->totalharga;
            }
        }
        else
        {
            $jumlah = 0;
        }
        return  $jumlah;
    }
   
    function sum_unit($kode)
    {
        $this->db->select("*");
        $this->db->where('id_inv_hasbispakai_permintaan',$kode);  
        return $query = $this->db->get("id_inv_hasbispakai_permintaan_item"); 
    }
	function delete_entry($kode)
	{
		$this->db->where('id_inv_hasbispakai_permintaan',$kode);

		return $this->db->delete('id_inv_hasbispakai_permintaan');
	}
    function jumlahtable($table,$id_inventaris_barang){

        $this->db->where('id_inventaris_barang',$id_inventaris_barang);
        $q = $this->db->get($table);
        $kd = 0;
        if($q->num_rows()>0)
        {
           $kd = $q->num_rows();
        }
        else
        {
            $kd = 0;
        }
        return $kd;
    }
	function delete_entryitem($kode,$barang,$batch)
	{  
        $this->db->where('id_inv_hasbispakai_permintaan',$kode);
        $this->db->where('id_mst_inv_barang_habispakai',$barang);
        $this->db->delete('id_inv_hasbispakai_permintaan_item');
	}
    function delete_entryitem_table($kode,$id_barang,$table)
    {    
        $this->db->where('id_pengadaan',$kode);
        $this->db->where('id_mst_inv_barang',$id_barang);
        return $this->db->delete($table);
    }
	function get_databarang($start=0,$limit=999999)
    {
		$this->db->order_by('uraian','asc');
        $query = $this->db->get('mst_inv_barang',$limit,$start);
        return $query->result();
    }
    function get_databarangwhere($obat=0)
    {
        if($obat=="8"){

        }
        $this->db->order_by('uraian','asc');
        $query = $this->db->get('mst_inv_barang');
        return $query->result();
    }
    public function getnamajenis()
    {
        $this->db->select("*");
        $query = $this->db->get("mst_inv_barang_habispakai_jenis");
        return $query->result();
    }

}