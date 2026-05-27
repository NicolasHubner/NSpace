<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader = 'light';

  	if (!isset($_GET['id'])) {
  		header('Location: '.URL.'painel/minhas-propriedades/');
  	}
	if($_GET['tipo']=='reserva'){
		$objReserva = Doctrine_Core::getTable('Reserva')->find($_GET['id']);
	}else{
		$objAnuncio = Doctrine_Core::getTable('Anuncio')->find($_GET['id']);
		$objPlano = Doctrine_Core::getTable('Plano')->find($objAnuncio->plano_id);
	}
?>
	<?php if($pagseguroAmbiente=='sandbox'){ ?>
		<?php $codigoPlano = isset($objPlano->pagseguro_sandbox)&&$objPlano->pagseguro_sandbox!=''?$objPlano->pagseguro_sandbox:null ?>
		<!-- SANDBOX -->
		<script async defer type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
	<?php } else { ?>
		<?php $codigoPlano = isset($objPlano->pagseguro_production)&&$objPlano->pagseguro_production!=''?$objPlano->pagseguro_production:null ?>
		<!-- PRODUÇÃO -->
		<script async defer type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
	<?php } ?>

	<section class="tela-pagamento">
		<div class="container">
			<div class="text-center">
				<?php if($_GET['tipo']=='reserva'){ ?>
					<h3>Pagamento da reserva</h3>
					<p>Realize o pagamento para confirmação da sua reserva.</p>
				<?php }else{ ?>
					<h3>Plano de destaque</h3>
					<p>Confirme os dados do seu cartão para liberar seu plano de impulsionamento.</p>
				<?php } ?>
			</div>

			<div class="dadosInformativos">
				<div class="row">
						
					<?php if($_GET['tipo']=='reserva'){ ?>
						<div class="col-md-2">
						</div>
					<?php }else{ ?>
						<div class="col-md-4">
									
							<div class="dados-plano">
								<div class="pricing-wrap <?php echo isset($objPlano->recomendavel)&&$objPlano->recomendavel==1?'recomendavel':'' ?>">
									<?php echo isset($objPlano->recomendavel)&&$objPlano->recomendavel==1?'<div class="planoRecomendavel">Plano recomendável</div>':'' ?>
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
								</div>
							</div>
						</div>	
					<?php } ?>

					<div class="col-md-8">
						<form class="formAssinatura">
							<div class="steps">
								<div class="text-center mb-20">
									<img class="bandeira-pagamento" src="<?php echo URL_IMAGES ?>bandeiras.jpg">
								</div>
								<div class="step step1 active">

									<div class="form-row">
										<div class="col-md-12">
											<label>Número do cartão:</label>
											<input type="text" name="cartao_numero" id="cartao_numero" class="form-control" data-mask="9999 9999 9999 9999">
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-12">
											<label>Nome do titular:</label>
											<input type="text" name="cartao_titular" id="cartao_titular" class="form-control">
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-7">
											<label>Data de validade: (Mês/Ano)</label>
											<input type="text" name="cartao_validade" id="cartao_vencimento" class="form-control" data-mask="99/9999">
										</div>

										<div class="col-md-5">
											<label>Código de segurança:</label>
											<input type="text" name="cartao_codigo" id="cartao_cvv" class="form-control" data-mask="999">
										</div>
									</div>
									

									<?php if($_GET['tipo']=='reserva'){ ?>
										<div class="form-row">
											<div class="col-md-12">
												<label>Parcelamento: <a href="#" class="tip-topdata" data-tip="As condições de parcelamento aparecem a partir do cartão inserido."><i class="ti-help"></i></a></label>
												<select name="parcelamento" id="parcelamento" data-live-search="true" data-width="100%"	data-toggle="tooltip" class="form-control">
													<option value="0">1x de R$<?php echo number_format($objReserva->valor_total, 2, ',', '.') ?></option>
												</select>
											</div>
										</div>
									
									<?php }else{ ?>
										<input type="hidden" id="parcelamento" name="parcelamento" value="" >
									<?php } ?>
									<div class="form-row">
										<div class="col-md-12">
											<input type="button" class="btn-default btn-proximo" value="Próximo">
										</div>
									</div>
								</div>

								<div class="step step2">

									<div class="form-row">
										<div class="col-md-7">
											<label>CPF:</label>
											<input type="text" name="cpf" id="cpf" class="form-control" data-mask="999.999.999-99">
										</div>

										<div class="col-md-5">
											<label>Data de Nascimento:</label>
											<input type="text" name="data_nascimento" id="data_nascimento" class="form-control" data-mask="99/99/9999">
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-7">
											<label>Telefone:</label>
											<input type="text" name="telefone" id="telefone" class="form-control" data-mask="(99) 99999-9999">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<input type="button" class="btn-default btn-proximo" value="Próximo">
										</div>
									</div>
								</div>
								
								<div class="step step3">
									<div class="form-row">
										<div class="col-md-6">
											<label>CEP:</label>
											<input type="text" name="cep" id="cep" class="form-control" data-mask="99999-999">
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<label>Endereço:</label>
											<input type="text" name="logradouro" id="logradouro" class="form-control">
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-6">
											<label>Número:</label>
											<input type="text" name="numero" id="numero" class="form-control">
										</div>
										<div class="col-md-6">
											<label>Complemento:</label>
											<input type="text" name="complemento" id="complemento" class="form-control">
										</div>
									</div>

									<div class="form-row">
										<div class="col-md-12">
											<label>Bairro</label>
											<input type="text" name="bairro" id="bairro" class="form-control">
										</div>
									</div>


									<div class="form-row">
										<div class="col-md-4">
											<label>Estado:</label>
											<select name="estado_id" id="estado_id" data-live-search="true" data-width="100%"	data-toggle="tooltip" class="form-control">
													<option value="">Estado</option>
													<?php
													try {

															$resAtiv = Doctrine_Query::create()->select()->from('Estado')->execute();

															if ($resAtiv->count() > 0) {
																	$resAtiv->toArray();

																	foreach ($resAtiv as $value) {
																			$selected = $value['id']==$objCliente->estado_id?"selected":"";
																			echo '<option value="' . $value['id'] . '" '.$selected.'>' . $value['sigla'] . '</option>';
																	}
															} else {
																	echo '<option value="">Nenhum registro encontrado</option>';
															}
													} catch (Exception $e) {
															echo '<option value="">Ocorreu um erro de sistema</option>';
													}
													?>
											</select>
										</div>
										
										<div class="col-md-8">
											<label>Cidade:</label>
											<select class='form-control' data-live-search="true" data-width="100%" data-toggle="tooltip" name="cidade_id" id='cidade_id'>
												<option value="">Selecione o estado</option>
											</select>
										</div>
									</div>
										<div class="form-row">
											<div class="col-md-12">
												<input type="hidden" name="id" id="id" value="<?php echo isset($_GET['id'])&&$_GET['id']!=''?$_GET['id']:'' ?>">
												<input type="hidden" name="plano" id="plano" value="<?php echo isset($codigoPlano)&&$codigoPlano!=''?$codigoPlano:'' ?>">
												<input type="hidden" name="valor" id="valor" value="<?php echo isset($objReserva->valor_total)&&$objReserva->valor_total!=''?$objReserva->valor_total:'' ?>">
												<input type="hidden" name="tipo" id="tipo" value="<?php echo isset($_GET['tipo'])&&$_GET['tipo']!=''?$_GET['tipo']:'' ?>">
												<input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo isset($_SESSION['sess_cliente_id'])&&$_SESSION['sess_cliente_id']!=''?$_SESSION['sess_cliente_id']:'' ?>">
												
												<?php if (isset($_GET['tipo'])&&$_GET['tipo']=='reserva') { ?>
													<input type="button" class="btn-default btn-assinar" value="Efetuar Pagamento">
												<?php } else { ?>
													<input type="button" class="btn-default btn-assinar" value="Assinar agora">
												<?php }  ?>
											</div>
										</div>
									</div>
								</div>
								
								<div class="text-center mt-40">
									<img class="bandeira-selo" src="<?php echo URL_IMAGES ?>selo-seguro.jpg">
								</div>
							</div>	
						</form>
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
	
<?php
	$obContent = ob_get_contents();
	ob_end_clean();
	include('base.php');
?>

<script src="<?= URL."assets/js/getCep.js" ?>"></script>
<script src="<?= URL."assets/js/pagamento.js" ?>"></script>
<script>
	let payment = new Payment();
	payment.generateSession()
	// payment.generateHash()
	payment.installmentsElement = $('#parcelamento')

	let currentStep = 1
	$('.btn-proximo').click(()=>{
		loadForm()

		if(currentStep == 1 && validateStep1()){
			currentStep++
			presentCurrentStep()	
		}

		if(currentStep == 2 && validateStep2()){
			currentStep++
			presentCurrentStep()	
		}

	})

	$('.btn-assinar').click(()=>{
		loadForm()
		validateStep3()
		loading()
	})

	$('.btn-voltar').click(()=>{
		currentStep--
		presentCurrentStep()
	})

	$('#cartao_numero').on('keyup', ()=>{
		loadForm()
		payment.getBrand()
	})

	const presentCurrentStep = ()=>{
		$('.step').removeClass('active')
		$('.step'+currentStep).addClass('active')
	}

	const loadForm = (step = null)=>{
		payment.form.plano = $('#plano').val()
		payment.form.id = $('#id').val()
		payment.form.tipo = $('#tipo').val()
		payment.form.valor = $('#valor').val()
		payment.form.telefone = $('#telefone').val()
		payment.form.selectedInstallment = $('#parcelamento').val()
		if(!step || step == 1){
			payment.form.cartao = {
				nome: $('#cartao_titular').val(),
				numero: $('#cartao_numero').val(),
				bandeira: payment.form.cartao.bandeira,
				cvv: $('#cartao_cvv').val(),
				vencimento: $('#cartao_vencimento').val(),
			}
		}
		if(!step || step == 2){
			payment.form.cpf = $('#cpf').val()
			payment.form.data_nascimento = $('#data_nascimento').val()
		}
		if(!step || step == 3){
			payment.form.endereco = {
				cep: $('#cep').val(),
				logradouro: $('#logradouro').val(),
				numero: $('#numero').val(),
				complemento: $('#complemento').val(),
				bairro: $('#bairro').val(),
				cidade_id: $('#cidade_id').val(),
				estado_id: $('#estado_id').val()
			}
		}
	}

	const validateStep1 = ()=>{
		return payment.validateCard()
	}
	const validateStep2 = ()=>{
		return payment.cpfIsValid() && $('#data_nascimento').val().length == 10
	}
	const validateStep3 = ()=>{
		if(payment.validAddress()){
			payment.generateCardToken()
		}
		// return 
	}

	const loading = ()=> {
		$('.dadosInformativos').css('display','none');
		$('.loadingadmins').css('display','block');
	}
</script>