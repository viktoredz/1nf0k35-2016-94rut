<?php if(validation_errors()!=""){ ?>
<div class="alert alert-warning alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>
<section class="content">
  <div class="row">
    <form action="<?php echo base_url()?>mst/keuangan_transaksi/transaksi_{action}/{id}" method="post" name="editform">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div>
        <div class="box-footer">
          <button type="button" id="btn-kembali" class="btn btn-primary pull-right"><i class='fa  fa-arrow-circle-o-left'></i> &nbsp;Kembali</button>
          <button type="button" name="btn_transaksi_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
          <button type="button" name="btn-reset" value="Reset" onclick='clearForm(this.form)' class="btn btn-success" ><i class='fa fa-refresh'></i> &nbsp; Reset</button>
        </div>
        <div class="box-body">

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">Nama Transaksi</div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="transaksi_nama" placeholder="Pembayaran Biaya Jasa Pelayanan" value="<?php 
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
            <textarea class="form-control" name="transaksi_deskripsi" placeholder="Deskripsi Dari Kategori"><?php 
              if(set_value('deskripsi')=="" && isset($deskripsi)){
              echo $deskripsi;
              }else{
              echo  set_value('deskripsi');
              }
              ?>
            </textarea>
         </div>  
      </div>

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">Untuk Jurnal</div>
        <div class="col-md-8">
          <select name="transaksi_jurnal" type="text" class="form-control">
          <?php 
            if(set_value('transaksi_jurnal')=="" && isset($untuk_jurnal)){
              $transaksi_jurnal = $untuk_jurnal;
            }else{
              $transaksi_jurnal = set_value('transaksi_jurnal');
            }
          ?>
            <option value="semua" <?php if($transaksi_jurnal=="semua") echo "selected" ?>>Semua</option>
            <option value="jurnal_umum" <?php if($transaksi_jurnal=="jurnal_umum") echo "selected" ?>>Jurnal Umum</option>
            <option value="jurnal_penyesuaian" <?php if($transaksi_jurnal=="jurnal_penyesuaian") echo "selected" ?>>Jurnal Penyesuaian</option>
            <option value="jurnal_penutup" <?php if($transaksi_jurnal=="jurnal_penutup") echo "selected" ?>>Jurnal Penutup</option>
          </select>
        </div>
      </div>

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">Kategori</div>
        <div class="col-md-8">
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
      
      <br><br>
      <div class="col-md-12">
        <div class="pull-right"><label>Jurnal Transaksi</label> <a class="glyphicon glyphicon-plus"name="jurnal_transaksi"></a></div>
      </div>  


      <div id="jurnal_transaksi" class="col-md-12">
        <div id="jt">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Jurnal Pasangan</h3>
              <div class="pull-right"><a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a></div>
            </div>
            <div class="box-body">
              <div class="row">
                <div id="Debit" class="col-sm-6">
                  <div class="row">
                    <div class="col-md-7" style="padding-top:5px;"><label> Debit </label> </div>
                    <div class="col-md-1">
                      <a class="glyphicon glyphicon-plus" name="add_debit"></a>
                    </div> 
                  </div>

                <?php foreach($debit as $row) : ?>
                  <div id="debt <?php echo $row->id_mst_transaksi_item ?>">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-8" style="padding-top:5px;">
                           <select  name="debit_akun" id="debit_akun" type="text" class="form-control">
                              <?php foreach($akun as $a) : ?>
                                <?php
                                  if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                    $id_mst_akun = $id_mst_akun;
                                  }else{
                                    $id_mst_akun = set_value('id_mst_akun');
                                  }
                                    $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                ?>
                                <option value="<?php echo $a->id_mst_akun ?>" <?php echo $select ?>><?php echo $a->uraian ?></option>
                                <?php endforeach ?>
                            </select>
                            <p id="demo"></p>
                          </div>
                          <div class="col-md-1">
                            <div class="parentDiv">
                              <a data-toggle="collapse" data-target="#debit" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                            </div>
                          </div>
<!--                           <div class="col-md-2">
                            <a href="#" class="glyphicon glyphicon-trash"></a>
                          </div>  -->
                      </div>
                    </div>
                  </div>

                  <div class="collapse" id="debit">

                    <div class="row">
                      <div class="col-md-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" name="debit_isi_otomatis" value="1" <?php 
                              if(set_value('status')=="" && isset($status)){
                                $status = $status;
                              }else{
                                $status = set_value('status');
                              }
                              if($status == 1) echo "checked";
                            ?>>
                          </div> 
                          <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                    <div class="col-sm-1"></div>
                      <div class="col-sm-10">
                        <div class="row">
                          <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>
                          <div class="col-md-7">
                            <select  name="debit_cmbx_nilai" type="text" class="form-control">
                              <?php foreach($kategori as $k) : ?>
                                  <?php
                                    if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                      $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                    }else{
                                      $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                    }
                                    $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                  ?>
                                  <option value="Dari Nilai Kredit" echo "selected" ?> Dari Nilai Kredit</option>
                                  <!-- <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option> -->
                              <!-- <?php endforeach ?> -->
                            </select>
                          </div> 
                           <p id="d_value_nilai"></p>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" name="debit_opsional" value="1" <?php 
                              if(set_value('status')=="" && isset($status)){
                              $status = $status;
                                }else{
                              $status = set_value('status');
                                }
                              if($status == 1) echo "checked";
                            ?>>
                          </div> 
                          <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>

              <div id="Kredit" class="col-sm-6">
                <div class="row">
                  <div class="col-md-8" style="padding-top:5px;"><label>Kredit</label></div>
                  <div class="col-md-2">
                    <a class="glyphicon glyphicon-plus" name="add_kredit"></a>
                  </div> 
                </div>

              <?php foreach($kredit as $row) : ?>
                <div id="kredit <?php echo $row->id_mst_transaksi_item ?>">
                  <div class="row" >
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-1" style="padding-top:5px;"><label><?php echo $row->urutan ?></label> </div>
                        <div class="col-md-8" style="padding-top:5px;">
                          <select  name="kredit_akun" type="text" class="form-control">
                            <?php foreach($akun as $a) : ?>
                              <?php
                                if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                  $id_mst_akun = $id_mst_akun;
                                }else{
                                  $id_mst_akun = set_value('id_mst_akun');
                                }
                                  $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                              ?>
                              <option value="<?php echo $a->id_mst_akun ?>" <?php echo $select ?>><?php echo $a->uraian ?></option>
                              <?php endforeach ?>
                          </select>
                        </div>
                        <div class="col-md-1">
                          <div class="parentDiv">
                            <a data-toggle="collapse" data-target="#kredit <?php echo $row->id_mst_transaksi_item ?>" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                          </div>
                        </div>
<!--                    <div class="col-md-2">
                          <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
                        </div>  -->
                      </div>
                    </div>
                  </div>

                  <div class="collapse" id="kredit <?php echo $row->id_mst_transaksi_item ?>">

                    <div class="row">
                      <div class="col-sm-1"></div>
                      <div class="col-sm-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" name="kredit_isi_otomatis" value="1" <?php 
                              if(set_value('status')=="" && isset($status)){
                                $status = $status;
                              }else{
                                $status = set_value('status');
                              }
                              if($status == 1) echo "checked";
                            ?>>
                          </div> 
                          <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-1"></div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-10">
                        <div class="row">
                          <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>
                          <div class="col-md-7">
                            <select  name="kredit_cmbx_nilai" type="text" class="form-control">
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
                              <input type="text" class="form-control" name="kredit_value_nilai" value="<?php 
                              if(set_value('value')=="" && isset($value)){
                                echo $value;
                              }else{
                                echo  set_value('value');
                              }
                              ?>">
                          </div>
                          <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-1"></div>
                      <div class="col-sm-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" name="kredit_opsional" value="1" <?php 
                              if(set_value('status')=="" && isset($status)){
                              $status = $status;
                                }else{
                              $status = set_value('status');
                                }
                              if($status == 1) echo "checked";
                            ?>>
                          </div> 
                          <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- </div> -->
              </div>
              <?php endforeach ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <label>Pengaturan Transaksi</label>

        <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <?php
             $i=1; foreach($template as $t) : ?>
              <input type="checkbox" name="transaksi_template" id="template<?php echo $t->id_mst_setting_transaksi_template;?>" value="<?php echo $t->id_mst_setting_transaksi_template;?>"
            <?php 
            if(!empty($t->id_mst_transaksi)){ echo "checked";}
            ?>> 
              <?php echo $t->setting_judul ?>
              </br>
              <?php echo $t->seting_deskripsi ?>
              </br></br>
            <?php $i++; endforeach ?> 
          </div>
        </div>
       </div>
      </div>
     </form>
    </div>
</section>
<script type="text/javascript">
    $("#btn-kembali").click(function(){
      $.get('<?php echo base_url()?>mst/keuangan_transaksi/transaksi_kembali', function (data) {
        $('#content2').html(data);
      });
    });

  $("select[name='debit_akun']").change(function(){
      var id_mst_akun_debit = $(this).val();
      alert(id_mst_akun_debit);

      var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

      data.append('id_mst_akun', id_mst_akun_debit);
      
      $.ajax({
         type: 'POST',
         url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit/{id}" ?>',
         data : 'id_mst_akun='+id_mst_akun_debit,
         success: function (response) {
          if(response=="OK"){
              alert("Success.");
          }else{
              alert("Failed.");
          }
         }
      });
  });

  $("[name='debit_value_nilai']").change(function(){
    
    var x = document.getElementById("debit_value_nilai").value;
    document.getElementById("d_value_nilai").innerHTML = "Text: " + x;
  
  });

      counter_debit = 2; 
      $("[name='add_debit']").click(function() {
         var data = new FormData();
            $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#biodata_notice').show();

        data.append('value',          $("[name='debit_value']").val());
        data.append('urutan',         counter_debit);

        $.ajax({
           cache : false,
           contentType : false,
           processData : false,
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_debit/{id}" ?>',
           data : data,
           success: function (response) {
            if(response=="OK"){

          var form_debit = '<div id="debt">\
                              <div class="row">\
                                <div class="col-md-12">\
                                  <div class="row">\
                                    <div class="col-md-8" style="padding-top:5px;">\
                                     <select  name="debit_akun" id="debit_akun" class="form-control"\ type="text">\
                                        <?php foreach($akun as $a) : ?>\
                                          <?php
                                            if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                              $id_mst_akun = $id_mst_akun;
                                            }else{
                                              $id_mst_akun = set_value('id_mst_akun');
                                            }
                                              $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                          ?>\
                                          <option value="<?php echo $a->id_mst_akun ?>"\
                                          <?php echo $select ?>><?php echo $a->uraian ?>\
                                          </option>\
                                          <?php endforeach ?>\
                                      </select>\
                                      <p id="demo">\
                                      </p>\
                                    </div>\
                                    <div class="col-md-1">\
                                      <div class="parentDiv">\
                                        <a data-toggle="collapse" data-target="#debit'+counter_debit+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                        </a>\
                                      </div>\
                                    </div>\
                                    <div class="col-md-2">\
                                      <a href="#" class="glyphicon glyphicon-trash">\
                                      </a>\
                                    </div>\
                              </div>\
                            </div>\
                          </div>\
                          <div class="collapse" id="debit'+counter_debit+'">\
                            <div class="row">\
                              <div class="col-md-7">\
                                <div class="row">\
                                  <div class="col-md-1">\
                                   <input type="checkbox" name="debit_isi_otomatis" value="1" <?php 
                                      if(set_value('status')=="" && isset($status)){
                                        $status = $status;
                                      }else{
                                        $status = set_value('status');
                                      }
                                      if($status == 1) echo "checked";
                                    ?>>\
                                  </div>\
                                  <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label></div>\
                                </div>\
                              </div>\
                            </div>\
                            <div class="row">\
                            <div class="col-sm-1"></div>\
                              <div class="col-sm-10">\
                                <div class="row">\
                                  <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>\
                                  <div class="col-md-7">\
                                    <select  name="debit_cmbx_nilai" type="text" class="form-control">\
                                      <?php foreach($kategori as $k) : ?>\
                                          <?php
                                            if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                              $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                            }else{
                                              $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                            }
                                            $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                          ?>\
                                          <option value="<?php echo $k->id_mst_kategori_transaksi ?>"\
                                           <?php echo $select ?>><?php echo $k->nama ?>\
                                          </option>\
                                      <?php endforeach ?>\
                                    </select>\
                                  </div>\
                                   <p id="d_value_nilai"></p>\
                                </div>\
                              </div>\
                            </div>\
                              <div class="row">\
                                <div class="col-md-7">\
                                  <div class="row">\
                                    <div class="col-md-1">\
                                      <input type="checkbox" name="debit_opsional" value="1" <?php 
                                        if(set_value('status')=="" && isset($status)){
                                        $status = $status;
                                          }else{
                                        $status = set_value('status');
                                          }
                                        if($status == 1) echo "checked";
                                      ?>>\
                                    </div>\
                                    <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label></div>\
                                  </div>\
                                </div>\
                              </div>\
                            </div>';

                $('#Debit').append(form_debit);
                counter_debit++;
            }else{
                alert("Failed.");
            }
           }
        });
      });
     
      counter_kredit = 2; 
      $("[name='add_kredit']").click(function() {
         var data = new FormData();

            $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#biodata_notice').show();

        data.append('value',            $("[name='debit_value']").val());
        data.append('urutan',           counter_kredit);

        $.ajax({
           cache : false,
           contentType : false,
           processData : false,
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_kredit/{id}" ?>',
           data : data,
           success: function (response) {
            if(response=="OK"){

              var form_kredit = '<div id="kredit">\
                                    <div class="row" >\
                                      <div class="col-md-12">\
                                        <div class="row">\
                                          <div class="col-md-1" style="padding-top:5px;"><label>'+(counter_kredit)+'</label> </div>\
                                          <div class="col-md-8" style="padding-top:5px;">\
                                            <select  name="kredit_akun" type="text" class="form-control">\
                                              <?php foreach($akun as $a) : ?>\
                                                <?php
                                                  if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                    $id_mst_akun = $id_mst_akun;
                                                  }else{
                                                    $id_mst_akun = set_value('id_mst_akun');
                                                  }
                                                    $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                ?>\
                                                <option value="<?php echo $a->id_mst_akun ?>"\
                                                 <?php echo $select ?>><?php echo $a->uraian ?>\
                                                 </option>\
                                                <?php endforeach ?>\
                                            </select>\
                                          </div>\
                                          <div class="col-md-1">\
                                            <div class="parentDiv">\
                                              <a data-toggle="collapse" data-target="#kredit'+counter_kredit+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                              </a>\
                                            </div>\
                                          </div>\
                                          <div class="col-md-2">\
                                            <a class="glyphicon glyphicon-trash">\
                                            </a>\
                                          </div>\
                                        </div>\
                                      </div>\
                                    </div>\
                                    <div class="collapse" id="kredit'+counter_kredit+'">\
                                      <div class="row">\
                                        <div class="col-sm-1">\
                                        </div>\
                                        <div class="col-sm-7">\
                                          <div class="row">\
                                            <div class="col-md-1">\
                                              <input type="checkbox" name="kredit_isi_otomatis" value="1" <?php 
                                                if(set_value('status')=="" && isset($status)){
                                                  $status = $status;
                                                }else{
                                                  $status = set_value('status');
                                                }
                                                if($status == 1) echo "checked";
                                              ?>>\
                                            </div>\
                                            <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>\
                                          </div>\
                                        </div>\
                                      </div>\
                                      <div class="row">\
                                        <div class="col-sm-1">\
                                        </div>\
                                        <div class="col-sm-1">\
                                        </div>\
                                        <div class="col-sm-10">\
                                          <div class="row">\
                                            <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>\
                                            <div class="col-md-7">\
                                              <select  name="kredit_cmbx_nilai" type="text" class="form-control">\
                                                <?php foreach($kategori as $k) : ?>\
                                                    <?php
                                                      if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                        $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                      }else{
                                                        $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                      }
                                                      $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                    ?>\
                                                    <option value="<?php echo $k->id_mst_kategori_transaksi ?>"\
                                                     <?php echo $select ?>><?php echo $k->nama ?>\
                                                    </option>\
                                                <?php endforeach ?>\
                                              </select>\
                                            </div>\
                                            <div class="col-md-2">\
                                                <input type="text" class="form-control" name="kredit_value_nilai" value="<?php 
                                                if(set_value('value')=="" && isset($value)){
                                                  echo $value;
                                                }else{
                                                  echo  set_value('value');
                                                }
                                                ?>">\
                                            </div>\
                                            <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>\
                                          </div>\
                                        </div>\
                                      </div>\
                                      <div class="row">\
                                        <div class="col-sm-1">\
                                        </div>\
                                        <div class="col-sm-7">\
                                          <div class="row">\
                                            <div class="col-md-1">\
                                              <input type="checkbox" name="kredit_opsional" value="1" <?php 
                                                if(set_value('status')=="" && isset($status)){
                                                $status = $status;
                                                  }else{
                                                $status = set_value('status');
                                                  }
                                                if($status == 1) echo "checked";
                                              ?>>\
                                            </div>\
                                            <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
                                          </div>\
                                        </div>\
                                      </div>\
                                    </div>\
                                </div>';


              $('#Kredit').append(form_kredit);
               counter_kredit++;
            }else{
                alert("Failed.");
            }
           }
        });
      });

    counter_jurnal =2;
    $("[name='jurnal_transaksi']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('value',          $("[name='debit_value']").val());
        data.append('type',           $("[name='debit_value']").val());
        data.append('group',          counter_jurnal);
              
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add/{id}" ?>',
            data : data,
            success : function(response){
              if(response=="OK"){

              var form_jurnal_transaksi ='<div id="jt">\
                                            <div class="box box-primary">\
                                              <div class="box-header">\
                                                <h3 class="box-title">Jurnal Pasangan</h3>\
                                                <div class="pull-right">\
                                                <a class="glyphicon glyphicon-trash">\
                                                </a>\
                                                </div>\
                                              </div>\
                                              <div class="box-body">\
                                                <div class="row">\
                                                  <div id="Debit" class="col-sm-6">\
                                                    <div class="row">\
                                                      <div class="col-md-7" style="padding-top:5px;"><label> Debit </label> </div>\
                                                      <div class="col-md-1">\
                                                        <a class="glyphicon glyphicon-plus" name="add_debit"></a>\
                                                      </div>\
                                                    </div>\
                                                    <div id="debt">\
                                                      <div class="row">\
                                                        <div class="col-md-12">\
                                                          <div class="row">\
                                                            <div class="col-md-8" style="padding-top:5px;">\
                                                             <select  name="debit_akun" id="debit_akun" type="text" class="form-control">\
                                                                <?php foreach($akun as $a) : ?>\
                                                                  <?php
                                                                    if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                                      $id_mst_akun = $id_mst_akun;
                                                                    }else{
                                                                      $id_mst_akun = set_value('id_mst_akun');
                                                                    }
                                                                      $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                                  ?>
                                                                  <option value="<?php echo $a->id_mst_akun ?>"\
                                                                   <?php echo $select ?>><?php echo $a->uraian ?>\
                                                                   </option>\
                                                                  <?php endforeach ?>\
                                                              </select>\
                                                            </div>\
                                                            <div class="col-md-1">\
                                                              <div class="parentDiv">\
                                                                <a data-toggle="collapse" data-target="#debit" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                                                </a>\
                                                              </div>\
                                                            </div>\
                                                            <div class="col-md-2">\
                                                              <a class="glyphicon glyphicon-trash">\
                                                              </a>\
                                                            </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                    <div class="collapse" id="debit">\
                                                      <div class="row">\
                                                        <div class="col-md-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" name="debit_isi_otomatis" value="1" <?php 
                                                                if(set_value('status')=="" && isset($status)){
                                                                  $status = $status;
                                                                }else{
                                                                  $status = set_value('status');
                                                                }
                                                                if($status == 1) echo "checked";
                                                              ?>>\
                                                            </div>\
                                                            <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                      <div class="row">\
                                                      <div class="col-sm-1">\
                                                      </div>\
                                                        <div class="col-sm-10">\
                                                          <div class="row">\
                                                            <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label></div>\
                                                            <div class="col-md-7">\
                                                              <select  name="debit_cmbx_nilai" type="text" class="form-control">\
                                                                <?php foreach($kategori as $k) : ?>\
                                                                    <?php
                                                                      if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                                        $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                                      }else{
                                                                        $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                                      }
                                                                      $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                                    ?>
                                                                    <option value="<?php echo $k->id_mst_kategori_transaksi ?>"\
                                                                     <?php echo $select ?>><?php echo $k->nama ?>\
                                                                    </option>\
                                                                <?php endforeach ?>\
                                                              </select>\
                                                            </div>\
                                                            <div class="col-md-2">\
                                                              <input type="text" class="form-control" id="debit_value_nilai" name="debit_value_nilai" value="<?php 
                                                                if(set_value('value')=="" && isset($value)){
                                                                  echo $value;
                                                                }else{
                                                                  echo  set_value('value');
                                                                }
                                                                ?>">\
                                                             </div>\
                                                            <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                      <div class="row">\
                                                        <div class="col-md-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" name="debit_opsional" value="1" <?php 
                                                                if(set_value('status')=="" && isset($status)){
                                                                $status = $status;
                                                                  }else{
                                                                $status = set_value('status');
                                                                  }
                                                                if($status == 1) echo "checked";
                                                              ?>>\
                                                            </div>\
                                                            <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                </div>\
                                                <div id="Kredit" class="col-sm-6">\
                                                  <div class="row">\
                                                    <div class="col-md-8" style="padding-top:5px;"><label>Kredit</label></div>\
                                                    <div class="col-md-2">\
                                                      <a class="glyphicon glyphicon-plus" name="add_kredit">\
                                                      </a>\
                                                    </div>\
                                                  </div>\
                                                  <div id="kredit">\
                                                    <div class="row" >\
                                                      <div class="col-md-12">\
                                                        <div class="row">\
                                                          <div class="col-md-1" style="padding-top:5px;"><label> 1 </label> </div>\
                                                          <div class="col-md-8" style="padding-top:5px;">\
                                                            <select  name="kredit_akun" type="text" class="form-control">\
                                                              <?php foreach($akun as $a) : ?>\
                                                                <?php
                                                                  if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                                    $id_mst_akun = $id_mst_akun;
                                                                  }else{
                                                                    $id_mst_akun = set_value('id_mst_akun');
                                                                  }
                                                                    $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                                ?>\
                                                                <option value="<?php echo $a->id_mst_akun ?>"\
                                                                 <?php echo $select ?>><?php echo $a->uraian ?>\
                                                                 </option>\
                                                                <?php endforeach ?>\
                                                            </select>\
                                                          </div>\
                                                          <div class="col-md-1">\
                                                            <div class="parentDiv">\
                                                              <a data-toggle="collapse" data-target="#kredit1" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                                              </a>\
                                                            </div>\
                                                          </div>\
                                                          <div class="col-md-2">\
                                                            <a class="glyphicon glyphicon-trash">\
                                                            </a>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                    <div class="collapse" id="kredit1">\
                                                      <div class="row">\
                                                        <div class="col-sm-1">\
                                                        </div>\
                                                        <div class="col-sm-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" name="kredit_isi_otomatis" value="1" <?php 
                                                                if(set_value('status')=="" && isset($status)){
                                                                  $status = $status;
                                                                }else{
                                                                  $status = set_value('status');
                                                                }
                                                                if($status == 1) echo "checked";
                                                              ?>>\
                                                            </div>\
                                                            <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                      <div class="row">\
                                                        <div class="col-sm-1">\
                                                        </div>\
                                                        <div class="col-sm-1">\
                                                        </div>\
                                                        <div class="col-sm-10">\
                                                          <div class="row">\
                                                            <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>\
                                                            <div class="col-md-7">\
                                                              <select  name="kredit_cmbx_nilai" type="text" class="form-control">\
                                                                <?php foreach($kategori as $k) : ?>\
                                                                    <?php
                                                                      if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                                        $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                                      }else{
                                                                        $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                                      }
                                                                      $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                                    ?>\
                                                                    <option value="<?php echo $k->id_mst_kategori_transaksi ?>"\
                                                                     <?php echo $select ?>><?php echo $k->nama ?>\
                                                                    </option>\
                                                                <?php endforeach ?>\
                                                              </select>\
                                                            </div>\
                                                            <div class="col-md-2">\
                                                                <input type="text" class="form-control" name="kredit_value_nilai" value="<?php 
                                                                if(set_value('value')=="" && isset($value)){
                                                                  echo $value;
                                                                }else{
                                                                  echo  set_value('value');
                                                                }
                                                                ?>">\
                                                            </div>\
                                                            <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                      <div class="row">\
                                                        <div class="col-sm-1">\
                                                        </div>\
                                                        <div class="col-sm-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" name="kredit_opsional" value="1" <?php 
                                                                if(set_value('status')=="" && isset($status)){
                                                                $status = $status;
                                                                  }else{
                                                                $status = set_value('status');
                                                                  }
                                                                if($status == 1) echo "checked";
                                                              ?>>\
                                                            </div>\
                                                            <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                </div>\
                                              </div>\
                                            </div>\
                                          </div>\
                                        </div>';

                $('#jt').append(form_jurnal_transaksi);
                counter_jurnal++;
              }else{
                alert("Failed.");
              }
            }
        });
        return false;
    });

    $('.parentDiv').click(function() {
      var toggle_sign = $(this).find(".toggle_sign");
      if ($(toggle_sign).hasClass("glyphicon-chevron-down")) {
        $(toggle_sign).removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
      } else {
        $(toggle_sign).addClass("glyphicon-chevron-down").removeClass("glyphicon-chevron-up");
      }
    });

    $("[name='transaksi_template']").click(function(){
      var data = new FormData();
        data.append('template',     $(this).val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_template_update/".$id?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#transaksi_template").prop("checked", true);
              }else{
                $("#transaksi_template").prop("checked", false);
              }
            }
        });
    });

    $("[name='btn_transaksi_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('nama',                      $("[name='transaksi_nama']").val());
        data.append('deskripsi',                 $("[name='transaksi_deskripsi']").val());
        data.append('untuk_jurnal',              $("[name='transaksi_jurnal']").val());
        data.append('id_mst_kategori_transaksi', $("[name='transaksi_kategori']").val());
              
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_{action}/{id}"?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                alert("Data berhasil disimpan.");
              }else{
                alert("Isi kolom yang kosong.");
              }
            }
        });
        return false;
    });

    function clearForm(form_transaksi) {
   
    var elements = form_transaksi.elements;
    form_transaksi.reset();

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

