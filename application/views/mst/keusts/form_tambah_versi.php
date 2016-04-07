
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
      <button type="button" name="btn_keuangan_versi_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
      <button type="button" name="btn_keuangan_versi_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Tutup</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
             
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                </div>
                <div class="col-md-8">
                  <input type="hidden" class="form-control" name="versi_id" id="id_mst_anggaran_versi" placeholder="ID" readonly>
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Judul Versi
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="versi_nama" placeholder=" Judul Versi " value="<?php 
                  if(set_value('nama')=="" && isset($nama)){
                    echo $nama;
                  }else{
                    echo  set_value('nama');
                  }
                  ?>">
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Deskripsi
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="versi_deskripsi" placeholder=" Deskripsi " value="<?php 
                  if(set_value('deskripsi')=="" && isset($deskripsi)){
                    echo $deskripsi;
                  }else{
                    echo  set_value('deskripsi');
                  }
                  ?>">
                </div>
              </div>

              <br>
            </div>
          </div>
  </div>
</form>

<script>

 function kodeVersi(){
      $.ajax({
      url: "<?php echo base_url().'mst/keuangan_sts/kodeVersi';?>",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          var lokasi = elemet.kodeversi.split(".")
          $("#id_mst_anggaran_versi").val(lokasi[0]);
        });
      }
      });
      return false;
  }

  $(function () { 
    tabIndex = 1;
    kodeVersi();
    
   $("[name='btn_keuangan_versi_close']").click(function(){
        $("#popup_keuangan_sts").jqxWindow('close');
    });

    $("[name='btn_keuangan_versi_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('id_mst_anggaran_versi', $("[name='versi_id']").val());
        data.append('nama',                  $("[name='versi_nama']").val());
        data.append('deskripsi',             $("[name='versi_deskripsi']").val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_sts/versi_{action}/{id}"   ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#popup_keuangan_sts").jqxWindow('close');
                alert("Data instansi berhasil disimpan.");
              }else{
                $('#popup_keuangan_sts_content').html(response);
              }
            }
        });

        return false;
    });
  });

</script>
