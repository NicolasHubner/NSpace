<section>
	<div class="container">
	
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="sec-heading center">
					<h2>Adicionados Recentemente</h2>
					<p>Encontre um novo local</p>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="property-slide">
					<?php 
						$where = "status_id = 2 and pagamento = 1";
						$retAnuncio = Doctrine_Query::create()->select()->from('Anuncio')->where($where)->orderBy('data_cadastro DESC')->limit(10)->execute();
						foreach ($retAnuncio as $objAnuncio) {
							if (isset($_SESSION['reserva']['data_entrada'])&&$_SESSION['reserva']['data_entrada']!='') {
						      	$dataEntrada                            = Util::dateConvert($_SESSION['reserva']['data_entrada']);
						  	} else {
						  		$dataEntrada = date('Y-m-d');
						  	}
							$whereData = 'anuncio_id = '.$objAnuncio->id.' and data_alterada = "'.$dataEntrada.'"';
						  	$objAnuncioDataPersonalizada 		= Doctrine_Query::create()->select()->from('AnuncioDataPersonalizada')->where($whereData)->execute();
						  	if ($objAnuncioDataPersonalizada->count()>0) {
						  		$objAnuncioDataPersonalizada = $objAnuncioDataPersonalizada[0];

						  		$valorAnuncio = $objAnuncioDataPersonalizada->valor;
						  	} else {
						  		$valorAnuncio = $objAnuncio->valor;
						  	}
							?>
								<div class="single-items">
									<div class="property-listing property-2">
										<div class="listing-img-wrapper">
											<div class="list-img-slide">
												<div class="click">
													<?php if (isset($objAnuncio->imagem)&&$objAnuncio->imagem!='') { ?>
														<div>
															<a href="<?php echo URL.'anuncio/'.$objAnuncio->dns.'/'.$objAnuncio->id.'/' ?>">
																<img src="<?php echo URL_ANUNCIO.$objAnuncio->imagem ?>" class="img-fluid mx-auto" alt="" />
															</a>
														</div>
													<?php } else { ?>
														<a class="maxedHei" href="<?php echo URL_IMAGES ?>sem-foto.jpg" data-fancybox="group"><img src="<?php echo URL_IMAGES ?>sem-foto.jpg"></a>
													<?php } ?>
												</div>
											</div>
										</div>
										
										<div class="listing-detail-wrapper pb-0">
											<div class="listing-short-detail">
												<h4 class="listing-name"><a href="<?php echo URL.'anuncio/'.$objAnuncio->dns.'/'.$objAnuncio->id.'/' ?>"><?php echo $objAnuncio->titulo ?></a><i class="list-status ti-check"></i></h4>
											</div>
										</div>
										
										<div class="price-features-wrapper">
											<div class="listing-price-fx">
												<h6 class="listing-card-info-price price-prefix">R$<?php echo number_format($valorAnuncio, 0, ',', '.') ?><span class="price-suffix">/<?php echo $objAnuncio->TipoCobranca->nome ?></span></h6>
											</div>
											<div class="list-fx-features">
												<div class="listing-card-info-icon">
													<?php 
														$dizeres = isset($objAnuncio->limite_pessoas)&&$objAnuncio->limite_pessoas>1?'pessoas':'pessoa';
													?>
													<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
													<?php echo $objAnuncio->limite_pessoas.' '.$dizeres ?></span>
												</div>
												<div class="listing-card-info-icon">
													<?php 
														$dizeres = isset($objAnuncio->banheiro)&&$objAnuncio->banheiro>1?'banheiros':'banheiro';
													?>
													<span class="inc-fleat inc-bath"><?php echo $objAnuncio->banheiro.' '.$dizeres ?></span>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							<?php 
						}
					?>
				</div>
			</div>
		</div>
		
	</div>
</section>