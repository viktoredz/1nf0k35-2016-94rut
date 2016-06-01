
<script>
	$(function(){
		var sourceskp = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_mst_peg_struktur_org', type: 'string'},
      { name: 'tugas', type: 'string'},
      { name: 'id_mst_peg_struktur_skp', type: 'string'},
      { name: 'ak', type: 'string'},
      { name: 'kuant', type: 'string'},
      { name: 'output', type: 'string'},
      { name: 'target', type: 'string'},
      { name: 'waktu', type: 'string'},
      { name: 'biaya', type: 'string'},
      { name: 'code_cl_phc', type: 'string'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/penilaiandppp/json_dppp/{tar_id_struktur_org}'); ?>",
    cache: false,
      updateRow: function (rowID, rowData, commit) {
             
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
        sourceskp.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadapterskp = new $.jqx.dataAdapter(sourceskp, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $('#btn-refresh-skp').click(function () {
      $("#jqxgrid").jqxGrid('clearfilters');
    });

    $("#jqxgrid").jqxGrid(
    {   
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadapterskp, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: true,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },
      columns: [
       
        { text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '6%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit_skp(\""+dataRecord.id_mst_peg_struktur_org+"\",\""+dataRecord.id_mst_peg_struktur_skp+"\",\""+dataRecord.code_cl_phc+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '6%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del_skp(\""+dataRecord.id_mst_peg_struktur_org+"\",\""+dataRecord.id_mst_peg_struktur_skp+"\",\""+dataRecord.code_cl_phc+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Tugas', editable:false ,datafield: 'tugas', columntype: 'textbox', filtertype: 'textbox', width: '36%' },
        { text: 'Target',editable:false , align: 'center', cellsalign: 'center', datafield: 'target', columntype: 'textbox', filtertype: 'textbox',  width: '15%' },
        { text: 'Waktu', editable:false ,align: 'center', cellsalign: 'center', datafield: 'waktu', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
        { text: 'Biaya', editable:false ,align: 'center', cellsalign: 'right', datafield: 'biaya', columntype: 'textbox', filtertype: 'textbox', width: '22%' }
            ]
    });
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton').click(function () {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});

 		$('#btn_add_dppp').click(function () {
			add_dppp();
		});

	});
	function close_popup(){
		$("#popup_dppp").jqxWindow('close');
		ambil_total();
	}

	function add_dppp(){
		$("#popup_dppp #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url().'kepegawaian/penilaiandppp/add_dppp/'.$tar_id_struktur_org.'/0/'.$code_cl_phc; ?>" , function(data) {
			$("#popup_content").html(data);
		});
		$("#popup_dppp").jqxWindow({
			theme: theme, resizable: false,
			width: 700,
			height: 700,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_dppp").jqxWindow('open');
	}

	function edit_dppp(kode,code_cl_phc,id_inv_permohonan_dppp_item){
		$("#popup_dppp #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url().'kepegawaian/penilaiandppp/edit_dppp/'.$kode.'/'.$code_cl_phc.'/'; ?>" + id_inv_permohonan_dppp_item, function(data) {
			$("#popup_content").html(data);
		});
		$("#popup_dppp").jqxWindow({
			theme: theme, resizable: false,
			width: 700,
			height: 700,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_dppp").jqxWindow('open');
	}

	function del_dppp(id_inv_permohonan_dppp_item){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'kepegawaian/penilaiandppp/dodelpermohonan/'.$kode.'/'.$code_cl_phc.'/' ?>/" + id_inv_permohonan_dppp_item,  function(){
				alert('Data berhasil dihapus');

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
	}

</script>

<div id="popup_dppp" style="display:none">
	<div id="popup_title">Data dppp</div>
	<div id="popup_content">&nbsp;</div>
</div>

<div>
	<div style="width:100%;">
		<div style="padding:5px" class="pull-right">
			<button class="btn btn-success" id='btn_add_dppp' type='button'><i class='fa fa-plus-square'></i> Tambah Dppp</button>
		</div>
        <div id="jqxgrid"></div>
	</div>
</div>