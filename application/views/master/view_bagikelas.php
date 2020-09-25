<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pembagian Kelas Mahasiswa</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="#">Master</a></li>
            <li class="active">Pembagian Kelas Mahasiswa</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <form class="form-inline" id="forminput">
                    <div class="form-group">
                        <label>Kelas : </label>
                        <select class="form-control select2" id="kelas" name="kelas" onchange="tampilkan()">
                            <option value="">Semua Kelas</option>
                            <?php
                            foreach ($datakelas as $hasil) {
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
                        <th>NIM</th>
                        <th>NAMA</th>
                        
                        <th width="2%">L/P</th>
                        <th width="15%">Kelas</th>
                    </tr>
                </thead>
                <tbody></tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <p style="text-align: right;">
                    <a href="<?php  echo base_url('beranda') ?>" class="btn btn-success"><i class="fa fa-save"></i> Selesai</a>
                </p>
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#tabelku').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                url :"<?php echo base_url('master/databagikelas')?>",
                type: "post", 
            },
    });
});

$(function() {
    $(".select2").select2();
});

function tampilkan(str) {
    var kelas=$("#kelas").val();
    var table=$("#tabelku").DataTable();
    url="<?php echo base_url('master/databagikelas') ?>/?kelas="+kelas;
    table.ajax.url(url).load();
}

function simpankelas(nim,kelas) {
    $.ajax({
        url:'<?php echo base_url('master/simpan_bagikelas') ?>',
        cache: false,
        type:'POST',
        data:{
                nim:nim,
                kelas:kelas
            },
            success:function(result) {
                //diisi nanti
            }
    });
}
</script>