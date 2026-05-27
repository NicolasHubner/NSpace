<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<?php 

try {
	
	// Seleciona o registro
	$obj = Doctrine_Core::getTable('UsuarioGrupo')->find($_GET['id']);
	$res = $obj->nome.' - Permissões'; 	
				
} catch (Exception $e){
	
	$res = 'Ocorreu um erro de sistema!';
	echo '<h1>Ocorreu um erro de sistema!</h1>';
	
}

?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
				<h3><?php echo $res; ?></h3>
			</div>
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('UsuarioGrupo')->find($_GET['id']);
				
				// Verifica se o registro pode ser alterado
				if ($res->id > 2){
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<ul style="list-style: none !important;">
					<?php
					
					$objPermissao = new UsuarioPermissao();
					$objPermissao->getPermission(0, $_GET['id']);
					
					?>
				</ul>
				
				<div class="clear"></div><br />
				
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
				
			</form>
			<?php 
			
				} else {
				
					echo '<h4>Esse registro não pode ser alterado.</h4>';

				}
			
			} catch (Exception $e){

				echo 'Ocorreu um erro!';
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->