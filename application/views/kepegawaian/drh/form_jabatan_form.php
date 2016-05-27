
<form action="#" method="POST" name="frmPegawai">
  <div class="row" style="margin: 15px 5px 15px 5px">
    <div class="col-sm-8">
      <?php if(validation_errors()!=""){ ?>
      <div class="alert alert-warning alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>  <i class="icon fa fa-check"></i> Information!</h4>
        <?php echo validation_errors()?>
      </div>
      <?php } ?>

      <?php if($alert_form!=""){ ?>
      <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>  <i class="icon fa fa-check"></i> Information!</h4>
        <?php echo $alert_form?>
      </div>
      <?php } ?>
    </div>
    <div class="col-sm-12" style="text-align: right">
      <button type="button" name="btn_jabatan_formal_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
      <button type="button" name="btn_jabatan_formal_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Kembali</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="row" style="margin: 5px" id="shownama">
                <div class="col-md-3" style="padding: 5px">
                  Nama
                </div>
                <div class="col-md-9">
                      <?php 
                      if (empty($gelar_depan)) {
                        $gelar_depan ='';
                      }
                      if (empty($nama)) {
                        $nama ='';
                      }
                      if (empty($gelar_belakang)) {
                        $gelar_belakang ='';
                      }
                      echo $gelar_depan.' '.$nama.' '.$gelar_belakang; ?>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="shownip" name="shownip">
              <div class="col-md-3"  style="padding: 5px" >
                Nomor Induk Pegawai (NIP)
              </div>
              <div class="col-md-9">
                  <?php 
                        if (empty($nip)) {
                          $nip  = '';
                        }
                        echo $nip;
                   ?>
                   <input type="hidden" class="form-control" name="nip" id="nip" placeholder="SK NIP" value="<?php 
                  if(set_value('nip')=="" && isset($nip)){
                    echo $nip;
                  }else{
                    echo  set_value('nip');
                  }
                  ?>">
                 
              </div>
              </div>
              <div class="row" style="margin: 5px" id="showttl">
                <div class="col-md-3" style="padding: 5px">
                Tempat, Tanggal Lahir
                </div>
                <div class="col-md-9">
                  <?php 
                        if (empty($tmp_lahir)) {
                          $tmp_lahir  = '';
                        }
                        if (empty($tgl_lhr)) {
                          $tgl_lhr = '';
                        }
                      echo date("d-m-Y",strtotime($tgl_lhr)).', '.$tmp_lahir;
                  ?>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showkelamin">
                <div class="col-md-3" style="padding: 5px">
                Jenis Kelamin
                </div>
                <div class="col-md-9">
                  <?php 
                        if (empty($jenis_kelamin)) {
                          $jk  = '';
                        }else{
                          if ($jenis_kelamin =='L') {
                            $jk = 'Laki-laki';
                          }else{
                            $jk = 'Perempuan';
                          }

                        }
                      echo $jk;
                  ?>
              </div>
              </div>
              <div class="row" style="margin: 5px" id="showpuskesmas">
                <div class="col-md-3" style="padding: 5px">
                  Puskesmas
                </div>
                <div class="col-md-9">
                  <select  name="codepus" id="codepus" class="form-control">
                      <?php foreach($datapuskesmas as $pus) : ?>
                        <?php $select = $pus->code == $code_cl_phc ? 'selected' : '' ?>
                        <option value="<?php echo $pus->code ?>" <?php echo $select ?>><?php echo $pus->value ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showtmt">
                <div class="col-md-3" style="padding: 5px">
                  Terhitung Mulai Tanggal
                </div>
                <div class="col-md-9">
                  <div id='tmt' name="tmt" value="<?php
                    if(set_value('tmt')=="" && isset($tmt)){
                      $tgl_tmt = strtotime($tmt);
                    }else{
                      $tgl_tmt = strtotime(set_value('tmt'));
                    }

                    if($tgl_tmt=="") $tgl_tmt = time();
                    echo date("Y-m-d",$tgl_tmt);
                  ?>"></div>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showpelantikan">
                <div class="col-md-3" style="padding: 5px">
                  Tanggal Pelantikan
                </div>
                <div class="col-md-9">
                  <div id='tgl_pelantikan' name="tgl_pelantikan" value="<?php
                    if(set_value('tgl_pelantikan')=="" && isset($tgl_pelantikan)){
                      $tgl_plt = strtotime($tgl_pelantikan);
                    }else{
                      $tgl_plt = strtotime(set_value('tgl_pelantikan'));
                    }

                    if($tgl_plt=="") $tgl_plt = time();
                    echo date("Y-m-d",$tgl_plt);
                  ?>" ></div>
                </div>
              </div>
              <div id="showkeputusan">
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  Surat Keputusan
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Tanggal
                </div>
                <div class="col-md-9">
                  <div id='sk_jb_tgl' name="sk_jb_tgl" value="<?php
                    if(set_value('sk_jb_tgl')=="" && isset($sk_jb_tgl)){
                      $tgl_jb = strtotime($sk_jb_tgl);
                    }else{
                      $tgl_jb = strtotime(set_value('sk_jb_tgl'));
                    }

                    if($tgl_jb=="") $tgl_jb = time();
                    echo date("Y-m-d",$tgl_jb);
                  ?>" ></div>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Nomor
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="sk_jb_nomor" id="sk_jb_nomor" placeholder="Nomor SK" value="<?php 
                  if(set_value('sk_jb_nomor')=="" && isset($sk_jb_nomor)){
                    echo $sk_jb_nomor;
                  }else{
                    echo  set_value('sk_jb_nomor');
                  }
                  ?>">
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Pejabat
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="sk_jb_pejabat" id="sk_jb_pejabat" placeholder="SK Penjabat" value="<?php 
                  if(set_value('sk_jb_pejabat')=="" && isset($sk_jb_pejabat)){
                    echo $sk_jb_pejabat;
                  }else{
                    echo  set_value('sk_jb_pejabat');
                  }
                  ?>">
                </div>
              </div>
              </div>
              
              
              <div class="row" style="margin: 5px" id="showstatus">
                <div class="col-md-3" style="padding: 5px">
                  Status
                </div>
                <div class="col-md-9">
                  <select  name="jenis" id="jenis" class="form-control">
                      <?php 
                      $stjenis = array_values($statusjenis);
                      foreach($stjenis as $jen) : 
                        echo $tampilsk = str_replace('_',' ',$jen);
                      ?>
                        <?php $select = $jen == $jenis ? 'selected' : '' ?>
                        <option value="<?php echo $jen ?>" <?php echo $select ?>><?php echo ucwords(strtolower($tampilsk)) ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showskstatus">
                <div class="col-md-3" style="padding: 5px">
                  SK Status
                </div>
                <div class="col-md-9">
                  <select  name="sk_status" id="sk_status" class="form-control">
                      <?php 
                      $skjenis  = array_values($statusjenissk);
                      foreach($skjenis as $sukjenis) : ?>
                        <?php $select = $sukjenis == $sk_status ? 'selected' : '' ?>
                        <option value="<?php echo $sukjenis ?>" <?php echo $select ?>><?php echo ucfirst($sukjenis) ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showstruktural">
                <div class="col-md-3" style="padding: 5px">
                  Jabatan Struktural
                </div>
                <div class="col-md-9">
                  <select  name="id_mst_peg_struktural" id="id_mst_peg_struktural" class="form-control">
                      <?php foreach($mst_peg_struktural as $struktural) : ?>
                        <?php $select = $struktural->tar_id_struktural == $id_mst_peg_struktural ? 'selected' : '' ?>
                        <option value="<?php echo $struktural->tar_id_struktural ?>" <?php echo $select ?>><?php echo $struktural->tar_nama_struktural ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showfungsionaltertentu">
                <div class="col-md-3" style="padding: 5px">
                  Jabatan Fungsional
                </div>
                <div class="col-md-9">
                  <select  name="id_mst_peg_fungsional_tertentu" id="id_mst_peg_fungsional_tertentu" class="form-control">
                      <?php foreach($mst_peg_fungsional_tertentu as $tertentu) : ?>
                        <?php $select = $tertentu->tar_id_fungsional == $id_mst_peg_fungsional ? 'selected' : '' ?>
                        <option value="<?php echo $tertentu->tar_id_fungsional ?>" <?php echo $select ?>><?php echo $tertentu->tar_nama_fungsional ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="showfungsionalumum">
                <div class="col-md-3" style="padding: 5px">
                  Jabatan Fungsional
                </div>
                <div class="col-md-9">
                  <select  name="id_mst_peg_fungsional_umum" id="id_mst_peg_fungsional_umum" class="form-control">
                      <?php foreach($mst_peg_fungsional_umum as $umum) : ?>
                        <?php $select = $umum->tar_id_fungsional == $id_mst_peg_fungsional ? 'selected' : '' ?>
                        <option value="<?php echo $umum->tar_id_fungsional ?>" <?php echo $select ?>><?php echo $umum->tar_nama_fungsional ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                  Unit Organisasi
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="unor" id="unor" placeholder="Unit Organisasi" value="<?php 
                  if(set_value('unor')=="" && isset($unor)){
                    echo $unor;
                  }else{
                    echo  set_value('unor');
                  }
                  ?>">
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                  Prosedur Awal
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="prosedur" id="prosedur" placeholder="Prosedur Awal" value="<?php 
                  if(set_value('prosedur')=="" && isset($prosedur)){
                    echo $prosedur;
                  }else{
                    echo  set_value('prosedur');
                  }
                  ?>">
                </div>
              </div>
             <!-- <div id="showkesehatan">
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  SDM Kesehatan
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px  5px 5px 30px">
                  Rumpun
                </div>
                <div class="col-md-9">
                  <select  name="id_mst_peg_fungsional_umum" id="id_mst_peg_fungsional_umum" class="form-control">
                      <?php /* foreach($mst_peg_rumpunpendidikan as $sehat) : ?>
                        <?php $select = $sehat->id_rumpun == $id_mst_peg_fungsional ? 'selected' : '' ?>
                        <option value="<?php echo $sehat->id_rumpun ?>" <?php echo $select ?>><?php echo $sehat->nama_rumpun ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Kelompok
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="spmt_nomor" id="spmt_nomor" placeholder="Nomor SPMT" value="<?php 
                  if(set_value('spmt_nomor')=="" && isset($spmt_nomor)){
                    echo $spmt_nomor;
                  }else{
                    echo  set_value('spmt_nomor');
                  }
                  ?>">
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Jenis SDM
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="spmt_nomor" id="spmt_nomor" placeholder="Nomor SPMT" value="<?php 
                  if(set_value('spmt_nomor')=="" && isset($spmt_nomor)){
                    echo $spmt_nomor;
                  }else{
                    echo  set_value('spmt_nomor');
                  }
                  ?>">
                </div>
              </div>
              </div>
              <div id="showpendidikan">
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  Pendidikan
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px  5px 5px 30px">
                  Tingkat 
                </div>
                <div class="col-md-9">
                    <select  name="id_mst_peg_fungsional_umum" id="id_mst_peg_fungsional_umum" class="form-control">
                      <?php foreach($mst_peg_tingkatpendidikan as $tingkat) : ?>
                            <?php $select = $tingkat->id_tingkat == $id_mst_peg_fungsional ? 'selected' : '' ?>
                            <option value="<?php echo $tingkat->id_tingkat ?>" <?php echo $select ?>><?php echo $tingkat->tingkat ?></option>
                          <?php endforeach ?>
                    </select>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px 5px 5px 30px">
                  Jurusan
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="dokter_nomor" id="dokter_nomor" placeholder="Nomor BKN" value="<?php 
                  if(set_value('dokter_nomor')=="" && isset($dokter_nomor)){
                    echo $dokter_nomor;
                  }else{
                    echo  set_value('dokter_nomor');
                  } */
                  ?>">
                </div>
              </div>
              </div>
-->



              <br>
            </div>
          </div>
  </div>
</form>

<script>
  $(function () { 
    $('#jenis').change(function(){
        hideshow();
    }).change();;
  hideshow();
  function hideshow(){
    if ($('#jenis').val()=='STRUKTURAL') {
        $('#showstruktural').show();
        $('#showfungsionaltertentu').hide();
        $('#showfungsionalumum').hide();
    }else if ($('#jenis').val()=='FUNGSIONAL_TERTENTU') {
        $('#showstruktural').hide();
        $('#showfungsionalumum').hide();
        $('#showfungsionaltertentu').show();
    }else{
      $('#showstruktural').hide();
        $('#showfungsionalumum').show();
        $('#showfungsionaltertentu').hide();
    } 
  }

  
    tabIndex = 1;
    $("[name='tmt']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});
    $("[name='sk_jb_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});
    $("[name='tgl_pelantikan']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});


    $("[name='btn_jabatan_formal_close']").click(function(){
        var peserta = "<?php echo $id_pegawai; ?>";
        $.get("<?php echo base_url().'kepegawaian/drh/biodata'?>/"+'5'+'/'+peserta,function(data){
            $('#content5').html(data);
        });
    });

    $("[name='btn_jabatan_formal_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();
        data.append('nip', $("#nip").val());
        data.append('tmt', $("#tmt").val());
        data.append('jenis', $("#jenis").val());
        data.append('unor', $("#unor").val());
        data.append('tgl_pelantikan', $("#tgl_pelantikan").val());
        data.append('sk_jb_tgl', $("#sk_jb_tgl").val());
        data.append('sk_jb_nomor', $("#sk_jb_nomor").val());
        data.append('sk_jb_pejabat', $("#sk_jb_pejabat").val());
        data.append('sk_status', $("#sk_status").val());
        data.append('prosedur', $("#prosedur").val());
        data.append('codepus', $("#codepus").val());

        if ($('#jenis').val()=='STRUKTURAL') {
            data.append('id_mst_peg_struktural', $("#id_mst_peg_struktural").val());
        }else if ($('#jenis').val()=='FUNGSIONAL_TERTENTU') {
            data.append('id_mst_peg_fungsional_tertentu', $("#id_mst_peg_fungsional_tertentu").val());
        }else{
            data.append('id_mst_peg_fungsional_umum', $("#id_mst_peg_fungsional_umum").val());
        } 
      var halaman = $("#statuspns").val();
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."kepegawaian/drh_jabatan/$action/$id/$tmt"   ?>',
            data : data,
            success : function(response){
              res = response.split(' | ');
              if(res[0]=="OK"){
                alert("Data Jabatan berhasil disimpan.");
                var peserta = "<?php echo $id; ?>";
                    $.get("<?php echo base_url().'kepegawaian/drh/biodata'?>/"+'5'+'/'+peserta,function(data){
                        $('#content5').html(data);
                    });
              }else{
                $('#content5').html(response);
              }
              ambil_nip();
            }
        });
        return false;
    });
  });

    function ambil_nip()
    {
      $.ajax({
      url: "<?php echo base_url().'kepegawaian/drh/nipterakhir/'.$id ?>",
      dataType: "json",
      success:function(data)
      { 
        $.each(data,function(index,elemet){
          $("#nipterakhir").html(elemet.nip);
        });
      }
      });

      return false;
    }
</script>
