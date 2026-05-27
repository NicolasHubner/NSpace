<div class="header <?php echo isset($tipoHeader)&&$tipoHeader=='light'?'header-light':'header-transparent' ?> change-logo">
	<div class="container">
		<nav id="navigation" class="navigation navigation-landscape">
			<div class="nav-header">
				<a class="nav-brand static-logo" href="<?php echo URL ?>"><img src="<?php echo URL_IMAGES ?>logo.png" class="logo" alt="" /></a>
				<a class="nav-brand fixed-logo" href="<?php echo URL ?>"><img src="<?php echo URL_IMAGES ?>logo.png" class="logo" alt="" /></a>
				<div class="nav-toggle"></div>
			</div>
			<div class="nav-menus-wrapper" style="transition-property: none;">
				<ul class="nav-menu">
					<li><a href="<?php echo URL ?>">Home</a></li>
					<li><a href="<?php echo URL ?>afiliados/">Afiliados</a></li>
					<li><a href="<?php echo URL ?>quem-somos/">Quem somos</a></li>
					<li><a href="<?php echo URL ?>anuncios/">Pesquisa</a></li>
				</ul>

				
				<?php if (isset($_SESSION['sess_cliente_id'])&&$_SESSION['sess_cliente_id']!='') { 
					$objCliente = Doctrine_Core::getTable('Cliente')->find($_SESSION['sess_cliente_id']);
					?>
					<ul class="nav-menu nav-menu-social align-to-right drops-dashboard">
						<li class="add-listing theme-bg">
							<a href="<?php echo URL ?>criar-propriedade/">Adicionar um local</a>
						</li>
					    <li class="">
					        <div class="btn-group account-drop">
					        	<button type="button" class="btn btn-order-by-filt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: <?php echo isset($tipoHeader)&&$tipoHeader=='light'?'rgb(100, 115, 146)':'#fff' ?>;">
					        	<img id="imgHeaderPerfil" src="<?php echo isset($objCliente->imagem)&&$objCliente->imagem!=''?URL_CLIENTE.$objCliente->imagem:URL_IMAGES.'no-photo.png' ?>" class="avater-img" alt="">Bem vindo, <?php echo isset($objCliente->apelido)&&$objCliente->apelido!=''?$objCliente->apelido:$objCliente->nome ?>
					        	</button>
					            <div class="dropdown-menu pull-right animated flipInX">
					            	<a href="<?php echo URL.'painel/' ?>dashboard/"><i class="ti-layers"></i>Dashboard</a>
					            	<a href="<?php echo URL.'painel/' ?>meu-perfil/"><i class="ti-user"></i>Meu Perfil</a>
					            	<a href="<?php echo URL.'painel/' ?>alterar-senha/"><i class="ti-unlock"></i>Alterar Senha</a>
					                <a href="<?php echo URL ?>sair/"><i class="ti-power-off"></i>Sair</a>
					        	</div>
					        </div>
					    </li>
					</ul>
				<?php } else { ?>
					<ul class="nav-menu nav-menu-social align-to-right">
						<li class="add-listing theme-bg">
							<a href="<?php echo URL ?>criar-propriedade/">Adicionar um local</a>
						</li>

						<li>
							<a href="#" data-toggle="modal" data-target="#cadastro">
								Criar conta
							</a>
						</li>

						<li>
							<a href="#" data-toggle="modal" data-target="#login">
								<i class="fas fa-user-circle mr-1"></i>Login</a>
						</li>
					</ul>
				<?php } ?>
			</div>
		</nav>
	</div>
</div>
<!-- End Navigation -->
<div class="clearfix"></div>