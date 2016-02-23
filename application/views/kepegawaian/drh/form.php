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

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
      </div>

      <div class="box-footer" style="text-align: right">
        <button type="submit" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
        <button type="button" class="btn btn-success" id="btn-return"><i class='fa fa-arrow-circle-o-left'></i> &nbsp; Kembali</button>
      </div>
    </div>
      <form action="<?php echo base_url()?>kepegawaian/drh/{action}/{id}" method="POST" name="">
        <div class="row">

          <div class="col-md-6">
            <div class="box box-primary">
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nama Lengkap
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
                  Jenis Kelamin
                </div>
                <div class="col-sm-4">
                  <input type="radio" name="jenis_kelamin" value="L" class="iCheck-helper"> Laki-laki 
                </div>
                <div class="col-sm-4">
                  <input type="radio" name="jenis_kelamin" value="P" class="iCheck-helper"> Perempuan
                </div>
              </div>

            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">{title_form}</h3>
              </div>
              <label>--Informasi Utama--</label>
              <div class="box-body">
              </div>
            </div>
          </div>

        </div>
      </form>
    </div>
  </div>

</section>

<script>
  $(function () { 
    $("#btn-return").click(function(){
      document.location.href="<?php echo base_url()?>kepegawaian/drh";
    });

    $("#menu_kepegawaian_drh").addClass("active");
    $("#menu_kepegawaian").addClass("active");
  });
</script>
