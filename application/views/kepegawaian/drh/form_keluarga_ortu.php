<div class="row" style="margin: 0">
  <div class="col-md-12">
    <div class="box-footer" style="background: #FAFAFA;text-align: right">
      <button type="button" class="btn btn-primary" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
      <button type="button" class="btn btn-warning" id="btn-ortu-tambah"><i class='fa fa-plus-circle'></i> &nbsp; Tambah Data Orang Tua</button>
       </div>
        <div class="box-body">
          <div class="div-grid">
              <div id="jqxgrid"></div>
          </div>
        </div>
      </div>
    </div>
</div>

<div id="popup_keluarga_ortu" style="display:none">
  <div id="popup_title">Data Keluarga Orang Tua</div>
  <div id="popup_keluarga_ortu_content">&nbsp;</div>
</div>

<script type="text/javascript">
     var source = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_pegawai', type: 'string'},
      { name: 'nip_lama', type: 'string'},
      { name: 'nip_baru', type: 'string'},
      { name: 'nik', type: 'string'},
      { name: 'nama', type: 'string'},
      { name: 'jenis_kelamin', type: 'string'},
      { name: 'tgl_lhr', type: 'date'},
      { name: 'tmp_lhr', type: 'string'},
      { name: 'kode_mst_agama', type: 'string'},
      { name: 'kode_mst_nikah', type: 'string'},
      { name: 'usia', type: 'string'},
      { name: 'goldar', type: 'string'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/drh/json'); ?>",
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

    $("#jqxgrid").jqxGrid(
    {   
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },
      columns: [
        { text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail(\""+dataRecord.id_pegawai+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_pegawai+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'NIP', datafield: 'nip_baru', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
        { text: 'Nama', datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', width: '29%' },
        { text: 'Jenis Kelamin', datafield: 'jenis_kelamin', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Usia', datafield: 'usia', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '6%' },
        { text: 'Tanggal Lahir', datafield: 'tgl_lhr', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Tempat Lahir', datafield: 'tmp_lhr', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '15%' }
            ]
    });

  function edit(id){

  }

  function del(id){
    var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'kepegawaian/drh/dodel' ?>/" + id,  function(){
        alert('data berhasil dihapus');

        $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
      });
    }
  }

  $(function () { 
    $("#btn-ortu-tambah").click(function(){
      $("#popup_keluarga_ortu #popup_keluarga_ortu_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh/biodata_keluarga_ortu_add/'.$id;?>" , function(data) {
        $("#popup_keluarga_ortu_content").html(data);
      });
      $("#popup_keluarga_ortu").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 500,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_keluarga_ortu").jqxWindow('open');
    });
  });

</script>
