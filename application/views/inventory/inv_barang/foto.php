<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plugins/js/jquery.imgzoom/css/imgzoom.css" />
 <script type="text/javascript" src="<?php echo base_url()?>plugins/js/jquery.imgzoom/scripts/jquery.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url()?>plugins/js/jquery.imgzoom/scripts/jquery.imgzoom.pack.js"></script>
 <a href="<?php echo base_url()?>public/files/foto/10/36.jpg"><img class="thumbnail" src="<?php echo base_url()?>public/files/foto/10/36.jpg" alt="Puppy" widht="100x" height="100px"/></a>
<script>
  $(document).ready(function () {
    $('img.thumbnail').imgZoom();
  });
</script>-->


<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plugins/js/stylezoom.css" />
<script type="text/javascript">

setTimeout(function() {
  if (location.hash) {
    window.scrollTo(0, 0);
  }
}, 1);


</script>
<div class="holder">
    <div id="image-1" class="image-lightbox">
      <span class="close"><a href="#">X</a></span>
      <img src="http://localhost/projek/epuskesmasgarut/public/files/foto/12/8.jpg" alt="earth!" width="100px" height="100px">
      <a class="expand" href="#image-1"></a>
    </div>
  </div>-->
<table>
<tr>
<?php
   if(isset($data_foto) && !empty($data_foto)){ 
      $i=1;
      foreach ($data_foto as $row ) {
?>


<td>
<!--<div class="img-thumbnail dg-picture-zoom"  style="background-image: url(<?php echo base_url()?>public/files/foto/<?php echo $row->id_inventaris_barang; ?>/<?php echo htmlspecialchars($row->namafile); ?>); background-size: cover; -webkit-transform: scale(1, 1) perspective(10000px) rotateX(0deg); opacity: 1; background-position: 50% 49%; background-repeat: no-repeat no-repeat;width:170px;height:100px">
   <a href="#" onclick="deleteimg(<?php echo $row->id_inventaris_barang.','."'".$row->namafile."'";?>)">
   <div style="background:#fbbc11;padding:4px;position:relative;float:left;margin-right:2px;cursor:pointer;height:25px;width:25px" id="btndelete__<?php echo $row->id_inventaris_barang.'__'.$row->namafile;?>">
      <i class="glyphicon glyphicon-trash" style="color:#FFFFFF;font-size:17px;position:relative;" title="Hapus Foto"></i>          
   </div>            
   </a>
   <div style="background:#fbbc11;padding:4px;position:relative;float:left;margin-right:2px;cursor:pointer;height:25px;width:25px" id="zoom">              
      <i class="glyphicon glyphicon-zoom-in" style="color:#FFFFFF;font-size:17px;position:relative;" title="Zoom In"></i>  
   </div>                    
</div>-->
<ul class="enlarge">
<li><img src="<?php echo base_url()?>public/files/foto/<?php echo $row->id_inventaris_barang; ?>/<?php echo htmlspecialchars($row->namafile); ?>" width="150px" height="100px" alt="Dechairs" /><span><img src="<?php echo base_url()?>public/files/foto/<?php echo $row->id_inventaris_barang; ?>/<?php echo htmlspecialchars($row->namafile); ?>" alt="Deckchairs" /><br /><?php echo $row->namafile; ?></span></li>
</ul>
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


<style type="text/css">
  ul.enlarge{
list-style-type:none; /*remove the bullet point*/
margin-left:0;
}
ul.enlarge li{
display:inline-block; /*places the images in a line*/
position: relative;
z-index: 0; /*resets the stack order of the list items - later we'll increase this*/
margin:10px 40px 0 20px;
}
ul.enlarge img{
background-color:#eae9d4;
padding: 6px;
-webkit-box-shadow: 0 0 6px rgba(132, 132, 132, .75);
-moz-box-shadow: 0 0 6px rgba(132, 132, 132, .75);
box-shadow: 0 0 6px rgba(132, 132, 132, .75);
-webkit-border-radius: 4px; 
-moz-border-radius: 4px; 
border-radius: 4px; 
}
ul.enlarge span{
position:absolute;
left: -9999px;
background-color:#eae9d4;
padding: 10px;
font-family: 'Droid Sans', sans-serif;
font-size:.9em;
text-align: center; 
color: #495a62; 
-webkit-box-shadow: 0 0 20px rgba(0,0,0, .75));
-moz-box-shadow: 0 0 20px rgba(0,0,0, .75);
box-shadow: 0 0 20px rgba(0,0,0, .75);
-webkit-border-radius: 8px; 
-moz-border-radius: 8px; 
border-radius:8px;
}
ul.enlarge li:hover{
z-index: 50;
cursor:pointer;
}
ul.enlarge span img{
padding:2px;
background:#ccc;
}
ul.enlarge li:hover span{ 
top: -300px; /*the distance from the bottom of the thumbnail to the top of the popup image*/
left: -20px; /*distance from the left of the thumbnail to the left of the popup image*/
}
ul.enlarge li:hover:nth-child(2) span{
left: -100px; 
}
ul.enlarge li:hover:nth-child(3) span{
left: -200px; 
}
/**IE Hacks - see http://css3pie.com/ for more info on how to use CS3Pie and to download the latest version**/
ul.enlarge img, ul.enlarge span{
behavior: url(pie/PIE.htc); 
}
</style>