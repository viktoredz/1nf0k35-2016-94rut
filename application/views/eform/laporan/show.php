
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
				     			<option value="2">Distribusi Penduduk Menurut Usia</option>
				     			<option value="3">Distribusi Penduduk Menurut Tingkat Pendidikan</option>
				     			<option value="4">Distribusi Penduduk Berdasarkan Pekerjaan</option>
				     			<option value="5">Distribusi Penduduk Mengikuti Kegiatan Posyandu</option>
				     			<option value="6">Distribusi Penduduk Penyandang Disabilitas</option>
				     			<option value="7">Distribusi Penduduk Jaminan Kesehatan</option>
				     			<option value="8">Distribusi Penduduk Keikutsertaan KB</option>
				     			<option value="9">Distribusi Penduduk Alasan Tidak KB</option>

				     		</select>
				  		</div>
				  	</div>				  	
				  	<div class="col-md-6">
						<div class="form-group">
							<label>Kecamatan</label>
				     		<select name="kecamatan" class="form-control" id="kecamatan">
				     			<!--<option value="">Pilih Kecamatan</option>-->
				     			<?php foreach ($datakecamatan as $kec ) { ;?>
								<?php $select = $kec->code == substr($this->session->userdata('puskesmas'), 0,7)  ? 'selected=selected' : '' ?>
									<option value="<?php echo $kec->code; ?>" <?php echo $select ?>><?php echo $kec->nama; ?></option>
								<?php	} ;?>
				     		</select>
						</div>
				  	</div>
				  	<div class="col-md-6">
						<div class="form-group">
							<label>Kelurahan</label>
				     		<select name="kelurahan" class="form-control" id="kelurahan">
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
							<button id="btn-export" type="button"  class="btn btn-success"><i class='fa fa-file-excel-o'></i> &nbsp; Export</button>
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
       <!-- <div class="row" id="rowchart">-->
          <div id="tampilchart">
            <!--<canvas id="tampilchart" height="240" width="511" style="width: 511px; height: 240px;"></canvas>-->
          </div>
        <!--</div>-->
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
      		//$('#isi').html($('[name=laporan] :selected').text());
      		var judul = $('[name=laporan] :selected').text();
      		var kecamatanbar = $("#kecamatan").val();
      		var kelurahanbar = $("#kelurahan").val();
      		var rw = $("#rw").val();
      		$.ajax({
	        url : '<?php echo site_url('eform/laporan_kpldh/pilihchart/') ?>',
	        type : 'POST',
	        data : 'judul=' + judul+'&kecamatan=' + kecamatanbar+'&kelurahan=' + kelurahanbar+'&rw=' + rw,
	        success : function(data) {
	          $('#tampilchart').html(data);
	        }
	      });

	      return false;
      		/*var rwbar = $("#rw").val();
      		if (judul=="Pilih Laporan"){
      			$('#row_umur').hide(); 
      			$('#row_kelamin').hide();
      		}else if (judul=="Distribusi Penduduk Berdasarkan Jenis Kelamin") {
      			//alert('hai');
      			kelaminbar();
      			 $('#row_kelamin').show(); 
      			$('#row_umur').hide(); 
      		}else{
      			$('#row_kelamin').hide(); 
      			$('#row_umur').show(); 
      		}*/

      	});
      	
      	$('#kecamatan').change(function(){
	      var kecamatan = $(this).val();
	     // var id_mst_inv_ruangan = '<?php echo set_value('ruangan')?>';
	      $.ajax({
	        url : '<?php echo site_url('eform/laporan_kpldh/get_kecamatanfilter') ?>',
	        type : 'POST',
	        data : 'kecamatan=' + kecamatan,
	        success : function(data) {
	          $('#kelurahan').html(data);
	        }
	      });

	      return false;
	    }).change();
	    $('#kelurahan').change(function(){
	      var kelurahan = $(this).val();
	     // var id_mst_inv_ruangan = '<?php echo set_value('ruangan')?>';
	      $.ajax({
	        url : '<?php echo site_url('eform/laporan_kpldh/get_kelurahanfilter') ?>',
	        type : 'POST',
	        data : 'kelurahan=' + kelurahan,
	        success : function(data) {
	          $('#rw').html(data);
	        }
	      });

	      return false;
	    }).change();



	 

       
	});
	$("#btn-export").click(function(){
  		var judul = $('[name=laporan] :selected').text();
  		var kecamatanbar = $("#kecamatan").val();
  		var kelurahanbar = $("#kelurahan").val();
  		var rw = $("#rw").val();

		var post = "";
		post = post+'judul='+judul+'&kecamatan='+ kecamatanbar+'&kelurahan=' + kelurahanbar+'&rw=' + rw;
		
		$.post("<?php echo base_url()?>eform/export_data/pilih_export",post,function(response){
			//window.location.href=response;
			alert(response);
		});
	});
</script>
