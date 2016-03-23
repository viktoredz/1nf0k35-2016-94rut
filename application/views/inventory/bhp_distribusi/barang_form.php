
<script type="text/javascript">

  $(function(){
    <?php 
    if (isset($obat)) {
      if ($obat=="8") {
    ?>
      $("[name='tgl_kadaluarsa']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme , height: '30px'});
    <?php
      }else{}
    }
    ?>
      $('#btn-close').click(function(){
        close_popup();
      }); 

      $('#form-ss').submit(function(){
          var data = new FormData();
          $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
          $('#notice').show();
          data.append('id_mst_inv_barang', $('#id_mst_inv_barang').val());
          data.append('jqxinput', $('#jqxinput').val());
          data.append('tanggal_diterima', $('#dateInput').val());
          data.append('tgl_kadaluarsa', $('#tgl_kadaluarsa').val());
          data.append('nama_barang', $('#v_nama_barang').val());
          data.append('jumlah', $('#jumlah').val());
          data.append('jml_rusak', $('#jml_rusak').val());
          data.append('batch', $('#batch').val());
          data.append('harga', $('#harga').val());
          data.append('obat', $('#id_mst_inv_barang_habispakai_jenis').val());
          data.append('subtotal', $('#subtotal').val());
          data.append('id_permohonan_barang', "<?php echo $kode;?>");
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."inventory/bhp_pengadaan/".$action."_barang/".$id_distribusi."/".$kode."/".$id_mst_inv_barang_habispakai_jenis."/" ?>',
              data : data,
              success : function(response){
                var res  = response.split("|");
                if(res[0]=="OK"){
                    $('#notice').hide();
                    $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                    $('#notice').show();
                    $("#jqxgrid_barang").jqxGrid('updatebounddata', 'cells');
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
      $("#jumlahdistribusi").change(function(){
          var jmlasli = "<?php if(set_value('jumlah')=="" && isset($jumlah)){
                            echo $jumlah - $jmldistribusi;
                          }else{
                            echo  set_value('jumlah');
                          } ?>";
          $("#jumlah").val(jmlasli - $("#jumlahdistribusi").val());
          if ($("#jumlah").val() <= 0){
            alert("Maaf, tidak ada data yang bisa di distribusikan");
            $("#jumlahdistribusi").val(0);
            $("#jumlah").val(jmlasli);
          };

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
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Nama Barang</div>
            <div class="col-md-8">
              <input type="text" class="form-control" name="uraian" id="uraian" placeholder="Nama Barang" value="<?php 
                if(set_value('uraian')=="" && isset($uraian)){
                  echo $uraian;
                }else{
                  echo  set_value('uraian');
                }
                ?>">
            </div>
          </div>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Jumlah</div>
            <div class="col-md-8">
              <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php 
                if(set_value('jumlah')=="" && isset($jumlah)){
                  echo $jumlah - $jmldistribusi;
                }else{
                  echo  set_value('jumlah');
                }
                ?>">
            </div>
            <input type="hidden" class="form-control" name="id_mst_inv_barang_habispakai_jenis" id="id_mst_inv_barang_habispakai_jenis" placeholder="Jumlah" value="<?php 
                if(set_value('id_mst_inv_barang_habispakai_jenis')=="" && isset($id_mst_inv_barang_habispakai_jenis)){
                  echo $id_mst_inv_barang_habispakai_jenis;
                }else{
                  echo  set_value('id_mst_inv_barang_habispakai_jenis');
                }
                ?>">
          </div>
          <?php 
            if (isset($id_mst_inv_barang_habispakai_jenis)) {
              if ($id_mst_inv_barang_habispakai_jenis=="8") {
          ?>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Nomor Batch</div>
            <div class="col-md-8">
              <input type="text" class="form-control" name="batch" id="batch" placeholder="Nomor Batch" value="<?php 
                if(set_value('batch')=="" && isset($batch)){
                  echo $batch;
                }else{
                  echo  set_value('batch');
                }
                ?>">
            </div>
          </div>
          <?php
           # code...
              }else{

              }
            }
          ?>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">Jumlah Distribusi</div>
            <div class="col-md-8">
              <input type="number" class="form-control" name="jumlahdistribusi" id="jumlahdistribusi" placeholder="Jumlah Rusak" value="<?php 
                if(set_value('jumlahdistribusi')=="" && isset($jumlahdistribusi)){
                  echo $jumlahdistribusi;
                }else{
                  echo  set_value('jumlahdistribusi');
                }
                ?>">
            </div>
          </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" id="btn-close" class="btn btn-warning">Batal</button>
        </div>
    </div>
</form>
</div>
<div id="popup_masterbarang" style="display:none">
  <div id="popup_mastertitle">Data master Barang</div>
  <div id="popup_mastercontent">&nbsp;</div>
</div>