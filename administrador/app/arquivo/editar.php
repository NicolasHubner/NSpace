<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<div id="body">

	<style type="text/css">

		#exemplo{

			width: 124px;

			padding: 5px 8px;

			font-size: 14px;

			height: 40px;

			line-height: 15px;

		}

		#p{

			color: #666;

			font-size: 12px;

			text-align: justify;

		}

	</style>

	<script type="text/javascript">

		$(document).ready(function(){

			$('#nome').keyup(function(){

				$('#exemplo p').html($(this).val());

			});

		});

	</script>

	<div class="row no-margin-top ">

	<div class="col-md-12">

        <div class="block-flat">

          	<div class="header">	

          		<a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Arquivo - Editar</h3>

			</div>

			<?php 



			try {

				

				// Seleciona os dados

				$res = Doctrine_Core::getTable('Arquivo')->find($_GET['id']);

				

			?>

			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" enctype="multipart/form-data">

				<div class="row">

					<div class="col-md-12">

						<label>Nome:</label>

						<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[60]]" value="<?php echo $res->nome; ?>" />

					</div>

				</div>

			

				<div class="row">

					<div class="col-md-12">

						<label>Arquivo:</label>

						<input type="file" name="arquivo" id="arquivo" class="input validate[required]" style="width: 380px;" />

						<br />Selecione o arquivo somente se pretenda substituir.

					</div>

				</div>

				

				<div class="row">

					<input type="hidden" name="id" value="<?php echo $res->id; ?>" />

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