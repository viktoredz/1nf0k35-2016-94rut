<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
           <h3 class="box-title">{title_form}</h3> 
      </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12 pull-left">
          <button id="doInduk" onclick='add_induk()' class="btn btn-success"><i class="icon fa fa-edit"></i> &nbsp;Ubah Anggaran</button> 
            <div class="col-md-3 pull-right">
              <div class="row">
                <div class="col-md-4" style="padding-top:5px;"><label> Periode </label> </div>
                  <div class="col-md-8">
                    <select name="tahun" id="tahun" class="form-control">
                      <?php for ($i=date("Y");$i>=date("Y")-10;$i--) { ;?>
                      <?php $select = $i == date("Y") ? 'selected=selected' : '' ?>
                     <option value="<?php echo $i; ?>" <?php echo $select ?>><?php echo $i; ?></option>
                      <?php   } ;?>
                    </select>
                  </div> 
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="default">
        <div id="treeGrid_anggaran_akun"></div>
      </div>
      </div>
    </div>
  </div>
  </div>
</section>

<script type="text/javascript">

    function getDemoTheme() {
      var theme = document.body ? $.data(document.body, 'theme') : null
      if (theme == null) {
        theme = '';
      } else {
        return theme;
      }
      var themestart = window.location.toString().indexOf('?');
      if (themestart == -1) {
        return '';
      }

      var theme = window.location.toString().substring(1 + themestart);
      if (theme.indexOf('(') >= 0){
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

    $("select[name='tahun']").change(function(){
      $.post("<?php echo base_url().'mst/keuangan_akun/filter_tahun' ?>", 'tahun='+$(this).val(),  function(){
        $("#treeGrid_anggaran_akun").jqxTreeGrid('updateBoundData','filter');
        });
    });
      
      var newRowID = null;

      var source =
      {
          datatype: "json",
          datafields: [
              { name: 'id_mst_akun' },
              { name: 'saldo_normal' }
          ],
          url: '<?php echo base_url()?>mst/keuangan_sts/json_kode_rekening',
          async: true
      };
      var saldo_norma_source = new $.jqx.dataAdapter(source);

           var source = {
            dataType: "tab",
            dataFields: [
                { name: "id_mst_akun", type: "number" },
                { name: "id_mst_anggaran_parent", type: "number" },
                { name: "kode", type: "number" },
                { name: "uraian", type: "string" },
                { name: "saldo_normal", type: "string" },
                { name: "saldo_awal", type: "number" },
                { name: "mendukung_transaksi", type: "number"}
            ],
                hierarchy:
                {
                     keyDataField: { name: 'id_mst_akun' },
                     parentDataField: { name: 'id_mst_anggaran_parent' }
                },
                id: 'id_mst_akun',

                url: '<?php echo base_url()?>mst/keuangan_akun/api_data',

                 addRow: function (rowID, rowData, position, parentID, commit) {        
                    commit(true);
                    newRowID = rowID;
                 },
                 updateRow: function (rowID, rowData, commit) {
                    commit(true);
                    var arr = $.map(rowData, function(el) { return el });         
                    if(typeof(arr[1]) === 'object'){
                      var arr2 = $.map(arr[1], function(el) { return el });
                      if(arr[4] + '' + arr[5] + '' + arr[6] + '' + arr[7]+ '' + arr[8]!='') {
                        $.post( '<?php echo base_url()?>mst/keuangan_akun/akun_add', {id_mst_akun:arr[2],id_mst_akun_parent:arr2[0], uraian:arr[4], kode:arr[5], saldo_normal:arr[6], saldo_awal : arr[7], mendukung_anggaran : arr[8]}, function( data ) {
                            if(data != 0){
                              alert(data);                  
                            }else{
                              alert("Data "+arr[4]+" berhasil disimpan");                  
                            }
                        });
                      }
                    }else{      
                      $.post( '<?php echo base_url()?>mst/keuangan_akun/akun_update', 
                        {
                          row:rowID,
                          id_mst_akun:arr[0] ,
                          id_mst_akun_parent:arr[1], 
                          kode:arr[2], 
                          uraian : arr[3], 
                          saldo_normal : arr[4], 
                          saldo_awal:arr[5], 
                          mendukung_anggaran : arr[6]
                        },
                        function( data ) {
                          if(data != 0){
                            alert(data);
                          }
                      });
                    }
                 },
                 deleteRow: function (rowID, commit) {
                    if( Object.prototype.toString.call( rowID ) === '[object Array]' ) {
                      for(var i=0; i< rowID.length; i++){
                        $.post( '<?php echo base_url()?>mst/keuangan_akun/akun_delete', {id_mst_akun:rowID[i]},function( data ) {
                          $("#treeGrid_anggaran_akun").jqxTreeGrid('updateBoundData');
                        });
                      }
                    }else{
                      $.post( '<?php echo base_url()?>mst/keuangan_akun/akun_delete', {id_mst_akun:rowID},function( data ) {
                        // $("#treeGrid").jqxTreeGrid('updateBoundData');
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

            $("#treeGrid_anggaran_akun").jqxTreeGrid({
                width: '100%',
                source: dataAdapter, 
                pageable: false,
                editable: true,
                showToolbar: true,
                altRows: true,
                ready: function(){
                   $("#treeGrid_anggaran_akun").jqxTreeGrid('expandAll');            
                },
                pagerButtonsCount: 8,
                toolbarHeight: 40,

                renderToolbar: function(toolBar){
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
                    var cancelButton  = $(buttonTemplate);
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
                    $("#treeGrid_anggaran_akun").on('rowSelect', function (event) {
                        var args = event.args;
                        rowKey = args.key;
                        updateButtons('Select');
                    });
                    $("#treeGrid_anggaran_akun").on('rowUnselect', function (event) {
                        updateButtons('Unselect');
                    });
                    $("#treeGrid_anggaran_akun").on('rowEndEdit', function (event) {
                        updateButtons('End Edit');
                    });
                    $("#treeGrid_anggaran_akun").on('rowBeginEdit', function (event) {
                        updateButtons('Edit');
                    });

                    addButton.click(function (event) {
                        if (!addButton.jqxButton('disabled')) {             
                            $("#treeGrid_anggaran_akun").jqxTreeGrid('expandRow', rowKey);
                            // add new empty row.
                            $("#treeGrid_anggaran_akun").jqxTreeGrid('addRow', null, {}, 'first', rowKey);
                            // select the first row and clear the selection.
                            $("#treeGrid_anggaran_akun").jqxTreeGrid('clearSelection');
                            $("#treeGrid_anggaran_akun").jqxTreeGrid('selectRow', newRowID);
                            // edit the new row.
                            $("#treeGrid_anggaran_akun").jqxTreeGrid('beginRowEdit', newRowID);
                            updateButtons('add');
                        }
                    });

                    cancelButton.click(function (event) {
                        if (!cancelButton.jqxButton('disabled')) {
                            // cancel changes.
                            $("#treeGrid_anggaran_akun").jqxTreeGrid('endRowEdit', rowKey, true);
                        }
                    });

                    updateButton.click(function (event) {
                        if (!updateButton.jqxButton('disabled')) {
                            // save changes.
                            $("#treeGrid_anggaran_akun").jqxTreeGrid('endRowEdit', rowKey, false);
                        }
                    });

                    editButton.click(function () {
                        if (!editButton.jqxButton('disabled')) {
                            $("#treeGrid_anggaran_akun").jqxTreeGrid('beginRowEdit', rowKey);
                            updateButtons('edit');

                        }
                    });

                    deleteButton.click(function () {
                        if (!deleteButton.jqxButton('disabled')) {
                            var selection = $("#treeGrid_anggaran_akun").jqxTreeGrid('getSelection');
                            if (selection.length > 1) {
                                var keys = new Array();
                                for (var i = 0; i < selection.length; i++) {
                                    keys.push($("#treeGrid_anggaran_akun").jqxTreeGrid('getKey', selection[i]));
                                }
                                if(confirm('Apakah anda yakin akan menghapus beberapa data sekaligus ? Data yang telah terhapus tidak dapat di kembalikan lagi')){
                                  $("#treeGrid_anggaran_akun").jqxTreeGrid('deleteRow', keys);
                                }
                            }
                            else {
                                if(confirm('Apakah anda yakin akan menghapus data ini ? Data yang telah terhapus tidak dapat di kembalikan lagi')){
                                  $("#treeGrid_anggaran_akun").jqxTreeGrid('deleteRow', rowKey);
                                }
                            }
                            updateButtons('delete');
                        }
                    });
                },
               
              columns: [                             
                { text: 'Uraian ', datafield: 'uraian', columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '40%' },
                { text: 'Kode Akun', datafield: 'kode', columntype: 'textbox', filtertype: 'textbox',align: 'center', cellsalign: 'left', width: '25%'},
                { text: 'Anggaran', datafield: 'saldo_normal', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '35%', cellsalign: 'center' }
              ]
            });
        });

    function detail(id){
        $("#popup_keuangan_akun_detail #popup_keuangan_akun_detail_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
          $.get("<?php echo base_url().'mst/keuangan_akun/induk_detail' ?>/"+ id, function(data) {
            $("#popup_keuangan_akun_detail_content").html(data);
          });
          $("#popup_keuangan_akun_detail").jqxWindow({
            theme: theme, resizable: false,
            width: 600,
            height: 450,
            isModal: true, autoOpen: false, modalOpacity: 0.2
          });
          $("#popup_keuangan_akun_detail").jqxWindow('open');
      }
    
    function add_induk(){
      $("#popup_keuangan_akun #popup_keuangan_akun_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_akun/induk_add' ?>/", function(data) {
          $("#popup_keuangan_akun_content").html(data);
        });
        $("#popup_keuangan_akun").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 280,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_keuangan_akun").jqxWindow('open');
    }

</script>

