<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<ul class="cl-vnavigation"><!-- Main Navigation Begin -->

    <li><a href="<?php echo URL_ADMIN ?>"><i class="fas fa-chart-bar"></i> Inicio (Dashboard)</a></li>
	<?php 
	
	try {

		$objPermissao = new UsuarioPermissao();
		$objPermissao->getMenu(0);
	
	} catch (Exception $e){
		$return_type	= 'error';
		$return_message	= 'Ocorreu um erro de permissão.';
	}
	
	unset($objPermissao);
	
	?>

	<?php if ($_SESSION['sess_usuario_id']==1) { ?>
		<li><a href="<?php echo URL_ADMIN.'modulo-permissao/'; ?>"><i class='fa fa-power-off'></i>Config Admin</a></li>
	<?php } ?>

	<li><a href="<?php echo URL_ADMIN.'logout/'; ?>"><i class='fa fa-power-off'></i>Sair</a></li>
</ul><!-- Main Navigation End -->