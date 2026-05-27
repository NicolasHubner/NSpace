<div class="dashboard-wraper meuFinanceiro">
	<div class="form-submit">
    	<h4>Meu Financeiro</h4>
    	<p>As solicitações de saque podem demorar em até 3 dias úteis para compensação.</p>

    	<div class="listSaldo">
    		<div class="saldoDisponivel mb-30">
	    		<?php 
		            $retReserva = Doctrine_Query::create()->select()->from('Reserva')->where('status = 1 or status = 10 and validacaoCodigo = 1 and afiliado_id = '.$objCliente->id)->execute();
		            $valorDisponivelAf = 0;
		            foreach ($retReserva as $objReserva) {
		                $valorDisponivelAf += $objReserva->valor_afiliado;
		            }

		            $retReserva = Doctrine_Query::create()->select()->from('Reserva r')->leftJoin('r.Anuncio a')->leftJoin('a.Cliente c')->where('status = 1 or status = 10 and validacaoCodigo = 1 and c.id = '.$objCliente->id)->execute();
		            $valorDisponivelReserva = 0;
		            foreach ($retReserva as $objReserva) {
		                $valorDisponivelReserva += $objReserva->valor_cliente;
		            }

		            $valorDisponivel = $valorDisponivelAf + $valorDisponivelReserva;

	             	$retSolicitacaoSaque = Doctrine_Query::create()->select()->from('SolicitacaoSaque r')->where('cliente_id = '.$objCliente->id)->execute();
		            $valorSaque = 0;
		            $valorTxSaque = 0;
		            foreach ($retSolicitacaoSaque as $objSolicitacaoSaque) {
		                $valorSaque += $objSolicitacaoSaque->valor;
		                $valorTxSaque += $objSolicitacaoSaque->taxa_saque;
		            }

		            if (isset($valorSaque)&&$valorSaque>0) {
		            	$valorDisponivel = $valorDisponivel - $valorSaque;
		            }

		            if (isset($valorTxSaque)&&$valorTxSaque>0) {
		            	$valorDisponivel = $valorDisponivel - $valorTxSaque;
		            }
		        ?>
		        <?php if (isset($valorDisponivel)&&$valorDisponivel>0) { ?>
		        	<span class="valorDs">R$<?php echo number_format($valorDisponivel, 2, ',', '.'); ?></span>  
		        <?php }  else { ?>
                    <span  class="valorDs"><?php echo 'R$'.number_format('0.00', 2, ',', '.') ?></span>
                <?php } ?>

		        <?php //if (isset($valorDisponivel)&&$valorDisponivel>50) { ?>
		        	<a class="sacarAgora" href="javascript:void(0);" cliente-id="<?php echo $objCliente->id ?>">Sacar agora</a>
		        <?php //} //else { ?>
		        	<h5 style="font-size: 12px;">Saque mínimo de R$ 50,00</h5>
		        <?php //} //?>
    		</div>

    		<div class="listaSaques">
       			<div class="table-responsive">
	    			<table class="table">
			          <thead>
			            <tr>
			              <th scope="col">Data solicitação</th>
			              <th scope="col">Tipo de saque</th>
			              <th scope="col">Valor a receber</th>
			              <th scope="col">Taxa de Saque</th>
			              <th scope="col">Status</th>
			            </tr>
			          </thead>
			          <tbody>
			            <?php 
			                $where = 'cliente_id = '.$objCliente->id;
			                $retSolicitacaoSaque = Doctrine_Query::create()->select()->from('SolicitacaoSaque r')->where($where)->orderBy('data_cadastro ASC')->execute();
			                foreach ($retSolicitacaoSaque as $objSolicitacaoSaque) {
			                    ?>
			                        <tr>
			                            <th><?php echo date('d/m/Y', strtotime($objSolicitacaoSaque->data_cadastro)); ?></th>
			                            <th><?php echo $objSolicitacaoSaque->TipoTransacao->nome ?></th>
			                            <th><?php echo 'R$'.number_format($objSolicitacaoSaque->valor, 2, ',', '.') ?></th>
			                            <th><?php echo 'R$'.number_format($objSolicitacaoSaque->taxa_saque, 2, ',', '.') ?></th>
			                            <th><?php echo $objSolicitacaoSaque->StatusSaque->nome ?></th>
			                            
			                        </tr>
			                    <?php 
			                }
			            ?>
			          </tbody>
			        </table>
    			</div>
    		</div>
    	</div>

    	<div class="modal fade modalSolicitacaoSaque" tabindex="-1" role="dialog" aria-hidden="true">
    		<div class="modal-dialog" role="document">
    			<div class="modal-content">
    				<div class="modal-header">
    					<h5 class="modal-title" id="exampleModalLabel">Solicitação de Saque</h5>
    					<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
    						<span aria-hidden="true">&times;</span>
    					</button>
    				</div>
    				<div class="modal-body">
    					<form class="formSaque" id="formulario-saque">
    						<div class="form-row mb-20">
    							<div class="col-md-12 text-center">
    								<label>Valor disponível:</label>
    								<span class="valorDs" style="font-size: 26px;color: #4caf50;font-weight: 600;">R$<span id="valor-disponivel"><?php echo number_format($valorDisponivel, 2, ',', '.'); ?></span></span><br>
    							</div>
    						</div>

    						<div class="form-row mb-20">
    							<div class="col-md-12">
    								<label>Quanto deseja sacar?</label>
    								<input type="text" class="form-control valor-input valor-para-saque" name="valor">
    								<label>Valor mínimo de saque: R$50,00.</label>
    							</div>

    							<!-- <div class="col-md-6">
    								<label>Valor após o saque:</label>
    								<input type="text" class="form-control valor-input" id="valor-apos-saque" disabled>
    							</div> -->
    						</div>

    						<div class="form-row mb-10">
    							<div class="col-md-12">
    								<label>Tipo de transação:</label><br>
    								<?php 
    									$retTipoTransacao 		= Doctrine_Query::create()->select()->from('TipoTransacao')->execute();
    									foreach ($retTipoTransacao as $objTipoTransacao) {
		    								?>
    											<label style="margin-right: 20px;"><input type="radio" name="tipo_transacao_id" value="<?php echo $objTipoTransacao->id ?>" <?php echo $objTipoTransacao->id==1?'checked':'' ?>> <?php echo $objTipoTransacao->nome ?></label>
    										<?php 
    									}
    								?>
    							</div>
    						</div>

    						<div class="taxasTransferencia">
    							<div class="viaTransferencia">
    								<div class="form-row mb-20">
		    							<div class="col-md-12">
		    								<span>Taxa de realização do TED: R$10,00</span>
		    								<input type="hidden" name="taxa_saque" value="10,00">
    									</div>	
									</div>	
    							</div>	

    							<div class="viaPIX" style="display: none;">
    								<div class="form-row mb-20">
		    							<div class="col-md-12">
		    								<span>Taxa de realização do PIX: R$10,00</span><br>
		    								<span>Obs: A chave PIX de CPF é a mais segura para realizar as transações!</span>
		    								<input type="hidden" name="taxa_saque" value="10,00">
    									</div>	
									</div>	
    							</div>
    						</div>



							<div class="form-row mb-20">
    							<div class="col-md-8">
    								<label>Nome do Titular:</label>
    								<input type="text" class="form-control" disabled value="<?php echo $objCliente->nome ?>">
    							</div>

    							<div class="col-md-4">
    								<label>CPF:</label>
    								<input type="text" class="form-control" disabled value="<?php echo $objCliente->cpf ?>">
    							</div>
    						</div>

    						<div class="tipoTransferencia">
    							<div class="form-row mb-20">
	    							<div class="col-md-12">
	    								<label>Banco</label>
	    								<select class="form-control" name="banco_id" name="banco_id">
	    									<option value="">Selecione</option>
	    									<?php 
		    									$retBanco 		= Doctrine_Query::create()->select()->from('Banco')->orderBy('nome ASC')->execute();
		    									foreach ($retBanco as $objBanco) {
				    								?>
	    												<option value="<?php echo $objBanco->id ?>"><?php echo $objBanco->codigo.' - '.$objBanco->nome ?></option>
		    										<?php 
		    									}
		    								?>
	    								</select>
	    							</div>
	    						</div>

	    						<div class="form-row mb-20">
	    							<div class="col-md-4">
	    								<label>Agência:</label>
	    								<input type="text" class="form-control" name="agencia">
	    							</div>

	    							<div class="col-md-4">
	    								<label>Conta:</label>
	    								<input type="text" class="form-control" name="conta">
	    							</div>

	    							<div class="col-md-4">
	    								<label>Digito/Operação:</label>
	    								<input type="text" class="form-control" name="digito">
	    							</div>
	    						</div>
    						</div>

    						<div class="form-row">
    							<div class="col-md-12">
    								<input type="hidden" name="valorMax" value="<?php echo $valorDisponivel ?>">
    								<input type="hidden" class="valCliente" name="cliente_id">
    								<input type="submit" class="btn btn-primary" value="Sacar agora">
    							</div>
    						</div>
    					</form>
    				</div>
    			</div>
    		</div>
    	</div>
	</div>
</div>