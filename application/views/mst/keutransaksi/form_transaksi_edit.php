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

<script>
  $(function() {
    $("#menu_master_data").addClass("active");
    $("#menu_mst_keuangan_transaksi").addClass("active");
  });
</script>

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
          <button type="reset" value="Reset" class="btn btn-success"><i class='fa fa-refresh'></i> &nbsp; Reset</button>
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
       <?php foreach($jurnal_transaksi as $jt) : ?>
        <div id="jt-<?php echo $jt->group ?>">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Jurnal Pasangan</h3>
              <div class="pull-right"><a id="delete_jt-<?php echo $jt->group ?>" name="delete_jt" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a></div>
            </div>
            <div class="box-body">
              <div class="row">
                <div id="Debit-<?php echo $jt->group ?>" class="col-sm-6">
                  <div class="row">
                    <div class="col-md-7" style="padding-top:5px;"><label> Debit</label> </div>
                    <div class="col-md-1">
                      <?php
                        // print_r(count($kredit[$jt->group]));
                        if(count($kredit[$jt->group]) > "1"){?>
                            <a style="visibility: hidden" class="glyphicon glyphicon-plus" id="add_debit-<?php echo $jt->group?>" name="add_debit"></a>
                         <?php }else{  ?>
                            <a class="glyphicon glyphicon-plus" id="add_debit-<?php echo $jt->group?>" name="add_debit"></a>
                      <?php } ?>
                    </div> 
                  </div>
                <?php foreach($debit[$jt->group] as $row) : ?>
                  <div id="debt-<?php echo $row->id_mst_transaksi_item ?>" name="debt-<?php echo $row->group ?>">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="row" style="margin: 5px">
                            <div class="col-md-8">
                              <input type="hidden" class="form-control" name="debit_id" id="debit_id" value="<?php echo $row->id_mst_transaksi_item ?>">
                            </div>
                          </div>
                          <div class="col-md-8" style="padding-top:5px;">
                           <select id="debit_akun-<?php echo $row->id_mst_transaksi_item ?>" name="debit_akun-<?php echo $row->group ?>" onchange="debit_akun(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>)" type="text" class="form-control">
                              <?php foreach($akun as $a) : ?>
                                <?php
                                  if(set_value('id_mst_akun')=="" && isset($row->id_mst_akun)){
                                    $id_mst_akun = $row->id_mst_akun;
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
                              <a data-toggle="collapse" data-target="#debit<?php echo $row->id_mst_transaksi_item ?>" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <a id="delete_debit-<?php echo $row->id_mst_transaksi_item ?>" name="delete_debit-<?php echo $row->group ?>" onclick="delete_debit(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>)" class="glyphicon glyphicon-trash"></a>
                          </div> 
                      </div>
                    </div>
                  </div>
                  <div class="collapse" id="debit<?php echo $row->id_mst_transaksi_item ?>">
                    <div class="row">
                      <div class="col-md-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" id="debit_isi_otomatis-<?php echo $row->id_mst_transaksi_item ?>" name="debit_isi_otomatis-<?php echo $row->group ?>" onclick="debit_isi_otomatis(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>,this)" value="1" 
                            <?php 
                              if(!empty($row->auto_fill)){
                               echo "checked";
                              }
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
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" id="debit_opsional-<?php echo $row->id_mst_transaksi_item ?>" name="debit_opsional" value="1" <?php 
                              if(!empty($row->opsional)){ echo "checked";}
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

              <div id="Kredit-<?php echo $jt->group ?>" class="col-sm-6">
                <div class="row">
                  <div class="col-md-8" style="padding-top:5px;"><label>Kredit</label></div>
                  <div class="col-md-2">
                    <?php
                      // print_r(count($debit[$jt->group]));
                      if(count($debit[$jt->group]) > "1"){?>
                          <a style="visibility: hidden" class="glyphicon glyphicon-plus" id="add_kredit-<?php echo $jt->group?>" name="add_kredit"></a>
                       <?php }else{  ?>
                          <a class="glyphicon glyphicon-plus" id="add_kredit-<?php echo $jt->group?>" name="add_kredit"></a>
                    <?php } ?>
                  </div> 
                </div>
              <?php foreach($kredit[$jt->group] as $row) : ?> 
                <div id="kredit-<?php echo $row->id_mst_transaksi_item ?>" name="kredit-<?php echo $row->group ?>">
                  <div class="row" >
                    <div class="col-md-12">
                      <div class="row">
                        <!-- <div class="col-md-1" style="padding-top:5px;"><label><?php echo $row->urutan ?></label> </div> -->
                        <div class="row" style="margin: 5px">
                          <div class="col-md-8">
                            <input type="hidden" class="form-control" name="kredit_id" id="kredit_id" value="<?php echo $row->id_mst_transaksi_item ?>">
                          </div>
                        </div>

                        <div class="col-md-8" style="padding-top:5px;"> 
                          <select id="kredit_akun-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_akun-<?php echo $row->group ?>" onchange="kredit_akun(<?php echo $row->id_mst_transaksi_item ?>)" type="text" class="form-control">
                            <?php foreach($akun as $a) : ?>
                              <?php
                                if(set_value('id_mst_akun')=="" && isset($row->id_mst_akun)){
                                  $id_mst_akuns = $row->id_mst_akun;
                                }else{
                                  $id_mst_akuns = set_value('id_mst_akun');
                                }
                                  $select = $a->id_mst_akun == $id_mst_akuns ? 'selected' : '' ;
                              ?>
                              <option value="<?php echo $a->id_mst_akun ?>" <?php echo $select ?>><?php echo $a->uraian ?></option>
                              <?php endforeach ?>
                          </select>
                        </div>
                        <div class="col-md-1">
                          <div class="parentDiv">
                            <a data-toggle="collapse" data-target="#kredit<?php echo $row->id_mst_transaksi_item ?>" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <a id="delete_kredit-<?php echo $row->id_mst_transaksi_item ?>" name="delete_kredit-<?php echo $row->group ?>" onclick="delete_kredit(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>)" class="glyphicon glyphicon-trash"></a>
                        </div> 
                      </div>
                    </div>
                  </div>
                  <div class="collapse" id="kredit<?php echo $row->id_mst_transaksi_item ?>">
                    <div class="row">
                      <div class="col-sm-1"></div>
                      <div class="col-sm-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" id="kredit_isi_otomatis-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_isi_otomatis" value="1" <?php 
                              if(!empty($row->auto_fill)){ 
                                echo "checked";
                              }
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
                            <select id="kredit_cmbx_nilai-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_cmbx_nilai-<?php echo $row->group?>" type="text" class="form-control">
                              <?php foreach($nilai_debit[$row->group] as $nd) : ?>
                                  <?php
                                    if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                      $id_mst_akun = $id_mst_akun;
                                    }else{
                                      $id_mst_akun = set_value('id_mst_akun');
                                    }
                                    $select = $nd->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                  ?>
                                  <option value="<?php echo $nd->id_mst_akun ?>" <?php echo $select ?>><?php echo $nd->uraian ?></option>
                              <?php endforeach ?>
                            </select>
                          </div> 
                          <div class="col-md-2">
                            <input type="text" class="form-control" id="kredit_value_nilai-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_value_nilai-<?php echo $row->group ?>" onchange="kredit_value_nilai(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>)" value="<?php echo $row->value ?>">
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
                            <input type="checkbox" id="kredit_opsional-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_opsional" value="1" <?php 
                              if(!empty($row->opsional)){
                               echo "checked";
                              }
                            ?>>
                          </div> 
                          <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
              <!-- <span id="percent-<?php echo $row->group ?>">0</span>% -->
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>
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

    function kredit_akun(id) {

      var kredit_akun_val    = $("#kredit_akun-"+id+"").val();
      var kredit_akun_select = $("#kredit_akun-"+id+">option:selected").text();

      $.ajax({
         type: 'POST',
         url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
         data : 'id_mst_akun='+kredit_akun_val+'&id_mst_transaksi_item='+id,
         success: function (response) {
          if(response=="OK"){
          }else{
              alert("Failed.");
          }
         }
      });
    }

    function debit_akun(id,group) {

      var debit_akun_val    = $("#debit_akun-"+id+"").val();
      var debit_akun_select = $("#debit_akun-"+id+">option:selected").text();

      $("[name='kredit_cmbx_nilai-"+group+"']").each(function(){
        var id_kredit_sementara = this.id;
        var fields = id_kredit_sementara.split(/-/);
        var id_kredit_cmbx = fields[1];

        $.ajax({
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
           data : 'id_mst_akun='+debit_akun_val+'&id_mst_transaksi_item='+id+'&id_mst_transaksi_item_from='+debit_akun_val+'&id_mst_transaksi_item_kredit='+id_kredit_cmbx,
           success: function (response) {
            if(response=="OK"){
              $("[name='kredit_cmbx_nilai-"+group+"']>").val(debit_akun_val).text(debit_akun_select);
            }else{
                alert("Failed.");
            }
           }
        });
      });
    }

    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>mst/keuangan_transaksi";
    });

      function delete_debit (id,group) {
        if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
            $.ajax({
             type: 'POST',
             url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete_debit" ?>',
             data : 'id_mst_transaksi_item='+id,
             success: function (response) {
              if(response=="OK"){
                  $("#debt-"+id).remove();
                  var count = $("[name='debt-"+group+"']").length;
                  if (count < 2) {
                    // $("[name='add_kredit']").show();
                    $('#add_kredit-'+group+'').show();
                  }else{
                    // $("[name='add_kredit']").hide();
                    $('#add_kredit-'+group+'').hide();
                  };
              }else{
                alert("Failed.");
              };
             }
          });

        } else{

        };
      }

      function delete_kredit (id,group) {
        if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
            $.ajax({
             type: 'POST',
             url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete_kredit" ?>',
             data : 'id_mst_transaksi_item='+id,
             success: function (response) {
              if(response=="OK"){
                  $("#kredit-"+id).remove();
                  var count = $("[name='kredit-"+group+"']").length;
                  if (count < 2) {
                    // $("[name='add_kredit']").show();
                    $('#add_debit-'+group+'').show();
                  }else{
                    // $("[name='add_kredit']").hide();
                    $('#add_debit-'+group+'').hide();
                  };
              }else{
                alert("Failed.");
              };
             }
          });

        } else{

        };
      }

    $("[name='delete_jt']").click(function(event){
       event.stopPropagation();
       if(confirm("Anda yakin ingin menghapus data ini ?")) {
        this.click;

          var group_sementara = this.id;
          var fields = group_sementara.split(/-/);
          var group = fields[1];

          $.ajax({
             type: 'POST',
             url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete" ?>',
             data : 'group='+group,
             success: function (response) {
              if(response=="OK"){
                  $("#jt-"+group).remove();
              }else{
                  alert("Failed.");
              }
             }
          });
        } else {
           // alert("Cancel");
       }       
       event.preventDefault();
    });

  $("select[name='kredit_cmbx_nilai']").change(function(){
      var id_mst_transaksi_item_from = $(this).val();
      var id_trans_item_sementara = this.id;
      var fields = id_trans_item_sementara.split(/-/);
      var id_mst_transaksi_item = fields[1];

      $.ajax({
         type: 'POST',
         url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
         data : 'id_mst_transaksi_item_from='+id_mst_transaksi_item_from+'&id_mst_transaksi_item='+id_mst_transaksi_item,
         success: function (response) {
          if(response=="OK"){
              // alert("Success.");
          }else{
              // alert("Failed.");
          }
         }
      });
  });

  function debit_isi_otomatis(id,group,obj) {
        var data = new FormData();
            data.append('auto_fill'            ,$("[name='debit_isi_otomatis-"+group+"']:checked").val());
            data.append('id_mst_transaksi_item', id);

        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                  if (obj.checked) {
                    $("#debit_isi_otomatis").prop("checked", true);
                    $("[name='kredit_cmbx_nilai-"+group+"']").prop("disabled",false);
                  } else{
                    $("#debit_isi_otomatis").prop("checked", false);
                    $("[name='kredit_cmbx_nilai-"+group+"']").prop("disabled",true);
                  };
              }else{
                  $("#debit_isi_otomatis").prop("checked", false);
                  alert("unchecked");
              }
            }
        });
    }

    $("[name='kredit_isi_otomatis']").change(function(){
          var id_trans_item_sementara = this.id;
          var fields = id_trans_item_sementara.split(/-/);
          var id_mst_transaksi_item = fields[1];

          var data = new FormData();
            data.append('auto_fill',  $("[name='kredit_isi_otomatis']:checked").val());
            data.append('id_mst_transaksi_item',  id_mst_transaksi_item);

            $.ajax({
                cache : false,
                contentType : false,
                processData : false,
                type : 'POST',
                url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
                data : data,
                success : function(response){
                  if(response=="OK"){
                      $("#kredit_isi_otomatis").prop("checked", true);
                      // alert("Success.");
                  }else{
                      $("#kredit_isi_otomatis").prop("checked", false);
                      // alert("Failed.");
                  }
                }
            });
        });

      $("[name='debit_opsional']").change(function(){
        var id_trans_item_sementara = this.id;
        var fields = id_trans_item_sementara.split(/-/);
        var id_mst_transaksi_item = fields[1];

        var data = new FormData();
          data.append('opsional',  $("[name='debit_opsional']:checked").val());
          data.append('id_mst_transaksi_item',  id_mst_transaksi_item);
          
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#debit_opsional").prop("checked", true);
                }else{
                    $("#debit_opsional").prop("checked", false);
                }
              }
          });
      });

      $("[name='kredit_opsional']").change(function(){
        var id_trans_item_sementara = this.id;
        var fields = id_trans_item_sementara.split(/-/);
        var id_mst_transaksi_item = fields[1];
      
        var data = new FormData();
        data.append('opsional',  $("[name='kredit_opsional']:checked").val());
        data.append('id_mst_transaksi_item',  id_mst_transaksi_item);
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                  $("#kredit_opsional").prop("checked", true);
              }else{
                  $("#kredit_opsional").prop("checked", false);
              }
            }
        });
    });

    function kredit_value_nilai(id,group) {

        var kredit_nilai_val = $("#kredit_value_nilai-"+id+"").val();
        
        //limit the value between 0 and 100
        var thisVal = parseInt($("[name='kredit_value_nilai-"+group+"']").val(), 10);

        if (!isNaN(thisVal)) {
          thisVal = Math.max(0, Math.min(100, thisVal));
          $(this).val(thisVal);
        }
        //get total of values
        var total = 0; 
        $("[name='kredit_value_nilai-"+group+"']:not(:last)").each(function() {
            var thisVal = parseInt($(this).val(), 10);
            if (!isNaN(thisVal))
                total += thisVal;
        var sisa = (100-total);

            if (100 - total > 0) {
               $("[name='kredit_value_nilai-"+group+"']:last").val(100 - total);

               $.ajax({
                   type: 'POST',
                   url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
                   data : 'value='+kredit_nilai_val+'&id_mst_transaksi_item='+id,
                   success: function (response) {
                    if(response=="OK"){
                        // alert("Success.");
                    }else{
                        alert("Failed.");
                    }
                   }
                });

            } else{
               alert("Jumlah Nilai Kredit Harus 100%");
               $("#kredit_value_nilai-"+id+"").val(0);
                  $.ajax({
                   type: 'POST',
                   url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
                   data : 'value='+sisa+'&id_mst_transaksi_item='+id,
                   success: function (response) {
                    if(response=="OK"){
                       alert(sisa);
                        // alert("Success.");
                    }else{
                        alert("Failed.");
                    }
                   }
                });
              };
        });
        // $('#percent-'+group+'').html(total);

    }

      <?php foreach($urutan_debit as $u) : ?>
      urutan_d = "<?php echo $u->urutan+1 ?>";
      <?php endforeach; ?>
      counter_debit = 1;

      $("[name='add_debit']").click(function() {
        var data = new FormData();
        var group_debit_sementara = this.id;
        var fields = group_debit_sementara.split(/-/);
        var group_debit = fields[1];

        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('value' ,      $("[name='debit_value']").val());
        data.append('urutan',      urutan_d);
        data.append('group' ,      group_debit);

        $.ajax({
           cache : false,
           contentType : false,
           processData : false,
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_debit/{id}" ?>',
           data : data,
           success: function (response) {
            a = response.split("|");
              if(a[0]=="OK"){
                if(a[1]!=null){

                var form_debit ='<div id="debt-'+a[1]+'">\
                                    <div class="row">\
                                      <div class="col-md-12">\
                                        <div class="row">\
                                          <div class="row" style="margin: 5px">\
                                            <div class="col-md-8">\
                                              <input type="hidden" class="form-control" name="debit_id_append" id="debit_id_append">\
                                            </div>\
                                          </div>\
                                          <div class="col-md-8" style="padding-top:5px;">\
                                            <select  name="debit_akun_append" id="debit_akun_append-'+a[1]+'" class="form-control"\ type="text">\
                                              <?php foreach($akun as $a) : ?>\
                                                <?php
                                                  if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                    $id_mst_akun = $id_mst_akun;
                                                  }else{
                                                    $id_mst_akun = set_value('id_mst_akun');
                                                  }
                                                    $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                ?>\
                                                <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?>\
                                                </option>\
                                                <?php endforeach ?>\
                                            </select>\
                                          </div>\
                                          <div class="col-md-1">\
                                            <div class="parentDiv">\
                                              <a data-toggle="collapse" data-target="#debit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                              </a>\
                                            </div>\
                                          </div>\
                                          <div class="col-md-2">\
                                           <a id="delete_debit_append-'+a[1]+'" name="delete_debit_append" onclick="delete_debit_append('+a[1]+')" class="glyphicon glyphicon-trash"></a>\
                                          </div>\
                                    </div>\
                                  </div>\
                                 </div>\
                               <div class="collapse" id="debit'+a[1]+'">\
                                  <div class="row">\
                                    <div class="col-md-7">\
                                      <div class="row">\
                                        <div class="col-md-1">\
                                         <input type="checkbox" id="debit_isi_otomatis_append-'+a[1]+'" name="debit_isi_otomatis_append" value="1" <?php 
                                            if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                $auto_fill = $auto_fill;
                                            }else{
                                                $auto_fill = set_value('auto_fill');
                                            }
                                                if($auto_fill == 1) echo "checked";
                                          ?>>\
                                        </div>\
                                        <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis '+counter_debit+' </label></div>\
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
                                             <option value="Dari Nilai Kredit" echo "selected" ?> Dari Nilai Kredit</option>\
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
                                            <input type="checkbox" id="debit_opsional_append-'+a[1]+'" name="debit_opsional_append" value="1" <?php 
                                            if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                $auto_fill = $auto_fill;
                                            }else{
                                                $auto_fill = set_value('auto_fill');
                                            }
                                                if($auto_fill == 1) echo "checked";
                                          ?>>\
                                          </div>\
                                          <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label></div>\
                                        </div>\
                                      </div>\
                                    </div>\
                                  </div>';

                $('#Debit-'+group_debit).append(form_debit);
                urutan_d++;
                counter_debit++;

                if (counter_debit > 1) {
                  $("#add_kredit-"+group_debit).hide();
                }else{
                  $("#add_kredit-"+group_debit).show();
                };

                $('#debit_id_append').val(a[1]);
                
                $("select[name='debit_akun_append']").change(function(){
                    var id_mst_akun_debit = $(this).val();

                    var id_trans_item_sementara = this.id;
                    var fields = id_trans_item_sementara.split(/-/);
                    var id_mst_transaksi_item_debit = fields[1];

                    var data = new FormData();

                    data.append('id_mst_akun', id_mst_akun_debit);
                    data.append('id_mst_transaksi_item',id_mst_transaksi_item_debit );

                    $.ajax({
                       type: 'POST',
                       url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
                       data : 'id_mst_akun='+id_mst_akun_debit+'&id_mst_transaksi_item='+id_mst_transaksi_item_debit,
                       success: function (response) {
                        if(response=="OK"){
                            // alert("Success.");
                        }else{
                            // alert("Failed.");
                        }
                       }
                    });
                });

                $("[name='debit_isi_otomatis_append']").change(function(){
                  var id_trans_item_sementara = this.id;
                  var fields = id_trans_item_sementara.split(/-/);
                  var id_mst_transaksi_item = fields[1];
                  
                  var data = new FormData();
                    data.append('auto_fill',  $("[name='debit_isi_otomatis_append']:checked").val());
                    data.append('id_mst_transaksi_item',  id_mst_transaksi_item);
                  
                  $.ajax({
                      cache : false,
                      contentType : false,
                      processData : false,
                      type : 'POST',
                      url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
                      data : data,
                      success : function(response){
                        if(response=="OK"){
                            $("#debit_isi_otomatis_append").prop("checked", true);
                        }else{
                            $("#debit_isi_otomatis_append").prop("checked", false);
                        }
                      }
                  });
              });

              $("[name='debit_opsional_append']").change(function(){
                var id_trans_item_sementara = this.id;
                var fields = id_trans_item_sementara.split(/-/);
                var id_mst_transaksi_item = fields[1];

                var data = new FormData();
                  data.append('opsional',  $("[name='debit_opsional_append']:checked").val());
                  data.append('id_mst_transaksi_item',  id_mst_transaksi_item);
                  
                  $.ajax({
                      cache : false,
                      contentType : false,
                      processData : false,
                      type : 'POST',
                      url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
                      data : data,
                      success : function(response){
                        if(response=="OK"){
                            $("#debit_opsional_append").prop("checked", true);
                        }else{
                            $("#debit_opsional_append").prop("checked", false);
                        }
                      }
                  });
              });
                }else{
                  alert("Kosong");
                };

            }else{
                alert("Failed.");
            }
           }
        });
      });

      function delete_debit_append (data) {
        if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
            $.ajax({
             type: 'POST',
             url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete_debit" ?>',
             data : 'id_mst_transaksi_item='+data,
             success: function (response) {
              if(response=="OK"){
                  $("#debt-"+data).remove();
                  counter_debit--;
                  urutan_d--;
                  if (counter_debit < 2) {
                    $("[name='add_kredit']").show();
                  }else{
                    $("[name='add_kredit']").hide();
                  }
              }else{
                alert("Failed.");
              };
             }
          });

        } else{

        };
      }

      <?php foreach($urutan_kredit as $u) : ?>
      urutan_k = "<?php echo $u->urutan+1 ?>";
      <?php endforeach ?>

      counter_kredit = 1;

      $("[name='add_kredit']").click(function() {
         var data = new FormData();
         var group_kredit_sementara = this.id;
         var fields = group_kredit_sementara.split(/-/);
         var group_kredit = fields[1];

            $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
            $('#biodata_notice').show();

        data.append('value',                      $("[name='debit_value']").val());
        data.append('urutan',                     urutan_k);
        data.append('group',                      group_kredit);
        data.append('id_mst_transaksi_item_from', $("[name='debit_akun']").val());

        $.ajax({
           cache : false,
           contentType : false,
           processData : false,
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_kredit/{id}" ?>',
           data : data,
           success: function (response) {
            // if(response=="OK"){
            a = response.split("|");
              if(a[0]=="OK"){
                if(a[1]!=null){
                  // counter_kredit = counter_kredit+1;

              var form_kredit = '<div id="kredit-'+a[1]+'" name="kredit-'+group_kredit+'">\
                                    <div class="row" >\
                                      <div class="col-md-12">\
                                        <div class="row">\
                                         <div class="row" style="margin: 5px">\
                                            <div class="col-md-8">\
                                              <input type="hidden" class="form-control" name="kredit_id_append" id="kredit_id_append">\
                                            </div>\
                                          </div>\
                                          <div class="col-md-8" style="padding-top:5px;">\
                                            <select id="kredit_akun_append-'+a[1]+'" name="kredit_akun_append" onchange="kredit_akun_appnd('+a[1]+')" type="text" class="form-control">\
                                              <?php foreach($akun as $a) : ?>\
                                                <?php
                                                  if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                    $id_mst_akun = $id_mst_akun;
                                                  }else{
                                                    $id_mst_akun = set_value('id_mst_akun');
                                                  }
                                                    $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                ?>\
                                                <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?></option>\
                                              <?php endforeach ?>\
                                            </select>\
                                          </div>\
                                          <div class="col-md-1">\
                                            <div class="parentDiv">\
                                              <a data-toggle="collapse" data-target="#kredit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                              </a>\
                                            </div>\
                                          </div>\
                                          <div class="col-md-2">\
                                            <a id="delete_kredit_append-'+a[1]+'" name="delete_kredit_append" onclick="delete_kredit_append('+a[1]+')" class="glyphicon glyphicon-trash">\
                                            </a>\
                                          </div>\
                                        </div>\
                                      </div>\
                                    </div>\
                                    <div class="collapse" id="kredit'+a[1]+'">\
                                      <div class="row">\
                                        <div class="col-sm-1">\
                                        </div>\
                                        <div class="col-sm-7">\
                                          <div class="row">\
                                            <div class="col-md-1">\
                                              <input type="checkbox" id="kredit_isi_otomatis_append-'+a[1]+'" name="kredit_isi_otomatis_append" value="1" <?php 
                                                if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                  $auto_fill = $auto_fill;
                                                }else{
                                                  $auto_fill = set_value('auto_fill');
                                                }
                                                if($auto_fill == 1) echo "checked";
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
                                              <select id="kredit_cmbx_nilai_append-'+a[1]+'" name="kredit_cmbx_nilai_append" type="text" class="form-control">\
                                                <?php foreach($nilai_debit[$row->group] as $nd) : ?>\
                                                    <?php
                                                      if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                        $id_mst_akun = $id_mst_akun;
                                                      }else{
                                                        $id_mst_akun = set_value('id_mst_akun');
                                                      }
                                                      $select = $nd->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                    ?>\
                                                    <option value="<?php echo $nd->id_mst_akun ?>" <?php echo $select ?>><?php echo $nd->uraian ?></option>\
                                                <?php endforeach ?>\
                                              </select>\
                                            </div>\
                                            <div class="col-md-2">\
                                                <input type="text" class="form-control" id="kredit_value_nilai_append-'+a[1]+'" name="kredit_value_nilai_append" value="<?php 
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
                                              <input type="checkbox" id="kredit_opsional_append-'+a[1]+'" name="kredit_opsional_append" value="1" <?php 
                                                if(set_value('opsional')=="" && isset($opsional)){
                                                $opsional = $opsional;
                                                  }else{
                                                $opsional = set_value('opsional');
                                                  }
                                                if($opsional == 1) echo "checked";
                                              ?>>\
                                            </div>\
                                            <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
                                          </div>\
                                        </div>\
                                      </div>\
                                    </div>\
                                </div>';

              $('#Kredit-'+group_kredit).append(form_kredit);
               urutan_k++;
               counter_kredit++;

               if (counter_kredit > 1) {
                  $("#add_debit-"+group_kredit).hide();
               }else{
                  $("#add_debit-"+group_kredit).show();
               }

              $('#kredit_id_append').val(a[1]);

              $("[name='kredit_isi_otomatis_append']").change(function(){
                var id_trans_item_sementara = this.id;
                var fields = id_trans_item_sementara.split(/-/);
                var id_mst_transaksi_item = fields[1];

                var data = new FormData();
                  data.append('auto_fill',  $("[name='kredit_isi_otomatis_append']:checked").val());
                  data.append('id_mst_transaksi_item',  id_mst_transaksi_item);
                  
                  $.ajax({
                      cache : false,
                      contentType : false,
                      processData : false,
                      type : 'POST',
                      url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
                      data : data,
                      success : function(response){
                        if(response=="OK"){
                            $("#kredit_isi_otomatis_append").prop("checked", true);
                            // alert("Success.");
                        }else{
                            $("#kredit_isi_otomatis_append").prop("checked", false);
                            // alert("Failed.");
                        }
                      }
                  });
              });

              $("[name='kredit_value_nilai_append']").change(function(){
                  var nilai_kredit = $(this).val();
                  var id_trans_item_sementara = this.id;
                  var fields = id_trans_item_sementara.split(/-/);
                  var id_mst_transaksi_item = fields[1];

                  $.ajax({
                     type: 'POST',
                     url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
                     data : 'id_mst_transaksi_item='+id_mst_transaksi_item+'&value='+nilai_kredit,
                     success: function (response) {
                      if(response=="OK"){
                          // alert("Success.");
                      }else{
                          // alert("Failed.");
                      }
                     }
                  });
              });

              $("[name='kredit_opsional_append']").change(function(){
                var id_trans_item_sementara = this.id;
                var fields = id_trans_item_sementara.split(/-/);
                var id_mst_transaksi_item = fields[1];
                
                var data = new FormData();
                  data.append('opsional',  $("[name='kredit_opsional_append']:checked").val());
                  data.append('id_mst_transaksi_item',  id_mst_transaksi_item);

                  $.ajax({
                      cache : false,
                      contentType : false,
                      processData : false,
                      type : 'POST',
                      url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
                      data : data,
                      success : function(response){
                        if(response=="OK"){
                            $("#kredit_opsional_append").prop("checked", true);
                        }else{
                            $("#kredit_opsional_append").prop("checked", false);
                        }
                      }
                  });
              });
              }else{
                alert("Kosong");
              };

            }else{
                alert("Failed.");
            }
           }
        });
      });

      function kredit_akun_appnd(id) {

        var kredit_akun_val    = $("#kredit_akun_append-"+id+"").val();
        var krefit_akun_select = $("#kredit_akun_append-"+id+">option:selected").text();

          $.ajax({
             type: 'POST',
             url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
             data : 'id_mst_akun='+kredit_akun_val+'&id_mst_transaksi_item='+id,
             success: function (response) {
              if(response=="OK"){
              }else{
                  alert("Failed.");
              }
             }
          });
      }

      function delete_kredit_append (data) {
        if (confirm("Anda yakin Akan menghapus Data Ini?")) {
            $.ajax({
             type: 'POST',
             url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete_kredit" ?>',
             data : 'id_mst_transaksi_item='+data,
             success: function (response) {
              if(response=="OK"){
                  $("#credit-"+data).remove();
                  counter_kredit--;
                  urutan_k--;
                  if (counter_kredit < 2) {
                    $("[name='add_debit']").show();
                  }else{
                    $("[name='add_debit']").hide();
                  }
              }else{
                alert("Failed.");
              };
             }
          });

        } else{

        };
      }
      
    <?php foreach($group as $g) : ?>
    counter_jurnal = "<?php echo $g->group+1 ?>";

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
            url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_pasangan_add/{id}" ?>',
            data : data,
            success : function(response){
              a = response.split("|");
              if(a[0]=="OK"){
                if(a[1]!=null){       //id debit
                  if(a[2]!=null){     //id kredit
                    if(a[3]!=null){   // group
                      if(a[4]!=null){ // value

              var form_jurnal_transaksi ='<div id="jt-'+counter_jurnal+'">\
                                            <div class="box box-primary">\
                                              <div class="box-header">\
                                                <h3 class="box-title">Jurnal Pasangan </h3>\
                                                <div class="pull-right">\
                                                <a id="delete_jt_append-'+counter_jurnal+'" name="delete_jt_append" onclick="delete_jt_append('+counter_jurnal+')" class="glyphicon glyphicon-trash"></a>\
                                                </div>\
                                              </div>\
                                              <div class="box-body">\
                                                <div class="row">\
                                                  <div id="Debit_jt-'+a[3]+'" class="col-sm-6">\
                                                    <div class="row">\
                                                      <div class="col-md-7" style="padding-top:5px;"><label> Debit </label> </div>\
                                                      <div class="col-md-1">\
                                                        <a class="glyphicon glyphicon-plus" id="add_debit_jt-'+counter_jurnal+'" name="add_debit_jt-'+counter_jurnal+'" onclick="add_debit_jt('+counter_jurnal+')" ></a>\
                                                      </div>\
                                                    </div>\
                                                    <div id="debt-'+a[1]+'" name="debt-'+a[3]+'">\
                                                      <div class="row">\
                                                        <div class="col-md-12">\
                                                          <div class="row">\
                                                            <div class="row" style="margin: 5px">\
                                                              <div class="col-md-8">\
                                                                <input type="hidden" class="form-control" name="debit_id_jt" id="debit_id_jt">\
                                                              </div>\
                                                            </div>\
                                                            <div class="col-md-8" style="padding-top:5px;">\
                                                             <select id="debit_akun_jt-'+a[1]+'" name="debit_akun_jt-'+a[3]+'" onchange="debit_akun_jt('+a[1]+','+a[3]+')" type="text" class="form-control">\
                                                                <?php foreach($akun as $a) : ?>\
                                                                  <?php
                                                                    if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                                      $id_mst_akun = $id_mst_akun;
                                                                    }else{
                                                                      $id_mst_akun = set_value('id_mst_akun');
                                                                    }
                                                                      $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                                  ?>
                                                                  <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?></option>\
                                                                  <?php endforeach ?>\
                                                              </select>\
                                                            </div>\
                                                            <div class="col-md-1">\
                                                              <div class="parentDiv">\
                                                                <a data-toggle="collapse" data-target="#debit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                                                </a>\
                                                              </div>\
                                                            </div>\
                                                            <div class="col-md-2">\
                                                              <a id="delete_debit_jt-'+a[1]+'" name="delete_debit_jt-'+a[3]+'" class="glyphicon glyphicon-trash">\
                                                              </a>\
                                                            </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                    <div class="collapse" id="debit'+a[1]+'">\
                                                      <div class="row">\
                                                        <div class="col-md-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" id="debit_isi_otomatis_jt-'+a[1]+'" name="debit_isi_otomatis_jt" value="1" <?php 
                                                                if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                                  $auto_fill = $auto_fill;
                                                                }else{
                                                                  $auto_fill = set_value('auto_fill');
                                                                }
                                                                if($auto_fill == 1) echo "checked";
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
                                                                <option value="Dari Nilai Kredit" echo "selected" ?> Dari Nilai Kredit</option>\
                                                              </select>\
                                                            </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                      <div class="row">\
                                                        <div class="col-md-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" id="debit_opsional_jt-'+a[1]+'" name="debit_opsional_jt" value="1" <?php 
                                                              if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                                  $auto_fill = $auto_fill;
                                                              }else{
                                                                  $auto_fill = set_value('auto_fill');
                                                              }
                                                                  if($auto_fill == 1) echo "checked";
                                                              ?>>\
                                                            </div>\
                                                            <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                </div>\
                                                <div id="Kredit_jt-'+a[3]+'" class="col-sm-6">\
                                                  <div class="row">\
                                                    <div class="col-md-8" style="padding-top:5px;"><label>Kredit</label></div>\
                                                    <div class="col-md-2">\
                                                      <a class="glyphicon glyphicon-plus" id="add_kredit_jt-'+counter_jurnal+'" name="add_kredit_jt-'+counter_jurnal+'" onclick="add_kredit_jt('+counter_jurnal+')">\
                                                      </a>\
                                                    </div>\
                                                  </div>\
                                                  <div id="kredit'+a[2]+'" name="kredit-'+a[3]+'">\
                                                    <div class="row" >\
                                                      <div class="col-md-12">\
                                                        <div class="row">\
                                                          <div class="row" style="margin: 5px">\
                                                            <div class="col-md-8">\
                                                              <input type="hidden" class="form-control" name="kredit_id_jt" id="kredit_id_jt">\
                                                            </div>\
                                                          </div>\
                                                          <div class="col-md-8" style="padding-top:5px;">\
                                                            <select id="kredit_akun_jt-'+a[2]+'" name="kredit_akun_jt-'+a[3]+'" onchange="kredit_akun_jt('+a[2]+','+a[3]+')" type="text" class="form-control">\
                                                              <?php foreach($akun as $a) : ?>\
                                                                <?php
                                                                  if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                                    $id_mst_akun = $id_mst_akun;
                                                                  }else{
                                                                    $id_mst_akun = set_value('id_mst_akun');
                                                                  }
                                                                    $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                                ?>\
                                                                <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?></option>\
                                                                <?php endforeach ?>\
                                                            </select>\
                                                          </div>\
                                                          <div class="col-md-1">\
                                                            <div class="parentDiv">\
                                                              <a data-toggle="collapse" data-target="#credit'+a[2]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                                              </a>\
                                                            </div>\
                                                          </div>\
                                                          <div class="col-md-2">\
                                                            <a id="delete_kredit_jt-'+a[2]+'" name="delete_kredit_jt-'+a[3]+'" class="glyphicon glyphicon-trash">\
                                                            </a>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                    <div class="collapse" id="credit'+a[2]+'">\
                                                      <div class="row">\
                                                        <div class="col-sm-1">\
                                                        </div>\
                                                        <div class="col-sm-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" id="kredit_isi_otomatis_jt-'+a[2]+'" name="kredit_isi_otomatis_jt" value="1" <?php 
                                                                if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                                  $auto_fill = $auto_fill;
                                                                }else{
                                                                  $auto_fill = set_value('auto_fill');
                                                                }
                                                                if($auto_fill == 1) echo "checked";
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
                                                              <select id="kredit_cmbx_nilai_jt-'+a[2]+'" name="kredit_cmbx_nilai_jt-'+a[3]+'" type="text" class="form-control">\
                                                                <?php foreach($nilai_debit[$row->group] as $nd) : ?>\
                                                                    <?php
                                                                      if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                                        $id_mst_akun = $id_mst_akun;
                                                                      }else{
                                                                        $id_mst_akun = set_value('id_mst_akun');
                                                                      }
                                                                      $select = $nd->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                                    ?>\
                                                                    <option value="<?php echo $nd->id_mst_akun ?>" <?php echo $select ?>><?php echo $nd->uraian ?></option>\
                                                                <?php endforeach ?>\
                                                              </select>\
                                                            </div>\
                                                            <div class="col-md-2">\
                                                                <input type="text" class="form-control" id="kredit_value_nilai_jt-'+a[2]+'" name="kredit_value_nilai_jt" value="'+a[4]+'">\
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
                                                              <input type="checkbox" id="kredit_opsional_jt-'+a[2]+'" name="kredit_opsional_jt" value="1" <?php 
                                                                if(set_value('opsional')=="" && isset($opsional)){
                                                                  $opsional = $opsional;
                                                                }else{
                                                                  $opsional = set_value('opsional');
                                                                }
                                                                  if($opsional == 1) echo "checked";
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

      $('#jurnal_transaksi').append(form_jurnal_transaksi);
      counter_jurnal++;
      <?php endforeach ?>

      $('#debit_id_jt').val(a[1]);
      $('#kredit_id_jt').val(a[2]);


      $("[name='debit_isi_otomatis_jt']").change(function(){
          var id_trans_item_sementara = this.id;
          var fields = id_trans_item_sementara.split(/-/);
          var id_mst_transaksi_item = fields[1];

          var data = new FormData();
          data.append('auto_fill',  $("[name='debit_isi_otomatis_jt']:checked").val());
          data.append('id_mst_transaksi_item',  id_mst_transaksi_item);
          
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#debit_isi_otomatis_jt").prop("checked", true);
                    // alert("Success.");
                }else{
                    $("#debit_isi_otomatis_jt").prop("checked", false);
                    // alert("Failed.");
                }
              }
          });
      });

      $("[name='kredit_isi_otomatis_jt']").change(function(){
        var id_trans_item_sementara = this.id;
        var fields = id_trans_item_sementara.split(/-/);
        var id_mst_transaksi_item = fields[1];

        var data = new FormData();
          data.append('auto_fill',  $("[name='kredit_isi_otomatis_jt']:checked").val());
          data.append('id_mst_transaksi_item',  id_mst_transaksi_item);
          
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#kredit_isi_otomatis_jt").prop("checked", true);
                    // alert("Success.");
                }else{
                    $("#kredit_isi_otomatis_jt").prop("checked", false);
                    // alert("Failed.");
                }
              }
          });
      });

      $("[name='kredit_value_nilai_jt']").change(function(){
          var nilai_kredit = $(this).val();
          var id_trans_item_sementara = this.id;
          var fields = id_trans_item_sementara.split(/-/);
          var id_mst_transaksi_item = fields[1];

          $.ajax({
             type: 'POST',
             url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
             data : 'id_mst_transaksi_item='+id_mst_transaksi_item+'&value='+nilai_kredit,
             success: function (response) {
              if(response=="OK"){
                  // alert("Success.");
              }else{
                  // alert("Failed.");
              }
             }
          });
      });

      $("[name='kredit_opsional_jt']").change(function(){
        var id_trans_item_sementara = this.id;
        var fields = id_trans_item_sementara.split(/-/);
        var id_mst_transaksi_item = fields[1];
        
        var data = new FormData();
          data.append('opsional',  $("[name='kredit_opsional_jt']:checked").val());
          data.append('id_mst_transaksi_item',  id_mst_transaksi_item);

          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#kredit_opsional_jt").prop("checked", true);
                }else{
                    $("#kredit_opsional_jt").prop("checked", false);
                }
              }
          });
      });

      $("[name='debit_opsional_jt']").change(function(){
        var id_trans_item_sementara = this.id;
        var fields = id_trans_item_sementara.split(/-/);
        var id_mst_transaksi_item = fields[1];
        
        var data = new FormData();
          data.append('opsional',  $("[name='debit_opsional_jt']:checked").val());
          data.append('id_mst_transaksi_item',  id_mst_transaksi_item);

          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#debit_opsional_jt").prop("checked", true);
                }else{
                    $("#debit_opsional_jt").prop("checked", false);
                }
              }
          });
      });


      // <?php foreach($urutan_debit as $u) : ?>
      // counter_debit = "<?php echo $u->urutan+1 ?>";
      // <?php endforeach ?>

      // group_debit   = "<?php echo $g->group+1 ?>";

      // $("[name='add_debit_jt']").click(function() {
      //    var data = new FormData();
      //       $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
      //       $('#biodata_notice').show();

      //       data.append('value',      $("[name='debit_value']").val());
      //       data.append('urutan',     counter_debit);
      //       data.append('group',      group_debit);

      //   $.ajax({
      //      cache : false,
      //      contentType : false,
      //      processData : false,
      //      type: 'POST',
      //      url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_debit/{id}" ?>',
      //      data : data,
      //      success: function (response) {
      //       a = response.split("|");
      //         if(a[0]=="OK"){
      //           if(a[1]!=null){

      //     var form_debit = '<div id="debt-'+a[1]+'">\
      //                         <div class="row">\
      //                           <div class="col-md-12">\
      //                             <div class="row">\
      //                               <div class="row" style="margin: 5px">\
      //                                 <div class="col-md-8">\
      //                                   <input type="hidden" class="form-control" name="debit_id_jt_append" id="debit_id_jt_append">\
      //                                 </div>\
      //                               </div>\
      //                               <div class="col-md-8" style="padding-top:5px;">\
      //                                 <select id="debit_akun_jt_append-'+a[1]+'" name="debit_akun_jt_append" class="form-control" type="text">\
      //                                   <?php foreach($akun as $a) : ?>\
      //                                     <?php
      //                                       if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
      //                                         $id_mst_akun = $id_mst_akun;
      //                                       }else{
      //                                         $id_mst_akun = set_value('id_mst_akun');
      //                                       }
      //                                         $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
      //                                     ?>\
      //                                     <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?>\
      //                                     </option>\
      //                                     <?php endforeach ?>\
      //                                 </select>\
      //                               </div>\
      //                               <div class="col-md-1">\
      //                                 <div class="parentDiv">\
      //                                   <a data-toggle="collapse" data-target="#debit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
      //                                   </a>\
      //                                 </div>\
      //                               </div>\
      //                               <div class="col-md-2">\
      //                                 <a id="delete_debit_jt_append-'+a[1]+'" name="delete_debit_jt_append-'+a[3]+'" onclick="delete_debit_jt_append('+a[1]+','+a[3]+')" class="glyphicon glyphicon-trash">\
      //                                 </a>\
      //                               </div>\
      //                         </div>\
      //                       </div>\
      //                     </div>\
      //                     <div class="collapse" id="debit'+a[1]+'">\
      //                       <div class="row">\
      //                         <div class="col-md-7">\
      //                           <div class="row">\
      //                             <div class="col-md-1">\
      //                              <input type="checkbox" id="debit_isi_otomatis_jt_append-'+a[1]+'" name="debit_isi_otomatis_jt_append" value="1" <?php 
      //                                 if(set_value('auto_fill')=="" && isset($auto_fill)){
      //                                     $auto_fill = $auto_fill;
      //                                 }else{
      //                                     $auto_fill = set_value('auto_fill');
      //                                 }
      //                                     if($auto_fill == 1) echo "checked";
      //                               ?>>\
      //                             </div>\
      //                             <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label></div>\
      //                           </div>\
      //                         </div>\
      //                       </div>\
      //                       <div class="row">\
      //                       <div class="col-sm-1"></div>\
      //                         <div class="col-sm-10">\
      //                           <div class="row">\
      //                             <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>\
      //                             <div class="col-md-7">\
      //                               <select  name="debit_cmbx_nilai" type="text" class="form-control">\
      //                                 <?php foreach($kategori as $k) : ?>\
      //                                     <?php
      //                                       if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
      //                                         $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
      //                                       }else{
      //                                         $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
      //                                       }
      //                                       $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
      //                                     ?>\
      //                                     <option value="<?php echo $k->id_mst_kategori_transaksi ?>"\
      //                                      <?php echo $select ?>><?php echo $k->nama ?>\
      //                                     </option>\
      //                                 <?php endforeach ?>\
      //                               </select>\
      //                             </div>\
      //                              <p id="d_value_nilai"></p>\
      //                           </div>\
      //                         </div>\
      //                       </div>\
      //                         <div class="row">\
      //                           <div class="col-md-7">\
      //                             <div class="row">\
      //                               <div class="col-md-1">\
      //                                 <input type="checkbox" id="debit_opsional_jt_append-'+a[1]+'" name="debit_opsional_jt_append" value="1" <?php 
      //                                 if(set_value('auto_fill')=="" && isset($auto_fill)){
      //                                     $auto_fill = $auto_fill;
      //                                 }else{
      //                                     $auto_fill = set_value('auto_fill');
      //                                 }
      //                                     if($auto_fill == 1) echo "checked";
      //                               ?>>\
      //                               </div>\
      //                               <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label></div>\
      //                             </div>\
      //                           </div>\
      //                         </div>\
      //                       </div>';

      //           $('#Debit_jt').append(form_debit);
      //           counter_debit++;

      //           if (counter_debit > 1) {
      //             $("[name=add_kredit_jt]").hide();
      //           }else{
      //             $("[name=add_kredit_jt]").show();
      //           };

      //           $('#debit_id_jt_append').val(a[1]);

      //           $("select[name='debit_akun_jt_append']").change(function(){
      //               var id_mst_akun_debit = $(this).val();
      //               var id_trans_item_sementara = this.id;
      //               var fields = id_trans_item_sementara.split(/-/);
      //               var id_mst_transaksi_item_debit = fields[1];

      //               var data = new FormData();

      //               data.append('id_mst_akun', id_mst_akun_debit);
      //               data.append('id_mst_transaksi_item',id_mst_transaksi_item_debit );

      //               $.ajax({
      //                  type: 'POST',
      //                  url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
      //                  data : 'id_mst_akun='+id_mst_akun_debit+'&id_mst_transaksi_item='+id_mst_transaksi_item_debit,
      //                  success: function (response) {
      //                   if(response=="OK"){
      //                       // alert("Success.");
      //                   }else{
      //                       // alert("Failed.");
      //                   }
      //                  }
      //               });
      //           });

      //         $("[name='debit_isi_otomatis_jt_append']").change(function(){
      //           var id_trans_item_sementara = this.id;
      //           var fields = id_trans_item_sementara.split(/-/);
      //           var id_mst_transaksi_item = fields[1];

      //           var data = new FormData();
      //             data.append('auto_fill',  $("[name='debit_isi_otomatis_jt_append']:checked").val());
      //             data.append('id_mst_transaksi_item',  id_mst_transaksi_item);
                  
      //             $.ajax({
      //                 cache : false,
      //                 contentType : false,
      //                 processData : false,
      //                 type : 'POST',
      //                 url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
      //                 data : data,
      //                 success : function(response){
      //                   if(response=="OK"){
      //                       $("#debit_isi_otomatis_jt_append").prop("checked", true);
      //                       // alert("Success.");
      //                   }else{
      //                       $("#debit_isi_otomatis_jt_append").prop("checked", false);
      //                       // alert("Failed.");
      //                   }
      //                 }
      //             });
      //         });

      //         $("[name='debit_opsional_jt_append']").change(function(){
      //           var id_trans_item_sementara = this.id;
      //           var fields = id_trans_item_sementara.split(/-/);
      //           var id_mst_transaksi_item = fields[1];
                
      //           var data = new FormData();
      //             data.append('opsional',  $("[name='debit_opsional_jt_append']:checked").val());
      //             data.append('id_mst_transaksi_item',  id_mst_transaksi_item);

      //             $.ajax({
      //                 cache : false,
      //                 contentType : false,
      //                 processData : false,
      //                 type : 'POST',
      //                 url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
      //                 data : data,
      //                 success : function(response){
      //                   if(response=="OK"){
      //                       $("#debit_opsional_jt_append").prop("checked", true);
      //                   }else{
      //                       $("#debit_opsional_jt_append").prop("checked", false);
      //                   }
      //                 }
      //             });
      //         });

      //           }else{
      //             alert("Kosong");
      //           };

      //       }else{
      //           alert("Failed.");
      //       }
      //      }
      //   });
      // });

      // <?php foreach($urutan_kredit as $u) : ?>
      // urutan_kredit_jt = "<?php echo $u->urutan+1 ?>";
      // <?php endforeach ?>

      // group_kredit   = "<?php echo $g->group+1 ?>";
      // counter_kredit = 1;


      // // $("[name='add_kredit_jt']").click(function() {
      // //    var data = new FormData();
      // //     $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
      // //     $('#biodata_notice').show();

      // //     data.append('value',            $("[name='kredit_value']").val());
      // //     data.append('urutan',           urutan_kredit_jt);
      // //     data.append('group',            group_kredit);

      // //   $.ajax({
      // //      cache : false,
      // //      contentType : false,
      // //      processData : false,
      // //      type: 'POST',
      // //      url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_kredit/{id}" ?>',
      // //      data : data,
      // //      success: function (response) {
      // //       a = response.split("|");
      // //         if(a[0]=="OK"){
      // //           if(a[1]!=null){
      // //             if(a[2]!=null){

      // //         var form_kredit = '<div id="credit-'+a[1]+'">\
      // //                               <div class="row" >\
      // //                                 <div class="col-md-12">\
      // //                                   <div class="row">\
      // //                                    <div class="row" style="margin: 5px">\
      // //                                       <div class="col-md-8">\
      // //                                         <input type="hidden" class="form-control" name="kredit_id_jt_append" id="kredit_id_jt_append">\
      // //                                       </div>\
      // //                                     </div>\
      // //                                     <div class="col-md-8" style="padding-top:5px;">\
      // //                                       <select id="kredit_akun_jt_append-'+a[1]+'" name="kredit_akun_jt_append" type="text" class="form-control">\
      // //                                         <?php foreach($akun as $a) : ?>\
      // //                                           <?php
      // //                                             if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
      // //                                               $id_mst_akun = $id_mst_akun;
      // //                                             }else{
      // //                                               $id_mst_akun = set_value('id_mst_akun');
      // //                                             }
      // //                                               $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
      // //                                           ?>\
      // //                                           <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?>\
      // //                                            </option>\
      // //                                           <?php endforeach ?>\
      // //                                       </select>\
      // //                                     </div>\
      // //                                     <div class="col-md-1">\
      // //                                       <div class="parentDiv">\
      // //                                         <a data-toggle="collapse" data-target="#kredit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
      // //                                         </a>\
      // //                                       </div>\
      // //                                     </div>\
      // //                                     <div class="col-md-2">\
      // //                                       <a id="delete_kredit_jt_append-'+a[1]+'" name="delete_kredit_jt_append" onclick="delete_kredit_jt_append('+a[1]+','+a[3]+')" class="glyphicon glyphicon-trash">\
      // //                                       </a>\
      // //                                     </div>\
      // //                                   </div>\
      // //                                 </div>\
      // //                               </div>\
      // //                               <div class="collapse" id="kredit'+a[1]+'">\
      // //                                 <div class="row">\
      // //                                   <div class="col-sm-1">\
      // //                                   </div>\
      // //                                   <div class="col-sm-7">\
      // //                                     <div class="row">\
      // //                                       <div class="col-md-1">\
      // //                                         <input type="checkbox" id="kredit_isi_otomatis_jt_append-'+a[1]+'" name="kredit_isi_otomatis_jt_append" value="1" <?php 
      // //                                           if(set_value('auto_fill')=="" && isset($auto_fill)){
      // //                                             $auto_fill = $auto_fill;
      // //                                           }else{
      // //                                             $auto_fill = set_value('auto_fill');
      // //                                           }
      // //                                           if($auto_fill == 1) echo "checked";
      // //                                         ?>>\
      // //                                       </div>\
      // //                                       <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>\
      // //                                     </div>\
      // //                                   </div>\
      // //                                 </div>\
      // //                                 <div class="row">\
      // //                                   <div class="col-sm-1">\
      // //                                   </div>\
      // //                                   <div class="col-sm-1">\
      // //                                   </div>\
      // //                                   <div class="col-sm-10">\
      // //                                     <div class="row">\
      // //                                       <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>\
      // //                                       <div class="col-md-7">\
      // //                                         <select  name="kredit_cmbx_nilai_jt_append" type="text" class="form-control">\
      // //                                           <?php foreach($kategori as $k) : ?>\
      // //                                               <?php
      // //                                                 if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
      // //                                                   $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
      // //                                                 }else{
      // //                                                   $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
      // //                                                 }
      // //                                                 $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
      // //                                               ?>\
      // //                                               <option value="<?php echo $k->id_mst_kategori_transaksi ?>"\
      // //                                                <?php echo $select ?>><?php echo $k->nama ?>\
      // //                                               </option>\
      // //                                           <?php endforeach ?>\
      // //                                         </select>\
      // //                                       </div>\
      // //                                       <div class="col-md-2">\
      // //                                           <input type="text" class="form-control" id="kredit_value_nilai_jt_append-'+a[1]+'" name="kredit_value_nilai_jt_append" value="<?php 
      // //                                           if(set_value('value')=="" && isset($value)){
      // //                                             echo $value;
      // //                                           }else{
      // //                                             echo  set_value('value');
      // //                                           }
      // //                                           ?>">\
      // //                                       </div>\
      // //                                       <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>\
      // //                                     </div>\
      // //                                   </div>\
      // //                                 </div>\
      // //                                 <div class="row">\
      // //                                   <div class="col-sm-1">\
      // //                                   </div>\
      // //                                   <div class="col-sm-7">\
      // //                                     <div class="row">\
      // //                                       <div class="col-md-1">\
      // //                                         <input type="checkbox" id="kredit_opsional_jt_append-'+a[1]+'" name="kredit_opsional_jt_append" value="1" <?php 
      // //                                           if(set_value('opsional')=="" && isset($opsional)){
      // //                                           $opsional = $opsional;
      // //                                             }else{
      // //                                           $opsional = set_value('opsional');
      // //                                             }
      // //                                           if($opsional == 1) echo "checked";
      // //                                         ?>>\
      // //                                       </div>\
      // //                                       <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
      // //                                     </div>\
      // //                                   </div>\
      // //                                 </div>\
      // //                               </div>\
      // //                           </div>';

      // //         $('#Kredit_jt').append(form_kredit);
      // //          counter_kredit++;
      // //          urutan_kredit_jt++;

      // //          alert(counter_kredit);
      // //          // var counter = 
      // //          // var count = $("[name='kredit-"+group+"']").length;

      // //          if (counter_kredit > 1) {
      // //             $("[name=add_debit_jt]").hide();
      // //          }else{
      // //             $("[name=add_debit_jt]").show();
      // //          }

      // //         $('#kredit_id_jt_append').val(a[1]);

      // //         $("[name='kredit_isi_otomatis_jt_append']").change(function(){
      // //           var id_trans_item_sementara = this.id;
      // //           var fields = id_trans_item_sementara.split(/-/);
      // //           var id_mst_transaksi_item = fields[1];

      // //           var data = new FormData();
      // //             data.append('auto_fill',  $("[name='kredit_isi_otomatis_jt_append']:checked").val());
      // //             data.append('id_mst_transaksi_item',  id_mst_transaksi_item);
                  
      // //             $.ajax({
      // //                 cache : false,
      // //                 contentType : false,
      // //                 processData : false,
      // //                 type : 'POST',
      // //                 url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
      // //                 data : data,
      // //                 success : function(response){
      // //                   if(response=="OK"){
      // //                       $("#kredit_isi_otomatis_jt_append").prop("checked", true);
      // //                       // alert("Success.");
      // //                   }else{
      // //                       $("#kredit_isi_otomatis_jt_append").prop("checked", false);
      // //                       // alert("Failed.");
      // //                   }
      // //                 }
      // //             });
      // //         });

      // //         $("[name='kredit_value_nilai_jt_append']").change(function(){
      // //             var nilai_kredit = $(this).val();
      // //             var id_trans_item_sementara = this.id;
      // //             var fields = id_trans_item_sementara.split(/-/);
      // //             var id_mst_transaksi_item = fields[1];

      // //             $.ajax({
      // //                type: 'POST',
      // //                url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
      // //                data : 'id_mst_transaksi_item='+id_mst_transaksi_item+'&value='+nilai_kredit,
      // //                success: function (response) {
      // //                 if(response=="OK"){
      // //                     // alert("Success.");
      // //                 }else{
      // //                     // alert("Failed.");
      // //                 }
      // //                }
      // //             });
      // //         });

      // //         $("[name='kredit_opsional_jt_append']").change(function(){
      // //           var id_trans_item_sementara = this.id;
      // //           var fields = id_trans_item_sementara.split(/-/);
      // //           var id_mst_transaksi_item = fields[1];
                
      // //           var data = new FormData();
      // //             data.append('opsional',  $("[name='kredit_opsional_jt_append']:checked").val());
      // //             data.append('id_mst_transaksi_item',  id_mst_transaksi_item);

      // //             $.ajax({
      // //                 cache : false,
      // //                 contentType : false,
      // //                 processData : false,
      // //                 type : 'POST',
      // //                 url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
      // //                 data : data,
      // //                 success : function(response){
      // //                   if(response=="OK"){
      // //                       $("#kredit_opsional_jt_append").prop("checked", true);
      // //                   }else{
      // //                       $("#kredit_opsional_jt_append").prop("checked", false);
      // //                   }
      // //                 }
      // //             });
      // //         });
      // //               }else{
      // //                 alert("Kosong");
      // //               };

      // //           }else{
      // //             alert("Kosong");
      // //           };

      // //       }else{
      // //           alert("Failed.");
      // //       }
      // //      }
      // //   });
      // // });
                          }else{
                            alert("Kosong");
                          };

                      }else{
                        alert("Kosong");
                      };

                  }else{
                    alert("Kosong");
                  };

              }else{
                alert("Kosong");
              };

          }else{
            alert("Failed.");
          }
        }
    });
        return false;
    });

    function delete_jt_append(data) {
      if (confirm("Anda yakin Akan menghapus Data Ini?")) {
          $.ajax({
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete" ?>',
           data : 'group='+data,
           success: function (response) {
            if(response=="OK"){
                $("#jt-"+data).remove();
                counter_jurnal--;
            }else{
              alert("Failed.");
            };
           }
        });

      } else{

      };
    }

    function delete_debit_jt_append (id,group) {
      if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
          $.ajax({
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete_debit" ?>',
           data : 'id_mst_transaksi_item='+id,
           success: function (response) {
            if(response=="OK"){
                $("#debt-"+id).remove();
                var count = $("[name='debt-"+group+"']").length;

                if (count<2) {
                    $('#add_kredit_jt-'+group+'').show();
                } else{
                    $('#add_kredit_jt-'+group+'').hide();
                };
            }else{
              alert("Failed.");
            };
           }
        });

      } else{

      };
    }

    function delete_kredit_jt_append (id,group) {
      if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
          $.ajax({
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete_kredit" ?>',
           data : 'id_mst_transaksi_item='+id,
           success: function (response) {
            if(response=="OK"){
                
                $("#kredit-"+id).remove();
                var count = $("[name='kredit-"+group+"']").length;

                if (count<2) {
                    $('#add_debit_jt-'+group+'').show();
                } else{
                    $('#add_debit_jt-'+group+'').hide();
                };
            }else{
              alert("Failed.");
            };
           }
        });

      } else{

      };
    }

      //     function delete_kredit (id,group) {
      //   if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
      //       $.ajax({
      //        type: 'POST',
      //        url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete_kredit" ?>',
      //        data : 'id_mst_transaksi_item='+id,
      //        success: function (response) {
      //         if(response=="OK"){
      //             $("#kredit-"+id).remove();
      //             var count = $("[name='kredit-"+group+"']").length;
      //             if (count < 2) {
      //               // $("[name='add_kredit']").show();
      //               $('#add_debit-'+group+'').show();
      //             }else{
      //               // $("[name='add_kredit']").hide();
      //               $('#add_debit-'+group+'').hide();
      //             };
      //         }else{
      //           alert("Failed.");
      //         };
      //        }
      //     });

      //   } else{

      //   };
      // }


  function debit_akun(id,group) {

      var debit_akun_val    = $("#debit_akun-"+id+"").val();
      var debit_akun_select = $("#debit_akun-"+id+">option:selected").text();

      $("[name='kredit_cmbx_nilai-"+group+"']").each(function(){
        var id_kredit_sementara = this.id;
        var fields = id_kredit_sementara.split(/-/);
        var id_kredit_cmbx = fields[1];

        $.ajax({
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
           data : 'id_mst_akun='+debit_akun_val+'&id_mst_transaksi_item='+id+'&id_mst_transaksi_item_from='+debit_akun_val+'&id_mst_transaksi_item_kredit='+id_kredit_cmbx,
           success: function (response) {
            if(response=="OK"){
              $("[name='kredit_cmbx_nilai-"+group+"']>").val(debit_akun_val).text(debit_akun_select);
            }else{
                alert("Failed.");
            }
           }
        });
      });
    }

    function debit_akun_jt(id,group) {

      var debit_akun_jt_val    = $("#debit_akun_jt-"+id+"").val();
      var debit_akun_jt_select = $("#debit_akun_jt-"+id+">option:selected").text();

      $("[name='kredit_cmbx_nilai_jt-"+group+"']").each(function(){
        var id_kredit_sementara = this.id;
        var fields = id_kredit_sementara.split(/-/);
        var id_kredit_cmbx = fields[1];

        $.ajax({
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
           data : 'id_mst_akun='+debit_akun_jt_val+'&id_mst_transaksi_item='+id+'&id_mst_transaksi_item_from='+debit_akun_jt_val+'&id_mst_transaksi_item_kredit='+id_kredit_cmbx,
           success: function (response) {
            if(response=="OK"){
              $("[name='kredit_cmbx_nilai_jt-"+group+"']>").val(debit_akun_jt_val).text(debit_akun_jt_select);
            }else{
                alert("Failed.");
            }
           }
        });
      });
    }

    function kredit_akun_jt(id,group) {

      var kredit_akun_jt_val    = $("#kredit_akun_jt-"+id+"").val();
      var kredit_akun_jt_select = $("#kredit_akun_jt-"+id+">option:selected").text();

        $.ajax({
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
           data : 'id_mst_akun='+kredit_akun_jt_val+'&id_mst_transaksi_item='+id,
           success: function (response) {
            if(response=="OK"){
            }else{
                alert("Failed.");
            }
           }
        });
    }

      <?php foreach($urutan_kredit as $u) : ?>
      urutan_kredit_jt = "<?php echo $u->urutan+1 ?>";
      <?php endforeach ?>

      group_kredit   = "<?php echo $g->group+1 ?>";

    function add_kredit_jt(group) {

        var data = new FormData();
          $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
          $('#biodata_notice').show();

          data.append('value',            $("[name='kredit_value']").val());
          data.append('urutan',           urutan_kredit_jt);
          data.append('group',            group);

        $.ajax({
           cache : false,
           contentType : false,
           processData : false,
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_kredit/{id}" ?>',
           data : data,
           success: function (response) {
            a = response.split("|");
              if(a[0]=="OK"){
                if(a[1]!=null){
                  if(a[2]!=null){

                      var form_kredit = '<div id="kredit-'+a[1]+'" name="kredit-'+group+'" >\
                                    <div class="row" >\
                                      <div class="col-md-12">\
                                        <div class="row">\
                                         <div class="row" style="margin: 5px">\
                                            <div class="col-md-8">\
                                              <input type="hidden" class="form-control" name="kredit_id_jt_append" id="kredit_id_jt_append">\
                                            </div>\
                                          </div>\
                                          <div class="col-md-8" style="padding-top:5px;">\
                                            <select id="kredit_akun_jt_append-'+a[1]+'" name="kredit_akun_jt_append-'+group+'" onchange="kredit_akun_jt_append('+a[1]+')" type="text" class="form-control">\
                                              <?php foreach($akun as $a) : ?>\
                                                <?php
                                                  if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                    $id_mst_akun = $id_mst_akun;
                                                  }else{
                                                    $id_mst_akun = set_value('id_mst_akun');
                                                  }
                                                    $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                ?>\
                                                <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?>\
                                                 </option>\
                                                <?php endforeach ?>\
                                            </select>\
                                          </div>\
                                          <div class="col-md-1">\
                                            <div class="parentDiv">\
                                              <a data-toggle="collapse" data-target="#kredit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                              </a>\
                                            </div>\
                                          </div>\
                                          <div class="col-md-2">\
                                            <a id="delete_kredit_jt_append-'+a[1]+'" name="delete_kredit_jt_append-'+group+'" onclick="delete_kredit_jt_append('+a[1]+','+group+')" class="glyphicon glyphicon-trash">\
                                            </a>\
                                          </div>\
                                        </div>\
                                      </div>\
                                    </div>\
                                    <div class="collapse" id="kredit'+a[1]+'">\
                                      <div class="row">\
                                        <div class="col-sm-1">\
                                        </div>\
                                        <div class="col-sm-7">\
                                          <div class="row">\
                                            <div class="col-md-1">\
                                              <input type="checkbox" id="kredit_isi_otomatis_jt_append-'+a[1]+'" name="kredit_isi_otomatis_jt_append" onclick="k_isi_otomatis_jt_append('+a[1]+',this);" value="1" <?php 
                                                if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                  $auto_fill = $auto_fill;
                                                }else{
                                                  $auto_fill = set_value('auto_fill');
                                                }
                                                if($auto_fill == 1) echo "checked";
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
                                              <select  name="kredit_cmbx_nilai_jt_append" type="text" class="form-control">\
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
                                                <input type="text" class="form-control" id="kredit_value_nilai_jt_append-'+a[1]+'" name="kredit_value_nilai_jt_append'+group+'" onchange="kredit_value_nilai_jt_append('+a[1]+')" value="<?php 
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
                                              <input type="checkbox" id="kredit_opsional_jt_append-'+a[1]+'" name="kredit_opsional_jt_append" onclick="k_opsional_jt_append('+a[1]+',this);" value="1" <?php 
                                                if(set_value('opsional')=="" && isset($opsional)){
                                                $opsional = $opsional;
                                                  }else{
                                                $opsional = set_value('opsional');
                                                  }
                                                if($opsional == 1) echo "checked";
                                              ?>>\
                                            </div>\
                                            <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
                                          </div>\
                                        </div>\
                                      </div>\
                                    </div>\
                                </div>';

                 $('#Kredit_jt-'+group).append(form_kredit);
                 urutan_kredit_jt++;

                 var count = $("[name='kredit-"+group+"']").length;

                 if (count > 1) {
                    $("[name='add_debit_jt-"+group+"']").hide();
                 }else{
                    $("[name='add_debit_jt-"+group+"']").show();
                 }

                  }else{
                      alert("Kosong");
                    };

                }else{
                  alert("Kosong");
                };

            }else{
                alert("Failed.");
            }
           }
        });
    }

      <?php foreach($urutan_debit as $u) : ?>
        urutan_debit_jt = "<?php echo $u->urutan+1 ?>";
      <?php endforeach ?>

    function add_debit_jt(group){

          var data = new FormData();
          $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
          $('#biodata_notice').show();

          data.append('value',      $("[name='debit_value']").val());
          data.append('urutan',     urutan_debit_jt);
          data.append('group',      group);

          $.ajax({
           cache : false,
           contentType : false,
           processData : false,
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_debit/{id}" ?>',
           data : data,
           success: function (response) {
            a = response.split("|");
              if(a[0]=="OK"){
                if(a[1]!=null){
                  if(a[2]!=null){

            var form_debit = '<div id="debt-'+a[1]+'" name="debt-'+a[2]+'">\
                          <div class="row">\
                            <div class="col-md-12">\
                              <div class="row">\
                                <div class="row" style="margin: 5px">\
                                  <div class="col-md-8">\
                                    <input type="hidden" class="form-control" name="debit_id_jt_append" id="debit_id_jt_append">\
                                  </div>\
                                </div>\
                                <div class="col-md-8" style="padding-top:5px;">\
                                  <select id="debit_akun_jt_append-'+a[1]+'" name="debit_akun_jt_append-'+a[2]+'" onchange="debit_akun_jt_append('+a[1]+')" class="form-control" type="text">\
                                    <?php foreach($akun as $a) : ?>\
                                      <?php
                                        if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                          $id_mst_akun = $id_mst_akun;
                                        }else{
                                          $id_mst_akun = set_value('id_mst_akun');
                                        }
                                          $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                      ?>\
                                      <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?>\
                                      </option>\
                                      <?php endforeach ?>\
                                  </select>\
                                </div>\
                                <div class="col-md-1">\
                                  <div class="parentDiv">\
                                    <a data-toggle="collapse" data-target="#debit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                    </a>\
                                  </div>\
                                </div>\
                                <div class="col-md-2">\
                                  <a id="delete_debit_jt_append-'+a[1]+'" name="delete_debit_jt_append-'+a[2]+'" onclick="delete_debit_jt_append('+a[1]+','+a[2]+')" class="glyphicon glyphicon-trash">\
                                  </a>\
                                </div>\
                          </div>\
                        </div>\
                      </div>\
                      <div class="collapse" id="debit'+a[1]+'">\
                        <div class="row">\
                          <div class="col-md-7">\
                            <div class="row">\
                              <div class="col-md-1">\
                               <input type="checkbox" id="debit_isi_otomatis_jt_append-'+a[1]+'" name="debit_isi_otomatis_jt_append-'+a[2]+'" onclick="d_isi_otomatis_jt_append('+a[1]+',this)" value="1" <?php 
                                  if(set_value('auto_fill')=="" && isset($auto_fill)){
                                      $auto_fill = $auto_fill;
                                  }else{
                                      $auto_fill = set_value('auto_fill');
                                  }
                                      if($auto_fill == 1) echo "checked";
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
                                  <input type="checkbox" id="debit_opsional_jt_append-'+a[1]+'" name="debit_opsional_jt_append" onclick="d_opsional_jt_append('+a[1]+',this)" value="1" <?php 
                                  if(set_value('auto_fill')=="" && isset($auto_fill)){
                                      $auto_fill = $auto_fill;
                                  }else{
                                      $auto_fill = set_value('auto_fill');
                                  }
                                      if($auto_fill == 1) echo "checked";
                                ?>>\
                                </div>\
                                <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label></div>\
                              </div>\
                            </div>\
                          </div>\
                        </div>';

                $('#Debit_jt-'+group).append(form_debit);
                urutan_debit_jt++;

                var count = $("[name='debt-"+group+"']").length;

                 if (count > 1) {
                    $("[name='add_kredit_jt-"+group+"']").hide();
                 }else{
                    $("[name='add_kredit_jt-"+group+"']").show();
                 };

                  }else{
                      alert("Kosong");
                    };

                }else{
                  alert("Kosong");
                };

            }else{
                alert("Failed.");
            }
           }
        });
    }

    function kredit_akun_jt_append(id) {

      var kredit_akun_jt_append_val    = $("#kredit_akun_jt_append-"+id+"").val();
      var kredit_akun_jt_append_select = $("#kredit_akun_jt_append-"+id+">option:selected").text();

        $.ajax({
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
           data : 'id_mst_akun='+kredit_akun_jt_append_val+'&id_mst_transaksi_item='+id,
           success: function (response) {
            if(response=="OK"){
            }else{
                alert("Failed.");
            }
           }
        });
    }

    function debit_akun_jt_append(id) {

      var debit_akun_jt_append_val    = $("#debit_akun_jt_append-"+id+"").val();
      var debit_akun_jt_append_select = $("#debit_akun_jt_append-"+id+">option:selected").text();

        $.ajax({
           type: 'POST',
           url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
           data : 'id_mst_akun='+debit_akun_jt_append_val+'&id_mst_transaksi_item='+id,
           success: function (response) {
            if(response=="OK"){
            }else{
                alert("Failed.");
            }
           }
        });
    }

    function k_isi_otomatis_jt_append(id,obj) {

      if (obj.checked) {

        var data = new FormData();
          data.append('auto_fill', 1);
          data.append('id_mst_transaksi_item',  id);
          
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#kredit_isi_otomatis_jt_append").prop("checked", true);
                }else{
                    $("#kredit_isi_otomatis_jt_append").prop("checked", false);
                }
              }
          });

      } else{

        var data = new FormData();
          data.append('auto_fill', 0);
          data.append('id_mst_transaksi_item',  id);
          
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#kredit_isi_otomatis_jt_append").prop("checked", true);
                }else{
                    $("#kredit_isi_otomatis_jt_append").prop("checked", false);
                }
              }
          });
      };

    }

     function d_isi_otomatis_jt_append(id,obj) {

      if (obj.checked) {

        var data = new FormData();
          data.append('auto_fill', 1);
          data.append('id_mst_transaksi_item',  id);
          
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#debit_isi_otomatis_jt_append").prop("checked", true);
                }else{
                    $("#debit_isi_otomatis_jt_append").prop("checked", false);
                }
              }
          });

      } else{

        var data = new FormData();
          data.append('auto_fill', 0);
          data.append('id_mst_transaksi_item',  id);
          
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#debit_isi_otomatis_jt_append").prop("checked", true);
                }else{
                    $("#debit_isi_otomatis_jt_append").prop("checked", false);
                }
              }
        });
      };
    }

    function d_opsional_jt_append(id,obj) {

      if (obj.checked) {

        var data = new FormData();
          data.append('opsional',1);
          data.append('id_mst_transaksi_item',id);

          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#debit_opsional_jt_append").prop("checked", true);
                }else{
                    $("#debit_opsional_jt_append").prop("checked", false);
                }
              }
          });

      } else{

        var data = new FormData();
          data.append('opsional',0);
          data.append('id_mst_transaksi_item',id);

          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#debit_opsional_jt_append").prop("checked", true);
                }else{
                    $("#debit_opsional_jt_append").prop("checked", false);
                }
              }
          });
      };
    }

        function k_opsional_jt_append(id,obj) {

      if (obj.checked) {

        var data = new FormData();
          data.append('opsional',1);
          data.append('id_mst_transaksi_item',id);

          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#kredit_opsional_jt_append").prop("checked", true);
                }else{
                    $("#kredit_opsional_jt_append").prop("checked", false);
                }
              }
          });

      } else{

        var data = new FormData();
          data.append('opsional',0);
          data.append('id_mst_transaksi_item',id);

          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
              data : data,
              success : function(response){
                if(response=="OK"){
                    $("#kredit_opsional_jt_append").prop("checked", true);
                }else{
                    $("#kredit_opsional_jt_append").prop("checked", false);
                }
              }
          });
      };
    }

    function kredit_value_nilai_jt_append(id) {

      var nilai = $("#kredit_value_nilai_jt_append-"+id+"").val();

      $.ajax({
         type: 'POST',
         url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
         data : 'id_mst_transaksi_item='+id+'&value='+nilai,
         success: function (response) {
          if(response=="OK"){
              // alert("Success.");
          }else{
              // alert("Failed.");
          }
         }
      });
    }


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

</script>

