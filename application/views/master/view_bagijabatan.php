<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pembagian Jabatan Karyawan</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="#">Master</a></li>
            <li class="active">Pembagian Jabatan Karyawan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <form class="form-inline" id="forminput">
                    <div class="form-group">
                        <label>Jabatan : </label>
                        <select class="form-control select2" id="jabatan" name="jabatan" onchange="tampilkan()">
						
                            <option value="">Semua Jabatan</option>
                            <?php
                            foreach ($datajabatan as $hasil) {
                                ?>
                                <option value="<?php echo $hasil->kd_jabatan ?>"><?php echo $hasil->kd_jabatan ?></option>
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
                        <th>NIP</th>
                        <th>NAMA</th>
                        <th width="2%">L/P</th>
                        <th width="15%">Jabatan</th>
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
                url :"<?php echo base_url('master/databagijabatan')?>",
                type: "post", 
            },
    });
});

$(function() {
    $(".select2").select2();
});

function tampilkan(str) {
    var jabatan=$("#jabatan").val();
    var table=$("#tabelku").DataTable();
    url="<?php echo base_url('master/databagijabatan') ?>/?jabatan="+jabatan;
    table.ajax.url(url).load();
}

function simpanjabatan(nip,jabatan) {
    $.ajax({
        url:'<?php echo base_url('master/simpan_bagijabatan') ?>',
        cache: false,
        type:'POST',
        data:{
                nip:nip,
                jabatan:jabatan
            },
            success:function(result) {
                //diisi nanti
            }
    });
}
</script>