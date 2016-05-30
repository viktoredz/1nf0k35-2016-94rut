<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div>
        <div class="box-footer">
          <button type="button" id="btn-kembali" class="btn btn-primary pull-right"><i class='fa  fa-arrow-circle-o-left'></i> &nbsp;Kembali</button>
          <button type="button" name="btn_transaksi_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
          <button type="button" name="btn-reset" value="Reset" onclick='clearForm(this.form)' class="btn btn-success" ><i class='fa fa-refresh'></i> &nbsp; Reset</button>
        </div>
        <div class="box-body">

			<div class="row" style="margin: 5px">
			  <div class="col-md-4" style="padding: 5px">Nama Transaksi</div>
  			  <div class="col-md-8">
    				<input type="text" class="form-control" name="transaksi_nama" placeholder="Pembayaran Biaya Jasa Pelayanan" value="<?php 
    				  if(set_value('nama')=="" && isset($nama)){
    					 echo $nama;
    				  }else{
    					 echo  set_value('nama');
    				  }
    				?>">
  			  </div>
			</div>

			<div class="row" style="margin: 5px">
			  <div class="col-md-4" style="padding: 5px">Deskripsi</div>
  				<div class="col-md-8">
  				  <textarea class="form-control" name="transaksi_deskripsi" placeholder="Deskripsi Dari Kategori"><?php 
  					  if(set_value('deskripsi')=="" && isset($deskripsi)){
  						echo $deskripsi;
  					  }else{
  						echo  set_value('deskripsi');
  					  }
  					  ?>
  				  </textarea>
  			 </div>  
			</div>

			<div class="row" style="margin: 5px">
			  <div class="col-md-4" style="padding: 5px">Untuk Jurnal</div>
				<div class="col-md-8">
				  <select name="transaksi_jurnal" type="text" class="form-control">
					<?php 
					  if(set_value('transaksi_jurnal')=="" && isset($untuk_jurnal)){
					    $transaksi_jurnal = $untuk_jurnal;
					  }else{
					    $transaksi_jurnal = set_value('transaksi_jurnal');
					  }
					?>
				    <option value="semua" <?php if($transaksi_jurnal=="semua") echo "selected" ?>>Semua</option>
					  <option value="jurnal_umum" <?php if($transaksi_jurnal=="jurnal_umum") echo "selected" ?>>Jurnal Umum</option>
					  <option value="jurnal_penyesuaian" <?php if($transaksi_jurnal=="jurnal_penyesuaian") echo "selected" ?>>Jurnal Penyesuaian</option>
					  <option value="jurnal_penutup" <?php if($transaksi_jurnal=="jurnal_penutup") echo "selected" ?>>Jurnal Penutup</option>
				  </select>
			  </div>
		  </div>

			<div class="row" style="margin: 5px">
			  <div class="col-md-4" style="padding: 5px">Kategori</div>
				<div class="col-md-8">
				  <select  name="transaksi_kategori" type="text" class="form-control">
					<?php foreach($kategori as $k) : ?>
						<?php
						  if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
							$id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
						  }else{
							$id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
						  }
						  $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
						?>
						<option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
					<?php endforeach ?>
				  </select>
				</div>
			</div>
			
			<br><br>
			<div class="col-md-12">
				<div class="pull-right"><label>Jurnal Transaksi</label> <a href="#" class="glyphicon glyphicon-plus" onclick="add_jurnal_trans()"></a></div>
			</div>  


      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Jurnal Pasangan</h3>
            <div class="pull-right"><a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a></div>
          </div>
          <div class="box-body">
            <div class="row">
              <div id="Debit" class="col-sm-6">
                <div class="row">
                  <div class="col-md-7" style="padding-top:5px;"><label> Debit </label> </div>
                  <div class="col-md-1">
                    <a class="glyphicon glyphicon-plus" onclick="add_debit"></a>
                  </div> 
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-8" style="padding-top:5px;">
                        <select  name="" type="text" class="form-control">
                          <?php foreach($kategori as $k) : ?>
                            <?php
                              if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                              }else{
                                $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                              }
                              $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                            ?>
                            <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                      <div class="col-md-1">
                        <div class="parentDiv">
                          <a href="#" data-toggle="collapse" data-target="#debit" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
                      </div> 
                  </div>
                </div>
              </div>

              <div class="collapse" id="debit">

                <div class="row">
                  <div class="col-md-7">
                    <div class="row">
                      <div class="col-md-1">
                        <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                          if(set_value('status')=="" && isset($status)){
                            $status = $status;
                          }else{
                            $status = set_value('status');
                          }
                          if($status == 1) echo "checked";
                        ?>>
                      </div> 
                      <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-1"></div>
                  <div class="col-sm-10">
                    <div class="row">
                      <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>
                      <div class="col-md-7">
                        <select  name="" type="text" class="form-control">
                          <?php foreach($kategori as $k) : ?>
                              <?php
                                if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                  $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                }else{
                                  $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                }
                                $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                              ?>
                              <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                          <?php endforeach ?>
                        </select>
                      </div> 
                      <div class="col-md-2">
                        <input type="text" class="form-control" name="transaksi_nama">
                      </div>
                      <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-7">
                    <div class="row">
                      <div class="col-md-1">
                        <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                          if(set_value('status')=="" && isset($status)){
                          $status = $status;
                            }else{
                          $status = set_value('status');
                            }
                          if($status == 1) echo "checked";
                        ?>>
                      </div> 
                      <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="row">
                <div class="col-md-8" style="padding-top:5px;"><label> Kredit </label> </div>
                <div class="col-md-2">
                  <a href="#" class="glyphicon glyphicon-plus"></a>
                </div> 
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-1" style="padding-top:5px;"><label> 1 </label> </div>
                    <div class="col-md-8" style="padding-top:5px;">
                      <select  name="" type="text" class="form-control">
                        <?php foreach($akun as $a) : ?>
                          <?php
                            if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                              $id_mst_akun = $id_mst_akun;
                            }else{
                              $id_mst_akun = set_value('id_mst_akun');
                            }
                              $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                          ?>
                          <option value="<?php echo $a->id_mst_akun ?>" <?php echo $select ?>><?php echo $a->uraian ?></option>
                          <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-md-1">
                      <div class="parentDiv">
                        <a href="#" data-toggle="collapse" data-target="#kredit1" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
                    </div> 
                  </div>
                </div>
              </div>

              <div class="collapse" id="kredit1">

                <div class="row">
                  <div class="col-sm-1"></div>
                  <div class="col-sm-7">
                    <div class="row">
                      <div class="col-md-1">
                        <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                          if(set_value('status')=="" && isset($status)){
                            $status = $status;
                          }else{
                            $status = set_value('status');
                          }
                          if($status == 1) echo "checked";
                        ?>>
                      </div> 
                      <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-1"></div>
                  <div class="col-sm-1"></div>
                  <div class="col-sm-10">
                    <div class="row">
                      <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>
                      <div class="col-md-7">
                        <select  name="" type="text" class="form-control">
                          <?php foreach($kategori as $k) : ?>
                              <?php
                                if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                  $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                }else{
                                  $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                }
                                $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                              ?>
                              <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                          <?php endforeach ?>
                        </select>
                      </div> 
                      <div class="col-md-2">
                          <input type="text" class="form-control" name="transaksi_nama">
                      </div>
                      <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-1"></div>
                  <div class="col-sm-7">
                    <div class="row">
                      <div class="col-md-1">
                        <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                          if(set_value('status')=="" && isset($status)){
                          $status = $status;
                            }else{
                          $status = set_value('status');
                            }
                          if($status == 1) echo "checked";
                        ?>>
                      </div> 
                      <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-1" style="padding-top:5px;"><label> 2 </label> </div>
                    <div class="col-md-8" style="padding-top:5px;">
                      <select  name="" type="text" class="form-control">
                        <?php foreach($kategori as $k) : ?>
                          <?php
                            if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                              $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                            }else{
                              $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                            }
                              $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                            ?>
                            <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                          <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-md-1">
                      <div class="parentDiv">
                        <a href="#" data-toggle="collapse" data-target="#kredit2" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
                    </div> 
                  </div>
                </div>
              </div>

              <div class="collapse" id="kredit2">

                <div class="row">
                  <div class="col-sm-1"></div>
                  <div class="col-sm-7">
                  <div class="row">
                    <div class="col-md-1">
                      <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                        if(set_value('status')=="" && isset($status)){
                          $status = $status;
                        }else{
                          $status = set_value('status');
                        }
                        if($status == 1) echo "checked";
                      ?>>
                    </div> 
                    <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
                  </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-1"></div>
                  <div class="col-sm-1"></div>
                  <div class="col-sm-10">
                    <div class="row">
                      <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>
                      <div class="col-md-7">
                        <select  name="" type="text" class="form-control">
                          <?php foreach($kategori as $k) : ?>
                              <?php
                                if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                                  $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                                }else{
                                  $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                                }
                                $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                              ?>
                              <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
                          <?php endforeach ?>
                        </select>
                      </div> 
                      <div class="col-md-2">
                        <input type="text" class="form-control" name="transaksi_nama">
                      </div>
                      <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-1"></div>
                  <div class="col-sm-7">
                    <div class="row">
                      <div class="col-md-1">
                        <input type="checkbox" name="keuinstansi_status" value="1" <?php 
                          if(set_value('status')=="" && isset($status)){
                          $status = $status;
                            }else{
                          $status = set_value('status');
                            }
                          if($status == 1) echo "checked";
                        ?>>
                      </div> 
                      <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <label>Pengaturan Transaksi</label>

        <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <?php
             $i=1; foreach($template as $t) : ?>
              <input type="checkbox" name="transaksi_template" id="template<?php echo $t->id_mst_setting_transaksi_template;?>" value="<?php echo $t->id_mst_setting_transaksi_template;?>"
            <?php 
            if(!empty($t->id_mst_transaksi)){ echo "checked";}
            ?>> 
              <?php echo $t->setting_judul ?>
              </br>
              <?php echo $t->seting_deskripsi ?>
              </br></br>
            <?php $i++; endforeach ?> 
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</section>

<script type="text/javascript">

    $("#btn-kembali").click(function(){
      $.get('<?php echo base_url()?>mst/keuangan_transaksi/transaksi_kembali', function (data) {
        $('#content2').html(data);
      });
    });

//     var debt = 1;
// function add_debit() {
//     debt++;
//     var objTo = document.getElementById('Debit')
//     var divtest = document.createElement("div");
//     // divtest.innerHTML = '<div class="label">Room ' + room +':</div>
//     // <div class="content">
//     // <span>Width: <input type="text" style="width:48px;" name="width[]" value="" /><small>(ft)</small>
//     // X</span><span>Length: <input type="text" style="width:48px;" namae="length[]" value="" /><small>(ft)</small></span>
//     // </div>';

//     divtest.innerHTML = '<div class="col-sm-6">
//                 <div class="row">
//                   <div class="col-md-7" style="padding-top:5px;"><label> Debit </label> </div>
//                   <div class="col-md-1">
//                     <a href="#" class="glyphicon glyphicon-plus"></a>
//                   </div> 
//                 </div>

//                 <div class="row">
//                   <div class="col-md-12">
//                     <div class="row">
//                       <div class="col-md-8" style="padding-top:5px;">
//                         <select  name="" type="text" class="form-control">
//                           <?php foreach($kategori as $k) : ?>
//                             <?php
//                               if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
//                                 $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
//                               }else{
//                                 $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
//                               }
//                               $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
//                             ?>
//                             <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
//                           <?php endforeach ?>
//                         </select>
//                       </div>
//                       <div class="col-md-1">
//                           <a href="#" data-toggle="collapse" data-target="#debit" class="glyphicon glyphicon-chevron-down"></a>
//                           <!-- <button data-toggle="collapse" data-target="#kredit1"><i class="glyphicon glyphicon-chevron-down"></i></button> -->
//                       </div>
//                       <div class="col-md-2">
//                         <a href="#" onclick="return confirm('Anda yakin ingin menghapus menu ini ?')" class="glyphicon glyphicon-trash"></a>
//                       </div> 
//                   </div>
//                 </div>
//               </div>

//               <div class="collapse" id="debit">

//                 <div class="row">
//                   <div class="col-md-7">
//                     <div class="row">
//                       <div class="col-md-1">
//                         <input type="checkbox" name="keuinstansi_status" value="1" <?php 
//                           if(set_value('status')=="" && isset($status)){
//                             $status = $status;
//                           }else{
//                             $status = set_value('status');
//                           }
//                           if($status == 1) echo "checked";
//                         ?>>
//                       </div> 
//                       <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
//                     </div>
//                   </div>
//                 </div>

//                 <div class="row">
//                 <div class="col-sm-1"></div>
//                   <div class="col-sm-10">
//                     <div class="row">
//                       <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>
//                       <div class="col-md-7">
//                         <select  name="" type="text" class="form-control">
//                           <?php foreach($kategori as $k) : ?>
//                               <?php
//                                 if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
//                                   $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
//                                 }else{
//                                   $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
//                                 }
//                                 $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
//                               ?>
//                               <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
//                           <?php endforeach ?>
//                         </select>
//                       </div> 
//                       <div class="col-md-2">
//                         <input type="text" class="form-control" name="transaksi_nama">
//                       </div>
//                       <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>
//                     </div>
//                   </div>
//                 </div>

//                 <div class="row">
//                   <div class="col-md-7">
//                     <div class="row">
//                       <div class="col-md-1">
//                         <input type="checkbox" name="keuinstansi_status" value="1" <?php 
//                           if(set_value('status')=="" && isset($status)){
//                           $status = $status;
//                             }else{
//                           $status = set_value('status');
//                             }
//                           if($status == 1) echo "checked";
//                         ?>>
//                       </div> 
//                       <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
//                     </div>
//                   </div>
//                 </div>
//               </div>
//             </div>';
    
//     objTo.appendChild(divtest)
// }


    $('.parentDiv').click(function() {
      var toggle_sign = $(this).find(".toggle_sign");
      if ($(toggle_sign).hasClass("glyphicon-chevron-down")) {
        $(toggle_sign).removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
      } else {
        $(toggle_sign).addClass("glyphicon-chevron-down").removeClass("glyphicon-chevron-up");
      }
    });

    $("[name='btn_transaksi_save']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('nama',                      $("[name='transaksi_nama']").val());
        data.append('deskripsi',                 $("[name='transaksi_deskripsi']").val());
        data.append('untuk_jurnal',              $("[name='transaksi_jurnal']").val());
        data.append('id_mst_kategori_transaksi', $("[name='transaksi_kategori']").val());
              
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_{action}/{id}"   ?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                alert("Data berhasil disimpan.");
              }else{
                alert("Isi kolom yang kosong.");
              }
            }
        });

        return false;
    });

    $("[name='transaksi_template']").click(function(){
      var data = new FormData();
        data.append('template',     $(this).val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_template_update/".$id?>',
            data : data,
            success : function(response){
              if(response=="OK"){
                $("#transaksi_template").prop("checked", true);
              }else{
                $("#transaksi_template").prop("checked", false);
              }
            }
        });
    });


    function clearForm(form_transaksi) {
   
    var elements = form_transaksi.elements;
    form_transaksi.reset();

    for(i=0; i<elements.length; i++) {
     
      field_type = elements[i].type.toLowerCase();
 
      switch(field_type) {
     
        case "text":
        case "password":
        case "textarea":
        case "hidden":  
         
          elements[i].value = "";
          break;
           
        case "radio":
        case "checkbox":
          if (elements[i].checked) {
                elements[i].checked = false;
          }
          break;

        case "select-one":
        case "select-multi":
                    elements[i].selectedIndex = -1;
          break;

        default:
          break;
      }
    }
}

</script>

