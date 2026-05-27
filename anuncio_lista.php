<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader = 'light';

  	if (isset($_GET['valor_max'])&&$_GET['valor_max']>0) {
  		$valorFormatadoMax                  = Util::formata_valor($_GET['valor_max']);
  	}

  	if (isset($_GET['valor_min'])&&$_GET['valor_min']>0) {
	  	$valorFormatadoMin                  = Util::formata_valor($_GET['valor_min']);
  	}

  	# Filtros relacionados a valores, visualizacoes...
  	$orderBy = 'data_cadastro DESC'; // Esse é o padrão.
  	if (isset($_GET['ordem'])&&$_GET['ordem']=='recentes') {
  		$orderBy = 'data_cadastro DESC';
  	} else if ($_GET['ordem']=='visualizacao') {
  		$orderBy = 'visualizacao DESC';
  	} else if ($_GET['ordem']=='menor_valor') {
  		$orderBy = 'valor ASC';
  	} else if ($_GET['ordem']=='maior_valor') {
  		$orderBy = 'valor DESC';
  	}

  	// Aqui validamos se existe já uma pesquisa, isso para que não seja perdido nenhum filtro pelo cliente.
  	$urlComplementar = "";
    $urlComplementar .= isset($_GET['categoria_id'])&&($_GET['categoria_id']!= "")?"&categoria_id=".$_GET['categoria_id']."":"";
    $urlComplementar .= isset($_GET['tags'])&&($_GET['tags']!= "")?"&tags=".$_GET['tags']."":"";
    $urlComplementar .= isset($_GET['tipo_cobranca_id'])&&($_GET['tipo_cobranca_id']!= "")?"&tipo_cobranca_id=".$_GET['tipo_cobranca_id']."":"";
    $urlComplementar .= isset($_GET['estado_id'])&&($_GET['estado_id']!= "")?"&estado_id=".$_GET['estado_id']."":"";
    $urlComplementar .= isset($_GET['cidade_id'])&&($_GET['cidade_id']!= "")?"&cidade_id=".$_GET['cidade_id']."":"";
    $urlComplementar .= isset($_GET['garagem'])&&($_GET['garagem']!= "")?"&garagem=".$_GET['garagem']."":"";
    $urlComplementar .= isset($_GET['quarto'])&&($_GET['quarto']!= "")?"&quarto=".$_GET['quarto']."":"";
    $urlComplementar .= isset($_GET['banheiro'])&&($_GET['banheiro']!= "")?"&banheiro=".$_GET['banheiro']."":"";
    $urlComplementar .= isset($_GET['valor_min'])&&($_GET['valor_min']!= "")?"&valor_min=".$_GET['valor_min']."":"";
    $urlComplementar .= isset($_GET['valor_max'])&&($_GET['valor_max']!= "")?"&valor_max=".$_GET['valor_max']."":"";
    $urlComplementar = sanitizeString($urlComplementar);
?>
	
	<div class="page-title">
		<div class="container">
			<div class="row mb-20">
				<div class="col-lg-12 col-md-12">
					<h2 class="ipt-title">Lista de locais</h2>
					<span class="ipn-subtitle">Escolha um local</span>
				</div>
			</div>

			<div class="breadcumb">
                <ul class="menuAcompanhador">
                    <li><a href="<?php echo URL ?>"><i class="fal fa-chevron-double-right"></i> Início</a></li>
                    <li><a class="active" href="javascript:void(0);"><i class="fal fa-chevron-double-right"></i> Anúncios</a></li>
                </ul>
            </div>
		</div>
	</div>

	<section>
		<div class="container">
			<?php 
                $dataEntrada = str_replace("/", "-", $_SESSION['reserva']['data_entrada']);
                $dataSaida = str_replace("/", "-", $_SESSION['reserva']['data_saida']);

                if (isset($dataEntrada)&&$dataEntrada!='') {
		            ?>
						<div class="hero-search-content filtroInterno">
							<div class="form-group dataJaSelecionada" <?php echo isset($_SESSION['reserva'])&&$_SESSION['reserva']!=''?'style="display:block;"':'' ?>>
								<div class="row">
									<div class="col-md-3">
										<label>Data de entrada:</label>
										<span><span id="dataEntrada"><?php echo isset($_SESSION['reserva']['data_entrada'])&&$_SESSION['reserva']['data_entrada']!=''?$_SESSION['reserva']['data_entrada']:'' ?></span></span>
									</div>

									<div class="col-md-3">
										<label>Data de saída:</label>
										<span><span id="dataSaida"><?php echo isset($_SESSION['reserva']['data_saida'])&&$_SESSION['reserva']['data_saida']!=''?$_SESSION['reserva']['data_saida']:'' ?></span></span>
									</div>
									<?php if (isset($_SESSION['reserva']['tipo_cobranca_id'])&&$_SESSION['reserva']['tipo_cobranca_id']==2) { ?>																		

										<div class="col-md-3">
											<?php 
					                            $TotalDias = Util::diasDatas(date('Y-m-d', strtotime($dataEntrada)), date('Y-m-d', strtotime($dataSaida)));
					                        ?>
											<label>Total de diárias:</label>
											<span id="TotalDias"><?php echo isset($TotalDias)&&$TotalDias!=''?$TotalDias.' diárias':$TotalDias.' diária' ?></span>
										</div>
									<?php } else { ?>
										<div class="col-md-3">
											<label>Horário Entrada:</label>
											<span><span class="horario_entrada"><?php echo isset($_SESSION['reserva']['horario_entrada'])&&$_SESSION['reserva']['horario_entrada']!=''?$_SESSION['reserva']['horario_entrada']:'' ?></span></span>
										</div>

										<div class="col-md-3">
											<label>Horário de Saída:</label>
											<span><span class="horario_saida"><?php echo isset($_SESSION['reserva']['horario_saida'])&&$_SESSION['reserva']['horario_saida']!=''?$_SESSION['reserva']['horario_saida']:'' ?></span></span>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php 
				}
			?>

			<div class="row">
				<div class="col-lg-4 col-md-12 col-sm-12">
					<div class="page-sidebar">
						<div class="simple-sidebar sm-sidebar">
							<div class="sidebar-widgets">
								<h5 class="mb-3">Pesquise um novo Espaço</h5>
								
								<form method="get" action="<?php echo URL ?>anuncios/">
									<div class="form-group">
										<div class="input-with-icon select2style">
											<select name="estado_id" id="estado_id" class="form-control">
												<option value="">Selecione o Estado</option>
											    <?php 
			                                    	$retEstado = Doctrine_Query::create()->select()->from('Estado')->execute();
			                                    	foreach ($retEstado as $objEstado) {
			                                            $selected = $_GET['estado_id']==$objEstado->id?'selected':'';
			                                            ?>
			                                            	<option value="<?php echo $objEstado->id ?>" <?php echo $selected ?>><?php echo $objEstado->nome ?></option>
			                                            <?php 
			                                        }
			                                    ?>
											</select>
											<i class="fal fa-map-marker"></i>
										</div>
									</div>

									<div class="form-group">
										<div class="input-with-icon select2style">
											<select name="cidade_id" id="cidade_id" class="form-control">
												<option value="">Selecione a Cidade</option>
											    <?php 
											    	if (isset($_GET['estado_id'])&&$_GET['estado_id']!='') {
				                                    	$retCidade = Doctrine_Query::create()->select()->from('Cidade')->where('estado_id = '.$_GET['estado_id'])->execute();
				                                    	foreach ($retCidade as $objCidade) {
				                                            $selected = $_GET['cidade_id']==$objCidade->id?'selected':'';
				                                            ?>
				                                            	<option value="<?php echo $objCidade->id ?>" <?php echo $selected ?>><?php echo $objCidade->nome ?></option>
				                                            <?php 
				                                        }
			                                        }
			                                    ?>
											</select>
											<i class="fal fa-map-marker"></i>
										</div>
									</div>	

									<div class="form-group">
										<div class="input-with-icon">
											<select name="categoria_id" id="categoria_id" class="form-control">
												<option value="">Selecione a Categoria</option>
											    <?php 
			                                    	$retCategoria = Doctrine_Query::create()->select()->from('Categoria')->where('status = 1')->orderBy('ordem ASC')->execute();
			                                    	foreach ($retCategoria as $objCategoria) {
			                                            $selected = $_GET['categoria_id']==$objCategoria->id?'selected':'';
			                                            ?>
			                                            	<option value="<?php echo $objCategoria->id ?>" <?php echo $selected ?>><?php echo $objCategoria->nome ?></option>
			                                            <?php 
			                                        }
			                                    ?>
											</select>
											<i class="fas fa-briefcase"></i>
										</div>
									</div>	

									<div class="form-group">
	                                    <label>Tag</label>
	                                    <input type="text" class="sc-eCApnc btdohk form-control validate[required]" name="tags" value="<?php echo $_GET['tags'] ?>">
	                                </div>

	                                <div class="form-group">
									    <label>Vagas a garagem?</label>
									    <input type="text" name="garagem" class="form-control validate[required]" data-mask="99" value="<?php echo $_GET['garagem'] ?>" />
									</div>

									<div class="form-group">
									    <label>Quartos?</label>
									    <input type="text" name="quarto" class="form-control validate[required]" data-mask="99" value="<?php echo $_GET['quarto'] ?>" />
									</div>

									<div class="form-group">
									    <label>Banheiros?</label>
									    <input type="text" name="banheiro" class="form-control validate[required]" data-mask="99" value="<?php echo $_GET['banheiro'] ?>" />
									</div>
								
									<?php if (isset($_GET['valor_min'])&&$_GET['valor_min']!='' && isset($_GET['valor_max'])&&$_GET['valor_max']!='') { ?>
										<div class="row">
											<div class="form-group col-md-6">
			                                    <label>Valor min:</label>
			                                    <input type="text" class="sc-eCApnc btdohk form-control validate[required] valor-input" name="valor_min" value="<?php echo number_format($_GET['valor_min'], 2, ',', '.') ?>">
			                                </div>

			                                <div class="form-group col-md-6">
			                                    <label>Valor max:</label>
			                                    <input type="text" class="sc-eCApnc btdohk form-control validate[required] valor-input" name="valor_max" value="<?php echo number_format($_GET['valor_max'], 2, ',', '.') ?>">
			                                </div>
										</div>
									<?php } else { ?>
										<div class="range-slider">
											<label>Seu orçamento(por diária)</label>
											<div data-min="0" data-max="6000" data-min-name="valor_min" data-max-name="valor_max" data-unit="" class="range-slider-ui ui-slider" aria-disabled="false"></div>
											<div class="clearfix"></div>
										</div>
									<?php } ?>
									
									<!-- <div class="range-slider">
										<label>Alcance da busca</label>
										<div data-min="0" data-max="600" data-min-name="min_area" data-max-name="max_area" data-unit="KM" class="range-slider-ui ui-slider" aria-disabled="false"></div>
										<div class="clearfix"></div>
									</div> -->

									<div class="clearfix"></div><br>

									<div class="ameneties-features">
										<div class="form-group" id="module">
											<a role="button" class="collapsed" data-toggle="collapse" href="#advance-search" aria-expanded="false" aria-controls="advance-search"></a>
										</div>

										<div class="collapse <?php echo isset($_GET['opcional_id'])&&$_GET['opcional_id']!=''?'show':'' ?>" id="advance-search" aria-expanded="false" role="banner">
											<ul class="no-ul-list mb" style="margin-bottom: 30px;">
											    <?php 
											    	$opcional_id = array();
													 foreach ($_GET['opcional_id'] as $key => $value) {
														 $opcional_id[] = $value;
													 }

											    	$retOpcional = Doctrine_Query::create()->select()->from('Opcional')->orderBy('nome ASC')->execute();
											    	foreach ($retOpcional as $objOpcional) {
														$checked = in_array($objOpcional->id, $opcional_id)?"checked":"";
													    ?>
														    <li>
														    	<input id="opc-<?php echo $objOpcional->id ?>" class="checkbox-custom" name="opcional_id[]" type="checkbox" <?php echo $checked ?> value="<?php echo $objOpcional->id ?>"/>
														    	<label for="opc-<?php echo $objOpcional->id ?>" class="checkbox-custom-label"><?php echo $objOpcional->nome ?></label>
														    </li>
														<?php 
													}
												?>
											</ul>
										</div>
									
										<button class="btn btn-theme full-width">Encontrar novos locais</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- Sidebar End -->
				
				</div>
				
				<div class="col-lg-8 col-md-12 list-layout">
					<?php 
                        $mostrar = 10;

						$where 			= 'status_id = 2 and pagamento = 1';
						$where 			.= isset($_GET['categoria_id'])&&$_GET['categoria_id']!=''?' and categoria_id = '.$_GET['categoria_id']:'';
						$where 			.= isset($_GET['estado_id'])&&$_GET['estado_id']!=''?' and estado_id = '.$_GET['estado_id']:'';
						$where 			.= isset($_GET['cidade_id'])&&$_GET['cidade_id']!=''?' and cidade_id = '.$_GET['cidade_id']:'';
						$where 			.= isset($_GET['garagem'])&&$_GET['garagem']!=''?' and garagem = '.$_GET['garagem']:'';
						$where 			.= isset($_GET['quarto'])&&$_GET['quarto']!=''?' and quarto = '.$_GET['quarto']:'';
						$where 			.= isset($_GET['tipo_cobranca_id'])&&$_GET['tipo_cobranca_id']!=''?' and tipo_cobranca_id = '.$_GET['tipo_cobranca_id']:'';
						$where 			.= isset($_GET['banheiro'])&&$_GET['banheiro']!=''?' and banheiro = '.$_GET['banheiro']:'';
		 				$where 			.=	isset($_GET['titulo'])&&$_GET['titulo']!=''?" and titulo like '%".$_GET['titulo']."%'":"";
		 				$where 			.=	isset($_GET['tags'])&&$_GET['tags']!=''?" and tags like '%".$_GET['tags']."%'":"";
						$where 			.= isset($_GET['valor_min'])&&$_GET['valor_min']!=''?' and valor >= '.$valorFormatadoMin:'';
						$where 			.= isset($_GET['valor_max'])&&$_GET['valor_max']!=''?' and valor <= '.$valorFormatadoMax:'';
						
						if(isset($_GET['opcional_id'])&&$_GET['opcional_id'] != ''){
			                foreach ($_GET['opcional_id'] as $value) {
								$where .= " and a.id in (select `anuncio_id` from `anuncio_opcional` where `opcional_id` = ".$value.")";
							}
			            }
						$retAnuncioTotal = Doctrine_Query::create()->select()->from('Anuncio a')->where($where)->execute();

                        if(isset($_GET['pag'])){
	                        $page = isset($_GET['pag'])?$_GET['pag']-1:0;
	                        $inicio = $page * $mostrar;
                    		$order = $orderBy.' limit '.$inicio.','.$mostrar;
	                    }else{
                        	$order = $orderBy.' limit '.$mostrar;
	                    }

						$retAnuncio = Doctrine_Query::create()->select()->from('Anuncio a')->where($where)->orderBy($order)->execute();
					?>
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="filter-fl">
								<h4 class="titulo">Total de locais encontrados: <span class="theme-cl"><?php echo $retAnuncio->count(); ?></span></h4>
								<div class="btn-group custom-drop ">
									<button type="button" class="btn btn-order-by-filt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Filtrar por:<i class="ti-angle-down"></i>
									</button>
									<div class="dropdown-menu pull-right animated flipInX">
										<a href="<?php echo URL.'anuncios/?'.$urlComplementar.'&ordem=recentes' ?>">Mais recentes</a>
										<a href="<?php echo URL.'anuncios/?'.$urlComplementar.'&ordem=visualizacao' ?>">Mais vista</a>
										<a href="<?php echo URL.'anuncios/?'.$urlComplementar.'&ordem=menor_valor' ?>">Menor valor</a>
										<a href="<?php echo URL.'anuncios/?'.$urlComplementar.'&ordem=maior_valor' ?>">Maior valor</a>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-12 col-md-12">
							<?php
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
										<div class="property-listing property-1">
											<div class="listing-img-wrapper">
												<?php if (isset($objAnuncio->imagem)&&$objAnuncio->imagem!='') { ?>
													<a href="<?php echo URL.'anuncio/'.$objAnuncio->dns.'/'.$objAnuncio->id.'/' ?>">
														<img src="<?php echo URL_ANUNCIO.$objAnuncio->imagem ?>" class="img-fluid mx-auto" alt="" />
													</a>
												<?php } else { ?>
													<a class="maxedHei" href="<?php echo URL_IMAGES ?>sem-foto.jpg" data-fancybox="group"><img src="<?php echo URL_IMAGES ?>sem-foto.jpg"></a>
												<?php } ?>

												<?php 
													if (isset($_SESSION['sess_cliente_id'])&&$_SESSION['sess_cliente_id']!='') {
														$objAnuncioFavorito = Doctrine_Core::getTable('AnuncioFavorito')->findOneByAnuncioIdAndClienteId($objAnuncio->id, $_SESSION['sess_cliente_id']);
														if (isset($objAnuncioFavorito->id)) {
															?>
																<div class="listing-like-top">
																	<a href="javascript:void(0);" class="addFavorito" id="addFavorito" propriedade_id="<?php echo $objAnuncio->id ?>">
																		<i class="fas fa-heart"></i>
																	</a>
																</div>
															<?php
														} else {
															?>
																<div class="listing-like-top">
																	<a href="javascript:void(0);" class="addFavorito" id="addFavorito" propriedade_id="<?php echo $objAnuncio->id ?>">
																		<i class="ti-heart"></i>
																	</a>
																</div>
															<?php
														}
													}
												?>
												
												<!-- <div class="listing-rating">
													<i class="ti-star filled"></i>
													<i class="ti-star filled"></i>
													<i class="ti-star filled"></i>
													<i class="ti-star filled"></i>
													<i class="ti-star"></i>
												</div> -->
											</div>
											
											<div class="listing-content">
											
												<div class="listing-detail-wrapper">
													<div class="listing-short-detail">
														<h4 class="listing-name"><a href="<?php echo URL.'anuncio/'.$objAnuncio->dns.'/'.$objAnuncio->id.'/' ?>"><?php echo $objAnuncio->titulo ?></a></h4>
														<?php
							                                if (isset($objAnuncio->estado_id) && $objAnuncio->estado_id != '') {
							                                $enderecoComp = isset($objAnuncio->logradouro) && $objAnuncio->logradouro != ''?$objAnuncio->logradouro : '';
							                                $enderecoComp .= isset($objAnuncio->bairro) && $objAnuncio->bairro != '' ? ' - ' . $objAnuncio->bairro.' - ' : '';
							                                $enderecoComp .= isset($objAnuncio->cidade_id) && $objAnuncio->cidade_id != '' ? $objAnuncio->Cidade->nome : '';
							                                $enderecoComp .= isset($objAnuncio->estado_id) && $objAnuncio->estado_id != '' ? '/' . $objAnuncio->Estado->sigla : '';
								                                ?>
																	<span class="listing-location"><i class="ti-location-pin"></i><?php echo $enderecoComp ?></span>
																<?php
							                                }
							                            ?>
													</div>
													<div class="list-author">
														<?php if (isset($objAnuncio->cliente_id)&&$objAnuncio->cliente_id!='') { ?>
															<a href="#"><img src="<?php echo URL_CLIENTE.$objAnuncio->Cliente->imagem ?>" class="img-fluid img-circle avater-30" alt=""></a>
														<?php } ?>
													</div>
												</div>
											
												<div class="listing-features-info">
													<ul>
														<?php if (isset($objAnuncio->quarto)&&$objAnuncio->quarto>0) { ?>
															<li><strong>Quartos:</strong><?php echo $objAnuncio->quarto ?></li>
														<?php } ?>

														<?php if (isset($objAnuncio->banheiro)&&$objAnuncio->banheiro>0) { ?>
															<li><strong>Banheiros:</strong><?php echo $objAnuncio->banheiro ?></li>
														<?php } ?>

														<?php if (isset($objAnuncio->espaco)&&$objAnuncio->espaco!='') { ?>
															<li><strong>Espaço:</strong><?php echo $objAnuncio->espaco.'m²' ?></li>
														<?php } ?>
													</ul>
												</div>
											
												<div class="listing-footer-wrapper">
													<div class="listing-price">
														<h4 class="list-pr">R$<?php echo number_format($valorAnuncio, 0 , ',', '.') ?>/<?php echo $objAnuncio->TipoCobranca->nome ?></h4>
													</div>
													<div class="listing-detail-btn">
														<a href="<?php echo URL.'anuncio/'.$objAnuncio->dns.'/'.$objAnuncio->id.'/' ?>" class="more-btn">Mais informações</a>
													</div>
												</div>
												
											</div>
											
										</div>
									<?php 
								}
							?>
						</div>				
						
					</div>


					
					<!-- Pagination -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<ul class="pagination p-center">
								<?php 
									function sanitizeString($string) {
			                            // matriz de entrada
			                            $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',',',';',':','|','!','"','~','^','>','<','ª','º' );

			                            // matriz de saída
			                            $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_' );

			                            // devolver a string
			                            return str_replace($what, $by, $string);
			                        }

			                        $pagTotal = ceil($retAnuncioTotal->count() / $mostrar); 
			                        $pagTotal = $pagTotal==0?1:$pagTotal;
			                        $pagina   = isset($_GET['pag'])&&$_GET['pag']>0?$_GET['pag']:1;


			                        // Testa para desabilitar caso esteja no inicio ou final
			                        $numAnt     = intval($pagina)-1;
			                        $numProx    = intval($pagina)+1;
			                        $linkAnt    = isset($pagina)&&$pagina!=1?URL.'anuncios?pag='.$numAnt:'#';
			                        $linkProx   = isset($pagina)&&$pagina!=$pagTotal?URL.'anuncios?pag='.$numProx:'#';
			                        // echo $linkAnt;
			                        // Valida para que mostre apenas 6 páginas
			                        $inicio     = isset($pagina)&&$pagina>3?$pagina-3:1;
			                        $fim        = !isset($pagina)||$pagTotal<=6?$pagTotal:6;
			                        $fim        = isset($pagina)&&$pagTotal>$pagina+3?$pagina+3:$fim;
								?>
									<li class="page-item">
									  <a class="page-link <?php echo isset($pagina)&&$pagina!=1?'':'disabled'; ?>" href="<?php echo $linkAnt.$urlComplementar ?>" aria-label="Previous">
										<span class="ti-arrow-left"></span>
										<span class="sr-only">Previous</span>
									  </a>
									</li>
									<?php 
		                            for ($i=$inicio; $i <= $fim; $i++) { 
		                                ?><li class="page-item <?php if(isset($pagina)&&$pagina==$i) echo "active" ?>"><a href="<?php echo URL.'anuncios?pag='.$i.$urlComplementar ?>"><?php echo $i ?></a></li><?php
		                            } 
		                            ?>
									<li class="page-item">
									  <a class="page-link <?php echo isset($pagina)&&$pagina!=$pagTotal?'':'disabled'; ?>" href="<?php echo $linkProx.$urlComplementar ?>" aria-label="Next">
										<span class="ti-arrow-right"></span>
										<span class="sr-only">Next</span>
									  </a>
									</li>

							</ul>
						</div>
					</div>
			
				</div>
				
				<!-- property Sidebar -->
				
			</div>
		</div>	
	</section>

<?php
  	$obContent = ob_get_contents();
  	ob_end_clean();
  	include('base.php');
?>

<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskMoney.js"></script>

<script type="text/javascript">
	setTimeout(function() {
		$(".valor-input").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	}, 1000);

	
     $("#estado_id").change(function(){
        // alert("ae");
        if($(this).val()){
            $("#cidade_id").html('<option value="">Carregando...</option>');
            $.getJSON("<?php echo URL_ADMIN ?>getCidades.php",{estado_id: jQuery(this).val()}, function(j){
                var options = '<option value="">Selecione</option>';
                for (var i = 0; i < j.length; i++){
                    options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';

                }
                $("#cidade_id").html(options);

            });
        } else {
            $("#cidade_id").html('<option value="">Selecione um estado</option>');
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

            var formulario = document.getElementById('formulario-data');
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

                    	$('.hero-search-content #dataEntrada').html(response.data_entrada);
                    	$('.hero-search-content #dataSaida').html(response.data_saida);

                    	if (response.totalDiarias>1) {
                    		$qtdDiarias = response.totalDiarias+' diárias';
                    	} else {
                    		$qtdDiarias = response.totalDiarias+' diária';
                    	}

                    	$('.hero-search-content #TotalDias').html($qtdDiarias);
                    	// $('.hero-search-content #dataEntradaHorario').html(response.data_entrada_horario);
						location.reload();
                    	// $('.hero-search-content #dataSaidaHorario').html(response.data_saida_horario);

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
</script>