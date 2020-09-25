<table class="table table-bordered table-hover">
<thead>
<tr>
    <th width="2%" rowspan="2">No</th>
    <th rowspan="2">Jenis Pembayaran</th>
    <th colspan="<?php echo count($arrkelas) ?>">Kelas</th>
</tr>
<tr>
<?php
foreach ($arrkelas as $key => $val) {
    ?>
    <th><?php echo $val ?></th>
    <?php
}
?>
</tr>
</thead>
<tbody>
<?php
$no=1;
foreach ($arrjenis as $key => $val) {
    ?>
    <tr>
        <td><?php echo $no ?></td>
        <td><?php echo $val ?></td>
        <?php
        foreach ($arrkelas as $key2 => $val2) {
            $total=@array_sum($arrtotal[$key][$val2]);
            if ($total) {
                $tot=$total;
            } else {
                $tot=0;
            }
            ?>
            <td>Rp <?php echo number_format($tot,0,',','.') ?></td>
            <?php
        }
        ?>
    </tr>
    <?php
    $no++;
}
?>
</tbody>
</table>