<section class="content">
<form action="<?php echo base_url()?>kepegawaian/drh/dodel_multi" method="POST" name="">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header pull-left">
          <h3 class="box-title">{title_form}</h3>
        </div>
        <div class="box-footer pull-right">
         <button type="button" class="btn btn-primary" id="jqxgrid_kategori_transaksi_refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button> 
         <button type="button" class="btn btn-success" onclick='add()'><i class='fa fa-plus-square'></i> &nbsp; Tambah Kategori Transaksi</button> 
        </div>
        <div class="box-body">
          <div class="div-grid">
            <div id="jqxgrid_kategori_transaksi"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</section>

<div id="popup_kategori_transaksi" style="display:none">
  <div id="popup_title">{title_form}</div>
  <div id="popup_kategori_transaksi_content">&nbsp;</div>
</div>

<script type="text/javascript">

     var source = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_mst_kategori_transaksi', type: 'string'},
      { name: 'nama', type: 'string'},
      { name: 'deskripsi', type: 'string'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('mst/keuangan_transaksi/json_kategori_transaksi'); ?>",
    cache: false,
    updaterow: function (rowid, rowdata, commit) {
      },
    filter: function(){
      $("#jqxgrid_kategori_transaksi").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgrid_kategori_transaksi").jqxGrid('updatebounddata', 'sort');
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
     
    $('#jqxgrid_kategori_transaksi_refresh').click(function () {
      $("#jqxgrid_kategori_transaksi").jqxGrid('clearfilters');
    });

    $("#jqxgrid_kategori_transaksi").jqxGrid(
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
            var dataRecord = $("#jqxgrid_kategori_transaksi").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail(\""+dataRecord.id_mst_kategori_transaksi+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                  }
                },

        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid_kategori_transaksi").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_mst_kategori_transaksi+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                  }
                },
        { text: 'Nama Kategori', datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '30%' },
        { text: 'Deskripsi', datafield: 'deskripsi', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '60%' }
            ]
    });

  function add(){
      $("#popup_kategori_transaksi #popup_kategori_transaksi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_transaksi/kategori_transaksi_add' ?>/", function(data) {
          $("#popup_kategori_transaksi_content").html(data);
        });
        $("#popup_kategori_transaksi").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 240,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_kategori_transaksi").jqxWindow('open');
  }

  function detail(id){
      $("#popup_kategori_transaksi #popup_kategori_transaksi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_transaksi/kategori_transaksi_edit' ?>/"+ id, function(data) {
          $("#popup_kategori_transaksi_content").html(data);
        });
        $("#popup_kategori_transaksi").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 600,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_kategori_transaksi").jqxWindow('open');
    }

  function del(id){
    var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'mst/keuangan_transaksi/delete_kategori_transaksi' ?>/" + id,  function(){
        $("#jqxgrid_kategori_transaksi").jqxGrid('updatebounddata', 'cells');
        alert('Data berhasil dihapus');
      });
    }
  }
</script>

