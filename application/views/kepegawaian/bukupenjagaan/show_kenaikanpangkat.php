
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
			 	<button type="button" class="btn btn-success" id="btn-refresh-pangkat"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
	          <button type="button" id="btn-export-pangkat" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Export</button> 
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
		        <div id="jqxgridPangkat"></div>
			</div>
    	</div>
      </div>
  </div>
</div>
</form>
</section>
<style type="text/css">
    .redClass
    {
        background-color: #FF9595;
    }
</style>
<script type="text/javascript">
	$(function () {	
	    $("#menu_kepegawaian").addClass("active");
	    $("#menu_kepegawaian_bukupenjagaan").addClass("active");
	});
	var tmtteakhir = "<?php echo $tmtteakhir; ?>";
	var splittmtterakhir = tmtteakhir.split('-');
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
			{ name: 'tmt', type: 'date'},
			{ name: 'tmtdata', type: 'string'},
			{ name: 'id_mst_peg_golruang', type: 'string'},
			{ name: 'ruang', type: 'string'},
			{ name: 'detail', type: 'number'}
        ],
		url: "<?php echo site_url('kepegawaian/bukupenjagaan/json'); ?>",
		cache: false,
			updateRow: function (rowID, rowData, commit) {
             
         },
		filter: function(){
			$("#jqxgridPangkat").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgridPangkat").jqxGrid('updatebounddata', 'sort');
		},

		root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){		
			if (data != null){
				source.totalrecords = data[0].TotalRows;					
			}
		}
		};	
		var cellclass = function (row, column, value, data) {
			if (data.tmt != null) {
				var th = data.tmtdata.split('-');
				var thsk = "<?php echo date('Y');?>";
	            if (parseInt(th[0])+4 <= thsk ) {
	                return "redClass";
	            }
			}
        };		
		var dataadapter = new $.jqx.dataAdapter(source, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});
     
		$('#btn-refresh-pangkat').click(function () {
			$("#jqxgridPangkat").jqxGrid('clearfilters');
		});

		$("#jqxgridPangkat").jqxGrid(
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
				//     var dataRecord = $("#jqxgridPangkat").jqxGrid('getrowdata', row);
				//     if(dataRecord.detail==1){
				// 		return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+dataRecord.id_inv_hasbispakai_permintaan+"\");'></a></div>";
				// 	}else{
				// 		return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lockdo.gif'></a></div>";
				// 	}
    //              }
    //             },
    			{ text: 'No', editable:false ,align: 'center', cellsalign: 'center', datafield: 'no', columntype: 'textbox', filtertype: 'none', width: '5%',sortable: false,cellclassname: cellclass },
    			{ text: 'Nip', editable:false ,align: 'center', cellsalign: 'left', datafield: 'nip_nit', columntype: 'textbox', filtertype: 'textbox', width: '15%',cellclassname: cellclass },
    			{ text: 'Nama', editable:false ,align: 'center', cellsalign: 'left', datafield:'nama', columntype: 'textbox', filtertype: 'textbox', width: '18%',cellclassname: cellclass },
				{ text: 'Pangkat', editable:false ,align: 'center', cellsalign: 'left', datafield: 'ruang', columntype: 'textbox', filtertype: 'textbox', width: '17%',cellclassname: cellclass },
				// { text: 'Tgl. Lahir',editable:false , align: 'center', cellsalign: 'center', datafield: 'tgl_lhr', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', width: '8%',cellclassname: cellclass },
				{ text: 'TMT',editable:false , align: 'center', cellsalign: 'center', datafield: 'tmt', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', width: '8%',cellclassname: cellclass },
				<?php 
					$tmtakhir = explode("-", date("Y-m-d"));
					for($i=$tmtakhir[0]; $i<=$tmtakhir[0]+5;$i++){
				?>
				{ text: 'Apr',cellclassname: cellclass,columngroup: '<?php echo $i; ?>', editable:false ,sortable: false,align: 'center', cellsalign: 'left',  columntype: 'textbox', filtertype: 'none', width: '4%',cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgridPangkat").jqxGrid('getrowdata', row);
				    	if (dataRecord.tmtdata !=null) {
					    	var tmtakhir = dataRecord.tmtdata.split('-');
					    	if (parseInt(tmtakhir[0])+4 == <?php echo $i;?>  && parseInt(tmtakhir[1]) =='4') {
							return "<div style='width:100%;padding-top:4px;text-align:center'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></div>";
							}
						}
					}
				},
				{ text: 'Okt',cellclassname: cellclass,columngroup: '<?php echo $i; ?>',sortable: false, editable:false ,align: 'center', cellsalign: 'left',  columntype: 'textbox', filtertype: 'none', width: '4%' ,  columntype: 'textbox', filtertype: 'none', width: '5%',cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgridPangkat").jqxGrid('getrowdata', row);
				    	if (dataRecord.tmtdata !=null) {
					    	var tmtakhir = dataRecord.tmtdata.split('-');
					    	if (parseInt(tmtakhir[0])+4 == <?php echo $i;?> && parseInt(tmtakhir[1]) =='10' ) {
							return "<div style='width:100%;padding-top:4px;text-align:center'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></div>";
							}
						}
					}
				},
				<?php } ?>
				
            ],
			columngroups: 
	        [
	        	<?php 
					$tmtakhirdata = explode("-", date("Y-m-d"));
					for($i=$tmtakhirdata[0]; $i<=$tmtakhirdata[0]+5;$i++){
				?>
	          	{ text: '<?php echo $i; ?>',align: 'center', name: '<?php echo $i; ?>' },
	          	<?php } ?>
	        ]
		});

	function detail(id){
		document.location.href="<?php echo base_url().'kepegawaian/bukupenjagaan/detail';?>/" + id ;
	}


	$("#btn-export-pangkat").click(function(){
		
		var post = "";
		// var filter = $("#jqxgridPangkat").jqxGrid('getfilterinformation');
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
		
		// var sortdatafield = $("#jqxgridPangkat").jqxGrid('getsortcolumn');
		// if(sortdatafield != "" && sortdatafield != null){
		// 	post = post + '&sortdatafield='+sortdatafield;
		// }
		// if(sortdatafield != null){
		// 	var sortorder = $("#jqxgridPangkat").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgridPangkat").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
		// 	post = post+'&sortorder='+sortorder;
			
		// }
		post = post+'&puskes='+$("#puskesmas option:selected").text();
		
		$.post("<?php echo base_url()?>kepegawaian/bukupenjagaan/permintaan_export_pangkat",post,function(response	){
			// alert(response);
			window.location.href=response;
		});
	});
</script>