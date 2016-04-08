<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<div id="popup_keuangan_sts" style="display:none">
  <div id="popup_title">Buat Versi Daftar Tarif STS Baru</div>
  <div id="popup_keuangan_sts_content">&nbsp;</div>
</div>

<div id="popup_keuangan_sts_induk" style="display:none">
  <div id="popup_title">Tambah Induk Baru</div>
  <div id="popup_keuangan_sts_induk_content">&nbsp;</div>
</div>

<div id="popup_keuangan_versi_sts" style="display:none">
  <div id="popup_title">Semua Versi Tarif STS</div>
  <div id="popup_keuangan_versi_sts_content">&nbsp;</div>
</div>


<section class="content">

  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
           <h3 class="box-title">{title_form}</h3> 
      </div>

      <div class="box-body">
      <div class="">
        <div class="col-md-4 pull-right">
          <button class="btn btn-success" data-toggle="modal" data-target="#myModal">Simpan Perubahan</button>          
          <button type="button" id="btn-kembali" class="btn btn-primary"><i class='fa  fa-arrow-circle-o-left'></i> &nbsp;Kembali</button>
        </div>
      </div>
      </div>

    <div class="box-body">
      <div class="">
        <div class="col-md-7 pull-right">
          <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"> Lihat Semua Versi</button>           -->
          <button type="button" class="btn btn-success" onclick='lihat_versi()'> Lihat Semua Versi</button>           
          <button type="button" class="btn btn-primary" onclick='add_versi()'> Buat Versi Baru</button> 
        </div>

        <div class="col-md-2" style="padding-top:5px;"><label> Pilih Versi </label> </div>
        <div class="col-md-3 pull-left">

        <select name="versi" class="form-control" id="versi">
          <option value="0">Pilih Versi</option>
        </select>
        </div>
      </div>
      </div>

      <br>

    <div class="box-body">
      <div class="">

        <div class="col-md-2" style="padding-top:5px;"><label> Versi Daftar Tarif</label> </div>
        <div class="col-md-3 pull-left">

        <div class="col-md-7" style="padding-top:5px;"><label> <?php echo $nama_versi ?></label> </div>

        <div class="col-md-3 pull-left">
        <!-- <h3 class="box-title">{title_form}</h3> -->
        </div>
      </div>
      </div>
      </div>

      <br>

    <div class="box-body">
      <div class="">

        <div class="col-md-2" style="padding-top:5px;"><label> Status Versi </label> </div>
        <div class="col-md-3 pull-left">

        <div class="col-md-2" style="padding-top:5px;"><label> Pilih Versi </label> </div>
        <div class="col-md-3 pull-left">
        </div>

            <div class="col-md-4 pull-right">
          <a href="<?php echo base_url(); ?>keuangan/master_sts/anggaran_tarif" class="btn btn-default" >Aktifkan Versi ini</a>  
        </div>

      </div>
      </div>
      </div>

      <br>

       <div class="box-body">
      <div class="">

        <div class="col-md-7 pull-left">
          <button id="doExpand"   onclick='' class="btn  btn-warning " >Expand All</button>  
          <button id="doCollapse" onclick='' class="btn btn-warning " >Collapse All</button> 
          <button id="doInduk"    onclick='add_induk()' class="btn btn-success" >Tambah Induk</button> 
      
      </div><br/><br/><br/>
    
        <div class="box-body">
      <div class="default">
        <div id="treeGrid"></div>
      </div>
      </div>
    </div>
  </div>
  </div>

</section>

  <script type="text/javascript">

    $("#btn-kembali").click(function(){
        $.get('<?php echo base_url()?>mst/keuangan_sts/kembali', function (data) {
          $('#content1').html(data);
          });
       });

      function getDemoTheme() {
      var theme = document.body ? $.data(document.body, 'theme') : null
      if (theme == null) {
        theme = '';
      }
      
      else {
        return theme;
      }
      var themestart = window.location.toString().indexOf('?');
      if (themestart == -1) {
        return '';
      }

      var theme = window.location.toString().substring(1 + themestart);
      if (theme.indexOf('(') >= 0)
      {
        theme = theme.substring(1);
      }
      if (theme.indexOf(')') >= 0) {
        theme = theme.substring(0, theme.indexOf(')'));
      }

      var url = "<?=base_url()?>jqwidgets/styles/jqx." + theme + '.css';

      if (document.createStyleSheet != undefined) {
        var hasStyle = false;
        $.each(document.styleSheets, function (index, value) {
          if (value.href != undefined && value.href.indexOf(theme) != -1) {
            hasStyle = true;
            return false;
          }
        });
        if (!hasStyle) {
          document.createStyleSheet(url);
        }
      }
      else {
        var hasStyle = false;
        if (document.styleSheets) {
          $.each(document.styleSheets, function (index, value) {
            if (value.href != undefined && value.href.indexOf(theme) != -1) {
              hasStyle = true;
              return false;
            }
          });
        }
        if (!hasStyle) {
          var link = $('<link rel="stylesheet" href="' + url + '" media="screen" />');
          link[0].onload = function () {
            if ($.jqx && $.jqx.ready) {
              $.jqx.ready();
            };
          }
          $(document).find('head').append(link);
        }
      }
      $.jqx = $.jqx || {};
      $.jqx.theme = theme;
      return theme;
    };
    var theme = '';
    try
    {
      if (jQuery) {
        theme = getDemoTheme();
        if (window.location.toString().indexOf('file://') >= 0) {
          var loc = window.location.toString();
          var addMessage = false;
          if (loc.indexOf('grid') >= 0 || loc.indexOf('chart') >= 0 || loc.indexOf('scheduler') >= 0 || loc.indexOf('tree') >= 0 || loc.indexOf('list') >= 0 || loc.indexOf('combobox') >= 0 || loc.indexOf('php') >= 0 || loc.indexOf('adapter') >= 0 || loc.indexOf('datatable') >= 0 || loc.indexOf('ajax') >= 0) {
            addMessage = true;
          }

          if (addMessage) {
            $(document).ready(function () {
              setTimeout(function () {
                $(document.body).prepend($('<div style="font-size: 12px; font-family: Verdana;">Note: To run a sample that includes data binding, you must open it via "http://..." protocol since Ajax makes http requests.</div><br/>'));
              }
              , 50);
            });
          }
        }
      }
      else {
        $(document).ready(function () {
          theme = getDemoTheme();
        });
      }
    }
    catch (error) {
      var er = error;
    }
  </script>
  <script type="text/javascript">
      
      $(document).ready(function () {

      $('#versi').change(function(){
          // var nama_versi=$("#versi option:selected").text();
          // alert(nama_versi);
          // var nama_versi= $('#versi').find(":selected").text();
          // var nama_versi = $("select#versi option").filter(":selected").text();
      $.ajax({
          url : '<?php echo site_url('mst/keuangan_sts/get_versi') ?>',
          type : 'POST',
          data : 'versi={versi}' ,
         // data : 'versi={versi}'+'&nama_versi'=$("#versi option:selected").text(),
         // data : 'versi={versi}'+'&nama_versi='+nama_versi,

          success : function(data) {
          $("select[name='versi']").html(data);
        }
      });
        return false;
      }).change();
      
      $("#menu_master_data").addClass("active");
      $("#menu_mst_keuangan_sts").addClass("active");

            var newRowID = null;
      
      $("#doExpand").click(function(){
          $("#treeGrid").jqxTreeGrid('expandAll');                    
            });
      
      $("#doCollapse").click(function(){
          $("#treeGrid").jqxTreeGrid('collapseAll');                    
            });

        $("select[name='versi']").change(function(){
            $.post( '<?php echo base_url()?>mst/keuangan_sts/set_versi', {versi:$(this).val()},function( data ) {
              $("#treeGrid").jqxTreeGrid('updateBoundData');
              $("#treeGrid").jqxTreeGrid('expandAll');            
            });
          });
            // prepare the data
            var source =
            {
                dataType: "tab",
                dataFields: [

                    { name: "IdMstAnggaran", type: "number" },
                    { name: "IdMstAnggaranParent", type: "number" },
                    { name: "IdMstAkun", type: "number" },
                    { name: "KodeAnggaran", type: "number" },
                    { name: "Uraian", type: "string" },
                    { name: "Tarif", type: "number" },
                    { name: "IdMstAnggaranVersi", type: "number" }

                ],
                hierarchy:
                {
                    keyDataField: { name: 'IdMstAnggaran' },
                    parentDataField: { name: 'IdMstAnggaranParent' }
                },
                id: 'id_mst_anggaran',
                url: '<?php echo base_url()?>mst/keuangan_sts/api_data',
                 addRow: function (rowID, rowData, position, parentID, commit) {        
                     // POST to server using $.post or $.ajax          
                     // synchronize with the server - send insert command
                     // call commit with parameter true if the synchronization with the server is successful 
                     // and with parameter false if the synchronization failed.
                     // you can pass additional argument to the commit callback which represents the new ID if it is generated from a DB.
                     commit(true);
                     newRowID = rowID;
                 },
                 updateRow: function (rowID, rowData, commit) {
                     // synchronize with the server - send update command
                     // call commit with parameter true if the synchronization with the server is successful 
                     // and with parameter false if the synchronization failed.         
          
                    commit(true);
          var arr = $.map(rowData, function(el) { return el });                                                           
          //cek tipe inputan 
          //object -> input
          //number -> update
          if(typeof(arr[1]) === 'object'){
            var arr2 = $.map(arr[1], function(el) { return el });
            //input data
            $.post( '<?php echo base_url()?>mst/keuangan_sts/anggaran_add', {id_mst_anggaran:arr[2],id_mst_anggaran_parent:arr2[0], id_mst_akun:arr[2], kode_anggaran:arr[4], uraian : arr[5], tarif : arr[6], id_mst_anggaran_versi : arr[0]}, function( data ) {
                if(data != 0){
                  alert(data);                  
                }else{
                  $("#treeGrid").jqxTreeGrid('updateBoundData');
                }
            });
          }else{      
            //update data
            $.post( '<?php echo base_url()?>mst/keuangan_sts/anggaran_update', {id_anggaran_awal:rowID, id_anggaran:arr[0],sub_id:arr[1], kode_rekening:arr[2], kode_anggaran:arr[3], uraian : arr[4], type : arr[5]},function( data ) {
                if(data != 0){
                  alert(data);                  
                }
            });
          }
                 },
                 deleteRow: function (rowID, commit) {
                     // synchronize with the server - send delete command
                     // call commit with parameter true if the synchronization with the server is successful 
                     // and with parameter false if the synchronization failed.
          
          if( Object.prototype.toString.call( rowID ) === '[object Array]' ) {
            for(var i=0; i< rowID.length; i++){
              $.post( '<?php echo base_url()?>mst/keuangan_sts/anggaran_delete', {id_mst_anggaran:rowID[i]},function( data ) {
                $("#treeGrid").jqxTreeGrid('updateBoundData');
              });
            }
            
          }else{
            $.post( '<?php echo base_url()?>mst/keuangan_sts/anggaran_delete', {id_mst_anggaran:rowID},function( data ) {
              $("#treeGrid").jqxTreeGrid('updateBoundData');
            });
          }
                     commit(true);
                 }
             };

            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function () {
                    // data is loaded.
                }
            });

            $("#treeGrid").jqxTreeGrid(
            {
                width: '100%',
                source: dataAdapter, 
                pageable: false,
                editable: true,
                showToolbar: true,
                altRows: true,
                ready: function()
                {
                    // called when the DatatreeGrid is loaded.   
               $("#treeGrid").jqxTreeGrid('expandAll');            
                },
                pagerButtonsCount: 8,
                toolbarHeight: 35,
                renderToolbar: function(toolBar)
                {
                    var toTheme = function (className) {
                        if (theme == "") return className;
                        return className + " " + className + "-" + theme;
                    }
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; height: 100%; width: 100%;'></div>");
                    var buttonTemplate = "<div style='float: left; padding: 3px; margin: 2px;'><div style='margin: 4px; width: 16px; height: 16px;'></div></div>";
                    var addButton = $(buttonTemplate);
                    var editButton = $(buttonTemplate);
                    var deleteButton = $(buttonTemplate);
                    var cancelButton = $(buttonTemplate);
                    var updateButton = $(buttonTemplate);                    
                    
                    container.append(addButton);
                    container.append(editButton);
                    container.append(deleteButton);
                    container.append(cancelButton);
                    container.append(updateButton);

                    toolBar.append(container);
          
                    addButton.jqxButton({cursor: "pointer", enableDefault: false, disabled: true, height: 25, width: 25 });
                    addButton.find('div:first').addClass(toTheme('jqx-icon-plus'));
                    addButton.jqxTooltip({ position: 'bottom', content: "Tambah Cabang"});

                    editButton.jqxButton({ cursor: "pointer", disabled: true, enableDefault: false,  height: 25, width: 25 });
                    editButton.find('div:first').addClass(toTheme('jqx-icon-edit'));
                    editButton.jqxTooltip({ position: 'bottom', content: "Edit"});

                    deleteButton.jqxButton({ cursor: "pointer", disabled: true, enableDefault: false,  height: 25, width: 25 });
                    deleteButton.find('div:first').addClass(toTheme('jqx-icon-delete'));
                    deleteButton.jqxTooltip({ position: 'bottom', content: "Delete"});

                    updateButton.jqxButton({ cursor: "pointer", disabled: true, enableDefault: false,  height: 25, width: 25 });
                    updateButton.find('div:first').addClass(toTheme('jqx-icon-save'));
                    updateButton.jqxTooltip({ position: 'bottom', content: "Save Changes"});

                    cancelButton.jqxButton({ cursor: "pointer", disabled: true, enableDefault: false,  height: 25, width: 25 });
                    cancelButton.find('div:first').addClass(toTheme('jqx-icon-cancel'));
                    cancelButton.jqxTooltip({ position: 'bottom', content: "Cancel"});

                    var updateButtons = function (action) {
                        switch (action) {
                            case "Select":
                                addButton.jqxButton({ disabled: false });
                                deleteButton.jqxButton({ disabled: false });
                                editButton.jqxButton({ disabled: false });
                                cancelButton.jqxButton({ disabled: true });
                                updateButton.jqxButton({ disabled: true });
                                break;
                            case "Unselect":
                                addButton.jqxButton({ disabled: true });
                                deleteButton.jqxButton({ disabled: true });
                                editButton.jqxButton({ disabled: true });
                                cancelButton.jqxButton({ disabled: true });
                                updateButton.jqxButton({ disabled: true });
                                break;
                            case "Edit":
                                addButton.jqxButton({ disabled: true });
                                deleteButton.jqxButton({ disabled: true });
                                editButton.jqxButton({ disabled: true });
                                cancelButton.jqxButton({ disabled: false });
                                updateButton.jqxButton({ disabled: false });
                                break;
                            case "End Edit":
                                addButton.jqxButton({ disabled: false });
                                deleteButton.jqxButton({ disabled: false });
                                editButton.jqxButton({ disabled: false });
                                cancelButton.jqxButton({ disabled: true });
                                updateButton.jqxButton({ disabled: true });
                                break;
                        }
                    }
                    var rowKey = null;
                    $("#treeGrid").on('rowSelect', function (event) {
                        var args = event.args;
                        rowKey = args.key;
                        updateButtons('Select');
                    });
                    $("#treeGrid").on('rowUnselect', function (event) {
                        updateButtons('Unselect');
                    });
                    $("#treeGrid").on('rowEndEdit', function (event) {
                        updateButtons('End Edit');
                    });
                    $("#treeGrid").on('rowBeginEdit', function (event) {
                        updateButtons('Edit');
                    });
          
                    addButton.click(function (event) {
                        if (!addButton.jqxButton('disabled')) {             
                            $("#treeGrid").jqxTreeGrid('expandRow', rowKey);
                            // add new empty row.
                            $("#treeGrid").jqxTreeGrid('addRow', null, {}, 'first', rowKey);
                            // select the first row and clear the selection.
                            $("#treeGrid").jqxTreeGrid('clearSelection');
                            $("#treeGrid").jqxTreeGrid('selectRow', newRowID);
                            // edit the new row.
                            $("#treeGrid").jqxTreeGrid('beginRowEdit', newRowID);
                            updateButtons('add');
                        }
                    });

                    cancelButton.click(function (event) {
                        if (!cancelButton.jqxButton('disabled')) {
                            // cancel changes.
                            $("#treeGrid").jqxTreeGrid('endRowEdit', rowKey, true);
                        }
                    });

                    updateButton.click(function (event) {
                        if (!updateButton.jqxButton('disabled')) {
                            // save changes.
                            $("#treeGrid").jqxTreeGrid('endRowEdit', rowKey, false);
                        }
                    });

                    editButton.click(function () {
                        if (!editButton.jqxButton('disabled')) {
                            $("#treeGrid").jqxTreeGrid('beginRowEdit', rowKey);
                            updateButtons('edit');

                        }
                    });
                    deleteButton.click(function () {
                        if (!deleteButton.jqxButton('disabled')) {
                            var selection = $("#treeGrid").jqxTreeGrid('getSelection');
                            if (selection.length > 1) {
                                var keys = new Array();
                                for (var i = 0; i < selection.length; i++) {
                                    keys.push($("#treeGrid").jqxTreeGrid('getKey', selection[i]));
                                }
                if(confirm('Apakah anda yakin akan menghapus beberapa data sekaligus ? Data yang telah terhapus tidak dapat di kembalikan lagi')){
                  $("#treeGrid").jqxTreeGrid('deleteRow', keys);
                }
                            }
                            else {
                if(confirm('Apakah anda yakin akan menghapus data ini ? Data yang telah terhapus tidak dapat di kembalikan lagi')){
                  $("#treeGrid").jqxTreeGrid('deleteRow', rowKey);
                }
                            }
                            updateButtons('delete');
                        }
                    });
                },

                columns: [                             
               { text: 'Kode Anggaran', dataField: "KodeAnggaran", align: 'center',cellsalign: 'center', width: '19%' },
               { text: 'Uraian', dataField: "Uraian", align: 'center', width: '31%',cellsalign: 'center' }, 
               { text: 'Tarif', dataField: "Tarif", align: 'center', width: '20%',cellsalign: 'center' },         
               { text: 'Kode Rekening', dataField: 'IdMstAkun', width: "30%", align:'center',cellsalign: 'center'}
               
                ]
            });
      
      
        });
    
    // function addParent(){
    //   var id_mst_anggaran_versi = 0;
    //   var id_mst_akun = document.getElementById("id_mst_akun").value;
    //   var kode_anggaran = document.getElementById("kode_anggaran").value;
    //   var uraian = document.getElementById("uraian").value;
    //   $.post( '<?php echo base_url()?>mst/keuangan_sts/anggaran_add', {id_mst_anggaran_versi:id_mst_anggaran_versi, id_mst_akun:id_mst_akun, kode_anggaran:kode_anggaran, uraian:uraian},function( data ) {
    //       $("#treeGrid").jqxTreeGrid('updateBoundData');
    //       $("#treeGrid").jqxTreeGrid('expandAll');            
    //       document.getElementById("id_mst_akun").value='';
    //       document.getElementById("kode_anggaran").value='';
    //       document.getElementById("uraian").value = '';
    //     });
    // }

    function add_versi(){
      $("#popup_keuangan_sts #popup_keuangan_sts_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_sts/versi_add' ?>/", function(data) {
          $("#popup_keuangan_sts_content").html(data);
        });
        $("#popup_keuangan_sts").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 280,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_keuangan_sts").jqxWindow('open');
    }

    function add_induk(){
      $("#popup_keuangan_sts_induk #popup_keuangan_sts_induk_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_sts/induk_add' ?>/", function(data) {
          $("#popup_keuangan_sts_induk_content").html(data);
        });
        $("#popup_keuangan_sts_induk").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 280,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_keuangan_sts_induk").jqxWindow('open');
    }

    function lihat_versi(){
      $("#popup_keuangan_versi_sts #popup_keuangan_versi_sts_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_sts/versi_view'?>/", function(data) {
          $("#popup_keuangan_versi_sts_content").html(data);
        });
        $("#popup_keuangan_versi_sts").jqxWindow({
          theme: theme, resizable: false,
          width: 9000,
          height: 300,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_keuangan_versi_sts").jqxWindow('open');
    }

    </script>

