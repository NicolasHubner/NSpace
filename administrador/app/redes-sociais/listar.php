<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
			<?php
				$res	= Doctrine_Core::getTable('RedeSocial')->find(1);
			?>

			<form class="formAdmin" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil"  enctype="multipart/form-data">
               	<div class="header">    
                    <h3>Redes Sociais:</h3>
                </div>

               	<div class="row">
					<div class="col-md-12">
						<label>Facebook:</label>
						<input type="text" class="form-style" name="facebook" id="facebook" value="<?php echo $res->facebook ?>">
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Instagram:</label>
						<input type="text" class="form-style" name="instagram" id="instagram" value="<?php echo $res->instagram ?>">
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Youtube:</label>
						<input type="text" class="form-style" name="youtube" id="youtube" value="<?php echo $res->youtube ?>">
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Linkedin:</label>
						<input type="text" class="form-style" name="linkedin" id="linkedin" value="<?php echo $res->linkedin ?>">
					</div>
				</div>

			<!-- 	<div class="row">
					<div class="col-md-12">
						<label>Tik Tok:</label>
						<input type="text" class="form-style" name="tiktok" id="tiktok" value="<?php echo $res->tiktok ?>">
					</div>
				</div> -->

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

