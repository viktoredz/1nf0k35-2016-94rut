<table width="80%" align="center" border="1">
  <tr>
    <th>Tanggal</th>
    <th>Baik</th>
    <th>Rusak</th>
    <th>Tidak diPakai</th>
  </tr>
  <?php
    foreach ($data_kondisi as $key) {
  ?>
   <tr>
    <td><?php echo date("d-m-Y",strtotime($key->tgl_update)); ?></td>
    <td><?php echo '11'; ?></td>
    <td><?php echo $key->jml_rusak; ?></td>
    <td><?php echo $key->jml_tdkdipakai; ?></td>
   </tr>
  <?php
    }
  ?>
</table>