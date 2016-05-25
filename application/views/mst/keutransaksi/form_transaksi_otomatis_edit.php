<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>kepegawaian/drh/dodel_multi" method="POST" name="">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
      </div>

        <div class="box-footer">
          <button type="button" id="btn-kembali" class="btn btn-primary pull-right"><i class='fa  fa-arrow-circle-o-left'></i> &nbsp;Kembali</button>
          <button type="button" disabled="" name="btn_kategori_transaksi_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
          <button type="button" name="btn-reset" value="Reset" onclick='clearForm(this.form)' class="btn btn-success" ><i class='fa fa-refresh'></i> &nbsp; Reset</button>
       </div>
        <div class="box-body">

 <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">
            Nama Transaksi
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="transaksi_otomatis_nama" placeholder="Pembayaran Biaya Jasa Pelayanan" value="<?php 
              if(set_value('nama')=="" && isset($nama)){
                echo $nama;
              }else{
                echo  set_value('nama');
              }
              ?>">
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Deskripsi</div>
          <div class="col-md-8">
          <textarea class="form-control" name="transaksi_otomatis_deskripsi" placeholder="Deskripsi Dari Kategori"><?php 
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
            Untuk Jurnal
          </div>
          <div class="col-md-8">
              <select name="transaksi_otomatis_jurnal" type="text" class="form-control">
              <?php 
                if(set_value('transaksi_otomatis_jurnal')=="" && isset($untuk_jurnal)){
                  $transaksi_otomatis_jurnal = $untuk_jurnal;
                }else{
                  $transaksi_otomatis_jurnal = set_value('transaksi_otomatis_jurnal');
                }
              ?>
              <option value="Semua" <?php if($transaksi_otomatis_jurnal=="semua") echo "selected" ?>>Semua</option>
              <option value="Jurnal Umum" <?php if($transaksi_otomatis_jurnal=="jurnal_umum") echo "selected" ?>>Jurnal Umum</option>
              <option value="Jurnal Penyesuaian" <?php if($transaksi_otomatis_jurnal=="jurnal_penyesuaian") echo "selected" ?>>Jurnal Penyesuaian</option>
              <option value="Jurnal Penutup" <?php if($transaksi_otomatis_jurnal=="jurnal_penutup") echo "selected" ?>>Jurnal Penutup</option>
              </select>
          </div>
      </div>

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
          Kategori
        </div>
        <div class="col-md-8">
          <select  name="transaksi_otomatis_kategori" type="text" class="form-control">
            <?php foreach($kategori as $k) : ?>
                <?php
                  if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                    $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                  }else{
                    $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                  }
                  $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                ?>
                <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div> 
      <br><br>
      <div class="col-md-12">
        <div class="pull-right"><label>Jurnal Transaksi</label> <a href="#" class="glyphicon glyphicon-plus"></a></div>
      </div>  

    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Jurnal Pasangan</h3>
          <div class="pull-right"><a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a></div>
        </div>
          <div class="box-body">

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-8" style="padding-top:5px;"><label> Debit </label> </div>
              <div class="col-md-2">
                <a href="#" class="glyphicon glyphicon-plus"></a>
              </div> 
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-8" style="padding-top:5px;"><label> Kredit </label> </div>
              <div class="col-md-2">
                <a href="#" class="glyphicon glyphicon-plus"></a>
              </div> 
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-8" style="padding-top:5px;">
                <select  name="transaksi_kategori" type="text" class="form-control">
                  <?php foreach($kategori as $k) : ?>
                    <?php
                      if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                        $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                      }else{
                        $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                      }
                      $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-2">
                <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
              </div> 

            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-8" style="padding-top:5px;">
                <select  name="transaksi_kategori" type="text" class="form-control">
                  <?php foreach($kategori as $k) : ?>
                    <?php
                      if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                        $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                      }else{
                        $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                      }
                      $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-2">
                <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
              </div> 
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-3" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
              <div class="col-md-2">
                <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                  if(set_value('status')=="" && isset($status)){
                  $status = $status;
                    }else{
                  $status = set_value('status');
                    }
                  if($status == 1) echo "checked";
                ?>>
              </div> 
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-8" style="padding-top:5px;">
                <select  name="transaksi_kategori" type="text" class="form-control">
                  <?php foreach($kategori as $k) : ?>
                    <?php
                      if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                        $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                      }else{
                        $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                      }
                      $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-2">
                <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
              </div> 
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
              <div class="col-md-2">
                <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                  if(set_value('status')=="" && isset($status)){
                  $status = $status;
                    }else{
                  $status = set_value('status');
                    }
                  if($status == 1) echo "checked";
                ?>>
              </div> 
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-2" style="padding-top:15px;"><label>Nama</label></div>
              <div class="col-md-6" style="padding-top:5px;">
                <select  name="transaksi_kategori" type="text" class="form-control">
                  <?php foreach($kategori as $k) : ?>
                    <?php
                      if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                        $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                      }else{
                        $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                      }
                      $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                    ?>
                    <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="col-md-2">
                <input type="text" class="form-control" name="transaksi_nama" value="">  
              </div> 
              <div class="col-md-2"><label>%</label></div>

            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-3" style="padding-top:5px;"><label> Nilai </label> </div>
              <div class="col-md-5">
                <select  name="transaksi_kategori" type="text" class="form-control">
                  <?php foreach($kategori as $k) : ?>
                      <?php
                        if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                          $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                        }else{
                          $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                        }
                        $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                      ?>
                      <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                  <?php endforeach ?>
                </select>
              </div> 
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-3" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
              <div class="col-md-2">
                <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                  if(set_value('status')=="" && isset($status)){
                  $status = $status;
                    }else{
                  $status = set_value('status');
                    }
                  if($status == 1) echo "checked";
                ?>>
              </div> 
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
              <div class="col-md-2">
                <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                  if(set_value('status')=="" && isset($status)){
                  $status = $status;
                    }else{
                  $status = set_value('status');
                    }
                  if($status == 1) echo "checked";
                ?>>
              </div> 
            </div>
          </div>

        </div>
      </div>
    </div>

        <label>Pengaturan Transaksi</label>


          <div class="row" style="margin: 5px">
            <div class="col-md-12">
              <?php $i=1; foreach($template as $t) : ?>
                  <input type="checkbox" name="transaksi_otomatis_template" id="template<?php echo $i;?>" value="<?php echo $i;?>">
              <?php 
                if(set_value('nilai')=="" && isset($t->nilai)){
                  $t->nilai= $t->nilai;
                }else{
                  $t->nilai= set_value('nilai');
                }
                if($t->nilai == 1) echo "checked";
              ?>
                <?php echo $t->setting_judul ?>
                  </br>
                <?php echo $t->seting_deskripsi ?>
                  </br></br>
              <?php $i++; endforeach ?> 
            </div>
          </div>

      </div>
    </div>
  </div>
</form>
</section>

<script type="text/javascript">

    $("#btn-kembali").click(function(){
      $.get('<?php echo base_url()?>mst/keuangan_transaksi/transaksi_otomatis_kembali', function (data) {
        $('#content3').html(data);
      });
    });

    $("[name='transaksi_otomatis_template']").click(function(){
      var data = new FormData();
      // alert($("[name='transaksi_otomatis_template']:checked").val());

        data.append('template',     $("[name='transaksi_otomatis_template']:checked").val());
        data.append('kategori',     "<?php echo $id;?>");
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_otomatis_template_update/"?>'+$(this).val(),
            data : data,
            success : function(response){
              // a = response.split("|");
              if(response=="OK"){
              // if (a[1]=='1') {
                    $("#transaksi_otomatis_template").prop("checked", true);
                }else{
                    $("#transaksi_otomatis_template").prop("checked", false);
                // };
              // }else{
                // alert("Mendukung transaksi belum berhasil di aktifkan.");

              }
              //ceklist();
            }
        });
        return false;
    });

  function clearForm(form_transaksi_otomatis) {
   
    var elements = form_transaksi_otomatis.elements;
    form_transaksi_otomatis.reset();

    for(i=0; i<elements.length; i++) {
     
      field_type = elements[i].type.toLowerCase();
 
      switch(field_type) {
     
        case "text":
        case "password":
        case "textarea":
        case "hidden":  
         
          elements[i].value = "";
          break;
           
        case "radio":
        case "checkbox":
          if (elements[i].checked) {
                elements[i].checked = false;
          }
          break;

        case "select-one":
        case "select-multi":
                    elements[i].selectedIndex = -1;
          break;

        default:
          break;
      }
    }
}

</script>

