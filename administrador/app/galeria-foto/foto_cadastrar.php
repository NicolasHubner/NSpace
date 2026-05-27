<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
		<?php 
		
		try {
			
			// Seleciona o registro
			$obj = Doctrine_Core::getTable('Galeria')->find($_GET['id']);
			$res = $obj->nome.' - Foto - Cadastrar';
		
		?>
			<style type="text/css">
				form div.upload { overflow:hidden; }
				form div.upload div.file-preview {
				    background:#ccc;
				    border:1px solid #000;
				    display:inline-block;
				    float:left;
				    margin-right:1em;
				    min-width:490px;
				    min-height:155px;
				    display: none;
				    height:auto;
				    text-align:center;
				}
			</style>
          	<div class="header">	
				<h3><?php echo $res; ?></h3>
			</div>
				<div>
					<?php 
					
					// Seleciona os dados do usuário
					$res = Doctrine_Core::getTable('Galeria')->find($_GET['id']);
					$_SESSION['sess_galeria_id'] = $res->id;
					
					// Verifica se o usuário possui permissão para alterar o registro
					if($_SESSION['sess_usuario_grupo_id'] != 2 || ($_SESSION['sess_usuario_grupo_id'] == 2 && $res->usuario_id == $_SESSION['sess_usuario_id'])){
						
					?>
					<form action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" class="dropzone" id="my-awesome-dropzone">
						<input class="dropzone" type="hidden" name="ambiente_id" id='ambiente_id' value="<?php echo $_GET['id']; ?>" />
					</form>
					<!-- <form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-12">
								<label>Nome:</label>
								<input type="text" name="nome" id="nome" class="form-control validate[required,maxSize[100]]" />
							</div>
							<div class="col-md-4">
								<label>Ordem:</label>
								<input type="text" name="ordem" id="ordem" class="form-control validate[maxSize[1]]" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label>Imagem:</label>
								<input type="file" name="imagem_principal[]" id="imagem_principal" class="validate[required]" multiple />
								<br />Arquivos permitidos (JPG, PNG, GIF)
							</div>

						</div>

						<div class="row">
							<input type="hidden" name="galeria_id" id='galeria_id' value="<?php echo $_GET['id']; ?>" />
							<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>
					</form> -->
					<?php 
					
					} else {
						
						echo '<h4>Você não tem permissão para inserir esse registro.</h4>';
		
					}
					
					?>
				</div>	
			</div>

      		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
			
		<?php
		
			} catch (Exception $e){
			
			$res = 	'Ocorreu um erro de sistema!';
			echo 	'<h1>Ocorreu um erro de sistema!</h1>';
			
		}
		?>
	</div><!-- Block End
</div><!-- Body Wrapper End -->

