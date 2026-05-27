<?php
  	include('lib/Config.php');
  	ob_start();

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
  
    $tipoHeader = 'light';

    if (!isset($_GET['id'])) {
        header('Location: '.URL.'anuncios/');
    }

    $objReserva 	=	Doctrine_Core::getTable('Reserva')->find($_GET['id']);

	$whereData = 'anuncio_id = '.$objReserva->Anuncio->id.' and data_alterada = "'.$objReserva->data_entrada.'"';
  	$objAnuncioDataPersonalizada 		= Doctrine_Query::create()->select()->from('AnuncioDataPersonalizada')->where($whereData)->execute();
  	if ($objAnuncioDataPersonalizada->count()>0) {
  		$objAnuncioDataPersonalizada = $objAnuncioDataPersonalizada[0];

  		$valorAnuncio = $objAnuncioDataPersonalizada->valor;
  	} else {
  		$valorAnuncio = $objReserva->Anuncio->valor;
  	}
?>


	<div class="page-section paginaPadrao">
		<div class="container">
			<div class="titulo-pagina text-center">
				<h3>Esperamos por você aqui!</h3>
				<p>Sua reserva está quase confirmada! Precisamos agora que você revise os dados de pagamento.</p>
			</div>

			<div class="detalheReserva">
				<div class="row">
					<div class="col-md-6">
						<div class="imagem">
							<img src="<?php echo URL_ANUNCIO.$objReserva->Anuncio->imagem ?>">
						</div>

						<div class="thumbImg">
							<div class="row">
								<?php 
									$retAnuncioFoto = Doctrine_Query::create()->select()->from('AnuncioFoto')->where('anuncio_id = '.$objReserva->anuncio_id)->execute();
									foreach ($retAnuncioFoto as $objAnuncioFoto) {
										?>
											<div class="col-md-3">
												<div class="single-imagem">
													<img src="<?php echo URL_ANUNCIO.$objAnuncioFoto->imagem ?>">
												</div>
											</div>
										<?php
									}
								?>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="dadosReserva">
							<div class="blocoInfo">
								<h3>Dados do Espaço:</h3>
								
								<div class="bloco">
									<label>Título:</label> <?php echo $objReserva->Anuncio->titulo ?>
								</div>

								<div class="bloco">
									<label>Limite de pessoas:</label> <?php echo $objReserva->Anuncio->limite_pessoas ?>
								</div>

								<?php if (isset($objReserva->Anuncio->codigo)&&$objReserva->Anuncio->codigo!='') { ?>
									<div class="bloco">
										<label>Cód. do espaço:</label> <?php echo $objReserva->Anuncio->codigo ?>
									</div>
								<?php } ?>

								<div class="bloco">
									<label>Garagem:</label> <?php echo $objReserva->Anuncio->garagem ?>
								</div>

								<div class="bloco">
									<label>Quartos:</label> <?php echo $objReserva->Anuncio->quarto ?>
								</div>

								<div class="bloco">
									<label>Banheiro:</label> <?php echo $objReserva->Anuncio->banheiro ?>
								</div>

								<div class="bloco">
									<label>Valor:</label> <?php echo 'R$'.number_format($valorAnuncio, 0, ',', '.') ?><span style="color: #72809d;font-size: 16px;">/<?php echo $objReserva->Anuncio->TipoCobranca->nome ?></span>
								</div>
							</div>

							<div class="blocoInfo">
								<h3>Dados do cliente:</h3>
								
								<div class="bloco">
									<label>Nome:</label> <?php echo $objReserva->Cliente->nome ?>
								</div>

								<div class="bloco">
									<label>E-mail:</label> <?php echo $objReserva->Cliente->email ?>
								</div>

								<div class="bloco">
									<label>Whatasapp:</label> <?php echo $objReserva->Cliente->telefone ?>
								</div>
							</div>

							<div class="blocoInfo">
								<h3>Dados da reserva:</h3>

								<div class="bloco">
									<label>ID da reserva:</label> <?php echo '#'.$objReserva->id; ?>
								</div>

								<div class="bloco">
									<label>Data da reserva:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_cadastro)); ?>
								</div>

								<div class="bloco">
									<label>Data de entrada:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_entrada)) ?>
								</div>

								<div class="bloco">
									<label>Data de saída:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_saida)) ?>
								</div>
								
								<?php if (isset($objReserva->Anuncio->tipo_cobranca_id)&&$objReserva->Anuncio->tipo_cobranca_id==2) { ?>

									<div class="bloco">
										<label>Tota de Diárias:</label> <?php echo $objReserva->qtd_dias ?>
									</div>

									<div class="bloco">
										<label>Valor:</label> <?php echo $objReserva->qtd_dias ?> x <?php echo 'R$'.number_format($valorAnuncio, 0, ',', '.') ?><span style="color: #72809d;font-size: 16px;"></span>
									</div>
								<?php } else { ?>
									<div class="bloco">
										<label>Horário entrada:</label> <?php echo date('H:i', strtotime($objReserva->horario_entrada)); ?>
									</div>

									<div class="bloco">
										<label>Horário saída:</label> <?php echo date('H:i', strtotime($objReserva->horario_saida)); ?>
									</div>

									<div class="bloco">
										<label>Qtde de horas alugada:</label> <?php echo $objReserva->hora_diferenca.' hora(s)' ?>
									</div>

									<div class="bloco">
										<label>Valor:</label> <?php echo $objReserva->hora_diferenca ?> vezes x <?php echo 'R$'.number_format($valorAnuncio, 0, ',', '.') ?><span style="color: #72809d;font-size: 16px;"></span>
									</div>
								<?php } ?>
							</div>

							<div class="blocoInfo text-center">
								<div class="dadosPagamento">
									<div class="titulo">
										<h4>Efetue o pagamento agora:</h4>

										<div class="valorTotal"><?php echo 'R$'.number_format($objReserva->valor_total, 2, ',', '.') ?></div>
									</div>

									<div class="pagamento">
										<a class="botaoPagamento addPagamento" href="<?php echo URL."pagamento/reserva/".$_GET['id'] ?>">Efetuar pagamento</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
  	$obContent = ob_get_contents();
  	ob_end_clean();
  	include('base.php');
?>