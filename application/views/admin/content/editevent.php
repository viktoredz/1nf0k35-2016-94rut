<link href="<?php echo base_url()?>plugins/js/kartik/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url()?>plugins/js/kartik/js/fileinput.js" type="text/javascript"></script>

<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>


<section class="content">
<form action="<?php echo base_url()?>admin_content/doeditevent/file_id/{file_id}/id/{id}" method="POST" name="frmFiles">
  <div class="row">
    <!-- left column -->
    <div class="col-md-10">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
          <div class="pull-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-warning">Ulang</button>
            <button type="button" class="btn btn-success" onClick="document.location.href='<?php echo base_url()?>admin_content/editevent/file_id/{file_id}'">Kembali</button>
          </div>
        </div><!-- /.box-header -->

      	<div class="box-body">
			<?php 
			foreach($lang as $row):
				eval("\$title_content= (isset(\$title_content_".$row['kode'].") ? \$title_content_".$row['kode']." : '');");
			?>
	            <div class="form-group">
	              <label for="exampleInputEmail1">Title <i><?php echo $row['lang']?></i></label>
	              <input type="text" class="form-control" name="title_content_<?php echo $row['kode']?>" value="<?php echo $title_content ?>">
	            </div>
			<?php endforeach;?>

            <div class="form-group">
              <label for="exampleInputEmail1">Author : </label>
              {author}
            <br>
              <label for="exampleInputEmail1">Hits : </label>
              {hits}
            <br>
              <input class=input type="checkbox" name="published" value="1" <?php if($published) echo "checked"; ?>>
              <label for="exampleInputEmail1">Publish / Unpublish</label>
            </div>
          
            <div class="form-group">
              <label for="exampleInputEmail1">Time Start / End</label>
              <input type="text" name="dtime" id="datemask" value="{dtime}" class="form-control"/>
            </div>
			<?php 
			foreach($lang as $row):
				eval("\$headline= (isset(\$headline_".$row['kode'].") ? \$headline_".$row['kode']." : '');");
			?>
	            <div class="form-group">
	              <label for="exampleInputEmail1">Headline <i><?php echo $row['lang']?></i></label>
	              <textarea name="headline_<?php echo $row['kode']?>" class="form-control" rows=4 cols=80><?php echo $headline?></textarea>
	            </div>
			<?php endforeach;?>

			<?php 
			foreach($lang as $row):
				eval("\$content= (isset(\$content_".$row['kode'].") ? \$content_".$row['kode']." : '');");
			?>
	            <div class="form-group">
	              <label for="exampleInputEmail1">Content <i><?php echo $row['lang']?></i></label>
	              <textarea name="content_<?php echo $row['kode']?>" id="content_<?php echo $row['kode']?>" class="form-control" rows=1 cols=1><?php echo $content?></textarea>
	            </div>
			<?php endforeach;?>

          <div class="pull-right">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-warning">Ulang</button>
            <button type="button" class="btn btn-success" onClick="document.location.href='<?php echo base_url()?>admin_content/editevent/file_id/{file_id}'">Kembali</button>
          </div>
      </div><!-- /.box -->
  	</div><!-- /.box -->
</form>

<form enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Upload Image / File</h3>
          <div class="pull-right">
      </div>
        <div class="box-body">
          <label>Klik nama file untuk mendapatkan URL.</label>
            <input type="text" class="form-control" id="clipboard" readonly placeholder="File / Image URL">
      </div><!-- /.box -->
        <div class="box-body">
          <input id="uploadfile" name="uploadfile[]" type="file" accept="image/*" multiple=true class="file-loading">
      </div><!-- /.box -->
      </div><!-- /.box -->
    </div><!-- /.box -->
  </div><!-- /.box -->
</form>
<script type="text/javascript">
{filelist_kartik}
</script>
</div><!-- /.box -->
</section>

<script src="<?php echo base_url()?>public/themes/admin/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>public/themes/admin/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {	
	$("#menu_admin_content").addClass("active");
	$("#menu_admin").addClass("active");

    $("#datemask").daterangepicker({format: 'DD/MM/YYYY'});
    $('#daterange-btn').daterangepicker(
                {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                  },
                  startDate: moment().subtract('days', 29),
                  endDate: moment()

                },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    CKEDITOR.config.height = '500px';
    CKEDITOR.config.extraAllowedContent = 'p(*)[*]{*};p[align];div{text-align};div{font-weight};strong{color};table{border};td{border};td{border-right};td{border-bottom};td{border-top}';
    CKEDITOR.config.autoParagraph = false;
    CKEDITOR.replace('content_en');
    CKEDITOR.replace('content_ina');
  });
</script>
