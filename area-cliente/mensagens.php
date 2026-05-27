<?php 
	$objReserva = Doctrine_Core::getTable('Reserva')->find($_GET['reserva_id']);

	if (isset($_POST['reserva_id'])) {
			
		$objMensagem  								= new Mensagem();
		$objMensagem->data_cadastro  				= date('Y-m-d H:i:s');
		$objMensagem->mensagem  					= $_POST['mensagem'];
		$objMensagem->reserva_id  					= $_POST['reserva_id'];
		$objMensagem->anuncio_id  					= $_POST['anuncio_id'];
		$objMensagem->enviada_para  				= $_POST['enviada_para'];
		$objMensagem->enviada_por  					= $_POST['enviada_por'];
		$objMensagem->save();

		include('email_nova_mensagem.php');

        header('Location: '.URL.'painel/mensagens/?reserva_id='.$_GET['reserva_id']);
	}
?>
<div class="dashboard-wraper">

	<div class="lista-mensagens">
		<div class="form-row" id="lista-mensagens">

			<input type="hidden" id="reserva_id" value="<?php echo $objReserva->id ?>">
		</div>
	</div>

	<form style="margin-top: 15px;" method="post">
		<div class="form-row mb-20">
			<div class="col-md-12">
				<label>Mensagem:</label>
				<textarea class="form-control" name="mensagem" id="mensagem" style="padding: 15px;"></textarea>
			</div>
		</div>

		<div class="form-row">
			<div class="col-md-12">
				<input type="hidden" name="reserva_id" value="<?php echo $objReserva->id ?>">
				<input type="hidden" name="anuncio_id" value="<?php echo $objReserva->anuncio_id ?>">
				<input type="hidden" name="enviada_para" value="<?php echo $objReserva->Anuncio->cliente_id ?>">
				<input type="hidden" name="enviada_por" value="<?php echo $_SESSION['sess_cliente_id'] ?>">
				<input type="submit" class="btn btn-primary" value="Enviar mensagem">
			</div>
		</div>
	</form>
</div>