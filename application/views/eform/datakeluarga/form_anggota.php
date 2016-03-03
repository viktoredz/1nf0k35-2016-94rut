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
			{ name: 'no_anggota', type: 'string'},
			{ name: 'nama', type: 'string'},
			{ name: 'nik', type: 'string'},
			{ name: 'tmpt_lahir', type: 'string'},
			{ name: 'tgl_lahir', type: 'date'},
			{ name: 'id_pilihan_hubungan', type: 'string'},
			{ name: 'id_pilihan_kelamin', type: 'string'},
			{ name: 'id_pilihan_agama', type: 'string'},
			{ name: 'id_pilihan_pendidikan', type: 'string'},
			{ name: 'id_pilihan_pekerjaan', type: 'string'},
			{ name: 'id_pilihan_kawin', type: 'string'},
			{ name: 'id_pilihan_jkn', type: 'string'},
			{ name: 'suku', type: 'string'},
			{ name: 'no_hp', type: 'string'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('eform/data_kepala_keluarga/json_anggotaKeluarga/{id_data_keluarga}'); ?>",
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
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit(\""+dataRecord.no_anggota+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.delete==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.no_anggota+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Nama', datafield: 'nama', columntype: 'textbox', align:'center', cellsalign:'center', filtertype: 'textbox', width: '16%' },
				{ text: 'NIK', datafield: 'nik', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
				{ text: 'Tempat Lahir', datafield: 'tmpt_lahir', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
                { text: 'Tgl Lahir', datafield: 'tgl_lahir', columntype: 'textbox', align:'center', cellsalign:'center', filtertype: 'date',cellsformat: 'dd-MM-yyyy', width: '10%' },
				{ text: 'Hubungan', datafield: 'id_pilihan_hubungan', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '8%' },
				{ text: 'Kelamin', datafield: 'id_pilihan_kelamin', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '12%' },
				{ text: 'Pendidikan', datafield: 'id_pilihan_pendidikan', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '10%' },
				{ text: 'Pekerjaan', datafield: 'id_pilihan_pekerjaan', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '10%' },
				{ text: 'Status', datafield: 'id_pilihan_kawin', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '10%' },
				{ text: 'JKN', datafield: 'id_pilihan_jkn', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '10%' },
				{ text: 'No Hp', datafield: 'no_hp', columntype: 'textbox', filtertype: 'textbox', align:'center', cellsalign:'center', width: '10%' }
			]
		});

	function edit(noanggota){
        $.get('<?php echo base_url()?>eform/data_kepala_keluarga/anggota_edit/{id_data_keluarga}/'+noanggota, function (data) {
            $('#content2').html(data);
        });
	}

	function del(noanggota){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'eform/data_kepala_keluarga/anggota_dodel/'.$id_data_keluarga ?>/" + noanggota,  function(){
				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
	}
</script>