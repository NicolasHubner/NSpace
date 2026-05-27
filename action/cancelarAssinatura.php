<?php
    include("../lib/Config.php");

    try {

        $objCancelamento                            =  new Cancelamento();
        $objCancelamento->data_cadastro             = date('Y-m-d H:i:s');
        $objCancelamento->data_cancelamento         = date('Y-m-d H:i:s');
        $objCancelamento->anuncio_id                = $_POST['anuncio_id']; 
        $objCancelamento->cliente_id                = $_POST['cliente_id']; 
        $objCancelamento->plano_id                  = $_POST['plano_id']; 
        $objCancelamento->status                    = 1;
        $objCancelamento->save();

        $retorno = array('status'=>'1');

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>