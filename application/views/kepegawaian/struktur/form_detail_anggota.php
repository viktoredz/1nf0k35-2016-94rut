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
      <button type="button" name="btn_pegawai_data_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Tutup</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
    <div class="col-md-12">
      <div class="box box-primary">
          <table class="table table-striped table-hover">
              <tr>
                  <th>NIP</th>  
                  <th>Nama</th>  
              </tr>
              <?php if(isset($all_pegawai)){
                foreach ($all_pegawai as $key) {
              ?>
              <tr>
                <td><?php echo $key->nip_nit; ?></td>
                <td><?php echo $key->gelar_depan.' '.$key->nama.' '.$key->gelar_belakang; ?></td>
              </tr>
              <?php }
              } 
              ?>
          </table>
      </div>
    </div>
  </div>
</form>

<script>

  $(document).ready(function () {   
    tabIndex = 1;

    $("[name='btn_pegawai_data_close']").click(function(){
        $("#popup_pegawai_data_detail").jqxWindow('close');
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
