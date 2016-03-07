<?php
class Lap_bhp_pengadaan_model extends CI_Model {

    var $tabel       = 'mst_inv_ruangan';
    var $t_puskesmas = 'cl_phc';
	var $lang	     = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    function get_data_jenis()
    {
        $this->db->select('*');
        $query = $this->db->get('mst_inv_barang_habispakai_jenis');
        return $query->result();
    }
	function get_pilihan_kondisi(){
		$this->db->select('code as id, value as val');
		$this->db->where('tipe','keadaan_barang');
		$q = $this->db->get('mst_inv_pilihan');
		return $q;
	}
	/*$this->db->select("inv_permohonan_barang_item.*");
    	$this->db->join('inv_permohonan_barang', "inv_permohonan_barang.id_inv_permohonan_barang = inv_permohonan_barang_item.id_inv_permohonan_barang",'inner');
		$this->db->join('mst_inv_ruangan', "inv_permohonan_barang.id_mst_inv_ruangan = mst_inv_ruangan.id_mst_inv_ruangan and inv_permohonan_barang.code_cl_phc = mst_inv_ruangan.code_cl_phc ",'left');
		$this->db->join('mst_inv_pilihan', "inv_permohonan_barang.pilihan_status_pengadaan = mst_inv_pilihan.code AND mst_inv_pilihan.tipe='status_pengadaan'",'left');
		$this->db->where('inv_permohonan_barang.tanggal_permohonan >=', $this->input->post('filter_tanggal'));
		$this->db->where('inv_permohonan_barang.tanggal_permohonan <=', $this->input->post('filter_tanggal1'));
		$this->db->order_by('inv_permohonan_barang.id_inv_permohonan_barang','desc');
		$query =$this->db->get('inv_permohonan_barang_item',$limit,$start);*/
	function get_data_permohonan($start=0,$limit=999999,$options=array())
    {	
    	$tanggal1 = $this->input->post('filter_tanggal');
    	$tanggal1 = $this->input->post('filter_tanggal1');
    	$pusksmas = "P".$this->session->userdata('puskesmas');
    	
    	
		$query = $this->db->query("
			SELECT b.id_mst_inv_barang_habispakai,mst_inv_barang_habispakai.uraian,mst_inv_pilihan.value, 
			mst_inv_barang_habispakai.harga AS harga_asli, 
			b.harga AS harga_beli,
			DATE_FORMAT(tgl_update, \" %m-%Y \") AS MONTH, SUM(jml)  AS jmlpengeluaran,
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
			b.id_mst_inv_barang_habispakai AND code_cl_phc=".'"'.$pusksmas.'"'." )
			LEFT JOIN mst_inv_pilihan ON (mst_inv_barang_habispakai.pilihan_satuan=mst_inv_pilihan.code AND mst_inv_pilihan.tipe='satuan_bhp' )
			WHERE b.tgl_update >=".'"'.$tanggal1.'"'." AND
			b.tgl_update <= ".'"'.$tanggal1.'"'."
			GROUP BY DATE_FORMAT(b.tgl_update, \" %m-%Y \") ,b.id_mst_inv_barang_habispakai
		");

        return $query->result();
    }
	
}