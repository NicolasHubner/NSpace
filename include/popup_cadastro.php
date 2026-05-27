<?php 
	$FacebookRedirect = URL."callbackFacebook.php";
	$FacebookData = ['email'];
	$FacebookUrl = $handler->getLoginUrl($FacebookRedirect, $FacebookData);
?>
<div class="modal fade signup blocoCadastro" id="cadastro" tabindex="-1" role="dialog" aria-labelledby="sign-up" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
		<div class="modal-content" id="sign-up">
			<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
			<div class="modal-body">
                <div class="alert alert-danger mb-40" role="alert" style="display: none;">
                    <p id="alert-mensagem"></p>
                </div>
				<div class="dadosCadastro">
					<h4 class="modal-header-title">Cadastro</h4>

					<div class="displayMobile">
						<div class="modal-divider"><span>Cadastre-se via</span></div>
						<div class="social-login mb-3 ">
							<ul>
								<li><a href="javascript:void(0);" onclick="window.location = '<?php echo $FacebookUrl ?>'" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
								<li><a href="javascript:void(0);" class="g-signin2" data-onsuccess="onSignIn"><i class="ti-google"></i>Google</a></li>
							</ul>
						</div>
					</div>

					<div class="login-form">
						<form class="formCadastro" id="formulario-cadastro">
							<div class="row select-pessoa">
								<div class="col-lg-12 col-md-12 text-center">
									<label><input type="radio" name="tipo_pessoa_id" value="1" checked> Pessoa física</label>
									<label><input type="radio" name="tipo_pessoa_id" value="2"> Pessoa jurídica</label>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6 display-juridica">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="text" class="form-control validate[required] validaCNPJ" name="cnpj" data-mask="99.999.999/9999-99" placeholder="CNPJ">
											<i class="ti-user"></i>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6 display-fisica">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="text" class="form-control validate[required] validaPerfCPF" name="cpf" data-mask="999.999.999-99" placeholder="CPF">
											<i class="ti-user"></i>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="text" class="form-control validate[required] display-fisica" name="nome" placeholder="Nome Completo">
											<input type="text" class="form-control validate[required] display-juridica" name="razao_social" placeholder="Razão Social">
											<i class="ti-user"></i>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="text" class="form-control validate[required]" name="apelido" placeholder="Apelido">
											<i class="ti-user"></i>
										</div>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="email" class="form-control validate[required]" name="email" placeholder="E-mail">
											<i class="ti-email"></i>
										</div>
									</div>
								</div>

								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="text" class="form-control validate[required]" name="telefone" placeholder="Celular" data-mask="(99) 99999-9999">
											<i class="lni-phone-handset"></i>
										</div>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="password" class="form-control validate[required]" id="senhaValidar" name="senha" placeholder="Senha">
											<i class="ti-unlock"></i>
										</div>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="password" class="form-control validate[required,equals[senhaValidar]]" name="confirmar_senha" placeholder="Confirmar senha">
											<i class="lni-unlock"></i>
										</div>
									</div>
								</div>
							</div>
							
		                    <div class="form-row">
		                        <div class="form-group col-md-12">
		                          <label><input type="checkbox" name="termo" class="validate[required]" value="1"> Aceito os <a href="<?php echo URL ?>termos-de-uso/" target="in_blank">Termos de Uso</a> e <a href="<?php echo URL ?>politica-de-privacidade/" target="in_blank">Política de Privacidade</a> do Portal NSPACE</label>
		                        </div>
		                    </div>
							
							<div class="form-group">
								<?php  if (isset($_SESSION['codigoAfiliado'])&&$_SESSION['codigoAfiliado']!='') { 
									$objClienteAfiliado 	=  Doctrine_Core::getTable('Cliente')->findOneByCodigoAfiliado($_SESSION['codigoAfiliado']);
									?>
									<input type="hidden" name="afiliado_id" value="<?php echo $objClienteAfiliado->id ?>">
								<?php } ?>
								<input type="hidden" name="url" value="<?php echo isset($_GET['ref'])&&$_GET['ref']!=''?$_GET['anuncio_id']:'' ?>">
								<button type="submit" class="btn btn-md full-width pop-login">Cadastrar</button>
							</div>
						
						</form>
					</div>
					<div class="displayComputador">
						<div class="modal-divider"><span>Ou cadastre-se via</span></div>
						<div class="social-login mb-3 ">
							<ul>
								<li><a href="javascript:void(0);" onclick="window.location = '<?php echo $FacebookUrl ?>'" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
								<li><a href="javascript:void(0);" class="g-signin2" data-onsuccess="onSignIn"><i class="ti-google"></i>Google</a></li>
							</ul>
						</div>
					</div>
					<div class="text-center">
						<p class="mt-5"><i class="ti-user mr-1"></i>Você já tem uma conta? <a class="link linkLogin" href="#">Faça login</a></p>
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
		            <h4>Realizando cadastro</h4>
	          	</div>
			</div>
		</div>
	</div>
</div>