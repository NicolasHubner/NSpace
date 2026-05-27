<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Usuário do Sistema - Cadastrar</h3>
			</div>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
				
				
				
				<div class="row">
					<div class="col-md-8">
						<label>Nome:</label>
						<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[60]]" />
					</div>
					
					<div class="col-md-4 control-label">
						<label>Status:</label><br>
						<?php foreach ($_STATUS as $k=>$v){ ?>
	                  		<label class="radio-inline"> <input class="icheck" type="radio" class="validate[required]" name="status" value="<?php echo $k ?>" <?php echo $k==1?'checked':'' ?>> <?php echo $v; ?></label> 
						<?php } ?> 
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<label>Grupo:</label>
						<select name="usuario_grupo_id" id="usuario_grupo_id" class="form-style validate[required]">
							<option value=""></option>
							<?php 
							
							try {
							
								$resGrupo = Doctrine_Query::create()->select()->from('UsuarioGrupo')->orderBy('nome ASC')->execute();
								
								if ($resGrupo->count() > 0){
									$resGrupo->toArray();
									
									foreach ($resGrupo as $value){
										echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
									}
									
								} else {
									echo '<option value="">Ocorreu um erro de sistema</option>';
								}
							
							} catch (Exception $e){
								echo '<option value="">Ocorreu um erro de sistema</option>';
							}
							
							
							?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label>E-mail:</label>
						<input type="text" name="email" id="email" class="form-style validate[required,custom[email],maxSize[100]]" />
					</div>
					
					
					<div class="col-md-6">
						<label>Senha:</label>
						<input type="password" name="senha" id="senha" class="form-style validate[required,minSize[4]]" />
					</div>
				</div>
				
				
				<div class="clear"></div><br />
				
				<div class="form_row"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->