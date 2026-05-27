<?php

// Arquivo de configuração
require_once('../lib/Config.php');

// Checa o usuário está logado
if (!Util::checkLoginAdmin()){
	header('Location: '.URL_ADMIN.'login/');
	exit;
}

// Constante de controle
define('_SYSTEM',1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" type="image/png" href="<?php echo URL ?>images/favicon.png" />

	<title><?php echo TITLE_DEFAULT ?></title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<script src="https://code.highcharts.com/highcharts.js"></script>

	<script type="text/javascript">
	URL_ADMIN = "<?php echo URL_ADMIN; ?>";
	</script>
	<?php 

	// Load de javascript e css padrão
	require_once(PATH_ADMIN.'includes/default_css.php');

	?>
</head>

<body>

<div id="cl-wrapper">

	<div class="cl-sidebar">
	    <div class="cl-toggle"><i class="fa fa-bars"></i></div>
	    <div class="cl-navblock">
	      <div class="menu-space">
	        <div class="content">
	          <div class="sidebar-logo">
		            <div class="logo">
		                <a href="index2.html"></a>
		            </div>
	          		</div>
	          		<?php include(PATH_ADMIN.'includes/profile_bar.php') ?>
	          		<?php include(PATH_ADMIN.'includes/menu.php') ?>
	        	</div>
	      	</div>
	    </div>
	</div>
	<?php

		try {

			// Seleciona os dados do usuário		
			$resUsuario = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);

			// Define avatar
			$avatar = 	URL_USUARIO;
			$avatar .= 	$resUsuario->imagem!=''?$resUsuario->imagem:'default.png';

		} catch (Exception $e){
			exit('Ocorreu um erro!');
		}
	?>


	  <div id="head-nav" class="navbar navbar-default">
	    <div class="container-fluid">
	      <div class="navbar-collapse">
	        <ul class="nav navbar-nav navbar-right user-nav">
	          <li class="dropdown profile_menu">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><?php echo TITLE_DEFAULT ?></span> <b class="caret"></b></a>
	            <ul class="dropdown-menu">
	              <li><a href="<?php echo URL_ADMIN ?>perfil/">Minha conta</a></li>
	              <li class="divider"></li>
	              <li><a href="<?php echo URL_ADMIN ?>logout/">Sair</a></li>
	            </ul>
	          </li>
	        </ul>
	      </div><!--/.nav-collapse animate-collapse -->
	    </div>
	  </div>
	  
	<div class="cl-mcont">	
		<?php
			require_once(PATH_ADMIN.'app/modulo-permissao/listar.php');
		?>

		<div class="row no-margin-top">			
			<?php 
				require_once(PATH_ADMIN.'includes/default_js.php'); 
			?>
		</div>
	</div>
	
</div>
</body>
</html>