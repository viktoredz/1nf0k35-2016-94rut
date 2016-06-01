<div class="row" style="margin: 0">
  <div class="col-md-12">
    <div class="box-footer" style="background: #FAFAFA;text-align: right">
      <button type="button" class="btn btn-primary" id="btn-penghargaan-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
      <button type="button" class="btn btn-warning" id="btn-penghargaan-tambah"><i class='fa fa-plus-circle'></i> &nbsp; Tambah Data Penghargaan</button>
       </div>
        <div class="box-body">
          <div class="div-grid">
              <div id="jqxgridPenghargaan"></div>
          </div>
        </div>
      </div>
    </div>
</div>

<div id="popup_keluarga_penghargaan" style="display:none">
  <div id="popup_title_penghargaan">Data Penghargaan</div>
  <div id="popup_keluarga_penghargaan_content">&nbsp;</div>
</div>
<script type="text/javascript">
     var sourcepenghargaan = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_pegawai', type: 'string'},
      { name: 'id_mst_peg_penghargaan', type: 'string'},
      { name: 'tingkat', type: 'string'},
      { name: 'instansi', type: 'string'},
      { name: 'sk_no', type: 'string'},
      { name: 'sk_tgl', type: 'date'},
      { name: 'sk_pejabat', type: 'string'},
      { name: 'nama_penghargaan', type: 'string'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/drh_penghargaan/json/{id}'); ?>",
    cache: false,
    updaterow: function (rowid, rowdata, commit) {
      },
    filter: function(){
      $("#jqxgridPenghargaan").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgridPenghargaan").jqxGrid('updatebounddata', 'sort');
    },
    root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){   
      if (data != null){
        sourcepenghargaan.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadapterpenghargaan = new $.jqx.dataAdapter(sourcepenghargaan, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $('#btn-penghargaan-refresh').click(function () {
      $("#jqxgridPenghargaan").jqxGrid('clearfilters');
    });

    $("#jqxgridPenghargaan").jqxGrid(
    {   
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadapterpenghargaan, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },
      columns: [
        { text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridPenghargaan").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detailpenghargaan (\""+dataRecord.id_pegawai+"\",\""+dataRecord.id_mst_peg_penghargaan+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridPenghargaan").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='delpenghargaan (\""+dataRecord.id_pegawai+"\",\""+dataRecord.id_mst_peg_penghargaan+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Nama Bintang / <br>Satyalancana Penghargaan', datafield: 'nama_penghargaan', columntype: 'textbox', filtertype: 'textbox', align: 'center', width: '27%' },
        { text: 'Tingkat', datafield: 'tingkat', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '12%' },
        { text: 'Pejabat',columngroup: 'suratkeputusan', datafield: 'sk_pejabat', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '15%' },
        { text: 'Nomor', columngroup: 'suratkeputusan',datafield: 'sk_no', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '15%' },
        { text: 'Tanggal', columngroup: 'suratkeputusan',datafield: 'sk_tgl', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '8%' },
        { text: 'Nama Negara / <br>Instansi yang Memberi', datafield: 'instansi', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '15%' }
            ],
        columngroups: 
        [
          { text: 'Surat Keputusan',align: 'center', name: 'suratkeputusan' }
        ]
    });

  function detailpenghargaan(id,idpenghargaan){
    $("#popup_keluarga_penghargaan #popup_keluarga_penghargaan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_penghargaan/edit' ?>/"+id+"/"+idpenghargaan, function(data) {
        $("#popup_keluarga_penghargaan_content").html(data);
      });
      $("#popup_keluarga_penghargaan").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 500,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_keluarga_penghargaan").jqxWindow('open');
  }
 
  function delpenghargaan(id,idpenghargaan){
       var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'kepegawaian/drh_penghargaan/delete' ?>/" + id +"/"+idpenghargaan,   function(){
        alert('data berhasil dihapus');

        $("#jqxgridPenghargaan").jqxGrid('updatebounddata', 'cells');
      });
    }
  }

  $(function () { 
    $("#btn-penghargaan-tambah").click(function(){
      $("#popup_keluarga_penghargaan #popup_keluarga_penghargaan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_penghargaan/add/'.$id;?>" , function(data) {
        $("#popup_keluarga_penghargaan_content").html(data);
      });
      $("#popup_keluarga_penghargaan").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 500,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_keluarga_penghargaan").jqxWindow('open');
    });
  });

</script>
