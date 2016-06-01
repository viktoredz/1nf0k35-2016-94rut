</style>
<?php
if(isset($disable)){if($disable='disable'){?>

<script type="text/javascript">
  $("#dateInput").jqxDateTimeInput({ width: '300px', height: '25px' });
</script>
<?php }} ?>
<script type="text/javascript">


  

    $(function(){
      $('#btn-close').click(function(){
          popup_close();
      }); 
        $('#form-ss-pegawai').submit(function(){
            var data = new FormData();
            $('#notice-content-pegawai').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#notice-pegawai').show();
            data.append('tugas', $('#tugas').val());
            data.append('output', $('#output').val());
            data.append('target', $('#target').val());
            data.append('waktu', $('#waktu').val());
            data.append('biaya', $('#biaya').val());
            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."kepegawaian/penilaiandppp/".$action."_dppp/".$kode."/".$id_dppp."/".$code_cl_phc ?>',
                data : data,
                success : function(response){
                  var res  = response.split("|");
                  if(res[0]=="OK"){
                      $('#notice-pegawai').hide();
                      $('#notice-content-pegawai').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice-pegawai').show();
                      $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                      popup_close();
                  }
                  else if(res[0]=="Error"){
                      $('#notice-pegawai').hide();
                      $('#notice-content-pegawai').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice-pegawai').show();
                  }
                  else{
                      $('#popup_dppp').html(response);
                  }
              }
            });

            return false;
        });

        
    });
</script>

<div style="padding:15px">
  <div id="notice-pegawai" class="alert alert-success alert-dismissable" <?php if ($notice==""){ echo 'style="display:none"';} ?> >
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>
    <i class="icon fa fa-check"></i>
    Information!
    </h4>
    <div id="notice-content-pegawai">{notice}</div>
  </div>
  <div class="row">
    <?php echo form_open(current_url(), 'id="form-ss-pegawai"') ?>
          <div class="box-body">
            <div class="continer">
            <div class="form-group">
              <label>Tugas</label>
              <input id="tugas" class="form-control"  name="tugas" placeholder="Tugas" type="text" value="<?php
              if(set_value('tugas')=="" && isset($tugas)){
                  echo $tugas;
                }else{
                  echo  set_value('tugas');
                }
                ?>"/>
            </div>
            <div class="form-group">
              <label>Output</label>
              <input type="text" class="form-control" id="output" name="output"  placeholder="Output" value="<?php
              if(set_value('output')=="" && isset($output)){
                  echo $output;
                }else{
                  echo  set_value('output');
                }
                ?>">
            
            </div>
            <div class="form-group">
              <label>Target</label>
              <input type="number" class="form-control" id="target" name="target"  placeholder="Target" value="<?php
              if(set_value('target')=="" && isset($target)){
                  echo $target;
                }else{
                  echo  set_value('target');
                }
                ?>">
            
            </div>
            <div class="form-group">
              <label>Waktu</label>
              <input type="number" class="form-control" id="waktu" name="waktu"  placeholder="Waktu" value="<?php
              if(set_value('waktu')=="" && isset($waktu)){
                  echo $waktu;
                }else{
                  echo  set_value('waktu');
                }
                ?>">
            
            </div>
            <div class="form-group">
              <label>Biaya</label>
              <input type="number" class="form-control" id="biaya" name="cekpassbiayaword"  placeholder="Biaya" value="<?php
              if(set_value('biaya')=="" && isset($biaya)){
                  echo $biaya;
                }else{
                  echo  set_value('biaya');
                }
                ?>">
            
            </div>
        <div class="box-footer" style="float:right;">
          
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" id="btn-close" class="btn btn-warning">Batal</button>
        </div>
    </div>
</form>
</div>
