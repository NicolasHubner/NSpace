<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top detalheAdmin">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
                <?php 
                    $resCliente  = Doctrine_Core::getTable('Cliente')->find($_GET['id']);
                ?>
                <a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>
				<h3>Cliente - Detalhes</h3>
            </div>

    		<div class="block_cont">
    	        <div class="blocoInfo mt-40">
                    <h4>Dados do cliente:</h4>
                    <div class="row">
                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Data de cadastro:</label>
                            <span class="text"><?php echo date('d/m/Y', strtotime($resCliente->data_cadastro)) ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Nome:</label>
                            <span class="text"><?php echo $resCliente->nome ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Data de nascimento:</label>
                            <span class="text"><?php echo $resCliente->data_nascimento ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>CPF:</label>
                            <span class="text"><?php echo $resCliente->cpf ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>E-mail:</label>
                            <span class="text"><?php echo $resCliente->email ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Apelido:</label>
                            <span class="text"><?php echo $resCliente->apelido ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Telefone:</label>
                            <span class="text"><?php echo $resCliente->telefone ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>CEP:</label>
                            <span class="text"><?php echo $resCliente->cep ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Rua/Av:</label>
                            <span class="text"><?php echo $resCliente->logradouro ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Nº:</label>
                            <span class="text"><?php echo $resCliente->numero ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Complemento:</label>
                            <span class="text"><?php echo $resCliente->complemento ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Bairro:</label>
                            <span class="text"><?php echo $resCliente->bairro ?></span>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="singleItem">
                            <label>Estado/Cidade:</label>
                            <span class="text"><?php echo $resCliente->Cidade->nome.'/'.$resCliente->Estado->sigla ?></span>
                          </div>
                        </div>
                    </div>
                </div>

                <?php 
                    $retClienteMigracao = Doctrine_Query::create()->select()->from('ClienteMigracao')->where('cliente_id = '.$resCliente->id)->orderBy('data_cadastro DESC')->limit(1)->execute();
                    if ($retClienteMigracao->count()>0) {
                        ?>
                            <div class="blocoInfo mt-40">
                                <h4>Solicitação de Migração/Verificação</h4>
                                <div class="row">
                                    <div class="col-md-3">
                                      <div class="singleItem">
                                        <label>Data de cadastro:</label>
                                        <span class="text"><?php echo date('d/m/Y', strtotime($retClienteMigracao[0]->data_cadastro)) ?></span>
                                      </div>
                                    </div>

                                    <div class="col-md-5">
                                      <div class="singleItem">
                                        <label>Migração para:</label>
                                        <?php if (isset($resCliente->tipo_cliente_id)&&$resCliente->tipo_cliente_id==$retClienteMigracao[0]->tipo_cliente_id) { ?>
                                            Manter atual (Somente verificar)
                                        <?php } else { ?>
                                            <span class="text"><?php echo $retClienteMigracao[0]->TipoCliente->nome ?></span>
                                        <?php } ?>
                                      </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="singleItem">
                                        <label>Identificador:</label>
                                        <span class="text"><?php echo $retClienteMigracao[0]->identificador ?></span>
                                      </div>
                                    </div>
                                </div>

                                <div class="row FotosComprovantes">
                                  <?php if (isset($retClienteMigracao[0]->comprovante_identidade)&&$retClienteMigracao[0]->comprovante_identidade!='') { ?>
                                    <div class="col-md-3">
                                      <div class="singleItem">
                                        <label>Comprovante de Identidade:</label>
                                        <div class="icone-doc">
                                          <a class="btn btn-success" href="<?php echo URL_CLIENTE.$retClienteMigracao[0]->comprovante_identidade  ?>" data-fancybox="group">
                                            <i class="fal fa-file"></i> Visualizar
                                          </a>
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>

                                  <?php if (isset($retClienteMigracao[0]->comprovante_endereco)&&$retClienteMigracao[0]->comprovante_endereco!='') { ?>
                                    <div class="col-md-3">
                                      <div class="singleItem">
                                        <label>Comprovante de Endereço:</label>
                                        <div class="icone-doc">
                                          <a class="btn btn-success" href="<?php echo URL_CLIENTE.$retClienteMigracao[0]->comprovante_endereco  ?>" data-fancybox="group">
                                            <i class="fal fa-file"></i> Visualizar
                                          </a>
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>
                                </div>

                                <form action="<?php echo URL_ADMIN.'app/cliente/aprovarMigracao.php' ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Situação:</label><br>
                                            <label><input type="radio" name="status" value="1" <?php echo $retClienteMigracao[0]->status==1?'checked':'' ?>> Analisando</label>
                                            <label><input class="ml-10" type="radio" name="status" value="2" <?php echo $retClienteMigracao[0]->status==2?'checked':'' ?>> Aprovar</label>
                                            <label><input class="ml-10" type="radio" name="status" value="3" <?php echo $retClienteMigracao[0]->status==3?'checked':'' ?>> Reprovar</label>
                                        </div>
                                    </div>

                                    <div class="displayNegar" <?php echo isset($retClienteMigracao[0]->status)&&$retClienteMigracao[0]->status==3?'style="display: block;"':'style="display: none;"' ?>>
                                      <div class="row">
                                        <div class="col-md-12">
                                          <label>Resposta automática:</label><br>
                                          <?php
                                            $retRespostaAutomatica = Doctrine_Query::create()->select()->from('RespostaAutomatica')->execute();
                                            foreach ($retRespostaAutomatica as $objRespostaAutomatica) {
                                              ?>
                                                <label class="resposdentes"><input type="radio" name="resposta_automatica_id" id="resposta_automatica" value="<?php echo $objRespostaAutomatica->id ?>"> <?php echo $objRespostaAutomatica->texto ?></label>
                                              <?php 
                                            }
                                          ?>
                                        </div> 
                                      </div>

                                      <div class="row">
                                        <div class="col-md-12">
                                          <label>Aviso:</label><br>
                                          <textarea class="form-style" name="aviso" id="aviso"><?php echo $retClienteMigracao[0]->aviso ?></textarea>
                                        </div> 
                                      </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="hidden" name="id" value="<?php echo $retClienteMigracao[0]->id ?>">
                                            <input type="submit" class="btn btn-primary" value="Salvar dados">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php
                    }
                ?>
            </div>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->

<script type="text/javascript">
  jQuery(document).ready(function() {
    $('input[name="status"]:radio').change(function () {
        var status = $("input[name='status']:checked").val();

        if (status == 3) {
          $('.displayNegar').css('display', 'block');
        } else {
          $('.displayNegar').css('display', 'none');
          $('#aviso').val("");
        }
    });
  });
</script>