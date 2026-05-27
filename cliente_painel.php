<?php
  	include('lib/Config.php');
  	ob_start();

  	$tipoHeader = 'light';
  	if (!isset($_SESSION['sess_cliente_id'])) {
  		header('Location: '.URL.'?ref=login');
  	}

	$objCliente = Doctrine_Core::getTable('Cliente')->find($_SESSION['sess_cliente_id']);
  $objTipoCliente = Doctrine_Core::getTable('TipoCliente')->find($objCliente->tipo_cliente_id);
?>

	<div class="page-title">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<h2 class="ipt-title">Área do cliente</h2>
					<span class="ipn-subtitle">Meu Painel</span>
				</div>
			</div>
		</div>
	</div>

	<section class="modelClientePainel">
    <div class="container-fluid">
       <div class="row">
          <div class="col-lg-3 col-md-4">
              <div class="dashboard-navbar">
                  <div class="d-user-avater">
                    <img id="sidebarImg" src="<?php echo isset($objCliente->imagem)&&$objCliente->imagem!=''?URL_CLIENTE.$objCliente->imagem:URL_IMAGES.'no-photo.png' ?>" class="img-fluid avater" alt="" />
                    <h4><?php echo isset($objCliente->apelido)&&$objCliente->apelido!=''?$objCliente->apelido:$objCliente->nome ?></h4>
                    <div class="tipoCliente"><?php echo $objTipoCliente->nome ?></div>
                    
                    <?php 
                      if (isset($objCliente->verificado)&&$objCliente->verificado==1) {
                        ?>
                          <span>Analisando documentos...</span>
                        <?php
                      } else if ($objCliente->verificado==2) {
                        ?>
                           <span style="font-weight: 400;color: #03a9f4;"><i class="fal fa-badge-check"></i> Conta verificada</span>
                        <?php
                      } else {
                        ?>
                          <a href="<?php echo URL ?>painel/dashboard/?refPopup=solicitacao">
                            <img src="<?php echo URL_IMAGES ?>seta-direita.png" style="width: 50px;"> Valide sua conta aqui
                          </a>
                        <?php
                      }
                    ?>

                    
                  </div>
                  <hr>
                  <div class="d-navigation">
                      <ul>
                          <li <?php echo isset($_GET['modulo'])&&$_GET['modulo']=='dashboard'?'class="active"':'' ?>>
                              <a href="<?php echo URL.'painel/' ?>dashboard/"><i class="fal fa-chart-line-down"></i> Dashboard</a>
                          </li>
                          <li <?php echo isset($_GET['modulo'])&&$_GET['modulo']=='meu-perfil'?'class="active"':'' ?>>
                              <a  href="<?php echo URL.'painel/' ?>meu-perfil/"><i class="ti-user"></i> Meu Perfil</a>
                          </li>
                          <li>
                              <a href="<?php echo URL.'painel/' ?>minhas-reservas/"><i class="ti-layers"></i> Minhas reservas</a>
                          </li>
                          <li <?php echo isset($_GET['modulo'])&&$_GET['modulo']=='meus-favoritos'?'class="active"':'' ?>>
                              <a href="<?php echo URL.'painel/' ?>meus-favoritos/"><i class="fal fa-bookmark"></i> Meus favoritos</a>
                          </li>
                          <li <?php echo isset($_GET['modulo'])&&$_GET['modulo']=='alterar-senha'?'class="active"':'' ?>>
                              <a href="<?php echo URL.'painel/' ?>alterar-senha/"><i class="ti-unlock"></i> Alterar Senha</a>
                          </li>

                          <?php if (isset($objCliente->tipo_cliente_id)&&$objCliente->tipo_cliente_id==2) { ?>
                          <hr>

                            <li <?php echo isset($_GET['modulo'])&&$_GET['modulo']=='minhas-propriedades'?'class="active"':'' ?>>
                              <a href="<?php echo URL.'painel/' ?>minhas-propriedades/"><i class="fal fa-home"></i> Minhas Propriedades</a>
                            </li>
                            <li>
                                <a href="<?php echo URL ?>painel/gerenciar-reservas/"><i class="fal fa-calendar-alt"></i> Gerenciar Reservas</a>
                            </li>
                      <!--       <li>
                                <a href=""><i class="fal fa-list"></i> Histórico de Pagamentos</a>
                            </li> -->

                            <li>
                                <a href="<?php echo URL.'painel/' ?>afiliado/"><i class="fal fa-user"></i> Afiliado</a>
                            </li>

                            <li>
                                <a href="<?php echo URL.'painel/' ?>financeiro/"><i class="fal fa-dollar-sign"></i> Meu saldo</a>
                            </li>
                          <?php } ?>

                          <hr>
                          <li>
                              <a href="<?php echo URL ?>sair/"><i class="ti-power-off"></i> Sair</a>
                          </li>

                          <br>  
                          <div style="margin: 0px auto; text-align: center;">
                            <a class="btn btn-theme" href="<?php echo URL ?>criar-propriedade/" style="width: 260px;">Cadastre sua propriedade</a>
                          </div>
                      </ul>
                  </div>
              </div>
          </div>

          <div class="col-lg-9 col-md-8">
              <?php 
              	if (isset($_GET['modulo'])&&$_GET['modulo']=='dashboard') {
              		include('area-cliente/dashboard.php');
              	} else if (isset($_GET['modulo'])&&$_GET['modulo']=='meu-perfil') {
              		include('area-cliente/meu-perfil.php');
              	} else if (isset($_GET['modulo'])&&$_GET['modulo']=='minhas-propriedades') {
                  include('area-cliente/minhas-propriedades.php');
                } else if (isset($_GET['modulo'])&&$_GET['modulo']=='visualizacoes-nos-anuncios') {
                  include('area-cliente/visualizacoes-nos-anuncios.php');
                }  else if (isset($_GET['modulo'])&&$_GET['modulo']=='alterar-senha') {
                  include('area-cliente/alterar-senha.php');
                } else if (isset($_GET['modulo'])&&$_GET['modulo']=='afiliado') {
                  include('area-cliente/afiliado.php');
                } else if (isset($_GET['modulo'])&&$_GET['modulo']=='adicionar-imagens') {
                  include('area-cliente/adicionar-imagens.php');
                } else if (isset($_GET['modulo'])&&$_GET['modulo']=='meus-favoritos') {
                  include('area-cliente/meus-favoritos.php');
                } else if (isset($_GET['modulo'])&&$_GET['modulo']=='gerenciar-reservas') {
                  include('area-cliente/gerenciar-reservas.php');
                }  else if (isset($_GET['modulo'])&&$_GET['modulo']=='reserva') {
                  include('area-cliente/reserva.php');
                } else if (isset($_GET['modulo'])&&$_GET['modulo']=='minhas-reservas') {
                  include('area-cliente/minhas-reservas.php');
                } else if (isset($_GET['modulo'])&&$_GET['modulo']=='gr-reserva') {
                  include('area-cliente/gr-reserva.php');
                }  else if (isset($_GET['modulo'])&&$_GET['modulo']=='financeiro') {
                  include('area-cliente/financeiro.php');
                }  else if (isset($_GET['modulo'])&&$_GET['modulo']=='personalizar-data') {
                  include('area-cliente/personalizar-data.php');
                } else if (isset($_GET['modulo'])&&$_GET['modulo']=='mensagens') {
                  include('area-cliente/mensagens.php');
                } else if (isset($_GET['modulo'])&&$_GET['modulo']=='bloquear-datas') {
                  include('area-cliente/bloqueio-de-datas.php');
                }
              ?>	                
          </div>
        </div>
    </div>
  </section>


<div class="modal fade modalVerificacaoConta" id="modalVerificacaoConta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verificar/Migrar conta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">     
              <?php
                $retDocumentos = Doctrine_Query::create()->select()->from('ClienteMigracao')->where('cliente_id = '.$objCliente->id)->limit(1)->orderBy('data_cadastro DESC')->execute();
                if ($retDocumentos->count()>0) {
                  if ($retDocumentos[0]->status == 3) {
                      ?>
                          <div class="statusNegado"><?php echo $retDocumentos[0]->aviso ?></div>
                      <?php
                  }
                }
              ?>
              <div class="dadosFormulario">
                <?php 
                $objClienteMigracao = Doctrine_Core::getTable('ClienteMigracao')->findOneByClienteIdAndStatus($objCliente->id, 1);
                if (isset($objClienteMigracao->id)) {
                    ?>  

                     <div class="retornoNotif success text-center mt-20" style="display: block;">
                      <i class="fas fa-check"></i>
                      <h4>Recebemos seus documentos com sucesso.</h4>
                      <p>Já estamos verificando e em breve retornaremos.</p>   
                      <a class="btn btn-primary" href="<?php echo URL ?>painel/dashboard/">Acessar dashboard</a>          
                    </div>
                  <?php } else { ?>
                  <form class="formVerificacao" id="formulario-verificacao" enctype="multipart/form-data">
                    <?php if (isset($objCliente->tipo_pessoa_id)&&$objCliente->tipo_pessoa_id==1) { ?>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                            <label>CPF</label>
                            <input type="text" class="form-control validaPerfCPF" name="cpf" data-mask="999.999.999-99"/>
                          </div>

                          <div class="form-group col-md-4">
                              <label>Sexo</label>
                              <select type="text" name="sexo_id" class="form-control validate[required]">
                                  <option value="">Selecione...</option>
                                  <option value="1">Masculino</option>
                                  <option value="2">Feminino</option>
                                  <option value="3">Outros</option>
                              </select>
                          </div>

                          <div class="form-group col-md-4">
                              <label>Data de Nascimento</label>
                              <input type="text" class="form-control validate[required]" name="data_nascimento" id="data_nascimento" data-mask="99/99/9999" />
                          </div>
                      </div>
                    <?php } else if ($objCliente->tipo_pessoa_id==2) { ?>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>CNPJ</label>
                          <input type="text" class="form-control validaCNPJ" name="cnpj" data-mask="99.999.999/9999-99"/>
                        </div>
                      </div>
                    <?php } ?>

                      <div class="form-row">
                        <div class="form-group col-md-8">
                          <label>Tipo de verificação</label>
                          <select class="form-control validate[required]" name="tipo_cliente_id">
                            <option value="">Selecione</option>
                            <option value="1">Quero verificar minha conta para reservar espaços</option>
                            <option value="2">Quero verificar minha conta para reservar espaços e anunciar meu espaço</option>
                          </select> 
                        </div>

                        <div class="form-group col-md-4">
                          <label>CEP</label>
                          <input type="text" class="form-control buscaCep validate[required]" name="cep" data-mask="99999-999" />
                        </div>
                      </div>

                      <div class="form-row">
                          <div class="form-group col-md-6">
                              <label>Logradouro</label>
                              <input type="text" class="form-control validate[required] logradouro" name="logradouro" id="logradouro" />
                          </div>

                          <div class="form-group col-md-3">
                              <label>Número</label>
                              <input type="text" class="form-control validate[required] numero" name="numero" id="numero" />
                          </div>

                          <div class="form-group col-md-3">
                              <label>Complemento</label>
                              <input type="text" class="form-control" name="complemento" id="complemento" />
                          </div>
                      </div>

                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <label>Bairro</label>
                              <input type="text" class="form-control validate[required] bairro" name="bairro" id="bairro" />
                          </div>

                           <div class="form-group col-md-4">
                              <label>Estado:</label>
                              <select name="estado_id"  data-live-search="true" data-width="100%"
                              data-toggle="tooltip" class="form-control validate[required] estado_id">
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

                          <div class="form-group col-md-4">
                              <label>Cidade:</label>
                              <select class="form-control cidade_id validate[required]" data-live-search="true" data-width="100%" data-toggle="tooltip" name="cidade_id">
                                  <option value="">Selecione o estado</option>
                              </select>
                          </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label>Identidade ou CNH</label>
                          <input type="file" name="comprovante_identidade" class="form-control validate[required]" />
                        </div>

                        <div class="form-group col-md-12">
                          <label>Comprovante de endereço</label>
                          <input type="file" name="comprovante_endereco" class="form-control validate[required]">
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label><input type="checkbox" name="termo" class="validate[required]" value="1"> Aceito os <a href="<?php echo URL ?>termos-de-uso/" target="in_blank">Termos de Uso</a> e <a href="<?php echo URL ?>politica-de-privacidade/" target="in_blank">Política de Privacidade</a> do Portal NSPACE</label>
                        </div>
                      </div>

                      <div class="form-row">
                          <div class="form-group col-md-4">
                              <input type="hidden" name="id" value="<?php echo $objCliente->id ?>">
                              <button type="submit" class="btn btn-primary">Solicitar verificação</button>
                          </div>
                      </div>
                  </form>

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
                    <h4>Realizando solicitação</h4>
                  </div>

                  <div class="retornoNotif success text-center mt-20">
                      <i class="fas fa-check"></i>
                      <h4>Recebemos seus documentos com sucesso.</h4>
                      <p>Já estamos verificando e em breve retornaremos.</p>   
                      <a class="btn btn-primary" href="<?php echo URL ?>painel/dashboard/">Acessar dashboard</a>          
                    </div>
                  <?php } ?>
                 
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
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskMoney.js"></script>
<script type="text/javascript" src="<?php echo URL ?>assets/js/cliente-painel.min.js"></script>

<script type="text/javascript">
  <?php if (isset($_GET['refPopup'])&&$_GET['refPopup']=='solicitacao') { ?>
    $('#modalVerificacaoConta').modal();
  <?php } ?>

<?php if (isset($_GET['modulo'])&&$_GET['modulo']=='adicionar-imagens') { ?>
    $(document).ready(function() {
       Dropzone.autoDiscover = false;
       var myDropzone = new Dropzone("#dropzoneFotos", {
        url: "<?php echo URL ?>action/uploadFotos.php",
        paramName: "imagem",
        createImageThumbnails: true,
        dictDefaultMessage: "Arraste suas fotos para aqui",
        thumbnailWidth: 120,
        thumbnailHeight: 120
      });   
    });
<?php } ?>



    // $('.valor-para-saque').keyup(function() {
    //   valorSaque = $(this).val();
    //   $valorDisponivel = $('#valor-disponivel').html();
      
    //   let valorSolicitado = parseFloat(valorSaque.replace(",", "."));
    //   let valorDisponivel = parseFloat($valorDisponivel.replace(",", "."));

    //   if (valorSolicitado > valorDisponivel) {
    //     $(this).val(valorDisponivel);
    //   } 
        
    //   valorSobra = valorDisponivel-valorSolicitado;

    //   if (valorSobra < 0) {
    //     $('#valor-apos-saque').val('0,00');
    //   } else {
    //     $('#valor-apos-saque').val(valorSobra);
    //   }
    // }); 
</script>


<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<!-- <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script> -->
<script type="text/javascript">
    $('.addPagamento').click(function(event) {

        $.get('<?php echo URL.'pagamento-reserva/'.$objReserva->id ?>','',function(data){
            $('#code').val(data);
            $('#comprar').submit();
        })
    });
</script>
