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

if (set_value('username')=='' && isset($username)) {
  $username = $username;
}else{
  $username = set_value('username');
}
$userdataname = $this->session->userdata('username');
// if ($username == $userdataname) {
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
            $("#id_pegawai_penilai").val(elemet.id_pegawai_penilai);
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
            $("#id_pegawai_penilai_atasan").val(elemet.id_atasan_penilai);
          }
        });
      }
      });

      return false;
    }
    function ambilnilairataskp()
    {

      $.ajax({
      url: "<?php echo base_url().'kepegawaian/penilaiandppp/nilairataskpterakhir/{id_mst_peg_struktur_org}/{id_pegawai}/'.$tahun."/0" ?>",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          $("#nilairataskp").val(elemet.nilai);
          <?php if (!isset($skp)) {?>
            $("#skp").val(elemet.nilai);
          <?php } ?>
        });
      }
      });

      return false;
    }
    $(function(){
      $("#simpandatapeniliandppp").show();
      ambilnilairataskp();
      ambil_nip_penilai();
      ambil_atasan_nip_penilai();
        $('#form-ss-penilaidpp').submit(function(){
            var data = new FormData();
            $('#notice-content-pegawai').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#notice-pegawai').show();
            data.append('tgl_dibuat', $('#tgl_dibuat').val());
            data.append('tgl_diterima_atasan', $('#tgl_diterima_atasan').val());
            data.append('id_pegawai', $('#id_pegawai').val());
            data.append('id_pegawai_penilai', $('#id_pegawai_penilai').val());
            data.append('id_pegawai_penilai_atasan', $('#id_pegawai_penilai_atasan').val());
            data.append('tahun', $('#tahun').val());
            data.append('tanggapan_tgl', $('#tanggapan_tgl').val());
            data.append('tanggapan', $('#tanggapan').val());
            data.append('username', $('#username').val());
            if ($('#username').val()=="<?php echo $userdataname; ?>") {
                data.append('keberatan_tgl', $('#keberatan_tgl').val());
                data.append('keberatan', $('#keberatan').val());
            }
            data.append('keputusan_tgl', $('#keputusan_tgl').val());

            data.append('keputusan', $('#keputusan').val());
            data.append('rekomendasi', $('#rekomendasi').val());
            data.append('skp', $('#skp').val());
            data.append('pelayanan', $('#pelayanan').val());
            data.append('integritas', $('#integritas').val());
            data.append('komitmen', $('#komitmen').val());
            data.append('disiplin', $('#disiplin').val());
            data.append('kerjasama', $('#kerjasama').val());
            data.append('kepemimpinan', $('#kepemimpinan').val());
            data.append('jumlah', $('#jumlah').val());
            data.append('ratarata', $('#ratarata').val());
            data.append('nilai_prestasi', $('#nilai_prestasi').val());
            data.append('tgl_diterima', $('#tgl_diterima').val());
            data.append('nilaiskp', $('#nilaiskp').val());
            data.append('nilaipelayanan', $('#nilaipelayanan').val());
            data.append('nilaiintegritas', $('#nilaiintegritas').val());
            data.append('nilaikomitmen', $('#nilaikomitmen').val());
            data.append('nilaidisiplin', $('#nilaidisiplin').val());
            data.append('nilaikerjasama', $('#nilaikerjasama').val());
            data.append('nilaikepemimpinan', $('#nilaikepemimpinan').val());
            data.append('nilaijumlah', $('#nilaijumlah').val());
            data.append('nilairatarata', $('#nilairatarata').val());
            data.append('nilai_nilai_prestasi', $('#nilai_nilai_prestasi').val());
            var tahunskrng = $('#tahun').val();
            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."kepegawaian/penilaiandppp/".$action."_dppp/".$id_pegawai."/".$tahun."/".$id_mst_peg_struktur_org."/".$id_mst_peg_struktur_skp ?>',
                data : data,
                success : function(response){
                  var res  = response.split("|");
                  if(res[0]=="OK"){
                    if ("<?php echo $action;?>"=='add') {
                      $("#tambahjqxgrid").hide();
                      $("#btn_back_dppp").hide();
                      $("#btn_add_dppp").show();
                      $("#jqxgrid").show();
                      $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                      ambilnilairataskp();
                      $("#btn-refresh-datagrid").show();
                      $("#btn-export-datagrid").hide();
                      $("#simpandatapeniliandppp").hide();
                    }else{
                      alert('Data berhasil diubah');
                       $("#tambahjqxgrid").show();
                      $("#btn_back_dppp").show();
                      $("#btn_add_dppp").hide();
                      $("#jqxgrid").hide();
                    }
                  }
                  else if(res[0]=="Error"){
                      $('#notice-pegawai').hide();
                      $('#notice-content-pegawai').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice-pegawai').show();
                      alert('Maaf penilaian pegawai sudah dimasukan pada tahun ini '+tahunskrng);
                      $("#btn-refresh-datagrid").hide();
                      $("#btn-export-datagrid").hide();
                      $("#simpandatapeniliandppp").show();
                      $("#btn_back_dppp").show();
                  }
                  else{
                      $('#tabadddppp2').html(response);
                      $("#btn-refresh-datagrid").hide();
                      $("#btn-export-datagrid").hide();
                      $("#simpandatapeniliandppp").show();
                      $("#btn_back_dppp").show();
                  }
              }
            });

            return false;
        });

        
    });
</script>
<div class="box-body">
 <?php echo form_open(current_url(), 'id="form-ss-penilaidpp"') ?>
      
<div class="row">
  <div class="col-md-12">
  <div class="box-footer" style="float:right">
    <?php 
    if (($statusanakbuah == 'atasan')) {
      
    }else{
    ?>
      <button type="submit" id="simpandatapeniliandppp" class="btn btn-primary"><i class='fa fa-save'></i> &nbsp; Simpan</button>
    <?php } ?>
    <!-- <button type="button" id="btn_back_dppp" class="btn btn-warning"><i class='fa fa-reply'></i> &nbsp; Kembali</button> -->
  </div>
  </div>
</div>
<div class="row">  
  <div class="col-md-5">
    <div class="box box-danger">
      <div class="box-body">
        <div class="form-group">
          <label>Tanggal dibuat</label>
          <div id='tgl_dibuat' name="tgl_dibuat" value="<?php
              if(set_value('tgl_dibuat')=="" && isset($tgl_dibuat)){
                date("Y-m-d",strtotime($tgl_dibuat));
              }else{
                date("Y-m-d",strtotime(set_value('tgl_dibuat')));
              }
            ?>" ></div>
        </div>
   
        <div class="form-group">
          <label>Tanggal diterima Atasan</label>
          <div id='tgl_diterima_atasan' name="tgl_diterima_atasan" value="<?php
              if(set_value('tgl_diterima_atasan')=="" && isset($tgl_diterima_atasan)){
                date("Y-m-d",strtotime($tgl_diterima_atasan));
              }else{
                date("Y-m-d",strtotime(set_value('tgl_diterima_atasan')));
              }
            ?>"></div>
        </div>
        
        <input type="hidden" class="form-control" name="id_pegawai" id="id_pegawai" placeholder="ID Pegawai" value="<?php 
        if(set_value('id_pegawai')=="" && isset($id_pegawai)){
            echo $id_pegawai;
          }else{
            echo  set_value('id_pegawai');
          }
        ?>">
        <input type="hidden" class="form-control" name="nilairataskp" id="nilairataskp" placeholder="nilairataskp " value="<?php 
        if(set_value('nilairataskp')=="" && isset($nilairataskp)){
            echo $nilairataskp;
          }else{
            echo  set_value('nilairataskp');
          }
        ?>">
        <input type="hidden" class="form-control" name="id_pegawai_penilai" id="id_pegawai_penilai" placeholder="ID Penilai" value="<?php 
            if(set_value('id_pegawai_penilai')=="" && isset($id_pegawai_penilai)){
                echo $id_pegawai_penilai;
              }else{
                echo  set_value('id_pegawai_penilai');
              }
            ?>">
        <input type="hidden" class="form-control" name="id_pegawai_penilai_atasan" id="id_pegawai_penilai_atasan" placeholder="ID Penilai Atasan" value="<?php 
            if(set_value('id_pegawai_penilai_atasan')=="" && isset($id_pegawai_penilai_atasan)){
                echo $id_pegawai_penilai_atasan;
              }else{
                echo  set_value('id_pegawai_penilai_atasan');
              }
            ?>">
          <input type="hidden" class="form-control" name="username" id="username" placeholder="username" value="<?php 
          if(set_value('username')=="" && isset($username)){
              echo $username;
            }else{
              echo  set_value('username');
            }
          ?>">
          <input type="hidden" class="form-control" name="username" id="idlogin" placeholder="idlogin" value="<?php 
          if(set_value('idlogin')=="" && isset($idlogin)){
              echo $idlogin;
            }else{
              echo  set_value('idlogin');
            }
          ?>">
        <div class="form-group">
          <label>Tahun</label>
            <select <?php echo $funshowhidden;?> name="tahun" id="tahun" class="form-control">
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
          <label>Tanggal Keberantan</label>
          <div id='keberatan_tgl' name="keberatan_tgl" value="<?php
              if(set_value('keberatan_tgl')=="" && isset($keberatan_tgl)){
                date("Y-m-d",strtotime($keberatan_tgl));
              }else{
                date("Y-m-d",strtotime(set_value('keberatan_tgl')));
              }
            ?>"></div>
        </div>

        <div class="form-group">
          <label>Keberatan</label>
          <textarea <?php echo $showtanggapan;?> class="form-control" name="keberatan" id="keberatan" placeholder="Keberatan" ><?php 
              if(set_value('keberatan')=="" && isset($keberatan)){
                echo $keberatan;
              }else{
                echo  set_value('keberatan');
              }
              ?></textarea>
        </div> 
        <div class="form-group">
          <label>Tanggal Tanggapan</label>
          <div id='tanggapan_tgl' name="tanggapan_tgl" value="<?php
              if(set_value('tanggapan_tgl')=="" && isset($tanggapan_tgl)){
                date("Y-m-d",strtotime($tanggapan_tgl));
              }else{
                date("Y-m-d",strtotime(set_value('tanggapan_tgl')));
              }
            ?>"></div>
        </div>

        <div class="form-group">
          <label>Tanggapan</label>
          <textarea <?php echo $funshowhidden;?> class="form-control" name="tanggapan" id="tanggapan" placeholder="Tanggapan"><?php 
              if(set_value('tanggapan')=="" && isset($tanggapan)){
                echo $tanggapan;
              }else{
                echo  set_value('tanggapan');
              }
              ?></textarea>
        </div>  
        <div class="form-group">
          <label>Tanggal Keputusan</label>
          <div id='keputusan_tgl' name="keputusan_tgl" value="<?php
              if(set_value('keputusan_tgl')=="" && isset($keputusan_tgl)){
                date("Y-m-d",strtotime($keputusan_tgl));
              }else{
                date("Y-m-d",strtotime(set_value('keputusan_tgl')));
              }
            ?>"></div>
        </div>

        <div class="form-group">
          <label>Keputusan</label>
          <textarea <?php echo $showkeputsan;?> class="form-control" name="keputusan" id="keputusan" placeholder="Keputusan"><?php 
              if(set_value('keputusan')=="" && isset($keputusan)){
                echo $keputusan;
              }else{
                echo  set_value('keputusan');
              }
              ?></textarea>
        </div>  
        <div class="form-group">
          <label>Rekomendasi</label>
          <textarea <?php echo $showkeputsan;?> class="form-control" name="rekomendasi" id="rekomendasi" placeholder="Rekomendasi"><?php 
              if(set_value('rekomendasi')=="" && isset($rekomendasi)){
                echo $rekomendasi;
              }else{
                echo  set_value('rekomendasi');
              }
              ?></textarea>
        </div>
        <div class="form-group">
          <label>Tanggal Diterima</label>
          <div id='tgl_diterima' name="tgl_diterima" value="<?php
              if(set_value('tgl_diterima')=="" && isset($tgl_diterima)){
                date("Y-m-d",strtotime($tgl_diterima));
              }else{
                date("Y-m-d",strtotime(set_value('tgl_diterima')));
              }
            ?>"></div>
        </div>
        
        
        
         
      </div>
    </div>
  </div><!-- /.form-box -->

  <div class="col-md-7">
    <div class="box box-warning">
      <div class="box-body">
        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>SKP</label>
          </div>
          <div class="col-md-5">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="skp" id="skp" placeholder="SKP" value="<?php 
              if(set_value('skp')=="" && isset($skp)){
                  echo $skp;
                }else{
                  echo  set_value('skp');
                }
              ?>">
          </div>
          <div class="col-md-4">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="nilaiskp" id="nilaiskp" placeholder="Nilai SKP" value="<?php 
              if(set_value('nilaiskp')=="" && isset($nilaiskp)){
                  echo $nilaiskp;
                }else{
                  echo  set_value('nilaiskp');
                }
              ?>">
          </div>
        </div>
        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>Pelayanan</label>
          </div>
          <div class="col-md-5">
            <input <?php echo $funshowhidden;?> type="number" class="form-control" name="pelayanan" id="pelayanan" placeholder="Pelayanan" value="<?php 
            if(set_value('pelayanan')=="" && isset($pelayanan)){
                echo $pelayanan;
              }else{
                echo  set_value('pelayanan');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="nilaipelayanan" id="nilaipelayanan" placeholder="Nilai Pelayanan" value="<?php 
              if(set_value('nilaipelayanan')=="" && isset($nilaipelayanan)){
                  echo $nilaipelayanan;
                }else{
                  echo  set_value('nilaipelayanan');
                }
              ?>">
          </div>
        </div>
        
        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>Integritas</label>
          </div>
          <div class="col-md-5">
            <input <?php echo $funshowhidden;?> type="number" class="form-control" name="integritas" id="integritas" placeholder="Integritas" value="<?php 
            if(set_value('integritas')=="" && isset($integritas)){
                echo $integritas;
              }else{
                echo  set_value('integritas');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="nilaiintegritas" id="nilaiintegritas" placeholder="Nilai Integritas" value="<?php 
              if(set_value('nilaiintegritas')=="" && isset($nilaiintegritas)){
                  echo $nilaiintegritas;
                }else{
                  echo  set_value('nilaiintegritas');
                }
              ?>">
          </div>
        </div>
          
        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>Komitmen</label>
          </div>
          <div class="col-md-5">
            <input <?php echo $funshowhidden;?> type="number" class="form-control" name="komitmen" id="komitmen" placeholder="Komitmen" value="<?php 
            if(set_value('komitmen')=="" && isset($komitmen)){
                echo $komitmen;
              }else{
                echo  set_value('komitmen');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="nilaikomitmen" id="nilaikomitmen" placeholder="Nilai Komitmen" value="<?php 
              if(set_value('nilaikomitmen')=="" && isset($nilaikomitmen)){
                  echo $nilaikomitmen;
                }else{
                  echo  set_value('nilaikomitmen');
                }
              ?>">
          </div>
        </div>
        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>Disiplin</label>
          </div>
          <div class="col-md-5">
            <input  <?php echo $funshowhidden;?> type="number" class="form-control" name="disiplin" id="disiplin" placeholder="Disiplin" value="<?php 
            if(set_value('disiplin')=="" && isset($disiplin)){
                echo $disiplin;
              }else{
                echo  set_value('disiplin');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="nilaidisiplin" id="nilaidisiplin" placeholder="Nilai Disiplin" value="<?php 
              if(set_value('nilaidisiplin')=="" && isset($nilaidisiplin)){
                  echo $nilaidisiplin;
                }else{
                  echo  set_value('nilaidisiplin');
                }
              ?>">
          </div>
        </div>

        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>Kerjasama</label>
          </div>
          <div class="col-md-5">
            <input <?php echo $funshowhidden;?> type="number" class="form-control" name="kerjasama" id="kerjasama" placeholder="Kerjasama" value="<?php 
            if(set_value('kerjasama')=="" && isset($kerjasama)){
                echo $kerjasama;
              }else{
                echo  set_value('kerjasama');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="nilaikerjasama" id="nilaikerjasama" placeholder="Nilai Kerjasama" value="<?php 
              if(set_value('nilaikerjasama')=="" && isset($nilaikerjasama)){
                  echo $nilaikerjasama;
                }else{
                  echo  set_value('nilaikerjasama');
                }
              ?>">
          </div>
        </div>

        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>Kepemimpinan</label>
          </div>
          <div class="col-md-5">
            <input <?php echo $funshowhidden;?> type="number" class="form-control" name="kepemimpinan" id="kepemimpinan" placeholder="Kepemimpinan" value="<?php 
            if(set_value('kepemimpinan')=="" && isset($kepemimpinan)){
                echo $kepemimpinan;
              }else{
                echo  set_value('kepemimpinan');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="nilaikepemimpinan" id="nilaikepemimpinan" placeholder="Nilai Kepemimpinan" value="<?php 
              if(set_value('nilaikepemimpinan')=="" && isset($nilaikepemimpinan)){
                  echo $nilaikepemimpinan;
                }else{
                  echo  set_value('nilaikepemimpinan');
                }
              ?>">
          </div>
        </div>

        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>Jumlah</label>
          </div>
          <div class="col-md-5">
            <input disabled="disabled" type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php 
            if(set_value('jumlah')=="" && isset($jumlah)){
                echo $jumlah;
              }else{
                echo  set_value('jumlah');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input type="text" disabled="disabled" class="form-control" name="nilaijumlah" id="nilaijumlah" placeholder="Nilai Jumlah" value="<?php 
              if(set_value('nilaijumlah')=="" && isset($nilaijumlah)){
                  echo $nilaijumlah;
                }else{
                  echo  set_value('nilaijumlah');
                }
              ?>">
          </div>
        </div>

        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>Rata - rata</label>
          </div>
          <div class="col-md-5">
            <input disabled="disabled" type="number" class="form-control" name="ratarata" id="ratarata" placeholder="Rata - rata" value="<?php 
            if(set_value('ratarata')=="" && isset($ratarata)){
                echo $ratarata;
              }else{
                echo  set_value('ratarata');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input disabled="disabled" type="text" class="form-control" name="nilairatarata" id="nilairatarata" placeholder="Nilai Rata - rata" value="<?php 
              if(set_value('nilairatarata')=="" && isset($nilairatarata)){
                  echo $nilairatarata;
                }else{
                  echo  set_value('nilairatarata');
                }
              ?>">
          </div>
        </div>

        <div class="row" style="padding:5px">
          <div class="col-md-3">
              <label>Nilai Prestasi</label>
          </div>
          <div class="col-md-5">
            <input disabled="disabled" type="number" class="form-control" name="nilai_prestasi" id="nilai_prestasi" placeholder="Nilai Prestasi" value="<?php 
            if(set_value('nilai_prestasi')=="" && isset($nilai_prestasi)){
                echo $nilai_prestasi;
              }else{
                echo  set_value('nilai_prestasi');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input disabled="disabled"type="text" class="form-control" name="nilai_nilai_prestasi" id="nilai_nilai_prestasi" placeholder="Nilai Prestasi" value="<?php 
              if(set_value('nilai_nilai_prestasi')=="" && isset($nilai_nilai_prestasi)){
                  echo $nilai_nilai_prestasi;
                }else{
                  echo  set_value('nilai_nilai_prestasi');
                }
              ?>">
          </div>
        </div>
        

      </div>
      
      </div>
          

  </div><!-- /.form-box -->
</div><!-- /.register-box -->
</form>  
</div>
<script type="text/javascript">
$(function(){
    $("#btn-refresh-datagrid").hide();
    $("#btn-export-datagrid").show();
    $("#menu_kepegawaian").addClass("active");
    $("#menu_kepegawaian_penilaiandppp").addClass("active");

     $("#btn-export-datagrid").click(function(){
    
    var post = "";
      $.post("<?php echo base_url()?>kepegawaian/penilaiandppp/data_export_dp3/{id_pegawai}/{tahun}",post,function(response ){
        location.href = response;
        // alert(response);
      });
    });
    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>kepegawaian/penilaiandppp";
    });
    $("#keberatan_tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showtanggapantgl;?>});
    $("#tanggapan_tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showhidetgl;?>});
    $("#keputusan_tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showkeputsantgl;?>});
    $("#tgl_diterima").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showkeputsantgl;?>});
    $("#tgl_diterima_atasan").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showkeputsantgl;?>});
    $("#tgl_dibuat").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showhidetgl;?>});
    


  });
    $(document).ready(function () {
      skpnilai();
       var statusanakbuah ="<?php echo $statusanakbuah; ?>";
        if (statusanakbuah == "atasan") {
          $("input").prop('disabled', true);
          $("textarea").prop('disabled', true);
        }
      function skpnilai(){
        if ($("#skp").val() !='') {
          if ($("#skp").val() < 0) {
              alert("Maaf, nilai tidak boleh kurang dari nol");
              $("#skp").val(0);
              $("#nilaiskp").val('');
            }else if ($("#skp").val() < 60) {
              $("#nilaiskp").val('D');
            }else if ($("#skp").val() <= 70) {
              $("#nilaiskp").val('C');
            }else if ($("#skp").val() <= 80) {
              $("#nilaiskp").val('B');
            }else if ($("#skp").val() <= 100) {
              $("#nilaiskp").val('A');
            }else if ($("#skp").val() > 1000) {
              alert("Maaf, nilai tidak boleh lebih dari seratus");
              $("#skp").val(0);
              $("#nilaiskp").val('');
            }
        }
        
      }
      
      $("#skp").change(function(){
          skpnilai();
          tambahalldata();
          ratarataall();
          nilairataskp();
      });
      function pelayanannilai(){
        if ($("#pelayanan").val() !='') {
          if ($("#pelayanan").val() < 0) {
              alert("Maaf, nilai tidak boleh kurang dari nol");
              $("#pelayanan").val(0);
              $("#nilaipelayanan").val('');
            }else if ($("#pelayanan").val() < 60) {
              $("#nilaipelayanan").val('D');
            }else if ($("#pelayanan").val() <= 70) {
              $("#nilaipelayanan").val('C');
            }else if ($("#pelayanan").val() <= 80) {
              $("#nilaipelayanan").val('B');
            }else if ($("#pelayanan").val() <= 100) {
              $("#nilaipelayanan").val('A');
            }else if ($("#pelayanan").val() > 100) {
              alert("Maaf, nilai tidak boleh lebih dari seratus");
              $("#skp").val(0);
              $("#nilaipelayanan").val('');
            }
        }
        
      }
      pelayanannilai();
      $("#pelayanan").change(function(){
          pelayanannilai();
          tambahalldata();
          ratarataall();
          nilairataskp();
      });
      function integritasnilai(){
        if ($("#integritas").val() !='') {
          if ($("#integritas").val() < 0) {
              alert("Maaf, nilai tidak boleh kurang dari nol");
              $("#skp").val(0);
              $("#nilaiintegritas").val('');
            }else if ($("#integritas").val() < 60) {
              $("#nilaiintegritas").val('D');
            }else if ($("#integritas").val() <= 70) {
              $("#nilaiintegritas").val('C');
            }else if ($("#integritas").val() <= 80) {
              $("#nilaiintegritas").val('B');
            }else if ($("#integritas").val() <= 100) {
              $("#nilaiintegritas").val('A');
            }else if ($("#integritas").val() > 100) {
              alert("Maaf, nilai tidak boleh lebih dari seratus");
              $("#integritas").val(0);
              $("#nilaiintegritas").val('');
            }
        }
        
      }
      integritasnilai();
      $("#integritas").change(function(){
          integritasnilai();
          tambahalldata();
          ratarataall();
          nilairataskp();
      });
      function komitmennilai(){
        if ($("#komitmen").val() !='') {
          if ($("#komitmen").val() < 0) {
              alert("Maaf, nilai tidak boleh kurang dari nol");
              $("#komitmen").val(0);
              $("#nilaikomitmen").val('');
            }else if ($("#komitmen").val() < 60) {
              $("#nilaikomitmen").val('D');
            }else if ($("#komitmen").val() <= 70) {
              $("#nilaikomitmen").val('C');
            }else if ($("#komitmen").val() <= 80) {
              $("#nilaikomitmen").val('B');
            }else if ($("#komitmen").val() <= 100) {
              $("#nilaikomitmen").val('A');
            }else if ($("#komitmen").val() > 100) {
              alert("Maaf, nilai tidak boleh lebih dari seratus");
              $("#komitmen").val(0);
              $("#nilaikomitmen").val('');
            }
        }
        
      }
      komitmennilai();
      $("#komitmen").change(function(){
          komitmennilai();
          tambahalldata();
          ratarataall();
          nilairataskp();
      });
      function disiplinnilai(){
        if ($("#disiplin").val() !='') {
          if ($("#disiplin").val() < 0) {
              alert("Maaf, nilai tidak boleh kurang dari nol");
              $("#disiplin").val(0);
              $("#nilaidisiplin").val('');
            }else if ($("#disiplin").val() < 60) {
              $("#nilaidisiplin").val('D');
            }else if ($("#disiplin").val() <= 70) {
              $("#nilaidisiplin").val('C');
            }else if ($("#disiplin").val() <= 80) {
              $("#nilaidisiplin").val('B');
            }else if ($("#disiplin").val() <= 100) {
              $("#nilaidisiplin").val('A');
            }else if ($("#disiplin").val() > 100) {
              alert("Maaf, nilai tidak boleh lebih dari seratus");
              $("#disiplin").val(0);
              $("#nilaidisiplin").val('');
            }
        }
        
      }
      disiplinnilai();
      $("#disiplin").change(function(){
          disiplinnilai();
          tambahalldata();
          ratarataall();
          nilairataskp();
      });
      function kerjasamanilai(){
        if ($("#kerjasama").val() !='') {
          if ($("#kerjasama").val() < 0) {
              alert("Maaf, nilai tidak boleh kurang dari nol");
              $("#kerjasama").val(0);
              $("#nilaikerjasama").val('');
            }else if ($("#kerjasama").val() < 60) {
              $("#nilaikerjasama").val('D');
            }else if ($("#kerjasama").val() <= 70) {
              $("#nilaikerjasama").val('C');
            }else if ($("#kerjasama").val() <= 80) {
              $("#nilaikerjasama").val('B');
            }else if ($("#kerjasama").val() <= 100) {
              $("#nilaikerjasama").val('A');
            }else if ($("#kerjasama").val() > 100) {
              alert("Maaf, nilai tidak boleh lebih dari seratus");
              $("#kerjasama").val(0);
              $("#nilaikerjasama").val('');
            }
        }
        
      }
      kerjasamanilai();
      $("#kerjasama").change(function(){
          kerjasamanilai();
          tambahalldata();
          ratarataall();
          nilairataskp();
      });
      function kepemimpinannilai(){
        if ($("#kepemimpinan").val() !='') {
          if ($("#kepemimpinan").val() < 0) {
            alert("Maaf, nilai tidak boleh kurang dari nol");
            $("#kepemimpinan").val(0);
            $("#nilaikepemimpinan").val('');
          }else if ($("#kepemimpinan").val() < 60) {
            $("#nilaikepemimpinan").val('D');
          }else if ($("#kepemimpinan").val() <= 70) {
            $("#nilaikepemimpinan").val('C');
          }else if ($("#kepemimpinan").val() <= 80) {
            $("#nilaikepemimpinan").val('B');
          }else if ($("#kepemimpinan").val() <= 100) {
            $("#nilaikepemimpinan").val('A');
          }else if ($("#kepemimpinan").val() > 100) {
            alert("Maaf, nilai tidak boleh lebih dari seratus");
            $("#kepemimpinan").val(0);
            $("#nilaikepemimpinan").val('');
          }
        }
        
      }
      kepemimpinannilai();
      $("#kepemimpinan").change(function(){
          kepemimpinannilai();
          tambahalldata();
          ratarataall();
          nilairataskp();
      });
      function tambahalldata(){
          $("#jumlah").val(parseInt($("#skp").val())+parseInt($("#pelayanan").val())+parseInt($("#integritas").val())+parseInt($("#komitmen").val())+parseInt($("#disiplin").val())+parseInt($("#kerjasama").val())+parseInt($("#kepemimpinan").val()));
      }
      ratarataall();
      function ratarataall(){
          var jumlahrata = (parseInt($("#skp").val())+parseInt($("#pelayanan").val())+parseInt($("#integritas").val())+parseInt($("#komitmen").val())+parseInt($("#disiplin").val())+parseInt($("#kerjasama").val())+parseInt($("#kepemimpinan").val()))/7;
            $("#ratarata").val(jumlahrata.toFixed(2));
        if ($("#ratarata").val() !='') {
            if ($("#ratarata").val() < 0) {
              alert("Maaf, nilai tidak boleh lebih dari nol");
            }else if ($("#ratarata").val() < 60) {
              $("#nilaijumlah").val('D');
              $("#nilairatarata").val('D');
            }else if ($("#ratarata").val() <= 70) {
              $("#nilaijumlah").val('C');
              $("#nilairatarata").val('C');
            }else if ($("#ratarata").val() <= 80) {
              $("#nilaijumlah").val('B');
              $("#nilairatarata").val('B');
            }else if ($("#ratarata").val() <= 100) {
              $("#nilaijumlah").val('A');
              $("#nilairatarata").val('A');
            }else if ($("#ratarata").val() > 100) {
              alert("Maaf, nilai tidak boleh lebih dari seratus");
            }
        }
         
      }
      
      function nilairataskp(){
      var nilaiskpdata = (parseFloat($("#skp").val())*60/100);
      var nilairata = parseFloat($("#ratarata").val())*40/100;
      //alert($("#nilairataskp").val());
      
      $("#nilai_prestasi").val(parseFloat(nilairata)+parseFloat(nilaiskpdata));
        if ($("#nilai_prestasi").val() !='') {
          if ($("#nilai_prestasi").val() < 60) {
            $("#nilai_nilai_prestasi").val('D');
          }else if ($("#kepemimpinan").val() <= 70) {
            $("#nilai_nilai_prestasi").val('C');
          }else if ($("#kepemimpinan").val() <= 80) {
            $("#nilai_nilai_prestasi").val('B');
          }else if ($("#kepemimpinan").val() <= 100) {
            $("#nilai_nilai_prestasi").val('A');
          }
        }
    }
      
      
      
        if ($('#id_pegawai').attr('value') == $('#id_pegawai_penilai_atasan').attr('value')) {
          $("input").prop('disabled', true);
          $("textarea").prop('disabled', true);
        }
  });
</script>
             