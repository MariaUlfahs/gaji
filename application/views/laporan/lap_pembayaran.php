<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Transaksi Pembayaran</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="#">Master</a></li>
            <li class="active">Data Kelas</li>
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
                        <select class="form-control" name="jenis" id="jenis">
                            <option value="">Semua pembayaran</option>
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
                        <select class="form-control" name="debitur" id="debitur">
                            <option value="">Semua debitur</option>
                            <?php
                            foreach ($debitur as $hasil) { 
                                 ?>
                                <option value="<?php echo $hasil->debitur ?>"><?php echo $hasil->debitur ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label></label>
                        <select class="form-control" name="kelas" id="kelas">
                            <option value="">Semua kelas</option>
                            <?php
                            foreach ($kelas as $hasil) { 
                                 ?>
                                <option value="<?php echo $hasil->kode_kelas ?>"><?php echo $hasil->kode_kelas ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="tampilkan()"><i class="fa fa-search"></i> Tampilkan</button>
                </form>
            </div>
            <div class="box-body">
                <div id="peringatan"></div>
                <table id="tabelku" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>NIM</th>
                       
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jenis Pembayaran</th>
						
                        <th>Jumlah Bayar</th>
                        <th>Debitur</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody></tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

<!-- Delete Modal content-->
<div class="modal fade" id="delete_confirmation_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Apakah yakin akan menghapus data ini?</h4>
            </div>
            <div class="modal-footer">
                <button name="hapus" id="hapus" value="" onclick="hapusdata(this.value)" class="btn btn-danger"><i class="fa fa-check"></i> Ya</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var tanggal=$("#tanggal").val();
    var bulan=$("#bulan").val();
    var tahun=$("#tahun").val();
    var jenis=$("#jenis").val();
    var debitur=$("#debitur").val();
    var kelas=$("#kelas").val();
    $('#tabelku').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                url :"<?php echo base_url('laporan/datapembayaran')?>/?tanggal="+tanggal+"&bulan="+bulan+"&tahun="+tahun+"&jenis="+jenis+"&debitur="+debitur+"&kelas="+kelas,
                type: "post", 
            },
    });
});

function tampilkan() {
    var tanggal=$("#tanggal").val();
    var bulan=$("#bulan").val();
    var tahun=$("#tahun").val();
    var jenis=$("#jenis").val();
    var debitur=$("#debitur").val();
    var kelas=$("#kelas").val();
    var table=$("#tabelku").DataTable();
    url="<?php echo base_url('laporan/datapembayaran') ?>/?tanggal="+tanggal+"&bulan="+bulan+"&tahun="+tahun+"&jenis="+jenis+"&debitur="+debitur+"&kelas="+kelas;
    table.ajax.url(url).load();
}

function represh() {
    $('#tabelku').DataTable().draw();
}

function konfirhapus(i) {
    $("#hapus").val(i);
    $("#delete_confirmation_modal").modal("show");
}

function hapusdata(str) {
    $.ajax({
        url:"<?php echo base_url('master/hapus_kelas') ?>",
        cache:false,
        type:"POST",
        data:{id:str},
            success:function(result){
                $("#peringatan").html(result);
                $("#delete_confirmation_modal").modal("hide");
                $("#tabelku").DataTable().draw();
            }
    });
}
</script>