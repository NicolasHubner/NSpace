<?php 

require_once('../lib/Config.php'); 

// Checa o usuário está logado
if (Util::checkLoginAdmin()){
	header('Location: '.URL_ADMIN);
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Autenticação - <?php echo TITLE_DEFAULT; ?></title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo URL_IMAGES ?>favicon.png" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?php echo URL_IMAGES ?>favicon.png">
	
	<!-- Bootstrap core CSS -->
	<link href="<?php echo URL_ADMIN_JS; ?>bootstrap/dist/css/bootstrap.css" rel="stylesheet">

	<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS; ?>fonts/font-awesome-4/css/font-awesome.min.css">

	<link href="<?php echo URL_ADMIN_CSS; ?>style.css" rel="stylesheet" />	

</head>

<body class="texture">

<div id="cl-wrapper" class="login-container">
	<div class="middle-login" style="top: 40%;">
		<?php if (isset($_SESSION['return_message'])){ ?>
			<div class="alert alert-<?php echo $_SESSION['return_type'] ?>">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<i class="fa fa-times-circle sign"></i><strong><?php echo $_SESSION['return_message'] ?></strong> 
			</div>
		<?php } ?>

		<div class="login-form">
			<div class="logomarca text-center">
				<img src="<?php echo URL_ADMIN ?>images/logo-acesso.png">
			</div>

			<!-- <h4 class="title text-center">Admin</h4> -->
			<form method="post" action="<?php echo URL_ADMIN.'authentication/'; ?>">
				<div class="row">
					<div class="col-md-12">
						<input type="email" class="duo-input" name="email" id="email" placeholder="E-mail" required>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<input type="password" class="duo-input" name="senha" id="senha" placeholder="Senha" required>
					</div>
				</div>

				<input type="submit" class="btn-login" value="Entrar">
			</form>
		</div>
	</div>
</div>


<script src="js/jquery.js"></script>
	<script type="text/javascript">
    $(function(){
      $("#cl-wrapper").css({opacity:1,'margin-left':0});
    });
  </script>
 
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
  <script src="<?php echo URL_ADMIN ?>js/behaviour/voice-commands.js"></script>
  <script src="<?php echo URL_ADMIN ?>js/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN ?>js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN ?>js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN ?>js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN ?>js/jquery.flot/jquery.flot.labels.js"></script>
</body>
</html>
