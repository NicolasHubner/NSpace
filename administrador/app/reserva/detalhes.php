<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top detalheAdmin">
  <div class="col-md-12">
    <div class="block-flat">
        <?php 
            $resReserva = Doctrine_Core::getTable('Reserva')->find($_GET['id']);
        ?>

      <div class="header">
        <a href="<?php echo URL_ADMIN.$_GET['model'].'/' ?>" class="btnVoltar pull-right">Voltar</a>	
        <h3>Reserva - <?php echo '#'.$resReserva->id ?> - Detalhes </h3>
      </div>
     
        <div class="mt-40">

            <div class="row">
                <div class="col-md-6">
                    <div class="blocoInfo">
                        <h4>Dados do cliente:</h4>

                        <?php if (isset($resReserva->Cliente->tipo_cliente_id)&&$resReserva->Cliente->tipo_cliente_id!='') { ?>
                            <div class="singleItem">
                                <label>Tipo de cliente:</label>
                                <span class="text"><?php echo $resReserva->Cliente->TipoCliente->nome ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->cliente_id)&&$resReserva->cliente_id!='') { ?>
                            <div class="singleItem">
                                <label>Nome Completo:</label>
                                <span class="text"><?php echo $resReserva->Cliente->nome ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->Cliente->apelido)&&$resReserva->Cliente->apelido!='') { ?>
                            <div class="singleItem">
                                <label>Apelido:</label>
                                <span class="text"><?php echo $resReserva->Cliente->apelido ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->Cliente->email)&&$resReserva->Cliente->email!='') { ?>
                            <div class="singleItem">
                                <label>E-mail:</label>
                                <span class="text"><?php echo $resReserva->Cliente->email ?></span>
                            </div>
                        <?php } ?>
                        
                        <?php if (isset($resReserva->Cliente->telefone)&&$resReserva->Cliente->telefone!='') { ?>
                            <div class="singleItem">
                                <label>Telefone:</label>
                                <span class="text"><?php echo $resReserva->Cliente->telefone ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->Cliente->cidade_id)&&$resReserva->Cliente->cidade_id!='') { ?>
                            <div class="singleItem">
                                <label>Cidade:</label>
                                <span class="text"><?php echo $resReserva->Cliente->Cidade->nome ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->Cliente->estado_id)&&$resReserva->Cliente->estado_id!='') { ?>
                            <div class="singleItem">
                                <label>Cidadade:</label>
                                <span class="text"><?php echo $resReserva->Cliente->Estado->nome ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="blocoInfo">
                        <h4>Dados da reserva:</h4>
                        
                        <?php if (isset($resReserva->data_cadastro)&&$resReserva->data_cadastro!='') { ?>
                            <div class="singleItem">
                                <label>Data da reserva:</label>
                                <span class="text"><?php echo date('d/m/Y H:i', strtotime($resReserva->data_cadastro)) ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->anuncio_id)&&$resReserva->anuncio_id!='') { ?>
                            <div class="singleItem">
                                <label>Espaço:</label>
                                <span class="text"><?php echo $resReserva->Anuncio->titulo ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->data_entrada)&&$resReserva->data_entrada!='') { ?>
                            <div class="singleItem">
                                <label>Data de entrada:</label>
                                <span class="text"><?php echo date('d/m/Y', strtotime($resReserva->data_entrada)) ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->data_saida)&&$resReserva->data_saida!='') { ?>
                            <div class="singleItem">
                                <label>Data de saída:</label>
                                <span class="text"><?php echo date('d/m/Y', strtotime($resReserva->data_saida)) ?></span>
                            </div>

                            <div class="singleItem">
                                <label>Quantidade de diárias:</label>
                                <span class="text"><?php echo $resReserva->qtd_dias ?></span>
                            </div>
                        <?php }  else { ?>
                            <div class="singleItem">
                                <label>Horário de entrada:</label>
                                <span class="text"><?php echo date('H:i', strtotime($resReserva->horario_entrada)) ?></span>
                            </div>

                            <div class="singleItem">
                                <label>Horário de saída:</label>
                                <span class="text"><?php echo date('H:i', strtotime($resReserva->horario_saida)) ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->valor_total)&&$resReserva->valor_total!='') { ?>
                            <div class="singleItem">
                                <label>Valor total:</label>
                                <span class="text"><?php echo 'R$'.number_format($resReserva->valor_total, 2, ',', '.') ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->validacaoCodigo)&&$resReserva->validacaoCodigo==1) { 
                            $codigoValidado = '<span class="status-validacao"><span class="validada"><i class="fas fa-key"></i></span> Confirmada</span>';
                            ?>
                            <div class="singleItem">
                                <label>Reserva confirmada?</label>
                                <span class="text"> <?php echo $codigoValidado ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->status)&&$resReserva->status!='') { 
                            switch ($resReserva->status) {
                                case '0':
                                    $status = '<span class="status-pagamento"><span class="aguardando"><i class="fas fa-circle"></i></span> Aguardando</span>';
                                    break;
                                
                                case '1':
                                    $status = '<span class="status-pagamento"><span class="aprovado"><i class="fas fa-circle"></i></span> Aprovado</span>';
                                    break;
            
                                case '2':
                                    $status = '<span class="status-pagamento"><span class="cancelado"><i class="fas fa-circle"></i></span> Cancelado</span>';
                                    break;
            
                                case '10':
                                    $status = '<span class="status-pagamento"><span class="finalizado"><i class="fas fa-circle"></i></span> Finalizado</span>';
                                    break;
                            }
                            ?>
                            <div class="singleItem">
                                <label>Status:</label>
                                <span class="text"> <?php echo $status ?></span>
                            </div>
                        <?php } ?>

                        <?php if (isset($resReserva->status)&&$resReserva->status==1) { ?>
                            <?php if (isset($resReserva->data_pagamento)&&$resReserva->data_pagamento!='') { ?>
                                <div class="singleItem">
                                    <label>Data de pagamento:</label>
                                    <span class="text"><?php echo date('d/m/Y H:i', strtotime($resReserva->data_pagamento)) ?></span>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
