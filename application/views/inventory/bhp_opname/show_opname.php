<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<div id="popup_barang" style="display:none">
	<div id="popup_title">Data Barang</div>
	<div id="popup_content">&nbsp;</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>inventory/bhp_opname/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div id="addopname"></div>
      <div class="box box-primary" id="grid">
	      	<div class="box-footer">
		      	<div class="row"> 
			      	<div class="col-md-12">
			      		<?php //if($unlock==1){ ?>
					<!-- 	<button type="button" class="btn btn-primary" onclick="add(0)"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah Pengeluaran</button>-->
						<?php //} ?>		 	
					 	<button type="button" class="btn btn-primary" id="btn-add"><i class='fa fa-plus-square'></i> &nbsp; Stock Opname Baru</button>
					 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
			          <button type="button" id="btn-export" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Export</button>
			      	</div>
		      	</div>
		    <div class="box-body">
		      	<div class="row">
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
			      <div class="col-md-4">
			     	<div class="row">
				     	<div class="col-md-4" style="padding-top:5px;"><label> Jenis Barang </label> </div>
				     	<div class="col-md-8">
				     		<select name="jenisbarang" id="jenisbarang" class="form-control">
			     				<option value="all">All</option>
								<?php foreach ($jenisbaranghabis as $val=>$key ) { ;?>
									<option value="<?php echo $val; ?>" ><?php echo $key; ?></option>
								<?php	} ;?>
					     	</select>
					     </div>	
			     	</div>
				  </div>
			      <div class="col-md-4">
			     	<div class="row">
				     	<div class="col-md-4" style="padding-top:5px;"><label> Bulan </label> </div>
				     	<div class="col-md-8">
				     		<select name="jenisbarang" id="jenisbarang" class="form-control">
			     				<option value="all">All</option>
								<?php foreach ($bulan as $val=>$key ) { ;?>
									<option value="<?php echo $val; ?>" ><?php echo $key; ?></option>
								<?php	} ;?>
					     	</select>
					     </div>	
			     	</div>
				  </div>
				</div>
			</div>
		</div>
        <div class="box-body">
		    <div class="div-grid">
		        <div id="jqxgridOpname"></div>
			</div>
    	</div>
      </div>
  </div>
</div>
</form>
</section>

<script type="text/javascript">

	function close_popup(){
	$("#popup_barang").jqxWindow('close');
	}
	$(function () {	
		$("select[name='jenisbarang']").change(function(){
			$.post("<?php echo base_url().'inventory/bhp_opname/filter_jenisbarang' ?>", 'jenisbarang='+$(this).val(),  function(){
				$("#jqxgridOpname").jqxGrid('updatebounddata', 'cells');
			});
		});
	    $("#menu_bahan_habis_pakai").addClass("active");
	    $("#menu_inventory_bhp_opname").addClass("active");
	});
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_inv_inventaris_habispakai_opname', type: 'string' },
			{ name: 'code_cl_phc', type: 'string' },
			{ name: 'jenis_bhp', type: 'string' },
			{ name: 'petugas_nip', type: 'string' },
			{ name: 'petugas_nama', type: 'string' },
			{ name: 'catatan', type: 'number' },
			{ name: 'tgl_opname', type: 'date' },
			{ name: 'nomor_opname', type: 'string' },
			{ name: 'no', type: 'string' },
			{ name: 'edit', type: 'number' },
			{ name: 'delete', type: 'number' },
        ],
		url: "<?php echo site_url('inventory/bhp_opname/json'); ?>",
		cache: false,
			updateRow: function (rowID, rowData, commit) {
             
         },
		filter: function(){
			$("#jqxgridOpname").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridOpname").jqxGrid('updatebounddata', 'sort');
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
			$("#jqxgridOpname").jqxGrid('clearfilters');
		});

		$("#jqxgridOpname").jqxGrid(
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
				{ text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgridOpname").jqxGrid('getrowdata', row)
				    if((dataRecord.edit==1)){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='editopname(\""+dataRecord.id_inv_inventaris_habispakai_opname+"\",\""+dataRecord.jenis_bhp+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgridOpname").jqxGrid('getrowdata', row);
				    if(dataRecord.delete==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_inv_inventaris_habispakai_opname+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php  echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Nomor', editable:false ,datafield: 'nomor_opname', columntype: 'textbox', filtertype: 'textbox', width: '16%' },
				{ text: 'Tanggal', align: 'center', cellsalign: 'center', columngroup: 'update',editable: false,datafield: 'tgl_opname', columntype: 'date', filtertype: 'none', cellsformat: 'dd-MM-yyyy', width: '10%'},
				{ text: 'Jenis Barang', editable:false ,align: 'center', datafield: 'jenis_bhp', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Nama Petugas', editable:false ,align: 'center', cellsalign: 'right', datafield: 'petugas_nama', columntype: 'textbox', filtertype: 'textbox', width: '25%' },
				{ text: 'NIP Petugas', editable:false ,align: 'center', cellsalign: 'right', datafield: 'petugas_nip', columntype: 'textbox', filtertype: 'textbox', width: '16%' },
				{ text: 'Catatan', editable:false ,datafield: 'catatan', columntype: 'textbox', filtertype: 'textbox', width: '13%' ,align: 'center', cellsalign: 'right'}
            ]
		});
	  function timeline_pengeluaran_barang(id){
	    $.get("<?php echo base_url();?>inventory/bhp_opname/timeline_pengeluaran_barang/"+id , function(response) {
	      $("#timeline-barang").html(response);
	    });
	  }
	function editopname(id,jenis){
		var idjenis = '0';
		if (jenis.toLowerCase()=="obat") {
			idjenis = '8';
		}else{
			idjenis = '0';
		}
  		$.ajax({
	        url : '<?php echo site_url('inventory/bhp_opname/edit_opname/') ?>',
	        type : 'POST',
	        data : 'id=' + id+'&idjenis='+idjenis,
	        success : function(data) {
	          	$('#addopname').html(data);
	          	$('#grid').hide();
	        }
     	});

      return false;
	}

	function del(id){
		$("#popup_barang #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url().'inventory/bhp_opname/kondisi_barang/'; ?>"+id , function(data) {
			timeline_kondisi_barang(id);
			$("#popup_content").html(data);
		});
		$("#popup_barang").jqxWindow({
			theme: theme, resizable: false,
			width: 500,
			height: 600,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_barang").jqxWindow('open');
	}
	
	$('#btn-add').click(function(){
		var opname = '';
  		$.ajax({
	        url : '<?php echo site_url('inventory/bhp_opname/add_opname/') ?>',
	        type : 'POST',
	        data : 'opname=' + opname,
	        success : function(data) {
	          	$('#addopname').html(data);
	          	$('#grid').hide();
	        }
     	});

      return false;

  	});

	$("#btn-export").click(function(){
		
		var post = "";
		var filter = $("#jqxgridOpname").jqxGrid('getfilterinformation');
		for(i=0; i < filter.length; i++){
			var fltr 	= filter[i];
			var value	= fltr.filter.getfilters()[0].value;
			var condition	= fltr.filter.getfilters()[0].condition;
			var filteroperation	= fltr.filter.getfilters()[0].operation;
			var filterdatafield	= fltr.filtercolumn;
			post = post+'&filtervalue'+i+'='+value;
			post = post+'&filtercondition'+i+'='+condition;
			post = post+'&filteroperation'+i+'='+filteroperation;
			post = post+'&filterdatafield'+i+'='+filterdatafield;
			post = post+'&'+filterdatafield+'operator=and';
		}
		post = post+'&filterscount='+i;
		
		var sortdatafield = $("#jqxgridOpname").jqxGrid('getsortcolumn');
		if(sortdatafield != "" && sortdatafield != null){
			post = post + '&sortdatafield='+sortdatafield;
		}
		if(sortdatafield != null){
			var sortorder = $("#jqxgridOpname").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgridOpname").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
			post = post+'&sortorder='+sortorder;
			
		}
		post = post+'&jenisbarang='+$("#jenisbarang option:selected").text()+'&nama_puskesmas='+$("#puskesmas option:selected").text();
		
		$.post("<?php echo base_url()?>inventory/bhp_opname/pengeluaran_export",post,function(response	){
			window.location.href=response;
		});
	});
</script>