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
				<h3>Arquivo - Cadastrar</h3>

			</div>

			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" enctype="multipart/form-data">

				<div class="row">

					<div class="col-md-12">

						<label>Nome:</label>

						<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[60]]"/>

					</div>

				</div>

			

				

				<div class="row">

					<div class="col-md-12">

						<label>Arquivo:</label>

						<input type="file" name="arquivo" id="arquivo" class="validate[required]" />

					</div>

				</div>

				

				<div class="row">

					<div class="col-md-12"><input type="submit" class="btn btn-primary" value="Salvar" /></div>

				</div>

			</form>

		</div>

	</div><!-- Block End -->

</div><!-- Body Wrapper End -->