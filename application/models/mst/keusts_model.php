<?php
class Keusts_model extends CI_Model {

   var $tb    = 'mst_keu_anggaran';
   var $lang     = '';

    function __construct() {
        parent::__construct();
        $this->lang   = $this->config->item('language');
    }

    function insert_versi()
    {
        $data['nama']            = $this->input->post('nama');
        $data['deskripsi']       = $this->input->post('tlp');
        $data['tanggal_dibuat']  = $this->input->post('alamat');
    
        if($this->db->insert('mst_keu_anggaran_versi', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function insert_induk()
    {
     //   $data['id_mst_anggaran_parent'] = $this->input->post('id_mst_anggaran_parent');
        $data['id_mst_akun']            = $this->input->post('id_mst_akun');
        $data['kode_anggaran']          = $this->input->post('kode_anggaran');
        $data['uraian']                 = $this->input->post('uraian');
        $data['tarif']                  = $this->input->post('tarif');
       // $data['id_mst_anggaran_versi']  = $this->input->post('id_mst_anggaran_versi');
    
        if($this->db->insert('mst_keu_anggaran', $data)){
            return 1;
        }else{
            return mysql_error();
        }
    }

    function get_data_induk_edit($id){
        $data = array();

        $this->db->select("*");
        $this->db->where("id_keu_anggaran",$id);
        $query = $this->db->get("mst_keu_anggaran");
        if($query->num_rows()>0){
            $data = $query->row_array();
        }
        $query->free_result();
        return $data;
    }

    function update_entry_induk($id){
        $data['kode_anggaran']    = $this->input->post('nama');
        $data['uraian']           = $this->input->post('tlp');
        $data['id_mst_akun']      = $this->input->post('alamat');

        $this->db->where('id_keu_anggaran',$id);

        if($this->db->update('mst_keu_anggaran', $data)){
            return true; 
        }else{
            return mysql_error();
        }
    }

    
    function get_data()
    {
        $this->db->select('*');     
        $query = $this->db->get($this->tb);     
        return $query->result_array();
    }
    
    function get_data_sts_total($tgl, $puskes)
    {
        $this->db->select('sum(jml) as n');             
        $this->db->where('tgl',$tgl);
        $this->db->where('code_cl_phc',$puskes);
        $query = $this->db->get('keu_sts_hasil');
        foreach($query->result() as $q){
            return $q->n;
        }       
    }
    
    function get_data_sts($tgl, $puskes)
    {
        $this->db->select('*');     
        $this->db->where('tgl', $tgl);
        $this->db->where('code_cl_phc', $puskes);
        $this->db->join('cl_phc','cl_phc.code = keu_sts.code_cl_phc');
        $query = $this->db->get('keu_sts');     
        return $query->result_array();
    }   
    
    function get_data_kode_rekening()
    {
        return array();
    }

    function get_data_kode_rek()
    {
        $this->db->select('*');     
        $query = $this->db->get('mst_keu_akun');     
        return $query->result_array();
    } 

    function get_data_type_filter($ver)
    {       
        $this->db->select('id_mst_anggaran, id_mst_anggaran_parent, mst_keu_akun.id_mst_akun as akun,uraian, kode_anggaran,uraian, tarif, id_mst_anggaran_versi');        
        $this->db->join('mst_keu_akun','mst_keu_akun.id_mst_akun = mst_keu_anggaran.id_mst_akun');
        $this->db->where('id_mst_anggaran_versi', $ver);        
        $this->db->order_by('id_mst_anggaran','asc');
        $query = $this->db->get($this->tb);     
        return $query->result_array();
    }
    
    function get_data_keu_sts_general($puskes)
    {       
        $this->db->select('*');         
        $this->db->where('code_cl_phc', $puskes);       
        $this->db->order_by('tgl','desc');
        $query = $this->db->get('keu_sts');     
        return $query->result_array();
    }
    
    function get_data_puskesmas_filter($pus)
    {               
        $this->db->select('keu_anggaran.*,keu_anggaran_tarif.*,mst_keu_rekening.kode_rekening AS rekening');        
        
        #$kodepuskesmas = $this->session->userdata('puskesmas');
        $kodepuskesmas = $pus;
        if(substr($kodepuskesmas, -2)=="01"){           
            $this->db->join('keu_anggaran_tarif', "keu_anggaran_tarif.id_keu_anggaran=keu_anggaran.id_anggaran and keu_anggaran_tarif.code_cl_phc= '".$pus."'",'left');
            $this->db->where("keu_anggaran.type",'kec');
            //kecamatan
        }else{
            $this->db->join('keu_anggaran_tarif', "keu_anggaran_tarif.id_keu_anggaran=keu_anggaran.id_anggaran and keu_anggaran_tarif.code_cl_phc= '".$pus."'",'left');
            $this->db->where("keu_anggaran.type",'kel');
            //kelurahan
        }
        $this->db->join('mst_keu_rekening', "mst_keu_rekening.code=keu_anggaran.kode_rekening",'inner');
        $this->db->order_by('id_anggaran','asc');
        $query = $this->db->get('keu_anggaran');        
        return $query->result_array();
    }
    
    function get_data_puskesmas_isi_sts($id_puskesmas, $tgl)
    {               
        $this->db->select('*');     
        
        $kodepuskesmas = $this->session->userdata('puskesmas');
        $this->db->join('keu_sts_hasil',"keu_sts_hasil.id_keu_anggaran = keu_anggaran.id_anggaran and keu_sts_hasil.code_cl_phc = '".$id_puskesmas."' and tgl='".$tgl."'",'left');
        if(substr($kodepuskesmas, -2)=="01"){           
            $this->db->join('keu_anggaran_tarif', "keu_anggaran_tarif.id_keu_anggaran=keu_anggaran.id_anggaran and keu_anggaran_tarif.code_cl_phc= '".$id_puskesmas."' where keu_anggaran.type='kec'",'left');          
            //kecamatan
        }else{
            $this->db->join('keu_anggaran_tarif', "keu_anggaran_tarif.id_keu_anggaran=keu_anggaran.id_anggaran and keu_anggaran_tarif.code_cl_phc= '".$id_puskesmas."' where keu_anggaran.type='kel'",'left');
            //kelurahan
        }
        
        $this->db->order_by('id_anggaran','asc');
        $query = $this->db->get('keu_anggaran');        
        return $query->result_array();
    }
    
    function get_data_puskesmas(){
        
        $kodepuskesmas = $this->session->userdata('puskesmas');
        if(substr($kodepuskesmas, -2)=="01"){           
            //kecamatan
            
                
                $this->db->like('code','P'.substr($kodepuskesmas,0,7));
            
        }else{
            $this->db->like('code','P'.$kodepuskesmas);
            //kelurahan
        }
        
        $query = $this->db->get('cl_phc');
        return $query->result_array();
    }
    
    function cek_duplicate(){
        $this->db->select('count(id_anggaran) as n');
        $query = $this->db->get($this->tb);
        
        foreach($query->result() as $q){
                if($q->n > 0){
                    return true;
                }else{
                    return false;
                }
        }
    }
    
    function get_new_id_keu_anggaran(){
        $this->db->select('max(id_anggaran) as n');
        $query = $this->db->get($this->tb);
        
        foreach($query->result() as $q){
                return $q->n+1;
        }
    }
    
    function get_new_id_keu_anggaran_tarif(){
        $this->db->select('max(id) as n');
        $query = $this->db->get("keu_anggaran_tarif");
        
        foreach($query->result() as $q){
                return $q->n+1;
        }
    }
    
    function add_anggaran(){
        $dataExplode = explode("-",$this->input->post('kode_rekening'));
        
        $data = array(
           'id_anggaran' => $this->get_new_id_keu_anggaran(),
           'sub_id' => $this->input->post('sub_id') ,
           'kode_rekening' => $dataExplode[0],
           'kode_anggaran' => $this->input->post('kode_anggaran'),
           'uraian' => $this->input->post('uraian'),
           'type' => $this->session->userdata('tipe')
        );
        
        return $this->db->insert($this->tb, $data);             
    }
    
    function add_kode_rekening(){               
        $data = array(
           'kode_rekening' => $this->input->post('kode_rekening') ,        
           'uraian' => $this->input->post('uraian') ,          
           'tipe' => $this->input->post('tipe'),           
        );
        
        return $this->db->insert('mst_keu_rekening', $data);                
    }
    
    function update_kode_rekening(){                
        $data = array(
           'code' => $this->input->post('code') ,          
           'kode_rekening' => $this->input->post('kode_rekening') ,        
           'uraian' => $this->input->post('uraian') ,          
           'tipe' => $this->input->post('tipe'),           
        );
        $this->db->where("code",$data['code']);
        return $this->db->update('mst_keu_rekening', $data);                
    }
    
    function delete_kode_rekening(){        
        $this->db->where('code', $this->input->post('code'));
        return $this->db->delete('mst_keu_rekening');
        
    }
    
    function get_puskesmas_name($id){
        $this->db->select('value');
        $this->db->where('code', $id);
        $query = $this->db->get("cl_phc");
        if(!empty($query->result())){
            foreach($query->result() as $q){
                return $q->value;
            }
        }else{
            return "";
        }   
    }
    function add_sts(){
        $datatgl = explode('/', $this->input->post('tgl'));
        $tgl = $datatgl[2].'-'.$datatgl[0].'-'.$datatgl[1];
        $data = array(         
           'nomor' => $this->input->post('nomor') ,
           'tgl' => $tgl,                  
           'code_cl_phc' => $this->input->post('code_cl_phc') ,       
        );
        
        return $this->db->insert("keu_sts", $data);             
    }
    
    function reopen(){
        
        $data = array(         
           'status' => 'buka'
        );
        $this->db->where('tgl', $this->input->post('tgl'));
        $this->db->where('code_cl_phc', $this->input->post('code_cl_phc'));
        
        return $this->db->update("keu_sts", $data);             
    }
    
    function cek_tarif($id_anggaran){
        $this->db->select('count(id_keu_anggaran) as n, id_keu_anggaran');
        $this->db->where('id_keu_anggaran',$id_anggaran);
        $this->db->where('code_cl_phc',$this->session->userdata('puskes'));
        $query = $this->db->get('keu_anggaran_tarif');
        
        foreach($query->result() as $q){
                
                if($q->n > 0){
                    
                    return $q->id_keu_anggaran;
                }else{
                    return 0;
                }
        }
    }
    function cek_volume($tgl, $puskes, $id_keu_anggaran){
        $this->db->select('count(tgl) as n');
        $this->db->where('id_keu_anggaran', $id_keu_anggaran);
        $this->db->where('tgl', $tgl);
        $this->db->where('code_cl_phc', $puskes);
        $query = $this->db->get('keu_sts_hasil');
        
        foreach($query->result() as $q){
                if($q->n > 0){
                    return true;
                    //ready update
                }else{
                    return false;
                    // need input
                }
        }
        
    }
    function update_total_sts($tgl, $code_cl_phc, $total){
        $data=array(
            'total'=> $total
        );
        $this->db->where('tgl', $tgl);
        $this->db->where('code_cl_phc', $code_cl_phc);
        $this->db->update('keu_sts', $data);                
    }
    function update_volume(){
        $data = array(         
           'tgl' => $this->input->post('tgl'),
           'id_keu_anggaran' => $this->input->post('id_keu_anggaran'),
           'tarif' => $this->input->post('tarif'),
           'vol' => $this->input->post('vol'),
           'jml' => ($this->input->post('vol')*$this->input->post('tarif')),
           'code_cl_phc' => $this->session->userdata('puskes')
        );
        if($this->cek_volume($data['tgl'], $data['code_cl_phc'], $data['id_keu_anggaran'])){
            //update
            $this->db->where('id_keu_anggaran', $data['id_keu_anggaran']);
            $this->db->where('tgl', $data['tgl']);
            $this->db->where('code_cl_phc', $data['code_cl_phc']);
            $this->db->update('keu_sts_hasil', $data);
        }else{
            //input
            $this->db->insert('keu_sts_hasil', $data);
            
        }
        $total = $this->get_data_sts_total($data['tgl'], $data['code_cl_phc']);
        $this->update_total_sts($data['tgl'], $data['code_cl_phc'], $total);
        return $total;
        
        
    }
    function update_ttd(){
        $data = array(         
           'ttd_pimpinan_nip' => $this->input->post('ttd_pimpinan_nip'),
           'ttd_pimpinan_nama' => $this->input->post('ttd_pimpinan_nama'),
           'ttd_penerima_nip' => $this->input->post('ttd_penerima_nip'),
           'ttd_penerima_nama' => $this->input->post('ttd_penerima_nama'),
           'ttd_penyetor_nip' => $this->input->post('ttd_penyetor_nip'),
           'ttd_penyetor_nama' => $this->input->post('ttd_penyetor_nama')
        );
                
        //update
        $this->db->where('tgl', $this->input->post('tgl'));     
        $this->db->where('code_cl_phc', $this->input->post('puskes'));
        $this->db->update('keu_sts', $data);
        
    }   
    
    function tutup_sts(){
        $data = array(         
            'tgl' => $this->input->post('tgl'),
            'code_cl_phc' => $this->input->post('puskes'),
            'status' => 'tutup'
        );
                
        //update
        $this->db->where('tgl', $this->input->post('tgl'));     
        $this->db->where('code_cl_phc', $this->input->post('puskes'));
        $this->db->update('keu_sts', $data);
        
    }
    
    
    function cek_rekap_sts_rekening($tgl, $kode_rekening, $code_cl_phc){
        $this->db->select('count(tgl) as n');
        $this->db->where('tgl',$tgl);
        $this->db->where('code_mst_keu_rekening',$kode_rekening);
        $this->db->where('code_cl_phc',$code_cl_phc);
        $q = $this->db->get('keu_sts_hasil_rekap');
        foreach($q->result() as $r){
            if($r->n > 0){
                echo "update";
                return 'update';
            }else{
                echo "input";
                return 'input';
            }
        }
    }
    function rekap_sts_rekening(){
        $tgl = $this->input->post('tgl');
        $code_cl_phc = $this->input->post('puskes');
        $this->db->select("sum(jml) as total, kode_rekening, tgl, code_cl_phc ");
        $this->db->join("keu_anggaran","keu_sts_hasil.id_keu_anggaran = keu_anggaran.id_anggaran");
        $this->db->where("tgl",$tgl);
        $this->db->where("code_cl_phc",$code_cl_phc);
        $this->db->group_by("kode_rekening");
        $query=$this->db->get("keu_sts_hasil");
        
        if(!empty($query->result())){
            foreach($query->result() as $q){
                #echo $q->kode_rekening." # ".$q->total." # ".$q->code_cl_phc." # ".$q->tgl."<br>";
                
                                
                $data = array(         
                    'tgl' => $q->tgl,
                    'code_cl_phc' => $q->code_cl_phc,
                    'jml' => $q->total,
                    'code_mst_keu_rekening' => $q->kode_rekening
                );
                if($this->cek_rekap_sts_rekening($q->tgl, $q->kode_rekening, $q->code_cl_phc) == 'input'){
                    $this->db->insert('keu_sts_hasil_rekap', $data);
                }else{
                    $this->db->where('tgl',$q->tgl);
                    $this->db->where('code_mst_keu_rekening',$q->kode_rekening);
                    $this->db->where('code_cl_phc',$q->code_cl_phc);
                    $this->db->update('keu_sts_hasil_rekap', $data);
                }
                
                
                
            }
        }
    
    }
    
    function add_tarif(){
        $data = array(         
           'id_keu_anggaran' => $this->input->post('id_anggaran'),
           'tarif' => $this->input->post('tarif'),
           'code_cl_phc' => $this->session->userdata('puskes')
        );
        if($this->cek_tarif($data['id_keu_anggaran']) > 0){
            $this->db->where('keu_anggaran_tarif.id_keu_anggaran', $data['id_keu_anggaran']);
            $this->db->where('keu_anggaran_tarif.code_cl_phc', $data['code_cl_phc']);
            return $this->db->update('keu_anggaran_tarif', $data);
        }else{
            return $this->db->insert('keu_anggaran_tarif', $data);
        }
    }
    
    function update_anggaran(){
        $dataExplode = explode("-",$this->input->post('kode_rekening'));
        $data = array(
           'id_anggaran' => $this->input->post('id_anggaran') ,
           'sub_id' => $this->input->post('sub_id') ,
           'kode_rekening' => $dataExplode[0],
           'kode_anggaran' => $this->input->post('kode_anggaran'),
           'uraian' => $this->input->post('uraian'),
           'type' => $this->session->userdata('tipe')
        );
        $this->db->where('id_anggaran', $this->input->post('id_anggaran_awal'));
        return $this->db->update($this->tb, $data);             
    }
            
    function delete_anggaran(){     
        $this->db->where('id_anggaran', $this->input->post('id_anggaran'));
        $this->db->delete($this->tb);
                
        $this->db->where('sub_id', $this->input->post('id_anggaran'));
        $this->db->delete($this->tb);
        
        $this->db->where('id_keu_anggaran', $this->input->post('id_anggaran'));     
        return $this->db->delete('keu_anggaran_tarif');
    }
    
    function delete_sts($tgl){      
        $this->db->where('tgl', $tgl);
        $this->db->where('code_cl_phc', $this->session->userdata('puskes'));
        $this->db->delete('keu_sts');
        
        $this->db->where('tgl', $tgl);
        $this->db->where('code_cl_phc', $this->session->userdata('puskes'));
        $this->db->delete('keu_sts_hasil');
        
    }
    
    function get_data_kode_rekening_all($start=0,$limit=100,$options=array())
    {
        $this->db->select('*');
        $query = $this->db->get('mst_keu_akun',$limit,$start);
        return $query->result();
    }

    function get_versi_sts(){
        $this->db->select('*');
        $this->db->from('mst_keu_anggaran_versi');
        $this->db->order_by('nama','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_kode_rek(){
        $this->db->select('*');
        $this->db->from('mst_keu_akun');
        $this->db->order_by('id_mst_akun','asc');
        $query = $this->db->get();
        return $query->result();
    }
}