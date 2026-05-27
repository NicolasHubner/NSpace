<?php
    include("../lib/Config.php");

    try {

        $_POST['plano_id']                  = isset($_POST['plano_id'])&&$_POST['plano_id']!=''?$_POST['plano_id']:null;

        $objAnuncio                         = Doctrine_Core::getTable('Anuncio')->find($_POST['anuncio_id']);
        $objAnuncio->plano_id               = $_POST['plano_id'];
        if (isset($_POST['plano_id'])&&$_POST['plano_id']==1) {
            $objAnuncio->pagamento          = 1;
        } else {
            $objAnuncio->pagamento          = 0;
        }
        $objAnuncio->save();

        $objPlano                           = Doctrine_Core::getTable('Plano')->find($_POST['plano_id']);

        $retorno = array('status'=>'1', 'plano_id'=>$objPlano->id, 'anuncio_id'=>$objAnuncio->id);
          

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>
