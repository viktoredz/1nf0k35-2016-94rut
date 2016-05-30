<?php
class Duk_model extends CI_Model {

    var $tabel    = 'inv_permohonan_barang';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
   
    function get_detail_ruang($id, $code_cl_phc){
		$this->db->where('id_inv_permohonan_barang',$id);
		$this->db->where('inv_permohonan_barang.code_cl_phc',$code_cl_phc);
		#$this->db->join('cl_phc','inv_permohonan_barang.code_cl_phc = cl_phc.code');
		$this->db->join('mst_inv_ruangan','inv_permohonan_barang.id_mst_inv_ruangan = mst_inv_ruangan.id_mst_inv_ruangan');
		$q = $this->db->get('inv_permohonan_barang',1);		
		return $q->result();
	}
    function get_data($grid='',$start=0,$limit=999999,$options=array())
    {	if ($grid=='export') {
            $baru = '\n';
        }else{
            $baru = '<br>';
        }
        $puskesmas_ = 'P'.$this->session->userdata('puskesmas');
        $this->db->query(" set @a:=0");
    	$this->db->select("@a:=@a+1 as no, pangkat.nip_nit,pangkat.tmt AS tmt_pangkat,pangkat.id_mst_peg_golruang,pangkat.pangkatterakhir,jabatanstruktural.jabatanterakhirstuktural,jabatanstruktural.sk_status,jabatanfungsional.jabatanterakhirfungsional,jabatanfungsional.sk_status,'' as catatanmutasi,'' as keterangan,IF(jabatanstruktural.sk_status = 'pengangkatan' AND jabatanfungsional.sk_status = 'pengangkatan', CONCAT(jabatanstruktural.tar_nama_struktural,".'"'.$baru.'"'.", jabatanfungsional.tar_nama_fungsional),(IF(jabatanstruktural.sk_status = 'pengangkatan', jabatanstruktural.tar_nama_struktural, (IF(jabatanfungsional.sk_status = 'pengangkatan', jabatanfungsional.tar_nama_fungsional, '-'))))) AS namajabatan, jabatanstruktural.tar_eselon, jabatanstruktural.tmtstruktural, jabatanfungsional.tmtfungsional, IF(jabatanstruktural.sk_status = 'pengangkatan' AND jabatanfungsional.sk_status = 'pengangkatan', CONCAT(DATE_FORMAT(jabatanstruktural.tmtstruktural, '%d-%m-%Y'), ".'"'.$baru.'"'.", DATE_FORMAT(jabatanfungsional.tmtfungsional,'%d-%m-%Y')) , (IF(jabatanstruktural.sk_status = 'pengangkatan', DATE_FORMAT(jabatanstruktural.tmtstruktural, '%d-%m-%Y'), (IF(jabatanfungsional.sk_status = 'pengangkatan', DATE_FORMAT(jabatanfungsional.tmtfungsional, '%d-%m-%Y'), '-'))))) AS tmtjabatan, pangkat.masa_krj_bln, pangkat.masa_krj_thn, diklat.diklatterakhir, diklat.nama_diklat, diklat.tgl_diklat, diklat.lama_diklat, pendidikan.nama_jurusan, pendidikan.deskripsi, CONCAT( pendidikan.nama_jurusan,' - ',pendidikan.sekolah_nama) AS namapendidikan,pendidikan.deskripsi,pendidikan.ijazah_tgl, DATE_FORMAT(pendidikan.ijazah_tgl, '%Y') AS tahunijazah, TIMESTAMPDIFF(YEAR, pegawai.tgl_lhr, CURDATE()) AS tahunumur, IF((MONTH(NOW()) - MONTH(pegawai.tgl_lhr) < 0), IF(((MONTH(NOW()) - MONTH(pegawai.tgl_lhr)) = 0), 0, ((MONTH(NOW()) - MONTH(pegawai.tgl_lhr)) + 12)), (MONTH(NOW()) - MONTH(pegawai.tgl_lhr))) AS bulanusia,pendidikan.sekolah_nama,pendidikan.id_jurusan, pegawai.*",false);
		$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat",'pangkat.id_pegawai = pegawai.id_pegawai','left');
		$this->db->join("(SELECT  id_pegawai, sk_status, tar_eselon, mst_peg_struktural.tar_nama_struktural, CONCAT(tmt, id_pegawai) AS jabatanterakhirstuktural, tmt AS tmtstruktural FROM pegawai_jabatan LEFT JOIN mst_peg_struktural ON pegawai_jabatan.id_mst_peg_struktural = mst_peg_struktural.tar_id_struktural WHERE jenis = 'STRUKTURAL' AND CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM
                pegawai_jabatan WHERE jenis = 'STRUKTURAL' GROUP BY id_pegawai)) jabatanstruktural","jabatanstruktural.id_pegawai = pegawai.id_pegawai",'left');
        $this->db->join("(SELECT  id_pegawai, sk_status, mst_peg_fungsional.tar_nama_fungsional, CONCAT(tmt, id_pegawai) AS jabatanterakhirfungsional,
            tmt AS tmtfungsional FROM pegawai_jabatan LEFT JOIN mst_peg_fungsional ON pegawai_jabatan.id_mst_peg_fungsional = mst_peg_fungsional.tar_id_fungsional WHERE jenis LIKE 'FUNGSIONAL%' AND CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_jabatan WHERE jenis LIKE 'FUNGSIONAL%' GROUP BY id_pegawai)) jabatanfungsional","jabatanfungsional.id_pegawai = pegawai.id_pegawai","left");
        $this->db->join("(SELECT  id_pegawai, CONCAT(tgl_diklat, id_pegawai) AS diklatterakhir, nama_diklat, tgl_diklat, lama_diklat FROM pegawai_diklat WHERE CONCAT(tgl_diklat, id_pegawai) IN (SELECT  CONCAT(MAX(tgl_diklat), id_pegawai) FROM pegawai_diklat GROUP BY id_pegawai)) diklat","diklat.id_pegawai = pegawai.id_pegawai","left");
        $this->db->join("(SELECT  id_pegawai, CONCAT(ijazah_tgl, id_pegawai) AS pendidikanterakhir,sekolah_nama, ijazah_tgl, mst_peg_jurusan.nama_jurusan,
            mst_peg_tingkatpendidikan.deskripsi,mst_peg_jurusan.id_jurusan FROM pegawai_pendidikan LEFT JOIN mst_peg_jurusan ON (pegawai_pendidikan.id_mst_peg_jurusan = mst_peg_jurusan.id_jurusan) LEFT JOIN mst_peg_tingkatpendidikan ON (mst_peg_jurusan.id_mst_peg_tingkatpendidikan = mst_peg_tingkatpendidikan.id_tingkat) WHERE CONCAT(ijazah_tgl, id_pegawai) IN (SELECT  CONCAT(MAX(ijazah_tgl), id_pegawai) FROM
                pegawai_pendidikan GROUP BY id_pegawai)) pendidikan","pendidikan.id_pegawai = pegawai.id_pegawai","left");
		$this->db->order_by('pangkat.id_mst_peg_golruang ','desc');
        $this->db->order_by('pangkat.masa_krj_thn  ','desc');
        $this->db->order_by('pangkat.masa_krj_bln ','desc');
        $this->db->order_by('pendidikan.id_jurusan ','desc');
        $this->db->order_by('pegawai.tgl_lhr','desc');

		$query =$this->db->get('pegawai',$limit,$start);
        return $query->result();
    }
    
}