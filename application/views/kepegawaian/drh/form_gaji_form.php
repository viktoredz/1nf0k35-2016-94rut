
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
      <button type="button" name="btn_biodata_gaji_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
      <button type="button" name="btn_biodata_gaji_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Tutup</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
             
             <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  TMT
                </div>
                <div class="col-md-8">
                  <div id='tmt' name="tmt" value="<?php
                    if(set_value('tmt')=="" && isset($tmt)){
                      $tmt = strtotime($tmt);
                    }else{
                      $tmt = strtotime(set_value('tmt'));
                    }

                    if($tmt=="") $tmt = time();
                    echo date("Y-m-d",$tmt);
                  ?>" ></div>
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nomor Surat
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="surat_nomor" id="surat_nomor" placeholder="Nomor Surat" value="<?php 
                  if(set_value('surat_nomor')=="" && isset($surat_nomor)){
                    echo $surat_nomor;
                  }else{
                    echo  set_value('surat_nomor');
                  }
                  ?>">
                </div>
              </div>

              
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Golongan
                </div>
                <div class="col-md-8">
                  <select  name="id_mst_peg_golruang" type="text" class="form-control" id="id_mst_peg_golruang">
                    <option value=''>Pilih Golongan</option>
                      <?php 
                      if (empty($id_mst_peg_golruang)) {
                        $id_mst_peg_golruang  = set_value('id_mst_peg_golruang');
                      }else{
                        $id_mst_peg_golruang = $id_mst_peg_golruang;
                      }
                      foreach($golongan as $gol) : 
                        $select = $gol->id == $id_mst_peg_golruang ? 'selected' : '' ;
                        if($gol->id_golongan=="-"){
                          $gol->id_golongan = "";
                        }else{
                          $gol->id_golongan =  $gol->id_golongan." - ";
                        }
                      ?>
                        <option value="<?php echo $gol->id ?>" <?php echo $select ?>><?php echo $gol->id_golongan.$gol->ruang ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Masa Kerja
                </div>
                <div class="col-md-4">
                  <select  name="masa_krj_thn" type="text" class="form-control" id="masa_krj_thn">
                    <option value=''>Pilih Tahun</option>
                      <?php 
                      if (empty($masa_krj_thn)) {
                        $masa_krj_thn  = set_value('masa_krj_thn');
                      }else{
                        $masa_krj_thn = $masa_krj_thn;
                      }
                      for($i=1;$i<50;$i++){
                        $select = $i == $masa_krj_thn ? 'selected' : '' ;
                      ?>
                        <option value="<?php echo $i ?>" <?php echo $select ?>><?php echo $i ?></option>
                      <?php } ?>
                  </select>
                </div>
                <div class="col-md-4">
                  <select  name="masa_krj_bln" type="text" class="form-control" id="masa_krj_bln">
                    <option value=''>Pilih Bulan</option>
                      <?php 
                      if (empty($masa_krj_bln)) {
                        $masa_krj_bln  = set_value('masa_krj_bln');
                      }else{
                        $masa_krj_bln = $masa_krj_bln;
                      }
                      for($i=1;$i<=12;$i++){
                        $select = $i == $masa_krj_bln ? 'selected' : '' ;
                      ?>
                        <option value="<?php echo $i ?>" <?php echo $select ?>><?php echo $i ?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Gaji Lama
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="gaji_lama" id="gaji_lama" placeholder="Gaji Lama" value="<?php 
                  if(set_value('gaji_lama')=="" && isset($gaji_lama)){
                    echo $gaji_lama;
                  }else{
                    echo  set_value('gaji_lama');
                  }
                  ?>">                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="gaji_lama_pp" id="gaji_lama_pp" placeholder="PP" value="<?php 
                  if(set_value('gaji_lama_pp')=="" && isset($gaji_lama_pp)){
                    echo $gaji_lama_pp;
                  }else{
                    echo  set_value('gaji_lama_pp');
                  }
                  ?>">                
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Gaji Baru
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="gaji_baru" id="gaji_baru" placeholder="Gaji Baru" value="<?php 
                  if(set_value('gaji_baru')=="" && isset($gaji_baru)){
                    echo $gaji_baru;
                  }else{
                    echo  set_value('gaji_baru');
                  }
                  ?>">                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="gaji_baru_pp" id="gaji_baru_pp" placeholder="PP" value="<?php 
                  if(set_value('gaji_baru_pp')=="" && isset($gaji_baru_pp)){
                    echo $gaji_baru_pp;
                  }else{
                    echo  set_value('gaji_baru_pp');
                  }
                  ?>">                
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  Surat Keputusan
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px 5px 5px 30px">
                  Tanggal
                </div>
                <div class="col-md-8">
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
                <div class="col-md-4" style="padding: 5px 5px 5px 30px">
                  Nomor
                </div>
                <div class="col-md-8">
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
                <div class="col-md-4" style="padding: 5px 5px 5px 30px">
                  Pejabat
                </div>
                <div class="col-md-8">
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

              <br>
            </div>
          </div>
  </div>
</form>

<script>
  $(function () { 
    tabIndex = 1;

    $("[name='sk_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});
    $("[name='tmt']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30 <?php if($disable!="") echo ",disabled:true"?>});

    $("[name='btn_biodata_gaji_close']").click(function(){
        $("#popup_keluarga_gaji").jqxWindow('close');
    });
  
    $("[name='btn_biodata_gaji_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();


        data.append('tmt',                  $("[name='tmt']").val());
        data.append('surat_nomor',          $("[name='surat_nomor']").val());
        data.append('id_mst_peg_golruang',  $("[name='id_mst_peg_golruang']").val());
        data.append('masa_krj_thn',         $("[name='masa_krj_thn']").val());
        data.append('masa_krj_bln',         $("[name='masa_krj_bln']").val());
        data.append('gaji_lama',            $("[name='gaji_lama']").val());
        data.append('gaji_lama_pp',         $("[name='gaji_lama_pp']").val());
        data.append('gaji_baru',            $("[name='gaji_baru']").val());
        data.append('gaji_baru_pp',         $("[name='gaji_baru_pp']").val());
        data.append('sk_tgl',         $("[name='sk_tgl']").val());
        data.append('sk_pejabat',     $("[name='sk_pejabat']").val());
        data.append('sk_nomor',       $("[name='sk_nomor']").val());

        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."kepegawaian/drh_gaji/{action}/{id}/{tmt}"   ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#popup_keluarga_gaji").jqxWindow('close');
                alert("Data Gaji berhasil disimpan.");
                $("#jqxgridGaji").jqxGrid('updatebounddata', 'filter');
              }else if(response=="NOTOK"){
                alert("Data Sudah pernah disimpan");
              }else{
                $('#popup_keluarga_gaji_content').html(response);
              }
            }
        });

        return false;
    });

  });
</script>
