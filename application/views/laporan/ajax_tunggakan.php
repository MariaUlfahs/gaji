<table class="table table-bordered table-hover">
<thead>
<tr>
    <th rowspan="2">NIM</th>
    
    <th rowspan="2">Nama</th>
    <th colspan="<?php echo count($jenis)*2 ?>">Kekurangan Pembayaran</th>
</tr>
<tr>
<?php
foreach ($jenis as $hasil) {
    ?>
    <th>
        <?php echo $hasil->jenis_bayar ?><br />
        (Rp <?php echo number_format($hasil->biaya,0,',','.') ?>)
    </th>
    <?php
}
?>
</tr>
</thead>
<tbody>
<?php
foreach ($siswa as $hasil) {
    ?>
    <tr>
        <td><?php echo $hasil->nim ?></td>
        
        <td><?php echo $hasil->nama ?></td>
        <?php
        foreach ($jenis as $hasil2) {
            $kurang=$hasil2->biaya-@array_sum($arrbayar[$hasil->nim][$hasil2->id_jenisbayar]);
            if ($kurang) {
                $kurangan=$kurang;
            } else if ($kurang<=0) {
                $kurangan=0;
            }
            ?>
            <td>Rp <?php echo number_format($kurangan,0,',','.') ?></td>
            <?php
        }
        ?>
    </tr>
    <?php
}
?>
</tbody>
</table>