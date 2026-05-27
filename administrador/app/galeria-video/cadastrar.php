<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Vídeo - Cadastrar</h3>
			</div>

			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[120]]" />
					</div>

					<div class="col-md-3">
						<label>Status:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" value='<?php echo $k ?>' <?php echo $k==1?"checked":""; ?>> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>

					<div class="col-md-3">
						<label>Destaque:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="destaque" value='<?php echo $k ?>' <?php echo $k==0?"checked":""; ?>> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<label>Código do Youtube: https://www.youtube.com/watch?v=<span style="color: red;">C0DPdy98e4c</span></label>
						<input type="text" name="codigo" id="codigo" class="form-style validate[required]" />
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
