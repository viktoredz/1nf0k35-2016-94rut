<script>
  	$(function () { 
      $('#btn-up').click(function(){
        $.get('<?php echo base_url()?>eform/data_kepala_keluarga/anggota/{id_data_keluarga}', function (data) {
            $('#content2').html(data);
        });
      });

      $('#btn-up2').click(function(){
          window.scrollTo(0, 600);
          $('#content2' ).scrollTop(0);
      });

      $("#tgl_lahir").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height: '30px'});
	});
</script>

<?php if(validation_errors()!=""){ ?>
<div class="alert alert-warning alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<?php if($alert_form!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $alert_form?>
</div>
<?php } ?>
<form action="<?php echo base_url()?>eform/data_kepala_keluarga/{action}/{id_data_keluarga}" method="post">
<div class="row" style="margin: 0" id="tops">
  <div class="col-md-12">
    <div class="box-footer" style="text-align: right">
        <button type="button" id="btn-up" class="btn btn-success"><i class='fa  fa-arrow-circle-o-up'></i> &nbsp;Kembali</button>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-body">
          <label>Data Anggota Keluarga</label>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">NIK</div>
            <div class="col-md-8">
              <input type="text" name="norumah" id="norumah" placeholder="Nomor Rumah" value="<?php 
                if(set_value('norumah')=="" && isset($norumah)){
                  echo $norumah;
                }else{
                  echo  set_value('norumah');
                }
                ?>" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Nama</div>
            <div class="col-md-8">
              <input type="text" name="norumah" id="norumah" placeholder="Nomor Rumah" value="<?php 
                if(set_value('norumah')=="" && isset($norumah)){
                  echo $norumah;
                }else{
                  echo  set_value('norumah');
                }
                ?>" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Tempat Lahir</div>
            <div class="col-md-8">
              <input type="text" name="norumah" id="norumah" placeholder="Nomor Rumah" value="<?php 
                if(set_value('norumah')=="" && isset($norumah)){
                  echo $norumah;
                }else{
                  echo  set_value('norumah');
                }
                ?>" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Tanggal Lahir</div>
            <div class="col-md-8">
              <div id='tgl_lahir' name="tgl_lahir" value="<?php
                if(set_value('tgl_lahir')=="" && isset($tgl_lahir)){
                  $tgl_lahir = strtotime($tgl_lahir);
                }else{
                  $tgl_lahir = strtotime(set_value('tgl_lahir'));
                }
                if($tgl_lahir=="") $tgl_lahir = time();
                echo date("Y-m-d",$tgl_lahir);
              ?>" >
              </div>
            </div>
          </div>
          
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Hubungan Dengan KK</div>
            <div class="col-md-8">
              <select  name="kelurahan" id="kelurahan" class="form-control">
                <?php
                if(set_value('kelurahan')=="" && isset($kelurahan)){
                  $kelurahan = $kelurahan;
                }else{
                  $kelurahan = set_value('kelurahan');
                }

                foreach($data_desa as $row_desa){
                $select = $row_desa->code == $kelurahan ? 'selected' : '' ;
                ?>
                    <option value="<?php echo $row_desa->code; ?>" <?php echo $select; ?>><?php echo ucwords(strtolower($row_desa->value)); ?></option>
                <?php
                }    
                ?>
            </select>
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Jenis Kelamin</div>
            <div class="col-md-8">
              <select  name="kelurahan" id="kelurahan" class="form-control">
                <?php
                if(set_value('kelurahan')=="" && isset($kelurahan)){
                  $kelurahan = $kelurahan;
                }else{
                  $kelurahan = set_value('kelurahan');
                }

                foreach($data_desa as $row_desa){
                $select = $row_desa->code == $kelurahan ? 'selected' : '' ;
                ?>
                    <option value="<?php echo $row_desa->code; ?>" <?php echo $select; ?>><?php echo ucwords(strtolower($row_desa->value)); ?></option>
                <?php
                }    
                ?>
            </select>
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Agama</div>
            <div class="col-md-8">
              <select  name="kelurahan" id="kelurahan" class="form-control">
                <?php
                if(set_value('kelurahan')=="" && isset($kelurahan)){
                  $kelurahan = $kelurahan;
                }else{
                  $kelurahan = set_value('kelurahan');
                }

                foreach($data_desa as $row_desa){
                $select = $row_desa->code == $kelurahan ? 'selected' : '' ;
                ?>
                    <option value="<?php echo $row_desa->code; ?>" <?php echo $select; ?>><?php echo ucwords(strtolower($row_desa->value)); ?></option>
                <?php
                }    
                ?>
            </select>
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Pendidikan</div>
            <div class="col-md-8">
              <select  name="kelurahan" id="kelurahan" class="form-control">
                <?php
                if(set_value('kelurahan')=="" && isset($kelurahan)){
                  $kelurahan = $kelurahan;
                }else{
                  $kelurahan = set_value('kelurahan');
                }

                foreach($data_desa as $row_desa){
                $select = $row_desa->code == $kelurahan ? 'selected' : '' ;
                ?>
                    <option value="<?php echo $row_desa->code; ?>" <?php echo $select; ?>><?php echo ucwords(strtolower($row_desa->value)); ?></option>
                <?php
                }    
                ?>
            </select>
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Pekerjaan</div>
            <div class="col-md-8">
              <select  name="kelurahan" id="kelurahan" class="form-control">
                <?php
                if(set_value('kelurahan')=="" && isset($kelurahan)){
                  $kelurahan = $kelurahan;
                }else{
                  $kelurahan = set_value('kelurahan');
                }

                foreach($data_desa as $row_desa){
                $select = $row_desa->code == $kelurahan ? 'selected' : '' ;
                ?>
                    <option value="<?php echo $row_desa->code; ?>" <?php echo $select; ?>><?php echo ucwords(strtolower($row_desa->value)); ?></option>
                <?php
                }    
                ?>
            </select>
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Status Kawin</div>
            <div class="col-md-8">
              <select  name="kelurahan" id="kelurahan" class="form-control">
                <?php
                if(set_value('kelurahan')=="" && isset($kelurahan)){
                  $kelurahan = $kelurahan;
                }else{
                  $kelurahan = set_value('kelurahan');
                }

                foreach($data_desa as $row_desa){
                $select = $row_desa->code == $kelurahan ? 'selected' : '' ;
                ?>
                    <option value="<?php echo $row_desa->code; ?>" <?php echo $select; ?>><?php echo ucwords(strtolower($row_desa->value)); ?></option>
                <?php
                }    
                ?>
            </select>
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">JKN</div>
            <div class="col-md-8">
              <select  name="kelurahan" id="kelurahan" class="form-control">
                <?php
                if(set_value('kelurahan')=="" && isset($kelurahan)){
                  $kelurahan = $kelurahan;
                }else{
                  $kelurahan = set_value('kelurahan');
                }

                foreach($data_desa as $row_desa){
                $select = $row_desa->code == $kelurahan ? 'selected' : '' ;
                ?>
                    <option value="<?php echo $row_desa->code; ?>" <?php echo $select; ?>><?php echo ucwords(strtolower($row_desa->value)); ?></option>
                <?php
                }    
                ?>
            </select>
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Suku</div>
            <div class="col-md-8">
              <input type="text" name="norumah" id="norumah" placeholder="Nomor Rumah" value="<?php 
                if(set_value('norumah')=="" && isset($norumah)){
                  echo $norumah;
                }else{
                  echo  set_value('norumah');
                }
                ?>" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Nomor HP</div>
            <div class="col-md-8">
              <input type="text" name="norumah" id="norumah" placeholder="Nomor Rumah" value="<?php 
                if(set_value('norumah')=="" && isset($norumah)){
                  echo $norumah;
                }else{
                  echo  set_value('norumah');
                }
                ?>" class="form-control">
            </div>
          </div>

          </div>
        </div><!-- /.form-box -->
      </div><!-- /.form-box -->

      <div class="col-md-6">
        <div class="box box-warning">
          <div class="box-body">
          <label>Profile Umum Anggota Keluarga</label>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px">1. Punya Akte Lahir ?</div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px">2. WNA ?</div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px">3. Putus Sekolah ?</div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px">4. Ikut PAUD/ Sejenisnya ? </div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>

          <div class="row" style="margin: 5px;">
            <div class="col-md-7" style="padding: 5px">5. Ikut Kelompok Belajar ?</div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px 5px 5px 24px">Jika Ya, pilih jenis paket A, B, C baru KF</div>
            <div class="col-md-2 col-xs-3">
              <input type="radio"> A
            </div>
            <div class="col-md-3 col-xs-3">
              <input type="radio"> B
            </div>
            <div class="col-md-2 col-xs-3">
              <input type="radio"> C
            </div>
            <div class="col-md-3 col-xs-3">
              <input type="radio"> KF
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px">6. Punya Tabungan ?</div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>

          <div class="row" style="margin: 5px;">
            <div class="col-md-7" style="padding: 5px">7. Ikut Koperasi ?</div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px 5px 5px 24px">Jika Ya, tuliskan jenis</div>
            <div class="col-md-5">
              <input type="text" name="norumah" id="norumah" placeholder="Ikut Koperasi ?" value="<?php 
                if(set_value('norumah')=="" && isset($norumah)){
                  echo $norumah;
                }else{
                  echo  set_value('norumah');
                }
                ?>" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px">8. Usia Subur ?</div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px">9. Hamil ?</div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>
           
          <div class="row" style="margin: 5px;">
            <div class="col-md-7" style="padding: 5px">10. Disabilitas ?</div>
            <div class="col-md-2 col-xs-6">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Tidak
            </div>
          </div>
           
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px 5px 5px 24px">Jika Ya, tuliskan jenis</div>
            <div class="col-md-5">
              <input type="text" name="norumah" id="norumah" placeholder="Disabilitas ?" value="<?php 
                if(set_value('norumah')=="" && isset($norumah)){
                  echo $norumah;
                }else{
                  echo  set_value('norumah');
                }
                ?>" class="form-control">
            </div>
          </div>

          </div>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->
  </div>
</div>

<div class="row" style="margin: 0">
  <div class="col-md-12">

    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-body">
          <label>Profile Kesehatan Anggota Keluarga (1)</label>
          <br><br>
          <label>Pemeliharaan Kebersihan Diri<br>Perilaku Higienis</label>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Selalu mencuci tangan pakai sabun?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Selalu mencuci tangan pakai sabun?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Setiap kali tangan kotor (pegang uang,
binatang, berkebun)?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Setelah buang air besar?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Setelah mencebok bayi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">e. Setelah menggunakan pestisida/
insektisida?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">f. Sebelum menyusui bayi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">2. Lokasi biasa buang air besar?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Jamban?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Kolam/ Sawah/ Selokan?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Sungai/ Danau/ Laut?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Lubang tanah?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">e. Pantai/ Tanah Lapangan/ Kebun/
Halaman?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">3. Sikat gigi setiap hari? (Ya atau Tidak)?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">4. Kapan menyikat gigi?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Saat mandi pagi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Saat mandi sore?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Sesudah makan pagi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Sesudah bangun pagi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">e. Sebelum tidur malam?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">f. Sesudah makan siang?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <br>
          <label>Kondisi dan Riwayat Kesehatan Diri<br>Penggunaan Tembakau</label>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Merokok selama 1 bulan terakhir?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8 col-xs-11" style="padding: 5px 5px 5px 24px">a. Ya, setiap hari?</div>
            <div class="col-md-4 col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8 col-xs-11" style="padding: 5px 5px 5px 24px">b. Ya, kadang-kadang?</div>
            <div class="col-md-4 col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8 col-xs-11" style="padding: 5px 5px 5px 24px">c. Tidak, tapi dulu merokok setiap hari?</div>
            <div class="col-md-4 col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8 col-xs-11" style="padding: 5px 5px 5px 24px">d. Tidak, tapi dulu kadang-kadang?</div>
            <div class="col-md-4 col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8 col-xs-11" style="padding: 5px 5px 5px 24px">e. Tidak pernah sama sekali?</div>
            <div class="col-md-4 col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8" style="padding: 5px 5px 5px 24px">Umur berapa . . .</div>
            <div class="col-md-4">
              <input type="number" placeholder="Tahun" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8" style="padding: 5px">2. Mulai merokok setiap hari?</div>
            <div class="col-md-4">
              <input type="number" placeholder="Tahun" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8" style="padding: 5px">3. Pertama kali merokok ?</div>
            <div class="col-md-4">
              <input type="number" placeholder="Tahun" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">4. Untuk jawaban "Ya" di pertanyaan no. 1,</div>
            <div class="col-md-8" style="padding: 5px 5px 5px 22px">Jumlah batang rokok dikonsumsi per hari ?</div>
            <div class="col-md-4">
              <input type="number" placeholder="Batang" class="form-control">
            </div>
          </div>


          </div>
        </div><!-- /.form-box -->
      </div><!-- /.form-box -->

      <div class="col-md-6">
        <div class="box box-warning">
          <div class="box-body">
          <label>Profile Kesehatan Anggota Keluarga (2)</label>
          <br>
          <br>
          <label>Kondisi & Riwayat Kesehatan Diri<br>Tuberkulosis Paru (TB Paru)</label>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Pernah didiagnosa dengan atau tanpa foto dada (rontgen) oleh tenaga kesehatan (dokter/ perawat/ bidan)?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Ya, dalam ≤ 1 bulan terakhir?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Ya, > 1 bulan - 12 bulan?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Tidak?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Tidak tahu?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">2. Mengalami gejala penyakit demam, batuk, kesulitan
bernafas dengan atau tanpa nyeri dada?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Ya, dalam ≤ 1 bulan terakhir?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Ya, > 1 bulan - 12 bulan?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Tidak?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Tidak tahu?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">3. Jika ya, kesulitan yang dialami?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Napas cepat?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Napas cuping hidung?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Tarikan dinding dada bawah ke dalam?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>
          <br>
          <label>Penyakit Ginjal, untuk berumur ≥ 15 tahun</label>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Pernah didiagnosa menderita penyakit gagal ginjal kronis (min.
sakit selama 3 bulan berturut-turut) oleh dokter?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">2. Pernah didiagnosa mengalami penyakit batu ginjal oleh dokter?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <br>
          <label>Tuberkulosis Paru (TB Paru)</label>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Akhir-akhir ini batuk?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Ya, < 2 minggu terakhir?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Ya, ≥ 2 minggu?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Tidak?</div>
            <div class="col-xs-1">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">2. Jika iya, batuk disertai gejala?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Dahak?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Darah/ Dahak campur darah?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Demam?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Nyeri Dada?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">e. Sesak Nafas?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">f. Berkeringat malam hari tanpa kegiatan
fisik?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">g. Nafsu Makan menurun?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">h. Berat badan menurun/ sulit bertambah?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>


          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">3. Perlu didiagnosa TB Paru oleh tenaga kesehatan?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Ya, dalam ≤ 1 tahun terakhir?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Ya, > 1 tahun?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Tidak?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>


          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">4. Pemeriksaan yang digunakan untuk
menegakkan diagnosa TB?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Pemeriksaan dahak?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Pemeriksaan foto dada (Rontgen)?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          </div>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->
  </div>
</div>

<div class="row" style="margin: 0">
  <div class="col-md-12">

    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-body">
          <label>Profile Kesehatan Anggota Keluarga (3)</label>
          <br><br>
          <label>Kondisi & Riwayat Kesehatan Diri<br>Kanker</label>
          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Pernah didiagnosa menderita penyakit kanker oleh dokter ?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8" style="padding: 5px">2. Didiagnosa kanker pertama kali pada tahun?</div>
            <div class="col-md-4">
              <input type="number" placeholder="Tahun" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">3. Jenis kanker?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Kanker leher rahim (cervix uteri) ?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Kanker Payudara?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Kanker prostat?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Kanker kolorektal/ usus besar?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">e. Kanker paru dan bronkus?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">f. Kanker nasofaring?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">g. Kanker getah bening?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;">
            <div class="col-xs-6" style="padding: 5px 5px 5px 24px">h. Lainnya. Jenis :</div>
            <div class="col-xs-6">
              <input type="text" name="data_g_3_h" id="data_g_3_h" placeholder="Jenis Kanker" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">4. Sudah pernah test IVA (Inspeksi Visual dengan Asam Asetat)?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">5. Pengobatan kanker yang telah dijalani?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Pembedahan/ operasi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Radiasi/ penyinaran?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Kemoterapi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;">
            <div class="col-xs-6" style="padding: 5px 5px 5px 24px">d. Lainnya. Jenis :</div>
            <div class="col-xs-6">
              <input type="text" name="data_g_3_h" id="data_g_3_h" placeholder="Jenis Pengobatan" class="form-control">
            </div>
          </div>


          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">6. Sudah pernah test pap smear?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>
          <br>
          <label>Asma/ Mengi/ Bengek dan Penyakit Paru Obstruktif Kronik (PPOK)</label>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Pernah mengalami gejala sesak napas?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">2. Gejala sesak napas terjadi pada kondisi?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Terpapar udara dingin?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Debu?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Asap rokok?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Stress?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">e. Flu atau infeksi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">f. Kelelahan?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">g. Alergi obat?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">h. Alergi makanan?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">3. Gejala sesak napas disertai kondisi?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Mengi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Sesak napas berkurang atau menghilang dengan pengobatan?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Sesak napas berkurang atau menghilang tanpa pengobatan?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Sesak napas lebih berat dirasakan pada malam hari atau menjelang pagi?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-8" style="padding: 5px">4. Umur berapa mulai merasakan keluhan
sesak pertama kali</div>
            <div class="col-md-4">
              <input type="number" placeholder="Tahun" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;">
            <div class="col-md-12" style="padding: 5px">5. Sesak napas pernah kambuh dalam 12 bulan terakhir?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          </div>
        </div><!-- /.form-box -->
      </div><!-- /.form-box -->

      <div class="col-md-6">
        <div class="box box-warning">
          <div class="box-body">
          <label>Profile Kesehatan Anggota Keluarga (4)</label>
          <br><br>
          <label>Kondisi & Riwayat Kesehatan Diri<br>Kencing Manis (Diabetes Melitus), untuk berumur ≥ 15 tahun</label>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Pernah didiagnosa menderita kencing manis oleh dokter?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">2. Hal-hal untuk mengendalikan penyakit?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Diet ?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Olah raga?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Minum obat anti diabetik?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Injeksi insulin?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">3. Gejala dialami dalam 1 bulan terakhir?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Sering lapar ?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Sering haus?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Sering buang air kecil & jumlah banyak?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Berat badan turun?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>
          <br><br>
          <label>Hipertensi/ Tekanan Darah Tinggi, untuk berumur ≥ 15 tahun</label>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Pernah didiagnosa menderita hipertensi/ penyakit tekanan
darah tinggi oleh tenaga kesehatan (dokter/ perawat/ bidan)?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;">
            <div class="col-md-8" style="padding: 5px">2. Tahun berapa didiagnosa pertama kali?</div>
            <div class="col-md-4">
              <input type="number" placeholder="Tahun" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">3. Sedang minum obat medis untuk tekanan darah tinggi?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <br><br>
          <label>Penyakit Jantung Koroner, untuk berumur ≥ 15 tahun</label>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. Pernah didiagnosa menderita penyakit jantung koroner (Angina Pektoris dan/atau Infark Miokard) oleh tenaga kesehatan (dokter/ perawat/ bidan)?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;">
            <div class="col-md-8" style="padding: 5px">2. Tahun berapa didiagnosa pertama kali?</div>
            <div class="col-md-4">
              <input type="number" placeholder="Tahun" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">3. Gejala/ riwayat yang pernah dialami?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Nyeri di dalam dada/ rasa tertekan berat/ tidak nyaman di dada ?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Nyeri/ tidak nyaman di dada bagian tengah/ dada kiri depan/ menjalar ke lengan kiri?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Nyeri/ tidak nyaman di dada dirasakan waktu  endaki/ naik tangga/ berjalan tergesa-gesa?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Nyeri/ tidak nyaman di dada hilang ketika menghentikan aktivitas/ istirahat?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <br><br>
          <label>Stroke, untuk berumur ≥ 15 tahun</label>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">1. PPernah didiagnosa menderita penyakit stroke oleh tenaga kesehatan (dokter/ perawat/ bidan)?</div>
          </div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <div class="row" style="margin: 5px;">
            <div class="col-md-8" style="padding: 5px">2. Tahun berapa didiagnosa pertama kali?</div>
            <div class="col-md-4">
              <input type="number" placeholder="Tahun" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">3. Pernah alami keluhan secara mendadak?</div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">a. Kelumpuhan pada satu sisi tubuh ?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">b. Kesemutan atau baal satu sisi tubuh?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">c. Mulut jadi mencong tanpa kelumpuhan otot mata?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">d. Bicara pelo?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px 5px 5px 24px">e. Sulit bicara/ komunikasi dan/atau tidak mengerti pembicaraan?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          </div>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->
  </div>
</div>

<div class="row" style="margin: 0">
  <div class="col-md-12">

    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-body">
          <label>Profile Kesehatan Anggota Keluarga (5)</label>
          <br><br>
          <label>Kesehatan Jiwa Untuk berumur ≥ 15 tahun</label>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">1. Sering menderita sakit kepala?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">2. Tidak nafsu makan?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">3. Sulit tidur?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">4. Mudah takut?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">5. Merasa tegang, cemas atau kuatir?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">6. Tangan gemetar?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">7. Percernaan terganggu/ buruk?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">8. Sulit berpikir jernih?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">9. Merasa tidak bahagia?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">10. Menangis lebih sering?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">11. Merasa sulit menikmati kegiatan seharihari?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">12. Sulit mengambil keputusan?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">13. Pekerjaan sehari-hari terganggu?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">14. Tidak mampu melakukan hal-hal yang bermanfaat dalam hidup?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">15. Kehilangan minat dalam berbagai hal?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">1. Sering menderita sakit kepala?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">16. Merasa tidak berharga?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">17. Mempunya pikiran untuk mengakhiri hidup?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">18. Merasa lelah sepanjang waktu?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">19. Mengalami rasa tidak enak di perut?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-11" style="padding: 5px">20. Sering menderita sakit kepala?</div>
            <div class="col-xs-1">
              <input type="checkbox">
            </div>
          </div>

          <div class="col-md-12" style="padding: 5px">21. Untuk semua keluhan 1 s/d 20, pernah melakukan pengobatan ke fasilitas kesehatan/ tenaga kesehatan?</div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          <div class="col-md-12" style="padding: 5px">22. Jika pernah melakukan pengobatan ke fasilitas kesehatan/ tenaga kesehatan, apakah dalam 2 minggu terakhir?</div>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">a. Ya?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
            <div class="col-xs-3" style="padding: 5px 5px 5px 24px">b. Tidak?</div>
            <div class="col-xs-3">
              <input type="radio">
            </div>
          </div>

          </div>
        </div><!-- /.form-box -->
      </div><!-- /.form-box -->

      <div class="col-md-6">
        <div class="box box-warning">
          <div class="box-body">
          <label>Profile Kesehatan Anggota Keluarga (6)</label>
          <div class="row" style="margin: 5px;border-bottom:1px solid #EEEEEE;">
            <div class="col-md-7" style="padding: 5px">1. Status Imunisasi ?</div>
            <div class="col-md-2">
              <input type="radio"> Ya
            </div>
            <div class="col-md-3">
              <input type="radio"> Tidak
            </div>
          </div>

          <div class="row" style="margin: 5px;">
            <div class="col-md-12" style="padding: 5px">2. Aktivitas?</div>
            <div class="col-md-6" style="padding: 5px 5px 5px 24px">Olahraga</div>
            <div class="col-md-6">
              <input type="text" placeholder="Olahraga" class="form-control">
            </div>
            <div class="col-md-6" style="padding: 5px 5px 5px 24px">Tidur</div>
            <div class="col-md-6">
              <input type="text" placeholder="Olahraga" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">3. TTV (Tanda-Tanda Vital)?</div>
            <div class="col-md-6" style="padding: 5px 5px 5px 24px">TD : Tekanan Darah</div>
            <div class="col-md-6">
              <input type="number" placeholder="Olahraga" class="form-control">
            </div>
            <div class="col-md-6" style="padding: 5px 5px 5px 24px">N : Nadi</div>
            <div class="col-md-6">
              <input type="number" placeholder="Olahraga" class="form-control">
            </div>
            <div class="col-md-6" style="padding: 5px 5px 5px 24px">P: Pernapasan</div>
            <div class="col-md-6">
              <input type="number" placeholder="Olahraga" class="form-control">
            </div>
            <div class="col-md-6" style="padding: 5px 5px 5px 24px">S: Suhu</div>
            <div class="col-md-6">
              <input type="number" placeholder="Olahraga" class="form-control">
            </div>
          </div>


          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">4. Antropometri?</div>
            <div class="col-md-6" style="padding: 5px 5px 5px 24px">TB: Tinggi Badan</div>
            <div class="col-md-6">
              <input type="number" placeholder="Olahraga" class="form-control">
            </div>
            <div class="col-md-6" style="padding: 5px 5px 5px 24px">BB: Berat Badan</div>
            <div class="col-md-6">
              <input type="number" placeholder="Olahraga" class="form-control">
            </div>
            <div class="col-md-6" style="padding: 5px 5px 5px 24px">Status Gizi</div>
            <div class="col-md-6">
              <input type="number" placeholder="Olahraga" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-6" style="padding: 5px">5. Conjunctiva ?</div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Pucat
            </div>
            <div class="col-md-3 col-xs-6">
              <input type="radio"> Normal
            </div>
          </div>


          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">6. Riwayat Kesehatan?</div>
            <div class="col-md-12">
              <input type="text" placeholder="Olahraga" class="form-control">
            </div>
          </div>

          <div class="row" style="margin: 5px;border-top:1px solid #EEEEEE;">
            <div class="col-md-12" style="padding: 5px">7. Analisa Masalah Kesehatan?</div>
            <div class="col-md-12">
              <input type="text" placeholder="Olahraga" class="form-control">
            </div>
          </div>

          </div>

      </div><!-- /.form-box -->
    <div class="box-footer" style="text-align: right">
        <button type="button" id="btn-up2" class="btn btn-warning"><i class='fa  fa-arrow-circle-up'></i> &nbsp;Back To Top</button>
    </div>
    </div><!-- /.register-box -->
  </div>
</div></form>        
