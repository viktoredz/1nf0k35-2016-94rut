
<script>
	$(function(){

	   var source_opanemkanan = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'inv_inventaris_habispakai_opname_item', type: 'string' },
			{ name: 'id_mst_inv_barang_habispakai', type: 'number' },
			{ name: 'uraian', type: 'string' },
			{ name: 'jml_awal', type: 'number' },
			{ name: 'jml_akhir', type: 'string' },
			{ name: 'batch', type: 'string' },
			{ name: 'harga', type: 'string' },
			{ name: 'selisih', type: 'string' },
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('inventory/bhp_pemusnahan/json_opname_dalam/'.$kode_opname); ?>",
		cache: false,
		updateRow: function (rowID, rowData, commit) {
         },
		filter: function(){
			$("#jqxgrid_barang_opname_kiri").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid_barang_opname_kiri").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){		
			if (data != null){
				source_opanemkanan.totalrecords = data[0].TotalRows;					
			}
		}
		};		
		var dataadapter_opnamekanan = new $.jqx.dataAdapter(source_opanemkanan, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});
     
		$("#jqxgrid_barang_opname_kiri").jqxGrid(
		{	
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter_opnamekanan, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
			showfilterrow: false, filterable: false, sortable: true, autoheight: true, pageable: false, virtualmode: true, editable: true,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},

			columns: [
			<?php if ($jenis_bhp=="8") { ?>
				{ text: 'Nama Barang ', editable: false,datafield: 'uraian', columntype: 'textbox', filtertype: 'textbox', width: '40%'},
				{ text: 'Batch ',datafield: 'batch' ,align: 'center', editable: false, columntype: 'textbox', filtertype: 'textbox', width: '20%'},
				{ text: 'Jumlah Akhir ', align: 'center',cellsalign: 'right',editable: false,datafield: 'jml_akhir', columntype: 'textbox', filtertype: 'textbox', width: '15%'},
				{ text: 'Selisih ', align: 'center',cellsalign: 'right',editable: false,datafield: 'selisih', columntype: 'textbox', filtertype: 'textbox', width: '15%'},
			<?php }else{
				?>
				{ text: 'Nama Barang ', editable: false,datafield: 'uraian', columntype: 'textbox', filtertype: 'textbox', width: '50%'},
				{ text: 'Jumlah Akhir ', align: 'center',cellsalign: 'right',editable: false,datafield: 'jml_akhir', columntype: 'textbox', filtertype: 'textbox', width: '20%'},
				{ text: 'Selisih ', align: 'center',cellsalign: 'right',editable: false,datafield: 'selisih', columntype: 'textbox', filtertype: 'textbox', width: '20%'},
				<?php } ?>
				{ text: 'Hapus', align: 'center', editable: false,filtertype: 'none', sortable: false, width: '10%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid_barang_opname_kiri").jqxGrid('getrowdata', row);
				    if (dataRecord.edit==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del_barang(\""+dataRecord.id_mst_inv_barang_habispakai+"\",\""+dataRecord.batch+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
           ]
		});
        
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid_barang_opname_kiri").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton').click(function () {
			$("#jqxgrid_barang_opname_kiri").jqxGrid('updatebounddata', 'cells');
		});


	});
	function close_popup_master(){
		$("#popup_barang_opname_kiri").jqxWindow('close');
		$("#jqxgrid_barang_opname_kanan").jqxGrid('updatebounddata', 'cells');
		$("#jqxgrid_barang_opname_kiri").jqxGrid('updatebounddata', 'cells');
	}
	
	function del_barang(id_barang,kode_batch){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'inventory/bhp_pemusnahan/dodelpermohonan/'.$kode_opname.'/'; ?>" + id_barang+'/'+kode_batch,  function(){
				alert('Data berhasil dihapus');
				$("#jqxgrid_barang_opname_kiri").jqxGrid('updatebounddata', 'cells');
				$("#jqxgrid_barang_opname_kanan").jqxGrid('updatebounddata', 'cells');
			});
			
		}
	}
	$("#btn-masteropname_baru").click(function(){
		pilih_opname_master($("#jenis_bhp").val());
	});
	function pilih_opname_master(jenis){
		if (jenis.toLowerCase()=="obat") {
			idjenis = '8';
		}else{
			idjenis = '0';
		}
		$("#popup_barang_opname_kiri #popup_content_opname_kiri").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url().'inventory/bhp_pemusnahan/add_barang_opnamemaster/'.$kode_opname.'/'?>"+idjenis, function(data) {
			$("#popup_content_opname_kiri").html(data);
		});
		$("#popup_barang_opname_kiri").jqxWindow({
			theme: theme, resizable: false,
			width: 600,
			height: 500,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_barang_opname_kiri").jqxWindow('open');
	}
</script>

<div id="popup_barang_opname_kiri" style="display:none">
	<div id="popup_title_opname_kiri">Data Opname Barang Master</div>
	<div id="popup_content_opname_kiri">&nbsp;</div>
</div>

<div>
	<div align="right">
	<button type="button" id="btn-masteropname_baru" class="btn btn-success"><i class='fa fa-plus-square'></i> &nbsp;Tambah</button>
	</div>
	<div class="box-body">
		<div style="width:100%;">
	        <div id="jqxgrid_barang_opname_kiri"></div>
		</div>
	</div>
</div>