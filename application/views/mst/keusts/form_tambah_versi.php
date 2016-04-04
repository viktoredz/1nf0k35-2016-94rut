<?php if(validation_errors()!=""){ ?>
<div class="alert alert-warning alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert_form')?>
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

             <!--  <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">ID</div>
                  <div class="col-md-8">-->
                    <input type="text" class="form-control" name="kode_versi_" id="kode_versi_" placeholder="ID" readonly>
                <!-- </div>
             </div> -->
             
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
                  <input type="text" class="form-control" name="versi_uraian" placeholder=" Deskripsi " value="<?php 
                  if(set_value('uraian')=="" && isset($uraian)){
                    echo $uraian;
                  }else{
                    echo  set_value('uraian');
                  }
                  ?>">
                </div>
              </div>

         <!--     <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                   Duplikasi Dari
                </div>
                <div class="col-md-8">
                 <select  name="versi" type="text" class="form-control">
               <option> Versi </option>
                <?php foreach($versi as $ver) : ?>
                    <?php
                       if(set_value('id_mst_anggaran_versi')=="" && isset($id_mst_anggaran_versi)){
                         $id_mst_anggaran_versi = $id_mst_anggaran_versi;
                       }else{
                         $id_mst_anggaran_versi = set_value('id_mst_anggaran_versi');
                       }
                     $select = $ver->id_mst_anggaran_versi == $id_mst_anggaran_versi ? 'selected' : '' ;
                  ?>
                 <option value="<?php echo $ver->id_mst_anggaran_versi ?>" <?php echo $select ?>><?php echo $ver->nama ?></option>
               <?php endforeach ?>
             </select>
                </div>
              </div> -->
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
          $("#kode_versi_").val(lokasi[0]);
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

        data.append('kode_versi_', $("[name='kode_versi_']").val());
        data.append('nama',                  $("[name='versi_nama']").val());
        data.append('deskripsi',             $("[name='versi_uraian']").val());
        
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
