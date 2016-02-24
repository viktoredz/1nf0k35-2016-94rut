</style>
<?php
if(isset($disable)){if($disable='disable'){?>

<script type="text/javascript">
  $("#dateInput").jqxDateTimeInput({ width: '300px', height: '25px' });
</script>
<?php }} ?>
<script type="text/javascript">  
    function jml(status) {
        var stok = "<?php echo $jml; ?>";
        var jmlbaik = $("#stok").val();
        var jmlrusak = $("#rusak").val();
        var jmltidak = $("#tidak").val();
        if ($("#rusak").val()<0) {
          alert("data tidak boleh kurang dari nol");
          $("#rusak").val("<?php echo $jml_rusak;?>");
          $("#stok").val(stok-$("#rusak").val()-$("#tidak").val());  
        }
        if ($("#tidak").val()<0) {
          alert("data tidak boleh kurang dari nol");
          $("#tidak").val("<?php echo $jml_tdkdipakai;?>");
          $("#stok").val(stok-$("#rusak").val()-$("#tidak").val());  
        }
        if($("#stok").val()==0){
          alert("Jumlah baik tidak boleh kurang dari kosong");  
          if (status=="tidak") {
             $("#tidak").val("<?php echo $jml_tdkdipakai;?>");
             $("#stok").val(stok-$("#rusak").val()-$("#tidak").val());
          }else if (status=="rusak"){
              $("#rusak").val("<?php echo $jml_rusak;?>");
              $("#stok").val(stok-$("#rusak").val()-$("#tidak").val());
          }
        }
        $("#stok").val(stok-$("#rusak").val()-$("#tidak").val());

      /*if($("#rusak").val() < 0 || $("#tidak").val() <0){
          alert("Maaf, data tidak boleh kurang dari nol");
          if(status=="rusak"){
            $("#rusak").val("");
            $("#stok").val(stok-jmlrusak-jmltidak);
          }else if (status=="tidak") {
            $("#tidak").val("");
            $("#stok").val(stok-jmlrusak-jmltidak);
          }
      }else{
        if($("#tidak").val() > $("#stok").val()){
          alert("Maaf! data tidak boleh lebih besar dari data jumlah baik");
          $("#tidak").val("");
          $("#stok").val(stok-jmlrusak-jmltidak);
        }else if($("#rusak").val() > $("#stok").val()){
          alert("Maaf! data tidak boleh lebih besar dari data jumlah baik");
          $("#rusak").val("");
          $("#stok").val(stok-jmlrusak-jmltidak);
        }else{
          if(status=="rusak"){
            document.getElementById("stok").value = stok - jmlrusak - jmltidak;  
          }else if (status=="tidak") {
             document.getElementById("stok").value = stok - jmlrusak - jmltidak;  
          }
        }
      }*/
    }
    $(function(){
      var stok = "<?php echo $jml; ?>";
     document.getElementById("stok").value = stok - document.getElementById("rusak").value - document.getElementById("tidak").value;
      $("#rusak").change(function(){
          jml("rusak");
      });
       $("#tidak").change(function(){
          jml("tidak");
      });
      $(document).ready(function() {
          $('#tblbarang').DataTable();
      } );
      $('#btn-close').click(function(){
        close_popup();
      }); 
        $('#form-ss').submit(function(){
            var data = new FormData();
            $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#notice').show();
            data.append('id_mst_inv_barang_habispakai', $('#kode').val());
            data.append('jml', $('#stok').val());
            data.append('jml_tdkdipakai', $('#tidak').val());
            data.append('jml_rusak', $('#rusak').val());
            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."inventory/bhp_opname/".$action."_barang/".$kode ?>',
                data : data,
                success : function(response){
                //  alert(response);
                  var res  = response.split("|");
                  if(res[0]=="OK"){
                      $('#notice').hide();
                      $('#notice-content').html('<div class="alert">'+res[2]+'</div>');
                      $('#notice').show();
                      $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                      timeline_kondisi_barang(res[1]);
                  }
                  else if(res[0]=="Error"){
                      $('#notice').hide();
                      $('#notice-content').html('<div class="alert">'+res[2]+'</div>');
                      $('#notice').show();
                      timeline_kondisi_barang(res[1]);
                  }
                  else{
                      $('#popup_content').html(response);
                      timeline_kondisi_barang($('#kode').val());
                  }
              }
            });

            return false;
        });

        
    });
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
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama Barang</label>
                  <div><?php echo $uraian;?></div>
                  <input type="hidden" class="form-control" name="kode" id="kode" placeholder="Kode" value="<?php 
                    if(set_value('kode')=="" && isset($kode)){
                      echo $kode;
                    }else{
                      echo  set_value('kode');
                    }
                    ?>">
                </div>
              </div>  
              <div class="col-md-6">
                <div class="form-group">
                  <label>Satuan</label>
                  <div><?php echo $nama_satuan;?></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jumlah Baik</label>
                  <input type="number" class="form-control" name="stok" id="stok" placeholder="Jumlah Baik" value="<?php 
                    if(set_value('stok')=="" && isset($jml)){
                      echo $jml;
                    }else{
                      echo  set_value('stok');
                    }
                    ?>" readonly="">
                </div>
              </div>  
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jumlah Rusak</label>
                  <input type="number" class="form-control" name="rusak" id="rusak" placeholder="Jumlah Rusak" value="<?php 
                    if(set_value('rusak')=="" && isset($jml_rusak)){
                      echo $jml_rusak;
                    }else{
                      echo  set_value('rusak');
                    }
                    ?>">
                </div>
              </div>
            </div>  
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jumlah Tidak dipakai</label>
                  <input type="number" class="form-control" name="tidak" id="tidak" placeholder="Jumlah Tidak dipakai" value="<?php 
                    if(set_value('tidak')=="" && isset($jml_tdkdipakai)){
                      echo $jml_tdkdipakai;
                    }else{
                      echo  set_value('tidak');
                    }
                    ?>">
                </div>
              </div>  
              <div class="col-md-6">
                <div class="form-group">
                  <label>Data Update</label>
                  <div><?php echo date("d-m-Y");?></div>
                </div>
              </div>
            </div>
            </div>
            <div class="box-footer" style="float:right;">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" id="btn-close" class="btn btn-warning">Tutup</button>
            </div>
    </div>
</form>
</div>
<div class="timeline-messages" id="timeline-barang"></div>