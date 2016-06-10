<?php if($notice!=""){ ?>
<div class="alert alert-warning alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } 

if (set_value('username_pengukuran')=='' && isset($username_pengukuran)) {
  $username_pengukuran = $username_pengukuran;
}else{
  $username_pengukuran = set_value('username_pengukuran');
}
$userdataname = $this->session->userdata('username_pengukuran');
// if ($username_pengukuran == $userdataname) {
if (($statusanakbuah == 'diasendiri') || ($statusanakbuah == 'atasan')) {
  $funshowhidden = 'disabled=disabled';
  $showhidetgl = ',disabled: true';
  $showtanggapan = '';
  $showtanggapantgl = '';
  $showkeputsan = 'disabled=disabled';
  $showkeputsantgl = ',disabled: true';
}else{
  $funshowhidden='';
  $showhidetgl = '';
  $showtanggapan = 'disabled=disabled';
  $showtanggapantgl = ',disabled: true';
  $showkeputsan = '';
  $showkeputsantgl = '';
}

?>
<script type="text/javascript">
    
    function ambil_nip_penilai()
    {
      var kode = "<?php echo $idlogin ?>";
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/penilaiandppp/nipterakhirpenilai/'.$id_pegawai ?>/",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          if ((elemet.namaterakhir=='')||(elemet.jabatanterakhir=='')) {
            $("#penilaipenilaidata").hide();
            $("#atasanpenilaidata").hide();
          }else{
            $("#penilaipenilaidata").show();
            $("#namapenilaiterakhir").html(elemet.namaterakhir);
            $("#nippenilaiterakhir").html(elemet.nipterakhir);
            $("#pangkatpenilaiterakhir").html(elemet.pangkatterakhir);
            $("#jabatanpenilaiterakhir").html(elemet.jabatanterakhir);
            $("#unitkerjapenilaiterakhir").html(elemet.ukterakhir);
            $("#id_pegawai_pengukuran_penilai").val(elemet.id_pegawai_penilai);
          }
        });
      }
      });

      return false;
    }

    function ambil_atasan_nip_penilai()
    {
      var kode = "<?php echo $idlogin ?>";
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/penilaiandppp/atasannipterakhirpenilai/'.$id_pegawai ?>/",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          if ((elemet.namaterakhir=='')||(elemet.jabatanterakhir=='')) {
            $("#atasanpenilaidata").hide();
          }else{
            $("#atasanpenilaidata").show();
            $("#atasannamapenilaiterakhir").html(elemet.namaterakhir);
            $("#atasannippenilaiterakhir").html(elemet.nipterakhir);
            $("#atasanpangkatpenilaiterakhir").html(elemet.pangkatterakhir);
            $("#atasanjabatanpenilaiterakhir").html(elemet.jabatanterakhir);
            $("#atasanunitkerjapenilaiterakhir").html(elemet.ukterakhir);
            $("#id_pegawai_pengukuran_penilai_atasan").val(elemet.id_atasan_penilai);
          }
        });
      }
      });

      return false;
    }
    function ambilnilairataskp_pengukuran()
    {
      var tahundata = $("#tahun_pengukuran").val();
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/penilaiandppp/nilairataskp/{id_mst_peg_struktur_org}/{id_pegawai}' ?>/"+tahundata,
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          $("#nilairataskp_pengukuran").val(elemet.nilai);
          $("#skp").val(elemet.nilai);
          $("#skp").val(elemet.data);
        });
      }
      });

      return false;
    }
    $(function(){
      ambilnilairataskp_pengukuran();
      ambil_nip_penilai();
      ambil_atasan_nip_penilai();
        $('#form-ss-penilaidpp_pengukuran').submit(function(){
            var data = new FormData();
            $('#notice-content-pegawai').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#notice-pegawai').show();
            data.append('tgl_dibuat_pengukuran', $('#tgl_dibuat_pengukuran').val());
            data.append('id_pegawai_pengukuran', $('#id_pegawai_pengukuran').val());
            data.append('periode', $('#periode').val());
            data.append('id_pegawai_pengukuran_penilai', $('#id_pegawai_pengukuran_penilai').val());
            data.append('id_pegawai_pengukuran_penilai_atasan', $('#id_pegawai_pengukuran_penilai_atasan').val());
            data.append('tahun_pengukuran', $('#tahun_pengukuran').val());
            var tahunskrng = $('#tahun_pengukuran').val();
            var periodeskrng = $('#periode').val();
            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."kepegawaian/penilaiandppp/".$action."_pengukuran/".$id_pegawai."/".$tahun."/".$id_mst_peg_struktur_org."/".$id_mst_peg_struktur_skp ?>',
                data : data,
                success : function(response){
                  var res  = response.split("|");
                  if(res[0]=="OK"){

                      ambilnilairataskp_pengukuran();
                      $.get("<?php echo base_url()."kepegawaian/penilaiandppp/pengukuran/".$id_pegawai."/"?>"+tahunskrng+"/<?php echo$id_mst_peg_struktur_org ?>/"+periodeskrng,function(data){
                          $('#tambahjqxgridPengukuran').html(data);
                      });

                  }
                  else if(res[0]=="Error"){
                      $('#notice-pegawai').hide();
                      $('#notice-content-pegawai').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice-pegawai').show();
                      alert('Maaf penilaian pegawai sudah dimasukan pada tahun ini '+tahunskrng +' di periode '+ periodeskrng);
                  }
                  else{
                      $('#tambahjqxgridPengukuran').html(response);
                  }
              }
            });

            return false;
        });

        
    });
</script>
<div class="box-body">
 <?php echo form_open(current_url(), 'id="form-ss-penilaidpp_pengukuran"') ?>
      

<div class="row">  
  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-body">
        <div class="form-group">
          <label>Tanggal dibuat</label>
          <div id='tgl_dibuat_pengukuran' name="tgl_dibuat_pengukuran" value="<?php
              if(set_value('tgl_dibuat_pengukuran')=="" && isset($tgl_dibuat)){
                date("Y-m-d",strtotime($tgl_dibuat));
              }else{
                date("Y-m-d",strtotime(set_value('tgl_dibuat_pengukuran')));
              }
            ?>" ></div>
        </div>
        
        <input type="hidden" class="form-control" name="id_pegawai_pengukuran" id="id_pegawai_pengukuran" placeholder="ID Pegawai" value="<?php 
        if(set_value('id_pegawai_pengukuran')=="" && isset($id_pegawai)){
            echo $id_pegawai;
          }else{
            echo  set_value('id_pegawai_pengukuran');
          }
        ?>">
        <input type="hidden" class="form-control" name="nilairataskp_pengukuran" id="nilairataskp_pengukuran" placeholder="nilairataskp_pengukuran " value="<?php 
        if(set_value('nilairataskp_pengukuran')=="" && isset($nilairataskp)){
            echo $nilairataskp;
          }else{
            echo  set_value('nilairataskp_pengukuran');
          }
        ?>">
        <input type="hidden" class="form-control" name="id_pegawai_pengukuran_penilai" id="id_pegawai_pengukuran_penilai" placeholder="ID Penilai" value="<?php 
            if(set_value('id_pegawai_pengukuran_penilai')=="" && isset($id_pegawai_penilai)){
                echo $id_pegawai_penilai;
              }else{
                echo  set_value('id_pegawai_pengukuran_penilai');
              }
            ?>">
        <input type="hidden" class="form-control" name="id_pegawai_pengukuran_penilai_atasan" id="id_pegawai_pengukuran_penilai_atasan" placeholder="ID Penilai Atasan" value="<?php 
            if(set_value('id_pegawai_pengukuran_penilai_atasan')=="" && isset($id_pegawai_penilai_atasan)){
                echo $id_pegawai_penilai_atasan;
              }else{
                echo  set_value('id_pegawai_pengukuran_penilai_atasan');
              }
            ?>">
          <input type="hidden" class="form-control" name="username_pengukuran" id="username_pengukuran" placeholder="username_pengukuran" value="<?php 
          if(set_value('username_pengukuran')=="" && isset($username)){
              echo $username;
            }else{
              echo  set_value('username_pengukuran');
            }
          ?>">
          <input type="hidden" class="form-control" name="idlogin_pengukuran" id="idlogin_pengukuran" placeholder="idlogin_pengukuran" value="<?php 
          if(set_value('idlogin_pengukuran')=="" && isset($id_login)){
              echo $id_login;
            }else{
              echo  set_value('idlogin_pengukuran');
            }
          ?>">
        <div class="form-group">
          <label>Tahun</label>
            <select <?php echo $funshowhidden;?> name="tahun_pengukuran" id="tahun_pengukuran" class="form-control">
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
        <div class="form-group">
          <label>Periode</label>
            <select <?php echo $funshowhidden;?> name="periode" id="periode" class="form-control">
              <?php 
                if (($periode!='')&&($periode!='0')) {
                    $periode = $periode;
                }else{
                  if ($this->session->userdata('filter_periodedata')!='') {
                    $periode = $this->session->userdata('filter_periodedata');
                  }else{
                    $periode = '1';
                  }
                  
                }
                for($z=1;$z<=2; $z++ ) { ;
                $select = $z == $periode ? 'selected=selected' : '';
              ?>
                <option value="<?php echo $z; ?>" <?php echo $select; ?>><?php echo $z; ?></option>
              <?php } ;?>
            </select>
        </div>
        <div class="box-footer" style="float:right">
            <?php 
            if (($statusanakbuah == 'atasan')) {
              
            }else{
            ?>
            <button type="submit" class="btn btn-primary"><i class='fa fa-save'></i> &nbsp; Simpan</button>
            <?php } ?>
            <!-- <button type="button" id="btn_back_pengukuran" class="btn btn-warning"><i class='fa fa-reply'></i> &nbsp; Kembali</button> -->
        </div>
      </div>
    </div>
  </div><!-- /.form-box -->
</div>
          

  </div><!-- /.form-box -->
</div><!-- /.register-box -->
</form>  
</div>
<script type="text/javascript">
$(function(){
    $("#menu_kepegawaian").addClass("active");
    $("#menu_kepegawaian_penilaiandppp").addClass("active");


    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>kepegawaian/penilaiandppp";
    });
    $("#tgl_dibuat_pengukuran").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showhidetgl;?>});
    


  });
    $(document).ready(function () {
       var statusanakbuah_pengukuran ="<?php echo $statusanakbuah; ?>";
        if (statusanakbuah_pengukuran == "atasan") {
          $("input").prop('disabled', true);
          $("textarea").prop('disabled', true);
        }
        if ($('#id_pegawai_pengukuran').attr('value') == $('#id_pegawai_pengukuran_penilai_atasan').attr('value')) {
          $("input").prop('disabled', true);
          $("textarea").prop('disabled', true);
        }
  });
</script>
             