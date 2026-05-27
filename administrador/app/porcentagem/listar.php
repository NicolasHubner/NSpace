<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
			<form class="formAdmin" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil"  enctype="multipart/form-data">
                <div class="header">    
                    <h3>Porcentagens:</h3>
                </div>

                <?php
                    $res    = Doctrine_Core::getTable('Configuracao')->find(1);
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <label>NSPACE:</label>
                        <input type="text" class="form-style" name="cent_nspace" id="cent_nspace" value='<?php echo $res->cent_nspace ?>'>
                    </div>

                    <div class="col-md-3 display-unidade">
                        <label>Cliente:</label>
                        <input type="text" class="form-style" name="cent_cliente" id="cent_cliente" value='<?php echo $res->cent_cliente ?>'>
                    </div>

                    <div class="col-md-3 display-unidade">
                        <label>Afiliados:</label>
                        <input type="text" class="form-style" name="cent_afiliado" id="cent_afiliado" value='<?php echo $res->cent_afiliado ?>'>
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
