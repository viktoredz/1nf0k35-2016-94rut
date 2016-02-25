
<script type="text/javascript">
  $("#tgl_update").jqxDateTimeInput({ width: '300px', height: '25px' });
</script>
<script type="text/javascript">

  
  function toRp(a,b,c,d,e){
    e=function(f){return f.split('').reverse().join('')};b=e(parseInt(a,10).toString());
    for(c=0,d='';c<b.length;c++){
      d+=b[c];if((c+1)%3===0&&c!==(b.length-1)){d+='.';}
    }
    return'Rp.\t'+e(d)+',00'
  }
  
  function tambahmaster(){
    $("#popup_masterbarang #popup_mastercontent").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
    $.get("<?php echo base_url().'inventory/bhp_pengeluaran/add_barang_master/'; ?>" , function(data) {
      $("#popup_mastercontent").html(data);
    });
    $("#popup_masterbarang").jqxWindow({
      theme: theme, resizable: false,
      width: 500,
      height: 500,
      isModal: true, autoOpen: false, modalOpacity: 0.2
    });
    $("#popup_masterbarang").jqxWindow('open');
  }
    $(function(){
      $('#btn-close').click(function(){
        close_popup();
      }); 
        $('#form-ss').submit(function(){
            var data = new FormData();
            $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#notice').show();
            data.append('id_mst_inv_barang', $('#id_mst_inv_barang').val());
            data.append('jqxinput', $('#jqxinput').val());
            data.append('tgl_update', $('#tgl_update').val());
            data.append('jumlahawal', $('#jumlahawal').val());
            data.append('dikeluarkan', $('#dikeluarkan').val());
            data.append('jumlahakhir', $('#jumlahakhir').val());
            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."inventory/bhp_pengeluaran/".$action."_barang/".$kode."/" ?>',
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
                  { name: 'jmlbaik', type: 'string'},
                  { name: 'totaljumlah', type: 'string'},
                ],
                url: '<?php echo base_url().'inventory/bhp_pengeluaran/autocomplite_barang'; ?>'
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
                      if (item.totaljumlah==null) {
                        var jumlahbaik = item.jmlbaik;
                      }else{
                        var jumlahbaik = item.jmlbaik+item.totaljumlah;
                      }
                      return item.uraian+' | '+item.id_mst_inv_barang_habispakai+' | '+jumlahbaik;
                    }));
                  }
                }
              });
          }
        });
        var jumlahawal  = $("#jumlahawal__").val();
        $("#jumlahawal").val(jumlahawal-$("#dikeluarkan").val());
        $("#jqxinput").select(function(){
            var codebarang = $(this).val();
            var res = codebarang.split(" | ");
            $("#id_mst_inv_barang").val(res[1]);
            $("#jumlahawal").val(res[2]);
        });
        $("#dikeluarkan").change(function(){
            var jumlahawal  = $("#jumlahawal").val();
            var jumlahakhir = $("#jumlahakhir").val();
            var dikeluarkan = $("#dikeluarkan").val();
            if ($("#dikeluarkan").val()<0) {
              alert("data tidak boleh kurang dari nol");
              $("#dikeluarkan").val("");
              $("#jumlahakhir").val(jumlahawal-$("#dikeluarkan").val());  
            }
            if ($("#jumlahawal").val()<0) {
              alert("Jumlah Awal tidak boleh kurang dari kosong");
              $("#dikeluarkan").val("");
              $("#jumlahakhir").val(jumlahawal-$("#dikeluarkan").val());
            }
            
            $("#jumlahakhir").val(jumlahawal-$("#dikeluarkan").val());
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
          <div class="col-md-9">
            <div class="form-group">
              <label>Nama Barang</label>
              <input id="jqxinput" class="form-control" autocomplete="off" name="jqxinput" type="text" value="<?php 
                if(set_value('jqxinput')=="" && isset($nama_barang)){ 
                  echo $nama_barang;
                }else{
                  echo  set_value('jqxinput');
                }
                ?>" <?php if(isset($disable)){if($disable='disable'){echo "readonly";}} ?>/>
            </div>
          </div>
          <div class="col-md-3" style="padding-top:20px;">
            <button type="button" class="btn btn-success" id="btn-refresh" onclick="tambahmaster()"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah</button>
          </div>
          </div>
              <input id="id_mst_inv_barang" class="form-control" name="id_mst_inv_barang" type="text" value="<?php 
                if(set_value('id_mst_inv_barang')=="" && isset($id_mst_inv_barang_habispakai)){
                  echo $id_mst_inv_barang_habispakai;
                }else{
                  echo  set_value('id_mst_inv_barang');
                }
                ?>" />

            <div class="form-group">
              <label>Tanggal</label>
              <div id='tgl_update' name="tgl_update" value="<?php
              echo (!empty($tgl_update)) ? date("Y-m-d",strtotime($tgl_update)) :  date("d-m-Y");
            ?>"></div>
            </div>
            <div class="form-group">
              <label>Jumlah Awal</label>
              <input type="number" class="form-control" name="jumlahawal" id="jumlahawal" placeholder="Jumlah Awal" value="<?php 
                if(set_value('jumlahawal')=="" && isset($jumlahawal)){
                  echo $jumlahawal;
                }else{
                  echo  set_value('jumlahawal');
                }
                ?>" readonly="">
            </div>
            <div class="form-group">
              <label>Dikeluarkan</label>
              <input type="number" class="form-control" name="dikeluarkan"  id="dikeluarkan" placeholder="di Keluarkan"  value="<?php
              if(set_value('dikeluarkan')=="" && isset($dikeluarkan)){
                  echo $dikeluarkan;
                }else{
                  echo  set_value('dikeluarkan');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Jumlah Akhir</label>
              <input type="number" class="form-control" name="jumlahakhir"  id="jumlahakhir" placeholder="Jumlah Akhir" readonly="" value="<?php
              if(set_value('jumlahakhir')=="" && isset($jumlahakhir)){
                  echo $jumlahakhir;
                }else{
                  echo  set_value('jumlahakhir');
                }
                ?>">
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