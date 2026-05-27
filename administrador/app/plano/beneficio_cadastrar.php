<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
		<?php 
		
		try {
			
			// Seleciona o registro
			$obj = Doctrine_Core::getTable('Plano')->find($_GET['id']);
			$res = $obj->nome.' - Plano - Cadastrar';
		
		?>
          	<div class="header">	
				<h3><?php echo $res; ?></h3>
			</div>
				<?php 
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Plano')->find($_GET['id']);
				
				// Verifica se o usuário possui permissão para alterar o registro
				if($_SESSION['sess_usuario_grupo_id'] != 2 || ($_SESSION['sess_usuario_grupo_id'] == 2 && $res->usuario_id == $_SESSION['sess_usuario_id'])){
					
				?>
				<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-12">
							<label>Nome:</label>
							<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[100]]" />
						</div>
					</div>

					<input type="hidden" name="plano_id" value="<?php echo $_GET['id']; ?>" />
					
					<div class="row">
						<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
					</div>
				</form>
				<?php 
				
				} else {
					
					echo '<h4>Você não tem permissão para inserir esse registro.</h4>';
	
				}
				
				?>
			</div>
		<?php
		
			} catch (Exception $e){
			
			$res = 	'Ocorreu um erro de sistema!';
			echo 	'<h1>Ocorreu um erro de sistema!</h1>'.$e;
			
		}
		?>
	</div><!-- Block End -->
</div>