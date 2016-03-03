<script>
  	$(function () { 
     	$('#btn-up,#btn-up2').click(function(){
        $.get('<?php echo base_url()?>eform/data_kepala_keluarga/anggota/{id_data_keluarga}', function (data) {
            $('#content2').html(data);
        });
	    });

      $('#btn-save-add').click(function(){
        $.get('<?php echo base_url()?>eform/data_kepala_keluarga/anggota_edit/{id_data_keluarga}/'+id, function (data) {
            $('#content2').html(data);
        });
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
<div class="row" style="margin: 0">
  <div class="col-md-12">
    <div class="box-footer" style="text-align: right">
        <button type="button" id="btn-save-add" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan & Lanjutkan</button>
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

    </div><!-- /.register-box -->
  </div>
</div>

</form>        
