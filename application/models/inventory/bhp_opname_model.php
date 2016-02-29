<?php
class Bhp_opname_model extends CI_Model {

    var $tabel    = 'mst_inv_barang_habispakai';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');

    }
    
    function get_data($start=0,$limit=999999,$options=array())
    {
        $kodepuskesmas = "P".$this->session->userdata("puskesmas");
        $data = array();
        $this->db->select("mst_inv_barang_habispakai.*,mst_inv_pilihan.value as value, (select jml as jml from  inv_inventaris_habispakai_opname where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jmlbaik,
            (select jml_rusak as jmlrusak from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai  and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jml_rusak,
            (select jml_tdkdipakai as jmltdkdipakai from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jml_tdkdipakai,
            (select sum(jml) as jmltotal from inv_inventaris_habispakai_pembelian_item 
            JOIN inv_inventaris_habispakai_pembelian ON(inv_inventaris_habispakai_pembelian.id_inv_hasbispakai_pembelian = inv_inventaris_habispakai_pembelian_item.id_inv_hasbispakai_pembelian AND inv_inventaris_habispakai_pembelian.code_cl_phc = inv_inventaris_habispakai_pembelian_item.code_cl_phc AND inv_inventaris_habispakai_pembelian.pilihan_status_pembelian=2)  
            where inv_inventaris_habispakai_pembelian_item.code_cl_phc=".'"'.$kodepuskesmas.'"'." and id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai ) as totaljumlah,
            (select jml as jmlpeng from  inv_inventaris_habispakai_pengeluaran where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jmlpengeluaran,
            (select tgl_update as tglupdate from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as tgl_update
             ");
        $this->db->join('mst_inv_pilihan',"mst_inv_barang_habispakai.pilihan_satuan=mst_inv_pilihan.code and mst_inv_pilihan.tipe='satuan_bhp'",'left');
        $query = $this->db->get('mst_inv_barang_habispakai',$limit,$start);
        return $query->result();
    }
    function get_data_jenis()
    {
        $this->db->select('*');
        $query = $this->db->get('mst_inv_barang_habispakai_jenis');
        return $query->result();
    }
    function get_data_detail_edit($kode){
        $data = array();
        $this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai",$kode);
        $this->db->select("mst_inv_barang_habispakai.*,mst_inv_pilihan.value as nama_satuan");
        $this->db->join('mst_inv_pilihan',"mst_inv_barang_habispakai.pilihan_satuan=mst_inv_pilihan.code and mst_inv_pilihan.tipe='satuan_bhp'",'left');
        $query = $this->db->get('mst_inv_barang_habispakai');
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }
        $query->free_result();    
        return $data;
    }
    function get_data_detail_edit_barang($kode){
        $kodepuskesmas = "P".$this->session->userdata("puskesmas");
        $data = array();
        //$this->db->order_by('inv_inventaris_habispakai_opname.tgl_update','desc');- ((select jml_rusak as jmlrusak from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai order by tgl_update desc limit 1)+(select jml_tdkdipakai as jmltdkdipakai from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai order by tgl_update desc limit 1))
        $this->db->where("mst_inv_barang_habispakai.id_mst_inv_barang_habispakai",$kode);
        $this->db->select("mst_inv_barang_habispakai.*,mst_inv_pilihan.value as nama_satuan,
            (select jml  as jumlah from inv_inventaris_habispakai_opname where id_mst_inv_barang_habispakai = mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jml,
            (select jml_rusak as jmlrusak from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jml_rusak,
            (select jml_tdkdipakai as jmltdkdipakai from  inv_inventaris_habispakai_kondisi where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jml_tdkdipakai,
            (select sum(jml) as jmltotal from inv_inventaris_habispakai_pembelian_item 
            JOIN inv_inventaris_habispakai_pembelian ON(inv_inventaris_habispakai_pembelian.id_inv_hasbispakai_pembelian = inv_inventaris_habispakai_pembelian_item.id_inv_hasbispakai_pembelian AND inv_inventaris_habispakai_pembelian.code_cl_phc = inv_inventaris_habispakai_pembelian_item.code_cl_phc AND inv_inventaris_habispakai_pembelian.pilihan_status_pembelian=2)  
            where inv_inventaris_habispakai_pembelian_item.code_cl_phc=".'"'.$kodepuskesmas.'"'." and id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai ) as totaljumlah,
            (select jml as jmlpeng from  inv_inventaris_habispakai_pengeluaran where id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as jmlpengeluaran,
            (select tgl_update  as tglupdate from inv_inventaris_habispakai_opname where id_mst_inv_barang_habispakai = mst_inv_barang_habispakai.id_mst_inv_barang_habispakai and code_cl_phc=".'"'.$kodepuskesmas.'"'." order by tgl_update desc limit 1) as tgl_update
            ");
        $this->db->join('mst_inv_pilihan',"mst_inv_barang_habispakai.pilihan_satuan=mst_inv_pilihan.code and mst_inv_pilihan.tipe='satuan_bhp'",'left');
        /*$this->db->join('inv_inventaris_habispakai_opname',"inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai=mst_inv_barang_habispakai.id_mst_inv_barang_habispakai",'left');*/
        $query = $this->db->get('mst_inv_barang_habispakai',1,0);
        if ($query->num_rows() > 0){
            $data = $query->row_array();
        }
        $query->free_result();    
        return $data;
    }
    function get_barang($kode){
        $puskesmas = 'P'.$this->session->userdata('puskesmas');
        $this->db->order_by('tgl_update','desc');
        $this->db->where("inv_inventaris_habispakai_opname.code_cl_phc",$puskesmas);
        $this->db->where("id_mst_inv_barang_habispakai",$kode);
        $this->db->select("inv_inventaris_habispakai_opname.*,
            (select sum(jml) as jmltotal from inv_inventaris_habispakai_pembelian_item 
            JOIN inv_inventaris_habispakai_pembelian ON(inv_inventaris_habispakai_pembelian.id_inv_hasbispakai_pembelian = inv_inventaris_habispakai_pembelian_item.id_inv_hasbispakai_pembelian AND inv_inventaris_habispakai_pembelian.code_cl_phc = inv_inventaris_habispakai_pembelian_item.code_cl_phc AND inv_inventaris_habispakai_pembelian.pilihan_status_pembelian=2)  
            where inv_inventaris_habispakai_pembelian_item.code_cl_phc=inv_inventaris_habispakai_opname.code_cl_phc and inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai=inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai ) as totaljumlah,
            (select jml as jmlpeng from  inv_inventaris_habispakai_pengeluaran where id_mst_inv_barang_habispakai=inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai and code_cl_phc=inv_inventaris_habispakai_opname.code_cl_phc order by tgl_update desc limit 1) as jmlpengeluaran,
            ");
        return $query = $this->db->get('inv_inventaris_habispakai_opname',3,0)->result();
    }
    function get_kondisi_barang($kode){
        $puskesmas = 'P'.$this->session->userdata('puskesmas');
        $this->db->order_by('inv_inventaris_habispakai_kondisi.tgl_update','desc');
        $this->db->where("inv_inventaris_habispakai_kondisi.code_cl_phc",$puskesmas);
        $this->db->where("inv_inventaris_habispakai_kondisi.id_mst_inv_barang_habispakai",$kode);
        $this->db->select("inv_inventaris_habispakai_kondisi.*,
            (select jml as jumlah from inv_inventaris_habispakai_opname where id_mst_inv_barang_habispakai = inv_inventaris_habispakai_kondisi.id_mst_inv_barang_habispakai and code_cl_phc=inv_inventaris_habispakai_kondisi.code_cl_phc order by tgl_update desc limit 1) as jml,
            (select sum(jml) as jmltotal from inv_inventaris_habispakai_pembelian_item 
            JOIN inv_inventaris_habispakai_pembelian ON(inv_inventaris_habispakai_pembelian.id_inv_hasbispakai_pembelian = inv_inventaris_habispakai_pembelian_item.id_inv_hasbispakai_pembelian AND inv_inventaris_habispakai_pembelian.code_cl_phc = inv_inventaris_habispakai_pembelian_item.code_cl_phc AND inv_inventaris_habispakai_pembelian.pilihan_status_pembelian=2)  
            where inv_inventaris_habispakai_pembelian_item.code_cl_phc=inv_inventaris_habispakai_kondisi.code_cl_phc and inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai=inv_inventaris_habispakai_kondisi.id_mst_inv_barang_habispakai ) as totaljumlah,
            (select jml as jmlpeng from  inv_inventaris_habispakai_pengeluaran where id_mst_inv_barang_habispakai=inv_inventaris_habispakai_kondisi.id_mst_inv_barang_habispakai and code_cl_phc=inv_inventaris_habispakai_kondisi.code_cl_phc order by tgl_update desc limit 1) as jmlpengeluaran
            ");
       /* $this->db->join('inv_inventaris_habispakai_opname',"inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai=inv_inventaris_habispakai_kondisi.id_mst_inv_barang_habispakai and inv_inventaris_habispakai_opname.code_cl_phc=inv_inventaris_habispakai_kondisi.code_cl_phc AND inv_inventaris_habispakai_opname.tgl_update = inv_inventaris_habispakai_kondisi.tgl_update");*/
        return $query = $this->db->get('inv_inventaris_habispakai_kondisi',3,0)->result();
    }
    function insertdata(){
        $this->db->where('tgl_update',date('Y-m-d'));
        $this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
        $this->db->where('id_mst_inv_barang_habispakai',$this->input->post('id_mst_inv_barang_habispakai'));
        $this->db->select("*");
        $query = $this->db->get("inv_inventaris_habispakai_opname");
           if ($query->num_rows() > 0){
                $dataupdate = array(
                    'jml' => $this->input->post('jml'),
                    'harga' => $this->input->post('harga'),
                    );
                $datakey = array(
                    'id_mst_inv_barang_habispakai'  =>$this->input->post('id_mst_inv_barang_habispakai'),
                    'code_cl_phc'                   =>'P'.$this->session->userdata('puskesmas') ,
                    'tgl_update'=> date('Y-m-d'),
                     );
                if($simpan=$this->db->update("inv_inventaris_habispakai_opname",$dataupdate,$datakey)){
                    return true;
                }else{
                    return mysql_error();
                }
            }else{
                $values = array(
                    'id_mst_inv_barang_habispakai'  =>$this->input->post('id_mst_inv_barang_habispakai'),
                    'code_cl_phc'                   =>'P'.$this->session->userdata('puskesmas') ,
                    'tgl_update'=> date('Y-m-d'),
                    'jml' => $this->input->post('jml'),
                    'harga' => $this->input->post('harga'),
                );
                if($simpan=$this->db->insert('inv_inventaris_habispakai_opname', $values)){
                    return true;
                }else{
                    return mysql_error();
                }
            }
            
    }
    function insertdatakondisi(){
        $this->db->where('tgl_update',date('Y-m-d'));
        $this->db->where('code_cl_phc','P'.$this->session->userdata('puskesmas'));
        $this->db->where('id_mst_inv_barang_habispakai',$this->input->post('id_mst_inv_barang_habispakai'));
        $this->db->select("*");
        $query = $this->db->get("inv_inventaris_habispakai_kondisi");
           if ($query->num_rows() > 0){
                $dataupdate = array(
                    'jml_rusak' => $this->input->post('jml_rusak'),
                    'jml_tdkdipakai' => $this->input->post('jml_tdkdipakai'),
                    );
                $datakey = array(
                    'id_mst_inv_barang_habispakai'  =>$this->input->post('id_mst_inv_barang_habispakai'),
                    'code_cl_phc'                   =>'P'.$this->session->userdata('puskesmas') ,
                    'tgl_update'=> date('Y-m-d'),
                     );
                if($simpan=$this->db->update("inv_inventaris_habispakai_kondisi",$dataupdate,$datakey)){
                    return true;
                }else{
                    return mysql_error();
                }
            }else{
                $values = array(
                    'id_mst_inv_barang_habispakai'  =>$this->input->post('id_mst_inv_barang_habispakai'),
                    'code_cl_phc'                   =>'P'.$this->session->userdata('puskesmas') ,
                    'tgl_update'=> date('Y-m-d'),
                    'jml_rusak' => $this->input->post('jml_rusak'),
                    'jml_tdkdipakai' => $this->input->post('jml_tdkdipakai'),
                );
                if($simpan=$this->db->insert('inv_inventaris_habispakai_kondisi', $values)){
                    return true;
                }else{
                    return mysql_error();
                }
            }
            
    }
}