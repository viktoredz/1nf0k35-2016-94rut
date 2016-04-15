<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<div id="popup_barang_bhp" style="display:none">
  <div id="popup_title">Detail Opname Barang</div>
  <div id="popup_content_bhp">&nbsp;</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>inventory/bhp_opname/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12 ">
      <!-- general form elements -->
      <div class="box box-primary">
          <div class="box-footer">
            <div class="row"> 

              <div class="col-md-3 pull-right">
                <button type="button" name="btn-simpan" class="btn btn-primary"></i> &nbsp; Simpan Perubahan</button>
              </div>

            </div>
        <div class="box-body">
            <div class="row">
            <div class="col-md-7">
              <div class="row">
              <div class="col-md-4" style="padding-top:5px;"><label> Akun Penerimaan STS </label> </div>
              <div class="col-md-8">
                <select  name="akun_penerimaan" type="text" class="form-control">
                <?php foreach($akun_penerimaan_sts as $penerimaan) : ?>
                    <?php
                       if(set_value('value')=="" && isset($value)){
                         $value = $value;
                       }else{
                         $value = set_value('value');
                       }
                         $select = $penerimaan->id_mst_akun == $value ? 'selected' : '' ;
                    ?>
                     <option value="<?php echo $penerimaan->id_mst_akun ?>" <?php echo $select ?>><?php echo $penerimaan->kode?>-<?php echo $penerimaan->uraian ?></option>
                      <?php endforeach ?>
                 </select>
               </div> 
            </div>
           </div>
        </div>
      </div>
     
     <div class="box-body">
     <div class="row">
              <div class="col-md-7">
            <div class="row">
              <div class="col-md-4" style="padding-top:5px;"><label> Akun Penyetoran STS </label> </div>
              <div class="col-md-8">
                <select  name="akun_penyetoran" type="text" class="form-control">
                <?php foreach($akun_penyetoran_sts as $penyetoran) : ?>
                    <?php
                       if(set_value('value')=="" && isset($value)){
                         $value = $value;
                       }else{
                         $value = set_value('value');
                       }
                         $select = $penyetoran->id_mst_akun == $value ? 'selected' : '' ;
                    ?>
                     <option value="<?php echo $penyetoran->id_mst_akun ?>" <?php echo $select ?>><?php echo $penyetoran->kode?>-<?php echo $penyetoran->uraian ?></option>
                      <?php endforeach ?>
                 </select>
               </div> 
            </div>
          </div> 
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</form>
</section>

<script type="text/javascript">

      $("[name='btn-simpan']").click(function(){
        var data = new FormData();

        data.append('value',  $("[name='akun_penerimaan']").val());
        data.append('value',  $("[name='akun_penyetoran']").val());

        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."kepegawaian/drh_keluarga/biodata_keluarga_ortu_{action}/{id}/{urut}"   ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#popup_keluarga_ortu").jqxWindow('close');
                alert("Data keluarga berhasil disimpan.");
                $("#jqxgridKeluarga").jqxGrid('updatebounddata', 'filter');
              }else{
                $('#popup_keluarga_ortu_content').html(response);
              }
            }
        });

        return false;
    });
</script>


