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
                 Judul Versi
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="sts_nama" placeholder=" Judul Versi " value="<?php 
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
                  <input type="text" class="form-control" name="sts_deskripsi" placeholder=" Deskripsi " value="<?php 
                  if(set_value('tlp')=="" && isset($tlp)){
                    echo $tlp;
                  }else{
                    echo  set_value('tlp');
                  }
                  ?>">
                </div>
              </div>

             <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                   Duplikasi Dari
                </div>
                <div class="col-md-8">
                  <select name="keuinstansi_kategori" type="text" class="form-control">
                  <?php 
                  if(set_value('keuinstansi_kategori')=="" && isset($kategori)){
                    $keuinstansi_kategori = $kategori;
                  }else{
                    $keuinstansi_kategori = set_value('keuinstansi_kategori');
                  }
                  ?>
                       <option value="Farmasi" <?php if($keuinstansi_kategori=="farmasi") echo "selected" ?>>Farmasi</option>
                       <option value="Umum" <?php if($keuinstansi_kategori=="umum") echo "selected" ?>>Umum</option>
                  </select>
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

    $("[name='btn_keuangan_versi_close']").click(function(){
        $("#popup_keuangan_sts").jqxWindow('close');
    });

    $("[name='btn_keuangan_versi_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('nama',            $("[name='sts_nama']").val());
        data.append('deskripsi',       $("[name='sts_deskripsi']").val());
        data.append('tanggal_dibuat',  $("[name='sts_tanggal_dibuat']").val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_instansi/instansi_{action}/{id}"   ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#popup_keuangan_instansi").jqxWindow('close');
                alert("Data instansi berhasil disimpan.");
                $("#jqxgrid").jqxGrid('updatebounddata', 'filter');
              }else{
                $('#popup_keuangan_sts_content').html(response);
              }
            }
        });

        return false;
    });

  });
</script>
