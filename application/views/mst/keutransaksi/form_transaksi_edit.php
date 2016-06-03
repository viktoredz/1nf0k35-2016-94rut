<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form>
  <div class="row">
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

                  <div id="debt">
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
                                  <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                              <?php endforeach ?>
                            </select>
                          </div> 
                          <div class="col-md-2">
                            <input type="text" class="form-control" id="debit_value_nilai" name="debit_value_nilai" value="<?php 
                              if(set_value('value')=="" && isset($value)){
                                echo $value;
                              }else{
                                echo  set_value('value');
                              }
                              ?>">
                           </div>
                           <p id="d_value_nilai"></p>
                          <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>
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
              </div>

              <div id="Kredit" class="col-sm-6">
                <div class="row">
                  <div class="col-md-8" style="padding-top:5px;"><label> Kredit </label> </div>
                  <div class="col-md-2">
                    <a class="glyphicon glyphicon-plus" onclick="add_kredit()"></a>
                  </div> 
                </div>
                
                <div id="kredit">
                  <div class="row" >
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-1" style="padding-top:5px;"><label> 1 </label> </div>
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
                            <a data-toggle="collapse" data-target="#kredit1" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                          </div>
                        </div>
<!--                         <div class="col-md-2">
                          <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
                        </div>  -->
                      </div>
                    </div>
                  </div>

                  <div class="collapse" id="kredit1">

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
  </div>
</form>
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
                    <a data-toggle="collapse" data-target="#debit" class="toggle_sign glyphicon glyphicon-chevron-down">\
                    </a>\
                  </div>\
                </div>\
                <div class="col-md-2">\
                  <a href="#" class="glyphicon glyphicon-trash">\
                  </a>\
                </div>\
          </div>\
        </div>\
      </div>';


  $("[name='add_debit']").click(function() {
          $('#Debit').append(form_debit);
      });


    $("[name='jurnal_transaksi']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('value',          $("[name='debit_value']").val());
              
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add/{id}" ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                alert("Success.");

                    //menentukan target append
                 var jurnal_transaksi = document.getElementById('jt');
                    
                    //membuat element
                  var row_parent = document.createElement('div');
                  row_parent.setAttribute('class','box box-primary');

                  var box_header = document.createElement('div');
                  box_header.setAttribute('class','box-header');

                  var box_body = document.createElement('div');
                  box_body.setAttribute('class','box-body');

                  var row_collapse = document.createElement('div');
                  row_collapse.setAttribute('id','debit2');
                  row_collapse.setAttribute('class','collapse');

                  var judul = document.createElement('h3');
                  judul.setAttribute('class','box-title');
                  judul.innerHTML = "Jurnal Pasangan";

                  var Debit = document.createElement('div');
                  Debit.setAttribute('id','Debit');
                  Debit.setAttribute('class','col-sm-6');

                  var row_d_1 = document.createElement('div');
                  row_d_1.setAttribute('class','row');

                  var row_lbl_debit = document.createElement('div');
                  row_lbl_debit.setAttribute('class','col-md-7');
                  row_lbl_debit.setAttribute('style','padding-top:5px');

                  var lbl_debit = document.createElement('label');
                  lbl_debit.innerHTML ='Debit';

                  var add_debit = document.createElement('div');
                  add_debit.setAttribute('class','col-md-1');
                  add_debit.innerHTML = '<a class="glyphicon glyphicon-plus" onclick="add_debit(Debit)"></a>';

                  var debt = document.createElement('div');
                  debt.setAttribute('id','debt');

                  var row_d_2 = document.createElement('div');
                  row_d_2.setAttribute('class','row');

                  var col_md = document.createElement('div');
                  col_md.setAttribute('class','col-md-12');

                  var row_d_6 = document.createElement('div');
                  row_d_6.setAttribute('class','row');

                  var col_md_2 = document.createElement('div');
                  col_md_2.setAttribute('class','col-md-8');
                  col_md_2.setAttribute('style','padding-top:5px');

                  var cmb_box_debit = document.createElement('select');
                  var options = ["1", "2", "3", "4", "5"];
                  for(var i = 0; i < options.length; i++) {
                      var opt = options[i];
                      var el = document.createElement("option");
                      el.textContent = opt;
                      el.value = opt;
                      cmb_box_debit.appendChild(el);
                  }
                  cmb_box_debit.setAttribute('name', 'cmb_box_debit');
                  cmb_box_debit.setAttribute('class', 'form-control');

                  var col_md_3 = document.createElement('div');
                  col_md_3.setAttribute('class','col-md-1');

                  var parentDiv = document.createElement('div');
                  parentDiv.setAttribute('class','parentDiv');
                  parentDiv.innerHTML = '<a data-toggle="collapse" data-target="#debit2" class="toggle_sign glyphicon glyphicon-chevron-down"></a>';

                  var debit = document.createElement('div');
                  debit.setAttribute('id','debit2');
                  debit.setAttribute('class','collapse');

                  var row_d_3 = document.createElement('div');
                  row_d_3.setAttribute('class','row');

                  var col_md_4 = document.createElement('div');
                  col_md_4.setAttribute('class','col-md-7');

                  var row_d_7 = document.createElement('div');
                  row_d_7.setAttribute('class','row');

                  var col_md_5 = document.createElement('div');
                  col_md_5.setAttribute('class','col-md-1');
                  
                  var cbx_isi_otomatis = document.createElement('input');
                  cbx_isi_otomatis.setAttribute('type','checkbox');

                  var col_md_6 = document.createElement('div');
                  col_md_6.setAttribute('class','col-md-6');
                  
                  var lbl_isi_otomatis = document.createElement('label');
                  lbl_isi_otomatis.innerHTML ='Isi Otomatis';

                  var row_d_4 = document.createElement('div');
                  row_d_4.setAttribute('class','row');

                  var col_md_7 = document.createElement('div');
                  col_md_7.setAttribute('class','col-sm-1');
                  
                  var col_md_8 = document.createElement('div');
                  col_md_8.setAttribute('class','col-sm-10');

                  var row_d_8 = document.createElement('div');
                  row_d_8.setAttribute('class','row');

                  var col_md_9 = document.createElement('div');
                  col_md_9.setAttribute('class','col-md-2');
                  col_md_9.setAttribute('style','padding-top:5px');

                  var lbl_nilai = document.createElement('label');
                  lbl_nilai.innerHTML="Nilai";

                  var col_md_10 = document.createElement('div');
                  col_md_10.setAttribute('class','col-md-7');

                  var cmb_box_nilai = document.createElement('select');
                   var options = ["1", "2", "3", "4", "5"];
                  for(var i = 0; i < options.length; i++) {
                      var opt = options[i];
                      var el = document.createElement("option");
                      el.textContent = opt;
                      el.value = opt;
                      cmb_box_debit.appendChild(el);
                  }
                  cmb_box_nilai.setAttribute('name', 'cmb_box_nilai');
                  cmb_box_nilai.setAttribute('class', 'form-control');

                  var col_md_11 = document.createElement('div');
                  col_md_11.setAttribute('class','col-md-2');

                  var txt_nilai =document.createElement('input');
                  txt_nilai.setAttribute('class','form-control');
                  txt_nilai.setAttribute('name','txt_nilai');

                  var col_md_12 = document.createElement('div');
                  col_md_12.setAttribute('class','col-md-1');
                  col_md_12.setAttribute('style','padding-top:5px');

                  var lbl_persen = document.createElement('label');
                  lbl_persen.innerHTML = "%";

                  var row_d_5 = document.createElement('div');
                  row_d_5.setAttribute('class','row');

                  var col_md_13 = document.createElement('div');
                  col_md_13.setAttribute('class','col-md-7');

                  var row_d_9 = document.createElement('div');
                  row_d_9.setAttribute('class','row');

                  var col_md_14 = document.createElement('div');
                  col_md_14.setAttribute('class','col-md-1');

                  var cbx_opsional = document.createElement('input');
                  cbx_opsional.setAttribute('type','checkbox');

                  var col_md_15 = document.createElement('div');
                  col_md_15.setAttribute('class','col-md-3');
                  col_md_15.setAttribute('style','padding-top:5px');

                  var lbl_opsional = document.createElement('label');
                  lbl_opsional.innerHTML = "Opsional";


                  var Kredit = document.createElement('div');
                  Kredit.setAttribute('id','Kredit');
                  Kredit.setAttribute('class','col-sm-6');

                  var row_k_1 = document.createElement('div');
                  row_k_1.setAttribute('class','row');

                  var col_mdk_1 = document.createElement('div');
                  col_mdk_1.setAttribute('class','col-md-8');
                  col_mdk_1.setAttribute('style','padding-top:5px');

                  var lbl_kredit = document.createElement('label');
                  lbl_kredit.innerHTML = "Kredit";

                  var col_mdk_2 = document.createElement('div');
                  col_mdk_2.setAttribute('class','col-md-2');

                  var add_kredit = document.createElement('div');
                  add_kredit.innerHTML = '<a class="glyphicon glyphicon-plus" onclick="add_kredit()"></a>';

                  var kredit = document.createElement('div');
                  kredit.setAttribute('id','kredit');


                  var row = document.createElement('div');
                  row.setAttribute('class','row');

                    //meng append element
                  jurnal_transaksi.appendChild(row_parent);
                  row_parent.appendChild(box_header);
                  row_parent.appendChild(box_body);

                  box_header.appendChild(judul);
                  box_body.appendChild(row);

                  row.appendChild(Debit);
                  Debit.appendChild(row_d_1);
                  row_d_1.appendChild(row_lbl_debit);
                  row_lbl_debit.appendChild(lbl_debit);
                  row_d_1.appendChild(add_debit);

                  Debit.appendChild(debt);
                  
                  debt.appendChild(row_d_2);
                  row_d_2.appendChild(col_md);

                  col_md.appendChild(row_d_6);
                  row_d_6.appendChild(col_md_2);
                  
                  col_md_2.appendChild(cmb_box_debit);

                  row_d_6.appendChild(col_md_3);
                  col_md_3.appendChild(parentDiv);

                  debt.appendChild(debit);
                  debit.appendChild(row_d_3);
                  row_d_3.appendChild(col_md_4);

                  col_md_4.appendChild(row_d_7);
                  row_d_7.appendChild(col_md_5);
                  col_md_5.appendChild(cbx_isi_otomatis);
                  row_d_7.appendChild(col_md_6);
                  col_md_6.appendChild(lbl_isi_otomatis);

                  debit.appendChild(row_d_4);
                  row_d_4.appendChild(col_md_7);
                  row_d_4.appendChild(col_md_8);
                  col_md_8.appendChild(row_d_8);

                  row_d_8.appendChild(col_md_9);
                  col_md_9.appendChild(lbl_nilai);

                  row_d_8.appendChild(col_md_10);
                  col_md_10.appendChild(cmb_box_nilai);

                  row_d_8.appendChild(col_md_11);
                  col_md_11.appendChild(txt_nilai);

                  row_d_8.appendChild(col_md_12);
                  col_md_12.appendChild(lbl_persen);

                  debit.appendChild(row_d_5);
                  row_d_5.appendChild(col_md_13);
                  col_md_13.appendChild(row_d_9);

                  row_d_9.appendChild(col_md_14);
                  col_md_14.appendChild(cbx_opsional);

                  row_d_9.appendChild(col_md_15);
                  col_md_15.appendChild(lbl_opsional);

                  row.appendChild(Kredit);
                  Kredit.appendChild(row_k_1);

                  row_k_1.appendChild(col_mdk_1);
                  col_mdk_1.appendChild(lbl_kredit);

                  row_k_1.appendChild(col_mdk_2);
                  col_mdk_2.appendChild(add_kredit);

                  Kredit.appendChild(kredit);

              }else{
                alert("Failed.");
              }
            }
        });

        return false;



    });

    // }

     var counter = 1;
    function add_kredit() {
          //menentukan target append
        var Kredit = document.getElementById('Kredit');
        
          //membuat element
        var row_parent = document.createElement('div');
        row_parent.setAttribute('id','kredit2');

        var row_collapse = document.createElement('div');
        row_collapse.setAttribute('id','debit2');
        row_collapse.setAttribute('class','collapse');

        var row = document.createElement('div');
        row.setAttribute('class','row');

        var row2 = document.createElement('div');
        row2.setAttribute('class','row');

        var row3 = document.createElement('div');
        row3.setAttribute('class','row');

        var row4 = document.createElement('div');
        row4.setAttribute('class','row');

        var empty2 = document.createElement('div');
        empty2.setAttribute('class','col-sm-1');

        var empty3 = document.createElement('div');
        empty3.setAttribute('class','col-sm-1');

        var empty4 = document.createElement('div');
        empty4.setAttribute('class','col-sm-1');

        var empty5 = document.createElement('div');
        empty5.setAttribute('class','col-sm-1');

        var jenis = document.createElement('div');
        jenis.setAttribute('class','col-md-8');
        jenis.setAttribute('style','padding-top:5px');

        var aksi = document.createElement('div');
        aksi.setAttribute('class','col-md-1');

        var aksi_collapse = document.createElement('div');
        aksi_collapse.setAttribute('class','col-md-1');

        var hapus = document.createElement('div');
        hapus.setAttribute('class','col-md-1');

        var collapse = document.createElement('div');
        collapse.setAttribute('class','parentDiv');

        var ck1 = document.createElement('div');
        ck1.setAttribute('class','col-md-1');

        var label_ck1 = document.createElement('div');
        label_ck1.setAttribute('class','col-md-6');
        label_ck1.setAttribute('style','padding-top:5px');

        var empty = document.createElement('div');
        empty.setAttribute('class','col-sm-1');

        var content_nilai = document.createElement('div');
        content_nilai.setAttribute('class','col-sm-10');

        var row_content_nilai = document.createElement('div');
        row_content_nilai.setAttribute('class','row');

        var label_n = document.createElement('div');
        label_n.setAttribute('class','col-sm-2');
        label_n.setAttribute('style','padding-top:13px');

        var cmb_box_n = document.createElement('div');
        cmb_box_n.setAttribute('class','col-sm-7');
        cmb_box_n.setAttribute('style','padding-top:5px');

        var input_n = document.createElement('div');
        input_n.setAttribute('class','col-md-2');
        input_n.setAttribute('style','padding-top:5px');

        var label_n_2 = document.createElement('div');
        label_n_2.setAttribute('class','col-sm-1');
        label_n_2.setAttribute('style','padding-top:7px');

        var ck2 = document.createElement('div');
        ck2.setAttribute('class','col-md-1');

        var label_ck2 = document.createElement('div');
        label_ck2.setAttribute('class','col-md-6');
        label_ck2.setAttribute('style','padding-top:5px');


          //meng append element
        Kredit.appendChild(row_parent);
        row_parent.appendChild(row);
        row_parent.appendChild(row_collapse);
        row_collapse.appendChild(row2);
        row_collapse.appendChild(row3);
        row_collapse.appendChild(row4);

        row.appendChild(empty2);
        row.appendChild(jenis);
        row.appendChild(aksi_collapse);
        row.appendChild(aksi);

        row2.appendChild(empty3);
        row2.appendChild(ck1);
        row2.appendChild(label_ck1);

        row3.appendChild(empty);
        row3.appendChild(empty5);
        row3.appendChild(content_nilai);
        content_nilai.appendChild(row_content_nilai);
        row_content_nilai.appendChild(label_n);
        row_content_nilai.appendChild(cmb_box_n);
        row_content_nilai.appendChild(input_n);
        row_content_nilai.appendChild(label_n_2);

        row4.appendChild(empty4);
        row4.appendChild(ck2);
        row4.appendChild(label_ck2);

          //membuat element input
        var jenis_input = document.createElement('select');
        var options = ["1", "2", "3", "4", "5"];
        for(var i = 0; i < options.length; i++) {
            var opt = options[i];
            var el = document.createElement("option");
            el.textContent = opt;
            el.value = opt;
            jenis_input.appendChild(el);
        }
        jenis_input.setAttribute('name', 'jenis_input[' + i + ']');
        jenis_input.setAttribute('class', 'form-control');

        var label_no = document.createElement('label');
        label_no.innerHTML = (counter + 1);
        counter++;

        var isi_otomatis = document.createElement('input');
        isi_otomatis.setAttribute('type','checkbox');

        var label_isi_otomatis = document.createElement('label');
        label_isi_otomatis.innerHTML = "Isi Otomatis";

        var label_nilai = document.createElement('label');
        label_nilai.innerHTML = "Nilai";

        var label_persen = document.createElement('label');
        label_persen.innerHTML = "%";

        var cmb_box_nilai = document.createElement('select');
        var options = ["1", "2", "3", "4", "5"];
        for(var i = 0; i < options.length; i++) {
            var opt = options[i];
            var el = document.createElement("option");
            el.textContent = opt;
            el.value = opt;
            jenis_input.appendChild(el);
        }
        cmb_box_nilai.setAttribute('name', 'cmb_bx_nilai');
        cmb_box_nilai.setAttribute('class', 'form-control');

        var input_nilai = document.createElement('input');
        input_nilai.setAttribute('class','form-control');
        input_nilai.setAttribute('type','text');
        input_nilai.setAttribute('name','nilai');

        var opsional = document.createElement('input');
        opsional.setAttribute('type','checkbox');

        var label_opsional = document.createElement('label');
        label_opsional.innerHTML = "Opsional";


          //meng append element input
        jenis.appendChild(jenis_input);
        aksi_collapse.appendChild(collapse);
        aksi.appendChild(hapus);
        ck1.appendChild(isi_otomatis);
        label_ck1.appendChild(label_isi_otomatis);
        label_n.appendChild(label_nilai);
        label_n_2.appendChild(label_persen);
        cmb_box_n.appendChild(cmb_box_nilai);
        input_n.appendChild(input_nilai);
        ck2.appendChild(opsional);
        label_ck2.appendChild(label_opsional);
        empty2.appendChild(label_no);

        hapus.innerHTML = '<a class="glyphicon glyphicon-trash"></a>';
        collapse.innerHTML = '<a data-toggle="collapse" data-target="#kredit_collapse" class="toggle_sign glyphicon glyphicon-chevron-down"></a>';

          //membuat aksi delete element
        hapus.onclick = function () {
            row.parentNode.removeChild(row);
            row2.parentNode.removeChild(row2);
            row3.parentNode.removeChild(row3);
            row4.parentNode.removeChild(row4);
        };

        i++;
    }

    // function add_debit() {
    //       //menentukan target append
    //     var Debit = document.getElementById('Debit');
        
    //       //membuat element
    //     var row_parent = document.createElement('div');
    //     row_parent.setAttribute('id','debt2');

    //     var row_collapse = document.createElement('div');
    //     row_collapse.setAttribute('id','debit2');
    //     row_collapse.setAttribute('class','collapse');

    //     var row = document.createElement('div');
    //     row.setAttribute('class','row');

    //     var row2 = document.createElement('div');
    //     row2.setAttribute('class','row');

    //     var row3 = document.createElement('div');
    //     row3.setAttribute('class','row');

    //     var row4 = document.createElement('div');
    //     row4.setAttribute('class','row');

    //     var jenis = document.createElement('div');
    //     jenis.setAttribute('class','col-md-8');
    //     jenis.setAttribute('style','padding-top:5px');

    //     var aksi = document.createElement('div');
    //     aksi.setAttribute('class','col-md-1');

    //     var aksi_collapse = document.createElement('div');
    //     aksi_collapse.setAttribute('class','col-md-1');

    //     var hapus = document.createElement('div');
    //     hapus.setAttribute('class','col-md-1');

    //     var collapse = document.createElement('div');
    //     collapse.setAttribute('class','parentDiv');

    //     var ck1 = document.createElement('div');
    //     ck1.setAttribute('class','col-md-1');

    //     var label_ck1 = document.createElement('div');
    //     label_ck1.setAttribute('class','col-md-6');
    //     label_ck1.setAttribute('style','padding-top:5px');

    //     var empty = document.createElement('div');
    //     empty.setAttribute('class','col-sm-1');

    //     var content_nilai = document.createElement('div');
    //     content_nilai.setAttribute('class','col-sm-10');

    //     var row_content_nilai = document.createElement('div');
    //     row_content_nilai.setAttribute('class','row');

    //     var label_n = document.createElement('div');
    //     label_n.setAttribute('class','col-sm-2');
    //     label_n.setAttribute('style','padding-top:13px');

    //     var cmb_box_n = document.createElement('div');
    //     cmb_box_n.setAttribute('class','col-sm-7');
    //     cmb_box_n.setAttribute('style','padding-top:5px');

    //     var input_n = document.createElement('div');
    //     input_n.setAttribute('class','col-md-2');
    //     input_n.setAttribute('style','padding-top:5px');

    //     var label_n_2 = document.createElement('div');
    //     label_n_2.setAttribute('class','col-sm-1');
    //     label_n_2.setAttribute('style','padding-top:7px');

    //     var ck2 = document.createElement('div');
    //     ck2.setAttribute('class','col-md-1');

    //     var label_ck2 = document.createElement('div');
    //     label_ck2.setAttribute('class','col-md-6');
    //     label_ck2.setAttribute('style','padding-top:5px');


    //       //meng append element
    //     Debit.appendChild(row_parent);
    //     row_parent.appendChild(row);
    //     row_parent.appendChild(row_collapse);
    //     row_collapse.appendChild(row2);
    //     row_collapse.appendChild(row3);
    //     row_collapse.appendChild(row4);

    //     row.appendChild(jenis);
    //     row.appendChild(aksi_collapse);
    //     row.appendChild(aksi);

    //     row2.appendChild(ck1);
    //     row2.appendChild(label_ck1);

    //     row3.appendChild(empty);
    //     row3.appendChild(content_nilai);
    //     content_nilai.appendChild(row_content_nilai);
    //     row_content_nilai.appendChild(label_n);
    //     row_content_nilai.appendChild(cmb_box_n);
    //     row_content_nilai.appendChild(input_n);
    //     row_content_nilai.appendChild(label_n_2);

    //     row4.appendChild(ck2);
    //     row4.appendChild(label_ck2);

    //       //membuat element input
    //     var jenis_input = document.createElement('select');
    //     var options = ["1", "2", "3", "4", "5"];
    //     for(var i = 0; i < options.length; i++) {
    //         var opt = options[i];
    //         var el = document.createElement("option");
    //         el.textContent = opt;
    //         el.value = opt;
    //         jenis_input.appendChild(el);
    //     }
    //     jenis_input.setAttribute('name', 'jenis_input[' + i + ']');
    //     jenis_input.setAttribute('class', 'form-control');

    //     var isi_otomatis = document.createElement('input');
    //     isi_otomatis.setAttribute('type','checkbox');

    //     var label_isi_otomatis = document.createElement('label');
    //     label_isi_otomatis.innerHTML = "Isi Otomatis";

    //     var label_nilai = document.createElement('label');
    //     label_nilai.innerHTML = "Nilai";

    //     var label_persen = document.createElement('label');
    //     label_persen.innerHTML = "%";

    //     var cmb_box_nilai = document.createElement('select');
    //     var options = ["1", "2", "3", "4", "5"];
    //     for(var i = 0; i < options.length; i++) {
    //         var opt = options[i];
    //         var el = document.createElement("option");
    //         el.textContent = opt;
    //         el.value = opt;
    //         jenis_input.appendChild(el);
    //     }
    //     cmb_box_nilai.setAttribute('name', 'cmb_bx_nilai');
    //     cmb_box_nilai.setAttribute('class', 'form-control');

    //     var input_nilai = document.createElement('input');
    //     input_nilai.setAttribute('class','form-control');
    //     input_nilai.setAttribute('type','text');
    //     input_nilai.setAttribute('name','nilai');

    //     var opsional = document.createElement('input');
    //     opsional.setAttribute('type','checkbox');

    //     var label_opsional = document.createElement('label');
    //     label_opsional.innerHTML = "Opsional";


    //       //meng append element input
    //     jenis.appendChild(jenis_input);
    //     aksi_collapse.appendChild(collapse);
    //     aksi.appendChild(hapus);
    //     ck1.appendChild(isi_otomatis);
    //     label_ck1.appendChild(label_isi_otomatis);
    //     label_n.appendChild(label_nilai);
    //     label_n_2.appendChild(label_persen);
    //     cmb_box_n.appendChild(cmb_box_nilai);
    //     input_n.appendChild(input_nilai);
    //     ck2.appendChild(opsional);
    //     label_ck2.appendChild(label_opsional);

    //     hapus.innerHTML = '<a class="glyphicon glyphicon-trash"></a>';
    //     collapse.innerHTML = '<a data-toggle="collapse" data-target="#debit2" class="toggle_sign glyphicon glyphicon-chevron-down"></a>';

    //       //membuat aksi delete element
    //     hapus.onclick = function () {
    //         row.parentNode.removeChild(row);
    //         row2.parentNode.removeChild(row2);
    //         row3.parentNode.removeChild(row3);
    //         row4.parentNode.removeChild(row4);
    //     };

    //     i++;
    // }

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

