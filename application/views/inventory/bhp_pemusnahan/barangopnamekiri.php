<script>
	$(function(){
	   var source_opname = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_inv_inventaris_habispakai_distribusi', type: 'string' },
			{ name: 'id_mst_inv_barang_habispakai', type: 'number' },
			{ name: 'uraian', type: 'string' },
			{ name: 'code_cl_phc', type: 'string' },
			{ name: 'jenis_bhp', type: 'string' },
			{ name: 'tgl_distribusi', type: 'string' },
			{ name: 'id_mst_inv_barang_habispakai_jenis', type: 'string' },
			{ name: 'jml_distribusi', type: 'string' },
			{ name: 'jml_opname', type: 'string' },
			{ name: 'batch', type: 'string' },
			{ name: 'tgl_opname', type: 'double' },
			{ name: 'jmlawal', type: 'string' },
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('inventory/bhp_pemusnahan/json_barang/'.'8'.'/'.$tgl_opname); ?>",
		cache: false,
		updateRow: function (rowID, rowData, commit) {
         },
		filter: function(){
			$("#jqxgrid_barang_opname_kanan").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_barang_opname_kanan").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){		
			if (data != null){
				source_opname.totalrecords = data[0].TotalRows;					
			}
		}
		};		
		var dataadapter_opname = new $.jqx.dataAdapter(source_opname, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});
     
		$("#jqxgrid_barang_opname_kanan").jqxGrid(
		{	
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter_opname, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: true,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},

			columns: [
				{ text: 'Pilih', align: 'center', editable: false,filtertype: 'none', sortable: false, width: '10%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid_barang_opname_kanan").jqxGrid('getrowdata', row);
				    if (dataRecord.edit==1) {
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_add.gif' onclick='pilih_opname_baru(\""+dataRecord.id_mst_inv_barang_habispakai+"\",\""+dataRecord.batch+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
                <?php if ($jenis_bhp=="8") { ?>
				{ text: 'Nama Barang ', editable: false,datafield: 'uraian', columntype: 'textbox', filtertype: 'textbox', width: '50%'},
				{ text: 'Batch ',datafield: 'batch' ,align: 'center', editable: false, columntype: 'textbox', filtertype: 'textbox', width: '20%'},
				{ text: 'Jumlah ', align: 'center',cellsalign: 'right',editable: false,datafield: 'jmlawal', columntype: 'textbox', filtertype: 'textbox', width: '20%'}
				<?php }else{
				?>
				{ text: 'Nama Barang ', editable: false,datafield: 'uraian', columntype: 'textbox', filtertype: 'textbox', width: '60%'},
				{ text: 'Jumlah ', align: 'center',cellsalign: 'right',editable: false,datafield: 'jmlawal', columntype: 'textbox', filtertype: 'textbox', width: '30%'}
				<?php } ?>
           ]
		});
        
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid_barang_opname_kanan").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton').click(function () {
			$("#jqxgrid_barang_opname_kanan").jqxGrid('updatebounddata', 'cells');
		});
 		$('#btn_add_barang_opname').click(function () {
 				add_barang();
		});


	});

	function close_popup_opname_baru(){
		$("#popup_barang_opname_kanan").jqxWindow('close');
		$("#jqxgrid_barang_opname_kanan").jqxGrid('updatebounddata', 'cells');
		$("#jqxgrid_barang_opname_kiri").jqxGrid('updatebounddata', 'cells');
	}
	function pilih_opname_baru(barang,batch){
		$tanggal_opname= $('#tgl_opname').val();
		$("#popup_barang_opname_kanan #popup_content_opname_kanan").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url().'inventory/bhp_pemusnahan/add_barang/'.$tgl_opname.'/'.$kode_opname.'/'; ?>"+barang+'/'+batch, function(data) {
			$("#popup_content_opname_kanan").html(data);
		});
		$("#popup_barang_opname_kanan").jqxWindow({
			theme: theme, resizable: false,
			width: 600,
			height: 500,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_barang_opname_kanan").jqxWindow('open');
	}

</script>

<div id="popup_barang_opname_kanan" style="display:none">
	<div id="popup_title_opname">Data Barang </div>
	<div id="popup_content_opname_kanan">&nbsp;</div>
</div>

<div>
	<div style="width:100%;">
        <div id="jqxgrid_barang_opname_kanan"></div>
	</div>
</div>