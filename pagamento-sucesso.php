<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader = 'light';
?>
	
	<section class="page-section">
		<div class="container">
			<div class="retornoNotif success text-center mt-20" style="display: block;">
              	<i class="fal fa-clock"></i>
              	<h4>Seu pagamento está em análise!</h4>
              	<p>Assim que confirmado o pagamento você receberá um email com o código da reserva, no dia da entrada favor informar para o proprietário o código.</p>             
              	<a class="btn btn-success" href="<?php echo URL.'painel/' ?>minhas-reservas/">Ir para minhas reservas</a>
            </div>
		</div>
	</section>

<?php
	$obContent = ob_get_contents();
	ob_end_clean();
	include('base.php');
?>