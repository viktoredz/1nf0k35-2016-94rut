
<div class="row">

	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-body">
				<div class="row">
				  	<div class="col-md-6">
						<div class="form-group">
							<label>Laporan</label>
				     		<select name="laporan" class="form-control" id="laporan">
				     			<option value="">Pilih Laporan</option>
				     			<option value="1">Distribusi Penduduk Berdasarkan Jenis Kelamin</option>
				     			<option value="2">Distribusi Penduduk Menurut Usia </option>
				     			<option value="3">Distribusi Penduduk Menurut Tingkat Pendidikan </option>
				     			<option value="4">Distribusi Penduduk Berdasarkan Pekerjaan </option>
				     		</select>
				  		</div>
				  	</div>				  	
				  	<div class="col-md-6">
						<div class="form-group">
							<label>Kecamatan</label>
				     		<select name="code_cl_kec" class="form-control" id="code_cl_kec">
				     			<option value="">Pilih Kecamatan</option>
				     		</select>
						</div>
				  	</div>
				  	<div class="col-md-6">
						<div class="form-group">
							<label>Kelurahan</label>
				     		<select name="code_cl_village" class="form-control" id="code_cl_village">
				     			<option value="">Pilih Kelurahan</option>
				     		</select>
				  		</div>
				  	</div>
				  	<div class="col-md-6">
						<div class="form-group">
							<label>RW</label>
				     		<select name="rw" class="form-control" id="rw">
				     			<option value="">Pilih RW</option>
				     		</select>
				  		</div>
				  	</div>
				  	<div class="col-md-12">
						<div class="form-group pull-right">
            				<button id="btn-preview" type="button"  class="btn btn-warning"><i class='fa fa-bar-chart-o'></i> &nbsp; Tampilkan Laporan & Chart</button>
						</div>
				  	</div>
				</div>
			</div>
		</div><!-- /.box -->
	</div><!-- /.box -->
</div><!-- /.box -->
<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title" id="judul">Distribusi Penduduk Berdasarkan Jenis Kelamin </h3>
        <br><br>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body" id="isi" style="min-height: 200px">

      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
</div><!-- /.row -->

<script type="text/javascript">
	$(function () {	
		$("#menu_ketuk_pintu").addClass("active");
		$("#menu_eform_laporan_kpldh").addClass("active");

      	$('#btn-preview').click(function(){
      		$('#judul').html($('[name=laporan] :selected').text());
      		$('#isi').html($('[name=laporan] :selected').text());
      		
      	});

	});
</script>
