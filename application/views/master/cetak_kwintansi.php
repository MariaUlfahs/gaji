<!DOCTYPE html>
<html>
<head>
	<title><?php echo @$title ?></title>
</head>
<body>
<table border="1" width="75%" cellspacing="0" cellpadding="10">
<tr>
	<td>
		<center>
			<h2>KWITANSI PEMBAYARAN</h2>
		</center>
		<hr>
		<table border="0" cellspacing="0" cellpadding="2" width="100%">
		<tr>
			<td width="25%">Nomor</td>
			<td width="2%">:</td>
			<td><?php echo @$id ?></td>
		</tr>
		<tr>
			<td>Telah diterima dari</td>
			<td>:</td>
			<td><?php echo @$dari ?></td>
		</tr>
		<tr>
			<td>Uang Sejumlah</td>
			<td>:</td>
			<td style="background: #b7a5a5;"><b><?php echo @$terbilang ?></b></td>
		</tr>
		<tr>
			<td>Untuk Pembayaran</td>
			<td>:</td>
			<td><?php echo @$bayar ?></td>
		</tr>
		</table>
		<br />
		<table border="0" width="100%">
		<tr>
			<td width="60%">
				<div style="background: #b7a5a5; width: 50%; padding: 15px;">
					<b>Terbilang : Rp <?php echo number_format(@$jumlah,0,',','.') ?></b>
				</div>
			</td>
			<td align="center">
				Purwokerto, <?php echo @$tanggalan ?>
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				_____________________________________
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</body>
</html>