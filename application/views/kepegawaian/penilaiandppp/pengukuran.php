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
              <div class="col-md-3">
                <label>Tahun</label>
                <select name="tahungrid" id="tahungrid" class="form-control">
                  <?php 
                    if (($tahun!='')&&($tahun!='0')) {
                        $tahun = $tahun;  
                    }else{
                      if ($this->session->userdata('filter_tahundata')!='') {
                        $tahun = $this->session->userdata('filter_tahundata');
                      }else{
                        $tahun = date("Y");
                      }
                      
                    }
                    for($i=date("Y")-8;$i<=date("Y")+8; $i++ ) { ;
                    $select = $i == $tahun ? 'selected=selected' : '';
                  ?>
                    <option value="<?php echo $i; ?>" <?php echo $select; ?>><?php echo $i; ?></option>
                  <?php } ;?>
                </select>
              </div>
              <div class="col-md-3">
                <label>Nilai Rata-rata</label>
                <input type="text" class="form-control" name="nilairataskpdata" id="nilairataskpdata" placeholder="nilairataskpdata " value="<?php 
                  if(set_value('nilairataskpdata')=="" && isset($nilairataskpdata)){
                      echo $nilairataskpdata;
                    }else{
                      echo  set_value('nilairataskpdata');
                    }
                  ?>">
              </div>
              <div class="col-md-6">  
                <div class="row">
                  <div class="col-md-12">
                    <div class="box-footer" style="float:right">
                        <button type="button" class="btn btn-primary" id="btnrefreshdata"><i class='fa fa-save'></i> &nbsp; Refresh</button>
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
      var tahundata = $("#tahungrid").val();
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/penilaiandppp/nilairataskp/{id_mst_peg_struktur_org}/{id_pegawai}' ?>/"+tahundata,
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          $("#nilairataskpdata").val(elemet.nilai);
        });
      }
      });

      return false;
    }
$(function(){
    ambilnilairataskp();
    $("#btnrefreshdata").click(function(){
      $("#jqxgridPenilaianSKP").jqxGrid('updatebounddata', 'cells');
    });
    $("#menu_kepegawaian").addClass("active");
    $("#menu_kepegawaian_penilaiandppp").addClass("active");
      var tahungrid = $("#tahungrid").val();
      $("#tahungrid").change(function(){
          tahungrid = $("#tahungrid").val();
          $("#jqxgridPenilaianSKP").jqxGrid('updatebounddata');
      });
      var data = {};  // prepare the data
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
        id: 'id_mst_peg_struktur_skp',
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
                tahun:$('#tahungrid').val(), 
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
  $("#tahungrid").change(function(){
    $.post("<?php echo base_url().'kepegawaian/penilaiandppp/filtertahundata' ?>", 'filtertahundata='+$(this).val(),  function(){
      $("#jqxgridPenilaianSKP").jqxGrid('updatebounddata', 'cells');
    });
    });
</script>
