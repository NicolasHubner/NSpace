<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<?php 
		
	try {

		// Seleciona os dados do usuário		
		$resUsuario = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);

		// Define avatar
		$avatar = 	URL_ADMIN.'images/user.png';

	} catch (Exception $e){
		exit('Ocorreu um erro!');
	}
		
?>
<div class="side-user">
	<div class="avatar"><img src="<?php echo $avatar; ?>" alt="<?php echo $resUsuario->nome; ?>" height=50px /></div>
	<div class="info">
	  <p><?php echo $resUsuario->nome_exibicao; ?></p>
	  <a href="<?php echo URL_ADMIN ?>perfil/">(Editar)</a>
	  <!-- <div class="progress progress-user">
	    <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
	      <span class="sr-only">50% Complete (success)</span>
	    </div>
	  </div> -->
	</div>
</div>
<?php 

unset($avatar);

?>