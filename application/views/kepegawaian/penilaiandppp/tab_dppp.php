<script>
  $(function() {
        $('#jqxTabsdppp').jqxTabs({ width: '100%', height: '1000'});
        // $('#btn-skjabatan-tambah').click(function(){
        //     $.get('<?php echo base_url()?>kepegawaian/penilaiandppp/add/{id}', function (data) {
        //         $("#tambahjqxgrid").show();
        //         $("#tambahjqxgrid").html(data);
        //         $("#jqxgrid").hide();
        //         $("#btn_back_dppp").show();
        //         $("#btn_add_dppp").hide();
        //     }0)
        // });

        var loadPage = function (url, tabIndex) {
            $.get(url, function (data) {
                $('#tabadddppp' + tabIndex).html(data);
            });
        }

        loadPage('<?php echo base_url()?>kepegawaian/penilaiandppp/form_tab_dpp/1/{id_pegawai}/{tahun}/{id_mst_peg_struktur_org}/0', 1);
        $('#jqxTabsdppp').on('selected', function (event) {
            var pageIndex = event.args.item + 1;
            loadPage('<?php echo base_url()?>kepegawaian/penilaiandppp/form_tab_dpp/'+pageIndex+'/{id_pegawai}/{tahun}/{id_mst_peg_struktur_org}/0', pageIndex);
        });

  });
</script>


<div id='jqxWidgetJabatan'>
    <div id='jqxTabsdppp'>
        <ul>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-plus" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 10px; vertical-align: middle; text-align: center; float: left;">
                      Pengukuran</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-plus" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 10px; vertical-align: middle; text-align: center; float: left;">
                      Penilaian DP3</div>
              </div>
            </li>
        </ul>
        <div id="tabadddppp1" style="background: #FAFAFA">
        </div>
        <div id="tabadddppp2" style="background: #FAFAFA">
        </div>
    </div>
</div>

