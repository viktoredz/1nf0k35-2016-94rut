
<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>admin_config/doupdate" method="POST" name="frmUsers">
  <div class="row">
    <!-- left column -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div><!-- /.box-header -->

        <!-- form start -->
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Web Title</label>
              <input type="text" class="form-control" name="title" placeholder="{title}" value="{title}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">META Descripton</label>
              <input type="text" class="form-control" name="description" placeholder="{description}" value="{description}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">META Keywords</label>
              <input type="text" class="form-control" name="keywords" placeholder="{keywords}" value="{keywords}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Detault Template ID</label>
              <?php echo form_dropdown('theme_default', $theme_default_option, $theme_default," class=form-control");?>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Offline Template ID</label>
              <?php echo form_dropdown('theme_offline', $theme_default_option, $theme_offline," class=form-control");?>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">
              	<input type="checkbox" name="online" value="1" <?php if($online) echo "checked"; ?>> Online/Offline
          	  </label>
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-warning">Reset</button>
          </div>
      </div><!-- /.box -->
  	</div><!-- /.box -->
    <div class="col-md-6">
      <!-- general form elements -->
      <div class="box box-warning">
        <div class="box-header">
          <h3 class="box-title">Mail Configuration</h3>
        </div><!-- /.box-header -->

        <!-- form start -->
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Mail Server</label>
              <input type="text" class="form-control" name="mail_server" placeholder="{mail_server}" value="{mail_server}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Mail Port</label>
              <input type="text" class="form-control" name="mail_port" placeholder="{mail_port}" value="{mail_port}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Mail Signature</label>
              <input type="text" class="form-control" name="mail_signature" placeholder="{mail_signature}" value="{mail_signature}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Mail User</label>
              <input type="text" class="form-control" name="mail_user" placeholder="{mail_user}" value="{mail_user}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Mail Password</label>
              <input type="text" class="form-control" name="mail_password" placeholder="{mail_password}" value="{mail_password}">
            </div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-warning">Reset</button>
          </div>
      </div><!-- /.box -->
  	</div><!-- /.box -->  
  </div><!-- /.box -->
</form>
</section>

<script>
	$(function () {	
		$("#menu_admin_config").addClass("active");
		$("#menu_admin_panel").addClass("active");
	});
</script>