<div class="row" style="margin: 0">
  <div class="col-md-12">
    <div class="box-footer" style="background: #FAFAFA;text-align: right">
      <button type="button" class="btn btn-primary" id="btn-gaji-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
      <button type="button" class="btn btn-warning" id="btn-gaji-tambah"><i class='fa fa-plus-circle'></i> &nbsp; Tambah SK Gaji</button>
       </div>
        <div class="box-body">
          <div class="div-grid">
              <div id="jqxgridGaji"></div>
          </div>
        </div>
      </div>
    </div>
</div>

<div id="popup_keluarga_gaji" style="display:none">
  <div id="popup_title_gaji">SK Kenaikan Gaji Pokok</div>
  <div id="popup_keluarga_gaji_content">&nbsp;</div>
</div>
<script type="text/javascript">
     var sourcegaji = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_pegawai', type: 'string'},
      { name: 'tmt', type: 'date'},
      { name: 'tmt2', type: 'string'},
      { name: 'surat_nomor', type: 'string'},
      { name: 'gaji_baru', type: 'number'},
      { name: 'masa_krj', type: 'string'},
      { name: 'id_mst_peg_golruang', type:'string'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/drh_gaji/json/{id}'); ?>",
    cache: false,
    updaterow: function (rowid, rowdata, commit) {
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
        sourcegaji.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadaptergaji = new $.jqx.dataAdapter(sourcegaji, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $('#btn-gaji-refresh').click(function () {
      $("#jqxgridGaji").jqxGrid('clearfilters');
    });

    $("#jqxgridGaji").jqxGrid(
    {   
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadaptergaji, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },
      columns: [
        { text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridGaji").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detailgaji (\""+dataRecord.id_pegawai+"\",\""+dataRecord.tmt2+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridGaji").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='delgaji (\""+dataRecord.id_pegawai+"\",\""+dataRecord.tmt2+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'TMT', datafield: 'tmt', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '14%' },
        { text: 'Nomor Surat', datafield: 'surat_nomor', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '22%' },
        { text: 'Golongan', datafield: 'id_mst_peg_golruang', columntype: 'textbox', filtertype: 'none', align: 'center', cellsalign: 'center', width: '18%' },
        { text: 'Gaji Pokok', datafield: 'gaji_baru', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '20%' },
        { text: 'Masa Kerja', datafield: 'masa_krj', columntype: 'textbox', filtertype: 'none', align: 'center', cellsalign: 'center', width: '18%' },
            ],
    });

  function detailgaji(id,idgaji){
    $("#popup_keluarga_gaji #popup_keluarga_gaji_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_gaji/edit' ?>/"+id+"/"+idgaji, function(data) {
        $("#popup_keluarga_gaji_content").html(data);
      });
      $("#popup_keluarga_gaji").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 550,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_keluarga_gaji").jqxWindow('open');
  }
 
  function delgaji(id,tmt){
       var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'kepegawaian/drh_gaji/delete' ?>/" + id +"/"+tmt,   function(){
        alert('Data berhasil dihapus');

        $("#jqxgridGaji").jqxGrid('updatebounddata', 'cells');
      });
    }
  }

  $(function () { 
    $("#btn-gaji-tambah").click(function(){
      $("#popup_keluarga_gaji #popup_keluarga_gaji_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_gaji/add/'.$id;?>" , function(data) {
        $("#popup_keluarga_gaji_content").html(data);
      });
      $("#popup_keluarga_gaji").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 550,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_keluarga_gaji").jqxWindow('open');
    });
  });

</script>
