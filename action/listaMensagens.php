<?php
	include("../lib/Config.php");

	$retMensagem 		= Doctrine_Query::create()->select()->from('Mensagem')->where('reserva_id = '.$_POST['reserva_id'])->orderBy('data_cadastro ASC')->execute();
	foreach ($retMensagem as $objMensagem) {
		$objEnviadaPor = Doctrine_Core::getTable('Cliente')->find($objMensagem->enviada_por);
		?>
			<div class="col-md-12">
				<div class="mensagem-unica mb-20">
					<strong><?php echo $objEnviadaPor->nome ?></strong><br>
					<?php echo $objMensagem->mensagem ?>
				</div>
			</div>
		<?php 
	}
?>