<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
      </div>

      <div class="box-footer" >

        <div class="row" id="linkimages_alert" style="display: none">
          <div class="col-sm-12 col-md-6" id="msg_alert">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12 col-md-1" style="text-align:  center">
              <img src="<?php echo base_url()?>kepegawaian/drh/getphoto/{id}" id='linkimages' style='border:1px solid #ECECEC' height='100'>
          </div>
          <div class="col-sm-12 col-md-4" style="padding-top: 10px">
            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Pegawai : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  {gelar_depan} {nama} {gelar_belakang}
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>NIP : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  <div id="nipterakhir"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Pankat : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  <div id="pangkatterakhir"></div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Jabatan : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  <div id="jabtanterakhir"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Unit Kerja : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  <div id="unitkerjaterakhir"></div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-1" style="text-align:  center">
              <img src="<?php echo base_url()?>kepegawaian/drh/getphoto/{id}" id='linkimages' style='border:1px solid #ECECEC' height='100'>
          </div>
          <div class="col-sm-12 col-md-4" style="padding-top: 10px">
            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Penilai : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  <div id="namapenilaiterakhir"></div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>NIP : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  <div id="nippenilaiterakhir"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Pankat : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  <div id="pangkatpenilaiterakhir"></div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Jabatan : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  <div id="jabatanpenilaiterakhir"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Unit Kerja : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  <div id="unitkerjapenilaiterakhir"></div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-1" style="text-align: right">
            <button type="button" class="btn btn-success" id="btn-return"><i class='fa fa-arrow-circle-o-left'></i> &nbsp; Kembali</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="box box-success">
    <div class="box-body">
      <div class="div-grid">
          <div id="jqxTabs">
            <?php echo $penilaian;?>
          </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
$(function(){
    ambil_nip_pegawai();
    ambil_nip_penilai();
    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>inventory/permohonanbarang";
    });

    $("#menu_kepegawaian").addClass("active");
      $("#menu_kepegawaian_penilaiandppp").addClass("active");


    $.ajax({
      url : '<?php echo site_url('inventory/permohonanbarang/get_ruangan') ?>',
      type : 'POST',
      data : 'code_cl_phc={code_cl_phc}&id_mst_inv_ruangan={id_mst_inv_ruangan}',
      success : function(data) {
        $('#ruangan').html(data);
      }
    }); 
  });
  $('#btn-return').click(function(){
      document.location.href="<?php echo base_url()?>kepegawaian/penilaiandppp";
  });
  function kodeInvetaris(tahun)
    {
      if (tahun==null) {
        var tahun = <?php echo date("y");?>;  
      }else{
        var tahun = tahun.substr(-2);
      }
      
      $.ajax({
      url: "<?php echo base_url().'inventory/permohonanbarang/kodePermohonan';?>",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          var lokasi = elemet.kodeper.split(".")
          $("#id_inv_permohonan_barang").val(lokasi[0]+"."+lokasi[1]+"."+lokasi[2]+"."+lokasi[3]+"."+lokasi[4]+"."+tahun+'.'+lokasi[5]);
        });
      }
      });

      return false;
    }
    function ambil_nip_pegawai()
    {
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/penilaiandppp/nipterakhirpegawai/'.$kode ?>",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          $("#nipterakhir").html(elemet.nip);
          $("#pangkatterakhir").html(elemet.pangkat);
          $("#jabatanterakhir").html(elemet.jabatan);
          $("#unitkerjaterakhir").html(elemet.uk);
        });
      }
      });

      return false;
    }
    function ambil_nip_penilai()
    {
      var kode = "<?php echo $this->session->userdata('username'); ?>";
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/penilaiandppp/nipterakhirpenilai' ?>/"+kode,
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          $("#namapenilaiterakhir").html(elemet.namaterakhir);
          $("#nippenilaiterakhir").html(elemet.nipterakhir);
          $("#pangkatpenilaiterakhir").html(elemet.pangkatterakhir);
          $("#jabatanpenilaiterakhir").html(elemet.pangkatjabatanterakhir);
          $("#unitkerjapenilaiterakhir").html(elemet.ukterakhir);
        });
      }
      });

      return false;
    }
</script>
