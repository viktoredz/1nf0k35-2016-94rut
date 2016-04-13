<section class="content">
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
    <?php echo $alert_form?>
  </div>
<?php } ?>
<div class="row">
  <form action="" method="post" id="form-ss">
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-body">
        
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Kode Lokasi</div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="kode_distribusi_" id="kode_distribusi_" placeholder="Kode Lokasi" readonly>
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Tanggal Retur</div>
          <div class="col-md-8">
            <div id='tgl_opname' name="tgl_opname" value="<?php
              echo (set_value('tgl_opname')!="") ? date("Y-m-d",strtotime(set_value('tgl_opname'))) : "";
            ?>"></div>
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Nomor Retur</div>
          <div class="col-md-8">
            <input type="text" disabled class="form-control" name="nomor_opname" id="nomor_opname" placeholder="Nomor Dokumen" value="<?php 
                if(set_value('nomor_opname')=="" && isset($nomor_opname)){
                  echo $nomor_opname;
                }else{
                  echo  set_value('nomor_opname');
                }
                ?>">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Penanggung Jawab</div>
          <div class="col-md-8">
            <input type="text" disabled class="form-control" name="penerima_nama" id="penerima_nama" placeholder="Nama Penanggung Jawab" value="<?php 
                if(set_value('penerima_nama')=="" && isset($penerima_nama)){
                  echo $penerima_nama;
                }else{
                  echo  set_value('penerima_nama');
                }
                ?>">
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">NIP Penanggung Jawab</div>
          <div class="col-md-8">
            <input type="text" disabled class="form-control" name="penerima_nip" id="penerima_nip" placeholder="NIP Penanggung Jawab" value="<?php 
                if(set_value('penerima_nip')=="" && isset($penerima_nip)){
                  echo $penerima_nip;
                }else{
                  echo  set_value('penerima_nip');
                }
                ?>">
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Catatan</div>
          <div class="col-md-8">
          <textarea class="form-control" disabled name="catatan" id="catatan" placeholder="Catatan / Keperluan"><?php 
              if(set_value('catatan')=="" && isset($catatan)){
                echo $catatan;
              }else{
                echo  set_value('catatan');
              }
              ?></textarea>
              <input type="hidden" id="last_opname" name="last_opname" />
          </div>  
        </div>        
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Puskesmas</div>
          <div class="col-md-8">
          <select  name="codepus" disabled id="puskesmas" name="puskesmas" class="form-control">
              <?php foreach($kodepuskesmas as $pus) : ?>
                <?php $select = $pus->code == set_value('codepus') ? 'selected' : '' ?>
                <option value="<?php echo $pus->code ?>" <?php echo $select ?>><?php echo $pus->value ?></option>
              <?php endforeach ?>
          </select>
          </div>
        </div>

      </div>
    </div>
  </div><!-- /.form-box -->

  <div class="col-md-6">
    <div class="box box-warning">

      <div class="box-body">
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Tanggal Faktur</div>
          <div class="col-md-8">
            <div id='tgl_faktur' name="tgl_faktur" value="<?php
              echo (set_value('tgl_faktur')!="") ? date("Y-m-d",strtotime(set_value('tgl_faktur'))) : "";
            ?>"></div>
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Nomor Faktur</div>
          <div class="col-md-8">
            <input type="text" disabled class="form-control" name="nomor_opname" id="nomor_opname" placeholder="Nomor Faktur" value="<?php 
                if(set_value('nomor_opname')=="" && isset($nomor_opname)){
                  echo $nomor_opname;
                }else{
                  echo  set_value('nomor_opname');
                }
                ?>">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Instansi / PBF</div>
          <div class="col-md-8">
            <input type="text" disabled class="form-control" name="penerima_nama" id="penerima_nama" placeholder="Instansi / PBF" value="<?php 
                if(set_value('penerima_nama')=="" && isset($penerima_nama)){
                  echo $penerima_nama;
                }else{
                  echo  set_value('penerima_nama');
                }
                ?>">
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Nama Barang</div>
          <div class="col-md-8">
            <input type="text" disabled class="form-control" name="penerima_nip" id="penerima_nip" placeholder="Nama Barang" value="<?php 
                if(set_value('penerima_nip')=="" && isset($penerima_nip)){
                  echo $penerima_nip;
                }else{
                  echo  set_value('penerima_nip');
                }
                ?>">
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Merek Barang</div>
          <div class="col-md-8">
            <input type="text" disabled class="form-control" name="penerima_nip" id="penerima_nip" placeholder="Merek Barang" value="<?php 
                if(set_value('penerima_nip')=="" && isset($penerima_nip)){
                  echo $penerima_nip;
                }else{
                  echo  set_value('penerima_nip');
                }
                ?>">
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Batch</div>
          <div class="col-md-8">
            <input type="text" disabled class="form-control" name="penerima_nip" id="penerima_nip" placeholder="Batch" value="<?php 
                if(set_value('penerima_nip')=="" && isset($penerima_nip)){
                  echo $penerima_nip;
                }else{
                  echo  set_value('penerima_nip');
                }
                ?>">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Total Penerimaan</div>
          <div class="col-md-8">
            <input type="number" disabled class="form-control" name="penerima_nip" id="penerima_nip" placeholder="Total Penerimaan" value="<?php 
                if(set_value('penerima_nip')=="" && isset($penerima_nip)){
                  echo $penerima_nip;
                }else{
                  echo  set_value('penerima_nip');
                }
                ?>">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Jumlah Retur</div>
          <div class="col-md-8">
            <input type="number" disabled class="form-control" name="penerima_nip" id="penerima_nip" placeholder="Jumlah Retur" value="<?php 
                if(set_value('penerima_nip')=="" && isset($penerima_nip)){
                  echo $penerima_nip;
                }else{
                  echo  set_value('penerima_nip');
                }
                ?>">
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-danger"><i class='fa fa-ban'></i> &nbsp; Batal & Hapus </button>
        <button type="button" id="btn-kembali" class="btn btn-warning"><i class='fa fa-arrow-circle-left'></i> &nbsp;Kembali</button>
      </div>
      </div>
    </form>        

  </div><!-- /.form-box -->
</div><!-- /.register-box -->

<script type="text/javascript">
$(function(){
  cekopname($('#tgl_opname').val(),$('#jenis_bhp').val());
    $('#form-ss').submit(function(){
      if ($('#last_opname').val() >= $('#tgl_opname').val()) {
      alert("Maaf! Kategori barang "+$('#jenis_bhp').val()+" sudah di opname pada "+$('#last_opname').val()+','+'\n'+"Silahkan ganti ke tanggal berikutnya");

      }else{
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
                url : "<?php echo base_url()?>inventory/bhp_retur/{action}_opname",
                data : data,
                success : function(response){
                  $('#addopname').html(response);
                }
            });
      }
            return false;
        });
    kodedistribusi();
    $('#btn-kembali').click(function(){
       $.ajax({
          url : '<?php echo site_url('inventory/bhp_retur/daftar_barangretur/') ?>',
          type : 'POST',
          success : function(data) {
              $('#content2').html(data);
          }
      });

      return false;
    });

    $("#tgl_faktur").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme , height: '30px', disabled:true});
    $("#tgl_opname").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme , height: '30px', disabled:true});
    $("#tgl_opname").change(function() {
        kodedistribusi($("#tgl_opname").val());
        
    });
    $("#jenis_bhp").change(function(){
        cekopname($('#tgl_opname').val(),$(this).val());
    });
    function cekopname(tgl,bhp){
     
      $.ajax({
          url : "<?php echo base_url().'inventory/bhp_retur/lastopname/';?>"+bhp,
          success : function(data) {
             tglop = data.split('-');
              $("#last_opname").val(tglop[2]+'-'+tglop[1]+'-'+tglop[0]);
          }
      });

      return false;
    }
    function kodedistribusi(tahun)
    {
      if (tahun==null) {
        var tahun = <?php echo date("y");?>;  
      }else{
        var tahun = tahun.substr(-2);
      }
      
      $.ajax({
      url: "<?php echo base_url().'inventory/bhp_retur/kodedistribusi';?>",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          var lokasi = elemet.kodeinv.split(".")
          $("#kode_distribusi_").val(lokasi[0]+"."+lokasi[1]+"."+lokasi[2]+"."+lokasi[3]+"."+lokasi[4]+"."+tahun+'.'+lokasi[5]);
        });
      }
      });

      return false;
    }
  });
</script>
  