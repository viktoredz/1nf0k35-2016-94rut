<script>
  $(function() {
        $('#jqxTabsPangkat').jqxTabs({ width: '100%', height: '500'});

        var loadPage = function (url, tabIndex) {
            $.get(url, function (data) {
                $('#pangkatnsub' + tabIndex).html(data);
            });
        }

        loadPage('<?php echo base_url()?>kepegawaian/drh/biodata_pangkatn/1/{id}', 1);
        $('#jqxTabsPangkat').on('selected', function (event) {
            var pageIndex = event.args.item + 1;
            loadPage('<?php echo base_url()?>kepegawaian/drh/biodata_pangkatn/'+pageIndex+'/{id}', pageIndex);
        });

  });
</script>

<section class="content">
<div id='jqxWidgetPangkat'>
    <div id='jqxTabsPangkat'>
        <ul>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-plus" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 10px; vertical-align: middle; text-align: center; float: left;">
                      Non PNS / Honorer</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-plus" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 10px; vertical-align: middle; text-align: center; float: left;">
                      Calon Pegawai Negeri Sipil / CPNS</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-plus" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 10px; vertical-align: middle; text-align: center; float: left;">
                      Pegawai Negeri Sipil / PNS</div>
              </div>
            </li>
        </ul>
        <div id="pangkatnsub1" style="background: #FAFAFA">
        </div>
        <div id="pangkatnsub2" style="background: #FAFAFA">
        </div>
        <div id="pangkatnsub3" style="background: #FAFAFA">
        </div>
    </div>
</div>

</section>

