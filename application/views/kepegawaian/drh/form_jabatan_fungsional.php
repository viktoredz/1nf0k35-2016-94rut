<div class="row" style="margin: 0">
  <div class="col-md-12">
    <div class="box-footer" style="background: #FAFAFA;text-align: right">
      <button type="button" class="btn btn-primary" id="btn-jabatanfungsional-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
      <!--<button type="button" class="btn btn-warning" id="btn-fungsional-tambah"><i class='fa fa-plus-circle'></i> &nbsp; Tambah Data Jabtan Fungsional</button>-->
       </div>
        <div class="box-body">
          <div class="div-grid">
              <div id="jqxgridJabatanFungsional"></div>
          </div>
        </div>
      </div>
    </div>
</div>

<div id="popup_jabatan_fungsional" style="display:none">
  <div id="popup_title">Data Jabatan Fungsional</div>
  <div id="popup_jabatan_fungsional_content">&nbsp;</div>
</div>

<script type="text/javascript">
     var sourcejabatanfunsional = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_pegawai', type: 'string'},
      { name: 'mst_peg_id_diklat', type: 'number'},
      { name: 'jenis_diklat', type: 'string'},
      { name: 'tipe', type: 'string'},
      { name: 'nama_diklat', type: 'string'},
      { name: 'tgl_diklat', type: 'date'},
      { name: 'nomor_sertifikat', type: 'string'},
      { name: 'lama_diklat', type: 'number'},
      { name: 'tipe', type: 'string'},
      { name: 'instansi', type: 'string'},
      { name: 'penyelenggara', type: 'string'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/drh_jabatan/json_jabatan_fungsional/{id}'); ?>",
    cache: false,
    updaterow: function (rowid, rowdata, commit) {
      },
    filter: function(){
      $("#jqxgridJabatanFungsional").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgridJabatanFungsional").jqxGrid('updatebounddata', 'sort');
    },
    root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){   
      if (data != null){
        sourcejabatanfunsional.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadapterfunsional = new $.jqx.dataAdapter(sourcejabatanfunsional, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $('#btn-jabatanfungsional-refresh').click(function () {
      $("#jqxgridJabatanFungsional").jqxGrid('clearfilters');
    });

    $("#jqxgridJabatanFungsional").jqxGrid(
    {   
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadapterfunsional, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },
      columns: [
        { text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridJabatanFungsional").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail_jabatanfungsional (\""+dataRecord.id_pegawai+"\",\""+dataRecord.mst_peg_id_diklat+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridJabatanFungsional").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del_jabatanfungsional (\""+dataRecord.id_pegawai+"\",\""+dataRecord.mst_peg_id_diklat+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Nama Jabatan', datafield: 'nomor_sertifikat', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center',width: '20%' },
        { text: 'TMT Jabatan', datafield: 'tgl_dikslat', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'TMT Pelantikan', datafield: 'tgl_dsiklat', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Pejabat', datafield: 'nama_diklat',columngroup: 'suratkeputusan', columntype: 'textbox', filtertype: 'textbox', align: 'center' , cellsalign: 'center', width: '20%' },
        { text: 'Nomor', datafield: 'jenis_diklat',columngroup: 'suratkeputusan', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '20%' },
        { text: 'TMT Jabatan', datafield: 'tgl_diklat',columngroup: 'suratkeputusan', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '10%' },
        
            ],
         columngroups: 
        [
          { text: 'Surat Keputusan',align: 'center', name: 'suratkeputusan' }
        ]
    });

  function detail_jabatanfungsional(id,id_diklat){
      $("#popup_jabatan_fungsional #popup_jabatan_fungsional_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_jabatan/biodata_jabatan_fungsional_edit' ?>/" + id +"/"+id_diklat,  function(data) {
        $("#popup_jabatan_fungsional_content").html(data);
      });
      $("#popup_jabatan_fungsional").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 500,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_jabatan_fungsional").jqxWindow('open');
  }

  function del_jabatanfungsional(id,id_diklat){
    var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'kepegawaian/drh_jabatan/biodata_jabatan_fungsional_del' ?>/" + id +"/"+id_diklat,   function(){
        alert('data berhasil dihapus');

        $("#jqxgridJabatanFungsional").jqxGrid('updatebounddata', 'cells');
      });
    }
  }

  $(function () { 
    $("#btn-fungsional-tambah").click(function(){
      $("#popup_jabatan_fungsional #popup_jabatan_fungsional_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_jabatan/biodata_jabatan_fungsional_add/'.$id;?>" , function(data) {
        $("#popup_jabatan_fungsional_content").html(data);
      });
      $("#popup_jabatan_fungsional").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 500,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_jabatan_fungsional").jqxWindow('open');
    });
  });

</script>
