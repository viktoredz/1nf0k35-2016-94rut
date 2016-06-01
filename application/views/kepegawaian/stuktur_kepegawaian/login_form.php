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
        close_popup();
      }); 
        $('#form-ss').submit(function(){
            var data = new FormData();
            $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#notice').show();
            data.append('username', $('#username').val());
            data.append('password', $('#password').val());
            data.append('cekpassword', $('#cekpassword').val());
            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."kepegawaian/stuktur_kepegawaian/".$action."/".$kode."/".$code_cl_phc ?>',
                data : data,
                success : function(response){
                  var res  = response.split("|");
                  if(res[0]=="OK"){
                      $('#notice').hide();
                      $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice').show();
                      $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                      close_popup();
                  }
                  else if(res[0]=="Error"){
                      $('#notice').hide();
                      $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice').show();
                  }
                  else{
                      $('#popup_content').html(response);
                  }
              }
            });

            return false;
        });

        
    });
    // $("#cekpassword ").change(function(){
    //     if ($("#cekpassword").val() != $("#password").val()) {
    //       alert("Maaf, data harus sama dengan password");
    //       $("#cekpassword").val('');
    //     }
    // });
</script>

<div style="padding:15px">
  <div id="notice" class="alert alert-success alert-dismissable" <?php if ($notice==""){ echo 'style="display:none"';} ?> >
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>
    <i class="icon fa fa-check"></i>
    Information!
    </h4>
    <div id="notice-content">{notice}</div>
  </div>
	<div class="row">
    <?php echo form_open(current_url(), 'id="form-ss"') ?>
          <div class="box-body">
            <div class="continer">
            <div class="form-group">
              <label>Username</label>
              <?php
              if (isset($id_pegawai) && isset($code) && isset($username)) {?>
                <label>: {username}</label>
              <?php
              }else{
            ?>
              <input id="username" class="form-control" autocomplete="off" name="code_mst_inv" placeholder="Username" type="text" value="<?php
              if(set_value('username')=="" && isset($username)){
                  echo $username;
                }else{
                  echo  set_value('username');
                }
                ?>"/>
            </div>
            <?php
              }
            ?>
            <?php
            if (isset($id_pegawai) && isset($code) && isset($username)) {
              # code...
              }else{
            ?>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" id="password" name="password"  placeholder="Password" value="<?php
              if(set_value('password')=="" && isset($password)){
                  echo $password;
                }else{
                  echo  set_value('password');
                }
                ?>">
            
            </div>
            <div class="form-group">
              <label>Confirm Password</label>
              <input type="password" class="form-control" id="cekpassword" name="cekpassword"  placeholder="Confirm Password" value="<?php
              if(set_value('cekpassword')=="" && isset($cekpassword)){
                  echo $cekpassword;
                }else{
                  echo  set_value('cekpassword');
                }
                ?>">
            
            </div>
            <?php
              }
            ?>
        <div class="box-footer" style="float:right;">
          <?php
            if (isset($id_pegawai) && isset($code) && isset($username)) {
              # code...
            }else{
          ?>
            <button type="submit" class="btn btn-primary">Simpan</button>
          <?php
            }
          ?>
            <button type="button" id="btn-close" class="btn btn-warning">
              <?php
                if (isset($id_pegawai) && isset($code) && isset($username)) {
                  echo "Tutup";
                }else{
              ?>
            Batal
            <?php
              }
            ?></button>
        </div>
    </div>
</form>
</div>
