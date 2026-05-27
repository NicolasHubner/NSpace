<?php 
    if (isset($_GET['data_inicial'])&&$_GET['data_inicial']!='') {
        $valor                              = Util::formata_valor($_GET['valor']);
        
        $objAnuncioDataBloqueada                         = new AnuncioDataBloqueada();
        $objAnuncioDataBloqueada->data_cadastro          = date('Y-m-d H:i:s');
        $objAnuncioDataBloqueada->data_inicial             = $_GET['data_inicial']; 
        $objAnuncioDataBloqueada->data_final             = $_GET['data_final']; 
        $objAnuncioDataBloqueada->anuncio_id             = $_GET['anuncio_id']; 
        $objAnuncioDataBloqueada->save();

        header('Location: '.URL.'painel/bloquear-datas/?refAn='.$_GET['anuncio_id']);
    }
?>

<div class="dashboard-wraper modelReservas">
    <div class="form-submit form-row">
        <div class="form-group col-lg-12 col-md-12">
            <h4>Datas Bloqueadas</h4>
        </div>      
    </div>

    <form style="margin: 25px 0px;" action="<?php echo URL.'painel/bloquear-datas/' ?>" method="get">
        <div class="form-row">
            <div class="col-md-3">
                <input type="date" class="form-control" name="data_inicial">
            </div>

            <div class="col-md-3">
                <input type="date" class="form-control" name="data_final">
            </div>

            <div class="col-md-3">
                <input type="hidden" name="anuncio_id" value="<?php echo $_GET['refAn'] ?>">
                <input type="submit" class="btn btn-primary" value="Cadastrar bloqueio">
            </div>
        </div>
    </form>

    <div class="listasReservas">
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Data inicial</th>
                  <th scope="col">Data final</th>
                  <th scope="col">Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                    $where = 'anuncio_id = '.$_GET['refAn'];
                    $retAnuncioDataBloqueada = Doctrine_Query::create()->select()->from('AnuncioDataBloqueada')->where($where)->orderBy('data_inicial ASC')->execute();
                    foreach ($retAnuncioDataBloqueada as $objAnuncioDataBloqueada) {
                        ?>
                            <tr>
                                <th><?php echo date('d/m/Y', strtotime($objAnuncioDataBloqueada->data_inicial)) ?></th>
                                <th><?php echo date('d/m/Y', strtotime($objAnuncioDataBloqueada->data_final)) ?></th>
                                <th><a href="#" id="deletarDataBloqueada" anuncio_data_id="<?php echo $objAnuncioDataBloqueada->id ?>" data-toggle="tooltip" data-placement="top" class="delete"><i class="fal fa-times"></i></a></th>
                            </tr>
                        <?php 
                    }
                ?>
              </tbody>
            </table>
        </div>
    </div>
</div>