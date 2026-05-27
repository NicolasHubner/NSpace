<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
				<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Tags - Cadastrar</h3>
			</div>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-style validate[required]" />
					</div>
                </div>
				
				<div class="row">
					<div class="col-md-12">
						<input type="submit" class="btn btn-primary pull-right" value="Salvar" />
					</div>
				</div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->
