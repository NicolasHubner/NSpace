<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Página - Editar</h3>
			</div>
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Pagina')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<div class="row">
					<div class="col-md-12">
						<label>Titulo: <?php echo $res->titulo; ?></label>
					</div>			
				</div>
					
				<div class="row">
					<div class="col-md-12">
						<label>Texto <?php if($_GET['id']==15) echo"(Para inserir o email ou senha basta digitar \"//\" antes da palavra. Ex.: //email irá aparecer o email.)"; ?>:</label>

						<textarea name="descricao" id="descricao" rows="" cols="" class="ckeditor" style="width: 695px; height: 120px;"><?php echo stripslashes($res->descricao); ?></textarea>
					</div>
				</div>
					
				<div class="row">
					<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
					<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
				</div>
				
			</form>
			<?php 
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!';
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->