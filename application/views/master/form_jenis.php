<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Jenis Pembayaran</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="#">Master</a></li>
            <li class="active">Jenis Pembayaran</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div id="peringatan"></div>
                <form class="form-horizontal" method="post" id="formdata">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Jenis Pembayaran</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jenis" name="jenis" value="<?php echo @$jenis ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-10">
                            <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Besaran Biaya</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($datakelas as $hasil) {
                                ?>
                                <tr>
                                    <td><?php echo $hasil->kode_kelas ?></td>
                                    <td><input type="tex" class="form-control" name="<?php echo $hasil->kode_kelas ?>" id="<?php echo $hasil->kode_kelas ?>" value="<?php echo @$arrbiaya[$hasil->kode_kelas] ?>"></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo @$id ?>">
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" value="simpan" name="simpan"><i class="fa fa-save"></i> Simpan</button>
                            <a href="<?php echo base_url('master/jenis') ?>" class="btn btn-warning"><i class="fa fa-times"></i> Batal</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">
$(function(){
    $("#formdata").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:'<?php echo base_url('master/simpan_jenis') ?>',
            cache: false,
            type:'POST',
            data:$(this).serialize(),
                success:function(result) {
                    $("#peringatan").html(result);
                    <?php
                    if (@$id=='') {
                        ?>
                        $("#formdata").trigger('reset');
                        <?php
                    }
                    ?>
                }
        });
    });
});
</script>