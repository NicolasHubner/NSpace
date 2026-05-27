<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader 					= 'light';

  	$objAnuncio 					= Doctrine_Core::getTable('Anuncio')->findOneByIdAndDns($_GET['id'], $_GET['dns']);
  	$objAnuncio->visualizacao++;
  	$objAnuncio->save();

  	$title = $objAnuncio->titulo;
    $description = $objAnuncio->descricao;
    $imagem = URL_ANUNCIO.$objAnuncio->imagem;

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

	<section class="gray model-anuncio">
		<div class="container">
			<div class="breadcumb mb-20">
				<ul class="menuAcompanhador">
					<li><a href="<?php echo URL ?>"><i class="fal fa-chevron-double-right"></i> Início</a></li>
					<li><a href="<?php echo URL.'anuncios/' ?>"><i class="fal fa-chevron-double-right"></i> Anúncios</a></li>
					<li><a href="<?php echo URL.'anuncios/?cidade_id='.$objAnuncio->cidade_id.'&estado_id='.$objAnuncio->estado_id ?>"><i class="fal fa-chevron-double-right"></i> <?php echo $objAnuncio->Cidade->nome.'/'.$objAnuncio->Estado->sigla ?></a></li>
					<li><a class="active" href="javascript:void(0);"><i class="fal fa-chevron-double-right"></i> <?php echo $objAnuncio->titulo ?></a></li>
				</ul>
			</div>

			<div class="blocoAnuncio reserva">
				<div class="row">
					<div class="col-lg-8 col-md-12 col-sm-12">
						<div class="slide-property-first mb-4">
							<div class="pr-price-into">
								<?php 
	                                $where = "anuncio_id = ".$objAnuncio->id;
	                                $retReservaAvaliacao = Doctrine_Query::create()->select('avg(avaliacao) as media, count(anuncio_id) as total')->from('ReservaAvaliacao ra')->where($where)->execute();
	                            ?>
								<div class="mediaAvaliacao">
									<span class="notas">(<?php echo number_format($retReservaAvaliacao[0]->media, 1, ',', '') ?> - <?php echo $retReservaAvaliacao[0]->total ?> avaliações)</span>
									<div class="ratings">
										<?php
	                                        for ($i=0; $i < 5; $i++) { 
	                                            if($i > $retReservaAvaliacao[0]->media){
	                                                ?><i class="fa fa-star" style="color: #d9d9d9;"></i><?php
	                                            }else if(($i+1) < $retReservaAvaliacao[0]->media){
	                                                ?><i class="fa fa-star" style="color: #fdd214;"></i><?php
	                                            }else if(($i+0.5) <= $retReservaAvaliacao[0]->media){
	                                                ?><i class="fa fa-star-half-o" style="color: #fdd214;"></i><?php
	                                            }else{
	                                                ?><i class="fa fa-star" style="color: #d9d9d9;"></i><?php
	                                            }
	                                        }
	                                    ?>  
									</div>
								</div>
								<?php 
									if (isset($_SESSION['sess_cliente_id'])&&$_SESSION['sess_cliente_id']!='') {
										$objAnuncioFavorito = Doctrine_Core::getTable('AnuncioFavorito')->findOneByAnuncioIdAndClienteId($objAnuncio->id, $_SESSION['sess_cliente_id']);
										if (isset($objAnuncioFavorito->id)) {
											?>
												<div class="listing-like-top">
													<a href="javascript:void(0);" class="addFavorito" id="addFavorito" propriedade_id="<?php echo $objAnuncio->id ?>" title="Remover dos favoritos">
														<i class="fas fa-heart"></i>
													</a>
												</div>
											<?php
										} else {
											?>
												<div class="listing-like-top">
													<a href="javascript:void(0);" class="addFavorito" id="addFavorito" propriedade_id="<?php echo $objAnuncio->id ?>" title="Adicionar aos favoritos">
														<i class="ti-heart"></i>
													</a>
												</div>
											<?php
										}
									}
								?>
								<h2 style="color: #fd5000;"><?php echo 'R$'.number_format($valorAnuncio, 0, ',', '.') ?><span style="color: #72809d;font-size: 16px;">/<?php echo $objAnuncio->TipoCobranca->nome ?></span></h2>
								<h3><?php echo $objAnuncio->titulo ?></h3>
								<?php
	                                if (isset($objAnuncio->estado_id) && $objAnuncio->estado_id != '') {
	                                $enderecoComp = isset($objAnuncio->logradouro) && $objAnuncio->logradouro != ''?$objAnuncio->logradouro : '';
	                                $enderecoComp .= isset($objAnuncio->bairro) && $objAnuncio->bairro != '' ? ' - ' . $objAnuncio->bairro.' - ' : '';
	                                $enderecoComp .= isset($objAnuncio->cidade_id) && $objAnuncio->cidade_id != '' ? $objAnuncio->Cidade->nome : '';
	                                $enderecoComp .= isset($objAnuncio->estado_id) && $objAnuncio->estado_id != '' ? '/' . $objAnuncio->Estado->sigla : '';
	                                ?>
										<span><i class="lni-map-marker"></i> <?php echo $enderecoComp ?></span>
									<?php
	                                }
	                            ?>
							</div>

						</div>
							
						<div class="property3-slide single-advance-property mb-4">
							<div class="slider-for">
								<?php if (isset($objAnuncio->imagem)&&$objAnuncio->imagem!='') { ?>
									<a class="maxedHei" href="<?php echo URL_ANUNCIO.$objAnuncio->imagem ?>" data-fancybox="group"><img src="<?php echo URL_ANUNCIO.$objAnuncio->imagem ?>"></a>
								<?php } else { ?>
									<a class="maxedHei" href="<?php echo URL_IMAGES ?>sem-foto.jpg" data-fancybox="group"><img src="<?php echo URL_IMAGES ?>sem-foto.jpg"></a>
								<?php } ?>

								<?php 
									$retAnuncioFoto  = Doctrine_Query::create()->select()->from('AnuncioFoto')->where('anuncio_id = '.$objAnuncio->id)->execute();
									foreach ($retAnuncioFoto as $objAnuncioFoto) {
										?>
											<a class="maxedHei" href="<?php echo URL_ANUNCIO.$objAnuncioFoto->imagem ?>" data-fancybox="group">
												<img src="<?php echo URL_ANUNCIO.$objAnuncioFoto->imagem ?>" alt="Alt">
											</a>
										<?php 
									}
								?>
							</div>
							<div class="slider-nav">
								<?php if (isset($objAnuncio->imagem)&&$objAnuncio->imagem!='') { ?>
									<div class="item-slick maxedHei"><img src="<?php echo URL_ANUNCIO.$objAnuncio->imagem ?>" alt="Alt"></div>
								<?php } ?>
								
								<?php 
									$retAnuncioFoto  = Doctrine_Query::create()->select()->from('AnuncioFoto')->where('anuncio_id = '.$objAnuncio->id)->execute();
									foreach ($retAnuncioFoto as $objAnuncioFoto) {
										?>
											<div class="item-slick maxedHei">
												<img src="<?php echo URL_ANUNCIO.$objAnuncioFoto->imagem ?>">
											</div>
										<?php 
									}
								?>
							</div>
						</div>
						
						<!-- Single Block Wrap -->
						<div class="block-wrap">
							<div class="block-header">
								<h4 class="block-title">Informações</h4>
							</div>
							
							<div class="block-body">
								<ul class="dw-proprty-info">
									<?php if (isset($objAnuncio->espaco)&&$objAnuncio->espaco!='') { ?>
										<li><strong>Espaço m²</strong><?php echo $objAnuncio->espaco.'m²' ?></li>
									<?php } ?>

									<?php if (isset($objAnuncio->limite_pessoas)&&$objAnuncio->limite_pessoas!='') { ?>
										<li><strong>Limite de pessoas</strong><?php echo $objAnuncio->limite_pessoas ?></li>
									<?php } ?>

									<?php if (isset($objAnuncio->codigo)&&$objAnuncio->codigo!='') { ?>
										<li><strong>Código</strong><?php echo $objAnuncio->codigo ?></li>
									<?php } ?>

									<?php if (isset($objAnuncio->garagem)&&$objAnuncio->garagem!='') { ?>
										<li><strong>Vagas de garagem</strong><?php echo $objAnuncio->garagem ?></li>
									<?php } ?>

									<?php if (isset($objAnuncio->quarto)&&$objAnuncio->quarto!='') { ?>
										<li><strong>Quarto</strong><?php echo $objAnuncio->quarto ?></li>
									<?php } ?>

									<?php if (isset($objAnuncio->banheiro)&&$objAnuncio->banheiro!='') { ?>
										<li><strong>Banheiros</strong><?php echo $objAnuncio->banheiro ?></li>
									<?php } ?>

									<?php if (isset($objAnuncio->estado_id)&&$objAnuncio->estado_id!='') { ?>
										<li><strong>Estado</strong><?php echo $objAnuncio->Estado->sigla ?></li>
									<?php } ?>

									<?php if (isset($objAnuncio->cidade_id)&&$objAnuncio->cidade_id!='') { ?>
										<li><strong>Cidade</strong><?php echo $objAnuncio->Cidade->nome ?></li>
									<?php } ?>
								</ul>
							</div>
						</div>
						
						<?php if (isset($objAnuncio->descricao)&&$objAnuncio->descricao!='') { ?>
							<div class="block-wrap">
								<div class="block-header">
									<h4 class="block-title">Descrição</h4>
								</div>
								
								<div class="block-body">
									<p><?php echo nl2br($objAnuncio->descricao) ?></p>
								</div>
							</div>
						<?php } ?>
						
						<!-- Single Block Wrap -->
						<div class="block-wrap">
							<div class="block-header">
								<h4 class="block-title">Opcionais</h4>
							</div>
							
							<div class="block-body">
								<ul class="avl-features third">
									<?php 
										$retAnuncioOpcional = Doctrine_Query::create()->select()->from('AnuncioOpcional')->where('anuncio_id = '.$objAnuncio->id)->execute();
										foreach ($retAnuncioOpcional as $objAnuncioOpcional) {
											?>
												<li><?php echo $objAnuncioOpcional->Opcional->nome ?></li>
											<?php 
										}
									?>								
								</ul>
							</div>
						</div>
						
						
					 	<?php if (isset($objAnuncio->cep)&&$objAnuncio->cep!='') { ?>
							<div class="block-wrap">
								<div class="block-header">
									<h4 class="block-title">Localização</h4>
								</div>
								
								<div class="block-body">
									<div class="map-container">
										<?php
						                	$mapa_rua = str_replace(" ", "%20", $objAnuncio->logradouro);
						                	$mapa_bairro = str_replace(" ", "%20", $objAnuncio->bairro);
						                	$mapa_complemento = str_replace(" ", "%20", $objAnuncio->complemento);
						                	$mapa_cidade = str_replace(" ", "%20", $objAnuncio->Cidade->nome);
						              	?>
						              	<iframe width="100%" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=<?php echo $mapa_rua."%2C%20"."%20".$mapa_complemento."%20-%20".$mapa_cidade."%20%2F%20".$objAnuncio->Estado->sigla ?>&key=AIzaSyCH1GFw2nj5WSe5MFQED0n1NnUHSiEy164" allowfullscreen></iframe>
									</div>
								</div>
							</div>
			          	<?php } ?>

			          	<?php 
			          		$retAnuncioReferencia = Doctrine_Query::create()->select()->from('AnuncioReferencia')->where('anuncio_id = '.$objAnuncio->id)->execute();
			          		if ($retAnuncioReferencia->count()>0) {
					          	?>
									<div class="block-wrap">
										<div class="block-header">
											<h4 class="block-title">Pontos de referência</h4>
										</div>
										
										<div class="block-body">
											<div class="nearby-wrap">
												<div class="neary_section_list">
													<?php 
				                                      foreach ($retAnuncioReferencia as $objAnuncioReferencia) {
				                                        ?>
				                                          <div class="neary_section">
				                                            <div class="neary_section_first">
				                                              <h4 class="nearby_place_title"><?php echo $objAnuncioReferencia->nome ?></h4>
				                                            </div>
				                                            <div class="neary_section_last">
				                                              <div class="nearby_place_rate good" style="background-color: <?php echo $objAnuncioReferencia->background ?>"><?php echo $objAnuncioReferencia->km.' km' ?></div>
				                                            </div>
				                                          </div>
				                                        <?php 
				                                      }
				                                    ?>    
												</div>
											</div>
										</div>
									</div>
								<?php 
							}
						?>
						
						<?php 
							$retReservaAvaliacao = Doctrine_Query::create()->select()->from('ReservaAvaliacao')->where('status = 1 and anuncio_id = '.$objAnuncio->id)->orderBy('data_cadastro DESC')->execute();
							if ($retReservaAvaliacao->count()>0) {
									?>
									<div class="block-wrap">
										<div class="block-header">
											<h4 class="block-title">Avaliações</h4>
										</div>
										
										<div class="block-body">
											<div class="author-review">
												<div class="comment-list">
													<ul>
														<?php 
															foreach ($retReservaAvaliacao as $objReservaAvaliacao) {
																?>
																	<li class="article_comments_wrap">
																		<article>
																			<div class="article_comments_thumb">
									        									<img src="<?php echo isset($objReservaAvaliacao->Cliente->imagem)&&$objReservaAvaliacao->Cliente->imagem!=''?URL_CLIENTE.$objReservaAvaliacao->Cliente->imagem:URL_IMAGES.'no-photo.png' ?>" class="avater-img" alt="">
																			</div>
																			<div class="comment-details">
																				<div class="comment-meta">
																					<div class="comment-left-meta">
																						<h4 class="author-name"><?php echo $objReservaAvaliacao->Cliente->nome ?></h4>
																						<div class="comment-date"><?php echo date('d/m/Y', strtotime($objReservaAvaliacao->data_cadastro)) ?></div>
																						<div class="avaliadosEstrela">
													                                        <?php if (isset($objReservaAvaliacao->avaliacao)&&$objReservaAvaliacao->avaliacao==1) { ?>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                        <?php } else if ($objReservaAvaliacao->avaliacao==2) { ?>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                        <?php } else if ($objReservaAvaliacao->avaliacao==3) { ?>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                        <?php } else if ($objReservaAvaliacao->avaliacao==4) { ?>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fal fa-star"></i>
													                                        <?php } else if ($objReservaAvaliacao->avaliacao==5) { ?>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                            <i class="fas fa-star"></i>
													                                        <?php }  ?>
													                                    </div>
																					</div>
																				</div>
																				<div class="comment-text">
																					<p><?php echo $objReservaAvaliacao->texto ?></p>
																				</div>
																			</div>
																		</article>
																	</li>
																<?php 
															}
														?>
													</ul>
												</div>
											</div>
										</div>
									</div>
								<?php 
							}
						?>					
					</div>
					
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="page-sidebar mb-20">
						    <div class="slide-property-sec mb-4">
						        <div class="pr-all-info socialCompartilhar">
						            <div class="btn_wrap">
								        <div id="compartilhar"></div>
								    </div>
						        </div>
						    </div>

						    <p class="linkCompleto">
			                    <span class="caminhoLink" id="linkPropriedade" style="display: none;">
			                    	<?php 
				                      echo URL.'anuncio/'.$objAnuncio->dns.'/'.$objAnuncio->id.'/';
				                    ?>
			                    </span>
			                    <button class="buttonCoppy btn btn-theme full-width" title="Copiar link do Espaço" onclick="copyToClipboard('#linkPropriedade')"><i class="fal fa-copy"></i> Copiar link do Espaço</button>
		                  	</p>
		                  	
		                  	<?php
		                  		$bloquearReserva = 0; 

		                  		$dataDeHoje = date('Y-m-d');

		                  		$where = 'anuncio_id = '.$objAnuncio->id;
               					// $where .= ' and "'.date('Y-m-d').'" between data_inicial and data_final';
        						$data_entrada                            = Util::dateConvert($_SESSION['reserva']['data_entrada']);
			                    $where .= ' and "'.$data_entrada.'" between data_inicial and data_final';
				                // echo $where;
		                  		$retAnuncioDataBloqueada = Doctrine_Query::create()->select()->from('AnuncioDataBloqueada')->where($where)->execute();
		                  		if ($retAnuncioDataBloqueada->count()>0) {
		                  			$bloquearReserva = 1; 
		                  		}

		                  		$opcaoReserva = 'liberado';
			                  	if (isset($_SESSION['sess_cliente_id'])&&$_SESSION['sess_cliente_id']!='') {
			                  		if ($_SESSION['sess_cliente_id']==$objAnuncio->cliente_id) {
			                  			$opcaoReserva = 'bloqueado';
			                  		}
			                  	} 

			                  	
				                  	if (isset($opcaoReserva)&&$opcaoReserva=='liberado') {
					                  	?>
										    <div class="agent-widget">
										        <h3>Reservar seu Espaço</h3>
									        	<form class="formReserva" id="formulario-reserva">
											        <?php 
										                $dataEntrada = str_replace("/", "-", $_SESSION['reserva']['data_entrada']);
										                $dataSaida = str_replace("/", "-", $_SESSION['reserva']['data_saida']);

										                if (isset($dataEntrada)&&$dataEntrada!='') {
												            ?>
														        <div class="hero-search-content filtroInterno">
																		<div class="form-group dataJaSelecionada" <?php echo isset($_SESSION['reserva'])&&$_SESSION['reserva']!=''?'style="display:block;"':'' ?>>
																			<div class="row">
																				<div class="col-md-12 mb-15">
																					<label>Data de entrada:</label>
																					<span><span id="dataEntrada"><?php echo isset($_SESSION['reserva']['data_entrada'])&&$_SESSION['reserva']['data_entrada']!=''?$_SESSION['reserva']['data_entrada']:'' ?></span> <i class="fal fa-pencil iconEditDate"></i></span>
																				</div>

																				<div class="col-md-12 mb-15">
																					<label>Data de saída:</label>
																					<span><span id="dataSaida"><?php echo isset($_SESSION['reserva']['data_saida'])&&$_SESSION['reserva']['data_saida']!=''?$_SESSION['reserva']['data_saida']:'' ?></span> <i class="fal fa-pencil iconEditDate"></i></span>
																				</div>
																				<?php if (isset($objAnuncio->tipo_cobranca_id)&&$objAnuncio->tipo_cobranca_id==2) { ?>																		

																					<div class="col-md-12 mb-15">
																						<?php 
																                            $TotalDias = Util::diasDatas(date('Y-m-d', strtotime($dataEntrada)), date('Y-m-d', strtotime($dataSaida)));
																                        ?>
																						<label>Total de diárias:</label>
																						<span id="TotalDias"><?php echo isset($TotalDias)&&$TotalDias!=''?$TotalDias.' diárias':$TotalDias.' diária' ?></span>
																					</div>

																					<div class="col-md-12 mb-15">
																						<label>Valor:</label>
																						<span><?php echo 'R$'.number_format($TotalDias*$valorAnuncio, 2, ',', '.') ?></span>
																					</div>
																				<?php } else { ?>
																					<div class="col-md-12 mb-15">
																						<label>Horário Entrada:</label>
																						<span><span class="horario_entrada"><?php echo isset($_SESSION['reserva']['horario_entrada'])&&$_SESSION['reserva']['horario_entrada']!=''?$_SESSION['reserva']['horario_entrada']:'' ?></span> <i class="fal fa-pencil iconEditDate"></i></span>
																					</div>

																					<div class="col-md-12 mb-15">
																						<label>Horário de Saída:</label>
																						<span><span class="horario_saida"><?php echo isset($_SESSION['reserva']['horario_saida'])&&$_SESSION['reserva']['horario_saida']!=''?$_SESSION['reserva']['horario_saida']:'' ?></span> <i class="fal fa-pencil iconEditDate"></i></span>
																					</div>

																					<div class="col-md-12 mb-15">
																						<?php 
																                            $TotalDias = $_SESSION['reserva']['horario_diferenca'];
																                        ?>
																						<label>Total de horas:</label>
																						<span id="TotalDias"><?php echo isset($TotalDias)&&$TotalDias!=''?$TotalDias.' horas':$TotalDias.' hora' ?></span>
																					</div>

																					<div class="col-md-12 mb-15">
																						<label>Valor:</label>
																						<span><?php echo 'R$'.number_format($_SESSION['reserva']['horario_diferenca']*$valorAnuncio, 2, ',', '.') ?></span>
																					</div>
																				<?php } ?>
																			</div>
																		</div>
																</div>
														    <?php 
														} else {
															?>
																<div class="row">
																	<div class="col-md-12">
																		<div class="dataJaSelecionada">
																			<div class="botaoSelecionaveis"><i class="fal fa-calendar-alt"></i> Selecione as datas</div>
																		</div>
																	</div>
																</div>
															<?php
														}
													?>
										
													<input type="hidden" name="data_entrada" value="<?php echo isset($_SESSION['reserva']['data_entrada'])&&$_SESSION['reserva']['data_entrada']!=''?$_SESSION['reserva']['data_entrada']:'' ?>">
													<input type="hidden" name="data_saida" value="<?php echo isset($_SESSION['reserva']['data_saida'])&&$_SESSION['reserva']['data_saida']!=''?$_SESSION['reserva']['data_saida']:'' ?>">
													<?php if (isset($objAnuncio->tipo_cobranca_id)&&$objAnuncio->tipo_cobranca_id==2) { ?>
														<input type="hidden" name="qtd_dias" value="<?php echo isset($TotalDias)&&$TotalDias!=''?$TotalDias:'' ?>">
														<input type="hidden" name="valor_total" value="<?php echo number_format($TotalDias*$valorAnuncio, 2, ',', '.') ?>">
													<?php } else { ?>
														<input type="hidden" name="horario_entrada" value="<?php echo $_SESSION['reserva']['horario_entrada'] ?>">
														<input type="hidden" name="horario_saida" value="<?php echo $_SESSION['reserva']['horario_saida'] ?>">
														<input type="hidden" class="valDiferenca" name="hora_diferenca" value="<?php echo $_SESSION['reserva']['horario_diferenca'] ?>">
														<input type="hidden" class="valValor" name="valor_total" value="<?php echo number_format($_SESSION['reserva']['horario_diferenca']*$valorAnuncio, 2, ',', '.') ?>">
													<?php } ?>

													<?php 
														if (isset($bloquearReserva)&&$bloquearReserva==0) { ?>
															<input type="hidden" name="tipo_cobranca_id" value="<?php echo isset($objAnuncio->tipo_cobranca_id)&&$objAnuncio->tipo_cobranca_id!=''?$objAnuncio->tipo_cobranca_id:'' ?>">
															<input type="hidden" name="anuncio_id" value="<?php echo isset($objAnuncio->id)&&$objAnuncio->id!=''?$objAnuncio->id:'' ?>">
															<input type="hidden" name="cliente_id" value="<?php echo isset($_SESSION['sess_cliente_id'])&&$_SESSION['sess_cliente_id']!=''?$_SESSION['sess_cliente_id']:'' ?>">
													    	<button class="btn btn-theme full-width" style="margin-top: 15px;">Reservar agora</button>
													    	<?php 
												    	} else {
															?>
																<div class="localProprio">
																	Reserva indisponível!
																</div>
															<?php
														}
												    ?>
												</form>
										    </div>
										<?php 
									} else if ($opcaoReserva=='bloqueado') {
										?>
											<div class="localProprio">
												Você é o proprietário do espaço!
											</div>
										<?php
									}
							?>
						</div>

						<div class="sidebar-widgets">
						    <h4>Locais parecidos nas proximidades</h4>
						    <div class="sidebar_featured_property">
						    	<?php 
									$retAnuncioProx = Doctrine_Query::create()->select()->from('Anuncio')->where('status_id = 2 and pagamento = 1 and id <> '.$objAnuncio->id)->limit(5)->orderBy('rand()')->execute();
									foreach ($retAnuncioProx as $objAnuncioProx) {
										?>
									        <div class="sides_list_property">
									            <div class="sides_list_property_thumb"><a href="<?php echo URL.'anuncio/'.$objAnuncioProx->dns.'/'.$objAnuncioProx->id.'/' ?>">
									            	<?php if (isset($objAnuncioProx->imagem)&&$objAnuncioProx->imagem!='') { ?>
														<img src="<?php echo URL_ANUNCIO.$objAnuncioProx->imagem ?>">
													<?php } else { ?>
														<img src="<?php echo URL_IMAGES ?>sem-foto.jpg">
													<?php } ?>
									            </div>
									            <div class="sides_list_property_detail">
									                <h4><a href="<?php echo URL.'anuncio/'.$objAnuncioProx->dns.'/'.$objAnuncioProx->id.'/' ?>"><?php echo $objAnuncioProx->titulo ?></a></h4><span><i class="ti-location-pin"></i>Belo Horizonte</span>
									                <div class="lists_property_price">
									                  <!--   <div class="lists_property_types">
									                        <div class="property_types_vlix sale">3 KM</div>
									                    </div> -->
									                    <div class="lists_property_price_value">
									                        <h4 style="color: #fd5000;">R$<?php echo number_format($objAnuncioProx->valor, 0, ',', '.') ?><span style="color: #72809d;font-size: 16px;">/mês</span></h4></div>
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
              <h4>Carregando...</h4>
            </div>
		</div>
	</section>

	<div class="modal fade ModalDateSelect" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="tituloModal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                  <span aria-hidden="true">&times;</span>
                </button>
                <?php 
                    $dataEntrada = str_replace("/", "-", $_SESSION['reserva']['data_entrada']);
                    $dataSaida = str_replace("/", "-", $_SESSION['reserva']['data_saida']);
                ?>
                <h5 class="modal-title" id="exampleModalLabel">Selecione as datas</h5>
            </div>

            <form class="formDates" id="formulario-data2">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Data de entrada:</label>
                            <div class="input-with-icon b-l">
                                <input type="date" class="form-control validate[required] plf-padrao" placeholder="Data" name="data_entrada" value="<?php echo isset($_SESSION['reserva']['data_entrada'])&&$_SESSION['reserva']['data_entrada']!=''?date('Y-m-d', strtotime($dataEntrada)):'' ?>">
                            </div>
                        </div>
                    </div>

                    <?php if (isset($objAnuncio->tipo_cobranca_id)&&$objAnuncio->tipo_cobranca_id==1) { ?>
	                    <div class="col-lg-6 col-md-6 col-sm-12">
	                        <div class="form-group">
	                            <label>Horário de entrada:</label>
	                            <div class="input-with-icon b-l">
	                               <select class="form-control" name="horario_entrada" id="horario_entrada">
	                                	<?php 
	                               			for ($horaEntrada=1; $horaEntrada <=23 ; $horaEntrada++) { 
	                               				?>
	                               					<option value="<?php echo str_pad($horaEntrada, 2, '0', STR_PAD_LEFT).':00' ?>" <?php echo isset($_SESSION['reserva']['horario_entrada'])&&$_SESSION['reserva']['horario_entrada']==str_pad($horaEntrada, 2, '0', STR_PAD_LEFT).':00'?'selected':'' ?>><?php echo str_pad($horaEntrada, 2, '0', STR_PAD_LEFT).':00' ?></option>
	                               				<?php
	                               			}
	                               		?>
	                               </select>
	                            </div>
	                        </div>
	                    </div>
                   <?php } ?>
                    
					<div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Data de saída:</label>
                            <div class="input-with-icon b-l">
                                <input type="date" class="form-control validate[required] plf-padrao" placeholder="Data" name="data_saida" value="<?php echo isset($_SESSION['reserva']['data_saida'])&&$_SESSION['reserva']['data_saida']!=''?date('Y-m-d', strtotime($dataSaida)):'' ?>">
                            </div>
                        </div>
                    </div>

                    <?php if (isset($objAnuncio->tipo_cobranca_id)&&$objAnuncio->tipo_cobranca_id==1) { ?>
	                    <div class="col-lg-6 col-md-6 col-sm-12">
	                        <div class="form-group">
	                            <label>Horário de saída:</label>
	                            <div class="input-with-icon b-l">
	                               <select class="form-control" name="horario_saida" id="horario_saida">
	                               		<option value="">Selecione</option>
	                               		<?php 
	                               			for ($horaSaida=1; $horaSaida <=23 ; $horaSaida++) { 
	                               				?>
	                               					<option value="<?php echo str_pad($horaSaida, 2, '0', STR_PAD_LEFT).':00' ?>" <?php echo isset($_SESSION['reserva']['horario_saida'])&&$_SESSION['reserva']['horario_saida']==str_pad($horaSaida, 2, '0', STR_PAD_LEFT).':00'?'selected':'' ?>><?php echo str_pad($horaSaida, 2, '0', STR_PAD_LEFT).':00' ?></option>
	                               				<?php
	                               			}
	                               		?>
	                               </select>
	                            </div>
	                        </div>
	                    </div>
                   <?php } ?>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                    	<input type="hidden" name="tipo_cobranca_id" value="<?php echo $objAnuncio->tipo_cobranca_id ?>">
                        <input type="submit" class="selecionarDatas" value="Selecionar datas">
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

<?php
  	$obContent = ob_get_contents();
  	ob_end_clean();
  	include('base.php');
?>

<script type="text/javascript">
  	function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();

       Lobibox.notify('success', {
        delay: 6000,
      position: "top right", 
        title: 'Sucesso',
        dataType: "json",
        icon: true,
        msg: 'Link do anúncio copiado com sucesso.'
    });
	}

	$('#selecionar-data').click(function() {
		$('.ModalDateSelect').modal();
	});

	$('.dataJaSelecionada').click(function() {
		$('.ModalDateSelect').modal();
	});

	$('.formDates').validationEngine({
        scroll: false
    });
    $('.formDates').submit(function(e) {
        e.preventDefault();
        if ($(this).validationEngine('validate')) {

            var formulario = document.getElementById('formulario-data2');
            var formData = new FormData(formulario);


            $.ajax({
                url: URL_SITE + 'action/SelecionarDatas.php',
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.status == 1) {
                    	$('.ModalDateSelect').modal('hide');
                    	$('.hero-search-content .SelecDate').css('display','none');
                    	$('.hero-search-content .dataJaSelecionada').css('display','block');

                    	function dataAtualFormatada(){
						    let data = new Date(),
						        dia  = data.getDate().toString().padStart(2, '0'),
						        mes  = (data.getMonth()+1).toString().padStart(2, '0'),
						        ano  = data.getFullYear();
						    return `${dia}/${mes}/${ano}`;
						}

                    	if (response.tipo_cobranca_id == 2) {
	                    	$('.hero-search-content #dataEntrada').html(response.data_entrada);
	                    	$('.hero-search-content #dataSaida').html(response.data_saida);
	                    	$('.hero-search-content #TotalDias').html(response.totalDiarias);


                    	} else if (response.tipo_cobranca_id == 1) {
                    		$('.hero-search-content .dataEntrada').html(response.data_entrada);
                    		$('.hero-search-content .horario_entrada').html(response.horario_entrada);
                    		$('.hero-search-content .horario_saida').html(response.horario_saida);
                    	}
                    	// $('.hero-search-content #dataEntradaHorario').html(response.data_entrada_horario);

                    	// $('.hero-search-content #dataSaidaHorario').html(response.data_saida_horario);
						location.reload();
                    } else if (response.status == 2 && response.mensagem !='') {
                    	Lobibox.notify('error', {
	                      delay: 6000,
	                      position: "top right", 
	                      title: 'Algo de errado',
	                      dataType: "json",
	                      icon: true,
	                      msg: response.mensagem
	                    });
                    }
                }
            });
        }
    });

    $('.formReserva').validationEngine({
	    scroll: false
	});
	$('.formReserva').submit(function(e) {
	    e.preventDefault();
	    if ($(this).validationEngine('validate')) {

	    	$('.model-anuncio .blocoAnuncio.reserva').css('display', 'none');
	    	$('.model-anuncio .loadingadmins').css('display', 'block');

	        var formulario = document.getElementById('formulario-reserva');
	        var formData = new FormData(formulario);

	        $.ajax({
	            url: URL_SITE + 'action/addReserva.php',
	            processData: false,
	            contentType: false,
	            type: 'POST',
	            dataType: 'json',
	            data: formData,
	            success: function(response) {
	                if (response.status == 1) {
	                	setTimeout(function() {
                         	window.location.href=URL_SITE+"reserva/"+response.reserva_id;
	                	}, 3000);

	                } else if (response.status == 2 && response.anuncio_id != '') {
                        window.location.href=URL_SITE+"anuncio/<?php echo $objAnuncio->dns.'/'.$objAnuncio->id ?>/?ref=login&anuncio_id="+response.anuncio_id;
	                } else if (response.status == 3) {
	    				$('.model-anuncio .loadingadmins').css('display', 'none');
	    				$('.model-anuncio .blocoAnuncio.reserva').css('display', 'block');

	    				Lobibox.notify('error', {
	                      delay: 6000,
	                      position: "top right", 
	                      title: 'Preencha as informações',
	                      dataType: "json",
	                      icon: true,
	                      msg: 'Selecione as datas para efetuar a reserva!'
	                    });
	                } else if (response.status == 4) {
	    				$('.model-anuncio .loadingadmins').css('display', 'none');
	    				$('.model-anuncio .blocoAnuncio.reserva').css('display', 'block');

	    				Lobibox.notify('error', {
	                      delay: 6000,
	                      position: "top right", 
	                      title: 'Espaço indisponível',
	                      dataType: "json",
	                      icon: true,
	                      msg: 'Ja existe uma reserva para esse período!'
	                    });
	                } else if (response.status == 5) {
	    				$('.model-anuncio .loadingadmins').css('display', 'none');
	    				$('.model-anuncio .blocoAnuncio.reserva').css('display', 'block');

	    				Lobibox.notify('error', {
	                      delay: 6000,
	                      position: "top right", 
	                      title: 'Não foi possível reservar',
	                      dataType: "json",
	                      icon: true,
	                      msg: 'O mínimo para reserva é de '+response.minimo_diaria+' dias/hora'
	                    });
	                }
	            }
	        });
	    }
	});

	$('.addFavorito').click(function(e) {
   		var anuncio_id = $(this).attr('propriedade_id');

   		$.ajax({
            url: URL_SITE + 'action/addFavorito.php',
            type: 'POST',
            dataType: 'json',
            data: {anuncio_id: anuncio_id},
            success: function(response) {
              if (response.status == 1) {
                Lobibox.notify('success', {
                  delay: 6000,
                  position: "top right", 
                  title: 'Sucesso',
                  dataType: "json",
                  icon: true,
                  msg: 'Espaço adicionado aos favoritos!'
                });
				 setTimeout(function() {
					location.reload();
                }, 1300);
              } else if (response.status == 2) {
                Lobibox.notify('success', {
                  delay: 6000,
                  position: "top right", 
                  title: 'Sucesso',
                  dataType: "json",
                  icon: true,
                  msg: 'Espaço removido dos favoritos!'
                });

                setTimeout(function() {
					location.reload();
                }, 1300);
              } else if (response.status == 3) {
                Lobibox.notify('error', {
                  delay: 6000,
                  position: "top right", 
                  title: 'Não foi possível',
                  dataType: "json",
                  icon: true,
                  msg: 'Você precisa acessar sua conta para adicionar o espaço aos favoritos!'
                });

              }
            }
        });
   	});

   	$(document).ready(function () {
	    $("#compartilhar").jsSocials({
	      shares: ["facebook", "whatsapp"],
	      url: "<?php echo utf8_encode(URL.'anuncio/'.$objAnuncio->dns.'/'.$objAnuncio->id.'/') ?>",
	      text: `<?php echo strip_tags($objAnuncio->titulo) ?>`,
	    });
  	});
</script>