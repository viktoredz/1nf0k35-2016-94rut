
<script>
	$(function(){
    $("#btnrefreshdata").hide();
    $("#btnrefreshdata-luar").show();
    $("#btnrexportdata-luar").hide();
		var sourcedppp = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_pegawai', type: 'string'},
      { name: 'tahun', type: 'string'},
      { name: 'periode', type: 'string'},
      { name: 'id_pegawai_penilai', type: 'string'},
      { name: 'skp', type: 'string'},
      { name: 'nama_penilai', type: 'string'},
      { name: 'jumlah', type: 'string'},
      { name: 'ratarata', type: 'string'},
      { name: 'id_mst_peg_struktur_org', type: 'string'},
      { name: 'namaatasanpenilai', type: 'string'},
      { name: 'tgl_dibuat', type: 'date'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/penilaiandppp/json_pengukuran/{id_pegawai}'); ?>",
    cache: false,
      updateRow: function (rowID, rowData, commit) {
             
         },
    filter: function(){
      $("#jqxgridPengukuran").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgridPengukuran").jqxGrid('updatebounddata', 'sort');
    },
    root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){   
      if (data != null){
        sourcedppp.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadapterskp = new $.jqx.dataAdapter(sourcedppp, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $('#btnrefreshdata-luar').click(function () {
      $("#jqxgridPengukuran").jqxGrid('clearfilters');
    });

    $("#jqxgridPengukuran").jqxGrid(
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
       
        { text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridPengukuran").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit_pengukuran(\""+dataRecord.id_pegawai+"\",\""+dataRecord.tahun+"\",\""+dataRecord.id_mst_peg_struktur_org+"\",\""+dataRecord.periode+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridPengukuran").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del_pengukuran(\""+dataRecord.id_pegawai+"\",\""+dataRecord.tahun+"\",\""+dataRecord.id_mst_peg_struktur_org+"\",\""+dataRecord.periode+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Tanggal dibuat', editable:false ,align: 'center', cellsalign: 'center', datafield: 'tgl_dibuat', cellsformat: 'dd-MM-yyyy',columntype: 'date', filtertype: 'date', width: '10%' },
        { text: 'Tahun', editable:false ,align: 'center', cellsalign: 'center', datafield: 'tahun', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
        { text: 'Periode', editable:false ,align: 'center', cellsalign: 'center', datafield: 'periode', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
        { text: 'Penilai', editable:false ,datafield: 'nama_penilai', columntype: 'textbox', filtertype: 'textbox', width: '30%' },
        { text: 'Jumlah', editable:false ,align: 'center', cellsalign: 'right', datafield: 'jumlah', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
        { text: 'SKP', editable:false ,align: 'center', cellsalign: 'right', datafield: 'ratarata', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
            ]
    });
		$('#clearfilteringbutton').click(function () {
			$("#jqxgridPengukuran").jqxGrid('clearfilters');
		});
        
 		$('#refreshdatabutton').click(function () {
			$("#jqxgridPengukuran").jqxGrid('updatebounddata', 'cells');
		});
    $("#tambahjqxgridPengukuran").hide();
    $("#btn_back_pengukuran").hide();
 		$('#btn_add_pengukuran').click(function () {
			add_pengukuran();
		});
    $("#btn_back_pengukuran").click(function(){
        $("#jqxgridPengukuran").show();
        $("#tambahjqxgridPengukuran").hide();
        $("#btn_back_pengukuran").hide();
        $("#btn_add_pengukuran").show();
        $("#btnrefreshdata").hide();
        $("#btnrefreshdata-luar").show();
        $("#btnexporthdata-luar").hide();
    });
	});
 
 
	function add_pengukuran(){
		$.get("<?php echo base_url().'kepegawaian/penilaiandppp/add_pengukuran/'.$id_pegawai.'/0/'.$id_mst_peg_struktur_org.'/0'; ?>" , function(data) {
      $("#tambahjqxgridPengukuran").show();
			$("#tambahjqxgridPengukuran").html(data);
      $("#jqxgridPengukuran").hide();
      $("#btn_back_pengukuran").show();
      $("#btn_add_pengukuran").hide();
		});
	}

	function edit_pengukuran(id_pegawai,tahun,id_mst_peg_struktur_org,periode){
		// $.get("<?php //echo base_url().'kepegawaian/penilaiandppp/edit_pengukuran/'; ?>"+id_pegawai+'/'+tahun+'/'+"<?php echo $id_mst_peg_struktur_org; ?>" , function(data) {
  //     $("#tambahjqxgridPengukuran").show();
  //     $("#tambahjqxgridPengukuran").html(data);
  //     $("#jqxgridPengukuran").hide();
  //     $("#btn_back_pengukuran").show();
  //     $("#btn_add_pengukuran").hide();
  //   });
        $.get("<?php echo base_url()."kepegawaian/penilaiandppp/pengukuran/"?>"+id_pegawai+"/"+tahun+'/'+id_mst_peg_struktur_org+'/'+periode,function(data){
              $("#tambahjqxgridPengukuran").show();
              $("#tambahjqxgridPengukuran").html(data);
              $("#jqxgridPengukuran").hide();
              $("#btn_back_pengukuran").show();
              $("#btn_add_pengukuran").hide();
        });
	}

	function del_pengukuran(id_pegawai,tahun,id_mst_peg_struktur_org,periode){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'kepegawaian/penilaiandppp/dodelpermohonanpengukuran';?>/" +id_pegawai+"/"+tahun+'/'+id_mst_peg_struktur_org+'/'+periode,  function(){
				alert('Data berhasil dihapus');

				$("#jqxgridPengukuran").jqxGrid('updatebounddata', 'cells');
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
			<button class="btn btn-success" id='btn_add_pengukuran' type='button'><i class='fa fa-plus-square'></i> Tambah Pengukuran</button>
    <?php
      }
      }
    ?>
      <button class="btn btn-warning" id='btn_back_pengukuran' type='button'><i class='glyphicon glyphicon-arrow-left'></i> Kembali</button>
      <button type="button" class="btn btn-primary" id="btnrefreshdata"><i class='fa fa-save'></i> &nbsp; Refresh</button>
      <button type="button" class="btn btn-primary" id="btnrefreshdata-luar"><i class='fa fa-save'></i> &nbsp; Refresh</button>
      <button type="button" class="btn btn-success" id="btnrexportdata-luar"><i class='fa fa-save'></i> &nbsp; Export</button>
		</div>
  </div>
      <div class="row">
        <div id="jqxgridPengukuran"></div>
        <div id="tambahjqxgridPengukuran"></div>
      </div>
	</div>
</div>
</div>
</section>