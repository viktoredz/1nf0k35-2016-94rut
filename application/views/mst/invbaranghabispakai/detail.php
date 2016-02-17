<?php if(validation_errors()!=""){ ?>
<div class="alert alert-warning alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
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

<!--<div class="row">
	<!-- left column -->
	<!--<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-body">
						<div class="form-group">
							<label>Uraian</label><br/>
							<?php echo $uraian;?>
						</div>
			</div>
		</div><!-- /.box -->
	<!--</div><!-- /.box 
</div>	-->


<div class="box box-success">
  <div class="box-body">
  	<div class="row"> 
  		<div class="col-md-6"> 
		  	<div class="form-group">
				<h4><label>Uraian :</label>
				<?php echo $uraian;?></h4>
			</div>
		</div>
		<div class="col-md-6"> 
		  	<div class="form-group pull-right">					
				<button onClick="add_barang();" type="button"  class="btn btn-success">Tambah</button>
				<button type="button" class="btn btn-warning" onClick="document.location.href='<?php echo base_url()?>mst/invbaranghabispakai'">Kembali</button>
			</div>
		</div>
	</div>
    <div class="div-grid">
        <div id="jqxTabs">
          <?php echo $barang;?>
        </div>
    </div>
  </div>
</div>


<script>
	$(function () {	
		$("#menu_master_data").addClass("active");
		$("#menu_mst_invbaranghabispakai").addClass("active");
	});
</script>
