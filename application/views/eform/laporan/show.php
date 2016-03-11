
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
	        <div class="row" id="row_kelamin">
	          <div class="chart">
	            <canvas id="pieChart" height="240" width="511" style="width: 511px; height: 240px;"></canvas>
	          </div>
	        </div>
	        <div class="row" id="row_umur">
	          <div class="chart">
	            <canvas id="barChart" height="240" width="511" style="width: 511px; height: 240px;"></canvas>
	          </div>
	        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
</div><!-- /.row -->

<script type="text/javascript">
	$(function () {	
		//$('#row_dimumur').hide(); 
      //	$('#row_dimkelamin').hide();
		$("#menu_ketuk_pintu").addClass("active");
		$("#menu_eform_laporan_kpldh").addClass("active");

      	$('#btn-preview').click(function(){
      		$('#judul').html($('[name=laporan] :selected').text());
      		//$('#isi').html($('[name=laporan] :selected').text());
      		var judul = $('[name=laporan] :selected').text();
      		var kecamatanbar = $("#kecamatan").val();
      		var kelurahanbar = $("#kelurahan").val();
      		var rwbar = $("#rw").val();
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
      		}
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



	   //-------------
        //- BAR CHART -
        //-------------
        var areaChartData = {
        labels: [<?php 
        $i=0;
       // print_r($bar);  
        foreach ($bar as $row ) { 
          if($i>0) echo ",";
            echo "\"".str_replace(array("KEC. ","KEL. "),"", $row['puskesmas'])."\"";
          $i++;
        } ?>],
        datasets: [
          {
            label: "Baik",
            fillColor: "#20ad3a",
            strokeColor: "#20ad3a",
            pointColor: "#20ad3a",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?php 
            $i=0;
            foreach ($bar as $row ) { 
              if(isset($row['j_barang_baik']))  $x = ($row['j_barang_baik']);
              else                              $x = 0;

              if($i>0) echo ",";
              echo "\"".$x."\"";
              $i++;
            } ?>]
          },
          {
            label: "Kurang Baik",
            fillColor: "#ffb400",
            strokeColor: "#ffb400",
            pointColor: "#ffb400",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?php 
            $i=0;
            foreach ($bar as $row ) { 
              if(isset($row['j_barang_rr']))  $x = ($row['j_barang_rr']);
              else                              $x = 0;

              if($i>0) echo ",";
              echo "\"".$x."\"";
              $i++;
            } ?>]
          },
          {
            label: "Rusak Berat",
            fillColor: "#e02a11",
            strokeColor: "#e02a11",
            pointColor: "#e02a11",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?php 
            $i=0;
            foreach ($bar as $row ) { 
              if(isset($row['j_barang_rb']))  $x = ($row['j_barang_rb']);
              else                              $x = 0;

              if($i>0) echo ",";
              echo "\"".$x."\"";
              $i++;
            } ?>]
          }
        ]
      };
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        var barChartOptions = {
          scaleBeginAtZero: true,
          scaleShowGridLines: true,
          scaleGridLineColor: "rgba(0,0,0,.05)",
          scaleGridLineWidth: 1,
          scaleShowHorizontalLines: true,
          scaleShowVerticalLines: true,
          barShowStroke: true,
          barStrokeWidth: 2,
          barValueSpacing: 5,
          barDatasetSpacing: 1,
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          responsive: true,
          maintainAspectRatio: false
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);

       
	});
	function kelaminbar(){
		var post = "";
		post = post+'&kecamatan='+$("#kecamatan").val()+'&kelurahan='+$("#kelurahan").val()+'&rukunwarga='+$("#rw").val();
		$.post("<?php echo base_url()?>eform/laporan_kpldh/datachart",post,function(response	){
			//window.location.href=response;
		var data = response;
		alert(data);
		 //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var i=0;
        var PieData = [ 
       
              document.write(
	              {
	              value: row['jml'],
	              color: color[i],
	              highlight: color[$i],
	              label:$row['nama_kecamatan']
	              }
              );
            
        ];
        var pieOptions = {
          segmentShowStroke: true,
          segmentStrokeColor: "#fff",
          segmentStrokeWidth: 2,
          percentageInnerCutout: 40, // This is 0 for Pie charts
          animationSteps: 100,
          animationEasing: "easeOutBounce",
          animateRotate: true,
          animateScale: false,
          responsive: true,
          maintainAspectRatio: false,
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        pieChart.Doughnut(PieData, pieOptions);
        });
	}
</script>
