<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button> 
		<h4 class="modal-title" id="myLargeModalLabel"><?php echo @$title ?></h4>
	</div>
	<div class="modal-body">
		<form class="form-horizontal" method="post" id="formdata">
			<div class="form-group">
				<label class="col-sm-2 control-label">NIP</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="nip" name="nip" value="<?php echo @$nip ?>" required>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Nama</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="nama" name="nama" value="<?php echo @$nama ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Jenis Kelamin</label>
				<div class="col-sm-10">
					<input type="radio" id="jekel" name="jekel" value="L" <?php if (@$jekel=='L') echo 'checked' ?> required> Laki-Laki<br />
					<input type="radio" id="jekel" name="jekel" value="P" <?php if (@$jekel=='P') echo 'checked' ?> required> Perempuan
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Telepon</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo @$telepon ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Alamat</label>
				<div class="col-sm-10">
					<textarea class="form-control" id="alamat" name="alamat"><?php echo @$alamat ?></textarea>
				</div>
			</div>
			<input type="hidden" name="id" value="<?php echo @$nim ?>">
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
            url:'<?php echo base_url('master/simpan_karyawan') ?>',
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