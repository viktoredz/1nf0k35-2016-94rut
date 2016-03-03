<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>mst/data_keluarga/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
	    </div>

	      <div class="box-footer">
		 	<button type="button" class="btn btn-primary" onclick="document.location.href='<?php echo base_url()?>eform/data_kepala_keluarga/add'"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah</button>
		 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
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
		$("#menu_ketuk_pintu").addClass("active");
	});
		
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_data_keluarga', type: 'string'},
			{ name: 'tanggal_pengisian', type: 'date'},
			{ name: 'jam_data', type: 'string'},
			{ name: 'alamat', type: 'string'},
			{ name: 'id_propinsi', type: 'string'},
			{ name: 'id_kota', type: 'string'},
			{ name: 'id_kecamatan', type: 'string'},
			{ name: 'value', type: 'string'},
			{ name: 'rt', type: 'string'},
			{ name: 'rw', type: 'string'},
			{ name: 'norumah', type: 'string'},
			{ name: 'nokeluarga', type: 'string'},
			{ name: 'nourutkel', type: 'string'},
			{ name: 'id_kodepos', type: 'string'},
			{ name: 'namadesawisma', type: 'string'},
			{ name: 'id_pkk', type: 'string'},
			{ name: 'namakepalakeluarga', type: 'string'},
			{ name: 'nama_komunitas', type: 'string'},
			{ name: 'notlp', type: 'string'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('eform/data_kepala_keluarga/json'); ?>",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
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

		$("#jqxgrid").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '3%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.edit==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit(\""+dataRecord.id_data_keluarga+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '3%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.delete==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_data_keluarga+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'No. Urut', datafield: 'nourutkel', columntype: 'textbox', filtertype: 'textbox', width: '6%' },
                { text: 'Tanggal Pengisian', datafield: 'tanggal_pengisian', columntype: 'textbox', filtertype: 'date',cellsformat: 'yyyy-MM-dd', width: '12%' },
				{ text: 'Kepala Keluarga', datafield: 'namakepalakeluarga', columntype: 'textbox', filtertype: 'textbox', width: '16%' },
				{ text: 'Desa', datafield: 'value', columntype: 'textbox', filtertype: 'textbox', width: '19%' },
				{ text: 'RT', datafield: 'rt', columntype: 'textbox', filtertype: 'textbox', width: '6%' },
				{ text: 'RW', datafield: 'rw', columntype: 'textbox', filtertype: 'textbox', width: '6%' },
				{ text: 'No. Rumah', datafield: 'norumah', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
				{ text: 'Alamat', datafield: 'alamat', columntype: 'textbox', filtertype: 'textbox', width: '21%' }
			]
		});

	function edit(id){
		document.location.href="<?php echo base_url().'eform/data_kepala_keluarga/edit';?>/" + id;
	}

	function del(id){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'eform/data_kepala_keluarga/dodel' ?>/" + id,  function(){
				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
	}
</script>