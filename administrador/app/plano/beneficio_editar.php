<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
		<?php 

		try {

            $obj = Doctrine_Core::getTable('Beneficio')->find($_GET['id']);
            $res = $obj->nome.' - Benefício - Editar';
	
		} catch (Exception $e){
			
			$res = 	'Ocorreu um erro de sistema!';
			echo 	'<h1>Ocorreu um erro de sistema!</h1>';

		}

		?>
          	<div class="header">	
				<h3><?php echo $res; ?></h3>
			</div>
			<?php 

			try {

				// Seleciona os dados
				$res = Doctrine_Core::getTable('Beneficio')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'.$_GET['id']; ?>" method="post" id="formPerfil" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[100]]" value="<?php echo $res->nome; ?>" />
					</div>
				</div>

				<div class="clear"></div><br />
				
				<input type="hidden" name="plano_id" value="<?php echo $res->Plano->id; ?>" />
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
</div>