<?php if(validation_errors()!=""){ ?>
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
<?php } ?>
<div class="row">
  <form action="<?php echo base_url()?>kepegawaian/penilaiandppp/add" method="post">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body">
        <div class="form-group">
          <label>Tanggal dibuat</label>
          <div id='tgl_dibuat' name="tgl_dibuat" value="<?php
              if(set_value('tgl_dibuat')=="" && isset($tgl_dibuat)){
                date("Y-m-d",strtotime($tgl_dibuat));
              }else{
                date("Y-m-d",strtotime(set_value('tgl_dibuat')));
              }
            ?>"></div>
        </div>
    <?php
      if ($action!='add') {
    ?>
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
    <?php
      }
    ?>
        <div class="form-group">
          <label>Pegawai</label>
          <input type="text" class="form-control" name="namapegawai" id="namapegawai" placeholder="Nama Pegawai" value="<?php 
            if(set_value('namapegawai')=="" && isset($namapegawai)){
                echo $namapegawai;
              }else{
                echo  set_value('namapegawai');
              }
            ?>">
            <input type="hidden" class="form-control" name="id_pegawai" id="id_pegawai" placeholder="ID Pegawai" value="<?php 
            if(set_value('id_pegawai')=="" && isset($id_pegawai)){
                echo $id_pegawai;
              }else{
                echo  set_value('id_pegawai');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Tahun</label>
            <select name="tahun" id="tahun" class="form-control">
              <?php 
                if ($tahun!='') {
                  $tahun = $tahun;# code...
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
          <label>Penilai</label>
          <input type="text" class="form-control" name="namapenilai" id="namapenilai" placeholder="Nama Pegawai" value="<?php 
            if(set_value('namapenilai')=="" && isset($namapenilai)){
                echo $namapenilai;
              }else{
                echo  set_value('namapenilai');
              }
            ?>">
            <input type="hidden" class="form-control" name="id_pegawai_penilai" id="id_pegawai_penilai" placeholder="ID Penilai" value="<?php 
            if(set_value('id_pegawai_penilai')=="" && isset($id_pegawai_penilai)){
                echo $id_pegawai_penilai;
              }else{
                echo  set_value('id_pegawai_penilai');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Atasan Penilai</label>
          <input type="text" class="form-control" name="namapenilaiatasan" id="namapenilaiatasan" placeholder="Nama Pegawai" value="<?php 
            if(set_value('namapenilaiatasan')=="" && isset($namapenilaiatasan)){
                echo $namapenilaiatasan;
              }else{
                echo  set_value('namapenilaiatasan');
              }
            ?>">
            <input type="hidden" class="form-control" name="id_pegawai_penilai_atasan" id="id_pegawai_penilai_atasan" placeholder="ID Penilai Atasan" value="<?php 
            if(set_value('id_pegawai_penilai_atasan')=="" && isset($id_pegawai_penilai_atasan)){
                echo $id_pegawai_penilai_atasan;
              }else{
                echo  set_value('id_pegawai_penilai_atasan');
              }
            ?>">
        </div>
    <?php
      if ($action!='add') {
    ?>
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
          <textarea class="form-control" name="keberatan" id="keberatan" placeholder="Keberatan"><?php 
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
          <textarea class="form-control" name="tanggapan" id="tanggapan" placeholder="Tanggapan"><?php 
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
          <textarea class="form-control" name="keputusan" id="keputusan" placeholder="Keputusan"><?php 
              if(set_value('keputusan')=="" && isset($keputusan)){
                echo $keputusan;
              }else{
                echo  set_value('keputusan');
              }
              ?></textarea>
        </div>  
        <div class="form-group">
          <label>Rekomendasi</label>
          <textarea class="form-control" name="rekomendasi" id="rekomendasi" placeholder="Rekomendasi"><?php 
              if(set_value('rekomendasi')=="" && isset($rekomendasi)){
                echo $rekomendasi;
              }else{
                echo  set_value('rekomendasi');
              }
              ?></textarea>
        </div>
        <div class="form-group">
          <label>Tanggal Keputusan</label>
          <div id='tgl_diterima' name="tgl_diterima" value="<?php
              if(set_value('tgl_diterima')=="" && isset($tgl_diterima)){
                date("Y-m-d",strtotime($tgl_diterima));
              }else{
                date("Y-m-d",strtotime(set_value('tgl_diterima')));
              }
            ?>"></div>
        </div>
    <?php
      }
    ?>    
        
        
        
         
      </div>
    </div>
  </div><!-- /.form-box -->

  <div class="col-md-6">
    <div class="box box-warning">
      <div class="box-body">
        <div class="form-group">
          <label>SKP</label>
          <input type="number" class="form-control" name="skp" id="skp" placeholder="SKP" value="<?php 
            if(set_value('skp')=="" && isset($skp)){
                echo $skp;
              }else{
                echo  set_value('skp');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>SKP</label>
          <input type="number" class="form-control" name="pelayanan" id="pelayanan" placeholder="Pelayanan" value="<?php 
            if(set_value('pelayanan')=="" && isset($pelayanan)){
                echo $pelayanan;
              }else{
                echo  set_value('pelayanan');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Integritas</label>
          <input type="number" class="form-control" name="integritas" id="integritas" placeholder="Integritas" value="<?php 
            if(set_value('integritas')=="" && isset($integritas)){
                echo $integritas;
              }else{
                echo  set_value('integritas');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Komitmen</label>
          <input type="number" class="form-control" name="komitmen" id="komitmen" placeholder="Komitmen" value="<?php 
            if(set_value('komitmen')=="" && isset($komitmen)){
                echo $komitmen;
              }else{
                echo  set_value('komitmen');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Disiplin</label>
          <input type="number" class="form-control" name="disiplin" id="disiplin" placeholder="Disiplin" value="<?php 
            if(set_value('disiplin')=="" && isset($disiplin)){
                echo $disiplin;
              }else{
                echo  set_value('disiplin');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Kerjasama</label>
          <input type="number" class="form-control" name="kerjasama" id="kerjasama" placeholder="Kerjasama" value="<?php 
            if(set_value('kerjasama')=="" && isset($kerjasama)){
                echo $kerjasama;
              }else{
                echo  set_value('kerjasama');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Kepemimpinan</label>
          <input type="number" class="form-control" name="kepemimpinan" id="kepemimpinan" placeholder="Kepemimpinan" value="<?php 
            if(set_value('kepemimpinan')=="" && isset($kepemimpinan)){
                echo $kepemimpinan;
              }else{
                echo  set_value('kepemimpinan');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Jumlah</label>
          <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php 
            if(set_value('jumlah')=="" && isset($jumlah)){
                echo $jumlah;
              }else{
                echo  set_value('jumlah');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Rata - rata</label>
          <input type="number" class="form-control" name="ratarata" id="ratarata" placeholder="Rata - rata" value="<?php 
            if(set_value('ratarata')=="" && isset($ratarata)){
                echo $ratarata;
              }else{
                echo  set_value('ratarata');
              }
            ?>">
        </div>
        <div class="form-group">
          <label>Nilai Prestasi</label>
          <input type="number" class="form-control" name="nilai_prestasi" id="nilai_prestasi" placeholder="Nilai Prestasi" value="<?php 
            if(set_value('nilai_prestasi')=="" && isset($nilai_prestasi)){
                echo $nilai_prestasi;
              }else{
                echo  set_value('nilai_prestasi');
              }
            ?>">
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-primary"><i class='fa fa-save'></i> &nbsp; Simpan & Lanjutkan</button>
        <button type="button" id="btn-kembali" class="btn btn-warning"><i class='fa fa-reply'></i> &nbsp; Kembali</button>
      </div>
      </div>
    </form>        

  </div><!-- /.form-box -->
</div><!-- /.register-box -->

<script type="text/javascript">
$(function(){
    $("#menu_kepegawaian").addClass("active");
    $("#menu_kepegawaian_penilaiandppp").addClass("active");


    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>kepegawaian/penilaiandppp";
    });
  <?php
  if ($action!='add') {
  ?>
    $("#keberatan_tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
    $("#tanggapan_tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
    $("#keputusan_tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
    $("#tgl_diterima").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
    $("#tgl_diterima_atasan").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
  <?php 
    }else{
  ?>
    $("#tgl_dibuat").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
  <?php
    }
  ?>
    


  });
  
</script>
