<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>kepegawaian/stuktur_kepegawaian/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
	    </div>

      	<div class="box-footer">
	      <div class="col-md-8">
		 	<button type="button" class="btn btn-warning" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
		 	<button type="button" class="btn btn-success" id="btn-export"><i class='fa fa-file-excel-o'></i> &nbsp; Export</button>
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
	    $("#menu_kepegawaian_stuktur_kepegawaian").addClass("active");
	});
		var sourcejabatan =
	      {
	          datatype: "json",
	          datafields: [
	              { name: 'tar_id_struktur_org' , type: 'string'},
	              { name: 'tar_nama_posisi' , type: 'string'}
	          ],
	          url: '<?php echo base_url()?>kepegawaian/stuktur_kepegawaian/json_kode_jabatan',
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
			{ name: 'nama', type: 'string'},
			{ name: 'id_mst_peg_golruang', type: 'string'},
			{ name: 'tar_nama_posisi', type: 'string'},
			{ name: 'detail', type: 'number'},
        ],
		url: "<?php echo site_url('kepegawaian/stuktur_kepegawaian/json'); ?>",
		cache: false,
		updateRow: function (rowID, rowData, commit) {
            commit(true);

            // var arr = $.map(rowData, function(el) { return el });   
            // alert(arr) ;
            // if(typeof(arr[1]) === 'object'){
            //   var arr2 = $.map(arr[1], function(el) { return el });
            //   if(arr[4] + '' + arr[5] + '' + arr[6] + '' + arr[7]!='') {
            //     $.post( '<?php echo base_url()?>kepegawaian/stuktur_kepegawaian/update', {code_cl_phc:arr[2],id_pegawai:arr2[0], namajabatan:arr[7], kode_anggaran:arr[4], uraian : arr[5], tarif : arr[6], id_mst_anggaran_versi : arr[0]}, function( data ) {
            //         if(data != 0){
            //           alert(data);                  
            //         }else{
            //           alert("Data "+arr[5]+" berhasil disimpan");                  
            //         }
            //     });
            //   }
            // }else{      
            //   $.post( '<?php echo base_url()?>kepegawaian/stuktur_kepegawaian/jabatan_update', 
            //     {
            //       row:rowID,
            //       code_cl_phc:arr[0] ,
            //       id_pegawai:arr[1], 
            //       namajabatan:arr[3], 
            //     },
            //     function( data ) {
            //       if(data != 0){
            //         alert(data);
            //       }
            //   });
            // }
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
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='edit(\""+dataRecord.id_inv_permohonan_barang+"\",\""+dataRecord.code_cl_phc+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				
				{ text: 'NIP', datafield: 'nip_nit', columntype: 'textbox', editable:false, filtertype: 'textbox', align: 'center' , cellsalign: 'center', width: '20%'},
				{ text: 'Nama', datafield: 'nama', columntype: 'textbox', editable:false, filtertype: 'textbox', align: 'center', width: '29%' },
				{ text: 'Golongan', align: 'center', cellsalign: 'center', editable:false ,datafield: 'id_mst_peg_golruang', columntype: 'textbox', filtertype: 'textbox', width: '16%' },
				{
	                text: '<b><i class="fa fa-pencil-square-o"></i> Jabatan </b>', align: 'center', cellsalign: 'center', datafield: 'tar_nama_posisi', width: '27%', columntype: 'dropdownlist',
	                createEditor: function (row, cellvalue, editor, cellText, width, height) {
                       editor.jqxDropDownList({autoDropDownHeight: true,source: kode_jabatan_source, displayMember: "tar_nama_posisi", valueMember: "tar_nama_posisi",selectedIndex: "tar_id_struktur_org"});

                   },
                   initEditor: function (row, cellvalue, editor, celltext, width, height) {
                       editor.jqxDropDownList('selectItem', cellvalue);
                   },
                   getEditorValue: function (row, cellvalue, editor) {
                       editor.val();
                       var datagrid = $("#jqxgrid").jqxGrid('getrowdata', row);
                       $.post( '<?php echo base_url()?>kepegawaian/stuktur_kepegawaian/updatestatus', {namajabatan:editor.val(),code_cl_phc:datagrid.code_cl_phc,id_pegawai:datagrid.id_pegawai}, function( data ) {
				            if(data != 0){
				              //alert(data);            
				              $("#jqxgrid").jqxGrid('updatebounddata', 'cells');      
				            }else{
				             // alert("Data berhasil disimpan"); 
				              $("#jqxgrid").jqxGrid('updatebounddata', 'cells');                 
				            }
				        });
                   },

                },
            ]
		});

	function detail(id,code_cl_phc){
		document.location.href="<?php echo base_url().'kepegawaian/stuktur_kepegawaian/detail';?>/" + id + "/" + code_cl_phc;
	}
	function simpan(kode){

	}
	function edit(id,code_cl_phc){
		document.location.href="<?php echo base_url().'kepegawaian/stuktur_kepegawaian/edit';?>/" + id + "/" + code_cl_phc;
	}

	function view(id,code_cl_phc){
		document.location.href="<?php echo base_url().'kepegawaian/stuktur_kepegawaian/view';?>/" + id + "/" + code_cl_phc;
	}

	function del(id,code_cl_phc){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'kepegawaian/stuktur_kepegawaian/dodel' ?>/" + id + "/" + code_cl_phc,  function(){
				alert('data berhasil dihapus');

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
	}
	$("select[name='code_cl_phc']").change(function(){
		$.post("<?php echo base_url().'kepegawaian/stuktur_kepegawaian/filter' ?>", 'code_cl_phc='+$(this).val(),  function(){
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
		
		$.post("<?php echo base_url()?>kepegawaian/stuktur_kepegawaian/permohonan_export",post,function(response	){
			window.location.href=response;
		});
	});
</script>











