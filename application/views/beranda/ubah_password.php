<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Ubah Password</h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Ubah Password</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                <?php echo @$peringatan ?>
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Password Lama</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="pass1" placeholder="Masukan password lama" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Password Baru</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="pass2" placeholder="Masukan password baru" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ulangi Password baru</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="pass3" placeholder="Ulangi password baru" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <button type="submit" name="ganti" value="ganti" class="btn btn-success">Ganti</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>