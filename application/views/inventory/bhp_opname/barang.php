<table width="80%" align="center" border="1">
	<tr>
		<th>Tanggal</th>
		<th>Jumlah</th>
		<th>Harga (Rp.)</th>
	</tr>
	<?php
		foreach ($data_barang as $key) {
	?>
	 <tr>
	 	<td><?php echo date("d-m-Y",strtotime($key->tgl_update)); ?></td>
	 	<td><?php echo $key->jml; ?></td>
	 	<td><?php echo number_format($key->harga,2); ?></td>
	 </tr>
	<?php
		}
	?>
</table>