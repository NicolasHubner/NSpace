<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader = 'light';
  	if (!isset($_SESSION['sess_cliente_id'])) {
  		header('Location: '.URL.'?ref=cadastro');
  	}

	$objCliente = Doctrine_Core::getTable('Cliente')->find($_SESSION['sess_cliente_id']);

	if (isset($objCliente->tipo_cliente_id)&&$objCliente->tipo_cliente_id!=2) {
		header('Location: '.URL.'painel/dashboard/?refPopup=solicitacao');
	}
?>


	<div class="page-title bg-laranja">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-12 col-md-12">
	                <h2 class="ipt-title">Adicionar Espaço</h2>
	                <span style="font-family: Montserrat; font-size: 20px;">Preencha os campos para adicionar seu espaço</span>
	            </div>
	        </div>
	    </div>
	</div>

	<section class="modelCriacaoPropriedade">
      	<div class="container">
      		<div class="formularioPasso">
      			<div class="guiaForm" id="ponto-inicial">
      				<li class="mr-30"><a id='passo-01' class="ative" href="javascript:void(0);"><span class="circleItem">1</span> Dados do espaço</a></li>
      				<li class="mr-30"><a id='passo-02' class="inativo" href="javascript:void(0);"><span class="circleItem">2</span> Localização</a></li>
      				<li class="mr-30"><a id='passo-03' class="inativo" href="javascript:void(0);"><span class="circleItem">3</span> Fotos</a></li>
      				<li><a class="inativo" id='passo-04' href="javascript:void(0);"><span class="circleItem">4</span> Documentações</a></li>
      			</div>

      			<div class="passo-01">
      				<?php include('area-cliente/formulario/passo01.php'); ?>
      			</div>

                <div class="passo-02">
                    <?php include('area-cliente/formulario/passo02.php'); ?>
                </div>

                <div class="passo-03 formPasso03">
                    <?php include('area-cliente/formulario/passo03.php'); ?>
                </div>

                <div class="passo-04">
                    <?php include('area-cliente/formulario/passo04.php'); ?>
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
                <h4 id="TitleEspaço">Definindo dados do espaço</h4>
                <h4 id="TitleLoc" style="display: none;">Configurando localização</h4>
                <h4 id="TitleFotos" style="display: none;">Adicionando as fotos</h4>
                <h4 id="TitleDoc" style="display: none;">Salvando documentações e finalizando cadastro</h4>
            </div>

            <div class="retornoNotif success text-center mt-20">
              <i class="fas fa-check"></i>
              <h4>Sua propriedade foi enviada com sucesso</h4>
              <p>Estamos analisando os dados da sua propriedade. Após a aprovação será publicada!</p>             
              <a class="btn btn-success" href="<?php echo URL.'painel/' ?>minhas-propriedades/">Ir para minha propriedades</a>
            </div>
      	</div>
  	</section>

<?php
  	$obContent = ob_get_contents();
  	ob_end_clean();
  	include('base.php');
?>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskMoney.js"></script>
<script type="text/javascript" src="<?php echo URL ?>assets/js/propriedade-cadastrar.min.js"></script>
