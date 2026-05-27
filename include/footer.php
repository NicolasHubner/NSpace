<?php if (isset($objConfiguracao->whatsapp)&&$objConfiguracao->whatsapp!='') { ?>
    <a href="https://api.whatsapp.com/send?phone=55<?php echo Util::getNumbers($objConfiguracao->whatsapp) ?>"
        target="in_blank">
        <div class="whatsapp buttonFlutuante">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32"
                class="wh-messenger-svg-whatsapp wh-svg-icon">
                <path
                    d=" M19.11 17.205c-.372 0-1.088 1.39-1.518 1.39a.63.63 0 0 1-.315-.1c-.802-.402-1.504-.817-2.163-1.447-.545-.516-1.146-1.29-1.46-1.963a.426.426 0 0 1-.073-.215c0-.33.99-.945.99-1.49 0-.143-.73-2.09-.832-2.335-.143-.372-.214-.487-.6-.487-.187 0-.36-.043-.53-.043-.302 0-.53.115-.746.315-.688.645-1.032 1.318-1.06 2.264v.114c-.015.99.472 1.977 1.017 2.78 1.23 1.82 2.506 3.41 4.554 4.34.616.287 2.035.888 2.722.888.817 0 2.15-.515 2.478-1.318.13-.33.244-.73.244-1.088 0-.058 0-.144-.03-.215-.1-.172-2.434-1.39-2.678-1.39zm-2.908 7.593c-1.747 0-3.48-.53-4.942-1.49L7.793 24.41l1.132-3.337a8.955 8.955 0 0 1-1.72-5.272c0-4.955 4.04-8.995 8.997-8.995S25.2 10.845 25.2 15.8c0 4.958-4.04 8.998-8.998 8.998zm0-19.798c-5.96 0-10.8 4.842-10.8 10.8 0 1.964.53 3.898 1.546 5.574L5 27.176l5.974-1.92a10.807 10.807 0 0 0 16.03-9.455c0-5.958-4.842-10.8-10.802-10.8z"
                    fill-rule="evenodd"></path>
            </svg>
        </div>
    </a>
<?php } ?>
<footer class="dark-footer skin-dark-footer">
	<div>
		<div class="container">
			<div class="row">
				
				<div class="col-lg-3 col-md-4">
					<div class="footer-widget">
						<img src="<?php echo URL_IMAGES ?>logo_white.png" class="img-footer">
						<div class="footer-add">
							<?php if (isset($objConfiguracao->telefone)&&$objConfiguracao->telefone!='') { ?>
                                <p><a href="tel:55<?php echo Util::getNumbers($objConfiguracao->telefone) ?>"><i class="fal fa-phone"></i> <?php echo $objConfiguracao->telefone ?></a></p>
                            <?php } ?>

                            <?php if (isset($objConfiguracao->whatsapp)&&$objConfiguracao->whatsapp!='') { ?>
                                <p><a href="https://api.whatsapp.com/send?phone=55<?php echo Util::getNumbers($objConfiguracao->whatsapp) ?>" target="in_blank"><i class="fal fa-phone"></i> <?php echo $objConfiguracao->whatsapp ?></a></p>
                            <?php } ?>

                             <?php if (isset($objConfiguracao->email)&&$objConfiguracao->email!='') { ?>
                                <p><a href="mailto:<?php echo $objConfiguracao->email ?>" target="in_blank" style="text-transform: initial;"><?php echo $objConfiguracao->email ?></a></p>
                            <?php } ?>

							<?php
                                if (isset($objConfiguracao->estado_id) && $objConfiguracao->estado_id != '') {
                                    $enderecoComp = isset($objConfiguracao->logradouro) && $objConfiguracao->logradouro != ''?$objConfiguracao->logradouro : '';
                                    $enderecoComp .= isset($objConfiguracao->numero) && $objConfiguracao->numero!=''?' '.$objConfiguracao->numero : '';
                                    $enderecoComp .= isset($objConfiguracao->complemento) && $objConfiguracao->complemento!=''?' <br>'. $objConfiguracao->complemento : '';
                                    $enderecoComp .= isset($objConfiguracao->bairro) && $objConfiguracao->bairro != '' ? ' - ' . $objConfiguracao->bairro.' - ' : '';
                                    $enderecoComp .= isset($objConfiguracao->cidade_id) && $objConfiguracao->cidade_id != '' ? $objConfiguracao->Cidade->nome : '';
                                    $enderecoComp .= isset($objConfiguracao->estado_id) && $objConfiguracao->estado_id != '' ? '/' . $objConfiguracao->Estado->sigla : '';
                                    ?>
										<p><?php echo $enderecoComp ?></p>
									<?php
                                }
                            ?>
						</div>
					</div>
				</div>		
				<div class="col-lg-3 col-md-4">
					<div class="footer-widget">
						<h4 class="widget-title">Navegação</h4>
						<ul class="footer-menu">
							<li><a href="<?php echo URL ?>afiliados/">Afiliados</a></li>
							<li><a href="<?php echo URL ?>quem-somos/">Quem somos</a></li>
							<li><a href="<?php echo URL ?>anuncios/">Pesquisa</a></li>
							<li><a href="<?php echo URL ?>artigos/">Últimos artigos</a></li>
						</ul>
					</div>
				</div>
						
				<div class="col-lg-3 col-md-4">
					<div class="footer-widget">
						<h4 class="widget-title">Mais Recentes</h4>
						<ul class="footer-menu">
							<?php 
								$retCategoria = Doctrine_Query::create()->select()->from('Categoria')->limit(4)->execute();
								foreach ($retCategoria as $objCategoria) {
									?>
										<li><a href="<?php echo URL.'anuncios/?categoria_id='.$objCategoria->id ?>"><?php echo $objCategoria->nome ?></a></li>
									<?php 
								}
							?>
						</ul>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6">
					<div class="footer-widget">
						<h4 class="widget-title">Minha Conta</h4>
						<ul class="footer-menu">
							<li><a href="<?php echo URL.'painel/meu-perfil/' ?>">Meu perfil</a></li>
							<li><a href="<?php echo URL.'painel/meus-favoritos/' ?>">Meus favoritos</a></li>
							<li><a href="<?php echo URL.'painel/minhas-propriedades/' ?>">Minhas propriedades</a></li>
							<li><a href="<?php echo URL.'painel/alterar-senha/' ?>">Alterar Senha</a></li>
						</ul>
					</div>
				</div>				
			</div>
		</div>
	</div>
	
	<div class="footer-bottom">
		<div class="container">
			<div class="row align-items-center">
				
				<div class="col-lg-4 col-md-4">
					<p class="mb-0">Desenvolvido por <a href="https://www.acessoweb.com/" target="in_blank">ACESSOWEB DESIGN</a></p>
				</div>
				
				<div class="col-lg-4 col-md-4 text-center">
					<ul class="footer-bottom-social">
						<?php if (isset($objRedeSocial->facebook)&&$objRedeSocial->facebook!='') { ?>
							<li><a href="<?php echo $objRedeSocial->facebook ?>" target="in_blank"><i class="fab fa-facebook"></i></a></li>
						<?php } ?>

						<?php if (isset($objRedeSocial->instagram)&&$objRedeSocial->instagram!='') { ?>
							<li><a href="<?php echo $objRedeSocial->instagram ?>" target="in_blank"><i class="fab fa-instagram"></i></a></li>
						<?php } ?>

						<?php if (isset($objRedeSocial->youtube)&&$objRedeSocial->youtube!='') { ?>
							<li><a href="<?php echo $objRedeSocial->youtube ?>" target="in_blank"><i class="fab fa-youtube"></i></a></li>
						<?php } ?>

						<?php if (isset($objRedeSocial->linkedin)&&$objRedeSocial->linkedin!='') { ?>
							<li><a href="<?php echo $objRedeSocial->linkedin ?>" target="in_blank"><i class="fab fa-linkedin"></i></a></li>
						<?php } ?>
					</ul>
				</div>

				<div class="col-lg-4 col-md-4 text-right">
					<ul class="footer-bottom-social mesma-linha">
						<li><a href="<?php echo URL ?>termos-de-uso/">Termos de Uso</a></li>
						<li><a href="<?php echo URL ?>politica-de-privacidade/">Política de Privacidade</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
<style>
    .whatsapp {
        position: fixed;
        right: 4%;
        bottom: 3%;
        background-color: #4dc247;
        height: 65px;
        width: 65px;
        border-radius: 100%;
        overflow: hidden;
        padding: 5px;
        z-index: 999;
        cursor: pointer;
        text-align: center;
    }

    .whatsapp svg {
        fill: #fff;
    }
</style>