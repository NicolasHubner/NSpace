<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">
          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>	
				<h3>Cancelamento - Editar</h3>
			</div>
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Cancelamento')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-3">
                        <label>Status:</label><br>
                        <label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" value='1' <?php echo isset($res->status)&&$res->status==1?'checked':'' ?>> Aguardando</label> 
                        <label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" value='2' <?php echo isset($res->status)&&$res->status==2?'checked':'' ?>> Cancelado</label> 
                    </div>
				</div>
					
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<div class="row">
					<div class="col-md-12"><input type="submit" class="btn btn-primary pull-right" value="Salvar" /></div>
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
