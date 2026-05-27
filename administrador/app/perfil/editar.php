<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<div class="row no-margin-top no-padding">

	<div class="col-sm-6">

        <div class="block-flat">

          	<div class="header">	

				<h3>Meu cadastro</h3>

			</div>



			<?php 



			try {

				

				// Seleciona os dados do usuário

				$res = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);

				

			?>

			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/cadastro/'; ?>" method="POST" id="formPerfil">

				<div class="form-group">

					<label>Nome:</label>

					<input type="text" name="nome" id="nome" class="form-style validate[required,maxSize[100]]" style="" value="<?php echo $res->nome; ?>" />

				</div>

				<div class="form-group">

					<label>Email:</label>

					<input type="text" name="email" id="email" class="form-style validate[required,custom[email],maxSize[100]]" style="" value="<?php echo $res->email; ?>" />

				</div>

				<div class="form-group">

					<label>Nome de Exibição:</label>

					<input type="text" name="nome_exibicao" id="nome_exibicao" class="form-style validate[required,maxSize[249]]" style="" value="<?php echo $res->nome_exibicao; ?>" />

				</div>

				<!-- <div class="form-group">

					<label>Data de Nascimento:</label>

					<input type="text" name="nascimento" id="nascimento" class="form-style validate[custom[dateBR]]" style="" value="<?php echo $res->nascimento!=''?date('d/m/Y',strtotime($res->nascimento)):''; ?>" />

				</div> -->

				<!-- <div class="form-group">

					<label>Sexo:</label>

					<select name="sexo" id="sexo" class="select" style="">

						<option value="">Selecione</option>

						<option value="1" <?php echo $res->sexo=='1'?' selected="selected"':''; ?>>Masculino</option>

						<option value="0" <?php echo $res->sexo=='0'?' selected="selected"':''; ?>>Feminino</option>

					</select>

				</div> -->

				

				<div class="clear"></div><br />

				<div class="clear"></div><br />

				

				<div class="form-group"><input type="submit" class="btn btn-primary" value="Salvar" /></div>

			</form>

			<?php 

			

			} catch (Exception $e){

				echo 'Ocorreu um erro!';

			}

			

			unset($res);

			

			?>

		</div>

	</div>

	<div class="col-sm-6">

        <div class="block-flat">

          	<div class="header">	

				<h3>Minha senha</h3>

			</div>

			<?php 



			try {

				

				// Seleciona os dados do usuário

				$res = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);

				

			?>

			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/senha/'; ?>" method="POST" id="formSenha">

				<div class="form-group">

					<label>Senha atual:</label>

					<input type="password" name="senha_atual" id="senha_atual" class="form-style validate[required]" style="" />

				</div>

				<div class="form-group">

					<label>Nova senha:</label>

					<input type="password" name="senha_nova" id="senha_nova" class="form-style validate[required]" style="" />

				</div>

				<div class="form-group">

					<label>Confirmação da nova senha:</label>

					<input type="password" name="senha_confirmacao" id="senha_confirmacao" class="form-style validate[required,equals[senha_nova]]" style="" />

				</div>

				

				<p><b>Dicas para criar uma senha segura:</b><br />

				1. Misture letras, símbolos especiais e números.<br />

				2. Use letras maiúsculas e minúsculas.<br />

				3. Use uma quantidade superior a 8 caracteres.</p>

				

				<div class="form-group"><input type="submit" class="btn btn-primary" value="Salvar" /></div>

			</form>

			<?php 

			

			} catch (Exception $e){

				echo 'Ocorreu um erro!';

			}

			

			unset($res);

			

			?>

		</div>

	</div>

</div>



