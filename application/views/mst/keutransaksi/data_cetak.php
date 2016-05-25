<form action="#" method="POST" name="frmPegawai">
  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
             
            <div class="row" id="linkimages_alert" style="display: none">
              <div class="col-sm-12 col-md-6" id="msg_alert"></div>
            </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nama Puskesmas
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="kategori_trans_nama" placeholder="Nama Puskesmas" value="<?php 
                  if(set_value('nama')=="" && isset($nama)){
                    echo $nama;
                  }else{
                    echo  set_value('nama');
                  }
                  ?>">
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nama Dinas
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="kategori_trans_deskripsi" placeholder="Nama Dinas" value="<?php 
                  if(set_value('deskripsi')=="" && isset($deskripsi)){
                    echo $deskripsi;
                  }else{
                    echo  set_value('deskripsi');
                  }
                  ?>">
                </div>
              </div>

             <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">Alamat</div>
                <div class="col-md-8">
                <textarea class="form-control" name="syarat_deskripsi" placeholder="Alamat Puskesmas"><?php 
                    if(set_value('deskripsi')=="" && isset($deskripsi)){
                      echo $deskripsi;
                    }else{
                      echo  set_value('deskripsi');
                    }
                    ?></textarea>
                </div>  
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Kota
                </div>
                <div class="col-md-8">
                  <select  name="anak_id_mst_peg_keluarga" type="text" class="form-control">
                      <?php foreach($kode_kel as $kel) : ?>
                        <?php
                        if(set_value('id_mst_peg_keluarga')=="" && isset($id_mst_peg_keluarga)){
                          $id_mst_peg_keluarga = $id_mst_peg_keluarga;
                        }else{
                          $id_mst_peg_keluarga = set_value('id_mst_peg_keluarga');
                        }
                        $select = $kel->id_keluarga == $id_mst_peg_keluarga ? 'selected' : '' ;
                        ?>
                        <option value="<?php echo $kel->id_keluarga ?>" <?php echo $select ?>><?php echo $kel->nama_keluarga ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Logo

                </div>
                <div class="col-md-8">
                  <button type="button" id='linkimages' class="btn btn-success"><i class='fa fa-plus-square'></i> &nbsp; Upload</button>
                </div>
                
                <div class="col-sm-12 col-md-2 pull-right" style="text-align:  center">
                  <img src="<?php echo base_url()?>mst/keuangan_transaksi/getphoto/{id}" id='linkimages' style='border:1px solid #ECECEC' height='100'>
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Kepala Puskesmas
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="kategori_trans_nama" placeholder="Nama Kepala Puskesmas" value="<?php 
                  if(set_value('nama')=="" && isset($nama)){
                    echo $nama;
                  }else{
                    echo  set_value('nama');
                  }
                  ?>">
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  NIP Kepala Puskesmas
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="kategori_trans_nama" placeholder="NIP Kepala Puskesmas" value="<?php 
                  if(set_value('nama')=="" && isset($nama)){
                    echo $nama;
                  }else{
                    echo  set_value('nama');
                  }
                  ?>">
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Pengelola Keuangan BOK
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="kategori_trans_nama" placeholder="Pengelola Keuangan BOK" value="<?php 
                  if(set_value('nama')=="" && isset($nama)){
                    echo $nama;
                  }else{
                    echo  set_value('nama');
                  }
                  ?>">
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  NIP Pengelola Keuangan BOK
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="kategori_trans_nama" placeholder="NIP Pengelola Keuangan BOK" value="<?php 
                  if(set_value('nama')=="" && isset($nama)){
                    echo $nama;
                  }else{
                    echo  set_value('nama');
                  }
                  ?>">
                </div>
              </div>

              <br>
            </div>
          </div>
  </div>
</form>

<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/ajaxupload.3.5.js"></script>
<script>
  $(function () { 
    tabIndex = 1;
   
    $("[name='btn_kategori_transaksi_close']").click(function(){
        $("#popup_kategori_transaksi").jqxWindow('close');
    });

    $("[name='btn_kategori_transaksi_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('nama',          $("[name='kategori_trans_nama']").val());
        data.append('deskripsi',     $("[name='kategori_trans_deskripsi']").val());
              
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/kategori_transaksi_{action}/{id}"   ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#popup_kategori_transaksi").jqxWindow('close');
                alert("Data berhasil disimpan.");
                $("#jqxgrid_kategori_transaksi").jqxGrid('updatebounddata', 'filter');
              }else{
                $('#popup_kategori_transaksi_content').html(response);
              }
            }
        });

        return false;
    });

        var divalert = '<div class="alert alert-warning alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><div>';

        new AjaxUpload($('#linkimages'), {
          action: '<?php echo base_url()?>mst/keuangan_transaksi/douploadphoto/{id}',
          name: 'uploadfile',
          onSubmit: function(file, ext){
            $('#linkimages_alert').show('fold');
             if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
              $('#msg_alert').html(divalert +'Only JPG, PNG or GIF files are allowed</div></div>');
              return false;
            }
            $('#msg_alert').html(divalert +'Uploading image...</div></div>');
          },
          onComplete: function(file, response){
            stat = response.substr(0,7)
            filename = response.substr(10)
            if(stat==="success"){
              $('#linkimages').attr("src", "<?php echo base_url()?>media/images/photos/{id}/"+filename);
              $('#msg_alert').html(divalert + 'Upload Image OK</div></div>');
            } else{
              $('#msg_alert').html(divalert + response + '</div></div>');
            }
          }
        }); 

  });
</script>
