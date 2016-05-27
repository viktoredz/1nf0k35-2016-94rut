
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
      <button type="button" name="btn_biodata_penghargaan_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
      <button type="button" name="btn_biodata_penghargaan_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Tutup</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
             

             <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Penghargaan
                </div>
                <div class="col-md-8">
                  <select  name="id_mst_peg_penghargaan" id="id_mst_peg_penghargaan" type="text" class="form-control">
                      <?php foreach($kodepenghargaan as $peng) : ?>
                        <?php
                        if(set_value('id_mst_peg_penghargaan')=="" && isset($id_mst_peg_penghargaan)){
                          $id_mst_peg_penghargaan = $id_mst_peg_penghargaan;
                        }else{
                          $id_mst_peg_penghargaan = set_value('id_mst_peg_penghargaan');
                        }
                        $select = $peng->id_penghargaan == $id_mst_peg_penghargaan ? 'selected' : '' ;
                        ?>
                        <option value="<?php echo $peng->id_penghargaan ?>" <?php echo $select ?>><?php echo $peng->nama_penghargaan ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Tingkat
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="tingkat" id="tingkat" placeholder="Tingkat" value="<?php 
                  if(set_value('tingkat')=="" && isset($tingkat)){
                    echo $tingkat;
                  }else{
                    echo  set_value('tingkat');
                  }
                  ?>">
                </div>
              </div>

              
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nama Negara/Instansi yang Memberi
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="instansi" id="instansi" placeholder=" Nama Negara/Instansi yang Memberi" value="<?php 
                  if(set_value('instansi')=="" && isset($instansi)){
                    echo $instansi;
                  }else{
                    echo  set_value('instansi');
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
                  <input type="text" class="form-control" name="sk_no" id="sk_no" placeholder="Nomor SK" value="<?php 
                  if(set_value('sk_no')=="" && isset($sk_no)){
                    echo $sk_no;
                  }else{
                    echo  set_value('sk_no');
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


    $("[name='btn_biodata_penghargaan_close']").click(function(){
        $("#popup_keluarga_penghargaan").jqxWindow('close');
    });

    
  
    $("[name='btn_biodata_penghargaan_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();


        data.append('id_mst_peg_penghargaan', $("[name='id_mst_peg_penghargaan']").val());
        data.append('tingkat',                $("[name='tingkat']").val());
        data.append('instansi',               $("[name='instansi']").val());
        data.append('sk_tgl',                 $("[name='sk_tgl']").val());
        data.append('sk_pejabat',             $("[name='sk_pejabat']").val());
        data.append('sk_no',                  $("[name='sk_no']").val());

        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."kepegawaian/drh_penghargaan/{action}/{id}/{id_mst_peg_penghargaan}"   ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#popup_keluarga_penghargaan").jqxWindow('close');
                alert("Data Penghargaan berhasil disimpan.");
                $("#jqxgridPenghargaan").jqxGrid('updatebounddata', 'filter');
              }else if(response=="NOTOK"){
                alert("Data Sudah pernah disimpan");
              }else{
                $('#popup_keluarga_penghargaan_content').html(response);
              }
            }
        });

        return false;
    });

  });
</script>
