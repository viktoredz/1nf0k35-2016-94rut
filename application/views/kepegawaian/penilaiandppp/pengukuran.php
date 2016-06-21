<?php 
if (($statusanakbuah == 'diasendiri') || ($statusanakbuah == 'atasan')) {
  $gridshowedit = ', editable:false ';
}else{
  $gridshowedit = '';
}

?>

<div class="box-body">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-body">
          <div class="row">
            <div class="box-body">
              <div class="col-md-2">
                <label>Tahun</label>
                <input disabled="disabled" type="text" class="form-control" name="tgl_dibuat_data_pengukuran" id="tgl_dibuat_data_pengukuran" placeholder="Tanggal Dibuat " value="<?php 
                  if(set_value('tgl_dibuat_data_pengukuran')=="" && isset($tgl_dibuat)){
                      echo date("d-m-Y",strtotime($tgl_dibuat));
                    }else{
                      echo  set_value('tgl_dibuat_data_pengukuran');
                    }
                  ?>">
              </div>
              <div class="col-md-2">
                <label>Tahun</label>
                <input disabled="disabled" type="text" class="form-control" name="tahungrid_datapengukuran" id="tahungrid_datapengukuran" placeholder="Tahun " value="<?php 
                  if(set_value('tahungrid_datapengukuran')=="" && isset($tahun)){
                      echo $tahun;
                    }else{
                      echo  set_value('tahungrid_datapengukuran');
                    }
                  ?>">
              </div>
              <div class="col-md-3">
                <label>Periode</label>
                <input disabled="disabled" type="text" class="form-control" name="periode_datapengukurandata" id="periode_datapengukurandata" placeholder="periode " value="<?php 
                  if(set_value('periode_datapengukurandata')=="" && isset($periode)){
                      if ($periode==1) {
                        echo 'Januari - Juni';
                      }else{
                        echo 'Juli - Desember';
                      }
                    }else{
                      echo  set_value('periode_datapengukurandata');
                    }
                  ?>">
                  <input disabled="disabled" type="hidden" class="form-control" name="periode_datapengukuran" id="periode_datapengukuran" placeholder="periode " value="<?php 
                  if(set_value('periode_datapengukuran')=="" && isset($periode)){
                      echo $periode;
                    }else{
                      echo  set_value('periode_datapengukuran');
                    }
                  ?>">
              </div>
              <div class="col-md-2">
                <label>Nilai Rata-rata</label>
                <input disabled="disabled" type="text" class="form-control" name="nilairataskpdata_datapengukuran" id="nilairataskpdata_datapengukuran" placeholder="nilairataskpdata " value="<?php 
                  if(set_value('nilairataskpdata_datapengukuran')=="" && isset($nilairataskpdata)){
                      echo $nilairataskpdata;
                    }else{
                      echo  set_value('nilairataskpdata_datapengukuran');
                    }
                  ?>">
              </div>
              <div class="col-md-3">  
                <div class="row">
                  <div class="col-md-12">
                    <div class="box-footer" style="float:right">
                        <!-- <button type="button" class="btn btn-primary" id="btnrefreshdata"><i class='fa fa-save'></i> &nbsp; Refresh</button> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id='jqxWidget'>
              <div id="jqxgridPenilaianSKP"></div>
              <div style="font-size: 12px; font-family: Verdana, Geneva, 'DejaVu Sans', sans-serif; margin-top: 30px;">
                  <div id="cellbegineditevent"></div>
                  <div style="margin-top: 10px;" id="cellendeditevent"></div>
             </div>
          </div>
      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
   function ambilnilairataskp()
    {
      var tahundata = $("#tahungrid_datapengukuran").val();
      var periodedata = $("#periode_datapengukuran").val();
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/penilaiandppp/nilairataskp/{id_mst_peg_struktur_org}/{id_pegawai}' ?>/"+tahundata+'/'+periodedata,
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          $("#nilairataskpdata_datapengukuran").val(elemet.nilai);
        });
      }
      });

      return false;
    }
$(function(){
  $("#btnrefreshdata").show();
    $("#btnrefreshdata-luar").hide();
    $("#btnrexportdata-luar").show();
    ambilnilairataskp();
    filtergriddata();
    $("#btnrefreshdata").click(function(){
      $("#jqxgridPenilaianSKP").jqxGrid('updatebounddata', 'cells');
      ambilnilairataskp();
    });
    $("#menu_kepegawaian").addClass("active");
    $("#menu_kepegawaian_penilaiandppp").addClass("active");
      var tahungrid = $("#tahungrid_datapengukuran").val();
      $("#tahungrid_datapengukuran").change(function(){
          tahungrid = $("#tahungrid_datapengukuran").val();
          $("#jqxgridPenilaianSKP").jqxGrid('updatebounddata');
      });
      var data = {};  
      var sourceskp = {
          datatype: "json",
          type  : "POST",
          datafields: [
          { name: 'id_mst_peg_struktur_org', type: 'string'},
          { name: 'tugas', type: 'string'},
          { name: 'id_mst_peg_struktur_skp', type: 'string'},
          { name: 'ak', type: 'string'},
          { name: 'no', type: 'number'},
          { name: 'kuant', type: 'string'},
          { name: 'output', type: 'string'},
          { name: 'kuant_output', type: 'string'},
          { name: 'target', type: 'string'},
          { name: 'waktu', type: 'string'},
          { name: 'biaya', type: 'string'},
          { name: 'code_cl_phc', type: 'string'},
          { name: 'ak_nilai', type: 'double'},
          { name: 'kuant_nilai', type: 'double'},
          { name: 'kuant_output_nilai', type: 'string'},
          { name: 'target_nilai', type: 'double'},
          { name: 'waktu_nilai', type: 'double'},
          { name: 'biaya_nilai', type: 'double'},
          { name: 'perhitungan_nilai', type: 'double'},
          { name: 'pencapaian_nilai', type: 'double'},
          { name: 'id_pegawai', type: 'string'},
          { name: 'tahun', type: 'string'},
          { name: 'edit', type: 'number'},
          { name: 'delete', type: 'number'}
            ],
        url: "<?php echo base_url().'kepegawaian/penilaiandppp/json_skp/{id_mst_peg_struktur_org}/{id_pegawai}'; ?>/",
        cache: false,
          updateRow: function (rowID, rowData, commit) {
                  commit(true);
             },
        filter: function(){
          $("#jqxgridPenilaianSKP").jqxGrid('updatebounddata', 'filter');
        },
        sort: function(){
          $("#jqxgridPenilaianSKP").jqxGrid('updatebounddata', 'sort');
        },
        updateRow: function (rowID, rowData, commit) {
            
            $.post( '<?php echo base_url()?>kepegawaian/penilaiandppp/updatenilaiskp', 
              {
                id_pegawai:"<?php echo $id_pegawai?>",
                tahun:$('#tahungrid_datapengukuran').val(), 
                periode:$('#periode_datapengukuran').val(), 
                id_mst_peg_struktur_org: "<?php echo $id_mst_peg_struktur_org?>", 
                id_mst_peg_struktur_skp : rowData.id_mst_peg_struktur_skp, 
                kuant: rowData.kuant_nilai, 
                target : rowData.target_nilai,
                waktu : rowData.waktu_nilai,
                biaya : rowData.biaya_nilai,
              },
              function( data ) {
                if(data != 0){
                  alert(data);
                }
            });
            $("#jqxgridPenilaianSKP").jqxGrid('updatebounddata', 'cells');
            ambilnilairataskp();
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
          
          $("#jqxgridPenilaianSKP").jqxGrid('clearfilters');
        });

        $("#jqxgridPenilaianSKP").jqxGrid(
        {   
          width: '100%',
          
          source: dataadapterskp, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
          showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: true,
          enabletooltips: true,
          selectionmode: 'singlerow',
          editmode: 'selectedrow',
          rendergridrows: function(obj)
          {
            return obj.data;    
          },
          columns: [
            { text: 'No', editable:false ,datafield: 'no', columntype: 'textbox', filtertype: 'none', width: '3%' },
            { text: 'Kegiatan Tugas Jabatan',editable:false , align: 'center',  datafield: 'tugas', columntype: 'textbox', filtertype: 'textbox',  width: '15%' },
            { text: 'AK', editable:false ,align: 'center', cellsalign: 'center', datafield: 'ak', columntype: 'textbox', filtertype: 'textbox', width: '3%' },
            { text: 'Kuant/ Output',columngroup: 'target', cellsalign: 'left',editable:false ,align: 'center', datafield: 'target', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Kual/Mutu',columngroup: 'target', editable:false ,align: 'center',cellsalign: 'right', datafield: 'kuant_output', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Waktu (Bulan)',columngroup: 'target', editable:false ,align: 'center', cellsalign: 'right', datafield: 'waktu', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Biaya',columngroup: 'target', editable:false ,align: 'center', cellsalign: 'right', datafield: 'biaya', columntype: 'textbox', filtertype: 'textbox', width: '9%' },
            { text: 'AK', editable:false ,align: 'center'<?php echo $gridshowedit; ?>, cellsalign: 'right', datafield: 'ak_nilai', columntype: 'textbox', filtertype: 'textbox', width: '3%' },
            { text: 'Kuant/ Output' <?php echo $gridshowedit; ?>,columngroup: 'realisasi',align: 'center',cellsalign: 'right', datafield: 'kuant_nilai', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Kual/Mutu' <?php echo $gridshowedit; ?>,columngroup: 'realisasi',align: 'center', cellsalign: 'right', datafield: 'target_nilai', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Waktu (Bulan)' <?php echo $gridshowedit; ?>,columngroup: 'realisasi',align: 'center', cellsalign: 'right', datafield: 'waktu_nilai', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Biaya' <?php echo $gridshowedit; ?>,columngroup: 'realisasi',align: 'center', cellsalign: 'right', datafield: 'biaya_nilai', columntype: 'textbox', filtertype: 'textbox', width: '9%' },
            { text: 'Perhitungan' , editable:false ,align: 'center', cellsalign: 'right', datafield: 'perhitungan_nilai', columntype: 'textbox', filtertype: 'none', width: '8%' },
            { text: 'Nilai Pencapaian SKP' , editable:false ,align: 'center', cellsalign: 'right', datafield: 'pencapaian_nilai', columntype: 'textbox', filtertype: 'none', width: '8%' },
            ],

            columngroups: 
            [
              { text: 'Target', align: 'center', name: 'target' },
              { text: 'Realisasi', align: 'center', name: 'realisasi' }
            ]
        });
        }); 
    function filtergriddata(){
      $.post("<?php echo base_url().'kepegawaian/penilaiandppp/filtertahundata/'?>", 'filtertahundata='+$("#tahungrid_datapengukuran").val()+'&filterperiodedata='+$("#periode_datapengukuran").val(),  function(){
        $("#jqxgridPenilaianSKP").jqxGrid('updatebounddata', 'cells');
      });
    };
    $("#btnrexportdata-luar").click(function(){
    
    var post = "";
    var filter = $("#jqxgridPenilaianSKP").jqxGrid('getfilterinformation');
    for(i=0; i < filter.length; i++){
      var fltr  = filter[i];
      var value = fltr.filter.getfilters()[0].value;
      var condition = fltr.filter.getfilters()[0].condition;
      var filteroperation = fltr.filter.getfilters()[0].operation;
      var filterdatafield = fltr.filtercolumn;
      
      post = post+'&filtervalue'+i+'='+value;
      post = post+'&filtercondition'+i+'='+condition;
      post = post+'&filteroperation'+i+'='+filteroperation;
      post = post+'&filterdatafield'+i+'='+filterdatafield;
      post = post+'&'+filterdatafield+'operator=and';
    }
    post = post+'&filterscount='+i;
    
    var sortdatafield = $("#jqxgridPenilaianSKP").jqxGrid('getsortcolumn');
    if(sortdatafield != "" && sortdatafield != null){
      post = post + '&sortdatafield='+sortdatafield;
    }
    if(sortdatafield != null){
      var sortorder = $("#jqxgridPenilaianSKP").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgridPenilaianSKP").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
      post = post+'&sortorder='+sortorder;
      
    }
    
    $.post("<?php echo base_url()?>kepegawaian/penilaiandppp/data_export/{id_pegawai}/{tahun}/{id_mst_peg_struktur_org}/{periode}",post,function(response ){
      location.href = response;
      // alert(response);
    });
  });
</script>
