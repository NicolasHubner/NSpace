<div class="dashboard-wraper model-minhas-propriedades">
    <div class="form-submit">
        <h4 class="mb-20">Minhas propriedades</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-md-12">
            <?php 
                $retAnuncio = Doctrine_Query::create()->select()->from('Anuncio')->where('cliente_id = '.$objCliente->id)->orderBy('data_cadastro DESC')->execute();
                foreach ($retAnuncio as $objAnuncio) {
                    ?>
                        <?php if (isset($objAnuncio->aviso)&&$objAnuncio->aviso!='' && isset($objAnuncio->status_id)&&$objAnuncio->status_id==3) { ?>
                            <div class="AvisoReprovado"><i class="fal fa-exclamation"></i> <?php echo $objAnuncio->aviso ?></div>
                        <?php } ?>
                        <div class="singles-dashboard-list">
                            <div class="noficicacaoStatus">
                                <label class="status-anuncio">Status do Anúncio</label>
                                <div class="statusAnuncio" style="background: <?php echo $objAnuncio->Status->background ?>; color: <?php echo $objAnuncio->Status->color ?>;">
                                    <?php echo $objAnuncio->Status->nome ?>
                                </div>
                                
                                <?php if (isset($objAnuncio->pagamento)&&$objAnuncio->pagamento==2) { ?>
                                    <label class="status-pagamento">Status da Assinatura</label>
                                    <a href="<?php echo URL.'pagamento/anuncio/'.$objAnuncio->id ?>">
                                        <div class="statusPagamento" style="background: red; color: #fff;">
                                            Pagamento Negado
                                        </div>
                                    </a>
                                <?php } else if (isset($objAnuncio->pagamento)&&$objAnuncio->pagamento==1) { ?>
                                    <label class="status-pagamento">Aprovado</label>
                                    <div class="statusPagamento" style="background: #4caf50; color: #fff;">
                                        <?php echo $objAnuncio->Plano->nome ?>
                                    </div>
                                <?php } else { ?>
                                    <?php if (isset($objAnuncio->plano_id)&&$objAnuncio->plano_id!=1) { ?>
                                        <label class="status-pagamento">Status da Assinatura</label>
                                        <a href="<?php echo URL.'pagamento/anuncio/'.$objAnuncio->id ?>">
                                            <div class="statusPagamento" style="background: #03a9f4; color: #fff;">
                                                Aguardando assinatura
                                            </div>
                                        </a>
                                    <?php } ?>
                                <?php }  ?>


                            </div>



                            <div class="sd-list-left">
                                <div class="imagemAnuncio">
                                    <?php if (isset($objAnuncio->imagem)&&$objAnuncio->imagem!='') { ?>
                                        <img src="<?php echo URL_ANUNCIO.$objAnuncio->imagem ?>" class="img-fluid"/>
                                    <?php } else { ?>
                                        <img src="<?php echo URL_IMAGES ?>sem-foto.jpg" style="width: 100%;">
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="sd-list-right blockConteudo">
                                <h4 class="listing_dashboard_title"><a href="<?php echo URL.'anuncio/'.$objAnuncio->dns.'/'.$objAnuncio->id.'/' ?>" class="theme-cl"><?php echo $objAnuncio->titulo ?></a></h4>
                                <div class="user_dashboard_listed">Cód. identificador: <?php echo $objAnuncio->id ?></div>
                                <div class="user_dashboard_listed">Data de cadastro: <?php echo date('d/m/Y', strtotime($objAnuncio->data_cadastro)) ?></div>
                                <div class="user_dashboard_listed">Preço: <?php echo 'R$'.number_format($objAnuncio->valor, 0, ',', '.') ?></div>
                                <div class="user_dashboard_listed">Tipo de local: <?php echo $objAnuncio->Categoria->nome ?></div>
                                <?php
                                    if (isset($objAnuncio->estado_id) && $objAnuncio->estado_id != '') {
                                    $enderecoComp = isset($objAnuncio->logradouro) && $objAnuncio->logradouro != ''?$objAnuncio->logradouro : '';
                                    $enderecoComp .= isset($objAnuncio->numero) && $objAnuncio->numero!=''?' '.$objAnuncio->numero : '';
                                    $enderecoComp .= isset($objAnuncio->complemento) && $objAnuncio->complemento!=''?' - '. $objAnuncio->complemento : '';
                                    $enderecoComp .= isset($objAnuncio->bairro) && $objAnuncio->bairro != '' ? ' - ' . $objAnuncio->bairro.' - ' : '';
                                    $enderecoComp .= isset($objAnuncio->cidade_id) && $objAnuncio->cidade_id != '' ? $objAnuncio->Cidade->nome : '';
                                    $enderecoComp .= isset($objAnuncio->estado_id) && $objAnuncio->estado_id != '' ? '/' . $objAnuncio->Estado->sigla : '';
                                        ?>
                                            <div class="user_dashboard_listed">Endereço completo: <?php echo $enderecoComp ?></div>
                                        <?php
                                    }
                                ?>
                                <div class="user_dashboard_listed">Visualizações: <i class="far fa-eye"></i> <?php echo $objAnuncio->visualizacao ?></div>
                                <div class="action versaoWeb">
                                    <a href="<?php echo URL.'painel/gerenciar-reservas/' ?>" data-toggle="tooltip" data-placement="top" title="Gerenciar Reservas"><i class="ti-calendar"></i></a>
                                    <a href="<?php echo URL.'painel/personalizar-data/?refAn='.$objAnuncio->id ?>" data-toggle="tooltip" data-placement="top" title="Definir preços para datas específicas"><i class="fal fa-calendar-alt"></i></a>
                                    <a href="<?php echo URL.'painel/bloquear-datas/?refAn='.$objAnuncio->id ?>" data-toggle="tooltip" data-placement="top" title="Gerenciar disponibilidade"><i class="far fa-calendar-times"></i></a>
                                    <a href="<?php echo URL.'painel/adicionar-imagens/?refAn='.$objAnuncio->id ?>" data-toggle="tooltip" data-placement="top" title="Adicionar imagens"><i class="ti-camera"></i></a>
                                    <a href="<?php echo URL.'editar-propriedade/'.$objAnuncio->id ?>" data-toggle="tooltip" data-placement="top" title="Editar anúncio, documentos e preço base."><i class="ti-pencil"></i></a>
                                    <a href="#" id="deletarAnuncio" anuncio_id="<?php echo $objAnuncio->id ?>" data-toggle="tooltip" data-placement="top" title="Deletar Propriedade" class="delete"><i class="ti-close"></i></a>
                                </div>

                                <div class="action versaoMobile">
                                    <a href="<?php echo URL.'painel/gerenciar-reservas/' ?>"><i class="ti-calendar"></i> Gerenciar Reservas</a>
                                    <a href="<?php echo URL.'painel/personalizar-data/?refAn='.$objAnuncio->id ?>"><i class="fal fa-calendar-alt"></i> Definir preços para datas específicas</a>
                                    <a href="<?php echo URL.'painel/bloquear-datas/?refAn='.$objAnuncio->id ?>"><i class="far fa-calendar-times"></i> Gerenciar disponibilidade</a>
                                    <a href="<?php echo URL.'painel/adicionar-imagens/?refAn='.$objAnuncio->id ?>"><i class="ti-camera"></i> Adicionar imagens</a>
                                    <a href="<?php echo URL.'editar-propriedade/'.$objAnuncio->id ?>"><i class="ti-pencil"></i> Editar anúncio, documentos e preço base.</a>
                                    <a href="#" id="deletarAnuncio" anuncio_id="<?php echo $objAnuncio->id ?>" class="delete"><i class="ti-close"></i> Deletar Propriedade</a>
                                </div>
                            </div>
                            
                            <div class="infoPlanos">
                                <?php 
                                    $objCancelamento = Doctrine_Core::getTable('Cancelamento')->findOneByAnuncioId($objAnuncio->id);
                                ?>

                                <?php if (isset($objAnuncio->plano_id)&&$objAnuncio->plano_id==1) { ?>
                                    <a href="<?php echo URL.'planos/'.$objAnuncio->id ?>">
                                        Impulsione seu anúncio
                                    </a>
                                <?php } else if ($objAnuncio->plano_id==2) { ?>
                                    <?php if (isset($objAnuncio->pagamento)&&$objAnuncio->pagamento==1) { ?>
                                        <a href="<?php echo URL.'planos/'.$objAnuncio->id ?>">
                                            Garanta divulgação máxima
                                        </a>

                                        <?php if(!isset($objCancelamento->id)) { ?>
                                            <a style="top: 230px;
                                            font-size: 10px;
                                            padding: 6px 20px;
                                            background: #f37a42;" href="<?php echo URL.'cancelamento-assinatura/?cliente_id='.$objCliente->id.'&anuncio_id='.$objAnuncio->id ?>">Cancelar assinatura</a>
                                        <?php } else { ?>
                                            <a style="top: 230px;
                                            font-size: 10px;
                                            padding: 6px 20px;
                                            background: #f37a42;" href="javascript:void(0);">Aguardando cancelamento</a>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else if ($objAnuncio->plano_id==3) { ?>
                                    <?php if (isset($objAnuncio->pagamento)&&$objAnuncio->pagamento==1) { ?>
                                        <a href="javascript:void(0);">
                                            Parabéns, seu anúncio tem impulsionamento máximo.
                                        </a>
                                        <?php if(!isset($objCancelamento->id)) { ?>
                                            <a style="top: 230px;
                                            font-size: 10px;
                                            padding: 6px 20px;" href="<?php echo URL.'cancelamento-assinatura/?cliente_id='.$objCliente->id.'&anuncio_id='.$objAnuncio->id ?>">Cancelar assinatura</a>
                                        <?php } else { ?>
                                            <a style="top: 230px;
                                            font-size: 10px;
                                            padding: 6px 20px;" href="javascript:void(0);">Aguardando cancelamento</a>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>

                    <?php 
                }
            ?>
        </div>
    </div>
</div>