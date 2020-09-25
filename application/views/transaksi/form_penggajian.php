<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Transaksi Penggajian</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('beranda') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="#">Transaksi</a></li>
            <li class="active">Penggajian</li>
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
                        <label class="col-sm-2 control-label">NIP/Nama</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="nip" name="nip" onchange="carigapok()" required>
                                <option value="">-- pilih Karyawan --</option>
                                <?php
                                foreach ($karyawan as $hasil) {
                                    ?>
                                    <option value="<?php echo $hasil->nip ?>"><?php echo $hasil->nip.' / '.$hasil->nama ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
					 <div class="form-group">
                        <label class="col-sm-2 control-label">Gapok</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="gapok" name="gapok" onchange="caritotal()" readonly>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-2 control-label">Jenis Tambahan</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="id_jenistambahan" name="id_jenistambahan" onchange="caritambahan()" required>
                                <option value="">-- pilih jenis Tambahan --</option>
                                <?php
                                foreach ($jenistambahan as $hasil) {
                                    ?>
                                    <option value="<?php echo $hasil->id_jenistambahan ?>"><?php echo $hasil->jenis_tambahan ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
					
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nominal Tambahan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nom_tambahan" name="nom_tambahan" readonly>
                        </div>
                    </div>
					
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Total Gaji</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="total_gaji" name="total_gaji" readonly>
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
            url:'<?php echo base_url('transaksi/simpan_gaji') ?>',
            cache: false,
            type:'POST',
            data:$(this).serialize(),
                success:function(result) {
                    $("#peringatan").html(result);
                    $("#formdata").trigger("reset");
                    $("#nip").val("").trigger("change");
                    $("#jenistambahan").val("").trigger("change");
                    
                }
        });
    });
});

$(function() {
    $(".select2").select2();
});

function caritambahan() {
    var nip=$("#nip").val();
    var id_jenistambahan=$("#id_jenistambahan").val();
	var gapok=$("#gapok").val();
	$.ajax({
        url:'<?php echo base_url('transaksi/cari_tambahan') ?>',
        cache: false,
        type:'POST',
        data:{
                nip:nip,
                id_jenistambahan:id_jenistambahan
            },
            success:function(result) {
                $("#nom_tambahan").val(result);
				total_gaji=parseInt(result)+parseInt(gapok);
				$("#total_gaji").val(total_gaji);
            }
    });
} 


function carigapok() {
    var nip=$("#nip").val();
	var kd_jabatan=$("#kd_jabatan").val();
    $.ajax({
        url:'<?php echo base_url('transaksi/cari_gapok') ?>',
        cache: false,
        type:'POST',
        data:{
                nip:nip,
				kd_jabatan:kd_jabatan
                
            },
            success:function(result) {
                $("#gapok").val(result);
				total_gaji();
            }
    });
} 

function total_gaji() {
	var gapok=$("#gapok").val();
	var nom_tambahan=$("#nom_tambahan").val();
	total_gaji=parseInt(gapok)+parseInt(nom_tambahan);
	//alert(nom_tambahan);
	$("#total_gaji").val(total_gaji);
}


function batal() {
    $("#formdata").trigger("reset");
    $("#nip").val("").trigger("change");
    
    $("#jenis_tambahan").val("").trigger("change");
}
</script>
