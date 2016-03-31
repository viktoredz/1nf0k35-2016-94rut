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
                <?php //if($unlock==1){ ?>
          <!--  <button type="button" class="btn btn-primary" onclick="add(0)"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah Pengeluaran</button>-->
            <?php //} ?>      
                <button type="button" id="btn-export" class="btn btn-primary"></i> &nbsp; Simpan Perubahan</button>
              </div>
            </div>
        <div class="box-body">
            <div class="row">
            <div class="col-md-7">
              <div class="row">
              <div class="col-md-4" style="padding-top:5px;"><label> Akun Penerimaan STS </label> </div>
              <div class="col-md-8">
                <select name="code_cl_phc" id="puskesmas" class="form-control">
                  <option value="all">All</option>
                <?php foreach ($datapuskesmas as $row ) { ;?>
                  <option value="<?php echo $row->code; ?>" onchange="" ><?php echo $row->value; ?></option>
                <?php } ;?>
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
                <select name="bulan" id="bulan" class="form-control">
                  <option value="all">All</option>
                <?php foreach ($bulan as $val=>$key ) { ;?>
                  <option value="<?php echo $val; ?>" ><?php echo $key; ?></option>
                <?php } ;?>
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


