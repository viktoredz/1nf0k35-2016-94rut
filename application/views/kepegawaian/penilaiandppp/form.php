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
if ($username == $userdataname) {
  $funshowhidden = 'disabled=disabled';
  $showhidetgl = ',disabled: true';
  $gridshowedit = ', editable:false';
  $showtanggapan = '';
  $showtanggapantgl = '';
}else{
  $funshowhidden='';
  $showhidetgl = '';
  $gridshowedit = '';
  $showtanggapan = 'disabled=disabled';
  $showtanggapantgl = ',disabled: true';
}

?>
<script type="text/javascript">
    function ambil_nip_penilai()
    {
      var kode = "<?php echo $idlogin; ?>";
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/penilaiandppp/nipterakhirpenilai' ?>/"+kode,
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          $("#namapenilaiterakhir").html(elemet.namaterakhir);
          $("#nippenilaiterakhir").html(elemet.nipterakhir);
          $("#id_pegawai_penilai").val(elemet.nipterakhir);
          $("#id_pegawai_penilai_atasan").val(elemet.id_atasanpenilai);
          $("#pangkatpenilaiterakhir").html(elemet.pangkatterakhir);
          $("#jabatanpenilaiterakhir").html(elemet.pangkatjabatanterakhir);
          $("#unitkerjapenilaiterakhir").html(elemet.ukterakhir);
        });
      }
      });

      return false;
    }
    $(function(){
      ambil_nip_penilai();
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
            if ($('#username').val()!="<?php echo $userdataname; ?>") {
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
            data.append('nilai_nilai_skp', $('#nilai_skp').val());
            data.append('nilai_pelayanan', $('#nilai_pelayanan').val());
            data.append('nilai_integritas', $('#inilai_ntegritas').val());
            data.append('nilai_komitmen', $('#nilai_komitmen').val());
            data.append('nilai_disiplin', $('#nilai_disiplin').val());
            data.append('nilai_kerjasama', $('#knilai_erjasama').val());
            data.append('nilai_kepemimpinan', $('#knilai_epemimpinan').val());
            data.append('nilai_jumlah', $('#nilai_jumlah').val());
            data.append('nilai_ratarata', $('#nilai_ratarata').val());
            data.append('nilai_nilai_prestasi', $('#nilai_nilai_prestasi').val());
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
                      $("#tambahjqxgrid").hide();
                      $("#btn_back_dppp").hide();
                      $("#btn_add_dppp").show();
                      $("#jqxgrid").show();
                      $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                  }
                  else if(res[0]=="Error"){
                      $('#notice-pegawai').hide();
                      $('#notice-content-pegawai').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice-pegawai').show();
                  }
                  else{
                      $('#tambahjqxgrid').html(response);
                  }
              }
            });

            return false;
        });

        
    });
</script>
 <?php echo form_open(current_url(), 'id="form-ss-penilaidpp"') ?>
      
<div class="row">
  <div class="col-md-12">
  <div class="box-footer" style="float:right">
    <button type="submit" class="btn btn-primary"><i class='fa fa-save'></i> &nbsp; Simpan & Lanjutkan</button>
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
        
        <input type="text" class="form-control" name="id_pegawai" id="id_pegawai" placeholder="ID Pegawai" value="<?php 
        if(set_value('id_pegawai')=="" && isset($id_pegawai)){
            echo $id_pegawai;
          }else{
            echo  set_value('id_pegawai');
          }
        ?>">
        <input type="text" class="form-control" name="id_pegawai_penilai" id="id_pegawai_penilai" placeholder="ID Penilai" value="<?php 
            if(set_value('id_pegawai_penilai')=="" && isset($id_pegawai_penilai)){
                echo $id_pegawai_penilai;
              }else{
                echo  set_value('id_pegawai_penilai');
              }
            ?>">
        <input type="text" class="form-control" name="id_pegawai_penilai_atasan" id="id_pegawai_penilai_atasan" placeholder="ID Penilai Atasan" value="<?php 
            if(set_value('id_pegawai_penilai_atasan')=="" && isset($id_pegawai_penilai_atasan)){
                echo $id_pegawai_penilai_atasan;
              }else{
                echo  set_value('id_pegawai_penilai_atasan');
              }
            ?>">
          <input type="text" class="form-control" name="username" id="username" placeholder="username" value="<?php 
          if(set_value('username')=="" && isset($username)){
              echo $username;
            }else{
              echo  set_value('username');
            }
          ?>">
          <input type="text" class="form-control" name="username" id="idlogin" placeholder="idlogin" value="<?php 
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
                  $tahun = date("Y");
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
          <textarea <?php echo $showtanggapan;?> class="form-control" name="keberatan" id="keberatan" placeholder="Keberatan"><?php 
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
                date("Y-m-d",strtotime(set_value('tgltanggapan')));
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
          <textarea <?php echo $funshowhidden;?> class="form-control" name="keputusan" id="keputusan" placeholder="Keputusan"><?php 
              if(set_value('keputusan')=="" && isset($keputusan)){
                echo $keputusan;
              }else{
                echo  set_value('keputusan');
              }
              ?></textarea>
        </div>  
        <div class="form-group">
          <label>Rekomendasi</label>
          <textarea <?php echo $funshowhidden;?> class="form-control" name="rekomendasi" id="rekomendasi" placeholder="Rekomendasi"><?php 
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
            <input <?php echo $funshowhidden;?> type="number" class="form-control" name="skp" id="skp" placeholder="SKP" value="<?php 
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
            <input <?php echo $funshowhidden;?> type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php 
            if(set_value('jumlah')=="" && isset($jumlah)){
                echo $jumlah;
              }else{
                echo  set_value('jumlah');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input type="text" class="form-control" name="nilaijumlah" id="nilaijumlah" placeholder="Nilai Jumlah" value="<?php 
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
            <input <?php echo $funshowhidden;?> type="number" class="form-control" name="ratarata" id="ratarata" placeholder="Rata - rata" value="<?php 
            if(set_value('ratarata')=="" && isset($ratarata)){
                echo $ratarata;
              }else{
                echo  set_value('ratarata');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="nilairatarata" id="nilairatarata" placeholder="Nilai Rata - rata" value="<?php 
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
            <input <?php echo $funshowhidden;?> type="number" class="form-control" name="nilai_prestasi" id="nilai_prestasi" placeholder="Nilai Prestasi" value="<?php 
            if(set_value('nilai_prestasi')=="" && isset($nilai_prestasi)){
                echo $nilai_prestasi;
              }else{
                echo  set_value('nilai_prestasi');
              }
            ?>">
          </div>
          <div class="col-md-4">
            <input <?php echo $funshowhidden;?> type="text" class="form-control" name="nilai_nilai_prestasi" id="nilai_nilai_prestasi" placeholder="Nilai Prestasi" value="<?php 
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
<div class="row">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-body">
          <!-- <table border="1">
            <tr>
              <th rowspan="2" width="3%"  align="center">No</th>
              <th rowspan="2" width="15%" align="center">Kegiatan Tugas Jabatan</th>
              <th rowspan="2" width="3%"  align="center">AK</th>
              <th colspan="4" width="30%" align="center">Target</th>
              <th rowspan="2" width="3%"  align="center">AK</th>
              <th colspan="4" width="30%" align="center">Realisasi</th>
              <th rowspan="2" width="8%"  align="center">Perhitungan</th>
              <th rowspan="2" width="8%"  align="center">Nilai Pencapaian SKP</th>
            </tr>
            <tr>
              <th width="7%">Kuant/ Output</th>
              <th width="7%">Kual/Mutu</th>
              <th width="7%">Waktu (Bulan)</th>
              <th width="9%">Biaya</th>
              <th width="7%">Kuant/ Output</th>
              <th width="7%">Kual/Mutu</th>
              <th width="7%">Waktu (Bulan)</th>
              <th width="9%">Biaya</th>
            </tr>
            <tr>
              <th rowspan="2" width="3%"  align="center">1</th>
              <th rowspan="2" width="15%" align="center">2</th>
              <th rowspan="2" width="3%"  align="center">3</th>
              <th width="7%">4</th>
              <th width="7%">5</th>
              <th width="7%">6</th>
              <th width="9%">7</th>
              <th rowspan="2" width="3%"  align="center">8</th>
              <th width="7%">9</th>
              <th width="7%">10</th>
              <th width="7%">11</th>
              <th width="9%">12</th>
              <th rowspan="2" width="8%"  align="center">13</th>
              <th rowspan="2" width="8%"  align="center">14</th>
            </tr>
            <?php 

            ?>
          </table> -->
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
</form>  

<script type="text/javascript">
$(function(){
    $("#menu_kepegawaian").addClass("active");
    $("#menu_kepegawaian_penilaiandppp").addClass("active");


    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>kepegawaian/penilaiandppp";
    });
    $("#keberatan_tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showtanggapantgl;?>});
    $("#tanggapan_tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showhidetgl;?>});
    $("#keputusan_tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showhidetgl;?>});
    $("#tgl_diterima").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showhidetgl;?>});
    $("#tgl_diterima_atasan").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showhidetgl;?>});
    $("#tgl_dibuat").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme <?php echo $showhidetgl;?>});
    


  });
    $(document).ready(function () {
            // prepare the data
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
          { name: 'ak_nilai', type: 'string'},
          { name: 'kuant_nilai', type: 'string'},
          { name: 'kuant_output_nilai', type: 'string'},
          { name: 'target_nilai', type: 'string'},
          { name: 'waktu_nilai', type: 'string'},
          { name: 'biaya_nilai', type: 'string'},
          { name: 'perhitungan_nilai', type: 'string'},
          { name: 'pencapaian_nilai', type: 'string'},
          { name: 'id_pegawai', type: 'string'},
          { name: 'tahun', type: 'string'},
          { name: 'edit', type: 'number'},
          { name: 'delete', type: 'number'}
            ],
        url: "<?php echo site_url('kepegawaian/penilaiandppp/json_skp/{id_mst_peg_struktur_org}/{id_pegawai}'); ?>",
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
            commit(true);
            var arr = $.map(rowData, function(el) { return el });         
            
            if(typeof(arr[1]) === 'object'){
              var arr2 = $.map(arr[1], function(el) { return el });
              if(arr[4] + '' + arr[5] + '' + arr[6] + '' + arr[7]+ '' + arr[8]!='') {
                $.post( '<?php echo base_url()?>mst/keuangan_akun/akun_add', {id_mst_akun:arr[2],id_mst_akun_parent:arr2[0], uraian:arr[4], kode:arr[5], saldo_normal:arr[6], saldo_awal : arr[7], mendukung_transaksi : arr[8]}, function( data ) {
                    if(data != 0){
                      alert(data);                  
                    }else{
                      alert("Data "+arr[4]+" berhasil disimpan");                  
                    }
                });
              }
            }else{    
              $.post( '<?php echo base_url()?>kepegawaian/penilaiandppp/updatenilaiskp', 
                {
                  row:rowID,
                  id_pegawai:"<?php echo $id_pegawai?>",
                  tahun:$('#tahun').val(), 
                  id_mst_peg_struktur_org: "<?php echo $id_mst_peg_struktur_org?>", 
                  id_mst_peg_struktur_skp : arr[2], 
                  ak : arr[12], 
                  kuant:arr[13], 
                  target : arr[13],
                  waktu : arr[14],
                  biaya : arr[15]
                },
                function( data ) {
                  if(data != 0){
                    alert(data);
                  }
              });
            }
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
            { text: 'Kuant/ Output',columngroup: 'target', cellsalign: 'center',editable:false ,align: 'center', datafield: 'kuant_output', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Kual/Mutu',columngroup: 'target', editable:false ,align: 'center', datafield: 'target', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Waktu (Bulan)',columngroup: 'target', editable:false ,align: 'center', cellsalign: 'right', datafield: 'waktu', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Biaya',columngroup: 'target', editable:false ,align: 'center', cellsalign: 'right', datafield: 'biaya', columntype: 'textbox', filtertype: 'textbox', width: '9%' },
            { text: 'AK',align: 'center'<?php echo $gridshowedit; ?>, cellsalign: 'center', datafield: 'ak_nilai', columntype: 'textbox', filtertype: 'textbox', width: '3%' },
            { text: 'Kuant/ Output' <?php echo $gridshowedit; ?>,columngroup: 'realisasi',align: 'center',cellsalign: 'center', datafield: 'kuant_output_nilai', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Kual/Mutu' <?php echo $gridshowedit; ?>,columngroup: 'realisasi',align: 'center',  datafield: 'target_nilai', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Waktu (Bulan)' <?php echo $gridshowedit; ?>,columngroup: 'realisasi',align: 'center', cellsalign: 'right', datafield: 'waktu_nilai', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
            { text: 'Biaya' <?php echo $gridshowedit; ?>,columngroup: 'realisasi',align: 'center', cellsalign: 'right', datafield: 'biaya_nilai', columntype: 'textbox', filtertype: 'textbox', width: '9%' },
            { text: 'Perhitungan' <?php echo $gridshowedit; ?>,align: 'center', cellsalign: 'right', datafield: 'perhitungan_nilai', columntype: 'textbox', filtertype: 'none', width: '8%' },
            { text: 'Nilai Pencapaian SKP' <?php echo $gridshowedit; ?>,align: 'center', cellsalign: 'right', datafield: 'pencapaian_nilai', columntype: 'textbox', filtertype: 'none', width: '8%' },
            ],

            columngroups: 
            [
              { text: 'Target', align: 'center', name: 'target' },
              { text: 'Realisasi', align: 'center', name: 'realisasi' }
            ]
        });
        });
</script>
             