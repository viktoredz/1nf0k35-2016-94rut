</style>
<?php
if(isset($disable)){if($disable='disable'){?>

<script type="text/javascript">
  $("#dateInput").jqxDateTimeInput({ width: '300px', height: '25px' });
</script>
<?php }} ?>
<script type="text/javascript">

  
  function toRp(a,b,c,d,e){
    e=function(f){return f.split('').reverse().join('')};b=e(parseInt(a,10).toString());
    for(c=0,d='';c<b.length;c++){
      d+=b[c];if((c+1)%3===0&&c!==(b.length-1)){d+='.';}
    }
    return'Rp.\t'+e(d)+',00'
  }
  

    $(function(){
      $('#btn-close').click(function(){
        close_popup();
      }); 
        $('#form-ss').submit(function(){
            var data = new FormData();
            $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#notice').show();
            data.append('id_mst_inv_barang', $('#v_kode_barang').val());
            data.append('tanggal_diterima', $('#dateInput').val());
            data.append('nama_barang', $('#v_nama_barang').val());
            data.append('jumlah', $('#jumlah').val());
            data.append('harga', $('#harga').val());
            data.append('id_permohonan_barang', "<?php echo $kode;?>");
            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."inventory/bhp_pengadaan/".$action."_barang/".$kode."/" ?>',
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

        $("#jqxinput").jqxInput(
          {
          placeHolder: " Ketik Nama Barang ",
          theme: 'classic',
          width: '100%',
          height: '30px',
          minLength: 2,
          source: function (query, response) {
            var dataAdapter = new $.jqx.dataAdapter
            (
              {
                datatype: "json",
                  datafields: [
                  { name: 'uraian', type: 'string'},
                  { name: 'id_mst_inv_barang_habispakai', type: 'string'},
                  { name: 'hargaterakhir', type: 'string'},
                  { name: 'harga', type: 'string'},
                ],
                url: '<?php echo base_url().'inventory/bhp_pengadaan/autocomplite_barang'; ?>'
              },
              {
                autoBind: true,
                formatData: function (data) {
                  data.query = query;
                  return data;
                },
                loadComplete: function (data) {
                  if (data.length > 0) {
                    response($.map(data, function (item) {
                      if (item.hargaterakhir==null) {
                        var hargabarang = item.harga;
                      }else{
                        var hargabarang = item.hargaterakhir;
                      }
                      return item.uraian+' | '+item.id_mst_inv_barang_habispakai+' | '+hargabarang;
                    }));
                  }
                }
              });
          }
        });
      
        $("#jqxinput").select(function(){
            var codebarang = $(this).val();
            var res = codebarang.split(" | ");
            $("#v_kode_barang").val(res[1]);
            $("#harga").val(res[2]);
        });
        $("#harga").change(function(){
            var jumlah = document.getElementById("jumlah").value;
            var harga = document.getElementById("harga").value;
            var subtotal =jumlah*harga;
            document.getElementById("subtotal").value = toRp(subtotal);
        });
        $("#jumlah").change(function(){
            var jumlah = document.getElementById("jumlah").value;
            var harga = document.getElementById("harga").value;
            var subtotal =jumlah*harga;
            document.getElementById("subtotal").value = toRp(subtotal);
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
            <div class="form-group">
              <label>Nama Barang</label>
              <input readonly="readonly" id="jqxinput" class="form-control" autocomplete="off" name="jqxinput" type="text" value="<?php 
                if(set_value('jqxinput')=="" && isset($uraian)){ 
                  echo $uraian;
                }else{
                  echo  set_value('jqxinput');
                }
                ?>"  <?php if(isset($disable)){if($disable='disable'){echo "readonly";}} ?>/>
              <input id="v_kode_barang" class="form-control" name="v_kode_barang" type="hidden" value="<?php 
                if(set_value('v_kode_barang')=="" && isset($id_mst_inv_barang_habispakai)){
                  echo $id_mst_inv_barang_habispakai;
                }else{
                  echo  set_value('v_kode_barang');
                }
                ?>" />
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input  type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php 
                if(set_value('jumlah')=="" && isset($jml)){
                  echo $jml;
                }else{
                  echo  set_value('jumlah');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Harga Satuan</label>
              <input type="number" class="form-control" name="harga" id="harga" placeholder="Harga Satuan" value="<?php 
                if(set_value('harga')=="" && isset($harga)){
                  echo $harga;
                }else{
                  echo  set_value('harga');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Sub Total</label>
              <input type="text" class="form-control" name="subtotal"  id="subtotal" placeholder="Sub Total" readonly="" value="<?php
              if(set_value('subtotal')=="" && isset($harga)){
                  echo $jml*$harga;
                }else{
                  echo  set_value('subtotal');
                }
                ?>">
            </div>
            <?php if(isset($disable)){if($disable='disable'){?>
            <div class="form-group">
              <label>Tanggal</label>
              <div id='dateInput' name="tanggal_diterima" value="<?php
              echo (!empty($tanggal_diterima)) ? date("Y-m-d",strtotime($tanggal_diterima)) :  date("d-m-Y");
            ?>"></div>
            </div>
            <?php }} ?>
           <!-- <div class="form-group">
              <label>Keterangan</label>
              <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"><?php 
               /*   if(set_value('keterangan')=="" && isset($keterangan_pengadaan)){
                    echo $keterangan_pengadaan;
                  }else{
                    echo  set_value('keterangan');
                  }*/
                  ?></textarea>
            </div>-->
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" id="btn-close" class="btn btn-warning">Batal</button>
        </div>
    </div>
</form>
</div>
