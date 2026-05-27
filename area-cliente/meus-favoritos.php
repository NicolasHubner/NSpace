<div class="dashboard-wraper model-minhas-propriedades">
    <div class="form-submit">
        <h4 class="mb-20">Meus favoritos</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-md-12">
            <?php 
                $retAnuncioFavorito = Doctrine_Query::create()->select()->from('AnuncioFavorito')->where('cliente_id = '.$objCliente->id)->orderBy('data_cadastro DESC')->execute();
                if ($retAnuncioFavorito->count()>0) {
                    foreach ($retAnuncioFavorito as $objAnuncioFavorito) {
                        ?>
                            <div class="singles-dashboard-list">
                                <div class="sd-list-left imagemAltura">
                                    <div class="listing-like-top">
                                        <a class="favoritado" href="javascript:void(0);">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                    </div>
                                    <div class="imagemAnuncioFavorito">
                                        <img src="<?php echo URL_ANUNCIO.$objAnuncioFavorito->Anuncio->imagem ?>" class="img-fluid">
                                    </div>
                                </div>

                                <div class="sd-list-right">

                                    <h4 class="listing_dashboard_title"><a href="<?php echo URL.'anuncio/'.$objAnuncioFavorito->Anuncio->dns.'/'.$objAnuncioFavorito->Anuncio->id.'/' ?>" class="theme-cl"><?php echo $objAnuncioFavorito->Anuncio->titulo ?></a></h4>
                                    <div class="user_dashboard_listed">Cód. identificador: <?php echo $objAnuncioFavorito->Anuncio->id ?></div>
                                    <div class="user_dashboard_listed">Data de cadastro: <?php echo date('d/m/Y', strtotime($objAnuncioFavorito->Anuncio->data_cadastro)) ?></div>
                                    <div class="user_dashboard_listed">Preço: <?php echo 'R$'.number_format($objAnuncioFavorito->Anuncio->valor, 0, ',', '.') ?></div>
                                    <div class="user_dashboard_listed">Tipo de local: <?php echo $objAnuncioFavorito->Anuncio->Categoria->nome ?></div>
                                    <?php
                                        if (isset($objAnuncioFavorito->Anuncio->estado_id) && $objAnuncioFavorito->Anuncio->estado_id != '') {
                                        $enderecoComp = isset($objAnuncioFavorito->Anuncio->logradouro) && $objAnuncioFavorito->Anuncio->logradouro != ''?$objAnuncioFavorito->Anuncio->logradouro : '';
                                        $enderecoComp .= isset($objAnuncioFavorito->Anuncio->numero) && $objAnuncioFavorito->Anuncio->numero!=''?' '.$objAnuncioFavorito->Anuncio->numero : '';
                                        $enderecoComp .= isset($objAnuncioFavorito->Anuncio->complemento) && $objAnuncioFavorito->Anuncio->complemento!=''?' - '. $objAnuncioFavorito->Anuncio->complemento : '';
                                        $enderecoComp .= isset($objAnuncioFavorito->Anuncio->bairro) && $objAnuncioFavorito->Anuncio->bairro != '' ? ' - ' . $objAnuncioFavorito->Anuncio->bairro.' - ' : '';
                                        $enderecoComp .= isset($objAnuncioFavorito->Anuncio->cidade_id) && $objAnuncioFavorito->Anuncio->cidade_id != '' ? $objAnuncioFavorito->Anuncio->Cidade->nome : '';
                                        $enderecoComp .= isset($objAnuncioFavorito->Anuncio->estado_id) && $objAnuncioFavorito->Anuncio->estado_id != '' ? '/' . $objAnuncioFavorito->Anuncio->Estado->sigla : '';
                                            ?>
                                                <div class="user_dashboard_listed">Endereço completo: <?php echo $enderecoComp ?></div>
                                            <?php
                                        }
                                    ?>
                                    <div class="user_dashboard_listed">Visualizações: <i class="far fa-eye"></i> <?php echo $objAnuncioFavorito->Anuncio->visualizacao ?></div>
                                    <div class="action">
                                        <a href="#" id="deletarAnuncioFavorito" anuncio_favorito_id="<?php echo $objAnuncioFavorito->id ?>" data-toggle="tooltip" data-placement="top" title="Deletar espaço dos favoritos" class="delete"><i class="ti-close"></i></a>
                                    </div>
                                </div>

                                <div class="sd-list-right">
                                </div>
                            </div>
                        <?php 
                    }
                } else {
                    ?>
                        <div class="col-md-12 text-center">
                            <p>Não há favoritos ainda, vá em pesquisar e clique no S2 para poder favoritar seus espaços preferidos</p>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>