<?php
    include("../lib/Config.php");

    try {

        $objAnuncioDataBloqueada                          =  Doctrine_Core::getTable('AnuncioDataBloqueada')->find($_POST['id']);
        $objAnuncioDataBloqueada->delete();

        $retorno = array('status'=>'1');

    } catch (\Throwable $th) {
        $retorno = array('status'=>$th);
    }

  	echo json_encode($retorno);
?>