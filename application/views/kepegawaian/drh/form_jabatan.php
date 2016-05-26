<script>
  $(function() {
        $('#jqxTabsJabatan').jqxTabs({ width: '100%', height: '500'});
        $('#btn-skjabatan-tambah').click(function(){
            $.get('<?php echo base_url()?>kepegawaian/drh_jabatan/add/{id}', function (data) {
                $('#content5').html(data);
            });
        });

        var loadPage = function (url, tabIndex) {
            $.get(url, function (data) {
                $('#jabatannsub' + tabIndex).html(data);
            });
        }

        loadPage('<?php echo base_url()?>kepegawaian/drh_jabatan/biodata_jabatan/1/{id}', 1);
        $('#jqxTabsJabatan').on('selected', function (event) {
            var pageIndex = event.args.item + 1;
            loadPage('<?php echo base_url()?>kepegawaian/drh_jabatan/biodata_jabatan/'+pageIndex+'/{id}', pageIndex);
        });

  });
</script>

<section class="content">
  <div class="row" style="margin-bottom:15px">
    <div class="col-md-12" style="text-align: right">
      <button type="button" class="btn btn-success" id="btn-skjabatan-tambah"><i class='fa fa-plus-circle'></i> &nbsp; Tambah SK Jabatan</button>
    </div>
  </div>
<div id='jqxWidgetJabatan'>
    <div id='jqxTabsJabatan'>
        <ul>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-plus" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 10px; vertical-align: middle; text-align: center; float: left;">
                      Jabatan Struktural</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-plus" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 10px; vertical-align: middle; text-align: center; float: left;">
                      Jabatan Fungsional</div>
              </div>
            </li>
        </ul>
        <div id="jabatannsub1" style="background: #FAFAFA">
        </div>
        <div id="jabatannsub2" style="background: #FAFAFA">
        </div>
    </div>
</div>

</section>

