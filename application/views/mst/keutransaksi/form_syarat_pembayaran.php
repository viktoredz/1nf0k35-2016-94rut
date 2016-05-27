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
      <button type="button" name="btn_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
      <button type="button" name="btn_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Tutup</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
             
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nama Kategori
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="syarat_nama" placeholder="Nama " value="<?php 
                  if(set_value('nama')=="" && isset($nama)){
                    echo $nama;
                  }else{
                    echo  set_value('nama');
                  }
                  ?>">
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">Deskripsi</div>
                <div class="col-md-8">
                <textarea class="form-control" name="syarat_desk" placeholder="Deskripsi Syarat Pembayaran"><?php 
                    if(set_value('deskripsi')=="" && isset($deskripsi)){
                      echo $deskripsi;
                    }else{
                      echo  set_value('deskripsi');
                    }
                    ?></textarea>
                </div>  
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Aktif
                </div>
                <div class="col-md-8">
                  <input type="checkbox" name="syarat_aktif" value="1" <?php 
                  if(set_value('aktif')=="" && isset($aktif)){
                    $aktif = $aktif;
                  }else{
                    $aktif = set_value('aktif');
                  }
                  if($aktif == 1) echo "checked";
                  ?>>
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

    $("[name='btn_close']").click(function(){
        $("#popup_syarat_pembayaran").jqxWindow('close');
    });

  
    $("[name='btn_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('nama',          $("[name='syarat_nama']").val());
        data.append('deskripsi',     $("[name='syarat_desk']").val());
        data.append('aktif',         $("[name='syarat_aktif']:checked").val());
              
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/syarat_pembayaran_{action}/{id}"   ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#popup_syarat_pembayaran").jqxWindow('close');
                alert("Data berhasil disimpan.");
                $("#jqxgrid_syarat_pembayaran").jqxGrid('updatebounddata', 'filter');
              }else{
                $('#popup_syarat_pembayaran_content').html(response);
              }
            }
        });

        return false;
    });

  });
</script>
