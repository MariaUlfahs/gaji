<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Laporan Pembayaran per Mahasiswa</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="#">Laporan</a></li>
            <li class="active">Pembayaran Per Mahasiswa</li>
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
                        <select class="form-control" name="jenis" id="jenis">
                            <option value="">-- semua pembayaran --</option>
                            <?php
                            foreach ($jenis as $hasil) { 
                                 ?>
                                <option value="<?php echo $hasil->id_jenisbayar ?>"><?php echo $hasil->jenis_bayar ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="kelas" id="kelas" onchange="siswa()">
                            <option value="">-- pilih kelas --</option>
                            <?php
                            foreach ($kelas as $hasil) { 
                                 ?>
                                <option value="<?php echo $hasil->kode_kelas ?>"><?php echo $hasil->kode_kelas ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="nim" id="nim">
                            <option value="">-- pilih mahasiswa --</option>
							<?php
                            foreach ($siswa as $hasil) { 
                                 ?>
                                <option value="<?php echo $hasil->nim ?>"><?php echo $hasil->nim.' / '.$hasil->nama ?></option>
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
    var tahun=$("#tahun").val();
    var jenis=$("#jenis").val();
    var kelas=$("#kelas").val();
    var nim=$("#nim").val();
    $.ajax({
        url:"<?php echo base_url('laporan/datatunggakansiswa') ?>",
        cache:false,
        type:"POST",
        data:{tahun:tahun,jenis:jenis,kelas:kelas,nim:nim},
        beforeSend: function(){
            $("#konten").html('<center><img src="<?php echo base_url('assets/img/loading.gif') ?>"></center>');
        },
        success:function(result){
            $("#konten").html(result);
        }
    });
}

function siswa() {
    var kelas=$("#kelas").val();
    $.ajax({
        url:"<?php echo base_url('laporan/carisiswa') ?>",
        cache:false,
        type:"POST",
        data:{kelas:kelas},
        success:function(result){
            $("#nim").html(result);
        }
    });
}
</script>