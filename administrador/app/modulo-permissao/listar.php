<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
			<form class="formAdmin" action="<?php echo URL_ADMIN.'app/modulo-permissao/listar_action.php' ?>" method="post" id="formPerfil"  enctype="multipart/form-data">
               	<div class="header">    
                    <h3>Liberar Permissões:</h3>
                </div>

               	<div class="row">
               		<div class="col-md-12">
               			<?php
               				$resModuloPermissao = Doctrine_Query::create()->select()->from('ModuloPermissao')->execute();
			                                 
		                    $usuario_permissao_id = array();
		                    foreach ($resModuloPermissao as $key => $objModuloPermissao) {
		                        $usuario_permissao_id[] = $objModuloPermissao->usuario_permissao_id;
		                    }

               				$retUsuarioPermissao = Doctrine_Query::create()->select()->from('UsuarioPermissao')->where('tipo = 0')->execute();
               				foreach ($retUsuarioPermissao as $objUsuarioPermissao) {
                                $selected = in_array($objUsuarioPermissao->id, $usuario_permissao_id)?"checked":"";

               					if ($objUsuarioPermissao->parent == 0) {
		               				$retUsuarioPermissaoParent = Doctrine_Query::create()->select()->from('UsuarioPermissao')->where('tipo = 0 and parent = '.$objUsuarioPermissao->id)->execute();
			               			?>
					               			<div class="radio" style="padding-left: 0px;"> 
							                    <label> 
							                    	<div class="icheckbox_flat-green checked" aria-checked="false" aria-disabled="false">
								                    	<input class="icheck" type="checkbox"  name="usuario_permissao_id[]" <?php echo $selected ?> value="<?php echo $objUsuarioPermissao->id ?>">
								                    	<ins class="iCheck-helper"></ins>
								                    </div> 
									                <span class="positionCheck"><?php echo $objUsuarioPermissao->titulo ?></span>
									            </label> 
							                </div>
				               			

				               			<?php
               								foreach ($retUsuarioPermissaoParent as $objUsuarioPermissaoParent) {
               									$selected = in_array($objUsuarioPermissaoParent->id, $usuario_permissao_id)?"checked":"";
				               					?>
						               				<div class="radio sub2"> 
									                    <label> 
									                    	<div class="icheckbox_flat-green checked" aria-checked="false" aria-disabled="false">
										                    	<input class="icheck" type="checkbox"  name="usuario_permissao_id[]" <?php echo $selected ?> value="<?php echo $objUsuarioPermissaoParent->id ?>">
										                    	<ins class="iCheck-helper"></ins>
										                    </div> 
											                <span class="positionCheck"><?php echo $objUsuarioPermissaoParent->titulo ?></span>
											            </label> 
									                </div>
					               				<?php
					               			}
				               			?>
						            <?php
               					}
					        }
					    ?>
               		</div>
               	</div>

				<div class="row">
					<div class="col-md-12">
						<input type="submit" class="button button-primary" value="Salvar">
					</div>
				</div>
			</form>
		</div>
	</div><!-- Block End -->
</div>

