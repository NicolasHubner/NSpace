<?php 
	$FacebookRedirect = URL."callbackFacebook.php";
	$FacebookData = ['email'];
	$FacebookUrl = $handler->getLoginUrl($FacebookRedirect, $FacebookData);
?>
<div class="modal fade blocoLogin" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
		<div class="modal-content" id="registermodal">
			<span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
			<div class="modal-body">
				<div class="dadosAcesso">
					<h4 class="modal-header-title" style="margin-bottom: 30px !important;">Login</h4>
					<!-- <a class="outrosAcessos" id="acessoCPF" href="javascript:void(0)">Entrar com CPF</a> -->
					<a class="outrosAcessos" id="acessoEmail" href="javascript:void(0)">Entrar com E-mail</a>

					<div class="login-form">
						<form class="formLogin" id="formulario-login">
							<div class="form-group displayEmail">
								<label>E-mail</label>
								<div class="input-with-icon">
									<input type="email"  name="email" class="form-control validate[required]" placeholder="E-mail">
									<i class="ti-email"></i>
								</div>
							</div>

							<div class="form-group displayCPF">
								<label>CPF</label>
								<div class="input-with-icon">
									<input type="text"  name="cpf" class="form-control validaCPF validate[required]" placeholder="CPF" data-mask="999.999.999-99">
									<i class="ti-file"></i>
								</div>
							</div>
							
							<div class="form-group">
								<label>Senha</label>
								<div class="input-with-icon">
									<input type="password" name="senha" class="form-control validate[required]" placeholder="*******">
									<i class="ti-unlock"></i>
								</div>
							</div>
							
							<label><input type="checkbox" name="manter_logado" value="1"> Manter conectado</label>

							<div class="form-group">
								<!-- Tipos de acesso: 
									1 - E-mail
									2 - CPF 
								-->
								<input type="hidden" name="url" value="<?php echo isset($_GET['ref'])&&$_GET['ref']!=''?$_GET['anuncio_id']:'' ?>">
								<input type="hidden" class="tipo_acesso" name="tipo_acesso" value="1">
								<button type="submit" class="btn btn-md full-width pop-login">Login</button>
							</div>
						</form>
					</div>
					<div class="modal-divider"><span>Ou faça login por</span></div>
					<div class="social-login mb-3">
						<ul>
							<li><a href="javascript:void(0);" onclick="window.location = '<?php echo $FacebookUrl ?>'" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
							<li><a href="javascript:void(0);" class="g-signin2" data-onsuccess="onSignIn"><i class="ti-google"></i>Google</a></li>
							<!-- <li><a href="#" class="btn connect-google"><i class="ti-google"></i>Google</a></li> -->
						</ul>
					</div>
					<div class="text-center">
						<p class="mt-5"><i class="ti-user mr-1"></i>Você não possui uma conta? <a class="link linkCadastro" href="#">Cadastre-se agora</a></p>
						<p><a href="<?php echo URL ?>esqueci-minha-senha/" class="link" id="esqueciSenha">Esqueci minha senha</a></p>
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
		            <h4>Acessando...</h4>
	          	</div>
			</div>
		</div>
	</div>
</div>