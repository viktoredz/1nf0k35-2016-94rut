<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plugins/js/jquery.imgzoom/css/imgzoom.css" />
 <script type="text/javascript" src="<?php echo base_url()?>plugins/js/jquery.imgzoom/scripts/jquery.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url()?>plugins/js/jquery.imgzoom/scripts/jquery.imgzoom.pack.js"></script>
 <a href="<?php echo base_url()?>public/files/foto/10/36.jpg"><img class="thumbnail" src="<?php echo base_url()?>public/files/foto/10/36.jpg" alt="Puppy" widht="100x" height="100px"/></a>
<script>
  $(document).ready(function () {
    $('img.thumbnail').imgZoom();
  });
</script>-->





<table>
<tr>
<?php
   if(isset($data_foto) && !empty($data_foto)){ 
      $i=1;
      foreach ($data_foto as $row ) {
?>


<td>
<div class="img-thumbnail dg-picture-zoom"  style="background-image: url(<?php echo base_url()?>public/files/foto/<?php echo $row->id_inventaris_barang; ?>/<?php echo htmlspecialchars($row->namafile); ?>); background-size: cover; -webkit-transform: scale(1, 1) perspective(10000px) rotateX(0deg); opacity: 1; background-position: 50% 49%; background-repeat: no-repeat no-repeat;width:170px;height:100px">
   <a href="#" onclick="deleteimg(<?php echo $row->id_inventaris_barang.','."'".$row->namafile."'";?>)">
   <div style="background:#fbbc11;padding:4px;position:relative;float:left;margin-right:2px;cursor:pointer;height:25px;width:25px" id="btndelete__<?php echo $row->id_inventaris_barang.'__'.$row->namafile;?>">
      <i class="glyphicon glyphicon-trash" style="color:#FFFFFF;font-size:17px;position:relative;" title="Hapus Foto"></i>          
   </div>            
   </a>
   <div style="background:#fbbc11;padding:4px;position:relative;float:left;margin-right:2px;cursor:pointer;height:25px;width:25px" id="zoom">              
      <i class="glyphicon glyphicon-zoom-in" style="color:#FFFFFF;font-size:17px;position:relative;" title="Zoom In"></i>  
   </div>                    
</div>
</td>
      <!--<td><img src="<?php echo base_url()?>public/files/foto/<?php echo $row->id_inventaris_barang; ?>/<?php echo htmlspecialchars($row->namafile); ?> " width="170px" height="100px"/></td>-->

<?php
         if(($i%2)==0){
            echo "</tr><tr>";     
         }
         $i++;
      }
   }
?>
</tr>
</div>
</table>
