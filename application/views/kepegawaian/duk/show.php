<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>kepegawaian/duk/dodel_multi" method="POST" name="">
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
		 	<!-- <button type="button" class="btn btn-primary" onclick="document.location.href='<?php echo base_url()?>kepegawaian/duk/add'"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah</button> -->
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
	    $("#menu_kepegawaian_duk").addClass("active");
	});
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'no', type: 'number'},
			{ name: 'id_pegawai', type: 'string'},
			{ name: 'nik', type: 'string'},
			{ name: 'gelar_depan', type: 'string'},
			{ name: 'gelar_belakang', type: 'string'},
			{ name: 'nama', type: 'string'},
			{ name: 'jenis_kelamin', type: 'string'},
			{ name: 'tmp_lahir', type: 'string'},
			{ name: 'tgl_lhr', type: 'date'},
			{ name: 'alamat', type: 'string'},
			{ name: 'code_cl_phc', type: 'string'},
			{ name: 'nip_nit', type: 'string'},
			{ name: 'tmt_pangkat', type: 'date'},
			{ name: 'pangkatterakhir', type: 'string'},
			{ name: 'id_mst_peg_golruang', type: 'string'},
			{ name: 'jabatanterakhirstuktural', type: 'string'},
			{ name: 'jabatanterakhirfungsional', type: 'string'},
			{ name: 'catatanmutasi', type: 'string'},
			{ name: 'keterangan', type: 'string'},
			{ name: 'namajabatan', type: 'string'},
			{ name: 'tar_eselon', type: 'string'},
			{ name: 'tmtstruktural', type: 'date'},
			{ name: 'tmtfungsional', type: 'date'},
			{ name: 'tmtjabatan', type: 'string'},
			{ name: 'masa_krj_bln', type: 'string'},
			{ name: 'masa_krj_thn', type: 'string'},
			{ name: 'diklatterakhir', type: 'string'},
			{ name: 'nama_diklat', type: 'string'},
			{ name: 'tgl_diklat', type: 'date'},
			{ name: 'lama_diklat', type: 'string'},
			{ name: 'nama_jurusan', type: 'string'},
			{ name: 'tahunijazah', type: 'string'},
			{ name: 'ijazah_tgl', type: 'date'},
			{ name: 'namapendidikan', type: 'string'},
			{ name: 'deskripsi', type: 'string'},
			{ name: 'bulanusia', type: 'string'},
			{ name: 'tahunumur', type: 'string'},
			{ name: 'detail', type: 'number'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('kepegawaian/duk/json'); ?>",
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
		 var cellsrenderer = function (row, column, value) {
                return '<div style="text-align: center; margin-top: 5px;">' + value + '</div>';
            }
            var columnrenderer = function (value) {
                return '<div style="text-align: center; margin-top: 5px;">' + value + '</div>';
            }
        var cellsrenderernama = function (row, column, value) {
                return '<div style=" margin-top: 5px; padding-left:5px;">' + value + '</div>';
            }
		$("#jqxgrid").jqxGrid(
		{		
			width: '100%',
			rowsheight: 40,
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: false,  autoheight: true, pageable: true, virtualmode: true, editable: true,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'No', align: 'center',editable:false ,cellsalign: 'left',datafield: 'no', columntype: 'textbox', filtertype: 'none', width: '3%' },
				{ text: 'Nama', align: 'center',editable:false ,cellsalign: 'left',datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', width: '20%' },
				{ text: 'Tempat Lahir', align: 'center', cellsalign: 'left', editable:false ,datafield: 'tmp_lahir', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Tanggal Lahir', align: 'center', cellsalign: 'center', editable:false ,datafield: 'tgl_lhr',cellsformat: 'dd-MM-yyyy', columntype: 'date', filtertype: 'date', width: '8%' },
				{ text: 'NIP', align: 'center', cellsalign: 'left', editable:false , datafield: 'nip_nit', columntype: 'textbox', filtertype: 'textbox',  width: '15%' },
				{ text: 'Gol',columngroup: 'pangkat',   align: 'left', cellsalign: 'center', editable:false ,datafield: 'id_mst_peg_golruang', columntype: 'textbox', filtertype: 'textbox', width: '5%' },
				
				{ text: 'TMT',align: 'center', columngroup: 'pangkat',editable:false ,datafield: 'tmt_pangkat', columntype: 'date', filtertype: 'date',cellsformat: 'dd-MM-yyyy', width: '8%'},
				{ text: 'Nama',columngroup: 'jabata',  cellsalign: 'left',align: 'center', editable:false ,datafield: 'namajabatan', columntype: 'textbox', filtertype: 'none', width: '25%', cellsrenderer: cellsrenderernama  },
				{ text: 'Eselon',columngroup: 'jabata',  align: 'left', cellsalign: 'center', editable:false ,datafield: 'tar_eselon', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
				{ text: 'Tanggal', columngroup: 'jabata', align: 'center', cellsalign: 'center', editable:false ,datafield: 'tmtjabatan', columntype: 'textboxe', filtertype: 'none', width: '16%',renderer: columnrenderer, cellsrenderer: cellsrenderer},
				{ text: 'Bulan',columngroup: 'masakerja',align: 'center', cellsalign: 'center', editable:false ,datafield: 'masa_krj_bln', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
				{ text: 'Tahun', columngroup: 'masakerja',align: 'center',cellsalign: 'center', editable:false ,datafield: 'masa_krj_thn', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
				{ text: 'Nama', columngroup: 'diklat',  align: 'center',  cellsalign: 'left', editable:false ,datafield: 'nama_diklat', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Tgl. Diklat',  columngroup: 'diklat',align: 'center', cellsalign: 'center', editable:false ,datafield: 'tgl_diklat', columntype: 'date', filtertype: 'date', width: '8%',cellsformat: 'dd-MM-yyyy', },
				{ text: 'Jml Jam', align: 'center',  columngroup: 'diklat',cellsalign: 'center', editable:false ,datafield: 'lama_diklat', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
				{ text: 'Nama',columngroup: 'pendidikan', align: 'center',  editable:false ,datafield: 'namapendidikan', columntype: 'textbox', filtertype: 'textbox', width: '16%' },
				{ text: 'Tahun Lulus',columngroup: 'pendidikan' ,align: 'center', cellsalign: 'center', editable:false ,datafield: 'tahunijazah', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
				{ text: 'Tingkat Ijazah',columngroup: 'pendidikan', align: 'center', cellsalign: 'center', editable:false ,datafield: 'deskripsi', columntype: 'textbox', filtertype: 'textbox', width: '8%' },
				{ text: 'Tahun',columngroup: 'usia', align: 'center', cellsalign: 'center', editable:false ,datafield: 'tahunumur', columntype: 'textbox', filtertype: 'none', width: '8%' },
				{ text: 'Bulan',columngroup: 'usia', align: 'center', cellsalign: 'center', editable:false ,datafield: 'bulanusia', columntype: 'textbox', filtertype: 'none', width: '8%' },
				{ text: 'Catatan Mutasi Pegawai', align: 'center', cellsalign: 'center', editable:false ,datafield: 'catatanmutasi', columntype: 'textbox', filtertype: 'none', width: '8%' },
				{ text: 'Keterangan',align: 'center', cellsalign: 'center', editable:false ,datafield: 'keterangan', columntype: 'textbox', filtertype: 'none', width: '8%' },
				
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
		document.location.href="<?php echo base_url().'kepegawaian/duk/detail';?>/" + id + "/" + code_cl_phc;
	}

	function edit(id,code_cl_phc){
		document.location.href="<?php echo base_url().'kepegawaian/duk/edit';?>/" + id + "/" + code_cl_phc;
	}

	function view(id,code_cl_phc){
		document.location.href="<?php echo base_url().'kepegawaian/duk/view';?>/" + id + "/" + code_cl_phc;
	}

	function del(id,code_cl_phc){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'kepegawaian/duk/dodel' ?>/" + id + "/" + code_cl_phc,  function(){
				alert('data berhasil dihapus');

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
	}
	$("select[name='code_cl_phc']").change(function(){
		$.post("<?php echo base_url().'kepegawaian/duk/filter' ?>", 'code_cl_phc='+$(this).val(),  function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
    });
			
	$("#btn-export").click(function(){
		
		var post = "";
		// var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
		// for(i=0; i < filter.length; i++){
		// 	var fltr 	= filter[i];
		// 	var value	= fltr.filter.getfilters()[0].value;
		// 	var condition	= fltr.filter.getfilters()[0].condition;
		// 	var filteroperation	= fltr.filter.getfilters()[0].operation;
		// 	var filterdatafield	= fltr.filtercolumn;
		// 	if(filterdatafield=="tgl"){
		// 		var d = new Date(value);
		// 		var day = d.getDate();
		// 		var month = d.getMonth();
		// 		var year = d.getYear();
		// 		value = year+'-'+month+'-'+day;
				
		// 	}
		// 	post = post+'&filtervalue'+i+'='+value;
		// 	post = post+'&filtercondition'+i+'='+condition;
		// 	post = post+'&filteroperation'+i+'='+filteroperation;
		// 	post = post+'&filterdatafield'+i+'='+filterdatafield;
		// 	post = post+'&'+filterdatafield+'operator=and';
		// }
		// post = post+'&filterscount='+i;
		
		// var sortdatafield = $("#jqxgrid").jqxGrid('getsortcolumn');
		// if(sortdatafield != "" && sortdatafield != null){
		// 	post = post + '&sortdatafield='+sortdatafield;
		// }
		// if(sortdatafield != null){
		// 	var sortorder = $("#jqxgrid").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgrid").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
		// 	post = post+'&sortorder='+sortorder;
			
		// }
		post = post+'&puskes='+$("#puskesmas option:selected").text();
		
		$.post("<?php echo base_url()?>kepegawaian/duk/permohonan_export",post,function(response){
			window.location.href=response;
			// alert(response);
		});
	});
</script>











