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
          <label>Tanggal</label>
          <div >
			
			<input type="hidden" id="tanggal" value="<?=$tanggal_permohonan?>">
			<?php
              echo ($tanggal_permohonan);
            ?>
		  </div>
        </div>
        <div class="form-group">
          <label>Puskesmas</label>
          <br/>
            <?php 
			$nama_pus = "";
			foreach($kodepuskesmas as $pus) {
				$nama_pus = $pus->value;
                echo $pus->value ;
            }?>
			<input type="hidden" id="nama_puskesmas" value="<?=$pus->value?>">
        </div>
        <div class="form-group">
          <label>Ruangan</label>
		  <br/>
		  
          <?php
			$nama_ruang = "";
			foreach($ruang as $r){
				$nama_ruang = $r->nama_ruangan;
				echo $r->nama_ruangan;
			}
			
		  ?>
		  <input type="hidden" id="ruang" value="<?=$nama_ruang?>">
        </div>
      </div>
    </div>
  </div><!-- /.form-box -->

  <div class="col-md-6">
    <div class="box box-warning">
      <div class="box-body">
        <div class="form-group">
          <label>Keterangan</label>
		  
		  <br/>
		  <input type="hidden" id="keterangan" value="<?=$keterangan?>">
          <?php 
              if(set_value('keterangan')=="" && isset($keterangan)){
                echo $keterangan;
              }else{
                echo  set_value('keterangan');
              }
              ?>
        </div>
        <table width="100%">
          <tr>
            <th width="25%">Jumlah Unit</th>
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
        <button type="button" id="btn-edit" class="btn btn-primary"><i class='fa fa-pencil-square-o'></i> &nbsp; Ubah Permohonan</button>
        <button type="button" id="btn-export" class="btn btn-success"><i class='fa fa-save'></i> &nbsp; Export</button>
        <button type="button" id="btn-kembali" class="btn btn-warning"><i class='fa fa-reply'></i> &nbsp; Kembali</button>
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
<input type="hidden" value="<?=$kode?>" id="kode">
<input type="hidden" value="<?=$code_cl_phc?>" id="code_cl_phc">
<script type="text/javascript">
$(function(){
    $('#btn-edit').click(function(){
        window.location.href="<?php echo base_url()?>inventory/permohonanbarang/edit/{kode}/{code_cl_phc}";
    });

    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>inventory/permohonanbarang";
    });

    $("#menu_inventory_permohonanbarang").addClass("active");
    $("#menu_inventory").addClass("active");

    //$("#tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});

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
