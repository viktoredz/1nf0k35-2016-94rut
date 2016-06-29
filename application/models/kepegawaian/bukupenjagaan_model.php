<?php
class Bukupenjagaan_model extends CI_Model {

    var $tabel    = 'pegawai';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');

    }

    function get_datagaji($start=0,$limit=999999,$options=array())
    {
        $this->db->order_by('nama','asc');
        $this->db->select("pegawai.*,pangkat.nip_nit,pangkat.tmt,pangkat.id_mst_peg_golruang,pangkat.masa_krj_bln,pangkat.masa_krj_thn,mst_peg_golruang.ruang, '' as keterangan,gaji.gaji_baru");
        $this->db->join("(SELECT  id_pegawai,gaji_baru, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS gajiterakhi FROM
        pegawai_gaji WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_gaji GROUP BY id_pegawai)) gaji",'gaji.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_golruang",'mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
        $query = $this->db->get('pegawai',$limit,$start);
        return $query->result();
    }
    function get_data($start=0,$limit=999999,$options=array())
    {
        $this->db->order_by('nama','asc');
        $this->db->select("pegawai.*,pangkat.nip_nit,pangkat.tmt,pangkat.id_mst_peg_golruang,pangkat.masa_krj_bln,pangkat.masa_krj_thn,mst_peg_golruang.ruang, '' as keterangan");
        $this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
        $this->db->join("mst_peg_golruang",'mst_peg_golruang.id_golongan = pangkat.id_mst_peg_golruang','left');
        $query = $this->db->get('pegawai',$limit,$start);
        return $query->result();
    }
    public function getItem($start=0,$limit=999999,$options=array()){
        $this->db->order_by('mst_inv_barang_habispakai.uraian','asc');
        $this->db->select("inv_inventaris_habispakai_permintaan_item.*,mst_inv_barang_habispakai.uraian, tgl_permintaan,status_permintaan,pilihan_satuan,merek_tipe");
        $this->db->join("inv_inventaris_habispakai_permintaan",
            "inv_inventaris_habispakai_permintaan.id_inv_hasbispakai_permintaan = inv_inventaris_habispakai_permintaan_item.id_inv_hasbispakai_permintaan",
            "LEFT");
        $this->db->join("mst_inv_barang_habispakai","mst_inv_barang_habispakai.id_mst_inv_barang_habispakai=inv_inventaris_habispakai_permintaan_item.id_mst_inv_barang_habispakai","inner");
        $query = $this->db->get("inv_inventaris_habispakai_permintaan_item",$limit,$start);
        return $query->result();
    }

 	function get_data_row($kode){
		$data = array();
		$this->db->where("inv_inventaris_habispakai_permintaan.id_inv_hasbispakai_permintaan",$kode);
		$this->db->select("$this->tabel.*,mst_inv_pilihan.value");
        $this->db->join('mst_inv_pilihan', "inv_inventaris_habispakai_permintaan.status_permintaan = mst_inv_pilihan.code AND mst_inv_pilihan.tipe='status_pengadaan'",'left');
		$query = $this->db->get($this->tabel);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
    

}