<!doctype html>
<html lang="en">
  <head>
    <title><?php echo $title; ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  </head>
  <body>
	<div class="container">
		<?php if($error){ ?>
		<br/><div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
		<?php } ?>
		<?php if($success){ ?>
		<br/><div class="alert alert-success" role="alert"><?php echo $success; ?></div>
		<?php } ?>
			<div class="card align-middle" style="width: 25rem; margin: 0 auto; top: 10rem;">
			  <div class="card-header">&nbsp;</div>
			  <div class="card-body">
			  	<form name="frmLogin" method="post" action="<?php echo site_url('login'); ?>">
				<div class="row">
					<div class="col-4">
					  Username
					</div>
					<div class="col-8">
					  <input type="text" name="username" class="form-control"/>
					</div>
				</div><br/>
				<div class="row">
					<div class="col-4">
					  Password
					</div>
					<div class="col-8">
					  <input type="password" name="userpasswd" class="form-control"/>
					</div>
				</div><br/>
				<input type="submit" class="btn btn-primary float-right clearfix" value="&nbsp;&nbsp;Login&nbsp;&nbsp;"/>
				</form>
			  </div>
			</div>
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>