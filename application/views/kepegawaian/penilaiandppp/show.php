<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>kepegawaian/penilaiandppp/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
	    </div>

      	<div class="box-footer">
	      <div class="col-md-8">
		 	<button type="button" class="btn btn-primary" onclick="document.location.href='<?php echo base_url()?>kepegawaian/penilaiandppp/add'"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah</button>
		 	<button type="button" class="btn btn-warning" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
		 	<button type="button" class="btn btn-success" id="btn-export"><i class='fa fa-file-excel-o'></i> &nbsp; Export</button>
	     </div>
	     <div class="col-md-4">
	     	<div class="row">
		     	<div class="col-md-4" style="padding-top:5px;"><label> Puskesmas </label> </div>
		     	<div class="col-md-8">
		     		<select name="code_cl_phc" id="puskesmas" class="form-control">
						<?php foreach ($datapuskesmas as $row ) { ;?>
							<option value="<?php echo $row->code; ?>" onchange="" ><?php echo $row->value; ?></option>
						<?php	} ;?>
			     	</select>
			     </div>	
	     	</div>
		  </div>
		</div>
        <div class="box-body">
		    <div class="div-grid">
		        <div id="jqxgrid"></div>
			</div>
	    </div>
	  </div>
	</div>
  </div>
</form>
</section>

<script type="text/javascript">
	$(function () {	
	    $("#menu_kepegawaian").addClass("active");
	    $("#menu_kepegawaian_penilaiandppp").addClass("active");
	});

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'no', type: 'number'},
			{ name: 'code_cl_phc', type: 'string'},
			{ name: 'id_inv_permohonan_barang', type: 'string'},
			{ name: 'tanggal_permohonan', type: 'date'},
			{ name: 'jumlah_unit', type: 'string'},
			{ name: 'nama_ruangan', type: 'string'},
			{ name: 'keterangan', type: 'text'},
			{ name: 'value', type: 'string'},
			{ name: 'totalharga', type: 'double'},
			{ name: 'pilihan_status_pengadaan', type: 'number'},
			{ name: 'detail', type: 'number'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('kepegawaian/penilaiandppp/json'); ?>",
		cache: false,
		updateRow: function (rowID, rowData, commit) {
        
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

		$("#jqxgrid").jqxGrid(
		{		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: true,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Nama', align: 'center',editable:false ,cellsalign: 'center',datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
				{ text: 'Tempat Lahir', align: 'center', cellsalign: 'center', editable:false ,datafield: 'tempatlahir', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Tanggal Lahir', align: 'center', cellsalign: 'center', editable:false ,datafield: 'tgllahir', columntype: 'date', filtertype: 'date', width: '8%' },
				{ text: 'NIP', align: 'center', cellsalign: 'center', editable:false , datafield: 'nip', columntype: 'textbox', filtertype: 'textbox',  width: '12%' },
				{ text: 'Gol',columngroup: 'pangkat',   align: 'center', cellsalign: 'center', editable:false ,datafield: 'golongan', columntype: 'textbox', filtertype: 'textbox', width: '5%' },
				
				{ text: 'TMT',align: 'center', columngroup: 'pangkat',editable:false ,datafield: 'tmt', columntype: 'date', filtertype: 'date',cellsformat: 'dd-MM-yyyy', width: '8%'},
				{ text: 'Nama',columngroup: 'jabata',  cellsalign: 'center',align: 'center', editable:false ,datafield: 'jabatan', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Eselon',columngroup: 'jabata',  align: 'center', cellsalign: 'center', editable:false ,datafield: 'eselon', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
				{ text: 'Tanggal', columngroup: 'jabata', align: 'center', cellsalign: 'center', editable:false ,datafield: 'tgljabata', columntype: 'date', filtertype: 'date',cellsformat: 'dd-MM-yyyy', width: '8%' },
				{ text: 'Bulan',columngroup: 'masakerja',  editable:false ,datafield: 'blnmk', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
				{ text: 'Tahun', columngroup: 'masakerja', editable:false ,datafield: 'tahunmk', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
				{ text: 'Nama', columngroup: 'diklat',  align: 'center',  cellsalign: 'center', editable:false ,datafield: 'struk', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Tgl. Diklat',  columngroup: 'diklat',align: 'center', cellsalign: 'center', editable:false ,datafield: 'tgldikat', columntype: 'date', filtertype: 'date', width: '8%',cellsformat: 'dd-MM-yyyy', },
				{ text: 'Jml Jam', align: 'center',  columngroup: 'diklat',cellsalign: 'center', editable:false ,datafield: 'jmljam', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Nama',columngroup: 'pendidikan', align: 'center',  editable:false ,datafield: 'jurusan', columntype: 'textbox', filtertype: 'textbox', width: '16%' },
				{ text: 'Tahun Lulus',columngroup: 'pendidikan' ,align: 'center', cellsalign: 'center', editable:false ,datafield: 'tahunlulus', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
				{ text: 'Tingkat Ijazah',columngroup: 'pendidikan', align: 'center', cellsalign: 'center', editable:false ,datafield: 'ijazah', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
				{ text: 'Tahun',columngroup: 'usia', align: 'center', cellsalign: 'center', editable:false ,datafield: 'tahunusia', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
				{ text: 'Bulan',columngroup: 'usia', align: 'center', cellsalign: 'center', editable:false ,datafield: 'bulanusia', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
				{ text: 'Catatan Mutasi Pegawai', align: 'center', cellsalign: 'center', editable:false ,datafield: 'catatan', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
				{ text: 'Keterangan',align: 'center', cellsalign: 'center', editable:false ,datafield: 'keterangan', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
				
            ],
			columngroups: 
	        [
	          { text: 'Jabatan',align: 'center', name: 'jabata' },
	          { text: 'Masa Kerja',align: 'center', name: 'masakerja' },
	          { text: 'Pangkat',align: 'center', name: 'pangkat' },
	          { text: 'Diklat',align: 'center', name: 'diklat' },
	          { text: 'Usia',align: 'center', name: 'usia' },
	          { text: 'Pendidikan',align: 'center', name: 'pendidikan' },
	        ]
		});

	function detail(id,code_cl_phc){
		document.location.href="<?php echo base_url().'kepegawaian/penilaiandppp/detail';?>/" + id + "/" + code_cl_phc;
	}

	function edit(id,code_cl_phc){
		document.location.href="<?php echo base_url().'kepegawaian/penilaiandppp/edit';?>/" + id + "/" + code_cl_phc;
	}

	function view(id,code_cl_phc){
		document.location.href="<?php echo base_url().'kepegawaian/penilaiandppp/view';?>/" + id + "/" + code_cl_phc;
	}

	function del(id,code_cl_phc){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'kepegawaian/penilaiandppp/dodel' ?>/" + id + "/" + code_cl_phc,  function(){
				alert('data berhasil dihapus');

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
	}
	$("select[name='code_cl_phc']").change(function(){
		$.post("<?php echo base_url().'kepegawaian/penilaiandppp/filter' ?>", 'code_cl_phc='+$(this).val(),  function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
    });
			
	$("#btn-export").click(function(){
		
		var post = "";
		var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
		for(i=0; i < filter.length; i++){
			var fltr 	= filter[i];
			var value	= fltr.filter.getfilters()[0].value;
			var condition	= fltr.filter.getfilters()[0].condition;
			var filteroperation	= fltr.filter.getfilters()[0].operation;
			var filterdatafield	= fltr.filtercolumn;
			if(filterdatafield=="tgl"){
				var d = new Date(value);
				var day = d.getDate();
				var month = d.getMonth();
				var year = d.getYear();
				value = year+'-'+month+'-'+day;
				
			}
			post = post+'&filtervalue'+i+'='+value;
			post = post+'&filtercondition'+i+'='+condition;
			post = post+'&filteroperation'+i+'='+filteroperation;
			post = post+'&filterdatafield'+i+'='+filterdatafield;
			post = post+'&'+filterdatafield+'operator=and';
		}
		post = post+'&filterscount='+i;
		
		var sortdatafield = $("#jqxgrid").jqxGrid('getsortcolumn');
		if(sortdatafield != "" && sortdatafield != null){
			post = post + '&sortdatafield='+sortdatafield;
		}
		if(sortdatafield != null){
			var sortorder = $("#jqxgrid").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgrid").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
			post = post+'&sortorder='+sortorder;
			
		}
		post = post+'&puskes='+$("#puskesmas option:selected").text();
		
		$.post("<?php echo base_url()?>kepegawaian/penilaiandppp/permohonan_export",post,function(response	){
			window.location.href=response;
		});
	});
</script>











