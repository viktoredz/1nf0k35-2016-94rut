<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>kepegawaian/drh/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
      </div>

      <div class="box-body">
       <div class="row">
        <div class="col-md-3 pull-left">
          <button type="button" class="btn btn-primary" onclick='add()'><i class='fa fa-plus-square'></i> &nbsp; Tambah Syarat Pembayaran</button>
        </div>
        </div>
      </div>

        <div class="box-body">
        <div class="div-grid">
            <div id="jqxgrid_syarat_pembayaran"></div>
      </div>
      </div>
    </div>
  </div>
  </div>
</form>
</section>

<div id="popup_syarat_pembayaran" style="display:none">
  <div id="popup_title">{title_form}</div>
  <div id="popup_syarat_pembayaran_content">&nbsp;</div>
</div>

<script type="text/javascript">

     var source = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_mst_syarat_pembayaran', type: 'string'},
      { name: 'nama', type: 'string'},
      { name: 'deskripsi', type: 'string'},
      { name: 'aktif', type: 'string'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('mst/keuangan_transaksi/json_syarat_pembayaran'); ?>",
    cache: false,
    updaterow: function (rowid, rowdata, commit) {
      },
    filter: function(){
      $("#jqxgrid_syarat_pembayaran").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgrid_syarat_pembayaran").jqxGrid('updatebounddata', 'sort');
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
      $("#jqxgrid_syarat_pembayaran").jqxGrid('clearfilters');
    });

    $("#jqxgrid_syarat_pembayaran").jqxGrid(
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
            var dataRecord = $("#jqxgrid_syarat_pembayaran").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail(\""+dataRecord.id_mst_syarat_pembayaran+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                  }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid_syarat_pembayaran").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_mst_syarat_pembayaran+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                  }
                },
        { text: 'Nama', datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'left', width: '20%' },
        { text: 'Deskripsi', datafield: 'deskripsi', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'left', width: '62%' },
        { text: 'Aktif', datafield: 'aktif', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '8%', cellsrenderer: function (row) {
          var dataRecord = $("#jqxgrid_syarat_pembayaran").jqxGrid('getrowdata',row);
          var aktif = dataRecord.aktif;
          var str   = "";
          if(aktif=='1'){
            str="<input type='checkbox' checked>";
          }else{
            str ="<input type='checkbox'>";
          }
          return "<div style='width:100%;padding-top:2px;text-align:center'>"+str+"</div>";
          } 
        }
            ]
    });

  function add(){
      $("#popup_syarat_pembayaran #popup_kategori_transaksi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_transaksi/syarat_pembayaran_add' ?>/", function(data) {
          $("#popup_syarat_pembayaran_content").html(data);
        });
        $("#popup_syarat_pembayaran").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 340,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_syarat_pembayaran").jqxWindow('open');
  }

  function detail(id){
      $("#popup_syarat_pembayaran #popup_kategori_transaksi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_transaksi/syarat_pembayaran_edit' ?>/" +id, function(data) {
          $("#popup_syarat_pembayaran_content").html(data);
        });
        $("#popup_syarat_pembayaran").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 340,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_syarat_pembayaran").jqxWindow('open');
  }

  function del(id){
    var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'mst/keuangan_transaksi/delete_syarat_pembayaran' ?>/" + id,  function(){
        alert('data berhasil dihapus');
        $("#jqxgrid_syarat_pembayaran").jqxGrid('updatebounddata', 'cells');
      });
    }
  }

</script>

