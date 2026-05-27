<?php 
    $objReserva = Doctrine_Core::getTable('Reserva')->find($_GET['id']);

    if ($objReserva->cliente_id != $objCliente->id) {
       header('Location: '. URL.'painel/minhas-reservas/');
    }

    if (isset($_GET['avaliacao'])&&$_GET['avaliacao']!='') {
        $_GET['reserva_id'] = isset($_GET['reserva_id'])&&$_GET['reserva_id']!=''?$_GET['reserva_id']:null;
        $_GET['cliente_id'] = isset($_GET['cliente_id'])&&$_GET['cliente_id']!=''?$_GET['cliente_id']:null;

        $objReservaAvaliacao                         = new ReservaAvaliacao();
        $objReservaAvaliacao->data_cadastro          = date('Y-m-d H:i:s');
        $objReservaAvaliacao->avaliacao              = $_GET['avaliacao']; 
        $objReservaAvaliacao->texto                  = $_GET['texto']; 
        $objReservaAvaliacao->cliente_id             = $_GET['cliente_id']; 
        $objReservaAvaliacao->reserva_id             = $_GET['reserva_id']; 
        $objReservaAvaliacao->anuncio_id             = $_GET['anuncio_id']; 
        $objReservaAvaliacao->status                 = 0; 
        $objReservaAvaliacao->save();

        header('Location: '. URL.'painel/reserva/?id='.$objReservaAvaliacao->reserva_id);
    }
?>
<div class="dashboard-wraper modelReservas">
    <div class="form-submit form-row">
      	<div class="form-group col-lg-12 col-md-12">
        	<h4>Reserva Código <span style="font-weight: 600; color: #000;">#<?php echo $objReserva->id ?></span></h4>
    	</div>      
    </div>

    <?php if (isset($objReserva->status)&&$objReserva->status==1) { ?>
        <div class="codigoLiberado">
            <label>Código da reserva:</label><br>
            <span class="chaveAcesso"><i class="fas fa-key"></i> <?php echo $objReserva->codigo ?></span>
        </div>
    <?php } ?>

    <div class="clearfix"></div><br>

    <div class="detalheReserva">
        <div class="dadosReserva">

            <div class="form-row">
                <div class="col-md-6">
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
                            <label>Valor:</label> <?php echo 'R$'.number_format($objReserva->Anuncio->valor, 0, ',', '.') ?><span style="color: #72809d;font-size: 16px;">/<?php echo $objReserva->Anuncio->TipoCobranca->nome ?></span>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-6">
                    <div class="blocoInfo">
                        <h3>Dados da reserva:</h3>

                        <div class="bloco">
                            <label>Data da reserva:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_cadastro)); ?>
                        </div>

                        <div class="bloco">
                            <label>Cód. Identificador:</label> <?php echo '#'.$objReserva->id; ?>
                        </div>

                        <div class="bloco">
                            <label>Data de entrada:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_entrada)); ?>
                        </div>

                        <div class="bloco">
                            <label>Data de saída:</label> <?php echo date('d/m/Y', strtotime($objReserva->data_saida)); ?>
                        </div>

                        <?php if (isset($objReserva->Anuncio->tipo_cobranca_id)&&$objReserva->Anuncio->tipo_cobranca_id==2) { ?>
                            <div class="bloco">
                                <label>Diárias:</label> <?php echo $objReserva->qtd_dias ?>
                            </div>
                        <?php } else if ($objReserva->Anuncio->tipo_cobranca_id==1) { ?>
                            <div class="bloco">
                                <label>Horario de entrada:</label> <?php echo date('H:i', strtotime($objReserva->horario_entrada)) ?>
                            </div>

                            <div class="bloco">
                                <label>Horario de saída:</label> <?php echo date('H:i', strtotime($objReserva->horario_saida)) ?>
                            </div>

                            <div class="bloco">
                                <label>Qtde. de horas alugada:</label> <?php echo $objReserva->hora_diferenca ?> hora(s)
                            </div>
                        <?php } ?>

                        <?php if (isset($objReserva->Anuncio->data_finalizacao)&&$objReserva->Anuncio->data_finalizacao!='') { ?>
                            <div class="bloco">
                                <label>Data de finalização:</label> <?php echo date('d/m/Y H:i', strtotime($objReserva->data_finalizacao)); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
           
            <div class="blocoInfo text-center mt-15">
                <?php if (isset($objReserva->validacaoCodigo)&&$objReserva->validacaoCodigo==1) { ?>
                    <div class="CodValidade mb-20">
                        <span class="UserValidate"><i class="fas fa-check-circle"></i> Reserva validada!</span>
                    </div>
                <?php } ?>

                <div class="dadosPagamento">
                    <div class="statusPagamento">
                        <?php if (isset($objReserva->status)&&$objReserva->status==0) { ?>
                            <div class="titulo">
                                <h4>Efetue o pagamento agora:</h4>

                                <div class="valorTotal"><?php echo 'R$'.number_format($objReserva->valor_total, 2, ',', '.') ?></div>
                            </div>

                            <div class="pagamento">
                              <a class="aguardando addPagamento" href="<?php echo URL."pagamento/reserva/".$objReserva->id ?>">Efetuar pagamento</a>
                            </div>
                            <?php echo $linkStatus ?>
                        <?php } else if ($objReserva->status==1) { ?>
                            <a class="aguardando mb-10" href="<?php echo URL.'painel/mensagens?reserva_id='.$objReserva->id ?>"><i class="fal fa-comments"></i> Enviar mensagem</a>
                            <a class="aprovado" href="javascript:void(0);">Pagamento aprovado</a>
                        <?php } else if ($objReserva->status==2) { ?>
                            <a class="cancelado" href="javascript:void(0);">Cancelado</a>
                        <?php }  else if ($objReserva->status==10) { ?>
                            <div class="text-center">
                                <label>Data de finalização:</label> <?php echo date('d/m/Y H:i', strtotime($objReserva->data_finalizacao)); ?>
                            </div>
                            <a class="aprovado" href="javascript:void(0);">Reserva finalizada</a>
                        <?php } ?>
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Código de reserva</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                            <div class="modal-body">
                                <div style="font-size: 50px;margin: 0px 0px 15px;text-align: center;letter-spacing: 17px;color: #fd5000;"><?php echo $objReserva->codigo ?></div>
                                
                                <div style="text-align: left;">
                                    <p style="margin: 0px;">Instruções:</p>
                                    <p><span style="color: red; font-weight: 600;">Forneça o código ao <span style="font-weight: 600; font-style: italic;">proprietário</span> após verificar que o local condiz com o reservado. <span style="font-weight: 600;">Sua entrada será liberada assim que o proprietário receber o código!</span></p>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>

            <?php 
                $objReservaAvaliacao = Doctrine_Core::getTable('ReservaAvaliacao')->findOneByClienteIdAndReservaId($objReserva->cliente_id, $objReserva->id);
                if (isset($objReservaAvaliacao->id)) {
                    ?>
                        <div class="listaAvaliacao mt-40">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="avaliadosEstrela">
                                        <?php if (isset($objReservaAvaliacao->avaliacao)&&$objReservaAvaliacao->avaliacao==1) { ?>
                                            <i class="fas fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                        <?php } else if ($objReservaAvaliacao->avaliacao==2) { ?>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                        <?php } else if ($objReservaAvaliacao->avaliacao==3) { ?>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fal fa-star"></i>
                                            <i class="fal fa-star"></i>
                                        <?php } else if ($objReservaAvaliacao->avaliacao==4) { ?>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fal fa-star"></i>
                                        <?php } else if ($objReservaAvaliacao->avaliacao==5) { ?>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        <?php }  ?>
                                    </div>
                                    <p><?php echo $objReservaAvaliacao->texto ?></p>
                                </div>
                            </div>
                        </div>
                    <?php 
                } else {
                    if (isset($objReserva->data_finalizacao)&&$objReserva->data_finalizacao!='') {
                        ?>
                            <div class="minhaAvaliacao mt-40">
                                <form method="get">
                                    <div class="titulo-padrao mb-30 text-center">
                                        <h5>Obrigado pela sua reserva em nosso espaço</h5>
                                        <p>Avalie como foi seu tempo em nosso local e como você achou.</p>
                                    </div>

                                    <div class="estrelas">
                                      <input type="radio" class="radioItens" id="cm_star-empty" name="avaliacao" value=""  checked/>
                                      <label for="cm_star-1"><i class="fa"></i></label>
                                      <input type="radio" class="radioItens" id="cm_star-1" name="avaliacao" value="1"/>
                                      <label for="cm_star-2"><i class="fa"></i></label>
                                      <input type="radio" class="radioItens" id="cm_star-2" name="avaliacao" value="2"/>
                                      <label for="cm_star-3"><i class="fa"></i></label>
                                      <input type="radio" class="radioItens" id="cm_star-3" name="avaliacao" value="3"/>
                                      <label for="cm_star-4"><i class="fa"></i></label>
                                      <input type="radio" class="radioItens" id="cm_star-4" name="avaliacao" value="4"/>
                                      <label for="cm_star-5"><i class="fa"></i></label>
                                      <input type="radio" class="radioItens" id="cm_star-5" name="avaliacao" value="5"/>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label>Texto:</label>
                                            <textarea class="form-control" name="texto"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-row mt-20">
                                        <div class="col-md-12">
                                            <input type="hidden" name="anuncio_id" value="<?php echo $objReserva->anuncio_id ?>">
                                            <input type="hidden" name="cliente_id" value="<?php echo $objReserva->cliente_id ?>">
                                            <input type="hidden" name="reserva_id" value="<?php echo $objReserva->id ?>">
                                            <input type="submit" class="btn btn-primary" value="Avaliar agora">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php
                    }
                }
            ?>
        </div>
    </div>
</div>

