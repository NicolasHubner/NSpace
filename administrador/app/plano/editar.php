<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
				<h3>Plano - Editar</h3>
			</div>
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Plano')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-3">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[60]]" value="<?php echo $res->nome; ?>" />
					</div>

					<div class="col-md-3">
						<label>Valor:</label>
						<input type="text" name="valor" id="valor" class="valores form-style" value="<?php echo $res->valor; ?>"  />
					</div>

					<div class="col-md-3">
						<label>Status:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" <?php echo ($res->status==$k?'checked="checked"':''); ?> value='<?php echo $k ?>'> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>

					<div class="col-md-3">
						<label>Destaque:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="destaque" <?php echo ($res->destaque==$k?'checked="checked"':''); ?> value='<?php echo $k ?>'> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Subtítulo:</label>
						<input type="text" name="subtitulo" id="subtitulo" class="form-style" value="<?php echo $res->subtitulo; ?>"  />
					</div>
				</div>
				
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<div class="row">
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

<script type="text/javascript">
	$(document).ready(function() {
		$('.valores').mask('000.000.000.000.000,00', {reverse: true});
	});
</script>
