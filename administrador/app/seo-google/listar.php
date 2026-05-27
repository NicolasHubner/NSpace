<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
			<?php
				$res	= Doctrine_Core::getTable('Configuracao')->find(1);
			?>

			<form class="formAdmin" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil"  enctype="multipart/form-data">
               	<div class="header">    
                    <h3>SEO (Google):</h3>
                </div>

               	<div class="row">
					<div class="col-md-3">
						<label>Nome do site:</label>
						<input type="text" class="form-style" name="nome" id="nome" value="<?php echo $res->nome ?>">
					</div>

					<div class="col-md-9">
						<label>Descrição para o Google:</label>
						<input type="text" class="form-style" name="google_descricao" id="google_descricao" value="<?php echo $res->google_descricao ?>">
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Palavras chaves separadas por ', ':</label>
						<input type="text" class="form-style" name="google_keywords" id="google_keywords" value="<?php echo $res->google_keywords ?>">
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Código de Acompanhamento (Analytics): <small>Para criar sua conta <a target='_blank' href="https://support.google.com/analytics/answer/1008015?hl=pt-BR&ref_topic=3544906&vid=1-635791347920816776-4197025384">Clique aqui</a></small></label>
						<textarea name="google_analytics" id="google_analytics" class="form-style" ><?php echo $res->google_analytics; ?></textarea>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
                        <input type="hidden" name="id" value="<?php echo $res->id ?>">
						<input type="submit" class="button button-primary" value="Salvar">
					</div>
				</div>
			</form>
		</div>
	</div><!-- Block End -->
</div>

