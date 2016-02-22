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
		<div class="box-header">
          <h3 class="box-title">Jenis Barang : <?php echo $uraian;?> </h3>
	    </div>

      	<div class="box-footer">
	      <div class="col-md-8">
		 		<button onClick="add_barang();" type="button"  class="btn btn-success">Tambah</button>
				<button type="button" class="btn btn-warning" onClick="document.location.href='<?php echo base_url()?>mst/invbaranghabispakai'">Kembali</button>
	     </div>
	     <div class="col-md-4">
	     	<div class="row">
		     	<div class="col-md-4" style="padding-top:5px;"><label> Jenis Barang </label> </div>
		     	<div class="col-md-8">
		     		<select name="jenisbarang" id="jenisbarang" class="form-control">
		     				<option value="all">All</option>
						<?php foreach ($jenisbarang as $row ) { ;?>
						<?php $select = $row->id_mst_inv_barang_habispakai_jenis == $kode ? 'selected=selected' : '' ?>
							<option value="<?php echo $row->id_mst_inv_barang_habispakai_jenis; ?>"  <?php echo $select ?> ><?php echo $row->uraian; ?></option>
						<?php	} ;?>
			     	</select>
			     </div>	
	     	</div>
		  </div>
		</div>
  <div class="box-body">
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

		$("select[name='jenisbarang']").change(function(){
		$.post("<?php echo base_url().'mst/invbaranghabispakai/filter_jenisbarang' ?>", 'jenisbarang='+$(this).val(),  function(){
			$("#jqxgrid_barang").jqxGrid('updatebounddata', 'cells');
		});
    });
	});
</script>