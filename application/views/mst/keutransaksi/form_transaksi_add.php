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
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
      </div>

        <div class="box-footer">
          <button type="button" id="btn-kembali" class="btn btn-primary pull-right"><i class='fa  fa-arrow-circle-o-left'></i> &nbsp;Kembali</button>
          <button type="button" name="btn_kategori_transaksi_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
          <button id="doRefresh" class="btn btn-success" ><i class='fa fa-refresh'></i> &nbsp; Reset</button>

       </div>
        <div class="box-body">

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Nama Transaksi</div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="kode_inventaris_" id="kode_inventaris_" placeholder="Pembayaran Biaya Jasa Pelayanan">
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Deskripsi</div>
          <div class="col-md-8">
          <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Deskripsi Dari Kategori"><?php 
              if(set_value('keterangan')=="" && isset($keterangan)){
                echo $keterangan;
              }else{
                echo  set_value('keterangan');
              }
              ?></textarea>
          </div>  
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Untuk Jurnal</div>
          <div class="col-md-8">
            <select  name="status" type="text" class="form-control">
              <?php foreach($kodestatus as $stat => $value) : ?>
                <?php $select = $stat == set_value('status') ? 'selected' : '' ?>
                <option value="<?php echo $stat?>" <?php echo $select ?>><?php echo $value ?></option>
              <?php endforeach ?>
          </select>
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Kategori</div>
          <div class="col-md-8">
            <select  name="status" type="text" class="form-control">
              <?php foreach($kodestatus as $stat => $value) : ?>
                <?php $select = $stat == set_value('status') ? 'selected' : '' ?>
                <option value="<?php echo $stat?>" <?php echo $select ?>><?php echo $value ?></option>
              <?php endforeach ?>
          </select>
          </div>
        </div>

        <label>Pengaturan Transaksi</label>
        
        <div class="row" style="margin: 5px">
           <div class="col-md-12">
              <?php $i=1; foreach($template as $t) : ?>
              <input type="checkbox" name="kategori_trans_template" id="kategori_trans_template<?php echo $i;?>" value="<?php echo $t->id_mst_setting_transaksi_template;?>" 
              <?php 
                if(set_value('nilai')=="" && isset($nilai)){
                   $nilai = $nilai;
                }else{
                   $nilai = set_value('nilai');
                }
                if($nilai == 1) echo "checked";
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
  </div>
</form>
</section>

<script type="text/javascript">

  function add(){
      $("#popup_kategori_transaksi #popup_kategori_transaksi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_transaksi/kategori_transaksi_add' ?>/", function(data) {
          $("#popup_kategori_transaksi_content").html(data);
        });
        $("#popup_kategori_transaksi").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 450,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_kategori_transaksi").jqxWindow('open');
  }

  function detail(id){
      $("#popup_kategori_transaksi #popup_kategori_transaksi_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_transaksi/kategori_transaksi_edit' ?>/"+ id, function(data) {
          $("#popup_kategori_transaksi_content").html(data);
        });
        $("#popup_kategori_transaksi").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 450,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_kategori_transaksi").jqxWindow('open');
    }

  function del(id){
    var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'mst/keuangan_transaksi/delete_kategori_transaksi' ?>/" + id,  function(){
        alert('data berhasil dihapus');
        $("#jqxgrid_transaksi").jqxGrid('updatebounddata', 'cells');
      });
    }
  }
</script>

