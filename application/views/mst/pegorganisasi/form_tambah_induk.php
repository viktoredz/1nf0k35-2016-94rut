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
      <button type="button" name="btn_keuangan_akun_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
      <button type="button" name="btn_keuangan_akun_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Tutup</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nama Posisi
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="tar_nama_posisi" placeholder=" Nama Jabatan " value="<?php 
                  if(set_value('tar_nama_posisi')=="" && isset($tar_nama_posisi)){
                    echo $tar_nama_posisi;
                  }else{
                    echo  set_value('tar_nama_posisi');
                  }
                  ?>">
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Status
                </div>

                <div class="col-md-4">
                  <select name="tar_status" type="text" class="form-control">
                       <option value="1">Aktif</option>
                       <option value="0">Tidak Aktif</option>
                  </select>
                </div>
              <br>
            </div>
          </div>
  </div>
</form>

<script>

  $(function () { 
    tabIndex = 1;

    $("[name='btn_keuangan_akun_close']").click(function(){
        $("#popup_keuangan_akun").jqxWindow('close');
        cekstatus();
    });

    $("[name='btn_keuangan_akun_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();
        
        data.append('tar_nama_posisi', $("[name='tar_nama_posisi']").val());
        data.append('tar_status', $("[name='tar_status']").val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/pegorganisasi/induk_add" ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#popup_keuangan_akun").jqxWindow('close');
                alert("Data berhasil disimpan.");
                cekstatus();
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }else{
                $('#popup_keuangan_akun_content').html(response);
              }
            }
        });

        return false;
    });
  });
</script>
