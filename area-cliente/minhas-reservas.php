<div class="dashboard-wraper modelReservas">
    <div class="form-submit form-row">
      	<div class="form-group col-lg-12 col-md-12">
        	<h4>Minhas reservas</h4>
    	</div>      
    </div>

    <div class="row">
        <?php 
            $retReserva = Doctrine_Query::create()->select()->from('Reserva')->where('cliente_id = '.$objCliente->id)->orderBy('data_cadastro DESC')->execute();
            if ($retReserva->count()>0) {
                foreach ($retReserva as $objReserva) {
                    ?>
                        <div class="col-md-3">
                        	<div class="singleItem">
    	                    	<?php if (isset($objReserva->Anuncio->imagem)&&$objReserva->Anuncio->imagem!='') { ?>
    	                    		<div class="imagem">
    	                    			<img src="<?php echo URL_ANUNCIO.$objReserva->Anuncio->imagem ?>">
    	                    		</div>
    	                    	<?php } ?>
                        		
                                <h3><?php echo $objReserva->Anuncio->titulo ?></h3>

                                <div class="informacoes">
                                    <p>Cód. do Espaço: <?php echo $objReserva->Anuncio->codigo ?></p>
                                    <p>Data de entrada: <?php echo date('d/m/Y', strtotime($objReserva->data_entrada)); ?></p>
                                    <p>Data de saída: <?php echo date('d/m/Y', strtotime($objReserva->data_saida)); ?></p>
                                    <?php if (isset($objReserva->Anuncio->tipo_cobranca_id)&&$objReserva->Anuncio->tipo_cobranca_id==2) { ?>
                                        <p>Qtde. de dias: <?php echo $objReserva->qtd_dias ?></p>
                                    <?php } else if($objReserva->Anuncio->tipo_cobranca_id==1) { ?>
                                        <p>Horário de entrada: <?php echo date('H:i', strtotime($objReserva->horario_entrada)); ?></p>
                                        <p>Horário de saida: <?php echo date('H:i', strtotime($objReserva->horario_saida)); ?></p>
                                        <p>Qtde. de horas alugada: <?php echo $objReserva->hora_diferenca ?></p>
                                    <?php } ?>

                                    <div class="valorTotal mt-15">
                                        <?php echo 'R$'.number_format($objReserva->valor_total, 2, ',', '.'); ?>
                                    </div>

                                    <div class="statusPagamento mt-10">
                                        <?php if (isset($objReserva->status)&&$objReserva->status==0) { ?>
                                            <div class="pagamento">
                                              <a class="aguardando addPagamento" href="<?php echo URL."pagamento/reserva/".$objReserva->id ?>">Efetuar pagamento</a>
                                            </div>
                                        <?php } else if ($objReserva->status==1) { ?>
                                            <a class="aprovado" href="javascript:void(0);">Pagamento aprovado</a>
                                        <?php } else if ($objReserva->status==2) { ?>
                                            <a class="cancelado" href="javascript:void(0);">Cancelada</a>
                                        <?php } else if ($objReserva->status==10) { ?>
                                            <a class="aprovado" href="javascript:void(0);">Reserva finalizada</a>
                                        <?php } ?>
                                    </div>

                                    <a class="btnDetalhes mt-10" href="<?php echo URL.'painel/reserva/?id='.$objReserva->id ?>"><i class="fal fa-arrow-alt-right"></i> Ver detalhes</a>
                                </div>
                        	</div>
                        </div>
                    <?php 
                }
            } else {
                ?>
                    <div class="col-md-12 text-center">
                        <p>Não há reservas feitas ainda, junte seus amigos e faça seu primeiro evento na NSpace.</p>
                    </div>
                <?php
            }
        ?>
    </div>
</div>