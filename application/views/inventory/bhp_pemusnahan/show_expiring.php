<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<div id="popup_barang_bhp" style="display:none">
	<div id="popup_title">Detail Opname Barang</div>
	<div id="popup_content_bhp">&nbsp;</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>inventory/bhp_opname/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
	      	<div class="box-footer">
		      	<div class="row"> 
			      	<div class="col-md-12">
					 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
			          <button type="button" id="btn-export" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Export</button>
			      	</div>
		      	</div>
		    <div class="box-body">
		      	<div class="row">
			      <div class="col-md-6">
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
			      <div class="col-md-3">
			     	<div class="row">
				     	<div class="col-md-4" style="padding-top:5px;"><label> Bulan </label> </div>
				     	<div class="col-md-8">
				     		<select name="bulan" id="bulan" class="form-control">
								<?php foreach ($bulan as $val=>$key ) { ;?>
								<?php $select = $val == date("m") ? 'selected=selected' : '' ?>
									<option value="<?php echo $val; ?>" <?php echo $select ?>><?php echo $key; ?></option>
								<?php	} ;?>
					     	</select>
					     </div>	
			     	</div>
				  </div>	
				  <div class="col-md-3">
			     	<div class="row">
				     	<div class="col-md-4" style="padding-top:5px;"><label> Tahun </label> </div>
				     	<div class="col-md-8">
				     		<select name="tahun" id="tahun" class="form-control">
								<?php for ($i=date("Y");$i>=date("Y")-10;$i--) { ;?>
									<?php $select = $i == date("Y") ? 'selected=selected' : '' ?>
									<option value="<?php echo $i; ?>" <?php echo $select ?>><?php echo $i; ?></option>
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
		        <div id="jqxgridExpiring"></div>
			</div>
    	</div>
      </div>
  </div>
</div>
</form>
</section>

<script type="text/javascript">

	function close_popup_bhp(){
	$("#popup_barang_bhp").jqxWindow('close');
	}
	$(function () {	
		$("select[name='jenisbarang']").change(function(){
			$.post("<?php echo base_url().'inventory/bhp_opname/filter_jenisbarang' ?>", 'jenisbarang='+$(this).val(),  function(){
				$("#jqxgridExpiring").jqxGrid('updatebounddata', 'cells');
			});
		});
		$("select[name='bulan']").change(function(){
			$.post("<?php echo base_url().'inventory/bhp_opname/filter_bulan' ?>", 'bulan='+$(this).val(),  function(){
				$("#jqxgridExpiring").jqxGrid('updatebounddata', 'cells');
			});
		});
		$("select[name='tahun']").change(function(){
			$.post("<?php echo base_url().'inventory/bhp_opname/filter_tahun' ?>", 'tahun='+$(this).val(),  function(){
				$("#jqxgridExpiring").jqxGrid('updatebounddata', 'cells');
			});
		});
	});
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_inv_inventaris_habispakai_opname', type: 'string' },
			{ name: 'id_mst_inv_barang_habispakai', type: 'string' },
			{ name: 'batch', type: 'string' },
			{ name: 'uraian', type: 'string' },
			{ name: 'jml_awal', type: 'number' },
			{ name: 'jml_akhir', type: 'number' },
			{ name: 'jmlawal_opname', type: 'number' },
			{ name: 'jmlakhir_opname', type: 'number' },
			{ name: 'sumselisih', type: 'number' },
			{ name: 'harga', type: 'string' },
			{ name: 'merek_tipe', type: 'string' },
			{ name: 'tgl_opname', type: 'string' },
			{ name: 'jml_selisih', type: 'number' }
        ],
		url: "<?php echo site_url('inventory/bhp_opname/json_opname'); ?>",
		cache: false,
			updateRow: function (rowID, rowData, commit) {
             
         },
		filter: function(){
			$("#jqxgridExpiring").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridExpiring").jqxGrid('updatebounddata', 'sort');
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
			$("#jqxgridExpiring").jqxGrid('clearfilters');
		});

		$("#jqxgridExpiring").jqxGrid(
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
				{ text: 'Nama Sediaan', editable:false ,datafield: 'uraian', columntype: 'textbox', filtertype: 'textbox', width: '45%' },
				{ text: 'Batch', align: 'center',cellsalign: 'center', editable:false ,datafield: 'batch', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Tgl Kadaluarsa', align: 'center', cellsalign: 'center', columngroup: 'update',editable: false,datafield: 'tgl_opname', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', width: '11%'},
				{ text: 'Lama', align: 'center', filtertype: 'none', editable:false , columntype: 'textbox', width: '11%' },
				{ text: 'Jumlah',sortable: false,editable:false ,datafield: 'sumselisih', columntype: 'textbox', filtertype: 'text', width: '11%' ,align: 'center', cellsalign: 'right'},
				{ text: 'Sumber Dana', editable:false ,columntype: 'textbox', width: '12%' ,align: 'center', cellsalign: 'right'}
            ]
		});
	  function timeline_pengeluaran_barang(id){
	    $.get("<?php echo base_url();?>inventory/bhp_opname/timeline_pengeluaran_barang/"+id , function(response) {
	      $("#timeline-barang").html(response);
	    });
	  }
	
	function add(id,barang,batch){
		$("#popup_barang_bhp #popup_content_bhp").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url().'inventory/bhp_opname/detailbhp/'; ?>"+id+'/'+barang+'/'+batch , function(data) {
			$("#popup_content_bhp").html(data);
		});
		$("#popup_barang_bhp").jqxWindow({
			theme: theme, resizable: false,
			width: 1100,
			height: 570,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_barang_bhp").jqxWindow('open');
	}

	$("#btn-export").click(function(){
		
		var post = "";
		/*var filter = $("#jqxgridExpiring").jqxGrid('getfilterinformation');

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
		
		var sortdatafield = $("#jqxgridExpiring").jqxGrid('getsortcolumn');
		if(sortdatafield != "" && sortdatafield != null){
			post = post + '&sortdatafield='+sortdatafield;
		}
		if(sortdatafield != null){
			var sortorder = $("#jqxgridExpiring").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgridExpiring").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
			post = post+'&sortorder='+sortorder;
			
		}*/
		post = post+'&jenisbarang='+$("#jenisbarang option:selected").text()+'&nama_puskesmas='+$("#puskesmas option:selected").text()+'&bulan='+$("#bulan option:selected").text()+'&tahun='+$("#tahun option:selected").text();
		//alert(post);
		
		$.post("<?php echo base_url()?>inventory/bhp_opname/laporan_opname",post,function(response	){
			//alert(response);
			window.location.href=response;
		});
	});
</script>