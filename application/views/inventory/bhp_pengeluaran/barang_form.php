
<script type="text/javascript">
  $("#tgl_update").jqxDateTimeInput({ width: '200px', height: '25px' });
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
          if (($('#jumlahawal').val()==0) || ($('#jumlahawal').val() == null)||($('#dikeluarkan__').val()==0)) {
            alert("Maaf data awal atau data pengeluaran tidak boleh kosong");
          }else{
            var data = new FormData();
            $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#notice').show();
            data.append('id_mst_inv_barang', $('#id_mst_inv_barang').val());
            data.append('jqxinput', $('#jqxinput').val());
            data.append('tgl_update', $('#tgl_update').val());
            data.append('jumlahawal', $('#jumlahawal').val());
            data.append('rusakdipakai', $('#rusakdipakai').val());
            data.append('dikeluarkan__', $('#dikeluarkan__').val());
            data.append('jumlahakhir', $('#jumlahakhir').val());
            data.append('harga', $('#harga').val());
            //alert('keluar '+$('#dikeluarkan__').val()+'awal : '+$('#jumlahawal').val()+"akhir : "+$('#jumlahakhir').val());
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
                      $('#notice-content').html('<div class="alert">'+res[2]+'</div>');
                      $('#notice').show();
                      $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                      timeline_pengeluaran_barang(res[1]);
                       $("#jumlahawal").val("<?php echo $jml_awal=($totaljumlah+$jmlbaik) ?>");
                  }
                  else if(res[0]=="Error"){
                      $('#notice').hide();
                      $('#notice-content').html('<div class="alert">'+res[2]+'</div>');
                      $('#notice').show();
                      timeline_pengeluaran_barang(res[1]);
                  }
                  else{
                      $('#popup_content').html(response);
                      timeline_pengeluaran_barang($("#id_mst_inv_barang").val());
                  }
              }
            });
          }
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
                  { name: 'harga', type: 'string'},
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
        <?php if (isset($jmlpengeluaran)) { ?>
                  var dikeluarkan = "<?php echo $jmlpengeluaran;?>";
        <?php }else{ ?>
                  var dikeluarkan = 0;
        <?php }  ?>
        $("#jumlahakhir").val( $("#jumlahawal").val()-$("#dikeluarkan__").val());
        $("#jqxinput").select(function(){
            var codebarang = $(this).val();
            var res = codebarang.split(" | ");
            $("#id_mst_inv_barang").val(res[1]);
            $("#jumlahawal").val(res[2]);
        });
        $("#dikeluarkan__").change(function(){
            var jumlahawal  = $("#jumlahawal").val();
            var jumlahakhir = $("#jumlahakhir").val();
            if($("#dikeluarkan__").val()>$("#jumlahawal").val()){
              alert("Maaf data pengeluaran tidak boleh lebih dari data awal");
              $("#dikeluarkan__").val("");
            }
            else if ($("#dikeluarkan__").val()<0) {
              alert("data tidak boleh kurang dari nol");
              $("#dikeluarkan__").val("");
              $("#jumlahakhir").val(jumlahawal-$("#dikeluarkan__").val());  
            }else if ($("#jumlahakhir").val()<0) {
              alert("Jumlah Awal tidak boleh kurang dari kosong");
              $("#dikeluarkan__").val("");
              $("#jumlahakhir").val(jumlahawal-$("#dikeluarkan__").val());
            }else if (jumlahakhir<$('#rusakdipakai').val()+1) {
              alert("Maaf! data dikeluarkan tidak boleh kurang dari jumlah data rusak dan tidak dipakai, yaitu :"+$('#rusakdipakai').val());
              $("#dikeluarkan__").val("");
            }
            $("#jumlahakhir").val(jumlahawal-$("#dikeluarkan__").val());
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
                  <input id="jqxinput" class="form-control" autocomplete="off" name="jqxinput" type="text" value="<?php 
                    if(set_value('jqxinput')=="" && isset($uraian)){ 
                      echo $uraian;
                    }else{
                      echo  set_value('jqxinput');
                    }
                    ?>" readonly="readonly"/>
                </div>
                    <input id="id_mst_inv_barang" class="form-control" name="id_mst_inv_barang" type="hidden" value="<?php 
                      if(set_value('id_mst_inv_barang')=="" && isset($id_mst_inv_barang_habispakai)){
                        echo $id_mst_inv_barang_habispakai;
                      }else{
                        echo  set_value('id_mst_inv_barang');
                      }
                      ?>"  readonly="readonly"/>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Merek Barang</label>
                  <input id="merek_tipe" class="form-control" autocomplete="off" name="merek_tipe" type="text" value="<?php 
                    if(set_value('merek_tipe')=="" && isset($merek_tipe)){ 
                      echo $merek_tipe;
                    }else{
                      echo  set_value('merek_tipe');
                    }
                    ?>" readonly="readonly"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label>Jenis Barang</label>
                    <input type="text" class="form-control" name="jenisbarang"  id="jenisbarang" placeholder="Jenis Barang" readonly="" value="<?php
                    if(set_value('jenisbarang')=="" && isset($jenisbarang)){
                            echo $jenisbarang;
                      }else{
                        echo  set_value('jumlahakhir');
                      }
                      ?>">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Tanggal</label>
                    <div id='tgl_update' name="tgl_update" value="<?php
                    echo (!empty($tgl_update)) ? date("Y-m-d",strtotime($tgl_update)) :  date("d-m-Y");
                  ?>"></div>
                  </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label>Harga</label>
                    <?php //echo $tgl_pembelian.' opname :'.$tgl_opname?>
                    <input type="text" class="form-control" name="harga"  id="harga" placeholder="Harga" readonly="" value="<?php
                    if(set_value('harga')=="" && isset($hargaasli)){
                          if((isset($tgl_pembelian))||(isset($tgl_opname))){
                            if ($tgl_pembelian >= $tgl_opname) {
                              echo $harga_pembelian;
                            }else{
                              echo $harga_opname;
                            }
                          }else{
                            echo $hargaasli;
                          }
                      }else{
                        echo  set_value('jumlahakhir');
                      }
                      ?>">
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Jumlah Awal</label>
                    <input type="text" class="form-control" name="jumlahawal" id="jumlahawal" placeholder="Jumlah Awal" value="<?php 
                      if(set_value('jumlahawal')=="" && (isset($jmlbaik)||isset($totaljumlah))){
                        if(isset($tgl_update)){
                            if ($tgl_update==date("Y-m-d")) {
                                echo $jml_awal=($totaljumlah+$jmlbaik);//-($jml_rusak+$jml_tdkdipakai);
                              }  else{
                                echo $jml_awal=($totaljumlah+$jmlbaik)-$jmlpengeluaran;
                              }
                        }else{
                            echo $jml_awal=($totaljumlah+$jmlbaik);//-($jml_rusak+$jml_tdkdipakai);
                        }
                        
                      }else{
                        echo  set_value('jumlahawal');
                      }
                      ?>" readonly="">
                      <input type="hidden" class="form-control" name="rusakdipakai" id="rusakdipakai" placeholder="Jumlah Rusak Tidak dipakai" value="<?php 
                      if(set_value('rusakdipakai')=="" && isset($jml_rusak)){
                        echo $jmlrusak=($jml_rusak+$jml_tdkdipakai);//-($jml_rusak+$jml_tdkdipakai);
                      }else{
                        echo  set_value('rusakdipakai');
                      }
                      ?>" readonly="">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Dikeluarkan</label>
                    <input type="number" class="form-control" name="dikeluarkan__"  id="dikeluarkan__" placeholder="di Keluarkan"  value="<?php
                    if(set_value('dikeluarkan__')=="" && isset($jmlpengeluaran)){
                        if (isset($jmlpengeluaran)) {
                          if ($tgl_update==date('Y-m-d')) {
                            echo $jmlpengeluaran;
                          }else{
                            echo '';
                          }
                        }else{
                          echo  '';
                        } 
                        
                      }else{
                        echo  set_value('dikeluarkan__');
                      }
                      ?>">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group">
                    <label>Jumlah Akhir</label>
                    <input type="text" class="form-control" name="jumlahakhir"  id="jumlahakhir" placeholder="Jumlah Akhir" readonly="" value="<?php
                    if(set_value('jumlahakhir')=="" && isset($jmlpengeluaran)){
                        echo $jml_awal=($totaljumlah+$jmlbaik)-(/*$jml_rusak+$jml_tdkdipakai+*/$jmlpengeluaran);;
                      }else{
                        echo  set_value('jumlahakhir');
                      }
                      ?>">
                  </div>
              </div>
            </div>
        </div>
        <div class="box-footer" style="float:right;">
            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
            <button type="button" id="btn-close" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i>Tutup</button>
        </div>
        <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="timeline-messages" id="timeline-barang"></div>
              </div>
            </div>
        </div>
    </div>
</form>
</div>
<div id="popup_masterbarang" style="display:none">
  <div id="popup_mastertitle">Data master Barang</div>
  <div id="popup_mastercontent">&nbsp;</div>
</div>