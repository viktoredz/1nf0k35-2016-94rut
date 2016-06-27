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
          <button type="button" name="btn_kategori_transaksi_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
          <button type="reset" value="Reset" class="btn btn-success"><i class='fa fa-refresh'></i> &nbsp; Reset</button>
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
              <option value="semua" <?php if($transaksi_otomatis_jurnal=="semua") echo "selected" ?>>Semua</option>
              <option value="jurnal_umum" <?php if($transaksi_otomatis_jurnal=="jurnal_umum") echo "selected" ?>>Jurnal Umum</option>
              <option value="jurnal_penyesuaian" <?php if($transaksi_otomatis_jurnal=="jurnal_penyesuaian") echo "selected" ?>>Jurnal Penyesuaian</option>
              <option value="jurnal_penutup" <?php if($transaksi_otomatis_jurnal=="jurnal_penutup") echo "selected" ?>>Jurnal Penutup</option>
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
        <div class="pull-right"><label>Daftar Transaksi</label> <a onclick="add_transaksi_otomatis" class="glyphicon glyphicon-plus"></a></div>
      </div>  

    <div id="daftar_transaksi" class="col-md-12">
      <div id="dt" class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Transaksi Otomatis</h3>
          <div class="pull-right"><a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a></div>
        </div>
          <div class="box-body">

          <div class="col-md-7">
            <div class="row">
              <div class="col-md-8" style="padding-top:5px;"><label> Nilai dari akun </label> </div>
              <div class="col-md-2">
                <a href="#" class="glyphicon glyphicon-plus"></a>
              </div> 
            </div>
          </div>

          <div class="col-md-6">
            <div class="row">
              <div class="col-md-1" style="padding-top:12px;">
                <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
              </div>
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
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
             <div class="col-md-2" style="padding-top:15px;"><label>Sebesar</label></div>
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
              <div class="col-md-2" style="padding-top:3px;">
                <input type="text" class="form-control" name="transaksi_nama" value="">  
            </div> 
            </div>
          </div>

       <!--    <div class="col-md-6">
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
              <div class="col-md-2" style="padding-top:15px;"><label>Sebesar</label></div>
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
              <div class="col-md-2" style="padding-top:3px;">
                <input type="text" class="form-control" name="transaksi_nama" value="">  
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
              <div class="col-md-2" style="padding-top:15px;"><label>Sebesar</label></div>
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
              <div class="col-md-2" style="padding-top:3px;">
                <input type="text" class="form-control" name="transaksi_nama" value="">  
            </div> 
             <div class="col-md-2" style="padding-top:11px;"><label>%</label></div>
          </div>
        </div> -->

          <div class="col-md-7">
            <div class="row">
              <div class="col-md-8" style="padding-top:5px;">
                <label>Keu Akun</label>
              </div>
            </div>
          </div>

        <div class="col-md-6">
          <div class="row">
              <div class="col-md-1" ></div>
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
                <input type="checkbox" name="transaksi_otomatis_template" id="template<?php echo $t->id_mst_setting_transaksi_template;?>" value="<?php echo $t->id_mst_setting_transaksi_template;?>"
              <?php 
              if(!empty($t->id_mst_keu_otomasi_transaksi)){ echo "checked";}
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
      $.get('<?php echo base_url()?>mst/keuangan_transaksi/transaksi_otomatis_kembali', function (data) {
        $('#content3').html(data);
      });
    });

    $("[name='daftar_transaksi']").click(function(){
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
            url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_otomatis_template_update/".$id?>',
            data : data,
            success : function(response){
              if(response=="OK"){

                 var form_daftar_transaksi = '<div id="dt" class="box box-primary">\
                                                <div class="box-header">\
                                                  <h3 class="box-title">Transaksi Otomatis</h3>\
                                                  <div class="pull-right"><a class="glyphicon glyphicon-trash"></a></div>\
                                                </div>\
                                                  <div class="box-body">\
                                                  <div class="col-md-7">\
                                                    <div class="row">\
                                                      <div class="col-md-8" style="padding-top:5px;"><label> Nilai dari akun</label></div>\
                                                      <div class="col-md-2">\
                                                        <a class="glyphicon glyphicon-plus">\
                                                        </a>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                  <div class="col-md-6">\
                                                    <div class="row">\
                                                      <div class="col-md-8" style="padding-top:5px;">\
                                                        <select  name="transaksi_kategori" type="text" class="form-control">\
                                                          <?php foreach($kategori as $k) : ?>\
                                                            <?php
                                                              if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                                $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                              }else{
                                                                $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                              }
                                                              $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                            ?>\
                                                            <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>>\
                                                            <?php echo $k->nama ?></option>\
                                                          <?php endforeach ?>\
                                                        </select>\
                                                      </div>\
                                                      <div class="col-md-2">\
                                                        <a class="glyphicon glyphicon-trash">\
                                                        </a>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                  <div class="col-md-6">\
                                                    <div class="row">\
                                                      <div class="col-md-2" style="padding-top:15px;"><label>Sebesar</label></div>\
                                                        <div class="col-md-6" style="padding-top:5px;">\
                                                          <select  name="transaksi_kategori" type="text" class="form-control">\
                                                            <?php foreach($kategori as $k) : ?>\
                                                              <?php
                                                                if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                                  $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                                }else{
                                                                  $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                                }
                                                                $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                              ?>\
                                                              <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>>\
                                                              <?php echo $k->nama ?></option>\
                                                            <?php endforeach ?>\
                                                          </select>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                  <div class="col-md-6">\
                                                    <div class="row">\
                                                      <div class="col-md-8" style="padding-top:5px;">\
                                                        <select  name="transaksi_kategori" type="text" class="form-control">\
                                                          <?php foreach($kategori as $k) : ?>\
                                                            <?php
                                                              if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                                $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                              }else{
                                                                $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                              }
                                                              $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                            ?>\
                                                            <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>>\
                                                            <?php echo $k->nama ?></option>\
                                                          <?php endforeach ?>\
                                                        </select>\
                                                      </div>\
                                                      <div class="col-md-2">\
                                                        <a class="glyphicon glyphicon-trash"></a>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                <div class="col-md-6">\
                                                  <div class="row">\
                                                    <div class="col-md-2" style="padding-top:15px;"><label>Sebesar</label></div>\
                                                      <div class="col-md-6" style="padding-top:5px;">\
                                                        <select  name="transaksi_kategori" type="text" class="form-control">\
                                                          <?php foreach($kategori as $k) : ?>\
                                                            <?php
                                                              if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                                $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                              }else{
                                                                $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                              }
                                                              $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                            ?>\
                                                            <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>>\
                                                            <?php echo $k->nama ?></option>\
                                                          <?php endforeach ?>\
                                                        </select>\
                                                      </div>\
                                                      <div class="col-md-2" style="padding-top:3px;">\
                                                        <input type="text" class="form-control" name="transaksi_nama" value="">\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                <div class="col-md-6">\
                                                  <div class="row">\
                                                      <div class="col-md-8" style="padding-top:5px;">\
                                                        <select  name="transaksi_kategori" type="text" class="form-control">\
                                                          <?php foreach($kategori as $k) : ?>\
                                                            <?php
                                                              if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                                $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                              }else{
                                                                $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                              }
                                                              $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                            ?>\
                                                            <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>>\
                                                            <?php echo $k->nama ?></option>\
                                                          <?php endforeach ?>\
                                                        </select>\
                                                      </div>\
                                                      <div class="col-md-2">\
                                                        <a class="glyphicon glyphicon-trash"></a>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                  <div class="col-md-6">\
                                                    <div class="row">\
                                                      <div class="col-md-2" style="padding-top:15px;"><label>Sebesar</label></div>\
                                                      <div class="col-md-6" style="padding-top:5px;">\
                                                        <select  name="transaksi_kategori" type="text" class="form-control">\
                                                          <?php foreach($kategori as $k) : ?>\
                                                            <?php
                                                              if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                                $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                              }else{
                                                                $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                              }
                                                              $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                            ?>\
                                                            <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>>\
                                                            <?php echo $k->nama ?></option>\
                                                          <?php endforeach ?>\
                                                        </select>\
                                                      </div>\
                                                      <div class="col-md-2" style="padding-top:3px;">\
                                                        <input type="text" class="form-control" name="transaksi_nama" value="">\
                                                      </div>\
                                                    <div class="col-md-2" style="padding-top:11px;"><label>%</label></div>\
                                                  </div>\
                                                </div>\
                                                  <div class="col-md-7">\
                                                    <div class="row">\
                                                      <div class="col-md-8" style="padding-top:5px;">\
                                                        <label>Keu Akun</label>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                <div class="col-md-6">\
                                                  <div class="row">\
                                                      <div class="col-md-8" style="padding-top:5px;">\
                                                        <select  name="transaksi_kategori" type="text" class="form-control">\
                                                          <?php foreach($kategori as $k) : ?>\
                                                            <?php
                                                              if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                                                $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                                              }else{
                                                                $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                                              }
                                                              $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                                                            ?>\
                                                            <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>>\
                                                            <?php echo $k->nama ?></option>\
                                                          <?php endforeach ?>\
                                                        </select>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                </div>\
                                              </div>';

                      $('#daftar_transaksi').append(form_jurnal_transaksi);
              }else{
                alert("Failed.");
              }
            }
        });
    });

    $("[name='transaksi_otomatis_template']").click(function(){
      var data = new FormData();
        data.append('template',     $(this).val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_otomatis_template_update/".$id?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#transaksi_otomatis_template").prop("checked", true);
              }else{
                $("#transaksi_otomatis_template").prop("checked", false);
              }
            }
        });
    });

    $("[name='btn_kategori_transaksi_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('nama',                      $("[name='transaksi_otomatis_nama']").val());
        data.append('deskripsi',                 $("[name='transaksi_otomatis_deskripsi']").val());
        data.append('untuk_jurnal',              $("[name='transaksi_otomatis_jurnal']").val());
        data.append('id_mst_kategori_transaksi', $("[name='transaksi_otomatis_kategori']").val());
              
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_otomatis_{action}/{id}"   ?>',
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

