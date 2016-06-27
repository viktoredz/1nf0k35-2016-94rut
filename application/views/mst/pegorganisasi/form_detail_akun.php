<form action="#" method="POST" name="frmPegawai">
  <div class="row" style="margin: 15px 5px 15px 5px">
    <div class="col-sm-8">
      <?php if(validation_errors()!=""){ ?>
      <div class="alert alert-warning alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>  <i class="icon fa fa-check"></i> Information!</h4>
        <?php echo validation_errors()?>
      </div>
      <?php } ?>

      <?php if($alert_form!=""){ ?>
      <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>  <i class="icon fa fa-check"></i> Information!</h4>
        <?php echo $alert_form?>
      </div>
      <?php } ?>
    </div>
    <div class="col-sm-12" style="text-align: right">
    <?php
      if ($tar_aktif=='1') {
    ?>
      <button type="button" name="non_aktifkan_status" class="btn btn-danger"><i class='fa fa-times-circle-o'></i> &nbsp; Non Aktifkan</button>
    <?php
    }else{ ?>
      <button type="button" name="aktifkan_status" class="btn btn-success"><i class='glyphicon glyphicon-ok'></i> &nbsp; Aktifkan</button>
    <?php        
    }
    ?>
      <button type="button" name="btn_keuangan_akun_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Tutup</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">


              <div class="row" style="margin: 5px">
                <div class="col-md-6" style="padding: 5px">
                  Nama Posisi
                </div>
                <div class="col-md-6">
                  <input type="hidden" id="tar_nama_posisi" value="<?php $tar_nama_posisi?>">
                  <?php
                    if(set_value('tar_nama_posisi')=="" && isset($tar_nama_posisi)){
                     echo $tar_nama_posisi;
                    }else{
                      echo  set_value('tar_nama_posisi');
                    }
                  ?>
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-6" style="padding: 5px">
                  Status
                </div>
                <div class="col-md-6">
                  <input disabled="disabled" type="checkbox" name="tar_aktif" id="tar_aktif" value="<?php $tar_aktif; ?>" 
                  <?php 
                  if ($tar_aktif=='1') {
                    echo 'checked';
                  }else{
                    echo '';
                  }
                  ?>
                  >
                </div>
              </div>

              <br>
            </div>
          </div>
  </div>
</form>
<div class="row" style="margin: 5px">
  <div class="col-md-12">
    <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">Pegawai Stuktur SKP</h3>
        </div>

        <div class="box-footer" style="float:right">
          <button type="button" class="btn btn-primary  btn-sm" id="btn-tambah-skp"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah</button>
          <button type="button" class="btn btn-success  btn-sm" id="btn-refresh-skp"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
          <button type="button" class="btn btn-danger  btn-sm" id="btn-back-skp"><i class='glyphicon glyphicon-arrow-left'></i> &nbsp; Kembali</button>
        </div>

        <div class="box-body">
            <div class="div-grid">
                  <div id="jqxgridSKP"></div>
                  <div id="tambahSKP"></div>
            </div>
        </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {   
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
    url: "<?php echo site_url('mst/pegorganisasi/json_skp/{tar_id_struktur_org}/{code_cl_phc}'); ?>",
    cache: false,
      updateRow: function (rowID, rowData, commit) {
             
         },
    filter: function(){
      $("#jqxgridSKP").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgridSKP").jqxGrid('updatebounddata', 'sort');
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
      $("#jqxgridSKP").jqxGrid('clearfilters');
    });

    $("#jqxgridSKP").jqxGrid(
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
            var dataRecord = $("#jqxgridSKP").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit_skp(\""+dataRecord.id_mst_peg_struktur_org+"\",\""+dataRecord.id_mst_peg_struktur_skp+"\",\""+dataRecord.code_cl_phc+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '6%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridSKP").jqxGrid('getrowdata', row);
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
    tabIndex = 1;
    $("[name='btn_keuangan_akun_close']").click(function(){
        $("#popup_keuangan_akun_detail").jqxWindow('close');
        cekstatus();
    });
    
    $("[name='non_aktifkan_status']").click(function(){
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/pegorganisasi/non_aktif_akun/{tar_id_struktur_org}/nonaktif"   ?>',
            success : function(response){
              if(response=="OK"){
                  $("[name='non_aktifkan_status']").show();
                $("#popup_keuangan_akun_detail").jqxWindow('close');
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }else{
                $("#popup_keuangan_akun_detail").jqxWindow('close');
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }
            }
        });
        return false;
    });
    $("[name='aktifkan_status']").click(function(){
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/pegorganisasi/non_aktif_akun/{tar_id_struktur_org}/aktip"   ?>',
            success : function(response){
              if(response=="OK"){
                  $("[name='non_aktifkan_status']").show();
                $("#popup_keuangan_akun_detail").jqxWindow('close');
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }else{
                $("#popup_keuangan_akun_detail").jqxWindow('close');
                $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
              }
            }
        });
        return false;
    });
    $("#btn-back-skp").hide();
    $("#tambahSKP").hide();
   $("#btn-tambah-skp").click(function(){
      $.get('<?php echo base_url()."mst/pegorganisasi/add_skp/$tar_id_struktur_org/0/$code_cl_phc"?>',function(data){
          $("#btn-tambah-skp").hide();
          $("#btn-refresh-skp").hide();
          $("#jqxgridSKP").hide();
          $("#btn-back-skp").show();
          $("#tambahSKP").show();
          $("#tambahSKP").html(data);

      });
   });
   $("#btn-back-skp").click(function(){
          $("#btn-tambah-skp").show();
          $("#btn-refresh-skp").show();
          $("#btn-back-skp").hide();
          $("#tambahSKP").hide();
          $("#jqxgridSKP").show();
   });
  });
    function del_skp(id_org,id_skp,code_cl_phc){
      var confirms = confirm("Hapus Data ?");
      if(confirms == true){
        $.post("<?php echo base_url().'mst/pegorganisasi/dodel_skp' ?>/" + id_org+ "/" + id_skp + "/" + code_cl_phc,  function(){
          alert('data berhasil dihapus');

          $("#jqxgridSKP").jqxGrid('updatebounddata', 'cells');
        });
      }
    }
    function edit_skp(id_org,id_skp,code_cl_phc){
      $.get('<?php echo base_url()."mst/pegorganisasi/edit_skp"?>/'+ id_org+ "/" + id_skp + "/" + code_cl_phc,function(data){
          $("#btn-tambah-skp").hide();
          $("#btn-refresh-skp").hide();
          $("#jqxgridSKP").hide();
          $("#btn-back-skp").show();
          $("#tambahSKP").show();
          $("#tambahSKP").html(data);

      });
    }
</script>
