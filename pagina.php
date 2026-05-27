<?php
    include('lib/Config.php');
  	ob_start();

    $tipoHeader = 'light';

    if  (!isset($_GET['dns'])) {
        header('Location: '.URL);
    }

    $objPagina = Doctrine_Core::getTable('Pagina')->findOneByDns($_GET['dns']);

    if (!isset($objPagina->id)) {
        header('Location: '.URL.'404');
    }
?>

    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title"><?php echo $objPagina->titulo ?></h2>

                    <div class="breadcumb">
                        <ul class="menuAcompanhador">
                            <li><a href="<?php echo URL ?>"><i class="fal fa-chevron-double-right"></i> Início</a></li>
                            <li><a class="active" href="javascript:void(0);"><i class="fal fa-chevron-double-right"></i> <?php echo $objPagina->titulo ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section style="padding: 120px 0;" <?php echo isset($objPagina->id)&&$objPagina->id==5?'class="fundo-grafismo"':'' ?>>
        <div class="container">
            <p><?php echo $objPagina->descricao ?></p>
        </div>
    </div>

<?php
    $obContent = ob_get_contents();
    ob_end_clean();
    include('base.php');
?>