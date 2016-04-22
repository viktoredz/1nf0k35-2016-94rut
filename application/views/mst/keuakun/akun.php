<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>mst/keuangan_instansi/dodel_multi" method="POST" name="">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
      </div>
        <div class="box-footer">
          <button id="doExpand" class="btn btn-warning " ><i class="icon fa fa-plus-square-o"></i> &nbsp;Expand</button>  
          <button id="doCollapse" class="btn btn-warning " ><i class="icon fa fa-minus-square-o"></i> &nbsp;Collapse</button> 
          <button id="doInduk" onclick='add_induk()' class="btn btn-success"><i class="icon fa fa-plus-square"></i> &nbsp;Tambah Induk</button> 
       </div>
        <div class="box-body">
        <div class="div-grid">
            <div id="jqxgrid"></div>
      </div>
      </div>
    </div>
  </div>
  </div>
</form>
</section>

<div id="popup_keuangan_instansi" style="display:none">
  <div id="popup_title">{title_form}</div>
  <div id="popup_keuangan_instansi_content">&nbsp;</div>
</div>

<script type="text/javascript">
  $(function () { 
    $("#menu_master_data").addClass("active");
    $("#menu_mst_keuangan_instansi").addClass("active");
  });

     var source = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_mst_akun', type: 'string'},
      { name: 'kode', type: 'string'},
      { name: 'uraian', type: 'string'},
      { name: 'saldo_normal', type: 'string'},
      { name: 'saldo_awal', type: 'string'},
      { name: 'mendukung_anggaran', type: 'string'},
      { name: 'aktif', type: 'string'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('mst/keuangan_akun/json_akun'); ?>",
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
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail(\""+dataRecord.code+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                 }
                },
        
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.code+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Kode Akun', datafield: 'kode', columntype: 'textbox', filtertype: 'textbox',align: 'left', width: '15%' },
        { text: 'Uraian', datafield: 'uraian', columntype: 'textbox', filtertype: 'textbox',align: 'center', cellsalign: 'left', width: '34%'},
        { text: 'Saldo Normal', datafield: 'saldo_normal', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '13%', cellsalign: 'center' },
        { text: 'Saldo Awal', datafield: 'saldo_awal', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '13%', cellsalign: 'center' },
        { text: 'Mendukung Transaksi', datafield: 'mendukung_anggaran', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '15%',  cellsrenderer: function (row) {
           var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
           var aktif = dataRecord.status;
           var str = "";
          if(aktif=='1'){
            str = "<input type='checkbox' checked>";
          }else{
            str = "<input type='checkbox'>";
          }
          return "<div style='width:100%;padding-top:2px;text-align:center'>"+str+"</div>";
         }
        }
            ]
    });

  function detail(id){
      $("#popup_keuangan_instansi #popup_keuangan_instansi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_instansi/instansi_edit' ?>/"+ id, function(data) {
          $("#popup_keuangan_instansi_content").html(data);
        });
        $("#popup_keuangan_instansi").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 400,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_keuangan_instansi").jqxWindow('open');
    }

  function del(id){
    var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'mst/keuangan_instansi/dodel' ?>/" + id,  function(){
        alert('Data berhasil dihapus');

        $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
      });
    }
  }

  function add(){
      $("#popup_keuangan_instansi #popup_keuangan_instansi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_instansi/instansi_add' ?>/", function(data) {
          $("#popup_keuangan_instansi_content").html(data);
        });
        $("#popup_keuangan_instansi").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 400,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_keuangan_instansi").jqxWindow('open');
    }

</script>

