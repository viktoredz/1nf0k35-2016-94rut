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
        <div class="col-xs-12 col-md-7 pull-left">
          <button id="doExpand" class="btn btn-warning " ><i class="icon fa fa-plus-square-o"></i> &nbsp;Expand</button>  
          <button id="doCollapse" class="btn btn-warning " ><i class="icon fa fa-minus-square-o"></i> &nbsp;Collapse</button> 
          <button id="doInduk" onclick='add_induk()' class="btn btn-success"><i class="icon fa fa-plus-square"></i> &nbsp;Tambah Induk</button> 
          <button id="doRefresh" class="btn btn-primary" ><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
        </div>
        <div class="col-xs-12 col-md-5">
          <div class="row">
            <div class="col-xs-4" style="padding-top:5px;"><label> Puskesmas </label> </div>
            <div class="col-xs-8">
              <select name="code_cl_phc" id="code_cl_phc" class="form-control">
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
      <div class="default">
        <div id="treeGrid"></div>
      </div>
      </div>
    </div>
  </div>
  </div>
</section>

<div id="popup_keuangan_akun" style="display:none">
  <div id="popup_title">Buat Posisi</div>
  <div id="popup_keuangan_akun_content">&nbsp;</div>
</div>

<div id="popup_keuangan_akun_detail" style="display:none">
  <div id="popup_title">Detail Posisi</div>
  <div id="popup_keuangan_akun_detail_content">&nbsp;</div>
</div>

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
      $("#menu_master_data").addClass("active");
      $("#menu_mst_pegorganisasi").addClass("active");

      cekstatus();
      var newRowID = null;
      $("#doExpand").click(function(){
          $("#treeGrid").jqxTreeGrid('expandAll');                    
      });
      
      $("#doCollapse").click(function(){
          $("#treeGrid").jqxTreeGrid('collapseAll');                    
      });

      $("#doRefresh").click(function(){
          $("#treeGrid").jqxTreeGrid('updateBoundData');
      });

           var source = {
            dataType: "tab",
            dataFields: [
                { name: "tar_id_struktur_org", type: "number" },
                { name: "tar_id_struktur_org_parent", type: "number" },
                { name: "tar_nama_posisi", type: "string" },
                { name: "tar_aktif", type: "string" },
                { name: "code_cl_phc", type: "string" }
            ],
                hierarchy:
                {
                     keyDataField: { name: 'tar_id_struktur_org' },
                     parentDataField: { name: 'tar_id_struktur_org_parent' }
                },
                id: 'tar_id_struktur_org',

                url: '<?php echo base_url()?>mst/pegorganisasi/api_data',
                
                 addRow: function (rowID, rowData, position, parentID, commit) {        
                    commit(true);
                    newRowID = rowID;
                 },
                 updateRow: function (rowID, rowData, commit) {
                    commit(true);
                    var arr = $.map(rowData, function(el) { return el });         
                 // /   alert(arr);
                    if(typeof(arr[1]) === 'object'){
                      var arr2 = $.map(arr[1], function(el) { return el });
                     //  alert(arr2);

                      if(arr[4]!='') {
                       
                        $.post( '<?php echo base_url()?>mst/pegorganisasi/akun_add', {tar_id_struktur_org:arr[2],tar_id_struktur_org_parent:arr2[0], tar_nama_posisi:arr[4], tar_aktif:1}, function( data ) {
                            if(data != 0){
                       //       alert(data);                 
                       $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter'); 
                            }else{
                              alert("Data "+arr[4]+" berhasil disimpan");       
                              $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');           
                            }
                        });
                      }
                    }else{    
                    //alert(rowID);  
                      $.post( '<?php echo base_url()?>mst/pegorganisasi/akun_update', 
                        {
                          row:rowID,
                          tar_id_struktur_org:arr[0] ,
                          tar_id_struktur_org_parent:arr[1], 
                          tar_nama_posisi:arr[2], 
                          tar_aktif : 1, 
                        },
                        function( data ) {
                          if(data != 0){
                            alert(data);
                            $("#treeGrid").jqxTreeGrid('updateBoundData', 'filter');
                          }
                      });
                    }
                 },
                 deleteRow: function (rowID, commit) {
                    if( Object.prototype.toString.call( rowID ) === '[object Array]' ) {
                      for(var i=0; i< rowID.length; i++){
                        $.post( '<?php echo base_url()?>mst/pegorganisasi/akun_delete', {tar_id_struktur_org:rowID[i]},function( data ) {
                          $("#treeGrid").jqxTreeGrid('updateBoundData');
                          cekstatus();
                        });
                      }
                    }else{
                      $.post( '<?php echo base_url()?>mst/pegorganisasi/akun_delete', {tar_id_struktur_org:rowID},function( data ) {
                         $("#treeGrid").jqxTreeGrid('updateBoundData');
                         cekstatus();
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

            $("#treeGrid").jqxTreeGrid({
                width: '100%',
                source: dataAdapter, 
                pageable: false,
                editable: true,
                showToolbar: true,
                altRows: true,
                ready: function(){
                   $("#treeGrid").jqxTreeGrid('expandAll');            
                },
                pagerButtonsCount: 8,
                toolbarHeight: 40,

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
                { text: 'Nama Posisi ', datafield: 'tar_nama_posisi', columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '70%' },
                { text: 'Aktif', datafield: 'tar_aktif', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '15%', cellsalign: 'center' },
                {text: 'Detail', sortable: false, align:'center', width: '15%',editable: false, filterable: false, cellsrenderer: function (row, column, value) {
                    if (row) {
                   var dataRecord = $("#treeGrid").jqxTreeGrid('getRow', row);
                    return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+dataRecord.tar_id_struktur_org+"\",\""+dataRecord.code_cl_phc+"\");'></a></div>";
                    }
                  },
                }
              ]
            });
        });

    function detail(id,code_cl_phc){
        var code_cl_phc = code_cl_phc.split(" ");
        $("#popup_keuangan_akun_detail #popup_keuangan_akun_detail_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
          $.get("<?php echo base_url().'mst/pegorganisasi/induk_detail' ?>/"+ id+'/'+code_cl_phc[1], function(data) {
            $("#popup_keuangan_akun_detail_content").html(data);
          });
          $("#popup_keuangan_akun_detail").jqxWindow({
            theme: theme, resizable: false,
            width: 950,
            height: 1000,
            isModal: true, autoOpen: false, modalOpacity: 0.2
          });
          $("#popup_keuangan_akun_detail").jqxWindow('open');
      }
    
    function add_induk(){
      $("#popup_keuangan_akun #popup_keuangan_akun_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/pegorganisasi/induk_add' ?>/", function(data) {
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

    function cekstatus(){
      $.get("<?php echo base_url().'mst/pegorganisasi/cekstatustambah' ?>/",function(data){
          if (data==1) {
            $("#doInduk").hide();
          }else{
            $("#doInduk").show();
          }
      });
    }
</script>

