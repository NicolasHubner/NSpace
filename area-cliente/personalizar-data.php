<?php 
    if (isset($_GET['data_alterada'])&&$_GET['data_alterada']!='') {
        $valor                              = Util::formata_valor($_GET['valor']);
        
        $objAnuncioDataPersonalizada                         = new AnuncioDataPersonalizada();
        $objAnuncioDataPersonalizada->data_cadastro          = date('Y-m-d H:i:s');
        $objAnuncioDataPersonalizada->data_alterada          = $_GET['data_alterada']; 
        $objAnuncioDataPersonalizada->anuncio_id             = $_GET['anuncio_id']; 
        $objAnuncioDataPersonalizada->valor                  = (float)$valor; 
        $objAnuncioDataPersonalizada->save();

        header('Location: '.URL.'painel/personalizar-data/?refAn='.$_GET['anuncio_id']);
    }
?>

<div class="dashboard-wraper modelReservas">
    <div class="form-submit form-row">
        <div class="form-group col-lg-12 col-md-12">
            <h4>Dias/Datas personalizadas</h4>

            <div style="background: #fd533261;
            padding: 15px 10px;
            border-radius: 8px;
            border: 1px solid #fd5332;
            color: #000;
            font-weight: 400;
            font-size: 13px;">
                <p style="margin-bottom: 5px;">Quando a data com o valor alterado estiver inclusa no período da reserva, o valor alterado será considerado para todo o período reservado.</p>
                <p style="margin-bottom: 0px;">Ex.: Dia 25/12 é natal e irei aumentar o preço da minha estadia. Se algum cliente alugar do dia 24 ao dia 26, irão pagar a diária "aumentada" equivalente do dia 25, não sendo necessário aumentar todos os dias, mas apenas dias pontuais.</p>
            </div>
        </div>      
    </div>

    <form style="margin: 25px 0px;" action="<?php echo URL.'painel/personalizar-data/' ?>" method="get">
        <div class="form-row">
            <div class="col-md-3">
                <input type="date" class="form-control" name="data_alterada">
            </div>

            <div class="col-md-3">
                <input type="text" class="form-control valor-input" name="valor" placeholder="Valor">
            </div>

            <div class="col-md-3">
                <input type="hidden" name="anuncio_id" value="<?php echo $_GET['refAn'] ?>">
                <input type="submit" class="btn btn-primary" value="Cadastrar">
            </div>
        </div>
    </form>

    <div class="listasReservas">
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Data</th>
                  <th scope="col">Valor modificado</th>
                  <th scope="col">Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                    $where = 'anuncio_id = '.$_GET['refAn'];
                    $retAnuncioDataPersonalizada = Doctrine_Query::create()->select()->from('AnuncioDataPersonalizada')->where($where)->orderBy('data_alterada ASC')->execute();
                    foreach ($retAnuncioDataPersonalizada as $objAnuncioDataPersonalizada) {
                        ?>
                            <tr>
                                <th><?php echo date('d/m/Y', strtotime($objAnuncioDataPersonalizada->data_alterada)) ?></th>
                                <th><?php echo 'R$'.number_format($objAnuncioDataPersonalizada->valor, 2, ',', '.') ?></th>
                                <th><a href="#" id="deletarDataPersonalizada" anuncio_data_id="<?php echo $objAnuncioDataPersonalizada->id ?>" data-toggle="tooltip" data-placement="top" class="delete"><i class="fal fa-times"></i></a></th>
                            </tr>
                        <?php 
                    }
                ?>
              </tbody>
            </table>
        </div>
    </div>
</div>