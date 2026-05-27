<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader = 'light';
?>
	
	<section class="page-section">
		<div class="container">
			<div class="retornoNotif success text-center mt-20" style="display: block;">
              	<i class="fas fa-check"></i>
              	<h4>Assinatura realizada com sucesso!</h4>
              	<p>Agora é só aguardar a nossa equipe validar os dados do seu espaço, em breve daremos um retorno com a liberação do espaço na plataforma.</p>             
              	<a class="btn btn-success" href="<?php echo URL.'painel/' ?>minhas-propriedades/">Ir para minhas propriedades</a>
            </div>
		</div>
	</section>

<?php
	$obContent = ob_get_contents();
	ob_end_clean();
	include('base.php');
?>