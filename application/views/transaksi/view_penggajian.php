<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Data Transaksi Penggajian</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="#">Master</a></li>
            <li class="active">Data Jabatan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <p style="text-align: right;">
                    <a href="<?php echo base_url('transaksi/gaji') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Transaksi Baru</a>
                    <a href="javascript:void()" onclick="represh()" class="btn btn-primary"><i class="fa fa-refresh"></i> Refresh</a>
                </p>
                <div class="alert alert-info" role="alert">
                    <p><strog>Hanya menampilkan data tanggal <?php echo @$tanggal ?></strog></p>
                </div>
                <hr />
            </div>
            <div class="box-body">
                <div id="peringatan"></div>
                <table id="tabelku" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>NIP</th>
                        
                        <th>Nama</th>
                        
                        <th>Gapok</th>
                        <th>Tambahan</th>
                        <th>Total Gaji</th>
                      
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
    $('#tabelku').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":{
                url :"<?php echo base_url('transaksi/datagaji')?>",
                type: "post", 
            },
    });
});

function tampilform(str) {
    $.ajax({
        url:"<?php echo base_url('master/form_jabatan') ?>",
        cache:false,
        type:"POST",
        data:{id:str},
            success:function(result){
                $("#modalform").html(result);
            }
    });
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
        url:"<?php echo base_url('master/hapus_jabatan') ?>",
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