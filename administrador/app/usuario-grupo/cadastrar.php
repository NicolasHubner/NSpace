<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
				<h3>Grupo de Usuário - Cadastrar</h3>
			</div>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
				<div class="row">
					<div class="col-md-8">
						<label>Grupo:</label>
						<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[45]]" />
					</div>
				
				
					<div class="col-md-4 control-label">
						<label>Status:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" value='<?php echo $k ?>' <?php echo $k==1?"checked":""; ?>> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>
				</div>

				
				<div class="row">
					<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
				</div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->