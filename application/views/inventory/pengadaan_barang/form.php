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
<div class="row">
  <form action="<?php echo base_url()?>inventory/pengadaanbarang/add" method="post">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body">
        <div class="form-group">
          <label>Tanggal Pengadaan</label>
          <div id='tgl' name="tgl" value="<?php
              echo (set_value('tgl')!="") ? date("Y-m-d",strtotime(set_value('tgl'))) : "";
            ?>"></div>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select  name="status" type="text" class="form-control">
              <option value="">Pilih Status</option>
              </option>
              <?php foreach($kodestatus as $stat) : ?>
                <?php $select = $stat->code == set_value('status') ? 'selected' : '' ?>
                <option value="<?php echo $stat->code ?>" <?php echo $select ?>><?php echo $stat->value ?></option>
              <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label>Puskesmas</label>
          <select  name="codepus" id="puskesmas" class="form-control">
              <?php foreach($kodepuskesmas as $pus) : ?>
                <?php $select = $pus->code == set_value('codepus') ? 'selected' : '' ?>
                <option value="<?php echo $pus->code ?>" <?php echo $select ?>><?php echo $pus->value ?></option>
              <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label>No. Kontrak</label>
          <input type="text" class="form-control" name="nomor_kontrak" placeholder="Nomor Kontrak" value="<?php 
            if(set_value('nomor_kontrak')=="" && isset($nomor_kontrak)){
              echo $nokontrak;
            }else{
              echo  set_value('nomor_kontrak');
            }
            ?>">
        </div>
        <div class="form-group">
          <label>Tanggal Kwitansi</label>
          <div id='tgl1' name="tgl1" value="<?php
              echo (set_value('tgl1')!="") ? date("Y-m-d",strtotime(set_value('tgl1'))) : "";
            ?>"></div>
        </div>
        <div class="form-group">
          <label>Nomor Kwitansi</label>
          <input type="text" class="form-control" name="nomor_kwitansi" placeholder="Nomor Kwitansi" value="<?php 
            if(set_value('nomor_kwitansi')=="" && isset($nomor_kwitansi)){
              echo $nokontrak;
            }else{
              echo  set_value('nomor_kwitansi');
            }
            ?>">
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <textarea class="form-control" name="keterangan" placeholder="Keterangan"><?php 
              if(set_value('keterangan')=="" && isset($keterangan)){
                echo $keterangan;
              }else{
                echo  set_value('keterangan');
              }
              ?></textarea>
        </div>  
      </div>
    </div>
  </div><!-- /.form-box -->

  <div class="col-md-6">
    <div class="box box-warning">
      <div class="box-body">
        <table class="table table-condensed">
          <tr>
            <td>Jumlah Unit</td>
            <td>
              <?php echo '0'.' '.'Unit' ?>
            </td>
          </tr>
          <tr>
            <td>Nilai Pengadaan</td>
            <td>
              <?php echo 'Rp.'.' '.'0,00' ?>
            </td>
          </tr>
          <tr>
            <td>Waktu dibuat</td>
            <td>
              <?php echo '00-00-0000' ?>
            </td>
          </tr>
          <tr>
            <td>Terakhir di edit</td>
            <td>
              <?php echo '00-00-0000' ?>
            </td>
          </tr>
        </tbody>
      </table>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" id="btn-kembali" class="btn btn-warning">Kembali</button>
      </div>
      </div>
    </form>        

  </div><!-- /.form-box -->
</div><!-- /.register-box -->

<script type="text/javascript">
$(function(){
    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>inventory/pengadaanbarang";
    });

    $("#menu_inventory").addClass("active");
    $("#menu_inventory_pengadaanbarang").addClass("active");

    $("#tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
    $("#tgl1").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});

  });
</script>
