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
            data.append('id_mst_inv_barang_habispakai_jenis', $('#id_jenis').val());
            data.append('code', $('#code').val());
            data.append('uraian', $('#uraian').val());
            data.append('merek_tipe', $('#merk').val());
            data.append('negara_asal', $('#negara').val());
            data.append('pilihan_satuan', $('#pilihan_satuan_barang').val());
            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."mst/invbaranghabispakai/".$action."_barang/".$kode."/" ?>',
                data : data,
                success : function(response){
                  var res  = response.split("|");
                  if(res[0]=="OK"){
                      $('#notice').hide();
                      $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                      $('#notice').show();
                      $("#jqxgrid_barang").jqxGrid('updatebounddata', 'cells');
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
              <input id="id_jenis" class="form-control" name="id_jenis" type="hidden" value="<?php 
               echo  $kode; ?>"/>
            <div class="form-group">
              <label>Kode</label>
              <input type="text" class="autocomplete form-control" id="code" name="code"  placeholder="Kode" value="<?php
              if(set_value('code')=="" && isset($code)){
                  echo $code;
                }else{
                  echo  set_value('code');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Uraian</label>
              <input type="text" class="form-control" name="uraian" id="uraian" placeholder="Uraian" value="<?php 
                if(set_value('uraian')=="" && isset($uraian)){
                  echo $uraian;
                }else{
                  echo  set_value('uraian');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Merek Tipe</label>
              <input type="text" class="form-control" name="merk" id="merk" placeholder="Merek Tipe" value="<?php 
                if(set_value('merk')=="" && isset($merk)){
                  echo $merk;
                }else{
                  echo  set_value('merk');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Negara Asal</label>
              <input type="text" class="form-control" name="negara"  id="negara" placeholder="Negara Asal" value="<?php
              if(set_value('negara')=="" && isset($negara)){
                  echo $negara;
                }else{
                  echo  set_value('negara');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Satuan</label>
              <select id="pilihan_satuan_barang" name="pilihan_satuan_barang" class="form-control" >
                <?php foreach($pilihan_satuan_barang as $barang) : ?>
                  <?php $select = $barang->code == $pilihan_satuan_barang ? 'selected' : '' ?>
                  <option value="<?php echo $barang->code ?>" <?php echo $select ?>><?php echo $barang->value ?></option>
                <?php endforeach ?>
              </select>
            </div>            
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" id="btn-close" class="btn btn-warning">Batal</button>
        </div>
    </div>
</form>
</div>
