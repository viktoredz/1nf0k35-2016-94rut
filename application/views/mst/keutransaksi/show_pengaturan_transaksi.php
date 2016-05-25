<script>
  $(function() {
    $('#jqxTabs_pengaturan_transaksi').jqxTabs({ width: '100%', height: '1000'});

    $('#btn-return').click(function(){
        document.location.href="<?php echo base_url()?>kepegawaian/drh";
    });

     var loadPage = function (url, tabIndex) {
        $.get(url, function (data) {
            $('#pengaturan_transaksi_sub' + tabIndex).html(data);
        });
    }

    loadPage('<?php echo base_url()?>mst/keuangan_transaksi/tab_pengaturan_transaksi/1', 1);
    $('#jqxTabs_pengaturan_transaksi').on('selected', function (event) {
        var pageIndex = event.args.item + 1;
        loadPage('<?php echo base_url()?>mst/keuangan_transaksi/tab_pengaturan_transaksi/'+pageIndex , pageIndex);
    });

    $("#menu_master_data").addClass("active");
    $("#menu_mst_keuangan_transaksi").addClass("active");
  });
</script>

<section class="content">
<div class="row">
  <div id='jqxWidget'>
    <div id='jqxTabs_pengaturan_transaksi'>
        <ul>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Data Cetak </div>
              </div>
            </li>

            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Data Syarat Pembayaran </div>
              </div>
            </li>
            
        </ul>
        <div id="pengaturan_transaksi_sub1" style="background: #FAFAFA"></div>
        <div id="pengaturan_transaksi_sub2" style="background: #FAFAFA"></div>

    </div>
  </div>
</div>
</section>

