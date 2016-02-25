<script>
  $(function() {
        $('#jqxTabs').jqxTabs({ width: '100%', height: '1000'});

        $('#btn-return').click(function(){
            document.location.href="<?php echo base_url()?>kepegawaian/drh";
        });

        var loadPage = function (url, tabIndex) {
            $.get(url, function (data) {
                $('#content' + tabIndex).html(data);
            });
        }

        loadPage('<?php echo base_url()?>kepegawaian/drh/biodata/1/{id}', 1);
        $('#jqxTabs').on('selected', function (event) {
            var pageIndex = event.args.item + 1;
            loadPage('<?php echo base_url()?>kepegawaian/drh/biodata/'+pageIndex+'/{id}', pageIndex);
        });

  });
</script>

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
      </div>

      <div class="box-footer" >
        <div class="row">
          <div class="col-sm-12 col-md-2" style="text-align:  center">
              <img src="" height="100">
          </div>
          <div class="col-sm-12 col-md-4" style="padding-top: 10px">
            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Nama : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  {nama}
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>NIP : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  {nip}
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 col-xs-6" style="text-align: right;">
                <label>Usia : </label>
              </div>
              <div class="col-md-8 col-xs-6">
                  {usia} Tahun
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6" style="text-align: right">
            <button type="button" class="btn btn-success" id="btn-return"><i class='fa fa-arrow-circle-o-left'></i> &nbsp; Kembali</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

<div id='jqxWidget'>
    <div id='jqxTabs'>
        <ul>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Biodata</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Keluarga</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Pendidikan</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Pangkat</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Jabatan</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      D P 3</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Peghargaan</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Status</div>
              </div>
            </li>
        </ul>
        <div id="content1" style="background: #FAFAFA"></div>
        <div id="content2" style="background: #FAFAFA"></div>
        <div id="content3" style="background: #FAFAFA"></div>
        <div id="content4" style="background: #FAFAFA"></div>
        <div id="content5" style="background: #FAFAFA"></div>
        <div id="content6" style="background: #FAFAFA"></div>
        <div id="content7" style="background: #FAFAFA"></div>
        <div id="content8" style="background: #FAFAFA"></div>
    </div>
</div>

</section>

<script>
  $(function () { 
    $("#menu_kepegawaian_drh").addClass("active");
    $("#menu_kepegawaian").addClass("active");
  });
</script>
