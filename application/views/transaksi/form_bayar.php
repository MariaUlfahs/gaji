<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Transaksi Pembayaran</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="#">Transaksi</a></li>
            <li class="active">Pembayaran</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div id="peringatan"></div>
                <form class="form-horizontal" id="formdata">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tanggal</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo @$tanggal ?>" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">NIM/Nama</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="nim" name="nim" required>
                                <option value="">-- pilih Mahasiswa --</option>
                                <?php
                                foreach ($siswa as $hasil) {
                                    ?>
                                    <option value="<?php echo $hasil->nim ?>"><?php echo $hasil->nim.' / '.$hasil->nama ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Jenis Pembayaran</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="jenis" name="jenis" onchange="caribiaya()" required>
                                <option value="">-- pilih jenis pembayaran --</option>
                                <?php
                                foreach ($jenis as $hasil) {
                                    ?>
                                    <option value="<?php echo $hasil->id_jenisbayar ?>"><?php echo $hasil->jenis_bayar ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Belum Dibayar</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="belum" name="belum" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Uang Bayar</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="bayar" name="bayar">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Debitur</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="debitur" name="debitur" required>
                                <option value="">-- pilih debitur --</option>
                                <?php
                                foreach ($debitur as $hasil) {
                                    ?>
                                    <option value="<?php echo $hasil->debitur ?>"><?php echo $hasil->debitur ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Keterangan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-8">
                        <button type="submit" class="btn btn-success" value="simpan" name="simpan"><i class="fa fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-warning" onclick="batal()"><i class="fa fa-times"></i> Batal</button>
                    </div>
                </form>
            </div>
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
            url:'<?php echo base_url('transaksi/simpan_bayar') ?>',
            cache: false,
            type:'POST',
            data:$(this).serialize(),
                success:function(result) {
                    $("#peringatan").html(result);
                    $("#formdata").trigger("reset");
                    $("#nis").val("").trigger("change");
                    $("#jenis").val("").trigger("change");
                    $("#debitur").val("").trigger("change");
                }
        });
    });
});

$(function() {
    $(".select2").select2();
});

function caribiaya() {
    var nim=$("#nim").val();
    var jenis=$("#jenis").val();
    $.ajax({
        url:'<?php echo base_url('transaksi/cari_bayar') ?>',
        cache: false,
        type:'POST',
        data:{
                nim:nim,
                jenis:jenis
            },
            success:function(result) {
                $("#belum").val(result);
            }
    });
}

function batal() {
    $("#formdata").trigger("reset");
    $("#nim").val("").trigger("change");
    $("#jenis").val("").trigger("change");
    $("#debitur").val("").trigger("change");
}
</script>
