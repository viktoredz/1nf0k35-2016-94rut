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
  <form action="<?php echo base_url()?>inventory/permohonanbarang/{action}/{kode}/{code_cl_phc}" method="post">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body">
        <div class="form-group">
          <label>Tanggal Permohonan</label>
          <div id='tgl' name="tgl" value="<?php
              echo date("Y-m-d",strtotime($tanggal_permohonan));
            ?>"></div>
        </div>
        <div class="form-group">
          <label>Puskesmas</label>
          <select  name="codepus" id="puskesmas" class="form-control">
              <?php foreach($kodepuskesmas as $pus) : ?>
                <option value="<?php echo $pus->code ?>" ><?php echo $pus->value ?></option>
              <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label>Ruangan</label>
          <select name="ruangan" id="ruangan"  class="form-control">
              <option value="">Pilih Ruangan</option>
          </select>
        </div>
      </div>
    </div>
  </div><!-- /.form-box -->

  <div class="col-md-6">
    <div class="box box-warning">
      <div class="box-body">
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
        <table width="100%">
          <tr>
            <th width="25%">Total Jumlah</th>
            <td>:</td>
            <td width="70%"><div id="total_jumlah_"></div></td>
          </tr>
          <tr>
            <th>Total Harga</th>
            <td>:</td>
            <td><div id="total_harga_"></div></td>
          </tr>
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
<div class="box box-success">
  <div class="box-body">
    <div class="div-grid">
        <div id="jqxTabs">
          <?php echo $barang;?>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>inventory/permohonanbarang";
    });

    $("#menu_inventory_permohonanbarang").addClass("active");
    $("#menu_inventory").addClass("active");

    $("#tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});

    $.ajax({
      url : '<?php echo site_url('inventory/permohonanbarang/get_ruangan') ?>',
      type : 'POST',
      data : 'code_cl_phc={code_cl_phc}&id_mst_inv_ruangan={id_mst_inv_ruangan}',
      success : function(data) {
        $('#ruangan').html(data);
      }
    });

  });

</script>
