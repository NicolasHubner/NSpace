<div class="bloco-grafico">
    <div class="row">
        <?php 
			$objCliente = Doctrine_Core::getTable('Cliente')->findAll();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-blue">
                <div class="content">
                    <h1 class="text-left"><?php echo $objCliente->count() ?></h1>
                    <p>Clientes</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>cliente/">Detalhes <span><i
                            class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>

        <?php 
			$objAnuncio = Doctrine_Core::getTable('Anuncio')->findAll();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-blue">
                <div class="content">
                    <h1 class="text-left"><?php echo $objAnuncio->count() ?></h1>
                    <p>Anuncios</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>espaco/">Detalhes <span><i
                            class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>

        <?php 
			$objSolicitacaoSaque = Doctrine_Core::getTable('SolicitacaoSaque')->findAll();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-blue">
                <div class="content">
                    <h1 class="text-left"><?php echo $objSolicitacaoSaque->count() ?></h1>
                    <p>Solicitações de Saque</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>solicitacao-saque/">Detalhes <span><i
                            class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>

        <?php 
			$objAvaliacao = Doctrine_Core::getTable('ReservaAvaliacao')->findAll();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-blue">
                <div class="content">
                    <h1 class="text-left"><?php echo $objAvaliacao->count() ?></h1>
                    <p>Avaliações</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>avaliacao/">Detalhes <span><i
                            class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>
    </div>

	<div class="row">
        <?php 
			$objPagina = Doctrine_Core::getTable('Pagina')->findAll();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-green">
                <div class="content">
                    <h1 class="text-left"><?php echo $objPagina->count() ?></h1>
                    <p>Paginas</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>pagina/">Detalhes <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>

		<?php 
			$objPlano = Doctrine_Core::getTable('Plano')->findAll();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-green">
                <div class="content">
                    <h1 class="text-left"><?php echo $objPlano->count() ?></h1>
                    <p>Planos</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>plano/">Detalhes <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>

		<?php 
			$objBanco = Doctrine_Core::getTable('Banco')->findAll();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-green">
                <div class="content">
                    <h1 class="text-left"><?php echo $objBanco->count() ?></h1>
                    <p>Agência Bancárias</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>banco/">Detalhes <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>

		<?php 
			$objOpcional = Doctrine_Core::getTable('Opcional')->findAll();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-green">
                <div class="content">
                    <h1 class="text-left"><?php echo $objOpcional->count() ?></h1>
                    <p>Opcionais (Espaços)</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>opcionais/">Detalhes <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>
	</div>


	<div class="row">
		 <?php 
			$objReserva = Doctrine_Core::getTable('Reserva')->findAll();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-blue">
                <div class="content">
                    <h1 class="text-left"><?php echo $objReserva->count() ?></h1>
                    <p>Reservas</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>reserva/">Detalhes <span><i
                            class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>

        <?php 
			$retReservaAprovadas = Doctrine_Query::create()->select()->from('Reserva')->where('status = 1')->execute();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-green">
                <div class="content">
                    <h1 class="text-left"><?php echo $retReservaAprovadas->count() ?></h1>
                    <p>Aprovadas</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>reserva/?status=1">Detalhes <span><i
                            class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>

        <?php 
			$retReservaAguardando = Doctrine_Query::create()->select()->from('Reserva')->where('status = 0')->execute();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-roxo">
                <div class="content">
                    <h1 class="text-left"><?php echo $retReservaAguardando->count() ?></h1>
                    <p>Aguardando Pagamento</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>reserva/?status=0">Detalhes <span><i
                            class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>

        <?php 
			$retReservaCancelada = Doctrine_Query::create()->select()->from('Reserva')->where('status = 2')->execute();
		?>
        <div class="col-md-3 col-sm-6">
            <div class="fd-tile detail tile-red">
                <div class="content">
                    <h1 class="text-left"><?php echo $retReservaCancelada->count() ?></h1>
                    <p>Canceladas</p>
                </div>
                <div class="icon"><i class="fa fa-flag"></i></div>
                <a class="details" href="<?php echo URL_ADMIN ?>reserva/?status=2">Detalhes <span><i
                            class="fa fa-arrow-circle-right pull-right"></i></span></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div id="grafico_cliente"></div>
        </div>

        <div class="col-md-6">
            <div id="grafico_reserva"></div>
        </div>
    </div>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		Highcharts.chart('grafico_cliente', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Clientes'
			},
			subtitle: {
				text: 'Ativos'
			},
			xAxis: {
				categories: [
					<?php
				for ($i = 11; $i >= 0; $i--) {

				echo "'".strftime('%b/%y', strtotime(date('Y-m-d') . "-".$i." months"))."', ";
				}
				?>
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Qtde'
				}
			},
			legend: {
				enabled: false
			},
			series: [{
				name: 'Clientes',
				data: [
					<?php
				$og = 0;
				
				for ($data_aluno = 11; $data_aluno >= 0; $data_aluno--) {
					$mes_atual = date('m', strtotime(date('Y-m-d') . "-".$data_aluno." months"));
					$ano_atual = date('Y', strtotime(date('Y-m-d') . "-".$data_aluno." months"));

					$where = "status = 1 and MONTH(data_cadastro) = '".$mes_atual."' and YEAR(data_cadastro) = '".$ano_atual."'";
					// echo $where;
					$retCliente = Doctrine_Query::create()->select()->from('Cliente')->where($where)->execute();
				
					?> {
						x: <?php echo $og ?>,
						y: <?php echo $retCliente->count() ?>
					},
					<?php
					$og++;
				}
				?>
				]
			}]
		});

		Highcharts.chart('grafico_reserva', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Reservas'
			},
			subtitle: {
				text: 'Aprovadas'
			},
			xAxis: {
				categories: [
					<?php
				for ($i = 11; $i >= 0; $i--) {

				echo "'".strftime('%b/%y', strtotime(date('Y-m-d') . "-".$i." months"))."', ";
				}
				?>
				],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Qtde'
				}
			},
			legend: {
				enabled: false
			},
			series: [{
				name: 'Reservas',
				data: [
					<?php
				$og = 0;
				
				for ($data_aluno = 11; $data_aluno >= 0; $data_aluno--) {
					$mes_atual = date('m', strtotime(date('Y-m-d') . "-".$data_aluno." months"));
					$ano_atual = date('Y', strtotime(date('Y-m-d') . "-".$data_aluno." months"));

					$where = "status = 1 and MONTH(data_cadastro) = '".$mes_atual."' and YEAR(data_cadastro) = '".$ano_atual."'";
					// echo $where;
					$retReserva = Doctrine_Query::create()->select()->from('Reserva')->where($where)->execute();
				
					?> {
						x: <?php echo $og ?>,
						y: <?php echo $retReserva->count() ?>
					},
					<?php
					$og++;
				}
				?>
				]
			}]
		});
	});
</script>