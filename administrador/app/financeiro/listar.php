<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div class="row no-margin-top ">
	<div class="col-md-12">
        <div class="block-flat">
          	<div class="header">	
          		<div class="pull-right btnActionCadastrar">
          			<?php
						$objPermissao = new UsuarioPermissao();
						$objPermissao->printActions($_GET['model'], 1);
	          		?>
          		</div>
				<h3>Financeiro (Reservas)</h3>
			</div>

			<div class="dashboard-valores">
				<div class="row">
					<div class="col-md-3">
						<?php 
							$valorCliente = 0;

							$retValorCliente = Doctrine_Query::create()->select()->from('Reserva')->where('status = 1')->execute();
							foreach ($retValorCliente as $objValorCliente) {
								$valorCliente += $objValorCliente->valor_cliente;
							}
						?>
						<div class="item-single orange">
							<label>Valor faturado (Clientes)</label>
							<div class="valor">R$<?php echo number_format($valorCliente, 2, ',', '.') ?></div>
						</div>
					</div>

					<div class="col-md-3">
						<?php 
							$valorNspace = 0;

							$retValorNspace = Doctrine_Query::create()->select()->from('Reserva')->where('status = 1')->execute();
							foreach ($retValorNspace as $objValorNspace) {
								$valorNspace += $objValorNspace->valor_nspace;
							}
						?>
						<div class="item-single blue">
							<label>Comissão da Nspace</label>
							<div class="valor">R$<?php echo number_format($valorNspace, 2, ',', '.') ?></div>
						</div>
					</div>

					<div class="col-md-3">
						<?php 
							$valorAfiliado = 0;

							$retValorNspace = Doctrine_Query::create()->select()->from('Reserva')->where('status = 1')->execute();
							foreach ($retValorNspace as $objValorNspace) {
								$valorAfiliado += $objValorNspace->valor_afiliado;
							}
						?>
						<div class="item-single green">
							<label>Comissões dos afiliados</label>
							<div class="valor">R$<?php echo number_format($valorAfiliado, 2, ',', '.') ?></div>
						</div>
					</div>

					<div class="col-md-3">
						<?php 
							$valorTotal = $valorNspace + $valorCliente + $valorAfiliado;
						?>
						<div class="item-single roxo">
							<label>Valor Total</label>
							<div class="valor">R$<?php echo number_format($valorTotal, 2, ',', '.') ?></div>
						</div>
					</div>
				</div>
			</div>
			
			<table class="data-table"><!-- Table Wrapper Begin -->
				<thead>
					<tr>
						<th width="170">Data de Cadastro</th>
						<th width="170">Código da Reserva</th>
						<th width="150">Valor do Cliente</th>
						<th width="150">Valor do Afiliado</th>
						<th width="150">Valor da Nspace</th>
						<th width="150">Pagamento</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->