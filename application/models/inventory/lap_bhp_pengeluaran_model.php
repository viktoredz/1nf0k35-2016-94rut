<?php
class Lap_bhp_pengeluaran_model extends CI_Model {

    var $tabel       = 'mst_inv_ruangan';
    var $t_puskesmas = 'cl_phc';
	var $lang	     = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    
	function get_pilihan_kondisi(){
		$this->db->select('code as id, value as val');
		$this->db->where('tipe','keadaan_barang');
		$q = $this->db->get('mst_inv_pilihan');
		return $q;
	}
	
	function get_data_permohonan($bulan,$tahun,$start=0,$limit=999999,$options=array())
    {	
    	
    	$data = array();
		for($i=1; $i<=31;$i++){
			$tanggal = date("Y-m-d",mktime(0, 0, 0, $bulan, $i, $tahun));
			$pusksmas = "P".$this->session->userdata('puskesmas');
			//$newdate = strtotime("+$i day",strtotime($tanggal));
			//$newdate = date('Y-m-d', $newdate);
			$this->db->where('code_cl_phc',$pusksmas);
			$this->db->where('tglkeluar',$tanggal);
			$query = $this->db->get("lap_bhp_pengeluaran");
	        $datas = $query->result_array();  
	       // print_r($datas);
	        foreach ($datas as $brg) {
	        	$data[$brg['uraian']][$i] = $brg;;
	        }
		}
		//die();
       	return $data;
    }
	function get_data_jenis()
    {
        $this->db->select('*');
        $query = $this->db->get('mst_inv_barang_habispakai_jenis');
        return $query->result();
    }
}
/*SELECT b.id_mst_inv_barang_habispakai,mst_inv_barang_habispakai.uraian,mst_inv_pilihan.value, 
				mst_inv_barang_habispakai.harga AS harga_asli, 
				b.harga AS harga_beli,
				tgl_update AS MONTH, SUM(jml)  AS jmlpengeluaran,
				(SELECT jml AS jml
				   FROM inv_inventaris_habispakai_opname
				   WHERE id_mst_inv_barang_habispakai=b.id_mst_inv_barang_habispakai
				     AND code_cl_phc=b.code_cl_phc
				   ORDER BY tgl_update DESC LIMIT 1) AS jmlbaik,
				(SELECT SUM(jml) AS jmltotal
				   FROM inv_inventaris_habispakai_pembelian_item
				   JOIN inv_inventaris_habispakai_pembelian ON (inv_inventaris_habispakai_pembelian.id_inv_hasbispakai_pembelian = inv_inventaris_habispakai_pembelian_item.id_inv_hasbispakai_pembelian
				                                                AND inv_inventaris_habispakai_pembelian.code_cl_phc = inv_inventaris_habispakai_pembelian_item.code_cl_phc
				                                                AND inv_inventaris_habispakai_pembelian.pilihan_status_pembelian=2)
				   WHERE inv_inventaris_habispakai_pembelian_item.code_cl_phc=b.code_cl_phc
				     AND id_mst_inv_barang_habispakai=b.id_mst_inv_barang_habispakai
				     AND inv_inventaris_habispakai_pembelian_item.tgl_update > IF(
				                                                                    (SELECT MAX(tgl_update)
				                                                                     FROM inv_inventaris_habispakai_opname
				                                                                     WHERE inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai=inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai
				                                                                       AND inv_inventaris_habispakai_pembelian_item.code_cl_phc=inv_inventaris_habispakai_opname.code_cl_phc) IS NOT NULL,
				                                                                    (SELECT MAX(tgl_update)
				                                                                     FROM inv_inventaris_habispakai_opname
				                                                                     WHERE inv_inventaris_habispakai_pembelian_item.id_mst_inv_barang_habispakai=inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai
				                                                                       AND inv_inventaris_habispakai_pembelian_item.code_cl_phc=inv_inventaris_habispakai_opname.code_cl_phc),
				                                                                    (SELECT MIN(tgl_update- INTERVAL 1 DAY)
				                                                                     FROM inv_inventaris_habispakai_pembelian_item))
				     AND inv_inventaris_habispakai_pembelian_item.tgl_update <= CURDATE()) AS totaljumlah,
				     (SELECT SUM(jml) AS jmlpeng
				   FROM inv_inventaris_habispakai_pengeluaran a
				   WHERE a.id_mst_inv_barang_habispakai=b.id_mst_inv_barang_habispakai
				     AND a.code_cl_phc=b.code_cl_phc
				     AND a.tgl_update > IF(
				                                                                 (SELECT MAX(tgl_update)
				                                                                  FROM inv_inventaris_habispakai_opname
				                                                                  WHERE a.id_mst_inv_barang_habispakai = inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai
				                                                                    AND a.code_cl_phc = inv_inventaris_habispakai_opname.code_cl_phc) IS NOT NULL,
				                                                                 (SELECT MAX(tgl_update)
				                                                                  FROM inv_inventaris_habispakai_opname
				                                                                  WHERE a.id_mst_inv_barang_habispakai = inv_inventaris_habispakai_opname.id_mst_inv_barang_habispakai
				                                                                    AND a.code_cl_phc = inv_inventaris_habispakai_opname.code_cl_phc),
				                                                                 (SELECT MIN(tgl_update - INTERVAL 1 DAY)
				                                                                  FROM inv_inventaris_habispakai_pengeluaran))
				     AND a.tgl_update <= CURDATE()
				   ORDER BY a.tgl_update DESC LIMIT 1) AS jmlpengeluaran
				     
				FROM inv_inventaris_habispakai_pengeluaran b
				JOIN mst_inv_barang_habispakai ON (mst_inv_barang_habispakai.id_mst_inv_barang_habispakai = 
				b.id_mst_inv_barang_habispakai )
				LEFT JOIN mst_inv_pilihan ON (mst_inv_barang_habispakai.pilihan_satuan=mst_inv_pilihan.code AND mst_inv_pilihan.tipe='satuan_bhp' )
				WHERE b.tgl_update >=".'"'.$tanggal.'"'." AND
				b.tgl_update <= ".'"'.$newdate.'"'."
				AND b.code_cl_phc=".'"'.$pusksmas.'"'."
				xGROUP BY b.tgl_update,b.id_mst_inv_barang_habispakai*/