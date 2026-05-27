<div class="image-cover hero-banner" style="background:url('<?php echo URL ?>images/banner/slide001.png') no-repeat;" data-overlay="6">
	<div class="container">

		<h1 class="big-header-capt mb-0">Encontre Seu Espaço Ideal</h1>
		<p class="text-center mb-5">Diárias a partir de R$30 com oferta por tempo limitado</p>
		
		<div class="full-search-2 eclip-search italian-search hero-search-radius">
			<div class="hero-search-content">
				<form method="get" action="<?php echo URL ?>anuncios/">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-12 small-padd">
							<div class="form-group">
								<div class="input-with-icon">
									<input type="text" class="form-control" placeholder="Localização" id="cidade-search">
									<i class="ti-location-pin"></i>
								</div>
								<div class="AutoComplete" id="listaCidades"></div>
							</div>
						</div>

						<div class="col-lg-3 col-md-3 col-sm-12 small-padd">
							<div class="form-group">
								<div class="input-with-icon b-l">
									<select id="categorias" class="form-control"  name="categoria_id" style="-webkit-appearance: none !important;">
										<option value="">Selecione sua Categoria</option>
										<?php 
	                                    	$retCategoria = Doctrine_Query::create()->select()->from('Categoria')->where('status = 1')->orderBy('ordem ASC')->execute();
	                                    	foreach ($retCategoria as $objCategoria) {
	                                            ?>
	                                            	<option value="<?php echo $objCategoria->id ?>"><?php echo $objCategoria->nome ?></option>
	                                            <?php 
	                                        }
	                                    ?>
									</select>
									<i class="ti-briefcase"></i>
								</div>
							</div>
						</div>
						
						
						<div class="col-lg-4 col-md-4 col-sm-12 small-padd">
							<div class="form-group dataJaSelecionada" <?php echo isset($_SESSION['reserva'])&&$_SESSION['reserva']!=''?'style="display:block;"':'' ?>>
								<div class="row">
									<div class="col-md-6">
										<label>Data de entrada:</label>
										<span><span id="dataEntrada"><?php echo isset($_SESSION['reserva']['data_entrada'])&&$_SESSION['reserva']['data_entrada']!=''?$_SESSION['reserva']['data_entrada']:'' ?></span></span>
									</div>

									<?php if (isset($_SESSION['reserva']['tipo_cobranca_id'])&&$_SESSION['reserva']['tipo_cobranca_id']==2) { ?>
										<div class="col-md-6">
											<label>Data de saída:</label>
											<span><span id="dataSaida"><?php echo isset($_SESSION['reserva']['data_saida'])&&$_SESSION['reserva']['data_saida']!=''?$_SESSION['reserva']['data_saida']:'' ?></span></span>
										</div>
									<?php } else { ?>
										<div class="col-md-6">
											<label>H. Entrada/Saída:</label>
											<span><span class="horario_entrada"><?php echo isset($_SESSION['reserva']['horario_entrada'])&&$_SESSION['reserva']['horario_entrada']!=''?$_SESSION['reserva']['horario_entrada']:'' ?></span></span> as <span class="horario_saida"><?php echo isset($_SESSION['reserva']['horario_saida'])&&$_SESSION['reserva']['horario_saida']!=''?$_SESSION['reserva']['horario_saida']:'' ?></span> <i class="fal fa-pencil iconEditDate"></i></span>
										</div>
									<?php } ?>
								</div>
							</div>

							<div class="form-group SelecDate" <?php echo isset($_SESSION['reserva'])&&$_SESSION['reserva']!=''?'style="display:none;"':'' ?>>
								<div class="input-with-icon b-l">
									<input type="text" class="form-control" placeholder="Selecione uma data" id="selecionar-data">
									<i class="ti-calendar"></i>
								</div>
							</div>
						</div>
						
						<div class="col-lg-2 col-md-2 col-sm-12 small-padd">
							<div class="form-group">
								<input type="hidden" name="cidade_id" id="cidade_id">
								<input type="hidden" name="estado_id" id="estado_id">
								<input type="hidden" name="tipo_cobranca_id" id="tipo_cobranca_id" value="<?php echo isset($_SESSION['reserva']['tipo_cobranca_id'])&&$_SESSION['reserva']['tipo_cobranca_id']!=''?$_SESSION['reserva']['tipo_cobranca_id']:'' ?>">
								<input type="submit" class="btn search-btn" value="Pesquisar">
							</div>
						</div>
					</div>
				</form>				
			</div>
		</div>
			
	</div>
</div>