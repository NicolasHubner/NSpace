<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
				<h3>Grupo de Usuário - editar</h3>
			</div>
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('UsuarioGrupo')->find($_GET['id']);
				
				// Verifica se o grupo pode ser alterado
				if ($res->id > 2){
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<div class="row">
					<div class="col-md-8">
						<label>Grupo:</label>
						<input type="text"  name="nome" id="nome" class="form-style validate[required,maxSize[60]]" value="<?php echo $res->nome; ?>" />
					</div>
				
					<div class="col-md-4 control-label">
						<label>Status:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" <?php echo ($res->status==$k?'checked="checked"':''); ?> value='<?php echo $k ?>'> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>
				</div>
				
				
				<div class="row">
					<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
					<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
				</div>
				
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