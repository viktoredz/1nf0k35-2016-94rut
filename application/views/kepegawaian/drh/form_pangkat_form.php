
<form action="#" method="POST" name="frmPegawai">
  <div class="row" style="margin: 15px 5px 15px 5px">
    <div class="col-sm-8">
      <?php if(validation_errors()!=""){ ?>
      <div class="alert alert-warning alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>  <i class="icon fa fa-check"></i> Information!</h4>
        <?php echo validation_errors()?>
      </div>
      <?php } ?>

      <?php if($alert_form!=""){ ?>
      <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>  <i class="icon fa fa-check"></i> Information!</h4>
        <?php echo $alert_form?>
      </div>
      <?php } ?>
    </div>
    <div class="col-sm-12" style="text-align: right">
      <button type="button" name="btn_cpns_formal_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
      <button type="button" name="btn_cpns_formal_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Kembali</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="row" style="margin: 5px" id="showstatus">
                <div class="col-md-3" style="padding: 5px">
                  Status
                </div>
                <div class="col-md-9">
                  <select  name="statuspns" type="text" class="form-control" id="statuspns">
                    <option value=''>Pilih Status</option>
                      <?php 
                        if (empty($status)) {
                          $statuspns  = set_value('statuspns');
                        }else{
                          $statuspns = $status;
                        }
                      foreach($kode_status as $status):
                        $select = $status->kode == $statuspns ? 'selected' : '' ;
                      ?>
                        <option value="<?php echo $status->kode ?>" <?php echo $select ?>><?php echo $status->nama ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showceklispns" name="showceklispns">
              <div class="col-md-3"   ></div>
                <div class="col-md-9"   id="showceklispns" name="showceklispns">
                  <input type="checkbox" name="penganggkatan" id="penganggkatan" value="1"
                  <?php 
                    if ((set_value('penganggkatan')!="")||(isset($is_pengangkatan))) {
                      if (set_value('penganggkatan')=='1' || (isset($is_pengangkatan) && $is_pengangkatan=='1')) {
                        echo "checked";
                      }
                    }else{
                      echo "";
                    }
                  ?>
                  > Ceklist Jika Pengangkatan PNS
                </div>
              </div>
              <div class="row" style="margin: 5px" id="shownip">
                <div class="col-md-3" style="padding: 5px">
                NIP
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="nip" id="nip" placeholder="NIP" value="<?php 
                  if(set_value('nip')=="" && isset($nip_nit)){
                    echo $nip_nit;
                  }else{
                    echo  set_value('nip');
                  }
                  ?>">
                </div>
              </div>
              <div class="row" style="margin: 5px" id="shownit">
                <div class="col-md-3" style="padding: 5px">
                NIT
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="nit" id="nit" placeholder="NIT" value="<?php 
                  if(set_value('nit')=="" && isset($nip_nit)){
                    echo $nip_nit;
                  }else{
                    echo  set_value('nit');
                  }
                  ?>">
                </div>
              </div>
              <div class="row" style="margin: 5px" >
                <div class="col-md-3" style="padding: 5px">
                  Puskesmas
                </div>
                <div class="col-md-9">
                  <select  name="codepus" id="codepus" class="form-control">
                      <?php foreach($datapuskesmas as $pus) : ?>
                        <?php $select = $pus->code == $code_cl_phc ? 'selected' : '' ?>
                        <option value="<?php echo $pus->code ?>" <?php echo $select ?>><?php echo $pus->value ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showpengadaan">
                <div class="col-md-3" style="padding: 5px">
                  Jenis Pengadaan
                </div>
                <div class="col-md-9">
                  <select  name="jenis_pengadaan" type="text" class="form-control" id="jenis_pengadaan">
                    <option value=''>Pilih Jenis Pengadaan</option>
                      <?php  
                      if (empty($jenis_pengadaan)) {
                        $jenis_pengadaan  = set_value('jenis_pengadaan');
                      }else{
                        $jenis_pengadaan = $jenis_pengadaan;
                      }
                        $array_pengadaan = array_values($kode_pengadaan);
                        foreach ($array_pengadaan as $vpengadaan) {
                          $select = $vpengadaan == $jenis_pengadaan ? 'selected' : '' ;
                          echo "<option value=".$vpengadaan." $select>" .ucfirst($vpengadaan)."</option>";
                        }
                      ?>
                  </select>
                </div>
              </div>
              
              
              <div class="row" style="margin: 5px" id="showgolongan">
                <div class="col-md-3" style="padding: 5px">
                  Golongan Ruang
                </div>
                <div class="col-md-9">
                  <select  name="id_mst_peg_golruang" type="text" class="form-control" id="id_mst_peg_golruang">
                    <option value=''>Pilih CPNS/NONCPNS</option>
                      <?php 
                      if (empty($id_mst_peg_golruang)) {
                        $id_mst_peg_golruang  = set_value('id_mst_peg_golruang');
                      }else{
                        $id_mst_peg_golruang = $id_mst_peg_golruang;
                      }
                      foreach($kode_pns as $kodepns) : 
                        $select = $kodepns->id_golongan == $id_mst_peg_golruang ? 'selected' : '' ;
                      ?>
                        <option value="<?php echo $kodepns->id_golongan ?>" <?php echo $select ?>><?php echo $kodepns->id_golongan.' - '.$kodepns->ruang ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showtmt">
                <div class="col-md-3" style="padding: 5px">
                  Terhitung Mulai Tanggal
                </div>
                <div class="col-md-9">
                  <div id='tmt' name="tmt" value="<?php
                    if(set_value('tmt')=="" && isset($tmt)){
                      $tgl_tmt = strtotime($tmt);
                    }else{
                      $tgl_tmt = strtotime(set_value('tmt'));
                    }

                    if($tgl_tmt=="") $tgl_tmt = time();
                    echo date("Y-m-d",$tgl_tmt);
                  ?>"></div>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showtat">
                <div class="col-md-3" style="padding: 5px">
                  Terhitung Akhir Tanggal
                </div>
                <div class="col-md-9">
                  <div id='tat' name="tat" value="<?php
                    if(set_value('tat')=="" && isset($tat)){
                      $tgl_tat = strtotime($tat);
                    }else{
                      $tgl_tat = strtotime(set_value('tat'));
                    }

                    if($tgl_tat=="") $tgl_tat = time();
                    echo date("Y-m-d",$tgl_tat);
                  ?>" ></div>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showkepangkatan">
                <div class="col-md-3" style="padding: 5px">
                  Jenis Kepangkatan
                </div>
                <div class="col-md-9">
                  <select  name="jenis_pangkat" type="text" class="form-control" id="jenis_pangkat">
                    <option value=''>Pilih Jenis Kepangkatan</option>
                      <?php 
                      if (empty($jenis_pangkat)) {
                        $jenis_pangkat  = set_value('jenis_pangkat');
                      }else{
                        $jenis_pangkat = $jenis_pangkat;
                      } 
                        $array_pangkat = array_values($kode_pangkat);
                        foreach ($array_pangkat as $vpangkat) {
                          $select = $vpangkat == $jenis_pangkat ? 'selected' : '' ;
                          echo "<option value=".$vpangkat." $select>" .ucfirst($vpangkat)."</option>";
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showmasakerjagolongan">
                <div class="col-md-3" style="padding: 5px">
                  Masa Kerja Golongan
                </div>
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-2">
                      <select  name="masa_krj_thn" type="text" class="form-control" id="masa_krj_thn">
                        <option value=''>-</option>
                        <?php 
                        if (empty($masa_krj_thn)) {
                          $masa_krj_thn  = set_value('masa_krj_thn');
                        }else{
                          $masa_krj_thn = $masa_krj_thn;
                        }
                        for($x=1;$x<=60;$x++){
                          $select = $x == $masa_krj_thn ? 'selected' : '' ;
                        ?>
                        <option value="<?php echo $x; ?>" <?php echo $select;?>><?php printf("%02d", $x); ?></option>
                        <?php } $i++ ?>
                      </select> 
                    </div>
                    <div class="col-md-2"  style="padding: 5px">
                      Tahun
                    </div>

                    <div class="col-md-2">
                      <select  name="masa_krj_bln" id="masa_krj_bln" type="text" class="form-control">
                        <option value=''>-</option>
                        <?php 
                        if (empty($masa_krj_bln)) {
                          $masa_krj_bln  = set_value('masa_krj_bln');
                        }else{
                          $masa_krj_bln = $masa_krj_bln;
                        } 
                        for($i=1;$i<=12;$i++){
                          $select = $i == $masa_krj_bln ? 'selected' : '' ;
                        ?>
                        <option value="<?php echo $i; ?>" <?php echo $select;?>><?php printf("%02d", $i); ?></option>
                        <?php } $i++ ?>
                      </select> 
                    </div>
                    <div class="col-md-2" style="padding: 5px">
                      Bulan
                    </div>
                  </div>
                </div>
              </div>
              <div  id="showpersetujuanbkn">
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  Persetujuan Kepala BKN
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Tanggal
                </div>
                <div class="col-md-9">
                  <div id='bkn_tgl' name="bkn_tgl" value="<?php
                    if(set_value('bkn_tgl')=="" && isset($bkn_tgl)){
                      $tgl_bkn = strtotime($bkn_tgl);
                    }else{
                      $tgl_bkn = strtotime(set_value('bkn_tgl'));
                    }

                    if($tgl_bkn=="") $tgl_bkn = time();
                    echo date("Y-m-d",$tgl_bkn);
                  ?>" ></div>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Nomor
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="bkn_nomor" id="bkn_nomor" placeholder="Nomor BKN" value="<?php 
                  if(set_value('bkn_nomor')=="" && isset($bkn_nomor)){
                    echo $bkn_nomor;
                  }else{
                    echo  set_value('bkn_nomor');
                  }
                  ?>">
                </div>
              </div>
              </div>
              <div id="showkeputusan">
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  Surat Keputusan
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Tanggal
                </div>
                <div class="col-md-9">
                  <div id='sk_tgl' name="sk_tgl" value="<?php
                    if(set_value('sk_tgl')=="" && isset($sk_tgl)){
                      $tgl_sk = strtotime($sk_tgl);
                    }else{
                      $tgl_sk = strtotime(set_value('sk_tgl'));
                    }

                    if($tgl_sk=="") $tgl_sk = time();
                    echo date("Y-m-d",$tgl_sk);
                  ?>" ></div>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Nomor
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="sk_nomor" id="sk_nomor" placeholder="Nomor SK" value="<?php 
                  if(set_value('sk_nomor')=="" && isset($sk_nomor)){
                    echo $sk_nomor;
                  }else{
                    echo  set_value('sk_nomor');
                  }
                  ?>">
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Pejabat
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="sk_pejabat" id="sk_pejabat" placeholder="SK Penjabat" value="<?php 
                  if(set_value('sk_pejabat')=="" && isset($sk_pejabat)){
                    echo $sk_pejabat;
                  }else{
                    echo  set_value('sk_pejabat');
                  }
                  ?>">
                </div>
              </div>
              </div>
              <div id="showsttpl">
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  STTPL
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Tanggal
                </div>
                <div class="col-md-9">
                  <div id='sttpl_tgl' name="sttpl_tgl" value="<?php
                    if(set_value('sttpl_tgl')=="" && isset($sttpl_tgl)){
                      $tgl_sttpl = strtotime($sttpl_tgl);
                    }else{
                      $tgl_sttpl = strtotime(set_value('sttpl_tgl'));
                    }

                    if($tgl_sttpl=="") $tgl_sttpl = time();
                    echo date("Y-m-d",$tgl_sttpl);
                  ?>" ></div>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Nomor
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="sttpl_nomor" id="sttpl_nomor" placeholder="Nomor STTPL" value="<?php 
                  if(set_value('sttpl_nomor')=="" && isset($sttpl_nomor)){
                    echo $sttpl_nomor;
                  }else{
                    echo  set_value('sttpl_nomor');
                  }
                  ?>">
                </div>
              </div>
              </div>
              <div id="showspmt">
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  SPMT
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Tanggal
                </div>
                <div class="col-md-9">
                  <div id='spmt_tgl' name="spmt_tgl" value="<?php
                    if(set_value('spmt_tgl')=="" && isset($spmt_tgl)){
                      $tgl_spmt = strtotime($spmt_tgl);
                    }else{
                      $tgl_spmt = strtotime(set_value('spmt_tgl'));
                    }

                    if($tgl_spmt=="") $tgl_spmt = time();
                    echo date("Y-m-d",$tgl_spmt);
                  ?>" ></div>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Nomor
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="spmt_nomor" id="spmt_nomor" placeholder="Nomor SPMT" value="<?php 
                  if(set_value('spmt_nomor')=="" && isset($spmt_nomor)){
                    echo $spmt_nomor;
                  }else{
                    echo  set_value('spmt_nomor');
                  }
                  ?>">
                </div>
              </div>
              </div>
              <div id="showdokter">
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  Keterangan Dokter
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Tanggal
                </div>
                <div class="col-md-9">
                  <div id='dokter_tgl' name="dokter_tgl" value="<?php
                    if(set_value('dokter_tgl')=="" && isset($dokter_tgl)){
                      $tgl_dokter = strtotime($dokter_tgl);
                    }else{
                      $tgl_dokter = strtotime(set_value('dokter_tgl'));
                    }

                    if($tgl_dokter=="") $tgl_dokter = time();
                    echo date("Y-m-d",$tgl_dokter);
                  ?>" ></div>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Nomor
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="dokter_nomor" id="dokter_nomor" placeholder="Nomor BKN" value="<?php 
                  if(set_value('dokter_nomor')=="" && isset($dokter_nomor)){
                    echo $dokter_nomor;
                  }else{
                    echo  set_value('dokter_nomor');
                  }
                  ?>">
                </div>
              </div>
              </div>




              <br>
            </div>
          </div>
  </div>
</form>
<?php
if ($action=='edit') {
  $dataeble = ',disabled: true';
}else{
  $dataeble = '';
}
?>
<script>
  $(function () { 
    ambil_nip();
    showhide();
  $("#statuspns").change(function(){
    showhide();
    $('#penganggkatan').prop('checked', false);
    //alert($("#statuspns").val());
  }); 
  $("#tmt").change(function(data){
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth()+1;
    var yy = date.getFullYear();
    var tmb = $("#tmt").val().split('-');
    var thn = parseInt(tmb[2]) - parseInt(yy);
    var bln = parseInt(tmb[1]) - parseInt(month);
    //alert(tmb[1] +'  '+month);
    //alert(thn+'--'+bln);
    var hasilbln = parseInt($("#masa_krj_bln").val())+parseInt(bln);
    var hasilthn = parseInt($("#masa_krj_thn").val())+parseInt(thn);
      $("#masa_krj_thn").val(hasilthn);
      $("#masa_krj_bln").val(hasilbln);
      //alert(hasilbln+'--'+hasilthn);
  });
  cekceklis();
  function cekceklis(){
    if ($('#statuspns').val()=='PNS') {
        if ($('#penganggkatan').prop("checked") == true){
            $("#showpengadaan").hide();
            $("#shownit").hide();
            $("#shownip").show();
            $("#showgolongan").show();
            $("#showtmt").show();
            $("#showtat").hide();
            $("#showkepangkatan").hide();
            $("#showmasakerjagolongan").show();
            $("#showpersetujuanbkn").show();
            $("#showkeputusan").show();
            $("#showsttpl").show();
            $("#showspmt").hide();
            $("#showdokter").show();
        }else if($('#penganggkatan').prop("checked") == false){
            $("#showpengadaan").hide();
            $("#shownit").hide();
            $("#shownip").show();
            $("#showgolongan").show();
            $("#showtmt").show();
            $("#showtat").hide();
            $("#showkepangkatan").show();
            $("#showmasakerjagolongan").show();
            $("#showpersetujuanbkn").show();
            $("#showkeputusan").show();
            $("#showsttpl").hide();
            $("#showspmt").hide();
            $("#showdokter").hide();
        }
    }
  }
 $('#penganggkatan').click(function(){
      if($(this).prop("checked") == true){
           $("#showpengadaan").hide();
            $("#showgolongan").show();
            $("#showtmt").show();
            $("#shownit").hide();
            $("#shownip").show();
            $("#showtat").hide();
            $("#showkepangkatan").hide();
            $("#showmasakerjagolongan").show();
            $("#showpersetujuanbkn").show();
            $("#showkeputusan").show();
            $("#showsttpl").show();
            $("#showspmt").hide();
            $("#showdokter").show();
      }
      else if($(this).prop("checked") == false){
           $("#showpengadaan").hide();
            $("#showgolongan").show();
            $("#showtmt").show();
            $("#shownit").hide();
            $("#shownip").show();
            $("#showtat").hide();
            $("#showkepangkatan").show();
            $("#showmasakerjagolongan").show();
            $("#showpersetujuanbkn").show();
            $("#showkeputusan").show();
            $("#showsttpl").hide();
            $("#showspmt").hide();
            $("#showdokter").hide();
      }
  });

  function showhide(){
    if ($("#statuspns").val()=='CPNS') {
          $("#showpengadaan").show();
          $("#showceklispns").hide();
          $("#showgolongan").show();
          $("#showtmt").show();
          $("#shownit").show();
          $("#shownip").hide();
          $("#showtat").hide();
          $("#showkepangkatan").hide();
          $("#showmasakerjagolongan").show();
          $("#showpersetujuanbkn").show();
          $("#showkeputusan").show();
          $("#showsttpl").hide();
          $("#showspmt").show();
          $("#showdokter").hide();

      }else if ($("#statuspns").val()=='PNS') {
        $("#showceklispns").show();
          $("#showpengadaan").hide();
          $("#showgolongan").show();
          $("#showtmt").show();
          $("#shownit").hide();
          $("#shownip").show();
          $("#showtat").hide();
          $("#showkepangkatan").show();
          $("#showmasakerjagolongan").show();
          $("#showpersetujuanbkn").show();
          $("#showkeputusan").show();
          $("#showsttpl").hide();
          $("#showspmt").hide();
          $("#showdokter").hide();
          
      }else if ($("#statuspns").val()=='HONORER') {
        $("#showceklispns").hide();
          $("#showpengadaan").show();
          $("#showgolongan").show();
          $("#showtmt").show();
          $("#shownit").show();
          $("#shownip").hide()
          $("#showtat").show();
          $("#showkepangkatan").hide();
          $("#showmasakerjagolongan").hide();
          $("#showpersetujuanbkn").show();
          $("#showkeputusan").show();
          $("#showsttpl").hide();
          $("#showspmt").show();
          $("#showdokter").hide();
      }else if ($("#statuspns").val()=='KAT2') {
        $("#showceklispns").hide();
          $("#showpengadaan").show();
          $("#showgolongan").show();
          $("#showtmt").show();
          $("#showtat").show();
          $("#shownit").show();
          $("#shownip").hide()
          $("#showkepangkatan").hide();
          $("#showmasakerjagolongan").hide();
          $("#showpersetujuanbkn").show();
          $("#showkeputusan").show();
          $("#showsttpl").hide();
          $("#showspmt").show();
          $("#showdokter").hide();
      }else if ($("#statuspns").val()=='NRPTT') {
        $("#showceklispns").hide();
          $("#showpengadaan").show();
          $("#showgolongan").show();
          $("#showtmt").show();
          $("#showtat").show();
          $("#shownit").show();
          $("#shownip").hide()
          $("#showkepangkatan").hide();
          $("#showmasakerjagolongan").hide();
          $("#showpersetujuanbkn").show();
          $("#showkeputusan").show();
          $("#showsttpl").hide();
          $("#showspmt").show();
          $("#showdokter").hide();
      }else if ($("#statuspns").val()=='PTT') {
        $("#showceklispns").hide();
          $("#showpengadaan").show();
          $("#showgolongan").show();
          $("#showtmt").show();
          $("#shownit").show();
          $("#shownip").hide()
          $("#showtat").show();
          $("#showkepangkatan").hide();
          $("#showmasakerjagolongan").hide();
          $("#showpersetujuanbkn").show();
          $("#showkeputusan").show();
          $("#showsttpl").hide();
          $("#showspmt").show();
          $("#showdokter").hide();
      }else if ($("#statuspns").val()=='PTTPONED') {
        $("#showceklispns").hide();
          $("#showpengadaan").show();
          $("#showgolongan").show();
          $("#shownit").show();
          $("#shownip").hide()
          $("#showtmt").show();
          $("#showtat").show();
          $("#showkepangkatan").hide();
          $("#showmasakerjagolongan").hide();
          $("#showpersetujuanbkn").show();
          $("#showkeputusan").show();
          $("#showsttpl").hide();
          $("#showspmt").show();
          $("#showdokter").hide();
      }else if($("#statuspns").val()=='SUKWAN') {
        $("#showceklispns").hide();
          $("#showpengadaan").show();
          $("#showgolongan").show();
          $("#showtmt").show();
          $("#shownit").show();
          $("#shownip").hide()
          $("#showtat").show();
          $("#showkepangkatan").hide();
          $("#showmasakerjagolongan").hide();
          $("#showpersetujuanbkn").show();
          $("#showkeputusan").show();
          $("#showsttpl").hide();
          $("#showspmt").show();
          $("#showdokter").hide();
      }else{
          $("#showceklispns").hide();
          $("#showpengadaan").hide();
          $("#showgolongan").show();
          $("#showtmt").show();
          $("#shownit").show();
          $("#shownip").hide()
          $("#showtat").hide();
          $("#showkepangkatan").hide();
          $("#showmasakerjagolongan").show();
          $("#showpersetujuanbkn").show();
          $("#showkeputusan").show();
          $("#showsttpl").hide();
          $("#showspmt").hide();
          $("#showdokter").hide();
      }
  } 
    tabIndex = 1;
    $("[name='tmt']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30 <?php echo $dataeble; ?>});
    $("[name='bkn_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});
    $("[name='sk_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});
    $("[name='sttpl_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});
    $("[name='dokter_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});
    $("[name='spmt_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});
    $("[name='tat']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});


    $("[name='btn_cpns_formal_close']").click(function(){
        var peserta = "<?php echo $id; ?>";
        $.get("<?php echo base_url().'kepegawaian/drh/biodata'?>/"+'4'+'/'+peserta,function(data){
            $('#content4').html(data);
        });
    });

    $("[name='btn_cpns_formal_save']").click(function(){
      if ($("#statuspns").val()=='') {
        alert('Silahkan pilih status terlebih dahulu');
      }else{
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();
        data.append('statuspns', $("#statuspns").val());
        data.append('id_mst_peg_golruang', $("#id_mst_peg_golruang").val());
        data.append('tmt', $("#tmt").val());
        data.append('bkn_tgl', $("#bkn_tgl").val());
        data.append('bkn_nomor', $("#bkn_nomor").val());
        data.append('sk_tgl', $("#sk_tgl").val());
        data.append('sk_nomor', $("#sk_nomor").val());
        data.append('sk_pejabat', $("#sk_pejabat").val());
        data.append('codepus', $("#codepus").val());

        if ($("#statuspns").val()=='CPNS') {
          data.append('jenis_pengadaan', $("#jenis_pengadaan").val());
          data.append('masa_krj_bln', $("#masa_krj_bln").val());
          data.append('masa_krj_thn', $("#masa_krj_thn").val());
          data.append('spmt_tgl', $("#spmt_tgl").val());
          data.append('spmt_nomor', $("#spmt_nomor").val());
          data.append('nit', $("#nit").val());
      }else if ($("#statuspns").val()=='PNS') {
          if($("#penganggkatan").prop("checked") == true){
            data.append('sttpl_tgl', $("#sttpl_tgl").val());
            data.append('penganggkatan', 1);
            data.append('sttpl_nomor', $("#sttpl_nomor").val());
            data.append('dokter_tgl', $("#dokter_tgl").val());
            data.append('dokter_nomor', $("#dokter_nomor").val());  
          }else if($("#penganggkatan").prop("checked") == false){
              data.append('jenis_pangkat', $("#jenis_pangkat").val());
              data.append('penganggkatan', 0);
          } 
          data.append('nip', $("#nip").val());
          data.append('masa_krj_bln', $("#masa_krj_bln").val());
          data.append('masa_krj_thn', $("#masa_krj_thn").val());
      }else if ($("#statuspns").val()=='HONORER') {
        data.append('jenis_pengadaan', $("#jenis_pengadaan").val());
        data.append('tat', $("#tat").val());
        data.append('spmt_tgl', $("#spmt_tgl").val());
        data.append('spmt_nomor', $("#spmt_nomor").val())
        data.append('nit', $("#nit").val());
      }else if ($("#statuspns").val()=='KAT2') {
        data.append('jenis_pengadaan', $("#jenis_pengadaan").val());
        data.append('tat', $("#tat").val());
        data.append('spmt_tgl', $("#spmt_tgl").val());
        data.append('spmt_nomor', $("#spmt_nomor").val());
        data.append('nit', $("#nit").val());
      }else if ($("#statuspns").val()=='NRPTT') {
        data.append('jenis_pengadaan', $("#jenis_pengadaan").val());
        data.append('tat', $("#tat").val());
        data.append('spmt_tgl', $("#spmt_tgl").val());
        data.append('spmt_nomor', $("#spmt_nomor").val());
        data.append('nit', $("#nit").val());
      }else if ($("#statuspns").val()=='PTT') {
        data.append('jenis_pengadaan', $("#jenis_pengadaan").val());
        data.append('tat', $("#tat").val());
        data.append('spmt_tgl', $("#spmt_tgl").val());
        data.append('spmt_nomor', $("#spmt_nomor").val());
        data.append('nit', $("#nit").val());
      }else if ($("#statuspns").val()=='PTTPONED') {
        data.append('jenis_pengadaan', $("#jenis_pengadaan").val());
        data.append('tat', $("#tat").val());
        data.append('spmt_tgl', $("#spmt_tgl").val());
        data.append('spmt_nomor', $("#spmt_nomor").val());
        data.append('nit', $("#nit").val());
      }else if($("#statuspns").val()=='SUKWAN') {
        data.append('jenis_pengadaan', $("#jenis_pengadaan").val());
        data.append('tat', $("#tat").val());
        data.append('sk_tgl', $("#sk_tgl").val());
        data.append('sk_nomor', $("#sk_nomor").val());
        data.append('nit', $("#nit").val());
      }else{
          data.append('masa_krj_bln', $("#masa_krj_bln").val());
          data.append('masa_krj_thn', $("#masa_krj_thn").val());
          data.append('nit', $("#nit").val());
      }
      var halaman = $("#statuspns").val();
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."kepegawaian/drh_pangkat/$action/$id/$tmt"   ?>',
            data : data,
            success : function(response){
              res = response.split(' | ');
              if(res[0]=="OK"){
                alert("Data pangkat berhasil disimpan.");
                var peserta = "<?php echo $id; ?>";
                    $.get("<?php echo base_url().'kepegawaian/drh/biodata'?>/"+'4'+'/'+peserta,function(data){
                        $('#content4').html(data);
                    });
              }else{
                $('#content4').html(response);
              }
              ambil_nip();
            }
        });
        return false;
        }
        return false;
    });
  });

    function ambil_nip()
    {
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/drh/nipterakhir/'.$id ?>",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          $("#nipterakhir").html(elemet.nip);
        });
      }
      });

      return false;
    }
</script>
