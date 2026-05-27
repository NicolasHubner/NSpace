<?php
    include('lib/Config.php');
  	ob_start();

    $tipoHeader = 'light';

    if  (!isset($_GET['cliente_id'])) {
        header('Location: '.URL);
    }

    $objCliente                         = Doctrine_Core::getTable('Cliente')->find($_GET['cliente_id']);
    $objCliente->email_confirmado       = 1;
    $objCliente->save();
?>

    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title">Confirmação de email</h2>

                    <div class="breadcumb">
                        <ul class="menuAcompanhador">
                            <li><a href="<?php echo URL ?>"><i class="fal fa-chevron-double-right"></i> Inicio</a></li>
                            <li><a class="active" href="javascript:void(0);"><i class="fal fa-chevron-double-right"></i> Confirmação de email</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section style="padding: 120px 0;">
        <div class="container">
            <div class="text-center">
                <i class="fas fa-check" style="font-size: 119px;
                margin-bottom: 20px;
                color: #4caf50;"></i>
                <h5>Obrigado por confirmar o seu email!</h5>
            </div>
        </div>
    </div>

<?php
    $obContent = ob_get_contents();
    ob_end_clean();
    include('base.php');
?>