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

<div id="popup_pegawai_data_detail" style="display:none">
  <div id="popup_title">Detail Posisi</div>
  <div id="popup_pegawai_data_detail_content">&nbsp;</div>
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
     $("#menu_kepegawaian").addClass("active");
      $("#menu_kepegawaian_struktur").addClass("active");
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
                { name: "jml_anggota", type: "number" },
                { name: "tar_aktif", type: "string" },
                { name: "code_cl_phc", type: "string" }
            ],
                hierarchy:
                {
                     keyDataField: { name: 'tar_id_struktur_org' },
                     parentDataField: { name: 'tar_id_struktur_org_parent' }
                },
                id: 'tar_id_struktur_org',

                url: '<?php echo base_url()?>kepegawaian/struktur/api_data',

                 addRow: function (rowID, rowData, position, parentID, commit) {        
                    commit(true);
                    newRowID = rowID;
                 },
                 updateRow: function (rowID, rowData, commit) {
                    commit(true);
                    var arr = $.map(rowData, function(el) { return el });         
                    alert(arr);
                    if(typeof(arr[1]) === 'object'){
                      var arr2 = $.map(arr[1], function(el) { return el });
                       alert(arr2);

                      if(arr[4]!='') {
                       
                        $.post( '<?php echo base_url()?>kepegawaian/struktur/akun_add', {tar_id_struktur_org:arr[2],tar_id_struktur_org_parent:arr2[0], tar_nama_posisi:arr[4], tar_aktif:arr[5]}, function( data ) {
                            if(data != 0){
                              alert(data);                  
                            }else{
                              alert("Data "+arr[4]+" berhasil disimpan");                  
                            }
                        });
                      }
                    }else{    
                    alert(rowID);  
                      $.post( '<?php echo base_url()?>kepegawaian/struktur/akun_update', 
                        {
                          row:rowID,
                          tar_id_struktur_org:arr[0] ,
                          tar_id_struktur_org_parent:arr[1], 
                          tar_nama_posisi:arr[2], 
                          tar_aktif : arr[5], 
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
                        $.post( '<?php echo base_url()?>kepegawaian/struktur/akun_delete', {id_mst_akun:rowID[i]},function( data ) {
                          $("#treeGrid").jqxTreeGrid('updateBoundData');
                        });
                      }
                    }else{
                      $.post( '<?php echo base_url()?>kepegawaian/struktur/akun_delete', {id_mst_akun:rowID},function( data ) {
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

            $("#treeGrid").jqxTreeGrid({
                width: '100%',
                source: dataAdapter, 
                pageable: false,
                editable: false,
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
                },

              columns: [                             
                { text: 'Nama Posisi ', editable: false,datafield: 'tar_nama_posisi', columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '70%' },
                { text: 'Jumlah Karyawan', editable: false,datafield: 'jml_anggota', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '25%', cellsalign: 'center' },
                {text: 'Detail', sortable: false, align:'center', width: '5%',editable: false, filterable: false, cellsrenderer: function (row, column, value) {
                  if(row){
                    return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail(" + row + ");'></a></div>";
                  }
                  },
                }
              ]
            });
        });

    function detail(id){
        $("#popup_pegawai_data_detail #popup_pegawai_data_detail_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
          $.get("<?php echo base_url().'kepegawaian/struktur/induk_detail' ?>/"+ id, function(data) {
            $("#popup_pegawai_data_detail_content").html(data);
          });
          $("#popup_pegawai_data_detail").jqxWindow({
            theme: theme, resizable: false,
            width: 600,
            height: 380,
            isModal: true, autoOpen: false, modalOpacity: 0.2
          });
          $("#popup_pegawai_data_detail").jqxWindow('open');
      }
    
</script>

