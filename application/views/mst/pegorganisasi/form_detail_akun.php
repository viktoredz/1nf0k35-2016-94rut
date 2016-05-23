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
    <?php
      if ($tar_aktif=='1') {
    ?>
      <button type="button" name="non_aktifkan_status" class="btn btn-danger"><i class='fa fa-times-circle-o'></i> &nbsp; Non Aktifkan</button>
    <?php
    }else{ ?>
      <button type="button" name="aktifkan_status" class="btn btn-success"><i class='glyphicon glyphicon-ok'></i> &nbsp; Aktifkan</button>
    <?php        
    }
    ?>
      <button type="button" name="btn_keuangan_akun_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Tutup</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">

             <!-- <div class="row" style="margin: 5px">
                <div class="col-md-6" style="padding: 5px">
                  Kode Akun
                </div>
                <div class="col-md-6">
                  <input type="hidden" id="tar_id_struktur_org" value="<?php $tar_id_struktur_org;?>">
                  <?php /*
                    if(set_value('tar_id_struktur_org')=="" && isset($tar_id_struktur_org)){
                      echo $tar_id_struktur_org;
                    }else{
                      echo('-');
                    }*/
                  ?>
                </div>
              </div>-->

              <div class="row" style="margin: 5px">
                <div class="col-md-6" style="padding: 5px">
                  Nama Posisi
                </div>
                <div class="col-md-6">
                  <input type="hidden" id="tar_nama_posisi" value="<?php $tar_nama_posisi?>">
                  <?php
                    if(set_value('tar_nama_posisi')=="" && isset($tar_nama_posisi)){
                     echo $tar_nama_posisi;
                    }else{
                      echo  set_value('tar_nama_posisi');
                    }
                  ?>
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-6" style="padding: 5px">
                  Status
                </div>
                <div class="col-md-6">
                  <input disabled="disabled" type="checkbox" name="tar_aktif" id="tar_aktif" value="<?php $tar_aktif; ?>" 
                  <?php 
                  if ($tar_aktif=='1') {
                    echo 'checked';
                  }else{
                    echo '';
                  }
                  ?>
                  >
                </div>
              </div>

              <br>
            </div>
          </div>
  </div>
</form>

<script>

  $(document).ready(function () {   
    tabIndex = 1;
    $("[name='btn_keuangan_akun_close']").click(function(){
        $("#popup_keuangan_akun_detail").jqxWindow('close');
        cekstatus();
    });

    $("[name='non_aktifkan_status']").click(function(){
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/pegorganisasi/non_aktif_akun/{tar_id_struktur_org}/nonaktif"   ?>',
            success : function(response){
              if(response=="OK"){
                  $("[name='non_aktifkan_status']").show();
                $("#popup_keuangan_akun_detail").jqxWindow('close');
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }else{
                $("#popup_keuangan_akun_detail").jqxWindow('close');
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }
            }
        });
        return false;
    });
    $("[name='aktifkan_status']").click(function(){
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/pegorganisasi/non_aktif_akun/{tar_id_struktur_org}/aktip"   ?>',
            success : function(response){
              if(response=="OK"){
                  $("[name='non_aktifkan_status']").show();
                $("#popup_keuangan_akun_detail").jqxWindow('close');
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }else{
                $("#popup_keuangan_akun_detail").jqxWindow('close');
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }
            }
        });
        return false;
    });

    $("[name='akun_mendukung_target']").click(function(){
      var data = new FormData();
        data.append('mendukung_target',        $("[name='akun_mendukung_target']:checked").val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/pegorganisasi/mendukung_target_update/{id}"   ?>',
            data : data,
            success : function(response){
              a = response.split("|");
              if(a[0]=="OK"){
                if(a[1]=='1'){
                  $("#akun_mendukung_target").prop("checked", true);
                }else{
                  $("#akun_mendukung_target").prop("checked", false);
                };
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }else{
                alert("Mendukung target belum berhasil di aktifkan.");

              }
            }
        });
        return false;
    });

    $("[name='akun_mendukung_anggaran']").click(function(){
      var data = new FormData();
        data.append('mendukung_anggaran',        $("[name='akun_mendukung_anggaran']:checked").val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/pegorganisasi/mendukung_anggaran_update/{id}"   ?>',
            data : data,
            success : function(response){
              a = response.split("|");
              if(a[0]=="OK"){
                if(a[1]=='1'){
                   $("#akun_mendukung_anggaran").prop("checked", true);
                }else{
                   $("#akun_mendukung_anggaran").prop("checked", false);
                };
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }else{
                alert("Mendukung anggaran belum berhasil di aktifkan.");
              }
            }
        });
        return false;
    });

    $("[name='akun_mendukung_transaksi']").click(function(){
      var data = new FormData();
        data.append('mendukung_transaksi',        $("[name='akun_mendukung_transaksi']:checked").val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/pegorganisasi/mendukung_transaksi_update/{id}"   ?>',
            data : data,
            success : function(response){
               a = response.split("|");
              if(a[0]=="OK"){
                if (a[1]=='1') {
                    $("#akun_mendukung_transaksi").prop("checked", true);
                }else{
                    $("#akun_mendukung_transaksi").prop("checked", false);
                };
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }else{
                alert("Mendukung transaksi belum berhasil di aktifkan.");

              }
            }
        });
        return false;
    });

  });
</script>
