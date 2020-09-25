<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Rekap Pendapatan</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="#">Laporan</a></li>
            <li class="active">Rekap Pendapatan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <form class="form-inline" id="forminput" onsubmit="">
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="tanggal" id="tanggal">
                            <option value="">Semua Tanggal</option>
                            <?php
                            for ($i=1; $i<=31 ; $i++) {
                                if ($i<10) {
                                    $d='0'.$i;
                                } else {
                                    $d=$i;
                                }
                                ?>
                                <option value="<?php echo $d ?>" <?php if ($d==@$tanggal) echo 'selected' ?>><?php echo $d ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="bulan" id="bulan">
                            <option value="">Semua Bulan</option>
                            <?php
                            foreach ($arrbulan as $key => $value) {
                                ?>
                                <option value="<?php echo $key ?>" <?php if ($key==date('m')) echo 'selected' ?>><?php echo $value ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="tahun" id="tahun">
                            <option value="">-- pilih tahun --</option>
                            <?php
                            for ($i=2016; $i<=@$tahun+3 ; $i++) { 
                                 ?>
                                <option value="<?php echo $i ?>" <?php if ($i==@$tahun) echo 'selected' ?>><?php echo $i ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="kelas" id="kelas">
                            <option value="">Semua tingkat kelas</option>
                            <?php
                            foreach ($kelas as $hasil) { 
                                 ?>
                                <option value="<?php echo $hasil->tingkat ?>"><?php echo $hasil->tingkat ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="tampilkan()"><i class="fa fa-search"></i> Tampilkan</button>
                </form>
            </div>
            <div class="box-body" id="konten"></div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">
function tampilkan() {
    var tanggal=$("#tanggal").val();
    var bulan=$("#bulan").val();
    var tahun=$("#tahun").val();
    var kelas=$("#kelas").val();
    $.ajax({
        url:"<?php echo base_url('laporan/datarekappendapatan') ?>",
        cache:false,
        type:"POST",
        data:{tanggal:tanggal,bulan:bulan,tahun:tahun,kelas:kelas},
        beforeSend: function(){
            $("#konten").html('<center><img src="<?php echo base_url('assets/img/loading.gif') ?>"></center>');
        },
        success:function(result){
            $("#konten").html(result);
        }
    });
}
</script>