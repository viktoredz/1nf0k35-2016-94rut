
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
    <div class="col-sm-4" style="text-align: right">
      <button type="button" name="btn_biodata_ortu_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nama Lengkap *
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" value="<?php 
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
                  Gelar Depan
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="gelar_depan" placeholder="Gelar Depan" value="<?php 
                  if(set_value('gelar_depan')=="" && isset($gelar_depan)){
                    echo $gelar_depan;
                  }else{
                    echo  set_value('gelar_depan');
                  }
                  ?>">
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Gelar Belakang
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="gelar_belakang" placeholder="Gelar Belakang" value="<?php 
                  if(set_value('gelar_belakang')=="" && isset($gelar_belakang)){
                    echo $gelar_belakang;
                  }else{
                    echo  set_value('gelar_belakang');
                  }
                  ?>">
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Jenis Kelamin *
                </div>
                <div class="col-sm-4">
                  <input type="radio" name="jenis_kelamin" value="L" class="iCheck-helper" <?php echo  ('L' == $jenis_kelamin) ? 'checked' : '' ?>> Laki-laki 
                </div>
                <div class="col-sm-4">
                  <input type="radio" name="jenis_kelamin" value="P" class="iCheck-helper" <?php echo  ('P' == $jenis_kelamin) ? 'checked' : '' ?>> Perempuan
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Tempat Lahir
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="tmp_lahir" placeholder="Tempat Lahir" value="<?php 
                  if(set_value('tmp_lahir')=="" && isset($tmp_lahir)){
                    echo $tmp_lahir;
                  }else{
                    echo  set_value('tmp_lahir');
                  }
                  ?>">
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Tanggal Lahir
                </div>
                <div class="col-md-8">
                  <div id='tgl_lhr' name="tgl_lhr" value="<?php
                    if(set_value('tgl_lhr')=="" && isset($tgl_lhr)){
                      $tgl_lhr = strtotime($tgl_lhr);
                    }else{
                      $tgl_lhr = strtotime(set_value('tgl_lhr'));
                    }
                    echo date("Y-m-d",$tgl_lhr);
                  ?>" >
                  </div>
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Alamat
                </div>
                <div class="col-md-8">
                  <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?php 
                      if(set_value('alamat')=="" && isset($alamat)){
                        echo $alamat;
                      }else{
                        echo  set_value('alamat');
                      }
                  ?></textarea>
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

    $("[name='btn_biodata_ortu_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('nama', $("[name='nama']").val());
        data.append('jenis_kelamin', $("[name='jenis_kelamin']:checked").val());
        data.append('nik', $("[name='nik']").val());
        
        data.append('gelar_depan', $("[name='gelar_depan']").val());
        data.append('gelar_belakang', $("[name='gelar_belakang']").val());
        data.append('tmp_lahir', $("[name='tmp_lahir']").val());
        data.append('tgl_lhr', $("[name='tgl_lhr']").val());
        data.append('alamat', $("[name='alamat']").val());
        data.append('kedudukan_hukum', $("[name='kedudukan_hukum']").val());
        data.append('npwp', $("[name='npwp']").val());
        data.append('npwp_tgl', $("[name='npwp_tgl']").val());
        data.append('kartu_pegawai', $("[name='kartu_pegawai']").val());
        data.append('kode_mst_agama', $("[name='kode_mst_agama']").val());
        data.append('goldar', $("[name='goldar']").val());
        data.append('kode_mst_nikah', $("[name='kode_mst_nikah']").val());

        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."kepegawaian/drh/biodata/1/{id}"   ?>',
            data : data,
            success : function(response){
                $('#popup_keluarga_ortu').html(response);
            }
        });

        return false;
    });

    $("#tgl_lhr").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});
  });
</script>
