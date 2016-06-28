
<section class="content">
<form action="<?php echo base_url()?>kepegawaian/bukupenjagaan/dodel_multi" method="POST" name="">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
	        <!-- <div class="box-header">
	          <h3 class="box-title">{title_form}</h3>
		    </div>
 -->	      	<div class="box-footer">
		      <div class="col-md-8">
			 	<!-- <button type="button" class="btn btn-primary" onclick="document.location.href='<?php echo base_url()?>kepegawaian/bukupenjagaan/add'"><i class='fa fa-plus-square-o'></i> &nbsp; Permintaan / Permohonan Baru</button>
			 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
	          <button type="button" id="btn-export" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Export</button> -->
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
		        <div id="jqxgridGaji"></div>
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
	    $("#menu_kepegawaian_bukupenjagaan").addClass("active");
	});
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_inv_hasbispakai_permintaan', type: 'string'},
			{ name: 'tgl_permintaan', type: 'date'},
			{ name: 'uraian', type: 'string'},
			{ name: 'no', type: 'string'},
			{ name: 'code_cl_phc', type: 'string'},
			{ name: 'pilihan_status_pembelian', type: 'string'},
			{ name: 'status_permintaan', type: 'string'},
			{ name: 'jumlah_unit', type: 'double'},
			{ name: 'total_harga', type: 'double'},
			{ name: 'nilai_pembelian', type: 'double'},
			{ name: 'keterangan', type: 'text'},
			{ name: 'detail', type: 'number'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('kepegawaian/bukupenjagaan/json'); ?>",
		cache: false,
			updateRow: function (rowID, rowData, commit) {
             
         },
		filter: function(){
			$("#jqxgridGaji").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridGaji").jqxGrid('updatebounddata', 'sort');
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
			$("#jqxgridGaji").jqxGrid('clearfilters');
		});

		$("#jqxgridGaji").jqxGrid(
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
				// { text: 'View', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				//     var dataRecord = $("#jqxgridGaji").jqxGrid('getrowdata', row);
				//     if(dataRecord.detail==1){
				// 		return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+dataRecord.id_inv_hasbispakai_permintaan+"\");'></a></div>";
				// 	}else{
				// 		return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lockdo.gif'></a></div>";
				// 	}
    //              }
    //             },
    			{ text: 'No', editable:false ,align: 'center', cellsalign: 'center', datafield: 'no', columntype: 'textbox', filtertype: 'none', width: '5%' },
				{ text: 'Tgl. Permintaan',editable:false , align: 'center', cellsalign: 'center', datafield: 'tgl_permintaan', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', width: '11%' },
				{ text: 'Status Permintaan', editable:false ,align: 'center', cellsalign: 'center', datafield: 'status_permintaan', columntype: 'textbox', filtertype: 'textbox', width: '12%' },
				{ text: 'Kategori Barang', editable:false ,align: 'center', cellsalign: 'center', datafield:'uraian', columntype: 'textbox', filtertype: 'textbox', width: '14%' },
				{ text: 'Jumlah Unit', editable:false ,align: 'center', cellsalign: 'right', datafield: 'jumlah_unit', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Total Harga (Rp.)', editable:false ,align: 'center', cellsalign: 'right', datafield: 'nilai_pembelian', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
				{ text: 'Keterangan', editable:false ,datafield: 'keterangan', columntype: 'textbox', filtertype: 'textbox', width: '25%' }
            ]
		});

	function detail(id){
		document.location.href="<?php echo base_url().'kepegawaian/bukupenjagaan/detail';?>/" + id ;
	}


	$("#btn-export").click(function(){
		
		var post = "";
		var filter = $("#jqxgridGaji").jqxGrid('getfilterinformation');
		for(i=0; i < filter.length; i++){
			var fltr 	= filter[i];
			var value	= fltr.filter.getfilters()[0].value;
			var condition	= fltr.filter.getfilters()[0].condition;
			var filteroperation	= fltr.filter.getfilters()[0].operation;
			var filterdatafield	= fltr.filtercolumn;
			if(filterdatafield=="tgl_permintaan"){
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
		
		var sortdatafield = $("#jqxgridGaji").jqxGrid('getsortcolumn');
		if(sortdatafield != "" && sortdatafield != null){
			post = post + '&sortdatafield='+sortdatafield;
		}
		if(sortdatafield != null){
			var sortorder = $("#jqxgridGaji").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgridGaji").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
			post = post+'&sortorder='+sortorder;
			
		}
		post = post+'&puskes='+$("#puskesmas option:selected").text();
		
		$.post("<?php echo base_url()?>kepegawaian/bukupenjagaan/permintaan_export",post,function(response	){
			//alert(response);
			window.location.href=response;
		});
	});
</script>