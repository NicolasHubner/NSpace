<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
	      	<div class="header">	
				<h3>Galeria - Foto - Editar</h3>
			</div>
			<?php 

			try {

				// Seleciona os dados
				$res = Doctrine_Core::getTable('GaleriaFoto')->find($_GET['id']);
				
				// Verifica se o usuário possui permissão para alterar o registro
				if ($_SESSION['sess_usuario_grupo_id'] != 2 || ($_SESSION['sess_usuario_grupo_id'] == 2 && $res->Local->usuario_id == $_SESSION['sess_usuario_id'])){
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-8">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-control validate[required,maxSize[100]]" value="<?php echo $res->nome; ?>" />
					</div>
					
					<div class="col-md-4">
						<label>Ordem:</label>
						<input type="text" name="ordem" id="ordem" class="form-control validate[required,maxSize[1]]" value="<?php echo $res->ordem; ?>" />
					</div>
					
					
				</div>

				<div class="row">

					<div class="col-md-12" style="float: left;">
						<label>Imagem:</label>
						<input type="file" name="imagem_principal" id="imagem_principal" class="" />
						<br />Arquivos permitidos (JPG, PNG, GIF)
						<?php if ($res->imagem!= ''){ ?>
						<br /><br />
						<img src="<?php echo URL_GALERIA.$res->imagem; ?>" style="max-width: 340px; max-height: 215px;" />
						<?php } ?>
					</div>

					
			
				</div>

				<div class="row">
					
					<input type="hidden" name="galeria_id" value="<?php echo $res->galeria_id; ?>" />
					<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
					<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
				</div>
					
			</form>
			<?php 
			
				} else {

					echo '<h4>Você não tem permissão para editar esse registro.</h4>';

				}
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!'.$e;
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->