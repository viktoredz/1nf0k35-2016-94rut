
<script>
	$(function(){
    $("#btn-refresh-datagrid").show();
    $("#btn-export-datagrid").hide();
    $("#simpandatapeniliandppp").hide();
    
		var sourceskp = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_pegawai', type: 'string'},
      { name: 'tahun', type: 'string'},
      { name: 'id_pegawai_penilai', type: 'string'},
      { name: 'id_pegawai_penilai_atasan', type: 'string'},
      { name: 'skp', type: 'string'},
      { name: 'namapegawai', type: 'string'},
      { name: 'nama_penilai', type: 'string'},
      { name: 'namaatasanpenilai', type: 'string'},
      { name: 'pelayanan', type: 'string'},
      { name: 'integritas', type: 'string'},
      { name: 'komitmen', type: 'string'},
      { name: 'disiplin', type: 'string'},
      { name: 'kerjasama', type: 'string'},
      { name: 'kepemimpinan', type: 'string'},
      { name: 'jumlah', type: 'string'},
      { name: 'ratarata', type: 'string'},
      { name: 'nilai_prestasi', type: 'string'},
      { name: 'keberatan_tgl', type: 'date'},
      { name: 'keberatan', type: 'string'},
      { name: 'pelayanan', type: 'string'},
      { name: 'tanggapan', type: 'string'},
      { name: 'tanggapan_tgl', type: 'date'},
      { name: 'keputusan_tgl', type: 'date'},
      { name: 'keputusan', type: 'string'},
      { name: 'rekomendasi', type: 'string'},
      { name: 'tgl_diterima', type: 'date'},
      { name: 'tgl_dibuat', type: 'date'},
      { name: 'tgl_diterima_atasan', type: 'date'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/penilaiandppp/json_dppp/{id_pegawai}'); ?>",
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
     
    $('#btn-refresh-datagrid').click(function () {
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
       
        { text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit_dppp(\""+dataRecord.id_pegawai+"\",\""+dataRecord.tahun+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del_dppp(\""+dataRecord.id_pegawai+"\",\""+dataRecord.tahun+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Tanggal dibuat', editable:false ,align: 'center', cellsalign: 'right', datafield: 'tgl_dibuat', cellsformat: 'dd-MM-yyyy',columntype: 'date', filtertype: 'date', width: '9%' },
        { text: 'Penilai', editable:false ,datafield: 'nama_penilai', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
        { text: 'Atasan Penilai',editable:false , align: 'center',  datafield: 'namaatasanpenilai', columntype: 'textbox', filtertype: 'textbox',  width: '15%' },
        { text: 'Jumlah', editable:false ,align: 'center', cellsalign: 'center', datafield: 'jumlah', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
        { text: 'Rata-rata', editable:false ,align: 'center', cellsalign: 'right', datafield: 'ratarata', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
        { text: 'Nilai Prestasi', editable:false ,align: 'center', cellsalign: 'right', datafield: 'nilai_prestasi', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
        { text: 'Tanggapan', editable:false ,align: 'center', cellsalign: 'center', datafield: 'tanggapan', columntype: 'textbox', filtertype: 'none', width: '7%' },
        { text: 'Keberatan', editable:false ,align: 'center', cellsalign: 'center', datafield: 'keberatan', columntype: 'textbox', filtertype: 'none', width: '7%' },
        { text: 'Keputusan', editable:false ,align: 'center', cellsalign: 'center', datafield: 'keputusan', columntype: 'textbox', filtertype: 'none', width: '7%' },
        { text: 'Rekomendasi', editable:false ,align: 'center', cellsalign: 'center', datafield: 'rekomendasi', columntype: 'textbox', filtertype: 'none', width: '9%' }
            ]
    });
		$('#clearfilteringbutton').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton').click(function () {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
    $("#tambahjqxgrid").hide();
    $("#btn_back_dppp").hide();
 		$('#btn_add_dppp').click(function () {
			add_dppp();
     
		});
    $("#btn_back_dppp").click(function(){
        $("#jqxgrid").show();
        $("#tambahjqxgrid").hide();
        $("#btn_back_dppp").hide();
        $("#btn_add_dppp").show();
        $("#btn-refresh-datagrid").show();
        $("#btn-export-datagrid").hide();
        $("#simpandatapeniliandppp").hide();
    });
	});
	function close_popup(){
		$("#popup_dppp").jqxWindow('close');
		ambil_total();
	}
  
	function add_dppp(){
		$.get("<?php echo base_url().'kepegawaian/penilaiandppp/add_dppp/'.$id_pegawai.'/0/'.$id_mst_peg_struktur_org.'/0'; ?>" , function(data) {
      $("#tambahjqxgrid").show();
			$("#tambahjqxgrid").html(data);
      $("#jqxgrid").hide();
      $("#btn_back_dppp").show();
      $("#btn_add_dppp").hide();
       $("#simpandatapeniliandppp").show();
      $("#btn-export-datagrid").hide();
		});
	}

	function edit_dppp(id_pegawai,tahun){
		$.get("<?php echo base_url().'kepegawaian/penilaiandppp/edit_dppp/'; ?>"+id_pegawai+'/'+tahun+'/'+"<?php echo $id_mst_peg_struktur_org; ?>" , function(data) {
      $("#tambahjqxgrid").show();
      $("#tambahjqxgrid").html(data);
      $("#jqxgrid").hide();
      $("#btn_back_dppp").show();
      $("#btn_add_dppp").hide();
      $("#btn-export-datagrid").show();
    });
	}

	function del_dppp(id_pegawai,tahun){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'kepegawaian/penilaiandppp/dodelpermohonan';?>/" + id_pegawai+'/'+tahun,  function(){
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
<section class="content">
<div class="box-body">
<div>
	<div style="width:100%;">
  <div class="row">
		<div style="padding:5px" class="pull-right">
    <?php 
      if (set_value('username')=='' && isset($username)) {
        $username = $username;
      }else{
        $username = set_value('username');
      }
      $userdataname = $this->session->userdata('username');
      if (($username != $userdataname)) {
      if ($statusanakbuah=='anakbuah')  {
    ?>
			<button class="btn btn-success" id='btn_add_dppp' type='button'><i class='fa fa-plus-square'></i> Tambah DP3</button>
    <?php
      }
      }
    ?>
      <button class="btn btn-warning" id='btn_back_dppp' type='button'><i class='glyphicon glyphicon-arrow-left'></i> Kembali</button>
      <button type="button" class="btn btn-primary" id="btn-refresh-datagrid"><i class='fa fa-save'></i> &nbsp; Refresh</button>
      <button type="button" class="btn btn-success" id="btn-export-datagrid"><i class='fa fa-save'></i> &nbsp; Export</button>
      
		</div>
  </div>
      <div class="row">
        <div id="jqxgrid"></div>
        <div id="tambahjqxgrid"></div>
      </div>
	</div>
</div>
</div>
</section>