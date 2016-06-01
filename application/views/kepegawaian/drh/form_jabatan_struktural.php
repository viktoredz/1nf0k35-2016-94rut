<div class="row" style="margin: 0">
  <div class="col-md-12">
    <div class="box-footer" style="background: #FAFAFA;text-align: right">
      <button type="button" class="btn btn-primary" id="btn-strukturalrefresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
      <!--<button type="button" class="btn btn-warning" id="btn-struktural-tambah"><i class='fa fa-plus-circle'></i> &nbsp; Tambah Data Diklat Strukutral</button>-->
       </div>
        <div class="box-body">
          <div class="div-grid">
              <div id="jqxgridJabatanStruktural"></div>
          </div>
        </div>
      </div>
    </div>
</div>

<div id="popup_jabatan_struktural" style="display:none">
  <div id="popup_title">Data Diklat Strukutral</div>
  <div id="popup_jabatan_struktural_content">&nbsp;</div>
</div>

<script type="text/javascript">
     var sourcestruktural = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_pegawai', type: 'string'},
      { name: 'nip_nit', type: 'number'},
      { name: 'tmt', type: 'string'},
      { name: 'jenis', type: 'string'},
      { name: 'unor', type: 'string'},
      { name: 'id_mst_peg_struktural', type: 'string'},
      { name: 'id_mst_peg_fungsional', type: 'string'},
      { name: 'sk_jb_tgl', type: 'date'},
      { name: 'sk_jb_nomor', type: 'string'},
      { name: 'sk_status', type: 'string'},
      { name: 'code_cl_phc', type: 'string'},
      { name: 'sk_jb_pejabat', type: 'string'},
      { name: 'tar_eselon', type: 'string'},
      { name: 'prosedur', type: 'string'},
      { name: 'tar_nama_struktural', type: 'string'},
      { name: 'tar_nama_fungsional', type: 'string'},
      { name: 'tgl_pelantikan', type: 'date'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/drh_jabatan/json_jabatan_struktural/{id}'); ?>",
    cache: false,
    updaterow: function (rowid, rowdata, commit) {
      },
    filter: function(){
      $("#jqxgridJabatanStruktural").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgridJabatanStruktural").jqxGrid('updatebounddata', 'sort');
    },
    root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){   
      if (data != null){
        sourcestruktural.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadapterstruktural = new $.jqx.dataAdapter(sourcestruktural, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $('#btn-strukturalrefresh').click(function () {
      $("#jqxgridJabatanStruktural").jqxGrid('clearfilters');
    });

    $("#jqxgridJabatanStruktural").jqxGrid(
    {   
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadapterstruktural, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },
      columns: [
        { text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridJabatanStruktural").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail_jabatanstruktural (\""+dataRecord.id_pegawai+"\",\""+dataRecord.tmt+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridJabatanStruktural").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del_jabatanstruktural (\""+dataRecord.id_pegawai+"\",\""+dataRecord.tmt+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Nama Jabatan', datafield: 'tar_nama_struktural', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center',width: '18%' },
        { text: 'Eselon', datafield: 'tar_eselon', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'TMT', datafield: 'tmt', columntype: 'textbox', filtertype: 'textbox',  align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Tanggal<br>Pelantikan', datafield: 'tgl_pelantikan', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Pejabat', datafield: 'sk_jb_pejabat',columngroup: 'suratkeputusan', columntype: 'textbox', filtertype: 'textbox', align: 'center' , cellsalign: 'center', width: '18%' },
        { text: 'Nomor', datafield: 'sk_jb_nomor',columngroup: 'suratkeputusan', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '16%' },
        { text: 'Tanggal', datafield: 'sk_jb_tgl',columngroup: 'suratkeputusan', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '10%' },
        
            ],
         columngroups: 
        [
          { text: 'Surat Keputusan',align: 'center', name: 'suratkeputusan' }
        ]
    });

  function detail_jabatanstruktural(id,tmt){
      $.get("<?php echo base_url().'kepegawaian/drh_jabatan/edit' ?>/" + id +"/"+tmt,  function(data) {
        $("#content5").html(data);
      });
  }

  function del_jabatanstruktural(id,tmt){
    var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'kepegawaian/drh_jabatan/biodata_jabatan_del' ?>/" + id +"/"+tmt,   function(){
        alert('data berhasil dihapus');

        $("#jqxgridJabatanStruktural").jqxGrid('updatebounddata', 'cells');
      });
    }
  }

  $(function () { 
    $("#btn-struktural-tambah").click(function(){
      $("#popup_jabatan_struktural #popup_jabatan_struktural_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_jabatan/biodata_jabatan_struktural_add/'.$id;?>" , function(data) {
        $("#popup_jabatan_struktural_content").html(data);
      });
      $("#popup_jabatan_struktural").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 400,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_jabatan_struktural").jqxWindow('open');
    });
  });

</script>
