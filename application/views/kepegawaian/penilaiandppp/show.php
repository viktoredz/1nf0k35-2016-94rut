<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<div id="popup_pegawai" style="display:none">
	<div id="popup_title">Data Login Pegawai</div>
	<div id="popup_content">&nbsp;</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>kepegawaian/penilaiandppp/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
	    </div>

      	<div class="box-footer">
		      <div class="col-md-5">
		      	<!-- <button type="button" class="btn btn-primary" id="btn-add"><i class='glyphicon glyphicon-plus'></i> &nbsp; Tambah</button> -->
			 	<button type="button" class="btn btn-warning" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
			 	<button type="button" class="btn btn-success" id="btn-export"><i class='fa fa-file-excel-o'></i> &nbsp; Export</button>
		     </div>
		     <div class="col-md-3">
		     	<div class="row">
			     	<div class="col-md-4" style="padding-top:5px;"><label> Tahun </label> </div>
			     	<div class="col-md-8">
			     		<select name="filtertahun" id="filtertahun" class="form-control">

							<?php 
							$tahuntampil = $this->session->userdata('filter_tahun');
							if ($tahuntampil!='') {
								$selectahun = $tahuntampil;
							}else{
								$selectahun = date("Y");
							}
							for($i=date("Y")-8;$i<=date("Y")+8; $i++ ) { ;
								$select = $i == $selectahun ? 'selected=selected' : '';
							?>
								<option value="<?php echo $i; ?>" <?php echo $select; ?>><?php echo $i; ?></option>
							<?php	} ;?>
				     	</select>
				     </div>	
		     	</div>
			  </div>
			  <div class="col-md-4">
		     	<div class="row">
			     	<div class="col-md-4" style="padding-top:5px;"><label> Puskesmas </label> </div>
			     	<div class="col-md-8">
			     		<select name="code_cl_phc" id="puskesmas" class="form-control">
							<?php foreach ($datapuskesmas as $row ) { ;?>
								<option value="<?php echo $row->code; ?>" onchange="" ><?php echo $row->value; ?></option>
							<?php	} ;?>
				     	</select>
				     </div>	
		     	</div>
			  </div>
		</div>
        <div class="box-body">
		    <div class="div-grid">
		        <div id="jqxgrid"></div>
			</div>
	    </div>
	  </div>
	</div>
  </div>
</form>
</section>

<script type="text/javascript">
	$(function () {	
	    $("#menu_kepegawaian").addClass("active");
	    $("#menu_kepegawaian_penilaiandppp").addClass("active");
	});
	function close_popup(){
		$("#popup_pegawai").jqxWindow('close');
	}
		var sourcejabatan =
	      {
	          datatype: "json",
	          datafields: [
	              { name: 'tar_id_struktur_org' , type: 'string'},
	              { name: 'tar_nama_posisi' , type: 'string'}
	          ],
	          url: '<?php echo base_url()?>kepegawaian/penilaiandppp/json_kode_jabatan',
	          async: true
	      };
		var kode_jabatan_source = new $.jqx.dataAdapter(sourcejabatan);
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'no', type: 'number'},
			{ name: 'code_cl_phc', type: 'string'},
			{ name: 'nip_nit', type: 'string'},
			{ name: 'id_pegawai', type: 'string'},
			{ name: 'nilai', type: 'string'},
			{ name: 'nama', type: 'string'},
			{ name: 'id_mst_peg_golruang', type: 'string'},
			{ name: 'ruang', type: 'string'},
			{ name: 'tahun_penilaian', type: 'string'},
			{ name: 'nilai_prestasi', type: 'string'},
			{ name: 'tar_nama_posisi', type: 'string'},
			{ name: 'detail', type: 'number'},
        ],
		url: "<?php echo site_url('kepegawaian/penilaiandppp/json'); ?>",
		cache: false,
		updateRow: function (rowID, rowData, commit) {
            commit(true);

         
         },
		filter: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){		
			if (data != null){
				source.totalrecords = data[0].TotalRows;					
			}
		}
		};		
		var dataadapter = new $.jqx.dataAdapter(source, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});
     
		$('#btn-refresh').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});

		$("#jqxgrid").jqxGrid(
		{		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: true,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				
				{ text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.detail==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+dataRecord.id_pegawai+"\",\""+dataRecord.code_cl_phc+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				
				{ text: 'NIP', datafield: 'nip_nit', columntype: 'textbox', editable:false, filtertype: 'textbox', align: 'center' , cellsalign: 'center', width: '13%'},
				{ text: 'Nama', datafield: 'nama', columntype: 'textbox', editable:false, filtertype: 'textbox', align: 'center', width: '25%' },
				{ text: 'Golongan', align: 'center', cellsalign: 'center', editable:false ,datafield: 'id_mst_peg_golruang', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
				{ text: 'Nama Golongan', align: 'center', cellsalign: 'center', editable:false ,datafield: 'ruang', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
				{text: 'Jabatan', align: 'center', datafield: 'tar_nama_posisi',editable:false , width: '28%', columntype: 'textbox'},
                { text: 'Nilai', datafield: 'nilai_prestasi',cellsalign:'right', columntype: 'textbox', editable:false, filtertype: 'textbox', align: 'center', width: '8%' },
            ]
		});

	function detail(id_pegawai,code_cl_phc){
		document.location.href="<?php echo base_url().'kepegawaian/penilaiandppp/edit';?>/" + id_pegawai+'/'+code_cl_phc;
	}
	$("select[name='code_cl_phc']").change(function(){
		$.post("<?php echo base_url().'kepegawaian/penilaiandppp/filter' ?>", 'code_cl_phc='+$(this).val(),  function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
    });
    $("select[name='filtertahun']").change(function(){
		$.post("<?php echo base_url().'kepegawaian/penilaiandppp/filtertahun' ?>", 'filtertahun='+$(this).val(),  function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
    });
			
	$("#btn-export").click(function(){
		
		var post = "";
		var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
		for(i=0; i < filter.length; i++){
			var fltr 	= filter[i];
			var value	= fltr.filter.getfilters()[0].value;
			var condition	= fltr.filter.getfilters()[0].condition;
			var filteroperation	= fltr.filter.getfilters()[0].operation;
			var filterdatafield	= fltr.filtercolumn;
			if(filterdatafield=="tgl"){
				var d = new Date(value);
				var day = d.getDate();
				var month = d.getMonth();
				var year = d.getYear();
				value = year+'-'+month+'-'+day;
				
			}
			post = post+'&filtervalue'+i+'='+value;
			post = post+'&filtercondition'+i+'='+condition;
			post = post+'&filteroperation'+i+'='+filteroperation;
			post = post+'&filterdatafield'+i+'='+filterdatafield;
			post = post+'&'+filterdatafield+'operator=and';
		}
		post = post+'&filterscount='+i;
		
		var sortdatafield = $("#jqxgrid").jqxGrid('getsortcolumn');
		if(sortdatafield != "" && sortdatafield != null){
			post = post + '&sortdatafield='+sortdatafield;
		}
		if(sortdatafield != null){
			var sortorder = $("#jqxgrid").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgrid").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
			post = post+'&sortorder='+sortorder;
			
		}
		post = post+'&puskes='+$("#puskesmas option:selected").text();
		
		$.post("<?php echo base_url()?>inventory/pengadaanbarang/pengadaan_export",post,function(response	){
			window.location.href=response;
		});
	});
</script>











