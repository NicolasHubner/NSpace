<div class="dashboard-wraper">
    <div class="form-submit">
        <h4 class="mb-20">Visualizações nos anúncios</h4>
    </div>
    
    <div class="row modelVisualizacoes">
        <div class="col-md-12 col-sm-12 col-md-12">
            <div class="table-responsive mb-20">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 100px;">IMG</th>
                            <th scope="col">Título</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Visualizações</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php 
                            $totalVisualizacao = 0;
                            $retAnuncio = Doctrine_Query::create()->select()->from('Anuncio')->where('cliente_id = '.$objCliente->id.' and visualizacao is not null')->orderBy('visualizacao DESC')->execute();
                            foreach ($retAnuncio as $objAnuncio) {
                                $totalVisualizacao += $objAnuncio->visualizacao;
                                ?>
                                <tr>
                                    <td>
                                        <div style="overflow: hidden; border-radius: 5px;">
                                            <img src="<?php echo URL_ANUNCIO.$objAnuncio->imagem ?>" style="width: 100%;">
                                        </div>
                                    </td>
                                    <td><?php echo $objAnuncio->titulo ?></td>
                                    <td><?php echo $objAnuncio->Categoria->nome ?></td>
                                    <td><?php echo 'R$'.number_format($objAnuncio->valor, 2, ',', '.') ?></td>
                                    <td><span class="badge-icon"><?php echo $objAnuncio->visualizacao ?></span></td>
                                </tr>
                                <?php 
                            }
                        ?>
                  </tbody>
                </table>
            </div>

            <div class="text-center visualizacaoTotais">
                <h4>Total de visualizações: <span><?php echo $totalVisualizacao ?></span></h4>
            </div>
        </div>
    </div>
</div>