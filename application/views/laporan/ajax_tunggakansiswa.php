<table class="table table-bordered table-hover">
<thead>
<tr>
    <th rowspan="2">Bulan</th>
    <th>Pembayaran</th>
</tr>
<tr>
<?php
foreach ($jenis as $hasil) {
    ?>
    <th><?php echo $hasil->jenis_bayar ?></th>
    <?php
}
?>
</tr>
</thead>
<tbody>
<?php
foreach ($arrbulan as $key => $val) {
    ?>
    <tr>
        <td><?php echo $val ?></td>
        <?php
        foreach ($jenis as $hasil) {
            $bayar=@array_sum($arrbayar[$hasil->id_jenisbayar][$key]);
            if ($bayar) {
                $bia=$bayar;
            } else {
                $bia=0;
            }
            ?>
            <td><?php echo number_format($bia,0,',','.') ?></td>
            <?php
        }
        ?>
    </tr>
    <?php
}
?>
</tbody>
<tfoot>
<tr>
    <th>Jumlah</th>
    <?php
    foreach ($jenis as $hasil) {
        $total=@array_sum($arrtotal[$hasil->id_jenisbayar]);
        if ($total) {
            $tot=$total;
        } else {
            $tot=0;
        }
        ?>
        <th><?php echo number_format($tot,0,',','.') ?></th>
        <?php
    }
    ?>
</tr>
<tr>
    <th>Total yang Harus Dibayarkan</th>
    <?php
    foreach ($jenis as $hasil) {
        ?>
        <th><?php echo number_format($hasil->biaya,0,',','.') ?></th>
        <?php
    }
    ?>
</tr>
<tr>
    <th>Kekurangan</th>
    <?php
    foreach ($jenis as $hasil) {
        $kurang=$hasil->biaya-@array_sum($arrtotal[$hasil->id_jenisbayar]);
        ?>
        <th><?php echo number_format($kurang,0,',','.') ?></th>
        <?php
    }
    ?>
</tr>
</tfoot>
</table>