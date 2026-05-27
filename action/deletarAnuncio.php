<?php
    include("../lib/Config.php");

    try {

        $objAnuncio                          =  Doctrine_Core::getTable('Anuncio')->find($_POST['id']);
        $objAnuncio->delete();

        $retorno = array('status'=>'1');

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>