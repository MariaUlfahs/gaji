<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo base_url('assets/css/AdminLTE.css') ?>" rel="stylesheet" type="text/css" />
<?php echo @$peringatan ?>
<title>Login</title>
</head>
<body class="login-page">

<div class="login-box">
	<div class="login-box-body">
		<p class="app-text">APLIKASI PENGGAJIAN KARYAWAN</p>
		<p class="app-detail">CV. Bintang Media Informatika</p>
		<img src="<?php echo base_url('assets/img/user.jpg');?>" class="img-login">

		
		<form action="" method="post">
			<div class="form-group has-feedback">
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
				<input type="text" name="user" class="form-control" placeholder="Masukan Username"/>
			</div>
			<div class="form-group has-feedback">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				<input type="password" name="pass" class="form-control" placeholder="Masukan Password"/>
			</div><br>
			<div class="row">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
				</div>
			</div>
		</form>
		<br><br>
		<div class="footer-login"><?php echo 'CV. Bintang Media Informatika<br />Purwokerto - '.date('Y');?></div>
	</div>
</div>
</body>
</html>