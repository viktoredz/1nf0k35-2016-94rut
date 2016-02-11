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
<div class="row">
  <form action="<?php echo base_url()?>inventory/pengadaanbarang/{action}/{kode}/" method="post">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body">
        <div class="form-group">
          <label>Tanggal Pengadaan</label><?php if(isset($viewreadonly)){if($action='view'){ 
            echo "<br>".date("d-m-Y",strtotime($tgl_pengadaan)); }}else{ ?>
              <div id='tgl' name="tgl" disabled value="<?php
              echo $tgl_pengadaan;;//echo ($tgl_pengadaan!="") ? date("Y-m-d",strtotime($$tgl_pengadaan)) : "";
            ?>" ></div>
             <?php  }?>
        </div>
        <div class="form-group">
          <label>Status Pengadaan</label>
          <?php if(!isset($viewreadonly)){ ?>
          <select  name="status" type="text" class="form-control">
              <option value="">Pilih Status</option>
              <?php foreach($kodestatus as $stat) : ?>
                <?php $select = $stat->code == $pilihan_status_pengadaan ? 'selected' : '' ?>
                <option value="<?php echo $stat->code ?>" <?php echo $select ?>><?php echo $stat->value ?></option>
              <?php endforeach ?>
          </select>
          <?php }else{ 
              foreach($kodestatus as $stat) : 
                if($stat->code == $pilihan_status_pengadaan ){
                  echo "<br>".$stat->value ;
                }
              endforeach;
          } ?>
        </div>
        <div class="form-group">
          <label>Puskesmas</label>
          <?php if(!isset($viewreadonly)){ ?>
          <select  name="codepus" id="puskesmas" class="form-control">
              <?php foreach($kodepuskesmas as $pus) : ?>
                <?php $select = $pus->code == $code_cl_phc ? 'selected' : '' ?>
                <option value="<?php echo $pus->code ?>" <?php echo $select ?>><?php echo $pus->value ?></option>
              <?php endforeach ?>
          </select>
          <?php }else{ 
              foreach($kodepuskesmas as $pus) : 
                if($pus->code == $code_cl_phc ){
                  echo "<br>".$pus->value ;
                }
              endforeach;
          } ?>
        </div>
        <div class="form-group">
          <label>Nomor Kontrak</label>
          <?php if(!isset($viewreadonly)){ ?>
          <input type="text" class="form-control" name="nomor_kontrak" placeholder="Nomor Kontrak" value="<?php 
            if(set_value('nomor_kontrak')=="" && isset($nomor_kontrak)){
              echo $nomor_kontrak;
            }else{
              echo  set_value('nomor_kontrak');
            }
            ?>">
          <?php }else{ 
              echo "<br>".$nomor_kontrak;
          } ?>
        </div>
        <div class="form-group">
          <label>Tanggal Kwitansi</label><?php if(isset($viewreadonly)){if($action='view'){ 
            echo "<br>".date("d-m-Y",strtotime($tgl_kwitansi)); }}else{ ?>
              <div id='tgl1' name="tgl1" disabled value="<?php
              echo $tgl_kwitansi;;//echo ($tgl_pengadaan!="") ? date("Y-m-d",strtotime($$tgl_pengadaan)) : "";
            ?>" ></div>
             <?php  }?>
        </div>
        <div class="form-group">
          <label>Nomor Kwitansi</label>
          <?php if(!isset($viewreadonly)){ ?>
          <input type="text" class="form-control" name="nomor_kwitansi" placeholder="Nomor Kwitansi" value="<?php 
            if(set_value('nomor_kwitansi')=="" && isset($nomor_kwitansi)){
              echo $nomor_kwitansi;
            }else{
              echo  set_value('nomor_kwitansi');
            }
            ?>">
          <?php }else{ 
              echo "<br>".$nomor_kwitansi;
          } ?>
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <?php if(!isset($viewreadonly)){ ?>
          <textarea class="form-control" name="keterangan" placeholder="Keterangan"><?php 
              if(set_value('keterangan')=="" && isset($keterangan)){
                echo $keterangan;
              }else{
                echo  set_value('keterangan');
              }
              ?></textarea>
          <?php }else{ 
              echo "<br>".$nomor_kontrak;
          } ?>
        </div>
      </div>
    </div>
  </div><!-- /.form-box -->

  <div class="col-md-6">
    <div class="box box-warning">
      <div class="box-body">
      <div id="success"> 
          <table class="table table-condensed">
              <tr>
                <td>Jumlah Unit</td>
                <td>
                    <div id="jumlah_unit_"></div>
                </td>
              </tr>
              <tr>
                <td>Nilai Pengadaan</td>
                <td>
                  <div id="nilai_pengadaan_"></div>
                </td>
              </tr>
              <tr>
                <td>Waktu dibuat</td>
                <td>
                  <div id="waktu_dibuat_"></div>
                </td>
              </tr>
              <tr>
                <td>Terakhir di edit</td>
                <td>
                  <div id="terakhir_diubah_"></div>
                </td>
              </tr>
            </tbody>
          </table>
      </div>
      <div class="box-footer">
        <?php if(!isset($viewreadonly)){?>
          <button type="submit" class="btn btn-primary"><i class='fa fa-floppy-o'></i> &nbsp; Simpan</button>
        <?php }else{ ?>
          <button type="button" id="btn-export" class="btn btn-primary"><i class='fa fa-save'></i> &nbsp; Export</button>
          <?php if($unlock==1){ ?>
            <button type="button" id="btn-edit" class="btn btn-success"><i class='fa fa-pencil-square-o'></i> &nbsp; Ubah Pengadaan</button>
          <?php } ?>
        <?php } ?>
        <button type="button" id="btn-kembali" class="btn btn-warning"><i class='fa fa-reply'></i> &nbsp; Kembali</button>
      </div>
      </div>
    </form>        
    </div>
  </div><!-- /.form-box -->
</div><!-- /.register-box -->      
<div class="box box-success">
  <div class="box-body">
    <div class="div-grid">
        <div id="jqxTabs">
          <?php echo $barang;?>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
    $('#btn-kembali').click(function(){
        window.location.href="<?php echo base_url()?>inventory/pengadaanbarang";
    });

    $('#btn-edit').click(function(){
        window.location.href="<?php echo base_url()?>inventory/pengadaanbarang/edit/{kode}";
    });

    $("#menu_inventory_pengadaanbarang").addClass("active");
    $("#menu_inventory").addClass("active");

    <?php if(!isset($viewreadonly)){?>
      $("#tgl").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
      $("#tgl1").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
    <?php } ?>
  });

</script>
