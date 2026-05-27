<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<link href="<?php echo URL_ADMIN_JS; ?>bootstrap/dist/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_JS; ?>jquery.gritter/css/jquery.gritter.css" />
<link rel="stylesheet" href="<?php echo URL_ADMIN_JS ?>fontawesome/css/fontawesome.min.css"/>
<link rel="stylesheet" href="<?php echo URL_ADMIN_JS ?>fontawesome/css/all.min.css"/>


<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="../../assets/js/html5shiv.js"></script>
  <script src="../../assets/js/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_JS; ?>jquery.nanoscroller/nanoscroller.css" />

<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_JS; ?>jquery.codemirror/lib/codemirror.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_JS; ?>jquery.codemirror/theme/ambiance.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_JS; ?>jquery.icheck/skins/flat/green.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_JS; ?>jquery.vectormaps/jquery-jvectormap-1.2.2.css"  media="screen"/>
<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS; ?>colpick.css" type="text/css" />

<link href="<?php echo URL_ADMIN_CSS; ?>style.css" rel="stylesheet" />	

<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_JS; ?>jquery.datatables/bootstrap-adapter/css/datatables.css" />
<script src="<?php echo URL_ADMIN_JS; ?>jquery.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo URL_ADMIN_JS; ?>dropzone/css/dropzone.css">
<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/jquery.fancybox.min.css">
<link rel="stylesheet" href="<?php echo URL ?>assets/js/lobibox/css/lobibox.css"/>

<?php 

$css_file = '';

// Verificação para abertura de um arquivo específico para o módulo
if (isset($_GET['model']) && isset($_GET['action'])){
	$css_file = URL_ADMIN.'app/'.$_GET['model'].'/css/'.$_GET['action'].'.css';
	if (file_exists(PATH_ADMIN.'app/'.$_GET['model'].'/css/'.$_GET['action'].'.css')){
		echo '<link rel="stylesheet" href="'.$css_file.'" type="text/css" />';
	}
} else if (isset($_GET['model'])){
	$css_file = URL_ADMIN.'app/'.$_GET['model'].'/css/listar.css';
	if (file_exists(PATH_ADMIN.'app/'.$_GET['model'].'/css/listar.css')){
		echo '<link rel="stylesheet" href="'.$css_file.'" type="text/css" />';
	}
} else {
	$css_file = URL_ADMIN.'app/perfil/css/editar.css';
	if (file_exists(PATH_ADMIN.'app/perfil/css/editar.css')){
		echo '<link rel="stylesheet" href="'.$css_file.'" type="text/css" />';
	}
}

unset($css_file);

?>