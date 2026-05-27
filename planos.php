<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader = 'light';
?>

	<div class="page-title">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<h2 class="ipt-title">Planos</h2>
					<span class="ipn-subtitle">Planos disponíveis</span>
				</div>
			</div>
		</div>
	</div>

	<section class="modelPlanos">
		<div class="container">
			<div class="lista-de-planos">
				<div class="text-center">
					<h3>Para finalizar o cadastro de sua propriedade escolha um plano:</h3>
				</div>

				<div class="row">
					<?php 
						$retPlano = Doctrine_Query::create()->select()->from('Plano')->where('status = 1')->orderBy('ordem ASC')->execute();
						foreach ($retPlano as $objPlano) {
							?>
								<div class="col-lg-4 col-md-4">
									<div class="pricing-wrap <?php echo isset($objPlano->recomendavel)&&$objPlano->recomendavel==1?'recomendavel':'' ?>">
										<?php echo isset($objPlano->recomendavel)&&$objPlano->recomendavel==1?'<div class="planoRecomendavel">Plano mais Utilizado</div>':'' ?>
										<div class="pricing-header">
											<h4 class="pr-title"><?php echo $objPlano->nome ?></h4>
											<?php 
												if ($objPlano->id==1) {
													echo '<span class="pr-subtitle">Impulsionamento básico</span>';
												} else if ($objPlano->id==2) {
													echo '<span class="pr-subtitle">Impulsionamento avião</span>';
												} else if ($objPlano->id==3) {
													echo '<span class="pr-subtitle">Impulsionamento foguete</span>';
												}
											?>
										</div>

										<?php if (isset($objPlano->valor)&&$objPlano->valor!='') { 

											$valorFormatado = number_format($objPlano->valor,2, ',', '.');

											$valorPlano = explode(',', $valorFormatado);
											$valorInteiro = $valorPlano[0];
											$valorCentavos = $valorPlano[1];
											?>
											<div class="pricing-value">
												<h4 class="pr-value"><?php echo $valorInteiro ?> <span class="centavos">,<?php echo $valorCentavos ?></span> <span style="font-size: 21px;">/mês</span></h4>
											</div>
										<?php } ?>

										<div class="pricing-body">
											<ul>
												<?php 
	                        $retBeneficio = Doctrine_Query::create()->select()->from('Beneficio')->where('plano_id = '.$objPlano->id)->orderBy('ordem ASC')->execute();
	                        if ($retBeneficio->count()>0) {
	                          foreach ($retBeneficio as $objBeneficio) {
	                            ?>
	                              <li><i class="fal fa-check"></i> <?php echo $objBeneficio->nome ?></li>
	                            <?php 
	                          }
	                        }
	                    	?>
											</ul>
										</div>

										<div class="pricing-bottom">
											<a href="#" class="btn-planos selectPlano" plano-id="<?php echo $objPlano->id ?>">Selecionar</a>
										</div>
									</div>
								</div>
							<?php 
						}
					?>				

					

					<input type="hidden" class="plano_id" name="plano_id">
					<input type="hidden" class="anuncio_id" name="anuncio_id" value="<?php echo $_GET['anuncio_id'] ?>">
				</div>
			</div>

			<div class="loadingadmins text-center">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="25 25 50 50">
            <circle cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke="#fd5000" stroke-linecap="round"
              stroke-dashoffset="0" stroke-dasharray="100, 200">
              <animateTransform attributeName="transform" attributeType="XML" type="rotate" from="0 50 50" to="360 50 50"
                dur="2.5s" repeatCount="indefinite" />
              <animate attributeName="stroke-dashoffset" values="0;-30;-124" dur="1.25s" repeatCount="indefinite" />
              <animate attributeName="stroke-dasharray" values="0,200;110,200;110,200" dur="1.25s"
                repeatCount="indefinite" />
            </circle>
          </svg>
          <h4>Contratando seu plano</h4>
        </div>

        <div class="retornoNotif success text-center mt-20">
          <i class="fas fa-check"></i>
          <h4>Sua propriedade foi enviada com sucesso</h4>
          <p>Estamos analisando os dados da sua propriedade. Após a aprovação será publicada!</p>             
          <a class="btn btn-success" href="<?php echo URL.'painel/' ?>minhas-propriedades/">Ir para minha propriedades</a>
        </div>
		</div>
	</section>

<?php
  	$obContent = ob_get_contents();
  	ob_end_clean();
  	include('base.php');
?>

<script type="text/javascript">
	$('.selectPlano').click(function(e) {
		e.preventDefault();
		$('.selectPlano').html('Selecione');
		$('.selectPlano').removeClass('btn-selecionado');
		$('.selectPlano').addClass('btn-planos');


		let PlanoId = $(this).attr('plano-id');
		$('.plano_id').val(PlanoId);

		$(this).html('Selecionado');

		$(this).removeClass('btn-planos');
		$(this).addClass('btn-selecionado');

    	$('.modelPlanos .lista-de-planos').css('display','none');
    	$('.modelPlanos .loadingadmins').css('display','block');


		$.ajax({
        url: URL_SITE + 'action/addPropriedadePlano.php',
        type: 'POST',
        dataType: 'json',
        data: {anuncio_id: $('.modelPlanos .anuncio_id').val(), plano_id: PlanoId},
        success: function(response) {
          if (response.status == 1 && response.plano_id != 1 && response.anuncio_id !='') {
          	setTimeout(() => {
         			window.location.href = URL_SITE+'pagamento/anuncio/'+response.anuncio_id;
            }, 2500);
          } else {
          	setTimeout(() => {
    					$('.modelPlanos .loadingadmins').css('display','none');
    					$('.modelPlanos .retornoNotif').css('display','block');
            }, 2500);
          }
        }
    });
		
	});
</script>