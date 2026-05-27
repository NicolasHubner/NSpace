<?php 
    $objReserva = Doctrine_Core::getTable('Reserva')->find($_GET['id']);

    if (isset($_GET['statusPagamento'])&&$_GET['statusPagamento']==3) {
        $objReserva->status             = 3;
        $objReserva->save();

        header('Location: '. URL.'painel/gr-reserva/?id='.$objReserva->id);
    } else if (isset($_GET['status'])&&$_GET['status']==10) {
        $objReserva->status                    = $_GET['status'];
        $objReserva->data_finalizacao          = date('Y-m-d H:i:s');
        $objReserva->save();

        header('Location: '. URL.'painel/gr-reserva/?id='.$objReserva->id);
    }
?>
<div class="dashboard-wraper modelReservas">
    <div class="form-submit form-row">
      	<div class="form-group col-lg-12 col-md-12">
        	<h4>Reserva Código <span style="font-weight: 600; color: #000;">#<?php echo $objReserva->id ?></span></h4>
    	</div>      
    </div>

    <div class="detalheReserva">
        <div class="dadosReserva">
            <div class="form-row">
                <div class="col-md-4">
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

                        <?php if (isset($objReserva->Anuncio->garagem)&&$objReserva->Anuncio->garagem>0) { ?>
                            <div class="bloco">
                                <label>Garagem:</label> <?php echo $objReserva->Anuncio->garagem ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($objReserva->Anuncio->quarto)&&$objReserva->Anuncio->quarto>0) { ?>
                            <div class="bloco">
                                <label>Quartos:</label> <?php echo $objReserva->Anuncio->quarto ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($objReserva->Anuncio->banheiro)&&$objReserva->Anuncio->banheiro>0) { ?>
                            <div class="bloco">
                                <label>Banheiro:</label> <?php echo $objReserva->Anuncio->banheiro ?>
                            </div>
                        <?php } ?>

                        <div class="bloco">
                            <label>Valor:</label> <?php echo 'R$'.number_format($objReserva->Anuncio->valor, 0, ',', '.') ?><span style="color: #72809d;font-size: 16px;">/<?php echo $objReserva->Anuncio->TipoCobranca->nome ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
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
                                <label>Horário de entrada:</label> <?php echo date('H:i', strtotime($objReserva->horario_entrada)); ?>
                            </div>

                            <div class="bloco">
                                <label>Horário de saida:</label> <?php echo date('H:i', strtotime($objReserva->horario_saida)); ?>
                            </div>

                            <div class="bloco">
                                <label>Qtde. de horas alugadas:</label> <?php echo $objReserva->hora_diferenca; ?> hora(s)
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="blocoInfo">
                        <h3>Dados do cliente:</h3>

                        <div class="bloco">
                            <div class="imagemPerfil">
                                <img src="<?php echo isset($objReserva->Cliente->imagem)&&$objReserva->Cliente->imagem!=''?URL_CLIENTE.$objReserva->Cliente->imagem:URL_IMAGES.'no-photo.png' ?>">
                            </div>
                            <?php echo isset($objReserva->Cliente->verificado)&&$objReserva->Cliente->verificado==2?'<a href="#" title="Cliente verificado"><span style="color: #03a9f4;font-size: 17px; display:block; margin-bottom: 10px;"><i class="fal fa-badge-check"></i> Verificado</span></a>':'' ?>
                        </div>

                        <div class="bloco">
                            <label>Cliente:</label> <?php echo $objReserva->Cliente->nome; ?> 
                        </div>

                        <div class="bloco">
                            <label>Apelido:</label> <?php echo $objReserva->Cliente->apelido; ?>
                        </div>

                        <div class="bloco">
                            <label>E-mail:</label> <?php echo $objReserva->Cliente->email; ?>
                        </div>

                        <div class="bloco">
                            <label>Telefone:</label> <?php echo $objReserva->Cliente->telefone; ?>
                        </div>
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
                            <div class="pagamento">
                                <a class="aguardando addPagamento">Aguardando pagamento</a>
                            </div>
                        <?php } else if ($objReserva->status==1) { ?>
                            <a class="aguardando mb-10" href="<?php echo URL.'painel/mensagens?reserva_id='.$objReserva->id ?>"><i class="fal fa-comments"></i> Enviar mensagem</a>
                            <?php if (isset($objReserva->validacaoCodigo)&&$objReserva->validacaoCodigo==1) { ?>
                                <a class="aprovado  mb-10" href="<?php echo URL.'painel/gr-reserva/?id='.$objReserva->id.'&status=10' ?>">Finalizar reserva</a>
                            <?php } ?>
                            <a class="aprovado" href="javascript:void(0);">Pagamento aprovado</a>
                        <?php } else if ($objReserva->status==2) { ?>
                            <a class="cancelado" href="javascript:void(0);">Cancelada</a>
                        <?php } else if ($objReserva->status==10) { ?>
                            <a class="aprovado" href="javascript:void(0);">Reserva finalizada</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

