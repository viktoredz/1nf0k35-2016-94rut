<?php if(validation_errors()!=""){ ?>
<div class="alert alert-warning alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<?php if($alert_form!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert_form')?>
</div>
<?php }  ?>
<div id="grid"></div>
<section class="content">
<div class="row">
  <form action="" method="post" name="editform" id="form-ss-edit">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body">
        
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Kode Lokasi</div>
          <div class="col-md-8">
          <?php if($action!="view") {?>
              <input type="text" class="form-control" name="kode_distribusi_" id="kode_distribusi_" placeholder="Kode Lokasi" readonly>
          <?php }else{?>
              <div id="kode_distribusi_"></div>
          <?php }?>
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Tanggal Pemusnahan</div>
          <div class="col-md-8">
          
          <?php if($action!="view") {?>
            <div id='tgl_opname' name="tgl_opname" value="<?php
              echo ($tgl_opname) ? date("Y-m-d",strtotime($tgl_opname)) : "";
            ?>"></div>
          <?php }else{
                echo date("d-m-Y",strtotime($tgl_opname));
          }?>  
          </div>
        </div>


        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Puskesmas</div>
          <div class="col-md-8">
          <?php if($action!="view") {?>
            <select  name="codepus" id="puskesmas" class="form-control">
              <?php foreach($kodepuskesmas as $pus) : ?>
                <?php $select = $pus->code == $code_cl_phc ? 'selected' : '' ?>
                <option value="<?php echo $pus->code ?>" <?php echo $select ?>><?php echo $pus->value ?></option>
              <?php endforeach ?>
          </select>
          <?php }else{
                  foreach($kodepuskesmas as $pus){
                    echo ($pus->code == $code_cl_phc ? $pus->value: '');
                  }
              }
          ?>
          
          </div>
        </div>
<div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Nomor Expired</div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="nomor_opname" id="nomor_opname" placeholder="Nomor Dokumen" value="<?php 
                if(set_value('nomor_opname')=="" && isset($nomor_opname)){
                  echo $nomor_opname;
                }else{
                  echo  set_value('nomor_opname');
                }
                ?>">
          </div>
        </div>
      </div>
    </div>
  </div><!-- /.form-box -->

  <div class="col-md-6">
    <div class="box box-warning">

      <div class="box-body">
        <div class="row" style="margin: 5px">
          <div class="col-md-5" style="padding: 5px">Saksi Satu</div>
          <div class="col-md-7">
            <input type="text" class="form-control" name="saksi1_nama" id="saksi1_nama" placeholder="Nama Penerima" value="<?php 
                if(set_value('saksi1_nama')=="" && isset($saksi1_nama)){
                  echo $saksi1_nama;
                }else{
                  echo  set_value('saksi1_nama');
                }
                ?>">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-5" style="padding: 5px">NIP Saksi Satu</div>
          <div class="col-md-7">
            <input type="text" class="form-control" name="saksi1_nip" id="saksi1_nip" placeholder="NIP Penerima" value="<?php 
                if(set_value('saksi1_nip')=="" && isset($saksi1_nip)){
                  echo $saksi1_nip;
                }else{
                  echo  set_value('saksi1_nip');
                }
                ?>">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-5" style="padding: 5px">Saksi Dua</div>
          <div class="col-md-7">
            <input type="text" class="form-control" name="saksi2_nama" id="saksi2_nama" placeholder="Nama Penerima" value="<?php 
                if(set_value('saksi2_nama')=="" && isset($saksi2_nama)){
                  echo $saksi2_nama;
                }else{
                  echo  set_value('saksi2_nama');
                }
                ?>">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-5" style="padding: 5px">NIP Saksi Dua</div>
          <div class="col-md-7">
            <input type="text" class="form-control" name="saksi2_nip" id="saksi2_nip" placeholder="NIP Penerima" value="<?php 
                if(set_value('saksi2_nip')=="" && isset($saksi2_nip)){
                  echo $saksi2_nip;
                }else{
                  echo  set_value('saksi2_nip');
                }
                ?>">
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-5" style="padding: 5px">Catatan</div>
          <div class="col-md-7">
          <?php if($action!="view") {?>
            <textarea class="form-control" name="catatan" id="catatan" placeholder="Keterangan / Keperluan"><?php 
              if(set_value('catatan')=="" && isset($catatan)){
                echo $catatan;
              }else{
                echo  set_value('catatan');
              }
              ?></textarea>
          <?php }else{
                    echo $catatan;
              }
          ?>
          </div>  
        </div>


      </div>
      <div class="box-footer">
        <?php if(!isset($viewreadonly)){?>
          <button type="submit" class="btn btn-primary" id="btn-submit"><i class='fa fa-floppy-o'></i> &nbsp; Simpan</button>
        <?php }else{ ?>
          <button type="button" id="btn-export" class="btn btn-primary"><i class='fa fa-save'></i> &nbsp; Export</button>
          <?php if($unlock==1){ ?>
            <button type="button" id="btn-edit" class="btn btn-success"><i class='fa fa-pencil-square-o'></i> &nbsp; Ubah Distribusi</button>
          <?php } ?>
        <?php } ?>
        <button type="button" id="btn-kembali-expired" class="btn btn-warning"><i class='fa fa-reply'></i> &nbsp; Kembali </button>
      </div>
    </div>
  </div><!-- /.form-box -->
</div><!-- /.register-box -->    
 </form>
 </section>
<div class="row">

<?php if(!isset($viewreadonly)){?>
  <div class="col-md-6">
    <div class="box box-success">
      <div class="box-body">
        <label>Barang Opname</label>
        <div class="div-grid">
            <div id="jqxTabs">
              <?php echo $barang_opname;?>
            </div>
        </div>
      </div>
    </div>
  </div>  

  <div class="col-md-6">
    <div class="box box-danger">
      <div class="box-body">
      <label>Daftar Barang Distribusi </label>
        <div class="div-grid">
            <div id="jqxTabs">
              <?php echo $barang;?>
            </div>
        </div>
      </div>
    </div>
  </div>
<?php }else{ ?>
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-body">
        <label>Barang Distribusi</label>
        <div class="div-grid">
            <div id="jqxTabs">
              <?php echo $barang_opname;?>
            </div>
        </div>
      </div>
    </div>
  </div>  
<?php } ?>

</div>
<script type="text/javascript">

$(function(){
  $('#form-ss-edit').submit(function(){
      var data = new FormData();
      data.append('kode_distribusi_', $('#kode_distribusi_').val());
      data.append('tgl_opname', $('#tgl_opname').val());
      data.append('nomor_opname', $('#nomor_opname').val());
      data.append('jenis_bhp', $('#jenis_bhp').val());
      data.append('puskesmas', $('#puskesmas').val());
      data.append('penerima_nama', $('#penerima_nama').val());
      data.append('penerima_nip', $('#penerima_nip').val());
      data.append('catatan', $('#catatan').val());
      $.ajax({
          cache : false,
          contentType : false,
          processData : false,
          type : 'POST',
          url : "<?php echo base_url()?>inventory/bhp_pemusnahan/{action}_opname/{kode}/8",
          data : data,
          success : function(response){
            $('#addopname').html(response);
          }
      });
      return false;
  });
  kodedistribusi();
    $('#btn-kembali-expired').click(function(){
        $.get('<?php echo base_url()?>inventory/bhp_pemusnahan/tab/1', function (data) {
            $('#addopname').hide();
              $('#content1').html(data);
      });
    });


    $("#menu_bahan_habis_pakai").addClass("active");
    $("#menu_inventory_bhp_pemusnahan").addClass("active");

    <?php if($action!="view"){?>
      $("#tgl_opname").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme , height: '30px' , disabled: true});
    
      $("#tgl_opname").change(function() {
          kodedistribusi($("#tgl_opname").val());
      });
    <?php } ?>
    });

    function kodedistribusi(tahun)
    { 
      if (tahun==null) {
        var tahun ='';
      }else{
        var tahun = tahun.substr(-2);
      }

      $.ajax({
      url: "<?php echo base_url().'inventory/bhp_pemusnahan/kodedistribusi';?>",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
         // alert( );
          var lokasi = elemet.kodeinv.split(".")
          <?php if($action!="view") {?>
          $("#kode_distribusi_").val(/*lokasi[0]+"."+lokasi[1]+"."+lokasi[2]+"."+lokasi[3]+"."+lokasi[4]+"."+tahun+'.'+lokasi[5]*/elemet.kodeinv);
          <?php }else{?>
          $("#kode_distribusi_").html(/*lokasi[0]+"."+lokasi[1]+"."+lokasi[2]+"."+lokasi[3]+"."+lokasi[4]+"."+tahun+'.'+lokasi[5]*/elemet.kodeinv;
          <?php }?>
        });
      }
      });

      return false;
    }
    $("#btn-export").click(function(){
    
    var post = "";
    post = post+'&jenis_bhp='+"<?php echo '8'; ?>"+'&kode='+"<?php echo $kode; ?>";
    
    $.post("<?php echo base_url()?>inventory/bhp_pemusnahan/export_distribusi",post,function(response ){
      window.location.href=response;
    });
  });
</script>

      