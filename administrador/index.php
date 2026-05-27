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
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo URL_IMAGES ?>favicon.png" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?php echo URL_IMAGES ?>favicon.png">

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
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><?php echo $resUsuario->nome_exibicao ?></span> <b class="caret"></b></a>
	            <ul class="dropdown-menu">
	              <!-- <li><a href="<?php echo URL_ADMIN ?>perfil/">Minha conta</a></li>
	              <li class="divider"></li> -->
	              <li><a href="<?php echo URL_ADMIN ?>logout/">Sair</a></li>
	            </ul>
	          </li>
	        </ul>			
	        <!-- <ul class="nav navbar-nav not-nav">
	          <li class="button dropdown">
	            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class=" fa fa-inbox"></i></a>
	            <ul class="dropdown-menu messages">
	              <li>
	                <div class="nano nscroller">
	                  <div class="content">
	                    <ul>
	                      <li>
	                        <a href="#">
	                          <img src="images/avatar2.jpg" alt="avatar" /><span class="date pull-right">13 Sept.</span> <span class="name">Daniel</span> Hey! How are you?
	                        </a>
	                      </li>
	                      <li>
	                        <a href="#">
	                          <img src="images/avatar_50.jpg" alt="avatar" /><span class="date pull-right">20 Oct.</span><span class="name">Adam</span> Hi! Can you fix my phone?
	                        </a>
	                      </li>
	                      <li>
	                        <a href="#">
	                          <img src="images/avatar4_50.jpg" alt="avatar" /><span class="date pull-right">2 Nov.</span><span class="name">Michael</span> Regards!
	                        </a>
	                      </li>
	                      <li>
	                        <a href="#">
	                          <img src="images/avatar3_50.jpg" alt="avatar" /><span class="date pull-right">2 Nov.</span><span class="name">Lucy</span> Hello, my name is Lucy
	                        </a>
	                      </li>
	                    </ul>
	                  </div>
	                </div>
	                <ul class="foot"><li><a href="#">View all messages </a></li></ul>           
	              </li>
	            </ul>
	          </li>
	          <li class="button dropdown">
	            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i><span class="bubble">2</span></a>
	            <ul class="dropdown-menu">
	              <li>
	                <div class="nano nscroller">
	                  <div class="content">
	                    <ul>
	                      <li><a href="#"><i class="fa fa-cloud-upload info"></i><b>Daniel</b> is now following you <span class="date">2 minutes ago.</span></a></li>
	                      <li><a href="#"><i class="fa fa-male success"></i> <b>Michael</b> commented on your link <span class="date">15 minutes ago.</span></a></li>
	                      <li><a href="#"><i class="fa fa-bug warning"></i> <b>Mia</b> commented on post <span class="date">30 minutes ago.</span></a></li>
	                      <li><a href="#"><i class="fa fa-credit-card danger"></i> <b>Andrew</b> sent you a request <span class="date">1 hour ago.</span></a></li>
	                    </ul>
	                  </div>
	                </div>
	                <ul class="foot"><li><a href="#">View all activity </a></li></ul>           
	              </li>
	            </ul>
	          </li>
	          <li class="button"><a class="toggle-menu menu-right push-body" href="javascript:;" class="speech-button"><i class="fa fa-comments"></i></a></li>				
	        </ul>
 -->
	      </div><!--/.nav-collapse animate-collapse -->
	    </div>
	  </div>
	  
	<div class="cl-mcont">		
		<div class="row no-margin-top">

			<?php

			// Verifica retorno de erro
			if ($_SESSION['return_type']){
				echo '
				<div class="alert alert-'.$_SESSION['return_type'].'">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<strong>'.$_SESSION['return_message'].'</strong> 
				</div>
				';
			}
			
			// Tratamento de model e action
			$_GET['model'] 	= isset($_GET['model'])&&$_GET['model']!=''?$_GET['model']:'';
			$_GET['action'] = isset($_GET['action'])&&$_GET['action']!=''?$_GET['action']:'listar';
				
			// Verifica se a permissão é a publica ou privada
			if ($_GET['model'] == 'perfil' || $_GET['model'] == ''){
				
				if ($_GET['model'] == 'perfil'){
				
					// Verifica se o arquivo público existe
					if (file_exists(PATH_ADMIN.'app/perfil/editar.php')){
						require_once(PATH_ADMIN.'app/perfil/editar.php');
					} else {
						echo '
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-times-circle sign"></i><strong>Erro!</strong> 
						</div>
						';
					}
					
				}else{
				
					// Verifica se o arquivo público existe
					if (file_exists(PATH_ADMIN.'app/inicio/graficos.php')){
						require_once(PATH_ADMIN.'app/inicio/graficos.php');
					} else {
						echo '
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-times-circle sign"></i><strong>Erro!</strong> 
						</div>
						';
					}
					
				}
				
			} else {
				
				try {
				
					// Verifica
					if (isset($_GET['action']) && $_GET['action'] != 'listar'){
						$where = ' AND p.action = "'.$_GET['action'].'"';
					} else { 
						$where = ' AND p.tipo = 0';
					}

					if(isset($_SESSION['sess_usuario_id'])&&$_SESSION['sess_usuario_id']){
			            $wherePermissao = "1=1";
			        }else{
			            $wherePermissao = "p.id in (select `usuario_permissao_id` from `modulo_permissao`)";
			        }



					// Busca por permissão de acesso
					$retPermissao = Doctrine_Query::create()
								->from('UsuarioPermissao p')
								->innerJoin('p.UsuarioGrupoPermissao g')
								->addWhere('g.usuario_grupo_id = '.$_SESSION['sess_usuario_grupo_id'])
								->addWhere('p.model = "'.$_GET['model'].'"'.$where)
								->addWhere($wherePermissao);
					
					// echo 'p.model = "'.$_GET['model'].'"'.$where;
					// echo $retPermissao->count();
					
					// Checagem de permissão de acesso
					if ($retPermissao->count()>0){
						// Tratamento de retorno
						$resPermissao = $retPermissao->fetchOne(null,Doctrine::HYDRATE_ARRAY);
						$resPermissao['action'] = is_null($resPermissao['action'])?'listar':$resPermissao['action'];
						
						// Verifica existência dos arquivos do módulo
						if (file_exists(PATH_ADMIN.'app/'.$resPermissao['model'].'/'.$resPermissao['action'].'.php')){
							require_once(PATH_ADMIN.'app/'.$resPermissao['model'].'/'.$resPermissao['action'].'.php');
						} else {
							// $_SESSION['return_type']	= 'error';
							// $_SESSION['return_message'] = 'Ocorreu um erro no sistema.';
							echo '
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<i class="fa fa-times-circle sign"></i><strong>Ocorreu um erro, tente novamente.</strong> 
							</div>
							';
						}
						
					} else {
						// Tratamento de retorno
						$_SESSION['return_type']	= 'warning';
						$_SESSION['return_message']	= 'Permissão negada.';
						echo '
						<div class="alert alert-'.$_SESSION['return_type'].'">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-times-circle sign"></i><strong>'.$_SESSION['return_message'].'</strong> 
						</div>
						';
					}
					
				} catch (Exception $e){
					// Tratamento de retorno
					$_SESSION['return_type'] 	= 'error';
					$_SESSION['return_message']	= 'Ocorreu um erro de permissão, tente novamente.'.$e;
					echo '
						<div class="alert alert-'.$_SESSION['return_type'].'">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="fa fa-times-circle sign"></i><strong>'.$_SESSION['return_message'].'</strong> 
						</div>
					';
				}
				
			}
			
			// Limpeza de sessões de retorno
			$_SESSION['return_type'] = false;
			$_SESSION['return_message'] = false;
			
			?>
			
			<?php 
				require_once(PATH_ADMIN.'includes/default_js.php'); 
			?>
		</div>
	</div>
	
</div>
</body>
</html>