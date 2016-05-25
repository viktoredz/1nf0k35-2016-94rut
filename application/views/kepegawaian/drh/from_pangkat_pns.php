<div class="row" style="margin: 0">
  <div class="col-md-12">
    <div class="box-footer" style="background: #FAFAFA;text-align: right">
      <button type="button" class="btn btn-primary" id="btn-pns-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
      <!--<button type="button" class="btn btn-warning" id="btn-pns-tambah"><i class='fa fa-plus-circle'></i> &nbsp; Tambah Data Pendidikan Formal</button>-->
       </div>
        <div class="box-body">
          <div class="div-grid">
              <div id="jqxgridPnsHonor"></div>
          </div>
        </div>
      </div>
    </div>
</div>

<div id="popup_pangkat_pns" style="display:none">
  <div id="popup_title">Data PNS</div>
  <div id="popup_pangkat_pns_content">&nbsp;</div>
</div>
<script type="text/javascript">
     var sourcepns = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_pegawai', type: 'string'},
      { name: 'nip_nit', type: 'string'},
      { name: 'tmt', type: 'string'},
      { name: 'id_mst_peg_golruang', type: 'string'},
      { name: 'is_pnsbaru', type: 'date'},
      { name: 'status', type: 'string'},
      { name: 'jenis_pengadaan', type: 'string'},
      { name: 'jenis_pangkat', type: 'string'},
      { name: 'masa_krj_bln', type: 'string'},
      { name: 'masa_krj_thn', type: 'string'},
      { name: 'bkn_tgl', type: 'date'},
      { name: 'bkn_nomor', type: 'string'},
      { name: 'sk_pejabat', type: 'string'},
      { name: 'sk_pejabat', type: 'string'},
      { name: 'sk_tgl', type: 'date'},
      { name: 'sk_nomor', type: 'string'},
      { name: 'sttpl_tgl', type: 'date'},
      { name: 'sttpl_nomor', type: 'string'},
      { name: 'dokter_tgl', type: 'date'},
      { name: 'dokter_nomor', type: 'string'},
      { name: 'spmt_nomor', type: 'string'},
      { name: 'spmt_tgl', type: 'date'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/drh_pangkat/json_pangkat_pns/{id}'); ?>",
    cache: false,
    updaterow: function (rowid, rowdata, commit) {
      },
    filter: function(){
      $("#jqxgridPnsHonor").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgridPnsHonor").jqxGrid('updatebounddata', 'sort');
    },
    root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){   
      if (data != null){
        sourcepns.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadapterpns = new $.jqx.dataAdapter(sourcepns, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $('#btn-pns-refresh').click(function () {
      $("#jqxgridPnsHonor").jqxGrid('clearfilters');
    });

    $("#jqxgridPnsHonor").jqxGrid(
    {   
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadapterpns, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },
      columns: [
        { text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridPnsHonor").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail_pns (\""+dataRecord.id_pegawai+"\",\""+dataRecord.tmt+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridPnsHonor").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del_pns (\""+dataRecord.id_pegawai+"\",\""+dataRecord.tmt+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'Gol Ruang', datafield: 'id_mst_peg_golruang', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '9%' },
        { text: 'TMT', datafield: 'tmt', columntype: 'textbox', cellsformat: 'dd-MM-yyyy', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '8%' },
        { text: 'Bulan', datafield: 'masa_krj_bln',columngroup: 'masakerja', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center',width: '7%' },
        { text: 'Tahun', datafield: 'masa_krj_thn',columngroup: 'masakerja', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center',width: '7%' },
        { text: 'Nomor', datafield: 'bkn_nomor',columngroup: 'keputusanbkn', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Tanggal', datafield: 'bkn_tgl',columngroup: 'keputusanbkn', cellsformat: 'dd-MM-yyyy', columntype: 'date', filtertype: 'date', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Pejabat', datafield: 'sk_pejabat', columngroup: 'suratkeputusan',columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '15%' },
        { text: 'Nomor', datafield: 'sk_nomor',columngroup: 'suratkeputusan', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Tanggal', datafield: 'sk_tgl', columngroup: 'suratkeputusan', cellsformat: 'dd-MM-yyyy',columntype: 'date', filtertype: 'date', align: 'center', cellsalign: 'center', width: '8%' },
        { text: 'Nomor', datafield: 'sttpl_nomor', columngroup: 'sttpl',columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Tanggal', datafield: 'sttpl_tgl', columngroup: 'sttpl',columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy',align: 'center', cellsalign: 'center', width: '8%' },
        { text: 'Nomor', datafield: 'dokter_nomor', columngroup: 'dokter',columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '10%' },
        { text: 'Tanggal', datafield: 'dokter_tgl', columngroup: 'dokter',columntype: 'date', filtertype: 'date',cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '8%' },
            ],
         columngroups: 
        [
          { text: 'Masa Kerja Golongan', align: 'center', name: 'masakerja' },
          { text: 'Keputusan BKN', align: 'center', name: 'keputusanbkn' },
          { text: 'STTPL',align: 'center', name: 'sttpl' },
          { text: 'Keterangan Dokter',align: 'center', name: 'dokter' }
        ]
    });

  function detail_pns(id,tmt){
      $("#popup_pangkat_pns #popup_pangkat_pns_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_pangkat/edit' ?>/" + id +"/"+tmt,  function(data) {
        $('#content4').html(data);
      });
  }

  function del_pns(id,tmt){
    var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'kepegawaian/drh_pangkat/biodata_pangkat_pns_del' ?>/" + id +"/"+tmt,   function(){
        alert('Data berhasil dihapus');

        $("#jqxgridPnsHonor").jqxGrid('updatebounddata', 'cells');
      });
    }
  }

  $(function () { 
    $("#btn-pns-tambah").click(function(){
      $("#popup_pangkat_pns #popup_pangkat_pns_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_pangkat/biodata_pangkat_pns_add/'.$id;?>" , function(data) {
        $("#popup_pangkat_pns_content").html(data);
      });
      $("#popup_pangkat_pns").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 500,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_pangkat_pns").jqxWindow('open');
    });
  });

</script>
