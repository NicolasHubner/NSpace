<div class="dashBoard">
    <?php if (isset($objCliente->email_confirmado)&&$objCliente->email_confirmado==0) { ?>
        <div style="background: #f44336;
        color: #fff;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 1px;
        box-shadow: 0px 0px 25px #0000004a;">Confirme sua conta no seu e-mail que você cadastrou!</div>
    <?php } ?>

    <?php if (isset($objCliente->tipo_cliente_id)&&$objCliente->tipo_cliente_id==1) { ?>
        <div class="row">
            <?php 
                $where = 'cliente_id = '.$objCliente->id;
                $retAnuncioFavorito = Doctrine_Query::create()->select()->from('AnuncioFavorito')->where($where)->execute();
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="<?php echo URL.'painel/meus-favoritos/' ?>">
                    <div class="dashboard-stat widget-1">
                        <div class="dashboard-stat-content">
                            <h4><?php echo $retAnuncioFavorito->count(); ?></h4>
                            <span>Meus Favoritos</span>
                        </div>
                        <div class="dashboard-stat-icon"><i class="ti-user"></i></div>
                    </div>
                </a>
            </div>

            <?php 
                $where = 'cliente_id = '.$objCliente->id;
                $retReserva = Doctrine_Query::create()->select()->from('Reserva')->where($where)->execute();
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="<?php echo URL ?>painel/minhas-reservas/">
                    <div class="dashboard-stat widget-3">
                        <div class="dashboard-stat-content">
                            <h4><?php echo $retReserva->count(); ?></h4>
                            <span>Minhas reservas</span>
                        </div>
                        <div class="dashboard-stat-icon"><i class="ti-user"></i></div>
                    </div>
                </a>
            </div>
        </div>
    <?php } else if ($objCliente->tipo_cliente_id==2) { ?>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="<?php echo URL ?>painel/financeiro/">
                    <div class="dashboard-stat widget-1">
                        <?php 
                            $retReserva = Doctrine_Query::create()->select()->from('Reserva')->where('status = 1 or status = 10 and afiliado_id = '.$objCliente->id)->execute();
                            $valorDisponivelAf = 0;
                            foreach ($retReserva as $objReserva) {
                                $valorDisponivelAf += $objReserva->valor_afiliado;
                            }

                            $retReserva = Doctrine_Query::create()->select()->from('Reserva r')->leftJoin('r.Anuncio a')->leftJoin('a.Cliente c')->where('status = 1 or status = 10 and c.id = '.$objCliente->id)->execute();
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
                        <div class="dashboard-stat-content">
                            <?php if (isset($valorDisponivel)&&$valorDisponivel>0) { ?>
                                <h4><?php echo 'R$'.number_format($valorDisponivel, 2, ',', '.') ?></h4>
                            <?php } else { ?>
                                <h4><?php echo 'R$'.number_format('0.00', 2, ',', '.') ?></h4>
                            <?php } ?>
                            <span>Saldo disponível para saque</span>
                        </div>
                        <div class="dashboard-stat-icon"><i class="ti-money"></i></div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <?php 
                    $retSolicitacaoSaque = Doctrine_Query::create()->select()->from('SolicitacaoSaque r')->where('cliente_id = '.$objCliente->id)->execute();
                    $valorSaque = 0;
                    foreach ($retSolicitacaoSaque as $objSolicitacaoSaque) {
                        $valorSaque += $objSolicitacaoSaque->valor;
                    }
                ?>
                <a href="<?php echo URL ?>painel/financeiro/">
                    <div class="dashboard-stat widget-2">
                        <div class="dashboard-stat-content">
                            <h4>R$<?php echo $valorSaque>0?number_format($valorSaque, 2, ',', '.'):'0,00' ?></h4>
                            <span>Valores a receber</span>
                        </div>
                        <div class="dashboard-stat-icon"><i class="ti-money"></i></div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <?php 
                    $retQtdAfiliado = Doctrine_Query::create()->select()->from('Cliente')->where('afiliado_id = '.$objCliente->id)->execute();
                    $retReserva = Doctrine_Query::create()->select()->from('Reserva')->where('status = 1 or status = 10 and afiliado_id = '.$objCliente->id)->execute();
                    $valorComissao = 0;
                    foreach ($retReserva as $objReserva) {
                        $valorComissao += $objReserva->valor_afiliado;
                    }
                ?>
                <a href="<?php echo URL ?>painel/financeiro/">
                    <div class="dashboard-stat widget-3">
                        <div class="dashboard-stat-content">
                            <h4><?php echo 'R$'.number_format($valorComissao, 2, ',', '.') ?></h4>
                            <span>Valor de comissão (Afiliados)</span>
                            <span>Qtde.: <?php echo $retQtdAfiliado->count(); ?></span>
                        </div>
                        <div class="dashboard-stat-icon"><i class="ti-user"></i></div>
                    </div>
                </a>
            </div>

            <?php 
                $retAnuncio = Doctrine_Query::create()->select()->from('Anuncio')->where('cliente_id = '.$objCliente->id)->execute();
                
                $qtdAnuncio = 0;
                foreach ($retAnuncio as $objAnuncio) {
                    $qtdAnuncio += $objAnuncio->visualizacao;
                }
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="<?php echo URL.'painel/' ?>minhas-propriedades/">
                    <div class="dashboard-stat widget-4">
                        <div class="dashboard-stat-content">
                            <h4><?php echo $retAnuncio->count(); ?></h4>
                            <span>Propriedades anunciadas</span>
                        </div>
                        <div class="dashboard-stat-icon"><i class="ti-location-pin"></i></div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="<?php echo URL.'painel/' ?>visualizacoes-nos-anuncios/">
                    <div class="dashboard-stat widget-6">
                        <div class="dashboard-stat-content">
                            <h4><?php echo $qtdAnuncio ?></h4>
                            <span>Visualizações nos anúncios</span>
                        </div>
                        <div class="dashboard-stat-icon"><i class="ti-user"></i></div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="dashboard-stat widget-7">
                    <div class="dashboard-stat-content">
                        <h4>0</h4>
                        <span>Médias de reservas/mês</span>
                    </div>
                    <div class="dashboard-stat-icon"><i class="ti-user"></i></div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php 
        $retCliente = Doctrine_Query::create()->select()->from('Cliente')->where('afiliado_id = '.$objCliente->id)->execute();
        if ($retCliente->count()>0) {
            ?>
                <div class="lista-afiliado" style="margin-top: 50px;">
                    <h3 class="mb-20">Afiliados</h3>

                    <div class="row">
                        <?php 
                            foreach ($retCliente as $objCliente) {
                            $retEspacos = Doctrine_Query::create()->select()->from('Anuncio')->where('cliente_id = '.$objCliente->id)->execute();
                                ?>
                                    <div class="col-md-2">
                                        <div class="singleItem">
                                            <div class="images text-center">
                                                <img src="<?php echo isset($objCliente->imagem)&&$objCliente->imagem!=''?URL_CLIENTE.$objCliente->imagem:URL_IMAGES.'no-photo.png' ?>" class="img-fluid avater" alt="" />                                   
                                            </div>
                                            <h5><?php echo $objCliente->apelido ?></h5>
                                            <span>Espaços: <?php echo $retEspacos->count(); ?></span>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>            
                    </div>
                </div>
            <?php 
        }
    ?>
</div>

