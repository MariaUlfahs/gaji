<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> 
		<h4 class="modal-title" id="myLargeModalLabel"><?php echo @$title ?></h4>
	</div>
	<div class="modal-body">
		<form class="form-horizontal" method="post" id="formdata">
			<div class="form-group">
				<label class="col-sm-2 control-label">Kode Jabatan</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="kd_jabatan" name="kd_jabatan" value="<?php echo @$kd_jabatan ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Nama Jabatan</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" value="<?php echo @$nama_jabatan ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Gaji Pokok</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="gapok" placeholder="Isilah dengan angka" name="gapok" value="<?php echo @$gapok ?>" required>
				</div>
			</div>
			<input type="hidden" name="id" value="<?php echo @$kd_jabatan ?>">
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-success" value="simpan" name="simpan"><i class="fa fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
$(function(){
    $("#formdata").submit(function(event){
        event.preventDefault();
        $.ajax({
            url:'<?php echo base_url('master/simpan_jabatan') ?>',
            cache: false,
            type:'POST',
            data:$(this).serialize(),
                success:function(result) {
                    $("#peringatan").html(result);
					$("#tabelku").DataTable().draw();
					$("#modalutama").modal('hide');
                }
        });
    });
});
</script>