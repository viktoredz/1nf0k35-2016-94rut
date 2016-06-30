
<section class="content">
<form action="<?php echo base_url()?>kepegawaian/bukupenjagaan/dodel_multi" method="POST" name="">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
	        <!-- <div class="box-header">
	          <h3 class="box-title">{title_form}</h3>
		    </div> -->
	      	<div class="box-footer">
		      <div class="col-md-8">
			 	<!-- <button type="button" class="btn btn-primary" onclick="document.location.href='<?php echo base_url()?>kepegawaian/bukupenjagaan/add'"><i class='fa fa-plus-square-o'></i> &nbsp; Permintaan / Permohonan Baru</button>-->
			 	<button type="button" class="btn btn-success" id="btn-refresh-pensiun"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
	          <button type="button" id="btn-export-pensiun" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Export</button> 
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
		        <div id="jqxgridPensiun"></div>
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
			{ name: 'id_pegawai', type: 'string'},
			{ name: 'tgl_lhr', type: 'date'},
			{ name: 'code_cl_phc', type: 'string'},
			{ name: 'no', type: 'string'},
			{ name: 'nik', type: 'string'},
			{ name: 'nama', type: 'string'},
			{ name: 'tmp_lahir', type: 'string'},
			{ name: 'nip_nit', type: 'string'},
			{ name: 'tahunpensiun', type: 'string'},
			{ name: 'bulanpensiun', type: 'string'},
			{ name: 'nip_nit', type: 'string'},
			{ name: 'tmt', type: 'date'},
			{ name: 'tmtdata', type: 'string'},
			{ name: 'keterangan', type: 'string'},
			{ name: 'id_mst_peg_golruang', type: 'string'},
			{ name: 'ruang', type: 'string'},
			{ name: 'detail', type: 'number'}
        ],
		url: "<?php echo site_url('kepegawaian/bukupenjagaan/json'); ?>",
		cache: false,
			updateRow: function (rowID, rowData, commit) {
             
         },
		filter: function(){
			$("#jqxgridPensiun").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridPensiun").jqxGrid('updatebounddata', 'sort');
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
     
		$('#btn-refresh-pensiun').click(function () {
			$("#jqxgridPensiun").jqxGrid('clearfilters');
		});

		$("#jqxgridPensiun").jqxGrid(
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
				//     var dataRecord = $("#jqxgridPensiun").jqxGrid('getrowdata', row);
				//     if(dataRecord.detail==1){
				// 		return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+dataRecord.id_inv_hasbispakai_permintaan+"\");'></a></div>";
				// 	}else{
				// 		return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lockdo.gif'></a></div>";
				// 	}
    //              }
    //             },
    			{ text: 'No', editable:false ,align: 'center', cellsalign: 'center', datafield: 'no', columntype: 'textbox', filtertype: 'none', width: '5%', sortable: false},
    			{ text: 'Nip', editable:false ,align: 'center', cellsalign: 'left', datafield: 'nip_nit', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
    			{ text: 'Nama', editable:false ,align: 'center', cellsalign: 'left', datafield:'nama', columntype: 'textbox', filtertype: 'textbox', width: '25%' },
				{ text: 'Tempat Lahir', editable:false ,align: 'center', cellsalign: 'left', datafield: 'tmp_lahir', columntype: 'textbox', filtertype: 'textbox', width: '12%' },
				{ text: 'Tgl. Lahir',editable:false , align: 'center', cellsalign: 'center', datafield: 'tgl_lhr', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', width: '9%' },
				{ text: 'TMT',editable:false , align: 'center', cellsalign: 'center', datafield: 'tmt', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', width: '9%' },
				{ text: 'Bulan', editable:false ,align: 'center', cellsalign: 'center', datafield: 'bulanpensiun', columntype: 'textbox', filtertype: 'none',sortable: false, width: '10%' },
				{ text: 'Tahun', editable:false ,align: 'center', cellsalign: 'center', datafield: 'tahunpensiun', columntype: 'textbox', filtertype: 'none',sortable: false, width: '10%' },
				
				
            ],
			columngroups: 
	        [
	          	{ text: 'Bulan',align: 'center', name: 'bulan' },
	          	{ text: 'Tahun',align: 'center', name: 'tahun' },
	        ]
		});

	function detail(id){
		document.location.href="<?php echo base_url().'kepegawaian/bukupenjagaan/detail';?>/" + id ;
	}


	$("#btn-export-pensiun").click(function(){
		
		var post = "";
		// var filter = $("#jqxgridPensiun").jqxGrid('getfilterinformation');
		// for(i=0; i < filter.length; i++){
		// 	var fltr 	= filter[i];
		// 	var value	= fltr.filter.getfilters()[0].value;
		// 	var condition	= fltr.filter.getfilters()[0].condition;
		// 	var filteroperation	= fltr.filter.getfilters()[0].operation;
		// 	var filterdatafield	= fltr.filtercolumn;
		// 	if(filterdatafield=="tmt"){
		// 		var d = new Date(value);
		// 		var day = d.getDate();
		// 		var month = d.getMonth();
		// 		var year = d.getYear();
		// 		value = year+'-'+month+'-'+day;
				
		// 	}
		// 	post = post+'&filtervalue'+i+'='+value;
		// 	post = post+'&filtercondition'+i+'='+condition;
		// 	post = post+'&filteroperation'+i+'='+filteroperation;
		// 	post = post+'&filterdatafield'+i+'='+filterdatafield;
		// 	post = post+'&'+filterdatafield+'operator=and';
		// }
		// post = post+'&filterscount='+i;
		
		// var sortdatafield = $("#jqxgridPensiun").jqxGrid('getsortcolumn');
		// if(sortdatafield != "" && sortdatafield != null){
		// 	post = post + '&sortdatafield='+sortdatafield;
		// }
		// if(sortdatafield != null){
		// 	var sortorder = $("#jqxgridPensiun").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgridPensiun").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
		// 	post = post+'&sortorder='+sortorder;
			
		// }
		post = post+'&puskes='+$("#puskesmas option:selected").text();
		
		$.post("<?php echo base_url()?>kepegawaian/bukupenjagaan/permintaan_export_pensiun",post,function(response	){
			// alert(response);
			window.location.href=response;
		});
	});
</script>