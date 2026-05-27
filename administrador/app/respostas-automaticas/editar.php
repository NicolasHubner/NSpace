<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="row no-margin-top ">
		<div class="col-md-12">
			<div class="block-flat">
				<div class="header">	
					<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
					<h3>Respostas automáticas - Editar</h3>
				</div>
				<?php 
				try {
					$res = Doctrine_Core::getTable('RespostaAutomatica')->find($_GET['id']);

					?>
					<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-12">
								<label>Texto:</label>
								<input type="text" name="texto" id="texto" class="form-style validate[required]" value="<?php echo $res->texto; ?>" />
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