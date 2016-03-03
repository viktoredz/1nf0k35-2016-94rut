<div class="row" style="margin: 0">
  	<div class="col-md-12">
	  <div class="box-footer" style="text-align: right">
	 	<button type="button" class="btn btn-primary" id="btn-tambah-anggota"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah Anggota Keluarga</button>
	 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
	  </div>
	  <div class="box box-primary">
	    <div class="box-body">
		    <div class="div-grid">
		        <div id="jqxgrid"></div>
			</div>
	    </div>
	  </div>
	</div>
</div>

<script type="text/javascript">
	$(function () {	
		$("#menu_ketuk_pintu").addClass("active");
		$("#menu_eform_data_kepala_keluarga").addClass("active");

		$("#btn-tambah-anggota").click(function(){
	        $.get('<?php echo base_url()?>eform/data_kepala_keluarga/anggota_add/{id_data_keluarga}', function (data) {
	            $('#content2').html(data);
	        });
		});

	});
		
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_data_keluarga', type: 'string'},
			{ name: 'tanggal_pengisian', type: 'date'},
			{ name: 'jam_data', type: 'string'},
			{ name: 'alamat', type: 'string'},
			{ name: 'id_propinsi', type: 'string'},
			{ name: 'id_kota', type: 'string'},
			{ name: 'id_kecamatan', type: 'string'},
			{ name: 'value', type: 'string'},
			{ name: 'rt', type: 'string'},
			{ name: 'rw', type: 'string'},
			{ name: 'norumah', type: 'string'},
			{ name: 'nourutkel', type: 'string'},
			{ name: 'id_kodepos', type: 'string'},
			{ name: 'namadesawisma', type: 'string'},
			{ name: 'id_pkk', type: 'string'},
			{ name: 'namakepalakeluarga', type: 'string'},
			{ name: 'nama_komunitas', type: 'string'},
			{ name: 'notlp', type: 'string'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('eform/data_kepala_keluarga/json'); ?>",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){		
			if (data != null){
				source.totalrecords = data[0].TotalRows;					
			}
		}
		};		
		var dataadapter = new $.jqx.dataAdapter(source, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});
     
		$('#btn-refresh').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});

		$("#jqxgrid").jqxGrid({		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.edit==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit(\""+dataRecord.id_data_keluarga+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.delete==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_data_keluarga+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'NIK', datafield: 'nourutkel', columntype: 'textbox', align:'center', cellsalign:'center', filtertype: 'textbox', width: '16%' },
				{ text: 'Nama', datafield: 'namakepalakeluarga', columntype: 'textbox', filtertype: 'textbox', width: '26%' },
                { text: 'Tgl Lahir', datafield: 'tanggal_pengisian', columntype: 'textbox', align:'center', cellsalign:'center', filtertype: 'date',cellsformat: 'dd-MM-yyyy', width: '10%' },
				{ text: 'Usia', datafield: 'rw', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '8%' },
				{ text: 'Hubungan', datafield: 'id_pkk', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '12%' },
				{ text: 'Agama', datafield: 'value', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '10%' },
				{ text: 'Jenis Kelamin', datafield: 'rt', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '10%' }
			]
		});

	function edit(id){
        $.get('<?php echo base_url()?>eform/data_kepala_keluarga/anggota_edit/{id_data_keluarga}/'+id, function (data) {
            $('#content2').html(data);
        });
	}

	function del(id){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'eform/data_kepala_keluarga/anggota_dodel/'.$id_data_keluarga ?>/" + id,  function(){
				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
	}
</script>